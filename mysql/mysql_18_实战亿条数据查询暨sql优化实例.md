
##### 抽取核心需求

- 获取从11月11号-12月15日，发帖或回帖>=5的用户

##### 前提条件

###### 发帖表情况

- 发帖表中的数据总共有1亿条，11月11号-12月15日目标数据总共有860万条

- 抽象后的表结构如下所示

```
// 发帖表
CREATE TABLE `post` (
  `pid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '??ID',
  `uid` bigint(20) unsigned NOT NULL COMMENT '??ID',
  `content` text NOT NULL COMMENT '??',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '????',
  PRIMARY KEY (`pid`),
  KEY `userid` (`uid`),
  KEY `ctime` (`ctime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

- 回帖表中数据有1千万条，11月11号-12月15日目标数据有720万条

- 抽象后的表结构如下所示

```
// 回帖表
CREATE TABLE `comment` (
  `cid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `content` text NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `ctime` (`ctime`),
  KEY `uid` (`uid`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

##### 方案一
- 统计用户发帖数量，对应的sql语句
```
select 
    uid
    count(*) as postCount
from 
    post
where
    ctime > unix_timestamp('2016-11-11')
    and
    ctime < unix_timestamp('2016-12-15')
group by 
    uid
```
##### 运行结果
- 运行15分出不了数据
- 优点：一条sql出结果，程序无需过多处理
- 缺点：1.压力全在mysql服务器 2.group by是低效率语句

##### 方案二
- mysql出数据，通过php程序脚本累加次数，判断ctime是否符合要求
```
select 
    Distinct uid
from 
    post
where
    pid > 12398000
order by 
    pid
limit 8600000;
```
- 运行结果:mysql出数据，运行5分钟报php程序脚本占用内存超出
- 优点:1. sql优化使用主键，limit，变得更加高效2. 根据业务，目标区域pid大于12398000，减少mysql扫描条数
- 缺点:1. 压力在脚本执行服务器，需要统计uid的个数，检查ctime 2.条数多，脚本服务器的内存非常容易占用超出

##### 方案三
- 沿用方案二sql，基于业务改善php脚本代码，ctime检查放到脚本中判断处理，结合分而治之的思维，产生中间过程文件
```
$sql = 'select 
    Distinct uid
from 
    post
where
    pid > 12398000
order by 
    pid
limit 8600000';
$result = $mysqli->query($sql, MYSQLI_USE_RESULT);// 此参数结果集在msyql服务器不在脚本服务器
while($post = $result->fetch_assoc()){
    $uid = $post['uid'];
    if($cache->has($uid)) {
        // 结合业务使用缓存来抗
        continue;
    }
    // 查询用户回帖数量
    
    // 重定向记录uid
    echo $uid . "\r\n";
}
```
- 结合分而治之思想，新起脚本统计上一步产生的uid文件
```
$fp = @fopen($filename, 'r');
if ($fp) {
    while(！feof($fp)) {
        $line = fgets($fp);
        // 执行业务操作
    }
}
fclose($fp);
```
- 运行结果:花费10分钟成功统计出数据
- 优点：1.通过参数MYSQLI_USE_RESULT,压力均分到mysql服务器和脚本服务器2.使用缓存来抗住大量的查询3.改善php脚本的流程，使用游标来降低内存压力4. 产生中间过程文件，降低单个php脚本程序内存占用
- 缺点：1.存在中间过程文件，整个流程不够舒畅




#### 总结

1. 对查询的sql有性能要求，sql本身性能不高或者需要执行动作太多，都将导致mysql不出数据。
2. 内存占用过多的风险。程序一次性数据加载过多或者随着程序运行，内存不断占用上升。都有此种风险。
3.执行时间不宜过长。每一个用户需要进行多个条件判断，包括通过向第三方系统调用信息再进行判断。这些操作都会增加执行时间。
4. 了解sql语句的效率。group by,distinct,limit off，lim都是低效率语句。在大表中都是不能去用的。
5. mysqli应该使用游标的方式获取，query方法并加上MYSQLI_USE_RESULT参数，将结果集的压力放到mysql服务器上，如果不加参数，结果集将放在脚本服务器上，内存将直接占用超出。
6. 分步治之的思想，产生中间过程文件，降低单个php程序占用的内存。
