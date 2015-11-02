function editUser(userId) {
    var $modal = $('#userForm');

    // create the backdrop and wait for next modal to be triggered
    $('body').modalmanager('loading');
    var cmd = '?command=uauiEditUser&user='+ userId;
    if (!userId) {
        cmd = "?command=uauiAddUser";
    }
    
    $modal.load(PHARINIX_ROOT_URL + cmd +'&interface=echoHtml', '', function () {
        $modal.modal();
    });
}

function alertModal(msg) {
    $("#alertModal .modal-body").html(msg);
    $("#alertModal").modal("show");
}

function confirmModal(msg, okCallBack) {
    $("#confirmModal .modal-body").html(msg);
    $("#confirmModal").modal("show");
    $(".confirmModalOk").one("click", okCallBack);
}

$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('.btnEdit').click(function(e) {
        e.preventDefault();
        editUser($(this).attr('user'));
    });
    
    $('.btnAdd').click(function(e) {
        e.preventDefault();
        editUser();
    });

    $('.btnDel').click(function(e) {
        e.preventDefault();
        var userid = $(this).attr('userid');
        var msg = __("Like you delete the user '%s' ?");
        confirmModal(sprintf(msg, $(this).attr('user')), function(){
            var post = {
               command: "delUser",
               uid: userid,
               interface: "echoJson",
           }
           $.ajax({
               type: "POST",
               url: PHARINIX_ROOT_URL,
               data: post,
               success: function(data) {
                   location.reload();
               }
           });
        });
    });
});
