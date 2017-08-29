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
	  * [Install PHP7, NGINX, and redis-server](#update-apt)
	  * [Install MySQL](#update-apt)
    * [Configuration](#configuration)
	* [Generate key for github](#configuration)
	* [Install SmartSettia](#configuration)
    * [Editor](#editor)
	

## Dependencies
### Update apt
```bash
sudo apt update
sudo apt upgrade
```

### Install PHP7, NGINX, and redis-server
```bash
sudo apt install curl unzip git 
sudo apt install php7.0 php7.0-mbstring php7.0-gd php7.0-xml php7.0-cli php7.0-mysql composer
sudo apt install redis-server nginx
```

### Install MySQL
```bash
sudo apt install mysql-client mysql-server
```

## Configuration
### Configure UFW firewall
```bash
sudo ufw allow http
sudo ufw allow https
sudo ufw allow ssh
```

### Configure MySQL
```bash
sudo mysql_secure_installation
mysql -U root -p
```
```sql
mysql> CREATE DATABASE smartsettia_db DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
mysql> GRANT ALL ON smartsettia_db.* TO 'smartsettia_db'@'localhost' IDENTIFIED BY 'tacopassword';
mysql> FLUSH PRIVILEGES;
mysql> EXIT;
```

### Configure PHP7
```bash
sudo nano /etc/php/7.0/fpm/php.ini
```

cgi.fix_pathinfo=0

```bash
sudo systemctl restart php7.0-fpm
```

### Configure NGINX
```bash
sudo nano /etc/nginx/sites-available/default
```

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
```bash
sudo systemctl reload nginx
```

## Generate key for github
```bash
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
```
When you're prompted to "Enter a file in which to save the key," press Enter. This accepts the default file location.
Press enter twice more to use a blank password.

```bash
cat ~/.ssh/id_rsa.pub
```
Copy this key and put it in your github authorized keys.


## Install smartsettia
```bash
cd ~
git clone git@github.com:uidaho/smartsettia.git
cd smartsettia
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
composer install
cp .env.example .env
nano .env
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






