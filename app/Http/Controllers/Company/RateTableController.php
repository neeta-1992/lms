<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
RateTable
};
use App\Http\Requests\RateTableRequest;
class RateTableController extends Controller
{
    private $viwePath   = "company.rate-table.";
    public  $pageTitle  = "Rate Table";
    public  $activePage = "rate-table";
    public  $route      = "company.rate-table.";
      public function __construct(RateTable $model){
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
    public function store(RateTableRequest $request)
    {
       $validatedData = $request->validated();

        try {
           if ($request->ajax()) {
                $inputs    = $request->post();
                $inputs['onDB'] = 'company_mysql';
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
        $data = $this->model::getData()->with(['rateTableFee'])->decrypt($id)->firstOrFail()?->toArray();

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
                $inputs['onDB'] = 'company_mysql';
                $inputs['id'] = decryptUrl($id);
                $stateData =  $this->model::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated
                successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                routeCheck($this->route."index")], 200);
                //return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated successfully','backurl'=> route($this->route."index")], 200);
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignToAgents(Request $request, $id)
    {
        $data = $this->model::getData()->with(['rateTableFee'])->decrypt($id)->firstOrFail()?->toArray();
        return view($this->viwePath."assign-to-agent",['route'=>$this->route,'data'=>$data,'id'=>$id]);
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
         $sqlData        = $this->model::getData();
        $totalCount      = $sqlData->count();
        $dataArr         = [];
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($data)){
                foreach($data as $row){
                    $editUrl   = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $dataArr[] = array(

                        "name"       => "<a href='{$editUrl}' data-turbolinks='false' >{$row->name}</a>",
                        "type"       => rateTableTypeDropDown($row->type),
                        "account_type" => rateTableAccountType($row->account_type),
                        "state"       => $row->state,
                        "created_at" => changeDateFormat($row->created_at),
                        "updated_at" => changeDateFormat($row->updated_at),

                    );

                }
          }
          $response = array("total" =>$totalCount,"totalNotFiltered" =>$totalCount,"rows" => $dataArr);
          return json_encode($response);
    }
}
