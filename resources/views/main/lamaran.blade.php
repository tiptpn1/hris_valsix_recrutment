<?


use App\Models\Lowongan;
use App\Models\LowonganDokumen;
use App\Models\LowonganPersyaratan;
use App\Models\Pelamar;
use App\Models\PelamarPendidikan;
use App\Models\PelamarPengalaman;
use App\Models\PelamarToefl;
use App\Models\PelamarSertifikat;
use App\Models\PelamarLowongan;

$reqId= setQuote($reqParse1);


$statement = " AND CURRENT_DATE BETWEEN A.TANGGAL_AWAL AND A.TANGGAL_AKHIR  ";	
$statement .= " AND NOT EXISTS(SELECT 1 FROM PELAMAR_LOWONGAN X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID AND X.PELAMAR_ID = '".$auth->userPelamarId."') ";
	
$lowongan = new Lowongan();
$lowongan->selectByParamsInformasi(array("md5(CONCAT(A.LOWONGAN_ID , 'lowongan' , '$MD5KEY'))" => $reqId, "A.PUBLISH" => "1"), -1, -1, $statement); 
$lowongan->firstRow();

$reqId = $lowongan->getField("LOWONGAN_ID");

if($reqId == "")
{
    $data = [
            "heading" => "Data lowongan tidak dikenali.",
			"auth" => $auth
    ];
    $body = view("konten/data_tidak_dikenali", $data);
    echo $body;
    return;
}


$lowongan_dokumen = new LowonganDokumen();
$ada = $lowongan_dokumen->getCountByParams(array("A.LOWONGAN_ID" => $reqId));

$daftar_entrian = new Pelamar();
$kurang_entri = $daftar_entrian->getCountByParamsDaftarEntrian(array("PELAMAR_ID" => $auth->userPelamarId), " AND WAJIB_ISI = '1' AND ADA = 0 ");

$arrData= array("Saya telah membaca seluruh persyaratan dan ketentuan lowongan yang telah saya pilih.",
"Saya memiliki kompetensi sesuai dengan ketentuan yang telah dipersyaratkan.",
"Saya tidak pernah terlibat masalah narkoba, pidana dan keuangan.",
// "Saya Tidak bertindik dan tidak bertato.",
"Saya akan menyertakan bukti yang diperlukan dari seluruh pernyataan di atas sebagaimana yang dipersyaratkan oleh panitia seleksi.",
"Saya telah memastikan bahwa data yang telah saya unggah sudah benar dan sesuai dengan persyaratan rekrutmen.");

$lowongan_persyaratan = new LowonganPersyaratan();
$lowongan_persyaratan->selectByParams(array("A.LOWONGAN_ID" => $reqId), -1, -1);


// DATA PRIBADI PELAMAR
$pelamar = new Pelamar();
$pelamar->selectByParams(array("A.PELAMAR_ID" => $auth->userPelamarId));
// echo $pelamar->query; exit;
$pelamar->firstRow();
/*PELAMAR_ID*/
$tempJenisKelamin = $pelamar->getField('JENIS_KELAMIN');
$tempTanggal = dateToPageCheck($pelamar->getField('TANGGAL_LAHIR'));
$tempTinggi= $pelamar->getField('TINGGI');
$tempDomisili= $pelamar->getField('DOMISILI');
$tempKotaId= $pelamar->getField('KOTA_ID');
$tempNamaKota= $pelamar->getField('NAMA_KOTA');
$tempNamaProvinsi= $pelamar->getField('NAMA_PROVINSI');
$tempUmur= $pelamar->getField('UMUR');
$tempStatusNikah= $pelamar->getField('STATUS_NIKAH');
$tempStatusKawin= $pelamar->getField('STATUS_KAWIN');
$tempSIM= $pelamar->getField('SIM');
$tempSIMId= $pelamar->getField('SIM_ID');
$tempSertifikat= $pelamar->getField('SERTIFIKAT');
$tempSertifikatId= $pelamar->getField('SERTIFIKAT_ID');
$tempBeratBadan= $pelamar->getField('BERAT_BADAN');
$tempScoreToefl= $pelamar->getField('SCORE_TOEFL');

$lolosJenisKelamin = 1;
$lolosPendidikan = 1;

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/jquery-easyui-1.4.5/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/global-tab-easyui.js"></script>

<style>
.window-shadow{
	height:100px !important;	
}
.window-header{
	width:388px !important;		
}
.messager-body{
	height:100px !important;
	width:388px !important;		
}
.l-btn-small{
	width:100px !important;	
}
.messager-button{
	width:388px !important;		
}
.messager-window{
	width:400px !important;			
}
. messager-body{
	width:400px !important;			
}
</style>

<script type="text/javascript">


	$(function(){
		
		
		$('#ffDokumen').form({
			url:'lamaran_dokumen_add',
			onSubmit:function(){
				var win = $.messager.progress({
									title:'Upload Data',
									msg:'Mengupload data...'
								});							
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.progress('close');	
				if(data == '')
				{
					document.location.reload(true);
				}
				else
				{
					$.messager.alert("Perhatian", data, 'warning');
				}
				$('input:file').MultiFile('reset');
			}
		});
		
		setSimpan();
		$('#ff').form({
			url:'lamaran',
			onSubmit:function(){
				var reqLinkFile = $("#reqLinkFile").val();
				reqJumlahInfo= $("#reqJumlahInfo").val();
				var jumlahData= "<?=count($arrData)?>"
				
				if(reqJumlahInfo == jumlahData)
				{		
					if($(this).form('validate'))
					{
				       var win = $.messager.progress({
									title:'Proses Registrasi',
									msg:'Registrasi lowongan...'
								});					
						return $(this).form('validate');
					}
				}
				else
				{
					$.messager.alert('Info', "Pastikan semua pernyataan sudah anda setujui terlebih dahulu", 'info');
					return false;
				}
			},
			success:function(data){
				$.messager.progress('close');	
				if(data == '')
				{
					$.messager.alertLink('Informasi', "Daftar lamaran anda telah kami terima dan segera kami verifikasi. Terima Kasih.", 'info', 'app/index/daftar_lowongan');
				}
				else
					$.messager.alertReload('Perhatian', data, 'warning');
			}
		});
		
		$('input[id^="reqInfo"]').click(function() {
			setSimpan();
		});
	
	});
	
	function setSimpan()
	{
		var reqJumlahInfo= "";
		reqJumlahInfo= 0;
		$('input[id^="reqInfo"]').each(function(){
			var id= $(this).attr('id');
			id= id.replace("reqInfo", "")
			
			if($(this).prop('checked'))
			{
				reqJumlahInfo= parseInt(reqJumlahInfo) + 1;
			}
	   });
		
		$("#reqJumlahInfo").val(reqJumlahInfo);
		var jumlahData= "<?=count($arrData)?>"
		
		if(reqJumlahInfo == jumlahData)
		{
			$("#reqSimpanInfo").show();
			$("#reqSimpan").show();
		}
		else
		{
			$("#reqSimpanInfo").hide();
			$("#reqSimpan").hide();
		}
		
		$("#reqSimpanInfo").show();
		$("#reqSimpan").show();
	}

	$(function() {
		$('input:radio').change(function(){
			var name = $(this).prop('name');

			$('#'+name+'').val($(this).val());
		});
	});


</script>
<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">
	
    <div id="judul-halaman">Kirim Lamaran > Halaman Pernyataan</div>

    <div class="data-monitoring">
        <table class="table table-hover">
            <tbody>
            <tr>
            	<td style="width:20%">Kode</td>
            	<td style="width:2%">:</td>
                <td><?=$lowongan->getField("KODE")?></td>
            </tr>
            <tr>
            	<td>Nama Lowongan</td>
            	<td>:</td>
                <td><?=$lowongan->getField("NAMA")?></td>
            </tr>
            <tr>
            	<td>Penempatan</td>
            	<td>:</td>
                <td><?=$lowongan->getField("REGIONAL")?> - <?=$lowongan->getField("AREA")?></td>
            </tr>
            <tr>
            	<td colspan="3" style="text-align:right"><a href="app/index/lowongan_detil/<?=$reqParse1?>">Lihat Informasi Lowongan</a></td>
            </tr>
            </tbody>
        </table>
    
    </div>
        
    <div id="pendaftaran">
    <?
    if($kurang_entri > 0)
	{
		$daftar_entrian->selectByParamsDaftarEntrian(array("PELAMAR_ID" => $auth->userPelamarId, "WAJIB_ISI" => "1"), -1, -1);
	?>
    	Untuk dapat melanjutkan proses lamaran ini anda harus melengkapi data sebagai berikut.

        <div class="data-monitoring">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col" style="text-align:center">Nama</th>
                    <th scope="col" style="text-align:center">Status Entri</th>
                    <th scope="col" style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?
                while($daftar_entrian->nextRow())
                {
                ?>
                    <tr>
                        <td><?=$daftar_entrian->getField("NAMA")?></td>
                        <td align="center">
							<?
                            if($daftar_entrian->getField("ADA") > 0)
							{
							?>
                            	<i class="fa fa-check"></i>
                            <?
							}
							else
							{
							?>
                            	<i class="fa fa-exclamation"></i>
                            <?
							}
							?>
                        </td>
                        <td align="center">
							<?
                            if($daftar_entrian->getField("ADA") > 0)
							{
							?>

                            <?
							}
							else
							{
							?>	
			                    <a href="app/index/isian_formulir"><i class="fa fa-file"></i> Lengkapi Berkas</a>                            
							<?
							}
							?>
                        </td>
                    </tr>    
                <?
                }
                ?>
                </tbody>
            </table>
        </div>        
            Silahkan lengkapi berkas terlebih dahulu.
    <?
	}
	else
	{
	?>

    	<div class="judul-kriteria">
        Untuk mendaftar dalam proses rekrutmen dan seleksi, maka saya menyatakan bahwa:
        </div>
        <table style="margin-top:0px;">
        	<input type="hidden" name="reqJumlahInfo" id="reqJumlahInfo" value="0" />
        	<?
			for($i_data=0; $i_data < count($arrData); $i_data++)
			{
            ?>
        	<tr>
            	<td class="bg-ketentuan-lamaran"><input type="checkbox" name="reqInfo<?=$i_data?>" value="1" id="reqInfo<?=$i_data?>" class="checkbox-pernyataan" /></td>
                <td class="bg-ketentuan-lamaran"><?=$arrData[$i_data]?></td>
            </tr>
            <?
			}
		
			$lowongan_dokumen = new LowonganDokumen();
			$pelamar_lowongan = new PelamarLowongan();
			$adaDokumen = $lowongan_dokumen->getCountByParams(array("A.LOWONGAN_ID" => $reqId));
			if($adaDokumen > 0)
			{
            ?>
            <tr>
				<td colspan="2" style="padding:0 0;">
					<div class="judul-kriteria">Dokumen</div>
				</td>
			</tr>
            <tr>
            	<td colspan="2" style="padding:0 0;">
                    <form id="ffDokumen" method="post" novalidate enctype="multipart/form-data">
					<?
                    $lowongan_dokumen->selectByParamsPelamarLowongan($auth->userPelamarId, array("A.LOWONGAN_ID" => $reqId));
                    ?>
                    <table>
                    <?
                    while($lowongan_dokumen->nextRow())
                    {
                    ?>
                        <tr>
                        <td>
                            <?=$lowongan_dokumen->getField("NAMA")?>
                            <?
                            if($lowongan_dokumen->getField("WAJIB") == "1")
                            {
                            ?>
                            <font color="#FF0000">*</font>
                            <?
                            }
                            ?>
                            <ol style="list-style:square">
                                <li>Ukuran maksimum 300KB</li>
                                <li>file harus (jpg/jpeg/png)</li>
                            </ol>
                        </td>
                        <td class="aksi">
                            <div id="reqDivButton<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>"><input class="btn btn-info btn-sm" id="reqButtonLampiranCV" type="button" value="Ubah" onClick='$("#reqDivButton<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").hide(); $("#reqDivLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").show();' /></div>
                            <div id="reqDivLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>">
                                <span class="btn btn-default btn-file btn-sm">
                                    Browse File <input name="reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>[]" type="file" multiple class="maxsize-20240" id="reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>" value="" /></span></div>
                                <!--<input name="reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>[]" type="file" multiple class="maxsize-20240" id="reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>" value="" />-->
                            
                            <script>
                            // wait for document to load
                            $(function(){
                                <? 
                                if($lowongan_dokumen->getField("LINK_FILE") == "") 
                                {
                                ?>
                                $("#reqDivButton<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").hide();
                                $("#reqDivLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").show();
                                <?
                                }
                                else
                                {
                                ?>
                                $("#reqDivButton<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").show();
                                $("#reqDivLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>").hide();
                                <?
                                }
                                ?>
                                
                                // invoke plugin
                                $('#reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>').MultiFile({
                                onFileChange: function(){
                
                                    $("#reqNamaDokumen").val("<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>");
                                    $("#reqNamaLampiran").val("reqLampiran<?=$lowongan_dokumen->getField("LOWONGAN_DOKUMEN_ID")?>");
                                    $("#btnSimpan").click();
                                        
                                }
                                });
                            
                            });
                            
                            </script>                
                        </td>    
                        <td>
                        <? 
                        if($lowongan_dokumen->getField("LINK_FILE") == "") 
                        {}
                        else
                        {
                        ?>
                        <a href="uploads/<?=$lowongan_dokumen->getField("LINK_FILE")?>" target="_blank"><i class="fa fa-download"></i> download</a>
                        <?
                        }
                        ?>
                        </td>
                        </tr>
                    <?
                    }
                    ?>              
                    </table> 
                    <input name="reqId" id="reqId" type="hidden" value="<?=$reqId?>" />     
                    <input name="reqNamaDokumen" id="reqNamaDokumen" type="hidden" value="" />     
                    <input name="reqNamaLampiran" id="reqNamaLampiran" type="hidden" value="" />      
                    <input id="btnSimpan" type="submit" value="Submit" style="display:none">
                    </form>  
                </td>
            </tr>
            <?
			}
			?>
           <tr>
				<td colspan="2" style="padding:0 0;">
					<div class="judul-kriteria">Kualifikasi Lowongan</div>
				</td>
			</tr>
            <tr>
            	<td colspan="2" style="padding:0 0;">
                	
        			<form id="ff" method="post" novalidate enctype="multipart/form-data">
            		<table class="bg-ketentuan-lamaran">
		            	<?
		            	$i = 0;
		            	while ($lowongan_persyaratan->nextRow()) {
							
							$trDisplay = " style='display:none' ";
							if($lowongan_persyaratan->getField("PREFIX") == "JENIS_KELAMIN" || $lowongan_persyaratan->getField("PREFIX") == "PENDIDIKAN")
								$trDisplay = "  ";
		            	?>
		            	<tr <?=$trDisplay?>>
		            		<td style="width:300px;">
		            			<input type="hidden" name="reqLowonganPersyaratanId[<?=$i?>]" value="<?=$lowongan_persyaratan->getField("LOWONGAN_PERSYARATAN_ID")?>">
		            			<input type="hidden" name="reqNamaJenisPersyaratan[<?=$i?>]" value="<?=$lowongan_persyaratan->getField("PREFIX")?>">
		            			<input type="hidden" name="reqKeterangan[<?=$i?>]" value="<?=$lowongan_persyaratan->getField("NAMA")?>">
		            			<?=$lowongan_persyaratan->getField("NAMA")?>
		            		</td>
		            		<td>
                            	<?
                                if($lowongan_persyaratan->getField("PREFIX") == 'JENIS_KELAMIN')
								{
									$kualifikasiJK = $lowongan_persyaratan->getField("JENIS_KELAMIN");
									if($kualifikasiJK == "L" || $kualifikasiJK == "P")
									{
										if($kualifikasiJK == $tempJenisKelamin)
											$lolosJenisKelamin = 1;	
										else
											$lolosJenisKelamin = 0;	
									}
									
		            				if($tempJenisKelamin == "L")
		            				{
		        					?>
		        						<span>Laki-laki (L)</span>
		        					<?
		            				}
		            				else
		            				{
		        					?>
		        						<span>Perempuan (P)</span>
		        					<?
		            				}
									
								}
								elseif($lowongan_persyaratan->getField("PREFIX") == 'PENDIDIKAN')
		            			{
									$adaDataPendidikan = 0;
									// DATA PELAMAR PENDIDIKAN TERAKHIR
									$pelamar_pendidikan = new PelamarPendidikan();
									$statement = " AND (A.PENDIDIKAN_ID BETWEEN '".$lowongan_persyaratan->getField("MIN_PENDIDIKAN_ID") ."' AND '".coalesce($lowongan_persyaratan->getField("MAX_PENDIDIKAN_ID"), $lowongan_persyaratan->getField("MIN_PENDIDIKAN_ID"))."' OR A.PENDIDIKAN_ID >= '".coalesce($lowongan_persyaratan->getField("MAX_PENDIDIKAN_ID"), $lowongan_persyaratan->getField("MIN_PENDIDIKAN_ID"))."') ";
									$pelamar_pendidikan->selectByParams(array("A.PELAMAR_ID" => $auth->userPelamarId), -1, -1, $statement, " ORDER BY A.PENDIDIKAN_ID DESC ");
									
									while($pelamar_pendidikan->nextRow())
									{
										if($adaDataPendidikan == 0)
											echo $pelamar_pendidikan->getField("PENDIDIKAN_NAMA").' '.$pelamar_pendidikan->getField("JURUSAN");
										else
											echo "<br>".$pelamar_pendidikan->getField("PENDIDIKAN_NAMA").' '.$pelamar_pendidikan->getField("JURUSAN");
										
										$adaDataPendidikan++;	
									}
									
									if($adaDataPendidikan > 0)
										$lolosPendidikan = 1;
									else
										$lolosPendidikan = 0;
								
								}
								?>
                            	<div style="display:none">
		            			<?
		            			if($lowongan_persyaratan->getField("PREFIX") == 'JENIS_KELAMIN')
		            			{
		            				?>
		        						<input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempJenisKelamin?>">
		            				<?
		            				if($tempJenisKelamin == "L")
		            				{
		        					?>
		        						<span>Laki-laki (L)</span>
		        					<?
		            				}
		            				else
		            				{
		        					?>
		        						<span>Perempuan (P)</span>
		        					<?
		            				}
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'USIA')
		            			{
		            				?>
		        						<input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempUmur?>">
		        						<span><?=$tempUmur?> Tahun</span>
		            				<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'PENDIDIKAN')
		            			{
									// DATA PELAMAR PENDIDIKAN TERAKHIR
									$pelamar_pendidikan = new PelamarPendidikan();
									$statement = " AND A.PENDIDIKAN_ID BETWEEN '".$lowongan_persyaratan->getField("MIN_PENDIDIKAN_ID") ."' AND '".coalesce($lowongan_persyaratan->getField("MAX_PENDIDIKAN_ID"), $lowongan_persyaratan->getField("MIN_PENDIDIKAN_ID"))."' ";
									$pelamar_pendidikan->selectByParams(array("A.PELAMAR_ID" => $auth->userPelamarId), -1, -1, $statement, " ORDER BY A.PENDIDIKAN_ID DESC ");
									
		            				?>
		            					<select name="reqPersyaratan[<?=$i?>]" >
		            						<?
		            						while ($pelamar_pendidikan->nextRow()) {
	            							?>
	            								<option value="<?=$pelamar_pendidikan->getField("PENDIDIKAN_ID")?>">
	            									<?=$pelamar_pendidikan->getField("PENDIDIKAN_NAMA").' '.$pelamar_pendidikan->getField("JURUSAN")?>
		            							</option>
	            							<?
		            						}
		            						?>
		            					</select>
		        						<!-- <input type="hidden" class="easyui-combobox" name="reqPersyaratan[<?=$i?>]" value=""> -->
		            				<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'DOMISILI')
		            			{
		            				?>
		        						<input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempKotaId?>">
		        						<span><?=$tempNamaKota?> - <?=$tempNamaProvinsi?></span>
		            				<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'PENGALAMAN')
		            			{
		            				// DATA PELAMAR PENDIDIKAN TERAKHIR
									$pelamar_pengalaman = new PelamarPengalaman();
									$pelamar_pengalaman->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
									// echo $pelamar_pendidikan->query;
		            				?>
		            					<select name="reqPersyaratan[<?=$i?>]" >
		            						<?
		            						while ($pelamar_pengalaman->nextRow()) {
	            							?>
	            								<option value="<?=$pelamar_pengalaman->getField("PELAMAR_PENGALAMAN_ID")?>">
	            									<?=$pelamar_pengalaman->getField("TAHUN").' Tahun, Jabatan : '.$pelamar_pengalaman->getField("JABATAN")?>
		            							</option>
	            							<?
		            						}
		            						?>
		            					</select>
		        						<!-- <input type="hidden" class="easyui-combobox" name="reqPersyaratan[<?=$i?>]" value=""> -->
		            				<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'STATUS_KAWIN')
		            			{
								?>
                                    <input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempStatusKawin?>">
                                    <span><?=$tempStatusNikah?></span>                                
								<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'SIM')
		            			{
								?>
                                    <input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempSIMId?>">
                                    <span><?=$tempSIM?></span>                                
								<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'SERTIFIKAT')
		            			{
		            				// DATA PELAMAR PERSYARATAN
									$pelamar_sertifikat = new PelamarSertifikat();
									$pelamar_sertifikat->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId, "A.SERTIFIKAT_ID" => $lowongan_persyaratan->getField("SERTIFIKAT_ID")));
									
		            				?>
		            					<select name="reqPersyaratan[<?=$i?>]" >
		            						<?
		            						while ($pelamar_sertifikat->nextRow()) {
	            							?>
	            								<option value="<?=$pelamar_sertifikat->getField("SERTIFIKAT_ID")?>">
	            									<? 
	            									if($pelamar_sertifikat->getField("SERTIFIKAT_ID") == "")
	            									{
	            										echo $pelamar_sertifikat->getField("NAMA");
	            									}
	            									else
	            									{
	            										echo $pelamar_sertifikat->getField("NAMA");
	            									}
	            									?>
		            							</option>
	            							<?
		            						}
		            						?>
		            					</select>
		        						<!-- <input type="hidden" class="easyui-combobox" name="reqPersyaratan[]" value=""> -->
		            			<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'TOEFL')
		            			{
		            				// DATA PELAMAR PENDIDIKAN TERAKHIR
									$pelamar_toefl = new PelamarToefl();
									$pelamar_toefl->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
									// echo $pelamar_pendidikan->query;
		            				?>
		            					<select name="reqPersyaratan[<?=$i?>]" >
		            						<?
		            						while ($pelamar_toefl->nextRow()) {
	            							?>
	            								<option value="<?=$pelamar_toefl->getField("PELAMAR_TOEFL_ID")?>">
	            									<?=$pelamar_toefl->getField("NAMA").', Score : '.$pelamar_toefl->getField("NILAI")?>
		            							</option>
	            							<?
		            						}
		            						?>
		            					</select>
		        						<!-- <input type="hidden" class="easyui-combobox" name="reqPersyaratan[]" value=""> -->
		            				<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'TINGGI_BADAN')
		            			{
								?>
                                    <input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempTinggi?>">
                                    <span><?=$tempTinggi?> Cm</span>                                
								<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'BERAT_BADAN')
		            			{
								?>
                                    <input type="hidden" name="reqPersyaratan[<?=$i?>]" value="<?=$tempBeratBadan?>">
                                    <span><?=$tempBeratBadan?> Kg</span>                                
								<?
		            			}
		            			else if($lowongan_persyaratan->getField("PREFIX") == 'ENTRI')
		            			{
	            				?>
		        					<input type="hidden" id="reqPersyaratan<?=$i?>" name="reqPersyaratan[<?=$i?>]" value="">

	            					<input type="radio" name="reqPersyaratanEntri<?=$i?>" value="Y" onClick="$('#reqPersyaratan<?=$i?>').val('Y')" checked> Ya
									<input type="radio" name="reqPersyaratanEntri<?=$i?>" value="T" onClick="$('#reqPersyaratan<?=$i?>').val('T')"> Tidak
	            				<?
		            			}
		            			else
		            			{
		            			?>
		        					<input type="hidden" id="reqPersyaratan<?=$i?>" name="reqPersyaratan[<?=$i?>]" value="">
		            			<?
								}
		            			?>
                                </div>
		            		</td>
		            	</tr>
		            	<?	
		            		$i++;
		            	}
		            	?>
            		</table>
                	<input name="reqSubmit" type="hidden" value="update" />
                	<input name="reqId" type="hidden" value="<?=$reqId?>" />
                    <input type="submit" id="btnSubmit" style="display:none" />
					@csrf  
        			</form>
            	</td>
            </tr>
            <tr>
            	<td colspan="2" style="text-align:justify">
                <p class="alert alert-danger" style="margin-bottom: 0px; margin-top: 10px;">
                Apabila di kemudian dari ternyata diketahui bahwa data dan informasi yang saya berikan pada proses rekrutmen dan seleksi ini tidak benar dan/atau tidak dapat dibuktikan, maka demi tanggung jawab moral sebagai calon pegawai/pegawai, saya bersedia mengundurkan diri dari seluruh proses rekrutmen dan seleksi maupun mengundurkan diri dari perusahaan saya bekerja.
                </p>
                </td>
            </tr>
            <?
            if($lolosJenisKelamin == 1 && $lolosPendidikan == 1)
			{
			?>
            <tr id="reqSimpanInfo" style="display:none">
            	<td colspan="2">
                <p class="alert alert-warning" style="margin-bottom: 0px;">
                Dengan klik tombol SETUJU, Saya menyatakan telah membaca dan memahami seluruh petunjuk serta mengijinkan Panitia Rekrutmen dan Seleksi untuk menggunakan data administrasi dalam proses rekrutmen dan seleksi pegawai PTPN 1
                </p>
                </td>
            </tr>
            <tr id="reqSimpan" style="display:none; text-align:center">
            	<td colspan="2">
                	<input type="button" id ="btn-kembali" value="Kembali" onClick="document.location.href='app/index/daftar_lowongan'"  />
                	<input type="button" id ="btn-setuju" value="Setuju" onClick="konfirmasi()" disabled />
                </td>
            </tr>          
            <?
			}
			else
			{
			?>
            <tr id="reqSimpanInfo" style="display:none">
            	<td colspan="2">
                <p class="alert alert-warning" style="margin-bottom: 0px;">
                <i class="fa fa-exclamation-triangle"></i> Anda tidak memenuhi kualifikasi lowongan, silahkan memilih lowongan lain.
                </p>
                </td>
            </tr>
            <tr id="reqSimpan">
            	<td colspan="2" style="text-align:center">
                	<input type="button" id ="btn-setuju" value="Kembali" onClick="document.location.href='app/index/daftar_lowongan'"  />
                </td>
            </tr>      
            <?
			}
			?>
        </table>
    <?
	}
	?>
    </div>
    
    <!--<form action="/">
        <input type="checkbox" class="number" value="One">One<br>
        <input type="checkbox" class="number" value="Two">Two<br>
        <input type="checkbox" class="number" value="Three">Three<br>
        <input type="checkbox" class="number" value="Four">Four<br>
        <input type="submit" id ="btn" value="Submit" disabled>
    </form>-->
    <script>
	$( ".checkbox-pernyataan" ).on( "click", function() {
	  if($( ".checkbox-pernyataan:checked" ).length > 3)
	  {
		$('#btn-setuju').prop('disabled', false);
	  }
	  else
	  {
		$('#btn-setuju').prop('disabled', true);
	  }  
	});

	</script>
    
    
    
</div>

<!-- UPLOAD CORE -->
<script src="libraries/multifile-master/jquery.MultiFile.js"></script>
<script>
	function konfirmasi()
	{
		var dlg = $.messager.confirm({
			title: 'Konfirmasi',
			msg: 'Pastikan data yang anda isi sudah benar, data pribadi anda tidak dapat diubah setelah mengirim lamaran. Lanjutkan proses ?',
			buttons:[{
				text: 'Ya',
				onClick: function(){
					$('#btnSubmit').click();
				}
			},{
				text: 'Batal',
				onClick: function(){
					dlg.dialog('destroy')
				}
			}]
		});

	}
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

<style>
.keterangan {
    margin-bottom: 0px;
    *background: #FFF;
	background: inherit;
    *padding: 20px 0;
    /*-webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;*/
	
	font-family: 'Montserrat Regular';
}
</style>