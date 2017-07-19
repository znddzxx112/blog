- 文件位置

```
php-scr/sapi/fpm/fpm_main.c 中main函数为fpm总入口
```

- fpm命令参数处理
```
# php-fpm --help // 所列参数处理
while((c = php_getopt(argc, argv, OPTIONS, &php_optarg, &php_optind, 0, 2)) != -1) {
    shiwch(c) {// c为操作码 php_optarg为操作值
        case 'c'://php 使用的ini文件
            ...
        break;
        case 'n'://忽视phpini文件
        break;
        case 'd'://直接给ini参数赋值 foo=bar
            ...
        break;
        case 'y':
            //php-fpm参数位置
        break;
        case 'p':
            //php-fpm前缀位置
        break;
        case 'g':
            //fpm,指定pid位置
        break;
        case 'e':
            // 不明白
        break;
        case 't':
            // 不明白
        break;
        case 'm':
            // 等同于php -m 列举出已编译的php，zend模块
        break;
        case 'i':
            // 等同于php -i命令 打印php info
        break;
        case 'R'
            // 以root运行
        break;
        case 'D':
            // 强制守护运行
        break;
        case 'F':
            // 非强制守护运行
        break;
        case 'O':
            // 不明白，貌似标准错误相关
        break;
        default:
        case 'h':
        case '?':
            // 帮助信息
            goto out;
        case 'v':
            // 打印php版本
            goto out;
    }
}
```

- fpm初始化
```
if (0 > fpm_init(argc, ...)) {
    // 初始化失败
}
```

- fpm向master发信息
```
if (fpm_globals.send_config_pipe[1]) {
    int writeval = 1;
    zlog();
    write(fpm_globals.send_config_pipe[1], &writeval, sizeof(writeval));
    close(fpm_globals.send_config_pipe[1]);
}
```

- fpm启动
```
fpm_is_running = 1;
fcgi_fd = fpm_run(&max_requests);
parent = 0;
```

- fpm已启动，初始化请求
```
request = fpm_init_request(fcgi_fd);
while(EXPECTED(fcgi_accept_request(request) >= 0)) {
    char *primary_script = NULL;//让zend去执行的脚本
    request_body_fd = -1;// 请求主体
    init_request_info();
    fpm_request_info();
    
    // 请求启动后，才能进行路径转换
    if (UNEXPECTED(php_request_startup() == FILURE)) {
        // 失败处理
    }
    
    // 获取请求方式 menthod_menthod
    if (UNEXPECTED(!sg(request_info).request_menthod)) {
        // 失败处理
    }
    
    // 请求状态
    if (UNEXPECTED(fpm_status_handle_request())) {
    
    }
    
    // primary script 执行脚本是否存在，否则404
    // 路径转换，获取primary script路径
    if (UNEXPECTED(SG(request_info).path_translated)) {
    
    }
    
    if (UNEXPECTED(fpm_php_limit_extension(SG(request_info).path_translated))) {
        // 脚本无权限访问 403
    }
    
    // 脚本存在，我们继续处理
    if (UNEXPECTED(php_fopen_primary_script(&file_handle) == FAILURE)) {
        // 打开脚本，权限不够打不开返回403
        // 否则报404 No input file spectified
    }
    
    fpm_request_executing();
    
    // 脚本输入，执行php脚本
    php_execute_script(&file_handle);
    
fastcgi_request_done:
    // 释放脚本
    if (EXPECTED(primary_script)) {
        efree(primary_script);
    }
    // 释放请求主题
    if (UNEXPECTED(request_body_fd != -1)) {
        close(request_body_fd);
    }
    request_body_fd = -2
    
    fpm_request_end();
    fpm_log_write(NULL);
    
    efree(SG(request_info).path_translated);
    SG(request_info).path_translated = NULL;
    
    // 请求关闭
    php_request_shutdown((void *) 0);
    
    requests++;
    // 子进程处理达到最大请求数
    if (UNEXPECTED(max_requests && (rquests == max_requests))) {
        // 关闭该子进程
        fcgi_finish_request(request, 1);
    }
    
    // fastcgi loop
}

fcgi_destroy_request(request);
fcgi_shutdown();

// 释放资源
if (cgi_sapi_module.php_ini_path_override) {
    free(cgi_sapi_module);
}
if (cgi_sapi_module.ini_entries) {
    free(cgi_sapi_module.ini_entries);
}
```

- fpm关闭
```
out:
    SG(server_context) = NULL;
    php_module_shutdown();
    
    if (parent) {
        sapi_shutdown();
    }
```

- fpm_run函数
```
// 实现位置:sapi/fpm/fpm/fpm.c

// 返回listening socket
int fpm_run(int *max_requests)
{
    struct fpm_worker_pool_s *wp;
    
    for (wp = fpm_worker_all_pools; wp; wp=wp->next) {
        int is_parent;
        
        is_parent = fpm_children_create_initial(wp);
        
        if (!is_parent) {
            goto run_child;
        }
        
        if (is_parent == 2) {
            fpm_pctl(FPM_PCTL_STATE_TERMINATING, FPM_PCTL_ACTION_SET);
            fpm_event_loop(1);
        }
    }

    fpm_event_loop(0);
    
run_child:
    
    fpm_cleanups_run(FPM_CLEANUP_CHILD);
    
    *max_requests = fpm_globals.max_requests;
    return fpm_global.listening_socket;
}
```

- cgi_sapi_module 定义
```
// 位置 fpm_main.c Line:846行左右
// 下面是赋值操作
// sapi_module_struct 定义在main/SAPI.h
static sapi_module_struct cgi_sapi_module = {
    "fpm-fcgi", //name
    "FPM/FastCGI", // pretty name
    
    php_cgi_startup, // startup
    php_module_shutdown_wrapper, // shutdown
    
    sapi_cgi_activate, // activate
    sapi_cgi_deactivate, // deactivate
    
    ...
    
    php_error,
    
    ...
    
    sapi_cgi_send_headers, // headers handler
    
    sapi_cgi_read_post,// POST data
    sapi_cgi_read_cookies,//Cookies data
    
    sapi_cgi_register_variables // register server variables
    
    STANDARD_SAPI_MODULE_PROPERTIES

}
```

- 函数赏析
```
staitc void print_extensions(void)
{
    zend_llist sorted_exts;
    
    zend_llist_copy(&sorted_exts, &zend_extensions);
    sorted_exts.dtor = NULL;
    zend_llist_sort(&sorted_exts, extension_name_cmp);
    zend_llist_apply_with_arguments(&sorted_exts, (llist_apply_with_arg_func_t) print_extension_info, NULL);
    zend_llist_destroy(&sorted_exts);
}

// 发送头部信息
static int sapi_cgsend_headers() //方法

// 读取来自http发送来的POST_DATA
static size_t sapi_cgi_read_post(char *buffer, size_t count_bytes);

// 读取系统的环境变量
static char *sapi_cgibin_getenv(char *name, size_t name_len)

// 读取cookie
static char *sapi_cgi_read_cookies(void){
    fcgi_requst *rquest = (fcgi_request*)SG(server_context);
    return FCGI_GETENV(request, "HTTP_COOKIE");
    
// 模块启动函数
static int php_cgi_startup(sapi_module_struct *sapi_module)
{
    if (php_module_startup(sapi_module, &cgi_module_entry, 1) == FAILURE) {
        return FAILURE;
    }
    return SUCCESS;
}

// 命令使用说明函数
static void php_cgi_usage(char *argv0);

// 请求初始化 - 获取PATH_INFO,SCRIPT_NAME等
/**
    http://localhost/info.php/test?a=b
    
    PATH_INFO = /info.php/test
    PATH_TRANSLATED=/docroot/test
    SCRIPT_NAME=/info.php
    REQUEST_URI=/info.php/test?a=b
    SCRIPT_FILENAME=/docroot/info.php
    QUERY_STRING=a=b
*/
static void init_request_info(void)


```

- 常用宏
```
Zend/zend_globals_macros.h:
# define CG(v) TSRMG(compiler_globals_id, zend_compiler_globals *, v)

Zend/zend_globals_macros.h:
# define EG(v) TSRMG(executor_globals_id, zend_executor_globals *, v)

main/php_globals.h:
# define PG(v) TSRMG(core_globals_id, php_core_globals *, v)

main/SAPI.h:
# define SG(v) TSRMG(sapi_globals_id, sapi_globals_struct *, v)

SG宏主要用于获取SAPI层范围内的全局变量 
```

- 总结
```
需要熟悉php_*,zend_* 函数
源码提到了redirect.so，可以关注一下
404出现，无primary_script脚本
403出现，访问脚本权限不够
```
