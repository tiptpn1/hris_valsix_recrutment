<?
use App\Models\Lowongan;
use App\Models\LowonganKategoriKriteria;

$lowongan= new Lowongan();

$reqPencarian = request()->reqPencarian;

$statementPencarian = " AND ( ";
$statementPencarian .= " UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%' OR ";
$statementPencarian .= " UPPER(A.KETERANGAN) LIKE '%".strtoupper($reqPencarian)."%' OR ";
$statementPencarian .= " UPPER(A.PERSYARATAN) LIKE '%".strtoupper($reqPencarian)."%' ";
$statementPencarian .= " ) ";
$allRecord = $lowongan->getCountByParamsMonitoringWeb(array("A.PUBLISH" => "1"), $statementPencarian); 
$lowongan->selectByParamsMonitoringWeb(array("A.PUBLISH" => "1"), -1, -1, $statementPencarian);



?>

<style>
.lowongan-area{
	*min-height:600px;
}
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

<div class="col-sm-12">
	
    <div class="lowongan-area">
    	<div class="judul">Hasil Pencarian :<?=$reqPencarian?></div>
        <?
		$ada = 0;
        while($lowongan->nextRow())
		{
			$reqLowonganId = $lowongan->getField("LOWONGAN_ID");
		?>
            <div class="list-baru">
                <div class="informasi">
                    <div class="judul"><a href="app/index/home_detil/<?=md5($reqLowonganId.'lowongan'.$MD5KEY)?>"><?=$lowongan->getField("JABATAN")?> (<?=$lowongan->getField("KODE")?>)</a></div>
                    <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : <?=$lowongan->getField("CABANG")?> </div>
                    <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> <?=getFormattedDateExt($lowongan->getField("TANGGAL_AWAL"))?> - <?=getFormattedDateExt($lowongan->getField("TANGGAL_AKHIR"))?></div>
                    <div class="kualifikasi">
                    <?=str_replace("($$)", ", ", $lowongan->getField("PERSYARATAN"))?>
                    </div>
                </div>
                <div class="ikon">
                    <img src="uploads/logo.png">
                </div>
                <div class="clearfix"></div>
            </div>
        <?
			$ada++;
		}
		if($ada == 0)
		{
		?>
        
        <!-- PAGING -->
        <div style="clear:both; padding-bottom:20px">
            <div class="pagesLL">
              <div class="pagesLL-margin">
               Hasil pencarian anda tidak ditemukan...
              </div>
            </div>
        </div>
        <?
		}
		?>
    </div>
</div>

