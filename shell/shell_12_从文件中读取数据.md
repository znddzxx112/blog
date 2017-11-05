```
#! /bin/bash 


IFS_OLD=$IFS
# IFS=:
for item in $(cat /etc/passwd)
do
        echo $item
done 
IFS=$IFS_OLD


#input="/etc/passwd";
#while read -r line 
#do
#       echo $line;         
#           
#done < $input
```
