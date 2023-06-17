<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Setting,BankAccount,CompanyDefaultFunding
};
use Str;
class SettingController extends Controller
{
    private $viwePath  = "company.settings.";
    public  $pageTitle = "Settings";
    public  $activePage = "setting";
    public  $route      = "company.settings.";
    public function __construct(Setting $model){
       $this->model =  $model;
    }

    public function accountSettings(Request $request){
        $pageTitle  = "Account  {$this->pageTitle}";
        $activePage = "account-{$this->activePage}";
        $route      = "{$this->route}account-setting";
        $data       =  $this->model::getData(['type'=>$activePage])->first();
       // dd($data );
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $pageTitle;
                $inputs['activePage'] = $activePage;
                $inputs['onDB'] = 'company_mysql';
                $res = $this->model::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status'=>true,'msg'=>$pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $data = !empty($data->json) ? json_decode($data->json,true) : [];
        return  view($this->viwePath.$activePage,['route'=>$route,'pageTitle'=>$pageTitle,'data'=>$data,'activePage'=>$activePage]);
    }


    public function electronicPaymentSettings(Request $request){
        $pageTitle  = "Electronic Payment {$this->pageTitle}";
        $activePage = "electronic-payment-{$this->activePage}";
        $route      = "{$this->route}electronic-payment";
        $data       =  $this->model::getData(['type'=>$activePage])->first();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $pageTitle;
                $inputs['activePage'] = $activePage;
                $inputs['onDB'] = 'company_mysql';
                $res = $this->model::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status'=>true,'msg'=>$pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $data = !empty($data->json) ? json_decode($data->json,true) : [];
      //  dd($data );
        return  view($this->viwePath.$activePage,['route'=>$route,'pageTitle'=>$pageTitle,'data'=>$data,'activePage'=>$activePage]);
    }


    public function achSettingsSettings(Request $request){
        $pageTitle  = "NACHA File and ACH {$this->pageTitle}";
        $activePage = "nacha-ach-{$this->activePage}";
        $route      = "{$this->route}ach-settings";
        $data       =  $this->model::getData(['type'=>$activePage])->first();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $pageTitle;
                $inputs['activePage'] = $activePage;
                $inputs['onDB'] = 'company_mysql';
                $res = $this->model::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status'=>true,'msg'=>$pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $data = !empty($data->json) ? json_decode($data->json,true) : [];
      //  dd($data );
        return  view($this->viwePath.$activePage,['route'=>$route,'pageTitle'=>$pageTitle,'data'=>$data,'activePage'=>$activePage]);
    }


    public function companyDefaults(){
        $pageTitle = "Company Defaults";
        $data = userguidesArr();
        return view($this->viwePath."company-defaults",['route'=>$this->route,'pageTitle'=>$pageTitle,'data'=>$data]);
    }

    public function companyDefaultsSetting(Request $request,$id=null){
        $dId = decryptUrl($id);
        $userType = userguidesArr(decryptUrl($id));
        $pageTitle = "{$userType} Company Default";
        $route = "{$this->route}company-default-settings";
        $activePage = "company-default-{$this->activePage}";
        $logActivePage =  $activePage.Str::slug($userType);
        $data = $this->model::getData(['type'=>$activePage,'userType'=>$dId])->first();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $pageTitle;
                $inputs['user_type'] = $dId;
                $inputs['activePage'] = $activePage;
                $inputs['logActivePage'] = $logActivePage;
                $inputs['onDB'] = 'company_mysql';
                $res = $this->model::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status'=>true,'msg'=>$pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $bankData = BankAccount::getData()->whereStatus(1)->get()?->toArray();
        $bankData = !empty($bankData) ? array_column($bankData,'bank_name','id') : [] ;
        $data = !empty($data->json) ? json_decode($data->json,true) : [];
        return
        view($this->viwePath."company-default-settings",["bankData"=>$bankData,'route'=>$route,'pageTitle'=>$pageTitle,'data'=>$data,'activePage'=>$activePage,'logActivePage'=>$logActivePage,'id'=>$id]);
    }

	public function paymentMethodPermissions(){
        $pageTitle = "Payment Method Permissions";
        return view("company.payment-method-permissions.index",['route'=>$this->route,'pageTitle'=>$pageTitle,'activePage'=>'payment-method-permissions']);
    }
	public function paymentMethodPermissionsSetting(Request $request,$id=null){
        $dId = decryptUrl($id);
		$userType       = loginUserTypeArr($dId);
        $pageTitle = "{$userType} Payment Method Permissions";
        $route = "{$this->route}";
        $activePage = "payment-method-permissions";
        $logActivePage =  $activePage.Str::slug($userType);
        $data = $this->model::getData(['type'=>$activePage,'userType'=>$dId])->first();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $pageTitle;
                $inputs['user_type'] = $dId;
                $inputs['activePage'] = $activePage;
                $inputs['logActivePage'] = $logActivePage;
                $inputs['onDB'] = 'company_mysql';
                $res = $this->model::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status'=>true,'msg'=>$pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $data = !empty($data->json) ? json_decode($data->json,true) : [];
        return
        view("company.payment-method-permissions.show",['route'=>$route,'pageTitle'=>$pageTitle,'data'=>$data,'activePage'=>$activePage,'logActivePage'=>$logActivePage,'id'=>$id]);
    }
}
