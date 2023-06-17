<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr,DBHelper;
use App\Models\{
    QuotePolicy,Entity,QuoteTerm,QuoteAccount
};
use App\Traits\ModelAttribute;
use App\Helpers\{
    QuoteHelper
};

class DailyNotice extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','status','send_type','account_id','notice_id','send_id','quote_id','version_id','policy_id','subject','notice_name','notice_action','notice_type','notice','template_type','email','account_number','mail_address','template','shortcodes','send_by','send_to'];
    protected $encryptable = ['template'];



     /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function send_data()
    {
        return $this->hasOne(Entity::class, 'id', 'send_id');
    }

     /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_data()
    {
        return $this->hasOne(QuoteAccount::class, 'id', 'account_id');
    }




    public static function insertOrUpdate(array $array)
    {

        $id             = !empty($array['id']) ? $array['id'] : '';
        $user_id        = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson        = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId          = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption     = !empty($array['save_option']) ? $array['save_option'] : null;
        $onDB           = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId       = !empty($array['parentId']) ? $array['parentId'] : null;
        $lang           = !empty($array['lang']) ? $array['lang'] : null;
        $entityContact  = !empty($array['entityContact']) ? $array['entityContact'] : null;
        $pageTitle      = !empty($array['pageTitle']) ? $array['pageTitle'] : null;
        $activePage     = !empty($array['activePage']) ? $array['activePage'] : null;


        $model = new self;
        $inserArr = Arr::only($array, $model->fillable);
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


        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }
/* dd($inserArr); */
        DB::beginTransaction();
        try {
            if (!empty($id)) {

                    $getdata = $model->updateOrCreate(['id' => $id], $inserArr);

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

    public static function getData(array $array=null){

        $model = new self;

        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        if(!empty($array['accountId'])){
            $model = $model->where('account_id',$array['accountId']);
        }
        if(!empty($array['id'])){
            $model = $model->where('id',$array['id']);
        }
        if(!empty($array['sendBy'])){
            if(is_array($array['sendBy'])){
                $model = $model->whereIN('send_by',$array['sendBy']);
            }else{
                $model = $model->where('send_by',$array['sendBy']);
            }
            
        }
        return $model;
    }
}
