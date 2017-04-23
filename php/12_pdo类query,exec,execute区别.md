- 参考文章：http://blog.csdn.net/z1002137615/article/details/52154223


PDO::query（PHP环境下同）和PDOStatement::execute函数均能实现SELECT查询功能，但官方文档并未见对此设计初衷的说明，此外还有个PDO::exec函数功能也很类似。天缘自己也很纳闷（也可能未发现或是未能完全理解），既然PDO::query函数功能做的如此单一，而且还和exec、execute之间有交叠，那为何不重新调整部分函数执行方法，只保留一个或保留两个足够，难道只是照顾到一些传统编程人员的习惯？下面是官方给这三个函数定义：
```
PDO::exec — Execute an SQL statement and return the number of affected rows
PDO::query — Executes an SQL statement, returning a result set as a PDOStatement object
PDOStatement::execute — Executes a prepared statement
```

```
特别注意：PDO::exec跟PDOStatement::execute是两个不同函数，前者跟PDO::query地位是并列的，而后者则是PDOStament类下子函数。
```

- PDO::query

PDO::query执行一条SQL语句，如果通过，则返回一个PDOStatement对象。PDO::query函数有个“非常好处”，就是可以直接遍历这个返回的记录集。
示例如下：
```
$sql = 'SELECT name FROM url';
foreach ($dbh->query($sql) as $row) {
    print $row['name'] . "\t";
}
```

query同传统的MySQL query函数类似，同样需要对开发者自行对输入的sql语句进行安全检查。
query因为会返回PDOStament对象，似乎用在SELECT语句执行上更合适，这跟上文提到的query支持直接遍历不谋而合。
query执行后，在下一次query执行之前，如果不取走所有返回的记录集，则query将会执行失败，除非我们调用 PDOStatement::closeCursor()来释放数据库资源与PDOStatement对象。
原话：If you do not fetch all of the data in a result set before issuing your next call to PDO::query(), your call may fail. Call PDOStatement::closeCursor() to release the database resources associated with the PDOStatement object before issuing your next call to PDO::query().

- PDO::exec
```
PDO::exec执行一条SQL语句，并返回受影响的行数。此函数不会返回结果集合。官方建议：
对于在程序中只需要发出一次的 SELECT 语句，可以考虑使用 PDO::query()。
对于需要发出多次的语句，可用 PDO::prepare() 来准备一个 PDOStatement 对象并用 PDOStatement::execute() 发出语句。
PDO::exec支持SELECT/DELETE/UPDATE/INSERT等全部SQL语句执行，所以相比PDO query()函数功能要强大的多。由于只返回受影响的函数，所以，如果执行SELECT则无法得到PDOStatement对象，故也无法遍历结果集，只能按照官方建议去使用query或execute函数。
```

- PDOStatement::execute
```
再看一下PDOStatement::execute函数，execute函数是用于执行已经预处理过的语句，只是返回执行结果成功或失败。也就是说execute需要配合prepare函数使用，这个的确是麻烦了一点，每次都要先prepare，然后才能exec。所以，如果执行SELECT等SQL语句，则还需要借助fetch等函数进行结果读取（当然上文的query也是可使用fetch等函数）。
execute支持绑定参数，无需考虑安全问题（绑定时！其它语句还需要自己考虑），示例如下：
$sth= $dbh->prepare('SELECT name FROM foo WHERE width < :width AND height = :height');
$sth->bindParam(':width', $width);
$sth->bindParam(':height', $height);
$sth->execute();
execute支持多次运行，这在某些方面，有助于性能提升。示例如下：
$sth = $db->prepare("SELECT * FROM foo WHERE width = ?");
$sth->execute(array(1));
$results = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth->execute(array(2));
$results = $sth->fetchAll(PDO::FETCH_ASSOC);
尽管PDOStatement::execute也很强大，但跟PDO::exec地位是不同的，不可混淆。
```
