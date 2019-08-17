<?php

namespace fastphp\db;

use \PDOStatement;

class Sql{

	//数据库表名
	protected $table;

	//数据库主键
	protected $primary = 'id';

	//where和 order 拼装后的条件
	private $filter = '';

	//PDO bindParam()绑定的参数结合
	private $param = array();


	public function where($where = array(),$param = array()){
		if($where){
			$this->filter .= ' WHERE ';
			$this->filter .= implode(' ', $where);

			$this->param = $param;
		}

		return $this;

	}

	public function order($order = array()){

		if($order){
			$this->filter .= ' ORDER BY ';
			$this->filter .= implode(',', $order);

		}

		return $this;
	}


	public function fetchAll(){

		$sql = sprintf("select * from `%s` %s",$this->table,$this->filter);
		//sprintf 把百分号（%）符号替换成一个作为参数进行传递的变量
		$sth = Db::pdo()->prepare($sql);
		$sth = $this->formatParam($sth,$this->param);
		$sth ->execute();

		return $sth->fetch();
	}

}