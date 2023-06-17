<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Entity,EntityContact,Notice
};
use Str;
use App\Enums\EntityType;
class BrokersController extends Controller
{
    private $viwePath = "company.entity.brokers.";
    public  $pageTitle  = "Broker";
    public  $activePage = "brokers";
    public  $route      = "company.brokers.";
    public function __construct(Entity $model){
       $this->model =  $model;
       $this->type = (int)EntityType::BROKER?->value;
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
                $inputs['pageTitle'] = $this->pageTitle;
                $inputs['type'] = $this->type;
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
        $data  = $this->model->getData(['dId'=>$id,'type'=>$this->type])->firstOrFail()?->toArray();
        return
        view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id,'activePage'=>$this->activePage,'viwePath'=>$this->viwePath]);
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
                $inputs['type'] = $this->type;
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


        $sqlData = $this->model::getData(['type'=> $this->type]);
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
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactCreate(Request $request,$id)
    {
        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = decryptUrl($id);
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $agencyId;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                $data = EntityContact::insertOrUpdate($inputs);
                //$id = !empty($data->id) ? encryptUrl($data->id) : null;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been created successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        return view($this->viwePath."pages.contacts.create",['route'=>$this->route.'contact.','id'=>$id]);
    }


     /**
     * entity Office Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityContactEdit(Request $request,$id)
    {
        $data = EntityContact::getData(['dId'=>$id])->firstOrFail();

        try {
           if ($request->ajax() && $request->isMethod('post')) {
                $agencyId = $data->agency_id;
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $data->entity_id;
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $agencyId;
                EntityContact::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=> $this->pageTitle.' Contact has been updated successfully',
                'type'=>'attr',
                'action' => "open = 'contacts'"
             ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
        return view($this->viwePath."pages.contacts.edit",['route'=>$this->route.'contact.','id'=>$id,'data'=>$data]);
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

        $sqlData =  EntityContact::getData([]);
        if(!empty($entityId)){
            $sqlData = $sqlData->where('entity_id',$entityId);
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
                        data-url='{$editUrl}'>{$name}</a>",
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }

    /**
     * Notice Settings Page show
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function entityNoticeSettings(Request $request,$id)
    {
        $validatedData  = $request->all();
        $entityId       = decryptUrl($id) ?? 'null';
        $data           = Notice::getData(['type'=>'broker','entityId'=>$entityId])->first()?->toArray();
        $noticeId       = !empty($data['id']) ? $data['id'] : '' ;
        if(empty($noticeId)){
            $data = Notice::getData(['type'=>'broker'])->first()?->toArray();
        }
        try {
           if ($request->ajax() && $request->isMethod("post")) {

                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $noticeId;
                $inputs['onDB'] = 'company_mysql';
                $inputs['entity_id'] = $entityId;
                $inputs['logsTypeId'] = $entityId;
                $inputs['logsTypeId'] = $entityId;
                $inputs['activePage'] = $this->activePage;
                $inputs['noticeType'] = "broker";
                $inputs['lang'] = Str::replace('-', '_',$this->activePage);
                $data = Notice::insertOrUpdate($inputs);
                $msg = !empty($noticeId) ? "updated" : "created" ;
                return response()->json(['status'=>true,'msg'=> $this->pageTitle." Notice Settings has been {$msg} successfully",
                'type'=>'attr',
                'action' => "open = 'notices'"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }

        $json = !empty($data['json']) ? json_decode($data['json'],true) : [] ;
        $json['option'] = !empty($json['description']) ? json_decode($json['description'],true) : '' ;
        $json['default_email_notices'] = !empty($data['default_email_notices']) ? $data['default_email_notices'] : '' ;
        $json['default_fax_notices'] = !empty($data['default_fax_notices']) ? $data['default_fax_notices'] : '' ;
        $json['default_mail_notices'] = !empty($data['default_mail_notices']) ? $data['default_mail_notices'] : '' ;
        return view($this->viwePath.".pages.notice.index",['route'=>$this->route,'data'=>$json,'id'=>$id]);
    }
}
