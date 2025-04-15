<?


use App\Models\PelamarLowongan;
use App\Models\Lowongan;


$reqId= setQuote($reqParse1);

$lowongan= new Lowongan();
$pelamar_lowongan = new PelamarLowongan();


$lowongan->selectByParamsMonitoringWeb(array("md5(CONCAT(A.LOWONGAN_ID , 'lowongan' , '$MD5KEY'))" => $reqId), -1, -1, $statement);
$lowongan->firstRow();

$reqId= $lowongan->getField("LOWONGAN_ID");

if($reqId == "")
{
    $data = [
            "message" => "Data lowongan tidak dikenali.",
			"auth" => $auth
    ];
    $body = view("konten/data_tidak_dikenali", $data);
    echo $body;
    return;
}

$reqDetilRowId= $lowongan->getField("LOWONGAN_ID_ENKRIP");
$reqNamaFormasi= $lowongan->getField("NAMA_FORMASI");
$reqJabatan= $lowongan->getField("JABATAN");
$reqDetilNama= $lowongan->getField("JABATAN");
$reqDetilKode= $lowongan->getField("KODE");
$reqTanggalAkhir= getFormattedDate($lowongan->getField("TANGGAL_AKHIR"));
$reqManual= $lowongan->getField("MANUAL");
$reqKeterangan= $lowongan->getField("KETERANGAN");
$reqLinkFile = $lowongan->getField("LINK_FILE");

$reqDetilPersyaratan= $lowongan->getField("PERSYARATAN");
$reqDetilPersyaratanArr = explode("($$)", $reqDetilPersyaratan);
$count_arr_persyaratan = count($reqDetilPersyaratanArr);

$reqDetilDokumen= $lowongan->getField("DOKUMEN");
$reqDetilDokumenArr = explode("($$)", $reqDetilDokumen);
$count_arr_dokumen = count($reqDetilDokumenArr);

$reqDetilPenempatan= $lowongan->getField("PENEMPATAN");
$reqDetilPenempatanArr = explode("($$)", $reqDetilPenempatan);
$reqPenempatan= implode(",", $reqDetilPenempatanArr);
?>

<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

	<div id="judul-halaman"><?=$lowongan->getField("NAMA")?> (<?=$lowongan->getField("KODE")?>)</div>
	
    <div class="lowongan-area lowongan-area-detil">
    	<div class="list-baru">
        	<div class="informasi">
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : <?=$lowongan->getField("REGIONAL")?> - <?=$lowongan->getField("AREA")?></div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> <?=getFormattedDateExt($lowongan->getField("TANGGAL_AWAL"))?> - <?=getFormattedDateExt($lowongan->getField("TANGGAL_AKHIR"))?></div>
                <div class="kualifikasi">
                	Kualifikasi:
                    <ul>
                    <?
                    $arrPersyaratan = explode("($$)", $lowongan->getField("PERSYARATAN"));
					for($i=0;$i<count($arrPersyaratan);$i++)
					{
					?>
                    <li><?=$arrPersyaratan[$i]?></li>
                    <?
					}
					?>
                    </ul>
                    
                    Job Description:
                    <?=$lowongan->getField("KETERANGAN")?>

                </div>
                
            </div>
            <div class="ikon">
            	<img src="images/logo-ttl.png">
            </div>
            <div><a class="btn btn-primary pull-right" href="app/index/daftar_lowongan">Kembali Ke Daftar Lowongan</a></div>
            <div id="more" style="display:inline-block">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                            <?
							use App\Models\LowonganKategoriKriteria;
                            $lowongan_kriteria = new LowonganKategoriKriteria();
							$lowongan_kriteria->selectByParams(array("A.LOWONGAN_ID" => $reqId), -1, -1, " AND A.PUBLISH_DATE IS NOT NULL ");
							$isAktif = 0;
							while($lowongan_kriteria->nextRow())
							{
								if($lowongan_kriteria->getField("KODE_KRITERIA") == "REGISTRASI")
								{
									$isAktif = $lowongan_kriteria->getField("AKTIF");
									$isBerakhirSd = $lowongan_kriteria->getField("TANGGAL_SELESAI");
								}	
							?>
                                <tr>
                                    <td class=""><?=$lowongan_kriteria->getField("KETERANGAN")?></td>
                                    <td class="tahapan"><?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_MULAI"))?> - <?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_SELESAI"))?></td>
                                </tr>
                            <?
							}
							?>
                        </table>
                    </div>
                    <?php /*?>'<div class="area-apply">
'                    	<button>Apply</button>
'                    </div><?php */?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            
        </div>
        
        
        
    </div>
</div>

