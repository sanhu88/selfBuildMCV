<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\base\Db;


class ItemModel extends Model{
	protected $table = 'item';

	public function search($keyword){
		$sql ="select * from `$this->table` where `item_name` like :keyword";
		$sth = Db::pdo()->prepare($sql);
		$sth = $this->formatParam($sth,[':keyword' => "%$keyword%"]);
		$sth->execute();

		return $sth->fetchAll();
	}
}