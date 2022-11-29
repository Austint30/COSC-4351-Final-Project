# 1) How to set up our project
### Note: We developed this using Windows so we highly recommend installing the Windows versions of the software below
## 1) Set up project
1. [Install XAMPP](https://www.apachefriends.org/)
2. Go to your XAMPP install directory (installs in C:/xampp by default) and delete everything within the `htdocs` directory.
3. Then move this project into `htdocs`.
4. [Install Composer](https://getcomposer.org/) and choose the php.exe located within the XAMPP directory.
5. In the terminal, navigate to the root directory of the project and run `composer install`.

## 2) Set up MySQL database
1. [Install MySQL for Windows](https://dev.mysql.com/downloads/installer/) and install the second option.
2. Once installed, install [MySQL Workbench](https://dev.mysql.com/downloads/workbench/) and set up with a username and password.
3. Once installed, launch MySQL workbench and create a new connection to localhost.
4. When successfully connected, go to the `Server > Data import` and import the `dump.sql` file in the project.
5. Go to `<project root>/include/connect.php` and change `$host` to `localhost` and change `$user` and `$pass` to the username and password you set up in MySQL.

## 2) Run the web server
1. Open the XAMPP application on Windows.
2. Click `Start` for the Apache module.
3. Go to localhost on the web browser and the website should display.

## 3) Run unit tests
1. Navigate to the root directory of the project in the terminal.
2. Run `./vendor/bin/phpunit ./tests` (PHPUnit dependency must be installed using Composer).