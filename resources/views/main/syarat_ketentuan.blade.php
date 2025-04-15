<?
use App\Models\Konten;

$content = new Konten();
$reqId = 1;
$content->selectByParams(array());
?>
<div class="<?=($auth->userPelamarId == "") ? "col-sm-12" : "col-sm-8 col-sm-pull-4"?>">

    <!--<div id="judul-halaman"><?=$caption?></div>-->
    <div id="judul-halaman">Syarat dan Ketentuan</div>
    <div id="konten">
    	<!--<p><? //tr_replace("\n", "<br/><p>", $text) ?></p>-->
    <?
    while($content->nextRow())
	{
	?>
		 
        <span class="judul-section"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$content->getField("NAMA")?></span>
        <?=$content->getField("KETERANGAN")?>
	<?
    }
    ?>
    
    </div>
</div>
