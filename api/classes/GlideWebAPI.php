<?php
require "GlideBaseAPI.php";

class GlideWebAPI extends GlideBaseAPI{

    /**
     * Name: register
     * Purpose: Allow users to register an account on the system
     * @return $log - Array: Contains invalid and duplicate data errors 
     */
    public static function register(){

        define("PASSWORD_LENGTH", 8);
        $companyName = Util::get("companyName");
        $adminEmail = Util::get("adminEmail");
        $adminPassword = Util::get("adminPassword");
        $adminRePassword = Util::get("adminRePassword");
        $hashedAdminPassword;
        $validAdminEmail;
        $emailInUse;
        $errorCount;
        $log = array();
        $log["type"] = "registration";
        $log["errors"] = array();


        $database = GlideWebAPI::connectDB();

        //check for invalid data
        if(empty($companyName)){
            $log["errors"]["companyNameErr"] = "Company name required";
        }
        if(empty($adminEmail)){
            $log["errors"]["adminEmailErr"] = "E-mail address required";
        }else{
            $validAdminEmail = Util::validateEmail($adminEmail);
            
            if($validAdminEmail === false){
                $log["errors"]["invalidEmail"] = "Email address is invalid";
            }else{
                //check for duplicate email addresses
                $emailInUse = $database->count("admins", [
                    "admin_email" => $validAdminEmail
                ]);
                if($emailInUse > 0){
                    $log["errors"]["adminEmailInUse"] = "Email address is already registered, try another.";
                }
            }
        }
        if(empty($adminPassword) || empty($adminRePassword)){
            $log["errors"]["adminPasswordErr"] = "Password required";
        }else if(strlen($adminPassword) < PASSWORD_LENGTH ){
            $log["errors"]["adminPasswordErrLength"] = "Password must be at least 8 characters in length";
        }else if($adminPassword != $adminRePassword){
            $log["errors"]["adminPasswordMismatch"] = "Retyped password incorrect";
        }else{
            //$hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
            $hashedAdminPassword = sha1($adminPassword);
        }
        

        //if data is valid input to database
        $errorCount = count($log["errors"]);
        if($errorCount == 0){
            
            //check if company is already registered
            $registeredCompany = $database->count("companies", [
                "company_name" => $companyName
            ]);

            //if regsitered get id, else insert new company and then get id
            if($registeredCompany === 1){     
                $companyID = $database->select("companies", [ "company_id"],[
                    "company_name" => $companyName
                ]);
            }else{
                
                $database->insert("companies", [
                    "company_name" => $companyName
                ]);

                $companyID = $database->select("companies", ["company_id"],[
                    "company_name" => $companyName
                ]);
            }

            $database->insert("admins", [
                "company_Id" => $companyID[0]["company_id"],
                "admin_password" => $hashedAdminPassword,
                "admin_email" => $adminEmail
            ]);
        }

        $logObject = json_encode($log);
        echo $logObject;   
    }




    /**
     * Name: signIn
     * Purpose: Allow users to sign into the system
     * @return $log - Array: Contains admin data error info 
     */
    public static function signIn(){

        define("AUTHORIZED", true);
        $adminEmail = Util::get("adminEmail");
        $adminPassword = Util::get("adminPassword");
        $registeredUser = array();
        $log = array(); 
        $log["type"] = "signIn";
        $log["errors"] = array();
        $log["data"] = array();
        $errorCount;
        $logObject;
        $validAdminEmail;
        $hashedAdminPassword;
        $database;
        
        $database = GlideWebAPI::connectDB();

        if(empty($adminEmail)){
            $log["errors"]["adminEmailErr"] = "E-mail address required";
        }else{
            
            $validAdminEmail = Util::validateEmail($adminEmail);
            
            if($validAdminEmail === false){
                $log["errors"]["invalidEmail"] = "Email address is invalid";
            }
        }
        if(empty($adminPassword)){
            $log["errors"]["adminPasswordErr"] = "Password required";
        }else{
            $hashedAdminPassword = sha1($adminPassword);
        }
        
        $errorCount = count($log["errors"]);

        if($errorCount == 0){ 
            
            $registeredUser = $database->select("admins", "*",[
                    "AND" => [
                        "admin_email" => $validAdminEmail,
                        "admin_password" => $hashedAdminPassword
                    ]
            ]);
            
            if(!empty($registeredUser)){
                session_start();
                $_SESSION["authorized"] = AUTHORIZED;
                $_SESSION["adminEmail"] = $registeredUser[0]["admin_email"];
                $_SESSION["adminId"] = $registeredUser[0]["admin_id"];
                $log["data"]["adminId"] = $registeredUser[0]["admin_id"];
                $log["data"]["adminEmail"] = $registeredUser[0]["admin_email"];
            }else{
                $log["errors"]["incorrectDetails"] = "The details you provided are incorrect";
            }
        }

        $logObject = json_encode($log);
        echo $logObject;
    }


    /**
     * Name: signOut
     * Purpose: Destroys session and allow users to sign out of system
     */
    public static function signOut(){
        session_start();
        session_destroy();
        echo "session is destroyed";
    }


    /**
     * Name: getExpensesData
     * Purpose: Retrieve data from expenses table
     * @return $expense or $error - JSON: Contains rows for each expense related to that specific instance.
     */
    public static function getExpensesData(){
        
        session_start();
        
        if(isset($_SESSION["adminId"])){

            $expense = array();
            $index = 0;
            $expensesData;
            $adminId;
            $error;
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];
            
            //use query public static static function for more complex database queries
            $expensesData = $database->query("SELECT
                                                ex.expense_id,
                                                u.user_name, 
                                                ex.expense_category, 
                                                mer.merchant_name, 
                                                ex.expense_cost, 
                                                ex.expense_date, 
                                                ex.expense_status,
                                                re.receipt_image, 
                                                ex.expense_comment,
                                                ex.account
                                                FROM users u
                                                JOIN expenses ex on ex.user_id = u.user_id
                                                JOIN merchants mer on mer.merchant_id = ex.merchant_id
                                                LEFT JOIN receipts re on re.receipt_id = ex.receipt_id
                                                where
                                                ex.admin_id = '$adminId'
                                                AND ex.is_deleted = 0
                                                ORDER BY ex.expense_id Desc")->fetchAll();

            foreach($expensesData as $data){
                $expense[$index] = array();
                $expense[$index]["DT_RowId"] = $data["expense_id"];
                $expense[$index]["user_name"] = $data["user_name"];
                $expense[$index]["expense_category"] = $data["expense_category"];
                $expense[$index]["merchant_name"] = $data["merchant_name"];
                $expense[$index]["expense_cost"] = $data["expense_cost"];
                $expense[$index]["receipt_image"] = $data["receipt_image"];
                $expense[$index]["expense_status"] = $data["expense_status"];
                $expense[$index]["expense_date"] = $data["expense_date"];
                $expense[$index]["account"] = $data["account"];
                $expense[$index]["expense_comment"] = $data["expense_comment"];
                $index++;
            }

            echo json_encode($expense);
        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
        
    }

    /**
     * Name: getUsersData
     * Purpose: Retrieve data from users table
     * @return $userData or $error - JSON : JSON: Contains rows for each user related to that specific instance.
     */
    public static function getUsersData(){
        session_start();
        
        if(isset($_SESSION["adminId"])){
            $userData;
            $adminId;
            $error;
            $database = GlideWebAPI::connectDB();

            $adminId = $_SESSION["adminId"];

            $userData = $database->select("users", [
                "user_id(DT_RowId)",
                "user_name",
                "user_email",
                ],[ "AND" => [
                    "admin_id" => $adminId,
                    "is_deleted" => 0
            ]]);



            echo json_encode($userData);

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }


    /**
     * Name: getJourneyData
     * Purpose: Retrieve journey data from journeys table
     * @return $journeyData or $error - JSON : JSON: Contains rows for each journey related to that specific instance.
     */
    public static function getJourneysData(){
        session_start();
        
        if(isset($_SESSION["adminId"])){

            $journey = array();
            $index = 0;
            $journeysData;
            $adminId;
            $error;
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];
            
            //use query public static static function for more complex database queries
            $journeysData = $database->query("SELECT id, user_name, origin, destination, distance, journey_time, date, status, account, comment
                                              FROM users, journeys
                                              WHERE ".$adminId." = journeys.admin_id
                                              AND journeys.user_id = users.user_id
                                              AND journeys.is_deleted = 0
                                              ORDER BY journeys.id Desc")->fetchAll();
                         

            foreach($journeysData as $data){
                $journey[$index] = array();
                $journey[$index]["DT_RowId"] = $data["id"];
                $journey[$index]["user_name"] = $data["user_name"];
                $journey[$index]["origin"] = $data["origin"];
                $journey[$index]["destination"] = $data["destination"];
                $journey[$index]["distance"] = $data["distance"];
                $journey[$index]["journey_time"] = $data["journey_time"];
                $journey[$index]["date"] = $data["date"];
                $journey[$index]["status"] = $data["status"];
                $journey[$index]["account"] = $data["account"];
                $journey[$index]["comment"] = $data["comment"];
                $index++;
            }

            echo json_encode($journey);
        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }

    /**
     * Name: addUser
     * Purpose: Add user to users table
     */
    public static function addUser(){

        session_start();
        
        if(isset($_SESSION["adminId"])){
            $userName = Util::get("userName");
            $userEmail = Util::get("userEmail");
            $log = array();
            $log["type"] = "addUser";
            $log["errors"] = array();
            $database = GlideWebAPI::connectDB();

            $adminId = $_SESSION["adminId"];

            $emailExists = $database->count("users", [
                "AND" => [
                    "user_email" => $userEmail,
                    "admin_id" => $adminId
                ]
            ]);

            if($emailExists == 1){
                $log["errors"]["email"] = "User email already exists";
                echo json_encode($log);   
            }else{
                    $lastUserId = $database->insert("users", [
                    "admin_id" => intval($adminId),
                    "user_name" => $userName,
                    "user_email" => $userEmail 
                ]);
                echo json_encode(array("table" => "users", "status" => "New user added..."));     
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }


    /**
     * Name: deleteData
     * Purpose: Delete data from specified table using given parameters.
     */
    public static function deleteData(){

        session_start();
        $ids = Array();
        
        if(isset($_SESSION["adminId"])){
            $ids = $_POST["rowIds"];
            if($_POST["tableData"] == "deleteExpense"){
                $table = "expenses";
                $field = "expense_id";
            }else if($_POST["tableData"] == "deleteJourney"){
                $table = "journeys";
                $field = "id";
            }else if($_POST["tableData"] == "deleteUser"){
                $table = "users";
                $field = "user_id";
            }

            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];

            for($x = 0; $x < sizeof($ids); $x++){
                $database->update($table,[
                    "is_deleted" => 1
                ],[
                    "AND" => [
                        $field => $ids[$x],
                        "admin_id" => $adminId
                ]]);

                
                //if user is deleted remove all assoicated records from
                //expesnes and journeys table.
                if($table == "users"){
                    $database->update("expenses",[
                    "is_deleted" => 1
                    ],[
                    "AND" => [
                        $field => $ids[$x],
                        "admin_id" => $adminId
                    ]]);

                    $database->update("journeys",[
                        "is_deleted" => 1
                    ],[
                    "AND" => [
                        $field => $ids[$x],
                        "admin_id" => $adminId
                    ]]);
                }
            }

            echo json_encode(array("Table" => $table));

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }

    /**
     * Name: searchExpenses
     * Purpose: Search expense table with the specified parameters.
     * @return $reults - json : contains search type and results. 
     */
    public static function searchExpenses(){

        session_start();
        
        if(isset($_SESSION["adminId"])){
            $userName = Util::get("searchUser");
            $account = Util::get("account");
            $merchant = Util::get("searchMerch");
            $date = Util::get("searchDate");
            $status = Util::get("status");
            $category = Util::get("category");
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];

            $sql = "SELECT 
                      ex.expense_id as DT_RowId,
                      u.user_name, 
                      ex.expense_category,
                      mer.merchant_name,
                      ex.expense_cost,
                      re.receipt_image,
                      ex.expense_date,
                      ex.expense_status,
                      ex.account,
                      ex.expense_comment 
                      FROM users u
                           JOIN expenses ex on ex.user_id = u.user_id
                           JOIN merchants mer on mer.merchant_id = ex.merchant_id
                           LEFT JOIN receipts re on re.receipt_id = ex.receipt_id
                           where ex.admin_id = '$adminId' AND ex.is_deleted = 0 ";

            if($userName){
                $sql .= "AND u.user_name LIKE '%$userName%' ";
            }

            if($account){
                $sql .="AND ex.account LIKE '%$account%' ";
            }

            if($merchant){
                $sql .= "AND mer.merchant_name LIKE '%$merchant%'";
            }

            if($status){
                $sql .= "AND ex.expense_status = '$status' ";
            }

            if($category){
                $sql .= "AND ex.expense_category = '$category' ";
            }

            $sql .= "ORDER BY ex.expense_id Desc"; 

            unset($userName, $merchant, $date, $status, $category);             

            $expensesData = $database->query($sql)->fetchAll();
            echo json_encode(array("type" => "expenses", "results" => $expensesData));
        

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }

    }


    /**
     * Name: searchJourneys
     * Purpose: Search journey table with the specified parameters.
     * @return $reults - json : contains search type and results. 
     */
    public static function searchJourneys(){

        session_start();

        if(isset($_SESSION["adminId"])){
            $userName = Util::get("userName");
            $origin = Util::get("origin");
            $destination = Util::get("destination");
            $status = Util::get("status");
            $account = Util::get("account");
            $date = Util::get("date");
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];

            $sql = "SELECT id as DT_RowId, user_name, origin, destination, distance, journey_time, date, status, account, comment
                    FROM users, journeys
                    WHERE ".$adminId." = journeys.admin_id
                    AND journeys.user_id = users.user_id
                    AND journeys.is_deleted = 0 ";

            if($userName){
                $sql .= " AND users.user_name LIKE '%$userName%' ";
            }

            if($origin){
                $sql .= " AND origin LIKE '%$origin%' ";
            }

            if($destination){
                $sql .= " AND destination LIKE '%$destination%' ";
            }

            if($status){
                $sql .= " AND status = '$status' ";
            }

            if($date){
                $sql .= " AND date LIKE '%$date%' ";
            }

            if($account){
                $sql .= "AND account LIKE '%$account%' ";
            }

            $sql .= "ORDER BY journeys.id Desc";

            unset($userName, $origin, $destination, $status, $date);             

            $journeyData = $database->query($sql)->fetchAll();
            echo json_encode(array("type" => "journeys", "results" => $journeyData));

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }

    }

    /**
     * Name: searchUsers
     * Purpose: Search users table with the specified parameters.
     * @return $reults - json : contains search type and results. 
     */
    public static function searchUsers(){

        session_start();

        if(isset($_SESSION["adminId"])){
            $userName = Util::get("userName");
            $database = GlideWebAPI::connectDB();

            $adminId = $_SESSION["adminId"];

            $sql = "SELECT user_id as DT_RowId, user_name, user_email
                    FROM users
                    WHERE admin_id = '$adminId' 
                    AND is_deleted = 0
                    AND user_name LIKE '%$userName%'";

            $userData = $database->query($sql)->fetchAll();

            unset($userName);             
            echo json_encode(array("type" => "users", "results" => $userData));

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }


    /**
     * Name: editExpense
     * Purpose: Edit and update existing record
     * @return $reults - json : contains table updated and message. 
     */
    public static function editExpense(){
        
        session_start();

        if(isset($_SESSION["adminId"])){
            $expenseId = Util::get("expenseId");
            $status = Util::get("status");
            $category = Util::get("category");
            $merchant = Util::get("merchant");
            $cost = $_POST["cost"];
            $account = Util::get("account");
            $comment = Util::get("comment");
            $database = GlideWebAPI::connectDB();

            $database->update("expenses", [
                "expense_category" => $category,
                "expense_cost" => $cost,
                "expense_status" => $status,
                "account" => $account,
                "expense_comment" => $comment
            ], [
                "expense_id" => $expenseId
            ]);

            echo json_encode(array("table" => "expenses", "results" => "updated"));

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }  
    }

    /**
     * Name: editJourney
     * Purpose: Edit and update existing record
     * @return $reults - json : contains table updated and message. 
     */
    public static function editJourney(){

        session_start();

        if(isset($_SESSION["adminId"])){
            $journeyId = Util::get("journeyId");
            $status = Util::get("status");
            $origin = Util::get("origin");
            $destination = Util::get("destination");
            $distance = Util::get("distance");
            $time = Util::get("journeyTime");
            $account = Util::get("account");
            $comment = Util::get("comment");
            $database = GlideWebAPI::connectDB();

            $database->update("journeys", [
                "status" => $status,
                "origin" => $origin,
                "destination" => $destination,
                "distance" => $distance,
                "journey_time" => $time,
                "account" => $account,
                "comment" => $comment
            ], [
                "id" => $journeyId
            ]);

            echo json_encode(array("table" => "journeys", "results" => "updated"));

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }  
    }

}


?>