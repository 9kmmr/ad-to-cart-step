<?php

	namespace Worldpay;

?>



<?php 

	get_header();
	function connection(){
			$mysqli = new \mysqli("localhost", "xpress_deepbratt", "Samadder5#", "xpress_delivery");

			//$mysqli = new mysqli("localhost", "root", "", "express_delivery");

			if ($mysqli->connect_errno) {

				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				return false;

			}
			else return $mysqli;
	}
	function get_distance($vehicle,$addTo,$addFrom){
		
			$mysqli = connection();
			$addressFrom = urlencode($addFrom);

			$addressTo = urlencode(trim($addTo));

			$rjourny = '';

			/*this is addressTo */
			$str_adrsz_to = preg_replace('/[+]/s','', $addressTo);
			$str_count_addr5 = strlen($str_adrsz_to);
			if($str_count_addr5 == 1){
				$deduct = 0;
			}else if($str_count_addr5 == 2){
				$deduct = 0;
			}else if($str_count_addr5 == 3){
				$deduct = 0;
			}else if($str_count_addr5 == 4){
				$deduct = 1;
			}else if($str_count_addr5 == 5){
				$deduct = 2;
			}else if($str_count_addr5 == 6){
				$deduct = 3;
			}else if($str_count_addr5 == 7){
				$deduct = 4;
			}
			$str_count_addr3 = $str_count_addr5-$deduct;
			$cutaddressTo = substr($str_adrsz_to,0,$str_count_addr3);
			/*this is addressTo */

			/*this is addressfrom */

			$str_adrsz_from = preg_replace('/[+]/s','', $addressFrom);
			
			$str_count_addr = strlen($str_adrsz_from);
			$str_count_addr2 = $str_count_addr-3;

			$cutaddressFrom = substr($str_adrsz_from,0,$str_count_addr2);
				

			/*this is addressfrom */
			//echo "<br />";
			$quwery = "SELECT * FROM collection_surcharge where vehicle_id='$vehicle' AND postal_codes = '$cutaddressFrom'";
			$query_check_collectionsurcharge = mysqli_query($mysqli,$quwery);
			$fetch_collectionsurcharge = mysqli_fetch_array($query_check_collectionsurcharge);

			$get_rows_count_collection = mysqli_num_rows($query_check_collectionsurcharge);
			$msg="";

			$clen = strlen($cutaddressFrom);
			
			$allow_from_other_collection = true;

			$query_allow_get = "SELECT allow_other_collection FROM  col_option WHERE id=1 ; ";
			$allow_value = mysqli_fetch_array(mysqli_query($mysqli,$query_allow_get));
			$allow_from_other_collection = ($allow_value['allow_other_collection']== 1 ) ? true :false ; 
			
			if((!$get_rows_count_collection) && $allow_from_other_collection){

				while((!$get_rows_count_collection) && ($clen >= 0) ){
					$cutaddressFrom2 = substr($cutaddressFrom,0,$clen);
					
					$quwery2 = "SELECT * FROM collection_surcharge where postal_codes like '%$cutaddressFrom2%'";
					$query_check_collectionsurcharge = mysqli_query($mysqli,$quwery2);
					$fetch_collectionsurcharge = mysqli_fetch_array($query_check_collectionsurcharge);

					$get_rows_count_collection = mysqli_num_rows($query_check_collectionsurcharge);	
					$clen = $clen-1;
				}

				$msg = "Surcharge fee for ".$cutaddressFrom." not active in database.<br>";
			}		

			$collection_surcharge = $fetch_collectionsurcharge['price'];
			if($clen <=1) $collection_surcharge = 0;

		
			$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$addressFrom&destinations=$addressTo&language=en-EN&sensor=false");
			$data = json_decode($data);
			
			$time = 0;
			$distance = 0;
			
			foreach($data->rows[0]->elements as $road) {
				$time += $road->duration->value;
				$distance += $road->distance->value;
			}
			//echo "Total Miles:";
			$mile = round($distance/1609.34,2);
			return $mile ;
	}
	function calculate($vehicle,$addTo,$addFrom,$date,$time_pick,$twoman){

			$mysqli = connection();

			$addressFrom = urlencode($addFrom);

			$addressTo = urlencode(trim($addTo));

			$rjourny = '';

			/*this is addressTo */
			$str_adrsz_to = preg_replace('/[+]/s','', $addressTo);
			$str_count_addr5 = strlen($str_adrsz_to);
			if($str_count_addr5 == 1){
				$deduct = 0;
			}else if($str_count_addr5 == 2){
				$deduct = 0;
			}else if($str_count_addr5 == 3){
				$deduct = 0;
			}else if($str_count_addr5 == 4){
				$deduct = 1;
			}else if($str_count_addr5 == 5){
				$deduct = 2;
			}else if($str_count_addr5 == 6){
				$deduct = 3;
			}else if($str_count_addr5 == 7){
				$deduct = 4;
			}
			$str_count_addr3 = $str_count_addr5-$deduct;
			$cutaddressTo = substr($str_adrsz_to,0,$str_count_addr3);
			/*this is addressTo */

			/*this is addressfrom */

			$str_adrsz_from = preg_replace('/[+]/s','', $addressFrom);
			
			$str_count_addr = strlen($str_adrsz_from);
			$str_count_addr2 = $str_count_addr-3;

			$cutaddressFrom = substr($str_adrsz_from,0,$str_count_addr2);
				

			/*this is addressfrom */
			//echo "<br />";
			$quwery = "SELECT * FROM collection_surcharge where vehicle_id='$vehicle' AND postal_codes = '$cutaddressFrom'";
			$query_check_collectionsurcharge = mysqli_query($mysqli,$quwery);
			$fetch_collectionsurcharge = mysqli_fetch_array($query_check_collectionsurcharge);

			$get_rows_count_collection = mysqli_num_rows($query_check_collectionsurcharge);
			$msg="";

			$clen = strlen($cutaddressFrom);
			
			$allow_from_other_collection = true;

			$query_allow_get = "SELECT allow_other_collection FROM  col_option WHERE id=1 ; ";
			$allow_value = mysqli_fetch_array(mysqli_query($mysqli,$query_allow_get));
			$allow_from_other_collection = ($allow_value['allow_other_collection']== 1 ) ? true :false ; 
			
			if((!$get_rows_count_collection) && $allow_from_other_collection){

				while((!$get_rows_count_collection) && ($clen >= 0) ){
					$cutaddressFrom2 = substr($cutaddressFrom,0,$clen);
					
					$quwery2 = "SELECT * FROM collection_surcharge where postal_codes like '%$cutaddressFrom2%'";
					$query_check_collectionsurcharge = mysqli_query($mysqli,$quwery2);
					$fetch_collectionsurcharge = mysqli_fetch_array($query_check_collectionsurcharge);

					$get_rows_count_collection = mysqli_num_rows($query_check_collectionsurcharge);	
					$clen = $clen-1;
				}

				$msg = "Surcharge fee for ".$cutaddressFrom." not active in database.<br>";
			}		

			$collection_surcharge = $fetch_collectionsurcharge['price'];
			if($clen <=1) $collection_surcharge = 0;

			$date = trim($date);
			$timstamp = strtotime($date);
			$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$addressFrom&destinations=$addressTo&language=en-EN&sensor=false");
			$data = json_decode($data);
			$time_pick = $time_pick;
			$time = 0;
			$distance = 0;
			
			foreach($data->rows[0]->elements as $road) {
				$time += $road->duration->value;
				$distance += $road->distance->value;
			}
			//echo "Total Miles:";
			$mile = round($distance/1609.34,2);
			//echo "<br />";

			/*mileage threshold */
			$query_get_threshold = mysqli_query($mysqli,"SELECT * FROM mileage_threshold WHERE mileage_threshold.range_from < $mile AND $mile <= mileage_threshold.range_to");
			$cound_rows = mysqli_num_rows($query_get_threshold);
			if($cound_rows > 0){
				$fetch_mileage_threshold = mysqli_fetch_array($query_get_threshold);

				/*current threshold id from range get */
				$current_rangefrom_id = $fetch_mileage_threshold['threshold_id'];
				/*current threshold id from range get */

				$get_all_thresholds = mysqli_query($mysqli,"SELECT * FROM mileage_threshold WHERE threshold_id < $current_rangefrom_id order by threshold_id desc limit 1");
				$fetch_all_threshold = mysqli_fetch_array($get_all_thresholds);

				/*current get_excess miles no */
				$mile_range = $fetch_all_threshold['range_to'];
				$excess_mile_no = $mile-$mile_range;

				/* get excess miles price count */
				$cost_dec_pmile = $fetch_mileage_threshold['cost_per_mile_decrease'];
				$get_last_mile_addition_value = round($excess_mile_no*$fetch_mileage_threshold['cost_per_mile_decrease'],2);
				$get_prev_miles_count = mysqli_query($mysqli,"SELECT * FROM mileage_threshold WHERE threshold_id < $current_rangefrom_id");
				$prev_mile_range_count = 0;

				while($fetch_prev_miles_count = mysqli_fetch_array($get_prev_miles_count)){
					$a += $fetch_prev_miles_count['cost_per_mile_decrease']*50;
				}
				//echo $a;
				$total_cost_decs = round($a+$get_last_mile_addition_value,2);
			}else{
				$total_cost_decs = 0;
			}
			/*mileage threshold*/

			//echo $total_cost_decs;
			//echo "<br />";

			$rdata = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$addressFrom&destinations=$addressTo&language=en-EN&sensor=false");
			$rdata = json_decode($rdata);
			$rdistance = 0;
			foreach($rdata->rows[0]->elements as $rroad) {
				$rdistance += $rroad->distance->value;
			}
			//echo "Total Return journey miles :";
			$zmile = round($rdistance/1609.34,2);
			/*mileage threshold */
			$query_get_thresholdz = mysqli_query($mysqli,"SELECT * FROM mileage_threshold WHERE mileage_threshold.range_from < $zmile AND $zmile <= mileage_threshold.range_to");
			$cound_rowsz = mysqli_num_rows($query_get_thresholdz);
			if($cound_rowsz > 0){
				$fetch_mileage_thresholdz = mysqli_fetch_array($query_get_thresholdz);
				$cost_dec_pmilez = $fetch_mileage_thresholdz['cost_per_mile_decrease'];
				$total_cost_decsz = round($zmile*$fetch_mileage_thresholdz['cost_per_mile_decrease'],2);
			}else{
				$total_cost_decsz = 0;
			}
			/*mileage threshold*/
	
			$get_all_details = mysqli_query($mysqli,"SELECT * FROM vehicle_options, vat_tax, min_charge, fuel_surcharge,  free_miles, charge_permile, extra_fare WHERE vehicle_options.vehicle_id='$vehicle' AND vat_tax.	vat_tax_vehicle='$vehicle' AND min_charge.vehicle_id='$vehicle' AND fuel_surcharge.fuel_surcharge_vehicle='$vehicle' AND free_miles.free_mile_vechile='$vehicle' AND extra_fare.vehicle_id='$vehicle' AND charge_permile.charge_permile_vehicle='$vehicle'");
			$fetch_all_details = mysqli_fetch_array($get_all_details);


				
			$rmile = round($zmile-$fetch_all_details['free_mile_no'],2);
			$original_mile = round($mile-$fetch_all_details['free_mile_no'],2);

			$check_weekends = date("w",$timstamp);
			if($check_weekends == 0){
				$min_charge = $fetch_all_details['hprice'];
			}else{
				$min_charge = $fetch_all_details['min_charge_price'];
			}
				//echo $min_charge;
				//echo $charge_mile = $min_charge+round(($fetch_all_details['charge_permile_price']*$original_mile)-$total_cost_decs,2);
			$charge_mile = round($fetch_all_details['charge_permile_price']*$original_mile,2);
				/* return journey */
				//$rcharge_mile = $min_charge+round(($fetch_all_details['charge_permile_price']*$rmile)-$total_cost_decsz,2);
			$rcharge_mile = round($fetch_all_details['charge_permile_price']*$rmile,2);
				/* return journey */
			if($vehicle == 1){
				$surcharge_fetch_value = 1;
			}else if($vehicle == 2){
				$surcharge_fetch_value = 2;
			}else if($vehicle == 3){
				$surcharge_fetch_value = 3;
			}

			$get_surcharge_val = mysqli_query($mysqli,"SELECT * FROM fuel_surcharge WHERE fuel_surcharge_vehicle='$surcharge_fetch_value'");
			$fetch_perce_surchar = mysqli_fetch_array($get_surcharge_val);

			$surcharge_percentage = $fetch_perce_surchar['fuel_surcharge_amt']/100;

			//$surcharge = ($charge_mile+$fetch_all_details['min_charge_price'])*$surcharge_percentage;
			$rsurcharge = ($rcharge_mile+$fetch_all_details['min_charge_price'])*$surcharge_percentage;
			$tax = ($charge_mile+$fetch_all_details['min_charge_price'])*0.2;
			$rtax = ($rcharge_mile)*0.2;


			if($min_charge > $charge_mile){
				$newcharge_mile = $min_charge;
			}else{
					$newcharge_mile = $charge_mile;
			}

			//0-sunday , 6-saturday
			$check_weekends = date("w",$timstamp);
			if($check_weekends == 0){
					$weekend_fare = ($newcharge_mile)*($fetch_all_details['weekends_fare']/100);
					$rweekend_fare = ($newcharge_mile)*($fetch_all_details['weekends_fare']/100);
			}
			else{
				$weekend_fare = "0"; //(this is percentage muli
				$rweekend_fare = "0";
			}

			// check night time between 6pm - 5am
			if($time_pick == '18' || $time_pick == '19' || $time_pick == '20' || $time_pick == '21' || $time_pick == '22' || $time_pick == '23' || $time_pick == '24' || $time_pick == '01' || $time_pick == '02' || $time_pick == '03' || $time_pick == '04' || $time_pick == '05'){
				$timefare = ($newcharge_mile)*($fetch_all_details['night_fare']/100);
				$rtimefare = ($newcharge_mile)*($fetch_all_details['night_fare']/100);
			}else{
				$timefare = "0";
				$rtimefare = "0";
			}

			//check expeceptional postal codes
			$query_show_codez = "SELECT * FROM `exceptional_pincodes` WHERE pincodes LIKE '%".$cutaddressTo."%'";
			$check_postal_codes = mysqli_query($mysqli,$query_show_codez);
			$get_postal_rows = mysqli_num_rows($check_postal_codes);
			if($get_postal_rows > 0){
				//$postal_fare = $charge_mile*0.2;
				$postal_fare = 35;
				//$rpostal_fare = $rcharge_mile*0.2;
			}else{
				$postal_fare = 0;
				$rpostal_fare = 0;
			}

			/*two man option starts */

			if($twoman && $twoman=="yes"){
				$two_man_getdeet = mysqli_query($mysqli,"SELECT * FROM two_man_option WHERE two_man_vehicleid='$vehicle'");
				$fetch_two_man = mysqli_fetch_array($two_man_getdeet);
				$two_man = $fetch_two_man['two_man_price'];
			}else{
				$two_man = 0;
			}
			/*two man option ends */

			if($get_rows_count_collection > 0){

				if($weekend_fare > 0){
					if($min_charge > $charge_mile){
						$newcharge_mile = $min_charge;
					}else{
						$newcharge_mile = $charge_mile;
					}
				}else{
					if($min_charge > $charge_mile){
						$newcharge_mile = $min_charge;
					}else{
						$newcharge_mile = $charge_mile;
					}
				}				
				$withoutsurcharge = round($newcharge_mile+$weekend_fare-$total_cost_decs+$timefare+$postal_fare+$two_man+$collection_surcharge,2);
				$surcharge = $withoutsurcharge*$surcharge_percentage;
				$withouttax = round($withoutsurcharge+$surcharge,2);				
					
				if($rjourny&& $rjourny != ''){
					if($rweekend_fare > 0){
						if($min_charge > $charge_mile){
							$rnewcharge_mile = $min_charge;
						}else{
							$rnewcharge_mile = $rcharge_mile;
						}
					}else{
						if($min_charge > $charge_mile){
							$rnewcharge_mile = $min_charge;
						}else{
							$rnewcharge_mile = $rcharge_mile;
						}
					}
					$rwithouttax = round(($rnewcharge_mile+$rsurcharge+$rweekend_fare+$rtimefare+$rpostal_fare+$two_man)/2,2);
					
				}else{
					$rwithouttax = 0;						
				}		
				if($rjourny && $rjourny != ''){
				 	$tttaxxx = round(($withouttax+$rwithouttax)*0.2,2);
				
				}else{
					
					$tttaxxx = round(($withouttax)*0.2,2);
				}
				if($rjourny && $rjourny != ''){
							$total_val =  round($withouttax+$rwithouttax+$tttaxxx,2);
					}else{
						$total_val =  round($withouttax+$tttaxxx,2);
					}
				
			}else{

				$data = "erz";

			}		

			return $total_val;

	}

	$total_money = 0;
	$total_distance = 0;
	if (count($_SESSION['data'])){

			foreach ($_SESSION['data'] as $key => $value) {

				$total_money += calculate($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman']);
				$total_distance += get_distance($value['type'],$value['to'],$value['from']);
			}

	}

	if (isset($_POST['finish'])){

		require_once(plugin_dir_path( __FILE__ ).'init.php');


		// SERVICE KEY IN THIS
		$worldpay = new Worldpay('T_S_13ff3d30-75d1-44ab-82c0-8e84b7d50658');

		$worldpay->disableSSLCheck(true);

		

		$billing_address = array(

		    "address1"=> isset($_POST['address1']) ? $_POST['address1'] :'',

		    "address2"=> isset($_POST['address2']) ? $_POST['address2'] :'',

		    "address3"=> isset($_POST['address3']) ? $_POST['address3'] :'',

		    "postalCode"=> isset($_POST['postcode']) ? $_POST['postcode'] : '',

		    "city"=> isset($_POST['city']) ? $_POST['city'] : '',

		    "state"=> isset($_POST['state']) ? $_POST['state'] : '',

		    "countryCode"=>  isset($_POST['countryCode']) ? $_POST['countryCode'] : 'GB',

		);

		$paymentMethod = array(

                  "name" => isset($_POST['cartname'])? $_POST['cartname'] : '',

                  "expiryMonth" => isset($_POST['expiration-month'] )? $_POST['expiration-month'] : '',

                  "expiryYear" => isset($_POST['expiration-year'])? $_POST['expiration-year'] : '',

                  "cardNumber"=>isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '',

                  "cvc"=>isset($_POST['cvc']) ? $_POST['cvc']: ''

            );

		$_3ds = (isset($_POST['3ds'])) ? $_POST['3ds'] : false;

		$orderType = (isset($_POST['order-type'])) ? $_POST['order-type'] : 'none';

		

		try {

			//if ($orderType != 'APM') {
				// CREATE ORDER
		   		$response = $worldpay->createOrder(array(

		   		    'token' => isset($_POST['token']) ? $_POST['token'] : '',

		   		    'amount' => round((float)$total_money * 100),

		   		    'currencyCode' => 'GBP' /*isset($_POST['currency']) ? $_POST['currency'] : ''*/,

		   		    'orderType' => isset($_POST['order-type']) ? $_POST['order-type'] : 'ECOM', //Order Type: ECOM/MOTO/RECURRING

		   		    'is3DSOrder' => $_3ds, // 3DS

		   		    'name' => isset($_POST['cartname']) ? $_POST['cartname'] : '',

		   		    'paymentMethod' => $paymentMethod ,

		   		    'billingAddress' => $billing_address,

		   		    'orderDescription' => isset($_POST['description']) ? $_POST['description'] : '',

		   		    'customerOrderCode' => isset($_POST['customer-order-code']) ? $_POST['customer-order-code'] : '',



		   		));

		   		

		   		if ($response['paymentStatus'] === 'SUCCESS') {

		   		    $worldpayOrderCode = $response['orderCode'];

		   		    // insert database

		   		    $mysqli = connection();

		   		    foreach ($_SESSION['data'] as $key => $value) {

		   		    	$query = "INSERT INTO `orders`(`fullname`, `address`, `package`, `from`, `to`, `type`, `twoman`, `dtime`, `instruction`, `invoice_company_name`, `booking_contact_name`, `invoice_company_account_no`, `booking_contact_mobile_number`, `email_address_for_invoice_1`, `email_address_for_invoice_2`, `full_collection_company_name`, `full_address_for_collection`, `collection_postcode`, `collection_contact_name`, `collection_contact_phone_number`, `collection_contact_email_address`, `collection_time`, `image_required`, `full_delivery_company_name`, `full_address_for_delivery`, `delivery_postcode`, `delivery_contact_name`, `delivery_contact_phone_number`, `delivery_contact_mobile_number`, `delivery_contact_email_address`, `delivery_company_close_time`,`money`,`distant`, `full_description_of_goods`, `length`, `width`, `height`, `depth`, `weight`,`transaction`) VALUES ('".$_POST['cartname']."', '".$_POST['address1']."', '".$value['package']."', '".$value['from']."', '".$value['to']."', '".$value['type']."', '".$value['twoman']."', '".date("y-m-d", strtotime($value['date']))."', '".$value['instruction']."', '".$value['invoice_company_name']."', '".$value['booking_contact_name']."', '".$value['invoice_company_account_no']."', '".$value['booking_contact_mobile_number']."', '".$value['email_address_for_invoice_1']."', '".$value['email_address_for_invoice_2']."', '".$value['full_collection_company_name']."', '".$value['full_address_for_collection']."', '".$value['collection_postcode']."', '".$value['collection_contact_name']."', '".$value['collection_contact_phone_number']."', '".$value['collection_contact_email_address']."', '".$value['collection_time']."', '".$value['image_required']."', '".$value['full_delivery_company_name']."', '".$value['full_address_for_delivery']."', '".$value['delivery_postcode']."', '".$value['delivery_contact_name']."', '".$value['delivery_contact_phone_number']."', '".$value['delivery_contact_mobile_number']."', '".$value['delivery_contact_email_address']."', '".$value['delivery_company_close_time']." ', '".calculate($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman'])."','".round(get_distance($value['type'],$value['to'],$value['from']),0)."', '".$value['full_description_of_goods']."', '".$value['length']."', '".$value['width']."', '".$value['height']."', '".$value['depth']."', '".$value['weight']."', '".$value['transaction']."' ) ;";

		   		    	

		   		    	mysqli_query($mysqli,$query);

		   		    }		   		    

		   		   
		   		    /*$cookie_name = "cart_data";
					// empty value and expiration one hour before
					 setcookie($cookie_name, "", time() - 3600,"/");*/

					 // send mail to user booking
					foreach ($_SESSION['data'] as $key => $value) {
						 $content = '
								    <div style="max-width:650;width:100%;display:inline-flex">
								        <div style="margin:5px;width:50%;float:left;">
								            <label for=""><b>Name:</b><span style="float:right;">'.urldecode($_POST['cartname']).' </span></label><br />
								            <label for=""><b>From:</b><span style="float:right;">'.urldecode($value['from']).'</span></label><br />
								            <label for=""><b>Package Description:</b><span style="float:right;">'.urldecode($value['package']).'</span></label><br />
								            <label for=""><b>Distance:</b><span style="float:right;">'.urldecode(round(get_distance($value['type'],$value['to'],$value['from']),0)).'</span></label><br />
								        </div>
								        <div style="margin:5px;width:50%;float:right;">
								            <label for=""><b>Billing Address:</b><span style="float:right;">'.urldecode($_POST['address1']).'</span></label><br />
								            <label for=""><b>To:</b><span style="float:right;">'.urldecode($value['to']).'</span></label><br />
								            <label for=""><b>Date:</b><span style="float:right;">'.date("d/m/Y", strtotime(urldecode($value['date']))).'</span></label><br />
								            <label for=""><b>Cost:</b><span style="float:right;">'.urldecode(calculate($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman'])).' GBP</span></label><br />
								        </div>
								    </div>
								    
								    ';
								    
						$message = '<html>
						            <head>
						            <meta charset="utf-8">
						            <title>Admin Confirmation Of Booking</title>
						            </head>
						            <body>
						            <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
						            <tr>
						                <td><table width="650" border="0" cellspacing="0" cellpadding="0">
						                <tr>
						                    <td align="center"><img src="http://firminxpress.com/email/admin1.jpg" width="650" height="221"  alt="head"/></td>
						                </tr>
						                <tr>
						                    <td>&nbsp;</td>
						                </tr>
						                <tr>
						                    <td><table width="610" border="0" align="center" cellpadding="0" cellspacing="0">
						                    <tr>
						                        <td style="font-family: Arial, "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, sans-serif"> 
						                            '.$content.'                          
						                        </td>
						                    </tr>
						                    </table></td>
						                </tr>
						                <tr>
						                    <td>&nbsp;</td>
						                </tr>
						                <tr>
						                    <td align="center"><img src="http://firminxpress.com/email/admin2.jpg" width="650" height="164"  alt="foot"/></td>
						                </tr>
						                </table></td>
						            </tr>
						            </table>
						            </body>
						            </html>';
						$message_customer = '<html>
						            <head>
						            <meta charset="utf-8">
						            <title>Admin Confirmation Of Booking</title>
						            </head>
						            <body>
						            <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
									  <tr>
									    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
									      <tr>
									        <td align="center"><img src="http://firminxpress.com/email/cust1.jpg" width="650" height="193"  alt=""/></td>
									      </tr>
									      <tr>
									        <td align="center"><img src="http://firminxpress.com/email/cust2.jpg" width="650" height="213"  alt=""/></td>
									      </tr>
									      <tr>
									        <td>&nbsp;</td>
									      </tr>
									      <tr>
									        <td><table width="610" border="0" align="center" cellpadding="0" cellspacing="0">
									          <tr>
									            <td style="font-family: Arial, "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, sans-serif">'.$content.'
									          </tr>
									        </table></td>
									      </tr>
									      <tr>
									        <td>&nbsp;</td>
									      </tr>
									      <tr>
									        <td align="center"><img src="http://firminxpress.com/email/cust3.jpg" width="650" height="164"  alt=""/></td>
									      </tr>
									    </table></td>
									  </tr>
									</table>
						            </body>
						            </html>';
						$to = urldecode($value['email_address_for_invoice_2']);
						$subject = "Admin Confirmation Of Booking";
						
						$headers = "From: xpress@firminxpress.info" . "\r\n"; 

						$headers .= "Content-Type: text/html;charset=iso-8859-1\r\n";
						$headers  .= 'MIME-Version: 1.0' . "\r\n";
						mail($to,$subject,$message_customer,$headers);
						mail('simon@kilocreative.com',$subject,$message,$headers);
					}

					unset($_SESSION['data']);
		   		    session_destroy();
		   		    echo "<script> window.location = '".substr($_SERVER[REQUEST_URI], 0, strrpos($_SERVER[REQUEST_URI], "/"))."/complete-checkout';</script>";



		   		} else {

		   		    throw new WorldpayException(print_r($response, true));

		   		}

		   	//}

		   	/*else{

		   		$apmFields = array();

	            if (isset($_POST['swiftCode'])) {

	                $apmFields['swiftCode'] = $_POST['swiftCode'];

	            }



	            if (isset($_POST['shopperBankCode'])) {

	                $apmFields['shopperBankCode'] = $_POST['shopperBankCode'];

	            }



	            if (empty($apmFields)) {

	                $apmFields =  new \stdClass();

	            }

	            $paymentMethod = array(

	                  "apmName" => isset($_POST['apm-name']) ? $_POST['apm-name'] : '',

	                  "shopperCountryCode" => isset($_POST['countryCode']) ? $_POST['countryCode'] : '',

	                  "apmFields" => $apmFields

	            );

		   		$response = $worldpay->createApmOrder(array(

		   		    'token' => isset($_POST['token']) ? $_POST['token'] : '',

		   		    'amount' => round((float)$total_money),

		   		    'currencyCode' => isset($_POST['currency']) ? $_POST['currency'] : '',

		   		    'orderType' => isset($_POST['order-type']) ? $_POST['order-type'] : '', //Order Type: ECOM/MOTO/RECURRING

		   		    'is3DSOrder' => $_3ds, // 3DS

		   		    'name' => isset($_POST['cartname']) ? $_POST['cartname'] : '',

		   		    'paymentMethod' => $paymentMethod ,

		   		    'billingAddress' => $billing_address,

		   		    'orderDescription' => isset($_POST['description']) ? $_POST['description'] : '',

		   		    'customerOrderCode' => isset($_POST['customer-order-code']) ? $_POST['customer-order-code'] : '',

		   		    'successUrl' => ' http://firminxpress.info/complete-checkout/', //Success redirect url for APM

		            'pendingUrl' => ' http://firminxpress.info/complete-checkout/', //Pending redirect url for APM

		            'failureUrl' => ' http://firminxpress.info/complete-checkout/', //Failure redirect url for APM

		            'cancelUrl' => ' http://firminxpress.info/complete-checkout/' //Cancel redirect url for APM



		   		));

		   		if ($response['paymentStatus'] === 'PRE_AUTHORIZED') {

		            // Redirect to URL

		            $_SESSION['orderCode'] = $response['orderCode'];

		            $mysqli = new \mysqli("localhost", "xpress_deepbratt", "Samadder5#", "xpress_delivery");

					//$mysqli = new mysqli("localhost", "root", "", "express_delivery");

					if ($mysqli->connect_errno) {

						echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

					}

		           foreach ($_SESSION['data'] as $key => $value) {

		   		    	$query = "INSERT INTO `orders`( `fullname`, `address`, `package`, `from`, `to`, `type`, `twoman`, `dtime`, `instruction`, `invoice_company_name`, `booking_contact_name`, `invoice_company_account_no`, `booking_contact_mobile_number`, `email_address_for_invoice_1`, `email_address_for_invoice_2`, `full_collection_company_name`, `full_address_for_collection`, `collection_postcode`, `collection_contact_name`, `collection_contact_phone_number`, `collection_contact_email_address`, `collection_time`, `image_required`, `full_delivery_company_name`, `full_address_for_delivery`, `delivery_postcode`, `delivery_contact_name`, `delivery_contact_phone_number`, `delivery_contact_mobile_number`, `delivery_contact_email_address`, `delivery_company_close_time`) VALUES ('".$_POST['cartname']."', '".$_POST['address1']."', '".$value['package']."', '".$value['from']."', '".$value['to']."', '".$value['type']."', '".$value['twoman']."', '".$value['date']."', '".$value['instruction']."', '".$value['invoice_company_name']."', '".$value['booking_contact_name']."', '".$value['invoice_company_account_no']."', '".$value['booking_contact_mobile_number']."', '".$value['email_address_for_invoice_1']."', '".$value['email_address_for_invoice_2']."', '".$value['full_collection_company_name']."', '".$value['full_address_for_collection']."', '".$value['collection_postcode']."', '".$value['collection_contact_name']."', '".$value['collection_contact_phone_number']."', '".$value['collection_contact_email_address']."', '".$value['collection_time']."', '".$value['image_required']."', '".$value['full_delivery_company_name']."', '".$value['full_address_for_delivery']."', '".$value['delivery_postcode']."', '".$value['delivery_contact_name']."', '".$value['delivery_contact_phone_number']."', '".$value['delivery_contact_mobile_number']."', '".$value['delivery_contact_email_address']."', '".$value['delivery_company_close_time']." ') ;";

		   		    	$_SESSION['sql'] = $query;

		   		    	mysqli_query($mysqli,$query);

		   		    }



		            ?>

		            <script>

		                window.location.replace("<?php echo $response['redirectURL'] ?>");

		            </script>

		            <?php

		        } else {

		            // Something went wrong

		            echo '<p id="payment-status">' . $response['paymentStatus'] . '</p>';

		            throw new WorldpayException(print_r($response, true));

		        }

		   		

		   	}*/

		} catch (WorldpayException $e) {

		 // echo 'Error code: ' .$e->getCustomCode() .'

		    //HTTP status code:' . $e->getHttpStatusCode() . '

		    //Error description: ' . $e->getDescription()  . '

		    echo 'Error message: Please complete right information : ' . $e->getMessage();

		} catch (Exception $e) {

			

		    echo 'Error message: '. $e->getMessage();

		}
	}

	



 ?>

 	<style type="text/css">

 		@import url(http://demos.creative-tim.com/paper-bootstrap-wizard/assets/css/bootstrap.min.css);

 		@import url(http://demos.creative-tim.com/paper-bootstrap-wizard/assets/css/paper-bootstrap-wizard.css);

 		@import url(https://fonts.googleapis.com/css?family=Muli:400,300);

 		/*@import url(http://demos.creative-tim.com/paper-bootstrap-wizard/assets/css/themify-icons.css);*/



 	</style>

 	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>

	<script type="text/javascript" src="http://demos.creative-tim.com/paper-bootstrap-wizard/assets/js/paper-bootstrap-wizard.js"></script>

   	<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>

   	<!--   Big container   -->

	    <div class="container">

	        <div class="row">

		        <div class="col-sm-8 col-sm-offset-2">



		            <!--      Wizard container        -->

		            <div class="wizard-container">



		                <div class="card wizard-card" data-color="orange" id="wizardProfile">

		                    <form action="" method="POST" id="my-payment-form">

		               			

		                    	<div class="wizard-header text-center">

		                    		<div id="payment-errors"></div>

		                        	<h3 class="wizard-title">Check Out</h3>

									<p class="category">Complete all information to proceed checkout.</p>

		                    	</div>



								<div class="wizard-navigation">

									<div class="progress-with-circle">

									     <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;" id="progressbar"></div>

									</div>

									<ul>

			                            

			                            <li>

											<a href="#address" data-toggle="tab">

												<div class="icon-circle">

													<i class="ti-map"></i>

												</div>

												Checkout

											</a>

										</li>

			                        </ul>

								</div>

		                        <div class="tab-content">

		                            

		                            <div class="tab-pane" id="address">

		                                <div class="row">

		                                    <div class="col-sm-12">

		                                        <h5 class="info-text"> Click finish to complete the checkout </h5>

		                                    </div>		                                   

		                                    <div class="col-sm-5">

		                                        <div class="form-group">

		                                            <label>Name</label>

		                                            <input type="text" class="form-control" placeholder="Name on card" id="cartname" name="cartname" data-worldpay="name"  required>

		                                        </div>

		                                    </div>

		                                    <div class="col-sm-5 col-sm-offset-1">

		                                        <div class="form-group">

		                                            <label>Card Number</label>

		                                            <input type="text" class="form-control" placeholder="Card Number" id="card" size="20" data-worldpay="number" name="cardnumber"  required>

		                                        </div>

		                                    </div>

		                                    <div class="col-sm-5"> 

		                                    	<div class="form-row no-apm ">

									                <label>

									                    Expiry Date (MM/YYYY)

									                </label>

									                <div class="form-group">

									                	<select id="expiration-month" data-worldpay="exp-month" name="expiration-month">

									                	    <option value="01">01</option>

									                	    <option value="02" >02</option>

									                	    <option value="03">03</option>

									                	    <option value="04">04</option>

									                	    <option value="05">05</option>

									                	    <option value="06">06</option>

									                	    <option value="07">07</option>

									                	    <option value="08">08</option>

									                	    <option value="09">09</option>

									                	    <option value="10" selected="selected">10	</option>

									                	    <option value="11">11</option>

									                	    <option value="12" selected>12</option>

									                	</select>

									                	<span> / </span>

									                	<select id="expiration-year" data-worldpay="exp-year" name="expiration-year" >

									                	    <option value="2017" selected="selected">2017</option>

									                	   

									                	    <option value="2018">2018</option>

									                	    <option value="2019">2019</option>

									                	    <option value="2020">2020</option>

									                	    <option value="2021">2021</option>

									                	    <option value="2022">2022</option>

									                	    <option value="2023">2023</option>

									                	    

									                	</select>

									                </div>

									            </div>

		                                    </div>

		                                    <div class="col-sm-5 col-sm-offset-1">

		                                        <div class="form-group">

		                                            <label>Address </label>

									                <input type="text" name="address1" placeholder="Address" required>

		                                        </div>

		                                    </div>

		                                    

		                                    <div class="col-sm-5 form-row apm" style="display:none;">

		                                    	<div class="form-group">

									                <label>APM</label>

									                <select id="apm-name" data-worldpay="apm-name" class="form-control" name="apm-name">

									                    <option value="paypal" selected="selected">PayPal</option><option value="giropay">Giropay</option><option value="ideal">iDEAL</option>

									                </select>

									            </div>

		                                    </div>

		                                    <div class="col-sm-5">

		                                    	<div class="form-group">

		                                    		<div class="form-row no-apm">

									            	    <label>

									            	        CVC

									            	    </label>

									            	    <input type="text" id="cvc" size="4" 	data-worldpay="cvc" name="cvc"  class="form-control" required />

									            </div>

									            </div>

		                                    </div>

		                                     <div class="col-sm-5 col-sm-offset-1">

		                                        <div class="form-group">

		                                            <label>Amount</label>

		                                            <input type="text" class="form-control"  id="amount"  name="amount" value="<?=$total_money?>" disabled="">

		                                        </div>

		                                    </div>

		                                     <div class="col-sm-5 ">

		                                        <div class="form-group">

		                                            <label>Currency</label>

		                                            <input type="text" name="" value="GBP">		                                            

		                                        </div>

		                                    </div>

		                                     <div class="col-sm-5 col-sm-offset-1">

		                                        <div class="form-group">

		                                            <label>Description</label>

		                                            <input type="text" class="form-control" placeholder="Description" name="description" id="description"  required>

		                                        </div>

		                                    </div>

		                                    <div class="form-row no-apm col-sm-5  ">

								                <label>Use 3DS</label>

								                <input type="checkbox" id="chk3Ds" name="3ds" />

								            </div>

		                                    <div class="col-sm-5 form-row swift-code-row apm" style="display:none">

		                                    	<div class="form-group">

								                	<label>

								                	    Swift Code

								                	</label>

								                	<input type="text" class="form-control" id="swift-code" />

								                </div>

								            </div>								            

								            <div class="col-sm-5 form-row shopper-bank-code-row apm" style="display:none">

								            	<div class="form-group">

									            	<label>

									            	    Shopper Bank Code

									            	</label>

									            	<input type="text" id="shopper-bank-code"  />

									            </div>

								            </div>

		                                </div>

		                            </div>

		                        </div>

		                        <div class="wizard-footer">

		                            <div class="pull-right">

		                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />

		                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Finish' id="finish" />

		                            </div>



		                            <div class="pull-left">

		                                <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />

		                            </div>

		                            <div class="clearfix"></div>

		                        </div>

		                        

		                    </form>

		                </div>

		            </div> <!-- wizard container -->

		        </div>

	    	</div><!-- end row -->

		</div> <!--  big container -->

  	<script type="text/javascript">

  		$("#progressbar").css('width','100%!important');

  	</script>

    <script type="text/javascript">

    	var showShopperBankCodeField = function() {

            $('#shopper-bank-code').attr('data-worldpay-apm', 'shopperBankCode');

            $('#shopper-bank-code').attr('name','shopperBankCode');

            $('.shopper-bank-code-row').show();

        };

        var hideShopperBankCodeField = function() {

            $('#shopper-bank-code').removeAttr('data-worldpay-apm');

            $('#shopper-bank-code').removeAttr('name');

            $('.shopper-bank-code-row').hide();

        };



        var showSwiftCodeField = function() {

            $('#swift-code').attr('data-worldpay-apm', 'swiftCode');

            $('#swift-code').attr('name','swiftCode');

            $('.swift-code-row').show();

        }



        var hideSwiftCodeField = function() {

            $('#swift-code').removeAttr('data-worldpay-apm');

             $('#swift-code').removeAttr('name');

            $('.swift-code-row').hide();

        }



        var showLanguageCodeField = function() {

            $('#language-code').attr('data-worldpay', 'language-code');

            $('.language-code-row').show();

        }



        var hideLanguageCodeField = function() {

            $('#language-code').removeAttr('data-worldpay');

            $('.language-code-row').hide();

        }



        var showReusableTokenField = function() {

            $('.reusable-token-row').show();

        }



        var hideReusableTokenField = function() {

            $('.reusable-token-row').hide();

        }

        $('#order-type').on('change', function () {

                if ($(this).val() == 'APM') {

                    Worldpay.tokenType = 'apm';

                    $('.apm').show();

                    $('.no-apm').hide();



                    //initialize fields

                    hideShopperBankCodeField();

                    hideSwiftCodeField();

                   



                    //handle attributes

                    $('#card').removeAttr('data-worldpay');

                    $('#cvc').removeAttr('data-worldpay');

                    $('#expiration-month').removeAttr('data-worldpay');

                    $('#expiration-year').removeAttr('data-worldpay');

                    $('#country-code').attr('data-worldpay', 'country-code');

                } else {

                    Worldpay.tokenType = 'card';

                    $('.apm').hide();

                    $('.no-apm').show();

                    $('#card').attr('data-worldpay', 'number');

                    $('#cvc').attr('data-worldpay', 'cvc');

                    $('#expiration-month').attr('data-worldpay', 'exp-month');

                    $('#expiration-year').attr('data-worldpay', 'exp-year');

                    $('#country-code').removeAttr('data-worldpay');

                }

            });



            $('#apm-name').on('change', function () {

                var _apmName = $(this).val();



                hideSwiftCodeField();

                hideShopperBankCodeField(); 

                $('#country-code').val('GB');

                $('#currency').val('GBP');



                switch (_apmName) {

                    case 'mistercash':

                        

                        $('#country-code').val('BE');

                    break;

                    case 'yandex':

                    case 'qiwi':

                        

                        $('#country-code').val('RU');

                    break;

                    case 'postepay':

                        

                        $('#country-code').val('IT');

                    break;

                    case 'alipay':

                        

                        $('#country-code').val('CN');

                    break;

                    case 'przelewy24':

                        

                        $('#country-code').val('PL');

                    break;

                    case 'sofort':

                        

                        $('#country-code').val('DE');

                    break;

                    case 'giropay':

                        Worldpay.reusable = false;

                        showSwiftCodeField();

                        $('#currency').val('EUR');

                    break;

                    case 'ideal':

                        //reusable token field is available for all apms (except giropay)

                         //shopper bank code field is only available for ideal

                        showShopperBankCodeField();

                    break;

                    default:

                        

                    break;

                }              

            });






       if ($("#finish")).click(function(){
      var form = document.getElementById('my-payment-form');



      Worldpay.useOwnForm({

        'clientKey': 'T_C_beab127d-8991-4a1f-8cff-7f7daea645d2',

        'form': form,

        'reusable': false,

        'callback': function(status, response) {

          document.getElementById('payment-errors').innerHTML = '';

          if (response.error) {             

            //Worldpay.handleError(form, document.getElementById('payment-errors'), response.error); 

          } else {

            var token = response.token;

            Worldpay.formBuilder(form, 'input', 'hidden', 'token', token);

            form.submit();

          }

        }

      });
  });

    </script>

<style type="text/css">

	.wizard-container{

		 padding-top: 10px!important;

	}

	#thong-left{

		width: 100%!important;

	}

	.newTicker{

		display: none;

	}

	#quote-title{

		display: none;

	}

	.page-title-left{

		display: none;

	}

	#small-nav{

		width: 88%!important;

		

	}

	#small-nav li  a{

		font-family: "Economica", Arial, Helvetica, sans-serif!important;

	}

</style>