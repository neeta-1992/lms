<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr,Str;
use App\Models\{
    Logs,User,Quote
};
use App\Traits\ModelAttribute;
class QuoteVersion extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
   // use EncryptedAttribute;

    protected $fillable = [
        'user_id','quote_id','version_id','quote_parent_id','favourite','document_id','notice','agent_sig_notice','upload_signed_finance_agreement',
        'attachment_signed_id','agent_insured_send_id','insured_signature_id','signature_key','insured_signature_date','underwriting_informations'
    ];

    public function quote_data()
    {
        return $this->belongsTo(Quote::class, 'quote_parent_id', 'id');
    }



    public static function insertOrUpdate(array $array)
    {

        $id                 = !empty($array['id']) ? $array['id'] : '';
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logJson            = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $titleArr            = !empty($array['titleArr']) ? json_decode($array['titleArr'],true) : null ;
        $logId              = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        $isLogMsg             = !empty($array['isLogMsg']) ? $array['isLogMsg'] : false ;



        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $user_id;

       // dd( $inserArr);
        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
        if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata  =    $model->create($inserArr);
            }


            if($getdata->wasRecentlyCreated == true){
                $signatureKey           = Str::uuid().time().Str::random(6);
                $getdata->signature_key = $signatureKey;
                $getdata->save();

                $msg = "<li>".__('logs.quote_version.add',['id'=> "# {$getdata->quote_data->qid}.{$getdata->version_id}"])." </li>";
            }else{
                if(!empty($logsmsg)){
                    $changesArr = $getdata?->changesArr ?? [];
                    $msg = logsMsgCreate($changesArr, $titleArr);
                }
            }

            $logId = !empty($logId) ? $logId : $getdata->id;
            if($isLogMsg == false && !empty($msg)){
                Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg]);
            }else{
                if($isLogMsg == true){
                    $getdata['logMsg'] = $msg;
                }
            }





        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


    /* quote favorite Version and change  quote table Version */

    public static function quotefavoriteVersion(array $array = null){

         $id         = !empty($array['id']) ? $array['id'] : '';
         $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
         $logId              = !empty($array['logId']) ? $array['logId'] : '' ;
         $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
         $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        try {

            DB::beginTransaction();

            $quoteVersion =   self::getData(['id'=>$id])->first();
            if(empty($quoteVersion))
                    throw new Error("Invalid Quote Version Id");

            $version = $quoteVersion->version_id;
            $quoteId  = $quoteVersion->quote_parent_id;


            self::getData(['quote_parent_id'=>$quoteId])->update(['favourite'=>0]);


            $quoteVersion->favourite = 1 ;
            $quoteVersion->save();


            $quoteData = Quote::getData(['id'=>$quoteId])->updateOrCreate(['id'=>$quoteId],['version'=>$version,'vid'=>$id]);

            $changesArr = $quoteData->changesArr ?? '';
            $qId = $quoteData->qid;
            $oldVersion = !empty($changesArr['version']['old']) ? $changesArr['version']['old'] : '';
            $newVersion = !empty($changesArr['version']['new']) ? $changesArr['version']['new'] : '';

            $msg = "<li>Quote version favorite was changed from <b>{$qId}.{$oldVersion}</b> to <b>{$qId}.{$newVersion}</b> </li>";


            $logId = !empty($logId) ? $logId : $quoteId;
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg]);


            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }
        if (!empty($array['qId'])) {
            $model = $model->whereQuoteParentId($array['qId']);
        }
        return $model;
    }
}
