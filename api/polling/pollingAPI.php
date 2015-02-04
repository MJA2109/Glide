<?php
   require "../helperClasses/medoo.php";
   require "../helperClasses/Util.php";

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

   if(isset($_GET["action"])){
   
      $action = $_GET["action"];
      switch($action){ 
         case "pollExpenses" : pollExpenses();
         break;
         case "pollJourneys" : pollJourneys();
         break;
         case "pollUsers" : pollUsers();
         break;
      }
   }


   function pollExpenses(){

      session_start();
      if(isset($_SESSION["adminId"])){
            $adminId = $_SESSION["adminId"];
            session_write_close();


            $database = connectDB(); 
            $lastId = $_GET['lastId'];
            $timestamp = trim( $_GET['timestamp'] );
            if($timestamp){
               $timestamp = time();
            }
                
            $timer = 0;
            $numNewExpeses = 0;
            
            $numNewExpeses = $database->count("expenses", [
                                   "AND" => [
                                       "expense_date[>=]" => $timestamp,
                                       "expense_id[>]" => $lastId,
                                       "expense_approved" => "Awaiting...",
                                       "admin_id" => $adminId,
                                       "is_deleted" => 0
                                   ]
                               ]);
               
            if($numNewExpeses <= 0){
               while($numNewExpeses <= 0){
                  if($numNewExpeses <= 0){
                     if($timer >= 30){
                        die( json_encode( array( 'status' => 'no-results', 'table' => 'expenses', 'lastId' => $lastId, 'timestamp' => time() ) ) );
                        exit;
                     }
                     sleep( 1 );
                     $numNewExpeses = $database->count("expenses", [
                                         "AND" => [
                                             "expense_date[>=]" => $timestamp,
                                             "expense_id[>]" => $lastId,
                                             "expense_approved" => "Awaiting...",
                                             "admin_id" => $adminId,
                                             "is_deleted" => 0
                                         ]
                                     ]);
                     $timer += 1;
                  }
               }
            }
          
            if( $numNewExpeses >= 1){

               $lastId = $database->max("expenses", "expense_id", [
                   "admin_id" => $adminId
               ]);

               $userId = $database->select("expenses", "user_id", [
                             "AND" => [
                                 "expense_date[>=]" => $timestamp,
                                 "expense_id" => $lastId,
                                 "admin_id" => $adminId,
                                 "is_deleted" => 0
                             ]
                         ]);

               $user = $database->select("users", "user_name",[
                           "user_id" => $userId[0]
                        ]);

               echo json_encode( array( 'status' => 'results', 'timestamp' => time(), 'lastId' => $lastId, 'username' => $user[0], 'userAction' => "New Expense Added") );
            } 
         }
   }


   function pollJourneys(){

      session_start();
      if(isset($_SESSION["adminId"])){
            $adminId = $_SESSION["adminId"];
            session_write_close();


            $database = connectDB(); 
            $lastId = $_GET['lastId'];
            $timestamp = trim( $_GET['timestamp'] );
            if($timestamp){
               $timestamp = time();
            }
                
            $timer = 0;
            $numNewJourneys = 0;
            
            $numNewJourneys = $database->count("journeys", [
                                   "AND" => [
                                       "date[>=]" => $timestamp,
                                       "id[>]" => $lastId,
                                       "approved" => "Awaiting...",
                                       "admin_id" => $adminId,
                                       "is_deleted" => 0
                                   ]
                               ]);
               
            if($numNewJourneys <= 0){
               while($numNewJourneys <= 0){
                  if($numNewJourneys <= 0){
                     if($timer >= 30){
                        die( json_encode( array( 'status' => 'no-results', 'table' => 'journeys', 'lastId' => $lastId, 'timestamp' => time() ) ) );
                        exit;
                     }
                     sleep( 1 );
                     $numNewJourneys = $database->count("journeys", [
                                   "AND" => [
                                       "date[>=]" => $timestamp,
                                       "id[>]" => $lastId,
                                       "approved" => "Awaiting...",
                                       "admin_id" => $adminId,
                                       "is_deleted" => 0
                                   ]
                               ]);
                     $timer += 1;
                  }
               }
            }
          
            if( $numNewJourneys >= 1){

               $lastId = $database->max("journeys", "id", [
                   "admin_id" => $adminId
               ]);

               $userId = $database->select("journeys", "user_id", [
                             "AND" => [
                                 "date[>=]" => $timestamp,
                                 "id" => $lastId,
                                 "admin_id" => $adminId,
                                 "is_deleted" => 0
                             ]
                         ]);

               $user = $database->select("users", "user_name",[
                           "user_id" => $userId[0]
                        ]);

               echo json_encode( array( 'status' => 'results', 'timestamp' => time(), 'lastId' => $lastId, 'username' => $user[0], 'userAction' => "New Journey Added") );
            } 
         }
   }


   function pollUsers(){

      session_start();
      if(isset($_SESSION["adminId"])){
            $adminId = $_SESSION["adminId"];
            session_write_close();
            $database = connectDB(); 
            
                
            $timer = 0;
            $numOnlineUsers = 0;
            
            $numOnlineUsers = $database->count("users", [
                                   "AND" => [
                                       "is_online" => 1,
                                       "admin_id" => $adminId,
                                       "is_deleted" => 0
                                   ]
                               ]);
               
            if($numOnlineUsers <= 0){
               while($numOnlineUsers <= 0){
                  if($numOnlineUsers <= 0){
                     if($timer >= 30){
                        die( json_encode( array( 'status' => 'no-results', 'table' => 'users', "onlineUsers" => "" ) ) );
                        exit;
                     }
                     sleep( 1 );
                     $numOnlineUsers = $database->count("users", [
                                   "AND" => [
                                       "is_online" => 1,
                                       "admin_id" => $adminId,
                                       "is_deleted" => 0
                                   ]
                               ]);
                     $timer += 1;
                  }
               }
            }
          
            if( $numOnlineUsers >= 1){

               $users = $database->select("users", "user_name",[
                           "AND" => [
                                    "is_online" => 1,
                                    "admin_id" => $adminId,
                                    "is_deleted" => 0
                                   ]
                               ]);
                  

               echo json_encode( array( 'status' => 'results', "table" => 'users', 'onlineUsers' => $users) );
            } 
         }
   }



?>