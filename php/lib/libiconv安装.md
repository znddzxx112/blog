```
// 源码包安装libiconv
# cd /usr/local/src && \
wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.14.tar.gz && \
tar zxvf libiconv-1.14.tar.gz && \
cd libiconv-1.14/ && \
./configure --prefix=/usr/local/libiconv && \
make && make install
```
