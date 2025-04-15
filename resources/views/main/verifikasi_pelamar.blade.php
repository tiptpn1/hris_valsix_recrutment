<?



use App\Models\Pelamar;

use App\Models\UsersBase;

$reqPelamarId = request()->reqId;

$pelamar = new Pelamar();
$users_base = new UsersBase();

$users_base->selectByParamsSimple(array("PELAMAR_ID"=>$reqPelamarId), -1, -1, "");
$users_base->firstRow();

$reqEmail = $users_base->getField("USER_LOGIN");
$reqPassword = $users_base->getField("USER_PASS");

$pelamar->setField('PELAMAR_ID', $reqPelamarId); 	
$pelamar->setField('VERIFIKASI', "1"); 	
$pelamar->setField('LAST_VERIFIED_USER', $reqPelamarId); 	
$pelamar->setField('LAST_VERIFIED_DATE', "CURRENT_DATE"); 	
if($pelamar->verifikasi());
{
	$this->verifyUserVerifikasi($reqEmail, $reqPassword);
	echo '<script language="javascript">';
	echo 'alert("Konfirmasi akun anda telah kami terima, Terima Kasih.");';
	echo 'top.location.href = "index.php";';
	echo '</script>';
	exit;			
}	
	

