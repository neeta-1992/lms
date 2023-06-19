<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    StateProgramSetting,StateProgramSettingOverride,TerritorySetting,Logs
};
class StateProgramSettingsController extends Controller
{
    private $viwePath   = "company.program-settings.";
    public  $pageTitle  = "State Program Settings";
    public  $activePage = "program-settings";
    public  $route      = "company.program-settings.";
    public function __construct(StateProgramSetting $model){
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
    public function store(Request $request)
    {
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
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
        return
        view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id,'activePage'=>$this->activePage]);
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
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;

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


        $sqlData = $this->model::getData();
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

                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }

     public function overridesettingList(Request $request,$stateProgramId=null){
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';


        $sqlData = StateProgramSettingOverride::getData(['stateProgramId'=>$stateProgramId]);
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."statefrom",($row['id']));
                    $name = Overridesettings($row?->override_settings ?? '');
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "id" => ($row['id']),
                        "override_settings" => "<a href='javascript:void(0)' data-turbolinks='false'
                         x-on:click='ruleTable = `ruleForm`;ruleEditUrl=`{$editUrl}`'>{$name}</a>",

                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }




    public function addstaterules($id="null"){
        $data = StateProgramSettingOverride::getData(['id'=>$id])->first()?->toArray();

        $territorySetting = TerritorySetting::getData()->get()?->pluck('name','id')?->toArray();
        return view($this->viwePath."override-setting",['route'=>$this->route,'data'=>$data,'id'=>$id,'territorySetting'=>$territorySetting]);
    }

    public function overridedelete(){
        $dId = request()->post('ids');
        $msg = "";
        $state_program_id = '';
        /* dd($dId); */
        if(!empty($dId)){
            foreach ($dId as $key => $value) {
                $data = StateProgramSettingOverride::getData(['id'=>$value])->first();
                if(!empty($data)){
                    $name = Overridesettings($data?->override_settings ?? '');
                    $state_program_id = $data?->state_program_id;
                    $data->delete();
                    $msg .= "<li>{$name} override setting was deleted</li>";
                }
            }
            $msg = !empty($msg) ? "<ul>{$msg}</ul>" : '' ;
            if(!empty($state_program_id) && !empty($msg)){
                Logs::saveLogs(['type'=>$this->activePage,'onDB'=>'company_mysql','user_id'=>auth()->user()->id,'type_id'=>$state_program_id,'message'=>$msg]);
            }
          }

           return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been delete successfully'], 200);

    }
}