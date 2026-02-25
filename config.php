<?php
$config["DB_NAME"] = getenv('DB_NAME') ?:"leather_store";
$config["DB_USER"] = getenv('DB_USER') ?:"root";
$config["DB_PASSWORD"] = getenv('DB_PASSWORD') ?:"";
$config["DB_HOST"] = getenv('DB_HOST') ?:"localhost";
$config["DB_PORT"] = getenv('DB_PORT') ?:5432;

$config["VENDOR_DIR"] = getenv('VENDOR_DIR') ?:"./vendor";

$config["URL"] = getenv('URL') ?:'http://localhost/';

$config["USER_EMAIL_VERF"] = getenv('USER_EMAIL_VERF') ?:FALSE;

$config["EMAIL_HOST"] = getenv('EMAIL_HOST') ?:'smtp.gmail.com';
$config["EMAIL_HOST_PORT"] = getenv('EMAIL_HOST_PORT') ?:587;
# Accepted values: STARTTLS OR SMTPS by Default if not set STARTTLS if EMAIL_HOST_PORT = 587 and SMTPS if EMAIL_HOST_PORT = 465
#$config["EMAIL_HOST_TLS_OPTION"] = getenv('EMAIL_HOST_TLS_OPTION') ?:587;
$config["EMAIL_USE_TLS"] = getenv('EMAIL_HOST_TLS') ?:TRUE;
$config["EMAIL"] = getenv('EMAIL') ?:'gmailuser@gmail.com';
$config["EMAIL_SENDER_NAME"] = getenv('EMAIL') ?:'The Administrator';
$config["EMAIL_PASSWORD"] = getenv('EMAIL_PASSWORD') ?:'email_password';
$config["ACTIVATION_EXPIRY_PERIOD"] = getenv('ACTIVATION_EXPIRY_PERIOD') ?:300;
?>
