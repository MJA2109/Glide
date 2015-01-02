<?php
require "GlideBaseAPI.php";

class GlideMobileAPI extends GlideBaseAPI{


	

	/**
     * Name: getExpenseHistory
     * Purpose: Get data from expenses table.
     */
	public static function getExpenseHistory(){

		$database = GlideBaseAPI::connectDB();

		$adminId = Util::get("adminId");
		$userId = Util::get("userId");
		$mostRecentExpense = Util::get("mostRecentExpense");
        
        $history = $database->select("expenses" , [

				"[>]merchants" => ["merchant_id" => "merchant_id"],

        	],[
        		"expense_id",
        		"expense_date",
        		"merchant_name",
        		"expense_cost",
        		"expense_category"

        	], [
			"AND" => [
	            "expenses.admin_id" => $adminId,
	            "user_id" => $userId,
	            "expense_id[>]" => $mostRecentExpense
	        ]
        ]);

        if($history){
        	echo json_encode($history);	
        }
	}

	public static function getJourneyHistory(){

		$database = GlideBaseAPI::connectDB();

		$adminId = Util::get("adminId");
		$userId = Util::get("userId");
		$mostRecentExpense = Util::get("mostRecentExpense"); 

		$history = $database->select("journeys" ,[
        		
        		"id",
        		"date",
        		"origin",
        		"destination",
        		"journey_time",
        		"distance"

        	], [
			"AND" => [
	            "admin_id" => $adminId,
	            "user_id" => $userId,
	            "id[>]" => $mostRecentExpense,
	            "is_deleted" => 0
	        ]
        ]);

        if($history){
        	echo json_encode($history);	
        }
	}
}

?>