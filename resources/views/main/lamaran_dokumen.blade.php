<?


use App\Models\LowonganDokumen;
use App\Models\PelamarLowongan;

$lowongan_dokumen = new LowonganDokumen();
$pelamar_lowongan = new PelamarLowongan();

$reqId = request()->reqId;

$pelamar_lowongan_id = $pelamar_lowongan->getPelamarLowonganId(array("A.PELAMAR_ID" => $auth->userPelamarId, "A.LOWONGAN_ID" => $reqId), " AND TANGGAL_KIRIM IS NULL ");

if($pelamar_lowongan_id == "")
{
	echo '<script language="javascript">';
	echo 'alert("Anda sudah melengkapi data sebelumnya.");';
	echo 'top.location.href = "index.php";';
	echo '</script>';
	
	exit;		
}

$lowongan_dokumen->selectByParamsPelamarLowongan($pelamar_lowongan_id, array("A.LOWONGAN_ID" => $reqId));
?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'../json/lamaran_dokumen_add.php',
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

		$('#gg').form({
			url:'../json/lamaran_dokumen_kirim_add.php',
			onSubmit:function(){	
				var win = $.messager.progress({
									title:'Proses Kirim Lamaran',
									msg:'Memproses data...'
								});						
				return $(this).form('validate');
			},
			success:function(data){				
				$.messager.progress('close');
				
				if(data == '')
					document.location.href = 'app/index/daftar_lamaran&reqKonfirmasi=<?=md5($reqId)?>';			
				else
					$.messager.alertReload("Perhatian", data, 'warning');
					
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


<div class="col-lg-8 sisi-kiri">

    <div id="judul-halaman">Kirim Lamaran > Upload Dokumen</div>
    
    <div class="data-lampiran">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
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
                    <li>file harus (pdf)</li>
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
            <a href="../uploads/<?=$lowongan_dokumen->getField("LINK_FILE")?>" target="_blank"><i class="fa fa-download"></i> download</a>
            <?
			}
			?>
            </td>
            </tr>
        <?
		}
		?>              
        </table>    
        <br>   
        <div>
        
            <input name="reqId" id="reqId" type="hidden" value="<?=$pelamar_lowongan_id?>" />     
            <input name="reqNamaDokumen" id="reqNamaDokumen" type="hidden" value="" />     
            <input name="reqNamaLampiran" id="reqNamaLampiran" type="hidden" value="" />      
            <input id="btnSimpan" type="submit" value="Submit" style="display:none">
        </div>
        </form>
        <form id="gg" method="post" novalidate enctype="multipart/form-data" class="konten-10">
            <input name="reqId" type="hidden" value="<?=$pelamar_lowongan_id?>" />     
            <input name="reqLowonganId" id="reqLowonganId" type="hidden" value="<?=$reqId?>" />     
            <input id="btnKirim" type="submit" value="Kirim Lamaran">        
        </form>
    </div>
    
</div>