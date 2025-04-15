<?


use App\Models\LowonganKategoriKriteria;
use App\Models\PelamarLowongan;
use App\Models\Lowongan;


$reqId= setQuote($reqParse1);

$lowongan= new Lowongan();
$pelamar_lowongan = new PelamarLowongan();

$lowongan->selectByParamsMonitoringWeb(array("md5(CONCAT(A.LOWONGAN_ID , 'lowongan' , '$MD5KEY'))" => $reqId)); //, "A.PERIODE_ID" => $auth->PERIODE_ID_AKTIF, "A.PUBLISH" => "1"
$lowongan->firstRow();

$reqId = $lowongan->getField("LOWONGAN_ID");

	
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


if($reqId == "")
{
    $data = [
            "heading" => "Data lowongan tidak dikenali.",
			"auth" => $auth
    ];
    $body = view("konten/data_tidak_dikenali", $data);
    echo $body;
    return;
}
?>

<!--<div class="col-md-4 sisi-kanan">-->
<div class="col-sm-4 col-sm-push-8 sisi-kanan">
	<div class="area-cek-register">
        <div class="judul"><span>Registrasi</span></div>
        <form>
            <input class="nik" id="reqKtp" type="text" placeholder="Masukkan 16 Digit NIK" maxlength="16">
            <span id="spanRegister" style="color:#D14F51"></span>
            <button type="button" onClick="checkKtp($('#reqKtp').val(), 'spanRegister');">Submit</button>
        </form>                        
    </div>
</div>

<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

	<div id="judul-halaman"><?=$lowongan->getField("NAMA")?> (<?=$lowongan->getField("KODE")?>)</div>
	
    <div class="lowongan-area">
    	<div class="list-baru">
        	<div class="informasi">
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : <?=$lowongan->getField("REGIONAL")?> - <?=$lowongan->getField("AREA")?></div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> <?=getFormattedDateExt($lowongan->getField("TANGGAL_AWAL"))?> - <?=getFormattedDateExt($lowongan->getField("TANGGAL_AKHIR"))?></div>
                <div class="kualifikasi">
                	Kualifikasi:
                    <ul>
                    <?
                    $sql = " select nama from lowongan_persyaratan where lowongan_id = '$reqId' order by lowongan_persyaratan_id ";
                    
                    $rowResult = KDatabase::query($sql)->result_array();
					foreach($rowResult as $row)
					{
					?>
                    <li><?=$row["nama"]?></li>
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
            <div id="more" style="display:inline-block">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                            <?
                            $lowongan_kriteria = new LowonganKategoriKriteria();
							$lowongan_kriteria->selectByParams(array("A.LOWONGAN_ID" => $reqId), -1, -1, " AND A.PUBLISH_DATE IS NOT NULL ");
							$isAktif = 0;
							while($lowongan_kriteria->nextRow())
							{
							?>
                                <tr>
                                    <td class="tahapan"><?=$lowongan_kriteria->getField("KETERANGAN")?></td>
                                    <td class="tahapan">
                                    	<?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_MULAI"))?> - <?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_SELESAI"))?>
                                     </td>
                                    <td class="keterangan">
                                    </td>
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
        
        <div class="list" style="display: none;">
                
                <?
				$total_pelamar = $pelamar_lowongan->getCountByParams(array("LOWONGAN_ID" => $reqId), " AND TANGGAL_KIRIM IS NOT NULL ");
                ?>
                <div id="info-pelamar">
                    <div>Jumlah pelamar posisi ini sampai saat ini : <?=$total_pelamar?>
                    </div> 
                    <?
                    if($auth->userPelamarId == "")
					{
					?>
                    <div>Silahkan registrasi / login untuk mengirim lamaran.</div>                  
                    <?
					}
					?>
                </div>
                
                <div class="area-tombol-kanan">
                    <?
                    if($auth->userPelamarId == "")
                    {}
                    else
                    {  
						if($lowongan->getField("TANGGAL_AKHIR") < date('Y-m-d'))
						{}
						else
						{
                    ?>
                            <!-- SETELAH LOGIN -->
                            <div class="kirim-lamaran"><a href="app/index/lamaran?reqId=<?=$reqId?>" >Kirim Lamaran</a></div>
                    <?
						}
                    }
                    ?>
                    <?
                    //}
                    ?>
                </div>
        </div>
    </div>
</div>

