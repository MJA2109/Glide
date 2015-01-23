<?php
	//sleep(3);
?>
<div id = "subHeader">
	<div id = "subHeaderFix">
		<div id = "subHeaderSec1">
			
		</div>
		<div id = "subHeaderSec2">
			<div></div>
		</div>
	</div>
</div>

<div id = "flexfix">
	<div id = "search">
		<form method = "POST" id = "getChartDataForm" >
			<input type = 'hidden' name = 'action' value = 'getChartData' />
			<input type = "hidden" name = "chartType" value = "barChart" />
			
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
				<select class = "form-control" name = "searchOption" id = "chartDisplayOptions">
					<option value = "" disabled>Display</option>
					<option value = "singleUser">User</option>
					<option value = "allUsers">All Users</option>
				</select>
			</div>
			
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userEmail" placeholder = "User email" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
				<select class = "form-control" name = "time">
					<option value = "" disabled>Time</option>
					<option value = "1 MONTH">1 Month</option>
					<option value = "1 MONTH">2 Month</option>
					<option value = "3 MONTH">4 Months</option>
					<option value = "6 MONTH">6 Months</option>
					<option value = "1 YEAR">1 Year</option>
					<!-- <option value = "all">All</option> -->
				</select>
			</div>
			<div class = "searchInput">
				<input type = 'submit' value = 'View' class = "btn btn-default" id = "btnGetChartData"/>
			</div>
		</form>
		<div id = "chartIcons">
			<span id = "barIcon" class="fa fa-bar-chart fa-3x chartIcon"></span>
			<span id = "pieIcon" class="fa fa-pie-chart fa-3x chartIcon"></span>
			<span id = "arrowIcon" class="fa fa-line-chart fa-3x chartIcon"></span>
		</div>
	</div>

	<div id = "mainView">
			
	</div>
</div>
	

