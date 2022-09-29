 - percona-toolkit 得到top N sql
 ```
pt-query-digest --user=/xxxx/mysql-slow.log > /tmp/slow.txt
优化原则：二八原则，优化掉占80%的语句即可让服务器性能大增
 ```
 
 - 修改排序内存,效果不明显
 ```
 查看数据库表记录，mysql从获取数据，排序，给出数据，发现这条sql的时间花在了排序上。
 修改排序内存：set session sort_buffer_size=96*1024*1024;
 换言之，数据库优化余地不大。
 优化方案：在应用端做缓存。
 ```
 
 - 字段内容多，返回数据量大
 ```
 每行超过6K，每次返回12G，每次执行对数据库，网络带宽压力都很大，执行的快慢取决于硬盘读写能力和网络带宽传输能力。
 优化策略：应用缓存+增量更新+只返回要用到的字段。
 ```

- MySQL插入数据很慢优化
一开始几百条记录TPS
加大mysql配置中的bulk_insert_buffer_size，这个参数默认为8M
set bulk_insert_buffer_size = 100 * 1024 * 1024;
修改该条记录有助于千万级别数据批量插入。
