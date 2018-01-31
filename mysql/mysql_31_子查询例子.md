 - 子查询方法
 ```
 一般来说，在进行数据统计的时候，会使用多层嵌套的子查询来跑出数据。符合业务逻辑的多层嵌套的子查询往往不是很容易写出来。今天介绍一种写子查询的方法。逆向法。
 从目标出发向前推演，每一层推演就是一层子查询.
 ```
 
 - 成功的案例
 ```
 select stat_id,count(*) as luncunNum from (
    select stat_id,user_id from (
        (select user_id,stat_id from db_dws where p_date='20180125' and stat_id in ('R_5adxxxx') GROUP BY stat_id,user_id)
        UNION ALL
        (select user_id,stat_id from db_dws where p_date='20180126' and stat_id in ('R_5adxxxx') GROUP BY stat_id,user_id)
    ) as temp
    group by stat_id,user_iud HAVING count(*) >= 2
 ) GROUP BY stat_id
 ```
