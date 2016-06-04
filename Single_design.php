<?php
/**
单例模式P139
*/
class Preferences {
	private $props = array();
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new Preferences();
		}
		return self::$instance;
	}
	
	public function setProperty($key, $val){
		$this->props[$key] = $val;
	}
	
	public function getProperty($key){
		return $this->props[$key];
	}
}
// $a=new Preferences();这样会出错，因为构造函数是私有的
$pref = Preferences::getInstance();
$pref->setProperty("name","matt");

unset($pref);

$pref2 = Preferences::getInstance();
echo $pref2->getProperty("name");


?>