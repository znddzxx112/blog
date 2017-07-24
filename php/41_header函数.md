- header必须写在最前面
```
原因是：PHP脚本开始执行 时,它可以同时发送http消息头部(标题)信息和主体信息. http消息头部(来自 header() 或 SetCookie() 函数)并不会立即发送,相反,它被保存到一个列表中. 这样就可以允许你修改标题信息,包括缺省的标题(例如 Content-Type 标题）.但是,一旦脚本发送了任何非标题的输出（例如,使用 HTML 或 print() 调用),那么PHP就必须先发送完所有的Header,然后终止 HTTP header.而后继续发送主体数据.从这时开始,任何添加或修改Header信息的试图都是不允许的,并会发送上述的错误消息之一。

解决办法：

修改php.ini打开缓存(output_buffering),或者在程序中使用缓存函数ob_start()，ob_end_flush()等。原理是：output_buffering被启用时,在脚本发送输出时，PHP并不发送HTTP header。相反，它将此输出通过管道（pipe）输入到动态增加的缓存中（只能在PHP 4.0中使用，它具有中央化的输出机制）。你仍然可以修改/添加header，或者设置cookie，因为header实际上并没有发送。当全部脚本终止时，PHP将自动发送HTTP header到浏览器，然后再发送输出缓冲中的内容。

```

- 在返回头部显示
```
// 三种主要表现形式
header(”http/1.1 404 Not Found”);
header('Location: http://www.example.org/');
header('hit cache: true');
```

- 更多实例
```
// ok
header('HTTP/1.1 200 OK');

//设置一个404头:
header('HTTP/1.1 404 Not Found');

//设置地址被永久的重定向
header('HTTP/1.1 301 Moved Permanently');

//转到一个新地址
header('Location: http://www.example.org/');

//文件延迟转向:
header('Refresh: 10; url=http://www.example.org/');
print 'You will be redirected in 10 seconds';

//当然，也可以使用html语法实现
// <meta http-equiv="refresh" content="10;http://www.example.org/ />

// override X-Powered-By: PHP:
header('X-Powered-By: PHP/4.4.0');
header('X-Powered-By: Brain/0.6b');

//文档语言
header('Content-language: en');

//告诉浏览器最后一次修改时间
$time = time() - 60; // or filemtime($fn), etc
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).' GMT');

//告诉浏览器文档内容没有发生改变
header('HTTP/1.1 304 Not Modified');

//设置内容长度
header('Content-Length: 1234');

//设置为一个下载类型
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="example.zip"'); 
header('Content-Transfer-Encoding: binary');
// load the file to send:
readfile('example.zip');

// 对当前文档禁用缓存
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Pragma: no-cache');

//设置内容类型:
header('Content-Type: text/html; charset=iso-8859-1');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/plain'); //纯文本格式
header('Content-Type: image/jpeg'); //JPG图片
header('Content-Type: application/zip'); // ZIP文件
header('Content-Type: application/pdf'); // PDF文件
header('Content-Type: audio/mpeg'); // 音频文件
header('Content-Type: application/x-shockwave-flash'); //Flash动画

//显示登陆对话框
header('HTTP/1.1 401 Unauthorized');
header('WWW-Authenticate: Basic realm="Top Secret"');
print 'Text that will be displayed if the user hits cancel or ';
print 'enters wrong login data';
```
