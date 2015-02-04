
//when signed in start polling server
if($('#ajaxContent').is('.home')){
  startPolling();
}

/**
 * Name: startPolling
 * Purpose: Call poll function for each table.
 */
function startPolling(){

   poll(true, 0, "pollExpenses");
   poll(true, 0, "pollJourneys");
   poll(true, 0, "pollUsers");
     
}


/**
 * Name: poll
 * Purpose: Poll server for new data.
 * @param : timestamp - String : timestamp to check for freshness.
 * @param : lastId - Int  : The id of the last record retrieved from database.
 * @param : action - String : Name of function to be called on server.
 */
function poll( timestamp, lastId, action ){
   
   var timeout;
 
   $.ajax({
      url: '../api/polling/pollingAPI.php',
      type: 'GET',
      data: 'timestamp=' + timestamp + '&lastId=' + lastId + '&action=' + action,
      dataType: 'json',
      success: function(server){
         
         clearInterval(timeout);

         console.log("Returned Polling Data : " + JSON.stringify(server));
         
         if(server.status == 'results' || server.status == 'no-results'){
            timeout = setTimeout( function(){
               poll( server.timestamp, server.lastId, action);
            }, 5000 );
            
            if(server.status == 'results' && server.table != "users"){
               notification(server.username, server.userAction, moment($.now()).format('h:mm:ss a'));
            }else if(server.table == 'users'){
               updateOnlineUsers(server.onlineUsers); //widgets.js
            }

         }else if(server.status == 'error'){
            alert('We got confused, Please refresh the page!');
         }

      },
      error: function(server){
         clearInterval(timeout);
         console.log("Server Error...");
         timeout=setTimeout( function(){
            poll( server.timestamp, server.lastId, action );
         }, 15000 );
      }
   });
}



