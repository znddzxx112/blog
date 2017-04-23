<?php

require_once __dir__ . '/Db_Driver_Mysql.php';

class Db_DataHandle_Get 
{
	private static $_readDbcon = array();

	/**
	*	获取链接
	*	@param database 数据库名称
	* 	@param config 	数据库连接配置
	*/
	public static function getReadDbcon($database = '', $config = array())
	{
		$config['database'] = $database;
		if (!isset(self::$_readDbcon[$database])) {
			$mysqlDriver = new Db_Driver_Mysql($config);
			if ($mysqlDriver) {
				self::$_readDbcon[$database] = $mysqlDriver;
			} else {
				return false;
			}
		}
		return self::$_readDbcon[$database];
	}
}
