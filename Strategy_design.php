<?php
/**
策略模式P124
*/
abstract class Lesson{
	private $duration;
	private $costStrategy;
	
	function __construct($duration, CostStrategy $strategy){
		$this->duration =  $duration;
		$this->costStrategy = $strategy;
	}
	
	function cost(){
		return $this->costStrategy->cost($this);
	}
	
	function chargeType(){
		return $this->costStrategy->chargeType();
	}
	
	function getDuration(){
		return $this->duration;
	}
}

class Lecture extends Lesson{
	
}

class Seminar extends Lesson{

}

abstract class CostStrategy{
	abstract function cost(Lesson $lesson);
	abstract function chargeType();
}

class TimeCostStrategy extends CostStrategy{
	function cost( Lesson $lesson){
		return ( $lesson->getDuration() * 5 );
	}

	function chargeType(){
		return "hourly rate";
	}
}

class FixedCostStrategy extends CostStrategy{
	function cost(Lesson $lesson){
		return 30;
	}
	
	function chargeType(){
		return "fixed rate";
	}
}

$lessons[] = new Lecture(5, new FixedCostStrategy());
$lessons[] =  new Seminar(10, new TimecostStrategy());
foreach($lessons as $lesson){
	echo 'lesson cost:'.$lesson->cost().'</br>';
	echo 'lesson type:'.$lesson->chargeType().'</br>';
}



//降低耦合
class RegistrationMgr{
	function register(Lesson $lesson){
		//处理数据

		//通知某人
		$notifier = Notifier::getNotifier();
		$notifier->inform("new Lesson :cost({$lesson->cost()})");
	}
}

abstract class Notifier{
	static function getNotifier(){
		//根据配置文件或其他信息获得具体的类


		if(rand(1,2)==1){
			return new MailNotifier();
		}else{
			return new TextNotifier();
		}
	}
	abstract function inform($message);
}

class MailNotifier extends Notifier{
	function inform($message){
		echo "Mail notification $message </br>";
	}
}

class TextNotifier extends Notifier{
	function inform($message){
		echo "Text notification $message </br>";
	}
}

$reg= new RegistrationMgr();
foreach($lessons as $lesson){
	$reg->register($lesson);
}


?>