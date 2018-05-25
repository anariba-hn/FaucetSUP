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
        if(data.status = 404)
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

    if(destination.length != 95)
    {
        $("#msg").css("visibility", "visible");
        msg.text("Please enter a Valid Wallet Address");
        $('#destination').focus();
    }
    else if(amount == 0)
    {
        $("#msg").css("visibility", "visible");
        msg.text("Please enter a higher amount");
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
                $("#msg").css("visibility", "visible");
                msg.text(data.message);
                $('#vpass').focus();
            }
            else if(data.flag == 2)
            {
                $("#msg").css("visibility", "visible");
                msg.text(data.message);
                $('#amount').focus();
            }
            else{

                $("#modal4").modal("show");
                
            }
        });

    }
}

$(document).ready(function(){
    //start once page is load
    getUser();

    $("#btnSend").click(function(){
        alert("This could an Add-On");
         window.open("https://www.youtube.com/watch?v=coVJIoQJx9Q", "Diseño Web", "width=500, height=300");
        setTransfer();
    })

    $("#btnClose").click(function(){
        window.location.reload();
    })

    $("#btnLogOut").click(function(){
        Cookies.remove('session');
        window.location.href = "index.html";
    })
});