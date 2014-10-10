<?php
require "classes/medoo.php";
require "classes/Util.php";


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
 * Purpose: Destroys session and allows users to sign out of system
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
        $expensesData = $database->query("SELECT user_name, expense_category, merchant_name, expense_cost, expense_date, expense_status, receipt_image, expense_comment
                                          FROM users, expenses, merchants, receipts
                                          WHERE ".$adminId." = expenses.admin_id
                                          AND expenses.user_id = users.user_id
                                          AND expenses.receipt_id = receipts.receipt_id
                                          AND expenses.merchant_id = merchants.merchant_id")->fetchAll();
        foreach($expensesData as $data){
            $expense[$index] = array();
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
            "user_name",
            "user_email",
            ],[
            "admin_id" => $adminId
        ]);

        echo json_encode($userData);

    }else{
        echo json_encode(array("error" => "Admin ID not set"));
    }
}





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
        $journeysData = $database->query("SELECT user_name, origin, destination, distance, journey_time, date, status, comment
                                          FROM users, journeys
                                          WHERE ".$adminId." = journeys.admin_id
                                          AND journeys.user_id = users.user_id")->fetchAll();
                     

        foreach($journeysData as $data){
            $journey[$index] = array();
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







?>