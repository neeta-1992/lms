<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Attachment,Entity,Logs
};
class AttachmentController extends Controller
{
    private $viwePath   = "company.attachments.";
    public $pageTitle   = "Attachment";
    public $activePage  = "attachment";
    public $route       = "company.attachments.";
    public function __construct(Attachment $model){
       $this->model =  $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attachment = null;
        $type = request()->type;
        if(request()->ajax() && ($type == 'quotes' || $type == 'account')){
            $attachment = $this->viewList(request()->all());
        }elseif(request()->ajax()){
            return $this->viewList(request()->all());
        }
        return view($this->viwePath."index",['routes'=>$this->route,'attachment'=>$attachment,'activePage'=>$this->activePage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $entityId = $request->id;
       $type     = $request->type;
       $quotesId     = $request->quotesId;
       $accountId     = $request->accountId;
       if(!empty($accountId)){
         $quotesId = $accountId;
       }
      // dd( $quotesId );
       $versionId     = $request->versionId;
       $pfa     = $request->pfa;
       return view($this->viwePath."create",['route'=>$this->route,'entityId'=>$entityId,'type'=>$type,'quotesId'=>$quotesId,'versionId'=>$versionId,'pfa'=>$pfa]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->post();
        try {
            $msg =null;
           if ($request->ajax()) {
                $inputs = $request->except('company_data');
                $attachments = !empty($inputs['attachments']) ? explode(",",$inputs['attachments']) : '' ;
                $activePage = !empty($inputs['type']) ? $inputs['type'] : $this->activePage;
                $typeId = !empty($inputs['typeId']) ? decryptUrl($inputs['typeId']) : null;
                $quoteId = !empty($inputs['quoteId']) ? ($inputs['quoteId']) : null;
                $versionId = !empty($inputs['versionId']) ? ($inputs['versionId']) : null;
                $attachment_type = !empty($inputs['attachment_type']) ? ($inputs['attachment_type']) : null;
                if(!empty($quoteId)){
                    $typeId = $quoteId;
                }
            //    dd($typeId);
                if(!empty($attachments)){
                    foreach ($attachments as $key => $value) {
                        $valueArr = explode("-", $value);
                        $originalName = !empty($valueArr[1]) ? $valueArr[1] : null;
                        $inputs['onDB'] = 'company_mysql';
                        $inputs['filename'] = $value;
                        $inputs['type_id'] = $typeId;
                        $inputs['v_id'] = $versionId;
                        $inputs['attachment_type'] = $attachment_type;
                        $inputs['original_filename'] = $originalName;
                        $inputs['activePage'] = !empty($inputs['type']) ? $inputs['type'] : $this->activePage;
                        $data = $this->model::insertOrUpdate($inputs);
                        $msg .= "<li>".__('logs.attachments.add',['name'=>$originalName])."</li>";
                    }
                }

                $msg = !empty($msg) ? "<ul class='logs_ul'>{$msg}</ul>" : '' ;
                !empty($msg) && Logs::saveLogs([
                    'type'=>$activePage,
                    'onDB'=>'company_mysql',
                    'user_id'=>auth()->user()->id,
                    'type_id'=>$typeId,
                    'message'=>$msg
                ]);


               return response()->json(['status'=>true,'msg'=> $this->pageTitle.' has been created successfully',
               'type'=>'attr',
               'action' => "open = 'attachments'"
               ], 200);
            }
        } catch (\Throwable $th) {
            dd($th) ;
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $entityId = $request->id;
        $type = $request->type;
        $data = $this->model::getData()->whereId($id)->firstOrFail()?->toArray();
        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id,'entityId'=>$entityId,'type'=>$type]);
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
        try {
           if ($request->ajax()) {
                $fileData = $this->model::getData()->whereId($id)->firstOrFail();
                $inputs = $request->post();
                $activePage = !empty($inputs['type']) ? $inputs['type'] : $this->activePage;
                $filename_name = !empty($inputs['original_filename']) ? $inputs['original_filename'] : '';
                $logsArr = !empty($inputs['logsArr']) ? json_decode($inputs['logsArr'],true) : null;
                $typeId = !empty($inputs['typeId']) ? decryptUrl($inputs['typeId']) : null;
                $ext = $fileData?->filename ?? null;
                $ext = !empty($ext) ? pathinfo($ext, PATHINFO_EXTENSION) : '' ;
                $inputs['id'] = ($id);
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $activePage;
                $inputs['original_filename'] = "{$filename_name}.{$ext}";

                $stateData =  $this->model::insertOrUpdate($inputs);


                $msg = !empty($logsArr) ? dbLogFormat($logsArr) : null ;
                !empty($msg) && Logs::saveLogs([
                    'type'=>$activePage,
                    'onDB'=>'company_mysql',
                    'user_id'=>auth()->user()->id,
                    'type_id'=>$typeId,
                    'message'=>$msg
                ]);
                 return response()->json(['status'=>true,'msg'=> $this->pageTitle.' has been updated successfully',
                 'type'=>'attr',
                 'action' => "open = 'attachments'"
                 ], 200);
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
        //
    }

    /*
      @Ajax Get Data List
    */
    private function viewList(array $request = null){

        $columnName      = !empty($request['sort'])   ? $request['sort'] : 'created_at';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : 'desc';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $typeId          = !empty($request['typeId']) ? $request['typeId'] : '';
        $type            = !empty($request['type']) ? $request['type'] : '';
        $quotesId        = !empty($request['quotesId']) ? $request['quotesId'] : '';
        $accountId        = !empty($request['accountId']) ? $request['accountId'] : '';


        $sqlData = $this->model::getData(['qId'=>$quotesId])
                            ->select('attachments.*','users.first_name','users.middle_name','users.last_name')
                            ->join('users','users.id','attachments.user_id');
        if(!empty($typeId)){
            $sqlData = $sqlData->decrypt($typeId,'attachments.type_id');
        }
        if(!empty($type)){
            $sqlData = $sqlData->whereEncrypted('type',$type);
        }
        if(!empty($accountId)){
            $sqlData = $sqlData->where('type_id',$accountId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

        if($type == 'quotes' || $type == 'account'){
            return  $date;
        }
          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."edit",($row['id']));
                    $name = ucfirst($row['subject']);
                    $dataArr[] = [
                        "created_at"        => changeDateFormat($row?->created_at),
                        "updated_at"        => changeDateFormat($row?->updated_at),
                        "subject"           => "<a href='javascript:void(0)' x-on:click='open = `attachmentsForm`;attachmentsEditUrl=`{$editUrl}`'  >{$name}</a>",
                        "description"       => ($row?->description ?? ''),
                        "user_name"         => "{$row?->first_name} {$row?->middle_name} {$row?->last_name}",
                        "original_filename" => ($row?->original_filename ?? ''),
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }
}
