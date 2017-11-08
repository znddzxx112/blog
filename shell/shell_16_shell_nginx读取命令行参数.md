
```
# 在其他shell脚本中使用以下代码
. auto/option #即可
```
```
help=
NGX_PREFIX=
opt=

for option in $@;do
    # opt 保留了完整的参数列表
    opt="$opt `echo $option | sed -e \"s/\(--[^=]*=\)\(.* .*\)/\1'\2'/\"`"

    # 解析了-- = 和 - =的这二种形式
    # 赋值给$option和$value二个变量
    case "$option" in
        -*=*) value=`echo "$option" | sed -e 's/[-_a-zA-Z0-9]*=//'` ;;
           *) value="" ;;
    esac

    case "$option" in
        --help)                          help=yes                   ;;
        --prefix=*)                      NGX_PREFIX="$value"        ;;
    esac
done

# 保存完整参数列表
NGX_CONFIGURE="$opt"

if [ $help = yes ]; then

cat << END 

  --help                             print this message

  --prefix=PATH                      set installation prefix
  --sbin-path=PATH                   set nginx binary pathname
  --conf-path=PATH                   set nginx.conf pathname
  --error-log-path=PATH              set error log pathname
  --pid-path=PATH                    set nginx.pid pathname
  --lock-path=PATH                   set nginx.lock pathname
END
    exit 1;
fi

# 变量默认赋值
NGX_CONF_PATH=${NGX_CONF_PATH:-conf/nginx.conf}
NGX_CONF_PREFIX=`dirname $NGX_CONF_PATH`
NGX_PID_PATH=${NGX_PID_PATH:-logs/nginx.pid}
NGX_LOCK_PATH=${NGX_LOCK_PATH:-logs/nginx.lock}

if [ ".$NGX_ERROR_LOG_PATH" = ".stderr" ]; then
    NGX_ERROR_LOG_PATH=
else
    NGX_ERROR_LOG_PATH=${NGX_ERROR_LOG_PATH:-logs/error.log}
fi

NGX_HTTP_LOG_PATH=${NGX_HTTP_LOG_PATH:-logs/access.log}
NGX_HTTP_CLIENT_TEMP_PATH=${NGX_HTTP_CLIENT_TEMP_PATH:-client_body_temp}
NGX_HTTP_PROXY_TEMP_PATH=${NGX_HTTP_PROXY_TEMP_PATH:-proxy_temp}
NGX_HTTP_FASTCGI_TEMP_PATH=${NGX_HTTP_FASTCGI_TEMP_PATH:-fastcgi_temp}
NGX_HTTP_UWSGI_TEMP_PATH=${NGX_HTTP_UWSGI_TEMP_PATH:-uwsgi_temp}
NGX_HTTP_SCGI_TEMP_PATH=${NGX_HTTP_SCGI_TEMP_PATH:-scgi_temp}
```
