<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
  FinanceAgreement,MetaTag
};
use App\Http\Requests\FinanceAgreementRequest;
class FinanceAgreementController extends Controller
{
    private $viwePath  = "company.finance-agreement.";
    public  $pageTitle = " Finance Agreement";
    public  $activePage = "finance-agreement";
    public $route = "company.finance-agreement.";
    public function __construct(FinanceAgreement $model){
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
    public function store(FinanceAgreementRequest $request)
    {
        $validatedData = $request->validated();
        try {
           if ($request->ajax()) {
                $inputs    = $request->post();
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
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
        $data['css'] = MetaTag::getData(['key'=>'css','type'=> $this->activePage])->first()?->value;
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
                $inputs['activePage'] = $this->activePage;
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

        $sqlData = $this->model::getData();
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date      = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get()->toArray();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $name   = ucfirst($row['name']);
                    $dataArr[] = array(
                        "description" =>$row['description'],
                        "created_at" =>changeDateFormat($row['created_at']),
                        "updated_at" =>changeDateFormat($row['updated_at']),
                        "name" => "<a href='{$editUrl}' data-turbolinks='false' >{$name}</a>",
                    );
                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    public function css(Request $request){
        $this->pageTitle = $this->pageTitle." ".__("labels.css");
        $activePage= $this->activePage."-meta-tag";
        if($request->ajax() && $request->isMethod('post')){
            try {
                $inputs = $request->post();
                $inputs['key'] = "css";
                $inputs['value'] = $request->post("css");
                $inputs['onDB'] = 'company_mysql';
                $inputs['status'] = 1;
                $inputs['title'] = $this->pageTitle;
                $inputs['activePage'] = $activePage;
                $inputs['type'] = $this->activePage;
                $data = MetaTag::insertOrUpdate($inputs);
                $id = encryptUrl($data->id);
                return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been update
                successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                routeCheck($this->route."index")], 200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
            }
        }
        $data = MetaTag::getData(['key'=>'css','type'=> $this->activePage])->first()?->makeHidden(['id']);
        if(!empty($data)){
            $data[$data->key] = $data->value;
        }

        return
        view($this->viwePath."css",['route'=>$this->route,'data'=>$data,'title'=>$this->pageTitle,'activePageName'=>$activePage]);
    }

}
