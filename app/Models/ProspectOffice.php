<?php

namespace App\Models;
use App\Encryption\Traits\EncryptedAttribute;
use App\Models\{
    Logs,User
};
use App\Traits\ModelAttribute;
use Error,Arr,DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProspectOffice extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    /**
     * Get the user that owns the AgentOffice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $fillable = [
        'user_id','agency_id','name','email',
        'notes','fax','telephone','address','city',
        'state','zip','description','mailing_address',
        'mailing_city','mailing_state','mailing_zip'
    ];

    protected $encryptable = ['name', 'email', 'notes', 'fax', 'telephone', 'address', 'city', 'state', 'zip', 'description'];

    public static function insertOrUpdate(array $array)
    {

        $id         = !empty($array['id']) ? $array['id'] : '';
        $user_id    = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson    = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId      = !empty($array['logId']) ? $array['logId'] : '';
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $parent_id  = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId   = !empty($array['parentId']) ? $array['parentId'] : null;
        $logMag     = !empty($array['logMag']) ? $array['logMag'] : false;
        $titleArr   = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;

        /*
          @Load Model
        */
        $model = new self;
        $inserArr = Arr::only($array, $model->fillable);
       //dd( $inserArr);
        if (!empty($array['parent_id']) || !empty($onDB)) {
            $inserArr['parent_id'] = $parent_id;
        }

        $logsmsg = "";
        if (!empty($logJson)) {
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }

            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.agent_office.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.agent_office.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */

            $logId = !empty($logId) ? $logId : $getdata?->id ;
            if(!empty($msg) && $logMag == false){
                Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' => $logId, 'message' => $msg]);
            }
        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        if(!empty($logMag)){
            $getdata['logMsg']=$msg;
        }

        return $getdata;
    }
    public static function getData(array $array = null)
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        if (!empty($array['dId'])) {
         $model = $model->decrypt($array['dId']);
        }
        if (!empty($array['prospectId'])) {
             $model = $model->whereAgencyId($array['prospectId']);
        }
         if (!empty($array['id'])) {
         $model = $model->whereId($array['id']);
         }
        return $model;
    }
}
