<?php
require "classes/medoo.php";
require "classes/Util.php";

//echo json_encode($_POST);

//Call function based on posted action
if(isset($_POST["action"])){
    $action = $_POST["action"];
    switch($action){
        case "register" : register();
        break;
        case "signIn" : signIn();
        break;
        case "signOut" : signOut();
        break;
        case "getExpensesData" : getExpensesData();
        break;
        case "getUsersData" : getUsersData();
        break;
        case "getJourneysData" : getJourneysData();
        break;
        case "addExpense" : addExpense();
        break;
        case "addJourney" : addJourney();
        break;
        case "addUser" : addUser();
        break;
        case "deleteData" : deleteData();
        break;
    }
}

/**
 * Name: connectDB
 * Purpose: Connect to mysql database
 * @return $database - object : database object
 */
function connectDB(){
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
 * Name: register
 * Purpose: Allow users to register an account on the system
 * @return $log - Array: Contains invalid and duplicate data errors 
 */
function register(){

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


    $database = connectDB();

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
function signIn(){

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
    
    $database = connectDB();

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
function signOut(){
    session_start();
    session_destroy();
    echo "session is destroyed";
}


/**
 * Name: getExpensesData
 * Purpose: Retrieve data from expenses table
 * @return $expense or $error - JSON: Contains rows for each expense related to that specific instance.
 */
function getExpensesData(){
    
    session_start();
    
    if(isset($_SESSION["adminId"])){

        $expense = array();
        $index = 0;
        $expensesData;
        $adminId;
        $error;
        $database = connectDB();
        
        $adminId = $_SESSION["adminId"];
        
        //use query function for more complex database queries
        $expensesData = $database->query("SELECT
                                            ex.expense_id,
                                            u.user_name, 
                                            ex.expense_category, 
                                            mer.merchant_name, 
                                            ex.expense_cost, 
                                            ex.expense_date, 
                                            ex.expense_status,
                                            re.receipt_image, 
                                            ex.expense_comment
                                            FROM users u
                                            JOIN expenses ex on ex.user_id = u.user_id
                                            JOIN merchants mer on mer.merchant_id = ex.merchant_id
                                            LEFT JOIN receipts re on re.receipt_id = ex.receipt_id
                                            where
                                            ex.admin_id = '$adminId'
                                            AND ex.is_deleted = 0")->fetchAll();
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
function getUsersData(){
    session_start();
    
    if(isset($_SESSION["adminId"])){
        $userData;
        $adminId;
        $error;
        $database = connectDB();

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
function getJourneysData(){
    session_start();
    
    if(isset($_SESSION["adminId"])){

        $journey = array();
        $index = 0;
        $journeysData;
        $adminId;
        $error;
        $database = connectDB();
        
        $adminId = $_SESSION["adminId"];
        
        //use query function for more complex database queries
        $journeysData = $database->query("SELECT id, user_name, origin, destination, distance, journey_time, date, status, comment
                                          FROM users, journeys
                                          WHERE ".$adminId." = journeys.admin_id
                                          AND journeys.user_id = users.user_id
                                          AND journeys.is_deleted = 0")->fetchAll();
                     

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
            $journey[$index]["comment"] = $data["comment"];
            $index++;
        }

        echo json_encode($journey);
    }else{
        echo json_encode(array("error" => "Admin ID not set"));
    }
}


/**
 * Name: processMerchant
 * Purpose: Get merchant id or add new merchant then get id
 * @param $marchantName - String : Contains merchant name.
 * @return $merchantId - Int : Contains merchant id.
 */
function processMerchant($merchantName){
    session_start();
    
    if(isset($_SESSION["adminId"])){
        $adminId = $_SESSION["adminId"];
        $database = connectDB();
        
        $merchantId = $database->select("merchants", [ "merchant_id"],[
            "merchant_name" => $merchantName
        ]);

        if(empty($merchantId)){
            $merchantId = $database->insert("merchants", [
                "merchant_name" => $merchantName,
                "admin_id" => $adminId
            ]);
        }
    }else{
        echo json_encode(array("error" => "Admin ID not set"));
    }

    return $merchantId;
}


/**
 * Name: addExpense
 * Purpose: Add expense to expense table
 */
function addExpense(){

    session_start();
    
    if(isset($_SESSION["adminId"])){

        $userName = Util::get("userName");
        $userId = Util::get("userId");
        $category = Util::get("category");
        $merchant = Util::get("merchant");
        $cost = Util::get("cost");
        $comment = Util::get("comment");
        $log = array();
        $log["type"] = "addExpense";
        $log["errors"] = array();
        $database = connectDB();
        
        $adminId = $_SESSION["adminId"];

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
            $merchantId = processMerchant($merchant);
            
            $lastExpenseId = $database->insert("expenses", [
                "admin_id" => intval($adminId),
                "user_id" => intval($userId),
                "merchant_id" => $merchantId,
                "expense_category" => $category,
                "expense_cost" => $cost,
                "expense_comment" => $comment,
                
            ]);
            echo json_encode(array("table" => "expenses", "status" => "New expense added..."));  
        }

    }else{
        echo json_encode(array("error" => "Admin ID not set"));
    }
}


/**
 * Name: addJourney
 * Purpose: Add journey to journey table
 */
function addJourney(){

    session_start();
    
    if(isset($_SESSION["adminId"])){
        $userName = Util::get("userName");
        $userId = Util::get("userId");
        $origin = Util::get("origin");
        $destination = Util::get("destination");
        $distance = Util::get("distance");
        $journeyTime = Util::get("journeyTime");
        $date = Util::get("date");
        $comment = Util::get("comment");
        $log = array();
        $log["type"] = "addExpense";
        $log["errors"] = array();
        $database = connectDB();
        
        $adminId = $_SESSION["adminId"];

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
                "comment" => $comment  
            ]);
            echo json_encode(array("table" => "journeys", "status" => "New journey added..."));  
        }


    }else{
        echo json_encode(array("error" => "Admin ID not set"));
    }
    
}

/**
 * Name: addUser
 * Purpose: Add user to users table
 */
function addUser(){

    session_start();
    
    if(isset($_SESSION["adminId"])){
        $userName = Util::get("userName");
        $userEmail = Util::get("userEmail");
        $log = array();
        $log["type"] = "addUser";
        $log["errors"] = array();
        $database = connectDB();

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
function deleteData(){

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

        $database = connectDB();
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












?>