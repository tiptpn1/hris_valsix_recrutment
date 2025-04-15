<?


use App\Models\Pelamar;
use App\Models\PelamarPengalaman;



$pelamar = new Pelamar();
$pelamar_pengalaman = new PelamarPengalaman();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= request()->reqRowId;

$pelamar_pengalaman->selectByParams(array('PELAMAR_PENGALAMAN_ID'=>$reqId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_pengalaman->firstRow();
//echo $pelamar_pengalaman->query;

$reqPelindoGroup = $pelamar_pengalaman->getField('STATUS_GROUP');
$reqPerusahaan = $pelamar_pengalaman->getField('PERUSAHAAN');
$reqDurasi = $pelamar_pengalaman->getField('DURASI');
$reqTahun = $pelamar_pengalaman->getField('TAHUN');
$reqJabatan = $pelamar_pengalaman->getField('JABATAN');
$reqTanggalMasuk = dateToPageCheck($pelamar_pengalaman->getField('TANGGAL_MASUK'));
$reqTanggalKeluar = dateToPageCheck($pelamar_pengalaman->getField('TANGGAL_KELUAR'));
$reqLampiran = $pelamar_pengalaman->getField('LAMPIRAN');
$reqRowId = $pelamar_pengalaman->getField('PELAMAR_PENGALAMAN_ID');

$PRESTASI = $pelamar_pengalaman->getField('PRESTASI');
$DESKRIPSI = $pelamar_pengalaman->getField('DESKRIPSI');
 


if($reqPelindoGroup == "")
	$reqPelindoGroup = "0";

$pelamar_pengalaman->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if($reqMode == "delete")
{
	$set= new PelamarPengalaman();
	$set->setField('PELAMAR_PENGALAMAN_ID', $reqId);
	if($set->delete())
	{
		echo "<script>document.location.href='app/index/data_pengalaman';</script>";
	}
	else
	{
		echo "<script>document.location.href='app/index/data_pengalaman';</script>";
	}
}

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'data_pengalaman_add',
			onSubmit:function(){
				if($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
					document.location.href = 'app/index/data_sertifikat';
				return $(this).form('validate');
			},
			success:function(data){
				top.loadPengalaman(data);
			}
		});

	});

</script>

<!--<div class="col-lg-8">-->
<!-- <div class="col-sm-8 col-sm-pull-4"> -->
<div class="col-md-12">

    <div id="entri">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Jabatan</td>
                    <td>
                        <input id="reqJabatan" name="reqJabatan" type="text" class="easyui-validatebox" style="width:80%" value="<?=$reqJabatan?>" required />
                    </td>
                </tr>
                <tr>
                    <td>Perusahaan</td>
                    <td>
                        <input id="reqPerusahaan" name="reqPerusahaan" class="easyui-validatebox" style="width:100%"   value="<?=$reqPerusahaan?>" required></input>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td>
                        <input id="reqTanggalMasuk" name="reqTanggalMasuk" class="easyui-datebox" data-options="validType:'date'"  value="<?=$reqTanggalMasuk?>" required></input>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Keluar</td>
                    <td>
                        <input id="reqTanggalKeluar" name="reqTanggalKeluar" class="easyui-datebox" data-options="validType:'date'"  value="<?=$reqTanggalKeluar?>" ></input>
                    </td>
                </tr>
                <tr>
                    <td>Deskripsi Tugas</td>
                    <td>
                        <textarea id="DESKRIPSI" name="DESKRIPSI" class="easyui-validatebox text textbox" style="width: 100%;" ><?=$DESKRIPSI?></textarea> 
                    </td>
                </tr>
                <tr>
                    <td>Prestasi</td>
                    <td>
                        <textarea id="PRESTASI" name="PRESTASI" class="easyui-validatebox text textbox" style="width: 100%;"><?=$PRESTASI?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Data Pengalaman</td>
                    <td>
                        <input type="file" id="reqLampiran" name="reqLampiran" class="easyui-validatebox" accept=".jpg,.png,.pdf"  value="<?=$reqLampiran?>" >
                        <?php
                        if($reqLampiran !=''){
                             ?><a href="<?='uploads/'.$reqLampiran ?>" target="_blank"><i class='fa fa-download' style='color:green'></i> Download</a>
                             <input type="hidden" name="reqLampiranOld" id="reqLampiranOld" value="<?=$reqLampiran?>" />
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <br>
            <div>
                <? if($reqRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
                <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input id="reqSubmit" type="submit" value="Submit">
            </div>
            @csrf  
        </form>
            <input type="hidden" id="reqFlagSelanjutnya" value="">
    </div>

</div>