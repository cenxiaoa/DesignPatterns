<?php
/**
 * 电视机遥控器 :
   电视机是请求的接收者，
   遥控器是请求的发送者，
   遥控器上有一些按钮，不同的按钮对应电视机的不同操作。抽象命令角色由一个命令接口来扮演，
   有三个具体的命令类实现了抽象命令接口，这三个具体命令类分别代表三种操作：打开电视机、关闭电视机和切换频道。
   显然，电视机遥控器就是一个典型的命令模式应用实例。

 */
/**
 * The Command abstraction( 命令接口，声明执行的操作).  
 * In this case the implementation must return a result,  
 * sometimes it only has side effects.  
 */
interface ICommand
{
	/**
	 * 执行命令对应的操作
	 *
	 * @param unknown_type $name
	 * @param unknown_type $args
	 */
	function execute();
}


/**
 * ConcreteCommand具体的命令实现对象:打开命令
 */
class ConcreteCommandOpen implements ICommand {
	/**
     * 持有相应的接收者对象
     */
	private  $_receiverTV = null; //
	/**
     * 示意，命令对象可以有自己的状态
     */
	private  $_state;
	/**
     * 构造方法，传入相应的接收者对象
     * @param receiver 相应的接收者对象
     */
	public function  __construct($receiver){
		$this->_receiverTV = $receiver;
	}
	public function execute() {
		//通常会转调接收者对象的相应方法，让接收者来真正执行功能
		$this->_receiverTV->actionOpen();
	}
}
/**
 * ConcreteCommand具体的命令实现对象：关闭
 */
class ConcreteCommandClose implements ICommand {
	/**
     * 持有相应的接收者对象
     */
	private  $_receiverTV = null; //
	/**
     * 示意，命令对象可以有自己的状态
     */
	private  $_state;
	/**
     * 构造方法，传入相应的接收者对象
     * @param receiver 相应的接收者对象
     */
	public function  __construct($receiver){
		$this->_receiverTV = $receiver;
	}
	public function execute() {
		//通常会转调接收者对象的相应方法，让接收者来真正执行功能
		$this->_receiverTV->actionClose();
	}
}

/**
 * ConcreteCommand具体的命令实现对象：换频道
 */
class ConcreteCommandChange implements ICommand {
	/**
     * 持有相应的接收者对象
     */
	private  $_receiverTV = null; //
	/**
     * 示意，命令对象可以有自己的状态
     */
	private  $_state;
	/**
     * 构造方法，传入相应的接收者对象
     * @param receiver 相应的接收者对象
     */
	public function  __construct($receiver){
		$this->_receiverTV = $receiver;
	}
	public function execute() {
		//通常会转调接收者对象的相应方法，让接收者来真正执行功能
		$this->_receiverTV->actionChange();
	}
}

/**
 * 接收者对象
 */
class ReceiverTV {
	/**
     * 真正执行命令相应的打开操作
     */
	public function actionOpen(){
		echo 'actionOpen<br/>';
	}
	
	/**
     * 真正执行命令相应的关闭操作
     */
	public function actionClose(){
		echo 'actionClose<br/>';
	}
	
	/**
     *  真正执行命令相应的换频道操作
     */
	public function actionChange(){
		echo 'actionChange<br/>';
	}
}

/**
 * 调用者Invoker:遥控器 
 */
class InvokerControler {
	/**
     * 持有命令对象
     */
	private $_commands = null; //ICommand
	/**
     * 设置调用者持有的命令对象
     * @param command 命令对象
     */
	public function addCommand($command) {
		$classname = get_class($command);
		$this->_commands[$classname] = $command;
	}
	/**
     * 示意方法，要求命令执行请求
     */
	public function runCommand($cmdName) {
		//调用命令对象的执行方法
		$this->_commands[$cmdName]->execute();
	}
}
class Client {
    /**
     * 示意，负责创建命令对象，并设定它的接收者
     */
    public static  function main(){
       //创建电视接收者
       $receiver = new ReceiverTV();
       
       //创建Invoker
       $invoker = new InvokerControler();
       //创建命令对象，设定它的接收者
       $commandOpen = new ConcreteCommandOpen($receiver);
       //把命令对象设置进调用遥控器
       $invoker->addCommand($commandOpen);
       
       //执行打开命令
       $invoker->runCommand(get_class($commandOpen));
       
     
    }
}
Client::main();
?>