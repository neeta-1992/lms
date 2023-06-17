<?php

namespace App\Http\Controllers\Company\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,Logs,Entity,AgentOffice,UserPermission
};
use App\Helpers\Permissions;
class FindUserController extends Controller
{
    private $viewPath   = "company.users.find-user.";
    public  $pageTitle  = "Find/Edit Users";
    public  $activePage = "find-user";
    public  $route       = "company.find-user.";

     /**
     * Display Search Inputs.
     *
     * @return \Illuminate\Http\Response
     */
    public function findUser(){
        return view("{$this->viewPath}index",['route'=>$this->route,'activePage'=>$this->activePage]);
    }

      /**
     * Display Search Inputs.
     *
     * @return \Illuminate\Http\Response
     */
    public function findUserView($userId){
        $data = User::getData()->with('profile')->decrypt($userId)->firstOrFail();
/*         dd($data->username); */
        $email_information = !empty($data->email_information) ? json_decode($data->email_information,true) : null;
        $userType = !empty($data['user_type']) ? $data['user_type'] : 0 ;
        $profile = !empty($data['profile']) ? $data->profile?->makeHidden(['id','created_at','updated_at'])?->toArray() : [];
        $data    = $data?->toArray() ?? [];
        $data    = array_merge($data,$profile);
		if(!empty($email_information)){
             foreach ($email_information as $key => $value) {
                $data["email_information[{$key}]"] =$value;
             }
        }

        $office  = null;
		$userTypeText = 'User';
        switch ($userType) {
            case User::AGENT:
				$userTypeText = "Agent";
                $view = "{$this->viewPath}user.agent";
                $office = AgentOffice::getData(['entityId' => $data['entity_id']])->get()->pluck('name','id');
                break;
            case User::INSURED:
				$userTypeText = "Insured";
                $view = "{$this->viewPath}user.insured";
                break;
            case User::SALESORG:
				$userTypeText = "Sales Organization";
                $view = "{$this->viewPath}user.sales-organization";
                break;
            case User::COMPANYUSER:
                $view = "{$this->viewPath}user.user";
                break;
            default:
                $view = "{$this->viewPath}user.user";
                break;
        }
        $pageTitle = !empty($data['name']) ? $data['name'] : 'Edit User';
        $permissions = Permissions::permissions($userType);
        $reports     = Permissions::reports($userType);
        $UserPermission = UserPermission::getData(['userId'=>$data['id']])->first();
        if(empty($UserPermission)){
            $UserPermission = UserPermission::getData(['type'=>$userType])->first();
        }

        $permissionsDB = !empty($UserPermission->permissions) ? json_decode($UserPermission->permissions,true) : '' ;
        $reportsDB = !empty($UserPermission->reports) ? json_decode($UserPermission->reports,true) : '' ;

        $permissionArray = $reportsArr = [];
        if(!empty($permissionsDB)){
            foreach ($permissionsDB as $key => $value) {
                $permissionArray['permission'][$key] = $value;
            }
        }
        if(!empty($reportsDB)){
            foreach ($reportsDB as $key => $value) {
                $reportsArr['report'][$key] = $value;
            }
        }
        $UserPermission = !empty($UserPermission) ? $UserPermission->toArray() : [];
        $userPermission = array_merge($UserPermission,$permissionArray,$reportsArr);
		return  view("{$this->viewPath}user",['route'=>$this->route,'userPermission'=>$userPermission,'permissions'=>$permissions,'reports'=>$reports,'view'=>$view,'activePage'=>$this->activePage,'data'=>$data,'id'=>$userId,'office'=>$office,'pageTitle'=>$pageTitle,'userTypeText'=>$userTypeText]);
    }

    public function saveUser(Request $request,$userId){
        try {
            $id = decryptUrl($userId) ?? 'null';
           if ($request->ajax() && $request->isMethod('put')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['password'] = !empty($request->post('password')) ? bcrypt($request->post('password')) : null;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['id'] = $id;
                $inputs['logId'] = $id;
             /*  dd( $inputs); */
                $data = User::saveAgent($inputs);
                $id   = !empty($data->id) ? encryptUrl($data->id) : null;
               
                return response()->json(['status'=>true,'msg'=> ' User has been updated successfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }


    /**
     * Display List.
     *
     * @return \Illuminate\Http\Response
     */
    public function findUserList(Request $request){

        $columnName      = !empty($request['sort'])   ? $request['sort'] : 'id';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : 'desc';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';

        $fillterArr = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'telephone'     => $request->telephone,
            'role'          => $request->role,
            'user_type'     => $request->user_type,
        ];
        $sqlData = User::getData($fillterArr);
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $data = $sqlData->skip($offset)->take($limit) ->orderByEn($columnName,$columnSortOrder)->get();
        $roleArr = [1 => 'Adminstrator',2 => 'User' ];
          if(!empty($data)){
                foreach($data as $row){
                    $editUrl = routeCheck($this->route."view",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "first_name" => "<a href='{$editUrl}' data-turbolinks='false' >{$name}</a>",
                        "mobile" => $row?->mobile,
                        "email" => $row?->email,
                        "user_name" => $row?->username,
                        "user_type" => !empty($row?->user_type) ? loginUserTypeArr($row?->user_type) : '',
                        "role" => isset($roleArr[$row?->role]) ? $roleArr[$row?->role] : '',
                        "status" => statusArr($row?->status ?? 0),
                    ];

                }
          }
        $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
        return json_encode($response);
    }


    public function addNewUser(){
        $pageTitle = "Add New User";
        return view("{$this->viewPath}new-user",['route'=>$this->route,'viewPath'=>$this->viewPath,'activePage'=>$this->activePage,'pageTitle'=>$pageTitle,'office'=>[]]);
    }
    public function userView(Request $request){
        $pageTitle = "Add New User";
        $userType = (int)$request->userType;
        $agency = $request->agency;
        $salesOrganization = $request->salesOrganization;
        $office = $entityId =null;
         switch ($userType) {
            case User::AGENT:
                $view = "{$this->viewPath}user.agent";
                $entityId = $agency;
                $office = AgentOffice::getData(['entityId' => $agency])->get()->pluck('name','id');
                break;
            case User::INSURED:
                $view = "{$this->viewPath}user.insured";
                break;
            case User::SALESORG:
                $entityId = $salesOrganization;
                $view = "{$this->viewPath}user.sales-organization";
                break;
            case User::COMPANYUSER:
                $view = "{$this->viewPath}user.user";
                break;
            default:
                $view = "{$this->viewPath}user.user";
                break;
        }
        return view($view,['office'=>$office,'entityId'=>$entityId]);
    }


      /**
     * entity user agent Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserCreate(Request $request)
    {
        $entityId = $request->entityId;
        $agency = $request->agency;
        $userType = $request->user_type;
        $entityData = Entity::getData(['id'=>$entityId])->firstOrFail();
        try {
           if ($request->ajax() && $request->isMethod('post')) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['type'] = $userType;
                if($userType == 3){
                    $inputs['userType'] = 'finance-company';
                }else{
                    $inputs['agencyUsername'] =$entityData?->username ?? '';
                    $inputs['entity_id'] = $entityId;
                    $inputs['logId'] = $entityId;
                }

                //dd($inputs);
                $data = User::saveAgent($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> ' User has been created successfully',
               'url'=> routeCheck($this->route."new-user")], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        return view($this->viwePath."users.create",['route'=>$this->route.'users','id'=>$id]);
    }


     /**
     * Group Permissions a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function groupPermissions(Request $request)
    {
        $validatedData  = $request->all();
        $userId         = $request->post('userId');

        $userData       = User::getData()->with('profile')->decrypt($userId)->firstOrFail();
        $data           = UserPermission::getData(['userId'=>$userData?->id])->first();
        $userType = $userData->user_type;
       /// $type           = decryptUrl($userType);
        try {
           if ($request->ajax()) {
                $inputs                 = $request->post();
                $inputs['onDB']         = 'company_mysql';
                $inputs['user_type']    = $userType;
                $inputs['userId'] = $userData?->id;
                $inputs['id']           = $data?->id;
                $inputs['activePage']   = $this->activePage;
                $inputs['logId'] = $userData?->id;
               // dd($inputs);
                $data                   = UserPermission::insertOrUpdate($inputs);
                $id                     = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been created
                successfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }



}
