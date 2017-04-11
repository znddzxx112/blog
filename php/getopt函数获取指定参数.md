```
$logopt = array(
    'userid::',#可选
    'tablename:',#必填
);

$opt = getopt('', $logopt);
if (isset($opt['tablename'])) {
    $tablename = $opt['tablename'];
} else {
    echo '请输入表名';
    exit;
}

$tablename = $opt['tablename'];
```
