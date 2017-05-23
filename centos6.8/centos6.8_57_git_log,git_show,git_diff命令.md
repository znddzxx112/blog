- git log 可以查看某一个分支的记录，某一个文件的历史记录
```
git log --pretty=oneline -3 <comment-hash-id>
git log --pretty=oneline -3 <comment-hash-id>:file
```

- git show 查看某个分支的提交记录，查看某个分支下的提交的文件记录  --stat只显示文件不包含具体改动内容
```
git show --stat <comment-hash-id>
git show <comment-hash-id>:file
```

- git diff 可以进行二个分支比较，二个版本比较，二个版本中具体文件比较
```
git diff branch1 branch2 显示branch2比较与branch1的变化情况
git diff <comment-hash-id>:file(旧) <comment-hash-id>:file(新) 新相对于旧的变化情况
```
