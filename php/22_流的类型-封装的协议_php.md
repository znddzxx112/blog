- php:// — 访问各个输入/输出流（I/O streams）


```
PHP 提供了一些杂项输入/输出（IO）流，允许访问 PHP 的输入输出流、标准输入输出和错误描述符， 内存中、磁盘备份的临时文件流以及可以操作其他读取写入文件资源的过滤器。
```

- 从协议中获取数据
```
方式一
$fp = fopen("php://input")
$content = fread($fp, 2014)
$content = stream_get_content($fp)

方式二
$content = file_get_content("php://input")

```

- php://input
```
$fp = fopen("php://input", "r");
$line = fread($fp, 1024);
fclose($fp);
var_dump($line); // http正文内容是啥就是啥
var_dump($_POST);// http正文内容foo=bar&foo1=bar2 转化成POST
```

- php://stdin
```
标准输入来自键盘
$fp = fopen("php://stdin", "r");
while(false != ($line = fgets($fp))) {
	echo $line;// echo往管道中输入，标准输出
	if (trim($line,"\n") == 'EOF') {
		break;
	}
}
fclose($fp);
```

- php://stdout
```
标准输出 屏幕
$fp = fopen("php://stdout", "w");
fwrite($fp, "hellos stdout\n");
fwrite($fp, "\twhere are you\n");
fwrite($fp, "please join me\n");
fclose($fp);
```

- php://memory
```
// 内存中写数据
$fp = fopen("php://memory", "r+");
fwrite($fp, "hello memory");
fwrite($fp, "2hello memory");
rewind($fp);
$content = fread($fp, 1024);
var_dump($content);
fclose($fp);
```

- php://temp
```
// 写入文件
$fp = fopen("php://temp", "r+");
fwrite($fp, "hello temp");
rewind($fp);
var_dump(fread($fp, 1024));
fclose($fp);
```
