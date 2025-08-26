<?php
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../includes/functions.php');
if(isset($_POST['submit'])){
	$select_extra_item = $_POST['select_extra_item'];
	$comm="";
	$extra_price = 0;
	$select_extra_item_val ="";
	for($i = 0; $i<count($select_extra_item); $i++){
		$select_extra_item_arr = explode(",",$select_extra_item[$i]);
		$arr = array('item' => $select_extra_item_arr[0],'price' => $select_extra_item_arr[1]); 
		$extra_price = $extra_price + $select_extra_item_arr[1];
		$select_extra_item_val .= $comm.json_encode($arr,JSON_UNESCAPED_UNICODE);
		$comm=",";
	}
	
	$extra_items = "[".$select_extra_item_val."]";
	$package_id = $obj->sanitize($conn,$_POST['id']);
	$booking_date = $obj->sanitize($conn,$_POST['booking_date']);
	$date = explode('-',$booking_date);
	$booking_date = $date[2].'-'.$date[1].'-'.$date[0];
	$booking_time = $_POST['booking_time'];
	if(isset($select_extra_item)){ $is_filming = 1; }else{ $is_filming =0; }
	$customer_name = $_POST['customer_name'];
	$customer_email = $_POST['customer_email'];
	$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	$phone = str_replace($arabic, $english, $_POST['mobile_number']);
	$mobile_number = $phone;
	if(isset($_POST['baby_name'])){ $baby_name = $_POST['baby_name']; }else{ $baby_name =''; }
	if(isset($_POST['baby_age'])){ $baby_age = $_POST['baby_age']; }else{ $baby_age =''; }
	if(isset($_POST['instructions'])){ $instructions = $_POST['instructions']; }else{ $instructions =''; }
	date_default_timezone_set('Asia/Riyadh');
			$created_at = date('Y-m-d H:i:s');

	if($is_filming == 1){
		$booking_price = $_POST['booking_price'];
		$booking_price = $booking_price + $extra_price;
	} else {
		$booking_price = $_POST['booking_price'];
		}
	
	if(check_bookingTimeAnddate($booking_date,$booking_time,$package_id)){
			$retuen_url = SITEURL.'?page=reservations&id='.$package_id;
			header('location:'.$retuen_url);
	}	 


	$package = get_packages_details($package_id);
	$package_title = $package['title_'.$_SESSION['lang']];
	$customer_mobile=$mobile_number;

	$postData='{
		"PaymentMethodId":"1",
		"CustomerName": "'.$customer_name.'",
		"DisplayCurrencyIso": "KWD",
		"MobileCountryCode":"+965",
		"CustomerMobile": "'.$customer_mobile.'",
		"CustomerEmail": "'.$customer_email.'",
		"InvoiceValue": 30.5,
		"CallBackUrl": "'.SITEURL.'index.php?page=booking-complete",
		"ErrorUrl": "'.SITEURL.'index.php?page=booking-faild",
		"Language": "en",
		"CustomerReference" :"Ref 0005",
		"ExpireDate": "",
		"SupplierCode": 5,
		"InvoiceItems": [
			{
			"ItemName": "'.$package_title.' ['.$booking_date.'] ['.$booking_time.']",
			"Quantity": 1,
			"UnitPrice": 30.5,
			}
		]
	}';

	$token = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL"; 
	$basURL = "https://apitest.myfatoorah.com";

	####### Execute Payment ######
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => "{$basURL}/v2/ExecutePayment",
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $postData,
	CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer $token",
		"Content-Type: application/json"
		),
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	echo $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
	echo "cURL Error #:" . $err;
	}else {
	//echo "$response '<br />'";
		$json = json_decode($response, true);
		$payment_url = $json["Data"]["PaymentURL"];
		$orderId = $json["Data"]["InvoiceId"];
		$tbl_name = 'tbl_booking';
		$data= "
			package_id = '$package_id',
			transaction_id = '$orderId',
			booking_date = '$booking_date',
			booking_time = '$booking_time',
			is_filming = '$is_filming',
			extra_items = '$extra_items',
			booking_price = '$booking_price',
			customer_name = '$customer_name',
			mobile_number = '$mobile_number',
			baby_name = '$baby_name',
			baby_age = '$baby_age',
			instructions = '$instructions',
			status ='No',
			created_at = '$created_at'
			";
		$query = $obj->insert_data($tbl_name,$data);
		$res = $obj->execute_query($conn,$query);
		if( $res == true ){
			$last_id = mysqli_insert_id($conn);
			header('location:'.$payment_url);
		}else{
			die('Error:'.mysqli_error($conn));
		}
	}
}
?>
