- 持久化
```
目的：区块链的信息保存到磁盘中
看完该节后，需明白如何将区块链写到磁盘文件中
这里使用的是bolt,可以看入门介绍：https://segmentfault.com/a/1190000010098668#item-1-9
自行理解bolt中db,tx,bucket,cursor概念
```

- 更新操作，将[]byte保存
```
func TestBolt_Update(t *testing.T)  {
	db, err:= bolt.Open("wallet_01.dat", 0600, nil)
	if err != nil {
		t.Fatal(err)
	}
	err = db.Update(func(tx *bolt.Tx) error {
		bucket, err := tx.CreateBucketIfNotExists([]byte("blocks"))
		if err != nil {
			return err
		}
		return bucket.Put([]byte("l"), []byte("foo"))
	})
	if err != nil {
		t.Fatal(err)
	}
}
```

- 读取操作,读取[]byte
```
func TestBolt_View(t *testing.T) {
	db, err:= bolt.Open("wallet_01.dat", 0600, nil)
	if err != nil {
		t.Fatal(err)
	}
	var val []byte
	err = db.View(func(tx *bolt.Tx) error {
		bucket := tx.Bucket([]byte("blocks"))
		val = bucket.Get([]byte("l"))
		return nil
	})
	if err != nil {
		t.Fatal(err)
	}
	t.Logf("%s", val)
}
```
