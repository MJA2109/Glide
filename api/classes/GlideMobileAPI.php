<?php
require "GlideBaseAPI.php";

class GlideMobileAPI extends GlideBaseAPI{


	/**
     * Name: appLogin
     * Purpose: Check does user exist in system.
     */
	public static function appLogin(){

		$database = GlideBaseAPI::connectDB();

		$email = Util::get("loginEmail");
		$password = $_POST["password"];
		$hashedPassword = sha1($password);
		$instanceId = Util::get("instanceId");

		$auth = $database->select("users", [
			
			"user_id",
			"user_name"

			], [
			"AND" => [
				"user_email" => $email,
				"admin_id" => $instanceId,
				"user_password" => $hashedPassword,
				"is_deleted" => 0
			]

		]);

		if($auth){
			$auth[0]["password"] = $password;
			echo json_encode($auth);
		}else{
			echo json_encode(false);
		}
	}
	
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


	/**
     * Name: getJourneyHistory
     * Purpose: Get data from journey table.
     */
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