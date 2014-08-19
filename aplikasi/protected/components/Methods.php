<?php

require_once('Config.php');
abstract class Methods
{


	public function new_testtaker($usermodel)
	{
		$process = curl_init("http://public.ppsdm.com/ppsdm/scripts/taoactions.php");

		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_POSTFIELDS, "command=new_testtaker&username=".$usermodel->username."&password=".$usermodel->password."");
		curl_setopt($process, CURLOPT_USERPWD, "admin:admin");

		$returnedData = curl_exec($process);
		$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
		curl_close($process);
		return $httpCode;
	}
	
	public function validationEmail($usermodel,$random_number)
	{

							$url = Yii::app()->createUrl('site/validate', array('id' => $usermodel->id));
							$message = "<h2>Terima kasih telah melakukan registrasi</h2><p>Kode validasi anda: <h2>".$random_number."</h2></p><p><a href='".
							"http://" . $_SERVER['HTTP_HOST']. $url."'>Klik disini untuk validasi</a></p>";
							$subject = 'Kode validasi dan password registrasi PPSDM Portal';
							self::eMail($usermodel->username,$subject,$message);
					
	
	}
	public function testEmail()
	{

							//$url = Yii::app()->createUrl('site/validate', array('id' => $usermodel->id));
							//$message = "<h2>Terima kasih telah melakukan registrasi</h2><p>Kode validasi anda: <h2>".$random_number."</h2></p><p><a href='".
							//"http://" . $_SERVER['HTTP_HOST']. $url."'>Klik disini untuk validasi</a></p>";
							//$subject = 'Kode validasi dan password registrasi PPSDM Portal';
							self::eMail('renowijoyo@gmail.com','contoh subject','ini pesan');
					
	
	}
	
	public function eMail($sendto,$subject,$message)
	{
	
	
		$mail = new JPhpMailer;
		//$mail->SMTPDebug  = 2; 
		$mail->IsSMTP();
		
		
		$mail->Host = 'mail.ppsdm.com';
		$mail->Port = 465;
		$mail->SMTPSecure = "ssl";
		$mail->SMTPAuth = true;
		$mail->Username = 'ppsdm@ppsdm.com';
		$mail->Password = 'ppsdm2013';

		$mail->SetFrom('ppsdm@ppsdm.com', 'Registrasi PPSDM Portal');
		$mail->Subject = $subject;
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->MsgHTML($message);
		$mail->AddAddress($sendto, $sendto);
		
		
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo 'message sent';
		}	
		

		
	}
	
}
?>