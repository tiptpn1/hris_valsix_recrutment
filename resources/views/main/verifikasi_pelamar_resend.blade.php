<?
/* INCLUDE FILE */

use App\Models\UsersBase;

$this->load->library("KMail");

$user_base = new UsersBase();

$reqId = $auth->userPelamarId;

// echo $reqId; exit;

$base_url  = "http://localhost/";
$pathInPieces = preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME']));
$pathInPieces = explode("/", $pathInPieces);
$base_url .= $pathInPieces[1].'/';

$user_base->selectByParamsSimple(array("PELAMAR_ID" => $reqId), -1, -1, "");
// echo $user_base->query; exit;
$user_base->firstRow();

if($user_base->getField("EMAIL") == "")
{
	echo '<script language="javascript">';
	echo 'alert("Email tidak ditemukan.");';
	echo 'top.location.href = "index.php";';
	echo '</script>';		
	exit;	
}
else
{
	$body = file_get_contents($base_url."templates/verifikasi_pelamar.php?reqPelamarId=".$user_base->getField("PELAMAR_ID")."&reqNama=".str_replace(' ', '_', $user_base->getField("NAMA")));
				
	$mail = new KMail("backup");
	
	$mail->AddAddress($user_base->getField("EMAIL") ,$user_base->getField("NAMA"));
//	$mail->AddAddress("rosyidi.alhamdani@valsix.co.id" , "Rosyidi Alhamdani");
//	$mail->AddAddress("riza@ptpds.co.id", "Riza Akhmad Juliantoko"); 
	// $mail->AddAddress("bluetabs01@gmail.com", "Agung Rastikan"); 
	$mail->Subject  =  "Verifikasi Akun - PTPN 1";
	$mail->MsgHTML($body);
	if(!$mail->Send())
	{
		// echo "Gagal";
		echo '<script language="javascript">';
		echo 'alert("Gagal Mengirim Email.");';
		echo 'top.location.href = "index.php";';
		echo '</script>';		
		exit;	
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("Berhasil Mengirim Email.");';
		echo 'top.location.href = "index.php";';
		echo '</script>';		
		exit;	
	}
}
		

?>