<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
class GLdefaultController extends Controller
{
    private $viwePath   = "company.default-gl-accounts.";
    public  $pageTitle  = "Default GL Accounts";
    public  $activePage = "setting";
    public  $route      = "company.default-gl-accounts.";
    public function __construct(Setting $model){
        $this->model =  $model;
     }

    public function defaultgl(){
		$activePage = "default-gl-accounts";
		$logActivePage =  $activePage;
		$data = $this->model::getData(['type'=>$activePage])->first();
		$data = !empty($data->json) ? json_decode($data->json,true) : [];
		return view($this->viwePath."index",['route'=>$this->route,'pageTitle'=>$this->pageTitle,'data'=>$data,'activePage'=>$activePage,'logActivePage'=>$logActivePage,]);
    }

    public function glsave(Request $request){
        $validatedData = $request->all();
        $activePage = "default-gl-accounts";
		$logActivePage =  $activePage;
		$data = $this->model::getData(['type'=>$activePage])->first();
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 0;
				$inputs['id'] = $data?->id;
                $inputs['pageTitle'] = $this->pageTitle;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $activePage;
				$inputs['logActivePage'] = $logActivePage;
                $data =  $this->model::insertOrUpdate($inputs);
				$msg = !empty($data->id) ? "updated" : "created";
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been '.$msg.'
                successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                routeCheck($this->route."index")], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }
}
