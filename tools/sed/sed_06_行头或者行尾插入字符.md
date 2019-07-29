- 在行头插入#字符
```
sed -i '/url/s/^/#/p' tea.php
sed -i '/^10\.10\.80\.240 sns-user$/s/^/#&/g' /hosts
```

- 在行尾插入#字符
```
sed -i '/url/s/$/#/p' tea.php
sed -in '/^10\.10\.80\.240 sns-user$/s/$/&#/g' /hosts
```
