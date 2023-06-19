<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Entity,EntityContact
};
use Str;
class InsuranceCompanyController extends Controller
{
    private $viwePath   = "admin.insurance-company.";
    public  $pageTitle  = "Insurance Company";
    public  $activePage = "insurance-company";
    public  $route      = "admin.insurance-company.";
    public function __construct(Entity $model){
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
                $inputs['activePage'] = $this->activePage;
                $inputs['type'] = 1;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
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
        $data  = $this->model->decrypt($id)->firstOrFail()?->toArray();
        $other_fields = !empty($data['other_fields']) ? $data['other_fields'] : null ;
        if(!empty($other_fields)){
            $other_fields = json_decode($other_fields,true);
            foreach($other_fields as $key => $otherField){
                $data["am_best[$key]"] = $otherField;
            }
        }

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
                $inputs['activePage'] = $this->activePage;
                $inputs['type'] = 1;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                $data = $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                 return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated
                 successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                 routeCheck($this->route."index")], 200);
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


        $sqlData         = $this->model::where('type',1);
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

    /**
     * Save a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactSave(Request $request)
    {
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = decryptUrl($request->post('id'));
                $inputs['entity_id'] = decryptUrl($request->post('entity_id'));

                $inputs['activePage'] = $this->activePage;
                $data = EntityContact::insertOrUpdate($inputs);

                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                if(!empty($inputs['id'])){
                    $msg = $this->pageTitle.' Contact has been updated successfully';
                }else{
                   $msg = $this->pageTitle.' Contact has been created successfully';
                }
                return response()->json(['status'=>true,'msg'=> $msg ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }
    /**
     * Edit a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactEdit(Request $request,$id)
    {
        $data = EntityContact::decrypt($id)->firstOrFail()->makeHidden(['id','user_id'])?->toArray();
        return view($this->viwePath."pages.contacts.edit",['route'=>$this->route,'data'=>$data,'editId'=>$id]);
    }


      /**
     * List a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactList(Request $request)
    {
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId        = !empty($request['entityId']) ? decryptUrl($request['entityId']) : '';

        $sqlData = new EntityContact;
        if(!empty($generalAgentId)){
            $sqlData = $sqlData->where('entity_id',$entityId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."entity-contact-edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)' x-on:click='open = `contactsEdit`;contactsEditUrl=`{$editUrl}`'
                            data-url='{$editUrl}'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }
}