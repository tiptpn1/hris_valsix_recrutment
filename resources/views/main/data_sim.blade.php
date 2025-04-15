<?


use App\Models\Pelamar;
use App\Models\PelamarSim;
use App\Models\JenisSim;



$pelamar = new Pelamar();
$pelamar_sim = new PelamarSim();
$jenis_sim = new JenisSim();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= request()->reqRowId;

$pelamar_sim->selectByParams(array('PELAMAR_SIM_ID'=>$reqId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_sim->firstRow();
//echo $pelamar_sim->query;

$tempPegawaiSimId = $pelamar_sim->getField("PELAMAR_SIM_ID");
$tempJenisSimId = $pelamar_sim->getField("JENIS_SIM_ID");
$tempKodeSim = $pelamar_sim->getField("KODE_SIM");
$tempNoSim = $pelamar_sim->getField("NO_SIM");
$tempTanggalKadaluarsa = dateToPageCheck($pelamar_sim->getField("TANGGAL_KADALUARSA"));
$tempLinkFile = $pelamar_sim->getField("LINK_FILE");
$tempLinkFileTemp= $pelamar_sim->getField("LINK_FILE");

$tempRowId = $tempPegawaiSimId;

$pelamar_sim->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if($reqMode == "delete")
{
	$set= new PelamarSim();
	$set->setField('PELAMAR_SIM_ID', $reqId);
	if($set->delete())
	{
		echo "<script>document.location.href='app/index/data_sim';</script>";
	}
	else
	{
		echo "<script>document.location.href='app/index/data_sim';</script>";
	}
}

$jenis_sim->selectByParams(array(),-1,-1,"", "ORDER BY NAMA");

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<!-- AUTO KOMPLIT -->
<!--<link rel="stylesheet" href="libraries/autokomplit/jquery-ui.css">
<script src="libraries/autokomplit/jquery-ui.js"></script>  -->
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
			url:'data_sim_add',
			onSubmit:function(){
				if($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
					document.location.href = 'app/index/data_toefl';
				return $(this).form('validate');
			},
			success:function(data){
				top.loadSim(data);
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
                    <td>Jenis SIM</td>
                    <td>
                        <select id="reqJenisSimId" name="reqJenisSimId" required>
                        <? 
                        while($jenis_sim->nextRow())
                        {
                        ?>
                            <option value="<?=$jenis_sim->getField('JENIS_SIM_ID')?>" <? if($tempJenisSimId == $jenis_sim->getField('JENIS_SIM_ID')) echo 'selected';?>><?=$jenis_sim->getField('KODE')?></option>
                        <? 
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nomor SIM</td>
                    <td>
                        <input id="reqNoSim" name="reqNoSim" type="text" class="easyui-validatebox" style="width:50%" value="<?=$tempNoSim?>" onKeyUp="CekNumber('reqNoSim');" required />
                    </td>
                </tr>
                <tr>
                    <td>Berlaku s.d</td>
                    <td>
                        <input id="reqTanggalKadaluarsa" name="reqTanggalKadaluarsa" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalKadaluarsa?>" required ></input>
                    </td>
                </tr>
                <tr>
                    <td>Dokumen</td>
                    <td>
                        <input type="file" style="width:250px" name="reqLinkFile[]" id="reqLinkFile" accept="image/jpeg" />
                        <input type="hidden" name="reqLinkFileTemp" value="<?=$tempLinkFileTemp?>" />
                        <?php
                        if ($tempLinkFileTemp != '') {
                        ?><a href="<?='uploads/sim/' . $tempLinkFileTemp ?>" target="_blank"><i class='fa fa-download' style='color:green'></i> Download</a>
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