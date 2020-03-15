[TOC]



#### 简介

gitlab的ci/cd文档

> https://docs.gitlab.com/ee/ci/yaml/README.html

##### 作用

> 代码push之后，允许自动化操作

##### 实现

> 项目目录下编写.gitlab-ci.yml文件
>
> 守护进程gitlab runner,根据yml文件自动化执行
>
> 同一个阶段的job都是并行执行，比如stage:build,build下的jobs都会并行处理

##### job由下列参数定义

- default

  > 定义默认值
  >
  > - [`image`](https://docs.gitlab.com/ee/ci/yaml/README.html#image)
  > - [`services`](https://docs.gitlab.com/ee/ci/yaml/README.html#services)
  > - [`before_script`](https://docs.gitlab.com/ee/ci/yaml/README.html#before_script-and-after_script)
  > - [`after_script`](https://docs.gitlab.com/ee/ci/yaml/README.html#before_script-and-after_script)
  > - [`tags`](https://docs.gitlab.com/ee/ci/yaml/README.html#tags)
  > - [`cache`](https://docs.gitlab.com/ee/ci/yaml/README.html#cache)
  > - [`artifacts`](https://docs.gitlab.com/ee/ci/yaml/README.html#artifacts)
  > - [`retry`](https://docs.gitlab.com/ee/ci/yaml/README.html#retry)
  > - [`timeout`](https://docs.gitlab.com/ee/ci/yaml/README.html#timeout)
  > - [`interruptible`](https://docs.gitlab.com/ee/ci/yaml/README.html#interruptible)

- scripts

  > shell脚本，最终被runner执行

- image

  > 可以使用的docker images。image:name

- services

  > docker service images

- before_script

  > job执行前置的脚本

- after_script

- stages

  > 本次ci总共有哪些阶段`场景

- stage

  > job在哪个具体的阶段执行

- only

  > 让job只在某个分支执行

- except

  > 让job不在某个分支执行

- rules

  > List of conditions to evaluate and determine selected attributes of a job, and whether or not it is created
  >
  > 不清楚含义

- tags

  > 执行某个runner去执行

- allow_failure

  > 允许job失败

- when

  > 何时运行job'. Also available: `when:manual` and `when:delayed`

- environment

  > job部署到哪种环境.Also available: `environment:name`, `environment:url`, `environment:on_stop`, `environment:auto_stop_in` and `environment:action`.

- cache

  > 文件缓存。Also available: `cache:paths`, `cache:key`, `cache:untracked`, and `cache:policy`.

- artifacts

  > job成功后，将文件和目录附加过去

- dependencies

  > 限制将artifact传给jobs

- retry

  > job失败后,重试次数

- timeout

  > 未知

- parallel

  > 允许job实例并行数量

- trigger

  > 未知

- include

  > 加载其他的yml文件
  >
  > Also available: `include:local`, `include:file`, `include:template`, and `include:remote`.

- extends

  > Configuration entries that this job is going to inherit from.

- pages

  > 未知

- variables

  > 定义变量

- interruptible

  > 定义job是否可被取消

- resource_group

  > 限制job数量

为php项目配置ci/cd流程