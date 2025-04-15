<?
use Pagination;
use App\Models\Lowongan;
use App\Models\LowonganKategoriKriteria;

$lowongan= new Lowongan();

/* DEFAULT VALUES */
$pageView = "app/home";
$showRecord = 10;

$arrStatement = array("A.PUBLISH" => "1", "COALESCE(NULLIF(A.STATUS_UNDANGAN, ''), '0')" => "0"); //"A.PERIODE_ID" => $auth->PERIODE_ID_AKTIF, "A.STATUS_UNDANGAN" => "0", 

$arrSerialized = serialize($arrStatement);	
$arrSerialized = str_replace('"', '@', $arrSerialized);		

$rowCount = $lowongan->getCountByParamsMonitoringWeb($arrStatement); 
$pagConfig = array('baseURL'=>$pageView, 'showRecord' => $showRecord, 'totalRows'=>$rowCount, 'perPage'=>$showRecord, 'contentDiv'=>'lowongan-area', 'arrSerialized' => $arrSerialized, 'searchVarible' => "reqPencarian");
$pagination =  new Pagination($pagConfig);					
$lowongan->selectByParamsMonitoringWeb($arrStatement, $pageNumber->limit, $pageNumber->from);



?>

<style>
.navigasi-area{
	border:0px solid red; margin-top:-50px; 
	margin-bottom:-30px;
}
@media screen and (max-width:767px) {
	.navigasi-area{
		border:0px solid red; 
		margin-top:10px; 
		margin-bottom:-30px;
	}	
}
</style>    
<script>
	function showHide(id) {
	  var dots = document.getElementById("dots"+id);
	  var moreText = document.getElementById("more"+id);
	  var btnText = document.getElementById("myBtn"+id);
	
	  if (dots.style.display === "none") {
		dots.style.display = "inline-block";
		btnText.innerHTML = "Perlihatkan lebih banyak &#x25BC;";
		moreText.style.display = "none";
	  } else {
		dots.style.display = "none";
		btnText.innerHTML = "Perlihatkan lebih sedikit &#x25B2;";
		moreText.style.display = "inline-block";
	  }
	} 
</script>
<!--<div class="col-lg-8">-->
<!--<div class="col-lg-8 col-lg-pull-4">-->
<!--col-sm-pull-4-->

<div class="col-sm-8 col-sm-pull-4">
    <div class="lowongan-area" id="lowongan-area">
    	<div class="judul">Lowongan Aktif</div>
        <?
        while($lowongan->nextRow())
		{
			$reqLowonganId = $lowongan->getField("LOWONGAN_ID");
			$lowongan_kriteria = new LowonganKategoriKriteria();
			$adaJadwal = $lowongan_kriteria->getCountByParams(array("A.LOWONGAN_ID" => $reqLowonganId));
		?>
            <div class="list-baru">
                <div class="informasi">
                    <div class="judul"><a href="app/index/home_detil/<?=md5($reqLowonganId.'lowongan'.$MD5KEY)?>"><?=$lowongan->getField("NAMA")?> (<?=$lowongan->getField("KODE")?>)</a></div>
                    <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : <?=$lowongan->getField("REGIONAL")?> - <?=$lowongan->getField("AREA")?> </div>
                    <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> <?=getFormattedDateExt($lowongan->getField("TANGGAL_AWAL"))?> - <?=getFormattedDateExt($lowongan->getField("TANGGAL_AKHIR"))?></div>
                    <div class="kualifikasi">
                    <?=str_replace("($$)", ", ", $lowongan->getField("PERSYARATAN"))?>
                    </div>
                    <div class="waktu">
                    </div>
                </div>
                <div class="ikon">
                    <img src="uploads/logo.png">
                </div>
				<?                
				if($adaJadwal > 0)
				{
                ?>
				<div class="more" id="more<?=$reqLowonganId?>">
                    <div class="area-tahapan-seleksi">
                        <div class="judul">Tahapan Seleksi</div>
                        <div class="tabel-tahapan">
                            <table>
                            <?
							$lowongan_kriteria->selectByParams(array("A.LOWONGAN_ID" => $reqLowonganId), -1, -1, " AND A.PUBLISH_DATE IS NOT NULL ");
							while($lowongan_kriteria->nextRow())
							{
							?>
                                <tr>
                                    <td class="tanggal"><?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_MULAI"))?> - <?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_SELESAI"))?></td>
                                    <td class="tahapan">- <?=$lowongan_kriteria->getField("KETERANGAN")?></td>
                                </tr>
                            <?
							}
							?>
                            </table>
                        </div>
                        <div class="area-apply">
                            <button onclick="location.href='app/index/home_detil/<?=md5($reqLowonganId.'lowongan'.$MD5KEY)?>';">Detil &rsaquo;</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?
				}
				?>
                <div class="clearfix"></div>
            </div>
        <?
		}
		?>

        <!-- PAGING -->
        <div style="clear:both; padding-bottom:20px">
            <div class="pagesLL">
              <div class="pagesLL-margin">
                <?=$pagination->createLinks()?>
              </div>
            </div>
        </div>
    </div>
</div>

