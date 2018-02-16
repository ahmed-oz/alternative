<?php
/*
* Email params
*/
define('MAIL_HOST' 		, 'mail.arguo.ch');
define('MAIL_USERNAME' 	, 'sender@arguo.ch');
define('MAIL_PASSWORD' 	, 'ArguoSender');

include "class/PHPMailer/PHPMailerAutoload.php";

function send_mail ($txt, $sub, $to, $from = NULL, $from_name =  NULL, $attachmen_path = NULL, $attachmen_name = NULL){
	$from = ( $from == NULL ) ? 'no-reply@app.alternativa-auto.it' : $from;
	$from_name = ( $from_name == NULL ) ? 'app.alternativa-auto.it' : $from_name;
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	$mail->isSMTP();
	$mail->Host = MAIL_HOST; 
	$mail->SMTPAuth = true;   
	$mail->Username = MAIL_USERNAME; 
    $mail->Password = MAIL_PASSWORD;   
	
	$mail->From = $from;
	$mail->FromName = $from_name;
	

	$mail->WordWrap = 150;
	$mail->isHTML(true);

	$mail->Subject = $sub;
	
	$mail->Body = $txt; 
	$mail->AltBody = '';
	
	//debug("public/".$attachmen_path);
	
	if ( $attachmen_path != NULL )
		$mail->AddAttachment("public/".$attachmen_path, $attachmen_name);
	

	
	if( is_array($to) ){
		foreach ($to as $t) {
			$userEmail = $t; 
			$mail->addAddress($userEmail);
			$mail->send();	
		}
	}
	else {
		$userEmail = $to; 
		$mail->addAddress($userEmail);
		$mail->send();
	}
}
?>