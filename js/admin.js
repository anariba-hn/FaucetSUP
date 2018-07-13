function newAdmin(){
    var name = $("#nick").val();
    var pass = $("#passw").val();
    
    if(name == '')
        alert("You need to eneter a valid nick");
    else if(pass == '')
        alert("You need to enter a password");
    else{
        
        $.post('../admincenter/setAdmin.php', {
            user_admin : name,
            user_password : pass
        }).done(function (data){
            
            if(data.status == 404)
                alert("Ups ! something happends: " + data.message);
            else{
                alert(data.message);
                window.location.reload();
            }
        });
    }
}

function updateAdmin(){
    var name = $("#editNick").val();
    var pass = $("#editPass").val();
    var id   = $("#getID").val();
    
    console.log(name);
    console.log(pass);
    console.log(id);
    
    if(name == null)
        alert("You need to eneter a valid nick");
    else if(pass == null)
        alert("You need to enter a password");
    else{
        
        $.post('../admincenter/updateAdmin.php', {
            user_id    : id,
            user_admin : name,
            user_pass : pass
        }).done(function (data){
            
            if(data.status == 404)
                alert("Ups ! something happends: " + data.message);
            else{
                alert(data.message);
                window.location.reload();
            }
        });
    }
    
}

function deleteAdmin(){
    var id   = $("#getID").val();
    console.log(id);
    
    $.post('./deleteAdmin.php',{
        user_id : id
    }).done(function(data){
        
        if(data.status == 404)
            alert("Ups ! something happends: " + data.message);
        else{
            alert("Admin deleted successfully !!");
            window.location.reload();
        }
    });
}

function setCnfg(action){
    var reward = $("#reward").val();
    var time = $("#time").val();
    var ref  = $("#href").val();
    var cron = $("#cron").val();
    
    if(action == 1 && reward != null)
        {
            $.post('../admincenter/setConfg.php',{
                option : action,
                reward : reward
            }).done(function(data){
                alert(data.message);
                window.location.reload();
            });
        }
    else if(action == 2 && time != null)
        {
            $.post('../admincenter/setConfg.php',{
                option : action,
                time   : time
            }).done(function(data){
                alert(data.message);
                window.location.reload();
            });
            
        }
    else if(action == 3 && ref != null)
        {
            $.post('../admincenter/setConfg.php',{
                option : action,
                ref    : ref
            }).done(function(data){
                alert(data.message);
                window.location.reload();
            });
        }
    else if(action == 4 && cron != null)
        {
            $.post('../admincenter/setConfg.php',{
                    option  : action,
                    cron    : cron
                }).done(function(data){
                    alert(data.message);
                    window.location.reload();
                });
        }
        else{
                alert("Not action completed.");
            }
    
}

function getConfg(){
    var action = 4;

    $.post('../getConfg.php',{
        option : action
    }).done(function(data){

        if(data.status != 200)
            alert("Ups ! something happends: " + data.message);
        else{
            $("#reward").val(data.reward);
            $("#time").val(data.time);
            $("#href").val(data.href);
            $("#cron").val(data.cron);
        }
    });
}

$(document).ready(function(){

    getConfg();

    $(document).on('click', '.edit_data', function(){
        var adminID = $(this).attr("id");
        console.log(adminID);
        
        $.post('../admincenter/getAdmin.php',{
            user_id : adminID
        }).done(function (data){
           
            if(data.status == 404)
                alert("Ups ! something happends: " + data.message);
            else{
                $("#editNick").val(data.user_admin);
                $("#editPass").val(data.user_password);
                $("#getID").val(adminID);
            }
        });
    });
    
    $(document).on('click', '.delete_data', function(){
        var adminID = $(this).attr("id");
        $("#getID").val(adminID);
    });
    
    $('#v-pills-tab a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    })
    
    $("#btnNewAdmin").click(function(){
        newAdmin();
    })
    
    $("#btnUpdate").click(function(){
        updateAdmin();
    })
    
    $("#btnConfirm").click(function(){
        deleteAdmin();
    })
    
    $("#btnReward").click(function(){
        setCnfg(1);
    })
    
    $("#btnTime").click(function(){
        setCnfg(2);
    })

    $("#btnRef").click(function(){
        setCnfg(3);
    })

    $("#btnCron").click(function(){
        setCnfg(4);
    })
    
    $("#btnlogOut").click(function(){
        //window.location.href = "../admincenter/index.html";
    })
    
});
