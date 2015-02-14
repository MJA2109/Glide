var channel = window.localStorage.adminId;
var server = "192.168.1.64";

client = new Faye.Client('http://' + server + ':8000/', {
	timeout: 120
});

client.subscribe('/' + channel + '_notification' , function(message){
	
	notification(message.name, message.action, moment().format("h:mm:ss a"));
	
	//add to widgets
	switch(message.type){
		case "expense" : updateExWidget(message);
		break;
		case "journey" : updateJourWidget(message);
		break;
	}
});



client.subscribe('/50_onlineUsers', function(message){
	//alert("Is user online : " + message.isOnline + "  -  User Id : " + message.userId);
	if(message.isOnline == true && message.userId != "undefined"){
		var exists = $(".onlineUsers ul").find("li #"+ message.userId);
		if(exists.length == 0){
			$(".onlineUsers ul").append("<li id = " + message.userId + " class = 'list-group-item'><span class ='fa fa-circle'></span>" + message.name +"</li>");
		}
		$(".gifLoader").hide();	
	}else if (message.isOnline == false){
		$(".onlineUsers ul #" + message.userId).remove();
	}
});


function updateExWidget(data){
	$(".recentExpenses ul").prepend("<li class = 'list-group-item'><span class ='fa fa-upload'></span>" + data.name + " <span class = 'textTime'> " + moment(Date.now()).fromNow() + " </span>  </li>");
}

function updateJourWidget(data){
	$(".recentJourneys ul").prepend("<li class = 'list-group-item'><span class ='fa fa-upload'></span>" + data.name + " <span class = 'textTime'> " + moment(Date.now()).fromNow() + " </span>  </li>");
}
