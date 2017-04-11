```
参考文章:http://www.jb51.net/article/48150.htm
参考文章：http://www.cnblogs.com/yjf512/p/3588466.html

php 4.0 2000年5月

php5.0 2004年7月
使用了Zend 2 引擎。
增加了新关键字，包括this,try,catch,public,private,protected等
strrpos() 和 strripos() 如今使用整个字符串作为 needle。

php 5.1 
重写了数据处理部分的代码
pdo扩展默认启动
性能优化
超过30个新函数
超过400个bug修复

php 5.2 2006-2011

spl_autoload_register()
json_encode() json_decode()

php 5.3 2009-2012
闭包函数功能
array_walk($array,function(&$v){}) : 数组的每一项作为一个闭包函数的输入
__invoke() 类作为函数时被调用
__callStatic() 不存在的静态方法会被调用
命名空间 类，函数，常量受影响
注意:命名空间与autoload一起使用
spl_autoload_register(
    function ($class) {
        spl_autoload(str_replace("\\", "/", $class));
    }
);
static 关键字指代 后期类 与self相对应
heredoc <<<EOF EOF;
nowdoc 不能引入变量 ，加引号
const 定义常量 以往define("xxoo",value);
phar 支持将php文件归档，类似于jar

php5.4 2012-2013
支持<?= ?>
数组简写["key"=>"value"]
traits 支持构件，解决多重继承，构件可以包含构件
// Traits不能被单独实例化，只能被类所包含
trait SayWorld
{
    public function sayHello()
    {
        echo 'World!';
    }
}
class MyHelloWorld
{
    // 将SayWorld中的成员包含进来
    use SayWorld;
}
$xxoo = new MyHelloWorld();
// sayHello() 函数是来自 SayWorld 构件的
$xxoo->sayHello();
内置web服务器 php -S localhost:8000 index.php

php5.5 2013起
yield 关键字
可用 MyClass::class 取到一个类的完整限定名(包括命名空间)。
try-catch 结构新增 finally 块。

php5.6
常量可以作为函数默认值
增加 func_get_args() ...$args

```
