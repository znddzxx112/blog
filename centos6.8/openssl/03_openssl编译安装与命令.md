```
./configure
make 
make install
```

- openssl配置文件
```
openssl.cnf

RANDFILE=
[req]
default-bits=1024
default-keyfile=#私钥保存文件

[CA_default]
dir=./demoCA
certs=$dir/certs
crl_dir=$dir/crl
database=$dir/index.txt

```

- enc指令
```
应用程序，集成了对称加密算法
enc -ciphername|none[-in filename][-out filename][-kfile filename] -k "" -pass pass -e -d - base64
enc -aes-128-cbc cbc模式
-aes-128-cfb cfb模式
-aes-128-ecb ecb模式
-aes-128-ofb ofb模式

-des-cbc cbc模式
-des-ede3-cbc 三个密钥加密

-e 加密
-d 解密
-k "加解密用的key"
-base64 加密后的文件使用base64编码
```

- 举例
```
# 只用base64加密
openssl enc-base64 -e -in filename -out filename

# des加密在用base64编码
openssl enc -des-ede3-cbc -in xxx.in -out xxx.out -k 12345678 -e -a
openssl enc -des-ede3-cbc -in xxx.in -out xxx.out -k 12345678 -d -a

```

- 非对称加密算法-rsa
```
genrsa 生成并输出rsa私钥
rsa 处理rsa密钥的格式转换
rsautl 使用rsa进行加密解密，签名和验证

rsa加密:输入数据不能超过RSA密钥的长度 1024
输出数据长度和RSA密钥长度相同
```

- 信息摘要 dgst
```

```

- genrsa
```
openssl genrsa -out xxx.pem -passout arg -des [numbit]
比如:
openssl genrsa -out rsa.pem 1024
openssl genrsa -out rsa.pem -des3 -passout pass:xsfdas 1024
```

- 管理RSA密钥 rsa
```
可以对密钥
rsa -in rsa.pem -pubout -out pub.pem
-pubout 输出为公钥
比如：
openssl rsa -in rsa.pem -passin pass:123456 -text -noout
rsa -in privkey.pem -passin pass:123456 -out pub.pem -passout pass:xxsdfa -aes256
```

- 使用rsa密钥 - rsautl
```
rsautl [-in file][-out file][-inkey xxx.pem][-sign][-verify][-encrypt][-decrypt]
```

- rsa加密解密
```
rsautl -in plain.txt -out enc.txt -inkey pubkey.pem -pubin -encrypt
rsautl -in enc.txt -out plain.txt
-inkey prikey.pem -decrypt
```

- rsa数字验证
```
rasutl -in plain.txt -out enc.txt -inkey cert.fix -keyform pkcs12 -sign
rasutl -in enc.txt -out plain.txt -inkey cert.pfx -keyform pkcs12 -certin -verify
```

- 信息摘要 - dgst
```
dgst [-dgst_cipher] -out xxx.txt -files
```
