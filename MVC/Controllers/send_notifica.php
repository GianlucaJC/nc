<?php
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

		require '../../mailer/src/Exception.php';
		require '../../mailer/src/PHPMailer.php';
		require '../../mailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		//$mail->Host = 'liosrv03.ad.liofilchem.net';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = "smtp@liofilchem.com";
		$mail->Password = "oSeaLeonel";
		$mail->SMTPSecure = "tls";
		$mail->Port = 587;

		$mail->From = "noreply@liofilchem.com";
		$mail->FromName = "Liofilchem NC-PR";
		
		$arr=explode(",",$dest);
		for ($ss=0;$ss<=count($arr)-1;$ss++) {
			$mail->addAddress($arr[$ss]);
		}

		$mail->isHTML(true);
		
		$msg="";
		$msg.="<i>Per visionare la nuova NC ";
		$msg.="<a href='http://liojls01.ad.liofilchem.net/nc/index.php?nc=$ref'>";
			$msg.="clicca quì";
		$msg.="</a><br>";
		$msg.="Protocollo NC: <b>$protocollo_nc</b><br>";
		$msg.="Lotto: <b>$lotto</b><br>";
		$msg.="Codice: <b>$cod_art</b><br>";
		$msg.="Descrizione: <b>$descr_art</b>";
		
		$mail->Subject = "Nuova segnalazione NC di prodotto";
		$mail->Body = $msg;
		$mail->AltBody = "Nuova segnalazione NC di prodotto";

		try {
			$mail->send();
			$sendmail="OK";
		} catch (Exception $e) {
			$sendmail=$mail->ErrorInfo;
		}	
?>		