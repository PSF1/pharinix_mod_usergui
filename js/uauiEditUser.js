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
                        message: __('The user name can not be empty.')
                    }
                }
            },
            txtTitle: {
                validators: {
                    notEmpty: {
                        message: __('The name can not be empty.')
                    }
                }
            },
            txtMail: {
                validators: {
                    notEmpty: {
                        message: __('Email required.')
                    },
                    emailAddress: {
                        message: __('Email not valid.')
                    }
                }
            },
            txtPass1: {
                validators: {
                    identical: {
                        field: 'txtPass2',
                        message: __('The password and confirmation are different.')
                    },
                }
            },
            txtPass2: {
                validators: {
                    identical: {
                        field: 'txtPass1',
                        message: __('The password and confirmation are different.')
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
    $("#selectGrp").bootstrapDualListbox({
        filterTextClear: __("Show all"),
        filterPlaceHolder: __("Filter"),
        infoText: __('Showing {0}'),
        infoTextFiltered: '<span class="label label-warning">'+__('Filtered')+'</span> '+__('{0} of {1}'),
        moveSelectedLabel: __("Move selected"),
        moveAllLabel: __("Move all"),
        removeSelectedLabel: __("Erase selected"),
        removeAllLabel: __("Erase all"),
        moveOnSelect: false,
        selectedListLabel: __("Groups they belong"),
        nonSelectedListLabel: __("Available"),
    });
    $("#cmdSave-[frmid]").on("click", function(event){
        $('.nav-tabs a:first').tab('show');
        $("#"+frmId).submit();
        if (frmOk) {
           var grps = $("#selectGrp").val();
           var post = {
               command: "updateNode",
               nodetype: "user",
               nid: $("#"+frmId).attr("user"),
               groups: grps.join(),
               name: $("#"+frmId).find("#txtName").val(),
               title: $("#"+frmId).find("#txtTitle").val(),
               mail: $("#"+frmId).find("#txtMail").val(),
               interface: "echoJson",
           }
           var pass1 = $("#"+frmId).find("#txtPass1").val();
           var pass2 = $("#"+frmId).find("#txtPass2").val();
           if (pass1 != "" && pass1 == pass2) {
               post.pass = $("#"+frmId).find("#txtPass1").val();
           }
           $.ajax({
               type: "POST",
               url: PHARINIX_ROOT_URL,
               data: post,
               success: function(data) {
                   if (data.ok) {
                       location.reload();
                   } else {
                       alert('Error:\n'+data.msg);
                   }
               }
           });
        }
    });
});