<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
  // empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$name = $_POST['name'];
$email_address = $_POST['email'];
//$phone = $_POST['phone'];
$message = $_POST['message'];
$url = 'https://api.sendgrid.com/';
$user = 'username';
$pass = 'supersecretpassword';
$messagebody = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$messagebodyhtml = "You have received a new message from your website contact form.<br>"."Here are the details:<br>Name: $name<br>Email: $email_address<br>Message: $message";
$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => 'you@yourdomain.com',
    'subject'   => 'Someone sent a message from yourdomain.com',
    'html'      => $messagebodyhtml,
    'text'      => $messagebody,
    'from'      => 'yourform@yourdomain.com',
  );


$request =  $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);
// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
// Tell PHP not to use SSLv3 (instead opting for TLS)
curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);

// print everything out
print_r($response);

?>
