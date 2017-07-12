> mongo是强类型，php是弱类型
> 有时需要统一字段的类型，来查找
```

$cursor = getAllCollectionData();

if (!empty($cursor)) {
    foreach ($cursor as $val) {
        $map = [
            '_id => $val['_id']
        ];
        $update = [
            'pid' => (int)$val['pid'],
            'userid' => (int)$val['userid'],
            'ctime' => (int)$val['ctime'],
        ]
        return $mongo->update($map, ['$set' => $update], ['multiple' => false, 'upsert' => false]);
    }
}

```
