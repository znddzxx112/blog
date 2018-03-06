- 建json文件
```
rs.slaveOk();
print("pid,title,userid,videoUrl");
db.debate.find({videoUrl:{$regex:/videoreplay/},valid:1}).forEach(function(debate){
        print("#" + debate.pid + ",#" + debate.title + ",#" + debate.userid + ",#" + debate.videoUrl);
});
```

- 执行命令并导出csv格式
```
/usr/local/mongodb3.2/bin/mongo --port 57119 newcircle_post /tmp/debate.js > /tmp/debate.csv
```
