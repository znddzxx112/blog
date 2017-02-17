#### git脚本扩展与易忘命令

- 脚本扩展 - 编写shell脚本
- git bash后台打开第三方软件
- 参考文章： http://blog.csdn.net/weixin_35955795/article/details/54880336
```
git.exe 目录下 或者 当前项目中.git/hooks/ 或者 .git/hexin/hooks 中即可
新建sub文件, 输入以下内容
#! /bin/sh
"C:\xxx\sublime_text.exe" $1 &
在git bash中直接输入 sub 文件名称
```

- 定义全局的用户名邮件
- 常用命令取别名
- 使用sublime默认打开文件
```
git bash中输入
$ git config --global --edit
[user]
    name = "znddzxx112"
    email = "znddzxx112@163.com"
[alias]
    pl = pull
    ps = push
    ck = checkout
[core]
    editor = sub(前提配置sub脚本)
    editor = vim
```

- 常用命令

- git push
```
git push -u origin master
git push -u origin ckl_feed_second_opt
```

- git log
```
git log --oneline -n 10
git log --stat
git log -p 显示文件比较
git log --author="<pattern>"
搜索特定作者的提交。<pattern>可以是字符串或正则表达式。
git log --grep="<pattern>"
搜索提交信息匹配特定<pattern>的提交。<pattern>可以是字符串或正则表达式。
git log <since>..<until>
只显示发生在<since>和<until>之间的提交。两个参数可以是提交ID、分支名、HEAD或是任何一种引用。
git log <file>
只显示包含特定文件的提交。查找特定文件的历史这样做会很方便。
git log --graph --decorate --oneline
还有一些有用的选项。--graph标记会绘制一幅字符组成的图形，左边是提交，右边是提交信息。--decorate标记会加上提交所在的分支名称和标签。--oneline标记将提交信息显示在同一行，一目了然。
git log --author="John Smith" -p hello.py
这个命令会显示John Smith作者对hello.py文件所做的所有更改的差异比较(diff)。
..句法是比较分支很有用的工具。下面的栗子显示了在some-feature分支而不在master分支的所有提交的概览。
git log --oneline master..some-feature

$ git log 447df45...HEAD --author="caokelei" --oneline

空格查看更多，q退出
```

- cd
```
cd ~
cd /c/Users/vir/
```

- git checkout
```
参考文章：https://github.com/geeeeeeeeek/git-recipes/wiki/2.5-%E6%A3%80%E5%87%BA%E4%B9%8B%E5%89%8D%E7%9A%84%E6%8F%90%E4%BA%A4
```

- git reset git clean
- 适用于本地
```
git clean命令经常和git reset --hard一起使用。记住，reset只影响被跟踪的文件，所以还需要一个单独的命令来清理未被跟踪的文件。这个两个命令相结合，你就可以将工作目录回到之前特定提交时的状态。
```

- git revert
- 远程回退
```
确保你只对本地的修改使用git reset——而不是公共更改。如果你需要修复一个公共提交，git revert命令正是被设计来做这个的。
```

- git remote
```
git remote -v
git remote add <name> url
git remote rm <name>
```

- git branch
```
git branch crazy-experiment
git branch -d crazy-experiment #删除分支

git branch new-feature
git checkout new-feature
git merge <branch> 将指定分支并入当前分支
```

- 钩子-自定义工作流
