<?


use App\Models\PelamarSubscribe;



$pelamar_subscribe = new PelamarSubscribe();

$pelamar_subscribe->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
$pelamar_subscribe->firstRow();

$tempBidangId = $pelamar_subscribe->getField("BIDANG_ID");

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'../json/data_pelamar_subscribe_add.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				// alert(data); return false;
				//$.messager.alert('Info', data, 'info');
				document.location.reload();
			}
		});
		
	});
	
</script>

<div class="col-lg-8">

    <div id="judul-halaman">Data Email Subscribe</div>
    
    <div class="judul-halaman2"><i class="fa fa-pencil"></i> Form Entri</div>
    <div id="pendaftaran">
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table>
            	<tr>
                    <td>Bidang Jabatan</td>
                    <td>:</td>
                    <td>
                        <input id="reqBidangId" class="easyui-combotree" name="reqBidangId" data-options="panelHeight:'200',url:'../json/bidang_combo_json.php?'" style="width:400px;" value="<?=$tempBidangId?>" />
                    </td>
                </tr>
            </table>
            <br>
            <div>
                <? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
                <input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input id="reqSubmit" type="submit" value="Subscribe">
            </div>
        </form>
    </div>
    
</div>