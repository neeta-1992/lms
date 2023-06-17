<?php
use App\Http\Controllers\Company\{
    QuotesController,PayablesController,DownPaymentRuleController,FinanceCompanyController,StateProgramSettingsController,
    PaymentsController,ReportsController,NoticeTemplatesController,NoticesController,SettingController,AccountStatusSettingsController,
    GLdefaultController,FinanceAgreementController,
    AccountsController,LogsController,RateTableController,Prospectscontroller,DailyNoticesController,
    Entity\GeneralAgentsController,
    Entity\InsuranceCarriersController,
    Entity\AgentsController,
    Entity\InsuredsController,
    Entity\BrokersController,
    Entity\LienholdersController,
    Entity\SalesOrganizationsController,
    User\FindUserController,
    User\UserSecuritySettingController,
    User\GroupPermissionsController,
    TaskController,InmailController,Quote\QuoteNotesController,Quote\ESignatureQuote,Account\EnterPaymentController
};



/* Admin Routes */
Route::group(['as' => 'company.','namespace' => 'App\Http\Controllers\Company'],function () {

    Route::get('/', function () {
        return view('company.dashboard');
    })->name('dashboard');

    Route::resource('finance-company',FinanceCompanyController::class)->only('index','update');
	Route::post('finance-company/deactive-user',[FinanceCompanyController::class,'deactiveUser'])->name('finance-company.deactive-user');
    Route::post('finance-company/deactive-user-confirmation',[FinanceCompanyController::class,'deactiveUserConfirmation'])->name('finance-company.deactive-user-confirmation');

    Route::resource('finance-agreement',FinanceAgreementController::class);
    Route::match(['get', 'post'],'finance-agreement-css',[FinanceAgreementController::class,'css'])->name('finance-agreement.css');
    Route::resource('attachments',AttachmentController::class);

    Route::resource('notice-templates',NoticeTemplatesController::class);
    Route::match(['get', 'post'],'notice-templates-css',[NoticeTemplatesController::class,'css'])->name('notice-templates.css');
    Route::match(['get', 'post'],'notice-templates/{type}/header-footer',[NoticeTemplatesController::class,'headerFooter'])->name('notice-templates.header-footer')->whereIn('type',['notice','email']);
    Route::resource('homepage-message',HomePageMessageController::class);
    Route::resource('notice-template-shortcodes',LmsShortcodsController::class)->only('index');
    Route::resource('state-settings',StateSettingController::class);
    Route::resource('coverage-type',CoverageTypeController::class);
    Route::resource('rate-table',RateTableController::class);
    Route::get('rate-table/assign-to-agents/{id}',[RateTableController::class,'assignToAgents'])->name('rate-table.assignToAgents');
    Route::resource('user-group',UserGroupsController::class);
    Route::resource('scheduled-tasks',ScheduledTaskController::class)->except(['create', 'store']);

    Route::get('logs/{type?}/{id?}/{duId?}',[LogsController::class,'logs'])->name('logs');
    Route::post('logs-details/{id?}',[LogsController::class,'logsDetails'])->name('logs-details');

    /* @QuotesControllerRoutes */


    Route::resource('compensation-table',CompensationTableController::class);
    Route::resource('company-defaults',CompanyDefaultsController::class)->only('index');
    Route::resource('account-status-settings',AccountStatusSettingsController::class)->only(['index','show','store']);
    Route::get('account-status-settings/{stateId}/{tab}',[AccountStatusSettingsController::class,'accountStatusSettingsTab'])->name('account-status-settings.account-status-settings-tab');
    Route::resource('processing-fee-tables',ProcessingFeeTablesController::class);
    Route::resource('cancellation-reasons',CancellationreasonsController::class);
    Route::resource('program-settings',StateProgramSettingsController::class);
    Route::post('program-settings-override/{id?}',[StateProgramSettingsController::class,'addstaterules'])->name('program-settings.statefrom');
    Route::get('program-settings-list/{id}',[StateProgramSettingsController::class,'overridesettingList'])->name('program-settings.viewlist');
    Route::delete('program-settings-delete',[StateProgramSettingsController::class,'overridedelete'])->name('program-settings.delete');

    Route::resource('territory-settings',TerritorySettingsController::class);
    Route::resource('account-settings',AccountSettingsController::class);
    Route::resource('down-payment-rules',DownPaymentRuleController::class);
    Route::get('down-payment-rule-list/{id}',[DownPaymentRuleController::class,'downPaymentRuleList'])->name('down-payment-rules.list');
    Route::post('down-payment-rule-form/{id?}',[DownPaymentRuleController::class,'downPaymentRuleForm'])->name('down-payment-rules.form');
    Route::delete('down-payment-rule-delete',[DownPaymentRuleController::class,'downPaymentRuleDelete'])->name('down-payment-rules.delete');

    Route::resource('daily-notices',DailyNoticesController::class);
    Route::post('daily-notices/daily-notice-process-html',[DailyNoticesController::class,'dailyNoticeProcessHtml'])->name('daily-notices.daily-notice-process-html');
    Route::post('daily-notices/daily-notice-process',[DailyNoticesController::class,'dailyNoticeProcessSend'])->name('daily-notices.daily-notice-process');


    Route::resource('policy-cancel-terms-options',PolicyTermsOptionController::class);





    Route::resource('notice-insurance-companies',NoticeInsuranceCompaniesController::class);
    Route::resource('general-agent-notice',GeneralAgentNoticeController::class);
    Route::resource('insurance-companies',InsuranceCarriersController::class);
    Route::get('insurance-companies/funding/{id}',[InsuranceCarriersController::class,'entityFunding'])->name('insurance-companies.funding');
    Route::post('insurance-companies/funding-save',[InsuranceCarriersController::class,'entityFundingSave'])->name('insurance-companies.funding.save');
    Route::match(['get', 'post'],'insurance-companies/notice-save/{id}',[InsuranceCarriersController::class,'entityNoticeSettings'])->name('insurance-companies.notice.save');
    Route::resource('general-ledger-accounts',GlAccountController::class);
    Route::resource('bank-accounts',BankAccountsController::class);
    Route::get('process-payables',[PayablesController::class,'index'])->name('payables.process-payables');
    Route::get('payable-history',[PayablesController::class,'historyindex'])->name('payables.payable-history');
    Route::get('find-payables',[PayablesController::class,'findindex'])->name('payables.find-payables');
    Route::get('enter-payments',[PaymentsController::class,'enterpayments'])->name('payment.enter-payments');
    Route::get('verify-entered-payments',[PaymentsController::class,'verifypayments'])->name('payment.verify-entered-payments');
    Route::get('entered-payments-history',[PaymentsController::class,'paymenthistory'])->name('payment.entered-payments-history');
    Route::get('ach-payments-history',[PaymentsController::class,'achpayment'])->name('payment.ach-payments-history');
    Route::post('payments/find-payment',[PaymentsController::class,'findPayment'])->name('payment.find-payment');
    Route::post('payments/commit-process-entered',[PaymentsController::class,'commitProcessEntered'])->name('payment.commit-process-entered');
    Route::get('payments/payments-history-list',[PaymentsController::class,'paymentsHistoryList'])->name('payment.payments-history-list');
    Route::get('payments/download-iif-file',[PaymentsController::class,'downloadIifFile'])->name('payment.download-iif-file');
    Route::get('payments/download-csv-file',[PaymentsController::class,'downloadCsvFile'])->name('payment.download-csv-file');
    Route::get('payments/download-nacha-file',[PaymentsController::class,'downloadNachaFile'])->name('payment.download-nacha-file');


    /*
      Entity Manager Menu Routes
    */

    Route::resource('agents',AgentsController::class);
    Route::get('agents-office/{agencyId}',[AgentsController::class,'entityofficeList'])->name('agents.office.index');
    Route::match(['get', 'post'],'agents-office-create/{agencyId}',[AgentsController::class,'entityOfficeCreate'])->name('agents.office.create');
    Route::match(['get', 'post'],'agents-office-edit/{editId}',[AgentsController::class,'entityOfficeEdit'])->name('agents.office.edit');
    Route::get('agents/funding/{id}',[AgentsController::class,'entityFunding'])->name('agents.funding');
    Route::post('agents/funding-save',[AgentsController::class,'entityFundingSave'])->name('agents.funding.save');
    Route::match(['get', 'post'],'agents/notice-save/{id}',[AgentsController::class,'entityNoticeSettings'])->name('agents.notice.save');
    Route::match(['get', 'post'],'agents/users-create/{agencyId}',[AgentsController::class,'agentUserCreate'])->name('agents.users.create');
    Route::match(['get', 'post'],'agents/users-edit/{id}',[AgentsController::class,'agentUserEdit'])->name('agents.users.edit');
    Route::get('agents/users/{agencyId}',[AgentsController::class,'agentUser'])->name('agents.users.index');
    Route::match(['get', 'post'],'agents/other-settings/{agencyId}',[AgentsController::class,'entityOtherSetting'])->name('agents.other-settings');


    Route::resource('insureds',InsuredsController::class);
    Route::match(['get', 'post'],'insureds/notice-save/{id}',[InsuredsController::class,'entityNoticeSettings'])->name('insureds.notice.save');
    Route::match(['get', 'post'],'insureds/users-create/{agencyId}',[InsuredsController::class,'agentUserCreate'])->name('insureds.users.create');
    Route::match(['get', 'post'],'insureds/users-edit/{id}',[InsuredsController::class,'agentUserEdit'])->name('insureds.users.edit');
    Route::get('insureds/users/{agencyId}',[InsuredsController::class,'agentUser'])->name('insureds.users.index');

    Route::resource('brokers',BrokersController::class);
    Route::match(['get', 'post'],'brokers/contact-create/{agencyId}',[BrokersController::class,'entityContactCreate'])->name('brokers.contact.create');
    Route::match(['get', 'post'],'brokers/contact-edit/{editId}',[BrokersController::class,'entityContactEdit'])->name('brokers.contact.edit');
    Route::get('brokers/contact/{entityId}',[BrokersController::class,'entityContactList'])->name('brokers.contact');
    Route::match(['get', 'post'],'brokers/notice-save/{id}',[BrokersController::class,'entityNoticeSettings'])->name('brokers.notice.save');

    Route::resource('lienholders',LienholdersController::class);
    Route::match(['get', 'post'],'lienholders/contact-create/{agencyId}',[LienholdersController::class,'entityContactCreate'])->name('lienholders.contact.create');
    Route::match(['get', 'post'],'lienholders/contact-edit/{editId}',[LienholdersController::class,'entityContactEdit'])->name('lienholders.contact.edit');
    Route::get('lienholders/contact/{entityId}',[LienholdersController::class,'entityContactList'])->name('lienholders.contact');
    Route::match(['get', 'post'],'lienholders/notice-save/{id}',[LienholdersController::class,'entityNoticeSettings'])->name('lienholders.notice.save');

    Route::resource('general-agents',GeneralAgentsController::class);
    Route::post('general-agents/contact-store',[GeneralAgentsController::class,'GeneralAgentContactStote'])->name('general-agents.contact.store');
    Route::get('general-agents/funding/{id}',[GeneralAgentsController::class,'entityFunding'])->name('general-agents.funding');
    Route::post('general-agents/funding-save',[GeneralAgentsController::class,'entityFundingSave'])->name('general-agents.funding.save');
    Route::match(['get', 'post'],'general-agents/notice-save/{id}',[GeneralAgentsController::class,'entityNoticeSettings'])->name('general-agents.notice.save');
    Route::match(['get', 'post'],'general-agents/contact-create/{agencyId}',[GeneralAgentsController::class,'entityContactCreate'])->name('general-agents.contact.create');
    Route::match(['get', 'post'],'general-agents/contact-edit/{editId}',[GeneralAgentsController::class,'entityContactEdit'])->name('general-agents.contact.edit');
    Route::get('general-agents/contact/{entityId}',[GeneralAgentsController::class,'entityContactList'])->name('general-agents.contact');

    Route::resource('sales-organizations',SalesOrganizationsController::class);
    Route::get('sales-organizations/office/{agencyId}',[SalesOrganizationsController::class,'entityofficeList'])->name('sales-organizations.office.index');
    Route::match(['get', 'post'],'sales-organizations/office-create/{agencyId}',[SalesOrganizationsController::class,'entityOfficeCreate'])->name('sales-organizations.office.create');
    Route::match(['get', 'post'],'sales-organizations/office-edit/{editId}',[SalesOrganizationsController::class,'entityOfficeEdit'])->name('sales-organizations.office.edit');
    Route::get('sales-organizations/funding/{id}',[SalesOrganizationsController::class,'entityFunding'])->name('sales-organizations.funding');
    Route::post('sales-organizations/funding-save',[SalesOrganizationsController::class,'entityFundingSave'])->name('sales-organizations.funding.save');
    Route::match(['get', 'post'],'sales-organizations/notice-save/{id}',[SalesOrganizationsController::class,'entityNoticeSettings'])->name('sales-organizations.notice.save');
    Route::match(['get', 'post'],'sales-organizations/users-create/{agencyId}',[SalesOrganizationsController::class,'agentUserCreate'])->name('sales-organizations.users.create');
    Route::match(['get', 'post'],'sales-organizations/users-edit/{id}',[SalesOrganizationsController::class,'agentUserEdit'])->name('sales-organizations.users.edit');
    Route::get('sales-organizations/users/{agencyId}',[SalesOrganizationsController::class,'agentUser'])->name('sales-organizations.users.index');

    Route::resource('finance-company-users',Entity\FinanceCompanyUsersController::class);


     /* Quotes Routes */
     Route::resource('quotes',QuotesController::class);
     Route::get('quotes/{quote}/underwriting-quote',[QuotesController::class,'edit'])->name('quotes.underwriting-edit-quote');

     Route::controller(QuotesController::class)->group(function () {
        Route::get('quotes/policy-list/{quoteId}/{vId}', 'policyList')->name('quotes.policy-list')->whereUuid('quoteId');

        Route::match(['get', 'post'],'quotes/policy-details/{id}', 'policyDetail')->name('quotes.policy-details')->whereUuid('id');
        Route::match(['get', 'post'],'quotes/policy-create/{quoteId}/{vId}', 'policyCreate')->name('quotes.policy-create')->whereUuid('quoteId');

        /* terms */
        Route::get('quotes/terms/{quoteId}/{vId}', 'terms')->name('quotes.terms')->whereUuid('quoteId');
        Route::post('quotes/favorite-version/{vId}', 'quotefavoriteVersion')->name('quotes.favorite-version')->whereUuid('vId');
        Route::post('quotes/clone-version/{vId}', 'quoteCloneVersion')->name('quotes.clone-version')->whereUuid('vId');
        Route::match(['get', 'post'],'quotes/new-version/{qId}', 'quoteNewVersion')->name('quotes.new-version')->whereUuid('qId');

        Route::get('quotes/attachment-list/{qId}/{vId}', 'quoteAttachments')->name('quotes.attachment-list')->whereUuid('qId');
        Route::get('quotes/tasks-list/{qId}/{vId}', 'tasksIndex')->name('quotes.tasks-list')->whereUuid('qId');
        Route::match(['get', 'post'],'quotes/tasks-create/{qId}/{vId}', 'tasksCreate')->name('quotes.tasks-create')->whereUuid('qId');
        Route::match(['post'],'quotes/task-details/{id}/{qId}/{vId}', 'tasksdetails')->name('quotes.tasks-details')->whereUuid('qId');
        Route::match(['get', 'post'],'quotes/task-edit/{id}/{qId}/{vId}', 'tasksEdit')->name('quotes.tasks-edit')->whereUuid('qId');
        Route::match(['post'],'quotes/task-update/{qId}/{vId}', 'termsUpdate')->name('quotes.tasks-update')->whereUuid('qId');
       	Route::match(['post'],'quotes/compensation-update/{qId}/{vId}', 'compensationUpdate')->name('quotes.compensation-update')->whereUuid('qId');



        Route::post('quotes/request-activation/{qId}/{vId}', 'requestActivation')->name('quotes.request-activation')->whereUuid('qId');
        Route::post('quotes/request-activation-unlock/{qId}/{vId}', 'quoteRequestToUnlock')->name('quotes.request-activation-unlock')->whereUuid('qId');
        Route::post('quotes/finance-unlock-quote/{qId}', 'financeUnlockQuote')->name('quotes.finance-unlock-quote')->whereUuid('qId');
        Route::post('quotes/underwriting-verification/{qId}', 'underwritingVerification')->name('quotes.underwriting-verification')->whereUuid('qId');
        Route::post('quotes/underwriting-information-save/{qId}', 'underWritingInformationSave')->name('quotes.underwriting-information-save')->whereUuid('qId');
        Route::post('quotes/quote-approve/{qId}', 'quoteApprove')->name('quotes.quote-approve')->whereUuid('qId');
        Route::post('quotes/quote-decline/{qId}', 'quoteDecline')->name('quotes.quote-decline')->whereUuid('qId');
        Route::post('quotes/aggregate-limit-status/{qId}', 'aggregateLimitStatus')->name('quotes.aggregate-limit-status')->whereUuid('qId');
    });

     /* Quote Notes */
     Route::controller(ESignatureQuote::class)->prefix('quotes')->name('quotes.')->group(function () {
        Route::get('view-fa/{qId}/{vId}', 'viewFa')->name('view-fa')->whereUuid('qId')->whereUuid('vId');
        Route::post('send-otp/{qId}/{vId}', 'sendOtp')->name('send-otp')->whereUuid('qId');
        Route::post('varify-otp/{qId}/{vId}', 'varifysendOtp')->name('varify-otp')->whereUuid('qId');
        Route::get('esignature/logs', 'viewList')->name('esignature_logs')->whereUuid('qId');
        Route::post('insured-signature-send/{qId}/{vId}', 'insuredSignatureSend')->name('insured-signature-send')->whereUuid('qId');
    });


    /* Quote Notes */
     Route::controller(QuoteNotesController::class)->prefix('quotes')->name('quotes.')->group(function () {
        Route::get('quote-notes/{qId}/{vId}', 'index')->name('quote-notes.index');
        Route::get('quote-notes/add/{qId}/{vId}', 'create')->name('quote-notes.create');
        Route::get('quote-notes/{id}/{qId}/{vId}', 'show')->name('quote-notes.show');
        Route::post('quote-notes/{qId}/{vId}', 'store')->name('quote-notes.store');
        Route::get('quote-notes-edit/{id}/{qId}/{vId}', 'edit')->name('quote-notes.edit');
        Route::put('quote-notes/{id}/edit/{qId}/{vId}', 'update')->name('quote-notes.update');
        Route::get('quote-notes-view-data/{qId}/{vId}', 'viewList')->name('quote-notes.viewList');
     });



     Route::get('find-quotes',[QuotesController::class,'findQuotes'])->name('quotes.find-quotes');
     Route::match(['get','post'],'new-quote',[QuotesController::class,'newQuote'])->name('quotes.new-quote');
     Route::match(['get','post'],'quotes/get_line_of_business_data',[QuotesController::class,'get_line_of_business_data'])->name('quotes.get_line_of_business_data');
     Route::match(['get','post'],'quotes/check_pure_premium',[QuotesController::class,'check_pure_premium'])->name('quotes.check_pure_premium');
     Route::get('quotes-activation',[QuotesController::class,'quotesActivation'])->name('quotes.quotes-activation');
     Route::match(['get', 'post'],'quotes-settings',[QuotesController::class,'quoteSettings'])->name('quotes.quote-settings');



    /*-------------More User Menu Routes -------*/
    Route::get('find-user',[FindUserController::class,'findUser'])->name('find-user.index');
    Route::get('find-user-list',[FindUserController::class,'findUserList'])->name('find-user.user-list');
    Route::get('find-user-view/{userId}',[FindUserController::class,'findUserView'])->name('find-user.view');
    Route::put('find-save-user/{userId}',[FindUserController::class,'saveUser'])->name('find-user.save-user');
    Route::get('add-user',[FindUserController::class,'addNewUser'])->name('find-user.new-user');
    Route::post('user-view',[FindUserController::class,'userView'])->name('find-user.user-view');
    Route::post('find-user/group-permissions',[FindUserController::class,'groupPermissions'])->name('find-user.group-permissions');
    Route::post('user-create',[FindUserController::class,'saveUserCreate'])->name('find-user.user-create');
    /*
        More Menu Routes ...
    */
    Route::resource('group-permissions',GroupPermissionsController::class);
    Route::resource('user-security-settings',UserSecuritySettingController::class);


    Route::resource('prospects',Prospectscontroller::class);
    Route::match(['get','post'],'prospects/contact-create/{agencyId}',[Prospectscontroller::class,'entityContactCreate'])->name('prospects.contact.create');
    Route::match(['get', 'post'],'prospects/contact-edit/{editId}',[Prospectscontroller::class,'entityContactEdit'])->name('prospects.contact.edit');
    Route::get('prospects/contact/{entityId}',[Prospectscontroller::class,'entityContactList'])->name('prospects.contact');
    Route::get('prospects-office/{agencyId}',[Prospectscontroller::class,'entityofficeList'])->name('prospects.office.index');
    Route::match(['get', 'post'],'prospects-office-create/{agencyId}',[Prospectscontroller::class,'entityOfficeCreate'])->name('prospects.office.create');
    Route::match(['get', 'post'],'prospects-office-edit/{editId}',[Prospectscontroller::class,'entityOfficeEdit'])->name('prospects.office.edit');
    Route::post('prospects/checkProspectAgencyUsersvalue',[Prospectscontroller::class,'checkProspectAgencyUsersvalue'])->name('prospects.checkProspectAgencyUsersvalue');
    /*
    Route::get('gl-accounts',[GlAccountController::class,'glaccount'])->name('account.gl-accounts');
    */
   Route::get('year-end-reports',[ReportsController::class,'yearreport'])->name('Report.year-end-reports');
   Route::get('earned-interest-reports',[ReportsController::class,'interestreport'])->name('Report.earned-interest-reports');
   Route::get('general-ledger',[ReportsController::class,'generalledger'])->name('Report.general-ledger');
   Route::get('expected-revenue-report',[ReportsController::class,'revenuereport'])->name('Report.expected-revenue-report');


   /*
    * NoticesController Routes
    */
    Route::match(['get', 'post'],'agents-notices',[NoticesController::class,'agentsNotices'])->name('notices.agents');
    Route::match(['get', 'post'],'general-agents-notices',[NoticesController::class,'generalAgentNotices'])->name('notices.general-agents');
    Route::match(['get', 'post'],'insurance-companies-notices',[NoticesController::class,'insuranceCompaniesNotices'])->name('notices.insurance-companies');
    Route::match(['get', 'post'],'insureds-notices',[NoticesController::class,'insuredsNotices'])->name('notices.insureds');
    Route::match(['get', 'post'],'sales-organizations-notices',[NoticesController::class,'salesOrganizationsNotices'])->name('notices.sales-organizations');
    Route::match(['get', 'post'],'brokers-notices',[NoticesController::class,'brokersNotices'])->name('notices.brokers');
    Route::match(['get', 'post'],'lienholders-notices',[NoticesController::class,'lienholdersNotices'])->name('notices.lienholders');

    /*
     *@param  App\Http\Controllers\Company\SettingController
     */
    Route::match(['get', 'post'],'account-settings',[SettingController::class,'accountSettings'])->name('settings.account-setting');
    Route::match(['get', 'post'],'electronic-payment-settings',[SettingController::class,'electronicPaymentSettings'])->name('settings.electronic-payment-settings');
    Route::match(['get', 'post'],'ach-settings',[SettingController::class,'achSettingsSettings'])->name('settings.ach-settings');
    Route::match(['get'],'company-defaults',[SettingController::class,'companyDefaults'])->name('settings.company-defaults');
    Route::match(['get','post'],'company-defaults-settings/{id}',[SettingController::class,'companyDefaultsSetting'])->name('settings.company-default-settings');
    Route::resource('quote-status-settings',QuoteStatusSettingController::class)->except(['create', 'store']);

	Route::match(['get'],'payment-method-permissions',[SettingController::class,'paymentMethodPermissions'])->name('settings.payment-method-permissions');
    Route::match(['get','post'],'payment-method-permissions-settings/{id}',[SettingController::class,'paymentMethodPermissionsSetting'])->name('settings.payment-method-permissions-settings');


    /* Task Controller */
     Route::resource('task', TaskController::class);
     Route::post('task/cloesTask',[TaskController::class,'cloesTask'])->name('task.cloes-task');
     Route::post('task/reopenTask',[TaskController::class,'reopenTask'])->name('task.reopen-task');


     Route::get('in-mail',[InmailController::class,'index'])->name('in-mail.index');
     Route::post('in-mail',[InmailController::class,'store'])->name('in-mail.store');
     Route::post('in-mail-save-drafts',[InmailController::class,'saveInDrafts'])->name('in-mail.save-drafts');
     Route::post('in-mail/send-mail',[InmailController::class,'sendMailList'])->name('in-mail.send-mail');
     Route::post('in-mail/draft-mail',[InmailController::class,'draftsMailList'])->name('in-mail.draft-mail');
     Route::post('in-mail/inbox-mail',[InmailController::class,'inboxMailList'])->name('in-mail.inbox-mail');
     Route::post('in-mail/unread-mail',[InmailController::class,'unreadMail'])->name('in-mail.unread-mail');
     Route::post('in-mail/important-mail',[InmailController::class,'importantMail'])->name('in-mail.important-mail');
     Route::post('in-mail/deletet-mail',[InmailController::class,'deletetMail'])->name('in-mail.deletet-mail');
     Route::post('in-mail/mail-details/{id}',[InmailController::class,'mailDetails'])->name('in-mail.mail-details');
     Route::post('in-mail/resend-mail/{id}',[InmailController::class,'resedMail'])->name('in-mail.resend-mail');
     Route::post('in-mail/unread-count',[InmailController::class,'unreadCountMail'])->name('in-mail.unread-count');
     Route::post('in-mail/replay-mail/{id}',[InmailController::class,'replayMail'])->name('in-mail.replay-mail');
     Route::post('in-mail/reply-save-mail/{id}',[InmailController::class,'mailReplySave'])->name('in-mail.reply-save-mail');

	Route::get('default-gl-accounts',[GLdefaultController::class,'defaultgl'])->name('default-gl-accounts.index');
	Route::post('gl-create',[GLdefaultController::class,'glsave'])->name('default-gl-accounts.gl-create');



    /*  */
    Route::resource('accounts',AccountsController::class);
    Route::get('find-accounts',[AccountsController::class,'findAccounts'])->name('accounts.find-accounts');
    Route::post('accounts/view-account/{accountId}',[AccountsController::class,'viewAccountData'])->name('accounts.viewAccountData');
    Route::get('accounts/notice-history/{accountId}',[AccountsController::class,'getNoticeHistory'])->name('accounts.notice-history');
    Route::get('accounts/payment-schedule-history/{accountId}',[AccountsController::class,'getPaymentScheduleHistory'])->name('accounts.payment-schedule-history');
    Route::get('accounts/alert/{accountId}',[AccountsController::class,'alertViewList'])->name('accounts.alert.index');
    Route::get('accounts/alert/create/{accountId}',[AccountsController::class,'accountAlertInsertOrUpdate'])->name('accounts.alert.create');
    Route::post('accounts/alert/store/{accountId}',[AccountsController::class,'accountAlertStore'])->name('accounts.alert.store');
    Route::post('accounts/alert/detilas/{accountId}/{id}',[AccountsController::class,'accountAlertDetails'])->name('accounts.alert.detilas');
    Route::post('accounts/policies-endorsments/{accountId}', [AccountsController::class,'policiesAndEndorsments'])->name('accounts.policiesAndEndorsments')->whereUuid('accountId');
    Route::match(['get', 'post'],'accounts/policy-details/{accountId}/{id}', [AccountsController::class,'policyDetail'])->name('accounts.policy-details')->whereUuid('id');
    Route::get('accounts/notes/{accountId}', [AccountsController::class,'notsViewList'])->name('accounts.note-list')->whereUuid('accountId');
    Route::match(['get','post'],'accounts/notes/create/{accountId}', [AccountsController::class,'notesAdd'])->name('accounts.note-create')->whereUuid('accountId');
    Route::match(['get','post'],'accounts/notes/details/{accountId}/{id}', [AccountsController::class,'notesDetails'])->name('accounts.note-details')->whereUuid('accountId');
    Route::match(['get','put'],'accounts/notes/edit/{accountId}/{id}', [AccountsController::class,'notesEdit'])->name('accounts.note-edit')->whereUuid('accountId');
    Route::post('accounts/notice/details/{accountId}/{id}', [AccountsController::class,'getNoticeHistoryDetails'])->name('accounts.notice-details')->whereUuid('accountId');
    Route::post('accounts/notice-action-update/{id}', [AccountsController::class,'noticeStatusUpdate'])->name('accounts.notice-update')->whereUuid('accountId');
    Route::get('accounts/payment-transaction-history/{id}', [AccountsController::class,'getPaymentTransactionHistory'])->name('accounts.payment-transaction-history')->whereUuid('accountId');
    Route::post('accounts/save-assess-manual-fee/{id}', [AccountsController::class,'saveAssessManualFee'])->name('accounts.save-assess-manual-fee')->whereUuid('accountId');
    Route::match(['get','post'],'/accounts/transaction-history-details/{accountId}/{id}', [AccountsController::class,'transactionHistoryDetails'])->name('accounts.payment-transaction-history-details')->whereUuid('accountId');
    Route::post('/accounts/email-receipt', [AccountsController::class,'emailReceipt'])->name('accounts.email-receipt')->whereUuid('accountId');
    Route::post('accounts/suspend-account/{accountId}', [AccountsController::class,'suspendAccount'])->name('accounts.suspend-account')->whereUuid('accountId');
    Route::post('accounts/unsuspend-account/{accountId}', [AccountsController::class,'unsuspendAccount'])->name('accounts.unsuspend-account')->whereUuid('accountId');
    
    

    /* EnterPaymentController */
    Route::controller(EnterPaymentController::class)->prefix('accounts')->name('accounts.')->group(function () {
        Route::match(['get','post'],'enter-payment/{accountId}', 'enterPayment')->name('enterPayment')->whereUuid('accountId');
        Route::post('payment-chart/{accountId}', 'getPaymentChart')->name('getPaymentChart')->whereUuid('accountId');
        Route::post('save-payment', 'savePayment')->name('save-payment')->whereUuid('accountId');
        Route::post('enter-peturn-premium-commission/{accountId}', 'enterReturnPremiumCommission')->name('enter-peturn-premium-commission')->whereUuid('accountId');
        Route::post('change-quote-policy/{id}', 'changeQuotePolicy')->name('change-quote-policy')->whereUuid('id');
        Route::post('enter-return-premium-sava', 'enterReturnPremiumSava')->name('enter-return-premium-sava')->whereUuid('id');
    });
});
