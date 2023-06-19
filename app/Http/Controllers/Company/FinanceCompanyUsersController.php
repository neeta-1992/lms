<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoverageType;
use App\Models\User;
class FinanceCompanyUsersController extends Controller
{
    private $viwePath   = "company.finance-company-users.";
    public  $pageTitle  = "Finance Company User";
    public  $activePage = "finance-company-users";
    public  $route      = "company.finance-company-users.";
    public function __construct(User $model){
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
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['userType'] = 'finance-company';
                $data = $this->model::saveAgent($inputs);
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
        $data = $this->model::getData()->select("*",'user_type as type')->decrypt($id)->firstOrFail();
        $profile = !empty($data['profile']) ? $data->profile?->makeHidden(['id','created_at','updated_at'])?->toArray() : [];
        $data = $data?->toArray() ?? [];
        $data = array_merge($data,$profile);

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
                $inputs['id'] = decryptData($id);
                $stateData = $this->model::saveAgent($inputs);
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


        $sqlData = $this->model::getData(['type'=>[2,3]]);
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
                        "mobile" => $row?->mobile,
                        "email" => $row?->email,
                        "entity_type" => 'Finance Company Users',
                        "role" => $row?->user_type == 2 ? 'Adminstrator' : 'User',
                        "status" => statusArr($row?->status ?? 0),
                    ];

                }
          }
        $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
        return json_encode($response);
    }
}