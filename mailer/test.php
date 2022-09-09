<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 1;
$mail->isSMTP();
//$mail->Host = 'liosrv03.ad.liofilchem.net';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = "smtp@liofilchem.com";
$mail->Password = "oSeaLeonel";
$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->From = "noreply@liofilchem.com";
$mail->FromName = "noreply@liofilchem.com";

$mail->addAddress("morescogianluca@gmail.com", "TimingRUN");

$mail->isHTML(true);

$mail->Subject = "Mail sent from php send mail script.";
$mail->Body = "<i>Text content from send mail.</i>";
$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

?>