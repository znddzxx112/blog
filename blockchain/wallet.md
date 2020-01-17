
- 自行理解Base58算法过程以及好处
- 自行理解椭圆曲线算法ecdsa中X,Y,D三个数值

- 理解钱包
```
保存着1对私钥和公钥，通过公钥可以推导出地址
```

- 生成私钥和公钥
```
func newPair()(*ecdsa.PrivateKey, []byte)  {
	curve := elliptic.P256()
	privateKey, err := ecdsa.GenerateKey(curve, rand.Reader)
	if err != nil {
		log.Panic(err)
	}

	public := append(privateKey.PublicKey.X.Bytes(), privateKey.PublicKey.Y.Bytes()...)
	return privateKey, public
}
```

- 生成bitcoin地址
```
解释一下过程：获取到私钥和公钥后，会进行一系列处理，最终从公钥推导出对人友好的bitcoin地址
输入：公钥和1个字节的version 输出：比特币地址
address = Base58Encode(publicHash)
					publicHash = version + publicKeyHash + checksum
									version = byte(0x00)
										  publicKeyHash = rmp160(sha256(publicKey)) publicKey 为公钥
										  				checksum = sha256(sha256(version+publicKeyHash))[:4] 取前4位
```
```
// 生成bitcoin地址代码
func TestAddress(t *testing.T)  {
	privateKey , publicKey :=newPair()
	privateBase58 := Base58Encode(append(publicKey, privateKey.D.Bytes()...))
	t.Logf("%s", privateBase58)

	var publicKey256 [32]byte
	publicKey256 = sha256.Sum256(publicKey)

	ripe := ripemd160.New()
	_, err := ripe.Write(publicKey256[:])
	if err != nil {
		log.Panic(err)
	}
	pubKeyHash := ripe.Sum(nil)

	t.Logf("%x", pubKeyHash)
	// ouput:
	// 39a72cd513840ecc0998794e2ac1a12a5913620b

	versionedPayload := append([]byte{byte(0x00)}, pubKeyHash...)

	firstSHA := sha256.Sum256(versionedPayload)
	secondSHA := sha256.Sum256(firstSHA[:])

	address := Base58Encode(append(versionedPayload, secondSHA[:4]...))
	t.Logf("%s", address)
	// output:
	// 17MKgBvsLgpDERSrkbAYwqRRaXF44zAwNX
}
```

- 验证bitcoin地址是否可用
```
解释一下过程：将一个地址Base58Decode之后，第1个字节是版本，最后4个字节是checksum,中间部分是publicKeyHash
根据version和publicKeyHash重新生成checksum，进行比对判断是否可用
```
```
func TestValidateAddress(t *testing.T)  {
	//address := "17MKgBvsLgpDERSrkbAYwqRRaXF44zAwNX"
	address := "15WKSALj85d7GU5dv14i8GZJ2mThkvdUJR" // 来自btc.com
	publicHash := Base58Decode([]byte(address))

	version , publicKeyHash, actualChecksum := publicHash[0], publicHash[1:len(publicHash)-4], publicHash[len(publicHash)-4:]

	payLoad := append([]byte{version}, publicKeyHash...)
	firstSHA := sha256.Sum256(payLoad)
	secondSHA := sha256.Sum256(firstSHA[:])

	targetCheckSum := secondSHA[:4]
	if bytes.Compare(targetCheckSum, actualChecksum) == 0 {
		t.Log("address is valid")
	}else {
		t.Log("address is not valid")
	}
	// output:
	// address is valid
}
```

- 导出私钥
```
目的：私钥进行保存。我自己想的一个方案：将X,Y,D三个值拼接成byte数组，然后Base58Encode()
```
```
func TestExportPrivate(t *testing.T)  {
	privateKey, publicKey :=newPair()
	t.Logf("%x", publicKey)
	t.Logf("%x", privateKey.PublicKey.X.Bytes())
	t.Logf("%x", privateKey.PublicKey.Y.Bytes())
	t.Logf("%x", privateKey.D.Bytes())
	t.Logf("%x", append(publicKey, privateKey.D.Bytes()...))
	privateBase58 := Base58Encode(append(publicKey, privateKey.D.Bytes()...))
	t.Logf("%s", privateBase58)
	// output:
	//448eb4b03bf9858b20b93dd0802cdc7cc59233de21f35e5f1d4a19079d49442c58b8379f59998837161270cde1703cc7e531c009e2ba5506eb8bad42bdb9041f
	//448eb4b03bf9858b20b93dd0802cdc7cc59233de21f35e5f1d4a19079d49442c
	//58b8379f59998837161270cde1703cc7e531c009e2ba5506eb8bad42bdb9041f
	//0eb75569a71c23df53a4295fdbb5bf40363f1252b0d89efc0f94255bfc3180f7
	//448eb4b03bf9858b20b93dd0802cdc7cc59233de21f35e5f1d4a19079d49442c58b8379f59998837161270cde1703cc7e531c009e2ba5506eb8bad42bdb9041f0eb75569a71c23df53a4295fdbb5bf40363f1252b0d89efc0f94255bfc3180f7
	//QckHmbbmaL9prGKD5Ermu3ZCrN64udzjkkUxDS3Zhswk4J85a7rMcHJXMYPn4QxEg2LGjgVYb1abpvXEFjECoPe5i3TELQs6J2LKbecpNQLyfZdzhbxhRrUwnejzVufypKg
}
```

- 导入私钥
```
上述过程的逆操作
```
```
func TestImportPrivate(t *testing.T) {
	privateBase58 := []byte("QckHmbbmaL9prGKD5Ermu3ZCrN64udzjkkUxDS3Zhswk4J85a7rMcHJXMYPn4QxEg2LGjgVYb1abpvXEFjECoPe5i3TELQs6J2LKbecpNQLyfZdzhbxhRrUwnejzVufypKg")
	decodeBytes := Base58Decode(privateBase58)
	perLen := len(decodeBytes)/3
	X, Y , D := decodeBytes[:perLen], decodeBytes[perLen:perLen+perLen], decodeBytes[perLen+perLen:]
	privateKey := ecdsa.PrivateKey{
		ecdsa.PublicKey{
			elliptic.P256(),
			big.NewInt(1).SetBytes(X),
			big.NewInt(1).SetBytes(Y),
		},
		big.NewInt(1).SetBytes(D),
	}
	t.Logf("%x", privateKey.PublicKey.X.Bytes())
	t.Logf("%x", privateKey.PublicKey.Y.Bytes())
	t.Logf("%x", privateKey.D.Bytes())
}
```
