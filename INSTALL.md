# The SmartSettia Project

[![Build Status](https://travis-ci.org/uidaho/smartsettia.svg?branch=master)](https://travis-ci.org/uidaho/smartsettia)
[![Total Downloads](https://poser.pugx.org/uidaho/smartsettia/d/total.svg)](https://packagist.org/packages/uidaho/smartsettia)
[![Latest Stable Version](https://poser.pugx.org/uidaho/smartsettia/v/stable.svg)](https://packagist.org/packages/uidaho/smartsettia)
[![Latest Unstable Version](https://poser.pugx.org/uidaho/smartsettia/v/unstable.svg)](https://packagist.org/packages/uidaho/smartsettia)
[![License](https://poser.pugx.org/uidaho/smartsettia/license.svg)](https://packagist.org/packages/uidaho/smartsettia).

SmartSettia is a poinsettia life-cycle management system that couples the flexibility of IoT devices with the power of the cloud. Control units can be securely installed and controlled anywhere with an internet connection.

Table of Contents
=================

  * [SmartSettia](#the-smartsettia-project)
    * [SmartSettia Requirements](#smartsettia-requirements)
      * [Obtaining a VPS](#obtaining-a-vps)
      * [Securing your VPS](#securing-your-vps)
      * [Create User](#create-user)
      * [Update system packages](#update-system-packages)
      * [Install dependencies](#install-dependencies)
    * [Configuration](#configuration)
      * [Create Self-Signed SSL Certificate](#create-self-signed-ssl-certificate)
      * [Configure MySQL](#configure-mysql)
      * [Configure PHP7.0](#configure-php7.0)
      * [Configure Nginx](#configure-nginx)
    * [SmartSettia Installation](#smartsettia-installation)
      * [Create MySQL Database and User](#create-mysql-database-and-user)
      * [Install SmartSettia](#install-smartsettia)

## SmartSettia Requirements
SmartSettia is straightforward to install if you have a webserver with the following prerequisites available you can skip ahead to [SmartSettia Installation](#smartsettia-installation).
- Apache/NGINX Webserver pointing to the smartsettia/public folder
- PHP 7.0 or greater
- Composer v1.0.0 or greater

Otherwise, start with [Obtaining a VPS](#obtaining-a-vps) and then create your hosting envionment.

### Obtaining a VPS
Use a provider like Digital Ocean or supply your own server. Here are the settings we used when creating our Digital Ocean droplet:
- Distrobution: Ubuntu 16.04.3 x64
- Size: Standard, 512MB / 1 CPU, 20GB Disk
- Datacenter region: Pick the one closest to your users.

### Securing your VPS
Login to your new server, change the root password and setup the firewall:
```
root@www:~# passwd
root@www:~# ufw allow ssh
root@www:~# ufw allow http
root@www:~# ufw allow https
root@www:~# ufw enable
root@www:~# ufw status
```
You should then see:
```
Status: active

To                         Action      From
--                         ------      ----
22                         ALLOW       Anywhere
80                         ALLOW       Anywhere
443                        ALLOW       Anywhere
25/tcp                     ALLOW       Anywhere
22 (v6)                    ALLOW       Anywhere (v6)
80 (v6)                    ALLOW       Anywhere (v6)
443 (v6)                   ALLOW       Anywhere (v6)
25/tcp (v6)                ALLOW       Anywhere (v6)
```

### Create user
Create a user for smartsettia:
```
adduser smartsettia admin
su smartsettia
```

### Update system packages
Update packages and then reboot:
```
sudo apt update
sudo apt upgrade
sudo reboot
```

### Install dependencies
Install PHP7, NGINX, redis-server, MySQL and other dependencies:
```bash
sudo apt install curl unzip git
sudo apt install php7.0 php7.0-fpm php7.0-curl php7.0-dev php7.0-gd php7.0-intl php7.0-mcrypt php7.0-json php7.0-mysql php7.0-opcache php7.0-bcmath php7.0-mbstring php7.0-soap php7.0-xml php7.0-cli
sudo apt install composer redis-server nginx
sudo apt install mysql-client mysql-server
```

## Configuration
### Create Self-Signed SSL Certificate
```
sudo mkdir /etc/nginx/ssl
openssl dhparam -out /etc/nginx/ssl/dhparam.pem 2048
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/ssl/nginx.key -out /etc/nginx/ssl/nginx.crt
```
Do not enter a password, just press enter twice. Follow the prompts to look something like this:
```
Country Name (2 letter code) [AU]:US
State or Province Name (full name) [Some-State]:Idaho
Locality Name (eg, city) []:Moscow
Organization Name (eg, company) [Internet Widgits Pty Ltd]:University of Idaho
Organizational Unit Name (eg, section) []:CS383
Common Name (e.g. server FQDN or YOUR name) []:*.your_domain.com
Email Address []:admin@your_domain.com
```

### Configure MySQL
Perform `mysql_secure_installation` to harden MySQL a bit and then connect to the server as root with the password you created earlier:
```bash
sudo mysql_secure_installation
mysql -U root -p
```
Once at the `mysql>` prompt run the following queries to create a database and user for SmartSettia. Be sure to change password to something secure and take note of it, you will need this password for the smartsettia .env file:
```sql
CREATE DATABASE smartsettia_db DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
GRANT ALL ON smartsettia_db.* TO 'smartsettia_db'@'localhost' IDENTIFIED BY 'password';
FLUSH PRIVILEGES;
EXIT;
```

### Configure PHP7.0
Edit `/etc/php/7.0/fpm/php.ini` and find `cgi.fix_pathinfo=0` then  set it to `1`:
```bash
sudo nano /etc/php/7.0/fpm/php.ini
sudo systemctl restart php7.0-fpm
```

### Configure Nginx
Edit `/etc/nginx/sites-available/your_domain.com` and put this in it:
```
server {
listen 80;
listen [::]:80;
listen 443 default ssl;
server_name www.your_domain.com your_domain.com;

ssl_certificate      /etc/nginx/ssl/nginx.crt;
ssl_certificate_key  /etc/nginx/ssl/nginx.key;
ssl_dhparam          /etc/nginx/ssl/dhparam.pem;
ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
ssl_prefer_server_ciphers on;
ssl_ciphers "EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH";
ssl_ecdh_curve secp384r1; # Requires nginx >= 1.1.0
ssl_session_cache shared:SSL:10m;
ssl_stapling on; # Requires nginx >= 1.3.7
ssl_stapling_verify on; # Requires nginx => 1.3.7
resolver 8.8.8.8 8.8.4.4 valid=300s;
resolver_timeout 5s;
# add_header Strict-Transport-Security "max-age=63072000; includeSubdomains; preload";
add_header X-Frame-Options DENY;
add_header X-Content-Type-Options nosniff;

if ($ssl_protocol = "") {
   rewrite ^   https://$server_name$request_uri? permanent;
}

root /home/smartsettia/smartsettia/public;
index index.php index.html index.htm;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php7.0-fpm.sock;
}

location ~ /\.ht {
    deny all;
}
}
```
Next lets create a symlink to enable the new domain:
```
sudo rm /etc/nginx/sites-enabled/default
sudo ln -s /etc/nginx/sites-available/your_domain.com /etc/nginx/sites-enabled/your_domain.com
sudo service nginx restart
```

## SmartSettia Installation
SSH into the server using the credentials for the smartsettia user you created earlier.

### Create MySQL Database and User
Open a mysql session as root and then execute the following:
```
mysql -u root
CREATE DATABASE IF NOT EXISTS smartsettia_smartsettia
CREATE USER 'smartsettia_smartsettia'@'localhost' IDENTIFIED BY 'secret_password';
GRANT ALL ON smartsettia_smartsettia.* TO 'smartsettia_smartsettia'@'localhost';
FLUSH PRIVILEGES;
exit
```

### Install SmartSettia
Once [Dependencies](#dependencies) and [Configuration](#configuration) have been completed you're ready to download the smartsettia project to your home (~) folder:
```bash
cd ~
git clone git@github.com:uidaho/smartsettia.git
cd smartsettia
```
Set permissions to allow nginx access to the storage and cache folders:
```bash
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```
Use composer to download all the php dependencies:
```bash
composer install
```
Customize the application configuration environment variables for your system:
```bash
cp .env.example .env
nano .env
```
Generate an application encryption key and perform the database migration:
```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```
Navigate to https://your_domain.com/ and bask in the awesomeness that is the SmartSettia project.
