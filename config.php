<?php

include('connection.php');
require_once 'vendor/autoload.php';


define('PAYPAL_SANDBOX', TRUE);

define('PAYPAL_SANDBOX_CLIENT_ID', 'ARsvm_38-yeIedzC88hRFVV9Jwt1QDaAUx59s1IPinhjuJtaRSkshQ_b9gEQ2Weqi_nCThTpC8reg2d0');

define('PAYPAL_SANDBOX_CLIENT_SECRET', 'EHaV8ihP5kKf_ak0ySDoXZvjv0sKhQ5CIYuJIORWHQoCU37LYdMFxmk78bWwbfEQTkivFudw0x5ETfgm');

define('PAYPAL_PROD_CLIENT_ID', 'Insert_Live_Paypal_Client_ID_Here');

define('PAYPAL_PROD_CLIENT_SECRET', 'Insert_Live_Paypal_Secret_Key_Here');



$clientID = '1046328293002-2mjrlp8mlurfon53vl542uh3d9j1qjff.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/finals/customer/packages';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

?>