$(document).ready(function(){

    var server = "../api/handlers/webHandler.php";
    

	$('#signUpForm').bootstrapValidator({
            
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                companyName: {
                    validators: {
                        notEmpty: {
                            message: 'A Comapany Name is required'
                        }
                    }
                },
                adminEmail: {
                    validators: {
                        notEmpty: {
                            message: 'An Email address is required'
                        },
                        emailAddress: {
                            message: 'The given Email address is not valid'
                        },
                        remote: {
                            message: 'Email address already exists on our system',
                            url: server,
                            data: {
                                action: 'isEmailAvail'
                            }
                        }
                    }
                },
                adminPassword: {
                    validators: {
                        notEmpty: {
                            message: 'A Password is required'
                        },
                        stringLength: {
                            message : "Password must be at least 8 characters",
                            min : 8
                        }

                    }
                },
                adminRePassword: {
                    validators: {
                        notEmpty: {
                            message: 'Confirm Password is required'
                        },
                        identical:{
                            field: 'adminPassword',
                            message: "Passwords do not match"
                        }
                    }
                }
            }
        });


        




});
	
