<?php

namespace App\Http\Controllers\Company\Entity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Agent,User,Entity,AgentOffice,
    Funding,BankAccount,Notice,
    AgentOtherSetting
};
use Str,Validator;
use App\Rules\CustomePassword;
class AgentsController extends Controller
{
    private $viwePath = "company.entity.agents.";
    public $pageTitle = "Agent";
    public $activePage = "agents";
    public $route = "company.agents.";
    public function __construct(Entity $model){
       $this->model =  $model;
       $this->type = $this->model::AGENT;
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
        return view($this->viwePath."index",['route'=>$this->route,'activePage'=>$this->activePage]);
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
                $inputs['lang'] = Str::replace('-','_',$this->activePage);
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
        $data = $this->model::getData()->decrypt($id)->firstOrFail()?->toArray();

        return view($this->viwePath."edit",[
            'route'=>$this->route,
            'data'=>$data,
            'id'=>$id,
            'viwePath'=>$this->viwePath,
            'activePage'=>$this->activePage
        ]);
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
                $inputs['type'] = $this->type;
                $inputs['id'] = decryptUrl($id);
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replace('-','_',$this->activePage);
                $stateData =  $this->model::insertOrUpdate($inputs);
               return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated
               successfully','backUrl'=> routeCheck($this->route."edit",$id)], 200);
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


        $sqlData = $this->model::getData(['type'=>$this->type]);
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
                        "name" => "<a href='{$editUrl}' data-turbolinks='false' >{$name}</a>",
                        "email" => $row?->email ?? '',
                        "telephone" => $row?->telephone ?? '',
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


      /**
     * List a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityofficeList(Request $request,$agencId='null')
    {
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId = !empty($agencId) ? decryptUrl($agencId) : '';

        $sqlData = AgentOffice::getData();
        if(!empty($entityId)){
            $sqlData = $sqlData->where('agency_id',$entityId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."office.edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)' x-on:click='open = `officeForm`;officeEditUrl=`{$editUrl}`'
                         data-url='{$editUrl}'>{$name}</a>",
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
    public function entityOfficeCreate(Request $request,$id)
    {
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = decryptUrl($id);
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agency_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                $data = AgentOffice::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Office has been created successfully',
                'type'=>'attr',
                'action' => "open = 'offices'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        return view($this->viwePath."offices.create",['route'=>$this->route.'office','id'=>$id]);
    }


     /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityOfficeEdit(Request $request,$id)
    {
        $data = AgentOffice::getData(['dId'=>$id])->firstOrFail();
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = $data->agency_id;
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agency_id'] = $data->agency_id;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                AgentOffice::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Office has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'offices'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        return view($this->viwePath."offices.edit",['route'=>$this->route.'office','id'=>$id,'data'=>$data]);
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
        return view($this->viwePath."funding.index",['route'=>$this->route,'data'=>$data,'id'=>$id,'bankData'=>$bankData]);
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

        $data = Notice::getData(['type'=>'agent','entityId'=>$entityId])->first()?->toArray();
        $noticeId = !empty($data['id']) ? $data['id'] : '' ;

        if(empty($noticeId)){
            $data = Notice::getData(['type'=>'agent'])->first()?->toArray();
        }
        try {
           if ($request->ajax() && $request->isMethod("post")) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $noticeId;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $entityId;
                $inputs['logsTypeId'] = $entityId;
                $inputs['logsTypeId'] = $entityId;
                $inputs['activePage'] = $this->activePage;
                $inputs['noticeType'] = "agent";
                $inputs['lang'] = Str::replace('-', '_',$this->activePage);
                $data = Notice::insertOrUpdate($inputs);
                $msg = !empty($noticeId) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." Notice Settings has been {$msg} successfully",
             'type'=>'attr',
             'action' => "open = 'notices'"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        $json = !empty($data['json']) ? json_decode($data['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        $json['default_email_notices'] = !empty($data['default_email_notices']) ? $data['default_email_notices'] : '' ;
        $json['default_fax_notices'] = !empty($data['default_fax_notices']) ? $data['default_fax_notices'] : '' ;
        $json['default_mail_notices'] = !empty($data['default_mail_notices']) ? $data['default_mail_notices'] : '' ;
        return view($this->viwePath."notice.index",['route'=>$this->route,'data'=>$json,'id'=>$id]);
    }



      /**
     * List a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentUser(Request $request,$agencyId)
    {
        $userType = User::AGENT;
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId        = !empty($agencyId) ? decryptUrl($agencyId) : '';

        $sqlData = User::getData(['entityId'=>$entityId,'type'=>$userType]);

        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."users.edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)'
                        x-on:click='open = `userForm`;usersEditUrl=`{$editUrl}`'
                         data-url='{$editUrl}'>{$name}</a>",
                        "username" => $row?->username,
                        "role" => $row?->role == 1 ? 'Adminstrator' : 'User',
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }



      /**
     * entity user agent Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentUserCreate(Request $request,$id)
    {
        $entityData = $this->model::getData()->decrypt($id)->firstOrFail();
        $agencyId = decryptUrl($id);
        try {
           if ($request->ajax() && $request->isMethod('post')) {

                $validator = Validator::make($request->post(),[
                    'first_name'    =>  'required',
                    'last_name'     => 'required',
                    'email'         => 'required|email',
                    'password' => ['nullable',new CustomePassword(User::AGENT)],
                ]);
                if ($validator->fails()){
                     return response()->json(['status'=>false, 'errors' => $validator->getMessageBag()->toArray()],422);
                }

                $inputs = $request->post();
                $inputs['password'] = !empty($request->post('password')) ? bcrypt($request->post('password')) : null;
			
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agencyUsername'] =$entityData?->username ?? '';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                $inputs['type'] = User::AGENT;
                $data = User::saveAgent($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;



                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' User has been created successfully',
                'type'=>'attr',
                'action' => "open = 'users'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $office = AgentOffice::getData(['entityId' => $agencyId])->get()->pluck('name','id');

        return view($this->viwePath."users.create",['route'=>$this->route.'users','id'=>$id,'office'=>$office]);
    }


         /**
     * entity user agent Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentUserEdit(Request $request,$id)
    {

        $userData = User::getData()->with('profile')->decrypt($id)->firstOrFail();
		//dd($userData?->toArray());
        $profile = !empty($userData['profile']) ? $userData->profile?->makeHidden(['id','created_at','updated_at'])?->toArray() : [];

        $agencyId = $userData?->entity_id;

        try {
           if ($request->ajax() && $request->isMethod('post')) {

                $validator = Validator::make($request->post(),[
                    'first_name'    =>  'required',
                    'last_name'     => 'required',
                    'email'         => 'required|email',
                    'password' => ['nullable',new CustomePassword(User::AGENT)],
                ]);
                if ($validator->fails()){
                     return response()->json(['status'=>false, 'errors' => $validator->getMessageBag()->toArray()],422);
                }
                $inputs = $request->post();
				$inputs['password'] = !empty($request->post('password')) ? bcrypt($request->post('password')) : null;
				//dd($inputs);
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['id'] = $userData?->id;
                $inputs['logId'] = $agencyId;
                $inputs['type'] = User::AGENT;
                $data = User::saveAgent($inputs);
                $id   = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' User has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'users'"
             ], 200);
            }
        } catch (\Throwable $th) {
          /*   dd($th); */
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $office = AgentOffice::getData(['entityId' => $agencyId])->get()->pluck('name','id');
        $userData = $userData?->toArray() ?? [];
        $userData = array_merge($userData,$profile);

        return view($this->viwePath."users.edit",['route'=>$this->route.'users','id'=>$id,'office'=>$office,'data'=>$userData]);
    }



     /**
     * other setting Save a newly created resource in storage.
     */
    public function entityOtherSetting(Request $request,$agencyId)
    {
        $ids = decryptUrl($agencyId);

        $data = AgentOtherSetting::getData(['entityId'=>$ids])->first();
        $validatedData = $request->all();
        if ($request->ajax() && $request->isMethod('post')) {
            try {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $ids;
                $inputs['id'] = ($data?->id ?? '');
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $ids;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                AgentOtherSetting::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Other Setting has been updated successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
            }
        }

        return view($this->viwePath."other-settings.index",['route'=>$this->route.'users','id'=>$agencyId,'data'=>$data]);
    }

}
