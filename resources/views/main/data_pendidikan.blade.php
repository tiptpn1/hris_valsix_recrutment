<?
use App\Models\Pelamar;
use App\Models\PelamarPendidikan;
use App\Models\Universitas;
use App\Models\Pendidikan;
use App\Models\PendidikanBiaya;



$pelamar = new Pelamar();
$pelamar_pendidikan = new PelamarPendidikan();
$universitas = new Universitas();
$pendidikan = new Pendidikan();
$pendidikan_biaya = new PendidikanBiaya();


$reqId = request()->reqId;

$pelamar_pendidikan->selectByParams(array('PELAMAR_PENDIDIKAN_ID' => $reqId, "PELAMAR_ID" => $auth->userPelamarId));
if ($pelamar_pendidikan->firstRow()) {
    $tempPendidikanId = $pelamar_pendidikan->getField('PENDIDIKAN_ID');
    $tempPendidikanBiayaId = $pelamar_pendidikan->getField('PENDIDIKAN_BIAYA_ID');
    $tempNama = $pelamar_pendidikan->getField('NAMA');
    $tempKota = $pelamar_pendidikan->getField('KOTA');
    $tempUniversitasId = $pelamar_pendidikan->getField('UNIVERSITAS_ID');
    $tempTanggalIjasah = dateToPageCheck($pelamar_pendidikan->getField('TANGGAL_IJASAH'));
    $tempLulus = $pelamar_pendidikan->getField('LULUS');
    $tempNo = $pelamar_pendidikan->getField('NO_IJASAH');
    $tempTtdIjazah = $pelamar_pendidikan->getField('TTD_IJASAH');
    $tempJurusan = $pelamar_pendidikan->getField('JURUSAN');
    $tempTanggalAcc = dateToPageCheck($pelamar_pendidikan->getField('TANGGAL_ACC'));
    $tempRowId = $pelamar_pendidikan->getField('PELAMAR_PENDIDIKAN_ID');
    $tempJurusanId = $pelamar_pendidikan->getField('JURUSAN_ID');
    $tempIPK = $pelamar_pendidikan->getField('IPK');
    $tempAkreditasi = $pelamar_pendidikan->getField('JURUSAN_AKREDITASI');
    $reqInstansi = $pelamar_pendidikan->getField('INSTANSI');
    $reqLampiranIjasah = $pelamar_pendidikan->getField('LAMPIRAN_IJASAH');
    $reqLampiranTranskrip = $pelamar_pendidikan->getField('LAMPIRAN_TRANSKRIP');
    $reqIsSuratKeterangan = $pelamar_pendidikan->getField('IS_SURAT_KETERANGAN');
	

    if ($tempJurusan == "")
        $tempJurusan = $tempJurusanId;
} else
    $reqInstansi = "DALAM";

$pendidikan_biaya->selectByParams();
$universitas->selectByParams();
$pendidikan->selectByParams(array(), -1, -1, "", "ORDER BY NAMA");

$pelamar_pendidikan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if ($reqMode == "delete") {
    $set = new PelamarPendidikan();
    $set->setField('PELAMAR_PENDIDIKAN_ID', $reqId);
    if ($set->delete()) {
        $alertMsg .= "Data berhasil dihapus";
        echo "<script>document.location.href='app/index/data_pendidikan_formal';</script>";
    } else {
        $alertMsg .= "Error " . $set->getErrorMsg();
        echo "<script>document.location.href='app/index/data_pendidikan_formal';</script>";
    }
}

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<!-- AUTO KOMPLIT -->
<!--<link rel="stylesheet" href="libraries/autokomplit/jquery-ui.css">-->
<!--<script src="libraries/autokomplit/jquery-ui.js"></script>-->
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


<script type="text/javascript">
    function setValue() {
        $('#reqJurusan').combobox('setValue', '<?= $tempJurusan ?>');
    }
    $.extend($.fn.validatebox.defaults.rules, {
        validUniversitaId: {
            validator: function(value, param) {

                var reqUniversitasId = "";
                reqUniversitasId = $("#reqUniversitasId").combobox('getValue');
                if (reqUniversitasId == '' || (typeof reqUniversitasId === 'undefined'))
                    return false;
                else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validKota: {
            validator: function(value, param) {

                var reqKota = "";
                reqKota = $("#reqKota").combobox('getValue');
                if (reqKota == '' || (typeof reqKota === 'undefined'))
                    return false;
                else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        }
    });
    $(function() {
        $('#ff').form({
            url: 'data_pendidikan_formal_add',
            onSubmit: function() {
                if ($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
                    document.location.href = 'app/index/data_pelatihan';

				$("#reqKotaFree").val($("#reqKota").combobox("getText"));

                return $(this).form('validate');
            },
            success: function(data) {
                
            }
        });

        $('input[name="reqInstansi"]').change(function() {

            var pendidikanId = $("#reqPendidikanId").combotree("getValue");
            if ($('#option-1').prop('checked') && Number(pendidikanId) > 10003) {
                $('#tdNama0').hide();
                $('#tdNama1').show();
                $('#tdJurusan0').hide();
                $('#tdJurusan1').show();
                $('#reqNama0').val('');
                $('#reqNamaInstansi').val('');
                $('#reqNama0').validatebox({
                    required: false
                });
                $('#reqUniversitasId').combobox('setValue', '');
                $('#reqUniversitasId').combobox({
                    required: true
                });
                $('#trAkreditasi').show();
                $('#reqJurusanId').val('');
                $('#reqJurusan0').val('');
                $('#reqNamaJurusan').val('');
                $('#reqJurusanId').combobox('setValue', '');
                $('#reqNama').val('');

                var url = 'universitas_combo_json?reqId=' + rec.id;
                $('#reqUniversitasId').combobox('reload', url);
                $('#reqUniversitasId').combobox('setValue', '');
            } else {
                $('#tdNama0').show();
                $('#tdNama1').hide();
                $('#tdJurusan0').show();
                $('#tdJurusan1').hide();
                $('#reqNama0').val('');
                $('#reqNamaInstansi').val('');
                $('#reqNama0').validatebox({
                    required: true
                });
                $('#reqUniversitasId').combobox('setValue', '');
                $('#reqUniversitasId').combobox({
                    required: false
                });
                $('#trAkreditasi').hide();
                $('#reqJurusanId').val('');
                $('#reqJurusan0').val('');
                $('#reqNamaJurusan').val('');
                $('#reqJurusanId').combobox('setValue', '');
                $('#reqNama').val('');
            }
        });

    });
	
	function setPendidikan(param)
	{
		var url = 'pendidikan_combo_json/combobox?reqId=' + param;
		$('#reqPendidikanId').combotree('reload', url);
	}
</script>

<!--<div class="col-lg-8">-->
<!-- <div class="col-sm-8 col-sm-pull-4"> -->
<div class="col-sm-8 col-sm-pull-4">

<div id="judul-halaman">Data Pendidikan Formal</div>
    
    <div id="pendaftaran">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Instansi</td>
                    <td>
                        <input type="radio" id="option-1" name="reqInstansi" value="DALAM" onClick="setPendidikan('')" <? if ($reqInstansi == "DALAM") { ?> checked <? } ?>> Dalam Negeri
                        <input type="radio" id="option-2" name="reqInstansi" value="LUAR" onClick="setPendidikan('EN')" <? if ($reqInstansi == "LUAR") { ?> checked <? } ?>> Luar Negeri
                    </td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>
                        <input type="text" name="reqPendidikanId" id="reqPendidikanId" class="easyui-combotree" data-options="
                    valueField:'id',
                    textField:'text',
                    url:'combo_json/pendidikan',
                    onSelect: function(rec){
                     	var radioValue = $('input[name=reqInstansi]:checked').val();
                        if(rec.urut > 3 && radioValue == 'DALAM')
                        {
                            $('#tdNama0').hide();
                            $('#tdNama1').show();
                            $('#tdJurusan0').hide();
                            $('#tdJurusan1').show();
                            $('#reqNama0').val('');
                            $('#reqNamaInstansi').val('');
                            $('#reqNama0').validatebox({ required: false });
                            $('#trAkreditasi').show();
                            $('#reqJurusanId').val('');
                            $('#reqJurusan0').val('');
                            $('#reqNamaJurusan').val('');
                            $('#reqJurusanId').combobox('setValue', '');
                            $('#reqNama').val('');

                            var url = 'universitas_combo_json?reqId='+rec.id;
                            $('#reqUniversitasId').combobox('reload', url);
                            $('#reqUniversitasId').combobox('setValue', '');

                        }
                        else
                        {
                            $('#tdNama0').show();
                            $('#tdNama1').hide();
                            $('#tdJurusan0').show();
                            $('#tdJurusan1').hide();
                            $('#reqNama0').val('');
                            $('#reqNamaInstansi').val('');
                            $('#reqNama0').validatebox({ required: true });
                            $('#trAkreditasi').hide();
                            $('#reqJurusanId').val('');
                            $('#reqJurusan0').val('');
                            $('#reqNamaJurusan').val('');
                            $('#reqJurusanId').combobox('setValue', '');
                            $('#reqNama').val('');
                        }
                    }" value="<?= $tempPendidikanId ?>">
                    </td>
                </tr>
                <tr>
                    <td>Nama Instansi</td>
                    <?
                    if ($tempUniversitasId == "") {
                    ?>
                        <td colspan="3" id="tdNama0">
                            <input id="reqNama0" name="reqNama0" class="easyui-validatebox" type="text" value="<?= $tempNama ?>" required style="width: 500px;" />
                        </td>
                    <?
                    }
                    ?>

                    <td colspan="3" id="tdNama1" <? if ($tempUniversitasId != "") {
                                                    } else { ?> style="display: none;" <? } ?>>
                        <input type="text" id="reqNamaInstansi" name="reqNamaInstansi" value="<?= $tempNama ?>">
                    </td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <?
                    if ($tempJurusanId == "") {
                    ?>
                        <td colspan="3" id="tdJurusan0">
                            <input id="reqJurusan0" name="reqJurusan0" class="easyui-validatebox" type="text" value="<?= $tempJurusan ?>" style="width: 500px;" />
                        </td>
                    <?
                    }
                    ?>
                    <td colspan="3" id="tdJurusan1" <? if ($tempJurusanId != "") {
                                                    } else { ?> style="display: none;" <? } ?>>
                        <input type="text" id="reqNamaJurusan" name="reqNamaJurusan" value="<?= $tempJurusan ?>">
                    </td>
                </tr>

                <tr id="trAkreditasi" style="display:none">
                    <td>Akreditasi</td>
                    <td>
                        <input id="reqAkreditasi" name="reqAkreditasi" size="20" maxlength="2" class="easyui-validatebox" value="<?= $tempAkreditasi ?>"  />
                    </td>
                </tr>
                <tr>
                    <td>Kota Instansi</td>
                    <td>
                        <input id="reqKota" name="reqKota" size="60" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'text', textField: 'text',
                    url: 'combo_json/kota'
                    " value="<?= $tempKota ?>" />
                       <input name="reqKotaFree" id="reqKotaFree" class="easyui-validatebox" size="20" type="hidden" value="<?= $tempKota ?>" />

                    </td>
                </tr>
                <tr>
                    <td>Lulus Tahun</td>
                    <td colspan="3">
                        <input name="reqLulus" id="reqLulus" required class="easyui-validatebox" size="4" maxlength="4" type="text" value="<?= $tempLulus ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Ijazah</td>
                    <td>
                        <input id="reqTanggalIjasah" name="reqTanggalIjasah" class="easyui-datebox" data-options="validType:'date'" value="<?= $tempTanggalIjasah ?>">
                    </td>
                </tr>
                <tr>
                    <td>No Ijazah</td>
                    <td colspan="3">
                        <input name="reqNoIjasah" id="reqNoIjasah" class="easyui-validatebox" style="20%" type="text" value="<?= $tempNo ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Nilai / IPK</td>
                    <td colspan="3">
                        <input name="reqIPK" id="reqIPK" class="easyui-validatebox" required size="10" type="text" value="<?= $tempIPK ?>" onKeyUp="CekNumber('reqIPK');" maxlength="6" />
                    </td>
                </tr>
                <tr>
                    <td>Fotocopy Ijazah</td>
                    <td colspan="3">
                        <input type="file" name="reqLampiranIjasah" id="reqLampiranIjasah" class="easyui-validatebox" size="10" value="" accept=".jpg,.png,.pdf" /><?php
                        if($reqLampiranIjasah !=''){
                             ?><a href="<?='uploads/'.$reqLampiranIjasah ?>" target="_blank"><i class='fa fa-download' style='color:green'></i> Download</a>
                             <input type="hidden" name="reqLampiranIjasahOld" id="reqLampiranIjasahOld" value="<?=$reqLampiranIjasah?>" />
                        <?php } ?>

                        <div class="info-lampiran">
                            <input type="checkbox" id="ijazah-belum-keluar" name="reqIsSuratKeterangan" id="reqIsSuratKeterangan" value="Y" <? if($reqIsSuratKeterangan == "Y") { ?> checked <? } ?>>
                            <label for="ijazah-belum-keluar"> - Checklist jika anda melampirkan ijasah sementara/SKL/SKHU</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Fotocopy Transkrip</td>
                    <td colspan="3">
                        <input type="file" name="reqLampiranTranskrip" id="reqLampiranTranskrip" class="easyui-validatebox" size="10" value="" accept=".jpg,.png,.pdf" /><?php
                        if($reqLampiranTranskrip){
                            ?><a href="<?='uploads/'.$reqLampiranTranskrip ?>" target="_blank"><i class='fa fa-download' style='color:green'></i> Download</a>
                            <input type="hidden" name="reqLampiranTranskripOld" id="reqLampiranTranskripOld" value="<?=$reqLampiranTranskrip?>" />
                            <?php } ?>
                    </td>
                </tr>
            </table>
            <br>
            <div>
                <? if ($tempRowId == '') {
                    $reqMode = 'insert';
                } else {
                    $reqMode = 'update';
                } ?>
                <input type="hidden" name="reqRowId" value="<?= $tempRowId ?>">
                <input type="hidden" name="reqId" value="<?= $reqId ?>">
                <input type="hidden" name="reqMode" value="<?= $reqMode ?>">
                <input id="reqSubmit" type="submit" value="Submit">

                
			    @csrf  
            </div>
        </form>
        <input type="hidden" id="reqFlagSelanjutnya" value="">
    </div>

</div>