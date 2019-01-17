```
tcpdump分析tcp三次握手过程
参考文章：https://blog.csdn.net/kofandlizi/article/details/8106841

1.选定端口：tcpdump port 80
2.选定二台机器之间： tcpdump 'port 80 and host 10.10.80.214'
3. 选定协议：tcpdump tcp
4. 常用命令：sudo tcpdump 'port 80 and host 10.10.80.214' -n -s 0 -w '/tmp/tcp.cap'
```
