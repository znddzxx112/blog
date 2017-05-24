- exec与system与popen命令都可以执行系统的shell命令
- exec命令
```
  1 <?php
  2 
  3 $output = array();
  4 $com = 'ls ';
  5 if(isset($argv[1])){
  6         $com = $com . ' ' .$argv[1];
  7 }
  8 var_dump($com);
  9 exec($com, $output, $return_var);
 10 var_dump($output);
 11 var_dump($return_var);
```
- 注意点
```
$output shell执行后的每行的结果
$return_var保存脚本执行后结果 0：代码执行成功
            类似于shell脚本中%?的效果
```


- 执行结果
```
/home/caokelei/test.php:10:
array(4) {
  [0] =>
  string(3) "cli"
  [1] =>
  string(4) "loop"
  [2] =>
  string(4) "note"
  [3] =>
  string(8) "test.php"
}
/home/caokelei/test.php:11:
int(0)
```


- system命令
```
14 $com = 'ls ';
 15 if (isset($argv[1])) {
 16         $com .= $argv[1];
 17 }
 18 $last_line = system($com, $return_var);
 19 var_dump($last_line);
 20 var_dump($return_var);
```

- 执行结果
```
cli
loop
note
test.php
/home/caokelei/test.php:19:
string(8) "test.php"
/home/caokelei/test.php:20:
int(0)
```

- popen命令
```
23 $fls = popen("ls /home/caokelei","r");
 24 //$line = fread($fls, 6);
 25 while(($line = fgets($fls)) !== false){
 26 echo $line;
 27 }
 28 //echo $line;
 29 pclose($fls);
```

- 执行结果
```
cli
loop
note
test.php
```

- popen命令访问redis
```
#redis-cli [options] cmd argc
```
```
 $fls = popen("/usr/local/bin/redis-cli -h xxx -p xxx -a xxxx -n 5 SCAN     0", "r");
 32 while(($line = fgets($fls)) !== false){
 33 echo $line;
 34 }
 35 pclose($fls);
```

- 执行结果
```
17
live_chosen
mykey
myset1
```
