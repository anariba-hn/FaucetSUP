function getUser(){
    if(!!Cookies.get('session'))
        var address = localStorage.getItem("walle");

    $.post('./getUser.php',
           {
        user_address : address
    }).done(function(data)
            {
        if(data.status == 404)
        {
            $("#alert_msg").text("This Address does not exist, please Sign-Up first");
            $("#alert_modal").modal("show");
        }
        else
        {   
            $("#spnIdUser").text(data.user_name);
            $("#spnEmail").text(data.user_email);
        }
    });
}

function getBalance(){
    if(!!Cookies.get('session'))
        var address = localStorage.getItem("walle");

    $.post('./getBalance.php', 
    {
        user_address : address
    }).done(function(data){
        if(data.status == 404)
        {
            alert(data.message);
        }
        else{

            $("#spnClaim").text(data.wallet_claims);
            $("#spnPaid").text(data.wallet_paids);
            $("#spnWithdraws").text(data.wallet_withdraws);
        }
    });

}


function setTransfer(){
    var address     = localStorage.getItem("walle");
    var destination = $('#destination').val();
    var user_pw     = $('#vpass').val();
    var amount      = $('#amount').val();
    var msg         = $('#msg');

    $("#account").css("color","black");
    $("#mount").css("color","black");
    $("#pass").css("color","black");

    if(destination.length != 95 && destination.length != 106)
    {
        $("#logMsg").text("Please enter a Valid Wallet Address");
        Errorlog();
        $("#account").css("color","red");
        $('#destination').focus();
    }
    else if(amount == 0)
    {
        $("#logMsg").text("Please enter a higher amount");
        Errorlog();
        $("#mount").css("color","red");
        $('#amount').focus();
    }
    else{

        $.post('./setPayments.php',
               {
            user_address   : address,
            user_pw        : user_pw,
            user_amount    : amount,
            tranfer_address : destination

        }).done(function(data){

            if(data.flag == 1)
            {
                $("#logMsg").text(data.message);
                Errorlog();
                $("#pass").css("color","red");
                $('#vpass').focus();
            }
            else if(data.flag == 2)
            {
                $("#logMsg").text("Please enter a higher amount");
                Errorlog();
                $("#mount").css("color","red");
                $('#amount').focus();
            }
            else{

                $("#succes_tranfer_modal").modal("show");
                
            }
        });

    }
}

function Errorlog(){

    $("#errorLog").fadeIn(300);

    setTimeout(function(){
        $("#errorLog").fadeOut(300);
    }, 3500)

}

$(document).ready(function(){
    //start once page is load
    getUser();
    getBalance();

    $("#btnSend").click(function(){
        $.post('../getHyperlinks.php',{

            }).done(function (data) {
                if(data.status == 404)
                    alert("Ups ! something happends: " + data.message);
                else{

                    var href = data.hyper;
                    var windowName = 'userConsole'; 
                    var popUp = window.open(href, windowName, 'width=1000, height=700, left=24, top=24, scrollbars, resizable');
                    if (popUp == null || typeof(popUp)=='undefined') {  
                    
                        swal({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Please disable your pop-up blocker and click the "Transfer" button again.'
                        })
                    } 
                    else {  
                        popUp.focus();
                        setTransfer();
                    }
                }
            });
    })

    $("#btnClose").click(function(){
        window.location.reload();
    })

    $("#btnLogOut").click(function(){
        Cookies.remove('session');
        window.location.href = "index.html";
    })
});