<?php

require "../classes/GlideMobileAPI.php";

//Call public static function based on posted action
if(isset($_POST["action"])){
	$action = $_POST["action"];
	switch($action){
		case "addExpense" : GlideMobileAPI::addExpense();
	    break;
	    case "uploadReceipt" : GlideMobileAPI::uploadReceipt();
	    break;

	}
}

?>