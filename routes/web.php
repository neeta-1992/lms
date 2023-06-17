<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Cron\{
    CompanyController,
};
use App\Http\Controllers\{
    CommonController,Auth\ForgotPasswordController,Company\QuotesController,
    Company\Quote\ESignatureQuote,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(config('fortify.prefix'))->group(function () {
   /* Custome Forget password*/
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get')->middleware('guest');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post')->middleware('guest');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    Route::get('quotes/signature', [ESignatureQuote::class,'eSignatureQuoteToInsured'])->name('quotes.signature');
    Route::get('quotes/download-quote', [ESignatureQuote::class,'downloadQuoteTemplete'])->name('quotes.download-quote');
    Route::post('quotes/signatures-save/{qId}/{vId}',  [ESignatureQuote::class,'quoteSignaturesSave'])->name('quotes.signatures-save')->whereUuid('qId');
});




Route::get('/', function () { return view('dashboard'); });


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {


    Route::group(['prefix'=>config('fortify.prefix')],function () {

        Route::get('demo', function() {
             return view('welcome');
        });

      /*  Company Routes  */
        require_once __DIR__."/company.php";
     /*  End Company Routes  */

       /*
       If you need more pages, you can simply create more markdown files in your docsify directory. If you create a file
       named guide.md, then it is accessible via /#/docs folder.
       */
       Route::view('docs',"docs")->name("user-guide-docs");




        /*
        * Common Ajax Data
        */
       Route::post("common/notice-template-data/{type?}/{action?}/{noticeType?}",[CommonController::class,'noticeTemplateData'])->name('ajax.notice-template-data');
       Route::post('common/file-upload',[CommonController::class,'fileUplode'])->name('ajax.file-upload');
       Route::post('common/remove-file',[CommonController::class,'removeFile'])->name('ajax.remove-file');
       Route::post('common/office-wish-role',[CommonController::class,'officeWishRole'])->name('common.officeWishRole');
       Route::post('common/prospect-office-wish-role',[CommonController::class,'prospectOfficeWishRole'])->name('common.prospectOfficeWishRole');
       Route::get('common/entity/{type}',[CommonController::class,'entityList'])->name('common.entityList');
       Route::post('common/user-status-change/{id}',[CommonController::class,'userStatusChange'])->name('common.userStatusChange');
       Route::get('common/mail-send-user',[CommonController::class,'mailSendUser'])->name('common.mailSendUser');
       Route::post('common/get-user-details',[CommonController::class,'userDetails'])->name('common.userDetails');
       Route::post('common/get-payment-details',[CommonController::class,'getPaymentDetails'])->name('common.get-payment-details');
       Route::post('common/user-list',[CommonController::class,'userList'])->name('common.user-list');



       /* In mail  */
      /*  Route::get('in-mail', ShowPosts::class); */
    });


        /* Admin Routes */
        require_once __DIR__."/admin.php";
        /* End Admin Routes */




});


Route::group(['prefix' => 'cron'],function () {
    Route::get('company-install',[CompanyController::class,'index']);
});


require_once __DIR__."/jetstream.php";

