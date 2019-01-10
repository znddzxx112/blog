- 在行头插入#字符
```
sed -i '/url/s/^/#/p' tea.php
```

- 在行尾插入#字符
```
sed -i '/url/s/$/#/p' tea.php
```
