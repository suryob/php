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
	function curlPost($url,$param){
		$ch = curl_init();
		if($ch==false){
			die('Failed to create curl object');
		}
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $param);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		//execute post
		$result = curl_exec($ch);
		$err = curl_error($curl);
		
		//close connection
		curl_close($ch);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $result;
		}
	}
	function curlGet($url){
		$ch = curl_init();
		if($ch==false){
			die('Failed to create curl object');
		}
		// $timeout = 40;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		// unset($ch);
		return $data;
	}
	$ret["nol"]="0";
	$ret["satu"]["dua"]="01";
	$ret["tiga"]["empat"]["lima"]="012";
	$ret["tiga"]["empat"]["enam"]="013";
	$ret["empat"]="4";
	logit(arr2xml($ret));
?>