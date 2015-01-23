function initialiseBarChart(table){
  google.load('visualization', '1.0', {'packages':['corechart'], 'callback' : function create(){
    drawBarChart(table);
  }});
}


function drawBarChart(table){

      var data = processData(table);

      var formattedData = google.visualization.arrayToDataTable([
        ["Element", "Amount €", { role: "style" } ],
        [data.col_1, data.val_1, "#a7bac4"],
        [data.col_2, data.val_2, "#608295"],
        [data.col_3, data.val_3, "#273a45"],
        [data.col_4, data.val_4, "#839ead"],
        [data.col_5, data.val_5, "#47697c"],
        [data.col_6, data.val_6, "#273a45"]
      ]);

      var view = new google.visualization.DataView(formattedData);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Category Expenditure",
        width: 1200,
        height: 600,
        bar: {groupWidth: "60%"},
        legend: { position: "none" },
        backgroundColor: "#EDF1F3"
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("mainView"));
      chart.draw(view, options);
  }



  function processData(table){

    var tableData = {};

    if(table.data[0] == undefined){
      tableData.col_1 = "";
      tableData.val_1 = 0;
    }else{
      tableData.col_1 = table.data[0].expense_category;
      tableData.val_1 = parseFloat(table.data[0].total_cost);
    }

    if(table.data[1] == undefined){
      tableData.col_2 = "";
      tableData.val_2 = 0;
    }else{
      tableData.col_2 = table.data[1].expense_category;
      tableData.val_2 = parseFloat(table.data[1].total_cost);
    }

    if(table.data[2] == undefined){
      tableData.col_3 = "";
      tableData.val_3 = 0;
    }else{
      tableData.col_3 = table.data[2].expense_category;
      tableData.val_3 = parseFloat(table.data[2].total_cost);
    }

    if(table.data[5] == undefined){
      tableData.col_6 = "";
      tableData.val_6 = 0;
    }else{
      tableData.col_6 = table.data[5].expense_category;
      tableData.val_6 = parseFloat(table.data[5].total_cost);
    }

    if(table.data[3] == undefined){
      tableData.col_4 = "";
      tableData.val_4 = 0;
    }else{
      tableData.col_4 = table.data[3].expense_category;
      tableData.val_4 = parseFloat(table.data[3].total_cost);
    }

    if(table.data[4] == undefined){
      tableData.col_5 = "";
      tableData.val_5 = 0;
    }else{
      tableData.col_5 = table.data[4].expense_category;
      tableData.val_5 = parseFloat(table.data[4].total_cost);
    }


    return tableData;


    }

