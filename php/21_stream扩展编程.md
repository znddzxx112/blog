stream - 是php的基本扩展之一
```
主要用于socket编程：多台主机（同一台主机）进程通信。
主机间通信，ip，端口，都是数据流的方式。
要读懂数据流，就是流的包装器，一般叫协议。流的包装器有file，http，ftp。
fopen系列函数，可以操作流。
```
- 重要东西：扩展中包含了哪些东西
```
1. streamWrapper - 流的包装器，自定义的流类型参照类
2. Stream 函数 - 流的函数[重要]
3. php_user_filter 类 - 流的过滤器父类
```
- 流的过滤器
```
 流的过滤器。多个过滤器可以叠加在同一个流上。可通过stream_filter_register() 增加自定义过滤器。
可通过stream_get_filters()获取内置定义的过滤器。
```
```
stream_context - 流的上下文。上下文就是参数和包装器。用来修改流的修改或增加流的行为。可通过stream_context_create() 创建流的上下文。
 stream_context_set_option() 可设置流的选项 - 特殊的选项
stream_context_set_params() 可设置流的参数 - 通用的选项
// 在流上增加过滤器
  ● stream_filter_append — Attach a filter to a stream
  ● stream_filter_prepend — Attach a filter to a stream
  ● stream_filter_register — Register a user defined stream filter
  ● stream_filter_remove — 从资源流里移除某个过滤器
  ● stream_get_filters — 获取已注册的数据流过滤器列表
Array
(
    [0] => convert.iconv.*
    [1] => string.rot13
    [2] => string.toupper
    [3] => string.tolower
    [4] => string.strip_tags
    [5] => convert.*
    [6] => consumed
    [7] => dechunk
    [8] => mcrypt.*
    [9] => mdecrypt.*
)
```

- Stream 函数 - 流的函数
```
$context = stream_context_create(); // 创建一个流的上下文
  ● stream_context_set_params — Set parameters for a stream/wrapper/context
  ● stream_context_get_params — Retrieves parameters from a context
  ● stream_encoding — 设置数据流的字符集
  ● stream_set_blocking — 为资源流设置阻塞或者阻塞模式
```

- socket编程
```
stream_socket_client - 启动一个流或数据连接到指定的目的地remote_socket。
// 可以是互联网域名：端口或者文件系统的socket file
stream_socket_server - 创建socket的服务端 绑定和监听都做了 - 创建的是一个全双工
stream_socket_accept - 接受由 stream_socket_server 创建的套接字连接，返回一个流
stream_socket_enable_crypto - 传输的数据是否加密，以及加密类型
stream_socket_get_name  -  获取本地或者远程的套接字名称
stream_socket_pair - 创建一对完全一样的网络套接字连接流,这个函数通常会被用在进程间通信(Inter-Process Communication)
stream_socket_shutdown - 可以关闭，socket的读或者写

// 流类型 ：常见的流类型，都可以使用fopen系列函数操纵流
  ● file:// — 访问本地文件系统
  ● http:// — 访问 HTTP(s) 网址
  ● ftp:// — 访问 FTP(s) URLs
  ● php:// — 访问各个输入/输出流（I/O streams）
  ● zlib:// — 压缩流
  ● data:// — 数据（RFC 2397）
  ● glob:// — 查找匹配的文件路径模式
  ● phar:// — PHP 归档
  ● ssh2:// — Secure Shell 2
  ● rar:// — RAR
  ● ogg:// — 音频流
  ● expect:// — 处理交互式的流
streamWrapper - 自定义流类型的参照类，注意不是接口也无需继承

// 从流上读数据到字符串
  ● stream_get_contents — 读取资源流到一个字符串
  ● stream_get_filters — 获取已注册的数据流过滤器列表
  ● stream_get_line — 从资源流里读取一行直到给定的定界符
  ● stream_get_meta_data — 从封装协议文件指针中取得报头／元数据
  ● stream_get_transports — 获取已注册的套接字传输协议列表
  ● stream_get_wrappers — 获取已注册的流类型
 ```
 
 - socket编程客户端
 ```
 <?php

/**
*	stream流扩展
*/
/* 自定义过滤器 */
class strtolower_filter extends php_user_filter {
  function filter($in, $out, &$consumed, $closing)
  {
    while ($bucket = stream_bucket_make_writeable($in)) {
      $bucket->data = strtolower($bucket->data);
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }
    return PSFS_PASS_ON;
  }
}

$sock = stream_socket_client("tcp://127.0.0.1:7867", $errno, $errstr);
// 设置流模式 1:阻塞 0:非阻塞
// 该参数的设置将会影响到像 fgets() 和 fread() 这样的函数从资源流里读取数据。
// 在非阻塞模式下，调用 fgets() 总是会立即返回；而在阻塞模式下，将会一直等到从资源流里面获取到数据才能返回。
stream_set_blocking($sock, 1);
// print_r(stream_context_get_options($sock));
// stream_encoding($sock, 'UTF-8');
if ($errno) {
	echo $errstr;
} else {
	$param = array("GET / HTTP/1.0", "Host: www.test.com", "Accept: text/html,*/*");
	$paramStr = implode("\r\n", $param)."\r\n\r\n";
	fwrite($sock, $paramStr);
	// fwrite($sock, "GET / HTTP/1.0\r\nHost: www.test.com\r\nAccept: text/html,*/*\r\n\r\n");

	// print_r(stream_get_filters()); // 查看系统默认的过滤器
	//stream_filter_append($sock, "string.toupper");// 设置内置的过滤器
	stream_filter_register("strtolower", "strtolower_filter");
	stream_filter_append($sock, "strtolower");// 设置自定义的过滤器

	// 等同于fgets，但可设定界限符,读1024，遇到"\r\n",哪个先遇到就结束读取
	echo stream_get_line($sock, 1024, "\r\n");
	// $line = '';
	// while (!feof($sock)) {
	// 	$line .= fgets($sock, 10);
	// }
	// echo $line;

	fclose($sock);
}
 ```
 
 - socket 服务端
 ```
 <?php

$server  = stream_socket_server("tcp://127.0.0.1:7867", $errno, $errstr);
if ($errno) {
	echo $errstr;
	exit;
}
while(1) {
	if(is_resource($a=stream_socket_accept($server))){
      	# do something
	  	// TRUE ，那么将返回 remote 套接字连接名称；
	  	$socketname = stream_socket_get_name($a, true);
	  	// 如果设置为 FALSE 则返回 local 套接字连接名称
      	// fwrite($a,"Regards form Berlin {$socketname}\n");
		/* Get the exact same packet again, but remove it from the buffer this time. */
		// fwrite($a, "Data: '" . stream_socket_recvfrom($a, 1500));
		stream_socket_sendto($a, "heooo\r\nsocket\r\n");
      	fclose($a);
   }
}
fcloset($server);
 
 ```
