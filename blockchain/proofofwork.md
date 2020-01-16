- 请先理解移位操作
```
func TestOp(t *testing.T)  {
	t.Logf("%b=%d", 1<<2, 1<<2)
	t.Logf("%b=%d", 1<<3, 1<<3)
	target := big.NewInt(1)
	target.Lsh(target, 10)
	t.Logf("%b=%d", target, target)
	//output:
	//100=4
	//1000=8
	//10000000000=1024
}
请思考下面uint(256-16)中16的特殊含义？
func TestOpBig(t *testing.T) {
	target := big.NewInt(1)
	target.Lsh(target, uint(256-16))
	t.Logf("%b=%d", target, target)
  // output:
	// 1000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000=1766847064778384329583297500742918515827483896875618958121606201292619776
}
```
- 请先理解hash
```
func TestHash(t *testing.T)  {
	var data []byte = []byte("foo")
	var hash [32]byte
	hash =sha256.Sum256(data)
	t.Logf("%x=%b", hash, hash)

	var hashInt big.Int
	hashInt.SetBytes(hash[:])
	t.Logf("%b=%d", hashInt.Uint64(),hashInt.Uint64())
	// output:
	// 2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae=[101100 100110 10110100 1101011 1101000 11111111 11000110 10001111 11111001 10011011 1000101 111100 11101 110000 1000001 110100 10011 1000010 101101 1110000 1100100 10000011 10111111 10100000 11111001 10001010 1011110 10001000 1100010 1100110 11100111 10101110]
	// 1111100110001010010111101000100001100010011001101110011110101110=17981288402089600942
}
这里使用的是32位byte（256的bit）的hash
并将hash转化为一个大数
```

- 理解工作量证明
```
通过计算得出的数值小于设定的目标值
func TestProof(t *testing.T) {
	var data []byte = []byte("foo")
	var hash [32]byte
	var hashInt big.Int
	hash =sha256.Sum256(data)
	hashInt.SetBytes(hash[:])

	target1 := big.NewInt(1)
	target1.Lsh(target1, 253)
	t.Log(hashInt.Cmp(target1)) //output:1 hashInt > target

	target2 := big.NewInt(1)
	target2.Lsh(target1, 254)
	t.Log(hashInt.Cmp(target2)) //output:-1 hashInt < target, got
}
思考：32位byte的hash如何与大数进行比较？
答：对于计算机而言都是bit，高位的0越多，这个数就越小。
上面的uint(256-16)中16代表前面有16个0的数，本质是控制高位0的位数就能达到目标值的大小，进而控制证明难度
```

- 下面是一个工作量证明示例
```
import (
	"bytes"
	"crypto/sha256"
	"encoding/binary"
	"fmt"
	"log"
	"math"
	"math/big"
)

const targetBits = 16

type ProofOfWork struct {
	target *big.Int
}

func NewProofOfWork() *ProofOfWork  {
	pow := new(ProofOfWork)
	target := big.NewInt(1)
	target.Lsh(target, uint(256-targetBits))

	pow.target = target
	return pow
}

var data = "hellofoo"

func (pow *ProofOfWork) Run() (int, []byte)  {
	fmt.Printf("Mining a new block")
	var hashInt big.Int
	var hash [32]byte

	nonce := 0
	for nonce < math.MaxInt64 {
		data := pow.prepareData(nonce)

		hash = sha256.Sum256(data)
		if math.Remainder(float64(nonce), 100000) == 0 {
			fmt.Printf("\r%x", hash)
		}
		hashInt.SetBytes(hash[:])

		if hashInt.Cmp(pow.target) == -1 {
			break
		}
		nonce++
	}
	return nonce, hash[:]
}

func (pow *ProofOfWork) prepareData(nonce int) []byte {
	return bytes.Join([][]byte{
		[]byte(data),
		IntToHex(int64(nonce)),
	}, []byte{})
}

// IntToHex converts an int64 to a byte array
func IntToHex(num int64) []byte {
	buff := new(bytes.Buffer)
	err := binary.Write(buff, binary.BigEndian, num)
	if err != nil {
		log.Panic(err)
	}

	return buff.Bytes()
}
```
