- 加密
```
openssl enc -des-cbc -in netstat.sh -kfile deskey -out netstat.en
```

- 解密
```
openssl enc -des-cbc -in netstat.en -kfile deskey -out netstat.en.sh -d
```

- 生成公私钥
```
openssl genrsa -out privkey.pem 1024 -passout pass:xxxxxx
openssl rsa -in privkey.pem -passin pass:xxxxxx -out pubkey.pem -pubout
```

- 加密
```
openssl rsautl -encrypt -in rsapri.data -out rsapri.data.en -inkey pubkey.pem -pubin -passin pass:xxxxxx
```

- 解密
```
openssl rsautl -decrypt -in rsapri.data.en -out rsapri.data.de -inkey privkey.pem -passin pass:xxxxxx
```
