<?php

require_once dirname(__file__) . '/Db_Driver_Pdo.php';

class Db_Driver extends Db_Driver_Pdo
{
	// PDO 操作实例
	protected $_pdoStatment = null;

	// 当前SQL指令
	protected $_queryStr = '';

	// 最后插入ID
    protected $_lastInsID  = null;

    // 返回或者影响记录数
    protected $_numRows    = 0;

    // 错误信息
    protected $_error      = '';

    // 当前连接ID
    protected $_linkID    = null;

    // 数据库连接参数配置
    protected $_config     = array(
        'type'              =>  '',         // 数据库类型
        'host'              =>  '', // 服务器地址
        'database'          =>  '',          // 数据库名
        'username'          =>  '',      // 用户名
        'password'          =>  '',          // 密码
        'hostport'          =>  '3306',        // 端口
        'dsn'               =>  '', //
        'params'            =>  array(), // 数据库连接参数
        'charset'           =>  'utf8',      // 数据库编码默认采用utf8
    );
    // 数据库表达式
    protected $_exp = array(
        'eq'=>'=',
        'neq'=>'<>',
        'gt'=>'>',
        'egt'=>'>=',
        'lt'=>'<',
        'elt'=>'<=',
        'notlike'=>'NOT LIKE',
        'like'=>'LIKE',
        'in'=>'IN',
        'notin'=>'NOT IN',
        'not in'=>'NOT IN',
        'between'=>'BETWEEN',
        'not between'=>'NOT BETWEEN',
        'notbetween'=>'NOT BETWEEN'
    );
    // 查询表达式
    protected $_selectSql  = 'SELECT %FIELD% FROM %TABLE%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT%';
    // PDO连接参数
    protected $_options = array(
        // PDO::ATTR_CASE              =>  PDO::CASE_LOWER,
        //PDO::ATTR_ERRMODE           =>  PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS      =>  PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES =>  false,
        PDO::ATTR_EMULATE_PREPARES => false, //禁止本地模拟
        // PDO::ATTR_PERSISTENT        =>  true
    );
    // [:val1=>param1,:val2=>param2]
    protected $_bind = array(); //参数绑定

    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     */
    public function __construct($config='')
    {
        if (!empty($config)) {
            $this->_config   =   array_merge($this->_config, $config);
        }
    }

    /**
     * 连接数据库方法
     * @access public
     */
    public function connect()
    {
        if (null === $this->_linkID) {
            try {
                if (empty($this->_config['dsn'])) {
                    $this->_config['dsn']  =   $this->_parseDsn($this->_config);
                }
                $this->_linkID = new Db_Driver_Pdo(
                    $this->_config['dsn'],
                    $this->_config['username'],
                    $this->_config['password'],
                    $this->_options
                );
            } catch (PDOException $e) {
            	// 错误处理
				// 'errorCode:' . $e->getCode() . ';errorMsg:' . $e->getMessage() . 'dsn:' . $this->_config['dsn'], 
				// 'error', 
				// 'mysql_connect'
                return false;
            }
        }
        return true;
    }

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
     * 释放查询结果
     * @access public
     */
    public function free()
    {
        $this->_pdoStatement = null;
    }

    /**
    * 查询
    * select
    */
    public function query($str)
    {
    	if (false == $this->connect()){
    		return false;
    	}
    	$this->_queryStr = $str;

    	if (!empty($this->_bind)) {
    		$that = $this;
    		$this->_queryStr = strtr(
    			$this->_queryStr, 
    			array_map(
                	function($val) use($that) { 
                		return is_array($val) ? $val[0] : '\''.$that->escapeString($val).'\''; 
                	}, 
                	$this->_bind
                )
    		);
    	}

    	if (!empty($this->_pdoStatement)) {
    		$this->_pdoStatement = null;
    	}

    	$this->_pdoStatement = $this->_linkID->prepare($this->_queryStr);
    	if (false === $this->_pdoStatement) {
            $this->error();
            return false;
        }
        foreach ($this->_bind as $key => $val) {
            if (is_array($val)) {
                $this->_pdoStatement->bindValue($key, $val[0], $val[1]);
            } else {
                $this->_pdoStatement->bindValue($key, $val);
            }
        }
        $this->_bind = array();
        try {
        	$result = $this->_pdoStatement->execute();
        } catch (Exception $e) {
        	$result = false;
        }
       
        if ($result == false) {
        	$this->error();
        	return false;
        } else {
        	return $this->_getResult();
        }

    }

    /**
     * 执行语句
     * insert replace delete update
     * @access public
     * @param string $str  sql指令
     * @param boolean $fetchSql  不执行只是获取SQL
     * @return mixed
     */
    public function execute($str)
    {
        if (false === $this->connect()) {
            return false;
        }

        $this->_queryStr = $str;
        
    	if (!empty($this->_bind)) {
            $that   =   $this;
            $this->_queryStr =   strtr(
                $this->_queryStr,
                array_map(
                	function($val) use($that) { 
                		return is_array($val) ? $val[0] : '\''.$that->escapeString($val).'\''; 
                	}, 
                	$this->_bind
                )
            );
        }
        //释放前次的查询结果
        if (!empty($this->_pdoStatement)) $this->free();
        $this->_pdoStatement =   $this->_linkID->prepare($str);
        if (false === $this->_pdoStatement) {
            $this->error();
            return false;
        }
        foreach ($this->_bind as $key => $val) {
            if (is_array($val)) {
                $this->_pdoStatement->bindValue($key, $val[0], $val[1]);
            } else {
                $this->_pdoStatement->bindValue($key, $val);
            }
        }
        $this->_bind =   array();

        try {
            $result = $this->_pdoStatement->execute();
        } catch (PDOException $e) {
            $result = false;
            // $this->error();
        }

        if (false === $result) {
            $this->error();
        } else {
            // $this->_numRows = $this->_pdoStatement->rowCount();
            if (preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $str)) {
                $this->_lastInsID = $this->_linkID->lastInsertId();
            } elseif (preg_match("/^\s*(UPDATE|DELETE)\s+/i", $str)) {
                $this->_lastInsID = $this->_pdoStatement->rowCount();
            }
        }
        return $result;
    }

     /**
     * 启动事务
     * @access public
     * @return void
     */
    public function startTrans()
    {
        if (false === $this->connect()) {
            //Public_Log::log('can not connect', 'error', 'begin_trans');            
            return false;
        }
        if (!$this->_linkID->beginTransaction()) {
            //Public_Log::log(var_export($this->_linkID->errorInfo(), true), 'error', 'begin_trans');
            return false;
        }

        return ;
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @access public
     * @return boolean
     */
    public function commit()
    {
        if (!$this->_linkID->inTransaction()) {
            //Public_Log::log(var_export(debug_backtrace(), true), 'error', 'no_transaction');
            return false;
        }
        $result = $this->_linkID->commit();
        if (!$result) {
            $this->error();
            return false;
        }
        return true;
    }

    /**
     * 事务回滚
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        if (!$this->_linkID->inTransaction()) {
            //Public_Log::log(var_export(debug_backtrace(), true), 'error', 'no_transaction');
            return false;
        }
        $result = $this->_linkID->rollback();
        $this->transTimes = 0;
        if (!$result) {
            $this->error();
            return false;
        }
        return true;
    }

    /**
     * 获得所有的查询数据
     * @access private
     * @return array
     */
    private function _getResult()
    {
        //返回数据集
        $result =   $this->_pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 关闭数据库
     * @access public
     */
    public function close()
    {
        $this->_linkID = null;
    }

    /**
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    public function error()
    {
        if ($this->_pdoStatement) {
            $error = $this->_pdoStatement->errorInfo();
            $this->_error = array($error[1], $error[2]);
            //$error[1].':'.$error[2];
        } else {
            $this->_error = array();
        }
        if ('' != $this->_queryStr) {
            $this->_error[] = "\n [ SQL语句 ] : ".$this->_queryStr;
        }
        //  报错处理
        return $this->_error;
    }

     /**
     * set分析
     * @access protected
     * @param array $data
     * @return string
     */
    protected function _parseSet($data)
    {
        foreach ($data as $key=>$val) {
            if (is_array($val) && 'exp' == $val[0]) {
                $set[]  =   $this->_parseKey($key).'='.$val[1];
            } elseif (is_null($val)) {
                $set[]  =   $this->_parseKey($key).'=NULL';
            } elseif (is_scalar($val)) {// 过滤非标量数据
                if (0 === strpos($val, ':') && in_array($val, array_keys($this->_bind))) {
                    $set[]  =   $this->_parseKey($key).'='.$this->escapeString($val);
                } else {
                    $name   =   count($this->_bind);
                    $set[]  =   $this->_parseKey($key).'=:'.$name;
                    $this->_bindParam($name, $val);
                }
            }
        }
        return ' SET '.implode(',', $set);
    }

    /**
     * 参数绑定
     * @access protected
     * @param string $name 绑定参数名
     * @param mixed $value 绑定值
     * @return void
     */
    protected function _bindParam($name, $value)
    {
        $this->_bind[':'.$name]  =   $value;
    }

    /**
     * 字段名分析
     * @access protected
     * @param string $key
     * @return string
     */
    protected function _parseKey(&$key)
    {
        return $key;
    }

    /**
     * value分析
     * @access protected
     * @param mixed $value
     * @return string
     */
    protected function _parseValue($value)
    {
        if (is_string($value)) {
            $value =  strpos($value, ':') === 0 && in_array($value, array_keys($this->_bind)) ?
                $this->escapeString($value) : '\''.$this->escapeString($value).'\'';
        } elseif (isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp') {
            $value =  $this->escapeString($value[1]);
        } elseif (is_array($value)) {
            $value =  array_map(array($this, '_parseValue'), $value);
        } elseif (is_bool($value)) {
            $value =  $value ? '1' : '0';
        } elseif (is_null($value)) {
            $value =  'null';
        }
        return $value;
    }

    /**
     * field分析
     * @access protected
     * @param mixed $fields
     * @return string
     */
    protected function _parseField($fields)
    {
        if (is_string($fields) && '' !== $fields) {
            $fields    = explode(',', $fields);
        }
        // echo $field;
        if (is_array($fields)) {
            // 完善数组方式传字段名的支持
            // 支持 'field1'=>'field2' 这样的字段别名定义
            $array   =  array();
            foreach ($fields as $key=>$field) {
                if (!is_numeric($key))
                    $array[] =  $this->_parseKey($key).' AS '.$this->_parseKey($field);
                else
                    $array[] =  $this->_parseKey($field);
            }
            $fieldsStr = implode(',', $array);
        } else {
            $fieldsStr = '*';
        }
        //TODO 如果是查询全部字段，并且是join的方式，那么就
        //把要查的表加个别名，以免字段被覆盖
        return $fieldsStr;
    }

    /**
     * table分析
     * @access protected
     * @param mixed $table
     * @return string
     */
    protected function _parseTable($tables)
    {
        return $this->_parseKey($tables);
    }

    /**
     * where分析
     * @access protected
     * @param mixed $where
     * @return string
     */
    protected function _parseWhere($where)
    {
        $whereStr = '';
        if (is_string($where)) {
            // 直接使用字符串条件
            $whereStr = $where;
        } else { // 使用数组表达式
            $operate  = isset($where['_logic'])?strtoupper($where['_logic']):'';
            if (in_array($operate, array('AND', 'OR', 'XOR'))) {
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate    =   ' '.$operate.' ';
                unset($where['_logic']);
            } else {
                // 默认进行 AND 运算
                $operate    =   ' AND ';
            }
            foreach ($where as $key=>$val) {
                if (is_numeric($key)) {
                    $key  = '_complex';
                }
                if (0===strpos($key, '_')) {
                    // 解析特殊条件表达式
                    $whereStr   .= $this->_parseThinkWhere($key, $val);
                } else {
                    // 多条件支持
                    $multi  = is_array($val) && isset($val['_multi']);
                    $key    = trim($key);
                    if (strpos($key, '|')) { // 支持 name|title|nickname 方式定义查询字段
                        $array =  explode('|', $key);
                        $str   =  array();
                        foreach ($array as $m=>$k) {
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = $this->_parseWhereItem($this->_parseKey($k), $v);
                        }
                        $whereStr .= '( '.implode(' OR ', $str).' )';
                    } elseif (strpos($key, '&')) {
                        $array =  explode('&', $key);
                        $str   =  array();
                        foreach ($array as $m=>$k) {
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = '('.$this->_parseWhereItem($this->_parseKey($k), $v).')';
                        }
                        $whereStr .= '( '.implode(' AND ', $str).' )';
                    } else {
                        $whereStr .= $this->_parseWhereItem($this->_parseKey($key), $val);
                    }
                }
                $whereStr .= $operate;
            }
            $whereStr = substr($whereStr, 0, -strlen($operate));
        }
        return empty($whereStr) ? '' : ' WHERE '.$whereStr;
    }

    // where子单元分析
    protected function _parseWhereItem($key, $val)
    {
        $whereStr = '';
        if (is_array($val)) {
            if (is_string($val[0])) {
                $exp    =   strtolower($val[0]);
                if (preg_match('/^(eq|neq|gt|egt|lt|elt)$/', $exp)) { // 比较运算
                    $whereStr .= $key.' '.$this->_exp[$exp].' '.$this->_parseValue($val[1]);
                } elseif (preg_match('/^(notlike|like)$/', $exp)) {// 模糊查找
                    if (is_array($val[1])) {
                        $likeLogic  =   isset($val[2])?strtoupper($val[2]):'OR';
                        if (in_array($likeLogic, array('AND','OR','XOR'))) {
                            $like       =   array();
                            foreach ($val[1] as $item) {
                                $like[] = $key.' '.$this->_exp[$exp].' '.$this->_parseValue($item);
                            }
                            $whereStr .= '('.implode(' '.$likeLogic.' ', $like).')';
                        }
                    } else {
                        $whereStr .= $key.' '.$this->_exp[$exp].' '.$this->_parseValue($val[1]);
                    }
                } elseif ('bind' == $exp ) { // 使用表达式
                    $whereStr .= $key.' = :'.$val[1];
                } elseif ('exp' == $exp ) { // 使用表达式
                    $whereStr .= $key.' '.$val[1];
                } elseif (preg_match('/^(notin|not in|in)$/', $exp)) { // IN 运算
                    if (isset($val[2]) && 'exp'==$val[2]) {
                        $whereStr .= $key.' '.$this->_exp[$exp].' '.$val[1];
                    } else {
                        if (is_string($val[1])) {
                             $val[1] =  explode(',', $val[1]);
                        }
                        $zone      =   implode(',', $this->_parseValue($val[1]));
                        $whereStr .= $key.' '.$this->_exp[$exp].' ('.$zone.')';
                    }
                } elseif (preg_match('/^(notbetween|not between|between)$/', $exp)) { // BETWEEN运算
                    $data = is_string($val[1])? explode(',', $val[1]):$val[1];
                    $whereStr .=  $key.' '.$this->_exp[$exp].' '.$this->_parseValue($data[0]).' AND '.
                        $this->_parseValue($data[1]);
                }
            } else {
                $count = count($val);
                $rule  = isset($val[$count-1]) ?
                    (is_array($val[$count-1]) ? strtoupper($val[$count-1][0]) : strtoupper($val[$count-1])) :
                    '' ;
                if (in_array($rule, array('AND', 'OR', 'XOR'))) {
                    $count  = $count -1;
                } else {
                    $rule   = 'AND';
                }
                for ($i=0;$i<$count;$i++) {
                    $data = is_array($val[$i])?$val[$i][1]:$val[$i];
                    if ('exp'==strtolower($val[$i][0])) {
                        $whereStr .= $key.' '.$data.' '.$rule.' ';
                    } else {
                        $whereStr .= $this->_parseWhereItem($key, $val[$i]).' '.$rule.' ';
                    }
                }
                $whereStr = '( '.substr($whereStr, 0, -4).' )';
            }
        } else {
            $whereStr .= $key.' = '.$this->_parseValue($val);
        }
        return $whereStr;
    }

    /**
     * 特殊条件分析
     * @access protected
     * @param string $key
     * @param mixed $val
     * @return string
     */
    protected function _parseThinkWhere($key, $val)
    {
        $whereStr   = '';
        switch($key) {
            case '_string':
                // 字符串模式查询条件
                $whereStr = $val;
                break;
            case '_complex':
                // 复合查询条件
                $whereStr = substr($this->_parseWhere($val), 6);
                break;
            case '_query':
                // 字符串模式查询条件
                parse_str($val, $where);
                if (isset($where['_logic'])) {
                    $op   =  ' '.strtoupper($where['_logic']).' ';
                    unset($where['_logic']);
                } else {
                    $op   =  ' AND ';
                }
                $array   =  array();
                foreach ($where as $field=>$data)
                    $array[] = $this->_parseKey($field).' = '.$this->_parseValue($data);
                $whereStr   = implode($op, $array);
                break;
        }
        return '( '.$whereStr.' )';
    }

    /**
     * limit分析
     * @access protected
     * @param mixed $lmit
     * @return string
     */
    protected function _parseLimit($limit)
    {
        return !empty($limit)?   ' LIMIT '.$limit.' ':'';
    }

    /**
     * join分析
     * @access protected
     * @param mixed $join
     * @return string
     */
    // protected function parseJoin($join)
    // {
    //     $joinStr = '';
    //     if (!empty($join)) {
    //         $joinStr    =   ' '.implode(' ', $join).' ';
    //     }
    //     return $joinStr;
    // }

    /**
     * order分析
     * @access protected
     * @param mixed $order
     * @return string
     */
    protected function _parseOrder($order)
    {
        if (is_array($order)) {
            $array   =  array();
            foreach ($order as $key=>$val) {
                if (is_numeric($key)) {
                    $array[] =  $this->_parseKey($val);
                } else {
                    $array[] =  $this->_parseKey($key).' '.$val;
                }
            }
            $order   =  implode(',', $array);
        }
        return !empty($order)?  ' ORDER BY '.$order:'';
    }

    /**
     * group分析
     * @access protected
     * @param mixed $group
     * @return string
     */
    protected function _parseGroup($group)
    {
        return !empty($group)? ' GROUP BY '.$group:'';
    }

    /**
     * having分析
     * @access protected
     * @param string $having
     * @return string
     */
    protected function _parseHaving($having)
    {
        return  !empty($having)?   ' HAVING '.$having:'';
    }

    /**
     * distinct分析
     * @access protected
     * @param mixed $distinct
     * @return string
     */
    // protected function parseDistinct($distinct)
    // {
    //     return !empty($distinct)?   ' DISTINCT ' :'';
    // }

    /**
     * union分析
     * @access protected
     * @param mixed $union
     * @return string
     */
    // protected function parseUnion($union)
    // {
    //     if (empty($union)) return '';
    //     if (isset($union['_all'])) {
    //         $str  =   'UNION ALL ';
    //         unset($union['_all']);
    //     } else {
    //         $str  =   'UNION ';
    //     }
    //     foreach ($union as $u) {
    //         $sql[] = $str.(is_array($u)?$this->buildSelectSql($u):$u);
    //     }
    //     return implode(' ', $sql);
    // }

    /**
     * 参数绑定分析
     * @access protected
     * @param array $bind
     * @return array
     */
    protected function _parseBind($bind)
    {
        $this->_bind   =   array_merge($this->_bind, $bind);
    }

    /**
     * ON DUPLICATE KEY UPDATE 分析
     * @access protected
     * @param mixed $duplicate
     * @return string
     */
    // protected function parseDuplicate($duplicate)
    // {
    //     return '';
    // }

    /**
     * 插入记录
     * @access public
     * @param mixed $data 数据
     * @param array $options 参数表达式
     * @param boolean $replace 是否replace
     * @return false | integer
     */
    public function insert($data, $options=array(), $replace=false)
    {
        $values  =  $fields    = array();
        // $this->model  =   $options['model'];
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        foreach ($data as $key=>$val) {
            if (is_array($val) && 'exp' == $val[0]) {
                $fields[]   =  $this->_parseKey($key);
                $values[]   =  $val[1];
            } elseif (is_null($val)) {
                $fields[]   =   $this->_parseKey($key);
                $values[]   =   'NULL';
            } elseif (is_scalar($val)) { // 过滤非标量数据
                $fields[]   =   $this->_parseKey($key);
                if (0===strpos($val, ':') && in_array($val, array_keys($this->_bind))) {
                    $values[]   =   $this->_parseValue($val);
                } else {
                    $name       =   count($this->_bind);
                    $values[]   =   ':'.$name;
                    $this->_bindParam($name, $val);
                }
            }
        }
        // 兼容数字传入方式
        $replace= (is_numeric($replace) && $replace>0) ? true : $replace;
        $sql    = (true===$replace?'REPLACE':'INSERT').' INTO '.
            $this->_parseTable($options['table']).' ('.implode(',', $fields).
            ') VALUES ('.implode(',', $values).')'.$this->_parseDuplicate($replace);
        // $sql    .= $this->parseComment(!empty($options['comment'])?$options['comment']:'');
        return $this->execute($sql/*, !empty($options['fetch_sql']) ? true : false*/);
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
        $fields =   array_map(array($this,'parseKey'), array_keys($dataSet[0]));
        foreach ($dataSet as $data) {
            $value   =  array();
            foreach ($data as $key=>$val) {
                if (is_array($val) && 'exp' == $val[0]) {
                    $value[]   =    $val[1];
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
            $values[]    = 'SELECT '.implode(',', $value);
        }
        $sql = 'INSERT INTO '.$this->_parseTable($options['table']).' ('.
            implode(',', $fields).') '.implode(' UNION ALL ', $values);
        // $sql   .= $this->parseComment(!empty($options['comment'])?$options['comment']:'');
        return $this->execute($sql/*, !empty($options['fetch_sql']) ? true : false*/);
    }

    /**
     * 更新记录
     * @access public
     * @param mixed $data 数据
     * @param array $options 表达式
     * @return false | integer
     */
    public function update($data, $options)
    {
        // $this->model  =   $options['model'];
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        $table  =   $this->_parseTable($options['table']);
        $sql   = 'UPDATE ' . $table . $this->_parseSet($data);
        $sql .= $this->_parseWhere(!empty($options['where'])?$options['where']:'');
        $sql   .=  $this->_parseOrder(!empty($options['order'])?$options['order']:'')
            .$this->_parseLimit(!empty($options['limit'])?$options['limit']:'');
        return $this->execute($sql/*, !empty($options['fetch_sql']) ? true : false*/);
    }

    /**
     * 删除记录
     * @access public
     * @param array $options 表达式
     * @return false | integer
     */
    public function delete($options=array())
    {
        // $this->model  =   $options['model'];
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        $table  =   $this->_parseTable($options['table']);
        $sql    =   'DELETE FROM '.$table;
        // if (strpos($table, ',')) {// 多表删除支持USING和JOIN操作
        //     if (!empty($options['using'])) {
        //         $sql .= ' USING '.$this->_parseTable($options['using']).' ';
        //     }
        //     $sql .= $this->parseJoin(!empty($options['join'])?$options['join']:'');
        // }
        $sql .= $this->_parseWhere(!empty($options['where'])?$options['where']:'');
        // if (!strpos($table, ',')) {
            // 单表删除支持order和limit
            $sql .= $this->_parseOrder(!empty($options['order'])?$options['order']:'')
            .$this->_parseLimit(!empty($options['limit'])?$options['limit']:'');
        // }
        // $sql .=   $this->parseComment(!empty($options['comment'])?$options['comment']:'');
        return $this->execute($sql/*, !empty($options['fetch_sql']) ? true : false*/);
    }

    /**
     * 查找记录
     * @access public
     * @param array $options 表达式
     * @return mixed
     */
    public function select($options=array())
    {
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        $sql    = $this->buildSelectSql($options);
        $result   = $this->query($sql/*, !empty($options['fetch_sql']) ? true : false*/);
        return $result;
    }

    /**
     * 普通sql查找记录
     * @access public
     * @param array $options 表达式
     * @return mixed
     */
    public function get($sql, $options=array())
    {
        $this->_parseBind(!empty($options['bind'])?$options['bind']:array());
        $result   = $this->query($sql);
        return $result;
    }

    /**
     * 生成查询SQL
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function buildSelectSql($options=array())
    {
        $sql  =   $this->parseSql($this->_selectSql, $options);
        $this->_queryStr = $sql;
        return $sql;
    }

    /**
     * 替换SQL语句中表达式
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function parseSql($sql, $options=array())
    {
        // echo $sql;exit;
        $sql   = str_replace(
            array(
                '%TABLE%','%FIELD%', '%WHERE%','%GROUP%','%HAVING%','%ORDER%','%LIMIT%'
            ),
            array(
                $this->_parseTable($options['table']),
                // $this->parseDistinct(isset($options['distinct'])?$options['distinct']:false),
                $this->_parseField(!empty($options['field'])?$options['field']:'*'),
                // $this->parseJoin(!empty($options['join'])?$options['join']:''),
                $this->_parseWhere(!empty($options['where'])?$options['where']:''),
                $this->_parseGroup(!empty($options['group'])?$options['group']:''),
                $this->_parseHaving(!empty($options['having'])?$options['having']:''),
                $this->_parseOrder(!empty($options['order'])?$options['order']:''),
                $this->_parseLimit(!empty($options['limit'])?$options['limit']:'')
                // $this->parseUnion(!empty($options['union'])?$options['union']:'')
            ),
            $sql
        );
        return $sql;
    }

	/**
     * 获取最近一次查询的sql语句
     * @param string $model  模型名
     * @access public
     * @return string
     */
    public function getLastSql(/*$model=''*/)
    {
        return $this->_queryStr;
        // return $model ? $this->_modelSql[$model] : $this->_queryStr;
    }

    /**
     * 获取最近插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID()
    {
        return $this->_lastInsID;
    }

    /**
     * 获取最近的错误信息
     * @access public
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }
    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str  SQL字符串
     * @return string
     */
    public function escapeString($str)
    {
        return addslashes($str);
    }

    /**
     * 析构方法
     * @access public
     */
    public function __destruct()
    {
        // 释放查询
        if ($this->_pdoStatement) {
            $this->free();
        }
        // 关闭连接
        $this->close();
    }

     /**
     * 拼装数据where传参的bind与where数组
     * @param array $params
     * return array
     */
    public static function getBindParams($params, $needType = false)
    {
        if (empty($params)) {
            return array();
        }
        
        $data   = array();
        array_walk(
            $params, 
            function ($item, $key) use (&$data, $needType) {
                if ($needType) {
                    $item   = gettype($item) == 'integer' 
                                ? array($item, PDO::PARAM_INT) : array($item, PDO::PARAM_STR);
                }
                $data[] = array('key' => $key, 'bind' => ':' . $key, 'value' => $item);
            }
        );
        
        $query['where'] = array_column($data, 'bind', 'key');
        $query['bind']  = array_column($data, 'value', 'bind');

        return $query;
    }

}
