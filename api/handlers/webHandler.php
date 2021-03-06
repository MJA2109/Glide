<?php
require "../classes/GlideWebAPI.php";

//Call public static function based on posted action
if(isset($_POST["action"])){
	$action = $_POST["action"];
	switch($action){
	    case "register" : GlideWebAPI::register();
	    break;
	    case "signIn" : GlideWebAPI::signIn();
	    break;
	    case "signOut" : GlideWebAPI::signOut();
	    break;
	    case "getExpensesData" : GlideWebAPI::getExpensesData();
	    break;
	    case "getUsersData" : GlideWebAPI::getUsersData();
	    break;
	    case "getJourneysData" : GlideWebAPI::getJourneysData();
	    break;
	    case "addExpense" : GlideWebAPI::addExpense();
	    break;
	    case "addJourney" : GlideWebAPI::addJourney();
	    break;
	    case "addUser" : GlideWebAPI::addUser();
	    break;
	    case "deleteData" : GlideWebAPI::deleteData();
	    break;
	    case "searchExpenses" : GlideWebAPI::searchExpenses();
	    break;
	    case "searchJourneys" : GlideWebAPI::searchJourneys();
	    break;
	    case "searchUsers" : GlideWebAPI::searchUsers();
	    break;
	    case "editExpense" : GlideWebAPI::editExpense();
	    break;
	    case "editJourney" : GlideWebAPI::editJourney();
	    break;
	    case "editUser" : GlideWebAPI::editUser();
	    break;
	    case "pmSignIn" : GlideWebAPI::pmSignIn();
	    break;
	    case "doesUserExist" : GlideWebAPI::doesUserExist();
	    break;
	    case "isAvailable" : GlideWebAPI::isAvailable();
	    break;
	    case "getChartData" : GlideWebAPI::getChartData();
	    break;
	    case "getWidgetData" : GlideWebAPI::getWidgetData();
	    break;
	    case "availableEmail" : GlideWebAPI::availableEmail();
	    break;
	    case "saveNotes" : GlideWebAPI::saveNotes();
	    break;
	    case "getNotes" : GlideWebAPI::getNotes();
	    break;
	    case "getTopMerchants" : GlideWebAPI::getTopMerchants();
	    break;
	}
}





?>