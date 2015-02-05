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
            $option = $_GET['option'];
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

               //query and output for notification
               if($option == "notification"){

                  $lastId = $database->max("expenses", "expense_id", [
                      "AND" => [
                           "admin_id" => $adminId,
                           "is_deleted" => 0
                        ]
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

                  echo json_encode( array( 'status' => 'results', 'timestamp' => time(), 'lastId' => $lastId, 'username' => $user[0], 'userAction' => "New Expense Added", 'option' => 'notification') );
               
               }else{

                  //query and output for recent expenses widget
                  $sql = "SELECT users.user_name, expenses.expense_date
                          FROM users, expenses
                          WHERE users.user_id = expenses.user_id
                          AND expense_approved = 'Awaiting...'
                          AND expenses.admin_id = $adminId
                          AND expenses.is_deleted = 0
                          AND users.is_deleted = 0 
                          ORDER BY expenses.expense_date DESC";

                  $widgetData = $database->query($sql)->fetchAll();

                  echo json_encode( array( 'status' => 'results', 'timestamp' => time(), 'widgetData' => $widgetData, "table" => "expenses", 'userAction' => "Update Expense Widget", 'option' => 'widget') ); 
               }
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
            $option = $_GET['option'];
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

               if($option == "notification"){

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
               }else{

                  //query and output for recent expenses widget
                  $sql = "SELECT users.user_name, journeys.date
                          FROM users, journeys
                          WHERE users.user_id = journeys.user_id
                          AND journeys.approved = 'Awaiting...'
                          AND journeys.admin_id = $adminId
                          AND journeys.is_deleted = 0
                          AND users.is_deleted = 0 
                          ORDER BY journeys.date DESC";

                  $widgetData = $database->query($sql)->fetchAll();

                  echo json_encode( array( 'status' => 'results', 'timestamp' => time(), 'widgetData' => $widgetData, "table" => "journeys", 'userAction' => "Update Journey Widget", 'option' => 'widget') ); 


               }

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