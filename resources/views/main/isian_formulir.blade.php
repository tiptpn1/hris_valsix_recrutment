<?

use App\Models\Pelamar;
use App\Models\Agama;
use App\Models\Bank;
use App\Models\StatusPegawai;
use App\Models\StatusKeluarga;

$pelamar = new Pelamar();
$agama = new Agama();
$bank = new Bank();
$status_pegawai = new StatusPegawai();
$status_keluarga = new StatusKeluarga();

$reqId = request()->reqId;
$reqKelompokPegawai = request()->reqKelompokPegawai;

$reqMode = "update";
$pelamar->selectByParams(array("A.PELAMAR_ID" => $auth->userPelamarId));
$pelamar->firstRow();
/*PELAMAR_ID*/
$reqNPP = $pelamar->getField('NIPP');
$reqNama = $pelamar->getField('NAMA');
$reqJenisKelamin = $pelamar->getField('JENIS_KELAMIN');
$reqAgamaId = $pelamar->getField('AGAMA_ID');
$reqDepartemen = $pelamar->getField('DEPARTEMEN_ID');
$reqNRP = $pelamar->getField('NRP');
$reqTempat = $pelamar->getField('TEMPAT_LAHIR');
$reqTanggal = dateToPageCheck($pelamar->getField('TANGGAL_LAHIR'));
$reqAlamat = $pelamar->getField('ALAMAT');
$reqAlamatDomisili = $pelamar->getField('DOMISILI');
$reqGolDarah = $pelamar->getField('GOLONGAN_DARAH');
$reqStatusPernikahan = $pelamar->getField('STATUS_KAWIN');
$reqEmail = $pelamar->getField('EMAIL');
$reqTelepon = $pelamar->getField('TELEPON');
$reqWhatsapp = $pelamar->getField('WHATSAPP');

if($reqWhatsapp == "")
	$reqWhatsapp = $reqTelepon;


$reqStatusPegawai = $pelamar->getField('STATUS_PELAMAR_ID');
$reqStatusKeluarga = $pelamar->getField('STATUS_KELUARGA_ID');
$reqBankId = $pelamar->getField('BANK_ID');
$reqRekeningNo = $pelamar->getField('REKENING_NO');
$reqRekeningNama = $pelamar->getField('REKENING_NAMA');
$reqNPWP = $pelamar->getField('NPWP');
$reqTglPensiun = dateToPageCheck($pelamar->getField('TANGGAL_PENSIUN'));
$reqTglMutasiKeluar = dateToPageCheck($pelamar->getField('TANGGAL_MUTASI_KELUAR'));
$reqTglWafat = dateToPageCheck($pelamar->getField('TANGGAL_WAFAT'));
$reqJamsostek = $pelamar->getField('JAMSOSTEK_NO');
$reqJamsostekTanggal = dateToPageCheck($pelamar->getField('JAMSOSTEK_TANGGAL'));
$reqKesehatan = $pelamar->getField('KESEHATAN_NO');
$reqKesehatanTanggal = dateToPageCheck($pelamar->getField('KESEHATAN_TANGGAL'));
$reqKesehatanFaskes = $pelamar->getField('KESEHATAN_FASKES');
$reqKkNo = $pelamar->getField('KK_NO');
$reqHobby = $pelamar->getField("HOBBY");
$reqFingerId = $pelamar->getField("FINGER_ID");
$reqTanggalNpwp = dateToPageCheck($pelamar->getField('TANGGAL_NPWP'));
$reqKtpNo = $pelamar->getField('KTP_NO');
$reqTMTNONAKTIF = dateToPageCheck($pelamar->getField('TGL_NON_AKTIF'));
$reqTglKeluar = dateToPageCheck($pelamar->getField('TGL_DIKELUARKAN'));
$reqTglKontrakAkhir = dateToPageCheck($pelamar->getField('TGL_KONTRAK_AKHIR'));
$reqTMTMPP = dateToPageCheck($pelamar->getField('TANGGAL_MPP'));
$reqNoSKMPP = $pelamar->getField('NO_MPP');
$reqTinggi = $pelamar->getField('TINGGI');
$reqBeratBadan = $pelamar->getField('BERAT_BADAN');
$reqNoSepatu = $pelamar->getField('NO_SEPATU');
$reqDomisili = $pelamar->getField('KOTA_ID');
$reqKotaId = $pelamar->getField('KOTA_ID');
$reqKota = $pelamar->getField("ALAMAT_KOTA_ID");
$reqProvinsi = $pelamar->getField("ALAMAT_PROVINSI_ID");
$reqKecamatan = $pelamar->getField("ALAMAT_KECAMATAN_ID");
$reqKelurahan = $pelamar->getField("ALAMAT_KELURAHAN_ID");
$reqFacebook    = $pelamar->getField("FACEBOOK");
$reqInstagram     = $pelamar->getField("INSTAGRAM");
$reqTwitter        = $pelamar->getField("TWITTER");
$reqLinkedin        = $pelamar->getField("LINKEDIN");

$reqLampiranTemp = $pelamar->getField('FOTO');
$reqLampiranCV = $pelamar->getField('LAMPIRAN_CV');
$reqLampiranNOKK = $pelamar->getField('LAMPIRAN_NOKK');
$reqLampiranKTP = $pelamar->getField('LAMPIRAN_KTP');
$reqLampiranFoto = $pelamar->getField('LAMPIRAN_FOTO');
$reqLampiranIjasah = $pelamar->getField('LAMPIRAN_IJASAH');
$reqLampiranTranskrip = $pelamar->getField('LAMPIRAN_TRANSKRIP');
$reqLampiranSKCK = $pelamar->getField('LAMPIRAN_SKCK');
$reqLampiranSKS = $pelamar->getField('LAMPIRAN_SKS');
$reqLampiranSuratLamaran = $pelamar->getField('LAMPIRAN_SURAT_LAMARAN');

$agama->selectByParams();
$bank->selectByParams();
$status_pegawai->selectByParams();
$status_keluarga->selectByParams();
?>


<!-- JQUERY STEP -->
<script src="libraries/jquery.js"></script>
<script src="libraries/jquery-steps/step.js"></script>
<link href="libraries/jquery-steps/step.css" rel="stylesheet">
<script>
    $(function() {

        var form = $("#example-form").show();
        form.children("div").steps({
            stepsOrientation: "vertical",
            headerTag: "h3",
            bodyTag: "section",
            <?
            $pelamar_entrian = new Pelamar();
            $entrianTerakhir = ($pelamar_entrian->getDaftarEntrianTerakhir(array("A.PELAMAR_ID" => $auth->userPelamarId))) - 1;
            ?>
            startIndex: <?= $entrianTerakhir ?>,
            transitionEffect: "slideLeft",
            onStepChanging: function(event, currentIndex, newIndex) {
                window.scroll(0, 0);

                if (newIndex < currentIndex)
                    return true;

                if (currentIndex == 0) {
                    if ($(this).form('validate')) {
                        $("#btnDataPribadi").click();
                    }
                    else
                    {
                        $.messager.alert('Info', "Pastikan anda telah melengkapi Isian Data Pribadi.", 'warning');
                    }

                    return ($(this).form('validate'));
                } 
                else if (currentIndex == 1) 
                {
                    if ($("#reqDataPendidikan").val() == "") 
                        return false;
                    else
                        return true;
                } 
                else 
                {
                    return form.valid();
                }


            },
            onFinishing: function(event, currentIndex) {
               
                if ($("#reqLampiranSuratLamaranData").val() == "") 
                    return false;
                if ($("#reqLampiranCVData").val() == "") 
                    return false;
                // if ($("#reqLampiranSKCKData").val() == "") 
                //     return false;
                // if ($("#reqLampiranSKSData").val() == "") 
                //     return false;
                form.validate().settings.ignore = ":disabled";

                console.log(form.valid());

                return form.valid();
            },
            onFinished: function(event, currentIndex) {
               
                var win = $.messager.progress({
                    title: '<?=config("app.nama_aplikasi")?> | <?=config("app.nama_perusahaan_singkat")?>',
                    msg: 'Registrasi formulir...'
                });
                $.post("verifikasi_isian_formulir", {
                        _token: "{{ csrf_token() }}"
                    })
                    .done(function(data) {
                        var obj = JSON.parse(data);
                        if (obj.VALIDASI == "1") {
                            $.messager.progress('close');
                            document.location.href = "app/index/daftar_lowongan";
                        } else {
                            $.messager.progress('close');
                            $.messager.alert('Info', obj.PESAN, 'info');
                        }
                    });

            }
        });


    });
</script>

<style>
    .wizard {
        position: relative;
        padding-top: 70px;
        margin-top: -70px;
    }

    .wizard .actions {
        position: absolute;
        top: -20px;
        right: 0;
    }
</style>
<style>

</style>


<div class="col-md-12">

    <div id="judul-halaman">Isian Formulir</div>
    <div id="pendaftaran">
        <form id="example-form" method="post" novalidate enctype="multipart/form-data">
            <div>
                <h3>Data Pribadi</h3>
                <section>
                    <div class="sub-judul-halaman"><span>Identitas Pribadi</span></div>
                    <table>
                        <tr>
                            <td>No. Registrasi</td>
                            <td colspan="2">
                                <input type="hidden" name="reqNRPTemp" id="reqNRPTemp" value="<?= $reqNRP ?>">
                                <input name="reqNRP" id="reqNRP" class="easyui-validatebox" maxlength="30" type="text" value="<?= $reqNRP ?>" readonly style="background-color:#EBEBEB" />
                            </td>
                        </tr>
                        <tr>
                            <td>No. NIK</td>
                            <td colspan="2">
                                <input name="reqKtpNo" class="easyui-validatebox" size="20" maxlength="16" type="text" value="<?= $reqKtpNo ?>" readonly style="background-color:#EBEBEB" />
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td colspan="2">
                                <input name="reqNama" class="easyui-validatebox" required type="text" value="<?= $reqNama ?>" readonly style="width:80%; background-color:#EBEBEB" />
                            </td>
                        </tr>
                        <tr>
                            <td>No. Kartu Keluarga</td>
                            <td colspan="2">
                                <input name="reqKkNo" class="easyui-validatebox" size="20" type="text" maxlength="20" value="<?= $reqKkNo ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td> Fotocopy Kartu Keluarga &nbsp; </td>
                            <td>
                                <div id="reqDivLampiranNOKK">
                                    <span class="btn btn-default btn-file btn-sm" id="browseFileNOKK">
                                            <span id="spanFileNOKK">Browse File <input name="reqLampiranNOKK[]"  accept="jpg,jpeg,png" type="file" class="maxsize-308" id="reqLampiranNOKK" value="" /></span>
                                            <span id="spanInfoNOKK" onClick="ubahNOKK()">Ubah dokumen</span>
                                    </span>
                                    <script>
                                        function ubahNOKK()
                                        {
                                            $('#spanInfoNOKK').hide(); 
                                            $('#spanFileNOKK').show();  
                                            $('#spanFileNOKK').html('Browse File  <input name="reqLampiranNOKK[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranNOKK" value="" />');
                                            $('#reqLampiranNOKK').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "NOKK", "LAMPIRAN_NOKK")
                                                }
                                            });
                                            
                                        }
                                        // wait for document to load
                                        $(function() {
                                            <?
                                            if ($reqLampiranNOKK == "")
                                                $spanHide = "spanInfoNOKK";
                                            else
                                                $spanHide = "spanFileNOKK";
                                            ?>
                                            $("#<?=$spanHide?>").hide();
                                            
                                            // invoke plugin
                                            $('#reqLampiranNOKK').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "NOKK", "LAMPIRAN_NOKK")
                                                }
                                            });
                                        });
                                    </script>
                                    <div id="progressBarNOKK" style="margin-top:10px; display:none">
                                        <div class="progress">
                                            <div class="progress-bar" id="progress-barNOKK" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ol style="list-style:square">
                                    <li>Ukuran maksimum 300KB</li>
                                    <li>file harus (jpg/jpeg/png)</li>
                                </ol>
                            </td>
                            <td style="width:160px"  id="tdFileNOKK">
                                <?
                                if ($reqLampiranNOKK == "") {
                                } else {
                                ?>
                                    <a href="uploads/<?= $reqLampiranNOKK ?>" target="_blank"><i class="fa fa-download"></i>&nbsp;download</a>
                                <?
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Fotocopy KTP &nbsp; </td>
                            <td>
                                <div id="reqDivLampiranKTP">
                                    <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileKTP">
                                        <span class="browse" id="spanFileKTP">Browse File  <input <? if ($reqLampiranKTP == "") { ?> required <? } ?>  name="reqLampiranKTP[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranKTP" value="" /></span>
                                        <span id="spanInfoKTP" onClick="ubahKTP();">Ubah dokumen</span>
                                    </span>
                                    <script>
                                        function ubahKTP()
                                        {
                                            $('#spanInfoKTP').hide(); 
                                            $('#spanFileKTP').show();   
                                            $('#spanFileKTP').html('Browse File  <input name="reqLampiranKTP[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranKTP" value="" />');
                                            $('#reqLampiranKTP').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "KTP", "LAMPIRAN_KTP")
                                                }
                                            });
                                            
                                        }
                                        // wait for document to load
                                        $(function() {
                                            <?
                                            if ($reqLampiranKTP == "")
                                                $spanHide = "spanInfoKTP";
                                            else
                                                $spanHide = "spanFileKTP";
                                            ?>
                                            $("#<?=$spanHide?>").hide();

                                            // invoke plugin
                                            $('#reqLampiranKTP').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "KTP", "LAMPIRAN_KTP")
                                                }
                                            });
                                        });
                                    </script>
                                    <div id="progressBarKTP" style="margin-top:10px; display:none">
                                        <div class="progress">
                                            <div class="progress-bar" id="progress-barKTP" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ol style="list-style:square">
                                    <li>Ukuran maksimum 300KB</li>
                                    <li>file harus (jpg/jpeg/png)</li>
                                </ol>
                            </td>
                            <td id="tdFileKTP">
                                <?
                                if ($reqLampiranKTP == "") {
                                } else {
                                ?>
                                    <a href="uploads/<?= $reqLampiranKTP ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                <?
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Pas Foto ukuran 4x6 Berwarna &nbsp;

                            </td>
                            <td>
                                <div id="reqDivLampiranFoto">
                                    <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileFoto">
                                    
                                        <span class="browse" id="spanFileFoto">Browse File  <input <? if ($reqLampiranFoto == "") { ?> required <? } ?>  name="reqLampiranFoto[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranFoto" value="" /></span>
                                        <span id="spanInfoFoto" onClick="ubahFoto()">Ubah dokumen</span>
                                    </span>
                                    <script>
                                        function ubahFoto()
                                        {
                                            $('#spanInfoFoto').hide(); 
                                            $('#spanFileFoto').show();  
                                            $('#spanFileFoto').html('Browse File  <input name="reqLampiranFoto[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranFoto" value="" />');
                                            $('#reqLampiranFoto').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "Foto", "LAMPIRAN_FOTO")
                                                }
                                            });
                                            
                                        }
                                        // wait for document to load
                                        $(function() {

                                            <?
                                            if ($reqLampiranFoto == "")
                                                $spanHide = "spanInfoFoto";
                                            else
                                                $spanHide = "spanFileFoto";
                                            ?>
                                            $("#<?=$spanHide?>").hide();

                                            // invoke plugin
                                            $('#reqLampiranFoto').MultiFile({
                                                afterFileAppend: function(element, value, master_element) {
                                                    uploadProgress(master_element, "Foto", "LAMPIRAN_FOTO")
                                                }
                                            });
                                        });
                                    </script>
                                    <div id="progressBarFoto" style="margin-top:10px; display:none">
                                        <div class="progress">
                                            <div class="progress-bar" id="progress-barFoto" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ol style="list-style:square">
                                    <li>Ukuran maksimum 300KB</li>
                                    <li>file harus (jpg/jpeg/png)</li>
                                </ol>
                            </td>
                            <td id="tdFileFoto">
                                <?
                                if ($reqLampiranFoto == "") {
                                } else {
                                ?>
                                    <a href="uploads/<?= $reqLampiranFoto ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                <?
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td colspan="2">
                                <select id="reqAgamaId" name="reqAgamaId">
                                    <option value="0"></option>
                                    <?
                                    while ($agama->nextRow()) {
                                    ?>
                                        <option value="<?= $agama->getField('AGAMA_ID') ?>" <? if ($reqAgamaId == $agama->getField('AGAMA_ID')) echo 'selected'; ?>><?= $agama->getField('NAMA') ?></option>
                                    <?
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td colspan="2">
                                <select id="reqJenisKelamin" name="reqJenisKelamin" required>
                                    <option value=""></option>
                                    <option value="L" <? if ($reqJenisKelamin == 'L') echo 'selected'; ?>>Laki-laki</option>
                                    <option value="P" <? if ($reqJenisKelamin == 'P') echo 'selected'; ?>>Perempuan</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kota / Tanggal Lahir</td>
                            <td colspan="2">
                                <input name="reqTempat" id="reqTempat" class="easyui-validatebox" size="20" required value="<?= $reqTempat ?>" />
                                <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?= $reqTanggal ?>"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>Tinggi / Berat Badan</td>
                            <td colspan="2">
                             <input name="reqTinggi" id="reqTinggi" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?= $reqTinggi ?>" required /> cm /
                                <input name="reqBeratBadan" id="reqBeratBadan" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?= $reqBeratBadan ?>" required /> kg
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat sesuai NIK</td>
                            <td colspan="2">
                       <input name="reqAlamat" class="easyui-validatebox" required type="text" value="<?= $reqAlamat ?>" maxlength="255" style="width:100%" />
                            </td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td colspan="2">
                             <input id="reqProvinsi" class="easyui-combobox" name="reqProvinsi" data-options="panelHeight:'200',url:'combo_json/provinsi', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validProvinsi[\'\']']" style="width:300px;" value="<?= $reqProvinsi ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kota</td>
                            <td colspan="2">
                           <input id="reqKota" class="easyui-combobox" name="reqKota" data-options="panelHeight:'200',url:'combo_json/kota?reqProvinsi=<?= $reqProvinsi ?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKota[\'\']']" style="width:300px;" value="<?= $reqKota ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td colspan="2">
                              <input id="reqKecamatan" class="easyui-combobox" name="reqKecamatan" data-options="panelHeight:'200',url:'combo_json/kecamatan?reqKota=<?= $reqKota ?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKecamatan[\'\']']" style="width:300px;" value="<?= $reqKecamatan ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td colspan="2">
                          <input id="reqKelurahan" class="easyui-combobox" name="reqKelurahan" data-options="panelHeight:'200',url:'combo_json/kelurahan?reqKecamatan=<?= $reqKecamatan ?>', method: 'get', valueField:'id', textField:'text', required:true, validType:['validKelurahan[\'\']']" style="width:300px;" value="<?= $reqKelurahan ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat Domisili</td>
                            <td colspan="2">
                              <input name="reqAlamatDomisili" class="easyui-validatebox" required type="text" maxlength="255" value="<?= $reqAlamatDomisili ?>" style="width:100%" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kota Domisili</td>
                            <td colspan="2">
                            <input id="reqDomisili" class="easyui-combobox" name="reqDomisili" data-options="panelHeight:'200',url:'combo_json/kota', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validDomisili[\'\']']" style="width:300px;" value="<?= $reqDomisili ?>" />
                          
                            </td>
                        </tr>
                        <tr>
                            <td>No. Handphone</td>
                            <td><input type="text" class="easyui-validatebox" size="30" maxlength="30" name="reqTelepon" id="reqTelepon" value="<?= $reqTelepon ?>" required />
                            </td>
                        </tr>
                        <tr>
                            <td>No. Whatsapp</td>
                            <td><input type="text" class="easyui-validatebox" size="30" maxlength="30" name="reqWhatsapp" id="reqWhatsapp" value="<?= $reqWhatsapp ?>" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" class="easyui-validatebox" data-options="validType:'email'" name="reqEmail" size="30" value="<?= $reqEmail ?>" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Golongan Darah</td>
                            <td colspan="2">
                                 <select name="reqGolDarah">
                                    <option value="A" <? if ($reqGolDarah == "A") echo 'selected' ?>>A</option>
                                    <option value="B" <? if ($reqGolDarah == "B") echo 'selected' ?>>B</option>
                                    <option value="AB" <? if ($reqGolDarah == "AB") echo 'selected' ?>>AB</option>
                                    <option value="O" <? if ($reqGolDarah == "O") echo 'selected' ?>>O</option>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td>Status Nikah</td>
                            <td colspan="2">
                                 <select name="reqStatusPernikahan">
                                    <option value="1" <? if ($reqStatusPernikahan == "1") echo 'selected' ?>>Belum Kawin</option>
                                    <option value="2" <? if ($reqStatusPernikahan == "2") echo 'selected' ?>>Kawin</option>
                                    <option value="3" <? if ($reqStatusPernikahan == "3") echo 'selected' ?>>Janda</option>
                                    <option value="4" <? if ($reqStatusPernikahan == "4") echo 'selected' ?>>Duda</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td colspan="2">
                             <input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" data-options="validType:'minLength[20]'" maxlength="20" size="20" type="text" value="<?= $reqNPWP ?>" onkeydown="return format_npwp(event,'reqNPWP');" />
                            </td>
                        </tr>

                        <tr>
                            <td>Tgl Daftar NPWP</td>
                            <td colspan="2">
                               <input id="reqTanggalNpwp" name="reqTanggalNpwp" class="easyui-datebox" data-options="validType:'date'" value="<?= $reqTanggalNpwp ?>"></input>
                            </td>
                        </tr>
                    </table>
                    <!-- <div class="sub-judul-halaman"><span>Dokumen</span></div> -->
                    <table>

                    </table>
                    <div class="sub-judul-halaman"><span>Social Media</span></div>
                    <table>
                        <!--<tr>
                            <td colspan="3">Social Media</td>
                        </tr>-->
                        <tr>
                            <td>Facebook</td>
                            <td colspan="2">
                              <input name="reqFacebook" id="reqFacebook" class="easyui-validatebox" size="30" type="text" value="<?= $reqFacebook ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Instagram</td>
                            <td colspan="2">
                            <input name="reqInstagram" id="reqInstagram" class="easyui-validatebox" size="30" type="text" value="<?= $reqInstagram ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td colspan="2">
                              <input name="reqTwitter" id="reqTwitter" class="easyui-validatebox" size="30" type="text" value="<?= $reqTwitter ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>LinkedIn</td>
                            <td colspan="2">
                              <input name="reqLinkedin" id="reqLinkedin" class="easyui-validatebox" size="30" type="text" value="<?= $reqLinkedin ?>" />
                            </td>
                        </tr>
                        

                    </table>
                    <br>
                    <div>
			            @csrf  
                        <input type="hidden" name="reqLampiranTemp" value="<?= $reqLampiranTemp ?>">
                        <input type="submit" value="Submit" id="btnDataPribadi" style="display:none">
                    </div>
                </section>

                <h3>Data Pendidikan Formal</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>
                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Nama Sekolah</th>
                                    <th scope="col">Jurusan</th>
                                    <th scope="col">Nilai/IPK</th>
                                    <th scope="col" style="width:80px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPendidikan">
                                <?
                                use App\Models\PelamarPendidikan;
                                $pelamar_pendidikan = new PelamarPendidikan();
                                $pelamar_pendidikan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                $adaData = "";
                                while ($pelamar_pendidikan->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_pendidikan->getField("PENDIDIKAN_NAMA") ?></td>
                                        <td><?= $pelamar_pendidikan->getField("NAMA") ?></td>
                                        <td><?= $pelamar_pendidikan->getField("JURUSAN") ?></td>
                                        <td><?= $pelamar_pendidikan->getField("IPK") ?></td>
                                        <td>
                                            <a onClick="$('#divPendidikan').show(); $('#framePendidikan').prop('src', 'app/loadEntri/main/data_pendidikan_formal?reqId=<?= $pelamar_pendidikan->getField("PELAMAR_PENDIDIKAN_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodyPendidikan', 'data_pendidikan_formal', '<?= $pelamar_pendidikan->getField("PELAMAR_PENDIDIKAN_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                    $adaData = "1";
                                }
                                if ($adaData == "") {
                                ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center">
                                            Data pendidikan belum dientri.
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                        <div style="display:none">
                         <input type="text"  style="position:absolute; z-index:-1" value="<?= $adaData ?>" id="reqDataPendidikan">
                         </div>
                    </div>
                    <script>
                        function loadPendidikan(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $("#reqDataPendidikan").val("1");
                            $('#divPendidikan').hide();
                            $.get("app/loadUrl/data/data_pendidikan_formal", function(data) {
                                $("#tbodyPendidikan").html(data);
                            });
                        }
                    </script>

                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divPendidikan').show(); $('#framePendidikan').prop('src', 'app/loadEntri/main/data_pendidikan_formal'); ">Tambah Data</button>
                    <div style="display:none" id="divPendidikan">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="framePendidikan" src="" style="width:100%; min-height:852px; border:none; overflow:auto"></iframe>
                        </div>
                    </div>

                </section>


                <h3>Data Pengalaman</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Perusahaan</th>
                                    <th scope="col">Tanggal Masuk</th>
                                    <th scope="col">Durasi (tahun)</th>
                                    <th scope="col">Durasi (bulan)</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPengalaman">
                                <?
                                use App\Models\PelamarPengalaman;
                                $pelamar_pengalaman = new PelamarPengalaman();
                                $pelamar_pengalaman->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                while ($pelamar_pengalaman->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_pengalaman->getField("JABATAN") ?></td>
                                        <td><?= $pelamar_pengalaman->getField("PERUSAHAAN") ?></td>
                                        <td><?= dateToPageCheck($pelamar_pengalaman->getField("TANGGAL_MASUK")) ?></td>
                                        <td><?= $pelamar_pengalaman->getField("TAHUN") ?></td>
                                        <td><?= $pelamar_pengalaman->getField("DURASI") ?></td>
                                        <td>
                                            <a onClick="$('#divPengalaman').show(); $('#framePengalaman').prop('src', 'app/loadEntri/main/data_pengalaman?reqId=<?= $pelamar_pengalaman->getField("PELAMAR_PENGALAMAN_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodyPengalaman', 'data_pengalaman', '<?= $pelamar_pengalaman->getField("PELAMAR_PENGALAMAN_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <script>
                        function loadPengalaman(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divPengalaman').hide();
                            $.get("app/loadUrl/data/data_pengalaman", function(data) {
                                $("#tbodyPengalaman").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divPengalaman').show(); $('#framePengalaman').prop('src', 'app/loadEntri/main/data_pengalaman'); ">Tambah Data</button>
                    <div style="display:none" id="divPengalaman">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="framePengalaman" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>

                </section>


                <h3>Data Sertifikat</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tanggal Terbit</th>
                                    <th scope="col">Tanggal Kadaluarsa</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodySertifikat">
                                <?
                                use App\Models\PelamarSertifikat;
                                $pelamar_sertifikat = new PelamarSertifikat();
                                $pelamar_sertifikat->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                while ($pelamar_sertifikat->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_sertifikat->getField("NAMA") ?></td>
                                        <td><?= dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_TERBIT")) ?></td>
                                        <td><?= dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_KADALUARSA")) ?></td>
                                        <td><?= $pelamar_sertifikat->getField("KETERANGAN") ?></td>
                                        <td>
                                            <a onClick="$('#divSertifikat').show(); $('#frameSertifikat').prop('src', 'app/loadEntri/main/data_sertifikat?reqId=<?= $pelamar_sertifikat->getField("PELAMAR_SERTIFIKAT_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodySertifikat', 'data_sertifikat', '<?= $pelamar_sertifikat->getField("PELAMAR_SERTIFIKAT_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                    <script>
                        function loadSertifikat(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divSertifikat').hide();
                            $.get("app/loadUrl/data/data_sertifikat", function(data) {
                                $("#tbodySertifikat").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divSertifikat').show(); $('#frameSertifikat').prop('src', 'app/loadEntri/main/data_sertifikat'); ">Tambah Data</button>
                    <div style="display:none" id="divSertifikat">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="frameSertifikat" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>

                </section>


                <h3>Data Pelatihan</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Pelatihan</th>
                                    <th scope="col">Lama (hari)</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Penyelenggara</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPelatihan">
                                <?
                                use App\Models\PelamarPelatihan;
                                $pelamar_pelatihan = new PelamarPelatihan();
                                $pelamar_pelatihan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                while ($pelamar_pelatihan->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_pelatihan->getField("JENIS") ?></td>
                                        <td><?= $pelamar_pelatihan->getField("WAKTU") ?></td>
                                        <td><?= $pelamar_pelatihan->getField("TAHUN") ?></td>
                                        <td><?= $pelamar_pelatihan->getField("PELATIH") ?></td>
                                        <td>
                                            <a onClick="$('#divPelatihan').show(); $('#framePelatihan').prop('src', 'app/loadEntri/main/data_pelatihan?reqId=<?= $pelamar_pelatihan->getField("PELAMAR_PELATIHAN_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodyPelatihan', 'data_pelatihan', '<?= $pelamar_pelatihan->getField("PELAMAR_PELATIHAN_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <script>
                        function loadPelatihan(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divPelatihan').hide();
                            $.get("app/loadUrl/data/data_pelatihan", function(data) {
                                $("#tbodyPelatihan").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divPelatihan').show(); $('#framePelatihan').prop('src', 'app/loadEntri/main/data_pelatihan'); ">Tambah Data</button>
                    <div style="display:none" id="divPelatihan">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="framePelatihan" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>

                </section>

                <h3>Data Keluarga</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Hubungan Keluarga</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyKeluarga">

                                <?
                                use App\Models\PelamarKeluarga;
                                $pelamar_keluarga = new PelamarKeluarga();
                                $pelamar_keluarga->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                while ($pelamar_keluarga->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_keluarga->getField("HUBUNGAN_KELUARGA_NAMA") ?></td>
                                        <td><?= $pelamar_keluarga->getField("NAMA") ?></td>
                                        <td><?= $pelamar_keluarga->getField("JENIS_KELAMIN") ?></td>
                                        <td>
                                            <a onClick="$('#divKeluarga').show(); $('#frameKeluarga').prop('src', 'app/loadEntri/main/data_keluarga?reqRowId=<?= $pelamar_keluarga->getField("PELAMAR_KELUARGA_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodyKeluarga', 'data_keluarga', '<?= $pelamar_keluarga->getField("PELAMAR_KELUARGA_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <script>
                        function loadKeluarga(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divKeluarga').hide();
                            $.get("app/loadUrl/data/data_keluarga", function(data) {
                                $("#tbodyKeluarga").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divKeluarga').show(); $('#frameKeluarga').prop('src', 'app/loadEntri/main/data_keluarga'); ">Tambah Data</button>
                    <div style="display:none" id="divKeluarga">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="frameKeluarga" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>

                </section>


                <h3>Data Surat Izin Mengemudi</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Jenis SIM</th>
                                    <th scope="col">No SIM</th>
                                    <th scope="col">Tanggal Kadaluarsa</th>
                                    <th scope="col">Link File</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            <tbody id="tbodySim">
                            <tbody>
                                <?
                                use App\Models\PelamarSim;
                                $pelamar_sim = new PelamarSim();
                                $pelamar_sim->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
                                while ($pelamar_sim->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_sim->getField("KODE_SIM") ?></td>
                                        <td><?= $pelamar_sim->getField("NO_SIM") ?></td>
                                        <td><?= dateToPageCheck($pelamar_sim->getField("TANGGAL_KADALUARSA")) ?></td>
                                        <td>
                                            <?
                                            if ($pelamar_sim->getField("LINK_FILE") == "") {
                                            } else {
                                            ?>
                                                <a href="uploads/sim/<?= $pelamar_sim->getField("LINK_FILE") ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                            <?
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a onClick="$('#divSim').show(); $('#frameSim').prop('src', 'app/loadEntri/main/data_sim?reqId=<?= $pelamar_sim->getField("PELAMAR_SIM_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodySim', 'data_sim', '<?= $pelamar_sim->getField("PELAMAR_SIM_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <script>
                        function loadSim(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divSim').hide();
                            $.get("app/loadUrl/data/data_sim", function(data) {
                                $("#tbodySim").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divSim').show(); $('#frameSim').prop('src', 'app/loadEntri/main/data_sim'); ">Tambah Data</button>
                    <div style="display:none" id="divSim">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="frameSim" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>
                </section>

                <h3>Data Kemampuan Bahasa</h3>
                <section>
                    <div class="judul-halaman"><i class="fa fa-table"></i> Monitoring</div>

                    <div class="data-monitoring">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Sertifikat</th>
                                    <th scope="col">Lembaga</th>
                                    <th scope="col">Tanggal Test</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyToefl">
                                <?
                                use App\Models\PelamarToefl;
                                $pelamar_toefl = new PelamarToefl();
                                $pelamar_toefl->selectByParams(array("PELAMAR_ID" => (int) $auth->userPelamarId));
                                while ($pelamar_toefl->nextRow()) {
                                ?>
                                    <tr>
                                        <td><?= $pelamar_toefl->getField("NAMA") ?></td>
                                        <td><?= $pelamar_toefl->getField("KETERANGAN") ?></td>
                                        <td><?= dateToPageCheck($pelamar_toefl->getField("TANGGAL")) ?></td>
                                        <td><?= $pelamar_toefl->getField("NILAI") ?></td>
                                        <td>
                                            <a onClick="$('#divToefl').show(); $('#frameToefl').prop('src', 'app/loadEntri/main/data_toefl?reqId=<?= $pelamar_toefl->getField("PELAMAR_TOEFL_ID") ?>');"><i class="fa fa-pencil"></i></a>&nbsp;
                                            <a onClick="deleteIsian('tbodyToefl', 'data_toefl', '<?= $pelamar_toefl->getField("PELAMAR_TOEFL_ID") ?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <script>
                        function loadToefl(data) {
                            window.scroll(0, 0);
                            $.messager.alert('Info', data, 'info');
                            $('#divToefl').hide();
                            $.get("app/loadUrl/data/data_toefl", function(data) {
                                $("#tbodyToefl").html(data);
                            });
                        }
                    </script>
                    <button class="btn btn-primary tambah-data-pendidikan-formal" onClick="$('#divToefl').show(); $('#frameToefl').prop('src', 'app/loadEntri/main/data_toefl'); ">Tambah Data</button>
                    <div style="display:none" id="divToefl">
                        <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
                        <div id="pendaftaran" class="input-form-pendidikan">
                            <iframe id="frameToefl" src="" style="width:100%; height:502px; border:none; overflow:hidden"></iframe>
                        </div>
                    </div>
                </section>



                <h3>Data Lampiran Lain-lain</h3>
                <section>
                    <div id="judul-halaman">Data Lampiran</div>

                    <div class="data-lampiran">

                        <table>
                            <tr>
                                <td>
                                    Surat Lamaran &nbsp;
                                    <ol style="list-style:square">
                                        <li>Ukuran maksimum 300KB</li>
                                        <li>file harus format gambar (jpg/jpeg/png) atau pdf</li>
                                    </ol>
                                </td>
                                <td>
                                    <div id="reqDivLampiranSuratLamaran">
                                        <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileSuratLamaran">
                                        
                                            <span class="browse" id="spanFileSuratLamaran">Browse File  <input <? if ($reqLampiranSuratLamaran == "") { ?>  <? } ?>  name="reqLampiranSuratLamaran[]" accept="jpg,jpeg,png,pdf" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranSuratLamaran" value="" /></span>
                                            <span id="spanInfoSuratLamaran" onClick="ubahSuratLamaran()">Ubah dokumen</span>
                                            <div style="display:none">
                                            <input type="text" value="<?= $reqLampiranSuratLamaran ?>" id="reqLampiranSuratLamaranData">
                                            </div>
                                        </span>
                                        <script>
                                            function ubahSuratLamaran()
                                            {
                                                $('#spanInfoSuratLamaran').hide(); 
                                                $('#spanFileSuratLamaran').show();  
                                                $('#spanFileSuratLamaran').html('Browse File  <input name="reqLampiranSuratLamaran[]" accept="jpg,jpeg,png,pdf" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranSuratLamaran" value="" />');
                                                $('#reqLampiranSuratLamaran').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SuratLamaran", "LAMPIRAN_SURAT_LAMARAN")
                                                    }
                                                });
                                                
                                            }
                                            // wait for document to load
                                            $(function() {

                                                <?
                                                if ($reqLampiranSuratLamaran == "")
                                                    $spanHide = "spanInfoSuratLamaran";
                                                else
                                                    $spanHide = "spanFileSuratLamaran";
                                                ?>
                                                $("#<?=$spanHide?>").hide();
                                                // invoke plugin
                                                $('#reqLampiranSuratLamaran').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SuratLamaran", "LAMPIRAN_SURAT_LAMARAN");
                                                        $("#reqLampiranSuratLamaranData").val("1");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div id="progressBarSuratLamaran" style="margin-top:10px; display:none">
                                            <div class="progress">
                                                <div class="progress-bar" id="progress-barSuratLamaran" role="progressbar">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                                </td>
                                </td>
                                <td id="tdFileSuratLamaran">
                                    <?
                                    if ($reqLampiranSuratLamaran == "") {
                                    } else {
                                    ?>
                                        <a href="uploads/<?= $reqLampiranSuratLamaran ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                    <?
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Daftar riwayat hidup (CV) &nbsp;
                                    <ol style="list-style:square">
                                        <li>Ukuran maksimum 300KB</li>
                                        <li>file harus format gambar (jpg/jpeg/png) atau pdf</li>
                                    </ol>
                                </td>
                                <td>
                                    <div id="reqDivLampiranCV">
                                        <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileCV">
                                            <span class="browse" id="spanFileCV">Browse File  <input <? if ($reqLampiranCV == "") { ?>  <? } ?>  name="reqLampiranCV[]" accept="jpg,jpeg,png,pdf" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranCV" value="" /></span>
                                            <span id="spanInfoCV" onClick="ubahCV()">Ubah dokumen</span>
                                            <div style="display:none">
                                            <input type="text" value="<?= $reqLampiranCV ?>" id="reqLampiranCVData">
                                            </div>
                                        </span>
                                        <script>
                                            function ubahCV()
                                            {
                                                $('#spanInfoCV').hide(); 
                                                $('#spanFileCV').show();    
                                                $('#spanFileCV').html('Browse File  <input name="reqLampiranCV[]" accept="jpg,jpeg,png,pdf" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranCV" value="" />');
                                                $('#reqLampiranCV').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "CV", "LAMPIRAN_CV")
                                                    }
                                                });
                                                
                                            }
                                            // wait for document to load
                                            $(function() {

                                                <?
                                                if ($reqLampiranCV == "")
                                                    $spanHide = "spanInfoCV";
                                                else
                                                    $spanHide = "spanFileCV";
                                                ?>
                                                $("#<?=$spanHide?>").hide();

                                                // invoke plugin
                                                $('#reqLampiranCV').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "CV", "LAMPIRAN_CV");
                                                        $("#reqLampiranCVData").val("1");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div id="progressBarCV" style="margin-top:10px; display:none">
                                            <div class="progress">
                                                <div class="progress-bar" id="progress-barCV" role="progressbar">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                </td>
                                <td id="tdFileCV">
                                    <?
                                    if ($reqLampiranCV == "") {
                                    } else {
                                    ?>
                                        <a href="uploads/<?= $reqLampiranCV ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                    <?
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    SKCK (masih berlaku) &nbsp;
                                    <ol style="list-style:square">
                                        <li>Ukuran maksimum 300KB</li>
                                        <li>file harus (jpg/jpeg/png)</li>
                                    </ol>
                                </td>
                                <td>
                                    <div id="reqDivLampiranSKCK">
                                        <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileSKCK">
                                            <span class="browse" id="spanFileSKCK">Browse File <input <? if ($reqLampiranSKCK == "") { ?>  <? } ?> name="reqLampiranSKCK[]" accept="jpg,jpeg,png" type="file" class="maxsize-308" id="reqLampiranSKCK" value="" /></span>
                                            <span id="spanInfoSKCK" onClick="ubahSKCK()">Ubah dokumen</span>
                                            
                                            <div style="display:none">
                                            <input type="text" value="<?= $reqLampiranSKCK ?>" id="reqLampiranSKCKData">
                                            </div>
                                        </span>
                                    <script>
                                            function ubahSKCK()
                                            {
                                                $('#spanInfoSKCK').hide(); 
                                                $('#spanFileSKCK').show();  
                                                $('#spanFileSKCK').html('Browse File  <input name="reqLampiranSKCK[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranSKCK" value="" />');
                                                $('#reqLampiranSKCK').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SKCK", "LAMPIRAN_SKCK")
                                                    }
                                                });
                                                
                                            }
                                            // wait for document to load
                                            $(function() {

                                                <?
                                                if ($reqLampiranSKCK == "")
                                                    $spanHide = "spanInfoSKCK";
                                                else
                                                    $spanHide = "spanFileSKCK";
                                                ?>
                                                $("#<?=$spanHide?>").hide();

                                                // invoke plugin
                                                $('#reqLampiranSKCK').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SKCK", "LAMPIRAN_SKCK");
                                                        $("#reqLampiranSKCKData").val("1");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div id="progressBarSKCK" style="margin-top:10px; display:none">
                                            <div class="progress">
                                                <div class="progress-bar" id="progress-barSKCK" role="progressbar">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                <td id="tdFileSKCK">
                                    <?
                                    if ($reqLampiranSKCK == "") {
                                    } else {
                                    ?>
                                        <a href="uploads/<?= $reqLampiranSKCK ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                    <?
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Surat Keterangan Sehat &nbsp;
                                    <ol style="list-style:square">
                                        <li>Ukuran maksimum 300KB</li>
                                        <li>file harus (jpg/jpeg/png)</li>
                                    </ol>
                                </td>
                                <td>
                                    <div id="reqDivLampiranSKS">
                                        <span class="btn btn-default btn-file btn-sm btn-required" id="browseFileSKS">
                                            <span class="browse" id="spanFileSKS">Browse File  <input <? if ($reqLampiranSKS == "") { ?>  <? } ?>  name="reqLampiranSKS[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranSKS" value="" /></span>
                                            <span id="spanInfoSKS" onClick="ubahSKS()">Ubah dokumen</span>
                                           
                                            
                                            <div style="display:none">
                                            <input type="text" value="<?= $reqLampiranSKS ?>" id="reqLampiranSKSData">
                                            </div>
                                        </span>
                                        <script>
                                            function ubahSKS()
                                            {
                                                $('#spanInfoSKS').hide(); 
                                                $('#spanFileSKS').show();   
                                                $('#spanFileSKS').html('Browse File  <input name="reqLampiranSKS[]" accept="jpg,jpeg,png" type="file" class="easyui-validatebox maxsize-308" id="reqLampiranSKS" value="" />');
                                                $('#reqLampiranSKS').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SKS", "LAMPIRAN_SKS")
                                                    }
                                                });
                                                
                                            }
                                            // wait for document to load
                                            $(function() {

                                                <?
                                                if ($reqLampiranSKS == "")
                                                    $spanHide = "spanInfoSKS";
                                                else
                                                    $spanHide = "spanFileSKS";
                                                ?>
                                                $("#<?=$spanHide?>").hide();
                                                // invoke plugin
                                                $('#reqLampiranSKS').MultiFile({
                                                    afterFileAppend: function(element, value, master_element) {
                                                        uploadProgress(master_element, "SKS", "LAMPIRAN_SKS");
                                                        $("#reqLampiranSKSData").val("1");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div id="progressBarSKS" style="margin-top:10px; display:none">
                                            <div class="progress">
                                                <div class="progress-bar" id="progress-barSKS" role="progressbar">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                <td id="tdFileSKS">
                                    <?
                                    if ($reqLampiranSKS == "") {
                                    } else {
                                    ?>
                                        <a href="uploads/<?= $reqLampiranSKS ?>" target="_blank"><i class="fa fa-download"></i> download</a>
                                    <?
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="spanItalicKpk">Keterangan: </span>
                                    <br /><i>Harus diisi</i>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

                        <br>
                        <div>
                            <input name="reqNamaDokumen" id="reqNamaDokumen" type="hidden" value="" />
                            <input name="reqNamaLampiran" id="reqNamaLampiran" type="hidden" value="" />
                            <input id="btnSimpan" type="submit" value="Submit" style="display:none">
                        </div>

                        <form id="ss" method="post" novalidate enctype="multipart/form-data">
                            <input name="reqNamaDokumen" id="reqNamaDokumen" type="hidden" value="" />
                            <input name="reqNamaLampiran" id="reqNamaLampiran" type="hidden" value="" />
                            <input id="btnSimpan" type="submit" value="Submit" style="display:none">
                        </form>

                    </div>

                    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
                    <?php /*?><div class="area-data-lampiran">
                        <div class="item">
                            Surat Lamaran
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Daftar riwayat hidup (CV)
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Pas Foto ukuran 4x6 Berwarna
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Fotocopy Ijazah terakhir
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Transkrip Nilai/ SKHU
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            SKCK (masih berlaku)
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Surat Keterangan Sehat
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                        <div class="item">
                            Fotocopy KTP
                            <input type="file" multiple class="multi" multiple="multiple" />
                        </div>
                    </div><?php */ ?>

                    <!--/ MULTIFILE -->
                    <!--// plugin-specific resources //-->
                    <script src="libraries/multifile/docs/jquery.form.js" type="text/javascript" language="javascript"></script>
                    <script src="libraries/multifile/docs/jquery.MetaData.js" type="text/javascript" language="javascript"></script>
                    <script src="libraries/multifile/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>


                </section>

            </div>
        </form>
    </div>
</div>

<!-- EASYUI -->
<!--<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script>
    $(function() {
        $('#example-form').form({
            url: 'data_pribadi_add',
            onSubmit: function() {

                return $(this).form('validate');
            },
            success: function(data) {}
        });

    });
</script>