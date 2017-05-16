```
#!/bin/bash

function_cli_redis() {
sudo /usr/local/bin/redis-cli -h xxx -p 6379 -a xxx
}

function_cli_mysql() {
mysql -h xxx -u root -P 3306 -p111111
}

function_cli_mongo() {
mongo
}

case $1 in
redis)
function_cli_redis;;
mysql)
function_cli_mysql;;
mongo)
function_cli_mongo;;
*)
echo "cli not exist";;
esac
```
