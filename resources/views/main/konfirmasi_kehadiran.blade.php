<?



use App\Models\PelamarLowonganShortlist;
use App\Models\PelamarLowonganTahapan;
use App\Models\LowonganTahapan;


$reqPelamarId = request()->reqPelamarId;
$reqLowonganId= request()->reqLowonganId;
$reqHadir = request()->reqHadir;

$pelamar_lowongan_shortlist = new PelamarLowonganShortlist();
$pelamar_lowongan_tahapan = new PelamarLowonganTahapan();
$lowongan_tahapan = new LowonganTahapan();

$lowongan_tahapan->selectByParams(array("A.LOWONGAN_ID" => $reqLowonganId, "URUT" => "1"));
$lowongan_tahapan->firstRow();

if($reqHadir == "")
{
	$pelamar_lowongan_shortlist->setField('LOWONGAN_ID', $reqLowonganId);
	$pelamar_lowongan_shortlist->setField('PELAMAR_ID', $reqPelamarId); 	
	if($pelamar_lowongan_shortlist->updateTidakHadir());
	{
		echo '<script language="javascript">';
		echo 'alert("Konfirmasi ketidakhadiran anda telah kami terima, Terima Kasih.");';
		echo 'top.location.href = "index.php";';
		echo '</script>';
		exit;			
	}	
}
else
{
	$pelamar_lowongan_shortlist->setField('LOWONGAN_ID', $reqLowonganId);
	$pelamar_lowongan_shortlist->setField('PELAMAR_ID', $reqPelamarId); 	
	if($pelamar_lowongan_shortlist->updateHadir())
	{
		$pelamar_lowongan_tahapan->setField("PELAMAR_ID", $reqPelamarId);
		$pelamar_lowongan_tahapan->setField("LOWONGAN_ID", $reqLowonganId);
		$pelamar_lowongan_tahapan->setField("LOWONGAN_TAHAPAN_ID", $lowongan_tahapan->getField("LOWONGAN_TAHAPAN_ID"));
		$pelamar_lowongan_tahapan->setField("LOLOS", "0");
		$pelamar_lowongan_tahapan->setField("LAST_CREATE_USER", $auth->nama);
		$pelamar_lowongan_tahapan->insertAwal();

		echo '<script language="javascript">';
		echo 'alert("Konfirmasi kehadiran anda telah kami terima, Terima Kasih.");';
		echo 'top.location.href = "index.php";';
		echo '</script>';
		exit;			
		
	}
}
	

