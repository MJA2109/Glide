<?php

require "../classes/GlideMobileAPI.php";

//Call public static function based on posted action
if(isset($_POST["action"])){
	//var_dump($_POST);
	$action = $_POST["action"];
	switch($action){
		case "addExpense" : GlideMobileAPI::addExpense();
	    break;
	    case "uploadReceipt" : GlideMobileAPI::uploadReceipt();
	    break;
	    case "addJourney" : GlideMobileAPI::addJourney();
	    break;
	    case "getExpenseHistory" : GlideMobileAPI::getExpenseHistory();
	    break;
	    case "getJourneyHistory" : GlideMobileAPI::getJourneyHistory();
	    break;
	    case "appLogin" : GlideMobileAPI::appLogin();
	    break;

	}
}

?>