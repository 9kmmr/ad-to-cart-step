<?php 

	

	

	$count=0;
	$cookie_name = "cart_data";
	$transaction = "CC";
	if(isset($_POST['payment'])){
  
	  	$response = $_POST["g-recaptcha-response"];

	  	$url = 'https://www.google.com/recaptcha/api/siteverify';
	  	$data = array(
	    	'secret' => '6LegeyUUAAAAAD96XEnoVw44JBcJdaD9rR_ORZeD',
	    	'response' => $_POST["g-recaptcha-response"]
	  	);
	  	$options = array(
	    	'http' => array (
	      		'method' => 'POST',
	      		'content' => http_build_query($data)
	    	)
	  	);
	  	$context  = stream_context_create($options);
	  	$verify = file_get_contents($url, false, $context);
	  	$captcha_success=json_decode($verify);

	  	if ($captcha_success->success==false) {

	  		header('Location: ' . $_SERVER['HTTP_REFERER'] . '&captcha=false');

	  	} else if ($captcha_success->success==true) {
	    	
			if (isset($_POST['dfrom'])){

				$transaction = $_POST['transaction'];

	            $name = urlencode($_POST['package']);

	            $from = urlencode($_POST['dfrom']);

	            $to =   urlencode(trim($_POST['dto']));

	            $type = $_POST['vehicle'];

	            $twoman = ($_POST['twoman']=='yes' ) ? 'yes' : 'no';

	            $date = trim($_POST['date']);

	            $hour = $_POST['time_pick'];

	            $minute = $_POST['time_mins'];

	            $instruction = urlencode($_POST['instruction']);

	            $invoice_company_name               = urlencode($_POST['invoice_company_name']);

	            $booking_contact_name               = urlencode($_POST['booking_contact_name']);

	            $invoice_company_account_no         = urlencode($_POST['invoice_company_account_no']);

	            $booking_contact_mobile_number      = urlencode($_POST['booking_contact_mobile_number']);

	            $email_address_for_invoice_1        = urlencode($_POST['email_address_for_invoice_1']);

	            $email_address_for_invoice_2        = urlencode($_POST['email_address_for_invoice_2']);

	            $full_collection_company_name       = urlencode($_POST['full_collection_company_name']);

	            $full_address_for_collection        = urlencode($_POST['full_address_for_collection']);

	            $collection_postcode                = urlencode($_POST['collection_postcode']);

	            $collection_contact_name            = urlencode($_POST['collection_contact_name']);

	            $collection_contact_phone_number    = urlencode($_POST['collection_contact_phone_number']);

	            $collection_contact_email_address   = urlencode($_POST['collection_contact_email_address']);

	            $collection_time                    = urlencode($_POST['collection_time']);

	            $image_required                     = urlencode($_POST['image_required']);

	            $full_delivery_company_name         = urlencode($_POST['full_delivery_company_name']);

	            $full_address_for_delivery          = urlencode($_POST['full_address_for_delivery']);

	            $delivery_postcode                  = urlencode($_POST['delivery_postcode']);

	            $delivery_contact_name              = urlencode($_POST['delivery_contact_name']);

	            $delivery_contact_phone_number      = urlencode($_POST['delivery_contact_phone_number']);

	            $delivery_contact_mobile_number     = urlencode($_POST['delivery_contact_mobile_number']);

	            $delivery_contact_email_address     = urlencode($_POST['delivery_contact_email_address']);

	            $delivery_company_close_time        = urlencode($_POST['delivery_company_close_time']);

	        	$full_description_of_goods = urlencode($_POST['full_description_of_goods']);

	        	$length = urlencode($_POST['length']);

	        	$width = urlencode($_POST['width']);

	        	$height = urlencode($_POST['height']);

	        	$depth = urlencode($_POST['depth']);

	        	$weight = urlencode($_POST['weight']);

	            $money = 1234;


	            $_SESSION['data'][count($_SESSION['data'])] = 

	             [

	                   'id'                                => (count($_SESSION['data'])+1),

	                   'package'                           => $name,

	                   'from'                              => $from, 

	                   'to'                                => $to,

	                   'type'                              => $type,

	                   'twoman'                            => $twoman,

	                   'money'                             => $money,

					   'transaction'						=> $transaction,

	                   'date'                              => $date,

	                   'hour'                              => $hour,

	                   'minute'                            => $minute,

	                   'instruction'                       => $instruction,

	                   'invoice_company_name'              => $invoice_company_name,

	                   'booking_contact_name'              => $booking_contact_name,

	                   'invoice_company_account_no'        => $invoice_company_account_no,

	                   'booking_contact_mobile_number'     => $booking_contact_mobile_number,

	                   'email_address_for_invoice_1'       => $email_address_for_invoice_1,

	                   'email_address_for_invoice_2'       => $email_address_for_invoice_2,

	                   'full_collection_company_name'      => $full_collection_company_name,

	                   'full_address_for_collection'       => $full_address_for_collection,

	                   'collection_postcode'               => $collection_postcode,

	                   'collection_contact_name'           => $collection_contact_name,

	                   'collection_contact_phone_number'   => $collection_contact_phone_number,

	                   'collection_contact_email_address'  => $collection_contact_email_address,

	                   'collection_time'                   => $collection_time,

	                   'image_required'                    => $image_required,

	                   'full_delivery_company_name'        => $full_delivery_company_name,

	                   'full_address_for_delivery'         => $full_address_for_delivery,

	                   'delivery_postcode'                 => $delivery_postcode,

	                   'delivery_contact_name'             => $delivery_contact_name,

	                   'delivery_contact_phone_number'     => $delivery_contact_phone_number,

	                   'delivery_contact_mobile_number'    => $delivery_contact_mobile_number,

	                   'delivery_contact_email_address'    => $delivery_contact_email_address,

	                   'delivery_company_close_time'       => $delivery_company_close_time,

	                   'full_description_of_goods'			=> $full_description_of_goods,

	                   'length' 							=>	$length,

	                   'width' 								=>	$width,

	                   'height' 							=>	$height,

	                   'depth' 								=>	$depth,
	                   
	                   'weight' 							=> $weight



	             ];

	            /*$cookie_name = "cart_data";

	            $cookie_value = $_SESSION['data'];       

	            setcookie($cookie_name, base64_encode(serialize($cookie_value)), time() + (86400), "/"); // 86400 = 1 day*/

	        }
	  	}
	}

	$transaction = $_SESSION['data'][0]['transaction'];
	// delete cart

	if (isset($_GET['deleteid'])){
		
		unset($_SESSION['data'][$_GET['deleteid']]);

		/*if(isset($_COOKIE[$cookie_name])) {
			setcookie($cookie_name, "", time() - 3600,"/");
			$cookie_value = $_SESSION['data'];

        	setcookie($cookie_name, base64_encode(serialize($cookie_value)), time() + (86400), "/"); // 86400 = 1 day
			}*/
		echo "<script>window.location = '".substr($_SERVER[REQUEST_URI], 0, strrpos($_SERVER[REQUEST_URI], "/"))."/';</script>";

	}

	// add to this cart


/*
    if (count($_SESSION['data'])<=0){

        if(isset($_COOKIE[$cookie_name])) {

            $_SESSION['data'] = unserialize(base64_decode($_COOKIE[$cookie_name]));

            setcookie($cookie_name, "", time() - 3600,"/");

        }
    }*/

    $count = count( $_SESSION['data']);
    // update cart
 	if (isset($_POST['update'])){

 		

 		foreach ($_POST['key'] as $key => $value) {

 			$_SESSION['data'][$key]['package'] = urlencode($_POST['package'][$key]);

 			$_SESSION['data'][$key]['from'] = $_POST['from'][$key];

 			$_SESSION['data'][$key]['to'] = $_POST['to'][$key];

 			$_SESSION['data'][$key]['type'] = $_POST['type'][$key]  ; 			

 			$_SESSION['data'][$key]['date'] = $_POST['date'][$key];

 			$_SESSION['data'][$key]['hour'] = $_POST['hour'][$key];

 		}

 	}


 	/*
 	if(isset($_COOKIE[$cookie_name])) {		

 		if (count($_SESSION['data'])<=0){

 			$_SESSION['data'] = unserialize(base64_decode($_COOKIE[$cookie_name]));

 			setcookie($cookie_name, "", time() - 3600,"/");

 		}

    }

    else{

    	if (count($_SESSION['data'])>0){

    		$cookie_value = $_SESSION['data'];

        	setcookie($cookie_name, base64_encode(serialize($cookie_value)), time() + (86400), "/"); // 86400 = 1 day

    	}

    }
	*/
    function checktype($val){

    	switch ($val) {

    		case 1:

    			return 'Small Van';

    			break;

    		case 2:

    			return 'Xtra LWB Van';

    			break;

    		case 3:

    			return 'Luton';

    			break;

    		default:

    			return 'Small Van';

    			break;

    	}

    }
    function connection(){
    		$mysqli = new \mysqli("localhost", "xpress_deepbratt", "Samadder5#", "xpress_delivery");

			//$mysqli = new mysqli("localhost", "root", "", "express_delivery");

			if ($mysqli->connect_errno) {

				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				return false;
			}
			else return $mysqli ;
    }
    

    // calculate distance
	function get_distance($vehicle,$addTo,$addFrom){
		
			$mysqli  = connection();
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
			return $mile;

	}

	// calculate money cost
	function calculate($vehicle,$addTo,$addFrom,$date,$time_pick,$twoman){

			$mysqli =  connection();

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

	function calculate_real($vehicle,$addTo,$addFrom,$date,$time_pick,$twoman){

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
					
				
				
				
			}else{

				$data = "erz";

			}		

			return $withouttax;

	}

    get_header();

 ?>

 <style type="text/css">



  	@import url(https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css);

	@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css);

 </style>

<div class="table-responsive">

	<h2>YOUR CART</h2>

	<form action="" method="POST">

	<table class="table table-bordered">

		<thead>

			<th></th>

			<th>Name</th>

			<th>From</th>

			<th>To</th>

			<th>Vehicle Type</th>



			<th>Cost (£)</th>

			<th>Tax (VAT)</th>

			<th>Date</th>

			



		</thead>

		<tbody id="data-cart">

			<?php 

			if (count($_SESSION['data'] )>0) {

				

			$show = "Small Van";

			foreach ($_SESSION['data']  as $key => $value) {

				switch ($value['type']) {

					case 1:

						$show = "Small Van";

						break;

					case 2:

						$show = "Xtra LWB Van";

						break;

					case 3:

						$show = "Luton";

						break;

					default:

						$show = "Small Van";

						break;

				}

			?>

			

			<tr>				

				<input type="hidden" name="key[]" value="<?=$key?>">

				<td class="removeii"><a href="<?=get_permalink()."?deleteid=".$key?>">Remove</a></td>

				<td><?=urldecode($value['package'])?></td>

				<td><?=urldecode($value['from'])?></td>

				<td><?=urldecode($value['to'])?> </td>

				<td><?=$show ?></td>				

				<td><?php echo calculate_real($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman']) ; ?></td>
				<td><?php echo round(calculate_real($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman'])*0.2,2) ; ?></td>
				<td><?=date("Y-m-d", strtotime($value['date'])) ?></td>						

			</tr>		



			<?php 

			} }?>

		</tbody>

	

	</table>

	<!-- <input type="submit" name="update" value="Update Cart" id="update_cart" class="btn btn-info btn-sm pull-right"> -->

	

	</form>

	<form action="<?php if ($transaction=="CC") echo get_home_url()."/check-out-express" ; else echo get_home_url()."/complete-checkout";  ?>" method="POST">

		<table>
		<input type="hidden" name="transaction" value="<?=($transaction=="CC")?'CC':'ACCOUNT' ?>">
		<input type="submit" name="checkout" value="<?=($transaction=="CC")?'Proceed to Checkout':'Complete Your Orders' ?>" class="btn btn-success pull-left">	

		</table>	

	</form>
</div>
<script type="text/javascript">

	$(".checkbox").change(function() {

		 if(this.checked) {

        	$(this).parent().find('input[type=hidden]').val(1);

    	}

    	else $(this).parent().find('input[type=hidden]').val(0);

    });

</script>



<style type="text/css">

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

</style>

