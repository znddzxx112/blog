 - 数据机密性
 ```
 免受非法窃取，通过加密来解决
 ```
 
 - 数据完整性
 ```
 没有被修改，防止假冒。通过信息摘要和数字签名
 ```
 
 - 古典加密算法与现代加密算法
 ```
 古典加密算法基于加密算法本身
 输入:明文
 输出:密文
 基于加密算法是不同，保证安全
 现代机密算法
 输入：明文，密钥
 输出：密文
 加密算法公开，基于密钥不同
 ```
 
 - 加密算法
 ```
 1. 对称加密算法,加密解密都是同一个密钥
 2. 非对称加密算法(约等于 公开密钥算法)
 公钥 = 公开的密钥
 私钥 = 私有的密钥
 ```
 
 - 信息摘要(单向散列算法)
 ```
 大文件产生固定长度的字符串
 比如md5,sha,sha1,sha256
 ```
 
 - 数字签名算法
 ```
 可以用非对称机密算法实现
 比如RSA算法
 签名过程：
 输入:私钥,明文的散列值
 输出:签名(散列值)
 验签过程:
 输入:公钥，签名(散列值)
 输入：验签结果 比较 明文的散列值
 ```
 
 - 数字证书适用
 ```
 虽然使用了数字签名，但还是没法讲数字签名与显示中的实体对象，这时候就需要数字证书.
 验证机构CA
 负责确认身份和创建数字证书，建立身份与密钥之间的关系.包含证书签发服务。
 证书服务器
 根据注册过程中提供的信息生成证书的服务程序.
 将公钥和其他信息比如公司名称形成证书结构,
 并用CA的私钥进行签名,从而形成正式的数字证书。
 证书库
 存储可以公开发布的证书设施。
 ```
 
 - 证书验证
 ```
 1. 验证证书的签名者以确认是否信任该证书
 2. 检测证书的有效期
 3. 证书有没有被CA撤销
 4. 检测证书预期用途跟CA在证书中指定的策略是否符合
 ```
 
 - 对称加密
 ```
 算法:DES,DES3,AES
 加密过程:
 输入:密钥，明文
 输出:密文
 解密过程:
 输入:密钥,密文
 输出:明文
 ```
 
 - 非对称加密
 ```
 算法:RSA,椭圆曲线算法
 加密过程：
 输入:明文,公钥
 输出:密文
 解密过程：
 输入：密文，私钥
 输出:明文
 ```
 
 - 安全协议
 ```
 密码算法最后都以安全协议的形式得到应用。
 比如：传输层安全协议SSL,标准化版本TLs, 可以应用于传输层上的所有服务
 ```
 
 - SSL协议
 ```
 接受到底层发来的数据后,进行解密,验证,解压和重新排序组合,然后交给上层的应用协议。
 发送一个Client_hello和发送一个Server_hello
 ```
 
 - openssl简介
 ```
 采用C语言编写，具有良好的跨平台性能.
 SSL协议库,密码算法库和应用程序三部分组成。
 密码算法库实现了目前大部分主流的密码算法和标准.包括公开密钥算法，对称加密算法,散列算法,X.509数字证书标准，PKCS12，PKCS7等标准。
 ```
 
 - 各种算法的加密程序和各种类型密钥的产生程序
 
```
rsa, md5, enc等等
```
 
- ca服务器
```
ca , req , x509
```

- ssl安全连接
```
S_client,S_server
```

- 推荐书籍
```
《公钥基础设施（ＰＫＩ）———实现和管理电子安全》
```

- 基于密码学的安全通信常用流程
```
① Ｔｏｍ和Ｊｉｍ通过网络协商要使用的公开密钥算法和对称加密算法；
②Ｊｉｍ通过网络将自己的公开密钥（加密密钥）发给Ｔｏｍ；
③ Ｔｏｍ产生一个会话密钥，并使用Ｊｉｍ的公开密钥使用协商好的公开密钥算法加密
该会话密钥；
④ Ｔｏｍ通过网络传输使用Ｊｉｍ公开密钥加密后的会话密钥给Ｊｉｍ；
⑤Ｊｉｍ使用自己的私人密钥（解密密钥）解密出Ｔｏｍ发过来的会话密钥；
⑥ Ｔｏｍ使用会话密钥作为加密密钥通过协商好的对称加密算法加密要发送的信息；
⑦ Ｔｏｍ通过网络将使用会话密钥加密的信息发送给Ｊｉｍ；
⑧Ｊｉｍ使用会话密钥作为解密密钥通过协商好的对称加密算法解密Ｔｏｍ 发送过来的
```
 
- RSA数字签名过程
```
通常采用单向散列函数和公开密钥算法相结合
的数字签名解决方案。其基本步骤如下。
① Ｔｏｍ对要签名的文件使用单向散列函数，然后使用自己的私钥将得到的散列值加
密，最后将文件和加密后的散列值发送给Ｊｉｍ。
②Ｊｉｍ收到Ｔｏｍ发来的文件和加密的散列值后，用同样的单向散列函数算法对该文
件作处理得到新的散列值，然后使用Ｔｏｍ的公钥将Ｔｏｍ发送过来的加密散列值解密，并
与自己计算得到的散列值对比，如果一致，就证明文件是Ｔｏｍ做了签名的。
```
