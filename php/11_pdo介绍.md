- pdo驱动
```
安装mysql（pdo）
./configure --with-pdo-mysql --with-mysql-sock=/var/mysql/mysql.sock
默认使用的驱动是mysqlnd
```

- 官方核心类
```
\PDO
\PDOStatement
\PDOException
```

- 参照pdo/

- 第一步：pdo类初始化
```
pdo construct(dsn, username, password, options=array());
// options中 ATTR_EMULATE_PREPARES 本地模拟预处理 关闭(false)
```

- 第二步：语句预处理
```
PDO类
public PDOStatement prepare ( string $statement [, array $driver_options = array() ] )
```

- 第三步：查询参数化
```
PDOStatement类
bool bindValue ( mixed $parameter , mixed $value [, int $data_type = PDO::PARAM_STR ] )
```

- 获取结果集
```
PDOStatement类
select
array fetchAll ([ int $fetch_style [, mixed $fetch_argument [, array $ctor_args = array() ]]] )

insert
PDO类
string lastInsertId ([ string $name = NULL ] )

update,delete
PDOStatement类
int rowCount ( void )
```

- mysql长连接
- 参考连接：http://www.tuicool.com/articles/iUrERn2
```
PDO有长连接选项
$conn = new PDO($dsn, DB_USER, DB_PASSWORD,
    array(PDO::ATTR_PERSISTENT => true)
);
```

```
php中的mysql长连接由于php的运行方式有多种，因而长连接实现也有多种。需要web服务器支持才可以实现长连接

cli下执行php,长连接无效，cli下脚本一退出，连接即释放

apche+mod_php不开启mpm模块的话，无论mysql mysql_pconnect、pdo_mysql长连接, 页面访问完毕, mysql连接即释放。
apche+mod_php开启mpm模块(worker模式)的话，无论mysql
mysql_pconnect、pdo_mysql长连接, 页面访问完毕, mysql连接＋１，直到达到最大的mysql连接数，不在增加，但是访问页面还是可以复用连接查询到相应数据。

nginx+php-fpm下mysql长连接基本无效果。
```

```
一般小型php应用是没有性能问题的，php自身连接mysql很快，很多都处于性能过剩, 随着apache慢慢被nginx替代，php的mysql长连接也只会越来越鸡肋。单机的话，其实要是怕mysql创建connections有压力，最好把mysql的创建使用单例模式，这样一个页面只会创建一个mysql连接实例
```

```
至于非要有用mysql连接池的那种要求的，推荐使用swoole扩展实现的连接池， http://rango.swoole.com/archives/265 或者更大型点的直接使用qihoo360开源的 atlas数据库中间件， https://github.com/Qihoo360/Atlas 。都很不错。mysql长连接的话，个人感觉可以在php中尽量不用。
```

