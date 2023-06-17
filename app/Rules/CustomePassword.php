<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\UserSecuritySetting;
class CustomePassword implements Rule
{
    public const LENGTH = 8;
    public const DIGITS = 2;
    public const UPPERLETTER = 2;
    public const LOWERLETTER = 2;

    public $message = null;
    public $type = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $type = 0)
    {
        $this->type = $type;
    }

    /*-- String Check white space--*/
    private function whitespace($string){
        return !preg_match('/\s+/', $string);
    }

    /*-- String Lenght Check--*/
    private function lenght(int $length,$value){
       return strlen($value) >= $length;
    }

    /* Get All upper Case Text (Capital Letter)*/
    private function upperCaseText($value){
       $checkAllLettar =  preg_match_all('/[A-Z]/', $value, $matches);
       $letter = !empty($matches[0]) ? implode('', $matches[0]) : null;
       return $letter;
    }

    /* Get upper Case Text Lenght (Capital Letter Length)*/
    private function upperCaseTextLenth($value,int $length){
        $text = $this->upperCaseText($value);
        return !empty($text) ? $this->lenght($length,$text) : false;
    }

    /* Get All Lower Case Text */
    private function lowerCaseText($value){
       $checkAllLettar = preg_match_all('/[a-z]/', $value, $matches);
       $letter = !empty($matches[0]) ? implode('', $matches[0]) : null;
       return $letter;
    }

    /* Get Lower Case Text Lenght */
    private function lowerCaseTextLenth($value,int $length){
        $text = $this->lowerCaseText($value);
       return $this->lenght($length,$text);
    }

    /* Get All numeric Number */
    private function digits($value){
       $checkAllLettar = preg_match_all('/[0-9]/', $value, $matches);
       $letter = !empty($matches[0]) ? implode('', $matches[0]) : null;
       return $letter;
    }

     /* Get All numeric Number Lenght */
    private function digitsLenth($value,int $length){
        $text = $this->digits($value);
       return $this->lenght($length,$text);
    }
	
	/* Get All numericpecial Characters */
    private function getspecialCharacters($value){
        $pattern = "/[^\w\s]/u"; // Match any character that is not a word character or whitespace
		preg_match_all($pattern, $value, $matches);
		$matches = isset($matches[0]) ? $matches[0] : [];
        return $matches;
    }
	
	

    /* Get All Special Characters and check allow Special Characters */
    private function checkSpecialCharacters($value,$specialCharacters){
       $pattern = "/[^\w\s]/u"; // Match any character that is not a word character or whitespace
       preg_match_all($pattern, $value, $matches);
       $matches = isset($matches[0]) ? $matches[0] : [];
       $specialCharacters = !empty($specialCharacters) ? preg_split("//",$specialCharacters, -1, PREG_SPLIT_NO_EMPTY) : [] ;
       if(!empty($specialCharacters) && empty($matches)){
		    return  false;
	   }
	   $arrDiffrenc = array_diff($matches,$specialCharacters);
	
       return empty($arrDiffrenc) ? true : false;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $UserSecuritySetting        = UserSecuritySetting::getData(['type'=>$this->type])->first();
        $length                     = $UserSecuritySetting?->minimum_length ?? 8;
        $minimumDigit               = $UserSecuritySetting?->minimum_digits ?? null;
        $minimumUpperCaseLetter     = $UserSecuritySetting?->minimum_upper_case_letters ?? null;
        $minimumLowerCaseLetter     = $UserSecuritySetting?->minimum_lower_case_letters ?? null;
        $minimumSpecialCharacters   = $UserSecuritySetting?->minimum_special_characters ?? null;
        $specialCharacters          = $UserSecuritySetting?->special_characters ?? null;


        if($this->whitespace($value) == false){
            $this->message = "Password should not contain any space.";
            return false;
        }

        if($this->lenght($length,$value) == false){
            $this->message = "Password length should be minimum {$length}.";
            return false;
        }

        if(!empty($minimumUpperCaseLetter) && $this->upperCaseTextLenth($value,$minimumUpperCaseLetter) == false){
            $this->message = "Password should contain at least {$minimumUpperCaseLetter} uppercase letter(A-Z).";
            return false;
        }

        if(!empty($minimumLowerCaseLetter) && $this->lowerCaseTextLenth($value,$minimumLowerCaseLetter) == false){
            $this->message = "Password should contain at least {$minimumLowerCaseLetter} lowercase letter(a-z).";
            return false;
        }

        if(!empty($minimumDigit) && $this->digitsLenth($value,$minimumDigit) == false){
            $this->message = "Password should contain at least {$minimumDigit} digit(0-9).";
            return false;
        }
		
		if(!empty($minimumSpecialCharacters) && count($this->getspecialCharacters($value)) < $minimumSpecialCharacters){
            $this->message = "Password should contain at least {$minimumSpecialCharacters} special character.";
            return false;
        }

        if(!empty($specialCharacters) && $this->checkSpecialCharacters($value,$specialCharacters) == false){
            $this->message = "Password should contain at special character ({$specialCharacters}).";
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
