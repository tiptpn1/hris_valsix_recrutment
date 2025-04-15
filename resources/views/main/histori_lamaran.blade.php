<?


use App\Models\PelamarLowongan;
use App\Models\Lowongan;



$reqKonfirmasi = request()->reqKonfirmasi;

$pelamar_lowongan = new PelamarLowongan();
$pelamar_lowongan->selectByParamsDaftarLamaran(array("A.PELAMAR_ID" => $auth->userPelamarId, "B.UNDANGAN" => "N"));
//echo $pelamar_lowongan->query;
if($reqKonfirmasi == "")
{}
else
{
	$lowongan = new Lowongan();
	$lowongan->selectByParams(array("MD5(A.LOWONGAN_ID::varchar)" => $reqKonfirmasi));
	$lowongan->firstRow();
	$judul_lowongan = $lowongan->getField("JABATAN");
	$kode_lowongan = $lowongan->getField("KODE");
}



?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<div class="col-lg-8">

    <div id="judul-halaman">Histori Lamaran Anda</div>
    <div class="konten-10">    
    <?
    if($reqKonfirmasi == "")
	{}
	else
	{
	?>
	    <div class="alert alert-info"><i class="fa fa-info-circle fa-lg"></i> Terima Kasih, anda telah berhasil mendaftar <?=$judul_lowongan?> (<?=$kode_lowongan?>).</div>    
    <?
	}
	?>
    </div>    
   	<div class="data-monitoring">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Kode</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Tanggal Kirim</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?
            while($pelamar_lowongan->nextRow())
            {
            ?>
                <tr>
                    <td><?=$pelamar_lowongan->getField("KODE")?></td>
                    <td><?=$pelamar_lowongan->getField("JABATAN")?></td>
                    <td><?=getFormattedDate($pelamar_lowongan->getField("TANGGAL_KIRIM"))?></td>
                    <td>
                        <a href="app/index/lamaran_detil?reqId=<?=$pelamar_lowongan->getField("LOWONGAN_ID")?>"><i class="fa fa-file"></i> Detil</a>
                    </td>
                </tr>    
            <?
            }
            ?>
            </tbody>
        </table>
    
    </div>    
    
</div>