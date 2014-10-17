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
        'datatables' : ['//cdn.datatables.net/1.10.1/js/jquery.dataTables', '../../../Glide/js/vendor/datatables'],
        'modal' : ['../../js/vendor/jquery.simplemodal.1.4.4.min']
    },
    shim:{
    	'bootstrap': ['jquery'],
        'datatables': ['jquery'],
        'modal': ['jquery']
    }
});

require(['jquery', 
		 'modernizr', 
		 'boilerPlugins', 
		 'analytics',
		 'bootstrap',
		 'cssLess',
         'datatables',
         'modal'], function($) {

            
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
             * Name: setLinkColour
             * Purpose: Set link to active colour.
             */
            function setLinkColour(link){
                $("nav a").css("background-color", "#7290a1");
                $(link).css("background-color", "#1f2e37");
            }


            /**
             * Name: submitModalForm
             * Purpose: Submit modal form using Ajax.
             * @param : form - String : form to send
             */
            function submitModalForm(form){
                var frm = $(form);
                frm.submit(function (ev) {
                    ev.preventDefault();
                    var data = frm.serialize();
                    console.log("Data for server : " + data);
                    $.ajax({
                        type: frm.attr('method'),
                        url: appData.api,
                        data: data,
                        success: function (data) {
                            console.log("Ajax success");
                            console.log(data);
                        },
                        error: function(){
                            console.log("Error: Ajax request unsuccessful");
                        }
                    });
                });
            }


            /**
             * Name: getTableData
             * Purpose: Query database.
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
                "searching": false,
                "ordering": false
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
                        {"data": "DT_RowId"},
                        {"data": "user_name"},
                        {"data": "user_email"}
                    ]
                });
            }


            /**
             * Name: buildJourneyTable
             * Purpose: Call datatables.js on DOM element and add data to created table.
             * @params: tableData - JSON : data to populate table
             */
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

            

            /**
             * Name: displayModal
             * Purpose: Take div, add options and display as modal.
             * @params: div - String : div to process
             */
            function displayModal(div){
                $(div).modal({
                    opacity:50,
                    overlayCss: {backgroundColor:"#000"},
                    onOpen: function(dialog){
                        dialog.overlay.fadeIn('slow', function(){
                            dialog.data.fadeIn(50, function() {
                                dialog.container.fadeIn(500);
                            });
                        });
                    }
                });   
            }

            /**
             * Name: initialiseEvents
             * Purpose: Initialise application events
             */
            function initialiseEvents(){
                
                //load home page
                setLinkColour("#navHome");
                getPage("../root/overview.php", "standard");

                submitForm('#signUpForm');
                submitForm('#signInForm');

                
                // navbar events
                $("#btnSignOut").on("click", function(){
                    signOut();
                });
                $("#navHome").click(function(){
                    setLinkColour(this);
                    getPage("../root/overview.php", "standard");
                });
                $("#navExpenses").click(function(){
                    setLinkColour(this);
                    getPage("../root/expenses.php", "getExpensesData", "datatable");
                });
                $("#navJourneys").click(function(){
                    setLinkColour(this);
                    getPage("../root/journeys.php", "getJourneysData", "datatable");
                });
                $("#navUsers").click(function(){
                    setLinkColour(this);
                    getPage("../root/users.php", "getUsersData", "datatable");
                });
                $("#navAdmin").click(function(){
                    setLinkColour(this);
                    getPage("../root/admin.php", "standard");
                });

                //modal events
                $("body").delegate("#btnAddExpense", "click", function(){
                    displayModal("#modalAddExpense");    
                });

                $("body").delegate("#btnAddJourney", "click", function(){
                    displayModal("#modalAddJourney");    
                });

                $("body").delegate("#btnAddUser", "click", function(){
                    displayModal("#modalAddUser");   
                });


                //submit modal forms
                $("body").delegate("#btnSubmitExpense", "click", function(){
                    submitModalForm("#modalExpenseForm");
                });

                $("body").delegate("#btnSubmitJourney", "click", function(){
                    submitModalForm("#modalJourneyForm");
                });

                $("body").delegate("#btnSubmitUser", "click", function(){
                    submitModalForm("#modalUserForm");
                });

            }

            initialiseEvents();
               
});








