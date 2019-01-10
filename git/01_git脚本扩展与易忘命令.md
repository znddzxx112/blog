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

```

Git钩子最常见的使用场景包括推行提交规范，根据仓库状态改变项目环境，和接入持续集成工作流。但是，因为脚本可以完全定制，你可以用Git钩子来自动化或者优化你开发工作流中任意部分。
```
- 安装钩子
- .git/hooks/ 去掉.sample后缀，在文件中写入即可
```
applypatch-msg.sample       pre-push.sample
commit-msg.sample           pre-rebase.sample
post-update.sample          prepare-commit-msg.sample
pre-applypatch.sample       update.sample
pre-commit.sample

```
- $ chmod +x prepare-commit-msg

```
在开发团队中维护钩子是比较复杂的，因为.git/hooks目录不随你的项目一起拷贝，也不受版本控制影响。一个简单的解决办法是把你的钩子存在项目的实际目录中（在.git 外）。这样你就可以像其他文件一样进行版本控制。为了安装钩子，你可以在.git/hooks中创建一个符号链接，或者简单地在更新后把它们复制到.git/hooks目录下。
```

- 实践做法
```
有一个专门的项目保存书写的 bin，hooks
在一个具体的项目中，.git/hooks 指向专门项目中的hooks
专门项目中bin命令目录放到环境变量中
通常执行类似 . install.sh
然后在具体项目中执行bin中命令 git-install 将hooks复制到具体目录
```

- install.sh
```
#!/bin/bash
cmdPath=$(dirname `realpath BASH_SOURCE[0]`)
gitConfigPath=$(which git-install-hxhooks 2>/dev/null)
if [ -z $gitConfigPath ]
then
    gitBinPath = ''
else
    gitBinPath = $(dirname $gitConfigPath)
fi
currentBinPath=${cmdPath}/bin
if [[ $currentBinPath == $gitBinPath]]
then
    echo 'git install'
    return 0;
fi

cmd='export PATH=$PATH:'${currentBinPath}
echo $cmd >> ~/.bash_profile
echo 'Install success!'
export PATH=$PATH:$currentBinPath
return 0
```

```
项目中bin/下的命令可以随意执行了
```

- git-install-hooks
```
if [[ ! -d `pwd`/.git ]]
then
    echo `pwd` 'is not a git repository.';
    exit 0;
fi

cp $(dirname `realpath $0`)/../hooks/* .git/hoooks
echo 'success'
```

- 有用的几个钩子
- 本地钩子
```
在这一节中，我们会探讨6个最有用的本地钩子：

pre-commit
prepare-commit-msg
commit-msg
post-commit
post-checkout
pre-rebase
前四个钩子让你介入完整的提交生命周期，后两个允许你执行一些额外的操作，分别为git checkout和git rebase的安全检查。

所有带pre- 的钩子允许你修改即将发生的操作，而带post- 的钩子只能用于通知。

我们也会看到处理钩子的参数和用底层Git命令获取仓库信息的实用技巧。
```

```
pre-commit

pre-commit脚本在每次你运行git commit命令时，Git向你询问提交信息或者生产提交对象时被执行。你可以用这个钩子来检查即将被提交的代码快照。比如说，你可以运行一些自动化测试，保证这个提交不会破坏现有的功能。

pre-commit不需要任何参数，以非0状态退出时将放弃整个提交。让我们看一个简化了的（和更详细的）内置pre-commit钩子。只要检测到不一致时脚本就放弃这个提交，就像git diff-index命令定义的那样（只要词尾有空白字符、只有空白字符的行、行首一个tab后紧接一个空格就被认为错误）。

#!/bin/sh

# 检查这是否是初始提交
if git rev-parse --verify HEAD >/dev/null 2>&1
then
    echo "pre-commit: About to create a new commit..."
    against=HEAD
else
    echo "pre-commit: About to create the first commit..."
    against=4b825dc642cb6eb9a060e54bf8d69288fbee4904
fi

# 使用git diff-index来检查空白字符错误
echo "pre-commit: Testing for whitespace errors..."
if ! git diff-index --check --cached $against
then
    echo "pre-commit: Aborting commit due to whitespace errors"
    exit 1
else
    echo "pre-commit: No whitespace errors :)"
    exit 0
fi
使用git diff-index时我们要指出和哪次提交进行比较。一般来说是HEAD，但HEAD在创建第一次提交时不存在，所以我们的第一个任务是解决这个极端情形。我们通过git rev-parse --verify来检查HEAD是否是一个合法的引用。>/dev/null 2>&1这部分屏蔽了git rev-parse任何输出。HEAD或者一个新的提交对象被储存在against变量中供git diff-index使用。4b825d...这个哈希字串代表一个空白提交的ID。

git diff-index --cached命令将提交和缓存区比较。通过传入-check选项，我们要求它在更改引入空白字符错误时警告我们。如果它这么做了，我们返回状态1来放弃这次提交，否则返回状态0，提交工作流正常进行。

这只是pre-commit的其中一个例子。它恰好使用了已有的Git命令来根据提交带来的更改进行测试，但你可以在pre-commit中做任何你想做的事，比如执行其它脚本、运行第三方测试集、用Lint检查代码风格。

prepare-commit-msg

prepare-commit-msg钩子在pre-commit钩子在文本编辑器中生成提交信息之后被调用。这被用来方便地修改自动生成的squash或merge提交。

prepare-commit-msg脚本的参数可以是下列三个：

包含提交信息的文件名。你可以在原地更改提交信息。
提交类型。可以是信息（-m或-F选项），模板（-t选项），merge（如果是个合并提交）或squash（如果这个提交插入了其他提交）。
相关提交的SHA1哈希字串。只有当-c，-C，或--amend选项出现时才需要。
和pre-commit一样，以非0状态退出会放弃提交。

我们已经看过一个修改提交信息的简单例子，现在我们来看一个更有用的脚本。使用issue跟踪器时，我们通常在单独的分支上处理issue。如果你在分支名中包含了issue编号，你可以使用prepare-commit-msg钩子来自动地将它包括在那个分支的每个提交信息中。

#!/usr/bin/env python

import sys, os, re
from subprocess import check_output

# 收集参数
commit_msg_filepath = sys.argv[1]
if len(sys.argv) > 2:
    commit_type = sys.argv[2]
else:
    commit_type = ''
if len(sys.argv) > 3:
    commit_hash = sys.argv[3]
else:
    commit_hash = ''

print "prepare-commit-msg: File: %s\nType: %s\nHash: %s" % (commit_msg_filepath, commit_type, commit_hash)

# 检测我们所在的分支
branch = check_output(['git', 'symbolic-ref', '--short', 'HEAD']).strip()
print "prepare-commit-msg: On branch '%s'" % branch

# 用issue编号生成提交信息
if branch.startswith('issue-'):
    print "prepare-commit-msg: Oh hey, it's an issue branch."
    result = re.match('issue-(.*)', branch)
    issue_number = result.group(1)

    with open(commit_msg_filepath, 'r+') as f:
        content = f.read()
        f.seek(0, 0)
        f.write("ISSUE-%s %s" % (issue_number, content))
首先，上面的prepare-commit-msg钩子告诉你如何收集传入脚本的所有参数。接下来，它调用了git symbolic-ref --short HEAD来获取对应HEAD的分支名。如果分支名以issue-开头，它会重写提交信息文件，在第一行加上issue编号。比如你的分支名issue-224 ，下面的提交信息将会生成：

ISSUE-224 

# Please enter the commit message for your changes. Lines starting 
# with '#' will be ignored, and an empty message aborts the commit. 
# On branch issue-224 
# Changes to be committed: 
#   modified:   test.txt
有一点要记住的是即使用户用-m传入提交信息，prepare-commit-msg 也会运行。也就是说，上面这个脚本会自动插入ISSUE-[#]字符串，而用户无法更改。你可以检查第二个参数是否是提交类型来处理这个情况。

但是，如果没有-m选项，prepare-commit-msg钩子允许用户修改生成后的提交信息。所以脚本的目的是为了方便，而不是推行强制的提交信息规范。如果你要这么做，你需要下一节所讲的commit-msg钩子。

commit-msg

commit-msg钩子和prepare-commit-msg钩子很像，但它会在用户输入提交信息之后被调用。这适合用来提醒开发者他们的提交信息不符合你团队的规范。

传入这个钩子唯一的参数是包含提交信息的文件名。如果它不喜欢用户输入的提交信息，它可以在原地修改这个文件（和prepare-commit-msg一样），或者它会以非0状态退出，放弃这个提交。

比如说，下面这个脚本确认用户没有删除prepare-commit-msg脚本自动生成的ISSUE-[#]字符串。

#!/usr/bin/env python

import sys, os, re
from subprocess import check_output

# 收集参数
commit_msg_filepath = sys.argv[1]

# 检测所在的分支
branch = check_output(['git', 'symbolic-ref', '--short', 'HEAD']).strip()
print "commit-msg: On branch '%s'" % branch

# 检测提交信息，判断是否是一个issue提交
if branch.startswith('issue-'):
    print "commit-msg: Oh hey, it's an issue branch."
    result = re.match('issue-(.*)', branch)
    issue_number = result.group(1)
    required_message = "ISSUE-%s" % issue_number

    with open(commit_msg_filepath, 'r') as f:
        content = f.read()
        if not content.startswith(required_message):
            print "commit-msg: ERROR! The commit message must start with '%s'" % required_message
            sys.exit(1)
虽然用户每次创建提交时，这个脚本都会运行。但你还是应该避免做检查提交信息之外的事情。如果你需要通知其他服务一个快照已经被提交了，你应该使用post-commit这个钩子。

post-commit

post-commit钩子在commit-msg钩子之后立即被运行 。它无法更改git commit的结果，所以这主要用于通知用途。

这个脚本没有参数，而且退出状态不会影响提交。对于大多数post-commit脚本来说，你只是想访问你刚刚创建的提交。你可以用git rev-parse HEAD来获得最近一次提交的SHA1哈希字串，或者你可以用git log -l HEAD获取完整的信息。

比如说，如果你需要每次提交快照时向老板发封邮件（也许对于大多数工作流来说这不是个好的想法），你可以加上下面这个post-commit钩子。

#!/usr/bin/env python

import smtplib
from email.mime.text import MIMEText
from subprocess import check_output

# 获得新提交的git log --stat输出
log = check_output(['git', 'log', '-1', '--stat', 'HEAD'])

# 创建一个纯文本的邮件内容
msg = MIMEText("Look, I'm actually doing some work:\n\n%s" % log)

msg['Subject'] = 'Git post-commit hook notification'
msg['From'] = 'mary@example.com'
msg['To'] = 'boss@example.com'

# 发送信息
SMTP_SERVER = 'smtp.example.com'
SMTP_PORT = 587

session = smtplib.SMTP(SMTP_SERVER, SMTP_PORT)
session.ehlo()
session.starttls()
session.ehlo()
session.login(msg['From'], 'secretPassword')

session.sendmail(msg['From'], msg['To'], msg.as_string())
session.quit()
你虽然可以用post-commit来触发本地的持续集成系统，但大多数时候你想用的是post-receive这个钩子。它运行在服务端而不是用户的本地机器，它同样在任何开发者推送代码时运行。那里更适合你进行持续集成。

post-checkout

post-checkout钩子和post-commit钩子很像，但它在你用git checkout查看引用的时候被调用。这是用来清理你的工作目录中可能会令人困惑的生成文件。

这个钩子接受三个参数，它的返回状态不影响git checkout命令。

HEAD前一次提交的引用
新的HEAD的引用
1或0，分别代表是分支checkout还是文件checkout。
Python程序员经常遇到的问题是切换分支后那些之前生成的.pyc文件。解释器有时使用.pyc而不是.py文件。为了避免歧义，你可以在每次用post-checkout切换到新的分支的时候，删除所有.pyc文件。

#!/usr/bin/env python

import sys, os, re
from subprocess import check_output

# 收集参数
previous_head = sys.argv[1]
new_head = sys.argv[2]
is_branch_checkout = sys.argv[3]

if is_branch_checkout == "0":
    print "post-checkout: This is a file checkout. Nothing to do."
    sys.exit(0)

print "post-checkout: Deleting all '.pyc' files in working directory"
for root, dirs, files in os.walk('.'):
    for filename in files:
        ext = os.path.splitext(filename)[1]
        if ext == '.pyc':
            os.unlink(os.path.join(root, filename))
钩子脚本当前的工作目录总是位于仓库的根目录下，所以os.walk('.')调用遍历了仓库中所有文件。接下来，我们检查它的拓展名，如果是.pyc就删除它。

通过post-checkout钩子，你还可以根据你切换的分支来来更改工作目录。比如说，你可以在代码库外面使用一个插件分支来储存你所有的插件。如果这些插件需要很多二进制文件而其他分支不需要，你可以选择只在插件分支上build。

pre-rebase

pre-rebase钩子在git rebase发生更改之前运行，确保不会有什么糟糕的事情发生。

这个钩子有两个参数：frok之前的上游分支，将要rebase的下游分支。如果rebase当前分支则第二个参数为空。以非0状态退出会放弃这次rebase。

比如说，如果你想彻底禁用rebase操作，你可以使用下面的pre-rebase脚本：

#!/bin/sh

# 禁用所有rebase
echo "pre-rebase: Rebasing is dangerous. Don't do it."
exit 1
每次运行git rebase，你都会看到下面的信息：

pre-rebase: Rebasing is dangerous. Don't do it.
The pre-rebase hook refused to rebase.
内置的pre-rebase.sample脚本是一个更复杂的例子。它在何时阻止rebase这方面更加智能。它会检查你当前的分支是否已经合并到了下一个分支中去（也就是主分支）。如果是的话，rebase可能会遇到问题，脚本会放弃这次rebase。
```

- 服务器钩子
```
服务端钩子和本地钩子几乎一样，只不过它们存在于服务端的仓库中（比如说中心仓库，或者开发者的公共仓库）。当和官方仓库连接时，其中一些可以用来拒绝一些不符合规范的提交。

这节中我们要讨论下面三个服务端钩子：

pre-receive
update
post-receive
这些钩子都允许你对git push的不同阶段做出响应。

服务端钩子的输出会传送到客户端的控制台中，所以给开发者发送信息是很容易的。但你要记住这些脚本在结束完之前都不会返回控制台的控制权，所以你要小心那些长时间运行的操作。

pre-receive

pre-receive钩子在有人用git push向仓库推送代码时被执行。它只存在于远端仓库中，而不是原来的仓库中。

这个钩子在任意引用被更新钱被执行，所以这是强制推行开发规范的好地方。如果你不喜欢推送的那个人（多大仇= =），提交信息的格式，或者提交的更改，你都可以拒绝这次提交。虽然你不能阻止开发者写出糟糕的代码，但你可以用pre-receive防止这些代码流入官方的代码库。

这个脚本没有参数，但每一个推送上来的引用都会以下面的格式传入脚本的单独一行：

<old-value> <new-value> <ref-name>
你可以看到这个钩子做了非常简单的事，就是读取推送上来的引用并且把它们打印出来。

#!/usr/bin/env python

import sys
import fileinput

# 读取用户试图更新的所有引用
for line in fileinput.input():
    print "pre-receive: Trying to push ref: %s" % line

# 放弃推送
# sys.exit(1)
这和其它钩子相比略微有些不同，因为信息是通过标准输入而不是命令行传入的。在远端仓库的.git/hooks中加上这个脚本，推送到master分支，你会看到下面这些信息打印出来：

b6b36c697eb2d24302f89aa22d9170dfe609855b 85baa88c22b52ddd24d71f05db31f4e46d579095 refs/heads/master
你可以用SHA1哈希字串，或者底层的Git命令，来检查将要引入的更改。一些常见的使用包括：

拒绝将上游分支rebase的更改
防止错综复杂的合并（非快速向前，会造成项目历史非线性）
检查用户是否有正确的权限来做这些更改（大多用于中心化的Git工作流中）
如果多个引用被推送，在pre-receive中返回非0状态，拒绝所有提交。如果你想一个个接受或拒绝分支，你需要使用update钩子
update

update钩子在pre-receive之后被调用，用法也差不多。它也是在实际更新前被调用的，但它可以分别被每个推送上来的引用分别调用。也就是说如果用户尝试推送到4个分支，update会被执行4次。和pre-receive不一样，这个钩子不需要读取标准输入。事实上，它接受三个参数：

更新的引用名称
引用中存放的旧的对象名称
引用中存放的新的对象名称
这些信息和pre-receive相同，但因为每次引用都会分别触发更新，你可以拒绝一些引用而接受另一些。

#!/usr/bin/env python

import sys

branch = sys.argv[1]
old_commit = sys.argv[2]
new_commit = sys.argv[3]

print "Moving '%s' from %s to %s" % (branch, old_commit, new_commit)

# 只放弃当前分支的推送
# sys.exit(1)
上面这个钩子简单地输出了分支和新旧提交的哈希字串。当你向远程仓库推送超过一个分支时，你可以看到每个分支都有输出。

post-receive

post-receive钩子在成功推送后被调用，适合用于发送通知。对很多工作流来说，这是一个比post-commit更好的发送通知的地方，因为这些更改在公共的服务器而不是用户的本地机器上。给其他开发者发送邮件或者触发一个持续集成系统都是post-receive常用的操作。

这个脚本没有参数，但和pre-receive一样通过标准输入读取。
```
