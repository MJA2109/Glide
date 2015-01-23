function initialiseChart(table, type){

    google.load('visualization', '1.0', {'packages':['corechart'], 'callback' : function create(){
      
      switch(type){
        case "bar" : drawBarChart(table);
        break;
        case "pie" : drawPieChart(table);
        break;
      }

    }});  
}



function drawPieChart(table){

  var data = processData(table);

  var formattedData = google.visualization.arrayToDataTable([
          ['Merchants', 'Total spend'],
          [data.col_1, data.val_1],
          [data.col_2, data.val_2],
          [data.col_3, data.val_3],
          [data.col_4, data.val_4],
          [data.col_5, data.val_5]
        ]);

        var options = {
          title: 'Most Popular Merchants',
          width: 1200,
          height: 600,
          backgroundColor: "#EDF1F3",
          slices: {
            0: { color: '#a7bac4' },
            1: { color: '#608295' },
            2: { color: '#273a45' },
            3: { color: '#839ead' },
            4: { color: '#47697c' },
            5: { color: '#273a45' }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('mainView'));

        chart.draw(formattedData, options);

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
      tableData.val_1 = 1;
    }else{
      tableData.col_1 = table.data[0].column;
      tableData.val_1 = parseFloat(table.data[0].colValue);
    }

    if(table.data[1] == undefined){
      tableData.col_2 = "";
      tableData.val_2 = 1;
    }else{
      tableData.col_2 = table.data[1].column;
      tableData.val_2 = parseFloat(table.data[1].colValue);
    }

    if(table.data[2] == undefined){
      tableData.col_3 = "";
      tableData.val_3 = 1;
    }else{
      tableData.col_3 = table.data[2].column;
      tableData.val_3 = parseFloat(table.data[2].colValue);
    }

    if(table.data[5] == undefined){
      tableData.col_6 = "";
      tableData.val_6 = 1;
    }else{
      tableData.col_6 = table.data[5].column;
      tableData.val_6 = parseFloat(table.data[5].colValue);
    }

    if(table.data[3] == undefined){
      tableData.col_4 = "";
      tableData.val_4 = 1;
    }else{
      tableData.col_4 = table.data[3].column;
      tableData.val_4 = parseFloat(table.data[3].colValue);
    }

    if(table.data[4] == undefined){
      tableData.col_5 = "";
      tableData.val_5 = 1;
    }else{
      tableData.col_5 = table.data[4].column;
      tableData.val_5 = parseFloat(table.data[4].colValue);
    }


    return tableData;


    }

