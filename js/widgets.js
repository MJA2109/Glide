function updateOnlineUsers(onlineUsers){	
	$(".onlineUsers ul").empty();	
	if(onlineUsers != ""){
		for(var i = 0; i < onlineUsers.length; i++){
			$(".onlineUsers ul").append("<li class = 'list-group-item'><span class ='fa fa-circle'></span>" + onlineUsers[i] +"</li>");
		}
	}
}