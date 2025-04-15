<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<base href="<?=base_url();?>">
<title>ERICA - PTPN 1</title>

<style>
html, body{
	height:100%;
}
body{
	font-family:Arial;
	padding-left:20px;
	padding-right:20px;
	
	margin:0 0;
	padding:0 0;
	
	display: flex;
	justify-content: center; /* align horizontal */
	align-items: center; /* align vertical */
	
	background:rgba(0,0,0,0.3);

	
}
.pilihan-wrapper{
	width:50%;
	margin:0 auto;
	*border:1px solid #1975a1;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	
	-webkit-box-shadow: 0 8px 6px -6px black;
	   -moz-box-shadow: 0 8px 6px -6px black;
	        box-shadow: 0 8px 6px -6px black;
}
.logo{
	text-align:center;
	padding-top:30px;
	padding-bottom:30px;
	
	background:rgba(255,255,255,0.3);
	
	-webkit-border-top-left-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius-topleft: 4px;
	-moz-border-radius-topright: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
}
@media screen and (max-width:767px) {
	.pilihan-wrapper{
		width:calc(100% - 40px);
	}
	.logo{
		padding-left:15px;
		padding-right:15px;
		padding-top:15px;
		padding-bottom:10px;
	}
	.logo img{
		width:100%;
	}
}
.judul{
	text-align:center;	 
	*background:#7ba4db;
	background:#1975a1;
	color:#FFF;
	padding-top:9px;
	padding-bottom:9px;
	
	border-bottom:4px solid rgba(0,0,0,0.2);
}

.pilihan{
	border:1px solid #f4f4f4;
	background:#f4f4f4;
	padding:0px 20px 10px;
	
	-webkit-border-bottom-right-radius: 4px;
	-webkit-border-bottom-left-radius: 4px;
	-moz-border-radius-bottomright: 4px;
	-moz-border-radius-bottomleft: 4px;
	border-bottom-right-radius: 4px;
	border-bottom-left-radius: 4px;
	
}
.pilihan ul{
	padding:0 0 ;
}
.pilihan ul li{
	list-style:none;
	border-bottom:1px solid rgba(0,0,0,0.2);
	padding-top:8px;
	padding-bottom:8px;
	
}
.pilihan ul li input[type=radio] {
	
}
.pilihan .aksi{
	text-align:center;
}
.pilihan input[type=submit]{
	background-color: #1975a1; background: url(images/linear_bg_2.png); background-repeat: repeat-x; 	
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#1975a1), to(#094c6c)); 	
	background: -webkit-linear-gradient(top, #1975a1, #094c6c); 	
	background: -moz-linear-gradient(top, #1975a1, #094c6c); 	
	background: -ms-linear-gradient(top, #1975a1, #094c6c); 	
	background: -o-linear-gradient(top, #1975a1, #094c6c);
	
	color:#FFF;
	padding:18px 60px;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	
	border:none;
	text-transform:uppercase;
	letter-spacing:5px;
	font-size:14px;
	
}
@media screen and (max-width:767px) {
	.pilihan input[type=button]{
		padding:18px 20px;
		width: 100%;
		margin-top: 5px;
	}
}

</style>
<script type="text/javascript" src="libraries/screen/jquery-1.6.1.min.js"></script>
</head>

<body>
<div class="pilihan-wrapper">
	
    <div class="logo"><img src="images/logo-erica.png" height="100px"></div>
    <div class="judul">Token tidak dikenali.</div>
    
</div>
</body>
</html>