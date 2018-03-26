- kafka,php扩展
```
http://pecl.php.net/package/rdkafka
```

- 封装
```

/**
 * example
 *
 * $producer = new Core_OutService_Ca_KafkaProducer($queue);
 * $producer->newTopic($topic);
 * $producer->produce($pushdata);
 */

class Core_OutService_Ca_KafkaProducer
{
    protected $_producer = null;

    protected $_topic = null;

    public function __construct($queue = null)
    {
        $this->_producer = new RdKafka\Producer();
        $this->_producer->setLogLevel(LOG_DEBUG);
        if ($queue !== null) {
            $this->addBrokers($queue);
        }
    }
    
    /**
     * 添加代理人
     * @param null $queue
     * @return bool
     */
    public function addBrokers($queue = null)
    {
        if ($queue !== null) {
            $this->_producer->addBrokers($queue);
            return true;
        }
        return false;
    }

    /**
     * 创建topic
     * @param null $topic
     * @return bool
     */
    public function newTopic($topic = null)
    {
        if ($topic === null) {
            return false;
        }
        if ($this->_producer === null) {
            return false;
        }
        $this->_topic = $this->_producer->newTopic($topic);
        return true;
    }
    
    
    /**
     * 生产数据
     * @param array $pushdata
     * @return bool
     */
    public function produce($pushdata = array())
    {
        if (empty($pushdata)) {
            return false;
        }
        if ($this->_topic === null) {
            return false;
        }
        $this->_topic->produce(RD_KAFKA_PARTITION_UA, 0, $pushdata);
        return true;
    }

}
```
