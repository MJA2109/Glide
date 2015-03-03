function updateOnlineUsers(onlineUsers){
	$(".onlineUsers ul").empty();	
	if(onlineUsers != ""){
		for(var i = 0; i < onlineUsers.length; i++){
			$(".onlineUsers ul").append("<li id = " + onlineUsers[i].user_id + " class = 'list-group-item'><span class ='fa fa-circle'></span>" + onlineUsers[i].user_name +"</li>");
		}
		$(".userVal").text(onlineUsers.length);
	}
	$(".gifLoader").hide();

}


function updateExpenseWidget(expensesData){
	$(".recentExpenses ul").empty();
	if(expensesData != ""){
		for(var i = 0; i < expensesData.length; i++){
			$(".recentExpenses ul").append("<li class = 'list-group-item'><span class ='fa fa-upload'></span>" + expensesData[i]["user_name"] + " <span class = 'textTime'> " + moment(expensesData[i]["expense_date"]).fromNow() + " </span>  </li>");
		}
		$(".expVal").text(expensesData.length);
	}
	$(".gifLoader").hide();			
}


function updateJourneyWidget(journeysData){
	$(".recentJourneys ul").empty();
	if(journeysData != ""){
		for(var i = 0; i < journeysData.length; i++){
			$(".recentJourneys ul").append("<li class = 'list-group-item'><span class ='fa fa-upload'></span>" + journeysData[i]["user_name"] + " <span class = 'textTime'> " + moment(journeysData[i]["date"]).fromNow() + " </span>  </li>");
		}
		$(".jourVal").text(journeysData.length);
	}
	$(".gifLoader").hide();

}

function updatedLiabilitiesWidget(lia){
	
	var catTotal = {};
	var total = 0;

	for(var i = 0; i < lia.data.length; i++){
		if(lia.data[i].column == "Accommodation"){
			catTotal.acc = lia.data[i].colValue;
		}else if(lia.data[i].column == "Entertainment"){
			catTotal.ent = lia.data[i].colValue;
		}else if(lia.data[i].column == "Mileage Cost"){
			catTotal.mil = lia.data[i].colValue;
		}else if(lia.data[i].column == "Travel"){
			catTotal.tra = lia.data[i].colValue;
		}else if(lia.data[i].column == "Phone"){
			catTotal.pho = lia.data[i].colValue;
		}else if(lia.data[i].column == "Food"){
			catTotal.foo = lia.data[i].colValue;
		}

		total = total + parseFloat(lia.data[i].colValue);
	}

	$(".acc").text(typeof catTotal.acc == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.acc));
	$(".ent").text(typeof catTotal.ent == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.ent));
	$(".mil").text(typeof catTotal.mil == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.mil));
	$(".tra").text(typeof catTotal.tra == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.tra));
	$(".pho").text(typeof catTotal.pho == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.pho));
	$(".foo").text(typeof catTotal.foo == 'undefined' ? "€" + 0 : "€" + addCommas(catTotal.foo));
	$(".liabVal").text(addCommas(total.toFixed(2)));

}

function addCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


