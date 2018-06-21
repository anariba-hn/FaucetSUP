function logIn(){
    var address = $("#txtWallet").val();

    if(address == '')
    {
        //$("#alert_msg").text("You need enter a Walled/Email Address");
        //$("#alert_modal").modal("show");
        $("#txtWallet").focus();
        $("#logMsg").text("You need enter a Walled/Email Address ");
        Errorlog();
    }
    else
    {
        $.post('./getUser.php',
               {
            user_address : address
        }).done(function(data)
                {
            if(data.status == 404)
            {
                //$("#alert_msg").text("This Address does not exist, please Sign-Up first");
                //$("#alert_modal").modal("show");
                $("#txtWallet").focus();
                $("#logMsg").text("This Address does not exist, please Sign-Up first");
                Errorlog();
            }
            else
            {	
                localStorage.setItem("walle", data.user_address);
                setCookie();
                window.location.href = "faucet.html";
            }
        });
    }
}


function verifyUser(){

    var name   = $('#user_name').val();
    var email  = $('#user_email').val();
    var pw     = $('#user_pw').val(); 
    var cpass  = $('#cpass').val();
    var wallet = $('#user_address').val();
    var msg    = $('#msg');
    var result = validate(email);

    if (name == '') 
    { 
        //$("#msg").css("visibility", "visible");
        //msg.text("Your Name is Requiered! Please enter your Name or Username");
        $("#logMsg").text("Your Name is Requiered! Please enter your Name or Username");
        Errorlog();
        $('#user_name').focus();
    }
    else if(email == '')
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Your Email is Requiered! Please enter a valid Email");
        $("#logMsg").text("Your Email is Requiered. Please enter a valid Email");
        Errorlog();
        $('#user_email').focus();
    }
    else if(!result)
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Enter a valid email!");
        $("#logMsg").text("Enter a valid email!");
        Errorlog();
        $("#user_email").focus();	
    }
    else if(pw == '')
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Password is Requiered! Please enter your Password this will be encrypted");
        $("#logMsg").text("Password is Requiered! Please enter your Password this will be encrypted");
        Errorlog();
        $('#user_pw').focus();
    }
    else if(cpass == '' || pw != cpass)
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Please enter the same Password");
        $("#logMsg").text("Please enter the same Password");
        Errorlog();
        $('#cpass').focus();
    }
    else if(wallet == '')
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Please a Wallet Address is Requiered");
        $("#logMsg").text("Please a Wallet Address is Requiered");
        Errorlog();
        $('#user_address').focus();
    }
    else if(wallet.length != 95)
    {
        //$("#msg").css("visibility", "visible");
        //msg.text("Please enter a Valid Wallet Address");
        $("#logMsg").text("Please enter a Valid Wallet Address");
        Errorlog();
        $('#user_address').focus();
    }
    else
    { 

        $.ajax({
            type: 'POST',
            url: './captcha.php',
            data : "g-recaptcha-response=" + grecaptcha.getResponse(),
            success : function(data) 
            {
                if (data.status == 404) 
                {

                    $.post('./newUser.php',
                           {
                        user_name    : name,
                        user_email   : email,
                        user_pw      : pw,
                        user_address : wallet
                    }).done(function(data)
                            {    

                        if(data.user_email == email)
                        {
                            //$("msg").css("visibility", "visible");
                            //$("#msg").text("There is an account registered whith this email");
                            $("#logMsg").text("There is an account registered whith this email");
                            Errorlog();
                            $("#user_email").focus();
                        }
                        else if(data.user_address == wallet)
                        {
                            //$("#msg").css("visibility", "visible");
                            //$("#msg").text("There is an account registered with this wallet address");
                            $("#logMsg").text("There is an account registered with this wallet address");
                            Errorlog();
                            $("#user_address").focus();
                        }         
                        else if(data.status == 404)
                        {
                            //$("#msg").css("visibility", "visible");
                            //$("#msg").text(data.message);
                            $("#logMsg").text(data.message);
                            Errorlog();
                        }
                        else
                        {   

                            //Cookie
                            localStorage.setItem("walle", wallet);
                            setCookie();

                            $("#msg").text("");
                            $("#user_address").val(wallet);
                            $("#user_name").val("");
                            $("#user_email").val("");
                            $("#user_pw").val("");
                            $("#cpass").val("");
                            $("#user_address").val("");

                            //open modal alert
                            $("#succes_signup_modal").modal("show");
                            $("#spnUser").text(name);

                        }
                    });

                }
                else{
                    //$("#msg").css("visibility", "visible");
                    //msg.text("Are you a robot? Then select the reCaptcha !!");
                    $("#logMsg").text("Are you a robot? Then select the reCaptcha !!");
                    Errorlog();
                    $("#g-recaptcha-response").focus();
                }
            }
        });             
    }
}

function validateEmail(email) {

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate(email){

    if (validateEmail(email))
        return true;
    else
        return false;
} 

function setCookie(){

    var date = new Date();
    var minutes = 30;
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    Cookies.set("session", "foo", {expires : date});
}

function getPool(){

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

function donate(action){
    
    var name  = $("#donateName").val();
    var email = $("#donateEmail").val();
    var result = validate(email);
    var act  = action;
    
    if(action == 2)
    {
        
        $.post('./setDonate.php',{
            action : act
        }).done(function(data){
            
            if(data.status != 200)
                alert("Ups something happens! " + data.message)
            else{
                $("#donate_modal").modal("hide");
                $("#anonymus_modal").modal("show");
                $("#integAddressAnonymus").val(data.address);
            }
        });
    }
    else if(name == ''){
        //$("#msgDonate").text("Please enter your name. If you don't want to share your information make an Anonymus donation.");
        $("#logMsg").text("Please enter your name. If you don't want to share your information make an Anonymus donation.");
        Errorlog();
    }

    else if(email == ''){
        //$("#msgDonate").text("Please enter your email. If you don't want to share your information make an Anonymus donation.");
        $("#logMsg").text("Please enter your email. If you don't want to share your information make an Anonymus donation.");
        Errorlog();
    }

    else if(!result){//$("#msgDonate").text("Please enter a Valid email address.");
        $("#logMsg").text("Please enter a Valid email address.");
        Errorlog();}

    else if(action == 1)
    {
        $("#succesDonate_modal").modal("show");

        $.post('./setDonate.php',{
            name : name,
            email : email,
            action : act
        }).done(function(data){
            
            if(data.status != 200)
                alert("Ups something happens! " + data.message)
            else{
                $("#donate_modal").modal("hide");
                $("#succesDonate_modal").modal("show");
                $("#integAddress").val(data.address);
            }
        });   
    }

}

function copyText(action){

    if(action == 1)
    {
         var copyText = document.getElementById("integAddress");
         copyText.select();
         document.execCommand("copy");
         alert("Copied the text: " + copyText.value);
    }

    if(action == 2)
    {
         var copyText = document.getElementById("integAddressAnonymus");
         copyText.select();
         document.execCommand("copy");
         alert("Copied the text: " + copyText.value);
    }

}

function Errorlog(){

    $("#errorLog").fadeIn(300);

    setTimeout(function(){
        $("#errorLog").fadeOut(300);
    }, 3500)

}

$(document).ready(function(){

    getPool();

    $("#btnLogIn").click(function(){
        logIn();
    })

    $("#submit").click(function(){
        verifyUser();
    })

    $("#btnRedirect").click(function(){
        alert("This Could be an Add-on")
        window.location.href = "faucet.html";
        window.open("https://www.youtube.com/watch?v=coVJIoQJx9Q", "Diseño Web", "width=300, height=200");
    })

    $("#btnSignAlert").click(function(){
        $("#alert_modal").modal("hide");
        //$("#succes_signup_modal").modal("show");
    })

    $("#btnDonate").click(function(){
        donate(1);
    })
    
    $("#btnAnonymus").click(function(){
        donate(2);
    })

    $("#cp1").click(function(){
        copyText(1);
    })

    $("#cp2").click(function(){
        copyText(2);
    })

});