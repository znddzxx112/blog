```
#!/bin/bash

function_cli_redis() {
sudo /usr/local/bin/redis-cli -h 192.168.xxx -p 6379 -a xxx
}

function_cli_mysql() {
mysql -h 192.168.xxx -u xxx -P 3306 -pxxx
}

function_cli_mongo() {
mongo
}

function_cli_sqs() {
        echo "name=$1";
        echo "opt=$2";
        echo "pos=$3";
curl "http://192.168.xxx/?name=$1&opt=$2&pos=$3"
}


case $1 in
redis)
function_cli_redis;;
mysql)
function_cli_mysql;;
mongo)
function_cli_mongo;;
sqs)
# cli sqs name opt pos
function_cli_sqs $2 $3 $4;;
*)
echo "cli not exist";;
esac
```
