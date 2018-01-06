- 目录
```
embed.php
main.c
Makefile
```

- 前提要把libphp7.so放/lib/中
- 在编译php时候加入--enable-embed


- Makefile文件
```
CC = gcc

CFLAGS = `php-config --includes`
LDFLAGS = -L/usr/local/lib -lphp7
ALL:
	$(CC) -o embed main.c $(CFLAGS) $(LDFLAGS)
clean:
	rm -f embed
test:
	./embed
```

- main.c文件
```
#include "sapi/embed/php_embed.h"

int main(int argc, char *argv[])
{
	PHP_EMBED_START_BLOCK(argc, argv);
	// char *script = "echo 'Hello World!';";
	// zend_eval_string(script, NULL, "Simple Hello World App" TSRMLS_CC);
	char *script_name = "include './embed.php';";
	zend_eval_string(script_name, NULL, "Simple embed App" TSRMLS_CC);
	PHP_EMBED_END_BLOCK();
	return 0;
}
```

- embed.php
```
<?php
echo "test php_embed.h" . PHP_EOL;
```

- 最后编译链接，执行
```
make clean && make && make test
```
