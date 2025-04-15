<?


use App\Models\Pelamar;
use App\Models\PelamarSertifikat;



$pelamar = new Pelamar();
$pelamar_sertifikat = new PelamarSertifikat();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= request()->reqRowId;

$pelamar_sertifikat->selectByParams(array('PELAMAR_SERTIFIKAT_ID'=>$reqId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_sertifikat->firstRow();
//echo $pelamar_sertifikat->query;

$tempPegawaiSertifikatId = $pelamar_sertifikat->getField("PELAMAR_SERTIFIKAT_ID");
$tempNama = $pelamar_sertifikat->getField("NAMA");
$tempTanggalTerbit = dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_TERBIT"));
$tempTanggalKadaluarsa = dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_KADALUARSA"));
$tempGroupSertifikat = $pelamar_sertifikat->getField("GROUP_SERTIFIKAT");
$tempKeterangan = $pelamar_sertifikat->getField("KETERANGAN");
$tempSertifikatId = $pelamar_sertifikat->getField("SERTIFIKAT_ID");
$reqLampiran = $pelamar_sertifikat->getField("LAMPIRAN");


$tempRowId = $tempPegawaiSertifikatId;

$pelamar_sertifikat->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if($reqMode == "delete")
{
	$set= new PelamarSertifikat();
	$set->setField('PELAMAR_SERTIFIKAT_ID', $reqId);
	if($set->delete())
	{
		echo "<script>document.location.href='app/index/data_sertifikat';</script>";
	}
	else
	{
		echo "<script>document.location.href='app/index/data_sertifikat';</script>";
	}
}

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<!-- AUTO KOMPLIT -->
<!--<link rel="stylesheet" href="libraries/autokomplit/jquery-ui.css">
<script src="libraries/autokomplit/jquery-ui.js"></script> -->
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        font-size:11px;
        overflow-x: hidden;
    }
    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    * html .ui-autocomplete {
        height: 200px;
    }
</style>

<!-- AUTO KOMPLIT -->
<?php /*?><script type="text/javascript" src="libraries/easyui/easyloader.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.form.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.linkbutton.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.draggable.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.resizable.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.panel.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.window.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.progressbar.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.messager.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.tooltip.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.validatebox.js"></script>
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.combo.js"></script><?php */?>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'data_sertifikat_add',
			onSubmit:function(){
				if($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
					document.location.href = 'app/index/data_keluarga';
				return $(this).form('validate');
			},
			success:function(data){
				top.loadSertifikat(data);
			}
		});

		<?php /*?>$('#reqNama').autocomplete({
			source:function(request, response){
				var id= this.element.attr('id');
				var field= "";


				$.ajax({
					url: "../json/sertifikat_auto_combo_json.php",
					type: "GET",
					dataType: "json",
					data: { term: request.term },
					success: function(responseData){
						if(responseData == null)
						{
							response(null);
						}
						else
						{
							var array = responseData.map(function(element) {
								return {id: element['id'], label: element['label']};
							});
							response(array);
						}
					}
				})
			},
			select: function (event, ui)
			{
				$("#reqSertifikatId").val(ui.item.id);
			},
			autoFocus: true
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
			return $( "<li>" )
		  .append( "<a>" + item.label + "</a>" )
		  .appendTo( ul );
		};<?php */?>

	});

</script>

<!--<div class="col-lg-8">-->
<!-- <div class="col-sm-8 col-sm-pull-4"> -->
<div class="col-md-12">

    <div id="entri">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table>

                <tr>
                    <td>Nama Sertifikat</td>
                    <td>
                		<!-- <input type="hidden" id="reqSertifikatId" name="reqSertifikatId" value="<?=$tempSertifikatId?>" /> -->
                        <input id="reqNama" name="reqNama" type="text" class="easyui-validatebox" style="width:80%"  required value="<?=$tempNama?>" />
                    </td>
                </tr>

                <tr>
                    <td>Jenis Sertifikat</td>
                    <td colspan="3">
                        <input id="reqSertifikatId" name="reqSertifikatId" required style="width:250px" class="easyui-combobox" data-options="
                        filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                        url: 'combo_json/sertifikat',
                        method: 'get',
                        valueField:'id',
                        textField:'text',
                        editable:false
                        " value="<?=$tempSertifikatId?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>
                        <input id="reqTanggalTerbit" name="reqTanggalTerbit" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalTerbit?>" required></input>
                    </td>
                </tr>
                <tr>
                    <td>Berlaku s.d</td>
                    <td>
                        <input id="reqTanggalKadaluarsa" name="reqTanggalKadaluarsa" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalKadaluarsa?>"></input> (*jika ada)
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>
                        <input id="reqKeterangan" name="reqKeterangan" type="text" class="easyui-validatebox" style="width:100%" value="<?=$tempKeterangan?>" />
                    </td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>
                        <input type="file" id="reqLampiran" name="reqLampiran" class="easyui-validatebox" value="<?= $reqLampiran ?>" accept=".jpg,.png,.pdf">
                        <?php
                        if ($reqLampiran != '') {
                        ?><a href="<?='uploads/' . $reqLampiran ?>" target="_blank"><i class='fa fa-download' style='color:green'></i> Download</a>
                            <input type="hidden" name="reqLampiranOld" id="reqLampiranOld" value="<?= $reqLampiran ?>" />
                        <?php } ?>
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