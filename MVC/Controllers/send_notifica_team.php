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
		$mail->FromName = "Liofilchem NC";
		
		//$elenco_mail_team=array();
		//$elenco_mail_team[0]['email']="morescogianluca@gmail.com";
		
		for ($ss=0;$ss<=count($elenco_mail_team)-1;$ss++) {
			$elem=$elenco_mail_team[$ss]['email'];
			if (strlen($elem)!=0) {
				$mail->addAddress($elem);
			}
		}

		$mail->isHTML(true);
		
		$msg="";
		$msg.="<i>Sei stato incluso nel Team di risoluzione di una Non Conformità. Per visionare la NC ";
		$dominio="http://liojls01.ad.liofilchem.net/nc";
		//$dominio="http://localhost/servizi_liofilchem/nc";
		$msg.="<a href='$dominio/index.php?$ref_lnk'>";
			$msg.="clicca quì";
		$msg.="</a><br>";
		$msg.="Protocollo NC: <b>$protocollo_nc</b><br>";
		$msg.="Lotto: <b>$lotto</b><br>";
		$msg.="Codice: <b>$cod_art</b><br>";
		$msg.="Descrizione: <b>$descr_art</b>";		
		
		$mail->Subject = $subject;
		$mail->Body = $msg;
		$mail->AltBody = $subject;

		try {
			$mail->send();
			$sendmail="OK";
		} catch (Exception $e) {
			$sendmail=$mail->ErrorInfo;
		}	
?>		