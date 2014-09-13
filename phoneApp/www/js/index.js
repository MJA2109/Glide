//Initialize application. Set global variables.
var app = {
    server: "http://ma.pickacab.com/test/test.php",
    map: "",
    latLng: "",
    imageURI : "",
    initialize: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function() {
        initializeEvents();
        getCurrentLocation();
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
        addMarker();
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
 * Name: addMarker
 * Purpose: Add marker to Google Map.
 */
function addMarker(){
    var marker = new google.maps.Marker({
        position: app.latLng,
        map: app.map,
        title: "You're here..."
    });
}

/**
 * Name: resizeMap
 * Purpose: Bug fix : resize ensures all tiles are loaded.
 */
function resizeMap(){
    google.maps.event.trigger(app.map, "resize");
    app.map.setCenter(app.latLng);
}


/**
 * Name: captureReceipt
 * Purpose: Acesses phone's camera to allow user to take picture. Returned image is placed in DOM
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







