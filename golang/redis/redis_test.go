package fortest

import (
	"github.com/go-redis/redis"
	"sync"
	"testing"
	"time"
)

func init() {
	NewRedisClientPool("6379write", &redis.Options{
		Network:      "tcp",
		Addr:         "127.0.0.1:6379",
		PoolSize:     3,
		MinIdleConns: 2,
	})
	NewRedisClusterPool("clusterwrite", &redis.ClusterOptions{
		Addrs:        []string{"127.0.0.1:7000", "127.0.0.1:7001", "127.0.0.1:7002"},
		PoolSize:     3,
		MinIdleConns: 2,
	})
}

func TestNewRedisClientPool(t *testing.T) {
	client, err := GetRedisClientPool("6379write")
	if err != nil {
		t.Errorf("%v", err)
	}
	gonum := 10
	wg := sync.WaitGroup{}
	wg.Add(gonum)
	for i := 1; i <= gonum; i++ {
		go func() {
			for j := 1; j <= 50; j++ {
				client.Get("foo").String()
				time.Sleep(time.Second)
			}
			wg.Done()
		}()
	}
	wg.Wait()
}

func TestNewRedisClusterPool(t *testing.T) {
	clusterClient, err := GetRedisClusterPool("clusterwrite")
	if err != nil {
		t.Errorf("%v", err)
	}
	gonum := 10
	wg := sync.WaitGroup{}
	wg.Add(gonum)
	for i := 1; i <= gonum; i++ {
		go func() {
			for j := 1; j <= 50; j++ {
				clusterClient.Get("foo").String()
				time.Sleep(time.Second)
			}
			wg.Done()
		}()
	}
	wg.Wait()

}
