 - export
 ```
 变量导出,当前shell往后运行的脚本都可以继承该变量
 export foo=bar
 ```
 
 - 打印当前shell的所有变量
 ```
 export -p
 ```
 
 - 设置全局的环境变量
 ```
 vim /etc/profile
 export PATH=$PATH:/usr/local/go/bin
 export PATH=$PATH:$home/bin
 ```
 
 - 设置用户的环境变量
 ```
 vim ~/.bashrc
 export PATH=$PATH:$home/bin
 ```
 
 
