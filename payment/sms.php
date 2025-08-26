<?php
$urlLink = "https://bit.ly/2S3e7WR";
$mobile ='96565680566';
 $message='MyShoots booking id 7868686, Studio location ' . $urlLink;
$message = str_replace(' ','+',$message);
		$url = 'http://www.kwtsms.com/API/send/?username=ghaliah&password=Gh@li@h91&sender=MyShoots&mobile='.$mobile.'&lang=1&message='.$message;
		       $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));
                $response = curl_exec($curl);
                var_dump($response);
                $err = curl_error($curl);
				curl_close($curl);
				if ($err){
					return $err;
				}else{
					  return $response;	
				}
?>
