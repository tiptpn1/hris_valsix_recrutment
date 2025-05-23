<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/global-tab-easyui.js"></script>

<script type="text/javascript">
	var tempCaptcha= tempNPP= tempEmail1= ""; 
    $.extend($.fn.validatebox.defaults.rules, {
		namaValsixEasyui: {
			validator:function(value, param) {
				var val1= val2= val3="";
				
				var reg = /^([a-zA-Z]+(?:\.)?(?:(?:'| )[a-zA-Z]+(?:\.)?)*)$/;
				if(reg.test(value) == true)
					val1=1;
				else
					val1=0;
				
				var reg = /[aeiou]{3}/;
				if(reg.test(value) == true)
					val2=0;
				else
					val2=1;
				
				var reg = /[bcdfghjklmnpqrstvwxyz]{4}/;
				if(reg.test(value) == true)
					val3=0;
				else
					val3=1;
				
				if(val1 == 1 && val2 == 1 && val3 == 1)
					return true;
				else
					return false;
			},
		message:"Pastikan Nama Anda yg ketik benar"
		},
		equals: {
			validator: function(value,param){
				return value == $(param[0]).val();
			},
		message: 'Password Anda belum benar.'
		},
		validDaftarCaptcha:{
            validator: function(value, param){
                var reqSecurity= panjang= "";
                reqSecurity= $("#reqSecurityDaftar").val();
                panjang= reqSecurity.length;
				
				var s_url= "../json/daftar_captcha_validation_json.php?characters=5&reqVal="+reqSecurity;
				var request = $.get(s_url);
					
				if(panjang == 5)
				{
					request.done(function(dataJson)
					{
						var data= JSON.parse(dataJson);
						tempCaptcha= data.VALUE_VALIDASI;
					});
					
					if(tempCaptcha == '1'){}
					else
						$('#reqSecurityDaftar').focus()
				}
				else
				{
					tempCaptcha="";
				}
					
                 if(tempCaptcha == '1')
                    return true;
                 else
                    return false;
            },
            message: 'Security code yang anda masukkan salah.'
        },
        validDaftarCaptchaBak:{
            validator: function(value, param){
                var reqSecurity= panjang= "";
                reqSecurity= $("#reqSecurityDaftar").val();
                panjang= reqSecurity.length;
				//alert('a');
				if(panjang == 5)
				{
					$.getJSON("../json/daftar_captcha_validation_json.php?characters=5&reqVal="+reqSecurity,
					function(data){
						tempCaptcha= data.VALUE_VALIDASI;
					});
				}
				else
					tempCaptcha= "";
					
                 if(tempCaptcha == '1')
                    return true;
                 else
                    return false;
            },
            message: 'Security code yang anda masukkan salah.'
        },
        validNPP:{
            validator: function(value, param){
                var reqNoKtp= "";
                reqNoKtp= $("#reqNoKtp").val();
                
				$.getJSON("../json/daftar_ktp_validation_json.php?reqVal="+reqNoKtp,
                function(data){
                    tempNPP= data.VALUE_VALIDASI;
                });
                 
                 if(tempNPP == '')
				 {
                    return true;
				 }
                 else
                    return false;
            },
            message: 'No Identitas sudah ada.'
        },
		validMail:{
            validator: function(value, param){
                var reqEmail1= "";
                reqEmail1= $("#reqEmail1").val();
                
				$.getJSON("../json/daftar_email1_validation_json.php?reqVal="+reqEmail1,
                function(data){
                    tempEmail1= data.VALUE_VALIDASI;
                });
                 
                 if(tempEmail1 == '')
                    return true;
                 else
                    return false;
            },
            message: 'Email sudah ada.'
        },
		validKTP:{
            validator: function(value, param){
                var reqNoKtp= "";
                reqNoKtp= $("#reqNoKtp").val();
                
                 if(reqNoKtp.length == 16)
                    return true;
                 else
                    return false;
            },
            message: 'Masukkan 16 digit nomor KTP.'
        }
    });
    
    $(function(){
        $('#ff').form({
			url:'../json/register.php',
            onSubmit:function(){
				var f = this;
				var opts = $.data(this, 'form').options;
				if($(this).form('validate') == false){
					return false;
				}
				
				$.messager.confirm('Konfirmasi','Apakah data yang anda isikan benar? karena data yang telah anda isi tidak dapat diubah.',function(r){
					if (r){
						var onSubmit = opts.onSubmit;
						opts.onSubmit = function(){};
						$(f).form('submit');
						opts.onSubmit = onSubmit;
					}
				})
				
				return false;
                //return $(this).form('validate');
            },
            success:function(data){
                $.messager.alertLink('Info', data, 'info', 'index.php'); 
                // return false;
                // document.location.href = 'app/index/data_pribadi';
				// document.location.href = 'index.php';
            }
        });
    });
	
</script>

<div class="col-lg-8">
	<div id="judul-halaman">Register</div>
    <div id="data-form">
		
        <div class="keterangan">
        <strong>Perhatian :</strong><br />
    	<ul>
        <li>Selama proses rekrutmen &amp; seleksi, pelamar TIDAK DIPUNGUT BIAYA dalam bentuk apapun</li>
        <li>Hanya pelamar yang memenuhi persyaratan dan TERBAIK yang akan dipanggil untuk mengikuti proses rekrutmen &amp; seleksi</li>
        <li>Keputusan panitia rekrutmen &amp; seleksi adalah MUTLAK dan TIDAK DAPAT DIGANGGU GUGAT</li>
        </ul>
        </div>

    	
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<table>
        	<tr>
            	<td>Nomor KTP</td>
                <td>:</td>
                <td>
                <input name="reqNoKtp" id="reqNoKtp" class="easyui-validatebox" data-options="required:true, validType:['validKTP[\'\']','validNPP[\'\']']" type="text" style="width:200px;" maxlength="16" />
                </td>
            </tr>
        	<tr>
            	<td>Nama</td>
                <td>:</td>
                <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required  type="text" style="width:400px;"  />
                </td>
            </tr>
        	<tr>
            	<td>No. Handphone</td>
                <td>:</td>
                <td>
                <input name="reqTelepon" id="reqTelepon" class="easyui-validatebox" required type="text" style="width:200px;"  />
                </td>
            </tr>
            <tr>
            	<td>Email</td>
                <td>:</td>
                <td>
                <input name="reqEmail" type="text" size="40" id="reqEmail1" data-options="validType:['email','validMail[\'\']']" class="easyui-validatebox" required style="width:272px;" />
                </td>
            </tr>
            <tr>
            	<td>Password / Kata Sandi</td>
                <td>:</td>
                <td>
                <input name="reqPassword" type="password" required id="reqPassword" class="easyui-validatebox" />
                </td>
            </tr>
            <tr>
            	<td>Ketik Ulang Password / Kata Sandi</td>
                <td>:</td>
                <td>
                <input id="reqPasswordUlang" name="reqPasswordUlang" type="password" class="easyui-validatebox" required validType="equals['#reqPassword']" />
                </td>
            </tr>
            <tr>
            	<td>Security Code</td>
                <td>:</td>
                <td>
                <img src="../json/CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" id="captchaImage" />&nbsp;&nbsp;&nbsp;<img src="images/refresh.png" 
                onclick="reloadCaptchaDinamis('captchaImage', '../json/CaptchaSecurityImages.php')" style="cursor:pointer" title="refresh captcha">
                </td>
            </tr>
            <tr>
                <td>Ketik Kode yang ditampilkan</td>
                <td>:</td>
                <td>
                    <input name="reqSecurity" id="reqSecurityDaftar" class="easyui-validatebox" validType="validDaftarCaptcha[]" required size="20" type="text" />
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                <input type="submit" value="Simpan" />
                <input name="reqSubmit" type="hidden" value="Daftar" />
                <input type="hidden" id="reqValKTP" value="">
                </td>
            </tr>
        </table>
        </form>
    </div>
    

</div>

