<?




use App\Models\Pelamar;

$pelamar = new Pelamar();
$pelamar->selectByParamsCutOffSimple(array("A.PELAMAR_ID" => $auth->userPelamarId));
$pelamar->firstRow();

$reqId = $pelamar->getField("PELAMAR_ID");
$reqNIK = $pelamar->getField("KTP_NO");
// if($reqId == "")
// 	redirect("app");

// if($auth->LOWONGAN_ID == "")
// 	redirect("app");

?>

<style>
.area-ttd{
	border: 1px solid #DDDDDD !important;
	border-width: 0 1px 0 1px !important;
	height: 80px;
}

@media print {
	@page { margin: 0; }
	body  { margin: 1.6cm; }
	nav.navbar,
	.container-fluid.footer{
		display: none !important;
	}
	.main-detil {
		margin-top: 0px !important;
	}
	#judul-halaman{
		display: none !important;
	}
	.col-sm-4.col-sm-push-8{
		display: none !important;
	}  
	#printableArea, #printableArea *{
		visibility: visible;
	}
	#printableArea {
		position: absolute;
		left: 0 !important;
		right: 0 !important;
		top: 0;
		margin-right: -100% !important;
		margin-left: 50% !important;
		border: 1px solid #999999;
	}
	#printableArea td{
		padding-right: 0px !important;
	}
}
</style>

<div class="col-sm-8 col-sm-pull-4">

	<div id="judul-halaman">Cetak Kartu Registrasi</div>
    
	<div class="row area-cetak-registrasi" id="printableArea">
        <div class="col-md-12">
            <table>
                <tr>
                  <td colspan="4" style="padding: 0 0 5px 0;">
                    <table>
                        <tr>
                            <td><img src="images/logo-ttl.png" height="45"></td>
                            <td align="center">
                            <span style="font-size: 32px; text-transform: uppercase;">Kartu Peserta Pelamar&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
                            <span style="text-transform: uppercase; letter-spacing: 1px;">PTPN 1&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                    <td>NIK&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=$pelamar->getField("KTP_NO")?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td rowspan="9" align="center" style="padding-left: 0; padding-right: 0;">
                    <table>
                        <tr>
                            <td>
                                <div class="foto-peserta">
                                    <div class="inner">
                                        <?
                                        $reqLampiranFoto = $pelamar->getField("LAMPIRAN_FOTO");
                                        if($reqLampiranFoto == "")
                                            $img = "images/img-pria.jpg";
                                        else
                                            $img = "uploads/".$reqLampiranFoto;		
                                        ?>
                                        <img class="foto" src="<?=$img?>">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="area-qr-code">
                                    <div id="output"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                    <td>Nomor&nbsp;Registrasi&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td class="nomor-registrasi"><?=$pelamar->getField("NRP")?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Waktu&nbsp;Registrasi&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=getFormattedDateTimeDMY($pelamar->getField("TANGGAL_DAFTAR"))?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?=$pelamar->getField("NAMA")?></td>
                </tr>
                <tr>
                    <td>Tempat&nbsp;Lahir&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=($pelamar->getField("TEMPAT_LAHIR"))?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Tanggal&nbsp;Lahir&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=getFormattedDateDMY($pelamar->getField("TANGGAL_LAHIR"))?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Jenis&nbsp;Kelamin&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=strtoupper($pelamar->getField("JENIS_KELAMIN_KET"))?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>Pendidikan&nbsp;Terakhir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>:</td>
                    <td><?=$pelamar->getField("PENDIDIKAN_TERAKHIR")?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Tanda&nbsp;tangan&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                  <td></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4" style="padding: 0 0;">
                    <table class="area-ttd">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                  </td>
                </tr>
            </table>
		</div>
    </div>
	<input type="button" onclick="print();" value="Cetak" />
</div>

<script type="text/javascript" src="libraries/jquery-qrcode-master/jquery.qrcode.min.js"></script>
<script>
jQuery(function(){
	jQuery('#output').qrcode("{{ asset('/') }}informasi/index/<?=md5($reqId.$reqNIK)?>");
})
</script>

<script type="text/javascript">
    function print_files(){
        
    }

    function printDiv() {
        var divName="printableArea";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>


