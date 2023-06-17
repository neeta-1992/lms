<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoverageType;
class PayablesController extends Controller
{
    private $viwePath   = "company.Payables.";
    public  $pageTitle  = "Process Payables";
    public  $activePage = "process-payables";
    public  $route      = "company.payables.";
    public function __construct(CoverageType $model){
       $this->model =  $model;
    }

    public function index(){
        return view($this->viwePath."index",['route'=>$this->route]);
    }

    public function historyindex(){
        return view($this->viwePath."history",['route'=>$this->route]);
    }

    public function findindex(){
        return view($this->viwePath."find",['route'=>$this->route]);
    }
    
}
