# ATMStater: 東成 Tommy
BAMS: Andy Alex





# Apache web server and MySQL database server are running at host "cslinux0.comp.hkbu.edu.hk".
The following are the steps to remote logon to MySQL server running at "cslinux0" with the mysql command line client tool at "csinux1|2|3":
0. please note that direct ssh access to host "cslinux0" is not allowed
1. ssh to "cslinux1"
2. issue command
        mysql -ucomp4107_grpXX -p comp4107_grpXX -hcslinux0
        (this asks the mysql client tool to remote logon to mysql server at "cslinux0"
        with mysql account comp4107_grpXX which has a password
        and use database comp4107_grpXX)
3. input mysql account password when prompted
 

# To setup webpages at "cslinux0" (URL: http://cslinux0.comp.hkbu.edu.hk/comp4107_20-21_grpXX/), do the following:
0. ssh to "cslinux1"
1. upload files to group webpage folder /home/sharefolders/comp4107_20-21/grpXX/public_html
2. name the 1st webpage as index.html or index.php
3. make all webpages world readable
4. make all web folders under /home/sharefolders/comp4107_20-21/grpXX/public_html/ world executable and readable
 

# A database account (mysql) on cslinux0, together with a database have been created for your group:
0. Account name: comp4107_grp08
1. DB name: same as account name
2. Password: 246186
