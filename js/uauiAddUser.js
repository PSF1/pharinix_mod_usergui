$(document).ready(function() {
    var frmId = '[frmid]';
    var frmOk = false;
    $('#[frmid]').bootstrapValidator({
//        live: 'disabled',
        message: __('This value is not valid'),
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            txtName: {
                validators: {
                    notEmpty: {
                        message: __('User name can\'t be empry.')
                    }
                }
            },
            txtTitle: {
                validators: {
                    notEmpty: {
                        message: __('Name can\'t be empty.')
                    }
                }
            },
            txtMail: {
                validators: {
                    notEmpty: {
                        message: __('Email is required.')
                    },
                    emailAddress: {
                        message: __('Email is wrong.')
                    }
                }
            },
            txtPass1: {
                validators: {
                    notEmpty: {
                        message: __('Password is required.')
                    },
                    identical: {
                        field: 'txtPass2',
                        message: __('Passwords are diferent.')
                    },
                }
            },
            txtPass2: {
                validators: {
                    identical: {
                        field: 'txtPass1',
                        message: __('Passwords are diferent.')
                    },
                }
            },
        },
        onError: function(e) {
            frmOk = false;
        },
        onSuccess: function(e) {
            frmOk = true;
        }
    });
    
    $("#cmdSave-[frmid]").on("click", function(event){
        $('.nav-tabs a:first').tab('show');
        $("#"+frmId).submit();
        if (frmOk) {
           var grps = $("#selectGrp").val();
           var post = {
               command: "addUser",
               name: $("#"+frmId).find("#txtName").val(),
               pass: $("#"+frmId).find("#txtPass1").val(),
               title: $("#"+frmId).find("#txtTitle").val(),
               mail: $("#"+frmId).find("#txtMail").val(),
               interface: "echoJson",
           }
           $.ajax({
               type: "POST",
               url: PHARINIX_ROOT_URL,
               data: post,
               success: function(data) {
                   if (data.ok) {
                       location.reload();
                   } else {
                       alert(__('Something go wrong:')+'\n'+data.msg);
                   }
               }
           });
        }
    });
});