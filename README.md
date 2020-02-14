# rec-direc

RecDirec website development is to develop a website which maintains contact details for legal recruiters

## Getting Started

These instructions are exclusively prepared to get the project up and running on Staging and Production environment.

### Prerequisites

1. Laravel (5.8)
2. PHP (7.2)
3. MySQL (5.7)
4. Apache (2.4.18)

### Global Depencencies for running project
Composer

### Installation Process

### 1. PHP7.2:
```
PHP 7.2 can be installed using the software-properties-common and python-software-properties packages:

sudo apt-get install software-properties-common python-software-properties

Then, add the PPA and update your sources:

sudo add-apt-repository -y ppa:ondrej/php

sudo apt-get update

sudo apt-get install php7.2 php7.2-cli php7.2-common

sudo apt-get install php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-intl php7.2-mysql php7.2-xml php7.2-zip

Use the following command to check the PHP version installed on your server:

php -v
```
### 2. Apache2:
```
Install the latest stable release of Apache 2.4.x using the following command:

sudo apt-get install apache2 -y
Use the below command to confirm the installation:

apache2 -v

The output should resemble:

Server version: Apache/2.4.18 (Ubuntu)
Server built:   2016-07-14T12:32:26

If we want to change the default PHP version to PHP 7.2 that is used by the web server, we need to disable the old PHP 7.0 version and enable the newly installed one.

a2enmod php7.2

systemctl restart apache2
```
### 3. MySQL:
```
sudo apt-get install software-properties-common
sudo add-apt-repository -y ppa:ondrej/mysql-5.7
sudo apt-get update
sudo apt-get install mysql-server
```
### 3. Install Composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Clone the project from the appropriate git repository using git clone.

## Install dependencies
Run the below command to install project dependencies.
```
composer install/update/dump-autoload
```
### Set permissions

Set 777 permissions to storage folder.
```
chmod -R 777 storage
```
### Global Configurations

Get below files from Developers

- SiteConstants.php / SiteConstant.php
- .env

### Application key

Generate application key using the below command.
```
php artisan key:generate
```
### Change Necessary Configurations

Update .env  with appropriate connections. Make sure to execute the below command after every .env update.
```    
php artisan config:cache  
```

### Run DB Migration

Run the database migrations using the below command,  this will create appropriate tables.
```  
php artisan migrate
```
Note: If you face migration error contact developer.

## Update existing project
### Step 1: Switch to project directory
```
cd project
```

### Step 2: Pull the recent version of code from Bitbucket
```
git pull
```

### Logs Location
 storage/logs/laravel.log

### Vulnerability Scanner 
 N/A

### Unit Test
 N/A

# Author
JMAN Digital Services