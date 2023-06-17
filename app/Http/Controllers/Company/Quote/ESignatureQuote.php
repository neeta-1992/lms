<?php

namespace App\Http\Controllers\Company\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Company,CoverageType,QuoteSetting,Entity,
    RateTable,PolicyTermsOption,QuoteTerm,Attachment,State,
    StateSettings,AccountStatusSetting,User,AgentOtherSetting,
    Setting,Quote,QuotePolicy,QuoteVersion,Task,QuoteNote,
    FinanceAgreement,QuoteSignatureOtp,QuoteSignature,Logs
};
use Error,Carbon\Carbon,Mail,Str,App;
use App\Helpers\ReplaceShortcodes;
use App\Mail\{
    SendOtp,InsuredSignatureMail
};
use Barryvdh\DomPDF\Facade\Pdf;
class ESignatureQuote extends Controller
{
    private $viwePath   = "company.quotes.";
    public  $pageTitle  = "Quotes";
    public  $activePage = "quotes";
    public  $route      = "company.quotes.";
    public function __construct(Quote $model){
       $this->model =  $model;
    }
     /* e signature quote to insured */
    public function viewFa(Request $request,$qId="null",$vId="null"){
        try {
            $userData           = $request->user();
            $userName           = $userData?->name;
            $userEmail          = $userData?->email;


            /* Log For view finance agreement  */
            $templateData = ReplaceShortcodes::financeAgreementTempalte($qId,$vId,['type'=>'view']);
            $template     = $templateData?->template ?? null;
            $quoteData    = $templateData?->quoteData ?? null;
            $vData        = $templateData?->vData ?? null;


            $quoteId = $quoteData->qid.".".(!empty($vData->version_id) ? $vData->version_id : $quoteData?->version);
            $msg = __('logs.quote.view_fa',['user_name'=>$userName,'user_email'=>$userEmail,'quote_id'=>"{$quoteId}"]);
            Logs::saveLogs([
                'type' => $this->activePage,
                'type_id' => $qId,
                'message' => $msg
            ]);
            $route = $this->route;
            $activePage = $this->activePage;
            
            return view($this->viwePath."e_signature.e-signature-quote",compact('qId','vId','template','quoteId','route','activePage'));
            return $template;
        } catch (\Throwable $th) {

            return $th;
        }
    }

    /* Send Otp */
    public function sendOtp(Request $request,$qId="null",$vId="null"){
        $insertData = false;
        $userData       = $request->user();
        $userName       = $userData?->name;
        $userEmail       = $userData?->email;
        $userId         = $userData?->id;
        $ip             = $request->ip();
        $insuredSignature  = !empty($request->insuredSignature) ? $request->insuredSignature : false;
        $otpValid       = config('custom.quote.otp_valid') ?? 5; // In Mins

        $agentCount     = QuoteSignature::getData(['qId'=>$qId,'type'=>'agent','vId'=>$vId,'action'=>'completed'])->count();

        if(!empty($agentCount) && $insuredSignature == false && $userData->user_type == User::AGENT){
            $isnuredCount   = QuoteSignature::getData(['qId'=>$qId,'type'=>'isnured','vId'=>$vId,'action'=>'completed'])->count();
            if(empty($isnuredCount)){
                return response()->json(['status'=>true,'type'=>'isnuredOpenModel'], 200);
            }
        }

        $data           = QuoteSignatureOtp::getData(['qId'=>$qId,'ip'=>$ip,'vId'=>$vId])->where('status',0)->first();


        if(!empty($data)){
            $time   = $data?->start_time;
            $start  = new Carbon(now());
            $end    = new Carbon($time);
            $time   = $start->diff($end)->format('%r%i:%S');
            $result = $start->gt($end);
          /*   dd($result); */
            if($result){
                $type = 'openModel';
                $insertData = true;
            }else{
                $type = 'openModel';
            }
        }else{
            $insertData = true;
            $type = 'openModel';
        }

        if($insertData){
            QuoteSignatureOtp::getData(['qId'=>$qId,'ip'=>$ip,'vId'=>$vId])->delete();
            $otp       = config('app.env') == 'local' ? 123456 : rand(123456, 999999);
            $time      = now()->addMinute($otpValid);
            $insertArr = [
               'ip'         => $ip,
               'qid'        => $qId,
               'vid'        => $vId,
               'otp'        => $otp ,
               'status'     => 0,
               'start_time' => $time,
            ];
            QuoteSignatureOtp::insertOrUpdate($insertArr);
            Mail::to($userEmail)->send(new SendOtp(['otp'=> $otp,'name'=>$userName]));
            $start  = new Carbon(now());
            $end    = new Carbon($time);
            $time   = $start->diff($end)->format('%r%i:%S');
        }

        return response()->json(['status'=>true,'type'=>$type,'time'=>$time], 200);

    }

    public function varifysendOtp(Request $request,$qId="null",$vId="null"){
        $error = "";
        $quoteData      = $this->model::getData(['id'=>$qId])->firstOrFail();
        $vData          = QuoteVersion::getData(['id'=>$vId])->firstOrFail();
        $userData       = $request->user();
        $userName       = $userData?->name;
        $userId         = $userData?->id;
        $ip             = $request->ip();
        $otp            = $request->otp;
        if(empty($otp)){
            $error  = "Invalid Otp";
        }
        $data           = QuoteSignatureOtp::getData(['qId'=>$qId,'vId'=>$vId,'ip'=>$ip,'otp'=>$otp])->where('status',0)->first();
        if(empty($data)){
            $error  = "Invalid Otp";
        }

        $time   = $data?->start_time;
        $start  = new Carbon(now());
        $end    = new Carbon($time);
        $time   = $start->diff($end)->format('%r%i:%S');
        $result = $start->gt($end);
        if($result){
            $error  = "The otp has expired. Please re-send the verification code to try again";
        }

        if(!empty($error)){
            return response()->json(['status'=>false,'msg'=>$error], 200);
        }

        $data->status = 1 ;
        $data->verify_time = now();
        $data->save();


        $inputs             = $request->post();
        $ip                 = $request->ip();
        $action             = 'Viewed';
        $inputs['onDB']     = 'company_mysql';
        $inputs['qid']      = $qId;
        $inputs['vid']      = $vId;
        $inputs['onDB']     = 'company_mysql';
        $inputs['action']   = $action;
        $inputs['current_datetime']   = $request->current_date;
        $inputs['signature_text'] = "";
        $data = QuoteSignature::insertOrUpdate($inputs);

        /* Two step verification code logged in  */
        $quoteId = $quoteData->qid.".".(!empty($vData->version_id) ? $vData->version_id : $quoteData?->version);
        $msg = __('logs.quote.two_step_verification',['user_name'=>$userName,'quote_id'=>"{$quoteId}"]);
        Logs::saveLogs([
            'type' => $this->activePage,
            'type_id' => $qId,
            'message' => $msg
        ]);


        return response()->json(['status'=>true,'msg'=>'Otp verify succesfully'], 200);
    }

    /* e signature quote to insured */
    public function  eSignatureQuoteToInsured(Request $request){

        $signatureKey       = $request->get('i');
        if(!empty($signatureKey)){
            $vData     = QuoteVersion::getData()->where('signature_key',$signatureKey)->whereRaw('insured_signature_date > NOW()')->firstOrFail();
            $insured_signature_date = $vData->insured_signature_date;
            $insured_signature_id = $vData->insured_signature_id;
            $qId       = $vData->quote_parent_id;
            $vId       = $vData->id;
        }else{
            $qId       = $request->get('q');
            $vId       = $request->get('v');
            $insured_signature_id = null;
            $vData    = QuoteVersion::getData(['id'=>$vId])->firstOrFail();
        }


        $error     = "";
        $ip        = $request->ip();
        $data      = QuoteSignatureOtp::getData(['qId'=>$qId,'ip'=>$ip])->whereStatus(1)->whereDate('created_at',date('Y-m-d'))->first();
        if (empty($data)) {
            if($request->ajax()){
                return response()->json(['status'=>false,'msg'=>'Please Verify Two-Step Verification'], 200);
            }else{
                $error = "Please Verify Two-Step Verification";
            }
        }


     


        $templateData = ReplaceShortcodes::financeAgreementTempalte($qId,$vId);
   /*  dd(   $templateData); */
        $template     = $templateData?->template ?? null;
        $quoteData    = $templateData?->quoteData ?? null;
        if(empty($quoteData)){
             abort('404','Invalid Id');
        }
        $agencyData   = $quoteData?->agency_data;
        $vData        = $templateData?->vData ?? null;
        $quoteId      = $quoteData?->qid.".".(!empty($vData->version_id) ? $vData->version_id : $quoteData?->version);

        /* QuoteSetting */
        $quoteSetting  = QuoteSetting::getData()->first();
        $textSignature = !empty($quoteSetting->text_signature) ? $quoteSetting->text_signature : '';
        if(!empty($textSignature)){
            $textSignature = Str::of($textSignature)
                                ->replace("{AGENCYNAME}",($agencyData->name ?? ''))
                                ->replace("{AGENCYEMAIL}",($agencyData->email ?? ''));
        }

        $isAgent = $isIsnured = "no";
        if(auth()->check()){
            $userData   = auth()->user();
            $isAgent    = ($userData?->user_type == User::AGENT) ? 'yes' : 'no';
            $isIsnured  = ($userData?->user_type == User::INSURED) ? 'yes' : 'no';
        }else{
            $isIsnured  = !empty($signatureKey) ? 'yes' : $isIsnured;
        }

        $agentCount     = QuoteSignature::getData(['qId'=>$qId,'type'=>'agent','vId'=>$vId,'action'=>'completed'])->count();
        $isnuredCount   = QuoteSignature::getData(['qId'=>$qId,'type'=>'isnured','vId'=>$vId,'action'=>'completed'])->count();
        $insuredUsers   = User::getData()->where('entity_id',$quoteData->insured)->get()?->pluck('name','id')?->toArray();


        return view($this->viwePath."e_signature.e-signature-quote",['qId'=>$qId,'vId'=>$vId,'error'=>$error,'template'=>$template,'textSignature'=>$textSignature,'agencyData'=>$agencyData,'route'=>$this->route,'qId'=>$qId,'vId'=>$vId,'isAgent'=>$isAgent,'isIsnured'=>$isIsnured,'agentCount'=>$agentCount,'insuredUsers'=>$insuredUsers,'isnuredCount'=>$isnuredCount,'insured_signature_id'=>$insured_signature_id]);
    }





    /**
      * newVersion Create Show In Quote Id Base
      */
    public function quoteSignaturesSave(Request $request,$qId="null",$vId="null"){
        try {
            if ($request->ajax() && $request->isMethod('post')  ) {

                $inputs         = $request->post();
                $insuredId         = $request->post('insured_id');
                if(!empty($insuredId)){
                    $userData       = User::getData(['id'=>$insuredId])->firstOrFail();
                    $userName       = $userData?->name;
                    $userId         = $userData?->id;
                    $inputs['user_id'] = $userId;
                }else{
                    $userData       = $request->user();
                    $userName       = $userData?->name;
                    $userId         = $userData?->id;
                }


                $action         = 'signature';
                $inputs['onDB'] = 'company_mysql';
                $inputs['qid'] = $qId;
                $inputs['vid'] = $vId;
                $inputs['onDB'] = 'company_mysql';
                $inputs['action'] = $action;
                $inputs['signature_text'] = $request->post('signature_text');
                $data = QuoteSignature::insertOrUpdate($inputs);

                $id = !empty($data->id) ? ($data->id) : null;
                $data = $data->makeHidden(['ip','lat','longs','agree','city','country','created_at','updated_at'])?->toArray();
              //  dd($data);
                return response()->json(['status' => true, 'msg' =>"", 'type' => 'signature_save','data'=>$data], 200);
            }
        } catch (\Throwable $th) {
          ///  dd($th);
            return ['status'=>false,'msg'=>$th->getMessage()];
        }
    }

    /*
    *
    * insured Signature Send
    */
    public function insuredSignatureSend(Request $request,$qId="null",$vId="null"){
        try {
            if ($request->ajax() && $request->isMethod('post')  ) {
                $insured        = $request->post('insured');
                $insuredData    = User::getData(['id'=>$insured])->firstOrFail();
                $quoteData      = $this->model::getData(['id'=>$qId])->firstOrFail();
                $vData          = QuoteVersion::getData(['id'=>$vId])->firstOrFail();
                $mail           = $insuredData->email;
              //  $mail           = env('ADMIN_MAIL');
                $signatureKey = $vData?->signatureKey ;
                if(empty($signatureKey)){
                    $signatureKey = Str::uuid().time().Str::random(6);
                    $vData->signature_key = $signatureKey;
                }
                
                $vData->insured_signature_id = $insuredData->id;
              
                $vData->insured_signature_date = now()->addHours(24);
                $vData->save();
                $url = routeCheck('quotes.signature',['i'=>$signatureKey]);
              /*   dd($url); */
                if(!empty($mail)){
                    Mail::to($mail)->send(new InsuredSignatureMail(['name'=>$insuredData->name,'url'=>$url]));
                    return response()->json(['status' => true, 'msg' =>"Insured Signature Mail Send Successfully", 'type' => 'insuredSignatureSend'], 200);

                }else{
                    return response()->json(['status' => true, 'msg' =>"Insured email not available", 'type' => 'insuredSignatureSend'], 200);
                }
             }
        } catch (\Throwable $th) {
            return ['status'=>false,'msg'=>$th->getMessage()];
        }
    }

     /* e signature quote to insured */
     public function  insuredSignature(Request $request,$id){

        $vData     = QuoteVersion::getData()->where('signature_key',$id)->firstOrFail();
        $insured_signature_date = $vData->insured_signature_date;
        $insured_signature_id = $vData->insured_signature_id;
        if(strtotime($insured_signature_date) > strtotime(date('Y-m-d H:i'))){
                $qId       = $vData->quote_parent_id;
                $vId       = $vData->id;
               /*  dd($qId); */
                $error     = "";
                $ip        = $request->ip();


                $quoteData          = $this->model::getData(['id'=>$qId])->firstOrFail();
                $agencyData          = $quoteData?->agency_data;
                $companyData        = Company::first();
                $financeAgreement   = FinanceAgreement::getData()->whereStatus(1)->latest()->firstOrFail();
                $template           = !empty($financeAgreement->template) ? $financeAgreement->template : '' ;
                if(empty($template)){
                    return response()->json(['status'=>false,'msg'=>$error], 200);
                }

                $data = ['companyData'=>$companyData ,'quoteData'=>$quoteData];
                $template = ReplaceShortcodes::financeAgreementTempalte($template,$data);

                /* QuoteSetting */
                $quoteSetting  = QuoteSetting::getData()->first();
            /*  dd($quoteSetting); */
                $textSignature = !empty($quoteSetting->text_signature) ? $quoteSetting->text_signature : '';
                if(!empty($textSignature)){
                    $textSignature = Str::of($textSignature)
                                        ->replace("{AGENCYNAME}",($agencyData->name ?? ''))
                                        ->replace("{AGENCYEMAIL}",($agencyData->email ?? ''));
                }
                $quoteSignature = QuoteSignature::getData(['qId'=>$qId,'vId'=>$vId])->orderBy('index','asc')->get()?->makeHidden(['user_id','region','city','lat','longs','country','status','created_at','updated_at','qid','vid','ip'])?->keyBy('key_index')?->toArray();
            /*   dd($quoteSignature); */
                $isIsnured  = 'yes';
                $agentCount =  0;
                $isAgent = null;
                if(auth()->user()?->user_type == User::AGENT){
                    $isAgent  = (auth()->user()?->user_type == User::AGENT) ? 'yes' : 'no';
                    $agentCount = QuoteSignature::getData(['qId'=>$qId,'vId'=>$vId,'action'=>['signature','completed']])->count();
                }

                $insuredUsers = User::getData()->where('entity_id',$quoteData->insured)->get()?->pluck('name','id')?->toArray();
                return view($this->viwePath."e_signature.e-signature-quote",['qId'=>$qId,'vId'=>$vId,'error'=>$error,'template'=>$template,'textSignature'=>$textSignature,'agencyData'=>$agencyData,'route'=>$this->route,'qId'=>$qId,'vId'=>$vId,'quoteSignature'=>$quoteSignature,'isAgent'=>$isAgent,'isIsnured'=>$isIsnured,'agentCount'=>$agentCount,'insuredUsers'=>$insuredUsers,'insured_signature_id'=>$insured_signature_id]);

        }else{
            abort('500','Link expiry date');
        }

    }

    public function downloadQuoteTemplete(Request $request){

        $signatureKey       = $request->get('i');
        $html       = $request->html;
        if(!empty($signatureKey)){
            $vData     = QuoteVersion::getData()->where('signature_key',$id)->whereRaw('insured_signature_date > NOW()')->firstOrFail();
            $insured_signature_date = $vData->insured_signature_date;
            $insured_signature_id = $vData->insured_signature_id;
            $qId       = $vData->quote_parent_id;
            $vId       = $vData->id;
        }else{
            $qId       = $request->get('q');
            $vId       = $request->get('v');
            $insured_signature_id = null;
            $vData    = QuoteVersion::getData(['id'=>$vId])->firstOrFail();
        }

        $templateData = ReplaceShortcodes::financeAgreementTempalte($qId,$vId,['type'=>'view']);
        $template     = $templateData?->template ?? null;
        $quoteData    = $templateData?->quoteData ?? null;
        $vData        = $templateData?->vData ?? null;


        $quoteId = $quoteData->qid.".".(!empty($vData->version_id) ? $vData->version_id : $quoteData?->version);
        $pdfName = "PFA-{$quoteId}.pdf";
        $pdfhtmls = '<!DOCTYPE html>
		<html>
		<head>
		<style>

			@page { size: 900pt 1200pt;}
		</style>
		</head>
			<body>
				<div class="page-container">
					<div class="finance-agreement-page single-html-block">
					   '.$template.'
					</div>
				</div>
			</body></html>';
        $pdf = Pdf::loadHTML($pdfhtmls)->setPaper('A4', 'landscape');
        return $pdf->download($pdfName);

        //return redirect()->back();


    }

    /*
      @Ajax Get Data List
    */
    public function viewList(Request $request)
    {


        $columnName         = !empty($request['sort']) ? $request['sort'] : '';
        $columnSortOrder    = !empty($request['order']) ? $request['order'] : "desc";
        $offset             = !empty($request['offset']) ? $request['offset'] : 0;
        $limit              = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue        = !empty($request['search']) ? $request['search'] : '';
        $quoteId            = !empty($request['quoteId']) ? $request['quoteId'] : 'null';
        $versionId          = !empty($request['versionId']) ? $request['versionId'] : 'null';

        $vData              = QuoteVersion::getData(['id'=>$versionId])->firstOrFail();
        $documentId         = $vData?->signature_key ?? '' ;
        $agentSignature     = $vData?->agent_signature ?? '' ;
        $isnuredSignature   = $vData?->isnured_signature ?? '' ;

        $agentSignatureStatus ='Not Started';
        $isnuredSignatureStatus ='Not Started';
        $agentSignatureCount = QuoteSignature::getData(['qId'=>$quoteId,'vId'=>$versionId,'type'=>'agent',"action"=> 'signature' ])->count();
        $isnuredSignatureCount = QuoteSignature::getData(['qId'=>$quoteId,'vId'=>$versionId,'type'=>'isnured',"action"=> 'signature'])->count();
        if(!empty($agentSignatureCount)){
            $agentSignatureStatus = 'Awaiting signature';
        }
        if(!empty($agentSignatureCount)){
            $isnuredSignatureStatus = 'Awaiting signature';
        }

        $agentSignatureStatus     = !empty($agentSignature) ? 'Completed' : $agentSignatureStatus;
        $isnuredSignatureStatus   = !empty($isnuredSignature) ? 'Completed' :  $isnuredSignatureStatus;
       
       /*  $columnName = [
            'created_at' => 'quote_notes.created_at',
            'updated_at' => 'quote_notes.updated_at',
            'subject' => 'quote_notes.subject',
            'description' => 'quote_notes.description',

        ]; */

        //$columnName = !empty($columnName[$sort]) ? $columnName[$sort] : 'quote_notes.created_at';
        $sqlData = QuoteSignature::getData(['qId'=>$quoteId,'vId'=>$versionId]);


        $totalstateDatas = $sqlData->count();
        $dataArr = [];
        $data = $sqlData->skip($offset)->take($limit)->orderByEn($columnName, $columnSortOrder)->get();

        if (!empty($data)) {
            foreach ($data as $row) {
                $dataArr[] = [
                    "created_at"    => ($row?->current_datetime),
                    "ip"            => $row?->ip ?? null,
                    "ip_location"   => "{$row?->city},{$row?->country} {$row?->lat} (lat) / {$row?->longs} (longs)",
                    "description"   => $row?->signature_text,
                    "action"        => $row?->action,
                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr,'documentId'=>$documentId,'agentSignatureStatus'=>$agentSignatureStatus,'isnuredSignatureStatus'=>$isnuredSignatureStatus);
        return json_encode($response);
    }
}
