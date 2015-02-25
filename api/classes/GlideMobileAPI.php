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

		$company = $database->select("companies" , [

				"[>]admins" => ["company_id" => "company_id"],

        	],[
        		"company_name"

        	], [
			"AND" => [
	            "admins.admin_id" => $instanceId
	        ]
        ]);



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
			$auth[0]["company"] = $company[0]["company_name"];
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
              "expenses.is_deleted" => 0,
	            "user_id" => $userId,
	            "expense_id[>]" => $mostRecentExpense,
              "expense_status" => "Processed"
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
	            "is_deleted" => 0,
              "status" => "Processed"
	        ]
        ]);

        if($history){
        	echo json_encode($history);	
        }
	}


	/**
     * Name: isOnline
     * Purpose: Update user online status
     */
	public static function isOnline(){

		$database = GlideBaseAPI::connectDB();
		$adminId = Util::get("adminId");
		$userId = Util::get("userId");
		$status = (int) Util::get("status");

		$database->update("users", [
                    "is_online" => $status
                ],[ "AND" => [
                    "user_id" => $userId,
                    "admin_id" => $adminId
                   ]
                ]);

		echo json_encode(array( 'status' => $status, 'adminId' => $adminId, 'userId' => $userId));		
	}


	public static function getAccountInfo(){

		$database = GlideMobileAPI::connectDB();
		$userEmail = Util::get("userEmail");
		$adminId = Util::get("adminId");
		$userId = GlideMobileAPI::getUserId($userEmail, $adminId);

		$noOfExpenses = $database->count("expenses", [
            "AND" => [
                "user_id" => $userId,
                "is_deleted" => 0,
                "expense_status" => "processed"
            ]
        ]);

        $noOfJourneys = $database->count("journeys", [
        	"AND" => [
        		"user_id" => $userId,
        		"is_deleted" => 0,
        		"status" => "processed"
        	]	
        ]);

        $totalClaims = $noOfJourneys + $noOfExpenses;

        echo json_encode(array("totalClaims" => $totalClaims));
	}


	public static function getClaimsInfo(){

		$database = GlideMobileAPI::connectDB();
		$userEmail = Util::get("userEmail");
		$adminId = Util::get("adminId");
		$userId = GlideMobileAPI::getUserId($userEmail, $adminId);

		$sql_1 = "SELECT expense_category, ROUND(SUM(expense_cost), 2) as total_cost
                  FROM expenses
                  WHERE admin_id = $adminId
                  AND is_deleted = 0 
                  AND expenses.expense_approved <> 'Awaiting...'
                  AND user_id = $userId[0]
                  AND expense_status = 'processed'
                  GROUP BY expense_category ";

        
        $sql_2 = "SELECT ROUND(SUM(distance * user_mileage_rate), 2) as mileage
                  FROM users ur, journeys jn
                  WHERE ur.user_id = jn.user_id
                  AND ur.user_id = $userId[0]
                  AND ur.admin_id = $adminId
                  AND jn.is_deleted = 0
                  AND ur.is_deleted = 0 
                  AND ur.user_mileage_rate > 0 
                  AND jn.approved <> 'Awaiting...' 
                  AND jn.status = 'processed' ";


        $categoryCost = $database->query($sql_1)->fetchAll();
        $mileageCost = $database->query($sql_2)->fetchAll();


        $index = 0;
        $last; //used to append mileage and total claims to last position of array

        foreach($categoryCost as $data){
            $accountInfo[$index] = array();
            $accountInfo[$index]["column"] = $data["expense_category"];
            $accountInfo[$index]["colValue"] = $data["total_cost"];
            $index++;
            $last = $index;
        }

        if($mileageCost[0]["mileage"] != null){
            //append mileage cost onto accountInfo
            $accountInfo[$last]["column"] = "Mileage Cost";
            $accountInfo[$last]["colValue"] = $mileageCost[0]["mileage"];
        }



		echo json_encode(array( 'data' => $accountInfo));	

	}
}

?>