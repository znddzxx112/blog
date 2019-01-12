 - ngx_http_core_module
```
指令：
root
alias
listen
location
error_page
server_name
server
变量：
$document_root
$args set $args fid=$1&$args
$request_uri
ngx_http_access_module
只有二个指令 allow 和 deny
location / {
	deny  192.168.1.1;
    allow 192.168.1.0/24;
	allow 10.1.1.0/16;
	allow 2001:0db8::/32;
	deny  all;
}
```