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
