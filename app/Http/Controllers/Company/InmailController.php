<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

use App\Models\Message;
use App\Models\MessageDraft;
use App\Models\MessageFile;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class InmailController extends Controller
{
    private $viwePath = "company.in-mail.";
    public $pageTitle = "InMail";
    public $activePage = "in-mail";
    public $route = "company.in-mail.";
    public function __construct(Message $model)
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
        return view($this->viwePath . "index", ['route' => $this->route, 'pageTitle' => $this->pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $validatedData = $request->validated(); */
        $draft = $request->post('draft');
        if (!empty($draft)) {
            return $this->saveInDrafts($request);
        } else {
            return $this->sendMail($request);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function sendMail($request)
    {
        try {
            if ($request->ajax()) {
                $inputs = $request->post();

                /* Message Save */
                $fromId = $request->user()?->id;
                $toIdArr = $request->post('to');
                $draftId = $request->post('draftId');
                $cc = $request->post('cc');
                $quote_subject = $request->post('quote_subject');
                $attachments = $request->post("attachments");
                $qId  = $request->qid;
                $vId  = $request->vid;
                $version  = $request->version;
                $inserArr = [];
                if (!empty($toIdArr)) {
                    $toIdArr = explode(",", $toIdArr);
                    /*  dd($toIdArr); */
                    foreach ($toIdArr as $key => $value) {
                        $inserArr = [
                            'from_id' => $fromId,
                            'to_id' => $value,
                            'subject' => $inputs['subject'],
                            'quote_subject' => $inputs['quote_subject'],
                            'qid' => $qId,
                            'vid' => $vId,
                            'version' => $version,
                            'cc' => $cc,
                            'message' => $inputs['message'],
                            'activePage' => $this->activePage,
                        ];
                        $data = $this->model::insertOrUpdate($inserArr);

                        if (!empty($attachments) && !empty($data?->id)) {

                            $attachmentsArr = explode(",", $attachments);

                            foreach ($attachmentsArr as $key => $value) {
                                $valueArr = explode("-", $value);
                                $originalName = !empty($valueArr[1]) ? $valueArr[1] : null;
                                $imageArr = [
                                    'message' => $data?->id ?? null,
                                    'message_type' => 1,
                                    'file_name' => $value,
                                    'original_name' => $originalName,
                                    'file_type' => \File::extension($value),
                                ];
                                MessageFile::insertOrUpdate($imageArr);
                            }
                        }
                    }
                }

                MessageDraft::getData(['id' => $draftId])->delete();
                return response()->json(['status' => true, 'msg' => 'In-mail send Successfully', 'type' => 'attr','action'=>"tab='sentMail'"], 200);
            }
        } catch (\Throwable$th) {
            /*  dd($th); */
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function saveInDrafts($request)
    {
        try {
            if ($request->ajax()) {
                $imageArr = [];
                $inputs = $request->post();
                $attachments = $request->post("attachments");
                if (!empty($attachments)) {
                    $attachments = explode(",", $attachments);
                    foreach ($attachments as $key => $value) {
                        $valueArr = explode("-", $value);
                        $originalName = !empty($valueArr[1]) ? $valueArr[1] : null;
                        $imageArr[] = [
                            'file_name' => $value,
                            'original_name' => $originalName,
                            'file_type' => \File::extension($value),
                        ];
                    }
                }

                $fromId = $request->user()?->id;
                $toIdArr = $request->post('to');
                $cc = $request->post('cc');
                $quote_subject = $request->post('quote_subject');
                $qId  = $request->qid;
                $vId  = $request->vid;
                $version  = $request->version;

                $inserArr = [];
                $inserArr = [
                    //'user_id'    => $fromId,
                    'from_id' => $fromId,
                    'to_id' => $toIdArr,
                    'subject' => $inputs['subject'],
                    'quote_subject' => $inputs['quote_subject'],
                    'cc' => $cc,
                    'message' => $inputs['message'],
                    'qid' => $qId,
                    'vid' => $vId,
                    'version' => $version,
                    'files' => !empty($imageArr) ? json_encode($imageArr) : null,
                    'activePage' => $this->activePage,
                ];
                if (isset($inputs['draftId']) && !empty($inputs['draftId'])) {
                    $inserArr['id'] = $inputs['draftId'];
                }

                $data = MessageDraft::insertOrUpdate($inserArr);

                return response()->json(['status' => true, 'msg' => 'In-mail save Successfully', 'id' => $data->id, 'url' => routeCheck($this->route . 'index')], 200);
            }
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function resedMail(Request $request, $id)
    {
        try {
            $data = $this->model::getData(['id' => $id])->firstOrFail();
            if ($request->ajax()) {
                $inserArr = [];
                $inserArr = [
                    'from_id' => $data['from_id'],
                    'to_id' => $data['to_id'],
                    'subject' => $data['subject'],
                    'quote_subject' => $data['quote_subject'],
                    'cc' => $data['cc'],
                    'message' => $data['message'],
                    'activePage' => $this->activePage,
                ];
                $data = $this->model::insertOrUpdate($inserArr);
                return response()->json(['status' => true, 'msg' => 'Resend mail send Successfully', 'id' => $data->id, 'url' => routeCheck($this->route . 'index')], 200);
            }
        } catch (\Throwable$th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function mailReplySave(Request $request, $id)
    {
        try {
            $data = $this->model::getData(['id' => $id])->firstOrFail();
            $message = $request->repalymessage;
            $attachments = $request->post("attachments");
            $forwardto = $request->forwardto;
            $forwardcc = $request->forwardcc;
            $type = empty($forwardto) ? 1 : 2;
            if (!empty($forwardto)) {
                $cc = !empty($forwardcc) ? $forwardcc : '';
            } else {
                $cc = $data['cc'];
            }

            $fromId = $request->user()?->id;
            $to = !empty($forwardto) ? $forwardto : $data['from_id'];
            $from = !empty($forwardto) ? auth()->user()->id : $data['to_id'];
            $to = !empty($to) ? explode(',', $to) : [];
            if ($request->ajax()) {

                if (!empty($to)) {
                    foreach ($to as $key => $value) {
                        # code...
                        $inserArr = [
                            'from_id' => $from,
                            'to_id' => $value,
                            'subject' => $data['subject'],
                            'quote_subject' => $data['quote_subject'],
                            'cc' => $cc,
                            'message' => $message,
                            'parent_id' => $id,
                            'type' => $type,
                            'activePage' => $this->activePage,
                        ];

                        $data = $this->model::insertOrUpdate($inserArr);
                        if (!empty($attachments) && !empty($data?->id)) {
                            $attachmentsArr = explode(",", $attachments);

                            foreach ($attachmentsArr as $key => $value) {
                                $valueArr = explode("-", $value);
                                $originalName = !empty($valueArr[1]) ? $valueArr[1] : null;
                                $imageArr = [
                                    'message' => $data?->id ?? null,
                                    'message_type' => 1,
                                    'file_name' => $value,
                                    'original_name' => $originalName,
                                    'file_type' => \File::extension($value),
                                ];
                                MessageFile::insertOrUpdate($imageArr);
                            }
                        }
                    }
                }
                $msg = $type == 1 ? 'Reply mail send Successfully' : 'Forward mail send Successfully';
                return response()->json(['status' => true, 'msg' => $msg, 'id' => $data->id, 'url' => routeCheck($this->route . 'index')], 200);
            }
        } catch (\Throwable$th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    /**Unread Count*/
    public function unreadCountMail(Request $request)
    {
        try {
            $auth = auth()->user()->id;
            $qId  = $request->qId;
            $vId  = $request->vId;
            $count = $this->model::getData(['toId' => $auth,'qId'=>$qId,'vId'=>$vId])->where(['read' => 0])->where('is_delete', 0)->count();
            return response()->json(['status' => true, 'count' => $count], 200);
        } catch (\Throwable$th) {

            return response()->json(['status' => false, 'msg' => 'something went wrong'], 200);
        }

    }
    /**unread*/
    public function unreadMail(Request $request)
    {
        try {
            $ids = $request->post('ids');
            if (!empty($ids) && is_array($ids)) {
                DB::beginTransaction();
                /*  dd($ids); */
                $this->model::getData()->whereIn('id', $ids)->update(['read' => 0]);
                DB::commit();
            } elseif (!empty($ids)) {
                DB::beginTransaction();
                $this->model::getData()->where('id', $ids)->update(['read' => 0]);
                DB::commit();
            }
            return response()->json(['status' => true, 'msg' => 'Mail Read Successfully'], 200);
        } catch (\Throwable$th) {
            DB::rollback();
            return response()->json(['status' => false, 'msg' => 'something went wrong'], 200);
        }

    }

    /**unread*/
    public function importantMail(Request $request)
    {
        try {
            $ids = $request->post('ids');
            $important = (int) $request->post('important');
            $type = $request->post('type');
            if ($type == 'inboxMail') {
                $arr = ['important' => $important];
            } elseif ($type == 'sentMail') {
                $arr = ['sent_important' => $important];
            } else {
                $arr = [];
                return response()->json(['status' => false, 'msg' => 'something went wrong'], 200);
            }

            if (!empty($ids) && is_array($ids)) {
                DB::beginTransaction();

                $this->model::getData()->whereIn('id', $ids)->update($arr);
                DB::commit();
            } elseif (!empty($ids)) {
                DB::beginTransaction();
                $this->model::getData()->where('id', $ids)->update($arr);
                DB::commit();
            }
            return response()->json(['status' => true, 'msg' => 'Mail important Successfully'], 200);
        } catch (\Throwable$th) {
            DB::rollback();
            return response()->json(['status' => false, 'msg' => 'something went wrong'], 200);
        }
    }

    /* Delete Mail For User Type  */
    public function deletetMail(Request $request)
    {

        try {
            $ids = $request->post('ids');
            $delete = $request->post('delete');
            $type = $request->post('type');

            DB::beginTransaction();
            if (!empty($type) && $type == "inboxMail") {
                $model = $this->model;
                $model::getData()->whereIn('id', $ids)->update(['is_delete' => 1]);
            } elseif (!empty($type) && $type == "draftsMail") {
                $model = new MessageDraft;

                $model::getData()->whereIn('id', $ids)->delete();
            } elseif (!empty($type) && $type == "deleteMail") {
                $model = $this->model;
                $model::getData()->whereIn('id', $ids)->update(['is_delete' => 2]);
            }
            DB::commit();
            return response()->json(['status' => true, 'msg' => 'Mail deleted Successfully'], 200);
        } catch (\Throwable$th) {
            /*   dd($th); */
            DB::rollback();
            return response()->json(['status' => false, 'msg' => 'something went wrong'], 200);
        }

    }

    public function sendMailList(Request $request)
    {
        $qId    = $request->qId;
        $vId    = $request->vId;
        $role = !empty($request->role) ? $this->roleArr($request->role) : '';
        $authId = auth()->user()?->id;
        $data = $this->model::getData(['formId' => $authId,'qId'=>$qId,'vId'=>$vId])->with('user');
        if (!empty($role)) {
            $data = $data->whereHas('user', function ($q) use ($role) {
                $q->where('user_type', $role);
            });
        }
        $data = $data->orderBy('created_at', 'desc')->paginate(10);
        $view = view($this->viwePath . 'inbox-row', ['data' => $data, 'type' => 'sent'])->render();
        $footer = $data->links('vendor.pagination.alpinejs-pagination')->render();
        return response()->json(['status' => true, 'view' => $view, 'footer' => $footer], 200);

    }

    /* Inbox mail lists */
    public function inboxMailList(Request $request)
    {
        $authId = auth()->user()?->id;

        $role = !empty($request->role) ? $this->roleArr($request->role) : '';
        $isDeleted = $request->post('isDeleted') ?? false;
        $qId = $request->post('qId') ?? null;
        $vId = $request->post('vId') ?? null;
        $search = $request->post('search') ?? null;
        $data = $this->model::getData(['toId' => $authId,'qId'=>$qId,'vId'=>$vId])->with('form_user');
        if ($isDeleted) {
            $data = $data->where('is_delete', 1);
        } else {
            $data = $data->where('is_delete', 0);
        }
        if (!empty($search)) {
            $data = $data->whereLike('subject', $search)->orWhereHas('form_user', function ($q) use ($search) {
                $q->whereLike('first_name', $search)
                    ->orwhereLike('middle_name', $search)
                    ->orwhereLike('last_name', $search);
            });
        }
        /*  dd($role); */
        if (!empty($role)) {
            $data = $data->whereHas('form_user', function ($q) use ($role) {
                $q->where('user_type', $role);
            });
        }
        $data = $data->orderBy('created_at', 'desc')->paginate(10);
        $view = view($this->viwePath . 'inbox-row', ['data' => $data, 'inbox' => true, 'isDeleted' => $isDeleted, 'type' => 'inbox'])->render();
        $footer = $data->links('vendor.pagination.alpinejs-pagination')->render();
        return response()->json(['status' => true, 'view' => $view, 'footer' => $footer], 200);
    }

    public function draftsMailList(Request $request)
    {
        $authId = auth()->user()?->id;
        $qId    = $request->qId;
        $vId    = $request->vId;
        $data = MessageDraft::getData(['qId'=>$qId,'vId'=>$vId])->where('from_id', $authId)->orderBy('created_at', 'desc')->paginate(10);
        $view = view($this->viwePath . 'inbox-row', ['data' => $data, 'drafts' => true, 'isDeleted' => true, 'type' => 'drafts'])->render();
        $footer = $data->links('vendor.pagination.alpinejs-pagination')->render();
        return response()->json(['status' => true, 'view' => $view, 'footer' => $footer], 200);
    }

    public function mailDetails(Request $request, $id = null)
    {
        $type = $request->type;
        if ($type == 'drafts') {
            $row = MessageDraft::getData(['id' => $id])->first();
            $toHtml = $ccHtml = array();
            if (isset($row->to_id) && !empty($row->to_id)) {
                $toIds = explode(',', $row->to_id);
                $data = User::getData()->whereIn('id', $toIds)->get();
                if (!empty($data)) {
                    foreach ($data as $d) {
                        $value = $d->name;
                        $id = $d->id;
                        $text = $d->name;
                        $userType = $d->user_type;
                        if ($userType == User::ADMIN) {
                            $textName = "";
                            $value = "LMS Support";
                            $color = "text-dark";
                        } elseif ($userType == User::COMPANYUSER) {
                            $textName = "@ " . $d?->company?->comp_name;
                            $color = "text-success";
                        } elseif ($userType == User::AGENT) {
                            $textName = "@ " . $d?->entity?->name;
                            $color = "text-info";
                        } elseif ($userType == User::SALESORG) {
                            $textName = "@ " . $d?->entity?->name;
                            $color = "text-warning";
                        }

                        $toHtml[] = [
                            "name" => "<span class='{$color}'>{$value} {$textName}</span>",
                            "value" => $id,
                            "id" => $id,
                            "text" => $value . " " . $textName,
                            "class" => $color,
                        ];

                    }
                }
            }
            if (isset($row->cc) && !empty($row->cc)) {
                $ccIds = explode(',', $row->cc);
                $data = User::getData()->whereIn('id', $ccIds)->get();
                if (!empty($data)) {
                    foreach ($data as $d) {
                        $value = $d->name;
                        $id = $d->id;
                        $text = $d->name;
                        $userType = $d->user_type;
                        if ($userType == User::ADMIN) {
                            $textName = "";
                            $value = "LMS Support";
                            $color = "text-dark";
                        } elseif ($userType == User::COMPANYUSER) {
                            $textName = "@ " . $d?->company?->comp_name;
                            $color = "text-success";
                        } elseif ($userType == User::AGENT) {
                            $textName = "@ " . $d?->entity?->name;
                            $color = "text-info";
                        } elseif ($userType == User::SALESORG) {
                            $textName = "@ " . $d?->entity?->name;
                            $color = "text-warning";
                        }

                        $ccHtml[] = [
                            "name" => "<span class='{$color}'>{$value} {$textName}</span>",
                            "value" => $id,
                            "id" => $id,
                            "text" => $value . " " . $textName,
                            "class" => $color,
                        ];
                    }
                }
            }
            return response()->json(['status' => true, 'data' => $row, 'toHtml' => $toHtml, 'ccHtml' => $ccHtml], 200);
        } else if ($type == 'forward') {
            $row = $this->model::getData(['id' => $id])->with('files')->first();
            $toHtml = $ccHtml = array();
            if (isset($row->to_id) && !empty($row->to_id)) {
                $toIds = explode(',', $row->to_id);
                $data = User::getData()->whereIn('id', $toIds)->get(['first_name', 'id as value', 'first_name as text'])?->toArray();
                if (!empty($data)) {
                    foreach ($data as $d) {
                        $toHtml[] = array('value' => $d['value'], 'text' => $d['text'], 'name' => $d['text']);
                    }
                }
            }
            if (isset($row->cc) && !empty($row->cc)) {
                $ccIds = explode(',', $row->cc);
                $data = User::getData()->whereIn('id', $ccIds)->get(['first_name', 'id as value', 'first_name as text'])?->toArray();
                if (!empty($data)) {
                    foreach ($data as $d) {
                        $ccHtml[] = array('value' => $d['value'], 'text' => $d['text'], 'name' => $d['text']);
                    }
                }
            }
            return response()->json(['status' => true, 'data' => $row, 'toHtml' => $toHtml, 'ccHtml' => $ccHtml], 200);
        } else {
            if ($type == 'inbox') {
                $this->model::getData()->where('id', $id)->update(['read' => 1]);
            }
            $row = $this->model::getData(['id' => $id])->with('reply_mail')->first();

            return view($this->viwePath . 'mail-details', ['row' => $row, 'type' => $type]);
        }
    }

    public function replayMail(Request $request, $id = null)
    {
        $type = $request->type;
        $replayType = $request->replayType;
        $row = $this->model::getData(['id' => $id])->first();

        return view($this->viwePath . 'reply-mail-form', ['row' => $row, 'type' => $type, 'route' => $this->route, 'replayType' => $replayType]);
    }

    private function roleArr($role)
    {
        $roleArr = [
            'finance_companies' => User::COMPANYUSER,
            'lms_support' => User::ADMIN,
            'insureds' => User::INSURED,
            'agents' => User::AGENT,
            'sales_organizations' => User::SALESORG,
        ];
        return isset($roleArr[$role]) ? $roleArr[$role] : null;
    }

}
