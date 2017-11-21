- 参考文章
```
http://man.linuxde.net/openssl
```

> 加密
```
将明文变成密文
```

> 传统加密
```
通过加密算法/过程的不同，来加密和解密明文
比如：密码本
只要加密和解密使用相同的密码本就可以获取明文
```

> 现代加密
```
加密算法/过程不变,加入秘钥，来加密和解密明文
比如：许多算法
```

> 现代加密
```
分为对称加密和非对称加密
```

> 对称加密算法
```
AES,DES
```

> 非对称加密算法
```
RSA,椭圆曲线算法(EC)
RSA算法既可以用于密钥交换，也可以用于数字签名，当然，如果你能够忍受其缓慢的速度，那么也可以用于数据加密。
DSA算法则一般只用于数字签名。
```

- 使用消息摘要
```
openssl dgst -sha mount.sh
```

- 数字签名（私钥签名，公钥验签）
> 参考文章：https://www.cnblogs.com/aLittleBitCool/archive/2011/09/22/2185418.html
> 生成公钥和私钥
```
# 创建私钥
openssl genrsa -out ckl_pri.key 1024
# 从私钥中创建公钥
openssl rsa -in ckl_pri.key -pubout -out ckl_pub.key
```

- RSA非对称加密
> 使用RSA公钥加密
```
# 文件unreply.txt一定要小
openssl rsautl -encrypt -in unreply.txt -inkey ckl_pub.key -pubin -out mount.en
```

> 使用RSA私钥解密
```
openssl rsautl -decrypt -in mount.en -inkey ckl_pri.key -out mount.de
```

