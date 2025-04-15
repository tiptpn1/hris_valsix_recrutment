<?

use App\Models\Pelamar;
use App\Models\PelamarKeluarga;
use App\Models\HubunganKeluarga;
use App\Models\Pendidikan;



$pelamar = new Pelamar();
$pelamar_keluarga = new PelamarKeluarga();
$hubungan_keluarga = new HubunganKeluarga();
$pendidikan = new Pendidikan();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= request()->reqRowId;

$pelamar_keluarga->selectByParams(array('PELAMAR_KELUARGA_ID'=>$reqRowId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_keluarga->firstRow();

$tempHubunganKeluargaId = $pelamar_keluarga->getField('HUBUNGAN_KELUARGA_ID');
$tempStatusKawin = $pelamar_keluarga->getField('STATUS_KAWIN');
$tempJenisKelamin = $pelamar_keluarga->getField('JENIS_KELAMIN');
$tempStatusTunjangan = $pelamar_keluarga->getField('STATUS_TUNJANGAN');
$tempNama = $pelamar_keluarga->getField('NAMA');
$tempTanggalWafat = dateToPageCheck($pelamar_keluarga->getField('TANGGAL_WAFAT'));
$tempTanggalLahir = dateToPageCheck($pelamar_keluarga->getField('TANGGAL_LAHIR'));
$tempStatusTanggung = $pelamar_keluarga->getField('STATUS_TANGGUNG');
$tempTempatLahir = $pelamar_keluarga->getField('TEMPAT_LAHIR');
$tempPendidikanId = $pelamar_keluarga->getField('PENDIDIKAN_ID');
$tempPekerjaan = $pelamar_keluarga->getField('PEKERJAAN');
$tempRowId = $pelamar_keluarga->getField('PELAMAR_KELUARGA_ID');
$tempKesehatan = $pelamar_keluarga->getField('KESEHATAN_NO');
$tempKesehatanTanggal = dateToPageCheck($pelamar_keluarga->getField('KESEHATAN_TANGGAL'));
$tempKesehatanFaskes =  $pelamar_keluarga->getField('KESEHATAN_FASKES');
$tempKtpNo =  $pelamar_keluarga->getField('KTP_NO');

$pendidikan->selectByParams();
$hubungan_keluarga->selectByParams();

$tempRowId = $reqRowId;

$pelamar_keluarga->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if($reqMode == "delete")
{
	$set= new PelamarKeluarga();
	$set->setField('PELAMAR_KELUARGA_ID', $reqId);
	if($set->delete())
	{
		echo "<script>document.location.href='index.phpapp/index/data_keluarga';</script>";
	}
	else
	{
		echo "<script>document.location.href='index.phpapp/index/data_keluarga';</script>";
	}
}

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
    $.extend($.fn.validatebox.defaults.rules, {
        validTempatLahir:{
            validator: function(value, param){
                
                var reqTempatLahir= "";
                reqTempatLahir= $("#reqTempatLahir").combobox('getValue');
                 if(reqTempatLahir == '' || (typeof reqTempatLahir === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        }
    });
	$(function(){
		$('#ff').form({
			url:'data_keluarga_add',
			onSubmit:function(){
				if($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
					document.location.href = 'app/index/data_sim';
				return $(this).form('validate');
			},
			success:function(data){
				top.loadKeluarga(data);
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
                    <td>Nama</td>
                    <td>
                        <input name="reqNama" id="reqNama" class="easyui-validatebox" required type="text" value="<?=$tempNama?>" />
                    </td>
                </tr>
                <tr>
                    <td>Tempat / Tanggal Lahir</td>
                    <td>
                        <input id="reqTempatLahir" name="reqTempatLahir" required size="60" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'text', textField: 'text',
                    url: 'combo_json/kota', required:true, validType:['validTempatLahir[\'\']']
                    " value="<?=$tempTempatLahir?>" style="width:300px;"/> 
                        / 
                        <input id="reqTanggalLahir" name="reqTanggalLahir" data-options="validType:'date'" class="easyui-datebox" value="<?=$tempTanggalLahir?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Hubungan Keluarga</td>
                    <td>
                        <select id="reqHubunganKeluargaId" name="reqHubunganKeluargaId" required>
                        <? 
                        while($hubungan_keluarga->nextRow())
                        {
                        ?>
                            <option value="<?=$hubungan_keluarga->getField('HUBUNGAN_KELUARGA_ID')?>" <? if($tempHubunganKeluargaId == $hubungan_keluarga->getField('HUBUNGAN_KELUARGA_ID')) echo 'selected';?>><?=$hubungan_keluarga->getField('NAMA')?></option>
                        <? 
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>
                        <select id="reqJenisKelamin" name="reqJenisKelamin">
                            <option value="L" <? if($tempJenisKelamin == 'L') echo 'selected';?>>L</option>
                            <option value="P" <? if($tempJenisKelamin == 'P') echo 'selected';?>>P</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td colspan="3">
                        <select id="reqPendidikanId" name="reqPendidikanId" required>
                        <option value=""></option>
                        <? 
                        while($pendidikan->nextRow())
                        {
                        ?>
                            <option value="<?=$pendidikan->getField('PENDIDIKAN_ID')?>" <? if($tempPendidikanId == $pendidikan->getField('PENDIDIKAN_ID')) echo 'selected';?>><?=$pendidikan->getField('NAMA')?></option>
                        <? 
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td colspan="3">
                        <input name="reqPekerjaan" id="reqPekerjaan" class="easyui-validatebox" type="text" style="width:80%" value="<?=$tempPekerjaan?>" />
                    </td>
                </tr>
                
            </table>      
            <br>
            <div>
                <? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
                <input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input id="reqSubmit" type="submit" value="Submit">
            </div>
            @csrf  
        </form>
            <input type="hidden" id="reqFlagSelanjutnya" value="">
    </div>
    
</div>