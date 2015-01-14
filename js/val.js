
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
            },
            account: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            },
            comment: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
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
            },
            account: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            },
            comment: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
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
            },
            account: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            },
            comment: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
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
            },
            account: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            },
            comment: {
                validators: {
                    regexp: {
                        regexp: validation.alphaNum,
                        message: 'Alphanumeric characters only'
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
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
                                action: 'isEmailAvail'
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


	
