<?



$this->load->library("PageNumber"); $pageNumber = new PageNumber();
use App\Models\Lowongan;

$lowongan= new Lowongan();

$reqId= request()->reqId;

/* DEFAULT VALUES */
$pageView = "index.phpapp/index/kategori_list";
$showRecord = 6;

/* DATA VIEWING */
//$informasi->selectByParams(array("I.STATUS_AKTIF" => 1, "I.STATUS_INFORMASI" => $reqId),-1,-1, "","id", "ORDER BY TANGGAL DESC");

$allRecord = $lowongan->getCountByParams(array("A.STATUS" => 1, "A.JABATAN_ID" => $reqId));
$pageNumber->initialize($allRecord, $showRecord, $reqPage, $pageView);
$lowongan->selectByParams(array("A.STATUS" => 1, "A.JABATAN_ID" => $reqId), $pageNumber->limit, $pageNumber->from, "");
//echo $lowongan->query;exit;
//$lowongan->selectByParams(array("FORMASI_ID" => 1),-1,-1, "", "ORDER BY A.TANGGAL DESC");

?>
<!-- TICKER -->
<link href="libraries/NewsTicker4line/global.css" rel="stylesheet" type="text/css">
<script src="libraries/NewsTicker4line/jquery.js"></script>
<link href="libraries/NewsTicker4line/css.css" rel="stylesheet" type="text/css">

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



<div class="col-lg-8">
	
    <?php /*?><div class="informasi-ticker-area">
    	<div class="title">Lowongan <?=$lowongan->getField("NAMA_JABATAN")?></div>
    </div><?php */?>

<div class="lowongan-area">
	<div class="judul">Lowongan <?=$lowongan->getField("NAMA_JABATAN")?></div>
	<? 
    while($lowongan->nextRow()) 
    {
        $tgl = getFormattedDateTimeShort($lowongan->getField("TANGGAL"), false);
        $tgl = explode(" ", $tgl);
        $tanggal = $tgl[0];
        $bulan = $tgl[1];
        $tahun = $tgl[2];
        $tempDetilPersyaratan= $lowongan->getField("PERSYARATAN");
        $tempDetilPersyaratanArr = explode("($$)", $tempDetilPersyaratan);
        $count_arr_persyaratan = count($tempDetilPersyaratanArr);
    ?>
    <div class="list">
	
	<?php /*?><div class="tanggal">
		<div class="bulan"><?=$bulan?></div>
		<div class="tgl"><?=$tanggal?><br><span class="thn"><?=$tahun?></span></div>
	</div><?php */?>
    
        <div class="tanggal">
            <i class="fa fa-calendar"></i>
            <div><?=$tanggal?> <?=$bulan?> <span class="thn"><?=$tahun?></span></div>
            
            <?php /*?><div class="tgl"><?=$tanggal?><br><span class="thn"><?=$tahun?></span></div><?php */?>
        </div>
        
        <div class="data">
            <div class="judul"><a href="app/index/home_detil?reqId=<?=$lowongan->getField("LOWONGAN_ID")?>"><span class="penempatan"><?=$lowongan->getField("PENEMPATAN")?></span> - <?=$lowongan->getField("JABATAN")?> (<?=$lowongan->getField("KODE")?>)</a></div>
		<div class="isi">Syarat :
			<?
            for($i=0; $i<$count_arr_persyaratan; $i++)
            {
                if($i == 0 && $tempDetilPersyaratan == '')
                { }
                else
                {
            ?>
                -&nbsp;<?=$tempDetilPersyaratanArr[$i]?></li>
            <?
                }
            }
            ?>
        ...</div>
        </div>
    </div>
	<? } ?>
        
        <!-- PAGING -->
        <div style="clear:both; padding-bottom:20px">
            <div class="pagesLL">
              <div class="pagesLL-margin">
                <?=$pageNumber->drawPageFlex()?>
              </div>
            </div>
        </div> 
        
    </div>
</div>

<!-- TICKER -->
<script>


	function tick2(){
		$('#ticker_02 li:first').slideUp( function () { $(this).appendTo($('#ticker_02')).slideDown(); });
	}
	setInterval(function(){ tick2 () }, 3000);



</script>
