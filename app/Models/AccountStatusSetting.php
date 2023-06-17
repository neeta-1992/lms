<?php

namespace App\Models;

use App\Helpers\AllDataBaseUpdate;

use App\Models\Logs;
use App\Models\State;
use App\Traits\ModelAttribute;
use Arr;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
class AccountStatusSetting extends Model
{
    use HasFactory;
    use ModelAttribute;
    //use EncryptedAttribute;

    protected $fillable = [
        'user_id', 'state_id', 'account_days_overdue', 'cancellation_notice_days', 'cancel_balance_due',
        'commercial_lines_days', 'personal_lines_days', 'fewer_days_remaining', 'personal_lines',
        'cancel_date_personal_lines', 'cancel_date_commercial_lines', 'commercial_lines',
        'sending_cancel_days', 'sending_cancel_days_collection', 'cancel_level_one', 'most_recent_date_days', 'maximum_automatic_amount', 'unearned_interest',
    ];
    //protected $encryptable = ['bank_name','account_number'];

    /**
     * Get the state that owns the AccountStatusSetting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state_data()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public static function insertOrUpdate(array $array)
    {

        $id         = !empty($array['id']) ? $array['id'] : '';
        $state_id   = !empty($array['state_id']) ? ($array['state_id']) : 0;
        $user_id    = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logId      = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $parent_id  = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId   = !empty($array['parentId']) ? $array['parentId'] : null;
        $titleArr   = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;

        $exceptArr  = ["id", 'company_data', 'activePage', 'onDB', 'logId', 'logsArr', '_token', 'pageTitle', 'user_type'];
        $inserArr   = Arr::except($array, $exceptArr);
        $inserArr['state_id'] = $state_id;
        $inserArr['user_id'] = $user_id;

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }


        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id)) {
                $inserArr = arrFilter($inserArr);
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }


            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.account_status_settings.add', ['name' => $name]);
            } else {
                $changesArr = $getdata?->changesArr ?? [];
                $logsText = self::logsText($changesArr);
                if (!empty($logsText)) {
                    $logsText = $logsText;
                    $msg = __('logs.account_status_settings.edit', ['name' => $name]) . " " . $logsText;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $state_id, 'message' => $msg]);

        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    private static function logsText($changesArr){
        $labelArr = [
            'account_days_overdue'=>'Is the account days overdue?',
            'commercial_lines_days'=>"Cancellation for commercial lines",
            'personal_lines_days'=>"Cancellation for personal lines",
            'fewer_days_remaining'=>'Is followup enabled and within days of cancel?',
            'cancel_date_personal_lines'=>'The cancel date for personal lines',
            'cancel_date_commercial_lines'=>'The cancel date for commercial lines',
            'commercial_lines'=>'Commercial lines',
            'personal_lines'=>'Personal lines',
            'cancellation_notice_days'=>'Is followup enabled and have more than days of elapsed?',
            'cancel_balance_due'=>'',
            'sending_cancel_days'=>'Is cancel 2 enabled and have more than days of elapsed?',
            'sending_cancel_days_collection'=>'Is collection enabled and have more than days of elapsed?',
            'cancel_level_one'=>'Cancel level one',
            'most_recent_date_days'=>'Have days elapsed?',
            'maximum_automatic_amount'=>'Maximum automatic write-off',
            'unearned_interest'=>'Unearned interest',
        ];
        $message = $and =  "";
        $amountFiedArr = ['commercial_lines','personal_lines','cancel_balance_due','cancel_level_one','maximum_automatic_amount','unearned_interest'];
        if(!empty($changesArr)){
            foreach ($changesArr as $key => $value) {
                $replace = !empty($labelArr[$key]) ? $labelArr[$key] : str_replace("_"," ",$key);
                $old = !empty($value['old']) ? $value['old'] : '';
                $new = !empty($value['new']) ? $value['new'] : '';

                if(in_array($key,$amountFiedArr)){
                    $old = !empty($old) ? '$'.number_format($old,2) : '';
                    $new = !empty($new) ? '$'.number_format($new,2) : '';
                }

                if(!empty($old) ){
					$new = !empty($new) ? $new : 'None';
					$message .= '<li> <b>'.$replace.'</b> was changed from <b>'.$old.'</b> to <b>'.$new.'</b> </li>' ;
				}else if(!empty($new)){
					$message .= '<li> <b>'.$replace.'</b> '.'was updated to <b>'.$new.'</b> </li>' ;
				}
              //  $and =' and ';


            }
        }
        return $message;
    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        if (isset($array['stateId'])) {
            $model = $model->whereStateId($array['stateId']);
        }
        return $model;
    }
}
