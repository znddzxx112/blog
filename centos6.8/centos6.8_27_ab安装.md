```
yum -y install httpd-tools

ab运行需要依赖apr-util包，安装命令为：

yum install apr-util

下载apache的rpm包，可以直接去官网手动下载，当然也可以使用命令yumdownloader来完成，yumdownloader是yum-utils包下面的，如果没有安装yum-utils，则需要先安装它。因为解压apache的rpm包时会在当前目录下生成etc、var和usr三个目录，所以建议先创建一个临时目录，命令如下：

mkdir /ab
cd /ab

yum -y install yum-utils
yumdownloader httpd-tools
rpm2cpio httpd-*.rpm | cpio -idmv

上述命令成功后，可以在~/abtmp下的usr/bin中看到一个名为ab的文件，复制到系统PATH下就大功告成，例如。

cp /ab/usr/bin/ab /usr/bin
rm -fr /ab

```

- ab教程
```
cd /usr/bin
  .\ab -n1000 -c10 http://localhost/index.PHP

下面开始解析这条命令语句：启动ab，并出入三个参数（ .\ab -n1000 -c10 http://localhost/index.php ）

-n1000 表示请求总数为1000

-c10 表示并发用户数为10

http://localhost/index.php 表示这写请求的目标URL

增加cookies
多个 -C 参数即可
ab -C cookie_name1=cookie_value1 -C cookie_name2=cookie_value2 ...

或者可以用 -H 参数实现
ab -H "Cookie: cookie_name1=cookie_value1;cookie_name2=cookie_value2;"

测试结果也一目了然，测试出的吞吐率为：Requests per second: 2015.93 [#/sec] (mean)  初次之外还有其他一些信息。

Server Software 表示被测试的Web服务器软件名称

Server Hostname 表示请求的URL主机名

Server Port 表示被测试的Web服务器软件的监听端口

Document Path 表示请求的URL中的根绝对路径，通过该文件的后缀名，我们一般可以了解该请求的类型

Document Length 表示HTTP响应数据的正文长度

Concurrency Level 表示并发用户数，这是我们设置的参数之一

Time taken for tests 表示所有这些请求被处理完成所花费的总时间

Complete requests 表示总请求数量，这是我们设置的参数之一

Failed requests 表示失败的请求数量，这里的失败是指请求在连接服务器、发送数据等环节发生异常，以及无响应后超时的情况。如果接收到的HTTP响应数据的头信息中含有2XX以外的状态码，则会在测试结果中显示另一个名为       “Non-2xx responses”的统计项，用于统计这部分请求数，这些请求并不算在失败的请求中。

Total transferred 表示所有请求的响应数据长度总和，包括每个HTTP响应数据的头信息和正文数据的长度。注意这里不包括HTTP请求数据的长度，仅仅为web服务器流向用户PC的应用层数据总长度。

HTML transferred 表示所有请求的响应数据中正文数据的总和，也就是减去了Total transferred中HTTP响应数据中的头信息的长度。

Requests per second 吞吐率，计算公式：Complete requests / Time taken for tests

Time per request 用户平均请求等待时间，计算公式：Time token for tests/（Complete requests/Concurrency Level）

Time per requet(across all concurrent request) 服务器平均请求等待时间，计算公式：Time taken for tests/Complete requests，正好是吞吐率的倒数。也可以这么统计：Time per request/Concurrency Level

Transfer rate 表示这些请求在单位时间内从服务器获取的数据长度，计算公式：Total trnasferred/ Time taken for tests，这个统计很好的说明服务器的处理能力达到极限时，其出口宽带的需求量。

Percentage of requests served within a certain time（ms） 这部分数据用于描述每个请求处理时间的分布情况，比如以上测试，80%的请求处理时间都不超过6ms，这个处理时间是指前面的Time per request，即对于单个用户而言，平均每个请求的处理时间。

```

- 压测结果
```
[root@centos6x8-lnmp ~]# ab -n100 -c10 http://127.0.0.1/
This is ApacheBench, Version 2.3 <$Revision: 655654 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 127.0.0.1 (be patient).....done


Server Software:        nginx/1.10.2
Server Hostname:        127.0.0.1
Server Port:            80

Document Path:          /
Document Length:        612 bytes

Concurrency Level:      10
Time taken for tests:   0.234 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      84500 bytes
HTML transferred:       61200 bytes
Requests per second:    427.97 [#/sec] (mean)
Time per request:       23.366 [ms] (mean)
Time per request:       2.337 [ms] (mean, across all concurrent requests)
Transfer rate:          353.16 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   8.9      0      90
Processing:     1   13  16.1      2      47
Waiting:        0   12  15.6      1      46
Total:          1   14  19.0      2     115

Percentage of the requests served within a certain time (ms)
  50%      2
  66%     12
  75%     30
  80%     31
  90%     47
  95%     47
  98%     47
  99%    115
 100%    115 (longest request)
```
