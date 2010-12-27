<?php
define("DEFAULT_EMAIL", "to_address@domain.com");
define("DEFAULT_NAME", "Full Name of Sender");
define("SMTP_SERVER", "smtp.domain.com");
define("SMTP_AUTH_USER", "SMTP User");
define("SMTP_AUTH_PASS", "SMTP Password");
include('submit.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Email Form</title>
<link rel="stylesheet" href="css/formalize.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="js/form_plugins.js"></script>
<script src="js/form_script.js"></script>
</head>

<body>
<h1>ANTI-SPAM FORM</h1>
<form action="index.php" enctype="multipart/form-data" id="contact_form" method="post">

<input id="name" class="required" name="<?php echo $name; ?>" placeholder="Full Name"/>

<input id="email" class="required email" name="<?php echo $email; ?>" placeholder="Email: name@example.com" />

<input id="number" class="required" name="<?php echo $number; ?>" placeholder="(123) 456-7890" />

<input id="hide" class="hide" name="<?php echo $hidden; ?>" />

<textarea id="textarea" class="required" name="<?php echo $comment; ?>" rows="5" placeholder="Please leave your comment here."></textarea>

<input type="submit" value="Submit" />
&nbsp;
<input type="reset" value="Reset" />
</form>
<div id="output"></div>

</body>
</html>
