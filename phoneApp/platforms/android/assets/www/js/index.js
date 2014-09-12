//Initialize application. Set global variables.
var app = {
    server: "http://ma.pickacab.com/test/test.php",
    imageURI : "",
    initialize: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function() {
        initializeEvents();
    },
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
        alert("working");
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

    var fileTrans = new FileTransfer();
    fileTrans.upload(imageURI, encodeURI(app.server), uploadComplete, uploadFailed, options);

    alert(JSON.stringify(options));

    function uploadFailed(error){
        alert("upload failed " + error.target);
    }

    function uploadComplete(data){
        alert("upload successful" + data.response);
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







