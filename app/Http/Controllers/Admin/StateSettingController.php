<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    StateSettings,StateSettingsTwo
};

class StateSettingController extends Controller
{
    private $viwePath  = "admin.state-setting.";
    public  $pageTitle = "State Settings";
    public  $activePage = "state-setting";
    public function __construct(StateSettings $model){
       $this->model =  $model;
       $this->route = 'admin.state-settings.';
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
       $stateId = $this->model::select('state')->get()?->toArray();
       $stateIdArr = !empty($stateId) && is_array($stateId) ? array_column($stateId,'state') : [] ;
       return view($this->viwePath."create",['route'=>$this->route,'stateId'=>$stateIdArr]);
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
                $userId = auth()->user()->id;
                $inputs['user_id'] = $userId;
                $inputs['company_id'] = $userId;
                $data = $this->model::insertOrUpdate($inputs);
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

        $data  = $this->model->with('stateData')->decrypt($id)->firstOrFail()?->toArray();
        $StateSettings2 = StateSettingsTwo::decrypt($id,'state_settings_id')->first()?->makeHidden(['id','created_at','updated_at'])?->toArray() ?? [];

        $data = array_merge($data,$StateSettings2);
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
                $inputs['id'] = decryptUrl($id);
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


        $sqlData         = $this->model->with('stateData');
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $stateDatas      = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get()->toArray();

          if(!empty($stateDatas)){
                foreach($stateDatas as $row){
                    $editUrl   = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $stateName = $row['state_data']['state'] ?? '' ;
                    $dataArr[] = array(
                        "created_at" =>changeDateFormat($row['created_at']),
                        "updated_at" =>changeDateFormat($row['updated_at']),
                        "state" => "<a href='{$editUrl}' data-turbolinks='false' >{$stateName}</a>",
                    );

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }
}