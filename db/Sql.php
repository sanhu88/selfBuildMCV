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

		return $sth->fetchAll();
	}

	public function fetch(){

		$sql = sprintf("select * from `%s` %s",$this->table,$this->filter);
		
		$sth = Db::pdo()->prepare($sql);
		$sth = $this->formatParam($sth,$this->param);
		$sth ->execute();

		return $sth->fetch();
	}


	public function delete($id){

		$sql = sprintf("delete from `%s` where `%s` = :%s",$this->table,$this->primary,$this->primary);
		$sth = Db::pdo()->prepare($sql);
		$sth = $this->formatParam($sth,[$this->primary => $id]);
		$sth->execute();

		return $sth->rowCount();
	}

	public function add($data){
		
		$sql = sprintf("insert into `%s` %s",$this->table,$this->formatInsert($data));

		$sth = Db::pdo()->prepare($sql);
		$sth = $this->formatParam($sth,$data);
		$sth = $this->formatParam($sth,$this->param);
		$sth->execute();

		return $sth->rowCount();
	}

	public function update($data){

		$sql = sprintf("update `%s` set %s %s",$this->table,$this->formatUpdate($data),$this->filter);

		$sth = Db::pdo()->prepare(sql);
		$sth = $this->formatParam($sth,$data);
		$sth = $this->formatParam($sth,$this->param);
		$sth->execute();

		return $sth->rowCount();
	}



	public function formatParam(PDOStatement $sth,$params=array()){

		foreach ($params as $param => &$value) {
			$param = is_int($param)?$param + 1 : ':'.ltrim($param,':');
			//ltrim() 函数移除字符串左侧的空白字符或其他预定义字符
			#rtrim() - 移除字符串右侧的空白字符或其他预定义字符
			#trim() - 移除字符串两侧的空白字符或其他预定义字符
			$sth->bindParam($param,$value);

		}

		return $sth;
	}


	public function formatInsert($data){

		$fields = array();
		$names = array();

		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s`",$key);
			$names[] = sprintf(":%s",$key);

		}

		$field = implode(',',$fields);
		$name = implode(',',$names);

		return sprintf("(%s) values (%s)",$field,$name);
	}


	public function formatUpdate($data){

		$fields = array();

		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s` = :%s",$key,$key);
		}

		return implode(',',$fields);

	}

}