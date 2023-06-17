<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,CoverageType,Entity,Quote,QuoteTerm,QuoteSetting,QuoteVersion,Payable,Task
};
use App\Traits\ModelAttribute;
class QuotePolicy extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
   // use EncryptedAttribute;

    protected $fillable = [
        'user_id','quote','version','first_installment_date','first_payment_due_date',
        'payment_due_days','policy_number',
        'inception_date','insurance_company','general_agent',
        'broker','coverage_type','pure_premium',
        'minimum_earned','cancel_terms','policy_term','policy_fee',
        'taxes_and_stamp_fees','broker_fee','inspection_fee','doc_stamp_fees',
        'short_rate','auditable','puc_filings','notes',
        'total','down_payment','down_payment_increase','quote','expiration_date',
        'version','unearned_fees','earned_fees','effective_cancel_date','required_earning_interest'
    ];



    public function quote_data()
    {
        return $this->belongsTo(Quote::class, 'quote', 'id');
    }


    public function version_data()
    {
        return $this->belongsTo(QuoteVersion::class, 'version', 'id');
    }



    public function coverage_type_data()
    {
        return $this->hasOne(CoverageType::class, 'id','coverage_type');
    }


    public function insurance_company_data()
    {
        return $this->hasOne(Entity::class, 'id','insurance_company')->where('type',Entity::INSURANCECOMPANY);
    }

    public function general_agent_data()
    {
        return $this->hasOne(Entity::class, 'id','general_agent')->where('type',Entity::GENERALAGENT);
    }


    public function payable()
    {
        return $this->belongsTo(Payable::class, 'id','policy_id');
    }



    public static function insertOrUpdate(array $array)
    {
		$quoteSetting      = QuoteSetting::getData()->first();
        $id                 = !empty($array['id']) ? $array['id'] : '';
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logJson            = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $titleArr           = !empty($array['titleArr']) ? json_decode($array['titleArr'],true) : null ;
        $logId              = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        $onlyPolicy         = !empty($array['onlyPolicy']) ? $array['onlyPolicy'] : false ;
        $isLogMsg           = !empty($array['isLogMsg']) ? $array['isLogMsg'] : false ;
        $createInsuranceCompany =  $createGeneralAgent = $createBroker = false;
       // $insurance_company         = !empty($array['insurance_company']) ? $array['insurance_company'] : false ;
       // $onlyPolicy         = !empty($array['general_agent']) ? $array['isLogs'] : false ;
       $taskSubject = $taskMessages = '';
        if(!empty($array['insurance_company'])){
           $insuranceCompany = Entity::getData(['id' =>$array['insurance_company'],'type'=> Entity::INSURANCECOMPANY])->first();
           if(empty($insuranceCompany)){
                // Create new  insurance company
                $insuranceArr = [
                    'name'    =>  $array['insurance_company'],
                    'type'    =>  Entity::INSURANCECOMPANY,
                    'status'  =>  Entity::TEMPORARY,
                    'logId'   =>  isset($array['quote']) ? $array['quote'] : '',
                    'activePage'  => $activePage,
                ];
                $insuranceData = Entity::insertOrUpdate($insuranceArr);
                $array['insurance_company'] = $insuranceData?->id;      
                $createInsuranceCompany = true;
                $taskSubject .= "A temporary Insurance Company ";
                $taskMessages .=   " A temporary Insurance Company <a href='".routeCheck('company.insurance-companies.edit',$insuranceData?->id)."' data-turbolinks='false'>{$insuranceData?->name}</a>";
                
            }
        }
        
        if(!empty($array['general_agent'])){
           $generalAgent = Entity::getData(['id' =>$array['general_agent'],'type'=> Entity::GENERALAGENT])->first();
           if(empty($generalAgent)){
            // Create new  general agent
                $generalAgentArr = [
                    'name'    =>  $array['general_agent'],
                    'type'    =>  Entity::GENERALAGENT,
                    'status'  =>  Entity::TEMPORARY,
                    'logId'   =>  isset($array['quote']) ? $array['quote'] : '',
                    'activePage'  => $activePage,
                ];
                $generalAgentData = Entity::insertOrUpdate($generalAgentArr);     
                $array['general_agent'] = $generalAgentData?->id;
                $createGeneralAgent = true;
                $taskSubject .= !empty($taskSubject) ? 'and  General Agent created' : " A temporary General Agent";
                if(!empty($taskMessages)){
                    $taskMessages .=  " and General Agent <a href='".routeCheck('company.general-agents.edit',$generalAgentData?->id)."' data-turbolinks='false'>{$generalAgentData?->name}</a> is created";
                }else{
                    $taskMessages .=  " A temporary General Agent <a href='".routeCheck('company.general-agents.edit',$generalAgentData?->id)."' data-turbolinks='false'>{$generalAgentData?->name}</a>";
                }
              
                
           }
        }

    /*     if(!empty($array['general_agent'])){
           $generalAgent = Entity::getData(['id' =>$array['general_agent'],'type'=> Entity::GENERALAGENT])->first();
           if(empty($generalAgent)){
            // Create new  general agent
                $generalAgentArr = [
                    'name'    =>  $array['general_agent'],
                    'type'    =>  Entity::GENERALAGENT,
                    'status'  =>  Entity::TEMPORARY,
                    'logId'   =>  isset($array['quote']) ? $array['quote'] : '',
                    'activePage'  => $activePage,
                ];
                $generalAgentData = Entity::insertOrUpdate($generalAgentArr);     
                $array['general_agent'] = $generalAgentData?->id;
                $createGeneralAgent = true;
           }
        } */
      /*   dd($taskMessages ); */
        /* Create Task */
        if(($createGeneralAgent == true || $createInsuranceCompany == true) && !empty($taskMessages)){
           
            /* Task Create */
            $teskArray = [
                'subject'       => $taskSubject,
                'notes'         => $taskMessages,
                'shedule'       => now(),
                'priority'      => 'High',
                'status'        => 0,
                'view_status'   => 1,
                'show_task'     => 1,
                'qId'           => isset($array['quote']) ? $array['quote'] : '',
                'vId'           => isset($array['version']) ? $array['version'] : '',
                'user_type'     => User::COMPANYUSER,
                'type'          => 'quote',
                'type_id'       => isset($array['quote']) ? $array['quote'] : '',
                'logId'         => isset($array['quote']) ? $array['quote'] : '',
                'activePage'    => $activePage,
            ];

            Task::insertOrUpdate($teskArray);
        }
       

		if(isset($array['quote'])){
			$quoteDatas = Quote::getData()->where('id',$array['quote'])->firstOrFail();
			if(!empty($quoteDatas)){
				$Unearned_fees = $Earnedfees = 0;
				$array['policy_fee'] = $policy_fee = isset($array['policy_fee']) && !empty($array['policy_fee']) ? toFloat($array['policy_fee']) : 0;
				$array['taxes_and_stamp_fees'] = $taxes_and_stamp_fees = isset($array['taxes_and_stamp_fees']) && !empty($array['taxes_and_stamp_fees']) ? toFloat($array['taxes_and_stamp_fees']) : 0;
				$array['broker_fee'] = $broker_fee = isset($array['broker_fee']) && !empty($array['broker_fee']) ? toFloat($array['broker_fee']) : 0;
				$array['inspection_fee'] = $inspection_fee = isset($array['inspection_fee']) && !empty($array['inspection_fee']) ? toFloat($array['inspection_fee']) : 0;
				if($quoteDatas->account_type == 'personal'){
					if(!empty($quoteSetting) && !empty($quoteSetting?->policy_fee_personal)){
						if($quoteSetting?->policy_fee_personal == 'financed'){
							$Unearned_fees += $policy_fee;
						}else if($quoteSetting?->policy_fee_personal == 'down_payment'){
							$Earnedfees  += $policy_fee;
						}
						if($quoteSetting?->tax_stamp_personal == 'financed'){
							$Unearned_fees += $taxes_and_stamp_fees;
						}else if($quoteSetting?->tax_stamp_personal == 'down_payment'){
							$Earnedfees  += $taxes_and_stamp_fees;
						}
						if($quoteSetting?->broker_fee_personal == 'financed'){
							$Unearned_fees += $broker_fee;
						}else if($quoteSetting?->broker_fee_personal == 'down_payment'){
							$Earnedfees  += $broker_fee;
						}
						if($quoteSetting?->inspection_fee_personal == 'financed'){
							$Unearned_fees += $inspection_fee;
						}else if($quoteSetting?->inspection_fee_personal == 'down_payment'){
							$Earnedfees  += $inspection_fee;
						}

					}
				}else if($quoteDatas->account_type == 'commercial'){
					if($quoteSetting?->policy_fee_commercial == 'financed'){
						$Unearned_fees += $policy_fee;
					}else if($quoteSetting?->policy_fee_commercial == 'down_payment'){
						$Earnedfees  += $policy_fee;
					}
					if($quoteSetting?->tax_stamp_commercial == 'financed'){
						$Unearned_fees += $taxes_and_stamp_fees;
					}else if($quoteSetting?->tax_stamp_commercial == 'down_payment'){
						$Earnedfees  += $taxes_and_stamp_fees;
					}
					if($quoteSetting?->broker_fee_commercial == 'financed'){
						$Unearned_fees += $broker_fee;
					}else if($quoteSetting?->broker_fee_commercial == 'down_payment'){
						$Earnedfees  += $broker_fee;
					}
					if($quoteSetting?->inspection_fee_commercial == 'financed'){
						$Unearned_fees += $inspection_fee;
					}else if($quoteSetting?->inspection_fee_commercial == 'down_payment'){
						$Earnedfees  += $inspection_fee;
					}
				}


				$array['unearned_fees'] = $Unearned_fees;
				$array['earned_fees'] = $Earnedfees;
				$array['total'] = toFloat($array['pure_premium']) + toFloat($Unearned_fees) + toFloat($Earnedfees);
			}
		}

        $array['inception_date']     = !empty($array['inception_date']) ? dbDateFormat($array['inception_date']) : null ;
        $array['expiration_date']     = !empty($array['expiration_date']) ? dbDateFormat($array['expiration_date']) : null ;


        $array['first_installment_date']     = !empty($array['first_installment_date']) ? date('Y-m-d',strtotime($array['first_installment_date'])) : null ;
        $array['first_payment_due_date']     = $array['first_installment_date'];
        $array['payment_due_days']   =  $quoteSetting?->until_first_payment;



        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        if(empty($id)){
            $inserArr['user_id'] = $user_id;
        }



        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
        if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);
                $getdata   = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata  =  $model->create($inserArr);
            }

            if($getdata->wasRecentlyCreated == true){
                $msg = "<li>".__('logs.quote_policy.add',['id'=> "# {$getdata->quote_data->qid}.{$getdata->version_data->version_id}"])." </li>";
            }else{
                $changesArr = $getdata?->changesArr ?? [];
                $logsMsg    = logsMsgCreate($changesArr, $titleArr);
                $msg        = $logsMsg?->msg;
            }


            /* QuoteTerm */
            //if($onlyPolicy != true){
                $array['quote'] = $getdata?->quote;
                $array['version'] = $getdata?->version;
                QuoteTerm::insertOrUpdate($array);
          //  }



          //  dd(  $msg  );
          $logId = !empty($logId) ? $logId : $getdata->id;
          if($isLogMsg == false && !empty($msg)){
              Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg]);
          }else{
              if($isLogMsg == true){
                $getdata['logMsg'] = $msg;
              }
          }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if (!empty($array['qId'])) {
            $model = $model->whereQuote($array['qId']);
        }

        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }
        if (!empty($array['version'])) {
            $model = $model->whereVersion($array['version']);
        }
        return $model;
    }
}
