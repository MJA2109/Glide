requirejs.config({
    appDir: ".",
    baseUrl: "js",
    paths: { 
        'jquery': ['//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min', 'vendor/jquery-1.10.2.min'],
        'modernizr' : ['../../js/vendor/modernizr-2.6.2.min'],
        'boilerPlugins' : ['../../js/plugins'],
        'analytics' : ['../../js/analytics'],
        'bootstrap': ['//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min', 'vendor/boostrap.min'],
        'cssLess' : ['//cdnjs.cloudflare.com/ajax/libs/less.js/1.7.3/less.min', 'vendor/less-1.7.3.min'],
        'datatables' : ['//cdn.datatables.net/1.10.1/js/jquery.dataTables', '../../../Glide/js/vendor/datatables']
    },
    shim:{
    	'bootstrap': ['jquery'],
        'datatables': ['jquery']
    }
});

require(['jquery', 
		 'modernizr', 
		 'boilerPlugins', 
		 'analytics',
		 'bootstrap',
		 'cssLess',
         'datatables'], function($) {
    	
        $(document).ready(function(){


            var appData = {

            }

            function submitForm(form){
                var frm = $(form);
                frm.submit(function (ev) {
                    var data = frm.serialize();
                    console.log(data);
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: data,
                        success: function (data) {
                            console.log(data);
                            var logData = JSON.parse(data);
                            var errorCount = Object.keys(logData.errors).length;
                            if(logData.type == "registration" && errorCount == 0){
                                window.location = "signIn.php"
                            }else if(logData.type == "signIn" && errorCount == 0){
                                window.location = "home.php";
                            }else{
                                console.log("not working");
                            }
                        },
                        error: function(){
                            console.log("Error: Ajax request unsuccessful");
                        }
                    });

                    ev.preventDefault();
                });
            }


            function signOut(){
                var data = {
                    action: "signOut"
                }
                
                $.ajax({
                    url: "../api/glideAPI.php",
                    type: "POST",
                    data: data,
                    success: function(){
                        window.location = "index.php";
                    },
                    error: function(){
                        console.log("Error: Ajax request unsuccessful");
                    }
                });
            }


            function initialiseEvents(){
                submitForm('#signUpForm');
                submitForm('#signInForm');
                $("#btnSignOut").on("click", function(){
                    signOut();
                });
                $("#expensesTable").dataTable();
                $("#usersTable").dataTable();
            }


            initialiseEvents();
     
        });  
        
});








