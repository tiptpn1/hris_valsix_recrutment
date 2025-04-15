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
					$.messager.alert('Info', data.message, 'info');
				else
					$.messager.alert('Info', data.message, 'warning');
			}
		});
		
	});
	
</script>

<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

	<div id="judul-halaman">Ganti Password</div>
    <div id="data-form">
		

    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
        	<div class="password-area">
            	<!--<div class="header">Ganti Password</div>-->
                <div class="body">
                    <div class="row">
                    	<div class="col-md-6 col-md-offset-2">
                            <div class="form-group ">
                                <label for="email">Password Baru :</label>
								<input type="password" name="reqPassword" class="form-control" value="">
                            </div>
                            <div class="form-group ">
                                <label for="email">Konfirmasi Password Baru :</label>
                                <input type="password" name="reqPasswordUlangi" class="form-control" value="">
                            </div>
	                        <input type="hidden" name="PELAMAR_ID" value="<?=$auth->userPelamarEnkripId?>" />
                            <button type="submit" class="btn btn-info">Submit</button>
                    	</div>
                    </div>
                </div>
                
            </div>
			@csrf  
        </form>
        
    
    </div>
    

</div>

