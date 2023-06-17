<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    AccountStatusSetting,State
};
class AccountStatusSettingsController extends Controller
{
    private $viwePath   = "company.account-status-settings.";
    public  $pageTitle  = "Account Status Settings";
    public  $activePage = "account-status-settings";
    public  $route      = "company.account-status-settings.";
    public function __construct(AccountStatusSetting $model){
       $this->model =  $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = State::getData()->get();
        return view($this->viwePath."index",['route'=>$this->route,'data'=>$data]);
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
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $stateId = decryptUrl($request->post('state_id'));
                $mainData = $this->model::getData(['stateId'=>$stateId])->first();
                $inputs['state_id'] = $stateId;
                $inputs['activePage'] = $this->activePage;
                $inputs['id'] = $mainData?->id ?? null;
                $data =  $this->model::insertOrUpdate($inputs);
                $msgText = empty($mainData?->id) ? "created" : 'updated' ;
                  return response()->json(['status'=>true,'msg'=>$this->pageTitle." has been {$msgText} successfully",'backurl'=> route($this->route."index")], 200);
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
        $data = State::getData(['id'=>$id])->firstOrFail();
        $pageTitle = "{$this->pageTitle} ({$data->state})";

        return view($this->viwePath."view-setting",['route'=>$this->route,'data'=>$data,'pageTitle'=>$pageTitle,'id'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data  = $this->model->where('id',decryptData($id))->firstOrFail()?->toArray();

        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id]);
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
                $inputs['id'] = decryptData($id);
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

    public function accountStatusSettingsTab($stateId=null,$tab=null){
        $dStateId = decryptUrl($stateId);
        $stateData = State::getData(['id'=>$stateId])->firstOrFail();
        $pageTitle = "{$this->pageTitle} ({$stateData->state})";
        $data = $this->model::getData(['stateId'=>$dStateId])->first();

        return view($this->viwePath."tabs",['route'=>$this->route,'pageTitle'=>$pageTitle,'tab'=>$tab,'id'=>$stateId,'data'=>$data]);
    }
}
