<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    GeneralAgent
};
class GeneralAgentController extends Controller
{
    private $viwePath   = "admin.general-agent.";
    public  $pageTitle  = "General Agent";
    public  $activePage = "general-agent";
    public  $route      = "admin.general-agent.";
    public function __construct(GeneralAgent $model){
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
       
      
        return view($this->viwePath."edit",['route'=>$this->route]);
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
        
        $totalCount      = 0;
        $dataArr         = [];
       /*  $sqlData         = $this->model;
        $totalCount      = $sqlData->count();
        $dataArr         = [];
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();
       */ /* dd(  $data ); */
        /*   if(!empty($data)){
                foreach($data as $row){
                    $editUrl   = routeCheck($this->route."edit",encryptData($row['id']));
                    $dataArr[] = array( 
                        "name"       => "<a href='{$editUrl}'>{$row->comp_name}</a>",
                        "email"      => $row->comp_contact_email,
                        "telephone"  => $row->primary_telephone,
                      //  "state"      => "<a href='{$editUrl}'>{$stateName}</a>",
                    );  

                }
          } */
          $response = array("total" =>$totalCount,"totalNotFiltered" =>$totalCount,"rows" => $dataArr);
          return json_encode($response);
    }
}
