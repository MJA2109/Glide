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
     * Name: processMerchant
     * Purpose: Get merchant id or add new merchant then get id
     * @param $marchantName - String : Contains merchant name.
     * @return $merchantId - Int : Contains merchant id.
     */
    public static function processMerchant($merchantName, $adminId){
    
        $database = GlideBaseAPI::connectDB();
        
        $merchantId = $database->select("merchants", [ "merchant_id"],[
            "merchant_name" => $merchantName
        ]);

        if(empty($merchantId)){
            $merchantId = $database->insert("merchants", [
                "merchant_name" => $merchantName,
                "admin_id" => $adminId
            ]);
        }

        return $merchantId;
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
            $comment = Util::get("comment");
            $log = array();
            $log["type"] = "addExpense";
            $log["errors"] = array();
            $database = GlideBaseAPI::connectDB();
            
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
                
                //get merchant id or add new merchant
                $merchantId = GlideBaseAPI::processMerchant($merchant, $adminId);
                
                $lastExpenseId = $database->insert("expenses", [
                    "admin_id" => intval($adminId),
                    "user_id" => intval($userId),
                    "merchant_id" => intval($merchantId),
                    "expense_category" => $category,
                    "expense_cost" => $cost,
                    "expense_comment" => $comment,
                    
                ]);
                echo json_encode(array("table" => "expenses", "status" => $lastExpenseId));  
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }


    

}

?>