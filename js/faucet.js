
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
            $("#balance").text(data.wallet_balance);
            $("#unlock-balance").text(data.wallet_unlock);


            if(data.wallet_balance >= 10)
            {
                $("#spnPaidMsg").text("You are avialable to withdraw your SUPs now !");
                $("#btnPaid").css("visibility", "visible");
            }
            else{
                $("#spnPaidMsg").text("You need 10-SUPs or more to get paid ! Keep playing");
                $("#btnPaid").css("visibility", "hidden");
            }

            //START TIMER
            setTimer();
            $("#destination").val(address);
    
        }
    });

    //GET POOL BALANCE
    var xhttp = new XMLHttpRequest(); 
    //CHECK STATUS VALUES -IF-ADD TEXT TO DIV -ELSE-NO CONNECTION MESSAGE
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            $("#spnPoolAmount").text(this.response);
        }
        else{
            $("#spnPoolAmount").text("INVALID CONNECTION");
        }
    };
    xhttp.open("GET","pool-show.php", true); //(METHOD,URL,BOOLEAN)
    xhttp.send();// SEND THE REQUEST

}

function setClaim(){
    var address        = localStorage.getItem("walle");

    $.post('./checkClaims.php',
           {
        user_address : address
    }).done(function(data){
        var values  = JSON.parse(data);
        value  = values[0];
        var     m  = parseInt(value);

        if(data.status == 404)
            alert(data.message);
        else if ( m < 1) 
        {
            $wait = (1 - m);
            alert("You have to wait "+$wait+" minutes to claim!")
        }
        else{

            $.post('./setClaim.php',
                   {
                user_address : address
            }).done(function(data){

                $("#btnClaim").css("visibility", "hide");
                $("#aClaim").css("color", "white");
                $("#modal1").modal("hide");
                window.location.reload();
            });
        }

    });
}

function setPaid(){
    var address     = localStorage.getItem("walle");

    $.post('./setPaid.php',
           {
        user_address   : address
    }).done(function(data){
        if (data.status == 404)
            alert(data.message);
        else{
            alert("Now You are avialable to tranfer your unlock-balance")
            $("#btnClaim").css("visibility", "hide");
            $("#aClaim").css("color", "white");
            $("#modal1").modal("hide");
            window.location.reload();
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

function getTbPayments(){

    // Disable search and ordering by default
         $.extend( $.fn.DataTable.defaults, {
             searching: false,
             ordering:  false
         } );
        
    var dataTable = $('#tb-payments').DataTable( {
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "./getTbPayments.php",
            "type": "post"
        }
    });
}

function setTimer(){

    $('#spnTimer').timer({
        countdown: true,
        duration: '1m',      // This will start the countdown from 3 mins 40 seconds
        callback: function() 
        {  // This will execute after the duration has elapsed
            $("#aClaim").css("color", "orange");
            $("#btnClaim").css("visibility", "visible");
        },
        repeat: false
    });
}


$(document).ready(function(){
    //start once page is load
    getBalance();
    getTbPayments();
    $('[data-toggle="tooltip"]').tooltip();

    $("#btnClaim").click(function(){
        alert("This could an Add-On");
        window.open("https://www.youtube.com/watch?v=coVJIoQJx9Q", "Diseño Web", "width=300, height=200");
        setClaim();
    })

    $("#btnPaid").click(function(){
        alert("This could an Add-On");
        window.open("https://www.youtube.com/watch?v=coVJIoQJx9Q", "Diseño Web", "width=300, height=200");
        setPaid();
    })

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