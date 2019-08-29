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


	public function detail($id){

		$item = (new ItemModel())->where(["id = ?"],[$id])->fetch();

		$this->assign('title','条目具体详情');
		$this->assign('count',$count);
		$this->render();
	}


	public function add(){

		$data['item_name'] = $_POST['value'];
		$count = (new ItemModel)->add($data);//?why not ItemModel()

		$this->assign('title','添加成功');
		$this->assign('count',$count);
		$this->render();
	}


	public function manage($id = 0){

		$item = array();

		if ($id) {
			$item = (new ItemModel())->where(["id = :id"],[':id'=>$id])-fetch();
		}

		$this->assign('title','管理条目');
		$this->assign('item',$item);
		$this->render();
	}


	public function update(){

		$data = array('id'=>$_POST['id'],'item_name'=>$_POST['value']);

		$count = (new ItemModel)->where(['id = :id'],[':id'=>$data['id']])->update($data);//?wh{y not ItemModel()
		
				$this->assign('title','修改成功');
				$this->assign('count',$count);
				$this->render();
			}
		
		
			public function delete($id = null){

				$count = (new ItemModel)->delete($id);//?wh{y not ItemModel()

				$this->assign('title','删除成功');
				$this->assign('count',$count);
				$this->render();

			}
}