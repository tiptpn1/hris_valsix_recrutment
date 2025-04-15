<?


use App\Models\Pelamar;
use App\Models\Agama;
use App\Models\Bank;
use App\Models\StatusPegawai;
use App\Models\StatusKeluarga;


$this->APP->checkSudahMelamar();


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
$reqAgamaId= $pelamar->getField('AGAMA_ID');
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
$reqStatusPegawai = $pelamar->getField('STATUS_PELAMAR_ID');
$reqStatusKeluarga = $pelamar->getField('STATUS_KELUARGA_ID');
$reqBankId = $pelamar->getField('BANK_ID');
$reqRekeningNo = $pelamar->getField('REKENING_NO');
$reqRekeningNama = $pelamar->getField('REKENING_NAMA');
$reqNPWP = $pelamar->getField('NPWP');
$reqTglPensiun= dateToPageCheck($pelamar->getField('TANGGAL_PENSIUN'));
$reqTglMutasiKeluar= dateToPageCheck($pelamar->getField('TANGGAL_MUTASI_KELUAR'));
$reqTglWafat= dateToPageCheck($pelamar->getField('TANGGAL_WAFAT'));
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
$reqTMTMPP= dateToPageCheck($pelamar->getField('TANGGAL_MPP'));
$reqNoSKMPP= $pelamar->getField('NO_MPP');
$reqTinggi= $pelamar->getField('TINGGI');
$reqBeratBadan= $pelamar->getField('BERAT_BADAN');
$reqNoSepatu= $pelamar->getField('NO_SEPATU');
$reqDomisili= $pelamar->getField('DOMISILI');
$reqKotaId= $pelamar->getField('KOTA_ID');
$reqKota = $pelamar->getField("ALAMAT_KOTA_ID");
$reqProvinsi = $pelamar->getField("ALAMAT_PROVINSI_ID");
$reqKecamatan = $pelamar->getField("ALAMAT_KECAMATAN_ID");
$reqKelurahan = $pelamar->getField("ALAMAT_KELURAHAN_ID");
$reqFacebook	= $pelamar->getField("FACEBOOK");
$reqInstagram 	= $pelamar->getField("INSTAGRAM");
$reqTwitter		= $pelamar->getField("TWITTER");

$reqLampiranTemp= $pelamar->getField('FOTO');
	

$agama->selectByParams();
$bank->selectByParams();
$status_pegawai->selectByParams();
$status_keluarga->selectByParams();
?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
    $.extend($.fn.validatebox.defaults.rules, {
        validTempat:{
            validator: function(value, param){
                
                var reqTempat= "";
                reqTempat= $("#reqTempat").combobox('getValue');
                 if(reqTempat == '' || (typeof reqTempat === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validProvinsi:{
            validator: function(value, param){
                
                var reqProvinsi= "";
                reqProvinsi= $("#reqProvinsi").combobox('getValue');
                 if(reqProvinsi == '' || (typeof reqProvinsi === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validKota:{
            validator: function(value, param){
                
                var reqKota= "";
                reqKota= $("#reqKota").combobox('getValue');
                 if(reqKota == '' || (typeof reqKota === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validKecamatan:{
            validator: function(value, param){
                
                var reqKecamatan= "";
                reqKecamatan= $("#reqKecamatan").combobox('getValue');
                 if(reqKecamatan == '' || (typeof reqKecamatan === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validKelurahan:{
            validator: function(value, param){
                
                var reqKelurahan= "";
                reqKelurahan= $("#reqKelurahan").combobox('getValue');
                 if(reqKelurahan == '' || (typeof reqKelurahan === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        },
        validKotaId:{
            validator: function(value, param){
                
                var reqKotaId= "";
                reqKotaId= $("#reqKotaId").combobox('getValue');
                 if(reqKotaId == '' || (typeof reqKotaId === 'undefined'))
                    return false;
                 else
                    return true;
            },
            message: 'Pilih data sesuai pilihan'
        }
    });
	$(function(){
		$('#ff').form({
			url:'data_pribadi_add',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.alertLink('Info', data, 'info', 'app/index/data_pendidikan_formal');
			}
		});
		
	});
	
</script>

<!-- UPLOAD CORE -->
<script src="libraries/multifile-master/jquery.MultiFile.js"></script>
<script>
	// wait for document to load
	$(function(){
		
		// invoke plugin
		$('#reqLampiran').MultiFile({
		onFileChange: function(){
			console.log(this, arguments);
		}
		});
	
	});
</script>	

<script>

$(document).ready(function() {
    
    
    $('#reqProvinsi').combobox({
        onSelect: function(row){
            var id = row.id;
             $('#reqKota').combobox('reload','combo_json/kota?reqProvinsi='+id);
             $('#reqKota').combobox('setValue', '');
        }
    });

    $('#reqKota').combobox({
        onSelect: function(row){
            var id = row.id;
             $('#reqKecamatan').combobox('reload','combo_json/kecamatan?reqKota='+id);
             $('#reqKecamatan').combobox('setValue', '');
        }
    });

    $('#reqKecamatan').combobox({
        onSelect: function(row){
            var id = row.id;
             $('#reqKelurahan').combobox('reload','combo_json/kelurahan?reqKecamatan='+id);
             $('#reqKelurahan').combobox('setValue', '');
        }
    });
});

</script>

<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

    <div id="judul-halaman">Data Pribadi Steps</div>
    
    <div class="content">
    
    	<!--<form id="example-advanced-form" action="#">-->
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <h3>Data Pribadi</h3>
            <fieldset>
                <div class="sub-judul-halaman"><span>Identitas Pribadi</span></div>
                <table>
                    <tr>
                        <td>No. Registrasi</td>
                        <td>
                            <input type="hidden" name="reqNRPTemp" id="reqNRPTemp" value="<?=$reqNRP?>" >
                            <input name="reqNRP" id="reqNRP" class="easyui-validatebox"  maxlength="30" type="text" value="<?=$reqNRP?>" readonly style="background-color:#EBEBEB" />
                        </td>
                    </tr>
                    <tr>
                        <td>No. NIK</td>
                        <td>
                             <input name="reqKtpNo" class="easyui-validatebox" size="20" maxlength="16" type="text" value="<?=$reqKtpNo?>" readonly  style="background-color:#EBEBEB" /> 
                        </td>
                    </tr> 
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>
                            <input name="reqNama" class="easyui-validatebox" required type="text" value="<?=$reqNama?>" readonly style="width:80%; background-color:#EBEBEB"   />
                        </td>
                    </tr>
                    <tr>        
                        <td>No. Kartu Keluarga</td>
                        <td>
                             <input name="reqKkNo" class="easyui-validatebox" size="20" type="text" maxlength="20" value="<?=$reqKkNo?>" /> 
                        </td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>
                            <select id="reqAgamaId" name="reqAgamaId">
                                <option value="0"></option>
                            <? 
                            while($agama->nextRow())
                            {
                            ?>
                                <option value="<?=$agama->getField('AGAMA_ID')?>" <? if($reqAgamaId == $agama->getField('AGAMA_ID')) echo 'selected';?>><?=$agama->getField('NAMA')?></option>
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
                                <option value="L" <? if($reqJenisKelamin == 'L') echo 'selected';?>>Laki-laki</option>
                                <option value="P" <? if($reqJenisKelamin == 'P') echo 'selected';?>>Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat / Tanggal Lahir</td>
                        <td>
                             <input id="reqTempat" name="reqTempat" size="60" class="easyui-combobox" data-options="
                            filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                            valueField: 'text', textField: 'text',
                            url: 'combo_json/kota', required:true, validType:['validTempat[\'\']']
                            " value="<?=$reqTempat?>" style="width:300px;"/>
                           <!--  <input name="reqTempat" class="easyui-validatebox" required size="20" type="text" value="<?=$reqTempat?>" /> --> / 
                            <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$reqTanggal?>"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>Tinggi / Berat Badan</td>
                        <td>
                            <input name="reqTinggi" id="reqTinggi" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?=$reqTinggi?>" required /> cm / 
                            <input name="reqBeratBadan" id="reqBeratBadan" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?=$reqBeratBadan?>" required /> kg
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat sesuai NIK</td>
                        <td>
                            <input name="reqAlamat" class="easyui-validatebox" required type="text" value="<?=$reqAlamat?>" maxlength="255" style="width:100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>Provinsi</td>
                        <td>
                            <input id="reqProvinsi" class="easyui-combobox" name="reqProvinsi" data-options="panelHeight:'200',url:'combo_json/provinsi', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validProvinsi[\'\']']" style="width:300px;" value="<?=$reqProvinsi?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Kota</td>
                        <td>
                                <input id="reqKota" class="easyui-combobox" name="reqKota" data-options="panelHeight:'200',url:'combo_json/kota?reqProvinsi=<?=$reqProvinsi?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKota[\'\']']" style="width:300px;" value="<?=$reqKota?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td>
                               <input id="reqKecamatan" class="easyui-combobox" name="reqKecamatan" data-options="panelHeight:'200',url:'combo_json/kecamatan?reqKota=<?=$reqKota?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKecamatan[\'\']']" style="width:300px;" value="<?=$reqKecamatan?>" />
                        </td>
                    </tr>
                       <tr>
                        <td>Kelurahan</td>
                        <td>
                               <input id="reqKelurahan" class="easyui-combobox" name="reqKelurahan" data-options="panelHeight:'200',url:'combo_json/kelurahan?reqKecamatan=<?=$reqKecamatan?>', method: 'get', valueField:'id', textField:'text', required:true, validType:['validKelurahan[\'\']']" style="width:300px;" value="<?=$reqKelurahan?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat Domisili</td>
                        <td>
                            <input name="reqAlamatDomisili" class="easyui-validatebox" required type="text" maxlength="255" value="<?=$reqAlamatDomisili?>" style="width:100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>Kota Domisili</td>
                        <td>
                            <input id="reqKotaId" name="reqKotaId" required size="60" class="easyui-combobox" data-options="
                            filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                            valueField: 'id', textField: 'text',
                            url: 'combo_json/kota/combo', required:true, validType:['validKotaId[\'\']']
                            " value="<?=$reqKotaId?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td><input type="text" class="easyui-validatebox" size="30" maxlength="30" name="reqTelepon" id="reqTelepon" value="<?=$reqTelepon?>" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text"  class="easyui-validatebox" data-options="validType:'email'" name="reqEmail" size="30" value="<?=$reqEmail?>" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td>
                            <select name="reqGolDarah">
                                <option value="A" <? if($reqGolDarah == "A") echo 'selected'?>>A</option>
                                <option value="B" <? if($reqGolDarah == "B") echo 'selected'?>>B</option>
                                <option value="AB" <? if($reqGolDarah == "AB") echo 'selected'?>>AB</option>
                                <option value="O" <? if($reqGolDarah == "O") echo 'selected'?>>O</option>
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>Status Nikah</td>
                        <td>
                            <select name="reqStatusPernikahan">
                                <option value="1" <? if($reqStatusPernikahan == "1") echo 'selected'?>>Belum Kawin</option>
                                <option value="2" <? if($reqStatusPernikahan == "2") echo 'selected'?>>Kawin</option>
                                <option value="3" <? if($reqStatusPernikahan == "3") echo 'selected'?>>Janda</option>
                                <option value="4" <? if($reqStatusPernikahan == "4") echo 'selected'?>>Duda</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>NPWP</td>
                        <td>
                             <input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" data-options="validType:'minLength[20]'" maxlength="20" size="20" type="text" value="<?=$reqNPWP?>" onkeydown="return format_npwp(event,'reqNPWP');"/>
                        </td>        
                    </tr>
                    
                    <tr>
                        <td>Tgl Daftar NPWP</td>
                        <td>
                             <input id="reqTanggalNpwp" name="reqTanggalNpwp" class="easyui-datebox" data-options="validType:'date'" value="<?=$reqTanggalNpwp?>"></input>
                        </td>           
                    </tr>
                </table>
                
                <div class="sub-judul-halaman"><span>Social Media</span></div>
                <table>
                    <!--<tr>
                        <td colspan="3">Social Media</td>
                    </tr>-->
                    <tr>
                        <td>Facebook</td> 
                        <td> 
                             <input name="reqFacebook" id="reqFacebook" class="easyui-validatebox" size="30" type="text" value="<?=$reqFacebook?>"/>
                        </td>        
                    </tr>
                    <tr>
                        <td>Instagram</td>
                        <td>
                             <input name="reqInstagram" id="reqInstagram" class="easyui-validatebox" size="30" type="text" value="<?=$reqInstagram?>"/>
                        </td>        
                    </tr>
                    <tr>
                        <td>Twitter</td>
                        <td>
                             <input name="reqTwitter" id="reqTwitter" class="easyui-validatebox" size="30" type="text" value="<?=$reqTwitter?>"/>
                        </td>        
                    </tr>
                    
                </table>    
                <?php /*?><br>   
                <div>
                    <input type="hidden" name="reqLampiranTemp" value="<?=$reqLampiranTemp?>">
                    <input type="submit" value="Submit">
                </div><?php */?>
            </fieldset>
         
            <h3>Data Pendidikan Formal</h3>
            <fieldset>
                <legend>Data Pendidikan Formal</legend>
                Hai
            </fieldset>
         	
            <h3>Data Pelatihan</h3>
            <fieldset>
                <legend>Data Pelatihan</legend>
                Hai
            </fieldset>
         	
            <h3>Data Pengalaman</h3>
            <fieldset>
                <legend>Data Pengalaman</legend>
                Hai
            </fieldset>
         	
            <h3>Data Sertifikat</h3>
            <fieldset>
                <legend>Data Sertifikat</legend>
                Hai
            </fieldset>
         	
            <h3>Data Keluarga</h3>
            <fieldset>
                <legend>Data Keluarga</legend>
                Hai
            </fieldset>
         	
            <h3>Data Surat Izin Mengemudi</h3>
            <fieldset>
                <legend>Data Surat Izin Mengemudi</legend>
                Hai
            </fieldset>
         	
            <h3>Data Kemampuan Bahasa</h3>
            <fieldset>
                <legend>Data Kemampuan Bahasa</legend>
                Hai
            </fieldset>
         	
            <h3>Data Lampiran </h3>
            <fieldset>
                <legend>Profile Information</legend>
                Hai
            </fieldset>
         	
            <!--<h3>Warning</h3>
            <fieldset>
                <legend>You are to young</legend>
         
                <p>Please go away ;-)</p>
            </fieldset>
         
            <h3>Finish</h3>
            <fieldset>
                <legend>Terms and Conditions</legend>
         
                <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
            </fieldset>-->
        </form>

        <!--<script>
            $(function ()
            {
                $("#wizard").steps({
                    headerTag: "h2",
                    bodyTag: "section",
                    transitionEffect: "slideLeft",
                    stepsOrientation: "vertical"
                });
            });
        </script>

        <div id="wizard">
            <h2>First Step</h2>
            <section>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut nulla nunc. Maecenas arcu sem, hendrerit a tempor quis, 
                    sagittis accumsan tellus. In hac habitasse platea dictumst. Donec a semper dui. Nunc eget quam libero. Nam at felis metus. 
                    Nam tellus dolor, tristique ac tempus nec, iaculis quis nisi.</p>
            </section>

            <h2>Second Step</h2>
            <section>
                <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque. 
                    In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum 
                    dictum, nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien a diam adipiscing consectetur. 
                    In euismod augue ullamcorper leo dignissim quis elementum arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Vestibulum leo velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis iaculis nec, malesuada a diam. 
                    Donec non pulvinar urna. Aliquam id velit lacus.</p>
            </section>

            <h2>Third Step</h2>
            <section>
                <p>Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo condimentum dapibus. Fusce eros justo, 
                    pellentesque non euismod ac, rutrum sed quam. Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat. 
                    Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui commodo lectus sollicitudin in auctor mauris 
                    venenatis.</p>
            </section>

            <h2>Forth Step</h2>
            <section>
                <p>Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor. 
                    Quisque sed felis ut mauris feugiat iaculis nec ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae. 
                    Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo tortor.</p>
            </section>
        </div>-->
    </div>
    
    <div id="pendaftaran">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
        <?php /*?><div class="sub-judul-halaman"><span>Identitas Pribadi</span></div>
        <table>
            <tr>
                <td>No. Registrasi</td>
                <td>
                    <input type="hidden" name="reqNRPTemp" id="reqNRPTemp" value="<?=$reqNRP?>" >
                    <input name="reqNRP" id="reqNRP" class="easyui-validatebox"  maxlength="30" type="text" value="<?=$reqNRP?>" readonly style="background-color:#EBEBEB" />
                </td>
            </tr>
            <tr>
                <td>No. NIK</td>
                <td>
                     <input name="reqKtpNo" class="easyui-validatebox" size="20" maxlength="16" type="text" value="<?=$reqKtpNo?>" readonly  style="background-color:#EBEBEB" /> 
                </td>
            </tr> 
            <tr>
                <td>Nama Lengkap</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required type="text" value="<?=$reqNama?>" readonly style="width:80%; background-color:#EBEBEB"   />
                </td>
            </tr>
            <tr>        
                <td>No. Kartu Keluarga</td>
                <td>
                     <input name="reqKkNo" class="easyui-validatebox" size="20" type="text" maxlength="20" value="<?=$reqKkNo?>" /> 
                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>
                    <select id="reqAgamaId" name="reqAgamaId">
                    	<option value="0"></option>
                    <? 
                    while($agama->nextRow())
                    {
                    ?>
                        <option value="<?=$agama->getField('AGAMA_ID')?>" <? if($reqAgamaId == $agama->getField('AGAMA_ID')) echo 'selected';?>><?=$agama->getField('NAMA')?></option>
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
                        <option value="L" <? if($reqJenisKelamin == 'L') echo 'selected';?>>Laki-laki</option>
                        <option value="P" <? if($reqJenisKelamin == 'P') echo 'selected';?>>Perempuan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tempat / Tanggal Lahir</td>
                <td>
                     <input id="reqTempat" name="reqTempat" size="60" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'text', textField: 'text',
                    url: 'combo_json/kota', required:true, validType:['validTempat[\'\']']
                    " value="<?=$reqTempat?>" style="width:300px;"/>
                   <!--  <input name="reqTempat" class="easyui-validatebox" required size="20" type="text" value="<?=$reqTempat?>" /> --> / 
                    <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$reqTanggal?>"></input>
                </td>
            </tr>
            <tr>
                <td>Tinggi / Berat Badan</td>
                <td>
                    <input name="reqTinggi" id="reqTinggi" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?=$reqTinggi?>" required /> cm / 
                    <input name="reqBeratBadan" id="reqBeratBadan" class="easyui-validatebox" size="10" maxlength="3" type="text" value="<?=$reqBeratBadan?>" required /> kg
                </td>
            </tr>
            <tr>
                <td>Alamat sesuai NIK</td>
                <td>
                    <input name="reqAlamat" class="easyui-validatebox" required type="text" value="<?=$reqAlamat?>" maxlength="255" style="width:100%" />
                </td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>
                    <input id="reqProvinsi" class="easyui-combobox" name="reqProvinsi" data-options="panelHeight:'200',url:'combo_json/provinsi', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validProvinsi[\'\']']" style="width:300px;" value="<?=$reqProvinsi?>" />
                </td>
            </tr>
            <tr>
                <td>Kota</td>
                <td>
                        <input id="reqKota" class="easyui-combobox" name="reqKota" data-options="panelHeight:'200',url:'combo_json/kota?reqProvinsi=<?=$reqProvinsi?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKota[\'\']']" style="width:300px;" value="<?=$reqKota?>" />
                </td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>
                       <input id="reqKecamatan" class="easyui-combobox" name="reqKecamatan" data-options="panelHeight:'200',url:'combo_json/kecamatan?reqKota=<?=$reqKota?>', method: 'get', valueField:'id',  textField:'text', required:true, validType:['validKecamatan[\'\']']" style="width:300px;" value="<?=$reqKecamatan?>" />
                </td>
            </tr>
               <tr>
                <td>Kelurahan</td>
                <td>
                       <input id="reqKelurahan" class="easyui-combobox" name="reqKelurahan" data-options="panelHeight:'200',url:'combo_json/kelurahan?reqKecamatan=<?=$reqKecamatan?>', method: 'get', valueField:'id', textField:'text', required:true, validType:['validKelurahan[\'\']']" style="width:300px;" value="<?=$reqKelurahan?>" />
                </td>
            </tr>
            <tr>
                <td>Alamat Domisili</td>
                <td>
                    <input name="reqAlamatDomisili" class="easyui-validatebox" required type="text" maxlength="255" value="<?=$reqAlamatDomisili?>" style="width:100%" />
                </td>
            </tr>
            <tr>
                <td>Kota Domisili</td>
                <td>
                    <input id="reqKotaId" name="reqKotaId" required size="60" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: 'combo_json/kota/combo', required:true, validType:['validKotaId[\'\']']
                    " value="<?=$reqKotaId?>"/>
                </td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td><input type="text" class="easyui-validatebox" size="30" maxlength="30" name="reqTelepon" id="reqTelepon" value="<?=$reqTelepon?>" required />
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text"  class="easyui-validatebox" data-options="validType:'email'" name="reqEmail" size="30" value="<?=$reqEmail?>" required />
                </td>
            </tr>
            <tr>
                <td>Golongan Darah</td>
                <td>
                    <select name="reqGolDarah">
                        <option value="A" <? if($reqGolDarah == "A") echo 'selected'?>>A</option>
                        <option value="B" <? if($reqGolDarah == "B") echo 'selected'?>>B</option>
                        <option value="AB" <? if($reqGolDarah == "AB") echo 'selected'?>>AB</option>
                        <option value="O" <? if($reqGolDarah == "O") echo 'selected'?>>O</option>
                    </select>
                </td>
                
            </tr>
            <tr>
                <td>Status Nikah</td>
                <td>
                    <select name="reqStatusPernikahan">
                        <option value="1" <? if($reqStatusPernikahan == "1") echo 'selected'?>>Belum Kawin</option>
                        <option value="2" <? if($reqStatusPernikahan == "2") echo 'selected'?>>Kawin</option>
                        <option value="3" <? if($reqStatusPernikahan == "3") echo 'selected'?>>Janda</option>
                        <option value="4" <? if($reqStatusPernikahan == "4") echo 'selected'?>>Duda</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td>
                     <input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" data-options="validType:'minLength[20]'" maxlength="20" size="20" type="text" value="<?=$reqNPWP?>" onkeydown="return format_npwp(event,'reqNPWP');"/>
                </td>        
            </tr>
            
            <tr>
                <td>Tgl Daftar NPWP</td>
                <td>
                     <input id="reqTanggalNpwp" name="reqTanggalNpwp" class="easyui-datebox" data-options="validType:'date'" value="<?=$reqTanggalNpwp?>"></input>
                </td>           
            </tr>
        </table>
        
        <div class="sub-judul-halaman"><span>Social Media</span></div>
        <table>
            <!--<tr>
            	<td colspan="3">Social Media</td>
            </tr>-->
            <tr>
                <td>Facebook</td> 
                <td> 
                     <input name="reqFacebook" id="reqFacebook" class="easyui-validatebox" size="30" type="text" value="<?=$reqFacebook?>"/>
                </td>        
            </tr>
            <tr>
                <td>Instagram</td>
                <td>
                     <input name="reqInstagram" id="reqInstagram" class="easyui-validatebox" size="30" type="text" value="<?=$reqInstagram?>"/>
                </td>        
            </tr>
            <tr>
                <td>Twitter</td>
                <td>
                     <input name="reqTwitter" id="reqTwitter" class="easyui-validatebox" size="30" type="text" value="<?=$reqTwitter?>"/>
                </td>        
            </tr>
            
        </table>    
        <br>   
        <div>
        	<input type="hidden" name="reqLampiranTemp" value="<?=$reqLampiranTemp?>">
            <input type="submit" value="Submit">
        </div><?php */?>
        </form>
    </div>
    
</div>

<div class="col-md-12">
	<form id="example-advanced-form" action="#">
        <h3>Account</h3>
        <fieldset>
            <legend>Account Information</legend>
     
            <label for="userName-2">User name *</label>
            <input id="userName-2" name="userName" type="text" class="required">
            <label for="password-2">Password *</label>
            <input id="password-2" name="password" type="text" class="required">
            <label for="confirm-2">Confirm Password *</label>
            <input id="confirm-2" name="confirm" type="text" class="required">
            <p>(*) Mandatory</p>
        </fieldset>
     
        <h3>Profile</h3>
        <fieldset>
            <legend>Profile Information</legend>
     
            <label for="name-2">First name *</label>
            <input id="name-2" name="name" type="text" class="required">
            <label for="surname-2">Last name *</label>
            <input id="surname-2" name="surname" type="text" class="required">
            <label for="email-2">Email *</label>
            <input id="email-2" name="email" type="text" class="required email">
            <label for="address-2">Address</label>
            <input id="address-2" name="address" type="text">
            <label for="age-2">Age (The warning step will show up if age is less than 18) *</label>
            <input id="age-2" name="age" type="text" class="required number">
            <p>(*) Mandatory</p>
        </fieldset>
     
        <h3>Warning</h3>
        <fieldset>
            <legend>You are to young</legend>
     
            <p>Please go away ;-)</p>
        </fieldset>
     
        <h3>Finish</h3>
        <fieldset>
            <legend>Terms and Conditions</legend>
     
            <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
        </fieldset>
    </form>

	
</div>

<!-- JQUERY STEP -->
<!--<link rel="stylesheet" href="libraries/jquery-steps-master/demo/css/normalize.css">
<link rel="stylesheet" href="libraries/jquery-steps-master/demo/css/main.css">-->
<link rel="stylesheet" href="libraries/jquery-steps-master/demo/css/jquery.steps.css">
<!--<script src="libraries/jquery-steps-master/lib/modernizr-2.6.2.min.js"></script>
<script src="libraries/jquery-steps-master/lib/jquery-1.9.1.min.js"></script>-->
<script src="libraries/jquery-steps-master/lib/jquery.cookie-1.3.1.js"></script>
<script src="libraries/jquery-steps-master/build/jquery.steps.js"></script>
<script>
//var form = $("#example-advanced-form").show();
var form = $("#ff").show();
 
form.steps({
	stepsOrientation: "vertical",
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            form.steps("previous");
        }
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password-2"
        }
    }
});
</script>

<script>
	var form = $("#example-advanced-form").show();

	form.steps({
		stepsOrientation: "vertical",
		headerTag: "h3",
		bodyTag: "fieldset",
		transitionEffect: "slideLeft",
		onStepChanging: function (event, currentIndex, newIndex)
		{
			// Allways allow previous action even if the current form is not valid!
			if (currentIndex > newIndex)
			{
				return true;
			}
			// Forbid next action on "Warning" step if the user is to young
			if (newIndex === 3 && Number($("#age-2").val()) < 18)
			{
				return false;
			}
			// Needed in some cases if the user went back (clean up)
			if (currentIndex < newIndex)
			{
				// To remove error styles
				form.find(".body:eq(" + newIndex + ") label.error").remove();
				form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
			}
			form.validate().settings.ignore = ":disabled,:hidden";
			return form.valid();
		},
		onStepChanged: function (event, currentIndex, priorIndex)
		{
			// Used to skip the "Warning" step if the user is old enough.
			if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
			{
				form.steps("next");
			}
			// Used to skip the "Warning" step if the user is old enough and wants to the previous step.
			if (currentIndex === 2 && priorIndex === 3)
			{
				form.steps("previous");
			}
		},
		onFinishing: function (event, currentIndex)
		{
			form.validate().settings.ignore = ":disabled";
			return form.valid();
		},
		onFinished: function (event, currentIndex)
		{
			alert("Submitted!");
		}
	}).validate({
		errorPlacement: function errorPlacement(error, element) { element.before(error); },
		rules: {
			confirm: {
				equalTo: "#password-2"
			}
		}
	});
</script>


