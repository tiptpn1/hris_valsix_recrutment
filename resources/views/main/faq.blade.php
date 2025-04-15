<?

use App\Models\Faq;

$faq = new Faq();
$faq->selectByParams(array());

?>
<!--<div class="col-lg-8">-->
<div class="<?=($auth->userPelamarId == "") ? "col-sm-12" : "col-sm-8 col-sm-pull-4"?>">

	<div id="judul-halaman">FAQ</div>
    
    <div class="faq-area">
    <?
    while($faq->nextRow())
	{
	?>
    	<div class="list">
            <div class="tanya">
                <i class="fa fa-question fa-3x" aria-hidden="true"></i> <?=$faq->getField("PERTANYAAN")?>
            </div>
            <div class="jawab">
            	<i class="fa fa-check fa-2x" aria-hidden="true"></i>
                <?=$faq->getField("JAWABAN")?>
            </div>
        </div>
    <?
	}
	?>    
    </div>

</div>