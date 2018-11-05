<?php 
include ("./connex.php"); //include db connection. import $cnn variable.
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
//Load Composer's autoloader
require "/var/www/html/vendor/vendor/autoload.php";


    $user_name    = $_POST['user_name'];
    $user_email   = $_POST['user_email'];
    $user_pw      = $_POST['user_pw'];
    $user_address = $_POST['user_address'];
    $succes  = false;
    $response= array();
    $type    = 0; //user_type will be 0 by default as player 1 will be donate member
//  $cnn     = include
 if($user_name != null && $user_email != null && $user_pw != null && $user_address != null)   
 {
    $query = "SELECT * FROM users WHERE user_email = '$user_email' or user_address = '$user_address'";
    if (!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $response = $row;
        }
    }
    else
    {
        $salted = "4566654jyttgdjgghjygg".$user_pw."yqwsx6890d"; //encryptin pw
        $hashed = hash("sha512", $salted); //encryptin pw
        $code   = md5(rand(0,1000)); //Generate random 32 character hash and assign it to a local variable. // Example output: f4552671f8909587cf485ea990207f3b
        $query = "INSERT INTO users(user_name, user_email, user_pw, user_address, registration, active) VALUES('$user_name','$user_email','$hashed','$user_address','$code', '$type')";
        if(!$result = mysqli_query($cnn,$query)) 
        {
            exit(mysqli_error($cnn));
        }else{
            $query2 = "SELECT id_user FROM users WHERE user_address = '$user_address'";
            if(!$result = mysqli_query($cnn,$query2)) 
            {
                exit(mysqli_error($cnn));
            }
            $data = mysqli_fetch_row($result);
            $user_id = (int) $data[0];
            #SET COOKIE ON SERVER
            setcookie("walle", $user_id, time() + 846000);
            $query3 = "INSERT INTO wallet(wallet_balance,wallet_unlock,wallet_withdraws,wallet_paids,wallet_claims,paids_update, user_id)VALUES(0,0,0,0,0,now(),'$user_id')";
            if(!$result = mysqli_query($cnn,$query3)) 
            {
                exit(mysqli_error($cnn));
            }else{
                $mail = new PHPMailer(true); 
                //Server settings
                $mail->SMTPDebug = 1;                               // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'superiorfaucet@gmail.com';          // SMTP username
                $mail->Password = 'Superior2020';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('admin@superior-coin.com', 'Faucet');
                $mail->addAddress($user_email);               // Name is optional

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'SignUp | Verification';
                $mail->Body    ="  
                <!DOCTYPE html>
                <html lang=''>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title></title>
                    <style>

                        body{
                            margin: 0px;
                            padding: 0px;
                        }

                        .container{
                            width: 96.7%;
                            box-sizing: border-box;
                            text-align: center;
                            font-family: sans-serif;
                        }

                        .hero{
                            color: #6a4809;
                        }

                        .data{
                            width: auto;
                            text-align: left;
                            margin-left: 120px;
                            margin-right: 120px;
                            margin-top: 30px;
                            padding: 10px;
                            border: solid 1px;
                            border-radius: 25px;
                            background-color: rgba(106, 72, 9, 0.31);
                            box-shadow: 0px 0px 20px 0px inset #6a4809;
                        }

                        .hero img{
                            width: 150px;
                        }

                        .footer{
                            width: 100%;
                            height: 180px;
                            padding: 20px;
                            margin-top: 50px;
                            color: white;
                            background-color: #343a40;
                        }

                        .footer p{
                            font-size: 18px;
                        }

                        .footer a{
                            color: #6a4809;
                        }
                    </style>
                </head>

                <body>
                    <div class='container'>
                        <div class='hero'>
                <img src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAkACQAAD/2wBDAAQDAwQDAwQEAwQFBAQFBgoHBgYGBg0JCggKDw0QEA8NDw4RExgUERIXEg4PFRwVFxkZGxsbEBQdHx0aHxgaGxr/2wBDAQQFBQYFBgwHBwwaEQ8RGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhr/wAARCAEmASwDASIAAhEBAxEB/8QAHQAAAgMBAAMBAAAAAAAAAAAAAAYFBwgEAQIDCf/EAFcQAAECBAMEBQULBwgIBQUAAAECAwAEBREGITEHEkFRMkJhcYEIExci0hQYU1aRk5WhscHRFSNSVWKSwhYzNGRlcoKDJDVDY6Lh8PElREWEs0dUhbLD/8QAGwEAAgMBAQEAAAAAAAAAAAAAAAQDBQYCAQf/xABAEQABAgMEBwQIBAYBBQAAAAABAAIDBBEhMUFRBRJhcZGh0ROBscEUIjJSktLh8CMzQkMGFRZTcqLxJDRigrL/2gAMAwEAAhEDEQA/AN/QQQQIRBBBAhEEEECEQQQQIRBBBAhehOl48k5Zx8JiYalGVPTTqGWkC6lrUAkDvMVVjfb9hzCaVNMPJm5m3qjMA9wGZHbkO2K+bn5aSH4zqE3C8ncBaeFExBl4sc+oK0vOA3m4K2r2iCq2M6JRbieqDIWnVCDvqHeBpGQ8S+ULiDEylNSazKyxyAPq/wDCDb5SqFNupzlRWFTsw48TwUch3DQeEZiPp6YfZLww0ZutPwg+Lq7FYNkYTLYjqnIWDienetX1HbjTG1lFKlFzChkC4sJHyC/12iAd2p12oqIllsSaToW2rkfLf7Ipal6iHKmdWKONNzsb8yM7cKNHdQV4kqWkKH7EMDabTzs5BPKKvWaj/S61PEHUNOebH1CO5ijtzNjMzE4/fXfmVGIincIaJLQRVxITXmryTvJPiSuTMxW+yabgB4AIawhSFgecl1rJ4l9f4x1DBlHA9Rh1B5pmFj74kmNBHanSF/RYF+oOAXPpkz/cPEpbcwyyxnKz1RlyNC3NKFo5XZiuSA/0SvTRA4PpS7f5YZZjQwvz/GGGN7P2HFu4keBC8EzEN5B3gHyXxb2i12nG04zJzrfGwLaj43tExT9rtJfIbqTD8is6nJxI8Rn9UV/VNFQkVbrRbQZ/SEGmpGJGTgHDjY7muqQIlj4Y3ioPmOS1RTK7Tqujepk6xM80pX6w8NREkc/+0Yddrc/SnUuSUwtBQbpF7gHs5eFocsNeUbU6OpDFcT7pYGRUu67Dv6Q/4ovpf+IIjKCZh2Ztt4tNo7tZRukWP/Kd3GzndxotYcP+ceT4Qi4U2q4dxayhUrONsOqy3VryJ5b2l+w2PZDwTkcxpGolpuXnGa8F4cMaYbxeDsIqq6LBiQTqvBB+7sD3L6QQQQ2okQQQQIRBBBAhEEEECEQQQQIRBBBAhEEEECEQQQQIXrlBBrHHUJ+Wpks5MzzyGGWxdS1GwH/OI3vbDaXOIAFtcl6ASaBdZMVttC2zYfwHKuKfmWn5kXATvXSFcssyeweNoqva1t/dS29TsMgoTYpUu+Z/vEcP2Rnz5RkbEVUnKxOLmajMLfeV1lHIDkBwHYIx01pqJMnUk7G+8Raf8QcNpG4EWq9gaObDGtHvywG8jwHecFZO0HyhMRYzmFtyTy5KUB9UiwXbsGie/M9sVk28t94uPrU44o3UpRJJPMnUmIpOsScr0hFIIbWmttTea1J3k2nywTznVAFwFwFgG4JgkOENdO6sKkhwhrp3VjkpdycqXqIcqZ1YVaNITL5SG2Vq3rAZWv3c/CLIouCa/NISpimuhP6blmx8qrH7YS7Rr3FjKuOQBJ4AEhRugvpU2DMkAcTQKSp3CGiS0EfOR2dV4gefmpKUHZvOKH3RMMbPZ8D89X3O5qWSn7zDDZCfiWtgOptLRyJrySzmwh7UUcz4CnNdDGgjtTpHKNn7g/8AX6lf9lSR90e38hJlI/NYiqIP7W6ofJaJP5RpOn5P+zVx/wBP/c5FeJjQwvz/ABibXg2tp/mMQhwfovSiftBvEVO4YxQ0DduQnU8C24W1HwVlC7pGehWvgOA2UdyaSeS6DIZ9mI3mPEU5pLqmioSKt1ofKzI1OTSTUKZMyozuoo3kD/EMoQ6tmFEZjnETIjNfUJo7Igg8DQ8lP2MRo1iLMxaOIqEj1bj4wl1LrQ6Vbj4wl1LrQ81SNUE1U5ykzImKbMuSzo6yFWv2EcR2ZiLs2beU5UKGtqSxNZ6UBACzcpA7tU94uOwaxRE5qYil9Ix2GUeIjCWuFxBod2RGwgjYmwat1XAEHA3fQ7RQr9PsJ43o+MJNt+kzSFqUne83vC9uYz9Ydohlj8w8GY1q+EJ1D9JmloSFBSm94gE8wb+qe0W8RlG0tlu3en4sl2pWsuJlp1IsXFED94fxDLnaNFJ6aLXCFOUFbA4WA7CP0nbccwSAqyY0fYXwLRiMRuzHPYb1dsEeAQoAg3GoIjzGtVMiCCCBCIIIIEIggggQiCCCBCIIIIEL1tBcQX5RDYlxHJYWpTtRqjm60jJKBmpxZ0SkcSfxJyBMRRIjILC95oAKk4AL1rS8gC0le1fxFIYbp652pu+bbTkhIzU4rglI4n/vGY9om0Ko4neXdRl5VN/NtIVkgc78VW4/ZHTiXEk/iqeXPVM7gzSxLpJKWUcAOZ5n7rAI1X6Jj5zpCffpN1DUQgbBnS4u8QLhebaU1UrKtlRW92Jy2DzPCy+u631oRKh0lQ9VvVcItQ6Sojbcp3LhRrEpJNrccQhpKlrUbJSkEknkBxiTwZgKsY2qDUtSJZxaXFWCwgm54gDj35DiSI2dsx8nCk4VZbmq+kTU7a5aCr27FK49wsO+JYcKNMv7OA2pF5uA3nyFTspaloj4cJutENBgLydw8zQbVQOAtjeIsUrSUSy2WQbKUQMu86J7sz2RpPCPk/UmjoQ5V3TMvDMpbOXcVHM+ATFvy8qxJsJZlGW2GUCyUNpCUgdgGUfYZ5RoZfQEEetMuLzlc0dwNveTuCqomkH3QhqjO88cO4DeoymYfplGTamSTMv+0lPrHvVqYlCctYLW0ygtyjSQoUOCwMhtAAwAoOSrXOc81cSTtXtBBBEq5RBBBAhEEEECF62y0heq2CaHW94zkg2l1X+0a9RV+ZI18YYo8E/9XhePLwZlmpGYHDIgELtkR8J2sxxB2GioPF2wJbza3qBMedyJDS7JX3A6H6ozri/BlYw6+43PyjqdzM+oQQOduXaLjtj9BeyI2s0Cm1+VMvV5Ruab4XFlJPMK1B7ozMxoFraulHUPumpHcbxxIGSsoc9U0jNrtFh78DyO1fmHOamIpfSMa42reTQsIfqOESp1IBUpoJusDjdI6XgAew6xlOrUqbpE2qXqDKmnATa+ihfUHiIoSHwn9lGaWuyOIzBuI3XYgFWrC17dZhqM8t4wP2F8ZbpDvhsokw7KvNvS7im3Um6VJNiDCnLdId8M9M1THLwHAgioKnbUEELUmyfbMuTbZpuIiVyuiXBmW+0DiP2deXKNHMPszTLb0u4l1lxIUhaDcKB0IMYEpJsUkZERdmzXaU9hd1uTqy1vUZ1VicyZdRPSSOKb6jxGdwX9G6SdIEQYxrCuBN7dm1v/AM7rk5yTEwDEhijsRn9fHffpaPAMfJh5uZZbdYcS604kKQtJuFJIuCCNecfaN9es1ciCCCPUIggggQiCCCBCIIIIELhqVRlKTT5ieqLyZeUlkFx1xWgSPt7oy/ifF81jusmoTAWzT2SUyEso9BN+kofpGwPZlmbAxI7Y8fnFldVhukuk0amO/wCmLScpiYHV7UoP135JMKssLAAcowWmZ4zUQwWH1Gm3aR5DDM24BaOQluyZ2jh6x5DqfCzNdDnRhdn5d2aX5qXQXHFXskQxLF02AuTkI530CTZWEfzzgstQ4DkIzMWKWEMYKuNwwGZOwczYL1bsYHAl1gH3QbVXNVwdXJi/mZFSr/7xA+0x8MMbI52q1dn+UZbpslvDeU4rfFuJ

                ISST3ceY1iSra1DesSNeMVzV3XAo2WoZ8zErWzbv1tp/ieHteFDlReEwhgeI6LeeC38BYEp6ZWizaA4UgOvqZXvudmSch+yMh33ho9ImGv1mn5pfsx+Xzkw7vn845+8Y6Zd534Rf7xi9hz89BYGQywAXANd86qoknLPcXO1iTjUfKv059IuGv1mn5lfsx49IuG/1mn5pfsx+ckk85ceur5TDTTXFndupXymA6W0kMWfC751AZOVGDuI+Vby9IuGv1kn5lfswekXDf6zT80v2Yx/S1KO7ck+MOdMJNrxGdNaSGLPhd86jMvKjB3xD5Vo30i4b/Wafml+zB6RcN/rNPzS/ZipacBZNwIa5FKbDIfJEZ07pIe58LvnUZhSowd8Q+VN3pEw1+s0/NL9mD0iYa/Wafml+zEfLoTuj1U/JHaG0W6KfkEc/z7SX/h8LvnXHZynuu+IfKvp6RcN/rNPzS/Zg9IuG/wBZp+aX7McEy2mx9VPyQu1FCQDkNOUejT2kj7nwu+deiHKH9LviHypx9IuG/wBZJ+aX7MHpFw3+s0/Mr9mKcqoACrCEarEjesYkGmtJnFnwu+dSCBKnB3xD5Vpz0i4b/Wafml+zB6RcNfrNPzS/ZjFFVWoFVlHjxhNqTqwTZavlMSjS2kziz4XfOphKSpwdxHyr9CDtEw2f/U0fMr9mKr2p4XwJtBk335edYlaubkOeZcCHVftWTkf2hnzBjFEy85c/nFfvGORL7tx+cX+8Yjjzk7NM1IpYR/i6w7PXqO5MwZaBBcHM1gd4t2H1bQnmZ2X4gk5tSJWT90sAndWl1Ayvpbe17sokpHBFeYsXaeoAa/nEH+KEyQecJTdavlMOtGfcbWhaHFBSSCkgm4PAxUObOAU12k/4n5vJWQMEmuqR3jopamApISoEEGxByIPKG+SF0WIuCLERxOS6ai37ul0hMwkD3QhOiv2gP+vx7ZHQRxDjCM01FCLCMj5g3g4heuZqmw1BuP3zVnbLcfnDc+zh+uu3pE2q0k+s/wBHcP8As1fsnhyPYbjQV8ox7NSrc7KuMPjeQtNu0HgR23i5ti+0F2uyr2G6+6VVyloBQ4pWc1L3sly+u8Mgq/YcyTbW6Eni2krENn6T5dOGAVFpCWr+M0b+vXjmregggjZKjRBBBAhEEEECF6cNIqzbptFXgbC6ZSlO7terClS8nY5tJt+cd7N0EAftKTrYxaDrrbDS3XlpbbbSVLUo2AAzJJ5Rg/GeNXNo+OqliBSle4EqMtTEKFtyXQSAq2oKjdRHDeIvkIp9KTRlpejTRzrBs2p6TgiLEqbhafIL70WXTKsNtIzCdVHVR4nvholtIXafoIZGClhpLrmaldBPPtPZHzeNEEFtaVJsAF5OXU4C1aqG0vN9mJyXYPzQBPTIyHIRHz2aVEx0tqK7qUbk6xzT3RMcQIRYS55q43nwA2DDibSV09wdQCwC7qdpSJXOt4xXFY1V3xY9c63jFcVjVXfFiy5QlLDnTMdMvHM50zHTLxMl3XqekdRDVTeEKsjqIaqbwiJygcnOlcIdaX1YSqVwh1pfVhZyWcnOm9XwhrkNBCpTer4Q1yGghdyXcp+X0EdqdI4pfQR2p0iNRFckz0TC5UePdDHM9EwuVHj3R029dNSbVeMIlX60PdV4wiVfrQy1MNSHVdVeMJtS6SocqrqrxhNqXSVDTbk21Lc1qY5BqI65rUxyDURMEw1TFP1TDpSdRCXT9Uw6UnURG5TBPdIdU0pC0Gyh9Y5RNmXSk+dYFm1dJI6p/CIGmaJhkllbozFwciOYirjw3Bwiw/aGGYyPkcDsJTMNwpquuPI59V7dWISenZ6hVGSr9DO7U6W551scHE9dtXNKkki2uZtmYnVoCRdJuk6fhERP9FXjE0CKHgRGGniCPAg81G9hBLXD6joVrPCGJ5HGWHKdXKQrelZ1oLSCc0K0Ug9qVApPaInrRlXye8ZfyaxjN4RnXN2m1oqmaffINzKR67YytZSRfvQOcaqEfTpKZE1AETG47wshMQexiFuGG5eYIIIfS6IIIIEKjvKexurDeA00WQd83UsQrMqkg2KZcAF5XdYpR3LJ4RlWkoS0htCBZKQAB2Q2eUBio4q2qz6W170nR0CQlwDlvJJLhtz3yoX4hIhXpYSBvuq3W0i6ldn4x8+0tMiJGc4mxtg7upWmkYRZDAF5tThTihlovP8A82k2A4qPACJBiZXNO+cc1OgGgHACFVudVOuggbrSckJ5Dn3wySGiYz7IZLu1febhkMt5xPdcFZOcANVt3ifu5TjPREc890THQz0RHPPdExNiuUiVzreMVxWNVd8WPXOtCTVGqXKbgrMy+h50FSWpdAUUp4FXLjlDLKuIa0Ek3AAk8AuHUaCSQAMTYEjudMx0y8SxbwwSSZmqfMpj6IOGEaTNTP8AkphrsZj+074SljEhH9Y4hfSR1ENVN4Qus1HDjNrPVE25sp/GJJjFVBl7bqp9VubI/GODLzJ/ad8JUTnQz+scQrDpXCHWl9WKcl9o9GlrbqJtVubI/GJaX2zUyWtusTCrc2j+MQOlZo3QXcCoHBhueOIWgKb1fCGuQ0EZpY8oORYA3ZJ025tH8Yk2fKblWRYU9R72le1EJk5s/su4FQlgP6hxC1FL6CO1OkZcR5VrKBlTL/5avaj7DytWgP8AVQ+bV7Ucegzn9l3AqPsh7w4haSmeiYXKjx7ooxflXMuCxpdv8tXtRwP+U1LPghVPUm/JpXtR6JKcB/JdwK6EMD9Q4hWhVeMIlX60Kszt9kJm+9Jui/Jo/jENM7W6TNX32ZkX5Nf84nbKzYvgu4FTNa0XvHEL71XVXjCbUukqJKZx1RJm+8J1N+TI/GIp+u4efJ3nKgL8mR+MTtl5kXwnfCUw0sF7xxCXprUxyDUROuTGGnNZipj/ACUx8wcMg/0ip/MpiXsZj+074SpmxIQveOIXin6ph0pOohbak5VcuicpD65iV3t1YWmy21cAocrcYZKTqIWca1BBBFhBFCDkQUyLgQagp4pmiYYmOjC7TNEwxMdGFnLoLw695om+aTqIjp1QWgkG4IjsnOiYXH5wsLKVn1D9UKOYYTzEYLDeM9o2jHMbQFKHBw1XYXHy3eCXq65Myq2J+muFmoSDyZqVcGqXEEEH5RpG58C4qlccYSpFfkbJbn5dLikg382vRaL8d1QUnwjDtUUFAlJuDF2eSficoar2FJheTK/d8mkm5CFEJcSOQCt025rMa/QcwGxTDrY4Wbx9FR6RhazdaloWmoIII2qoV6xEYprKcPYdqlUUATKSy3EpPWUAd0eJsPGJeKp8oWs/knZ1OgKsp5Qvna4SCof8QQPGFZqN2EB0TIWb8FJDbrvDc1h1x9U3U5l5xwuKU6orWo3JN8yT35+MdQnvdCktMmzCT+8eZhZVNEAMtnIi6lfpdndExTdR4R81LdY6zsLuq1o9Uao+9icqZwhvkNEwoUzhDfIaJjhy7CnGeiI557omOhnoiFfHlcdodLC5ZBU8+vzaCOqbHPvy+/hHDQXEAC0r0kAVKVcR1ZLMymXlU+fm1KshAzur8P8AtFt7L/J5brsganigFb8x6yisZ3/DhbgI4Ng+yB+szia7iFskEgpSsXsNQBGvpWWblGEMsJCUJFgBH0LRujxJM1nWvN5yGQ2Z5nupmZuaMw6g9kXbdp+7FS3vaMN/Bpg97Rhv4NMXlBFwkFRvvaMN/Bpg97Rhv4NMXlBAhUb72jDfwaYPe0Yb+DTF5QQIVG+9ow38GmD3tGG/g0xeUECFRvvaMN/Bpg97Rhv4NMXlBAhUb72jDfwaYPe0Yb+DTF5QQIVG+9ow38GmD3tGG/g0xeUECFRvvaMN/Bpg97Rhv4NMXlBAhUb72jDfwaY8HyZ8NkH82mLzggQsObVdj0zs8mVVKhtF2SULPNjMKTxB7e3h8ohEoz7L9lS6rpOYB1HMHt4R+g2IKBK4gpzsnOIStC02zF4wxtU2ez+zevOzkg2oyLiyogAkDtt/1cRn9KaO9IHbQh6wFozHUYHuypZyc32R1Hn1TyPTPipymaJhiY6MU/K7U5KWACpVRI19cj+GJJG2eQQP

                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'>
                            <h2>Thanks for sign up to Superior Coin Faucet !</h2>
                        </div>
                        <div class='content'>
                            <p>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</p>
                            <div class='data'>
                            <p>Username: " .$user_name."</p>
                            <p>Address: " .$user_address."</p>
                            <p>Password: " .$user_pw."</p>
                            </div>
                            <div class='redirect'>
                                <p>Please click this link to activate your account: <a href='https://faucet.the-superior-coin.net/verify.php?email=".$user_email."&hash=".$code."'>https://faucet.the-superior-coin.net/verify.php?email=".$user_email."&hash=".$code."</a></p>
                            </div>
                        </div>
                        <div class='footer'>
                            <p>Learn How it works: <a href='https://steemit.com/superiorcoin/@joanstewart/how-new-faucet-for-superior-coin-works'> https://steemit.com/superiorcoin/@joanstewart/how-new-faucet-for-superior-coin-works</a></p>
                            <p>Check out our Telegram SUP Channel: <a href='https://t.me/superiorcoin'> https://t.me/superiorcoin</a></p>
                            <p>SuperiorCoin: <a href='https://www.superior-coin.com/'> https://www.superior-coin.com/</a></p>
                            <p>Kryptonia:<a href='https://kryptonia.io/'> https://kryptonia.io/</a></p>
                        </div>
                    </div>
                </body>
                </html>
                ";

                if(!$mail->send())
                {
                    $response['status'] = 404;
                    $response['message'] = "Mail was not sent";
                    $response['erno'] = $mail->ErrorInfo;
                }
                else{
                    $response['status'] = 200;
                    $response['message'] = "Mail was sent successfully";
                    $succes = true;    
                }
            }
        }
        if (!$succes) {
         $response['status'] = 404;
         $response['message'] = "Invalid To insert !";
        }
    }
    header('Content-type: application/json; charset=utf8');
    echo json_encode($response);
}
else
{
    $response['status'] = 404;
    $response['message'] = "Invalid Values !";
}
 ?>