<?php
$config["DB_NAME"] = getenv('DB_NAME') ?:"leather_store";
$config["DB_USER"] = getenv('DB_USER') ?:"root";
$config["DB_PASSWORD"] = getenv('DB_PASSWORD') ?:"";
$config["DB_HOST"] = getenv('DB_HOST') ?:"localhost";
$config["DB_PORT"] = getenv('DB_PORT') ?:5432;

$config["VENDOR_DIR"] = getenv('VENDOR_DIR') ?:"../vendor";

$config["URL"] = getenv('URL') ?:'http://localhost/';

$config["DEBUG"] = getenv('DEBUG')=="true"? true:false;

$config["USER_EMAIL_VERF"] = getenv('USER_EMAIL_VERF')=="true" ?true:true;

$config["EMAIL_HOST"] = getenv('EMAIL_HOST') ?:'smtp.gmail.com';
$config["EMAIL_HOST_PORT"] = getenv('EMAIL_HOST_PORT') ?:587;
$config["EMAIL_USE_TLS"] = getenv('EMAIL_HOST_TLS')=="false" ?false:true;
$config["EMAIL"] = getenv('EMAIL') ?:'gmailuser@gmail.com';
$config["EMAIL_SENDER_NAME"] = getenv('EMAIL') ?:'The Administrator';
$config["EMAIL_PASSWORD"] = getenv('EMAIL_PASSWORD') ?:'email_password';
$config["ACTIVATION_EXPIRY_PERIOD"] = getenv('ACTIVATION_EXPIRY_PERIOD') ?:300;

return $config;
?>
