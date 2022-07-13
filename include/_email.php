<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


class Email{
	private $email;
	private $to;
	private $from;
	private $from_name;
	private $subject;
	private $message;
	public $error_message;

	function __construct(){
        $this->email = new PHPMailer(true);
	}

	function setTo($to){$this->to = $to;}
	function setFrom($from){$this->from = $from;}
	function setFromName($from_name){$this->from_name = $from_name;}
	function setSubject($subject){$this->subject = $subject;}
	function setMessage($message){$this->message = $message;}

	function sendEmail(){
		$returValue = false;
		try {
		    //Server settings
		    // $this->email->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		    // $this->email->isSMTP();                                            // Send using SMTP
		    // $this->email->Host       = 'smtp1.example.com';                    // Set the SMTP server to send through
		    // $this->email->SMTPAuth   = true;                                   // Enable SMTP authentication
		    // $this->email->Username   = 'user@example.com';                     // SMTP username
		    // $this->email->Password   = 'secret';                               // SMTP password
		    // $this->email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    // $this->email->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    // Recipients
		    $this->email->setFrom($this->from, $this->from_name);
		    $this->email->addAddress($this->to);               // Name is optional

		    // Content
		    $this->email->isHTML(true);                                  // Set email format to HTML
		    $this->email->Subject = $this->subject;
		    $this->email->Body    = $this->message;
		    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $this->email->send();
		    $this->error_message = "Mensaje Enviado";

			// Mail header
		    // $header = "Content-type: text/html; charset=UTF-8 \r\n";
		    // $header .= "From: ".$this->from_name." <".$this->from."> \r\n";
		    // $header .= "MIME-Version: 1.0 \r\n";
		    // $header .= "Content-Transfer-Encoding: 8bit \r\n";
		    // $header .= "Date: ".date("r (T)")." \r\n";

		    // // Send mail
		    // $returnValue = mail($this->to, $this->subject, $this->message, $header);
		    // $this->error_message = 'EMAIL:'.$returnValue;
		} catch (Exception $e) {
			$this->error_message = "Message could not be sent. Mailer Error: {$this->email->ErrorInfo}";
		}

		return $returValue;
	}
}
?>