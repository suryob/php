<?php
	date_default_timezone_set("Asia/Jakarta");
	$uniqid = uniqid();
	function logit($str){
		global $uniqid;
		if(!is_dir("logs")){
			mkdir("logs");
		}
		$logfile = date('Ymd').".log";
		$log = fopen("logs/$logfile","a");
		$write = date('Y-m-d H:i:s')." - ".$uniqid." - ".get_client_ip()." - ".$str."\n";
		fwrite($log, $write);
		fclose($log);
	}
	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	function isjson($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
	function is_xml($xml){
		$doc = @simplexml_load_string($xml);
		if ($doc) {
			return true; //this is valid
		} else {
			return false; //this is not valid
		}
	}
	
	function arr2xml($arr,$root="response") {
		$xml = "<".$root.">";
		foreach ($arr as $key => $value) {
			if(is_array($value)) {
				$xml.=arr2xml($value,$key);
			} else {
				$xml .= "<$key>$value</$key>";
			}
		}
		$xml .= "</".$root.">";
		
		return $xml;
	}
	$ret["nol"]="0";
	$ret["satu"]["dua"]="01";
	$ret["tiga"]["empat"]["lima"]="012";
	$ret["tiga"]["empat"]["enam"]="013";
	$ret["empat"]="4";
	logit(arr2xml($ret));
?>