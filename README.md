# FaucetSUP
Newest superior coin faucet project

Superior Coin Faucet is a site where you can win coins easier. The only thing you have to do, is sign up and collect coins every hour.

## About The Project
It's a direct faucet system which gives a reward once a timer goes down. Users will be available to claim an amount of coins established by the administrator. FaucetSUP manage two balance; [Balance] amount of coins collected per click in a determinate time. [Unlock-Balance] it's a transferable amount which you can send to your wallet. The [Balance] amount will be available to [Unlock] onece user collects ten or more coins, this could be changed by the administrator. FaucetSUP has a transferable system by groups of transactions. This group amount could be set by the administrator. 

The FaucetSUP count with a donation system trough integrated address. This could be anonymous or not at the benefit of the user. A single donation count with a [Hyperlink-Add-on] space; this Hyperlink will output as an Add-on each time users Claims, Paid, or Withdrawals any time. Anonymous donations do not request any information.
The Donation script logic evaluates which donation comes with information and takes a random [Hyperlink] from the database to promote. The lifetime per [Hyperlink] is equal to the amount which come with, this will be reduce per each output.

The project count is in [admincenter] section where administrators can take full reports of Users, Claims, Paid, Withdrawals, Donations, and General Settings.

Users are available to Log-in or Sign-up with a SuperiorCoin Wallet Address.

### The Superior Coin
Copyright (c) 2018, Thesuperiorcoin Project

### Development Resources
<ul>
  <li>Michael Senn</li>
  <li>Dennis Anariba</li>
  <li>Web: https://faucet.the-superior-coin.net</li>
  <li>BCT: BitCoinTalk</li>
  <li>Mail: admin@Superior-coin.com</li>
</ul>

### Dependencies
<ul>
  <li>TheSuperiorCoin</li>
  <li>composer</li>
  <li>php7.2 php7.2-cli php7.2-fpm php7.2-curl (7.2 or higher)</li>
  <li>DB management of preference</li>
</ul>

### Installation
  * Install and set the SuperiorCoin daemon: https://github.com/TheSuperiorCoin/TheSuperiorCoin 
  
  Enter `TheSuperiorCoin/build/release/bin ` <br/>
`- sudo ./superiord --detach`  for backgorund run. <br/><br/>
  Create a main faucet wallet <br/>
`- sudo ./superior-wallet-cli` to create a new wallet. <br/> <br/>
  If you prefer a oldest wallet <br/>
`- sudo ./superior-wallet-cli --electrum-seed arg` and paste your 25 seed words.<br/><br/>
  Establish the rpc connection <br/>
`-sudo nohup ./superior-wallet-rpc --rpc-bind-port [port instead] --wallet-file [wallet name instead] --password [password instead] --disable-rpc-login &` NOTICE: BlockChain has to be up to date. <br/><br/>  
  
 * Install vendor: https://github.com/TheSuperiorCoin/superior-php <br/>
`- composer require thesuperiorcoin/superior-php` <br/><br/>
Move the `vendor` directory into `/var/www/html/` main directory. <br><br/>
Change the port communication in  `/vendor/thesuperiorcoin/superior-php/src/# `.<br/><br/>
`-sudo nano Wallet.php` <br/><br/>

  
 * Set your DB importing: <br/>
`superiorf.sql` file and modify the `connex.php` file. <br>
  
 * Clone the repository: <br/>
`-sudo git clone /var/www/html/https://github.com/anariba-hn/FaucetSUP.git` <br/><br/>
 
 * There are two files needs Cron to run or do it manually<br/>
 `cron-transfer.php`  and  `txs_donation.php` on main directory. <br/><br/>
 On Linux: <br/>
 `sudo nano /etc/crontab` Here you set the time of preference for your jobs. <br/><br/>
 You could visit crontab.guru site to learn about crons sintaxys: https://crontab.guru/#*_*_*_*_* <br/><br/>
 `* * * * root php /var/www/html/FaucetSUP/cron-transfer.php` - Give all permissions to  `FaucetSUP` directory.<br/><br/>
