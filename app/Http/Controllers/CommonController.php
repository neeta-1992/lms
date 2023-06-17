<?php

namespace App\Http\Controllers;

use App\Helpers\ReplaceShortcodes;


use App\Models\{
    NoticeTemplate,User,MetaTag,Entity,ProspectContact,Logs,MessageFile,Quote,QuoteAccount,Payment
};
use Illuminate\Http\Request;
use Str,DB;

class CommonController extends Controller
{

    public function userDetails(Request $request){
        $eId = $request->eId;
        if(!empty($eId)){
            $f['entityId'] = $eId;
        }

        $userData = !empty($f) ?  User::getData($f)->with('entity')->first() : null;
        if(!empty($userData)){
         
            $userData  = [
                'username'          => $userData->username,
                'first_name'        => $userData->first_name,
                'middle_name'       => $userData->middle_name,
                'last_name'         => $userData->last_name,
                'email'             => $userData->email,
                'mobile'            => $userData->mobile,
                'entity_name'       => $userData->entity?->name,
                'mailing_address'   => $userData->entity?->mailing_address,
                'mailing_city'      => $userData->entity?->mailing_city,
                'mailing_state'     => $userData->entity?->mailing_state,
                'mailing_zip'       => $userData->entity?->mailing_zip,
                'mailing_address'   => $userData->entity?->mailing_address,
                'mailing_address'   => $userData->entity?->mailing_address,
                'name'              => $userData->name,
            ];
        }

        return  $userData;
    }

    public function fileUplode(Request $request)
    {
        $file = $request->file('file');
       // $ismultiple = $request->file('ismultiple');
        $accept = $request->post('accept');
        $file_path = $request->post('file_path');
        $accept = !empty($accept) ? explode(",", $accept) : [];




        $validate = $request->validate([
            'file' => "required|file",
        ]);


        $errorMsg = null;
        $fileName = $file->getClientOriginalName();

        $fileName       = removeWhiteSpace($fileName);
        $fileName       = Str::replace(' ', '_', $fileName);
        $fileName       = Str::replace('-', '', $fileName);
        $fileExtension  = $file->getClientOriginalExtension();
        $fileRealPath   = $file->getRealPath();
        $fileSize       = $file->getSize();
        $fileSize = round($fileSize / (1024 * 1024), 2);
        if ($fileSize > 8) {
            $errorMsg = "Sorry, maximum file size allowed is 8 MB";
        }
        $fileMimeType = $file->getMimeType();
        if (!empty($accept) && !in_array(".{$fileExtension}", $accept)) {
            $errorMsg = "Sorry, this file type is not permitted for security reasons.";
        }

        $uploadFileName = time().date("Ymdhis").'-'.$fileName;
        try {

            $uploadPath = public_path("uploads/{$file_path}");
            empty($errorMsg) && $file->move($uploadPath, $uploadFileName);
        } catch (\Throwable$th) {
            $errorMsg = "Sorry, there was an error uploading your file.";
        }

        if(!empty($errorMsg)){
            $html = '<div class="flow-progress media">
                <div class="media-body">
                    <div><strong class="flow-file-name">'.$fileName.'</strong> <br> <em
                            class="flow-file-progress text-danger">('.$errorMsg.')</em></div>
                </div>
                <div class="ml-3 align-self-center"><button type="button" class="flow-file-cancel btn btn-sm removeUploedFile"
                        data-file-name="'.$file_path.'/'.$uploadFileName.'" data-type="'.($file_path == 'message' ? 'mail' : "").'"><i class="fal fa-times-circle"></i></button></div>
            </div>';
            $status = false;
        }else{
            $html = '<div class="flow-progress media">
                <div class="media-body">
                    <div><strong class="flow-file-name">' . $fileName . '</strong> <br> <em
                            class="flow-file-progress text-success">(file successfylly uploaded: )</em></div>
                </div>
                <div class="ml-3 align-self-center"><button type="button"
                        class="flow-file-cancel btn btn-sm removeUploedFile"
                        data-file-name="'.$file_path.'/'.$uploadFileName.'" data-type="'.($file_path == 'message' ? 'mail' : "").'"><i class="fal fa-times-circle"></i></button>
                        </div>
            </div>';
            $status = true;
        }

        return response()->json(['status'=>$status,'msg'=>$html,'imageName'=>$file_path.'/'.$uploadFileName ], 200);
    }


    public function removeFile(Request $request){
        $image = $request->post('image');
        $imageid = $request->post('imageid');
        $imageType = $request->post('imageType') ?? '';
        $file = public_path("uploads/{$image}");;
        try {
            if(file_exists($file)){
                unlink($file);
            }

            if(!empty($imageid) && $imageType == 'mail'){
                DB::beginTransaction();
                MessageFile::getData()->whereId($imageid)->delete();
                DB::commit();
            }

            if($imageType == 'mail'){
                DB::beginTransaction();
                MessageFile::getData()->whereEn('file_name',$image)->delete();
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollback();
        }
        return response()->json(['status'=>true,'msg'=>""], 200);
    }


    /*
     *@ Model NoticeTemplate Get Data
     */
    public function noticeTemplateData(Request $request, $type = null, $action = null, $noticeType = null)
    {
      
        try {
            $companyData = $request->company_data;
            $id = $request->id;
           /*  dd( $data['template_text']); */
            $data = NoticeTemplate::getData(['type' => $type, 'noticeType' => $noticeType, 'action' => $action, 'id' => $id])->first();
            if(empty($data) && !empty($type)){
                $data = NoticeTemplate::getData(['type' => 'any', 'noticeType' => $noticeType, 'action' => $action, 'id' => $id])->first();
            /* dd( $data); */
            }
            $style = MetaTag::getData(['key' => 'css', 'type' => "notice-templates"])->first();
            $style = !empty($style->value) ? $style->value : '' ;
            
            $data['template_text'] = !empty($data->template_text) ? ReplaceShortcodes::companyTemplate($data->template_text, $companyData, $data) : '';
        
            return response()->json(["status" => true, 'result' => $data, 'style' => $style], 200);
        } catch (\Throwable $th) {
          /*    dd($th); */
               return $th->getMessage(); 
        }
    }

    /* sales-organization List */
    public function entityList(Request $request,$type=null)
    {
        $agency = $request->agency;
        $istype = $request->istype;
        $requestType = $type;
        try {
            switch ($type) {
                case 'sales-organization':
                    $type = Entity::SALESORG;
                    break;
                case 'agency':
                    $type = Entity::AGENT;
                    break;
                case 'insured':
                    $type = Entity::INSURED;
                    break;
				case 'insurance_company':
                    $type = Entity::INSURANCECOMPANY;
                    break;
				case 'general_agent':
                    $type = Entity::GENERALAGENT;
                    break;
                default:
                    $type = 'null';
                    break;
            }
            $data = Entity::getData(['type' => $type,'search'=>$request->search,'agency'=>$agency])->get(['name','id as value','name as text'])?->makeHidden(['upload_agency_ec_insurance_url'])?->toArray();
          
            if(($requestType == 'insurance_company' || $requestType ==  'general_agent') && empty($data) && $istype == 'quote'){
                $data[] = ['name' => $request->search,'value' => $request->search,"text"=>$request->search];
            } 
            return response()->json(['success'=>true,'results'=>$data], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    /* Office wish Role*/
    public function officeWishRole(Request $request){
        $office     = $request->post('office');
        $userId = $request->post('userId') ;
        $userData = User::getData(['dId'=>$userId])->first();
        $userAdmin =!empty($userData?->role) ? $userData?->role : 0 ;
        $officeData = User::getData(['office'=>$office])->first();
        $admin = !empty($officeData?->role) ? $officeData?->role : 0 ;
        if($admin == 1 && $userAdmin == 2){
            $role = [2=>'User'];
        }else{
             $role = [1=>'Adminstrator',2=>'User'];
        }
        return response()->json(['status'=>true,'role'=> $role], 200);
    }


    /* Office wish Role*/
    public function prospectOfficeWishRole(Request $request){
        $office     = $request->post('office');
        $userId = $request->post('userId') ;
        $userData = ProspectContact::getData(['dId'=>$userId])->first();
        $userAdmin =!empty($userData?->role) ? $userData?->role : 0 ;
        $officeData = ProspectContact::getData(['office'=>$office])->first();
        $admin = !empty($officeData?->role) ? $officeData?->role : 0 ;
        if($admin == 1){
            $role = [2=>'User'];
        }else{
             $role = [1=>'Adminstrator',2=>'User'];
        }
        return response()->json(['status'=>true,'role'=> $role], 200);
    }


    /* User Status Chnage */
    public function userStatusChange(Request $request){
        $id = $request->post('id');
        $type = $request->post('type');
        $id = !empty($id) ? $id : 'null';
        $user_id = auth()->user()?->id ;
        $userData = User::getData(['dId'=>$id])->first();
        if($type == "spend"){
            $spend = $userData?->suspend ?? 0;
            if($spend == 1){
                $msg = "Account  unsuspend";
                $spendStatus = 0;
            }else{
                $msg = "Account suspended";
                $spendStatus = 1;
            }

            $userData->update(['suspend'=>$spendStatus ]);


            Logs::saveLogs([
                'type'      =>'find-user',
                'user_id'   =>$user_id,
                'type_id'   =>$userData->id,
                'uId'       =>$userData->id,
                'message'   =>$msg
            ]);
        }
        return response()->json(['status'=>true]);
    }


    public function mailSendUser(Request $request){
        $userData               = auth()->user();

        $userId                 = $userData?->id;
        $userType               = $userData?->user_type;
        $entityId               = $userData?->entity_id;
        $userRole               = $userData?->role;
        $role                   = $request->role ;
        $qId                    = $request->qId ;
        $companyUser            = User::COMPANYUSER;
        $adminUser              = User::ADMIN;
        $insuredsUser           = User::INSURED;
        $agentsUser             = User::AGENT;
        $salesOrganizationsUser = User::SALESORG;
        $roleArr = [
            'finance_companies'     => $companyUser,
            'lms_support'           => $adminUser,
            'insureds'              => $insuredsUser,
            'agents'                => $agentsUser,
            'sales_organizations'   => $salesOrganizationsUser,
        ];

        $roleRequest = !empty($role) ? $roleArr[$role] : null;
        $filtter = [];

        $userSql    =  User::getData();
        $quoteAgency= $quoteInsured = null;
        if(!empty($qId)){
            $quoteData = Quote::getData(['id'=>$qId])->first();
            $quoteAgency = !empty($quoteData->agency) ? $quoteData->agency : '';
            $quoteInsured = !empty($quoteData->insured) ? $quoteData->insured : '';
        }


        if($userType == User::ADMIN){

            if(!empty($qId)){
                if(!empty($roleRequest)){
                    if($roleRequest == $insuredsUser){
                        $userSql = $userSql->where('entity_id',$quoteInsured);
                    }
                    if($roleRequest == $agentsUser){
                        $userSql = $userSql->where('entity_id',$quoteAgency);
                    }
                    if($roleRequest == $companyUser){
                        $userSql = $userSql->where('user_type',$companyUser)->where('role',1);
                    }
                }else{
                    $userSql = $userSql->where('user_type',$companyUser)->where('role',1);
                    $userSql = $userSql->orwhere(function($q) use($quoteAgency,$quoteInsured) {
                        $q->orwhere('entity_id',$quoteAgency)->orwhere('entity_id',$quoteInsured);
                    });
                }
            }else{
                $userSql = $userSql->where('user_type',$companyUser)->where('role',1);
            }

        }elseif($userType == $companyUser && $userRole == 1){
            if(!empty($roleRequest)){
                if($roleRequest == $insuredsUser){
                    $userSql = $userSql->where('user_type',$insuredsUser);
                }elseif($roleRequest == $agentsUser){
                    $userSql = $userSql->where('user_type',$agentsUser);
                }elseif($roleRequest == $salesOrganizationsUser){
                    $userSql = $userSql->where('user_type',$salesOrganizationsUser);
                }elseif($roleRequest == $companyUser){
                    $userSql = $userSql->where('user_type',$companyUser);
                }elseif($roleRequest == $adminUser){
                    $userSql = $userSql->where('user_type',$adminUser);
                }
            }else{
                $userSql = $userSql->where(function($q) use($companyUser,$adminUser,$insuredsUser,$agentsUser,$salesOrganizationsUser) {
                    $q->where('user_type',$companyUser)
                    ->orWhere('user_type',$adminUser)
                    ->orWhere('user_type',$insuredsUser)
                    ->orWhere('user_type',$agentsUser)
                    ->orWhere('user_type',$salesOrganizationsUser);
                });
            }
        }elseif($userType == $companyUser && $userRole == 2){
            $userSql = $userSql->whereNot('id',$userId);
            if(!empty($roleRequest)){
                if($roleRequest == $insuredsUser){
                    $userSql = $userSql->where('user_type',$insuredsUser);
                }elseif($roleRequest == $agentsUser){
                    $userSql = $userSql->where('user_type',$agentsUser);
                }elseif($roleRequest == $salesOrganizationsUser){
                    $userSql = $userSql->where('user_type',$salesOrganizationsUser);
                }elseif($roleRequest == $companyUser){
                    $userSql = $userSql->where('user_type',$companyUser);
                }
            }else{
                $userSql = $userSql->where(function($q) use($companyUser,$adminUser,$insuredsUser,$agentsUser,$salesOrganizationsUser) {
                    $q->where('user_type',$companyUser)
                    ->orWhere('user_type',$insuredsUser)
                    ->orWhere('user_type',$agentsUser)
                    ->orWhere('user_type',$salesOrganizationsUser);
                });
            }
        }elseif($userType == $agentsUser){
            $agencyIds = Entity::getData(['agency'=>$entityId])->get()?->pluck('id')?->toArray();
            $agencyIdSalesOrg = Entity::getData(['id'=>$entityId])->first();
            $salesOrganizationId = !empty($agencyIdSalesOrg->sales_organization) ? $agencyIdSalesOrg->sales_organization : '' ;
            $userSql = $userSql->whereNot('id',$userId);
            if(!empty($roleRequest)){
                if($roleRequest == $insuredsUser){
                    $userSql = $userSql->where('user_type',$insuredsUser)->whereIN('entity_id',$agencyIds);
                }elseif($roleRequest == $agentsUser){
                    $userSql = $userSql->where('user_type',$agentsUser)->where('entity_id',$entityId);
                }elseif($roleRequest == $salesOrganizationsUser){
                    $userSql = $userSql->where('user_type',$salesOrganizationsUser)->where('entity_id',$salesOrganizationId);
                }elseif($roleRequest == $companyUser){
                    $userSql = $userSql->where('user_type',$companyUser)->where('role',2);
                }
            }else{
                $userSql = $userSql->where(function($q) use($agencyIds,$insuredsUser,$entityId,$agentsUser,$salesOrganizationId,$salesOrganizationsUser,$companyUser) {
                    $q->where('user_type',$insuredsUser)->whereIN('entity_id',$agencyIds)
                    ->orwhere(function($q) use($entityId,$agentsUser) {
                        $q->where('user_type',$agentsUser)->where('entity_id',$entityId);
                    })->orwhere(function($q) use($salesOrganizationId,$salesOrganizationsUser) {
                        $q->where('user_type',$salesOrganizationsUser)->where('entity_id',$salesOrganizationId);
                    })->orwhere(function($q) use($agencyIds,$companyUser) {
                        $q->where('user_type',$companyUser)->where('role',2);
                    });
                });
            }
        }elseif($userType == $insuredsUser){
            $userSql = $userSql->whereNot('id',$userId);
            $agencyIds = Entity::getData(['id'=>$entityId])->first()?->agency ?? 'null';
            if(!empty($roleRequest)){
                if($roleRequest == $insuredsUser){
                    $userSql = $userSql>where('user_type',$insuredsUser)->where('entity_id',$entityId);
                }elseif($roleRequest == $agentsUser){
                    $userSql = $userSql->where('user_type',$agentsUser)->where('entity_id',$agencyIds);
                }
            }else{
                $userSql = $userSql->where(function($q) use($entityId,$insuredsUser,$agencyIds,$agentsUser) {
                    $q->where('user_type',$insuredsUser)->where('entity_id',$entityId)
                    ->orwhere(function($q) use($agencyIds,$agentsUser) {
                        $q->where('user_type',$agentsUser)->where('entity_id',$agencyIds);
                    });
                });
            }
        }elseif($userType == $salesOrganizationsUser){
            $agencyIds = Entity::getData(['salesOrganization'=>$entityId])->get()?->pluck('id')?->toArray() ?? [];
            $userSql = $userSql->whereNot('id',$userId);
           /*  dd($roleRequest); */
            if(!empty($roleRequest)){
                if($roleRequest == $companyUser){
                    $userSql = $userSql->where('user_type',$companyUser)->where('role',2);
                }elseif($roleRequest == $salesOrganizationsUser){
                    $userSql = $userSql->where('user_type',$salesOrganizationsUser)->where('entity_id',$entityId);
                }elseif($roleRequest == $agentsUser){
                    $userSql = $userSql->where('user_type',$agentsUser)->whereIn('entity_id',$agencyIds);
                }
            }else{
                $userSql = $userSql->where(function($q) use($agencyIds,$companyUser,$agentsUser,$entityId,$salesOrganizationsUser) {
                    $q->where('user_type',$companyUser)->where('role',2)
                    ->orwhere(function($q) use($agencyIds,$agentsUser) {
                        $q->where('user_type',$agentsUser)->whereIn('entity_id',$agencyIds);
                    })->orwhere(function($q) use($entityId,$salesOrganizationsUser) {
                        $q->where('user_type',$salesOrganizationsUser)->where('entity_id',$entityId);
                    });
                });
            }
        }





        $data = $userSql->get();
        $newArray =[];$textName="";
        if(!empty($data)){
            foreach ($data as $key => $user) {
               $value = $user->name;
               $id = $user->id;
               $text = $user->name;
               $userType = $user->user_type;
               if($userType == User::ADMIN){
                    $textName = "";
                    $value = "LMS Support";
                    $color = "text-dark";
               }elseif($userType == User::COMPANYUSER){
                    $textName = "";
                    $color = "text-success";
               }elseif($userType == User::AGENT){
                    $textName = "@ ".$user?->entity?->name;
                    $color = "text-info";
               }elseif($userType == User::SALESORG){
                    $textName = "@ ".$user?->entity?->name;
                    $color = "text-warning";
               }elseif($userType == User::INSURED){
                    $textName = "@ ".$user?->entity?->name;
                $color = "text-danger";
               }

               $newArray[] = [
                  "name" => "<span class='{$color}'>{$value} {$textName}</span>",
                  "value" => $id,
                  "id"      => $id,
                  "text" => $value." ".$textName,
                  "class" => $color,
               ];
            }
        }

/*  dd( $newArray); */
        return response()->json(['success'=>true,'results'=>$newArray], 200);
    }



    public function getPaymentDetails(Request $request){
         
        $type = $request->type;
        $qId = $request->quoteId;
        $accountId = $request->accountId;

        if(!empty($qId)){
            $quoteData = Quote::getData(['id'=>$qId])->first();

        }

        if(!empty($accountId)){
            $data = QuoteAccount::getData(['id'=>$accountId])->first();
            $quoteData    = $data?->q_data;
            $userData     = $data?->insured_user;
            $entityData   = $data?->insur_data;
        }

        $res  = [
            'bank_name'   => $data?->bank_name ?? '',
            'bank_routing_number'   => $data?->bank_routing_number ?? '',
            'bank_account_number'   => $data?->bank_account_number ?? '',
            'payment_method_account_type'   => $data?->payment_method_account_type ?? '',
            'card_holder_name'      => $data?->card_holder_name ?? '',
            'card_number'           => $data?->card_number ?? '',
            'end_date'              => $data?->end_date ?? '',
            'cvv'                   => $data?->cvv ?? '',
            'mailing_firstname'       => $data?->mailing_firstname ?? '',
            'mailing_lastname'          => $data?->mailing_lastname ?? '',
            'mailing_address'       => $data?->mailing_address ?? '',
            'mailing_city'          => $data?->mailing_city ?? '',
            'mailing_state'         => $data?->mailing_state ?? '',
            'mailing_zip'           => $data?->mailing_zip ?? '',
            'cardholder_email'      => $data?->cardholder_email ?? '',
            'cardholder_email'      => $data?->cardholder_email ?? '',
            'account_name'          => $data?->account_name ?? '',
            'mailing_email'         => $data?->mailing_email ?? '',
        ];


        if(!empty($entityData)){
             if(empty($res['mailing_address'])){
                $res['mailing_address'] = $entityData?->mailing_address;
                $res['mailing_city'] = $entityData?->mailing_city;
                $res['mailing_state'] = $entityData?->mailing_state;
                $res['mailing_zip'] = $entityData?->mailing_zip;
             }
        }

        if(!empty($userData)){
            if(empty($res['mailing_firstname'])){
                $res['mailing_firstname'] = $userData->first_name;
                $res['mailing_lastname'] = $userData->last_name;
            }
            if(empty($res['mailing_telephone'])){
                $res['mailing_telephone'] = $userData->mobile;
            }
        }

        if($type == 'credit_card' && empty($res['card_holder_name'])){
            $res['cardholder_email'] = $userData->email;
            $res['card_holder_name'] = $userData->name;
          
        }
       
        if(empty($res['account_name'])){
            $res['account_name'] =  $userData->name;
        }


       return $res;

    }



    public function userList(Request $request){

        try {
            $type       = $request->type;
            $dropdown   = $request->dropdown;
            $search     = $request->search;
            $userArr    = [];
           // $data = User::getData()->get();
            if($type == 'payment_user'){
                 $userList =  Payment::getData(['status' => 0])
                ->select('users.first_name as first_name','users.last_name as last_name','users.middle_name as middle_name','users.id as user_id')
                ->join('users','users.id','payments.user_id');
                if(!empty($search)){
                    $userList =  $userList->where(function($q) use($search) {
                        return $q->whereLike('users.first_name',$search)
                                ->orwhereLike('users.last_name',$search)
                                ->orwhereLike('users.middle_name',$search) ;
                    });
                }
                $userList =  $userList->groupBy('payments.user_id')
                ->get();
              
                if(!empty($userList) && !empty($dropdown)){
                    foreach ($userList as $key => $row) {
                        $fname  = !empty($row?->first_name) ? decryptData($row?->first_name) : '';
                        $mname  = !empty($row?->middle_name) ? decryptData($row?->middle_name) : '';
                        $lname  = !empty($row?->last_name) ? decryptData($row?->last_name) : '';

                        $userArr[] =  [
                            "name"  => removeWhiteSpace("{$fname} {$mname} {$lname}"),
                            "value" => $row?->id,
                            "text"  => removeWhiteSpace("{$fname} {$mname} {$lname}"),
                        ];
                    }
                }
            }
            return response()->json([ "success" => true,'results'=>$userArr], 200);
          
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
