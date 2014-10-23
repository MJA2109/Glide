<?php
/**
 * Util helper class
 * Contains commonly used functions 
 */
class Util{

	/**
	 * Name: get
	 * Purpose: Get and clean posted data
	 * @param string $input : posted data
	 * @return string $cleanInput : cleaned input
	 */
	public static function get($input){
    	$input = mysql_real_escape_string($_POST[$input]);
    	$input = trim($input);
    	$input = ucwords(strtolower($input));
    	$cleanInput = htmlspecialchars($input); 
    	return $cleanInput;
	}

	/**
	 * Name: validateEmail
	 * Purpose: Checks whether input is validate email address
	 * @param string $email : posted email address
	 * @return boolean $valid : is email valid
	 */
	public static function validateEmail($email){
		$valid = filter_var($email, FILTER_VALIDATE_EMAIL);
		return $valid;
	}

}
?>