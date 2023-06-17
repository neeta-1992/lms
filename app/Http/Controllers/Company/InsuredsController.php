<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Agent,User,Entity,AgentOffice,
    Funding,BankAccount,Notice,
    AgentOtherSetting
};
use Illuminate\Validation\Rule;
use Str;
class InsuredsController extends Controller
{
    private $viwePath   = "company.insureds.";
    public  $pageTitle  = "Insured";
    public  $activePage = "insureds";
    public  $route      = "company.insureds.";
    public function __construct(Entity $model){
       $this->model =  $model;
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
        return view($this->viwePath."index",['route'=>$this->route]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $agency = Entity::getData(['type' => 3])->get()?->pluck('name','id')?->toArray();
       return view($this->viwePath."create",['route'=>$this->route,'agency'=>$agency]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique_encrypted:entities,name,type,4'
        ],[
            'unique_encrypted' => 'Insured name already exists with this name',
        ]
        );
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
               // $inputs['status'] = 1;
                $inputs['type'] = 4;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replace('-','_',$this->activePage);
               // dd( $inputs);
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
        $json = !empty($data['json']) ? json_decode($data['json'],true) : '' ;
        if(!empty($json)){
            array_walk($json, function ($value, $key) use (&$data) {
                $data["insurance[{$key}]"] = $value;
            });
        }

        $agency = Entity::getData(['type' => 3])->get()?->pluck('name','id')?->toArray();
        return view($this->viwePath."edit",[
            'route'=>$this->route,
            'data'=>$data,
            'agency'=>$agency,
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

        $validated = $request->validate([
            'name' => "required|unique_encrypted:entities,name,id,{$id},type,4"
        ],[
            'unique_encrypted' => 'Insured name already exists with this name',
        ]
        );

        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['type'] = 4;
                $inputs['id'] = decryptUrl($id);
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['lang'] = Str::replace('-','_',$this->activePage);
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


        $sqlData = $this->model::getData(['type'=>4]);
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
                        "legal_name" => $row?->legal_name ?? '',
                        "telephone" => $row?->telephone ?? '',
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
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

        $data = Notice::getData(['type'=>'insured','entityId'=>$entityId])->first()?->toArray();
        $noticeId = !empty($data['id']) ? $data['id'] : '' ;

        if(empty($noticeId)){
            $data = Notice::getData(['type'=>'insured'])->first()?->toArray();
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
                $inputs['noticeType'] = "insured";
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
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId        = !empty($agencyId) ? decryptUrl($agencyId) : '';

        $sqlData = User::getData(['entityId'=>$entityId]);

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

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['type'] = 4;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agencyUsername'] =$entityData?->username ?? '';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
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
        $office = AgentOffice::getData(['entityId' => $agencyId])->get()->pluck('name');

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
        $agencyId = $userData?->entity_id;
        $profile = !empty($userData['profile']) ? $userData->profile?->makeHidden(['id','created_at','updated_at'])?->toArray() : [];
        $agencyId = $userData?->entity_id;
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['id'] = $userData?->id;
                $inputs['logId'] = $agencyId;
                $data = User::saveAgent($inputs);
                $id   = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' User has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'users'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        $userData = $userData?->toArray() ?? [];
        $userData = array_merge($userData,$profile);
        return view($this->viwePath."users.edit",['route'=>$this->route.'users','id'=>$id,'data'=>$userData]);
    }





}
