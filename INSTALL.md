# The smartsettia Project

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
      * [Install Composer](#install-composer)
      * [Install MySQL, Nginx and PHP5-FPM](#install-mysql-nginx-and-php5-fpm)
    * [Configuration](#configuration)
      * [Create Self-Signed SSL Certificate](#create-self-signed-ssl-certificate)
      * [Configure Nginx](#configure-nginx)
      * [Configure PHP5-FPM](#configure-php5-fpm)
    * [SmartSettia Installation](#smartsettia-installation)
      * [Create MySQL Database and User](#create-mysql-database-and-user)
      * [Install smartsettia](#install-smartsettia)
      * [Install phpMyAdmin (optional)](#install-phpmyadmin-optional)

## SmartSettia Requirements
SmartSettia is straightforward to install if you have a webserver with the following prerequisites available you can skip ahead to [smartsettia Installation](#smartsettia-installation).
- Apache/NGINX Webserver pointing to the smartsettia/public folder
- PHP 5.6 or greater
- Composer v1.0.0 or greater

Otherwise, start with [Obtaining a VPS](#obtaining-a-vps) to create your hosting envionment.

### Obtaining a VPS
### Securing your VPS
```
root@www:~# passwd
root@www:~# ufw allow ssh
root@www:~# ufw allow http
root@www:~# ufw allow https
root@www:~# ufw allow mail
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

### Create User
Create a user for smartsettia and give it the ability to use sudo:
```
adduser smartsettia
adduser smartsettia admin
su smartsettia
```

### Install Composer
```
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install curl php5-cli git
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

### Install MySQL, Nginx and PHP5-FPM
```
sudo mysql_secure_installation
sudo apt-get install nginx php5-fpm php5-cli php5-mcrypt git lrzsz unzip zip
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
add_header Strict-Transport-Security "max-age=63072000; includeSubdomains; preload";
add_header X-Frame-Options DENY;
add_header X-Content-Type-Options nosniff;

if ($ssl_protocol = "") {
   rewrite ^   https://$server_name$request_uri? permanent;
}

root /home/smartsettia/smartsettia/public;
index index.php index.html index.htm;

location / {
    try_files $uri $uri/ =404;
}

error_page 404 /404.html;
error_page 500 502 503 504 /50x.html;
location = /50x.html {
    root /usr/share/nginx/html;
}

location ~ \.php$ {
    try_files $uri =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
}
```
Next lets create a symlink to enable the new domain:
```
sudo rm /etc/nginx/sites-enabled/default
sudo ln -s /etc/nginx/sites-available/your_domain.com /etc/nginx/sites-enabled/your_domain.com
sudo service nginx restart
```

### Configure PHP5-FPM
Edit `/etc/php5/fpm/php.ini` and then find cgi.fix_pathinfo and uncomment and set it like:
```
cgi.fix_pathinfo=0
```
Edit `/etc/php5/fpm/pool.d/sites.conf` and then add the following to it:
```
[smartsettia]
user = smartsettia
group = smartsettia
listen = /var/run/php5-fpm-smartsettia.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
chdir = /
```
Edit `/etc/php5/fpm/conf.d/05-opcache.ini` and set:
```
opcache.enable=0
```
Then restart the service:
```
sudo service php5-fpm restart
```

## smartsettia Installation
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

### Install smartsettia
1. Generate ssh key on the server:
    * `smartsettia@www:~$ ssh-keygen -t rsa -b 4096 -C "CHANGE_ME@vandals.uidaho.edu"`
    * If you enter a password, you will have to provide it each time you use the key (often).
1. Add your new public key to github.com:
    * `smartsettia@www:~$ cat ~/.ssh/id_rsa.pub`
    * copy and paste this string into github key management https://github.com/settings/keys
1. Clone the smartsettia Project files into your home directory:
    * `smartsettia@www:~$ cd`
    * `smartsettia@www:~$ git config --global push.default simple`
    * `smartsettia@www:~$ git clone git@github.com:uidaho/smartsettia.git`
1. Change directory to the project folder:
    * `smartsettia@www:~$ cd ~/smartsettia`
1. Install the project's library pre-reqs with composer:
    * `smartsettia@www:~/smartsettia$ composer install`
1. Edit your individual .env environment file to include your username and mysql db password:
    * `smartsettia@www:~/smartsettia$ cp .env.example .env`
    * `smartsettia@www:~/smartsettia$ nano .env`
    * The .env should look like this:
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=
APP_URL=http://smartsettia.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartsettia_smartsettia
DB_USERNAME=smartsettia_smartsettia
DB_PASSWORD=secret_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=sendmail
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```
1. Generate application key for encrypting protected data:
    - `smartsettia@www:~/smartsettia$ php artisan key:generate`
1. Set permissions on the storage folder:
    - `smartsettia@www:~/smartsettia$ find ~/smartsettia/storage -type d -exec chmod 775 {} +`
    - `smartsettia@www:~/smartsettia$ find ~/smartsettia/storage -type f -exec chmod 664 {} +`
1. Navigate to https://your_domain.com/ and bask in the awesomeness that is the smartsettia project.

### Install phpMyAdmin (optional)
```
smartsettia@www:~$ cd smartsettia/public
smartsettia@www:~/smartsettia/public$ wget https://files.phpmyadmin.net/phpMyAdmin/4.6.0/phpMyAdmin-4.6.0-all-languages.zip
smartsettia@www:~/smartsettia/public$ unzip phpMyAdmin-4.6.0-all-languages.zip
smartsettia@www:~/smartsettia/public$ mv phpMyAdmin-4.6.0-all-languages phpmyadmin
smartsettia@www:~/smartsettia/public$ rm phpMyAdmin-4.6.0-all-languages.zip
```
