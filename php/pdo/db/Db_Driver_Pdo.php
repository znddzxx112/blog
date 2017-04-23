<?php

// 扩展pdo类
class Db_Driver_Pdo extends \PDO
{
	 /**
     * 嵌套层数
     * @var int
     */
    protected $_transactionCounter = 0;

    /**
     * 开启事务
     * @return bool
     */
    public function beginTransaction()
    {
        if (!$this->_transactionCounter++) {
            return parent::beginTransaction();
        }

        return $this->_transactionCounter >= 0;
    }

    /**
     * 开启事务
     * @return bool
     */
    public function commit()
    {
        if (!--$this->_transactionCounter) {
            return parent::commit();
        }

        return $this->_transactionCounter >= 0;
    }

    /**
     * 回滚事务
     * @return bool
     */
    public function rollback()
    {
        if ($this->_transactionCounter >= 0) {
            $this->_transactionCounter = 0;

            return parent::rollback();
        }

        $this->_transactionCounter = 0;
        return false;
    }

}




