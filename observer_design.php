<?php
/**
观察者模式P189
*/
interface Observable{
	function attach(Observer $observer);//注册观察者
	function detach(Observer $observer);//释放观察者
	function notify();//通知所有观察者
}
//Login类
class Login implements Observable{
	const LOGIN_USER_UNKNOWN=1;
	const LOGIN_WRONG_PASS=2;
	const LOGIN_ACCESS=3;
	private $status =array();

	private $observers;
	
	function __construct(){
		$this->observers = array();
	}
	
	function attach(Observer $observer){//实现接口
		$this->observers[] = $observer;
	}

	function detach(Observer $observer){//实现接口
		$newobservers = array();
		foreach($this->observers as $obs){
			if($obs!==$observer){
				$newobservers[]=$obs;
			}
		}
		$this->observers = $newobservers;
	}

	function notify(){//实现接口
		foreach($this->observers as $obs){
			$obs->update($this);
		}
	}
	function handleLogin($user,$pass,$ip){//主体
		switch(rand(1,3)){
			case 1:
				$this->setStatus(self::LOGIN_ACCESS,$user,$ip);
				$ret=true;
				break;
			case 2:
				$this->setStatus(self::LOGIN_WRONG_PASS,$user,$ip);
				$ret=false;
				break;
			case 3:
				$this->setStatus(self::LOGIN_ACCESS,$user,$ip);
				$ret=false;
				break;
		}
		$this->notify();//通知所有观察者
		return $ret;
	}

	private function setStatus($status,$user,$ip){
		$this->status = array($status,$user,$ip);
	}

	function getStatus(){
		return $this->status;
	}

}

interface Observer{//观察者接口
	function update(Observable $observable);
}

abstract class LoginObserver implements Observer{//Login类型专用的观察者抽象类
	private $login;
	function __construct(Login $login)
	{
		$this->login = $login;
		$login->attach($this);
	}

	function update(Observable $observable){
		if($observable === $this->login){
			$this->doUpdate($observable);
		}
	}

	abstract function doUpdate(Login $login);
}

class SecurityMonitor extends LoginObserver{//观察者1
	function  doUpdate(Login $login){
		$status = $login->getStatus();
		if($status[0] == Login::LOGIN_WRONG_PASS){
			//发送邮件给系统管理员
			print __CLASS__.":发送邮件给管理员</br>";
		}
	}
}

class GeneralLogger extends LoginObserver{//观察者1
	function doUpdate(Login $login){
		$status = $login->getStatus();
		//记录登陆数据到日志
		echo __CLASS__.":记录登陆数据到日志</br>";
	}
}

class PartnershipTool extends LoginObserver{//观察者1
	function doUpdate(Login $login){
		$status = $login->getStatus();
		//检查IP
		//如果匹配列表，则设置COOKIE
		echo __CLASS__.":检查IP,如果匹配列表，则设置COOKIE</br>";
	}
}

//客户端代码
$login = new Login();
$a=new SecurityMonitor($login);
$b=new GeneralLogger($login);
$c=new PartnershipTool($login);
/*$d=new GeneralLogger($login);
$login->detach($d);*/
$login->handleLogin("stud1","123123","10.0.0.1");//这里就会先调用notify通知所有观察者，然后调用每个观察者的updata，检查类型后再调用doUpdate
