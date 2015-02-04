function updateOnlineUsers(onlineUsers){	
	$(".onlineUsers ul").empty();	
	if(onlineUsers != ""){
		for(var i = 0; i < onlineUsers.length; i++){
			$(".onlineUsers ul").append("<li class = 'list-group-item'><span class ='fa fa-circle'></span>" + onlineUsers[i] +"</li>");
		}
	}
}


function updateExpenseWidget(expensesData){
	$(".recentExpenses ul").empty();
	if(expensesData != ""){
		for(var i = 0; i < expensesData.length; i++){
			$(".recentExpenses ul").append("<li class = 'list-group-item'><span class ='fa fa-upload'></span>" + expensesData[i]["user_name"] + " <span class = 'textTime'> " + moment(expensesData[i]["expense_date"]).fromNow() + " </span>  </li>");
		}
	}			
}