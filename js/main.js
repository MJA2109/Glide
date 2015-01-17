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
        'modal' : ['../../js/vendor/jquery.simplemodal.1.4.4.min'],
        'validator' : ['//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min'],
        'val' : ['../../js/val'],
        'notify' : ['../../js/vendor/notify.min'],
        'moment' : ["../../js/vendor/moment"],
        'datepicker' : ["../../js/vendor/bootstrap-datepicker"]
    },
    shim:{
    	'bootstrap': ['jquery'],
        'datatables': ['jquery'],
        'modal': ['jquery'],
        'validator' : ['jquery'],
        'val' : ['validator'],
        'notify' : ['jquery'],
        'moment' : ['jquery'],
        'datepicker' : ['jquery']
    }
});

require(['jquery', 
		 'modernizr', 
		 'boilerPlugins', 
		 'analytics',
		 'bootstrap',
		 'cssLess',
         'datatables',
         'modal',
         'validator',
         'val',
         'notify',
         'moment',
         'datepicker'], function($) {

            
            //Contains global variables
            var appData = {
                api: "../api/handlers/webHandler.php",
                apiKey: "dflj45fgfg343fggf454rgf53"
            }

            /**
             * Name: submitFrom
             * Purpose: Submits form for signing in/up. Redirection based on return Ajax values.
             * @params: from - string : form to be processed
             */
            function submitForm(form){
                var frm = $(form);
                frm.submit(function (ev) {
                    var data = frm.serialize();
                    console.log(data);
                    $.ajax({
                        type: frm.attr('method'),
                        url: appData.api,
                        data: data,
                        success: function (data) {
                            var logData = JSON.parse(data);
                            console.log("submitFrom - RETURNED FROM SERVER : " + JSON.stringify(logData));
                            //check for errors
                            var errorCount = Object.keys(logData.errors).length;
                            if(logData.type == "registration" && errorCount == 0){
                                window.location = "signIn.php"
                            }else if(logData.type == "signIn"){
                                if(errorCount == 0){
                                    window.localStorage.layout = "admin";
                                    window.location = "home.php";
                                }else{
                                    errorFeedback(); 
                                    $("#errorNote").notify("Incorrect details...");    
                                }
                            }else if(logData.type == "pmSignIn"){
                                if(errorCount == 0){
                                    window.localStorage.layout = "projectManager";
                                    window.location = "home.php";
                                }else{
                                    errorFeedback();
                                    $("#errorNote").notify("Incorrect details...");
                                }
                            }else{
                                console.log("Error : " + JSON.stringify(data));
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
             * @param : form - String : form to sent.
             */
            function submitModalForm(form){
                var frm = $(form);
                frm.submit(function (ev) {
                    var data = frm.serialize();
                    console.log("Data for server : " + data);
                    $.ajax({
                        type: frm.attr('method'),
                        url: appData.api,
                        data: data,
                        success: function (data) {
                            console.log("Ajax success");
                            console.log(data);
                            var log = JSON.parse(data);
                            var errorCount = Object.keys(log.errors).length;
                            if(log.table == "expenses"){
                                if(errorCount == 0){
                                    resetButtons();
                                    refreshTable("#expensesTable", "getExpensesData");
                                    $.modal.close();
                                }else{
                                    console.log(JSON.stringify(log));
                                }  
                            }else if(log.table == "journeys"){
                                if(errorCount == 0){
                                    resetButtons();
                                    refreshTable("#journeysTable", "getJourneysData");
                                    $.modal.close();
                                }else{
                                    console.log(JSON.stringify(log));
                                }
                            }else if(log.table == "users"){
                                if(errorCount == 0){
                                    resetButtons();
                                    refreshTable("#usersTable", "getUsersData");
                                    $.modal.close();
                                }else{
                                    console.log(JSON.stringify(log));
                                }  
                            }
                            
                        },
                        error: function(){
                            console.log("Error: Ajax request unsuccessful");
                        }
                    });
                    // $(form).unbind('submit');
                    ev.preventDefault();
                    ev.stopImmediatePropagation();
                    return false;  
                });
            }

            

            /**
             * Name: clearForm
             * Purpose: Reset text input fields.
             * @param : form - String : form to processed.
             */
            function clearForm(form){
                $(form + " input[type = text]").val("");
            }

            
            /**
             * Name: deleteData
             * Purpose: Send Ajax request to server and delete the specified data.
             * @params: data - json : object containing data to specify which rows/row to delete.
             */
            function deleteData(data){
                console.log(JSON.stringify(data));
                $.ajax({
                    type: "POST",
                    url: appData.api,
                    data: data,
                    success: function (data) {
                        console.log("Ajax success");
                        console.log(data);
                        var data = JSON.parse(data);
                        if(data.Table == "expenses"){
                            resetButtons();
                            refreshTable("#expensesTable", "getExpensesData");
                        }else if(data.Table == "journeys"){
                            resetButtons();
                            refreshTable("#journeysTable", "getJourneysData");
                        }else if(data.Table == "users"){
                            resetButtons();
                            refreshTable("#usersTable", "getUsersData");
                        }
                        $.modal.close();
                    },
                    error: function(){
                        console.log("Error: Ajax request unsuccessful");
                    }
                });
            }

            /**
             * Name: refreshTable
             * Purpose: Refresh specified table.
             * @params: tableId - string : table to be refreshed.
             * @params: action - string : the process to be executed by server.
             */
            function refreshTable(tableId, action){
                var table = $(tableId).dataTable();
                table.fnDestroy();
                getTableData(action);
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
                        {
                            "data": "expense_cost",
                            "render" : function(data){
                                return "€ " + data;
                            }
                        },
                        {
                            "data": "receipt_image",
                            "render" : function(data){
                                return  data == null || data == "default" ?
                                        " " :
                                        "<div class = 'receiptLink' url = '" + data +"'>"+
                                            "<p><span class='glyphicon glyphicon-picture'>Image</span></p>"+
                                       "</div>";
                            }

                        },
                        {
                            "data": "expense_date",
                            "render" : function(data){
                                return moment(data).format('MMMM Do YYYY, h:mm:ss a');
                            }
                        },
                        {"data": "expense_status"},
                        {"data": "account"},
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
                        {"data": "user_mobile"},
                        {"data": "user_email"},
                         {
                            "data": "user_mileage_rate",
                            "render" : function(data){
                                return "€ " + data;
                            }
                        },
                        {"data": "user_type"}
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
                        {
                            "data": "distance",
                            "render" : function(data){
                                return "Km " + data;
                            }
                        },
                        {
                            "data": "journey_time",
                            "render" : function(data){
                                return data;
                            }

                        },
                        {
                            "data": "date",
                            "render" : function(data){
                                return moment(data).format('MMMM Do YYYY, h:mm:ss a');
                            }
                        },
                        {"data": "status"},
                        {"data": "account"},
                        {"data": "comment"}
                    ]
                });
            }


            /**
             * Name: displaySearchResults
             * Purpose: Build table with search results.
             * @params: buildTableFunction - function : specify which table to build.
             * @params: tableData - JSON : search results.
             * @params: tableId - String : id of table to insert data.
             */
            function displaySearchResults(buildTableFunction, tableData, tableId){
                var table = $(tableId).dataTable();
                table.fnDestroy();
                buildTableFunction(tableData);    
            }


            /**
             * Name: searchForm
             * Purpose: Search database for specific entries. Display results in datatable.
             * @params: form - String : form to be processed.
             */
            function searchForm(form){
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
                            var returnedData = JSON.parse(data);
                            console.log(JSON.stringify(returnedData));
                            switch(returnedData.type){
                                case "expenses" : 
                                displaySearchResults(buildExpensesTable, returnedData.results, "#expensesTable");
                                clearForm("#searchExpensesForm");
                                break;
                                case "journeys" : 
                                displaySearchResults(buildJourneysTable, returnedData.results, "#journeysTable");
                                clearForm("#searchJourneysForm");
                                break;
                                case "users" :
                                displaySearchResults(buildUserTable, returnedData.results, "#usersTable");
                                clearForm("#searchUsersForm");
                                break;
                            }
                        },
                        error: function(){
                            console.log("Error: Ajax request unsuccessful");
                        }
                    });
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
                        attachValEvent(div); //method located in val.js
                    }
                });   
            }


            /**
             * Name: resetButtons
             * Purpose: Reset control buttons.
             */
            function resetButtons(){
                $(".btnAdd").attr("disabled", false);
                $(".btnEdit, .btnDelete").attr("disabled", true);
            }


            /**
             * Name: setAdminLayout
             * Purpose: Display all features in layout.
             */
            function setAdminLayout(){
                $(document).on('DOMNodeInserted', function() {
                    $("#subHeaderSec2").removeClass('hidden');
                    $("#navUsers").removeClass('hidden');
                    $(".accountSearch").removeClass('hidden');
                });
            }


            /**
             * Name: setProjectManagerLayout
             * Purpose: Hide certain features in layout.
             */
            function setProjectManagerLayout(){
                $(document).on('DOMNodeInserted', function() {
                    $("#subHeaderSec2").addClass('hidden');
                    $("#navUsers").addClass('hidden');
                    $(".accountSearch").addClass('hidden');
                });
            }


            /**
             * Name: errorFeedback
             * Purpose: Add red colour to selected divs.
             */
            function errorFeedback(){
                $(".input-group-addon").addClass("err");
                $(".input-group-addon").addClass("err");
                $("input[type = 'text'], input[type = 'email'], input[type = 'password']").addClass("errBorder");
            }



            /**
             * Name: formatDecimal
             * Purpose: Remove € sign and add .00 to number if doesn't exist.
             * @params: data - Int : Int to process
             * @return: data - Int : formatted int
             */
            function formatDecimal(data){
                data = data.replace(/[^\d \.]/g, '');
                data = data.trim();
                if(data.indexOf(".") == -1){
                    data = data + ".00";
                }
                return data;
            }


            function transition(){
                $("#ajaxContent").hide().fadeIn();
            }


            /**
             * Name: initialiseEvents
             * Purpose: Initialise application events
             */
            function initialiseEvents(){

                //array to hold Ids of selected users, expenses and journeys
                var selectedIdStack = new Array();
                
                //load home page
                setLinkColour("#navHome");
                getPage("../root/overview.php", "standard");

                submitForm('#signUpForm');
                submitForm('#signInForm');
                submitForm('#pmSignInForm');

                //set layout
                if(window.localStorage.layout == "admin"){
                    setAdminLayout();
                }
                if(window.localStorage.layout == "projectManager"){
                   setProjectManagerLayout(); 
                }

                
                /********* NAVBAR EVENTS **********/
                $("#btnSignOut").on("click", function(){
                    signOut();
                });
                $("#navHome").click(function(){
                    setLinkColour(this);
                    getPage("../root/overview.php", "standard");
                    transition();
                });
                $("#navExpenses").click(function(){
                    setLinkColour(this);
                    selectedIdStack = new Array(); //reset array
                    getPage("../root/expenses.php", "getExpensesData", "datatable");
                    transition();
                });
                $("#navJourneys").click(function(){
                    setLinkColour(this);
                    selectedIdStack = new Array(); //reset array
                    getPage("../root/journeys.php", "getJourneysData", "datatable");
                    transition();
                });
                $("#navUsers").click(function(){
                    setLinkColour(this);
                    selectedIdStack = new Array(); //reset array
                    getPage("../root/users.php", "getUsersData", "datatable");
                    transition();
                });
                $("#navAdmin").click(function(){
                    setLinkColour(this);
                    getPage("../root/admin.php", "standard");
                });


                //display add data modals
                $("body").delegate("#btnAddExpense", "click", function(){
                    displayModal("#modalAddExpense");    
                });

                $("body").delegate("#btnAddJourney", "click", function(){
                    displayModal("#modalAddJourney");    
                });

                $("body").delegate("#btnAddUser", "click", function(){
                    displayModal("#modalAddUser");   
                });


                //add new data - submit modal forms
                $("body").delegate("#btnSubmitExpense", "click", function(){
                    submitModalForm("#modalExpenseForm");
                });

                $("body").delegate("#btnSubmitJourney", "click", function(){
                    submitModalForm("#modalJourneyForm");
                });

                $("body").delegate("#btnSubmitUser", "click", function(){
                    submitModalForm("#modalUserForm");
                });

                //modal delete data events
                $("body").delegate(".btnDelete", "click", function(){
                    displayModal("#modalDeleteConfirmation"); 
                });


                //sumbit update form
                $("body").delegate("#btnSubmitEditExpense", "click", function(){
                    selectedIdStack = new Array(); //reset array
                    submitModalForm("#modalEditExpenseForm");
                });

                $("body").delegate("#btnSubmitEditJourney", "click", function(){
                    selectedIdStack = new Array(); //reset array
                    submitModalForm("#modalEditJourneyForm");
                });

                $("body").delegate("#btnSubmitEditUser", "click", function(){
                    selectedIdStack = new Array(); //reset array
                    submitModalForm("#modalEditUserForm");
                });



                //search database 
                $("body").delegate("#btnSearchExpenses", "click", function(){
                    searchForm("#searchExpensesForm");
                });

                $("body").delegate("#btnSearchJourneys", "click", function(){
                    searchForm("#searchJourneysForm");
                });

                $("body").delegate("#btnSearchUsers", "click", function(){
                    searchForm("#searchUsersForm");
                });

                
                //display update data modal
                $("body").delegate("#btnEditExpense", "click", function(){
                    var dataId = selectedIdStack[0];
                    var row = "#" + dataId;
                    var form = "#modalEditExpenseForm";
                    
                    //get data from table and place in form
                    var name = $(row + " td:nth-child(1)").text();
                    var category = $(row + " td:nth-child(2)").text();
                    var merchant = $(row + " td:nth-child(3)").text();
                    var cost = $(row + " td:nth-child(4)").text();
                    
                    cost = formatDecimal(cost);

                    var status = $(row + " td:nth-child(7)").text();
                    var account = $(row + " td:nth-child(8)").text();
                    var comment = $(row + " td:nth-child(9)").text();

                    $(form + " #expenseId").val(dataId);
                    $(form + " input[name = 'userName']").val(name);
                    $(form + " option[value = '" + status + "']").prop("selected", true);
                    $(form + " option[value = '" + category + "']").prop("selected", true);
                    $(form + " input[name = 'merchant']").val(merchant);
                    $(form + " input[name = 'cost']").val(cost);
                    $(form + " input[name = 'status']").val(status);
                    $(form + " input[name = 'account']").val(account);
                    $(form + " input[name = 'comment']").val(comment);

                    displayModal("#modalEditExpense");   
                });

                $("body").delegate("#btnEditJourney", "click", function(){
                    var dataId = selectedIdStack[0];
                    var row = "#" + dataId;
                    var form = "#modalEditJourneyForm";

                    //get data from table and place in form
                    var name = $(row + " td:nth-child(1)").text();
                    var status = $(row + " td:nth-child(7)").text();
                    var origin = $(row + " td:nth-child(2)").text();
                    var destination = $(row + " td:nth-child(3)").text();
                    var distance = $(row + " td:nth-child(4)").text();
                    distance = distance.replace(/[^\d \.]/g, '');
                    distance = distance.trim();
                    var journeyTime = $(row + " td:nth-child(5)").text();
                    var account = $(row + " td:nth-child(8)").text();
                    var comment = $(row + " td:nth-child(9)").text();

                    $(form + " #journeyId").val(dataId);
                    $(form + " input[name = 'userName']").val(name);
                    $(form + " option[value = '" + status + "']").prop("selected", true);
                    $(form + " input[name = 'origin']").val(origin);
                    $(form + " input[name = 'destination']").val(destination);
                    $(form + " input[name = 'distance']").val(distance);
                    $(form + " input[name = 'journeyTime']").val(journeyTime);
                    $(form + " input[name = 'account']").val(account);
                    $(form + " input[name = 'comment']").val(comment);
                    displayModal("#modalEditJourney");
                });

                $("body").delegate("#btnEditUser", "click", function(){

                    var dataId = selectedIdStack[0];
                    var row = "#" + dataId;
                    var form = "#modalEditUserForm";

                    var userId = $(row + " td:nth-child(1)").text();
                    var userName = $(row + " td:nth-child(2)").text();
                    var userMobile = $(row + " td:nth-child(3)").text();
                    var userEmail = $(row + " td:nth-child(4)").text();
                    var userRate = $(row + " td:nth-child(5)").text();
                    var userType = $(row + " td:nth-child(6)").text();
                    
                    userRate = formatDecimal(userRate);

                    $(form + " #userId").val(dataId);
                    $(form + " input[name = 'userName']").val(userName);
                    $(form + " input[name = 'userMobile']").val(userMobile);
                    $(form + " input[name = 'userEmail']").val(userEmail);
                    $(form + " input[name = 'userMileageRate']").val(userRate);
                    $(form + " option[value = '" + userType + "']").prop("selected", true);

                    displayModal("#modalEditUser");
                });


               

                //add selected rows to array for deleting, submitting or updating
                //data
                $("body").delegate("tbody", "click", function(event){
                    
                    var rowId = $(event.target).parent().attr("id");
                    if($.inArray(rowId, selectedIdStack) == -1){
                        selectedIdStack.push(rowId);
                        $(event.target).parent().addClass("selected");
                    }else{
                        selectedIdStack.splice($.inArray(rowId, selectedIdStack), 1);
                        $(event.target).parent().removeClass("selected");
                    }

                    // alert(selectedIdStack);
                
                    //disable endable deletion, add and edit buttons
                    if(selectedIdStack.length == 0){
                        $(".btnAdd").attr("disabled", false);
                        $(".btnEdit, .btnDelete").attr("disabled", true);
                    }else if( selectedIdStack.length == 1){
                        $(".btnEdit, .btnDelete").attr("disabled", false);
                        $(".btnAdd").attr("disabled", true);
                    }else{
                        $(".btnEdit, .btnAdd").attr("disabled", true);
                        $(".btnDelete").attr("disabled", false);   
                    }

                });


                //confirm deletion modal
                $("body").delegate("#modalDeleteConfirmation button", "click", function(event){
                    var action = $(event.target).attr("action");
                    var tableData = $(event.target).attr("id");
                    var rowIds = new Array();
                    rowIds = selectedIdStack;
                    selectedIdStack = [];
                    $(".btnDelete").attr("disabled", "disabled");
                    var data = {
                        action : action,
                        tableData : tableData,
                        rowIds : rowIds
                    }
                    deleteData(data);
                });

                //toggle sign out div
                $("#emailDiv").click(function(){
                    $("#signOutDiv").toggle("slow");
                });
                
                //call receipt image modal
                $("body").delegate(".receiptLink", "click", function(event){
                    var url = $(event.target).closest("div").attr("url");
                    $(".modalReceiptImage img").attr("src", url);
                    displayModal(".modalReceiptImage");
                    event.stopImmediatePorpagtion();
                });

                //initialise datapicker
                $("body").delegate(".searchDatePicker", "focus", function(){
                    $(".searchDatePicker").datepicker({
                        format: 'yyyy-mm-dd'
                    }).on('changeDate', function(e){
                        $(this).datepicker('hide');
                    });;
                });

                // $("body").delegate(".simplemodal-close", "click", function(){
                //     selectedIdStack = new Array();
                //     alert(selectedIdStack);    
                // });
                
            }

            initialiseEvents();              
});








