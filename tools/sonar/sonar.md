### sonar

#### 目的

> 借助sonar平台分析和管理项目代码质量
>
> sonar是一个用于代码质量管理的开放平台，sonar提供潜在bug、漏洞、代码重复率等指标，进而提升项目代码质量。

#### sonar平台

> 公司已搭建以下二个平台
>
> 

#### sonar-scanner 命令

> 可扫描项目代码并发送扫描结果到sonar平台

使用sonar-scanner的docker镜像

```bash
$ docker pull kiwicom/sonar-scanner:4.3 
$ cd 项目代码目录
$ docker run -it --user=root --net=host --rm --name sonar-scanner -v `pwd`:/usr/src sonar-scanner:4.3 sonar-scanner -X -Dsonar.projectKey=xx \
  -Dsonar.sources=./xx \
  -Dsonar.host.url=http://xxx:9000 \
  -Dsonar.login=xx
```

`-it`:交互形式执行

`--user=root`:容器中使用root用户权限

`--net=host`:容器使用宿主机网络环境

`--rm`:容器执行完后即删除

`--name sonar-scanner`:容器名称

`-v`:当前项目目录挂载到容器/usr/src目录下

` -X`:sonar-scanner命令参数，能打印出有用info信息

#### gitlab-ci中集成sonar-scanner命令

.gitlab-ci.yml文件中的内容

```yaml
stages:
  - lint
  - build
  - test
  - deploy

lint_code:
  stage: lint
  image:
    name: kiwicom/sonar-scanner:4.3
  allow_failure: true
  only:
    - stage
    - feature_sonar
  variables:
    SONAR_HOST_URL: 'http://192.168.3.xx:9000/'
    SONAR_LOGIN: 'xx'
    SONAR_PROJECTKEY: 'xx.xx'
    SONAR_SOURCES: './xx'
  script:
    - sonar-scanner -X -Dsonar.projectKey=$SONAR_PROJECTKEY -Dsonar.sources=$SONAR_SOURCES -Dsonar.host.url=$SONAR_HOST_URL -Dsonar.login=$SONAR_LOGIN
```

`only`:指定stage分支执行本任务

`SONAR_HOST_URL`:sonar平台

`SONAR_LOGIN`:sonar平台登录凭证，sonar平台【我的账户->安全->生成令牌】

`SONAR_PROJECTKEY`:项目名称

`SONAR_SOURCES`:项目扫描路径

#### sonar平台搭建

> docker-composer安装sonar https://www.bbsmax.com/A/WpdK4b31zV/