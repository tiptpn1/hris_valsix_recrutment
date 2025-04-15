<?

use App\Models\Pelamar;



$pelamar = new Pelamar();

$reqId = request()->reqId;
$reqKelompokPegawai = request()->reqKelompokPegawai;

$reqMode = "update";
$pelamar->selectByParams(array("A.PELAMAR_ID" => $auth->userPelamarId));
//echo $pelamar->query;
$pelamar->firstRow();
$reqLampiranCV= $pelamar->getField('LAMPIRAN_CV');
$reqLampiranKTP= $pelamar->getField('LAMPIRAN_KTP');
$reqLampiranFoto= $pelamar->getField('LAMPIRAN_FOTO');
$reqLampiranIjasah= $pelamar->getField('LAMPIRAN_IJASAH');
$reqLampiranTranskrip= $pelamar->getField('LAMPIRAN_TRANSKRIP');
$reqLampiranSKCK= $pelamar->getField('LAMPIRAN_SKCK');
$reqLampiranSKS= $pelamar->getField('LAMPIRAN_SKS');
$reqLampiranSuratLamaran= $pelamar->getField('LAMPIRAN_SURAT_LAMARAN');

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	/*//The magic code to add show/hide custom event triggers
	(function ($) {
	  $.each(['show', 'hide'], function (i, ev) {
		var el = $.fn[ev];
		$.fn[ev] = function () {
		  this.trigger(ev);
		  return el.apply(this, arguments);
		};
	  });
	})(jQuery);*/
	
	$(function(){
		setButtonUbah();
		$('#ff').form({
			url:'data_lampiran_add',
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
					$.messager.alertReload("Perhatian", data, 'warning');
				}
				$('input:file').MultiFile('reset');
			}
		});
		
		$('input[id^="reqButtonLampiran"]').click(function() {
			var id= $(this).attr('id');
			id= id.replace("reqButtonLampiran", "");
			
			$("#reqDivButton"+id).hide();
			$("#reqDivLampiran"+id).show();
		});
		
	});
	
	function setButtonUbah()
	{
		//alert('a');
		<? 
		if($reqLampiranCV == "") 
		{
		?>
		$("#reqDivButtonCV").hide();
		$("#reqDivLampiranCV").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonCV").show();
		$("#reqDivLampiranCV").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranKTP == "") 
		{
		?>
		$("#reqDivButtonKTP").hide();
		$("#reqDivLampiranKTP").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonKTP").show();
		$("#reqDivLampiranKTP").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranFoto == "") 
		{
		?>
		$("#reqDivButtonFoto").hide();
		$("#reqDivLampiranFoto").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonFoto").show();
		$("#reqDivLampiranFoto").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranIjasah == "") 
		{
		?>
		$("#reqDivButtonIjasah").hide();
		$("#reqDivLampiranIjasah").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonIjasah").show();
		$("#reqDivLampiranIjasah").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranTranskrip == "") 
		{
		?>
		$("#reqDivButtonTranskrip").hide();
		$("#reqDivLampiranTranskrip").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonTranskrip").show();
		$("#reqDivLampiranTranskrip").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranSKCK == "") 
		{
		?>
		$("#reqDivButtonSKCK").hide();
		$("#reqDivLampiranSKCK").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonSKCK").show();
		$("#reqDivLampiranSKCK").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranSKS == "") 
		{
		?>
		$("#reqDivButtonSKS").hide();
		$("#reqDivLampiranSKS").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonSKS").show();
		$("#reqDivLampiranSKS").hide();
		<?
		}
		?>
		
		<? 
		if($reqLampiranSuratLamaran == "") 
		{
		?>
		$("#reqDivButtonSuratLamaran").hide();
		$("#reqDivLampiranSuratLamaran").show();
		<?
		}
		else
		{
		?>
		$("#reqDivButtonSuratLamaran").show();
		$("#reqDivLampiranSuratLamaran").hide();
		<?
		}
		?>
		
	}
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


<!--<div class="col-lg-8">-->
<!-- <div class="col-sm-8 col-sm-pull-4"> -->
<div class="col-md-12">

    <div id="judul-halaman">Data Lampiran</div>
    
    <div class="data-lampiran">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
        <table>
            <tr>
            <td>
                Surat Lamaran &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonSuratLamaran"><input class="btn btn-info btn-sm" id="reqButtonLampiranSuratLamaran" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranSuratLamaran">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranSuratLamaran[]" type="file" multiple class="maxsize-20240" id="reqLampiranSuratLamaran" value="" />
                    </span>
				</div>
                
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranSuratLamaran').MultiFile({
                    onFileChange: function(){
						
                        $("#reqNamaDokumen").val("LAMPIRAN_SURAT_LAMARAN");
                        $("#reqNamaLampiran").val("reqLampiranSuratLamaran");
                        $("#btnSimpan").click();
                            
                    }
                    });
                });
                </script>
            </td>
            </td>
            </td>    
            <td>
            <? 
			if($reqLampiranSuratLamaran == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranSuratLamaran?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>
            <tr>
            <td>
                Daftar riwayat hidup (CV) &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonCV"><input class="btn btn-info btn-sm" id="reqButtonLampiranCV" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranCV">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranCV[]" type="file" multiple class="maxsize-20240" id="reqLampiranCV" value="" />
                    </span>
				</div>
                
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranCV').MultiFile({
                    onFileChange: function(){
						
                        $("#reqNamaDokumen").val("LAMPIRAN_CV");
                        $("#reqNamaLampiran").val("reqLampiranCV");
                        $("#btnSimpan").click();
                            
                    }
                    });
                });
                </script>
            </td>
            </td>    
            <td>
            <? 
			if($reqLampiranCV == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranCV?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>
            <tr>
            <td>
                Fotocopy KTP &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonKTP"><input class="btn btn-info btn-sm" id="reqButtonLampiranKTP" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranKTP">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranKTP[]" type="file" multiple class="maxsize-20240" id="reqLampiranKTP" value="" /></span></div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranKTP').MultiFile({
                    onFileChange: function(){
    
						$("#reqNamaDokumen").val("LAMPIRAN_KTP");
						$("#reqNamaLampiran").val("reqLampiranKTP");
						$("#btnSimpan").click();
                            
                    }
                    });
                
                });
                
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranKTP == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranKTP?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>   
            <tr>
            <td>
                Pas Foto ukuran 4x6 Berwarna &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonFoto">               	
	                <input class="btn btn-info btn-sm" id="reqButtonLampiranFoto" type="button" value="Ubah" />
                </div>
                <div id="reqDivLampiranFoto">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranFoto[]" type="file" multiple class="maxsize-20240" id="reqLampiranFoto" value="" /></span></div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranFoto').MultiFile({
                    onFileChange: function(){
    
						$("#reqNamaDokumen").val("LAMPIRAN_FOTO");
						$("#reqNamaLampiran").val("reqLampiranFoto");
						$("#btnSimpan").click();
                            
                    }
                    });
                
                });
                
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranFoto == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranFoto?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>        
            <tr>
            <td>
                Fotocopy Ijazah sesuai kualifikasi lowongan &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol> 
            </td>
            <td align="center">
                <div id="reqDivButtonIjasah"><input class="btn btn-info btn-sm" id="reqButtonLampiranIjasah" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranIjasah">
                    <span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranIjasah[]" type="file" multiple class="maxsize-20240" id="reqLampiranIjasah" value="" />
                    </span>
                
                
                </div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranIjasah').MultiFile({
                    onFileChange: function(){
    
						$("#reqNamaDokumen").val("LAMPIRAN_IJASAH");
						$("#reqNamaLampiran").val("reqLampiranIjasah");
						$("#btnSimpan").click();
                            
                    }
                    });
                
                });
                
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranIjasah == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranIjasah?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>          
            <tr>
            <td>
                Transkrip Nilai/ SKHU &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonTranskrip"><input class="btn btn-info btn-sm" id="reqButtonLampiranTranskrip" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranTranskrip">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranTranskrip[]" type="file" multiple class="maxsize-20240" id="reqLampiranTranskrip" value="" /></span></div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranTranskrip').MultiFile({
                    onFileChange: function(){
    
						$("#reqNamaDokumen").val("LAMPIRAN_TRANSKRIP");
						$("#reqNamaLampiran").val("reqLampiranTranskrip");
						$("#btnSimpan").click();
                            
                    }
                    });
                });
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranTranskrip == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranTranskrip?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>   
            <tr>
            <td>
                SKCK (masih berlaku) &nbsp;<i class="fa fa-star"></i>
                <ol style="list-style:square">
                    <li>Ukuran maksimum 300KB</li>
                    <li>file harus (jpg/jpeg/png)</li>
                </ol>
            </td>
            <td align="center">
            	<div id="reqDivButtonSKCK"><input class="btn btn-info btn-sm" id="reqButtonLampiranSKCK" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranSKCK">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranSKCK[]" type="file" multiple class="maxsize-20240" id="reqLampiranSKCK" value="" /></span></div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranSKCK').MultiFile({
                    onFileChange: function(){
    
						$("#reqNamaDokumen").val("LAMPIRAN_SKCK");
						$("#reqNamaLampiran").val("reqLampiranSKCK");
						$("#btnSimpan").click();
                            
                    }
                    });
                
                });
                
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranSKCK == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranSKCK?>" target="_blank"><i class="fa fa-download"></i> download</a>
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
            <td align="center">
                <div id="reqDivButtonSKS"><input class="btn btn-info btn-sm" id="reqButtonLampiranSKS" type="button" value="Ubah" /></div>
                <div id="reqDivLampiranSKS">
                	<span class="btn btn-default btn-file btn-sm">
                        Browse File <input name="reqLampiranSKS[]" type="file" multiple class="maxsize-20240" id="reqLampiranSKS" value="" /></span></div>
                <script>
                // wait for document to load
                $(function(){
                    
                    // invoke plugin
                    $('#reqLampiranSKS').MultiFile({
						onFileChange: function(){
		
							$("#reqNamaDokumen").val("LAMPIRAN_SKS");
							$("#reqNamaLampiran").val("reqLampiranSKS");
							$("#btnSimpan").click();
								
						}
                    });
                
                });
                
                </script>                
            </td>    
            <td>
            <? 
			if($reqLampiranSKS == "") 
			{}
			else
			{
			?>
            <a href="uploads/<?=$reqLampiranSKS?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>
            <tr>
              <td>
              	<span class="spanItalicKpk">Keterangan: </span>
              	<br/><i class="fa fa-star"></i><i>Harus diisi</i> 
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
        </form>
        <form id="ss" method="post" novalidate enctype="multipart/form-data">
            <input name="reqNamaDokumen" id="reqNamaDokumen" type="hidden" value="" />     
            <input name="reqNamaLampiran" id="reqNamaLampiran" type="hidden" value="" />      
            <input id="btnSimpan" type="submit" value="Submit" style="display:none">
        </form>
        
    </div>
    
</div>