<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoverageType;
class ReportsController extends Controller
{
    private $viwePath   = "company.Reports.";
    public  $pageTitle  = "Year End Report";
    public  $activePage = "year-end-reports";
    public  $route      = "company.Report.";
    public function __construct(CoverageType $model){
       $this->model =  $model;
    }

    
    public function yearreport(){
        return view($this->viwePath."yearreports",['route'=>$this->route]);
    }

    public function interestreport(){
        $this->pageTitle = "Earned Interest Report";
        return view($this->viwePath."interest",['route'=>$this->route,'pageTitle'=>$this->pageTitle]);
    }

    public function generalledger(){
        $this->pageTitle = "General Ledger";
        return view($this->viwePath."general",['route'=>$this->route,'pageTitle'=>$this->pageTitle]);
    }

    public function revenuereport(){
        $this->pageTitle = "Expected Revenue";
        return view($this->viwePath."revenu",['route'=>$this->route,'pageTitle'=>$this->pageTitle]);
    }
}
