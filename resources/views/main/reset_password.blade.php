<?

use App\Models\UsersBase;




$reqId = setQuote($reqParse1);

$user = new UsersBase();

if($reqValidasi == md5(date("dmY")))
{}
else
{
	// echo '<script language="javascript">';
	// echo 'alert("Sesi ubah password anda telah habis, silahkan request kembali, Terima Kasih.");';
	// echo 'top.location.href = "home";';
	// echo '</script>';
	// exit;		
}

$user->selectByParamsSimple(array("md5(CONCAT(A.PELAMAR_ID , 'pelamar', date_format(current_date, '%d%m%y'), '$MD5KEY'))" => $reqId), -1, -1, "");
$user->firstRow();
$PELAMAR_ID = $user->getField("PELAMAR_ID");

if($PELAMAR_ID == "")
{
    $data = [
            "message" => "Link reset pasword telah kadaluarsa, silahkan request kembali reset password.",
			"auth" => $auth
    ];
    $body = view("konten/data_tidak_dikenali", $data);
    echo $body;
    return;
}
?>

<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'reset_password',
			onSubmit:function()
			{
				if($(this).form('validate'))
				{
					var win = $.messager.progress({
						title:'<?=config("app.nama_aplikasi")?> | <?=config("app.nama_perusahaan_singkat")?>',
						msg:'proses data...'
					});     
				}           
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.progress('close');

				data = JSON.parse(data);

				if(data.status == 'success')
					$.messager.alertLink('Info', data.message, 'info', 'app/index/home');
				else
					$.messager.alert('Info', data.message, 'warning');
			}
		});
		
	});
	
</script>

<div class="<?=($auth->userPelamarId == "") ? "col-sm-12" : "col-sm-8 col-sm-pull-4"?>">
	<div id="judul-halaman">Reset Password</div>
    <div id="data-form">
		

    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
        	<div class="password-area">
                <div class="body">
                	<div class="alert alert-warning" role="alert"><?=$user->getField("NAMA")?>, silahkan masukkan password baru anda.</div>
                    
                    <div class="row">
                    	<div class="col-md-6 col-md-offset-2">
                            <div class="form-group ">
                                <label for="email">Password Baru:</label>
                                <input type="password" class="form-control" id="reqPassword" name="reqPassword">
                            </div>
                            <div class="form-group ">
                                <label for="email">Ulangi Password Baru:</label>
                                <input type="password" class="form-control" id="reqPasswordUlangi" name="reqPasswordUlangi">
                                <input type="hidden" name="PELAMAR_ID" value="<?=md5($PELAMAR_ID.'pelamar'.$MD5KEY)?>">
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>
                    	</div>
                    </div>
                    
                
                </div>
                
            </div>
			@csrf  
        </form>
        
    
    </div>
    

</div>

