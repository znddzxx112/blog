 - 签名流程概述
 ```
 1. 产生RSA密钥对
 2. 使用某种信息摘要算法对文件进行信息摘要得到摘要信息
 3. 使用RSA私钥进行加密操作
 4. 将RSA的公钥，文件和签名信息发送给接收方
 ```
 
 - 代码
 ```
 1. genrsa -out rsaprivkey.pem -passout pass:111111 -des3 1024
 2. genrsa -in rsaprivkey.pem -passin pass:111111 -out rsapubkey.pem -pubout
 3. dgst -sha1 -sign rsaprivkey.pem -out sign.txt file.doc
 4. 将file.doc sign.txt,rsapubkey.pem发送给接收方
 ```
 
 - 验证数字签名流程
 ```
 1. 对file.doc进行信息摘要
 2. 公钥解密sign.txt签名信息得到信息摘要
 3. 对比第一步与第二步的信息摘要,二者一致，则签名验证通过
 ```
 
 - 代码
 ```
 dgst -sha1 -verify rsapubkey.pem -signature sign.txt file.doc
 ```
 
 - 实例
 ```
 openssl genrsa -out privkey.pem 1024 -passout pass:xxxxxx
 openssl rsa -in privkey.pem -passin pass:xxxxxx -out pubkey.pem -pubout
 # 对文件netstat.sh私钥签名
 openssl dgst -sha1  -sign privkey.pem -out sign.txt netstat.sh
 
 # 验签
 openssl dgst -sha1 -verify pubkey.pem -signature sign.txt netstat.sh
 ```
