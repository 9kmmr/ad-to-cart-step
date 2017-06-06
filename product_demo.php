<?php 

    
    $cookie_name = "cart_data";
        if (isset($_POST['dfrom'])){
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
                   'delivery_company_close_time'       => $delivery_company_close_time

             ];
            $cookie_name = "cart_data";
            $cookie_value = $_SESSION['data'];       
            setcookie($cookie_name, base64_encode(serialize($cookie_value)), time() + (86400), "/"); // 86400 = 1 day
        }
    get_header();
 ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Lato:300,400,700);
@import url(https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css);
@import url(https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css);

@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css);
* {
    margin: 0;
    padding: 0;
}
body {
    background-color: #F2EEE9;
    font: normal 13px/1.5 Georgia, Serif;
    color: #333;
}
.wrapper {
    width: 705px;
    margin: 0 auto;
    padding: 20px;
    margin-top: 100px!important;
}
h1 {
    display: inline-block;
    background-color: #333;
    color: #fff;
    font-size: 20px;
    font-weight: normal;
    text-transform: uppercase;
    padding: 4px 20px;
    float: left;
}
.clear {
    clear: both;
}
.items {
    display: block;
    margin: 20px 0;
}
.item {
    background-color: #fff;
    float: left;
    margin: 0 10px 10px 0;
    width: 205px;
    padding: 10px;
    height: 325px;
}
.item img {
    display: block;
    margin: auto;
}
h2 {
    font-size: 16px;
    display: block;
    border-bottom: 1px solid #ccc;
    margin: 0 0 10px 0;
    padding: 0 0 5px 0;
}
button {
    border: 1px solid #722A1B;
    padding: 4px 14px;
    background-color: #fff;
    color: #722A1B;
    text-transform: uppercase;
    float: right;
    margin: 5px 0;
    font-weight: bold;
    cursor: pointer;
}
.thiscart {
    float: right;
}
.shopping-cart1 {
    display: inline-block;
    background: url('http://cdn1.iconfinder.com/data/icons/jigsoar-icons/24/_cart.png') no-repeat 0 0;
    width: 24px;
    height: 24px;
    margin: 0 10px 0 0;
}
.containter {
    position: relative;
}
.shopping-cart {
    display: none;
    margin: 20px 0;
    float: right;
    background: white;
    width: 320px;
    position: absolute;
    border-radius: 3px;
    padding: 20px;
}
.shopping-cart-header {
    border-bottom: 1px solid #E8E8E8;
    padding-bottom: 15px;
}
.shopping-cart-total {
    float: right;
}
}
.shopping-cart-items {
    padding-top: 20px;
}
li {
    margin-bottom: 18px;
    list-style: none;
}
img {
    float: left;
    margin-right: 12px;
}
.item-name {
    display: block;
    padding-top: 10px;
    font-size: 16px;
}
.item-price {
    margin-right: 8px;
}
.shopping-cart:after {
    bottom: 100%;
    left: 89%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: white;
    border-width: 8px;
    margin-left: -8px;
}
.clearfix:after {
    content: "";
    display: table;
    clear: both;
}
</style>
<!-- wrapper -->
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<div class="wrapper">
    <h1>Bike Stock</h1>
    <div>
       <a href="<?=get_home_url()."/view-cart"?>"><span class="thiscart "><i class="shopping-cart1" id="cart"></i><span class="badge"><?=$count?></span></span></a>    
    </div>
   
    <div class="clear"></div>
    <!-- items -->
    <div class="items">
        <!-- single item -->
        <div class="item">
            <img src="http://img.tjskl.org.cn/pic/z2577d9d-200x200-1/pinarello_lungavita_2010_single_speed_bike.jpg" alt="item" />
             <h2>Item 1</h2>

            <p>Price: <em>$449</em>
            </p>
            <p>Quantity :<input type="number" value="1" style="width: 30px;"></p>
            <button class="add-to-cart" type="button">Add to cart</button>
        </div>
        <!--/ single item -->
        
    </div>
    <!--/ items -->
</div>
<!--/ wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
