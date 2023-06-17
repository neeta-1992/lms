<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;

use App\Models\Entity;

use App\Models\Logs;

use App\Models\ProspectContact;

use App\Models\ProspectOffice;
use App\Models\User;use App\Traits\ModelAttribute;use DB;use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Prospect extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = [
        'user_id', 'agency',
        'entity_name', 'legal_name',
        'telephone', 'email', 'website', 'fax', 'tin',
        'city', 'address', 'state', 'zip',
        'sales_excustive', 'sales_organization', 'notes', 'status',
    ];
    protected $encryptable = [
        'agency',
        'entity_name', 'legal_name',
        'telephone', 'email', 'website', 'fax', 'tin',
        'city', 'address', 'state', 'zip',
        'sales_excustive', 'notes',
    ];

    /**
     * Get the sales_organization that owns the Prospect
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sales_organization_data()
    {

        return $this->belongsTo(Entity::class, 'sales_organization', 'id')->where('type', Entity::SALESORG);
    }


    /**
     * Get all of the contact for the Prospect
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contact_data()
    {
        return $this->hasMany(ProspectContact::class, 'prospect_id', 'id');
    }

    /*
     *
     * Get all of the agency_id for the Prospect
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function office_data()
    {
        return $this->hasMany(ProspectOffice::class, 'agency_id', 'id');
    }




    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $lang = !empty($array['lang']) ? $array['lang'] : null;
        $entityContact = !empty($array['entityContact']) ? $array['entityContact'] : null;
        $pageTitle = !empty($array['pageTitle']) ? $array['pageTitle'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $exceptArr = ["id", 'entityContact', 'lang', 'pageTitle', 'company_data', 'activePage', 'onDB', 'logId', 'logsArr', '_token'];

        $inserArr = Arr::except($array, $exceptArr);
        $inserArr['user_id'] = $user_id;
/* dd( $inserArr); */

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $logsmsg = $templateTextOld = $templateTextNew = "";

        if (!empty($logJson)) {
            $logsArr = $logJson;
            $templateTextNew = !empty($logsArr['e_signature'][0]['value']) ? $logsArr['e_signature'][0]['value'] : '';
            $logsmsg = dbLogFormat($logsArr);
        }

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                //$inserArr  = arrFilter($inserArr);
                if (!empty($parentId)) {

                    $getdata = $model->updateOrCreate(['parent_id' => $parentId], $inserArr);
                    $getChanges = $getdata?->changesArr;
                    if (!empty($getChanges)) {
                        $logsMsg = logsMsgCreate($getChanges, $titleArr, $logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                } else {
                    $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
                }
            } else {
                $getdata = $model->create($inserArr);
            }
            $prospectId = $getdata?->id;
            $wasRecentlyCreated = $getdata?->wasRecentlyCreated;
            $name = $getdata?->agency ?? "";
            if ($wasRecentlyCreated == true) {
                $msg = __('logs.' . $lang . '.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.' . $lang . '.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }

            /*
             * Add Home Office For Agent
             */
            $officeData = null;
            if ($wasRecentlyCreated == true) {
                $officeArr = $array;
                $city = !empty($officeArr['city']) ? $officeArr['city'] : '';
                $state = !empty($officeArr['state']) ? $officeArr['state'] : '';
                $officeArr['logMag'] = true;
                $officeArr['agency_id'] = $prospectId;
                $officeArr['name'] = "{$city},{$state} *";
                $officeData = ProspectOffice::insertOrUpdate($officeArr);

                $msg .= !empty($msg) ? ' , ' : '';
                $msg .= !empty($officeData?->logMsg) ? " <br> " . $officeData?->logMsg : '';

            }

            /*
            $entity Contact Save
             */
            if (!empty($entityContact) && $wasRecentlyCreated == true) {
                $msg .= !empty($msg) ? ' , ' : '';

                $officeDataId = $officeData?->id ?? null;

                $userDataContact = self::entityContact($entityContact, $prospectId, $lang, $pageTitle,'', $officeDataId);
                $msg .= !empty($userDataContact?->logMsg) ? " <br> " . $userDataContact?->logMsg : '';

            }

            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg, 'old_value' => $templateTextOld, 'new_value' => $templateTextNew]);

        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    private static function entityContact($data, $prospectId = null, $lang = "", $pageTitle = null, $activePage = null, $office = null)
    {

        $data = arrayFormatGroup($data) ?? [];

        $data['prospect_id'] = $prospectId;
        $data['logId'] = $prospectId;
        $data['lang'] = $lang;
        $data['entityName'] = $pageTitle;
        $data['office'] = $office;
        $data['role'] = 1;
        //  $data['activePage'] = $activePage;
        $data['logMag'] = true;

        $response = ProspectContact::insertOrUpdate($data);
        return $response;
    }

    public static function getData(array $array = null)
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        $model->when(!empty($array['search']), function ($q) use ($array) {
            return $q->whereLike('prospects.agency', $array['search']);
        });

        if (isset($array['name'])) {
            $model = $model->whereLike('prospects.agency',$array['name']);
        }
 /*        if (isset($array['nameLike'])) {
            $model = $model->whereLike('agency',$array['nameLike']);
        } */
        if (isset($array['sales_organization'])) {
            if($array['sales_organization']  !== 'all'){
                $model = $model->where('sales_organization',$array['sales_organization']);
            }
        }
        if (isset($array['state'])) {
            $model = $model->whereEn('prospects.state',$array['state']);
        }
        if (isset($array['status'])) {
            $model = $model->where('prospects.status',$array['status']);
        }
        if (isset($array['type'])) {
            $model = $model->where('prospects.type',$array['type']);
        }
        if (isset($array['id'])) {
            $model = $model->where('prospects.id',$array['id']);
        }
        if (isset($array['dId'])) {
            $model = $model->decrypt($array['dId'],'prospects.id');
        }
        if (isset($array['form_date']) && isset($array['to_date'])) {
            $form_date = !empty($array['form_date']) ? date('Y-m-d',strtotime($array['form_date'])) : null ;
            $to_date = !empty($array['to_date']) ? date('Y-m-d',strtotime($array['to_date'])) : null ;
            $model = $model->whereBetween('prospects.created_at',[$form_date,$to_date]);
        }

        return $model;
    }

}
