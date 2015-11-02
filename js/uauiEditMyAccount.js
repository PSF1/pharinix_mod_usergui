var frmProfileOk = false;
$('#frmUser').bootstrapValidator({
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
    onError: function (e) {
        frmProfileOk = false;
    },
    onSuccess: function (e) {
        frmProfileOk = true;
    }
});

$('#cmdSave').click(function (e) {
    $('.nav-tabs a:first').tab('show');
    $("#frmUser").submit();
    if (frmProfileOk) {
        var post = {
            command: "updateNode",
            nodetype: "user",
            nid: $("#frmUser").attr("data-user"),
            name: $("#frmUser").find("#txtName").val(),
            title: $("#frmUser").find("#txtTitle").val(),
            interface: "echoJson",
        }
        var pass1 = $("#frmUser").find("#txtPass1").val();
        var pass2 = $("#frmUser").find("#txtPass2").val();
        if (pass1 != "" && pass1 == pass2) {
            post.pass = $("#frmUser").find("#txtPass1").val();
        }
        $.ajax({
            type: "POST",
            url: PHARINIX_ROOT_URL,
            data: post,
            success: function (data) {
                if (data.ok) {
                    location.reload();
                } else {
                    alert('Error:\n' + data.msg);
                }
            }
        });
    }
});