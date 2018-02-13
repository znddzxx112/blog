- 参考文章：http://rango.swoole.com/archives/date/2013/04

```
Linux IPC消息队列是一个全内存设计，内核保证读写顺序和数据同步，并且性能非常强悍的先进现先出数据结构。它的特性如下：

    每秒可读写超过50万次（4核/4G内存的机器）
    支持消息多类型，抢队列时可根据需要获取特定的消息类型
    每个消息长度最大支持65535个字节
    队列长度受内存大小限制，最大不超过机器内存的50%，可以修改内核参数来调整

消息队列可以用在很多场景下，如异步任务处理，抢占式的数据分发，顺序缓存区等。使用方法也非常简单，Linux提供了4个库函数，msgget,msgsnd,msgrcv,msgctl，分别用于创建/获取消息队列、发送数据、接收数据、设置/获取消息队列。PHP内核包含了这个扩展，需要在./configure时加入–enable-sysvmsg来开启。具体可参考PHP手册。Swoole框架内提供了一个sysvmsg的封装，代码在http://code.google.com/p/swoole/source/browse/trunk/libs/class/swoole/queue/SysvQueue.class.php.

下面写一个简单的例子，采用单Proxy主进程+多Worker进程的模式，功能是做异步任务的处理。本代码没有提供进程管理、信号处理、队列过载保护，如果要用在生产环境，请自行实现。
```

```
<?php
$msg_key = 0x3000111; //系统消息队列的key
$worker_num = 2;   //启动的Worker进程数量
$worker_pid = array();

$queue = msg_get_queue($msg_key, 0666);
if($queue === false)
{
    die("create queue fail\n");
}
for($i = 0; $i < $worker_num; $i++)
{
    $pid = pcntl_fork();
    //主进程
    if($pid > 0)
    {
        $worker_pid[] = $pid;
        echo "create worker $i.pid = $pid\n";
        continue;
    }
    //子进程
    elseif($pid == 0)
    {
        proc_worker($i);
        exit;
    }
    else
    {
        echo "fork fail\n";
    }
}

proc_main();

function proc_main()
{
    global $queue;
    $bind = "udp://0.0.0.0:9999";
    //建立一个UDP服务器接收请求
    $socket = stream_socket_server($bind, $errno, $errstr, STREAM_SERVER_BIND);
    if (!$socket)
    {
        die("$errstr ($errno)");
    }
    stream_set_blocking($socket, 1);
    echo "stream_socket_server bind=$bind\n";
    while (1)
    {
        $errCode = 0;
        $peer = '';
        $pkt = stream_socket_recvfrom($socket, 8192, 0, $peer);

        if($pkt == false)
        {
            echo "udp error\n";
        }
        $ret = msg_send($queue, 1, $pkt, false, true, $errCode); //如果队列满了，这里会阻塞
        if($ret)
        {
            stream_socket_sendto($socket, "OK\n", 0, $peer);
        }
        else
        {
            stream_socket_sendto($socket, "ER\n", 0, $peer);
        }
    }
}

function proc_worker($id)
{
    global $queue;
    $msg_type = 0;
    $msg_pkt = '';
    $errCode = 0;
    while(1)
    {
        $ret = msg_receive($queue, 0, $msg_type, 8192, $msg_pkt, false, $errCode);
        if($ret)
        {
            //TODO 这里处理接收到的数据
            //.... Code ....//
            echo "[Worker $id] ".$msg_pkt;
        }
        else
        {
            echo "ERROR: queue errno={$errCode}\n";
        }
    }
}
```

```
客户端使用netcat来测试，netcat -u 127.0.0.1 9999。

使用ipcs -q来查看系统消息队列：
tianfenghan@VM_194_118_sles10_64:/data/nginx_log> ipcs -q

------ Message Queues --------
key msqid owner perms used-bytes messages
0x4000270f 0 tianfengha 666 0 0
0x03000111 32769 tianfengha 666 0 0
```
