<?


$this->load->library("KMail");

//echo "wewe".$_SERVER['SERVER_NAME'];



$body = file_get_contents("http://".$_SERVER['SERVER_HOST']."/pds-rekrutmen/main/templates/konfirmasi_daftar.php?reqNama=TANPA&reqPassword=CINTA");


$mail = new KMail("backup");
$mail->AddAddress("rosyidi.alhamdani@valsix.co.id" , "Rosyidi Alhamdani");
$mail->Subject  =  "Pengumuman";
$mail->MsgHTML($body);
if(!$mail->Send())
{
	echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
	echo 'Message has been sent.';
}

?>