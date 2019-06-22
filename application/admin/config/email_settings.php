<?php

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "mail.pranavnbapat.com";
$mail->Port = 26;
$mail->Username = "test@pranavnbapat.com";
$mail->Password = "test@123";
?>