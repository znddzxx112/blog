- 循环 loop
- while do done
```
while []
do

done
```

- for do done
```
for var in con1 con2 con3 ...
do 

done
```

- for do done
```
for (( 初始值; 限制值; 执行步长))
do
    程序段
done
```

- for example
```
#!/bin/bash

for((i=0;i<=100;i++))
do
    // ...
done
```

- foreach
```
calNum=(1 2 3 4); 
for num in ${calNum[*]}
do
        echo ${num};
done
```
