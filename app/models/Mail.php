<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/Exception.php';
require 'lib/PHPMailer/PHPMailer.php';
require 'lib/PHPMailer/SMTP.php';

class Mail extends Controller {

	public function send($sender,$recipient,$subject,$message)
	{
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = 0;                                 // 2=Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $this->f3->get('smtp_host');   		  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $this->f3->get('smtp_user');        // SMTP username
			$mail->Password = $this->f3->get('smtp_pw');          // SMTP password
			$mail->SMTPSecure =$this->f3->get('smtp_scheme');     // Enable TLS 
			$mail->Port = $this->f3->get('smtp_port');            // TCP port to connect to

			//reply to before setfrom: https://stackoverflow.com/questions/10396264/phpmailer-reply-using-only-reply-to-address
			$mail->AddReplyTo($sender);
			$mail->setFrom( $this->f3->get('smtp_user') );

			$mail->addAddress($recipient);     // Add a recipient

			//Content
			$mail->isHTML(true);               // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->AltBody = strip_tags($message);
			$mail->send();
			
		} catch (Exception $e) {
			$logger = new Log('logs/'.date("Ymd").'error.log');
			$logger->write( "MAIL ERROR: " .$mail->ErrorInfo,'r'  );
		}

	}
}