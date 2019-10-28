<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_lib {

	public function native_curl($url, $data=null)
	{
		    //$username = 'admin';
		    //$password = '1234';
		
		    // Alternative JSON version
		    // $url = 'http://twitter.com/statuses/update.json';
		    // Set up and execute the curl process
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curl_handle, CURLOPT_USERPWD, "admin:1234");

		
		if($data!=null){

			curl_setopt($curl_handle, CURLOPT_POST, 0);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
		} else {
			curl_setopt($curl_handle, CURLOPT_HTTPGET, 1);
		}
		
		    // Optional, delete this line if your API is open
		    //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
		
		$buffer = curl_exec($curl_handle);
		
		curl_close($curl_handle);
		// return $buffer;
		
		return json_decode($buffer);
	}

	public function sms_curl($url, $data=null)
	{
		$curl_handle = curl_init();
		
		if($data!=null){
			$curl_handle = curl_init();

			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
		} 
		$buffer = curl_exec($curl_handle);
		$http = curl_getinfo($curl_handle);
		$redirect = $http['redirect_url'];
		curl_setopt($curl_handle, CURLOPT_URL, $redirect);
		echo file_get_contents($redirect);
		
		curl_close($curl_handle);
		// return $buffer;
		
		return json_decode($buffer);
	}

	public function email_curl($url, $data=null)
	{
		$curl_handle = curl_init();
		
		if($data!=null){
			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		} 
		$buffer = curl_exec($curl_handle);
		
		curl_close($curl_handle);
	}

	public function cleanlink($link) {
		return str_replace(array(' ', '&', '/'), array('', '', ''), $link);
	}

	public function linkspace($link) {
		return str_replace(array('%20','+'), array(' ',' '), $link);
	}

	public function arrsort(&$array, $key, $type) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		$type=="asc" ? asort($sorter) : arsort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
	}

	public function humanTiming($time) {
		$time = time()- $time; 
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
			);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'')." ago";
			
		}
	}

}
?>