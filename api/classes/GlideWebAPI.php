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
     * Purpose: Allow admin to sign into the system
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
     * Name: signIn
     * Purpose: Allow project manager to sign into the system
     */
    public static function pmSignIn(){
        
        define("AUTHORIZED", true);
        $adminEmail = Util::get("adminEmail");
        $email = Util::get("email");
        $password = $_POST["password"];
        $account = Util::get("account");
        $registeredUser = array();
        $log = array(); 
        $log["type"] = "pmSignIn";
        $log["errors"] = array();
        $log["data"] = array();
        $errorCount;
        $logObject;
        $validAdminEmail;
        $hashedAdminPassword;
        $database;
        
        $database = GlideWebAPI::connectDB();

        if(empty($adminEmail)){
            $log["errors"]["adminEmailErr"] = "Admin E-mail address required";
        }else{
            
            $validAdminEmail = Util::validateEmail($adminEmail);
            
            if($validAdminEmail === false){
                $log["errors"]["invalidAdminEmail"] = "Admin Email address is invalid";
            }else{
                
                $registeredAdmin = $database->select("admins", "*",[   
                    "admin_email" => $adminEmail   
                ]);

                if($registeredAdmin){
                    
                    if(empty($account)){
                        $log["errors"]["accountError"] = "Account required";
                    }else{

                        $accountExistsExpense = $database->count("expenses", [
                            "AND" => [
                                "account" => $account,
                                "admin_id" => $registeredAdmin[0]["admin_id"]

                            ]
                        ]);

                        $accountExistsJourney = $database->count("journeys", [
                            "AND" => [
                                "account" => $account,
                                "admin_id" => $registeredAdmin[0]["admin_id"]

                            ]
                        ]);

                        if($accountExistsJourney == 0 && $accountExistsExpense == 0){
                            $log["errors"]["accountError"] = "Account doesn't exist in system.";   
                        }

                    }
                }else{
                    $log["errors"]["invalidAdminEmail"] = "Admin Email address not recognised";   
                }
            }
        }

        if(empty($email)){
            $log["errors"]["emailErr"] = "E-mail address required";
        }else{
            
            $validEmail = Util::validateEmail($email);
            
            if($validEmail === false){
                $log["errors"]["invalidEmail"] = "Email address is invalid";
            }
        }

        if(empty($password)){
            $log["errors"]["passwordErr"] = "Password required";
        }else{
            $hashedPassword = sha1($password);
        }
        
        $errorCount = count($log["errors"]);

        if($errorCount == 0){ 
            
            $registeredUser = $database->select("users", "*",[
                    "AND" => [
                        "user_email" => $email,
                        "user_password" => $hashedPassword,
                        "user_type" => "Project Manager"
                    ]
            ]);
            
            if(!empty($registeredUser)){
                session_start();
                $_SESSION["authorized"] = AUTHORIZED;
                $_SESSION["adminEmail"] = $registeredUser[0]["user_email"];
                $_SESSION["adminId"] = $registeredUser[0]["admin_id"];
                $_SESSION["account"] = $account;
                $log["data"]["adminId"] = $registeredUser[0]["admin_id"];
                $log["data"]["adminEmail"] = $registeredUser[0]["admin_email"];
            }else{
                $log["errors"]["incorrectDetails"] = $email." *** ".$hashedPassword;
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
     * Name: isAvailable
     * Purpose: Check does user email or mobile exist
     */
    public static function isAvailable(){

        session_start();
        
        if(isset($_SESSION["adminId"])){

            if(Util::get("userMobile") != null){
                $column = "user_mobile";
                $table = "users";
                $data = Util::get("userMobile");
            }else if(Util::get("userEmail") != null){
                $column = "user_email";
                $table = "users";
                $data = Util::get("userEmail"); 
            }

            $log = array();
            $adminId = $_SESSION["adminId"];
            $database = GlideWebAPI::connectDB();

            $inUse = $database->count($table, [
                "AND" => [
                    $column => $data,
                    "is_deleted" => 0,
                    "admin_id" => $adminId 
                ]
            ]);

            if($inUse > 0){
                $log["valid"] = false;
            }else{
                $log["valid"] = true;
            }
            echo json_encode($log); 

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }

    }

    /**
     * Name: availableEmail
     * Purpose: On sign up check is purposed email in use
     */
    public static function availableEmail(){

        $database = GlideWebAPI::connectDB();
        $email = Util::get("adminEmail");
        $log = array();
            
        $inUse = $database->count("admins", [
            "AND" => [
                "admin_email" => $email,
                "is_deleted" => 0
            ]
        ]);

        if($inUse > 0){
            $log["valid"] = false;
        }else{
            $log["valid"] = true;
        }
        echo json_encode($log); 
    }




    /**
     * Name: doesUserExist
     * Purpose: Check does user exist in database 
     */
    public static function doesUserExist(){
        
        session_start();
        
        if(isset($_SESSION["adminId"])){
            // $database = GlideWebAPI::connectDB();
            // $adminId = $_SESSION["adminId"];
            // $userName = Util::get("userName");

            // if(Util::get("userId") != null){
                
            //     $userId = Util::get("userId");
                
            //     $userExists = $database->count("users", [
            //         "AND" => [
            //             "user_name" => $userName,
            //             "admin_id" => $adminId,
            //             "user_id" => $userId
            //         ]
            //     ]);
            
            // }else{
            //     $userExists = $database->count("users", [
            //         "AND" => [
            //             "user_name" => $userName,
            //             "admin_id" => $adminId
            //         ]
            //     ]);
            // }

            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];
            $userEmail = Util::get("userEmail");

            $userExists = $database->count("users", [
                                "AND" => [
                                    "user_email" => $userEmail,
                                    "admin_id" => $adminId
                                ]
                            ]);

            if($userExists > 0){
                $log["valid"] = true;
            }else{
                $log["valid"] = false;
            }
            echo json_encode($log); 

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }

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
            $accountName = null;
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];
            if(isset($_SESSION["account"])){
                $accountName = $_SESSION["account"];
            }
            
            $sql = "SELECT
                    ex.expense_id,
                    u.user_name, 
                    ex.expense_category, 
                    mer.merchant_name, 
                    ex.expense_cost, 
                    ex.expense_date, 
                    ex.expense_status,
                    re.receipt_image, 
                    ex.expense_comment,
                    ex.account,
                    ex.expense_approved
                    FROM users u
                    JOIN expenses ex on ex.user_id = u.user_id
                    JOIN merchants mer on mer.merchant_id = ex.merchant_id
                    LEFT JOIN receipts re on re.receipt_id = ex.receipt_id
                    where
                    ex.admin_id = '$adminId'
                    AND ex.is_deleted = 0 
                    AND ex.expense_approved <> 'No' ";

            if($accountName){
                $sql .="AND ex.account = '$accountName'";
            }

            $sql .="ORDER BY ex.expense_id Desc";
            
            //use query public static static function for more complex database queries
            $expensesData = $database->query($sql)->fetchAll();

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
                $expense[$index]["expense_approved"] = $data["expense_approved"];
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
                "user_type",
                "user_mobile",
                "user_mileage_rate"
                ],[ "AND" => [
                    "admin_id" => $adminId,
                    "is_deleted" => 0
                ]
            ]);



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
            $accountName;
            $database = GlideWebAPI::connectDB();
            
            $adminId = $_SESSION["adminId"];
            if(isset($_SESSION["account"])){
                $accountName = $_SESSION["account"];
            }else{
                $accountName = null;
            }

            $sql = "SELECT id, user_name, origin, destination, distance, journey_time, date, status, account, comment, approved
                                              FROM users, journeys
                                              WHERE ".$adminId." = journeys.admin_id
                                              AND journeys.user_id = users.user_id
                                              AND journeys.is_deleted = 0 
                                              AND journeys.approved <> 'No' ";
            if($accountName){
                $sql .= "AND journeys.account = '$accountName' ";
            }
                                              
            $sql .= "ORDER BY journeys.id Desc";
            
            //use query public static static function for more complex database queries
            $journeysData = $database->query($sql)->fetchAll();
                         

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
                $journey[$index]["approved"] = $data["approved"];
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
            $userMobile = Util::get("userMobile");
            $userType = Util::get("userType");
            $userMileageRate = Util::get("userMileageRate");
            $log = array();
            $log["type"] = "addUser";
            $log["table"] = "users";
            $log["errors"] = array();
            $database = GlideWebAPI::connectDB();

            $adminId = $_SESSION["adminId"];

            if(empty($userName)){
                $log["errors"]["userName"] = "User Name is required";
            }

            if(empty($userEmail)){
                $log["errors"]["email"] = "Email is required";
            }else{
                $emailExists = $database->count("users", [
                    "AND" => [
                        "user_email" => $userEmail,
                        "admin_id" => $adminId
                    ]
                ]);

                if($emailExists == 1){
                    $log["errors"]["email"] = "User email already exists";
                }
            }

            if(empty($userMobile)){
                $log["errors"]["mobile"] = "Mobile number is required";
            }else{
                $mobileExists = $database->count("users", [
                    "AND" => [
                        "user_mobile" => $userMobile,
                        "admin_id" => $adminId
                    ]
                ]);

                if($emailExists == 1){
                    $log["errors"]["mobile"] = "Mobile number already exists";
                }

            }

            if(empty($userType)){
                $log["errors"]["type"] = "User Type is required";
            }

            if(empty($userMileageRate)){
                $log["errors"]["mileageRate"] = "User Mileage Rate is required";    
            }

            $errorCount = count($log["errors"]);

            if($errorCount == 0){ 

                //generate password
                $password = GlideWebAPI::generatePassword(10);
                $hashedPassword = sha1($password);
                
                $lastUserId = $database->insert("users", [
                    "admin_id" => intval($adminId),
                    "user_name" => $userName,
                    "user_email" => $userEmail,
                    "user_mobile" => $userMobile,
                    "user_type" => $userType,
                    "user_mileage_rate" => $userMileageRate,
                    "user_password" => $hashedPassword 
                ]);


                //format number and message and send text to user
                $userMobile = ltrim($userMobile, '0');
                $userMobile = "353".$userMobile;
                $message = 'LOGIN DETAILS  Email : '.$userEmail.' Instance ID :  '.$adminId.' Password : '.$password;
                $response = GlideWebAPI::sendText("353871272117", $message);

                echo json_encode($log);     
            }else{
                echo json_encode($log);
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }
    }


    /**
     * Name: addUser
     * Purpose: Edit user table.
     */
    public static function editUser(){

        session_start();

        
        if(isset($_SESSION["adminId"])){
            
            $userId = Util::get("userId");
            $userName = Util::get("userName");
            $userEmail = Util::get("userEmail");
            $userMobile = Util::get("userMobile");
            $userRate = Util::get("userMileageRate");
            $userType = Util::get("userType");
            $log = array();
            $log["table"] = "users";
            $log["errors"] = array();

            $database = GlideWebAPI::connectDB();

            if(empty($userRate)){
                $log["errors"]["mileageRate"] = "User Mileage Rate is required";    
            }

            $errorCount = count($log["errors"]);

            if($errorCount == 0){ 

                $database->update("users", [
                    "user_name" => $userName,
                    "user_email" => $userEmail,
                    "user_mobile" => $userMobile,
                    "user_mileage_rate" => $userRate,
                    "user_type" => $userType
                ], [
                    "user_id" => $userId
                ]);

                echo json_encode($log);
            }else{
                echo json_encode($log);   
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
        $ids = array();
        
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

            echo json_encode(array("Table" => $table, "ID of deleted records" => $ids));

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
            $accountName;
            
            $adminId = $_SESSION["adminId"];
            if(isset($_SESSION["account"])){
                $accountName = $_SESSION["account"];
            }

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
                      ex.expense_comment,
                      ex.expense_approved 
                      FROM users u
                           JOIN expenses ex on ex.user_id = u.user_id
                           JOIN merchants mer on mer.merchant_id = ex.merchant_id
                           LEFT JOIN receipts re on re.receipt_id = ex.receipt_id
                           where ex.admin_id = '$adminId' AND ex.is_deleted = 0 
                           AND ex.expense_approved <> 'No' ";

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

            if($accountName){
                $sql .= "AND ex.account = '$accountName' ";
            }

            if($date){
               $sql .= "AND ex.expense_date LIKE '%$date%' "; 
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
            $accountName;
            
            $adminId = $_SESSION["adminId"];
            if(isset($_SESSION["account"])){
                $accountName = $_SESSION["account"];
            }

            $sql = "SELECT id as DT_RowId, user_name, origin, destination, distance, journey_time, date, status, account, comment, approved
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

            if($accountName){
                $sql .= "AND journeys.account = '$accountName' ";
            }

            if($date){
               $sql .= "AND journeys.date LIKE '%$date%' "; 
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

            $sql = "SELECT user_id as DT_RowId, user_name, user_email, user_mobile, user_type, user_mileage_rate
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
            $approved = Util::get("approved");
            $log = array();
            $log["type"] = "editExpense"; 
            $log["table"] = "expenses";
            $log["errors"] = array();
            $log["data"] = array();
            $database = GlideWebAPI::connectDB();

            if(empty($cost)){
                $log["errors"]["cost"] = "Cost is required";
            }

            if(empty($category)){
                $log["errors"]["category"] = "Category is required";
            }

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{

                $database->update("expenses", [
                    "expense_category" => $category,
                    "expense_cost" => $cost,
                    "expense_status" => $status,
                    "account" => $account,
                    "expense_comment" => $comment,
                    "expense_approved" => $approved
                ], [
                    "expense_id" => $expenseId
                ]);

                echo json_encode($log);
            }

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
            $approved = Util::get("approved");
            $database = GlideWebAPI::connectDB();
            $log = array();
            $log["type"] = "editJourney"; 
            $log["table"] = "journeys";
            $log["errors"] = array();
            $log["data"] = array();

            if(empty($origin)){
                $log["errors"]["origin"] = "Origin address is required";
            }
            if(empty($destination)){
                $log["errors"]["destination"] = "Destination address is required";
            }
            if(empty($time)){
                $log["errors"]["journeyTime"] = "Journey Time is required";
            }
            if(empty($distance)){
                $log["errors"]["distance"] = "Distance is required";
            }
            if(empty($time)){
                $log["errors"]["time"] = "Time is required";
            }

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{

                $database->update("journeys", [
                    "status" => $status,
                    "origin" => $origin,
                    "destination" => $destination,
                    "distance" => $distance,
                    "journey_time" => $time,
                    "account" => $account,
                    "comment" => $comment,
                    "approved" => $approved
                ], [
                    "id" => $journeyId
                ]);

                echo json_encode($log);
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }  
    }


    /**
     * Name: sendText
     * Purpose: Send text message to user phone with app sign in info.
     * @return $reults - json : status of localtxt api call. 
     */
    public static function sendText($number, $message){

        // Authorisation details.
        $username = "anderson.j.michael@outlook.com";
        $hash = "a1f9a91ba921113515f10f344371226cc1af39ff";
        $test = "0";
        $sender = "Glide"; 
        
        $message = urlencode($message);
        $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$number."&test=".$test;
        $ch = curl_init('http://api.txtlocal.com/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API call
        curl_close($ch);

        return json_encode(array("table" => "users", "api response" => $result));
    }


    /**
     * Name: getRandomBytes
     * Purpose: Get random bytes to create a password using the open ssl random byte generator.
     * @return $bytes - Sting : generated bytes. 
     */
    public static function getRandomBytes($nbBytes = 32){

        $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
        
        if (false !== $bytes && true === $strong) {
            return $bytes;
        }
        else {
            throw new \Exception("Unable to generate secure token from OpenSSL.");
        }
    }


    /**
     * Name: generatePassword
     * Purpose: Generate random password.
     * @return $password - Sting : random password. 
     */
    public static function generatePassword($length){
        return substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode(GlideWebAPI::getRandomBytes($length+1))),0,$length);
    }


    public static function getChartData(){
        $chartType = $_POST["chartType"];
        switch($chartType){
            case "barChart" : GlideWebAPI::getBarChartData();
            break;
            case "pieChart" : GlideWebAPI::getPieChartData();
            break;
            case "lineChart" : GlideWebAPI::getLineChartData();
            break;
        }    
    }


    /**
     * Name: getPieChartData
     * Purpose: Calculate the most popular merchants. 
     */
    static function getPieChartData(){

        session_start();

        if(isset($_SESSION["adminId"])){
            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];
            $time = Util::get("time");
            $log = array();
            $log["type"] = "getChartData"; 
            $log["table"] = "expenses";
            $log["chartType"] = "pie";
            $log["errors"] = array(); 
            $chartData = array();


            $option = $_POST["searchOption"];

            if($option == "singleUser"){

                $userEmail = Util::get("userEmail");
                $userId = GlideWebAPI::getUserId($userEmail, $adminId);
                if(!$userId){
                    $log["errors"]["user ID"] = "ID not set";
                }
            }

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{

                //query expense table 
                $sql_1 = "SELECT merchant_name, ROUND(SUM(expense_cost), 2) as total_spend
                          FROM merchants mc, expenses ex
                          WHERE expense_date BETWEEN CURDATE() - INTERVAL ".$time." AND CURDATE()
                          AND ex.admin_id = $adminId
                          AND ex.merchant_id = mc.merchant_id
                          AND ex.is_deleted = 0
                          AND mc.is_deleted = 0
                          AND ex.expense_approved <> 'No' ";
                
                //add for single user only
                if($option == "singleUser"){
                    $sql_1 .= " AND user_id = $userId[0] ";
                }
                $sql_1 .= " GROUP BY merchant_name
                            ORDER BY expense_cost DESC 
                            LIMIT 8";

                $merchantCost = $database->query($sql_1)->fetchAll();

                $index = 0;

                foreach($merchantCost as $data){
                    $chartData[$index] = array();
                    $chartData[$index]["column"] = $data["merchant_name"];
                    $chartData[$index]["colValue"] = $data["total_spend"];
                    $index++;
                }

                $log["data"] = $chartData;                

                echo json_encode($log);

            }
        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }      
    }


    /**
     * Name: getBarChartData
     * Purpose: Get category totals to generate Google bar chart. 
     */
    static function getBarChartData(){

        session_start();

        if(isset($_SESSION["adminId"])){
            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];
            $time = Util::get("time");
            $log = array();
            $log["type"] = "getChartData"; 
            $log["table"] = "expenses";
            $log["chartType"] = "bar";
            $log["errors"] = array();
            $chartData = array();
            $userId;


            $option = $_POST["searchOption"];

            if(isset($_POST['liabilities'])){
                $liabilities = $_POST['liabilities'];
            }

            if($option == "singleUser"){

                $userEmail = Util::get("userEmail");
                $userId = GlideWebAPI::getUserId($userEmail, $adminId);
                if(!$userId){
                    $log["errors"]["user ID"] = "ID not set";
                }
            }

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{
                
                   
                //query expense table 
                $sql_1 = "SELECT expense_category, ROUND(SUM(expense_cost), 2) as total_cost
                          FROM expenses
                          WHERE expense_date BETWEEN CURDATE() - INTERVAL ".$time." AND CURDATE()
                          AND admin_id = $adminId
                          AND is_deleted = 0 
                          AND expenses.expense_approved <> 'Awaiting...' ";
                
                //add for single user only
                if($option == "singleUser"){
                    $sql_1 .= " AND user_id = $userId[0] ";
                }
                //add if liabilities request
                if($liabilities){
                    $sql_1 .= "AND expense_status = 'unprocessed' ";
                }

                $sql_1 .= " GROUP BY expense_category ";

                //calculate mileage for single user only
                if($option == "singleUser"){
                    $sql_2 = "SELECT (ROUND(SUM(distance), 2) * user_mileage_rate) as mileage
                              FROM users ur, journeys jn
                              WHERE date BETWEEN CURDATE() - INTERVAL ".$time." AND CURDATE()
                              AND ur.user_id = jn.user_id
                              AND ur.admin_id = $adminId
                              AND jn.is_deleted = 0
                              AND ur.is_deleted = 0 
                              AND ur.user_mileage_rate > 0
                              AND jn.user_id = $userId[0] 
                              AND jn.approved <> 'Awaiting...' ";
                

                }else{
                    //calculate all mileage costs
                    $sql_2 = "SELECT ROUND(SUM(distance * user_mileage_rate), 2) as mileage
                              FROM users ur, journeys jn
                              WHERE date BETWEEN CURDATE() - INTERVAL ".$time." AND CURDATE()
                              AND ur.user_id = jn.user_id
                              AND ur.admin_id = $adminId
                              AND jn.is_deleted = 0
                              AND ur.is_deleted = 0 
                              AND ur.user_mileage_rate > 0 
                              AND jn.approved <> 'Awaiting...' ";
                              
                              if($liabilities){
                                $sql_2 .= "AND jn.status = 'unprocessed' ";
                              }
                }

                $categoryCost = $database->query($sql_1)->fetchAll();
                $mileageCost = $database->query($sql_2)->fetchAll();

                $index = 0;
                $last; //used to append mileage to last position of array

                foreach($categoryCost as $data){
                    $chartData[$index] = array();
                    $chartData[$index]["column"] = $data["expense_category"];
                    $chartData[$index]["colValue"] = $data["total_cost"];
                    $index++;
                    $last = $index;
                }

                // $log["sql"] = $mileageCost;

                if($mileageCost[0]["mileage"] != null){
                    //append mileage cost onto chartData
                    $chartData[$last]["column"] = "Mileage Cost";
                    $chartData[$last]["colValue"] = $mileageCost[0]["mileage"];
                } 

                $log["data"] = $chartData;                

                echo json_encode($log);
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }          
    }


     /**
     * Name: getLineChartData
     * Purpose: Get total expenditure to generate Google bar chart. 
     */
    static function getLineChartData(){
        
        session_start();

        if(isset($_SESSION["adminId"])){
            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];
            $time = Util::get("time");
            $log = array();
            $log["type"] = "getChartData"; 
            $log["table"] = "expenses";
            $log["chartType"] = "line";
            $log["errors"] = array();
            $chartData = array();


            $option = $_POST["searchOption"];

            if($option == "singleUser"){

                $userEmail = Util::get("userEmail");
                $userId = GlideWebAPI::getUserId($userEmail, $adminId);
                if(!$userId){
                    $log["errors"]["user ID"] = "ID not set";
                }
            }

            $errorCount = count($log["errors"]);

            if($errorCount != 0){
                echo json_encode($log);
            }else{

                //query expense table 
                $sql_1 = "SELECT DATE_FORMAT(expense_date, '%b') as month, ROUND(SUM(expense_cost), 2) as total_cost
                          FROM expenses
                          WHERE expense_date BETWEEN CURDATE() - INTERVAL ".$time." AND CURDATE()
                          AND admin_id = $adminId
                          AND is_deleted = 0 
                          AND expenses.expense_approved <> 'No' ";
                
                //add for single user only
                if($option == "singleUser"){
                    $sql_1 .= " AND user_id = $userId[0] ";
                }
                $sql_1 .= "GROUP BY MONTH(expense_date)
                           ORDER BY expense_date ASC";

                $totalCost = $database->query($sql_1)->fetchAll();
                $index = 0;

                foreach($totalCost as $data){
                    $chartData[$index] = array();
                    $chartData[$index]["column"] = $data["month"];
                    $chartData[$index]["colValue"] = $data["total_cost"];
                    $index++;
                }

                $log["data"] = $chartData;
                echo json_encode($log);
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }     
    }
    

    /**
     * Name: getUserId
     * Purpose: Get user ID associated with a given email address.
     * @param $userEmail - String : Email address
     * @param $adminId - Int : Administrators ID
     * @return $userId 
     */
    static function getUserId($userEmail, $adminId){

        $database = GlideWebAPI::connectDB();
        $log["errors"] = array();

        if(empty($userEmail)){
            $log["errors"]["userEmailErr"] = "User E-mail address required";
        }else{

            $validAdminEmail = Util::validateEmail($userEmail);
        
            if($validAdminEmail === false){
                $log["errors"]["validEmail"] = "User E-mail is not valid";
            }else{
                
                $userId = $database->select("users", "user_id",[
                    "AND" => [
                        "user_email" => $userEmail,
                        "admin_id" => $adminId,
                        "is_deleted" => 0
                    ]
                ]);

                if(!$userId){
                    $log["errors"]["user"] = "User does not exist";   
                }
            }
        }

        $errorCount = count($log["errors"]);

        if($errorCount != 0){
            return false;
        }else{
            return $userId;
        }
    }


     /**
     * Name: getWidgetData
     * Purpose: Get data for either the expense, journey or user widget
     */
    static function getWidgetData(){

        session_start();

        if(isset($_SESSION["adminId"])){

            $database = GlideWebAPI::connectDB();
            $adminId = $_SESSION["adminId"];
            $widgetType = Util::get("widgetType");
            
            if($widgetType == "Onlineusers"){
                $users = $database->select("users", "*",[
                           "AND" => [
                                    "is_online" => 1,
                                    "admin_id" => $adminId,
                                    "is_deleted" => 0
                                   ]
                               ]);
                  
               echo json_encode( array( 'type' => 'users', 'widgetData' => $users) );

            }else if($widgetType == "Recentexpenses"){
                $sql = "SELECT users.user_name, expenses.expense_date
                        FROM users, expenses
                        WHERE users.user_id = expenses.user_id
                        AND expense_approved = 'Awaiting...'
                        AND expenses.admin_id = $adminId
                        AND expenses.is_deleted = 0
                        AND users.is_deleted = 0 
                        ORDER BY expenses.expense_date DESC";

                      $widgetData = $database->query($sql)->fetchAll();
                
                echo json_encode( array( 'type' => 'expenses', 'widgetData' => $widgetData) ); 

            }else if($widgetType == "Recentjourneys"){
                
                 $sql = "SELECT users.user_name, journeys.date
                          FROM users, journeys
                          WHERE users.user_id = journeys.user_id
                          AND journeys.approved = 'Awaiting...'
                          AND journeys.admin_id = $adminId
                          AND journeys.is_deleted = 0
                          AND users.is_deleted = 0 
                          ORDER BY journeys.date DESC";

                  $widgetData = $database->query($sql)->fetchAll();

                  echo json_encode( array( 'type' => 'journeys', 'widgetData' => $widgetData) ); 
            }

        }else{
            echo json_encode(array("error" => "Admin ID not set"));
        }  
    }

} //class


?>