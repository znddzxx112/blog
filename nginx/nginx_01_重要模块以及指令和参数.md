 nginx 重要的模块以及指令和参数
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
- ngx_http_fastcgi_module
```
指令：
fastcgi_index 设置fastcgi优先读取文件名称
fastcgi_param 设置fastcgi变量
 fastcgi_pass 转发给fastcgi服务器
fastcgi_cache fastcgi缓存
fastcgi_temp_path 存储来自fastcgi的缓存文件目录
变量：
$fastcgi_script_name 等于指令fastcgi_index的值
```
- ngx_http_rewrite_module
```
指令：
if
break
return
rewrite regex replacement last|break|redirect|permanent
redirect 返回301，地址栏跳转
permanent 返回302，地址栏跳转
set $var value
```
