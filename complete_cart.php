<?php


function connection(){
		$mysqli = new \mysqli("localhost", "xpress_deepbratt", "Samadder5#", "xpress_delivery");

			//$mysqli = new mysqli("localhost", "root", "", "express_delivery");

			if ($mysqli->connect_errno) {

				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				return faLse;
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
if (isset($_POST['checkout'])&&isset($_POST['transaction'])){
	if ($_POST['transaction']=="CC"){
		header('Location: ' . get_home_url()."/check-out-express");
	}
	else {
		$mysqli = connection();
		

		foreach ($_SESSION['data'] as $key => $value) {

		 	$query = "INSERT INTO `orders`( `package`, `from`, `to`, `type`, `twoman`, `dtime`, `instruction`, `invoice_company_name`, `booking_contact_name`, `invoice_company_account_no`, `booking_contact_mobile_number`, `email_address_for_invoice_1`, `email_address_for_invoice_2`, `full_collection_company_name`, `full_address_for_collection`, `collection_postcode`, `collection_contact_name`, `collection_contact_phone_number`, `collection_contact_email_address`, `collection_time`, `image_required`, `full_delivery_company_name`, `full_address_for_delivery`, `delivery_postcode`, `delivery_contact_name`, `delivery_contact_phone_number`, `delivery_contact_mobile_number`, `delivery_contact_email_address`, `delivery_company_close_time`,`money`,`distant`, `full_description_of_goods`, `length`, `width`, `height`, `depth`, `weight`,`transaction`) VALUES ( '".$value['package']."', '".$value['from']."', '".$value['to']."', '".$value['type']."', '".$value['twoman']."', '".date("y-m-d", strtotime($value['date']))."', '".$value['instruction']."', '".$value['invoice_company_name']."', '".$value['booking_contact_name']."', '".$value['invoice_company_account_no']."', '".$value['booking_contact_mobile_number']."', '".$value['email_address_for_invoice_1']."', '".$value['email_address_for_invoice_2']."', '".$value['full_collection_company_name']."', '".$value['full_address_for_collection']."', '".$value['collection_postcode']."', '".$value['collection_contact_name']."', '".$value['collection_contact_phone_number']."', '".$value['collection_contact_email_address']."', '".$value['collection_time']."', '".$value['image_required']."', '".$value['full_delivery_company_name']."', '".$value['full_address_for_delivery']."', '".$value['delivery_postcode']."', '".$value['delivery_contact_name']."', '".$value['delivery_contact_phone_number']."', '".$value['delivery_contact_mobile_number']."', '".$value['delivery_contact_email_address']."', '".$value['delivery_company_close_time']." ', '".calculate($value['type'],$value['to'],$value['from'],$value['date'],$value['hour'],$value['twoman'])."','".round(get_distance($value['type'],$value['to'],$value['from']),0)."', '".$value['full_description_of_goods']."', '".$value['length']."', '".$value['width']."', '".$value['height']."', '".$value['depth']."', '".$value['weight']."', '".$value['transaction']."' ) ;";

		   		    	
		 	
		   	mysqli_query($mysqli,$query);

		   	$content = '
								    <div style="max-width:650;width:100%;display:inline-flex">
								        <div style="margin:5px;width:50%;float:left;">
								            <label for=""><b>Name:</b><span style="float:right;">'.urldecode($value['booking_contact_name']).' </span></label><br />
								            <label for=""><b>From:</b><span style="float:right;">'.urldecode($value['from']).'</span></label><br />
								            <label for=""><b>Package Description:</b><span style="float:right;">'.urldecode($value['package']).'</span></label><br />
								            <label for=""><b>Distance:</b><span style="float:right;">'.urldecode(round(get_distance($value['type'],$value['to'],$value['from']),0)).'</span></label><br />
								        </div>
								        <div style="margin:5px;width:50%;float:right;">
								            <label for=""><b>Billing Address:</b><span style="float:right;">'.urldecode($value['full_address_for_collection']).'</span></label><br />
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
						$subject2 = "Customer Confirmation Of Booking";
						$headers = "From: xpress@firminxpress.info" . "\r\n";

						$headers .= "Content-Type: text/html;charset=iso-8859-1\r\n";
						$headers  .= 'MIME-Version: 1.0' . "\r\n";
						mail($to,$subject2,$message_customer,$headers);
						mail('simon@kilocreative.com',$subject,$message,$headers);
					


		}
		unset($_SESSION['data']);
		session_destroy();
	}
}

get_header();
?>



<div class="container">

	<h1>Your payment has been processed.</h1>
	<h3><strong><a href="/index.php">Please click here to continue</a></strong></h3>

	

	<div class="form-group">

	  <label></label>

	</div>

</div>

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

