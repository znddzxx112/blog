<?php

requeire __dir__ . '/Db_Driver.php';
/**
 * 数据库驱动基类类
 */
class Db_Driver_Mysql extends Db_Driver
{
    /**
     * 解析pdo连接的dsn信息
     * @access public
     * @param array $config 连接信息
     * @return string
     */
    protected function _parseDsn($config)
    {
        $dsn  =   'mysql:dbname='.$config['database'].';host='.$config['host'];
        if (!empty($config['hostport'])) {
            $dsn  .= ';port='.$config['hostport'];
        }
        if (!empty($config['charset'])) {
            $this->options[PDO::MYSQL_ATTR_INIT_COMMAND]    =   'SET NAMES '.$config['charset'];
            $dsn  .= ';charset='.$config['charset'];
        }
        return $dsn;
    }

    /**
     * 获取pdo对象
     * @return pdo
     */
    public function getDbcon()
    {
        if (false === $this->connect()) {
            return false;
        }
        return $this->_linkID;
    }


    /**
     * 字段和表名处理
     * @access protected
     * @param string $key
     * @return string
     */
    protected function _parseKey(&$key)
    {
        $key   =  trim($key);
        if (!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/', $key)) {
           $key = '`'.$key.'`';
        }
        return $key;
    }

    /**
     * 批量插入记录
     * @access public
     * @param mixed $dataSet 数据集
     * @param array $options 参数表达式
     * @param boolean $replace 是否replace
     * @return false | integer
     */
    public function insertAll($dataSet, $options=array(), $replace=false)
    {
        $values  =  array();
        // $this->model  =   $options['model'];
        if (!is_array($dataSet[0])) return false;
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        $fields =   array_map(array($this, '_parseKey'), array_keys($dataSet[0]));
        foreach ($dataSet as $data) {
            $value   =  array();
            foreach ($data as $key=>$val) {
                if (is_array($val) && 'exp' == $val[0]) {
                    $value[]   =  $val[1];
                } elseif (is_null($val)) {
                    $value[]   =   'NULL';
                } elseif (is_scalar($val)) {
                    if (0===strpos($val, ':') && in_array($val, array_keys($this->_bind))) {
                        $value[]   =   $this->_parseValue($val);
                    } else {
                        $name       =   count($this->_bind);
                        $value[]   =   ':'.$name;
                        $this->_bindParam($name, $val);
                    }
                }
            }
            $values[]    = '('.implode(',', $value).')';
        }
        // 兼容数字传入方式
        $replace= (is_numeric($replace) && $replace>0)?true:$replace;
        $sql =  (true===$replace?'REPLACE':'INSERT').' INTO '.
            $this->_parseTable($options['table']).' ('.implode(',', $fields).') VALUES '.
            implode(',', $values).$this->_parseDuplicate($replace);
        // $sql    .= $this->parseComment(!empty($options['comment'])?$options['comment']:'');
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }


    /**
     * ON DUPLICATE KEY UPDATE 分析
     * @access protected
     * @param mixed $duplicate
     * @return string
     */
    protected function _parseDuplicate($duplicate)
    {
        // 布尔值或空则返回空字符串
        if (is_bool($duplicate) || empty($duplicate)) return '';

        if (is_string($duplicate)) {
            // field1,field2 转数组
            $duplicate = explode(',', $duplicate);
        } elseif (is_object($duplicate)) {
            // 对象转数组
            $duplicate = get_class_vars($duplicate);
        }
        $updates                    = array();
        foreach ((array) $duplicate as $key=>$val) {
            if (is_numeric($key)) { 
            // array('field1', 'field2', 'field3') 解析
            // 为 ON DUPLICATE KEY UPDATE field1=VALUES(field1), field2=VALUES(field2), field3=VALUES(field3)
                $updates[]          = $this->_parseKey($val)."=VALUES(".$this->_parseKey($val).")";
            } else {
                if (is_scalar($val)) // 兼容标量传值方式
                    $val            = array('value', $val);
                if (!isset($val[1])) continue;
                switch ($val[0]) {
                    case 'exp': // 表达式
                        $updates[]  = $this->_parseKey($key)."=($val[1])";
                        break;
                    case 'value': // 值
                    default:
                        $name       = count($this->_bind);
                        $updates[]  = $this->_parseKey($key)."=:".$name;
                        $this->_bindParam($name, $val[1]);
                        break;
                }
            }
        }
        if(empty($updates)) return '';
        return " ON DUPLICATE KEY UPDATE ".join(', ', $updates);
    }
    
    /**
     * 切换同台服务器的不同数据库
     * @param  string $database
     * @return void
     */
    public function switchDatabase($database)
    {
        return $this->_linkID->query('USE `' . $database . '`');
    }

}
