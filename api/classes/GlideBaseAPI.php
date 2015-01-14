<?php
require "../helperClasses/medoo.php";
require "../helperClasses/Util.php";

class GlideBaseAPI{

	/**
     * Name: self::connectDB
     * Purpose: Connect to mysql database
     * @return $database - object : database object
     */
    public static function connectDB(){
        $database = new medoo([
            "database_type" => "mysql",
            "database_name" => "glide",
            "server" => "localhost",
            "username" => "root",
            "password" => "root"
        ]);
        return $database;
    }


    /**
     * Name: uploadReceipt
     * Purpose: Retrieve uploaded image and move to upload folder and 
     *          add to database. 
     */
    public static function uploadReceipt(){

        $databasePath = "../uploads/receiptImages/";
        $storePath = "../../uploads/receiptImages/";
        $database = GlideBaseAPI::connectDB();

        $filename = basename($_FILES['file']['name']);
        $storePath = $storePath . $filename;
        $databasePath = $databasePath . $filename;


        if(move_uploaded_file($_FILES["file"]["tmp_name"], $storePath)){

            $receiptId = $database->insert("receipts", [
                "receipt_image" => $databasePath
            ]);

            echo $receiptId;
            
        }else{
            echo "Error : Receipt not Uploaded !";
        }
    }

    
    /**
     * Name: processMerchant
     * Purpose: Get merchant id or add new merchant then get id
     * @param $marchantName - String : Contains merchant name.
     * @return $merchantId - Int : Contains merchant id.
     */
    public static function processMerchant($merchantName, $adminId){
    
        $database = GlideBaseAPI::connectDB();
        
        $merchantId = $database->select("merchants", [ "merchant_id"],[
            "AND" => [
                "merchant_name" => $merchantName,
                "admin_id" => $adminId
            ]
        ]);

        if(empty($merchantId)){
            $merchantId = $database->insert("merchants", [
                "merchant_name" => $merchantName,
                "admin_id" => $adminId
                
            ]);
            return $merchantId;
        }

        return $merchantId[0]["merchant_id"];
    }


    /**
     * Name: getAdminId
     * Purpose: Get admin id from either the session if a request is made from the web app 
     *          or the adminId parameter if request is made from the phone app.
     * @param $adminId - int : if exists returns admin id else null.
     */
    public static function getAdminId(){

        session_start();
        $adminId = null;

        if(isset($_SESSION["adminId"])){
            $adminId = $_SESSION["adminId"];
        }else{
            $adminId = Util::get("adminId");
        }
        return $adminId;
    }

    
    
    /**
     * Name: addExpense
     * Purpose: Add expense to expense table
     */
    public static function addExpense(){

        $adminId = GlideBaseAPI::getAdminId();  

        if($adminId){

            $userName = Util::get("userName");
            $userId = Util::get("userId");
            $category = Util::get("category");
            $merchant = Util::get("merchant");
            $cost = Util::get("cost");
            $account = Util::get("account");
            $receiptId = Util::get("receiptId");
            $comment = Util::get("comment");
            $log = array();
            $log["table"] = "expenses";
            $log["type"] = "addExpense";
            $log["errors"] = array();
            $database = GlideBaseAPI::connectDB();

            if($receiptId == ""){
                $receiptId = 1;
            }

            if(empty($userName)){
                $log["errors"]["userName"] = "User Name is required";   
            }else{
                $userExists = $database->count("users", [
                "AND" => [
                    "user_id" => $userId,
                    "user_name" => $userName,
                    "admin_id" => $adminId
                    ]
                ]);
                if($userExists == 0){
                    $log["errors"]["userName"] = "User Name doesn't exist";   
                }
            }

            if(empty($userId)){
                $log["errors"]["userId"] = "User ID is required";
            }

            if(empty($merchant)){
                $log["errors"]["merchant"] = "Merchant is required";
            }

            if(empty($cost)){
                $log["errors"]["cost"] = "Cost is required";
            }   

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{

                //get merchant id or add new merchant
                $merchantId = GlideBaseAPI::processMerchant($merchant, $adminId);

                $lastExpenseId = $database->insert("expenses", [
                    "admin_id" => intval($adminId),
                    "user_id" => intval($userId),
                    "merchant_id" => $merchantId,
                    "receipt_id" => $receiptId,
                    "expense_category" => $category,
                    "expense_cost" => $cost,
                    "account" => $account,
                    "expense_comment" => $comment
                    
                ]); 

                echo json_encode($log);  
            }

        }else{
            $log["errors"]["adminId"] = "Admin ID not set";
            echo json_encode($log);
        }
    }

    /**
     * Name: addJourney
     * Purpose: Add journey to journey table
     */
    public static function addJourney(){

        $adminId = GlideBaseAPI::getAdminId(); 
        
        if($adminId){
            $userName = Util::get("userName");
            $userId = Util::get("userId");
            $origin = Util::get("origin");
            $destination = Util::get("destination");
            $distance = Util::get("distance");
            $journeyTime = Util::get("journeyTime");
            $date = Util::get("date");
            $account = Util::get("account");
            $comment = Util::get("comment");
            $log = array();
            $log["type"] = "addJouney";
            $log["errors"] = array();
            $database = GlideBaseAPI::connectDB();
            
            //$adminId = $_SESSION["adminId"];

            $userExists = $database->count("users", [
                "AND" => [
                    "user_id" => $userId,
                    "user_name" => $userName,
                    "admin_id" => $adminId
                ]
            ]);

            if($userExists == 0){
                $log["errors"]["user"] = "User doesn't exist";
                echo json_encode($log);
            }else{

                $lastJourneyId = $database->insert("journeys", [
                    "admin_id" => intval($adminId),
                    "user_id" => intval($userId),
                    "origin" => $origin,
                    "destination" => $destination,
                    "distance" => $distance,
                    "journey_time" => $journeyTime,
                    "account" => $account,
                    "comment" => $comment  
                ]);
                
                echo json_encode(array("table" => "journeys", "status" => "New journey added..."));  
            }


        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
        
    }


    

}

?>