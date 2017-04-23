- 借助shm记录循环的id
```
 $lastidfile = '/dev/shm/lastid';
 if (file_exists($lastidfile)) {
    $lastid = (int)file_get_contents($lastidfile);
 }
 
 while (true) {
    $sql = "select * from user where userid > {$lastid} order by userid asc limit 10000";
    $res = $db->query($sql);
    if ($res != false && is_array($res) && count($res) > 0) {
        foreach ($res as $user) {
            $lastid = $user['id'];
        }
        file_put_contents($lastidfile, $lastid);
    } else {
        file_put_contents($lastidfile, $lastid);
        break;
    }
 }

```
