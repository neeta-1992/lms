<?php

namespace App\Http\Controllers\Company\Entity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Entity,EntityContact,BankAccount,Funding,Notice
};
use Str;
class GeneralAgentsController extends Controller
{
    private $viwePath = "company.entity.general-agents.";
    public  $pageTitle  = "General Agents";
    public  $activePage = "general-agents";
    public $route       = "company.general-agents.";
    public function __construct(Entity $model){
       $this->model =  $model;
       $this->type = $this->model::GENERALAGENT;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            return $this->viewList(request()->all());
        }
        return view($this->viwePath."index",['route'=>$this->route,'pageTitle' =>$this->pageTitle,'activePage' =>$this->activePage]);
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
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['type'] = $this->type;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                $data =  $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                 return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been created
                 successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                 routeCheck($this->route."index")], 200);
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
    public function edit($id)
    {
        $data = $this->model::getData(['type'=>$this->type])->decrypt($id)->firstOrFail()->makeHidden(['id','user_id'])?->toArray();
        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id ,'viwePath'=>$this->viwePath,'activePage'=>$this->activePage]);
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
                $inputs = $request->post();
                $inputs['id'] = decryptUrl($id);
                $inputs['type'] = $this->type;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                $data = $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated
                successfully'], 200);
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

        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $tab             = !empty($request['tab']) ? $request['tab'] : '';
    
     
        $sqlData = $this->model::getData(['type'=>$this->type]);
        if(!empty($tab)){
            $statusArr= ['active' => $this->model::ACTIVE,'temporary'=>$this->model::TEMPORARY];
            $tabStatus = isset($statusArr[$tab]) ? $statusArr[$tab] : '' ;
            $sqlData = $sqlData->where('status',$tabStatus);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='{$editUrl}' data-turbolinks='false'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }



   /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactCreate(Request $request,$id)
    {
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = decryptUrl($id);
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                $data = EntityContact::insertOrUpdate($inputs);
                //$id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been created successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        return view($this->viwePath."pages.contacts.create",['route'=>$this->route.'contact.','id'=>$id]);
    }


     /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactEdit(Request $request,$id)
    {
        $data = EntityContact::getData(['dId'=>$id])->firstOrFail();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = $data->agency_id;
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $data->entity_id;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                EntityContact::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        return view($this->viwePath."pages.contacts.edit",['route'=>$this->route.'contact.','id'=>$id,'data'=>$data]);
    }



      /**
     * List a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactList(Request $request)
    {
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId = !empty($request['entityId']) ? decryptUrl($request['entityId']) : '';

        $sqlData =  EntityContact::getData([]);
        if(!empty($entityId)){
            $sqlData = $sqlData->where('entity_id',$entityId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."contact.edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)'
                            x-on:click='open = `contactsForm`;contactsEditUrl=`{$editUrl}`'
                        data-url='{$editUrl}'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    /**
     * Funding Save a newly created resource in storage.
     */
    public function entityFundingSave(Request $request)
    {
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                /* $inputs['id'] = decryptUrl($request->post('id')); */
                $inputs['entity_id'] = decryptUrl($request->post('entity_id'));
                $inputs['id'] = decryptUrl($request->post('entity_id'));
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                $data = Funding::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Funding has been updated successfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }


    /**
     * Funding Page show
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityFunding(Request $request,$id)
    {
        $bankData = BankAccount::getData()->whereStatus(1)->get()?->toArray();
        $bankData = !empty($bankData) ? array_column($bankData,'bank_name','id') : [] ;
        $data = Funding::getData()->decrypt($id,'entity_id')->first()?->makeHidden(['id','user_id'])?->toArray();
        $data['entity'] = $this->model::getData()->decrypt($id)->first()?->makeHidden(['id','user_id'])?->toArray();
        $data   = !empty($data) ? $data : [];
        return view($this->viwePath."pages.funding.index",['route'=>$this->route,'data'=>$data,'id'=>$id,'bankData'=>$bankData]);
    }


    /**
     * Notice Settings Page show
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityNoticeSettings(Request $request,$id)
    {
        $validatedData = $request->all();
        $entityId = decryptUrl($id) ?? 'null';
        $data = Notice::getData(['type'=>'general-agents-notice','entityId'=>$entityId])->first()?->toArray();
        $noticeId = !empty($data['id']) ? $data['id'] : '' ;

        if(empty($noticeId)){
            $data = Notice::getData(['type'=>'general-agents-notice'])->first()?->toArray();
        }
        try {
           if ($request->ajax() && $request->isMethod("post")) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $noticeId;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $entityId;
                $inputs['logsTypeId'] = $entityId;
                $inputs['activePage'] = $this->activePage;
                $inputs['noticeType'] = "general-agents-notice";
                $inputs['lang'] = Str::replace('-', '_',$this->activePage);
                $data = Notice::insertOrUpdate($inputs);
                $msg = !empty($noticeId) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." Notice Settings has been {$msg}
                successfully", 'type'=>'attr',
                'action' => "open = 'notice-settings'"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        $json = !empty($data['json']) ? json_decode($data['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        $json['default_email_notices'] = !empty($data['default_email_notices']) ? $data['default_email_notices'] : '' ;
        $json['default_fax_notices'] = !empty($data['default_fax_notices']) ? $data['default_fax_notices'] : '' ;
        $json['default_mail_notices'] = !empty($data['default_mail_notices']) ? $data['default_mail_notices'] : '' ;

        $entityContact = EntityContact::getData()->where('entity_id',$entityId)->get()?->toArray();
        if(!empty($entityContact)){
            $entityContact = array_column($entityContact,"name",'id');
        }
        return view($this->viwePath."pages.notice.index",['route'=>$this->route,'data'=>$json,'id'=>$id,'entityContact'=>$entityContact]);
    }



}
