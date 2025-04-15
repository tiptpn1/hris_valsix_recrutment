<?

use App\Models\UsersBase;




$reqId = request()->reqId;
$reqValidasi = request()->reqValidasi;


?>

<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'../json/unsubscribe_json.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				alert(data);
				document.location.href = "index.php";
			}
		});
		
	});
	
</script>

<div class="col-lg-8">
	<div id="judul-halaman">Unsubscribe Informasi Lowongan Terbaru</div>
    <div id="data-form">
		

    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
        	<div class="password-area">
                <div class="body">
                	<div class="alert alert-warning" role="alert">silahkan masukkan username dan password.</div>
                    
                    <div class="row">
                    	<div class="col-md-6 col-md-offset-2">
                            <div class="form-group ">
                                <label for="email">Username :</label>
                                <input type="text" class="form-control" id="reqUsername" name="reqUsername">
                            </div>
                            <div class="form-group ">
                                <label for="email">Password :</label>
                                <input type="password" class="form-control" id="reqPassword" name="reqPassword">
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>
                    	</div>
                    </div>
                    
                
                </div>
                
            </div>
        </form>
        
    
    </div>
    

</div>

