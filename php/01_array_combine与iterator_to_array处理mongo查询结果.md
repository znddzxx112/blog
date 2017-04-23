- 通过合并两个数组来创建一个新数组，其中的一个数组元素为键名，另一个数组元素为键值：

```
$cursor 为mongo查询出来的对象
$data = iterator_to_array($cursor);
$ids = array_column($data, '_id');
$data = array_combine($ids, $data);
```
