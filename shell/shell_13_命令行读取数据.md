- getopts
```

#! /bin/bash

echo $#; 
echo $(basename $0) 

while getopts :ab:c opt 
do
        case $opt in
                a)  
                        echo a selected;;
                b)  
                        echo b values $OPTARG;;
                c)  
                        echo c selected;;
                *)  
                        echo true optarg;;
        esac
done

```
