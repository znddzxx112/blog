 - 参考文章：
 - https://segmentfault.com/a/1190000000380008
 
```
FIG制定的PHP规范，简称PSR，是PHP开发的事实标准。
PSR-0 自动加载
PSR-1 基本代码规范
PSR-2 代码样式
PSR-3 日志接口
PSR-4 自动加载，PSR-0的升级版
```

- psr-0 与 psr-4区别
```
PSR-4规范了如何指定文件路径从而自动加载类定义，同时规范了自动加载文件的位置。
这个乍一看和PSR-0重复了，实际上，在功能上确实有所重复。区别在于PSR-4的规范比较干净，去除了兼容PHP 5.3以前版本的内容，有一点PSR-0升级版的感觉。
当然，PSR-4也不是要完全替代PSR-0，而是在必要的时候补充PSR-0——当然，如果你愿意，PSR-4也可以替代PSR-0。PSR-4可以和包括PSR-0在内的其他自动加载机制共同使用。

PSR-4和PSR-0最大的区别是对下划线（underscore)的定义不同。PSR-4中，在类名中使用下划线没有任何特殊含义。而PSR-0则规定类名中的下划线_会被转化成目录分隔符。
```

- psr-0 与 psr-4实现方式
```
psr-0 将命名空间转化为路径名的一部分，类名带有下划线，展示为文件目录。再去加载文件
psr-4 维护 命名空间与文件路径 对应关系。
好处：psr-4 更加简洁
```

- 自动加载基础 - spl_autoload_register()
```
new Class();当找不到类的时候，先去找autoload函数列表，根据列表注册的函数，尝试加载类所在文件。
spl_autoload_register() 默认往autoload函数列表增加 处理函数
```

- 加载相对路径文件
```
require 'light/load.php';
require / include 使用相对路径时，php通过从php默认搜索路径中找
获取当前默认搜索路径 get_include_path()
设置默认搜索路径
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            PROJECT_PATH . '/library',
            get_include_path()
        )
    )
);

```
