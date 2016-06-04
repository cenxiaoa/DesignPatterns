<?php
/**
工厂方法模式P144
*/
abstract class ApptEncoder{
	abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder{
	function encode(){
		return "Appointment data encode in BloggsCal format </br>";
	}
}

class MegaApptEncoder extends ApptEncoder{
	function encode(){
		return "Appointment data encode in MegaCal format </br>";
	}
}

abstract class CommsManager{//抽象工厂
	abstract function getHeaderText();
	abstract function getApptEncoder();
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager{//具体工厂，只负责Bloggs格式
	function getHeaderText(){
		return "BloggsCal header </br>";
	}
	
	function getApptEncoder(){
		return new BloggsApptEncoder();
	}
	
	function getFooterText(){
		return "BloggsCal footer </br>";
	}
}

class MegaCommsManager extends CommsManager{//具体工厂，只负责Mega格式
	function getHeaderText(){
		return "MegaCal header </br>";
	}
	
	function getApptEncoder(){
		return new MegaApptEncoder();
	}
	
	function getFooterText(){
		return "MegaCal footer </br>";
	}
}

$Manager = new BloggsCommsManager();

print $Manager->getHeaderText();

print $Manager->getApptEncoder()->encode();

print $Manager->getFooterText();


$Manager2 = new MegaCommsManager();

print $Manager2->getHeaderText();

print $Manager2->getApptEncoder()->encode();

print $Manager2->getFooterText();

?>