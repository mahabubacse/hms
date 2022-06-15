<?php


function sendSms($phoneNumber,$message)
{
    //echo "here";
    $phoneNumber = trim($phoneNumber);
    $message = urlencode($message);
    if($message !=null && $phoneNumber !=null){
		$url = "https://api.tnrsoft.com/send.php?token=gdvefdrgrdft354678dctrs&phone=".$phoneNumber."&message=".urlencode($message);
		$curl = curl_init($url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);

		if($curl_response === false){
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('Error occurred'.var_export($info));
		}

		curl_close($curl);

		$response  = json_decode($curl_response);
		if($response->code == 1){
			//echo 'Message has been sent';
			
			//$res = (object)array("success"=>true); //Return Json
			$res = (object)array("code"=>'1',"status"=>'success',"phone"=>$phoneNumber); //Return Json
			$mJSON = json_encode($res);

			//echo $mJSON;
		}else{
			$res = (object)array("code"=>'0',"status"=>'failed',"phone"=>$phoneNumber); //Return Json
			$mJSON = json_encode($res);

			//echo $mJSON;
		}
	}
}
?>