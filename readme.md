## Why WINRad?
The name comes from series of other tools created by RADWIN, like WINTouch, WINManage, WINDeploy, I paired prefix WIN with abbreviation Rad from Radius, just to keep pattern :P

## This Web app was written using Laravel framework, to make life easier for myself and my field technicians.

Instead of having to Authorize each new HSU on the HBS, this app is using the same concept as provided by RADWIN documentation, but instead of creating user.conf file
in notepad, I have made nice web interface. It stores each HSU entry in mysql database, and I have created cli script to compile all records of database into
text file every 5 minutes and reload freeradius service.

## TODO
- write custom mysql query for freeradius, to avoid need reloading freeradius after every users.conf file change. Any contributions welcome.



## Installation steps on Ubuntu 18.04:
Install Nginx PHP and MariaDB

```
apt-get update && apt-get upgrade -y
apt-get install -y git vim curl composer
apt-get install -y nginx
apt-get install -y php7.2-common php7.2-cli php7.2-gd php7.2-mysql php7.2-curl php7.2-intl php7.2-mbstring php7.2-bcmath php7.2-imap php7.2-xml php7.2-zip php7.2-fpm
apt-get install -y mariadb-server mariadb-client
apt-get install -y freeradius

```
```
sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php/7.2/fpm/php.ini

```
Now we can start PHP-FPM and enable it to start automatically at system boot.
```
systemctl start php7.2-fpm
systemctl enable php7.2-fpm
```
Copy repo files to /var/www/radius
```
git clone https://github.com/kristapsdravnieks/WINRad.git /var/www/radius
```
run composer install
```
cd /var/www/radius
composer update
```
Setup Enviroment
- Set variable values according to your Setup, Once that is done, rest of the steps are just copy/paste.
```
### Set hostname and database credentials

export FQDN=radius.test
export DBUSER=radius
export DBNAME=radius
export DBPASS=radius

### Set username and password for WEB interface

export ADMINUSER=admin
export ADMINMAIL=admin@admin.com
export ADMINPASS=admin
```
- Create database
```
mysql -u root -e "create database $DBNAME;"
mysql -u root -e "grant all privileges on $DBNAME.* to '$DBUSER'@'localhost' identified by '$DBPASS';"
mysql -u root -e "flush privileges;"
```

- Create Laravel Enviroment file
```
cd /var/www/radius
cp .env.example .env

sed -i "s\APP_URL=http://localhost\APP_URL=http://${FQDN}\g" /var/www/radius/.env
sed -i "s/DB_DATABASE=homestead/DB_DATABASE=${DBNAME}/g" /var/www/radius/.env
sed -i "s/DB_USERNAME=homestead/DB_USERNAME=${DBUSER}/g" /var/www/radius/.env
sed -i "s/DB_PASSWORD=secret/DB_PASSWORD=${DBPASS}/g" /var/www/radius/.env
```
Create UsersSeed file

```
echo "<?php" > /var/www/radius/database/seeds/UsersTableSeeder.php
echo "use Illuminate\Database\Seeder;" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "class UsersTableSeeder extends Seeder" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "{" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo " /** " >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "    * Run the database seeds." >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "    *" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "     * @return void" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "     */" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "    public function run()" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "    {" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "      DB::table('users')->insert([" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "          'name' => '${ADMINUSER}'," >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "          'email' => '${ADMINMAIL}'," >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "          'password' => bcrypt('${ADMINPASS}')," >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "          'username' => '${ADMINUSER}'," >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "      ]);" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "    }" >> /var/www/radius/database/seeds/UsersTableSeeder.php
echo "}" >> /var/www/radius/database/seeds/UsersTableSeeder.php
```
- Initialise Laravel
```
php artisan key:generate
php artisan migrate
php artisan db:seed --class=UsersTableSeeder

```
-  Set www-data user as owner of web directory
```
chown -R 33:33 /var/www/radius
```

- Copy Nginx Configuration files
```
cp contrib/nginx.conf /etc/nginx/sites-available/default
```

- Add IP addresses and secret of Your HBU's to /etc/freeradius/3.0/clients.conf
```
### Single IP
client HBU-1 {
        ipaddr          = 10.0.0.120
        secret          = secret
}
### All HBU's from range 10.0.0.1-10.255.255.254
client HBU-SUBNET {
        ipaddr          = 10.0.0.0/8
        secret          = secret
}

```
- copy User generator script to /usr/local/bin and give execute permisions

```
cp contrib/usergen.php /usr/local/bin/
chmod +x /usr/local/bin/usergen.php
####
# Set DB credentials for database
sed -i 's/$username = "homestead"/$username = "'"${DBUSER}"'"/g' /usr/local/bin/usergen.php
sed -i 's/$password = "secret"/$password = "'"${DBPASS}"'"/g' /usr/local/bin/usergen.php
sed -i 's/$dbname = "radius"/$dbname = "'"${DBNAME}"'"/g' /usr/local/bin/usergen.php
####
```
- Add Radwin dictionary file to freeradius Configuration
```
cp contrib/dictionary.radwin /usr/share/freeradius/dictionary.radwin
echo "$INCLUDE dictionary.radwin" >> /usr/share/freeradius/dictionary
```
- Now just have to add cron task to write db contents to users file and reload freeradius Configuration
```
echo "*/5 * * * *  root cd /usr/local/bin && php usergen.php > /etc/freeradius/3.0/mods-config/files/authorize && /usr/sbin/service freeradius reload" > /etc/cron.d/freeradius
```

#
## License

The WINRad is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
