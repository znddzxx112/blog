- phpcurl:http://php.net/manual/zh/book.curl.php

- 简介
```
PHP 支持 Daniel Stenberg 创建的 libcurl 库，能够连接通讯各种服务器、使用各种协议。libcurl 目前支持的协议有 http、https、ftp、gopher、telnet、dict、file、ldap。 libcurl 同时支持 HTTPS 证书、HTTP POST、HTTP PUT、 FTP 上传(也能通过 PHP 的 FTP 扩展完成)、HTTP 基于表单的上传、代理、cookies、用户名+密码的认证。
```

- 参数配置：http://php.net/manual/zh/function.curl-setopt.php

- 步骤大体如下
```
初始化句柄
设置句柄参数，包括请求地址
执行句柄
判断结果是否正确
返回执行结果
```

- 实例信任ssl证书
```
$ch = curl_init($url);
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_USERAGENT => $useragent,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => 0,//证书中的域名不设置，0不验证
            CURLOPT_SSL_VERIFYPEER => FALSE,//信任任何证书
        )
    );
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    $result = curl_exec($ch);
    if (false === $result) {
        $error = curl_error($ch);
    }
    curl_close($ch);
    return $result;
```
