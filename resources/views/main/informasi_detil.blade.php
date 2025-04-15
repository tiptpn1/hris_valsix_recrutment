<?
use App\Models\Informasi;


$this->load->library("PageNumber"); $pageNumber = new PageNumber();


$informasi = new Informasi();

$reqId = request()->reqId;

$informasi->selectByParams(array("I.INFORMASI_ID" => $reqId));
$informasi->firstRow();

$tgl = getFormattedDateExt($informasi->getField("TANGGAL"), false);
$tgl = explode(" ", $tgl);
$tanggal = $tgl[0];
$bulan = $tgl[1];
$tahun = $tgl[2];
?>
<div class="col-lg-8">

    <div id="judul-halaman">Informasi Detil</div>
    <div class="konten-detil">
    	<div class="informasi-area">
        	<div class="list">
            	<div class="tgl">
                	<span class="tanggal"><?=$tanggal?></span> 
                    <span class="bulan"><?=$bulan?> <?=$tahun?></span>
                </div>
                <div class="data">
                	<div class="judul"><?=$informasi->getField("I_NAMA")?></div>
                    <div class="isi">
						<?=$informasi->getField("I_KETERANGAN")?>
                    </div>
                    <div class="kembali"><a href="app/index/informasi"><i class="fa fa-reply" aria-hidden="true"></i> Kembali ke daftar informasi </a></div>
                </div>
            </div>
            
            
            
        </div>
    </div>
    
</div>
