function initialiseChart(table, type){

    google.load('visualization', '1.0', {'packages':['corechart'], 'callback' : function create(){
      
      switch(type){
        case "bar" : drawBarChart(table);
        break;
        case "pie" : drawPieChart(table);
        break;
        case "line" : drawLineChart(table);
        break;
      }

    }});  
}


function drawLineChart(table){


      var data = processData(table);

      var formattedData = google.visualization.arrayToDataTable([
          ['Month', '€'],
          [data.col_1, data.val_1],
          [data.col_2, data.val_2],
          [data.col_3, data.val_3],
          [data.col_4, data.val_4],
          [data.col_5, data.val_5],
          [data.col_6, data.val_6],
          [data.col_7, data.val_7],
          [data.col_8, data.val_8],
          [data.col_9, data.val_9],
          [data.col_10, data.val_10],
          [data.col_11, data.val_11],
          [data.col_12, data.val_12]

        ]);

      var options = {
        width: 1200,
        height: 563,
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Total Expenditure'
        },
        backgroundColor: "#EDF1F3",
        series: {
            0: { color: '#273a45' }
        },
        tooltip: {isHtml: true},
        lineWidth: 1,
        line: {groupWidth: "5%"},
      };

      var chart = new google.visualization.LineChart(document.getElementById('mainView'));

      chart.draw(formattedData, options);

}



function drawPieChart(table){

  var data = processData(table);

  var formattedData = google.visualization.arrayToDataTable([
          ['Merchants', 'Total spend'],
          [data.col_1, data.val_1],
          [data.col_2, data.val_2],
          [data.col_3, data.val_3],
          [data.col_4, data.val_4],
          [data.col_5, data.val_5],
          [data.col_6, data.val_6],
          [data.col_7, data.val_7],
          [data.col_8, data.val_8]
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
            5: { color: '#273a45' },
            6: { color: '#172329' },
            7: { color: '#b8c7d0' },
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

    if(table.data[5] == undefined){
      tableData.col_6 = "";
      tableData.val_6 = 1;
    }else{
      tableData.col_6 = table.data[5].column;
      tableData.val_6 = parseFloat(table.data[5].colValue);
    }


    if(table.data[6] == undefined){
      tableData.col_7 = "";
      tableData.val_7 = 1;
    }else{
      tableData.col_7 = table.data[6].column;
      tableData.val_7 = parseFloat(table.data[6].colValue);
    }

    if(table.data[7] == undefined){
      tableData.col_8 = "";
      tableData.val_8 = 1;
    }else{
      tableData.col_8 = table.data[7].column;
      tableData.val_8 = parseFloat(table.data[7].colValue);
    }

    if(table.data[8] == undefined){
      tableData.col_9 = "";
      tableData.val_9 = 1;
    }else{
      tableData.col_9 = table.data[8].column;
      tableData.val_9 = parseFloat(table.data[8].colValue);
    }

    if(table.data[9] == undefined){
      tableData.col_10 = "";
      tableData.val_10 = 1;
    }else{
      tableData.col_10 = table.data[9].column;
      tableData.val_10 = parseFloat(table.data[9].colValue);
    }

    if(table.data[10] == undefined){
      tableData.col_11 = "";
      tableData.val_11 = 1;
    }else{
      tableData.col_11 = table.data[10].column;
      tableData.val_11 = parseFloat(table.data[10].colValue);
    }

    if(table.data[11] == undefined){
      tableData.col_12 = "";
      tableData.val_12 = 1;
    }else{
      tableData.col_12 = table.data[11].column;
      tableData.val_12 = parseFloat(table.data[11].colValue);
    }
    


    return tableData;


    }

