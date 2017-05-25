- proc_open  执行一个命令，并且打开用来输入/输出的文件指针


- 参考文章：http://php.net/manual/zh/function.proc-open.php


- redis执行多个命令
```

39 $descriptorspec = array(
 40    0 => array("pipe", "r"),  // 标准输入，子进程从此管道中读取数据
 41    1 => array("pipe", "w"),  // 标准输出，子进程向此管道中写入数据
 42    2 => array("file", "/tmp/error-output.txt", "a") // 标准错误，写入到一个文件
 43 );
 44 
 45 $cwd = '/tmp';
 46 $env = array('some_option' => 'aeiou');
 47 
 48 $process = proc_open('/usr/local/bin/redis-cli -h xxx -p 6379 -a xxx -n 5 -x', $descriptorspec, $pipes, $cwd, $env);
 49 
 50 if (is_resource($process)) {
 51     // $pipes 现在看起来是这样的：
 52     // 0 => 可以向子进程标准输入写入的句柄
 53     // 1 => 可以从子进程标准输出读取的句柄
 54     // 错误输出将被追加到文件 /tmp/error-output.txt
 55     fwrite($pipes[0], "keys * \n");
 56 
 57     fwrite($pipes[0], 'scan 0');
 58     fclose($pipes[0]);
 59 
 60     echo stream_get_contents($pipes[1]);
 61     fclose($pipes[1]);
 62 
 63 
 64     // 切记：在调用 proc_close 之前关闭所有的管道以避免死锁。
 65     $return_value = proc_close($process);
 66 
 67     echo "command returned $return_value\n";
 68 }
```
