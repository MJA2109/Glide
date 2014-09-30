//Initialize application. Set global variables.
var app = {
    server: "http://ma.pickacab.com/test/test.php", 
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
        }else{
            initializeEvents();
            getCurrentLocation();
        }
    }
};


/**
 * Name: initializeEvents
 * Purpose: Initialize each event before use.
 */
function initializeEvents(){
    
    $("#btnCaptureReceipt").click(function(){
        captureReceipt();
    });

    $("#btnUpload").click(function(){
        uploadExpenseForm("#uploadExpenseForm");
    });

    $("#trackJourney").on("pageshow", function(){
        resizeMap();
        addLocationMarker();
        addTrackerMarker();
    });

    $("#btnStartJourney").click(function(){
        startJourney();
        alert("Journey Started");
    });

    $("#btnFinishJourney").click(function(){
        finishJourney();
    });

    $("#btnCancelUploadJourneyData").click(function(){
        resetUploadJourneyData();
        $.mobile.changePage("#home");
    });
}

/**
 * Name: getCurrentLocation
 * Purpose: Using GPS get the current latitude and longitude of the device.
 */
function getCurrentLocation(){

    navigator.geolocation.getCurrentPosition(onSuccess, onError);

    function onSuccess(position){
        initializeMap(position);
    }

    function onError(){
        alert("Couldn't get your current location");
    }
}

/**
 * Name: startJourney
 * Purpose: Initiate the watchPosition method to track user's GPS. Update marker position and draw
 *          polyline on route taking.
 */
function startJourney(){

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

    navigator.geolocation.clearWatch(app.watchId);
    window.localStorage.setItem("journeyData", JSON.stringify(app.journeyData));
    var geoData = window.localStorage.getItem("journeyData");
    var jsonGeoData = JSON.parse(geoData);
    
    setOrigin(jsonGeoData);
    setDestination(jsonGeoData);
    setTotalDistance(jsonGeoData);
    setJourneyTime(getJourneyTime());
    setCurrentDateTime();
    
    $.mobile.changePage("#uploadJourneyData");
    app.watchId = null;
    app.journeyData = null;
    resetMap();
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
    var originLng = geoData[Object.keys(geoData)[0]].B;
    originUrl = originUrl + originLat + "," + originLng;

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
    var originLng = geoData[Object.keys(geoData)[lastKey]].B;
    originUrl = originUrl + originLat + "," + originLng;
    alert("Length of json object : " + originLat + " : " + originLng);

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
                                     jsonGeoData[i].B,
                                     jsonGeoData[i+1].k,
                                     jsonGeoData[i+1].B);
    }

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
    
    alert("global latlng : " + app.latLng);
    
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
                    destinationType: Camera.DestinationType.FILE_URI, correctOrientation: false });
    
    function onSuccess(imageURI) {
        $("<img id = 'receipt' src = ''>").appendTo("#uploadedImage");
        app.imageURI = imageURI;
        var image = document.getElementById('receipt');
        image.src = imageURI;
    }

    function onFail(message) {
        alert('Failed because: ' + message);
    }
}

/**
 * Name: uploadReceipt
 * Purpose: Upload captured receipt to the Glide server.
 */
function uploadReceipt(){

    $.mobile.loading("show", {
        text: "Uploading data...",
        textVisible: true,
        theme: "z"
    });

    var imageURI = app.imageURI;
    var options = new FileUploadOptions();
    options.fileKey = "file";
    options.fileName = imageURI.substr(imageURI.lastIndexOf('/')+1);
    options.mimeType = "image/jpeg";

    var params = {};
    params.value1 = "test";
    params.value2 =  "param";
    options.params = params;
    options.headers = {"Connection" : "close"};

    var fileTrans = new FileTransfer();
    fileTrans.upload(imageURI, encodeURI(app.server), uploadComplete, uploadFailed, options);
    
    function uploadFailed(error){
        alert("Upload failed " + error.target);
    }

    function uploadComplete(data){
        resetUploadExpenseForm();
        $.mobile.loading("hide");
    }
}


/**
 * Name: uploadExpenseForm
 * Purpose: Get data from form and send to Glide server.
 * @param form - string : form to be processed.
 */
function uploadExpenseForm(form){
    var frm = $(form);
    var data = frm.serialize();
    $.ajax({
        type: "post",
        url: app.server,
        data: data,
        beforeSend: function() {
            uploadReceipt(); 
        },
        complete: function(){
        
        }, 
        success: function(data){

        },
        error: function(data){
            alert("Ajax Error " + data);
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







