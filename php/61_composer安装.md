- composer中文文档
```
https://laravel-china.org/docs/composer/2018
```

- 安装php
```
# curl -sSL -o php-7.1.20.tar.gz http://cn2.php.net/get/php-7.1.20.tar.gz/from/this/mirror
# tar -zxvf php-7.1.20.tar.gz
# cd php-7.1.20
# ./configure --prefix=/usr/local/php71 -enable-fpm --with-openssl --with-zlib --enable-mbstring  --with-curl=/usr/bin/ --enable-opcache
# make && make install
# cp /usr/local/src/php-7.1.0/php.ini-production /usr/local/php7/etc/php.ini
```

- 安装composer
```
# php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# curl -sSL -o composer-setup.php https://getcomposer.org/installer // 可替代上面命令

# php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# php composer-setup.php --install-dir=/usr/local/bin --filename=composer
# php -r "unlink('composer-setup.php');"
```

- php软链
```
# ln -s /usr/local/php71/bin/php /usr/local/bin/
```
