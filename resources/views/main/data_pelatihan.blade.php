<?

use App\Models\Pelamar;
use App\Models\PelamarPelatihan;



$pelamar = new Pelamar();
$pelamar_pelatihan = new PelamarPelatihan();

$reqId = request()->reqId;
$reqMode = request()->reqMode;
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId = request()->reqRowId;

$pelamar_pelatihan->selectByParams(array('PELAMAR_PELATIHAN_ID' => $reqId, "PELAMAR_ID" => $auth->userPelamarId));
$pelamar_pelatihan->firstRow();
//echo $pelamar_pelatihan->query;

$tempJenis = $pelamar_pelatihan->getField('JENIS');
$tempJumlah = $pelamar_pelatihan->getField('JUMLAH');
$tempWaktu = $pelamar_pelatihan->getField('WAKTU');
$tempPelatih = $pelamar_pelatihan->getField('PELATIH');
$tempRowId = $pelamar_pelatihan->getField('PELAMAR_PELATIHAN_ID');
$tempTahun = $pelamar_pelatihan->getField('TAHUN');
$reqLampiran = $pelamar_pelatihan->getField('LAMPIRAN');

$pelamar_pelatihan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));

if ($reqMode == "delete") {
    $set = new PelamarPelatihan();
    $set->setField('PELAMAR_PELATIHAN_ID', $reqId);
    if ($set->delete()) {
        echo "<script>document.location.href='app/index/data_pelatihan';</script>";
    } else {
        echo "<script>document.location.href='app/index/data_pelatihan';</script>";
    }
}

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
    $(function() {
        $('#ff').form({
            url: 'data_pelatihan_add',
            onSubmit: function() {
                if ($(this).form('validate') == false && $("#reqFlagSelanjutnya").val() == "1")
                    document.location.href = 'app/index/data_pengalaman';
                return $(this).form('validate');
            },
            success: function(data) {
                top.loadPelatihan(data);
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
                    <td>Nama Pelatihan</td>
                    <td>
                        <input id="reqJenis" name="reqJenis" class="easyui-validatebox" style="width:80%" value="<?= $tempJenis ?>" required></input>
                    </td>
                </tr>
                <tr>
                    <td>Lama</td>
                    <td>
                        <input type="text" name="reqWaktu" class="easyui-validatebox" required style="" value="<?= $tempWaktu ?>" /> hari
                    </td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td>
                        <select name="reqTahun" id="reqTahun">
                            <?
                            for ($i = date("Y") - 25; $i < date("Y") + 1; $i++) {
                            ?>
                                <option value="<?= $i ?>" <? if ($i == $tempTahun) echo 'selected' ?>><?= $i ?></option>
                            <?
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Penyelenggara</td>
                    <td>
                        <input id="reqPelatih" name="reqPelatih" class="easyui-validatebox" style="width:50%" value="<?= $tempPelatih ?>"></input>
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
                <? if ($tempRowId == '') {
                    $reqMode = 'insert';
                } else {
                    $reqMode = 'update';
                } ?>
                <input type="hidden" name="reqRowId" value="<?= $tempRowId ?>">
                <input type="hidden" name="reqId" value="<?= $reqId ?>">
                <input type="hidden" name="reqMode" value="<?= $reqMode ?>">
                <input id="reqSubmit" type="submit" value="Submit">
            </div>
            @csrf  
        </form>
        <input type="hidden" id="reqFlagSelanjutnya" value="">
    </div>

</div>