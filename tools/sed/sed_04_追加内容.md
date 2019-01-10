- 在匹配到的行新增行,并直接作用于文件
```
sed -i '/url/a ok' tea.php
```

- 3,7行每一行都增加新行
```
sed -i '3,7a yes' tea.php 
```

