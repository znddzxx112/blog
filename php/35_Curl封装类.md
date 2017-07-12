```
<?php
class Mycurl
{
	//类单例静态变量
	private static $_instance	= null;
	
	/**
	 * 请求的url地址
	 * @var string
	 */
	protected $_url				= '';
	
	/**
	 * curl连接句柄
	 * @var 
	 */
	protected $_ch				= array();
	
	/**
	 * 超时时间
	 * @var int
	 */
	protected $_timeOut			= 1;
	
	/**
	 * 构造器
	 * @param string $url
	 */
	public function __construct($url = '')
	{
		if (!empty($url)) {
			$this->_setUrl($url);
		}
	}

	/**
	 * 禁止克隆对象
	 */
	private function __clone()
	{

	}
	
	/**
	 * 单例实现
	 * @param string $host
	 * @param int $port
	 * @param bool $change
	 * @return Public_HttpSqs
	 */
	public static function getInstance($url = '')
	{
		if (null == self::$_instance || self::$_instance->_url != $url) {
			self::$_instance = new self($url);
		}

		return self::$_instance;
	}
	
	/**
	 * 设置url
	 * @param string $url
	 * @return void
	 */
	private function _setUrl($url)
	{
		$this->_url = $url;
	}

	
	/**
	 * 设置curl
	 * @return $this->_ch
	 */
	private function _getCurlHandle()
	{
		if (!isset($this->_ch[$this->_url]) && empty($this->_ch[$this->_url])) {
			$this->_ch[$this->_url] = curl_init($this->_url);
			
			curl_setopt($this->_ch[$this->_url], CURLOPT_HEADER, 0);
			curl_setopt($this->_ch[$this->_url], CURLOPT_POST, 1);
			curl_setopt($this->_ch[$this->_url], CURLOPT_TIMEOUT, $this->_timeOut);
			curl_setopt($this->_ch[$this->_url], CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->_ch[$this->_url], CURLOPT_FOLLOWLOCATION, true);
			$header = array('Accept-Encoding: gzip, deflate','Content-Type: text/xml; charset=utf-8');
			curl_setopt($this->_ch[$this->_url], CURLOPT_HTTPHEADER, $header);
			curl_setopt($this->_ch[$this->_url], CURLOPT_VERBOSE, 0);	
		}
		return $this->_ch[$this->_url];
	}
	
	/**
	 * 发送请求
	 * @return stdClass
	 */
	private function send($message = '')
	{
		$this->_getCurlHandle();
		
		curl_setopt($this->_ch[$this->_url], CURLOPT_POSTFIELDS, $message);

		
		$return = curl_exec($this->_ch[$this->_url]);
		
		return $return;
	}
}

```
