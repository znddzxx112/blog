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
