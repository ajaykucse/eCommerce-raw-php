<?php  
require_once 'core/init.php';


// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = isset($_POST['stripeToken'])? $_POST['stripeToken']:'';﻿
// Get the rest of the post data
$full_name = isset($_POST['full_name'])? sanitize($_POST['full_name']):'';
$email = isset($_POST['email'])? sanitize($_POST['email']):'';
$street = isset($_POST['street'])? sanitize($_POST['street']):'';
$street2 = isset($_POST['street2'])? sanitize($_POST['street2']):'';
$city = isset($_POST['city'])? sanitize($_POST['city']):'';
$state = isset($_POST['state'])? sanitize($_POST['state']):'';
$zip_code = isset($_POST['zip_code'])? sanitize($_POST['zip_code']):'';
$country = isset($_POST['country'])? sanitize($_POST['country']):'';
$tax = isset($_POST['tax'])? sanitize($_POST['tax']):'';
$sub_total = isset($_POST['sub_total'])? sanitize($_POST['sub_total']):'';
$grand_total = isset($_POST['grand_total'])? sanitize($_POST['grand_total']):'';
$cart_id = isset($_POST['cart_id'])? sanitize($_POST['cart_id']):'';
$description = isset($_POST['description'])? sanitize($_POST['description']):'';
$charge_amount = number_format((int)$grand_total, 2) * 100;
$metadata = array(
    "cart_id"   => $cart_id,
    "tax"       => $tax,
    "sub_total" => $sub_total,
);

// Create the Charge on Stripe's servers  this will charge the user's card:
try {
$charge = \Stripe\Charge::create(array(
  "amount" 			=> $charge_amount, // amount in cents, again 
  "currency" 		=> CURRENCY,
  "source" 			=> $token,
  "description" 	=> $description,
  "receipt_email"	=> $email,
  "metadata"		=>$metadata)
);

$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code, country, sub_total, tax, grand_total, description, txn_type) 
VALUES ('$charge->id', '$cart_id', '$full_name', '$email', '$street', '$street2', '$city', '$state', '$zip_code', '$country', '$sub_total', '$tax', '$grand_total', '$description', '$charge->object')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? '.'.$_SERVER['HTTP_HOST'] : false;
setcookie(CART_COOKIE, '', 1, "/", $domain, false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
	<h1 class="text-center text-success">Thank You!</h1>
	<p> Your card has been successfully charged <?=money($grand_total);?>. You have been emailed a receipt. Pleasse check your spam folder if it is not in your inbox. Additionally you can print this page as a receipt.</p>
	<P>Your receipt number is: <strong><?=$cart_id;?></strong> </P>
	<p>Your order will be shipped to the address bellow.</p>
	<address>
		<?=$full_name;?><br>
		<?=$street;?><br>
		<?=(($street2 !='')?$street2.'<br>':'');?>
		<?=$city. ', '.$state.' '.$zip_code;?><br>
		<?=$country;?><br>
	</address>
<?php

} catch(\Stripe\Error\Card $e){
	// The card has been declined
	echo $e;
}
?>