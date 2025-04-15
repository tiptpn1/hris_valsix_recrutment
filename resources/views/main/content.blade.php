<?
use App\Models\Konten;

$content = new Konten();
$reqId = request()->reqId;
$content->selectByParams(array());
//echo $content->errorMsg;exit;
//echo $content->query;exit;
/*$content->firstRow();
$caption= $content->getField("NAMA");
$text= $content->getField("KETERANGAN");*/

?>
<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

    <!--<div id="judul-halaman"><?=$caption?></div>-->
    <div id="judul-halaman">Syarat dan Ketentuan</div>
    <div id="konten">
    	<!--<p><? //tr_replace("\n", "<br/><p>", $text) ?></p>-->
    <?
    while($content->nextRow())
	{
	?>
		<?php /*?><p><strong><?=$content->getField("NAMA")?></strong></p><?php */?>
        
        <span class="judul-section"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$content->getField("NAMA")?></span>
        <?=$content->getField("KETERANGAN")?>
	<?
    }
    ?>
    
    </div>
</div>
