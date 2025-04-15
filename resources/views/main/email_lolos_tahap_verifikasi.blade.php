<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

<!--<script type="text/javascript" src="../jquery.qrcode.min.js"></script> -->
<script type="text/javascript" src="libraries/jquery-qrcode-master/src/jquery.qrcode.js"></script>
<script type="text/javascript" src="libraries/jquery-qrcode-master/src/qrcode.js"></script>

<style>
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    border-radius: 4px;
}
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.text-uppercase {
    text-transform: uppercase;
}
.text-center {
    text-align: center;
}
#qrcodeCanvas canvas{
	width: 130px !important;
	height: 130px !important;
}
</style>

</head>

<body>
<div class="container">
	<div class="row">
    	<div class="col-md-8 col-md-pull-4">
			<div class="area-email-lolos-tahap">
            <div class="alert alert-success text-center text-uppercase">
            	<h3>Selamat, Anda lolos tahap verifikasi</h3>
            </div>
            
            <div class="alert alert-warning">
            	Harap datang ke :<br>
                PTPN 1<br>
                JL. Raya Tambak Osowilangon km 12<br>
                Surabaya 60191<br>
                Jawa Timur, Indonesia<br><br>
                
                <table>
                	<tr>
                    	<td>Pada</td>
                        <td style="padding-left: 20px; padding-right: 20px;">:</td>
                        <td>Rabu, 08 April 2020</td>
                    </tr>
                	<tr>
                    	<td>Pukul</td>
                        <td style="padding-left: 20px; padding-right: 20px;">:</td>
                        <td>08:00 WIB</td>
                    </tr>
                	<tr>
                    	<td>Keperluan</td>
                        <td style="padding-left: 20px; padding-right: 20px;">:</td>
                        <td><strong class="text-uppercase">Test TOEFL</strong></td>
                    </tr>
                </table>
            </div>
            
            <table style="width: 100%;">
            	<tr>
                	<td style="vertical-align: top; padding-right: 20px; width: 250px;">
                    	<div class="text-muted">
                            Tunjukkan QR Code berikut<br>
                            untuk proses absensi :<br><br>
                        </div>
                    </td>
                    <td style="vertical-align: top;">
                    	<div id="qrcodeCanvas"></div>
                    </td>
                    <td style="vertical-align: bottom; text-align: center;">
                    	Surabaya, 07 April 2020<br><br>
                    	TTD<br>
                        <strong style="text-transform: uppercase;">Panitia Seleksi</strong>
                    </td>
                </tr>
            </table>
            
        
        </div>
        
        </div>
    </div>
</div>


</body>


<script>
	//jQuery('#qrcode').qrcode("this plugin is great");
	jQuery('#qrcodeTable').qrcode({
		render	: "table",
		text	: "http://jetienne.com"
	});	
	jQuery('#qrcodeCanvas').qrcode({
		text	: "http://jetienne.com"
	});	
</script>

</html>