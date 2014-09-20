//Initialize application. Set global variables.
var app = {
    server: "http://ma.pickacab.com/test/test.php",
    map: "",
    trackerMarker: "",
    markerArray: [],
    latLng: "",
    watchId: null,
    journeyData: [],
    imageURI: "",
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

    app.watchId = navigator.geolocation.watchPosition(
        
        function(position){
            app.journeyData.push(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
            moveTrackerMarker(app.map, app.trackerMarker, position.coords.latitude, position.coords.longitude);
            
            // var polyline = new google.maps.Polyline({
            //     map: app.map,
            //     path: app.journeyData,
            //     strokeColor: '#4F758A',
            //     strokeOpacity: 0.5,
            //     strokeWeight: 3
            // });

            // app.markerArray.push(polyline);
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
            frequency: 10 * 8
        }
    );
}


/**
 * Name: finishJourney
 * Purpose: Clear geolocation hook. Save Geo Data and reset associated variables.
 */
function finishJourney(){

    navigator.geolocation.clearWatch(app.watchId);
    window.localStorage.setItem("journeyData", JSON.stringify(app.journeyData));
    var data = window.localStorage.getItem("journeyData");
    alert("Local stored data: " + data);
    $.mobile.changePage("#uploadJourneyData", "slide");
    app.watchId = null;
    app.journeyData = null;
    resetMap();
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







