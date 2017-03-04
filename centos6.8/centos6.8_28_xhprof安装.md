- 文章参考：https://laravel-china.org/topics/3142
- http://blog.oneapm.com/apm-tech/219.html

- 安装扩展
- http://pecl.php.net/package/xhprof
```
php5.4及以上版本不能在pecl中下载，不支持。
需要在github上下载hhttps://github.com/phacility/xhprof.git。
另外xhprof已经很久没有更新过了，截至目前还不支持php7，
php7可以试使用https://github.com/tideways/php-profiler-extension。
php7推荐使用这个：https://github.com/Yaoguais/phpng-xhprof ./xhprof
```

```
# git clone https://github.com/Yaoguais/phpng-xhprof ./xhprof
#cd xhprof
#/Library/WebServer/php-5.4/bin/phpize
#./configure --with-php-config=/usr/local/php7/bin/php-config 
#make && make install

```

- 复制php.ini
```
cp /usr/local/src/php-7.1.0/php.ini-production /usr/local/php7/lib/php.ini
```

- php.ini写配置
```
[xhprof]
extension = phpng_xhprof.so
xhprof.outpout_dir = /tmp/xhprof
```

- 重启php-fpm
```
# kill -USR2 `cat /usr/local/php7/var/run/php-fpm.pid`
```

- 检验xhprof

```
php --ri xhprof
```

- 执行脚本增加代码
```
xhprof_enable();
// your code
// ...
file_put_contents((ini_get('xhprof.output_dir') ? : '/tmp') . '/' . uniqid() . '.xhprof.xhprof', serialize(xhprof_disable()));
```

- 优雅接入项目中（使用xhgui跳过这些）

```
/data/www/xhprof/inject.php
<?php
//开启xhprof
xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU);

//在程序结束后收集数据
register_shutdown_function(function() {
    $xhprof_data        = xhprof_disable();

    //让数据收集程序在后台运行
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }

    //保存xhprof数据
    ...
});

修改php配置文件中的auto_prepend_file配置
auto_prepend_file = /data/www/xhprof/inject.php
nginx服务器配置加上
fastcgi_param PHP_VALUE "auto_prepend_file=/data/www/xhprof/inject.php";
```

- 安装xhgui
- 安装composer
- 需要先安装libmcrypt
- 安装mcrypt扩展
- 安装mongodb
- 安装mongodb扩展

- 下载 xhgui
```
# cd /var/www/
# git clone github.com/xhui.git
# composer install
```

- 在nginx中配置指向xhgui/webroot中
```
fastcgi_param  PHP_VALUE "auto_prepend_file=/var/www/xhgui/external/header.php";
```
- 在php.ini 增加（与上面的方法选其中之一即可）
```
vim /usr/local/php7/lib/php.ini
auto_prepend_file = /var/www/xhgui/external/header.php
```

- 需要编辑一下代码
```
#vim xhgui/external/header.php
// 注释这块代码
if (!Xhgui_Config::shouldRun()) {
    return;
}
```
