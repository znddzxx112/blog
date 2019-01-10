- zsh
```
终极zsh

```

- 查看是否安装zsh
```
cat /etc/shells
```
- zsh安装
```
yum install zsh
```
- 查看当前使用什么shell
```

```
- zsh设置为默认shell
```
usermod -s /bin/zsh username
或者
chsh -s /bin/zsh 

touch ~/.zshrc
```

- 安装ozh
```
先到需要安装ozh的账户中，再执行下面的命令

sh -c "$(wget https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh -O -)"
或者
sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"

手动安装
git clone git://github.com/robbyrussell/oh-my-zsh.git ~/.oh-my-zsh
cp ~/.oh-my-zsh/templates/zshrc.zsh-template ~/.zshrc

```

- 使用配色主题
```
查看选择主题
https://github.com/robbyrussell/oh-my-zsh/wiki/Themes
vim ~/.zshrc
ZSH_THEME="mortalscumbag"
source ~/.zshrc
```

- 安装插件
```
查看插件
https://github.com/robbyrussell/oh-my-zsh/wiki/Plugins
插件分类
https://github.com/robbyrussell/oh-my-zsh/wiki/Plugins-Overview

vim ~/.zshrc
plugins=(git autojump)

git clone git://github.com/joelthelion/autojump.git
cd autojump
./install.py or ./uninstall.py
vim ~/.zshrc
加入下面一句
    [[ -s /home/caokelei/.autojump/etc/profile.d/autojump.sh ]] && source /home/caokelei/.autojump/etc/profile.d/autojump.sh

    
重启ternimal
```
