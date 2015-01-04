//Initialize application. Set global variables.
var app = {
    server: "http://192.168.1.74/Glide/api/handlers/mobileHandler.php",
    //server: "http://ma.pickacab.com/test/test.php",
    map: "",             //google map object
    trackerMarker: "",   //contains tracker marker
    markerArray: [],     //array of map markers
    latLng: "",          //lat lng for initialising map 
    watchId: null,       //the geo id of each journey
    journeyData: [],     //google formatted geo data
    totalDistance: null,
    imageURI: "",        //path to captured image
    timestamp: [],       //timestamp for each geo location
    initialize: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function() {
        if(navigator.network.connection.type == Connection.NONE){
            alert("No Network Connection detected");   
        }
        initializeEvents();
    }
};


/**
 * Name: initializeEvents
 * Purpose: Initialize each event before use.
 */
function initializeEvents(){

    $("#btnLogin").click(function(){
        login("#loginForm");
    });
    
    $("#btnCaptureReceipt").click(function(){
        captureReceipt();
    });

    $("#btnUpload").click(function(){
        uploadForm("#uploadExpenseForm");
    });

    $("#btnUploadJourneyData").click(function(){
        uploadForm("#uploadJourneyDataForm");
    });

    $("#trackJourney").on("pageshow", function(){
        getCurrentLocation();
    });

    $("#home").on("pageshow", function(){
        resetMapGPS();
        resetUploadExpenseForm();
        resetUploadJourneyData();
    });

    $("#btnStartJourney").click(function(){
        startJourney();
    });

    $("#btnFinishJourney").click(function(){
        finishJourney();
    });

    $("#btnCancelUploadJourneyData").click(function(){
        resetUploadJourneyData();
        clearGeoDataArrays();
        $.mobile.changePage("#home");
    });

    $("#expenseScroll").on("iscroll_onpulldown", function(){
        refreshHistory("#expenseHistory", "expenseId", "getExpenseHistory");
        $(this).iscrollview("refresh");
    });

    $("#journeyScroll").on("iscroll_onpulldown", function(){
        refreshHistory("#journeyHistory", "journeyId", "getJourneyHistory");
        $(this).iscrollview("refresh");
    });

    window.localStorage.clear();

    //check local storage for login details
    checkPreAuth();


}


/**
 * Name: checkPreAuth
 * Purpose: Check local storage for for login details
 */
function checkPreAuth(){
    if(window.localStorage.userName != undefined && window.localStorage.userId != undefined){   
        $("#loginEmail").val(window.localStorage.email);
        $("#instanceId").val(window.localStorage.instanceId);
        login("#loginForm");
    }
}


/**
 * Name: login
 * Purpose: Allow user to login to phone app. Add user's details to local storage.
 * @param form - String : form to process
 */
function login(form){

    var frm = $(form);
    var data = frm.serialize();

    $.ajax({
        type: "post",
        url: app.server,
        data: data,
        success: function(data){
            var auth = JSON.parse(data);
            if(auth){
                window.localStorage.userId = auth[0].user_id;
                window.localStorage.userName = auth[0].user_name;
                window.localStorage.email = $("#loginEmail").val();
                window.localStorage.instanceId = $("#instanceId").val();
                setFormData();
                $.mobile.changePage("#home");

            }else{
                alert("Incorrect details, try again...");
            } 
        },
        error: function(){
            alert("Unable to connect to server.");
        } 
    });
}


/**
 * Name: resetMapGPS
 * Purpose: Reset the GPS ID and reset map controls.
 */
function resetMapGPS(){
    
    $("#start").show();
    $("#finish").hide();
    navigator.geolocation.clearWatch(app.watchId);
    app.watchId = null;
}


/**
 * Name: setFormData
 * Purpose: Add user login details to hidden form fields to allow for uploading data.
 */
function setFormData(){

    $("#jourAdminId").val(window.localStorage.instanceId);
    $("#jourUserId").val(window.localStorage.userId);
    $("#jourUserName").val(window.localStorage.userName);
    $("#expAdminId").val(window.localStorage.instanceId);
    $("#expUserId").val(window.localStorage.userId);
    $("#expUserName").val(window.localStorage.userName);
}



/**
 * Name: refreshHistory
 * Purpose: Prepend new expense/journey data to expense/journey history list.
 */
function refreshHistory(divId, attr, action){

    var mostRecentExpense = 0; //id of most recent expense retreived
    mostRecentExpense = $(divId + " ul li").attr(attr);

    var data = {
        action: action,
        adminId: window.localStorage.instanceId,
        userId: window.localStorage.userId,
        mostRecentExpense: mostRecentExpense
    };

    $.ajax({
        type: "post",
        url: app.server,
        data: data,
        success: function(data){
            if(data){
                var history = JSON.parse(data);
                if(attr == "expenseId"){
                    $.each(history, function(key, value){
                        $(divId + " ul").prepend("<li expenseId  = ' " + value.expense_id + " '>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Date:</div> " + value.expense_date + "</div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Type:</div> " + value.expense_category + "</div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Merchant:</div> " + value.merchant_name + " </div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Location:</div> Cork City</div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Cost:</div> € " + value.expense_cost + "</div></li>");      
                    });
                    data = null;
                }else{
                    $.each(history, function(key, value){
                        $(divId + " ul").prepend("<li journeyId  = ' " + value.id + " '>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Date:</div> " + value.date + "</div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Origin:</div> " + value.origin + "</div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Destination:</div> " + value.destination + " </div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Time:</div>  " + value.journey_time + " </div>" +
                                                 "<div class = 'historyDiv'><div class = 'historyInfo'>Distance:</div> Km " + value.distance + "</div></li>");      
                    });
                    data = null;
                }

                $( divId + " ul").listview("refresh"); //fix to reapply css

            }else{
                alert("Already up to date...");
            }    
        },
        errror: function(){
            alert("Unable to retrieve data...");  
        }

    });
}


/**
 * Name: getCurrentLocation
 * Purpose: Using GPS get the current latitude and longitude of the device.
 */
function getCurrentLocation(){
    
    var options = {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
    }

    navigator.geolocation.getCurrentPosition(onSuccess, onFail, options);

    function onSuccess(position){
        initializeMap(position);
        resizeMap();
        addLocationMarker();
        addTrackerMarker();
    }

    function onFail(error){
        alert("Unable to retrieve GPS position.");
    }
}

/**
 * Name: startJourney
 * Purpose: Initiate the watchPosition method to track user's GPS. Update marker position and draw
 *          polyline on route taking.
 */
function startJourney(){

    $("#start").hide();
    $("#finish").show();
    alert("Journey Started");

    var minimumAccuracy = 20;

    app.watchId = navigator.geolocation.watchPosition(
        
        function(position){
            if(position.coords.accuracy < minimumAccuracy){
                app.timestamp.push(position.timestamp);
                app.journeyData.push(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
                moveTrackerMarker(app.map, app.trackerMarker, position.coords.latitude, position.coords.longitude);
            }else{
                //do nothing
            }
        },

        function(error){
            if(error.code == 1){
                alert("Error: Access denied !");
            }else if(error.code == 2){
                alert("Error: Position is unavailable");
            }
        },

        options = {
            enableHighAccuracy: true,
            maximumAge: 0
        }
    );
}


/**
 * Name: finishJourney
 * Purpose: Clear geolocation hook. Save Geo Data and reset associated variables. Set upload form.
 */
function finishJourney(){

    
    if(app.journeyData.length > 0){

        window.localStorage.setItem("journeyData", JSON.stringify(app.journeyData));
        var geoData = window.localStorage.getItem("journeyData");
        var jsonGeoData = JSON.parse(geoData);
        
        setOrigin(jsonGeoData);
        setDestination(jsonGeoData);
        setTotalDistance(jsonGeoData);
        setJourneyTime(getJourneyTime());
        setCurrentDateTime();
        
        $.mobile.changePage("#uploadJourneyData");
        resetMap();

    }else{
        alert("Device has not received sufficient GPS data.");
        $.mobile.changePage("#home");
        $("#start").show();
        $("#finish").hide();
    }

    resetMapGPS();
}

/**
 * Name: getJourneyTime
 * Purpose: Calculate the journey time.
 * @return: string : formatted journey time
 */
function getJourneyTime(){

    var startTime;
    var finishTime;
    var totalJourneyTime;

    startTime = new Date(app.timestamp[0]).getTime();
    finishTime = new Date(app.timestamp[app.timestamp.length - 1]).getTime();
    totalJourneyTime = finishTime - startTime;
    return moment.utc(totalJourneyTime).format("HH:mm:ss");

    alert(startTime);
    alert(finishTime);
    alert(totalJourneyTime);
}

/**
 * Name: setJourneyTime
 * Purpose: Set val of journey time text box.
 */
function setJourneyTime(journeyTime){
    $("#uploadJourneyTime").val(journeyTime);
}


/**
 * Name: setOrigin
 * Purpose: Send Ajax request to google geo data server to retrieve the origin of journey.
 * @param geoData - JSON : contains geo coordinates of journey
 */
function setOrigin(geoData){

    var originUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
    var originLat = geoData[Object.keys(geoData)[0]].k;
    var originLng = geoData[Object.keys(geoData)[0]].D;
    originUrl = originUrl + originLat + "," + originLng;

    // alert("geo data : " + JSON.stringify(geoData));
    // alert("setOrigin : " + originUrl);

    //reverse geocoding looking up request
    $.ajax({
        type: "post",
        url: originUrl,
        success: function(data){
            $("#uploadOrigin").val(data.results[0].formatted_address);
        },
        errror: function(){
            alert("setOrigin Ajax failed");
        }

    });
}


/**
 * Name: setDestination
 * Purpose: Send Ajax request to google geo data server to retrieve the destination of journey.
 * @param geoData - JSON : contains geo coordinates of journey
 */
function setDestination(geoData){

    var originUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";

    //get length of json object
    var objectKeys = Object.keys(geoData);
    var lastKey = objectKeys[objectKeys.length-1];

    var originLat = geoData[Object.keys(geoData)[lastKey]].k;
    var originLng = geoData[Object.keys(geoData)[lastKey]].D;
    originUrl = originUrl + originLat + ", " + originLng;

    // alert("geo data : " + JSON.stringify(geoData));
    // alert("destination : " + originUrl);

    $.ajax({
        type: "post",
        url: originUrl,
        success: function(data){
            $("#uploadDestination").val(data.results[0].formatted_address);
        },
        errror: function(){
            alert("set Destination Ajax failed");
        }

    });
}

/**
 * Name: setTotalDistance
 * Purpose: Calculate total distance and set val of textbox
 * @param jsonGeoData - JSON : contains geo coordinates of journey
 */
function setTotalDistance(jsonGeoData){
    
    var totalDistance = 0;

    for(var i = 0; i < jsonGeoData.length; i++){
        if(i == (jsonGeoData.length - 1)){
            break;
        }
        totalDistance += gpsDistance(jsonGeoData[i].k,
                                     jsonGeoData[i].D,
                                     jsonGeoData[i+1].k,
                                     jsonGeoData[i+1].D);
    }

    // alert("total distance : " + totalDistance);

    $("#uploadDistance").val(totalDistance.toFixed(2));
}

/**
 * Name: setCurrentDateTime
 * Purpose: Set date and time of journey
 */
function setCurrentDateTime(){
    var currentDateTime = moment().format('MMMM Do YYYY, h:mm:ss a');
    $("#uploadDateTime").val(currentDateTime);
}

/**
 * Name: gpsDistance
 * Purpose: Calculate the distance between to gps points
 * @param lat1 - int : latitude of gps coordinate
 * @param lng1 - int : longitude of gps coordinate
 * @param lat2 - int : latitude of gps coordinate
 * @param lng2 - int : longitude of gps coordinate
 * @return distance - float : distance in kilometers between the two given coordinates
 */
function gpsDistance(lat1, lng1, lat2, lng2){

    var R = 6371;
    var dLat = (lat2-lat1) * (Math.PI / 180);
    var dLng = (lng2-lng1) * (Math.PI / 180);
    var lat1 = lat1 * (Math.PI / 180);
    var lat2 = lat2 * (Math.PI / 180);
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.sin(dLng/2) * Math.sin(dLng/2) * Math.cos(lat1);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var distance = R * c;
    return distance;
}


/**
 * Name: moveTrackerMarker
 * Purpose: Update position of marker on map. Pan map position to marker position.
 * @param map - map : map to be manipulated.
 * @param marker - marker : marker to be moved.
 * @param lat - int : latitude position to set marker and map.
 * @param lng - int : lngitude position to set marker and map.
 */
function moveTrackerMarker(map, marker, lat, lng){
    marker.setPosition( new google.maps.LatLng(lat, lng));
    map.panTo( new google.maps.LatLng(lat, lng));
}

/**
 * Name: initializeMap
 * Purpose: Initialize Google map and append to div.
 */
function initializeMap(position){

    var lng = position.coords.longitude;
    var lat = position.coords.latitude;
    app.latLng = new google.maps.LatLng(lat, lng);
    
    var mapOptions = {
        center : app.latLng,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        zoomControl: false,
        mapTypeControl: false
    };

    app.map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
}


/**
 * Name: addLocationMarker
 * Purpose: Add marker to Google Map.
 */
function addLocationMarker(){
    locationMarker = new google.maps.Marker({
        position: app.latLng,
        map: app.map,
        animation: google.maps.Animation.DROP,
        title: "You're here..."
    });

    app.markerArray.push(locationMarker);
}

/**
 * Name: addTrackerMarker
 * Purpose: Add tracker marker to Google Map.
 */
function addTrackerMarker(){

    var customIcon = "http://maps.google.com/mapfiles/kml/pal4/icon15.png";
    app.trackerMarker = new google.maps.Marker({
        position: app.latLng,
        map: app.map,
        icon: customIcon
    });

    app.markerArray.push(app.trackerMarker);
}

/**
 * Name: resetMap
 * Purpose: Remove all markers and polylines from map.
 */
function resetMap(){
    $.each(app.markerArray, function(index, val){
        val.setMap(null);
    });
}

/**
 * Name: resizeMap
 * Purpose: Resize map to ensures all tiles are loaded.
 */
function resizeMap(){
   
    google.maps.event.trigger(app.map, "resize");
    app.map.setCenter(app.latLng);
}


/**
 * Name: captureReceipt
 * Purpose: Acesses phone's camera to allow user to take picture. Returned image and placed in DOM
 */
function captureReceipt(){
    navigator.camera.getPicture(onSuccess, onFail, { quality: 50, 
                    destinationType: Camera.DestinationType.FILE_URI, correctOrientation: true, targetWidth: 800, targetHeight: 800 });
    
    function onSuccess(imageURI) {
        $("<img id = 'receipt' src = ''>").appendTo("#uploadedImage");
        app.imageURI = imageURI;
        var image = document.getElementById('receipt');
        image.src = imageURI;
        uploadReceipt();
    }

    function onFail(message) {
        alert("Error : Can't access device camera.");
    }
}

/**
 * Name: uploadReceipt
 * Purpose: Upload captured receipt to the Glide server.
 */
function uploadReceipt(){

    var imageURI = app.imageURI;
    var options = new FileUploadOptions();
    options.fileKey = "file";
    options.fileName = imageURI.substr(imageURI.lastIndexOf('/')+1);
    options.mimeType = "image/jpeg";

    var params = {};
    params.action =  "uploadReceipt";
    options.params = params;
    options.headers = {"Connection" : "close"};

    var fileTrans = new FileTransfer();
    fileTrans.upload(imageURI, encodeURI(app.server), uploadComplete, uploadFailed, options);
    
    function uploadFailed(error){
        alert("Upload failed : " + JSON.stringify(error));
    }

    function uploadComplete(data){
        $("#uploadExpenses input[name = 'receiptId']").val(data.response);
    }
}


/**
 * Name: uploadForm
 * Purpose: Get data from form and send to Glide server.
 * @param form - string : form to be processed.
 */
function uploadForm(form){
    var frm = $(form);
    var data = frm.serialize();
    $.ajax({
        type: "post",
        url: app.server,
        data: data,
        beforeSend: function() {          
            $.mobile.loading("show", {
                text: "Uploading data...",
                textVisible: true,
                theme: "z"
            });
        },
        success: function(data){
           
            if(form == "#uploadJourneyDataForm"){ 
                clearGeoDataArrays();
                resetUploadJourneyData(); 
            }
            if(form == "#uploadExpenseForm"){ 
                resetUploadExpenseForm(); 
            }
            $.mobile.changePage("#home");
            $.mobile.loading("hide");
        },
        error: function(data, error){
            alert("Ajax Error " + data + " : " + error);
        }               
    });   
}


/**
 * Name: resetUploadExpenseForm
 * Purpose: Reset image & data input fields to null
 */
function resetUploadExpenseForm(){
    $("#uploadMerchant, #uploadDate, #uploadCost, #uploadComment").val("");
    $("#receipt").remove();
}

/**
 * Name: resetUploadJourneyData
 * Purpose: Reset form fields
 */
function resetUploadJourneyData(){
    $("#uploadJourneyData, #uploadOrigin, #uploadDestination, #uploadDistance, #uploadJourneyTime, #uploadDateTime, #uploadJourneyComment").val("");
}

/**
 * Name: clearGeoDataArray
 * Purpose: clear arrays.
 */
function clearGeoDataArrays(){
    app.journeyData.length = 0;
    app.timestamp.length = 0;
}






