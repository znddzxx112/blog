package fortest

import (
	"errors"
	"sync"
	"time"
)

// like:https://github.com/fatih/pool
// 作用：对象复用，降低GC压力,更少资源

var ErrTooObject = errors.New("too object")
var ErrPoolClose = errors.New("pool has closed")

type objectpool struct {
	mu         sync.RWMutex
	objectchan chan *object

	opts    *objectOptions
	stat    *poolStatistic
	isclose bool
}

type object struct {
	obj        interface{}
	createTime time.Time
}

type objectFactory func() (interface{}, error)
type objectClose func(interface{}) error
type objectOptions struct {
	// struct objectpool opts
	initialObjectSize int
	minObjectSize     int
	maxObjectSize     int
	// struct object opts
	objFactory  objectFactory
	objClose    objectClose
	objLifttime time.Duration
}

type poolStatistic struct {
	unusedObjectSize int
	usedObjectSize   int
}

func NewObjectOptions(initialSize, minSize, maxSize int, objFactory objectFactory, objClose objectClose, objLifttime time.Duration) *objectOptions {
	opt := new(objectOptions)
	opt.initialObjectSize = initialSize
	opt.minObjectSize = minSize
	opt.maxObjectSize = maxSize
	opt.objFactory = objFactory
	opt.objClose = objClose
	opt.objLifttime = objLifttime
	return opt
}

func NewObjectpool(opts *objectOptions) *objectpool {
	objectpool := new(objectpool)
	objectpool.mu.Lock()
	defer objectpool.mu.Unlock()

	objectpool.opts = opts
	objectpool.stat = &poolStatistic{
		unusedObjectSize: opts.initialObjectSize,
		usedObjectSize:   0,
	}
	objectpool.isclose = false

	objectpool.objectchan = make(chan *object, opts.maxObjectSize)
	for i := 1; i <= opts.initialObjectSize; i++ {
		if obj, err := opts.objFactory(); err == nil {
			objectpool.objectchan <- &object{obj: obj, createTime: time.Now()}
		} else {
			objectpool.stat.unusedObjectSize--
		}
	}
	return objectpool
}

func (pool *objectpool) Get() (interface{}, error) {
	pool.mu.Lock()
	defer pool.mu.Unlock()
	if pool.isclose {
		return nil, ErrPoolClose
	}
	if pool.stat.usedObjectSize >= pool.opts.maxObjectSize {
		return nil, ErrTooObject
	}

	select {
	case object := <-pool.objectchan:
		pool.stat.unusedObjectSize--
		pool.stat.usedObjectSize++
		// check object lifttime
		if pool.opts.objLifttime != 0 {
			if (object.createTime.Add(pool.opts.objLifttime).Unix() - time.Now().Unix()) < 0 {
				return pool.opts.objFactory()
			}
		}
		return object.obj, nil
	default:
		pool.stat.usedObjectSize++
		return pool.opts.objFactory()
	}
}

func (pool *objectpool) Put(obj interface{}) {
	pool.mu.Lock()
	defer pool.mu.Unlock()
	if pool.isclose {
		return
	}
	if pool.stat.usedObjectSize > 0 {
		pool.stat.usedObjectSize--
	}
	if pool.stat.unusedObjectSize >= pool.opts.minObjectSize {
		pool.opts.objClose(obj)
		return
	}
	pool.stat.unusedObjectSize++
	pool.objectchan <- &object{obj: obj, createTime: time.Now()}
	return
}

func (pool *objectpool) Stat() (unusedObjectSize, usedObjectSize int) {
	return pool.stat.unusedObjectSize, pool.stat.usedObjectSize
}

func (pool *objectpool) Close() {
	pool.mu.Lock()
	defer pool.mu.Unlock()

	pool.isclose = true
	close(pool.objectchan)
	for obj := range pool.objectchan {
		pool.opts.objClose(obj)
	}
	pool.stat = nil
	pool.opts = nil
}
