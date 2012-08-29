<?php

// replace whitespace with "+"
function replace_space($string){
	return str_replace(" ", "+", $string);
}

// list all plugins in "plugins" folder
function list_plugins(){
	$file = scandir(getcwd()."/plugins");
	foreach(array('0', '1') as $remove){
		unset($file[$remove]);
	}
	return $file;
}

// encode and decode GET request when sending data
function encode_url($input, $type) {
	if($type == "encode") {
		return strtr(base64_encode(gzdeflate(gzcompress(str_rot13($input)), 9)), '+/=', '-_,');
	}elseif($type == "decode"){
		return str_rot13(gzuncompress(gzinflate(base64_decode(strtr($input, '-_,', '+/=')))));
	}
}

// rename plugins
function rename_plugins($file){
	return str_replace(".php", "", str_replace("_", ".", $file));
}

// check curl status from local server and from variable $curl
function curl_status($options){
	if($options == "TRUE" && in_array('curl', get_loaded_extensions())){
		return "OK!";
	}else{
		return "NOT OK!";
	}
}

// get data from internet
function getdata($url, $option){
	if($option = TRUE && curl_status($curl) == "OK!"){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec ($ch);
		curl_close ($ch);
		return $data;
	} else {
		return file_get_contents($url);
	}
}

// credit..please don't remove  :)
function credit(){
	echo "<br><br><center>Idea and creator : <font color=red>Shahril</font> <br> Thank to <font color=blue>AFnum</font> for fixing some code<br>-<font color=purple>2012</font>-</center>";
}

?>