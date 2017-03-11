```
# wget http://pecl.php.net/get/mongodb-1.2.5.tgz
# tar zxvf mongodb-1.2.5.tgz
# cd mongodb-1.2.5
# /usr/local/php7/bin/phpize 
#  ./configure --with-php-config=/usr/local/php7/bin/php-config 
#  make && make install
#  vim /usr/local/php7/lib/php.ini 
extension = mongodb.so
# php -m | grep mongodb
```
