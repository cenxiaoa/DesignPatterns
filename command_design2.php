<?php
/**
 * 命令模式 P201
 相对于第一个例子，少了执行命令的接收对象。
 */

abstract class Command{ //命令接口
	abstract function execute(CommandContext $context);
}

class LoginCommand extends Command{//具体的命令
	function execute(CommandContext $context){
		// $manager = Registry::getAccessManager();
		$user = $context->get('username');
		$pass = $context->get('pass');
		// $user_obj = $manager->login($user,$pass);
		// if(is_null($user_obj)){
			// $context->setError($manager->getError);
			// return false;
		// }
		// $context->addParam('user',$user_obj);
		// return true;
		echo '执行登陆</br>';
		return true;
	}
}
 
class CommandContext{//只是将关联数组变量包装而成的对象
	private $params = array();
	private $error ="";
	 
	function __construct(){
		$this->params = $_REQUEST;
	}
	 
	function addParam($key,$val){
		$this->params[$key]=$val;
	}
	 
	function get($key){
		return $this->params[$key];
	}
	 
	function setError($error){
		$this->error = $error;
	}
	 
	function getError(){
		return $this->error;
	}
}

//工厂，根据调用者传递过来的参数，生成命令对象
class CommandFactory{
	private static $dir = 'commands';
	
	static function getCommand($action='Default'){
		if(preg_match('/\W/',$action)){
			throw new Exception("illegal characters in action");
		}
		$class=$action."Command";
		$cmd = new $class;
		return $cmd;
	}
}
//调用者
class Controller{
	private $context;
	
	function __construct(){
		$this->context = new CommandContext();
	}
	function getContext(){
		return $this->context;
	}
	
	function process(){
		$cmd = CommandFactory::getCommand($this->context->get('action'));//获取命令对象
		if(!$cmd->execute($this->context)){
			//处理失败
			echo '失败';
		}
		else{
			//处理成果
			echo '成功';
		}
	}
	
}

$controller = new Controller();
//伪造客户请求
$context = $controller->getContext();
$context->addParam('action','Login');//要执行命令Login
$context->addParam('username','bob');
$context->addParam('pass','tiddles');
$controller->process();