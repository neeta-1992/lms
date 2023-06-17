<?php

namespace App\Http\Controllers\Company\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    QuoteNote,Quote,Task
};
class QuoteNotesController extends Controller
{

    private $viwePath   = "company.quotes.notes.";
    public  $pageTitle  = "Quotes";
    public  $activePage = "quotes";
    public  $route      = "company.quotes.quote-notes.";
    public function __construct(QuoteNote $model){
       $this->model =  $model;

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($qId=null,$vId=null)
    {
        $quoteData = Quote::getData(['id' => $qId])->first();

        return view($this->viwePath."index",['route'=>$this->route,'qId'=>$qId,'vId'=>$vId,'activePage'=>$this->activePage,'quoteData'=>$quoteData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($qId=null,$vId=null)
    {
       return view($this->viwePath."create",['route'=>$this->route,'qId'=>$qId,'vId'=>$vId,'activePage'=>$this->activePage]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$qId=null,$vId=null)
    {
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['onDB']     = 'company_mysql';
                $inputs['qId']      = $qId;
                $inputs['vId']      = $vId;
                $inputs['files']    =  $request->post('attachments');
                $inputs['onDB']     = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $data = $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? ($data->id) : null;
                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' Notes has been created
                successfully', 'type' => 'attr','action' => "open = 'notesList'"], 200);
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
    public function show($id,$qId=null,$vId=null)
    {
       /*  dd($id); */
        $data = QuoteNote::getData(['id'=>$id])->firstOrFail();
        return view($this->viwePath."details",['route'=>$this->route,'qId'=>$qId,'vId'=>$vId,'id'=>$id,'activePage'=>$this->activePage,'data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$qId=null,$vId=null)
    {
        /* dd($id); */
        $data  = $this->model::getData(['id'=>$id,'qId'=>$qId])->firstOrFail();
        $userData = Task::userData();
        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id,'qId'=>$qId,'vId'=>$vId,'userData'=>$userData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$qId=null,$vId=null)
    {
        try {
            if ($request->ajax()) {
                 $inputs = $request->post();
                 $dbData  = $this->model::getData(['id'=>$id,'qId'=>$qId])->first();
                 $is_task = $request->post('is_task');
                 $task = $request->post('task');
                 $inputs['onDB']     = 'company_mysql';
                 $inputs['qId']      = $qId;
                 $inputs['vId']      = $vId;
                 $inputs['id']      =  !empty($dbData->parent_id) ? $dbData->parent_id : $id;
                 $inputs['files']    =  $request->post('attachments');
                 $inputs['onDB']     = 'company_mysql';
                 $inputs['activePage'] = $this->activePage;
                 $data = $this->model::insertOrUpdate($inputs);
                 if(!empty($is_task)){
                    $taskData =  Task::insertOrUpdate($task);
                 }
                 $id = !empty($data->id) ? ($data->id) : null;
                 return response()->json(['status' => true, 'msg' => $this->pageTitle . ' Notes has been updated
                 successfully', 'type' => 'attr','action' => "detailsNotes('$id')"], 200);
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
    public function viewList(Request $request,$qId=null,$vId=null)
    {

        $sort = !empty($request['sort']) ? $request['sort'] : '';
     /*    dd( $sort); */
        $columnSortOrder = !empty($request['order']) ? $request['order'] : "desc";
        $offset = !empty($request['offset']) ? $request['offset'] : 0;
        $limit = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue = !empty($request['search']) ? $request['search'] : '';
        $parentId = !empty($request['parentId']) ? $request['parentId'] : '';
        $qId = !empty($request['qId']) ? $request['qId'] : '';
        $statusVal = !empty($request['statusVal']) ? explode(',', $request['statusVal']) : '';

        $columnName = [
            'created_at' => 'quote_notes.created_at',
            'updated_at' => 'quote_notes.updated_at',
            'subject' => 'quote_notes.subject',
            'description' => 'quote_notes.description',

        ];

        $columnName = !empty($columnName[$sort]) ? $columnName[$sort] : 'quote_notes.created_at';
        $sqlData = $this->model::getData(['qId'=>$qId]);
        if (!empty($parentId)) {
             $sqlData = $sqlData->where('quote_notes.id', $parentId)
                ->orWhere('quote_notes.parent_id', $parentId);
        } else {
            $sqlData = $sqlData->where('show_status', '=', 1);
        }

        $totalstateDatas = $sqlData->count();
        $dataArr = [];
        $data = $sqlData->skip($offset)->take($limit)->orderByEn($columnName, $columnSortOrder)->get();

        if (!empty($data)) {
            foreach ($data as $row) {
                $id = !empty($row['parent_id']) ? $row['parent_id'] : $row['id'];
                $editUrl = routeCheck($this->route . "edit", ['id'=>$id,'vId'=>$vId,'qId'=>$qId]);
                $subject = ucfirst($row['subject']);
                $show_status = !empty($row->show_status) ? $row->show_status : '' ;
                if(empty($show_status)){
                    $subject = "<del>$subject</del>";
                    $subject = "<a href='javasacript:void(0)' onclick=textAlertModel(false,'{$row->description}')>{$subject}</a>";
                }else{
                    $subject = "<a href='javasacript:void(0)' x-on:click=detailsNotes('{$row['id']}')>{$subject}</a>";
                }


                $dataArr[] = [
                    "created_at"    => changeDateFormat($row?->created_at),
                    "updated_at"    => changeDateFormat($row?->updated_at),
                    "username"      => $row?->created_by?->name ?? null,
                    "description"      => $row?->description,
                    "subject" => $subject,
                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }

}
