<?php





session_start();

	if($_SERVER['REQUEST_METHOD'] != "POST") { //INITIAL PAGE LOAD - SETS NEW VALUES FOR POST NAMES - LOADS FORM
		$name='name'.md5(rand());
		$email='email'.md5(rand());
		$number ='number'.md5(rand());
		$comment='comment'.md5(rand());
		$hidden='hidden'.md5(rand());
		$_SESSION['com']="name=$name&email=$email&number=$number&comment=$comment&hidden=$hidden";
	}
	
	
//-------------------------------VERIFY-LEGITIMACY-----------------------------------//	

	if($_SERVER['REQUEST_METHOD'] == "POST") { //LOADS ONLY IF POST 
			if(!empty($_SESSION['com'])){
				parse_str($_SESSION['com']);
			}
			else{
				 die("Sorry, your form did not send, please try again. <em>(67)</em>");//NO SESSION - 67
			}
		
		
		function safe( $value ) { return( str_ireplace(array( "\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:" ), "", $value )); }
		
		$name = safe($_POST["$name"]);
		$email = safe($_POST["$email"]);
		$number = safe($_POST["$number"]);
		$comment = $_POST["$comment"];
		$hidden = $_POST["$hidden"];
		
		if($hidden == ''){  //CHECK THAT HIDDEN FORM ELEMENT IS EMPTY
		
		
			$nohttp = "Sorry, your form did not send, please try again. <em>(45)</em>"; //NO HTTP ALLOWED - 45
			if(preg_match("/http/i","$name")) die($nohttp);
			if(preg_match("/http/i","$email")) die($nohttp);
			if(preg_match("/http/i","$number")) die($nohttp);
			if(preg_match("/http/i","$comment")) die($nohttp);
			
		
		
		//-------------------------------SETUP-EMAIL-----------------------------------//
		include("php/class.phpmailer.php");
		include("php/class.smtp.php");
		
		$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$imgurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']):'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		
		
		
		$mail             = new PHPMailer();
		
		//SETUP EMAIL SMTP INFO       
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		if (SMTP_SERVER == "smtp.gmail.com") {
				$mail->SMTPSecure = 'ssl'; 
				$mail->Port = 465;   
		}	
		$mail->Host = SMTP_SERVER;
		$mail->Username   = SMTP_AUTH_USER; 
		$mail->Password   = SMTP_AUTH_PASS; 
		
		
		//VARIABLES
		$mail->From       = strip_tags($email);
		$mail->FromName   = strip_tags($name);
		$mail->Subject    = "Website Contact - " . date('D, M n, Y');
		$mail->AltBody    = stripslashes(htmlentities($comment));
		$mail->WordWrap   = 50;
		
		
				$message = '<html><body>';
				$message .= '<img src="' . $imgurl . '/email/images/form_email_header.jpg" alt="Email Form" />';
				$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
				$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
				$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
				$message .= "<tr><td><strong>Phone Number:</strong> </td><td>" . strip_tags($number) . "</td></tr>";
				$message .= "<tr><td><strong>Sent From URL:</strong> </td><td>" . $url . "</td></tr>";
				$message .= "<tr><td><strong>Description:</strong> </td><td>" . stripslashes(htmlentities($comment)) . "</td></tr>";
				$message .= "</table>";
				$message .= "</body></html>";
		
		
		$mail->MsgHTML($message);
		$mail->AddReplyTo(strip_tags($email),strip_tags($name));
		$mail->AddAddress(DEFAULT_EMAIL,DEFAULT_NAME);
		$mail->IsHTML(true);
		
		//-------------------------------SEND-EMAIL | POST RESPONSE-----------------------------------//
		
		if(!$mail->Send()) {
		
		  echo "Mailer Error: " . $mail->ErrorInfo;
		
		} else {
		
		  echo "<div style=\"height:260px; width: 265px; padding-top:75px;\"><p style=\"text-align:center;\">Thank You.<br>Your message has been sent.</p></div>";
		
		}
		
		
		}else{die("Sorry, your form did not send, please try again. <em>(103)</em>"); }//HIDDEN TAG CONTAINED CONTENT - 103
		
		
		die; //Once form is sent don't bother loading html
	
	}//END IF POST

?>