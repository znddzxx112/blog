<?php

require_once dirname(__File__) . '/db/Db_DataHandle_Get.php';
require_once dirname(__File__) . '/db/Db_Model.php';
$config['host'] = '127.0.0.1';
$config['username'] = 'root';
$config['password'] = 'yibite16888';
$config['database'] = 'mysql';
$db = Db_DataHandle_Get::getReadDbcon('mysql', $config);

$model = new Db_Model($db);
$model->setTableName('user');
$where['user'] = array('eq', 'www');
$result = $model->field('host,user')->where($where)->select();
var_dump($result);

// $param[':limit'] = 2;
// $resbind = $db->translateBind($param);
// var_dump($resbind);
// $sql = "select host,User from user limit :limit";
// $result = $db->query($sql);
// var_dump($db->getError());
// var_dump($result);


// $result = $db->select(array('table'=>'user','limit'=>'0,1','field'=>'host,user'));
// var_dump($result);

// $dsn = 'mysql:dbname=mysql;host=127.0.0.1';
// $options = array(
// 	PDO::ATTR_ORACLE_NULLS      =>  PDO::NULL_NATURAL,
//     PDO::ATTR_STRINGIFY_FETCHES =>  false,
// );
// $linkId = new Db_Driver($dsn, 'root', 'yibite16888', $options);

// // // 获取预变量参数
// $mix = $linkId->getAttribute(PDO::ATTR_DRIVER_NAME);
// var_dump($mix);

// // 直接执行query
// // PDO ,PDOStatement
// $sql = "select host,User from user limit 5";

// // 直接执行
// // $pdoStatement = $linkId->query($sql);
// // $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
// // var_dump($result);

// // 进行预处理
// $pdoStatement = $linkId->prepare($sql);
// $exeRes = $pdoStatement->execute();
// if ($exeRes == false) {
// 	echo $pdoStatement->errorCode();
// 	var_dump($pdoStatement->errorInfo());
// } else {
// 	$result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
// 	var_dump($result);
// }
