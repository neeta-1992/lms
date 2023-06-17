<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    DownPayment,DownPaymentRule,Logs
};
use App\Helpers\QuoteHelper;
class DownPaymentRuleController extends Controller
{
    private $viwePath   = "company.down-payment-rules.";
    public  $pageTitle  = "Down Payment Rule";
    public  $activePage = "down-payment-rules";
    public  $route      = "company.down-payment-rules.";
    public function __construct(DownPayment $model){
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
        try {
            if ($request->ajax()) {
                $inputs = $request->post();
                $agency = !empty($inputs['agency']) ? $inputs['agency'] : '';
                 $inputs['agency'] = !empty($agency) && is_array($agency) ?
                 implode(",",$agency) : $agency;
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
        $data = $this->model::getData(['dId'=>$id])->firstOrFail()?->toArray();

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
                 $agency = !empty($inputs['agency']) ? $inputs['agency'] : '';
                 $inputs['agency'] = !empty($agency) && is_array($agency) ?
                 implode(",",$agency) : $agency;
                $inputs['id'] = decryptUrl($id);
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
              /*   dd($inputs); */
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
                    $name = ucfirst($row['name']);
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

       /*
      @Ajax Get Data List
    */
    public function downPaymentRuleList(Request $request,$downPaymentId=null){

        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';


        $sqlData = DownPaymentRule::getData(['downPaymentId'=>$downPaymentId]);
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."form",encryptUrl($row['id']));
                    $name = ucfirst($row['rule_name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "id" => encryptData($row['id']),
                        "rule_name" => "<a href='javascript:void(0)' data-turbolinks='false'
                        x-on:click='ruleTable = `ruleForm`;ruleEditUrl=`{$editUrl}`'>{$name}</a>",
                        "rule_description" => $row?->rule_description,
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downPaymentRuleForm($id="null")
    {

        $data = DownPaymentRule::getData(['dId'=>$id])->first()?->toArray();
        return view($this->viwePath."rule-form",['route'=>$this->route,'data'=>$data,'id'=>$id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downPaymentRuleDelete()
    {

        $dId = request()->post('ids');
        $msg = $and ="";
        if(!empty($dId)){
            foreach ($dId as $key => $value) {
                $id = decryptData($value);
                $data = DownPaymentRule::getData(['id'=>$id])->first();
                $name = $data?->rule_name ?? '';
                $typeId = $data->down_payment_id ?? null;
                $msg .= "{$and} {$name} Rule was deleted";
                $and = "and";
                $data->delete();
            }
            Logs::saveLogs(['type' => $this->activePage, 'type_id' => $typeId,'message' => $msg]);
            return ['status'=>true];
        }

        return view($this->viwePath."rule-form",['route'=>$this->route,'data'=>$data,'id'=>$id]);
    }


}
