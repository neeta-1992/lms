<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
class NoticesController extends Controller
{
    private $viwePath  = "company.notices.";
    public $pageTitle  = "Notices";
    public $activePage = "notices";
    public $route      = "company.notices.";

    public function __construct(Notice $Model)
    {
        $this->model = $Model;
    }

    /**
     * Display a listing of the Notices Agents Data And Save Data .
     */
    public function agentsNotices(Request $request)
    {
        $type = "agents-notice";
        $this->pageTitle = "Agent " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."agents.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
     }

     /**
     * Display a listing of the Notices General Agents Data And Save Data .
     */
    public function generalAgentNotices(Request $request)
    {
        $type = "general-agents-notice";
        $this->pageTitle = "General Agent " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."general-agents.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }

     /**
     * Display a listing of the Notices insurance companies Data And Save Data .
     */
    public function insuranceCompaniesNotices(Request $request)
    {
        $type = "insurance-companies-notice";
        $this->pageTitle = "Insurance Companies " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."insurance-companies.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }


     /**
     * Display a listing of the Notices insureds Data And Save Data .
     */
    public function insuredsNotices(Request $request)
    {
        $type = "insureds-notice";
        $this->pageTitle = "Insureds " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."insureds.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }

     /**
     * Display a listing of the Notices sales organizations Data And Save Data .
     */
    public function salesOrganizationsNotices(Request $request)
    {
        $type = "sales-organizations";
        $this->pageTitle = "Sales Organizations " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."sales-organizations.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }


        /**
     * Display a listing of the Notices Brokers Data And Save Data .
     */
    public function brokersNotices(Request $request)
    {
        $type = "brokers";
        $this->pageTitle = "Broker " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."brokers.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }


        /**
     * Display a listing of the Notices Lienholders Data And Save Data .
     */
    public function lienholdersNotices(Request $request)
    {
        $type = "lienholders";
        $this->pageTitle = "Lienholders " .$this->pageTitle;
        $getData = $this->model::getData(['type'=>$type])->first();
        try {
           if ($request->ajax() && $request->isMethod("post")) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $getData?->id ?? null;
                $inputs['onDB']   = 'company_mysql';
                $inputs['activePage'] = $type;
                $inputs['title'] = $this->pageTitle;
                $data = $this->model::insertOrUpdate($inputs);
                $msg = !empty($getData->id) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $json = !empty($getData['json']) ? json_decode($getData['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        return view($this->viwePath."lienholders.index", ['route' => $this->route,'data'=>$json,'type'=>$type,'pageTitle'=>$this->pageTitle]);
    }


}
