<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Company,CompanyEmailSetting,CompanyFaxSetting,User
};
use Session,Mail,Config,DB;
use App\Mail\CompanyDataBase as CompanyDataBaseMail;
use App\Http\Requests\FinanceCompanyRequest;
use App\Helpers\AllDataBaseUpdate;
class FinanceCompanyController extends Controller
{
    private $viwePath   = "admin.company.";
    private $route      = "admin.finance-company.";
    public  $pageTitle  = "Finance Company";
    public  $activePage = "finance-company";
    public function __construct(Company $model){
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

       return view($this->viwePath."create",['route'=>$this->route]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinanceCompanyRequest $request){

        $validatedData = $request->validated();

        try {
           if ($request->ajax()) {
                $requests = $request->post();
                $emailSetting  = !empty($requests['email_setting']) ? $requests['email_setting'] : [] ;
                //Comapany besic details save
                $userId = auth()->user()->id;
                $requests['user_id'] = $userId;
                $companyId =  $this->model::saveCompany($requests);
                $requests['company_id'] = $companyId->id;

                /*?----  Comapny Email setting Addd ------ */
                if(!empty($emailSetting)){
                    foreach ($emailSetting as $key => $value) {
                        if(!empty($value['email']) && !empty($requests['company_id'])){

                            $settingArr = [
                                    'company_id'        =>$requests['company_id'],
                                    'type'              =>$key,
                                    'email'             =>$value['email'],
                                    'username'          =>$value['username'],
                                    'outgoing_server'   =>!empty($value['server'])  ? $value['server'] : '',
                                    'passward'          =>$value['password'],
                                    'authentication'    =>!empty($value['authentication'])  ? $value['authentication'] : '',
                                    'imap'              =>$value['imap'],
                                    'port'              =>!empty($value['port'])  ? $value['port'] : '',
                                    'smpt_secure'       =>$value['encryption'],
                            ];

                            CompanyEmailSetting::saveData($settingArr);
                        }
                    }
                }


               /*?----  Comapny fax setting Add  ------ */
                $CompanyFaxSetting = CompanyFaxSetting::saveData($requests);
               /*?----  Comapny Data Save In User table ------ */
                $userCompanyId = User::saveCompany($requests);
                $preDatabase = config('database.connections.mysql.database');
                $compDomainName = $request?->comp_domain_name;
                $comapnyUserName = !empty($compDomainName) ? strtolower(trim(str_replace("-","_",$compDomainName))) :"";
                $companyDBName = "{$preDatabase}_{$compDomainName}";
                 Mail::to(env('ADMIN_MAIL'))->send(new CompanyDataBaseMail(['name' => $companyDBName]));

                return   response()->json(['status'=>true,'msg'=>'Your finance company has been created successfully. It will be setup within 7 days.','backurl'=> route($this->route."index")], 200);
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

        $data = $this->model->where('uuid',$id)->with('user')->firstOrFail()?->toArray();
        $did = $data['id'];
        $compantEmail = CompanyEmailSetting::whereCompanyId($did)->get()?->toArray();
        $compantFax =CompanyFaxSetting::whereCompanyId($did)->first()?->makeHidden(['id','company_id','created_at','updated_at','date_format_value','time_format_value'])?->toArray();
    /*    dd($compantFax); */
        $emailSetArr = [];
        array_walk($compantEmail, function ($value, $key) use (&$emailSetArr) {
            $emailSetArr["email_setting[{$value['type']}][email]"]    = $value['email'];
            $emailSetArr["email_setting[{$value['type']}][username]"] = $value['username'];
            $emailSetArr["email_setting[{$value['type']}][server]"]   = $value['outgoing_server'];
            $emailSetArr["email_setting[{$value['type']}][password]"] = $value['passward'];
            $emailSetArr["email_setting[{$value['type']}][authentication]"] = $value['authentication'];
            $emailSetArr["email_setting[{$value['type']}][imap]"] = $value['imap'];
            $emailSetArr["email_setting[{$value['type']}][port]"] = $value['port'];
            $emailSetArr["email_setting[{$value['type']}][encryption]"] = $value['smpt_secure'];
            $emailSetArr["email_setting[{$value['type']}][port]"] = $value['port'];
        });
        $eid = encryptUrl( $data['id']);
        $data = array_merge($data,$compantFax,$emailSetArr);

        return view($this->viwePath."edit",['data'=>$data,'eid'=>$eid,'id'=>$id,'route'=>$this->route,'activePage'=>$this->activePage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FinanceCompanyRequest $request,$id){

        $validatedData = $request->validated();
       try {
           if ($request->ajax()) {
                $requests = $request->post();
                $emailSetting  = !empty($requests['email_setting']) ? $requests['email_setting'] : [] ;
                //Comapany besic details save
               /// $dId   = decryptUrl($id);
                $requests['uuid'] = $id;
                $companyId =  $this->model::saveCompany($requests);
                $requests['company_id'] = $companyId->id;
                $dId = $companyId->id;

                /*?----  Comapny Email setting Addd ------ */
                if(!empty($emailSetting)){
                    foreach ($emailSetting as $key => $value) {
                        if(!empty($value['email']) && !empty($requests['company_id'])){

                            $settingArr = [
                                    'editId'            =>$dId,
                                    'company_id'        =>$requests['company_id'],
                                    'type'              =>$key,
                                    'email'             =>$value['email'],
                                    'username'          =>$value['username'],
                                    'outgoing_server'   =>!empty($value['server'])  ? $value['server'] : '',
                                    'passward'          =>$value['password'],
                                    'authentication'    =>!empty($value['authentication'])  ? $value['authentication'] : '',
                                    'imap'              =>$value['imap'],
                                    'port'              =>!empty($value['port'])  ? $value['port'] : '',
                                    'smpt_secure'       =>$value['encryption'],
                            ];

                            CompanyEmailSetting::saveData($settingArr);
                        }
                    }
                }


               /*?----  Comapny fax setting Add  ------ */
                $requests['editId'] =$dId;
                $CompanyFaxSetting = CompanyFaxSetting::saveData($requests);
               /*?----  Comapny Data Save In User table ------ */
                $userCompanyId = User::saveCompany($requests);

                 return response()->json(['status'=>true,'msg'=>'Your finance company has been updated successfully','backurl'=> route($this->route."index")], 200);
            }
        } catch (\Throwable $th) {
/* dd($th); */
            return response()->json(['status'=>false,'msg'=>$th->getMessage()],);
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
        try {
            $data = $this->model::whereUuid($id)->first();
            if(!empty($data?->id)){
                $compantEmail = CompanyEmailSetting::whereCompanyId($data->id)->delete();
                $compantFax =CompanyFaxSetting::whereCompanyId($data->id)->delete();
                $data->delete();
            }
            return response()->json(['status'=>true,'url'=>routeCheck($this->route.'index')], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
    }


     /*
@AjaxGet Data List
    */
    private function viewList(array $request = null){

        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';

        switch ($columnName) {
            case 'name':
                $columnName = "first_name";
                break;
            case 'telephone':
                $columnName = "mobile";
                break;
            default:
                $columnName = $columnName;
                break;
        }

        $sqlData         = $this->model::getData(['type'=>'0'])->with("user");
        $totalCount      = $sqlData->count();
        $dataArr         = [];
        $sqlData = $sqlData->skip($offset)->take($limit);
        $data = $sqlData->get()->load(['user' => function ($q) use($columnName,$columnSortOrder) {
            $q->orderBy($columnName, $columnSortOrder);
        }]);

        if(!empty($data)){
                foreach($data as $row){
                    $url =
                    routeCheck($this->route."adminlogin",['id'=>encryptUrl($row['id']),'host'=>encryptUrl($row['comp_domain_name'])]);
					$editurl = routeCheck($this->route."edit",$row['uuid'] );
                    $status = $row?->user?->status ?? 0 ;
                    if($status == 0){
                        $name = "<a href='{$editurl}' class='mr-2' data-turbolinks='false'><span
                            class='mr-2'>{$row->comp_name}</span></a><button type='button' class='btn btn-danger btn-circle btn-xsm'></button>";
                    }elseif($status == 1 || $status == 3){
                        $name = "<a href='{$url}' class='mr-2' data-turbolinks='false'>{$row->comp_name}</a><button type='button' class='btn btn-success btn-circle btn-xsm'></button>";
                    }else{
                        $name = "<a
                            href='{$editurl}' class='mr-2' data-turbolinks='false'><span
                            class='mr-2'>{$row->comp_name}</span></a><button type='button' class='btn btn-warning  btn-circle btn-xsm'></button>";
                    }
                    $dataArr[] = array(
						"created_at" => changeDateFormat($row->created_at),
						"updated_at" => changeDateFormat($row->updated_at),
                        "name" => $name,
                        "email"      => $row->comp_contact_email,
                        //"telephone"  => $row->primary_telephone,
                    );
                }
        }
          $response = array("total" =>$totalCount,"totalNotFiltered" =>$totalCount,"rows" => $dataArr);
          return json_encode($response);
    }


    public function adminFinanceCompanyLogin(Request $request,$id=null,$host=null){
        $dID   = decryptUrl($id);
        $dHost = decryptUrl($host);
        Session::put('adminCompanyId',$dID);
        Config::set(["fortify.isAdminCompany"=>true]);
        return redirect($dHost);
    }



    public function activeCompany(Request $request,$id=null,$host=null){
        $companyId = $request->id;

        $adminCompanyData = $this->model::decrypt($companyId)->first();
        User::where('company_id',$adminCompanyData->id)->update(['status'=>User::ACTIVEUSER]);

        $compDomainName = $adminCompanyData?->comp_domain_name;

        if(!empty($compDomainName)){
            $preDatabase = config('database.connections.mysql.database');
            $comapnyUserName =  !empty($compDomainName) ? strtolower(trim(str_replace("-","_",$compDomainName))) : "";
            $companyDBName   =  "{$preDatabase}_{$comapnyUserName}";
            \Config::set('database.connections.company_mysql.database',$companyDBName);
            DB::purge('company_mysql');
            DB::reconnect('company_mysql');

            $companyData = $this->model::on('company_mysql')->with('user')->whereEn('comp_domain_name',$compDomainName)->first();
            User::on('company_mysql')->where('company_id',$companyData->id)->update(['status'=>User::ACTIVEUSER]);
        }


       return response()->json(['status'=>true,'msg'=>' finance company has been active successfully','url'=>routeCheck('admin.finance-company.index')], 200);
    }
}
