<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyNotice;
use Str;
use PDF;
use App\Helpers\Email;
class DailyNoticesController extends Controller
{
    private $viwePath   = "company.daily-notices.";
    public  $pageTitle  = "Daily Notices";
    public  $activePage = "daily-notices";
    public  $route      = "company.daily-notices.";
    public function __construct(DailyNotice $model){
       $this->model =  $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dailyNotice = DailyNotice::getData(['status'=>1,'sendBy'=>['email','mail','fax']])->selectRaw('send_by,COUNT(*) as count,(select COUNT(*) from daily_notices where send_by = "attachments" and status = 1) as attachments_count')->groupBy('send_by')->get();
/* dd( $dailyNotice?->toArray()); */
        return view($this->viwePath."index",['route'=>$this->route,'data'=>$dailyNotice,'pageTitle'=>$this->pageTitle,'activePage'=>$this->activePage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view($this->viwePath."create",['route'=>$this->route]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $stateData =  $this->model::insertOrUpdate($inputs);
                return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been created successfully','backurl'=> route($this->route."index")], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        if(request()->ajax()){
            return $this->viewList(request()->all(),$type);
        }
        $this->pageTitle = ucfirst($type)." - ". Str::singular($this->pageTitle)." List";
        return view($this->viwePath."show",['route'=>$this->route,'pageTitle'=>$this->pageTitle,'activePage'=>$this->activePage,'type'=>$type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
        $data  = $this->model->where('id',decryptData($id))->firstOrFail()?->toArray();

        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['id'] = decryptData($id);
                $stateData =  $this->model::insertOrUpdate($inputs);


                 return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated successfully','backurl'=> route($this->route."index")], 200);
            }
        } catch (\Throwable $th) {

            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
        //
    }

    /*
      @Ajax Get Data List
    */
    private function viewList(array $request = null,$type=null){
        $dataArr         = [];
        $totalCount      = 0;
        $type             = strtolower($type) ;
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $type            = $type == 'mail' ? ['mail','attachments'] : $type;
        $sqlData         = $this->model::getData(['sendBy'=>$type]);
        $totalCount      = $sqlData->count();
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();
        $statusArray     = ['1'=>'New','2'=>"Prossec"];
          if(!empty($data)){
                foreach($data as $row){

                    $editUrl   = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $dataArr[] = array(

                        "name"              => "<a href='{$editUrl}' data-turbolinks='false' >{$row->name}</a>",
                        "account_number"    => ($row->account_number),
                        "notice"               => '<a href="javascript:void(0);"  data-id="'.$row->id.'" data-account="'.$row->account_id.'"  class="linkButton dailyNoticeDetails">'.$row->notice_name.'</a>',
                        "id"                => ($row->id),
                        "send_to"           => $row->send_data->name,
                        "insured_name"      => $row?->account_data?->insur_data?->name,
                        "status"            => isset($statusArray[$row->status]) ? $statusArray[$row->status] : 'New',
                        "created_at"        => changeDateFormat($row->created_at),
                        "updated_at"        => changeDateFormat($row->updated_at),

                    );

                }
          }
          $response = array("total" =>$totalCount,"totalNotFiltered" =>$totalCount,"rows" => $dataArr);
          return json_encode($response);
    }


    public function dailyNoticeProcessHtml(Request $request){
        $id = $request->post('id');
        $data = $this->model::getData()->whereIn('id',$id )->get();
        return view($this->viwePath."daily-notice-html",['route'=>$this->route,'data'=>$data]);
    }


    public function dailyNoticeProcessSend(Request $request){

        try {
            $userData = $request->user();
            $response = null;
            $id = $request->post('id');
            $type = $request->post('type');
            $dailyNoticeData = $this->model::getData()->whereIn('id',$id )->get();
        
            if(!empty($dailyNoticeData)){
                foreach ($dailyNoticeData as $key => $dailyNotice) {
                    $dailyNoticeId = $dailyNotice?->id ?? 0 ;
                    $dailyNoticeStatus = $dailyNotice?->status ?? 0 ;
                    $sendBy = $dailyNotice?->send_by ?? '' ;
                    $sendTo = $dailyNotice?->send_to ?? '' ;
                    $template = $dailyNotice?->template ?? '' ;
                    $subject = $dailyNotice?->subject ?? '' ;
                    $sendBy   = !empty($sendBy) ? strtolower($sendBy) : '' ;
                    $sendTo   = !empty($sendTo) ? $sendTo : '' ;
                    $companyData =  $request->company_data;
                    //dd($dailyNotice);
                  
                    
                    if(!empty($sendBy) && !empty($template) && $sendTo != 'do not sent'){
                        if($sendBy != 'mail'){
                            $status = true;
                            $pdfName = time().'processnotice.pdf';
                            if($sendBy == 'fax'){
                                $pdf =  PDF::loadHTML($template);
                                $customPaper = array(0,0,800,1150);
                                $pdf->set_paper($customPaper);
                                $pdf->render();
                                $output = $pdf->output();
                                

                                $serverEmailDomain = !empty($companyData->companyFaxSettings?->server_email_domain) ? $companyData->companyFaxSettings?->server_email_domain : '' ;
                                $outgoingFaxNumbers = !empty($companyData->companyFaxSettings?->outgoing_fax_numbers) ? $companyData->companyFaxSettings?->outgoing_fax_numbers : '' ;
                                $useSubject = !empty($companyData->companyFaxSettings?->use_subject) ? $companyData->companyFaxSettings?->use_subject : '' ;
                                $useSecuritySode = !empty($companyData->companyFaxSettings?->use_security_code) ? $companyData->companyFaxSettings?->use_security_code : '' ;
                                $securitySode = !empty($companyData->companyFaxSettings?->security_code) ? $companyData->companyFaxSettings?->security_code : '' ;
                                $serverEmail = !empty($companyData->companyFaxSettings?->server_email) ? $companyData->companyFaxSettings?->server_email : '' ;
                               
                                if($useSubject == 'Yes'){
                                    $subject  = $sendTo;
                                    $subject  =	 $outgoingFaxNumbers == true ? '1'.$subject : $subject;
                                    $fax      = $serverEmail;
                                    if($useSecuritySode == 'Yes'){
                                        $subject = !empty($securitySode) ? $subject.'.'.$securitySode : $subject;
                                    }
                                }else{
                                    $fax  = !empty($sendTo) ? $sendTo.''.$serverEmailDomain : '';
                                    $fax  =	 $outgoingFaxNumbers == true ? '+1'.$fax : $fax;
                                }
                                $response = Email::sendemail(['domPdf'=>$output,'pdfName'=>$pdfName,'email'=>$fax,'subject'=> $subject]);
                            }else{

                                $response =  Email::sendemail(['body'=>$template,'email'=>'sachin.hos7@gmail.com','subject'=> $subject]);
                         
                            }
                        }

                        if($response == true || $sendBy == 'mail'){
                            $status = false;
                            if($dailyNoticeStatus == 1){
                                $dailyNotice->status = 2;
                                $dailyNotice->save();
                            }
                           
                            if($status == '2'){
                                $logMessage =  $subject.' notice resent';
                            }else{
                                $logMessage =  $subject.' process completed'; 
                            }

                            Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$dailyNoticeId,'message'=>$logMessage]);
                        }
                    }
                    
                }
            }
            return response()->json(['status'=>true,'message'=>"Process notices successfully."], 200);
        } catch (\Throwable $th) {
           // throw $th;
            return response()->json(['status'=>false,'message'=>"{$type} not sent because of smtp error. You need to correct InMail settings"], 200);
        }
       
     
    }
}
