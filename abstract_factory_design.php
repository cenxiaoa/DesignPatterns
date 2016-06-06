<?php
/**
抽象工厂模式
*/
abstract class CommsManager{
	const APPT =1;
	const TTD =2;
	const CONTACT =3;
	abstract function getHeaderText();
	abstract function make( $flag_int);
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager{
	function getHeaderText(){
		return "BloggsCal header \n";
	}
	
	function make ($flag_int){//BloggsApptEncoder、BloggsContectEncoder和BloggsTtdEncoder属于同一个产品族（不同产品树中相关联的产品）
		switch($flag_int){
			case self::APPT:
				return new BloggsApptEncoder();
			case self::CONTACT:
				return new BloggsContectEncoder();
			case selft:TTD:
				return new BloggsTtdEncoder();
		}
	}
	
	function getFooterText(){
		return "BloggsCal Footer \n";
	}
}

?>