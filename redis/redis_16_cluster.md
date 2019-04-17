```
https://redis.io/topics/cluster-tutorial

wget "http://download.redis.io/releases/redis-5.0.4.tar.gz"
make && make install


303  mkdir /data2/redis_cluster
  304  mkdir -p /data2/redis_cluster/7000
  305  mkdir -p /data2/redis_cluster/7001
  306  mkdir -p /data2/redis_cluster/7002
  315  cp src/redis-trib.rb /usr/local/bin/
  316  cp redis.conf /data2/redis_cluster/7000/
  317  cp redis.conf /data2/redis_cluster/7001/
  318  cp redis.conf /data2/redis_cluster/7002/
  307  cd /data2/redis_cluster/
  308  vim 7000/redis.conf 
  309  vim 7001/redis.conf 
  310  vim 7002/redis.conf 

port  7000                                        //端口7000,7002,7003        
bind 本机ip                                       //默认ip为127.0.0.1 需要改为其他节点机器可访问的ip 否则创建集群时无法访问对应的端口，无法创建集群
daemonize    yes                               //redis后台运行
pidfile  /var/run/redis_7000.pid          //pidfile文件对应7000,7001,7002
cluster-enabled  yes                           //开启集群  把注释#去掉
cluster-config-file  nodes_7000.conf   //集群的配置  配置文件首次启动自动生成 7000,7001,7002
cluster-node-timeout  15000                //请求超时  默认15秒，可自行设置
appendonly  yes                           //aof日志开启  有需要就开启，它会每次写操作都记录一条日志　
dir /data2/redis_cluster/7000


  340  redis-server 7000/redis.conf 
339  redis-server 7001/redis.conf 
  340  redis-server 7002/redis.conf 


https://blog.51cto.com/8370646/2309693
https://www.cnblogs.com/wuxl360/p/5920330.html
  redis-cli --cluster create 127.0.0.1:7000 127.0.0.1:7001 127.0.0.1:7002
  redis-cli -p 7001 -c

```
