<?php  
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/E-commerce/');
define('CART_COOKIE','JC76986fsKJBvj');
define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
define('TAXRATE',0.087); // Salse Tax rate Set to 0 if you arn't charging tax.

define('CURRENCY','usd');
define('CHECKOUTMODE','TEST'); // Change TEST to LIVE when you are ready to go LIVE

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE', 'sk_test_XLYT4R5FMesWhlylduLIayPA');
	define('STRIPE_PUBLIC', 'pk_test_c1BC05VP2Lk5MXp72cCv4qJ2');
}

if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE', 'sk_test_XLYT4R5FMesWhlylduLIayPA');
	define('STRIPE_PUBLIC', 'pk_test_c1BC05VP2Lk5MXp72cCv4qJ2');
}