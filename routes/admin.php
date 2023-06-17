<?php
use App\Http\Controllers\Admin\{
   FinanceCompanyController,GAFinanceCompanyController,FinanceAgreementController,
   RateTableController,LogsController,InsuranceCompanyController,NoticeTemplatesController,CancellationreasonsController
};
use Illuminate\Support\Facades\Session;


/* Admin Routes */
Route::group(['middleware'=>'adminUser','as' => 'admin.','namespace' => 'App\Http\Controllers\Admin','prefix'=>"enetworks"],function () {
    //uthenticated Urls

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('finance-company',FinanceCompanyController::class);
    Route::resource('cancellation-reasons',CancellationreasonsController::class);
	Route::resource('ga-finance-company',GAFinanceCompanyController::class);
    Route::get('{id}/finance-company/{host}',[FinanceCompanyController::class,'adminFinanceCompanyLogin'])->name("finance-company.adminlogin");
    Route::post('finance-company/active-company',[FinanceCompanyController::class,'activeCompany'])->name("finance-company.active-company");
    Route::resource('state-settings',StateSettingController::class);
   /*  Route::resource('coverage-type',CoverageTypeController::class); */
    Route::resource('general-ledger-accounts',GlAccountController::class);
    Route::resource('notice-templates',NoticeTemplatesController::class);
    Route::match(['get', 'post'],'notice-templates-css',[NoticeTemplatesController::class,'css'])->name('notice-templates.css');
    Route::match(['get', 'post'],'notice-templates/{type}/header-footer',[NoticeTemplatesController::class,'headerFooter'])->name('notice-templates.header-footer')->whereIn('type',['notice','email']);
    Route::resource('notice-template-shortcodes',LmsShortcodsController::class)->only('index');
    Route::resource('finance-agreement',FinanceAgreementController::class);
    Route::match(['get', 'post'],'finance-agreement-css',[FinanceAgreementController::class,'css'])->name('finance-agreement.css');
/*     Route::resource('user-group',UserGroupsController::class); */
    Route::resource('user-guide',UserGuidesController::class);
    Route::resource('scheduled-task',ScheduledTaskController::class);

    /* RateTableController */
  /*   Route::resource('rate-table',RateTableController::class);
    Route::get('rate-table/assign-to-agents/{id}',[RateTableController::class,'assignToAgents'])->name('rate-table.assignToAgents'); */

   /*  Route::resource('general-agent',GeneralAgentController::class); */
    Route::resource('insurance-company',InsuranceCompanyController::class);
    Route::post('entity-contact-save',[InsuranceCompanyController::class,'entityContactSave'])->name('insurance-company.entity-contact-save');
    Route::get('entity-contact-edit/{id}',[InsuranceCompanyController::class,'entityContactEdit'])->name('insurance-company.entity-contact-edit');
    Route::get('entity-contact-list/{entityId}',[InsuranceCompanyController::class,'entityContactList'])->name('insurance-company.entity-contact-list');

    Route::get('logs/{type}/{id?}',[LogsController::class,'logs'])->name('logs');
    Route::post('logs-details/{id?}',[LogsController::class,'logsDetails'])->name('logs-details');

    
    //CancellationreasonsController


});
