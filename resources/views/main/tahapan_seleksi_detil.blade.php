
<style>
.lowongan-template-wrapper{
	position:relative;
	*border:1px solid red;
}
.lowongan-template-wrapper .area-tombol{
	*border:1px soli] cyan;
	*position:absolute;
	*top:10px;
	*right:10px;
}
.lowongan-template-wrapper .area-tombol input[type=button],
.lowongan-template-wrapper .area-tombol a{
	height:30px;
	line-height:30px;
	background:rgba(255,255,255,0.6);
	
	*border:1px solid rgba(255,255,255,0.6);
	border: 1px solid #114c74;
	
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
	
	font-size:14px;
	
	padding-left:20px;
	padding-right:20px;
	
	*color:#FFF;
	color:#114c74;
}
.lowongan-template-wrapper .area-tombol a{
	display:inline-block;
}

/****/
.area-preview-image{
	border: 1px solid #114c74;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	
	margin-top:15px;
	margin-bottom:15px;
	
	box-sizing:border-box;
}
.area-preview-image h3{
	border: 1px solid #114c74;
	border-width:0 1px 1px 0;
	display:inline-block;
	
	-webkit-border-radius: 1px;
	-webkit-border-bottom-right-radius: 15px;
	-moz-border-radius: 1px;
	-moz-border-radius-bottomright: 15px;
	border-radius: 1px;
	border-bottom-right-radius: 15px;
	
	margin-top:0px;
	font-size:14px;
	
	height:30px;
	line-height:30px;
	
	padding-left:20px;
	padding-right:20px;
}
.area-preview-image #previewImage canvas{
	width:100% !important;
	display:block !important;
}
</style>

<?


use App\Models\Lowongan;


$reqId= request()->reqId;
$reqKode= request()->reqKode;

$lowongan= new Lowongan();


//$statement = " AND EXISTS(SELECT 1 FROM PELAMAR_LOWONGAN X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID AND X.PELAMAR_ID = '".$auth->userPelamarId."') ";

$lowongan->selectByParamsMonitoringWeb(array("MD5(A.LOWONGAN_ID)" => $reqId, "A.PERIODE_ID" => $auth->PERIODE_ID_AKTIF, "A.PUBLISH" => "1"), -1, -1, $statement);
$lowongan->firstRow();

$reqId= $lowongan->getField("LOWONGAN_ID");
$reqLowongan= $lowongan->getField("JABATAN");
$reqLowonganKode= $lowongan->getField("KODE");

if($reqId == "")
	redirect("app");
	

use App\Models\LowonganKategoriKriteria;
$lowongan_kategori_kriteria = new LowonganKategoriKriteria();
$lowongan_kategori_kriteria->selectByParams(array("A.LOWONGAN_ID" => $reqId, "MD5(A.KODE_KRITERIA)" => $reqKode));
$lowongan_kategori_kriteria->firstRow();

$reqPublish = $lowongan_kategori_kriteria->getField("STATUS_PUBLISH");
$reqKodeTahapan = $lowongan_kategori_kriteria->getField("KODE_KRITERIA");
$reqNamaTahapan = $lowongan_kategori_kriteria->getField("NAMA");
$reqKeteranganTahapan = $lowongan_kategori_kriteria->getField("KETERANGAN");
if($reqPublish == 0)
	redirect("app");
	

if($reqKodeTahapan == "PENGUMUMAN")
{
	$reqNamaTahapan = "Pengumuman Penerimaan";
	$reqInformasi   = "Daftar peserta yang diterima : ";
}
else
{
	$reqNamaTahapan = "Undangan ".$reqNamaTahapan;	
	$reqInformasi   = "Daftar peserta yang lolos untuk tahapan berikutnya :";
}

$lowongan_kategori_kriteria = new LowonganKategoriKriteria();
$lowongan_kategori_kriteria->selectByParamsPengumuman(array("A.LOWONGAN_ID" => $reqId, "A.KODE_KRITERIA" => $reqKodeTahapan));


?>


<!--<div class="col-sm-8 col-sm-pull-4"> <div class="col-sm-12">-->
<div class="col-sm-8 col-sm-pull-4">
	<div id="judul-halaman"><?=$reqNamaTahapan?> |  <?=$reqLowongan?> (<?=$reqLowonganKode?>)</div>
	<div class="lowongan-template-wrapper">
        <div class="lowongan-area">
            <div class="list-baru">
                <div class="informasi">
                	<?=$reqInformasi?>
                 
                 </div>
                <div class="ikon">
                   <img src="uploads/<?=$lowongan->getField("LOGO")?>">
                </div>
                <div id="more" style="display:inline-block">
                    <div class="area-tahapan-seleksi">
                        <div class="judul"><span class="nama-tahap"><?=$reqKeteranganTahapan?></span></div>
                        <div class="tabel-tahapan detil">
                        	<table class="peserta-lolos">
                                <thead>
                                    <tr>
                                        <th>Nomor Registrasi</th>
                                        <th>Nama</th>
                                        <?
                                        if($reqKodeTahapan !== "PENGUMUMAN")
										{
										?>
                                        <th>Gelombang</th>
                                        <th>Waktu Pelaksanaan</th>
                                        <th>Lokasi</th>
                                        <?
										}
										?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                while($lowongan_kategori_kriteria->nextRow())
								{
								?>
                                    <tr>
                                        <td><?=$lowongan_kategori_kriteria->getField("PELAMAR_NRP")?></td>
                                        <td><?=$lowongan_kategori_kriteria->getField("PELAMAR")?></td>
                                        <?
                                        if($reqKodeTahapan !== "PENGUMUMAN")
										{
										?>
                                        <td><?=$lowongan_kategori_kriteria->getField("GELOMBANG_KE")?></td>
                                        <td><?=getFormattedDate($lowongan_kategori_kriteria->getField("GELOMBANG_TANGGAL"))?>, <?=$lowongan_kategori_kriteria->getField("GELOMBANG_JAM")?></td>
                                        <td><?=$lowongan_kategori_kriteria->getField("GELOMBANG_LOKASI")?></td>
                                        <?
										}
										?>
                                    </tr>
                                <?
								}
								?>
                                </tbody>
                            </table>    
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>            
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
