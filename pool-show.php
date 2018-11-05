<?php
    ini_set('display_errors', true); 
    require "../vendor/autoload.php";
                    use Superior\Wallet;
                    $wallet = new Superior\Wallet();

                    $address = $wallet->getAddress();
                    $balance = $wallet->getBalance();
                    
                    
                        //$balance = $this->getBalance();
                        $getfaucetbal = json_decode($balance);
                        $realBalance = number_format($getfaucetbal->{'balance'}/100000000);
                        //$realBalance = number_format($realBalance, 2, '.', '');
                        //return $realBalance;
                    
                    
                    echo($realBalance);
?>