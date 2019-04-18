package fortest

//doc:https://godoc.org/github.com/go-redis/redis

import (
	"errors"
	"github.com/go-redis/redis"
)

var defaultRedisPool *RedisPool

func init() {
	defaultRedisPool = new(RedisPool)
	defaultRedisPool.singleRedisPool = make(map[string]*redis.Client)
	defaultRedisPool.singleRedisPoolOption = make(map[string]*redis.Options)
	defaultRedisPool.clusterPool = make(map[string]*redis.ClusterClient)
	defaultRedisPool.clusterPoolOption = make(map[string]*redis.ClusterOptions)
}

func NewRedisClientPool(poolname string, options *redis.Options) {
	client := redis.NewClient(options)
	defaultRedisPool.setRedisClient(poolname, client)
	defaultRedisPool.setRedisOptions(poolname, options)
}

func GetRedisClientPool(poolname string) (*redis.Client, error) {
	if client, ok := defaultRedisPool.singleRedisPool[poolname]; ok {
		return client, nil
	} else {
		return nil, errors.New("not exist")
	}
}

func NewRedisClusterPool(poolname string, options *redis.ClusterOptions) {
	client := redis.NewClusterClient(options)
	defaultRedisPool.setRedisCluster(poolname, client)
	defaultRedisPool.setRedisClusterOptions(poolname, options)
}

func GetRedisClusterPool(poolname string) (*redis.ClusterClient, error) {
	if client, ok := defaultRedisPool.clusterPool[poolname]; ok {
		return client, nil
	} else {
		return nil, errors.New("not exist")
	}
}

type RedisPool struct {
	singleRedisPool       map[string]*redis.Client
	singleRedisPoolOption map[string]*redis.Options
	clusterPool           map[string]*redis.ClusterClient
	clusterPoolOption     map[string]*redis.ClusterOptions
}

func (pool *RedisPool) setRedisClient(poolname string, client *redis.Client) {
	pool.singleRedisPool[poolname] = client
}

func (pool *RedisPool) setRedisOptions(poolname string, options *redis.Options) {
	pool.singleRedisPoolOption[poolname] = options
}

func (pool *RedisPool) setRedisCluster(poolname string, client *redis.ClusterClient) {
	pool.clusterPool[poolname] = client
}

func (pool *RedisPool) setRedisClusterOptions(poolname string, options *redis.ClusterOptions) {
	pool.clusterPoolOption[poolname] = options
}
