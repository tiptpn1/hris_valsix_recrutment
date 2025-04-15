<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/global-tab-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<script type="text/javascript">

    $(function(){
        refreshing_Captcha();
        $('#ff').form({
			url:'registrasi_akun',
            onSubmit:function(){
				var f = this;
				var opts = $.data(this, 'form').options;
				
				
				if($(this).form('validate') == false){
					return false;
				}

				$.messager.confirm('Konfirmasi','Apakah data yang anda isikan benar? karena data yang telah anda isi tidak dapat diubah.',function(r){
					if (r){
                        var win = $.messager.progress({
                            title:'Proses registrasi.',
                            msg:'Proses registrasi akun pelamar...'
                        });

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
                $.messager.progress('close');

                data = JSON.parse(data);
                if(data.status == "success")
                    $.messager.alertLink('Info', data.message, 'info', 'app/index/home');
                else
                    $.messager.alert('Info', data.message, 'warning');

            }
        });
    });
    // $.fn.combobox.extends = {}
    // (function(){
    // // var destroy = $.fn.combobox.methods.destroy;
    // $.extend($.fn.combobox.methods, {
    //       destroy: function() {
    //     this.wrapper.remove();
    //     this.button.remove();
    //     this.element.show();
    //     $.Widget.prototype.destroy.call( this );
    // }
    // })
    // });
    // $.fn.combobox.methods.destroy = function(){
    //     // this.wrapper.remove();
    //     // this.button.remove();
    //     this.element.show();
    //     $.Widget.prototype.destroy.call( this )
    // }
</script>

<div class="col-lg-12">
	<div id="judul-halaman">Registrasi Pelamar</div>
    <div id="data-form">

        <div class="keterangan">
        <strong>Perhatian :</strong><br />
    	<ul>
        <li>Selama proses rekrutmen &amp; seleksi, pelamar TIDAK DIPUNGUT BIAYA dalam bentuk apapun</li>
        <li>Keputusan panitia rekrutmen &amp; seleksi adalah MUTLAK dan TIDAK DAPAT DIGANGGU GUGAT</li>
        </ul>
        </div>


    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<table>
        	<tr>
            	<td>No. NIK</td>
                <td>:</td>
                <td>
                <input name="reqNoKtp" id="reqNoKtp" class="easyui-validatebox"  style="width:200px;" value="<?=$NIK_DAFTAR?>" required readonly>
                </td>
            </tr>
        	<tr>
            	<td>Nama Lengkap</td>
                <td>:</td>
                <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required  type="text" style="width:400px;" maxlength="150"  />
                </td>
            </tr>
        	<tr>
            	<td>No. Handphone</td>
                <td>:</td>
                <td>
                <input name="reqTelepon" id="reqTelepon" class="easyui-validatebox" required type="text" style="width:200px;" onKeyUp="CekNumber('reqTelepon')" maxlength="15"  />
                </td>
            </tr>
            <tr>
                <td>Kota Lahir / Tanggal Lahir</td>
                <td>:</td>
                <td>
					<input name="reqTempat" id="reqTempat" class="easyui-validatebox" size="20" required value="" />
                    <input name="reqTanggal" id="reqTanggal" class="easyui-datebox" data-options="required:true" required type="text" style="width:150px"/>
                </td>
            </tr>
            <tr>
            	<td>Email</td>
                <td>:</td>
                <td>
                <input name="reqEmail" type="text" size="40" id="reqEmail1" data-options="validType:['email']" class="easyui-validatebox" required style="width:272px;" />
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
                <img src="login/captcha" id='image_captcha' onclick="refreshing_Captcha();">
                </td>
            </tr>
            <tr>
                <td>Ketik Kode yang ditampilkan</td>
                <td>:</td>
                <td>
                    <input name="reqSecurity" id="reqSecurityDaftar" class="easyui-validatebox reqCaptcha" maxlength="5" required size="20" type="text" />
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                <input type="submit" value="Registrasi" />
                <input name="reqSubmit" type="hidden" value="Daftar" />
                <input type="hidden" id="reqValKTP" value="">
                </td>
            </tr>

            
            @csrf  
        </table>
        </form>
    </div>


</div>

