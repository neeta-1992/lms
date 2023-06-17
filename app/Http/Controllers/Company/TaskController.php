<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

use App\Models\Logs;

use App\Models\Task;
use App\Models\User;use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $viwePath = "company.task.";
    public $pageTitle = "Task";
    public $activePage = "task";
    public $route = "company.task.";
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->viewList(request()->all());
        }
        return view($this->viwePath . "index", ['route' => $this->route, 'activePage' => $this->activePage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $userData = $this->userData();
        $qId   = $request->qId;
        $vId   = $request->vId;
        return view($this->viwePath . "create", ['route' => $this->route, 'userData' => $userData,'qId'=>$qId,'vId'=>$vId]);
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
                $qId = $request->qId;
              /*   dd($qId); */
                ///  $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = !empty($qId) ? 'quotes' : $this->activePage;
                $data = $this->model::insertOrUpdate($inputs);
                $id = !empty($data->id) ? ($data->id) : null;
                if(!empty($qId)){
                    return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created successfully','type' =>'attr','action'=>"detailsTask('{$id}')"], 200);
                }else{
                    return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created
                    successfully', 'continue' => routeCheck($this->route . "edit", $id), 'back' =>
                        routeCheck($this->route . "index")], 200);
                }

            }
        } catch (\Throwable$th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
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
    public function edit(Request $request, $id)
    {
        $data = $this->model::getData()->whereId($id)->firstOrFail();
        if ($request->ajax()) {
            return $data;
        }

        $userData = $this->userData();
        return view($this->viwePath . "edit", ['route' => $this->route, 'pageTitle' => $this->pageTitle, 'userData' => $userData, 'data' => $data, 'activePage' => $this->activePage, 'id' => $id]);
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
                $data = $this->model::getData()->whereId($id)->firstOrFail();
                $inputs = $request->post();
                $qId = $request->qId;
                $vId = $request->vId;
                $inputs['id'] = !empty($data['parent_id']) ? $data['parent_id'] : $id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['qId'] = $qId;
                $inputs['vId'] = $vId;
                $stateData = $this->model::insertOrUpdate($inputs);
                if(!empty($qId)){
                    return response()->json(['status' => true, 'msg' => $this->pageTitle . 'Appended a task successfully','type' =>'attr','action'=>"detailsTask('{$id}')"], 200);
                }else{
                return response()->json(['status' => true, 'msg' =>'Appended a task successfully', 'url' =>
                    routeCheck($this->route . "edit", $id)], 200);
                }
            }
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()]);

        }
    }

    public function cloesTask(Request $request)
    {
        try {

            if ($request->ajax()) {
                $inputs = $request->post();
                $qId = $request->qId;

                $logId = auth()->user()->id ?? '';
                $id = $inputs['id'];
                $inputs['activePage'] = !empty($qId) ? 'quotes' : $this->activePage;
                $this->model::getData()->where('id', $id)->update(['current_status' => 1]);
                $this->model::getData()->updateOrCreate(['parent_id' => $id, 'show_task' => 1], ['status' => 1, 'current_status' => 1, 'remark' =>     $request->post('notes'),'user_id'=>$logId]);
                $msg = "Status was updated in Close";
                Logs::saveLogs(['type' => $this->activePage, 'user_id' => $logId, 'type_id' => $id, 'message' => $msg]);
               if(!empty($qId)){
                return response()->json(['status' => true, 'msg' => 'Task has been closed', 'type' =>'attr','action'=>"detailsTask('{$id}')"], 200);
               }else{
                return response()->json(['status' => true, 'msg' => 'Task has been closed', 'url' => routeCheck($this->route . "edit", $id)], 200);
               }

            }
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()]);

        }
    }

    public function reopenTask(Request $request)
    {
        try {

            if ($request->ajax()) {
                $inputs = $request->post();
                $qId = $request->qId;
                $logId = auth()->user()->id ?? '';
                $id = $request->post('id');
                $data = $this->model::getData()->whereId($id)->firstOrFail()?->makeHidden(['current_status', 'created_at', 'updated_at', 'images'])?->toArray();
                $data['id'] = !empty($data['parent_id']) ? $data['parent_id'] : $id;
                $data['status'] = 4;
                $data['description'] = $request->post('description');
                $data['activePage'] = !empty($qId) ? 'quotes' : $this->activePage;

                $this->model::insertOrUpdate($data);
                if(!empty($qId )){
                    return response()->json(['status' => true, 'msg' => 'Task has been closed', 'type' =>'attr','action'=>"detailsTask('{$id}')"], 200);
                   }else{
                    return response()->json(['status' => true, 'msg' => 'Task has been closed', 'url' => routeCheck($this->route . "edit", $id)], 200);
                   }
            }
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()]);

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
    @AjaxGet Data List
     */
    private function viewList(array $request = null)
    {
        $userType = auth()->user()?->user_type ?? '';
        $sort = !empty($request['sort']) ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order']) ? $request['order'] : "desc";
        $offset = !empty($request['offset']) ? $request['offset'] : 0;
        $limit = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue = !empty($request['search']) ? $request['search'] : '';
        $parentId = !empty($request['parentId']) ? $request['parentId'] : '';
        $qId = !empty($request['qId']) ? $request['qId'] : '';
        $statusVal = !empty($request['statusVal']) ? explode(',', $request['statusVal']) : '';

        $columnName = [
            'created_at' => 'tasks.created_at',
            'updated_at' => 'tasks.updated_at',
            'username' => 'lu.first_name',
            'subject' => 'tasks.subject',
            'priority' => 'tasks.priority',
            'status' => 'tasks.status',
            'assign_task' => 'assu.first_name',
        ];

        $columnName = !empty($columnName[$sort]) ? $columnName[$sort] : 'tasks.created_at';
        $sqlData = $this->model::getData(['qId'=>$qId])->select([
            'tasks.*',
            'lu.first_name as lf',
            'lu.middle_name as lm',
            'lu.last_name as ll',
            'assu.first_name as af',
            'assu.middle_name as am',
            'assu.last_name as al',
        ])
            ->join('users as lu', 'lu.id', 'tasks.user_id')
            ->leftjoin('users as assu', 'assu.id', 'tasks.assign_task');
        if (!empty($parentId)) {
            $sqlData = $sqlData->where('tasks.id', $parentId)->orWhere('tasks.parent_id', $parentId);
        } else {
            $sqlData = $sqlData->where('show_task', '=', 1)
            ->orwhereRaw('FIND_IN_SET(?, tasks.user_type)', [$userType]);
        }
        if (!empty($statusVal)) {
            $sqlData = $sqlData->whereIn('tasks.status', $statusVal);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr = [];
        $data = $sqlData->skip($offset)->take($limit)->orderByEn($columnName, $columnSortOrder)->get();

        if (!empty($data)) {
            foreach ($data as $row) {
                $id = !empty($row['parent_id']) ? $row['parent_id'] : $row['id'];
                $editUrl = routeCheck($this->route . "edit", ($id));
                $subject = ucfirst($row['subject']);
                if (empty($parentId)) {
                    if(!empty($qId)){
                        $subject = "<a href='javasacript:void(0)' x-on:click=detailsTask('{$row['id']}')>{$subject}</a>";
                    }else{
                        $subject = "<a href='{$editUrl}' data-turbolinks='false'>{$subject}</a>";
                    }

                } else {
                    $subject = "<a href='javasacript:void(0)' class='taskDataGet' data-id='{$row['id']}'>{$subject}</a>";
                }
                $dataArr[] = [
                    "created_at" => changeDateFormat($row?->created_at),
                    "updated_at" => changeDateFormat($row?->updated_at),
                    "username" => decryptData($row?->lf)." ".decryptData($row?->lm)." ".decryptData($row?->ll),
                    "subject" => "<a href='{$editUrl}' data-turbolinks='false'>{$subject}</a>",
                    "shedule" => changeDateFormat($row?->shedule, true),
                    "priority" => $row?->priority ?? '',
                    "status" => !empty($row?->status) ? taskStatus($row?->status ?? 'null', true) : '',
                    "assign_task" => decryptData($row?->af) . " " . decryptData($row?->am) . " " . decryptData($row?->al),
                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }

    private function userData()
    {
        return $this->model::userData();
    }
}
