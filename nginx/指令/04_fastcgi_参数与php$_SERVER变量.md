- http://nginx.org/en/docs/http/ngx_http_fastcgi_module.html
- 属于nginx中nginx_http_fastcgi模块


- fastcgi_index
```
摘自官方的解释：fastcgi_index  
语法：fastcgi_index file 默认值：none 使用字段：http, server, location  如果URI以斜线结尾，文件名将追加到URI后面，这个值将存储在变量$fastcgi_script_name中。
例如：fastcgi_index  index.php;fastcgi_param  SCRIPT_FILENAME  /home/www/scripts/php$fastcgi_script_name;
请求"/page.php"的参数SCRIPT_FILENAME将被设置为"/home/www/scripts/php/page.php"，
但是"/"为"/home/www/scripts/php/index.php"。


```

- fastcgi_pass
```
语法：fastcgi_pass fastcgi-server 
默认值：none 
使用字段：http, server, location 
指定FastCGI服务器监听端口与地址，可以是本机或者其它：

fastcgi_pass   localhost:9000;
使用Unix socket:

fastcgi_pass   unix:/tmp/fastcgi.socket;
同样可以使用一个upstream字段名称：

upstream backend  {
  server   localhost:1234;
}
 
fastcgi_pass   backend;
```

- fastcgi_param
```
fastcgi_param directives to set parameters passed to a FastCGI server

Syntax:	fastcgi_param parameter value [if_not_empty];
Default:	—
Context:	http, server, location

Sets a parameter that should be passed to the FastCGI server. The value can contain text, variables, and their combination. These directives are inherited from the previous level if and only if there are no fastcgi_param directives defined on the current level.
```

- 同样可以使用fastcgi_param自定义变量，向fastcgi服务器（php-fpm）传值

```
"http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; 
```


```
SERVER["HTTP_ACCEPT"]=*/* 
$_SERVER["HTTP_REFERER"]=http://localhost/lianxi/ 
$_SERVER["HTTP_ACCEPT_LANGUAGE"]=zh-cn 
$_SERVER["HTTP_ACCEPT_ENCODING"]=gzip, deflate 
$_SERVER["HTTP_USER_AGENT"]=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727) 
$_SERVER["HTTP_HOST"]=localhost 
$_SERVER["HTTP_CONNECTION"]=Keep-Alive 
$_SERVER["PATH"]=C:\WINDOWS\system32;C:\WINDOWS;C:\WINDOWS\System32\Wbem;C:\Program Files\Common Files\Adobe\AGL;C:\Program Files\MySQL\MySQL Server 5.0\bin;C:\php;C:\php\ext 
$_SERVER["SystemRoot"]=C:\WINDOWS 
$_SERVER["COMSPEC"]=C:\WINDOWS\system32\cmd.exe 
$_SERVER["PATHEXT"]=.COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH 
$_SERVER["WINDIR"]=C:\WINDOWS 
$_SERVER["SERVER_SIGNATURE"]= 
Apache/2.0.55 (Win32) PHP/5.1.1 Server at localhost Port 80 \\使用的何服务器 
$_SERVER["SERVER_SOFTWARE"]=Apache/2.0.55 (Win32) PHP/5.1.1 
$_SERVER["SERVER_NAME"]=localhost \\服务器名称 
$_SERVER["SERVER_ADDR"]=127.0.0.1 
$_SERVER["SERVER_PORT"]=80 \\服务器端口 
$_SERVER["REMOTE_ADDR"]=127.0.0.1 
$_SERVER["DOCUMENT_ROOT"]=D:/lianxi \\网站的主目录 
$_SERVER["SERVER_ADMIN"]=sss@163.com \\安装APACHE时设置的邮箱 
$_SERVER["SCRIPT_FILENAME"]=D:/lianxi/lianxi/servervalues.php \\当前的网页的绝对路径， 
$_SERVER["REMOTE_PORT"]=1076 \\远程端口 
$_SERVER["GATEWAY_INTERFACE"]=CGI/1.1 
$_SERVER["SERVER_PROTOCOL"]=HTTP/1.1 
$_SERVER["REQUEST_METHOD"]=GET 
$_SERVER["QUERY_STRING"]=\\获取？号后面的内容 
$_SERVER["REQUEST_URI"]=例子：/lianxi/servervalues.php?a=1&b=2 
$_SERVER["SCRIPT_NAME"]=例子：/lianxi/servervalues.php 
$_SERVER["PHP_SELF"]=/lianxi/servervalues.php \\返回当前网页的相对路径. 
$_SERVER["REQUEST_TIME"]=1179190013 \\运行时间 单位为十万分之一毫秒 
$_SERVER["argv"]=Array 
$_SERVER["argc"]=0 
说明：返回此结果运行的网站的主目录是D:/lianxi 
<?php 
foreach($_SERVER as $asd =>$values) 
{ 
echo("\$_SERVER[\"$asd\"]=".$values."</p>"); 
} 

$_SERVER存储当前服务器信息，其中有几个值 如$_SERVER["QUERY_STRING"]，$_SERVER["REQUEST_URI"]，$_SERVER["SCRIPT_NAME"] 和$_SERVER["PHP_SELF"]常常容易混淆，以下通过实例详解$_SERVER函数中 QUERY_STRING，REQUEST_URI，SCRIPT_NAME和PHP_SELF变量区别，掌握这四者之间的关系，便于在实际应用中正确获 取所需要的值，供参考。 



1，$_SERVER["QUERY_STRING"] 
说明：查询(query)的字符串 

2，$_SERVER["REQUEST_URI"] 
说明：访问此页面所需的URI 

3，$_SERVER["SCRIPT_NAME"] 
说明：包含当前脚本的路径 

4，$_SERVER["PHP_SELF"] 
说明：当前正在执行脚本的文件名 

实例： 
1，http://www.biuuu.com/ (直接打开主页) 
结果： 
$_SERVER["QUERY_STRING"] = “” 
$_SERVER["REQUEST_URI"] = “/” 
$_SERVER["SCRIPT_NAME"] = “/index.php” 
$_SERVER["PHP_SELF"] = “/index.php” 

2，http://www.biuuu.com/?p=222 (附带查询) 
结果： 
$_SERVER["QUERY_STRING"] = “p=222″ 
$_SERVER["REQUEST_URI"] = “/?p=222″ 
$_SERVER["SCRIPT_NAME"] = “/index.php” 
$_SERVER["PHP_SELF"] = “/index.php” 

3，http://www.biuuu.com/index.php?p=222&q=biuuu 
结果： 
$_SERVER["QUERY_STRING"] = “p=222&q=biuuu” 
$_SERVER["REQUEST_URI"] = “/index.php?p=222&q=biuuu” 
$_SERVER["SCRIPT_NAME"] = “/index.php” 
$_SERVER["PHP_SELF"] = “/index.php” 

$_SERVER["QUERY_STRING"]获取查询语句，实例中可知，获取的是?后面的值 
$_SERVER["REQUEST_URI"] 获取http://www.biuuu.com后面的值，包括/ 
$_SERVER["SCRIPT_NAME"] 获取当前脚本的路径，如：index.php 
$_SERVER["PHP_SELF"] 当前正在执行脚本的文件名 

```
