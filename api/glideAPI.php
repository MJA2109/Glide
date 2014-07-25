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
 * @return $log - Array: Contains the status and errors of registration 
 */
function register(){

    define("PASSWORD_LENGTH", 8);
    $companyName = Util::get("companyName");
    $adminEmail = Util::get("adminEmail");
    $adminPassword = Util::get("adminPassword");
    $validAdminEmail = Util::validateEmail($adminEmail);

    $database = connectDB();

    $log = array();

    //check for invalid data
    $log["type"] = "registration";

    if(empty($companyName)){
        $log["companyNameErr"] = "Company name required";
    }
    if(empty($adminEmail)){
        $log["adminEmailErr"] = "E-mail address required";
    }
    if(empty($adminPassword)){
        $log["adminPasswordErr"] = "Password required";
    }
    if(strlen($adminPassword) < PASSWORD_LENGTH ){
        $log["adminPasswordErrLength"] = "Password must be at least 8 characters in length";
    }else{
        $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
    }
    if($validAdminEmail === false){
        $log["invalidEmail"] = "Email address is invalid";
    }
    
    //check for duplicate email addresses
    $emailInUse = $database->count("admins", [
            "admin_email" => $adminEmail
    ]);
    if($emailInUse > 0){
        $log["adminEmailInUse"] = "Email address is already registered, try another.";
    }

    //if log exist return, else send to database
    $logCount = count($log);

    if($logCount > 1){
        $log["errors"] = "Your registration contains invalid data";
        $logObject = json_encode($log);
        echo $logObject;
    }else{

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

        $log['noErrors'] = "Congratulations, you are now registered";
        $logObject = json_encode($log);
        echo $logObject;      
    }
}




function signIn(){

    echo "your signed in";
}





?>