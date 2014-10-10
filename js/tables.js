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
            {"data": "expense_name"},
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
            {"data": "comment"}
        ]
    });
}

function initialiseTables(){
    getTableData("getExpensesData");
    getTableData("getUsersData");
    getTableData("getJourneysData");
}