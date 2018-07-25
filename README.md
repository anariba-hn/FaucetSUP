# FaucetSUP
Newest superior coin faucet project

Superior Coin Faucet is a site where you can win money easier. The only thing you have to do, is sign up and collect coins every hour.

## About The Project
It's a direct faucet system wich gives a reward onces a timer goes down. Users will be avialable to claim an amount of coins established by the administrator as same with the time. FaucetSUP manage two balance; [Balance] amount it's the coins collected per click in a determinate time. [Unlock-Balance] it's a transferable amount wich you can send to your default wallet or others. The [Balance] amount will be available to [Unlock] ones user collect ten or more coins, this could be changed by the administrator. FaucetSUP has a transferable system by groups of transactions. This group amount could be set by the administrator. 

The FaucetSUP count with a donation system trough integrated address. This could be anonymus or not at the benefit of the user. A single donation count with a [Hyperlink-Add-on] space; this Hyperlink will output as an Add-on each time users Claims, Paid, or Withdrawals any time. Anonymus donations do not request any information instead not give any feature.
The Donation script logic evaluate wich donation comes with information and take a random [Hyperlink] from the database to showout. The timelife per each [Hyperlink] is equal to the amount wich come with, this will be reduceble per each output.

The project count with an [admincenter] section where can take full reports of Users, Claims, Paid, Withdrawals, Donation, and General Settings.

Users are avialable to Log-in or Sign-up with a SuperiorCoin Wallet Address.

## The Superior Coin
Copyright (c) 2018, TheSuperioriorCoin Project

### Development Resources
<ul>
  <li>Michael Senn</li>
  <br/>
  <li>Dennis Anariba</li>
  <br/>
  <li>Web: https://faucet.the-superior-coin.net</li>
  <br/>
  <li>BCT: BitCoinTalk</li>
  <br/>
  <li>Mail: admin@Superior-coin.com</li>
</ul>

### Dependencies
<ul>
  <li>TheSuperiorCoin</li>
  <br/>
  <li>composer</li>
  <br/>
  <li>php7.2 php7.2-cli php7.2-fpm php7.2-curl (7.2 or higher)</li>
  <br/>
  <li>DB management of preference</li>
</ul>

### Installation
  * Install and set the SuperiorCoin daemon: https://github.com/TheSuperiorCoin/TheSuperiorCoin 
  
  Enter `TheSuperiorCoin/build/release/bin ` <br/><br/>
`- sudo ./superiord --detach`  for backgorund run. <br/><br/>
  Create a main faucet wallet <br/><br/>
`- sudo ./superior-wallet-cli` to create a new wallet. <br/> <br/>
  If you prefer a oldest wallet <br/><br/>
`- sudo ./superior-wallet-cli --electrum-seed arg` an paste you 25 seed words.<br/><br/>
  Establish the rpc connection <br/><br/>
`-sudo nohup ./superior-wallet-rpc --rpc-bind-port [port instead] --wallet-file [wallet name instead] --password [password instead] --disable-rpc-login &` NOTICE: BlockChain has to be up to date. <br/> <br/>
  
 * Install vendor: https://github.com/TheSuperiorCoin/superior-php <br/> <br/>
`- composer require thesuperiorcoin/superior-php` <br/> <br/>
Move the `vendor` directory to `/var/www/html/` main directory. <br><br/>
Change the port comunication with yours in `/vendor/thesuperiorcoin/superior-php/src/# `.<br/><br/>
`-sudo nano Wallet.php` <br/><br/>

  
 * Set your DB importing: <br/><br/>
`superiorf.sql` file and modify the `connex.php` file. <br><br/>
  
 * Clone the repository: <br/><br/>
`-sudo git clone /var/www/html/https://github.com/anariba-hn/FaucetSUP.git` <br/><br/>
    
