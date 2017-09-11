# SmartSettia Development Environment

[![Build Status](https://travis-ci.org/uidaho/smartsettia.svg?branch=master)](https://travis-ci.org/uidaho/smartsettia)
[![Total Downloads](https://poser.pugx.org/uidaho/smartsettia/d/total)](https://packagist.org/packages/uidaho/smartsettia)
[![Latest Stable Version](https://poser.pugx.org/uidaho/smartsettia/v/stable)](https://packagist.org/packages/uidaho/smartsettia)
[![Latest Unstable Version](https://poser.pugx.org/uidaho/smartsettia/v/unstable)](https://packagist.org/packages/uidaho/smartsettia)
[![License](https://poser.pugx.org/uidaho/smartsettia/license)](https://packagist.org/packages/uidaho/smartsettia)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/uidaho/smartsettia/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/uidaho/smartsettia/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/uidaho/smartsettia/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/uidaho/smartsettia/?branch=master)
[![composer.lock](https://poser.pugx.org/uidaho/smartsettia/composerlock)](https://packagist.org/packages/uidaho/smartsettia)

SmartSettia is a poinsettia life-cycle management system that couples the flexibility of IoT devices with the power of the cloud. Control units can be securely installed and controlled anywhere with an internet connection.

Table of Contents
=================

  * [SmartSettia Development Environment](#smartsettia-development-environment)
    * [Dependencies](#dependencies)
	  * [Update apt](#update-apt)
	  * [Install PHP7, NGINX, and redis-server](#install-php7-nginx-and-redis-server)
	  * [Install MySQL](#install-mysql)
    * [Configuration](#configuration)
	* [Generate key for github](#generate-key-for-github)
	* [Install SmartSettia](#install-smartsettia)
    * [Editor](#editor)


## Dependencies
These instructions were tested using Ubuntu Server 16.04.3 LTS (Xenial Xerus) on a DigitalOcean.com virtual machine and Ubuntu Desktop 16.04.3 LTS. While this application can be run from a Windows environment, with the approriate dependencies, your mileage may vary.

### Update apt
```bash
sudo apt update
sudo apt upgrade
```

### Install PHP7, NGINX, and redis-server
```bash
sudo apt install curl unzip git
sudo apt install php7.0 php7.0-fpm php7.0-curl php7.0-dev php7.0-gd php7.0-intl php7.0-mcrypt php7.0-json php7.0-mysql php7.0-opcache php7.0-bcmath php7.0-mbstring php7.0-soap php7.0-xml php7.0-cli
sudo apt install composer redis-server nginx
```

### Install MySQL
```bash
sudo apt install mysql-client mysql-server
```

## Configuration
### Configure UFW firewall (optional)
This step is optional and recommended if your computer directly exposed to the internet. Configure ufw to open the web and ssh ports:
```bash
sudo ufw allow http
sudo ufw allow https
sudo ufw allow ssh
```
and then enable the firewall:
```bash
sudo ufw enable
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

### Configure PHP7
Edit `/etc/php/7.0/fpm/php.ini` and find `cgi.fix_pathinfo=0` then  set it to `1`:
```bash
sudo nano /etc/php/7.0/fpm/php.ini
sudo systemctl restart php7.0-fpm
```

### Configure NGINX
Edit `/etc/nginx/sites-available/default`:
```bash
sudo nano /etc/nginx/sites-available/default
```
Replace USERNAME with your username and make it look like this:
```nginx
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /home/USERNAME/smartsettia/public;
    index index.php index.html index.htm index.nginx-debian.html;

    server_name localhost;

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
Then reload nginx with the new configuration:
```bash
sudo systemctl reload nginx
```

## Generate key for github
If you do not have a `~/.ssh/id_rsa.pub` then you'll need to create one:
```bash
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
```
When you're prompted to "Enter a file in which to save the key," press Enter. This accepts the default file location. Press enter twice more to use a blank password. Copy this key and put it in your github authorized keys:
```bash
cat ~/.ssh/id_rsa.pub
```

## Install smartsettia
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
```



## Editor
### Setup Atom
```bash
wget https://atom.io/download/deb
sudo dpkg -i atom-amd64.deb
```

Recommended Packages:
* aligner
* aligner-css
* aligner-javascript
* aligner-php
* aligner-python
* atom-beautify
* emmet
* emmet-snippets-compatibility
* file-icons
* highlight-selected
* intentions
* language-blade
* language-ini
* language-lua
* laravel
* laravel-forms-bootstrap-snippets
* linter
* pigments
