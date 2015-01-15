
var validation = {
    server : "../api/handlers/webHandler.php",
    timeFormat : /^([0-9]+):([0-5]?[0-9]):([0-5]?[0-9])$/,
    alphaNum : /^([a-z A-Z 0-9]*)$/,
    disFormat : /^([0-9]+).([0-9]{2})$/,
    costFormat : /^([0-9]+).([0-9]{2})$/
}


function attachValEvent(div){
    switch(div){
        case "#modalAddExpense" : addExpenseValidation();
        break;
        case "#modalEditExpense" : editExpenseValidation();
        break;
        case "#modalAddJourney" : addJourneyValidation();
        break;
        case "#modalEditJourney" : editJourneyValidation();
        break;
        case "#modalAddUser" : addUserValidation();
        break;
    }
}


function addExpenseValidation(){
    $('#modalExpenseForm').bootstrapValidator({

        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        live: 'enabled',
        trigger: null,
        fields: {
            userName: {
                validators: {
                    notEmpty: {
                        message: 'User Name is required'
                    },
                    remote: {
                        url: validation.server,
                        data: {
                            action : "doesUserExist"
                        },
                        message: 'User does not exist',
                        type: 'POST'
                    }

                }
            },
            userId: {
                validators: {
                    notEmpty: {
                        message: 'User ID is required'
                    },
                    integer: {
                        message: 'The value is not an integer'
                    },
                    remote: {
                        url: validation.server,
                        data: function(validator) {
                            return {
                                userName: validator.getFieldElements('userName').val(),
                                action: "doesUserExist"
                            };
                        },
                        message: "User ID and Name do not match",
                        type: 'POST'
                    }
                }
            },
            category: {
                icon: false,
                validators: {
                    notEmpty: {
                        message: 'Category is required'
                    }
                }
            },
            merchant: {
                validators: {
                    notEmpty: {
                        message: 'Merchant Name is required'
                    }

                }
            },
            cost: {
                validators: {
                    notEmpty: {
                        message: 'Cost is required',
                    },
                    regexp: {
                        regexp: validation.costFormat,
                        message: 'Incorrect format, use 00.00'
                    }

                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
    }).on('status.field.bv', function(e, data) {
        if(data.bv.isValid()){
            data.bv.disableSubmitButtons(false);
        }else{
            data.bv.disableSubmitButtons(true);
        }
    });
}


function editExpenseValidation(){
    $('#modalEditExpenseForm').bootstrapValidator({

        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            cost: {
                validators: {
                    notEmpty: {
                        message: 'Cost is required',
                    },
                    regexp: {
                        regexp: validation.costFormat,
                        message: 'Incorrect format, use 00.00'
                    }

                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
    }).on('status.field.bv', function(e, data) {
        if(data.bv.isValid()){
            data.bv.disableSubmitButtons(false);
        }else{
            data.bv.disableSubmitButtons(true);
        }
    });  
}


function addJourneyValidation(){

    $('#modalJourneyForm').bootstrapValidator({

        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            userName: {
                validators: {
                    notEmpty: {
                        message: 'User Name is required'
                    },
                    remote: {
                        url: validation.server,
                        data: {
                            action : "doesUserExist"
                        },
                        message: 'User does not exist',
                        type: 'POST'
                    }

                }
            },
            userId: {
                validators: {
                    notEmpty: {
                        message: 'User ID is required'
                    },
                    digits: {
                        message: 'A valid ID is required'
                    },
                    remote: {
                        url: validation.server,
                        data: function(validator) {
                            return {
                                userName: validator.getFieldElements('userName').val(),
                                action: "doesUserExist"
                            };
                        },
                        message: "User ID and Name do not match",
                        type: 'POST'
                    }
                }
            },
            origin: {
                validators: {
                    stringLength: {
                        message : "Origin address must be at least 10 characters",
                        min : 10
                    },
                    notEmpty: {
                        message: 'Origin address is required'
                    }
                }
            },
            destination: {
                validators: {
                    stringLength: {
                        message : "Destination address must be at least 10 characters",
                        min : 10
                    },
                    notEmpty: {
                        message: 'Destination address is required'
                    }

                }
            },
            distance: {
                validators: {
                    notEmpty: {
                        message: 'Distance is required',
                    },
                    regexp: {
                        regexp: validation.disFormat,
                        message: 'Incorrect format, use 00.00'
                    }

                }
            },
            journeyTime: {
                validators: {
                    notEmpty: {
                        message: 'Journey Time is required',
                    },
                    regexp: {
                        regexp: validation.timeFormat,
                        message: 'Incorrect format, use 00:00:00'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
    }).on('status.field.bv', function(e, data) {
        if(data.bv.isValid()){
            data.bv.disableSubmitButtons(false);
        }else{
            data.bv.disableSubmitButtons(true);
        }
    });
    
}


function editJourneyValidation(){

    $('#modalEditJourneyForm').bootstrapValidator({

        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            origin: {
                validators: {
                    stringLength: {
                        message : "Origin address must be at least 10 characters",
                        min : 10
                    },
                    notEmpty: {
                        message: 'Origin address is required'
                    }
                }
            },
            destination: {
                validators: {
                    stringLength: {
                        message : "Destination address must be at least 10 characters",
                        min : 10
                    },
                    notEmpty: {
                        message: 'Destination address is required'
                    }

                }
            },
            distance: {
                validators: {
                    notEmpty: {
                        message: 'Distance is required',
                    },
                    regexp: {
                        regexp: validation.disFormat,
                        message: 'Incorrect format, use 00.00'
                    }

                }
            },
            journeyTime: {
                validators: {
                    notEmpty: {
                        message: 'Journey Time is required',
                    },
                    regexp: {
                        regexp: validation.timeFormat,
                        message: 'Incorrect format, use 00:00:00'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
    }).on('status.field.bv', function(e, data) {
        if(data.bv.isValid()){
            data.bv.disableSubmitButtons(false);
        }else{
            data.bv.disableSubmitButtons(true);
        }
    });
    
}


function addUserValidation(){

    $('#modalUserForm').bootstrapValidator({

        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            userName: {
                validators: {
                    stringLength: {
                        message : "User Name must be at least 3 characters",
                        min : 3
                    },
                    notEmpty: {
                        message: 'User Name is required'
                    }
                }
            },
            userMobile: {
                validators: {
                    digits: {
                        message : "Must be a valid mobile number"
                    },
                    notEmpty: {
                        message: 'User Mobile is required'
                    },
                    stringLength: {
                        min : 10,
                        message : "Must be a valid mobile number"
                    },
                    remote: {
                        url: validation.server,
                        data: {
                            action : "isAvailable"
                        },
                        message: "Mobile number is already in use",
                        type: 'POST'
                    }

                }
            },
            retypeMobile: {
                validators: {
                    notEmpty: {
                        message: 'Comfirm User Mobile',
                    },
                    identical:{
                        field: 'userMobile',
                        message: "Mobile numbers do not match"
                    }

                }
            },
            userEmail: {
                validators: {
                    notEmpty: {
                        message: 'User Email is required',
                    },
                    emailAddress: {
                        message: 'The given Email address is not valid'
                    },
                    remote: {
                        url: validation.server,
                        data: {
                            action : "isAvailable"
                        },
                        message: "Email address already in use",
                        type: 'POST'
                    }
                    
                }
            },
            userType: {
                validators: {
                    notEmpty: {
                        message: 'User Type is required',
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
    }).on('status.field.bv', function(e, data) {
        if(data.bv.isValid()){
            data.bv.disableSubmitButtons(false);
        }else{
            data.bv.disableSubmitButtons(true);
        }
    });
}







$(document).ready(function(){

	$('#signUpForm').bootstrapValidator({
            
            framework: 'bootstrap',
            feedbackIcons: {
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
                            url: validation.server,
                            data: {
                                action: 'isAvailable'
                            },
                            type : 'POST'
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


	
