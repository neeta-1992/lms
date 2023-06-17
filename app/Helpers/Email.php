<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Route;
use Config;
use App\Models\{
    User,Company
};
use DB,Mail;
class Email{

    public static function sendemail(array $arr){
       try {
            $view       = !empty($arr['view']) ? $arr['view'] : [] ;
          
            $res = Mail::send($view, $arr, function ($message) use($arr) {   /* Send Mail */
                $subject    = !empty($arr['subject']) ? $arr['subject'] : '' ;
                $body       = !empty($arr['body']) ? $arr['body'] : '' ;
                $email      = !empty($arr['email']) ? $arr['email'] : '' ;
                $domPdf     = !empty($arr['domPdf']) ? $arr['domPdf'] : '' ;
                $pdfName    = !empty($arr['pdfName']) ? $arr['pdfName'] : '' ;
                $message->to($email);
                if(!empty($subject)){
                    $message->subject($subject);
                }
                if(!empty($body)){
                    $message->html($body);    // HTML rich messages  assuming text/plain
                }

                if(!empty($domPdf) && !empty($pdfName)){
                    $message->attachData($domPdf,$pdfName);
                }
               
            });
            return true;
       } catch (\Throwable $th) {
            throw $th;
       }
    }
     
}
