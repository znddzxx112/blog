package fortest

import (
	"testing"
	"time"
)

var defaultobjectpool *objectpool

func init() {
	objFactory := func() (interface{}, error) {
		return "hellofoo", nil
	}
	objClose := func(interface{}) error {
		return nil
	}
	opts := NewObjectOptions(5, 3, 8, objFactory, objClose, 1)
	defaultobjectpool = NewObjectpool(opts)
}

func Test_objectpool_Get_Put(t *testing.T) {
	//t.Log(time.Now().Add(time.Second*60).Unix() - time.Now().Unix())
	var obj interface{}
	var err error
	for i := 1; i <= 8; i++ {
		obj, err = defaultobjectpool.Get()
		if err != nil {
			t.Errorf("%v", err)
		}
		if defaultobjectpool.stat.usedObjectSize > 8 || defaultobjectpool.stat.unusedObjectSize < 0 {
			u, uu := defaultobjectpool.Stat()
			t.Errorf("%v, %v", u, uu)
		}

	}

	for i := 1; i <= 2; i++ {
		obj, err = defaultobjectpool.Get()
		if err != ErrTooObject {
			t.Errorf("%v", err)
		}
	}

	for i := 1; i <= 10; i++ {
		defaultobjectpool.Put("newfoo")
		if defaultobjectpool.stat.usedObjectSize < 0 || defaultobjectpool.stat.unusedObjectSize > 3 {
			u, uu := defaultobjectpool.Stat()
			t.Errorf("%v, %v", u, uu)
		}
	}

	for i := 1; i <= 2; i++ {
		obj, err = defaultobjectpool.Get()
		//t.Log(obj.(string))
		if obj.(string) != "newfoo" {
			t.Error(obj)
		}
	}

	time.Sleep(time.Second * 2)
	// check lifttime
	for i := 1; i <= 2; i++ {
		obj, err = defaultobjectpool.Get()
		//t.Log(obj.(string))
		if obj.(string) != "hellofoo" {
			t.Error(obj)
		}
	}

	defaultobjectpool.Close()

	defaultobjectpool.Put("newfoo2")
	_, err = defaultobjectpool.Get()
	if err != ErrPoolClose {
		t.Errorf("%v", err)
	}
}
