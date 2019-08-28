<?php 
namespace app\controllers;

use fastphp\base\Controller;
use app\models\ItemModel;

class ItenController extends Controller{

	public function index(){
		$keyword = isset($_GET['keyword'])?$_GET('keyword'):'';

		if($keyword){
			$items = (new ItemModel())->search($keyword);

		}else{
			$items = (new ItemModel)->where()->order(['id DESC'])->fetchAll();

		}


		$this->assign('title','全部条目');
		$this->assign('keuword',$keyword);
		$this->assign('items',$itens);

		$this->render();
	}
}