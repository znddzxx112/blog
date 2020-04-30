# openapi/swagger

路径

source code -> swagger/openapi json/yaml file -> yapi -> jenkins

1. 扫描源码中的接口描述信息
2. 生成openapi标准的 json/yaml 文件
3. 接口管理平台yapi可以自动导入openapi文件，openapi文件可以导出到postman,jmeter

也可以手动编写符合openapi规范的yaml文件，工具生成服务端和客户端的可执行示例代码。

## source code

应用端源码（php,nodejs,go），都有生成api的相关工具。

###php

参考 https://blog.csdn.net/hero2040407/article/details/80647328

https://github.com/zircote/swagger-php

```bash
composer require zircote/swagger-php
mkdir json_docs
#假设接口存放于api目录,生成openapi.yaml接口文件。
php ./vendor/bin/openapi ./api/ -o json_docs/
```



#### docs

##### 生成文档

**方式1：**

```bash
$ docker pull tico/swagger-php
```

> 前提安装docker，拉取镜像。只需操作一次

```bash

$ docker run -v {项目路径}:/sipc_vip_backend_php -it tico/swagger-php -o /sipc_vip_backend_php/docs/docs.yaml /sipc_vip_backend_php/app/controllers
```

> {项目路径} 比如我的项目路径为：/home/znddzxx112/workspace/sipc/sipc_vip_backend_php
>
> -v 代表docker挂载路径映射，对应容器中路径为/sipc_vip_backend_php
>
> -it 代表docker的交互式执行方式
>
> tico/swagger-php 镜像名称
>
> -o 代表文档输出路径
>
> /sipc_vip_backend_php/app/controllers 代表扫描所在路径下的注释

**其他方式**

> 参照：https://github.com/zircote/swagger-php#usage
>
> 注意点1：zircote/swagger-php的composer.json写明要求php7.2以上
>
> 如果实践了其他文档生成方式，请继续补充。

##### 上传文档至测试服务器

```bash
$ scp docs/* ubuntu@192.168.3.212:/var/www/sipc.vip.php/docs/
docs.yaml
```

##### 如何为接口写注释请看：

> 文档：https://swagger.io/specification/
>
> 示例：https://github.com/zircote/swagger-php/tree/master/Examples







### nodejs

https://www.npmjs.com/package/swagger-jsdoc

参考帮助文档，可以在nodejs中集成生成文档，/test/example/v3/test.js

命令行方式可以参考帮助文档，或者测试文件 /test/example/cli/cli.js

```bash
swagger-jsdoc -d example/v2/swaggerDef.js -o openapi.yaml
```

默认生成的是json文件，可以指定参数生成yaml文件。

### go

https://github.com/swaggo/swag

```
go get -u github.com/swaggo/swag/cmd/swag
swag init
```

gin集成代码示例，主要是ui显示，可有可无。

https://github.com/swaggo/swag/tree/master/example/celler

##相关链接

postman导入示例

https://learning.getpostman.com/docs/postman/collections/working-with-openAPI/

最新3.0.2文档

http://spec.openapis.org/oas/v3.0.2