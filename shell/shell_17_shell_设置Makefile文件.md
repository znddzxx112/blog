```
NGX_MAKEFILE=$NGX_OBJS/Makefile
NGX_MODULES_C=$NGX_OBJS/ngx_modules.c

NGX_AUTO_HEADERS_H=$NGX_OBJS/ngx_auto_headers.h
NGX_AUTO_CONFIG_H=$NGX_OBJS/ngx_auto_config.h

NGX_AUTOTEST=$NGX_OBJS/autotest
NGX_AUTOCONF_ERR=$NGX_OBJS/autoconf.err

cat << END > Makefile

default:        build

clean:
        rm -rf Makefile $NGX_OBJS
END
```
