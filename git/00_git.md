

### tortoiseGit

```
拉取项目
根目录下 右键Git clone

新增文件
git add

提交文件/拉取文件
进入文件夹中,右键 tortoiseGit->PUll/Push

创建本地分支
tortoiseGit->Create Branch

分支之间切换
Switch/Checkout

推送到远程分支
若远程分支为空，直接push即可

拉取远程分支
切换到master分支 使用Switch/Checkout
拉取更新系统 pull
再使用Swith/Checkout 到新分支就可以了

直接在仓库增加远程分支
Branches->Create New branch

分支合并
切换到master 然后选择merge

拉取冲突解决
tortoiseGit->Diff -> stash save(把自己的代码隐藏存起来) -> 重新pull -> stash pop(把存起来的隐藏的代码取回来 ) -> 代码文件会显示冲突 -> 右键选择edit conficts，解决后点击编辑页面的 mark as resolved ->  commit&push

查看历史记录
tortoiseGit->show log

提交文件
Git Commit->"dev"

查看文件状态 
tortoiseGit->show log

忽视文件
tortoiseGit->delete and add to ignore list

版本回退
tortoiseGit->show log ,选中版本，右击 reset master to this
git reset --hard 3628164
远程分支回滚
本地代码回滚到上一版本（或者指定版本）
git reset --hard HEAD~1
1
1
加入-f参数，强制提交，远程端将强制跟新到reset版本
git push -f origin 分支名称
git reset --hard HEAD^

版本前进
tortoiseGit->show Reflog 选中版本，右击 reset master to this

查看版本-根据作者
git log --author="caokelei" --pretty=oneline
```

### git revert

```
1 先备份当前要操作的分支 git branch 
2 【范围查看回退的commit】git log 查看提交记录 
git log  -p -8 --before="2008-11-01" --since="2008-10-01" --author="xxx@xx.com" --graph
3 【单个commit查看】git log commit_id -1 -p(看详情)
4  git revert -n commit_id -m 1(父分支)
5. 提交回滚 git commit -am ""

总结:reset 会使HEAD向前进,revert的commit_id做反向操作，更加安全，push到远程了一定要使用该操作
reset 会使HEAD向后退,做反向操作
```


### git stash

当前分支内容暂存,使得可以切换到其他分支继续工作
```
git stash clear
git stash save ""
git stash list
git stash 【pop | apply】 stash
```

### git log 可以查看某一个分支的记录，某一个文件的历史记录
```
git log --pretty=oneline -3 <comment-hash-id>
git log --pretty=oneline -3 <comment-hash-id>:file
```

### git show 
查看某个分支的提交记录，查看某个分支下的提交的文件记录  --stat只显示文件不包含具体改动内容
```
git show --stat <comment-hash-id>
git show <comment-hash-id>:file
```

### git diff 可以进行二个分支比较，二个版本比较，二个版本中具体文件比较
```
git diff branch1 branch2 显示branch2比较与branch1的变化情况
git diff <comment-hash-id>:file(旧) <comment-hash-id>:file(新) 新相对于旧的变化情况
```

> 重命名文件和删除文件是应使用 git mv/rm命令
> 尽量别使用rm

### git mv命令
```
git mv filename1,filename2

等同于
mv oldname newname
git add newname
git rm oldname
```

### git rm命令
```
git rm filename
```

### 统计代码量
```
git log --author="$(git config --get user.name)" --after="2017-01-01" --before="2017-07-01" --pretty=tformat: --numstat | gawk '{add += $1; subs += $2 ; loc += $1 - $2} END {printf "add lines: %s removed lines : %s total lines: %s\n", add, subs, loc}' -
```

### git tag

```
git tag -a v1.0 commit_id 打标签
git tag 查看所有标签
git show v1.0 具体查看标签细节
git push origin v1.0 推送标签
git tag -d test_tag　　　　　　　　本地删除tag
git push origin :refs/tags/test_tag　　　　本地tag删除了，再执行该句，删除远程tag
```

### git fork
- 当需要fork其他人的项目时候
```
// 拉取从原项目中拉取
go get -u 原始项目
// remote fork 对标自己fork过来的github地址
git remote add fork git@github.com/znddzxx112/xxx.git
git fetch fork
git push fork master
// 查看总共有哪些remote
git remote -v
// 删除/新建 remote 
git remote remove <name>
git remote add <name> <url>
```

- 维护自己的golang github仓库
```
go get -u 自己的项目
修改remote origin 改成 git@github.com 这样每次都不用输入账号密码了
```

### 查看分支
```
git branch -a
```

### 删除本地分支
```
git branch -d 分支名称
强制删除: git branch -D 分支名称
```

### 删除远程分支
```
git push origin --delete 分支名称
```

#### 查看本地分支和追踪情况

```shell
git remote show origin
```



#### 同步远程删除分支 

```shell
git remote prune origin
```



#### 删除本地多余分支

```shell
git branch -D feature/xxx
```

