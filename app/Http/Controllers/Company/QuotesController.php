<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\AgentOtherSetting;
use App\Models\Attachment;
use App\Models\CoverageType;
use App\Models\Entity;
use App\Models\Logs;
use App\Models\Message;
use App\Models\PolicyTermsOption;
use App\Models\Quote;
use App\Models\QuoteNote;
use App\Models\QuotePolicy;
use App\Models\QuoteSetting;
use App\Models\QuoteTerm;
use App\Models\QuoteVersion;
use App\Models\RateTable;
use App\Models\Setting;
use App\Models\State;
use App\Models\StateSettings;
use App\Models\Task;
use App\Models\User;
use DBHelper;
use Error,DB,Arr;
use Illuminate\Http\Request;use Str;

class QuotesController extends Controller
{
    private $viwePath = "company.quotes.";
    public $pageTitle = "Quotes";
    public $activePage = "quotes";
    public $route = "company.quotes.";
    public function __construct(Quote $model)
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
        $this->pageTitle = "Quotes";
        return view($this->viwePath . "index", ['route' => $this->route,'pageTitle'=>$this->pageTitle, 'activePage' => $this->activePage,'pageType'=>'index']);
    }

    public function quotesActivation()
    {
        $this->pageTitle = "Quotes In Activation";
        return view($this->viwePath . "index", ['route' => $this->route, 'pageTitle' => $this->pageTitle,'activePage' => $this->activePage,'pageType'=>'quotes-activation']);
    }

    public function findQuotes()
    {
        $this->pageTitle = "Find/Edit Quotes";
        return view($this->viwePath . "find-quotes", ['route' => $this->route,'activePage'=>$this->activePage, 'pageTitle' => $this->pageTitle]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userData = auth()->user();
        $userType = $userData?->user_type;
        $paymentSetting = Setting::getData(['type' => 'electronic-payment-setting'])->first()?->json ?? null;
        $paymentSetting = !empty($paymentSetting) ? json_decode($paymentSetting, true) : null;
        $count = $this->model::getData()->count();
        $count = (int) $count + 1;
        $count = idCount(1, $count);
        $this->pageTitle = "Quote # {$count}";

        $agencyId = $insuredId = null;
        if ($userType == User::AGENT) {
            $agencyId = $userData?->entity_id;
        } elseif ($userType == User::INSURED) {
            $insuredId = $userData?->entity_id;
            $agencyId = $userData?->entity?->agency;
        }

        return view($this->viwePath . "create", [
            'agencyId' => $agencyId,
            'insuredId' => $insuredId,
            'route' => $this->route,
            'pageTitle' => $this->pageTitle,
            'paymentSetting' => $paymentSetting,
        ]);
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
                $inputs = $request->except(['company_data', '_token']);
                $inputs['inception_date'] = $request->post('inception_date');

                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $data = $this->model::insertOrUpdate($inputs);
                $qid = $data?->id;
                $vid = $data?->quoteVersion?->id;

                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created successfully', 'type' => 'policyModel', 'policy' => routeCheck($this->route . "edit", ['quote' => $qid, 'type' => 'policy']), 'url' => routeCheck($this->route . "edit", ['quote' => $qid])], 200);
            }
        } catch (\Throwable $th) {
            /*    dd($th); */
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
    public function edit($id)
    {
        $pageType = request()->segment(4);
        $userData = auth()->user();
        $userType = $userData?->user_type;
        $pageType = !empty($pageType) ? $pageType : 'edit';
        $data = $this->model::getData()->where('id', $id)->firstOrFail();
        $paymentSetting = Setting::getData(['type' => 'electronic-payment-setting'])->first()?->json ?? null;
        $paymentSetting = !empty($paymentSetting) ? json_decode($paymentSetting, true) : null;
        if ($data?->status == -1) {
            $this->pageTitle = "Quote # {$data?->qid}";
            $agencyJson[] = [
                "name" => $data?->agency_data?->name,
                "value" => $data?->agency,
                "text" => $data?->agency_data?->name,
            ];

            $insuredJson[] = [
                "name" => $data?->insur_data?->name,
                "value" => $data?->insured,
                "text" => $data?->insur_data?->name,
            ];
            $agencyId = $insuredId = null;
            if ($userType == User::AGENT) {
                $agencyId = $userData?->entity_id;
            } elseif ($userType == User::INSURED) {
                $insuredId = $userData?->entity_id;
                $agencyId = $userData?->entity?->agency;
            }

            return view($this->viwePath . "create", [
                'agencyId' => $agencyId,
                'insuredId' => $insuredId,
                'route' => $this->route,
                'data' => $data,
                'id' => $id,
                'activePage' => $this->activePage, 'paymentSetting' => $paymentSetting, 'pageTitle' => $this->pageTitle, 'agencyJson' => $agencyJson, 'insuredJson' => $insuredJson]);
        }

        /* if($data?->status == $this->model::DELETE && empty($data?->finance_company)){
            return redirect()->route($this->route . "underwriting-edit-quote", $data['id']);
        } */

       

        if($data?->status == $this->model::PROCESS && $pageType == 'edit' && !($data?->status == $this->model::DELETE)){
            return redirect()->route($this->route . "underwriting-edit-quote", $data['id']);
        }
        $ratetables = RateTable::getData()->whereIn('id', explode(',', $data?->agency_data?->rate_table))->get()?->pluck('name', 'id')?->toArray();
        $versionList = QuoteVersion::getData(['qId' => $id])->get();
        $versionCount = !empty($versionList) ? count($versionList?->toArray() ?? []) : 0;
        $insuredUsers = User::getData()->where('entity_id', $data->insured)->get()?->pluck('name', 'id')?->toArray();
        $quoteVersion = QuoteVersion::getData(['id' => $data->vid])->first();
        $agentSignature = $quoteVersion?->agent_signature ?? 0;
        $isnuredSignature = $quoteVersion?->isnured_signature ?? 0;
        $attachmentData = Attachment::getData(['qId' => $id, 'vId' => $data->vid, 'pfa' => 1])->count();
       /*  dd($attachmentData); */
        $isRequestActive = false;

        if ((!empty($agentSignature) && !empty($isnuredSignature)) || !empty($attachmentData)) {
            $isRequestActive = true;
        }
        return view($this->viwePath . "edit", [
            'route' => $this->route,
            'data' => $data,
            'id' => $id,
            'ratetables' => $ratetables,
            'activePage' => $this->activePage,
            'paymentSetting' => $paymentSetting,
            'versionList' => $versionList,
            'versionCount' => $versionCount,
            'insuredUsers' => $insuredUsers,
            'isRequestActive' => $isRequestActive,
            'pageType' => $pageType,
        ]);
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
                $inputs = $request->except(['company_data', '_token']);
                $inputs['id'] = $id;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $stateData = $this->model::insertOrUpdate($inputs);
                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been updated successfully', 'backurl' => route($this->route . "index")], 200);
            }
        } catch (\Throwable $th) {
            /*  dd($th); */
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        try {

            $userData = $request->user();
            $userId   = $userData?->id;
            $userType = $userData?->user_type;
            $userName = $userData?->name;

            $quoteData = $this->model::getData(['id' => $id])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $version = $quoteData?->version;
            $quoteData->status = $this->model::DELETE;
            $quoteData->save();


            $quoteNumber= $quoteData?->quote_number;
            $message = "Quote # {$quoteNumber} Deleted";
            Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userId, 'type_id' => $id, 'message' => $message]);

            if ($request->ajax()) {

                return response()->json(['status' => true, 'msg' => $message, 'url' => routeCheck($this->route . "index")], 200);
            }else{
                return redirect()->route($this->route.'index');
            }
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
            }else{
                return redirect()->route($this->route.'edit', $qId);
            }

        }
    }

    /*
    @AjaxGet Data List
     */
    private function viewList(array $request = null)
    {
        //$request =$request->except(['company_data', '_token']);
        $userData = auth()->user();
        $userId = $userData->id;
        $userType = $userData->user_type;
        $entityId = $userData->entity_id;

        $columnName         = !empty($request['sort']) ? $request['sort'] : '';
        $columnSortOrder    = !empty($request['order']) ? $request['order'] : '';
        $offset             = !empty($request['offset']) ? $request['offset'] : 0;
        $limit              = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue        = !empty($request['search']) ? $request['search'] : '';
        $tab                = !empty($request['tab']) ? $request['tab'] : '';
        $status             = !empty($request['status']) ? $request['status'] : '';
        $policy_number      = !empty($request['policy_number']) ? $request['policy_number'] : '';
        $insurance_company  = !empty($request['insurance_company']) ? $request['insurance_company'] : '';
        $general_agent      = !empty($request['general_agent']) ? $request['general_agent'] : '';
        $email              = !empty($request['email']) ? $request['email'] : '';
        $telephone          = !empty($request['telephone']) ? $request['telephone'] : '';
        $address            = !empty($request['address']) ? $request['address'] : '';
        $city               = !empty($request['primary_address_city']) ? $request['primary_address_city'] : '';
        $state              = !empty($request['primary_address_state']) ? $request['primary_address_state'] : '';
        $zip                = !empty($request['primary_address_zip']) ? $request['primary_address_zip'] : '';
        $startDate          = !empty($request['start_date']) ? $request['start_date'] : '';
        $endDate            = !empty($request['end_date']) ? $request['end_date'] : '';
        $insured            = !empty($request['insured']) ? $request['insured'] : '';
        $coverageType       = !empty($request['coverage_type']) ? $request['coverage_type'] : '';
        $agency             = !empty($request['agency']) ? $request['agency'] : '';
        $general_agent      = !empty($general_agent) && isEncryptValue($general_agent) ? decryptUrl($general_agent) : $general_agent ;
        $insured      = !empty($insured) && isEncryptValue($insured) ? decryptUrl($insured) : $insured ;

/* dd( $general_agent ); */

        $columnNameArr = ['quoteid' => 'quotes.qid', 'created_at' => 'quotes.created_at', 'updated_at' => 'quotes.updated_at', 'insured' => 'insured_e.name', 'agency' => 'agency_e.name','premium' => 'quote_terms.pure_premium','down_payment' => 'quote_terms.down_payment','total' => 'quote_terms.total_payment'];
        $columnName = isset($columnNameArr[$columnName]) ? $columnNameArr[$columnName] : 'quotes.created_at';


        $selectFields = ['quotes.*', 'insured_e.name as insured_name', 'agency_e.name as agency_name','quote_terms.pure_premium as pure_premium','quote_terms.down_payment as down_payment','quote_terms.total_payment as total_payment'];
        $sqlData =  $this->model::getData($request)
                        ->Join('entities as insured_e', function ($join) {
                            $join->on('insured_e.id', '=', 'quotes.insured')
                        ->where('insured_e.type', Entity::INSURED);
                        })->Join('entities as agency_e', function ($join) {
                            $join->on('agency_e.id', '=', 'quotes.agency')
                                 ->where('agency_e.type', Entity::AGENT);
                        })->leftJoin('quote_terms', function ($join) {
                            $join->on('quote_terms.quote', '=', 'quotes.id')
                            ->whereColumn('quote_terms.version', '=', 'quotes.vid');
                        });

        $sqlData->when($userType == User::AGENT, function ($q) use($entityId) {
            return $q->where('quotes.agency', $entityId);
        });
        $sqlData->when($userType == User::INSURED, function ($q) use($entityId) {
            return $q->where('quotes.insured', $entityId);
        });
        $sqlData->when($tab == 'open_quote', function ($q) {
            return $q->where('quotes.status',$this->model::NEW);
        });
        $sqlData->when($tab == 'draft_quote', function ($q) {
            return $q->where('quotes.status',$this->model::DRAFT);
        });
        $sqlData->when($tab == 'delete_quote', function ($q) {
            return $q->where('quotes.status',$this->model::DELETE);
        });

        if($tab == 'request_for_activation'){
            $sqlData = $sqlData->where('quotes.status',$this->model::ACTIVEREQUEST);
           // $selectFields[] = DB::raw('CONCAT(fc.first_name," ",fc.first_name," ",fc.first_name) as fc_name');
        }


        if($tab == 'in_process_request'){
            $sqlData = $sqlData->Join('users as fc', function ($join) {
                $join->on('fc.id', '=', 'quotes.finance_company');
            })->where('quotes.status',$this->model::PROCESS);
            $selectFields[] = 'fc.first_name as fname';
            $selectFields[] = 'fc.last_name as lname' ;
            $selectFields[] = 'fc.middle_name as mname';
        }
    //  dd($status);
        if(!empty($status) && is_array($status)){
            $statusArr  = [
                'all'           => null ,
                'open_tab'      =>$this->model::NEW,
                'draft_quote'   =>$this->model::DRAFT,
                'request_for_activation'=>$this->model::ACTIVEREQUEST,
                'locked_tab'    =>null,
                'delete_quote'  =>null
            ];
            $status = Arr::only($statusArr,$status);
            $status = !empty($status) ? array_values($status) : [];
            $status = !empty($status) ? arrFilter($status) : [];
            $sqlData = $sqlData->whereIn('quotes.status',$status);
        }

        /* filtter for policy_number on join quotes policy  table */
        if(!empty($policy_number) || !empty($insurance_company) || !empty($general_agent) || !empty($coverageType)){
            $sqlData = $sqlData->Join('quote_policies as qp', function ($join) use($policy_number,$insurance_company,$general_agent) {
                $join->on('qp.quote', '=', 'quotes.id');
            });

            if(!empty($policy_number)){
                $sqlData = $sqlData->where('qp.policy_number','LIKE',"%{$policy_number}%");
            }

            if(!empty($insurance_company)){
                $sqlData = $sqlData->where('qp.insurance_company',$insurance_company);
            }

            if(!empty($general_agent)){
                $sqlData = $sqlData->where('qp.general_agent',$general_agent);
            }
            if(!empty($coverageType)){
                $sqlData = $sqlData->where('qp.coverage_type',$coverageType);
            }

        }

        if(!empty($email)){
            $sqlData = $sqlData->where(function($q) use($email) {
                $q->whereLike('insured_e.email',$email)
                ->orwhereLike('agency_e.email',$email);
            });
        }
        if(!empty($agency)){
            $sqlData = $sqlData->where(function($q) use($agency) {
                $q->where('agency_e.id',$agency);
            });
        }

        if(!empty($telephone)){
            $sqlData = $sqlData->where(function($q) use($telephone)   {
                $q->whereEn('insured_e.telephone',$telephone)
                ->orWhereEncrypted('agency_e.telephone',$telephone);
            });
           
        }

        if(!empty($address)){
            $sqlData = $sqlData->where(function($q) use($address)   {
                $q->whereEn('insured_e.address',$address)
                ->orWhereEncrypted('agency_e.address',$address);
            });
        }

        if(!empty($state)){
            $sqlData = $sqlData->where(function($q) use($state)   {
                $q->whereEn('insured_e.state',$state)
                ->orWhereEncrypted('agency_e.state',$state);
            });
        }

        if(!empty($city)){
            $sqlData = $sqlData->where(function($q) use($city)   {
                $q->whereEn('insured_e.city',$city)
                ->orWhereEncrypted('agency_e.city',$city);
            });
        }
        if(!empty($zip)){
            $sqlData = $sqlData->where(function($q) use($zip)   {
                $q->whereEn('insured_e.zip',$zip)
                ->orWhereEncrypted('agency_e.zip',$zip);
            });
           
        }
        if(!empty($insured)){
            $sqlData = $sqlData->where('quotes.insured',$insured);
        }

        if(!empty($date)){
            $startDate    = !empty($startDate) ? dbDateFormat($startDate) : '' ;
            $endDate    = !empty($endDate) ? dbDateFormat($endDate) : '' ;
            $sqlData = $sqlData->whereBetween('quotes.created_at',[$startDate,$endDate]);
        }





        $totalstateDatas = $sqlData->count();
        $dataArr = [];

        if ($columnName == 'insured_e.name' || $columnName == "agency_e.name") {
            $sqlData = $sqlData->orderBy("{$columnName}", $columnSortOrder);
        } else {
            $sqlData = $sqlData->orderBy($columnName, $columnSortOrder);
        }

        $data = $sqlData->skip($offset)->take($limit)->get($selectFields);

        if (!empty($data)) {
            foreach ($data as $row) {


                if($userType == User::COMPANYUSER){
                    if($row?->status >= $this->model::PROCESS && $row?->status != $this->model::DELETE){
                        $editUrl = routeCheck($this->route . "underwriting-edit-quote", $row['id']);
                    }else{
                        $editUrl = routeCheck($this->route . "edit", $row['id']);
                    }
                }else{
                    $editUrl = routeCheck($this->route . "edit", $row['id']);
                }


                $name   = "{$row['qid']}" . (!empty($row['version']) ? "." . $row['version'] : '');
                $status = dotBtn($row?->status, 'quote');
                $fname  = !empty($row?->fname) ? decryptData($row?->fname) : '';
                $mname  = !empty($row?->mname) ? decryptData($row?->mname) : '';
                $lname  = !empty($row?->lname) ? decryptData($row?->lname) : '';
                $dataArr[] = [
                    "created_at" => changeDateFormat($row?->created_at),
                    "updated_at" => changeDateFormat($row?->updated_at),
                    "insured"    => decryptData($row?->insured_name),
                    "agency"     => decryptData($row?->agency_name),
                    "account_type"     => ucfirst($row?->account_type),
                    "quote_type"     => ucfirst($row?->quote_type),
                    "assign_to"  => "{$fname} {$mname} {$lname}",
                    "premium"  => !empty($row?->pure_premium) ? "$".formatAmount($row?->pure_premium) : "$0.00",
                    "down_payment"  => !empty($row?->down_payment) ? "$".formatAmount($row?->down_payment) : "$0.00",
                    "total"  => !empty($row?->total_payment) ? "$".formatAmount($row?->total_payment) : "$0.00",
                    "quoteid" => "<a href='{$editUrl}'  data-turbolinks='false' >{$name}</a> {$status}",

                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }





    public function quoteSettings(Request $request)
    {
        $this->pageTitle = "Quote Settings";
        $this->activePage = "quote_settings";
        $data = QuoteSetting::getData()->first();
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['status'] = 1;
                $inputs['id'] = $data?->id;
                $inputs['onDB'] = 'company_mysql';
                $res = QuoteSetting::insertOrUpdate($inputs);
                $msg = !empty($data->id) ? "updated" : "created";
                return response()->json(['status' => true, 'msg' => $this->pageTitle . " has been {$msg} successfully"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
        return view($this->viwePath . "quote-settings", ['route' => $this->route, 'pageTitle' => $this->pageTitle, 'data' => $data, 'activePage' => 'quote_settings']);
    }

    public function newQuote(Request $request)
    {

        $pageTitle = "Add New Quote";
        $draftId = $request->draftId;
        $update = $request->update;
        $userType = (int) $request->userType;
        $insured = (int) $request->insured;
        $agency = $request->agency;

        /* Quote Save in darft */
        $notallowedMsg = $qId = '';
        if (!empty($insured) && !empty($insured) && $update != 'no') {
            $inserData = [
                'agency' => $agency,
                'insured' => $insured,
                'status' => $this->model::DRAFT,
                'isDraft' => true,
                'id' => $draftId,
            ];
            $quoteData = $this->model::darftSaveData($inserData);
            $draftId = $quoteData?->id;
            $qId = $quoteData?->qid;
        }

        $rate_table = Entity::getData(['id' => $agency])->first();
        $insured_data = Entity::getData(['id' => $insured])->first();
        $allowedNewQuote = false;

        /* Check State Setting For insured state */
        if (!empty($insured_data)) {
            $state = State::getData()->whereEn('state', $insured_data->state)->first();
            if (!empty($state) && isset($state->id) && isset($state->state_setting->id)) {
                $allowedNewQuote = true;
            } else {
                $notallowedMsg = "A State settings for the state of " . $insured_data->state . " need to be added prior to adding the state of " . $insured_data->state . ".";
            }
        }

        /* Check Rate Table Exits */
        $rateTableId = !empty($rate_table?->rate_table) ? explode(',', $rate_table->rate_table) : [];
        $agent_rate_table = RateTable::getData()->whereIn('id', $rateTableId)->get()?->pluck('name', 'id')?->toArray();
        if (empty($agent_rate_table)) {
            $allowedNewQuote = false;
            $notallowedMsg = "There is no Rate table assigned to this agency please contact to Administrator";
        }

        $quoteSettings = QuoteSetting::getData()->first();
        $coverage_types = array();
        $policy_terms = PolicyTermsOption::getData()->get();
        $policy_term_options = array();
        if (!empty($policy_terms)) {
            foreach ($policy_terms as $policy_term) {
                $policy_term_options[$policy_term->days] = $policy_term->days . ' days';
            }
        }

        $policyminiumearnedpercent = !empty($quoteSettings->policy_minium_earned_percent) ? $quoteSettings->policy_minium_earned_percent : '';
        if (auth()->user()?->user_type == USER::AGENT || !empty($agency)) {
            $agentOtherSetting = AgentOtherSetting::getData(['entityId' => $agency])->first();
            $agentdownpaymentincrease = !empty($agentOtherSetting) && isset($agentOtherSetting->down_payment_increase) ? $agentOtherSetting->down_payment_increase : '';
            $down_payment_increase = empty($agentdownpaymentincrease) ? (!empty($quoteSettings->down_percent) ? $quoteSettings->down_percent : '') : $agentdownpaymentincrease;
        } else {
            $down_payment_increase = !empty($quotesettingsArr['down_percent']) ? $quotesettingsArr['down_percent'] : '';
        }

        $policy_minium_earned_percent = !empty($down_payment_increase) ? ($policyminiumearnedpercent + $down_payment_increase) : $policyminiumearnedpercent;
        $view = view("{$this->viwePath}.new_quote", ['route' => $this->route, 'draftId' => $draftId, 'qId' => $qId, 'pageTitle' => $this->pageTitle, 'agency' => $agency, 'insured' => $insured, 'activePage' => $this->activePage, 'quoteSettings' => $quoteSettings, 'agent_rate_table' => $agent_rate_table, 'coverage_types' => $coverage_types, 'policy_term_options' => $policy_term_options, 'allowedNewQuote' => $allowedNewQuote, 'notallowedMsg' => $notallowedMsg, 'policy_minium_earned_percent' => $policy_minium_earned_percent])->render();
        return response()->json(['status' => true, 'view' => $view, 'draftId' => $draftId, 'qId' => $qId], 200);
    }

    public function get_line_of_business_data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $coverage_types = $this->get_coverage_type($request->line_of_business);
            return response()->json(['status' => true, 'coverage_types' => $coverage_types], 200);
        }
    }
    public function get_coverage_type($line_of_business)
    {
        if (!empty($line_of_business)) {
            $coverage_types = CoverageType::getData()->whereEn('account_type', 'all')->orWhereEncrypted('account_type', '=', $line_of_business)->get();
        } else {
            $coverage_types = CoverageType::getData()->whereEn('account_type', 'all')->get();
        }
        $coverages = array();
        if (!empty($coverage_types)) {
            foreach ($coverage_types as $coverage_type) {
                $coverages[] = array('name' => $coverage_type->name, 'value' => $coverage_type->id, 'text' => $coverage_type->name);
            }
        }
        return $coverages;
    }
    public function check_pure_premium(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $error = '';
            $line_of_business = $request->line_of_business;
            $origination_state = $request->origination_state;
            $pure_premium = $request->pure_premium;
            $agency = $request->agency;
            $insured = $request->insured;
            $pure_premium = !empty($pure_premium) ? str_replace('$', '', $pure_premium) : '';
            $purepremium = !empty($pure_premium) ? str_replace(',', '', $pure_premium) : '';
            $agencyData = Entity::getData(['id' => $agency])->first();
            $insuredData = Entity::getData(['id' => $insured])->first();
            $quoteSettings = QuoteSetting::getData()->first();
            if ($line_of_business == 'commercial') {
                $maximum_finance_amount = $agencyData->commercial_maximum_finance_amount;
            } else if ($line_of_business == 'personal') {
                $maximum_finance_amount = $agencyData->personal_maximum_finance_amount;
            }
            if (empty($maximum_finance_amount)) {
                if ($origination_state == 'insured_physical') {
                    $mainoriginationstate = $insuredData->state;
                } else if ($origination_state == 'insured_mailing') {
                    $mainoriginationstate = $insuredData->mailing_state;
                    if (empty($mainoriginationstate)) {
                        $mainoriginationstate = $insuredData->state;
                    }
                } else if ($origination_state == 'agent') {
                    $mainoriginationstate = $agencyData->state;
                }
                $state_settings_Arr = '';
                if (!empty($mainoriginationstate)) {
                    $state = State::getData()->whereEn('state', $mainoriginationstate)->first();
                    if (!empty($state) && isset($state->id)) {
                        $stateSettings = StateSettings::getData()->where('state', $state->id)->first();
                        if (!empty($stateSettings) && isset($stateSettings->id)) {
                            if ($line_of_business == 'commercial') {
                                $maximum_finance_amount = !empty($stateSettings->commercial_maximum_finance_amount) ? $stateSettings->commercial_maximum_finance_amount : '';
                            } else if ($line_of_business == 'personal') {
                                $maximum_finance_amount = !empty($stateSettings->personal_maximum_finance_amount) ? $stateSettings->personal_maximum_finance_amount : '';
                            }
                        }
                    }
                }
            }
            if (empty($maximum_finance_amount)) {
                if (!empty($quoteSettings)) {
                    if ($line_of_business == 'Commercial') {
                        $maximum_finance_amount = !empty($quoteSettings->commercial_maximum_finance_amount) ? $quoteSettings->commercial_maximum_finance_amount : '';
                    } else if ($line_of_business == 'Personal') {
                        $maximum_finance_amount = !empty($quoteSettings->personal_maximum_finance_amount) ? $quoteSettings->personal_maximum_finance_amount : '';
                    }
                }
            }
            if (!empty($maximum_finance_amount) && $purepremium > $maximum_finance_amount) {
                $error = 'The pure premium you entered should be less than the minimum amount of $' . number_format($maximum_finance_amount, 2);
                return response()->json(['status' => false, 'error' => $error], 200);
            }
            return response()->json(['status' => true], 200);
        }
    }

    /**
     * quote_policy a newly created resource in storage.
     */
    public function quotePolicy(Request $request, $qId = "null", $vId = "null")
    {
        $quoteData = $this->model::getData(['id' => $qId])->firstOrFail();
        try {
            if ($request->ajax()) {
                $inputs = $request->except(['company_data', '_token']);
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $qId;
                $inputs['quote'] = $qId;
                $data = QuotePolicy::insertOrUpdate($inputs);
                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created successfully', 'url' => route($this->route . "quote-policy", ['qId' => $qId, 'vId' => $vId])], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }

        $this->pageTitle = "Quote Policy";
        $quoteSettings = QuoteSetting::getData()->first();
        $policy_terms = PolicyTermsOption::getData()->get();
        $policy_term_options = array();
        if (!empty($policy_terms)) {
            foreach ($policy_terms as $policy_term) {
                $policy_term_options[$policy_term->days] = $policy_term->days . ' days';
            }
        }
        return view($this->viwePath . "quote_policy", ['route' => $this->route, 'quoteSettings' => $quoteSettings, 'pageTitle' => $this->pageTitle, 'quoteData' => $quoteData, 'policy_term_options' => $policy_term_options, 'vId' => $vId]);

    }

    /**
     * Policy List Show In Quote Id Base
     */
    public function policyList($quoteId = "null", $vId = "null")
    {
        $quoteData = $this->model::getData(['id' => $quoteId])->firstOrFail();
        $data = QuotePolicy::getData(['qId' => $quoteId, 'version' => $vId])->orderBy('created_at', 'desc')->get();
        return view($this->viwePath . "policy.index", ['route' => $this->route, 'activePage' => $this->activePage, 'data' => $data, 'quoteData' => $quoteData]);
    }

    /**
     * Policy details Show In Quote Id Base
     */
    public function policyDetail(Request $request, $id = "null")
    {

        $data = QuotePolicy::getData(['id' => $id])->first();

        try {
            /* Update Code In Ajax */

            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['id'] = $id;
                $inputs['logId'] = $data->quote;
                $inputs['activePage'] = $this->activePage;
                $inputs['onlyPolicy'] = true;
                $QuotePolicy = QuotePolicy::insertOrUpdate($inputs);
                return response()->json(['status' => true, 'msg' => 'Quote Policy has been updated successfully'], 200);
            }

            $insurance = !empty($data->insurance_company_data) ? $data->insurance_company_data : null;
            $generalAgent = !empty($data->general_agent_data) ? $data->general_agent_data : null;
            $view = view($this->viwePath . "policy.edit", ['route' => $this->route, 'activePage' => $this->activePage, 'data' => $data])->render();
            $insuranceJson = [['value' => $insurance?->id, 'text' => $insurance?->name, 'name' => $insurance?->name, 'selected' => true]];
            $generalAgentJson = [['value' => $generalAgent?->id, 'text' => $generalAgent?->name, 'name' => $generalAgent?->name, 'selected' => true]];
            return ['status' => true, 'view' => $view, 'insuranceJson' => $insuranceJson, 'generalAgentJson' => $generalAgentJson];
        } catch (\Throwable $th) {

            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }
    /**
     * Policy Create Show In Quote Id Base
     */
    public function policyCreate(Request $request, $quoteId = "null", $vId = "null")
    {
        try {
            /* Update Code In Ajax */
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['quote'] = $quoteId;
                $inputs['logId'] = $quoteId;
                $inputs['version'] = $vId;
                $inputs['onlyPolicy'] = true;
                $inputs['activePage'] = $this->activePage;
                //dd( $inputs);
                $QuotePolicy = QuotePolicy::insertOrUpdate($inputs);
                return response()->json(['status' => true, 'msg' => 'Policy was added successfully!', 'type' => 'policyModel', 'policy' => routeCheck($this->route . "edit", ['quote' => $quoteId, 'type' => 'policy']), 'url' => routeCheck($this->route . "edit", ['quote' => $quoteId])], 200);

            }
            $view = view($this->viwePath . "policy.create", ['route' => $this->route, 'activePage' => $this->activePage, 'quoteId' => $quoteId, 'vId' => $vId])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {

            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /** * Policy Create Show In Quote Id Base*/
    public function terms(Request $request, $quoteId = "null", $vId = "null")
    {
        try {

            $quoteData = $this->model::getData(['id' => $quoteId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $quoteVersion = QuoteVersion::getData(['id' => $vId])->first();
            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Version Id");
            }

            $quoteTerm = QuoteTerm::getData(['qId' => $quoteId, 'vId' => $vId])->first();
            $quoteSetting = QuoteSetting::getData()->first();
            return view($this->viwePath . "terms.index", ['quoteVersion' => $quoteVersion, 'quoteTerm' => $quoteTerm, 'quoteSetting' => $quoteSetting, 'quoteData' => $quoteData]);
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /**
     * Policy Create Show In Quote Id Base
     */
    public function termsUpdate(Request $request, $quoteId = "null", $vId = "null")
    {
        try {
            $quoteVersion = QuoteTerm::getData(['qId' => $quoteId, 'vId' => $vId])->first();

            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Data");
            }

            $updateData = array();
            $name = $request->post('name');
            $value = $request->post('value');
            $quoteVersion = $quoteVersion->toArray();
            $updateData[$name] = $value;

            $response = QuoteTerm::updateTerms($quoteVersion, $updateData);

            /*  dd( $response); */
			 return ['status' => true, 'msg' => 'Successfully updated'];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }
	 /**
     * Update agent compensation
     */
    public function compensationUpdate(Request $request, $quoteId = "null", $vId = "null")
    {
        try {
            $quoteVersion = QuoteTerm::getData(['qId' => $quoteId, 'vId' => $vId])->first();

            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Data");
            }

            $updateData = array();
            $name = $request->post('name');
            $value = $request->post('value');
            $quoteVersion = $quoteVersion->toArray();
            $updateData[$name] = $value;

            $response = QuoteTerm::updateCompensation($quoteVersion, $updateData);

            /*  dd( $response); */
			 return ['status' => true, 'msg' => 'Successfully updated'];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /* Policy Create Show In Quote Id Base*/

    public function quotefavoriteVersion(Request $request, $vId = "null")
    {

        try {
            /* Update Code In Ajax */
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['id'] = $vId;
                $inputs['activePage'] = $this->activePage;
                $QuotePolicy = QuoteVersion::quotefavoriteVersion($inputs);
                return response()->json(['status' => true, 'msg' => 'Quote Version was favorite successfully!'], 200);
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }

    }

    /*clone Version*/

    public function quoteCloneVersion(Request $request, $vId = "null")
    {

        try {
            /* Update Code In Ajax */
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['id'] = $vId;
                $inputs['activePage'] = $this->activePage;
                $insertOrUpdate = Quote::quoteCloneVersion($inputs);
                return response()->json(['status' => true, 'msg' => 'Version copied successfully!', 'version' => $insertOrUpdate->version_id, 'versionId' => $insertOrUpdate->id], 200);
            }
        } catch (\Throwable $th) {
            // dd($th);
            return ['status' => false, 'msg' => $th->getMessage()];
        }

    }

    /**
     * newVersion Create Show In Quote Id Base
     */
    public function quoteNewVersion(Request $request, $quoteId = "null")
    {
        try {
            /* Update Code In Ajax */
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                $inputs['id'] = $quoteId;
                $inputs['activePage'] = $this->activePage;
                $QuotePolicy = $this->model::quoteNewVersion($inputs);
                return response()->json(['status' => true, 'msg' => 'New Version was added successfully!', 'type' => 'policyModel', 'url' => routeCheck($this->route . "edit", ['quote' => $quoteId, 'type' => 'policy'])], 200);
            }
            $view = view($this->viwePath . "terms.create", ['route' => $this->route, 'activePage' => $this->activePage, 'quoteId' => $quoteId])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            //  dd($th);
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /**
     * newVersion Create Show In Quote Id Base
     */
    public function tasksIndex(Request $request, $qId = "null", $vId = "null")
    {

        try {
            $view = view($this->viwePath . "tasks.index", ['route' => $this->route, 'qId' => $qId, 'vId' => $vId, 'activePage' => $this->activePage])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /**
     * newVersion Create Show In Quote Id Base
     */
    public function tasksCreate(Request $request, $qId = "null", $vId = "null")
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $inputs = $request->post();
                ///  $inputs['status'] = 1;
                $inputs['onDB'] = 'company_mysql';
                $inputs['qId'] = $qId;
                $inputs['vId'] = $vId;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $data = Task::insertOrUpdate($inputs);
                $id = !empty($data->id) ? ($data->id) : null;
                return response()->json(['status' => true, 'msg' => $this->pageTitle . 'Task has been created
                successfully', 'type' => 'attr', 'action' => "open = 'tasks'"], 200);
            }
            $userData = Task::userData();
            $view = view($this->viwePath . "tasks.create", ['userData' => $userData, 'route' => $this->route, 'activePage' => $this->activePage, 'qId' => $qId, 'vId' => $vId])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /**
     * newVersion Create Show In Quote Id Base
     */
    public function tasksdetails(Request $request, $id, $qId = "null", $vId = "null")
    {

        $taskData = Task::getData(['id' => $id])->firstOrFail();
        try {
            $userData = Task::userData();
            $view = view($this->viwePath . "tasks.details", ['userData' => $userData, 'route' => $this->route, 'activePage' => $this->activePage, 'qId' => $qId, 'vId' => $vId, 'data' => $taskData, 'id' => $id])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            //dd($th);
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }
    /**
     * newVersion Create Show In Quote Id Base
     */
    public function tasksEdit(Request $request, $id, $qId = "null", $vId = "null")
    {
        $taskData = Task::getData(['id' => $id])->firstOrFail();

        try {

            $userData = Task::userData();
            $view = view($this->viwePath . "tasks.edit", ['userData' => $userData, 'route' => $this->route, 'activePage' => $this->activePage, 'qId' => $qId, 'vId' => $vId, 'data' => $taskData, 'id' => $id])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            /*   dd($th); */
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    /*** @AjaxGet Data List*/
    public function notesList(Request $request, $qId = "null", $vId = "null")
    {

        $sort = !empty($request['sort']) ? $request['sort'] : '';
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
        $sqlData = QuoteNote::getData(['qId' => $qId]);
        if (!empty($parentId)) {
            $sqlData = $sqlData->where('quote_notes.id', $parentId)->orWhere('quote_notes.parent_id', $parentId);
        } else {
            $sqlData = $sqlData->where('show_status', '=', 1);
        }
        if (!empty($statusVal)) {
            $sqlData = $sqlData->whereIn('quote_notes.status', $statusVal);
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
                    if (!empty($qId)) {
                        $subject = "<a href='javasacript:void(0)' x-on:click=detailsNotes('{$row['id']}')>{$subject}</a>";
                    } else {
                        $subject = "<a href='{$editUrl}' data-turbolinks='false'>{$subject}</a>";
                    }

                } else {
                    $subject = "<a href='javasacript:void(0)' class='taskDataGet' data-id='{$row['id']}'>{$subject}</a>";
                }
                $dataArr[] = [
                    "created_at" => changeDateFormat($row?->created_at),
                    "updated_at" => changeDateFormat($row?->updated_at),
                    "username" => $row?->user?->name ?? null,
                    "description" => $row?->description,
                    "subject" => "<a href='{$editUrl}' data-turbolinks='false'>{$subject}</a>",

                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }

    /** request-activation*/
    public function requestActivation(Request $request, $qId = "null", $vId = "null")
    {

        $userData = $request->user();
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;


        try {
            if($userType != User::AGENT && $userType != User::COMPANYUSER){
                throw new Error("Invalid User");
            }




            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            if($userType == User::COMPANYUSER){
                $input = $request->all();
                $input['activePage'] = $this->activePage;
                $this->model::underwritingVerification($qId,$quoteData,$input);
                return response()->json(['status' => true,
                    'msg' => 'Underwriting Verification Successfully',
                    'url' => routeCheck($this->route . 'underwriting-edit-quote', $qId),
                ], 200);
            }

            $vId = $quoteData->vid;
            $quoteVersion = QuoteVersion::getData(['qId' => $qId, 'id' => $vId])->first();
            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Version Id");
            }

            $agentSignature = $quoteVersion?->agent_signature ?? 0;
            $isnuredSignature = $quoteVersion?->isnured_signature ?? 0;

            $attachmentData = Attachment::getData(['qId' => $qId, 'vId' => $vId, 'pfa' => 1])->count();
            if ((empty($agentSignature) && empty($isnuredSignature)) && empty($attachmentData)) {
                throw new Error("Agent signature and isnured signature not completed");
            }

            $statuStext     = 'Activation Requested';
            $message        = "{$statuStext} by {$userName} on {$currentDate}";
            $taskMessages   = 'Request for Activation for Quote <a href="' . routeCheck('company.quotes.edit', ['quote' => $qId]) . '">' . $quoteData->qid . '.' . $quoteVersion->version_id . '</a>';
            $taskSubject    = 'Request for Activation <a href="' . routeCheck('company.quotes.edit', ['quote' => $qId]) . '">' . $quoteData->qid . '.' . $quoteVersion->version_id . '</a>';

            /* quote Status update */
            $quoteData->status = $this->model::ACTIVEREQUEST;
            $quoteData->unlock_request = false;
            $quoteData->save();

            /* Task Create */
            $array = [
                'subject' => $taskSubject,
                'notes' => $taskMessages,
                'shedule' => now(),
                'priority' => 'High',
                'status' => 0,
                'view_status' => 1,
                'show_task',
                'qId' => $qId,
                'vId' => $vId,
                'user_type' => User::COMPANYUSER, User::ADMIN,
                'type' => 'request_activation',
                'type_id' => $qId,
                'logId' => $qId,
                'activePage' => $this->activePage,
            ];

            Task::insertOrUpdate($array);
            return response()->json(['status' => true, 'msg' => 'Request activation successfully', 'url' => routeCheck($this->route . "edit", $qId)], 200);
        } catch (\Throwable $th) {

            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function quoteRequestToUnlock(Request $request, $qId = "null", $vId = "null")
    {
        $userData = $request->user();
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;
        try {
           

            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }
            if ($userType != User::AGENT) 
                    throw new Error("Invalid User Type");
            

            $vId = $quoteData->vid;
            $quoteVersion = QuoteVersion::getData(['qId' => $qId, 'id' => $vId])->first();
            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Version Id");
            }

            $agentSignature = $quoteVersion?->agent_signature ?? 0;
            $version = $quoteVersion?->version_id ?? 0;
            $isnuredSignature = $quoteVersion?->isnured_signature ?? 0;

            $attachmentData = Attachment::getData(['qId' => $qId, 'vId' => $vId, 'pfa' => 1])->count();
            if ((empty($agentSignature) && empty($isnuredSignature)) && empty($attachmentData)) {
                throw new Error("Agent signature and isnured signature not completed");
            }

            $subject = 'Agent unlock quote request';
            $statuStext = 'Activation Requested Unlock';
            $message = 'Unlock request for activation by ' . $userName . ' on ' . $currentDate;
            $mailmessage = "Agent {$userName}, requested to reverse the request for activation. Click <a href='" . routeCheck('company.quotes.edit', ['quote' => $qId]) . "'>{$quoteData->qid}.{$quoteVersion->version_id}</a> to UNLOCK the quote";

            $toId = User::getData(['type' => User::COMPANYUSER])->orderBy('created_at', 'asc')->first()?->id;

            //  $quoteData->status = $this->model::ACTIVEREQUEST;
            $quoteData->unlock_request = true;
            //$quoteData->unlock_request = true;
            $quoteData->save();

            /* Task Create */
            $inserArr = [
                'from_id' => $userId,
                'to_id' => $toId,
                'subject' => $subject,
                'qid' => $qId,
                'vid' => $vId,
                'version' => $version,
                'message' => $mailmessage,
                // 'logId'         => $qId,
                'activePage' => $this->activePage,
            ];
            $data = Message::insertOrUpdate($inserArr);

            Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);
            return response()->json(['status' => true, 'msg' => 'Activation Unlock Request Send Successfully', 'url' => routeCheck($this->route . "edit", $qId)], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function financeUnlockQuote(Request $request, $qId = "null")
    {
        $userData = $request->user();
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;
        $type = $request->type;
        try {

            $quoteData = $this->model::getData(['id' => $qId])->where('status', $this->model::ACTIVEREQUEST)->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $vId = $quoteData?->vid;
            $version = $quoteData?->version;
            $agentData = $quoteData?->agent_user;
            $agentName = $quoteData?->agent_data?->name;
            $agentEmail = $quoteData?->agent_data?->email;


        if ($type == 'unlock') {
                $message = 'Quote is unlocked by ' . $userName . ' on ' . $currentDate;
                $mailmessage = 'Reason : ' . $request->reason . '<br>';
                $mailmessage .= $request->note;
                $subject = 'Unlock Quote Request - Completed';
                $resMsg = "Quote is unlocked.";

                $quoteData->status = $this->model::NEW;
                $quoteData->unlock_request = false;
                $quoteData->save();

            } else {
                $message = 'Removed the request for activation by ' . $userName . ' on ' . $currentDate;
                $mailmessage = "Your request to unlock Quote #" . $quoteData->qid . "." . $quoteData->version . " was canceled.";
                $subject = 'Agent unlock quote request canceled';
                $resMsg = "Remove the request for activation successfully.";

                $quoteData->unlock_request = false;
                $quoteData->save();
            }

            $toId = $agentData->id;

            $inserArr = [
                'from_id' => $userId,
                'to_id' => $toId,
                'subject' => $subject,
                'qid' => $qId,
                'vid' => $vId,
                'version' => $version,
                'message' => $mailmessage,
                'activePage' => $this->activePage,
            ];
            $data = Message::insertOrUpdate($inserArr);
            Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);

            return response()->json(['status' => true, 'msg' => $resMsg, 'singleurl' => routeCheck($this->route . "edit", $qId)], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function quoteApprove(Request $request, $qId = "null")
    {


        try {
            $inputs = $request->all();
            $inputs['activePage'] = $this->activePage;
            $inputs['route'] = $this->route;
           
            $quoteData = $this->model::quoteApproved($qId,$inputs);


            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            return response()->json($quoteData, 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function quoteDecline(Request $request, $qId = "null")
    {
        $userData = $request->user();
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;
        $type = $request->type;
        $reason = $request->note;
        try {

            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $vId            = $quoteData?->vid;
            $version        = $quoteData?->version;
            $agentData      = $quoteData?->agent_user;
            $agentName      = $quoteData?->agent_data?->name;
            $agentEmail     = $quoteData?->agent_data?->email;


            $message = 'Decline by ' . $userName . ' on ' . $currentDate;
            $mailmessage = " <a href='" . routeCheck('company.quotes.edit', ['quote' => $qId]) . "'>Please Click to view the quote</a>";
            $subject = 'Quote Decline';
            $resMsg = "Quote is Decline.";
            $quoteData->status = $this->model::DECLINE;
            $quoteData->decline_reason = $reason;
            $quoteData->unlock_request = false;
            $quoteData->save();

            $toId = $agentData->id;

            $inserArr = [
                'from_id' => $userId,
                'to_id' => $toId,
                'subject' => $subject,
                'qid' => $qId,
                'vid' => $vId,
                'version' => $version,
                'message' => $mailmessage,
                'activePage' => $this->activePage,
            ];
            $data = Message::insertOrUpdate($inserArr);
            Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);
            return response()->json(['status' => true, 'msg' => $resMsg, 'url' => routeCheck($this->route . "edit", $qId)], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function underwritingVerification(Request $request, $qId = "null")
    {


        try {

            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $input = $request->all();
            $input['activePage'] = $this->activePage;
            $this->model::underwritingVerification($qId,$quoteData,$input);



            return response()->json(['status' => true,
                'msg' => 'Underwriting Verification Successfully',
                'url' => routeCheck($this->route . 'underwriting-edit-quote', $qId),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function underWritingInformationSave(Request $request, $qId = "null")
    {
        $msg = $isPercentage = $isDoller = "";
        $userData = $request->user();
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;
        $type = $request->type;
        $titleArr = !empty($request->titleArr) ? json_decode($request->titleArr, true) : '';
        try {

            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }

            $vId = $quoteData?->vid;

            $quoteVersion = QuoteVersion::getData(['qId' => $qId, 'id' => $vId])->first();
            if (empty($quoteVersion)) {
                throw new Error("Invalid Quote Version Id");
            }

            $version = $quoteData?->version;
            $agentData = $quoteData?->agent_user;
            $agentName = $quoteData?->agent_data?->name;
            $agentEmail = $quoteData?->agent_data?->email;

            $inputs = $request->except(['company_data', '_token', 'titleArr']);
            $inputs = arrFilter($inputs);
            $inputJson = json_encode($inputs);

            $quoteVersion = QuoteVersion::getData()->updateOrcreate(['id' => $vId], ['underwriting_informations' => $inputJson]);
            // dd( $quoteVersion);
            $changesArr = $quoteVersion?->changesArr;
            $changesArr = !empty($changesArr['underwriting_informations']) ? $changesArr['underwriting_informations'] : [];
            $old = !empty($changesArr['old']) ? json_decode($changesArr['old'], true) : [];
            $new = !empty($changesArr['new']) ? json_decode($changesArr['new'], true) : [];

            $arrayDiff = array_diff_assoc($old, $new);
            $arrayDiff = empty($arrayDiff) ? array_diff_assoc($new, $old) : $arrayDiff;

            if (!empty($arrayDiff)) {
                foreach ($arrayDiff as $key => $value) {
                    $old = !empty($old[$key]) ? $old[$key] : '';
                    $new = !empty($new[$key]) ? $new[$key] : '';
                    $new = !empty($new) ? $new : 'None';
                    $title = !empty($titleArr[$key]['title']) ? $titleArr[$key]['title'] : '';
                    $class = !empty($titleArr[$key]['class']) ? $titleArr[$key]['class'] : '';
                    $tagType = !empty($titleArr[$key]['tagType']) ? $titleArr[$key]['tagType'] : '';
                    $optArray = !empty($titleArr[$key]['optionArr'][$key]) ? $titleArr[$key]['optionArr'][$key] : '';

                    if (Str::contains($class, ['percentage_input', 'percentageinput']) && $tagType != 'select') {
                        $isPercentage = "%";
                        $old = ($old) . $isPercentage;
                        $new = ($new) . $isPercentage;
                    } elseif (Str::contains($class, ['amount']) && $tagType != 'select') {
                        $isDoller = "$";
                        $old = floatval($old);
                        $new = floatval($new);
                        $old = $isDoller . number_format($old, 2);
                        $new = $isDoller . number_format($new, 2);
                    } elseif ($tagType == 'select') {
                        $old = isset($optArray[$old]) ? $optArray[$old] : '';
                        $new = isset($optArray[$new]) ? $optArray[$new] : '';
                    }

                    if (empty($old)) {
                        $msgTitle = "<li> {$title} was updated to <b>{$new}</b> </li>";
                    } else {
                        $msgTitle = "<li> {$title} was changed from <b>{$old}</b> to <b>{$new}</b> </li>";
                    }
                    $msg .= isset($logsArr[$key]) ? "" : removeWhiteSpace($msgTitle);
                }
            }
            !empty($msg) && Logs::saveLogs(['type' => "{$this->activePage}-underwriting", 'user_id' => $userId, 'type_id' => $quoteVersion->id, 'message' => $msg]);
            return response()->json(['status' => true, 'msg' => "Save Successfully"], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

    /** request-activation unlock */
    public function aggregateLimitStatus(Request $request, $qId = "null")
    {
        $userData = $request->user();
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $userName = $userData?->name;
        $currentDate = $request->current_date;
        $type = $request->type;
        try {

            $quoteData = $this->model::getData(['id' => $qId])->first();
            if (empty($quoteData)) {
                throw new Error("Invalid Quote Id");
            }



            $vId = $quoteData?->vid;

            if($type == 'approve'){
                $limitStatus    = 2;
                $text           = 'Approved of aggregate limit request';
                $statusmessage  = 'Quote Approved of aggregate limit request.';
            }else if($type == 'decline'){
                $limitStatus    = 3;
                $text           = 'Declined of aggregate limit request';
                $statusmessage  = 'Quote Declined of aggregate limit request.';
            }
            $quoteData->aggregate_limit_approve = $limitStatus;
            $quoteData->save();


            $message = "{$text} by {$userName} on {$currentDate}";
            Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);

            return response()->json(['status' => true, 'msg' =>$statusmessage, 'url' => routeCheck($this->route . "edit", $qId)], 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 200);
        }

    }

}
