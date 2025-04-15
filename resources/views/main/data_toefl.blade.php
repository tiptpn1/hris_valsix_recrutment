<?


use App\Models\Pelamar;
use App\Models\PelamarToefl;



$pelamar = new Pelamar();
$pelamar_toefl = new PelamarToefl();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId = request()->reqRowId;

$pelamar_toefl->selectByParams(array('PELAMAR_TOEFL_ID' => $reqId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_toefl->firstRow();
// echo $pelamar_toefl->query;

$reqPegawaiToeflId = $pelamar_toefl->getField("PELAMAR_TOEFL_ID");
$reqNama = $pelamar_toefl->getField("NAMA");
$reqSertifikat = $pelamar_toefl->getField("SERTIFIKAT_ID");
$reqTanggal = dateToPageCheck($pelamar_toefl->getField("TANGGAL"));
$reqKeterangan = $pelamar_toefl->getField("KETERANGAN");
$reqNilai = $pelamar_toefl->getField("NILAI");
$reqLampiran = $pelamar_toefl->getField("LAMPIRAN");
$reqInfoSkor = "(" . $pelamar_toefl->getField("SKOR_MINIMAL") . " - " . $pelamar_toefl->getField("SKOR_MAKSIMAL") . ")";

$reqRowId = $reqPegawaiToeflId;

$pelamar_toefl->selectByParams(array("PELAMAR_ID" => (int) $auth->userPelamarId));

if ($reqMode == "delete") {
    $set = new PelamarToefl();
    $set->setField('PELAMAR_TOEFL_ID', $reqId);
    if ($set->delete()) {
        echo "<script>document.location.href='app/index/data_toefl';</script>";
    } else {
        echo "<script>document.location.href='app/index/data_toefl';</script>";
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
<script src="libraries/autokomplit/jquery-ui.js"></script>  -->
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        font-size: 11px;
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
<script type="text/javascript" src="libraries/easyui/pluginsbaru/jquery.combo.js"></script><?php */ ?>

<script type="text/javascript">
    $(function() {
        $('#ff').form({
            url: 'data_toefl_add',
            onSubmit: function() {
                if ($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
                    document.location.href = 'app/index/data_lampiran';
                return $(this).form('validate');
            },
            success: function(data) {
                top.loadToefl(data);
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
		};<?php */ ?>

    });
</script>

<!--<div class="col-lg-8">-->
<!-- <div class="col-sm-8 col-sm-pull-4"> -->
<div class="col-md-12">

    <div id="entri">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table>

                <tr>
                    <td>Sertifikat</td>
                    <td>
                        <input id="reqSertifikat" name="reqSertifikat" size="40" required class="easyui-combotree" data-options="
                        editable:false,
                        valueField: 'id', textField: 'text',
                        url: 'combo_json/toefl',
                        onSelect: function(rec){
                            $('#skorInfo').text(rec.SKOR);
                        }
                        " value="<?= $reqSertifikat ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Lembaga</td>
                    <td>
                        <input id="reqKeterangan" name="reqKeterangan" type="text" class="easyui-validatebox" style="width:100%" value="<?= $reqKeterangan ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Sertifikasi</td>
                    <td>
                        <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?= $reqTanggal ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Score <span id="skorInfo"><?= $reqInfoSkor ?></span></td>
                    <td>
                        <input name="reqNilai" id="reqNilai" class="easyui-validatebox" size="10" type="text" value="<?= $reqNilai ?>" onKeyUp="CekNumber('reqNilai');" maxlength="3" />
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
                <? if ($reqRowId == '') {
                    $reqMode = 'insert';
                } else {
                    $reqMode = 'update';
                } ?>
                <input type="hidden" name="reqRowId" value="<?= $reqRowId ?>">
                <input type="hidden" name="reqId" value="<?= $reqId ?>">
                <input type="hidden" name="reqMode" value="<?= $reqMode ?>">
                <input id="reqSubmit" type="submit" value="Submit">
            </div>
            @csrf  
        </form>
        <input type="hidden" id="reqFlagSelanjutnya" value="">
    </div>

</div>