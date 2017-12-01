```
密码学-机密性，完整性
C 明文 M 密文
M = E(C)
C = Ddcrypt(Encrypt(C))
古典加密（密码本），现代加密(基于秘钥)

对称加密，非对称加密（公开密钥算法）
加密
输入：明文 + 秘钥
输出：密文
解密
输入：密文 + 秘钥
输出：明文

非对称加密
输入：明文 + 公钥（密钥）
输出：密文

非对称解密
输入：密文 + 私钥
输出：明文

数字签名动作
输入： 文件 + 私钥
输出：签名文件

验签：
输入:  文件 + 公钥 + 签名文件
输出: 验证结果

对称加密 aes,des
非对称加密 dh, rsa[], ec（椭圆曲线算法）
openssl genrsa -out privkey.pem 1024 -passout pass:xxxxxx
openssl rsa -in privkey.pem -passin pass:xxxxxx -out pubkey.pem -pubout
openssl dgst -sha1  -sign privkey.pem -out sign.txt netstat.sh
openssl dgst -sha1 -verify pubkey.pem -signature sign.txt netstat.sh

openssl rsautl -encrypt -in rsapri.data -out rsapri.data.en -inkey pubkey.pem -pubin -passin pass:xxxxxx
openssl rsautl -decrypt -in rsapri.data.en -out rsapri.data.de -inkey privkey.pem -passin pass:xxxxxx


对称加密目的：1. 加密数据
非对称加密目的：1. 对称加密的密钥交换 2. 数字签名
https交互流程
1. 浏览器向服务hello
2. 服务器 证书（公钥） 浏览器
3. 证书 向 CA机构
4. 证书中的公钥 浏览器产生的随机数(对称加密的秘钥) 给服务器
5. 服务器 私钥 解密，得到 随机数(对称加密的秘钥)
6. 服务器 用 随机数 加密hello 发给浏览器
7. 浏览器用随机数 解密,确认服务器已经获取到了随机数。
8. ...

openssl
算法库,ssl,应用程序


信息摘要目的：完整性

对称加密 aes,des
openssl enc -des-cbc -in netstat.sh -kfile deskey -out netstat.en
openssl enc -des-cbc -in netstat.en -kfile deskey -out netstat.en.sh -d

非对称加密(公开秘钥算法) dh, rsa[], ec（椭圆曲线算法）
openssl genrsa -out privkey.pem 1024 -passout pass:xxxxxx
openssl rsa -in privkey.pem -passin pass:xxxxxx -out pubkey.pem -pubout

openssl rsautl -encrypt -in rsapri.data -out rsapri.data.en -inkey pubkey.pem -pubin -passin pass:xxxxxx
openssl rsautl -decrypt -in rsapri.data.en -out rsapri.data.de -inkey privkey.pem -passin pass:xxxxxx

数字签名
openssl dgst -sha1  -sign privkey.pem -out sign.txt netstat.sh
openssl dgst -sha1 -verify pubkey.pem -signature sign.txt netstat.sh
```
