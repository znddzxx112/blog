
- php错误展示分二个步骤，报告错误，展示错误
- 这二步都有各自配置项,这二步是二回事情

- 展示错误
```
# php.ini
// 搜索display_error 
修改为display_error = On/Off
开发环境为On 正式环境为Off
// 方式1
正式环境中开启 错误日志记录
log_errors = On                             ;决定日志语句记录的位置     
log_errors_max_len = 1024                   ;设置每个日志项的最大长度     
error_log = /usr/local/error.log                ;指定产生的 错误报告写入的日志文件位置 
// 方式2
使用顶层错误处理函数，定向输出错误日志
```

- 错误报告方式
```
// php.ini中设置
//报告所有错误
error_reporting = E_ALL
// 报告所有错误除了E_NOTICE
error_reporting = E_ALL &~ E_NOTICE

//使用函数来报告所有错误
error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);    // 除了E_NOTICE之外，报告所有的错误
error_reporting(E_ERROR);       // 只报告致命错误
echo error_reporting(E_ERROR | E_WARNING | E_NOTICE);   // 只报告E_ERROR、E_WARNING 和 E_NOTICE三种错误
error_reporting(0) // 不报告错误
//在函数前面加 @，可以抑制错误输出，以防止错误消息泄露敏感信息。
```

- 错误类型说明
```
; 错误报告是按位的。或者将数字加起来得到想要的错误报告等级。 
; E_ALL - 所有的错误和警告 
; E_ERROR - 致命性运行时错 
; E_WARNING - 运行时警告（非致命性错） 
; E_PARSE - 编译时解析错误 
; E_NOTICE - 运行时提醒(这些经常是是你的代码的bug引起的， 

;也可能是有意的行为造成的。(如：基于未初始化的变量自动初始化为一个 
　　　　　　　　　　　　　　;空字符串的事实而使用一个未初始化的变量) 

; E_CORE_ERROR - 发生于PHP启动时初始化过程中的致命错误 
; E_CORE_WARNING - 发生于PHP启动时初始化过程中的警告(非致命性错) 
; E_COMPILE_ERROR - 编译时致命性错 
; E_COMPILE_WARNING - 编译时警告(非致命性错) 
; E_USER_ERROR - 用户产生的出错消息 
; E_USER_WARNING - 用户产生的警告消息 
; E_USER_NOTICE - 用户产生的提醒消息 
```

- 顶层错误报告处理函数
```
// http://php.net/manual/zh/function.set-error-handler.php
mixed set_error_handler ( callable $error_handler [, int $error_types = E_ALL | E_STRICT ] )
```

- 错误中用到的位运算
```
// 参考文章：http://php.net/manual/zh/language.operators.bitwise.php
$a & $b	And（按位与）	将把 $a 和 $b 中都为 1 的位设为 1。
$a | $b	Or（按位或）	将把 $a 和 $b 中任何一个为 1 的位设为 1。
$a ^ $b	Xor（按位异或）	将把 $a 和 $b 中一个为 1 另一个为 0 的位设为 1。
~ $a	Not（按位取反）	将 $a 中为 0 的位设为 1，反之亦然。

// &~ 等同 ^
```
