<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HmepageMssage;
class HomePageMessageController extends Controller
{
     private $viwePath  = "company.homepage-message.";
    public  $pageTitle  = "Homepage Message";
    public  $activePage = "homepage-message";
    public  $route      = "company.homepage-message.";
    public function __construct(HmepageMssage $model){
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
                $from_to_date = $request->post('from_to_date');
                list($from_date,$to_date) = explode(" - ",$from_to_date);
                $inputs['from_date'] = $from_date;
                $inputs['to_date'] = $to_date;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $data =  $this->model::insertOrUpdate($inputs);
                $id = encryptUrl($data->id);
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
        $data = $this->model::getData()->decrypt($id)->firstOrFail()?->makeHidden(['id'])?->toArray();
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
                $from_to_date = $request->post('from_to_date');
                list($from_date,$to_date) = explode(" - ",$from_to_date);
                $inputs['from_date'] = $from_date;
                $inputs['to_date'] = $to_date;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['id'] = decryptUrl($id);
                $data = $this->model::insertOrUpdate($inputs);
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
                    $userType = userType($row['user_type']);
                    $dataArr[] = array(
                        "created_at" =>changeDateFormat($row['created_at']),
                        "updated_at" =>changeDateFormat($row['updated_at']),
                        "status" => !empty($row['status']) ? 'Enable' : 'Disable',

                        "user_type" => "<a href='{$editUrl}' data-turbolinks='false' >{$userType}</a>",
                    );

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }
}
