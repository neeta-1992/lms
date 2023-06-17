<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoverageType;
use App\Models\{
    ProspectContact,Prospect,ProspectOffice,Entity,User,AgentOffice
};
use Str;
class Prospectscontroller extends Controller
{
    private $viwePath   = "company.prospects.";
    public  $pageTitle  = "Prospects";
    public  $activePage = "prospects";
    public  $route      = "company.prospects.";
    public function __construct(Prospect $model){
       $this->model =  $model;
        ///$this->type = $this->model::INSURED;
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
        return view($this->viwePath."index",['route'=>$this->route,'activePage'=>$this->activePage]);
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
                $inputs['pageTitle'] = $this->pageTitle;
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
        $data  = $this->model->getData(['dId'=>$id])->firstOrFail()?->toArray();
        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id,'activePage'=>$this->activePage,'viwePath'=>$this->viwePath]);
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
                //  $inputs['type'] = $this->type;
                $inputs['lang'] = Str::replaceFirst('-', '_',$this->activePage);
                $data = $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                if(!empty($data) && $request->post('status') == 3){
                    $this->prospectsToAgency($data);
                }
                 return response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated
                 successfully','continue'=> routeCheck($this->route."edit",$id),'back'=>
                 routeCheck($this->route."index")], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }

    private function prospectsToAgency($data){
        $activePage ='agents';
        $contactData = $data?->contact_data?->makeHidden(['id','created_at','updated_at','prospect_id'])?->toArray() ?? null;
        $officeData = $data?->office_data?->makeHidden(['id','created_at','updated_at'])?->toArray() ?? null;
        $agency = !empty($data->agency) ? $data->agency : null;
        $data = $data?->makeHidden(['name','id','created_at','updated_at','agency'])?->toArray();
        $data['name'] = $agency;
        $data['type'] = Entity::AGENT;
        $data['onDB'] = 'company_mysql';
        $data['lang'] = $activePage;
        unset($data['contact_data']);
        unset($data['office_data']);

        $EntityData = Entity::insertOrUpdate($data);
       if(!empty($officeData)){
          // $userArr = [];
           foreach ($officeData as $key => $value) {
                $value['agency_id']     = $EntityData?->id;
                $value['onDB']          = 'company_mysql';
                $value['activePage']    = $activePage;
                $value['logId']         = $EntityData?->id;
                $value['type']          = User::AGENT;
                $value['status']        = 1;
                $agentOffice = AgentOffice::insertOrUpdate($value);
           }
       }

       if(!empty($contactData)){
          // $userArr = [];
           foreach ($contactData as $key => $value) {
            /* dd($value); */
                $value['entity_id']     = $EntityData?->id;
                $value['onDB']          = 'company_mysql';
                $value['activePage']    = $activePage;
                $value['logId']         = $EntityData?->id;
                $value['type']          = User::AGENT;
                $value['status']        = 1;
                $value['mobile'] = !empty($value['telephone']) ? $value['telephone'] : '';
                $value['email'] = !empty($value['email']) ? $value['email'] : '';
                $value['agencyUsername']= $EntityData?->username ?? '';
                $userInserrtData = User::saveAgent($value);
           }
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
        $orderBy = [
            'sales_organization'=>'entities.name',
            'created_at'=>'prospects.created_at',
            'updated_at'=>'prospects.updated_at',
            'status'=>'prospects.status',
            'state'=>'prospects.state',
            'name'=>'prospects.agency',
        ];
        $columnName = !empty($orderBy[$columnName]) ? $orderBy[$columnName] : '' ;


        $sqlData = $this->model::getData($request)->select('prospects.*','entities.name')
        ->join('entities','entities.id','prospects.sales_organization');
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

        $statusArr = prospectsStatuArr();
          if(!empty($data)){
                foreach($data as $row){

                    $editUrl = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $name = ucfirst($row['agency']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='{$editUrl}' data-turbolinks='false'>{$name}</a>",
                        "state" => $row->state,
                        "status" => isset($statusArr[$row->status]) ? $statusArr[$row->status] : '',
                        "sales_organization" => $row->sales_organization_data?->name ?? '',
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }

      /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactCreate(Request $request,$id)
    {
        $prospectId = decryptUrl($id);
        try {
           if ($request->ajax() && $request->isMethod('post')) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['prospect_id'] = $prospectId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $prospectId;
                $data = ProspectContact::insertOrUpdate($inputs);

                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been created successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        $office = ProspectOffice::getData(['prospectId' => $prospectId])->get()->pluck('name','id');
        return view($this->viwePath."contacts.create",['route'=>$this->route.'contact.','office'=>$office,'id'=>$id]);
    }


     /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactEdit(Request $request,$id)
    {
        $data = ProspectContact::getData(['dId'=>$id])->firstOrFail();
         $prospectId = $data?->prospect_id;
        try {
           if ($request->ajax() && $request->isMethod('post')) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['prospect_id'] = $prospectId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $prospectId;
                ProspectContact::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        $office = ProspectOffice::getData(['prospectId' => $prospectId])->get()->pluck('name','id');
        return view($this->viwePath."contacts.edit",['route'=>$this->route.'contact.','id'=>$id,'office'=>$office,'data'=>$data]);
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
        $entityId = !empty($request['entityId']) ? decryptUrl($request['entityId']) : '';

        $sqlData =  ProspectContact::getData([]);
        if(!empty($entityId)){
            $sqlData = $sqlData->where('prospect_id',$entityId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."contact.edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)'
                            x-on:click='open = `contactsForm`;contactsEditUrl=`{$editUrl}`'
                        data-url='{$editUrl}' data-turbolinks='false'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    /**
     * List a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityofficeList(Request $request,$agencId='null')
    {
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $entityId        = !empty($agencId) ? decryptUrl($agencId) : '';

        $sqlData = ProspectOffice::getData();
        if(!empty($entityId)){
            $sqlData = $sqlData->where('agency_id',$entityId);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."office.edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['name']);
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "name" => "<a href='javascript:void(0)' x-on:click='open = `officeForm`;officeEditUrl=`{$editUrl}`'
                         data-url='{$editUrl}' data-turbolinks='false'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityOfficeCreate(Request $request,$id)
    {
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = decryptUrl($id);
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agency_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;

                $data = ProspectOffice::insertOrUpdate($inputs);
                $id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Office has been created successfully',
                'type'=>'attr',
                'action' => "open = 'offices'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        return view($this->viwePath."offices.create",['route'=>$this->route.'office','id'=>$id]);
    }


     /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityOfficeEdit(Request $request,$id)
    {
        $data = ProspectOffice::getData(['dId'=>$id])->firstOrFail();
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = $data->agency_id;
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['agency_id'] = $data->agency_id;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                ProspectOffice::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Office has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'offices'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        return view($this->viwePath."offices.edit",['route'=>$this->route.'office','id'=>$id,'data'=>$data]);
    }


    public function checkProspectAgencyUsersvalue(){
        $prospectId = $request->id ?? 'null';
        $error =null;
        $user_contact = ProspectContact::getData([])->where('prospect_id',$prospectId)->first();
        if(!empty($data)){
            if(empty($user_contact['first_name']) || empty($user_contact['last_name']) || empty($user_contact['title'])
            || empty($user_contact['telephone']) || empty($user_contact['email'])
            ){
                $error = 'You should first fill contacts value for this agency before Agency approved - Won!';
            }
        }else{
            $error = 'You should first create contact for this agency before Agency approved - Won!';
        }

        return $error;
    }

}
