<?php
namespace fastphp;

//定义根目录
defind('CORE_PATH') or defind('CORE_PATH',__DIR__);



class Fastphp{

	protected $config =[];

	public function __construct($config){
		$this->config =$config;
	}


	public function run(){
		spl_autoload_register(array($this,'loadClass'));
		$this->setReporting();
		$this->removeMagicQuotes();
		$this->unregisterGlobals();
		$this->setDbConfig();
		$this->route();
	}

	public function route(){
		$controllerName = $this->config['defaultController'];
		$actionName = $this->config['defaultAction'];
		$param =array();


		$url = $_SERVER['REQUEST_URI'];

		$position = strpos($url,'?');
		$url = $position === false ? $url : substr($uel,0,$position);

		$url = trim($url,'/');

		if($url){

			//分割url保存到数组
			$urlArray = explode('/', $url);

			//删除空数组元素
			$urlArray = array_filter($urlArray);

			//ucfirst() 函数把字符串中的首字符转换为大写
			/*lcfirst() - 把字符串中的首字符转换为小写
			strtolower() - 把字符串转换为小写
			strtoupper() - 把字符串转换为大写
			ucwords() - 把字符串中每个单词的首字符转换为大写*/

			$controllerName = ucfirst($urlArray[0]);

			//array_shift() 函数删除数组中第一个元素，并返回被删除元素的值。
			arrary_shift($urlArray);

			$actionName = $urlArray ? $urlArray[0] : $actionName;
		}
	}
}