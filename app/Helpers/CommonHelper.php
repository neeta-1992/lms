<?php
use Illuminate\Support\Str;
use App\Encryption\Encrypter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\{
    UserSecuritySetting,Quote
};

/*
 *?float val
 */
if(!function_exists('toFloat')){
    function toFloat($number =0)
    {
        return (double)filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}

/* amount round */
if(!function_exists('toRound')){
    function toRound($number =0,$precision = 2,int $mode = PHP_ROUND_HALF_UP)
    {
        return  round($number,$precision,$mode);
    }
}
/* amount round */
if(!function_exists('formatAmount')){
    function formatAmount($amount =0,$isDoller= true)
    {
        return (number_format(floatval($amount), 2, '.', ','));
    }
}
/* amount round */
if(!function_exists('dollerFormatAmount')){
    function dollerFormatAmount($amount =0)
    {
        $amount = !empty($amount) ? $amount : '0.00';
        return "$".formatAmount($amount);
    }
}
/* amount round */
if(!function_exists('dollerFA')){
    function dollerFA($amount =0)
    {
        $amount = !empty($amount) ? $amount : '0.00';
        return "$".formatAmount($amount);
    }
}
/* amount round */
if(!function_exists('pFormat')){
    function pFormat($number =0)
    {
        $number = !empty($number) ? $number : '0';
        return toRound($number)."%";
    }
}
/*
 *?Layout File Path
 */
if(!function_exists('layoutParts')){
   function layoutParts(string $type=null,$partsFolder="parts"):string{
       $prefix = config('fortify.prefix');
       $path = $prefix == "enetworks" ? 'admin' : "company";
       $path = $partsFolder !== 'common' ?  "{$path}.{$partsFolder}.{$type}" :  "{$partsFolder}.{$type}";
       return $path;
   }
}
/*
 *?Database name
 */
if(!function_exists('dbName')){
   function dbName(string $name=null):string{
       return strtolower(trim(str_replace("-","_",$name)));

   }
}
/*
/*
 *?Fiele Get Url
 */
if(!function_exists('fileUrl')){
   function fileUrl(string $file=null):string{
       $isfile = public_path('uploads/'.$file);
       return file_exists($isfile) ? url("public/uploads/{$file}") : '';

   }
}
/*
 *?Full Name Division First Name , Middle Name And Last Name
 */
if(!function_exists('nameDivision')){
   function nameDivision(string $name):array{
        $name       =  trim(removeWhiteSpace($name)); //Remove Left And Right Space
        $nameArr    =  explode(" ",$name); //String Convert To Arr
        $firstName  =  !empty($nameArr[0]) ? $nameArr[0] : '' ;
        $middleName =  !empty($nameArr[1]) ? $nameArr[1] : '' ;
        $lastName   =  !empty($nameArr[2]) ? $nameArr[2] : '' ;
        $lastName   =  empty($nameArr[2]) ? $middleName : $lastName;
        $middleName =  !empty($nameArr[2]) ? $middleName : "";
        return [$firstName,$middleName,$lastName];
   }
}
/*
 *?Remove multiple whitespaces (extra space remove)
 */
if(!function_exists('removeWhiteSpace')){
   function removeWhiteSpace(string $name=null):string{
        $name   =  preg_replace('/\s+/', ' ', $name);
        $name   = trim($name); //Remove Left And Right Space
        return $name;
   }
}
/*
 *?GateAllow
 */
if(!function_exists('GateAllow')){
   function GateAllow(string $ability):bool{
        return Gate::allows($ability);

   }
}

/*
 *?GateAllow
 */
if(!function_exists('dotBtn')){
    function dotBtn(mixed $status,string $type=null):string{
        $class = "success";
        switch ($status) {
            case Quote::DRAFT:
                $class = "dark";
                break;
            case Quote::NEW:
                $class = "success";
                break;
            case Quote::ACTIVEREQUEST:
                $class = "warning";
                break;
            case Quote::PROCESS:
                $class = "info";
                break;
            case Quote::APPROVE:
                $class = "primary";
                break;
            case Quote::DECLINE:
                $class = "danger";
                break;
            case Quote::DELETE:
                $class = "danger";
                break;
            default:
                break;
        }

        $btn = "<button type='button' class='btn btn-{$class} btn-circle btn-xsm ml-1'></button>";
        return $btn;
    }
 }

/*
 *?groupArray
 */
if(!function_exists('arrayFormatGroup')){
   function arrayFormatGroup(array $array):array{
      $newArr = [];
       foreach ($array as $keyOne => $arr) {
           if(!empty($arr)){
               foreach ($arr as $keyTwo => $value) {
                  $newArr[$keyOne] = $value;
               }
           }
       }
       return $newArr;
   }
}

/*
  Usersname create and saveDatabase
 */
if(!function_exists('dbUsername')){
   function dbUsername(string $prefix=null,int $count=0):string{
	$date = date('njy');
    if($count < 10){
        $username = $prefix.$date.'0000'.$count;
    }else if ($count < 100){
        $username = $prefix.$date.'000'.$count;
    }else if ($count < 1000){
        $username = $prefix.$date.'00'.$count;
    }else if ($count < 10000){
        $username = $prefix.$date.'0'.$count;
    }else {
        $username = $prefix.$date.$count;
    }
    return $username;

   }
}

/*
  Usersname create and saveDatabase
 */
if(!function_exists('idCount')){
    function idCount(string $prefix=null,int $count=0):string{
     if($count < 10){
         $username = $prefix.'0000'.$count;
     }else if ($count < 100){
         $username = $prefix.'000'.$count;
     }else if ($count < 1000){
         $username = $prefix.'00'.$count;
     }else if ($count < 10000){
         $username = $prefix.'0'.$count;
     }else {
        $username = $prefix.$count;
     }
     return $username;

    }
 }

/*
 *?Generating a random password use larave  Support Str function
 */
if(!function_exists('randomPassword')){
    function randomPassword(int $length=8):string {
       return Str::random($length);
    }
}


/*
 *?Generating a random password use larave  Support Str function
 */
if(!function_exists('randomPasswordUser')){
    function randomPasswordUser(int $userType=null,$data=null):string {
        if(empty($data)){
           $data = UserSecuritySetting::getData(['type'=>$userType])->first();
        }
        $length                     = 8;
        $length                     = $data?->minimum_length ?? $length;
        $minimumDigit               = $data?->minimum_digits ?? 1;
        $minimumUpperCaseLetter     = $data?->minimum_upper_case_letters ?? 1;
        $minimumLowerCaseLetter     = $data?->minimum_lower_case_letters ?? 1;
        $minimumSpecialCharacters   = $data?->minimum_special_characters ?? 1;
        $specialCharacters          = $data?->special_characters ?? '!@#$%^&*()<>-_^';
        $charactersLength           = strlen($specialCharacters);

        $passWord = '';
        //Create contents of the password
        for ($i = 0; $i < $minimumUpperCaseLetter; $i++) {
            $passWord .= chr(rand(65, 90));
        }
        for ($i = 0; $i < $minimumLowerCaseLetter; $i++) {
            $passWord .= chr(rand(97, 122));
        }
        for ($i = 0; $i < $minimumDigit; $i++) {
            $passWord .= (rand(0, 9));
        }
        for ($i = 0; $i < $minimumSpecialCharacters; $i++) {
            $passWord .= $specialCharacters[rand(0, $charactersLength - 1)];
        }

        $passwordLength = strlen($passWord);
        if($passwordLength < $length){
            $remeningLength = $length - $passwordLength;
            $passWord .= time();
        }

        $passWord = Str::limit($passWord, $length, $end = '');
        return $passWord;
    }
}
/*
 *?Remove Sepicel Icon
 */
if(!function_exists('replaceIntvalues')){
    function replaceIntvalues(string $int = null):int{
        if(!empty($int)){
                $int = str_ireplace([',','$','%'],'',$int);
        }
        return (int)$int;
    }
}
/*
 *?dbDateFormat Sepicel Icon
 */
if(!function_exists('dbDateFormat')){
    function dbDateFormat(string $date = null){
        if(!empty($date)){
               // $date = str_ireplace(['/','.'],'-',$date);

                $date = date('Y-m-d',strtotime($date));
              //  dd($date);
        }
        return $date;
    }
}

/*
 *?Change Date Formate
 */
if(!function_exists('changeDateFormat')){
    function changeDateFormat(string $date = null,bool $onlyDate = false,$format=null):string{
        $companyData = request("company_data");
        if($date == '0000-00-00'){
            return '';
        }
        $dateFormat  = !empty($companyData->date_format) ? $companyData->date_format : '';
        $dateFormatOther  = !empty($companyData->date_format_value) ? $companyData->date_format_value : $dateFormat;
        $timeFormat  = !empty($companyData->time_format) ? $companyData->time_format : '';
        $timeFormatOther  = !empty($companyData->time_format_value) ? $companyData->time_format_value : $timeFormat;
        $timeFormatOther  = !empty($timeFormatOther) ? $timeFormatOther : "h:i A";
        $dateFormatOther  = !empty($dateFormatOther) ? $dateFormatOther : "m/d/Y";

        $format = $onlyDate == false ? "{$dateFormatOther} {$timeFormatOther}" : $dateFormatOther;
        $format = !empty($format) ? $format : $format;
        $date   = !empty($date) ? $date : now();
        $date   = date($format,strtotime($date));
        return $date;
    }
}

/*
 *?Change Time Formate
 */
if(!function_exists('changeTimeFormat')){
    function changeTimeFormat(string $time = null,$format=null):string{
        $companyData = request("company_data");
        $timeFormat  = !empty($companyData->time_format) ? $companyData->time_format : '';
        $timeFormatOther  = !empty($companyData->time_format_value) ? $companyData->time_format_value : $timeFormat;
        $timeFormatOther  = !empty($timeFormatOther) ? $timeFormatOther : "h:i A";
        $format = $timeFormatOther;
		$date   = !empty($time) ? date('Y-m-d').' '.$time : now();
		$formatTime   = date($format,strtotime($date));
        return $formatTime;
    }
}

/*
 *?Data Is encrypt
 */
if(!function_exists('encryptData')){
    function encryptData(string $data = null):string{
        return Encrypter::encrypt($data);
    }
}

/*
 *?Data Is decrypt
 */
if(!function_exists('decryptData')){
    function decryptData(string $str = null){
        $str =  isEncryptValue($str) == true ? Encrypter::decrypt($str) : $str;
        return $str;
    }
}


/*
 *?Id And Url ParameterIs encrypt
 */
if(!function_exists('encryptUrl')){
    function encryptUrl(string $data = null):string{
        $val = encryptData($data);
        $val = str_replace("/","----",$val);
        return $val;
    }
}

/*
 *?Id And Url Parameter Is  decrypt
 */
if(!function_exists('decryptUrl')){
    function decryptUrl(string $data = null):string{
        $data = str_replace("----","/",$data);
        $val = decryptData($data);
        return $val;
    }
}
/*
 *?Chekc encryp value
 */
if(!function_exists('isEncrypt')){
    
    function isEncryptValue($str){
        if((!is_null($str) && $str != '')){
            $str = str_replace("----","/",$str);
          /*   print_r($str); */
            return (bool)preg_match('%^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$%', $str);
        }
        return false;

    }
}

/*
 *?Route Check
 */
if(!function_exists('routeCheck')){
    function routeCheck(string $name = null,mixed $agr=null):string{
        if($agr){
            return Route::has($name) ? route($name,$agr) : '';
        }
        return Route::has($name) ? route($name) : '';
    }
}
/*
 *?Databse Check
 */
if(!function_exists('databseCheck')){
    function databseCheck(string $dbname = null):bool{
        // Create connection
        $servername = config("database.connections.mysql.host");
        $username   = config("database.connections.mysql.username");
        $password   = config("database.connections.mysql.password");
        try {
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            $isConnection = true;
            if ($conn->connect_error) {
            $isConnection = false;
            }
            $conn->close();
        } catch (\Throwable $th) {
           $isConnection = false;
        }
        return $isConnection;
    }
}
/*
 *?url Check is valid and Exists
 */
if(!function_exists('urlExists')){
    function urlExists($url) {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if($httpCode >= 200 && $httpCode <= 400) {
            return true;
        } else {
            return false;
        }
    }
}
/*
 *? Page Title Get In Controller Property pageTitle
 */
if(!function_exists('dynamicPageTitle')){
    function dynamicPageTitle(string $type = null,string $wordType = null):string{
       $method     = Route::getCurrentRoute()->getAction();
       $controller = $method['controller'] ?? [];
       if(!empty($controller)){

            list($controllerPath,$actionFunction) = explode("@",$controller);
            $pageTitle  = app($controllerPath)?->pageTitle ?? '';
            $methodArr  = ['create'=>"Add",'edit'=>"",'login'=>'Login'];
            $actionName = isset($methodArr[$actionFunction]) ? $methodArr[$actionFunction] : "" ;
            if(!empty($actionFunction) && $actionFunction == "index" && $wordType !== "isSingular"){
                $pageTitle  = !empty($pageTitle) ? Str::plural($pageTitle) : $pageTitle ;
            }

            if($type == 'page'){
                $pageTitle  = !empty($pageTitle) ? "{$actionName} {$pageTitle}" : '';
            }else if($type == 'logs'){
                $pageTitle  = !empty($pageTitle) ? "{$pageTitle}" : '';
            }else{
                $mainAppName = config('app.name');
                if(!empty($pageTitle) && empty($actionName)){
                     $pageTitle  = "{$pageTitle} - {$mainAppName}";
                }elseif(!empty($pageTitle) && !empty($actionName)){
                     $pageTitle  = "{$actionName} {$pageTitle} - {$mainAppName}";
                }else{
                      $pageTitle  = $mainAppName;
                }

            }
       }else{
            $pageTitle = config('app.name');
       }
       $pageTitle =  preg_replace('/\s+/', ' ', $pageTitle);
       return $pageTitle;
    }
}

/*
 *? Active page get in controller
 */
if(!function_exists('activePageName')){
    function activePageName(string $type = null):string{
        $method     = Route::getCurrentRoute()->getAction();
        $controller = $method['controller'] ?? "";
        if(!empty($controller)){
            list($controllerPath) = explode("@",$controller);
            $activePage  = app($controllerPath)?->activePage ?? '';
            return $activePage;
        }
        return '';
    }
}

/*
 *? Aray Filter Spik Value
 */
if(!function_exists('arrFilterSkipValue')){
    function arrFilterSkipValue($var){
        return ($var !== NULL);
    }
}

/*
 *? Aray Filter Check Arr
 */
if(!function_exists('arrFilter')){
    function arrFilter(array $values = null):array{
        $res = array_filter($values, 'arrFilterSkipValue');
        return $res;
    }
}

/*
 *? Add Extrat Html tag with imploade function
 */
if(!function_exists('wrapImplode')){
    function wrapImplode($array, $before = '', $after = '', $separator = '' ){
        if( ! $array ) return '';
        return $before . implode("{$after}{$separator}{$before}", $array ) . $after;
    }
}

/*
 *? Logs Format set
 */
if(!function_exists('dbLogFormat')){
    function dbLogFormat(array $logsArr = null):string{
        $logsArr = !empty($logsArr) ? array_reduce($logsArr, 'array_merge', array()) : [] ;
        $logsArr = !empty($logsArr) ? array_column($logsArr,'msg') : [] ;
        $lis     = wrapImplode($logsArr, "<li>", "</li>");
        $logsmsg = !empty($lis) ? $lis : '';
        /* dd($logsmsg); */
        return $logsmsg;
    }
}


/*
 *? Logs Create msg
 */
if(!function_exists('logsMsgCreate')){
    function logsMsgCreate(array $getChanges = [],array $titleArr = null,$logsArr=null){
        if(isset($getChanges['updated_at'])){
            unset($getChanges['updated_at']);
        }

        $msg = $preValue = $newValue = "" ;

        if(!empty($getChanges)){
           foreach ($getChanges as $key => $value) {
               $isPercentage = $isDoller = "" ;

               $old = !empty($value['old']) ? $value['old'] : '';
               $new = !empty($value['new']) ? $value['new'] : '';
               $title  = !empty($titleArr[$key]['title']) ? $titleArr[$key]['title'] : '';
               $class  = !empty($titleArr[$key]['class']) ? $titleArr[$key]['class'] : '';
               $tagType = !empty($titleArr[$key]['tagType']) ? $titleArr[$key]['tagType'] : '';
               $optArray = !empty($titleArr[$key]['optionArr'][$key]) ? $titleArr[$key]['optionArr'][$key] : '';

               $msg   .= !empty($msg) ? "" : '' ;
               if(Str::contains($class, ['percentage_input', 'percentageinput']) && $tagType != 'select'){
                    $isPercentage = "%";
               }elseif(Str::contains($class, ['amount']) && $tagType != 'select'){
                    $isDoller = "$";
                    $old = floatval($old);
                    $new = floatval($new);
                    $old = number_format($old,2);
                    $new = number_format($new,2);
               }elseif($tagType == 'select'){
                   $old = isset($optArray[$old]) ? $optArray[$old] : '' ;
                   $new = isset($optArray[$new]) ? $optArray[$new] : '' ;
               }

               if (empty($old)) {
                  $msgTitle = "<li> {$title} was updated to <b>{$isDoller}{$new}{$isPercentage}</b> </li>";
               } else {
                 $msgTitle = "<li> {$title} was changed from <b>{$isDoller}{$old}{$isPercentage}</b> to
                 <b>{$isDoller}{$new}{$isPercentage}</b> </li>";
               }

               if(Str::contains($class, ['templateEditor'])){
                    $msgTitle = "<li><a href='javascript:void(0)' class='templateEditorLogsPreview'
                         data-id='{LOGSID}'>{$title} was changed</a> </li>";
                    $preValue = $old;
                    $newValue = $new;
               }
               $msg .= isset($logsArr[$key]) ? "" : removeWhiteSpace($msgTitle) ;
           }
           return (object)['msg'=>$msg,'preValue'=>$old,'newValue'=>$new];
       }
    }
}


function setEnv($key, $value)
{

	 file_put_contents(app()->environmentFilePath(),str_replace(
		($key . '=' .env($key)),
		($key . '=' .$value),
		file_get_contents(app()->environmentFilePath())
	));
}


function ordinalNum($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}


function arrayColumn($array,$key) {
  /*   dd($array); */
    $newArr = [];
    foreach($array as $arr){
        $newArr[$arr[$key]][] =  $arr;
    }
    return  $newArr;
}





/*
 *? Logs Format set
 */
if(!function_exists('dateDiff')){
    function dateDiff(string $dateOne = null,string $dateTwo = null){
        $dateOne = !empty($dateOne) ? date('Y-m-d',strtotime($dateOne)) :null;
        $dateTwo = !empty($dateTwo) ? date('Y-m-d',strtotime($dateTwo)) : date('Y-m-d');

        $interval = null;
        if(!empty($dateOne) && !empty($dateTwo)){
            $datetime1 = new DateTime($dateOne);
            $datetime2 = new DateTime($dateTwo);
            $interval = $datetime1->diff($datetime2);
        }
        return $interval;
    }
}



if(!function_exists('tanValueGat')){
    function tanValueGat(int $number){
        $number 	= $number <= 9 ? ("0".$number) : $number ;
        $isFirst 	= (int)substr($number,0, -1) ;
        $isTanDiv 	= (int)$number%10;
        $isFirst  	= $isTanDiv === 0 ? $isFirst : $isFirst + 1;
        return $isFirst*10;
    }
}