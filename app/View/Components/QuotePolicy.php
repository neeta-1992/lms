<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{
    QuoteSetting,User,AgentOtherSetting
};
class QuotePolicy extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $agency;
    public $data;
    public $quoteSetting;

    public function __construct($agency=null,$data=null,$quoteSetting=null)
    {
        $this->agency = $agency;
        $this->data = $data;
        $this->quoteSetting = $quoteSetting;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $quoteSettings = !empty($this->quoteSetting) ? $this->quoteSetting : QuoteSetting::getData()->first();
        $policyminiumearnedpercent =  !empty($quoteSettings->policy_minium_earned_percent) ? $quoteSettings->policy_minium_earned_percent : '';
		if(auth()->user()?->user_type   == USER::AGENT || !empty($this->agency)){
			$agentOtherSetting          = AgentOtherSetting::getData(['entityId'=>$this->agency])->first();
			$agentdownpaymentincrease   = !empty($agentOtherSetting) && isset($agentOtherSetting->down_payment_increase) ? $agentOtherSetting->down_payment_increase : '';
			$down_payment_increase      = empty($agentdownpaymentincrease) ? (!empty($quoteSettings->down_percent) ? $quoteSettings->down_percent : '') : $agentdownpaymentincrease;
		}else{
			$down_payment_increase      = !empty($quotesettingsArr['down_percent']) ? $quotesettingsArr['down_percent'] : '';
		}
        $policy_minium_earned_percent = !empty($down_payment_increase) ? ($policyminiumearnedpercent + $down_payment_increase) : $policyminiumearnedpercent;
        return view('components.quote-policy',['quoteSettings'=>$quoteSettings,'policy_minium_earned_percent'=>$policy_minium_earned_percent,'data'=>$this->data]);
    }
}
