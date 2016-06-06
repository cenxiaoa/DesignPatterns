<?php
/**
组合模式P158
*/
class UnitException extends Exception{}

abstract class Unit{
	function addUnit(Unit $unit){
		throw new UnitException(get_class($this)." is a leaf");
	}
	
	function removeUnit(Unit $unit){
		throw new UnitException(get_class($this)." is a leaf");
	}
	
	abstract function bombardStrength();
}

class Army extends Unit{
	private $units =array();
	
	function addUnit(Unit $unit){
		if(in_array($unit,$this->units,true)){
			return;
		}
		$this->units[]=$unit;
	}
	
	function removeUnit(Unit $unit){
		$this->units = array_udiff($this->units,array($unit),
						function($a,$b){ return ($a===$b)?0:1;});
	}
	
	function bombardStrength(){
		$ret=0;
		foreach($this->units as $unit){
			$ret+=$unit->bombardStrength();
		}
		return $ret;
	}
}

class Archer extends Unit{
	function bombardStrength(){
		return 4;
	}
}

class LaserCannonUnit extends Unit{
	function bombardStrength(){
		return 44;
	}
}
// $main_army = new Archer();
// $main_army->addUnit(new Archer());//抛出异常

$main_army = new Army();

$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());

$sub_army = new Army();

$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

$main_army->addUnit($sub_army);

print "attacking with strength: {$main_army->bombardStrength()}";
?>