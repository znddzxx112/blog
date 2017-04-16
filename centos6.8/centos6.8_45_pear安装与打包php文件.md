- 安装php的应用文件
- 主要通过php编写的应用文件
- pecl安装的是c语言编写的扩展
- pecl与pear是姐妹
- 不过这个已经被composer取代了
- 因为composer是php的包管理工具，更加好用，便捷

- pear命令安装php后就存在,放到path中
```
# ln -s ./pear /usr/local/bin/
```

- pear常用命令 - 与pecl几乎一样
```
# 官网:pear.php.net
# pear install Config-1.10.12
# pear install channel:pear.php.net/Config-1.10.12
# 安装的pear
# pear list
```

- pear install的文件位置存放查看
```
# php -i | grep include_path
# php默认回去查找的地方
# ll /usr/local/php7/lib/php/ | grep Config
drwxr-xr-x  3 root root  4096 4月  16 21:56 Config
-rw-r--r--  1 root root  8669 4月  16 21:56 Config.php

```

- 使用刚刚下载Config文件
```
<?php

require_once('Config.php');
var_dump(class_exists("Config_Container"));
$conf = new Config_Container('section', 'conf');
$conf_DB = $conf->createSection('DB');
$conf_DB->createDirective('type', 'mysql');
$conf_DB->createDirective('host', 'localhost');
$conf_DB->createDirective('user', 'root');
$conf_DB->createDirective('pass', 'root');

// set this container as our root container child in Config

$config = new Config();
$config->setRoot($conf);

// write the container to a php array
  
$config->writeConfig('/tmp/config_test.php', 'phparray',
                     array('name' => 'test'));

// // print the content of our conf section to screen
  
echo $conf->toString('phparray', array('name' => 'test'));
```
