<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyEmailSetting;
use App\Models\CompanyFaxSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Gate,Mail;
use App\Mail\DeactiveCompany;
class FinanceCompanyController extends Controller
{
    private $viwePath = "company.company.";
    private $route = "company.finance-company.";
    public $pageTitle = "Finance Company";
    public $activePage = "finance-company";
    public function __construct(Company $model)
    {
        $this->model = $model;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = $request->model;
        $uid   = $request->uid;
        $n    = $request->n;
        $model = !empty($model) ? decryptUrl($model) : '';
        $uid   = !empty($uid) ? decryptUrl($uid) : '';
        $n = !empty($n) ? decryptUrl($n) : '';

        $loginUserData = auth()->user();
        $adminCompanyId = session()->get('adminCompanyId');
        $emailSetArr = [];

        $data = $this->model::getData()->firstOrFail();
        $data['final_approval'] = !empty($data['final_approval']) ? true : false ;
        $compantEmail = $data?->companyEmailSettings?->toArray();
        $compantFax   = $data?->companyFaxSettings?->makeHidden(['id', 'company_id', 'created_at', 'updated_at', 'date_format_value', 'time_format_value'])?->toArray();
/* dd( $data?->companyFaxSettings); */
        if(!empty($n) && $n != $data['comp_domain_name']){
            return redirect()->route('admin.dashboard');
        }
        $id = encryptData($data['id']);
        array_walk($compantEmail, function ($value, $key) use (&$emailSetArr) {
            $emailSetArr["email_setting[{$value['type']}][email]"] = $value['email'];
            $emailSetArr["email_setting[{$value['type']}][username]"] = $value['username'];
            $emailSetArr["email_setting[{$value['type']}][server]"] = $value['outgoing_server'];
            $emailSetArr["email_setting[{$value['type']}][password]"] = $value['passward'];
            $emailSetArr["email_setting[{$value['type']}][authentication]"] = $value['authentication'];
            $emailSetArr["email_setting[{$value['type']}][imap]"] = $value['imap'];
            $emailSetArr["email_setting[{$value['type']}][port]"] = $value['port'];
            $emailSetArr["email_setting[{$value['type']}][encryption]"] = $value['smpt_secure'];
            $emailSetArr["email_setting[{$value['type']}][port]"] = $value['port'];
        });

        $data = array_merge($data?->toArray(), $compantFax, $emailSetArr);

        $userDataOptions = User::getData(['type'=>User::COMPANYUSER])->whereRole(2)->get()?->pluck('name','id')?->toArray();
        return view($this->viwePath . "edit", ['data' => $data, 'id' => $id, 'route' => $this->route,'model'=>$model,'userDataOptions'=>$userDataOptions,'activePage'=>$this->activePage]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
                $requests = $request->post();
             //   dd( $requests);
                $emailSetting = !empty($requests['email_setting']) ? $requests['email_setting'] : [];
                //Comapany besic details save
                $dId = decryptData($id);
                $requests['onDB'] = 'company_mysql';
                $requests['editId'] = $dId;
                $companyId = $this->model::saveCompany($requests);
                $requests['company_id'] = $companyId->id;
                $comp_domain_name = !empty($requests['comp_domain_name']) ? $requests['comp_domain_name'] : '' ;
                //IS Admin Database update Company Data
                $companyAdminId = $this->model::getData()->whereEncrypted('comp_domain_name', $comp_domain_name)->first()?->id;
                if (!empty($companyAdminId)) {
                    $adminRequrst = $requests;
                    $adminRequrst['editId'] = $companyAdminId;
                    $adminRequrst['company_id'] = $companyAdminId;
                    unset($adminRequrst['onDB']);
                    $this->model::saveCompany($adminRequrst);
                }

                /*?----  Comapny Email setting Addd ------ */
                if (!empty($emailSetting)) {
                    foreach ($emailSetting as $key => $value) {
                        if (!empty($value['email']) && !empty($requests['company_id'])) {

                            $settingArr = [
                                'editId' => $dId,
                                'company_id' => $requests['company_id'],
                                'type' => $key,
                                'email' => $value['email'],
                                'username' => $value['username'],
                                'outgoing_server' => !empty($value['server']) ? $value['server'] : '',
                                'passward' => $value['password'],
                                'authentication' => !empty($value['authentication']) ? $value['authentication'] : '',
                                'imap' => $value['imap'],
                                'port' => !empty($value['port']) ? $value['port'] : '',
                                'smpt_secure' => $value['encryption'],
                                'onDB' => $requests['onDB'],
                            ];

                            CompanyEmailSetting::saveData($settingArr);
                            if (!empty($companyAdminId)) {
                                $settingArr['onDB'] = null;
                                $settingArr['company_id'] = $adminRequrst['company_id'];
                                CompanyEmailSetting::saveData($settingArr);
                            }
                        }
                    }
                }

                /*?----  Comapny fax setting Add  ------ */
                $CompanyFaxSetting = CompanyFaxSetting::saveData($requests);
                if (!empty($companyAdminId)) {
                    CompanyFaxSetting::saveData($adminRequrst);
                }
                /*?----  Comapny Data Save In User table ------ */
                $userCompanyId = User::saveCompany($requests);
                if (!empty($companyAdminId)) {
                    User::saveCompany($adminRequrst);
                }
                return response()->json(['status' => true, 'msg' => 'Your finance company has been updated successfully.', 'backurl' => route($this->route . "index")], 200);
            }
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()], );
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



    public function deactiveUser(Request $request){
        $companyId          = $request->id;
        $adminData          = User::getData(['type'=>User::ADMIN])->first();
        $adminEmail         = $adminData?->email ?? '';

        $companyData        = $this->model::getData(['dId'=>$companyId])->first();
        $companyUserData    = User::getData()->where('company_id',$companyData->id)->first();


        $companyUserData->status = User::INACTIVEUSER;
        $companyUserData->save();

        $adminCompanyData = $this->model::whereEn('comp_domain_name',$companyData?->comp_domain_name)->first();
      /*  dd($companyData?->comp_domain_name); */
        User::where('company_id',$adminCompanyData->id)->update(['status'=>User::INACTIVEUSER]);
        $adminEmail = 'neetaagrawal19@gmail.com';
        $mailData = ['name'=>$companyData?->comp_name,'url'=>route("company.finance-company.index",['model'=>encryptUrl("true"),'uid'=>$companyId,'n'=>encryptUrl($companyData?->comp_domain_name)])];
        Mail::to($adminEmail)->send(new DeactiveCompany($mailData));

        return response()->json(['status'=>true,'url'=>routeCheck('company.finance-company.index')]);
    }


    public function deactiveUserConfirmation(Request $request){
        $companyId          = $request->id;


        $companyData        = $this->model::getData(['dId'=>$companyId])->first();
        $companyUserData    = User::getData()->where('company_id',$companyData->id)->first();


        $companyUserData->status = User::DISABLEUSER;
        $companyUserData->save();

        $adminCompanyData = $this->model::whereEn('comp_domain_name',$companyData?->comp_domain_name)->first();
        User::where('company_id',$adminCompanyData->id)->update(['status'=>User::DISABLEUSER]);

        return response()->json(['status'=>true,'url'=>routeCheck('admin.finance-company.index')]);
    }

}
