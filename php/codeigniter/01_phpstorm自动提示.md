

##### 参考文章

> https://blog.csdn.net/zhao_liwei/article/details/52337044

##### 克隆项目

```bash
$ git clone https://github.com/topdown/phpStorm-CC-Helpers.git
```

##### 查看codeigniter框架版本

> CodeIgniter.php文件中 const CI_VERSION = ‘版本’

下面以CI框架3.1为例子，我是用PhpStorm版本是2019.3 其他版本的PS应当也同样使用，因为此方法是改变PhpStorm的解析来源

##### 项目的External Libraries上右键->Configure PHP Include Path

![v1](C:\Users\86188\workspace\znddzxx112\blog\php\codeigniter\v1.jpg)

加入phpStorm-CC-Helpers/Codeigniter3文件夹

##### 选中CI框架下3个文件->右键->Mark as Plain Text（标记为纯文本）

core/Controller.php,core/Model.php,database/DB_query_builder.php

##### 增加注释

- 打开phpStorm-CC-Helpers/Codeigniter3/my_models.php文件补充注释。比如

> @property UserModel $UserModel
>
> @property UserService $UserService

- 打开文件app/core/MY_Service.php文件添加同样注释

##### 结语

至此，在services和controllers文件夹下写代码能自动提示补充方法名称了。减少拼写错误，提高些开发效率。

这种方法改变了PS解析的来源，通过添加注释的方法获得框架相关的自动提示。只要你添加到my_model.php和MY_Service.php的注释区会有自动提示。

