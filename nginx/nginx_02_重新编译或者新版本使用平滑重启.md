- 参考文章
```
https://www.cnblogs.com/zhming26/p/6278667.html
```
```
找到安装nginx的源码根目录，如果没有的话下载新的源码

http://nginx.org

tar xvzf nginx-1.3.2.tar.gz

查看ngixn版本极其编译参数

/usr/local/nginx/sbin/nginx -V

进入nginx源码目录

cd nginx-1.3.2

以下是重新编译的代码和模块

./configure --prefix=/usr/local/nginx--with-http_stub_status_module --with-http_ssl_module --with-file-aio --with-http_realip_module

make 千万别make install，否则就覆盖安装了

make完之后在objs目录下就多了个nginx，这个就是新版本的程序了

备份旧的nginx程序

cp /usr/local/nginx/sbin/nginx/usr/local/nginx/sbin/nginx.bak

把新的nginx程序覆盖旧的

cp objs/nginx /usr/local/nginx/sbin/nginx

测试新的nginx程序是否正确

/usr/local/nginx/sbin/nginx -t

nginx: theconfiguration file /usr/local/nginx/conf/nginx.conf syntax is ok

nginx:configuration file /usr/local/nginx/conf/nginx.conf test issuccessful

平滑重启nginx

/usr/local/nginx/sbin/nginx -s reload

查看ngixn版本极其编译参数

/usr/local/nginx/sbin/nginx -V

这是我重新编译的代码：

./configure --prefix=/usr/local/nginx --with-google_perftools_module --user=www --group=www --with-http_stub_status_module --with-http_gzip_static_module --with-openssl=/usr/ --with-pcre=/mydata/soft/pcre-8.31
```
