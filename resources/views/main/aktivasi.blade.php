<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">
	$(function(){
		$('#ff').form({
			url:'kirim_aktivasi',
			onSubmit:function(){
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
					$.messager.alertReload('Info', data.message, 'info');
				else
					$.messager.alert('Info', data.message, 'warning');
			}
		});
		
	});
	
	function check_email(val){
		if(!val.match(/\S+@\S+\.\S+/)){ // Jaymon's / Squirtle's solution
			// Do something
			return false;
		}
		if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
			// Do something
			return false;
		}
		return true;
	}	
	
</script>

<div class="<?=($auth->userPelamarId == "") ? "col-sm-12" : "col-sm-8 col-sm-pull-4"?>">
	<div id="judul-halaman">Kirim Ulang Aktivasi Akun</div>
    <div id="data-form">
		

    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
        	<div class="password-area">
            	<!--<div class="header">Lupa Password Anda?</div>-->
                <div class="body">
                	<div class="alert alert-warning" role="alert">Silakan masukkan No. NIK anda, kami akan membantu mengirim ulang link aktivasi akun anda.</div>
                    
                    <div class="row">
                    	<div class="col-md-6 col-md-offset-2">
                            <div class="form-group ">
                                <label for="email">No. NIK</label>
                                <input type="email" class="form-control" id="reqKtp" name="reqKtp" placeholder="Masukkan 16 Digit NIK" maxlength="16">
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

