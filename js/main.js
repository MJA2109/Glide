requirejs.config({
    appDir: ".",
    baseUrl: "js",
    paths: { 
        'jquery': ['//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min', 'vendor/jquery-1.10.2.min'],
        'modernizr' : ['../../js/vendor/modernizr-2.6.2.min'],
        'boilerPlugins' : ['../../js/plugins'],
        'analytics' : ['../../js/analytics'],
        'bootstrap': ['//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min', 'vendor/boostrap.min'],
        'cssLess' : ['//cdnjs.cloudflare.com/ajax/libs/less.js/1.7.3/less.min', 'vendor/less-1.7.3.min'],
        'datatables' : ['//cdn.datatables.net/1.10.1/js/jquery.dataTables', '../../../Glide/js/vendor/datatables']
    },
    shim:{
    	'bootstrap': ['jquery'],
        'datatables': ['jquery']
    }
});

require(['jquery', 
		 'modernizr', 
		 'boilerPlugins', 
		 'analytics',
		 'bootstrap',
		 'cssLess',
         'datatables'], function($) {

            
            //Contains global variables
            var appData = {
                api: "../api/glideAPI.php",
                apiKey: "dflj45fgfg343fggf454rgf53"
            }

            
            /**
             * Name: submitFrom
             * Purpose: Submits form using ajax. Redirection based on return Ajax values.
             * @params: from - string : form to be processed
             */
            function submitForm(form){
                var frm = $(form);
                frm.submit(function (ev) {
                    var data = frm.serialize();
                    console.log(data);
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: data,
                        success: function (data) {
                            var logData = JSON.parse(data);
                            console.log("submitFrom - RETURNED FROM SERVER : " + JSON.stringify(logData));
                            //check for errors
                            var errorCount = Object.keys(logData.errors).length;
                            if(logData.type == "registration" && errorCount == 0){
                                window.location = "signIn.php"
                            }else if(logData.type == "signIn" && errorCount == 0){
                                window.location = "home.php";
                            }else{
                                console.log("not working");
                            }
                        },
                        error: function(){
                            console.log("Error: Ajax request unsuccessful");
                        }
                    });

                    ev.preventDefault();
                });
            }

            /**
             * Name: signOut
             * Purpose: Send Ajax request to API to destroy session.
             */
            function signOut(){
                var data = {
                    action: "signOut"
                }
                
                $.ajax({
                    url: appData.api,
                    type: "POST",
                    data: data,
                    success: function(){
                        window.location = "index.php";
                    },
                    error: function(){
                        console.log("Error: Ajax request unsuccessful");
                    }
                });
            }


            /**
             * Name: getPage
             * Purpose: loads page at 'url' via ajax call
             * @params: url - string : url of content
             * @params: action - string : function to be called on server
             * @params: pageType - string : identifies weather or not page contains datatables.
             */
            function getPage(url, action, pageType){

                var loader = "<div = id = 'loaderGif'><img src = '../img/gifLoader.gif' alt = 'loading...' /></div>";
                
                $("#ajaxContent").html(loader).load(url, function(){
                    if(pageType == "datatable"){
                        getTableData(action);
                    }
                });  
            }

            /**
             * Name: initialiseEvents
             * Purpose: Initialise application events
             */
            function initialiseEvents(){
                submitForm('#signUpForm');
                submitForm('#signInForm');
                $("#btnSignOut").on("click", function(){
                    signOut();
                });
                $("#navHome").click(function(){
                    getPage("../root/overview.php", "standard");
                });
                $("#navExpenses").click(function(){
                    getPage("../root/expenses.php", "getExpensesData", "datatable");
                });
                $("#navJourneys").click(function(){
                    getPage("../root/journeys.php", "getJourneysData", "datatable");
                });
                $("#navUsers").click(function(){
                    getPage("../root/users.php", "getUsersData", "datatable");
                });
                $("#navAdmin").click(function(){
                    getPage("../root/admin.php", "standard");
                });
            }

            /**
             * Name: getTableData
             * Purpose: Query database for specific data
             * @params: action - string : function to be called on server
             */
            function getTableData(action){
                var data = {
                    action: action
                }

                $.ajax({
                    url: appData.api,
                    type: "POST",
                    data: data,
                    success: function(response){
                        var tableData = JSON.parse(response);
                        console.log("getTableData - RETURNED FROM SERVER : " + JSON.stringify(tableData));
                        switch(action){
                            case "getExpensesData":
                                buildExpensesTable(tableData);
                                break;
                            case "getUsersData":
                                buildUserTable(tableData);
                                break;
                            case "getJourneysData":
                                buildJourneysTable(tableData);
                                break;
                        }
                    },
                    error: function(){
                        console.log("Error: Ajax request unsuccessful");   
                    }
                });
            }


            //Set global options for datatables.js
            $.extend( $.fn.dataTable.defaults, {
                searching: false
            });


            /**
             * Name: buildExpensesTable
             * Purpose: Call datatables.js on DOM element and add data to created table.
             * @params: tableData - JSON : data to populate table
             */
            function buildExpensesTable(tableData){

                $("#expensesTable").dataTable({
                    "data" : tableData,
                    "columns" : [
                        {"data": "user_name"},
                        {"data": "expense_category"},
                        {"data": "merchant_name"},
                        {"data": "expense_cost"},
                        {"data": "receipt_image"},
                        {"data": "expense_date"},
                        {"data": "expense_status"},
                        {"data": "expense_comment"}
                    ]
                });
            }

            /**
             * Name: buildUserTable
             * Purpose: Call datatables.js on DOM element and add data to created table.
             * @params: tableData - JSON : data to populate table
             */
            function buildUserTable(tableData){

                $("#usersTable").dataTable({
                    "data" : tableData,
                    "columns" : [
                        {"data": "user_name"},
                        {"data": "user_email"}
                    ]
                });
            }


            function buildJourneysTable(tableData){
                
                $("#journeysTable").dataTable({
                    "data" : tableData,
                    "columns" : [
                        {"data": "user_name"},
                        {"data": "origin"},
                        {"data": "destination"},
                        {"data": "distance"},
                        {"data": "journey_time"},
                        {"data": "date"},
                        {"data": "status"},
                        {"data": "comment"}
                    ]
                });
            }

            initialiseEvents();
     
        
});








