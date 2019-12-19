<?php
	function createClearPin($pan,$pin){
		$theLenght = 16;
		$pinlenght = strlen($pin);
		/*
			add 0 and pin lenght to pin
		*/
		$pin = "0".$pinlenght.$pin;
		/*
			append pin with "F"
		*/
		$pin = str_pad($pin,$theLenght,"F");
		/*
			extract pan account number
		*/
		$xpan = substr($pan,-13);
		$xpan = substr($xpan,0,12);
		
		/*
			add 0 in front of pan
		*/
		$pan = str_pad($xpan,$theLenght,"0",STR_PAD_LEFT);
		/*
			pack('H*',{string} is used to convert string into binary string with HEX format
			
		*/
		$clearPin = bin2hex(pack('H*',$pin) ^ pack('H*',$pan));
		return strtoupper($clearPin);
	}
	$pan = "6086141000000261";
	$pin = "111111";
	echo "pan		: ".$pan.PHP_EOL;
	echo "pin		: ".$pin.PHP_EOL;
	echo "pinclear	: ".createClearPin($pan,$pin).PHP_EOL;
?>
