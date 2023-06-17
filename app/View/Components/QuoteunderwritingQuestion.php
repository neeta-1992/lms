<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{
    QuoteVersion,User
};
class QuoteunderwritingQuestion extends Component
{
    public $qData;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($qData = null)
    {
        $this->qData = $qData;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $userData = null;
        $quoteData = $this->qData;

        $qId = $quoteData?->id;
        $financeCompany = $quoteData?->finance_company;
        $vId = $quoteData?->vid;
        $data = QuoteVersion::getData(['qId' => $qId, 'id' => $vId])->first();
        $underwritingInformation = !empty($data->underwriting_informations) ? json_decode($data->underwriting_informations, true) : '';
        if (auth()->user()->can('company') || auth()->user()->can('isAdminCompany')) {
            $userData = User::getData(['type' => [User::COMPANYUSER, User::ADMIN]])->get()?->pluck('name', 'id')->toArray();
        }

        return view('components.quoteunderwriting-question',['data'=>$underwritingInformation,'quoteData'=>$quoteData,'userData'=>$userData]);
    }
}
