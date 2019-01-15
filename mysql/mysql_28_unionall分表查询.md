> sql union all
```
1.1 记录分表minpid 和 maxpid
1.1 单个pid查询,判断出在哪个表即可
1.2 批量pids查询,判断出在哪几个表即可
比如:
select * from user_info_1 where userid in()
union all 
select * from user_info_2 where userid in()
```

> 相比较union区别
```
union会去掉重复的行数
union all 不会去掉重复的行数
```

> php写法
```
$tables = getTables('user_info');// show tables like 'user_info%'
foreach ($tables as $table) {
    $sqlArr[] = sprintf('select * from %s where userid = %d', $table, $userid);
}
$sql = implode(' UNION ALL ', $sqlArr);
$result = query($sql);
for ($i = 0; $i < count($result); $i++ ) {
    $return[] = $result[$i]['userid'];
}
return $return;
```
