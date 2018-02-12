```
if(($sock = socket_create(AF_INET, SOCK_STREAM, 0)) < 0)
{
echo "failed to create socket: ".socket_strerror($sock)."\n";
exit();
}

if(($ret = socket_bind($sock, $address, $port)) < 0)
{
echo "failed to bind socket: ".socket_strerror($ret)."\n";
exit();
}

if( ( $ret = socket_listen( $sock, 0 ) ) < 0 )
{
echo "failed to listen to socket: ".socket_strerror($ret)."\n";
exit();
}

while (true)
{
$conn = @socket_accept($sock);

//子进程
if(pcntl_fork() == 0)
{
$recv = socket_read($conn, 8192);
//处理数据
$send_data = "server: ".$recv;
socket_write($conn, $send_data);
socket_close($conn);
exit(0);
}
else
{
socket_close($conn);
}
}

```
