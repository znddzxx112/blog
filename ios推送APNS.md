- 将证书制作成pem

```bash
// 证书
$ openssl pkcs12 -clcerts -nokeys -out push-development.pem -in push-development.p12
// key
 $ openssl pkcs12 -nocerts -out push-developmentKey.pem -in push-developmentKey.p12

// 不需要密码则执行这一步
 $ openssl rsa -in push-developmentKey.pem -out push-developmentKey_noencrypt.pem

 $ cat ylsipc-push-development.pem push-developmentKey_noencrypt.pem > apns_development.pem

 $ openssl s_client -connect gateway.sandbox.push.apple.com:2195 -cert apns_development.pem
```

- php Client

```php
<?php


class APNSClient
{
	protected $apnsHost           = NULL;
	protected $pem = NULL;
	protected $ctx = NULL;
	protected $client = NULL;
	public function __construct($apnsHost, $pem) {
		$this->apnsHost = $apnsHost;
		$this->pem = $pem;
		$this->ctx = stream_context_create();

	}

	public function setCtxLocalCert() {
		stream_context_set_option($this->ctx,"ssl","local_cert", $this->pem);
	}

	public function setCtxPassPhrase($pass) {
		stream_context_set_option($this->ctx, 'ssl', 'passphrase', $pass);
	}

	public function start() {
		$client = stream_socket_client(
			$this->apnsHost, $err, $errstr,
			60, STREAM_CLIENT_CONNECT, $this->ctx
		);
		if (!$client) {
			return false;
		}
		$this->client = $client;
		return true;
	}

    // 可以自由组织方法
	public function push(
		$deviceToken, $alert, $productionMode,
		$extraType = "", $extraId = "", $extraAsset = "",
		$extraAmount = "", $extraCode = ""
	) {
		$body = array("aps" => array("alert" => $alert,"badge" => 5,"sound"=>'default'));
		// 额外字段
		if (!empty($extraType)) {
			$body["type"] = $extraType;
		}
		if (!empty($extraId)) {
			$body["id"] = $extraId;
		}
		if (!empty($extraAsset)) {
			$body["asset"] = $extraAsset;
		}
		if (!empty($extraAmount)) {
			$body["amount"] = $extraAmount;
		}
		if (!empty($extraCode)) {
			$body["code"] = $extraCode;
		}
		$payload = json_encode($body);
		if ($payload == false) {
			return "ios推送失败,palyload is false";
		}
		$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
		if ($this->client == null) {
			return "ios推送失败,client is null";
		}
		fwrite($this->client, $msg);
		return "ios推送成功";
	}

	// 显示关闭
	public function close() {
		if ($this->client != null) {
			fclose($this->client);
		}
	}

}

```

