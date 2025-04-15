<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes



include_once("libraries/MPDF60/mpdf.php");



/* END VALIDASI */
/*$mpdf = new mPDF('c','LEGAL',0,'',2,2,2,2,2,2,'L');*/
//$mpdf = new mPDF('c','LEGAL',0,'',15,15,16,16,9,9, 'L');
$mpdf = new mPDF('c','A4');
$mpdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            15, // margin_left
            15, // margin right
            36, // margin top
            36, // margin bottom
            9, // margin header
            9);  
//$mpdf=new mPDF('c','A4'); 
//$mpdf=new mPDF('utf-8', array(297,420));


$mpdf->mirroMargins = true;

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('css/invoice-kwitansi.css');
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

// LOAD a stylesheet
//$stylesheet = file_get_contents('css/gaya_laporan.css');
//$stylesheet = file_get_contents("gaya-report.css");
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$html = file_get_contents($this->config->item('base_url')."app/index/cetak_registrasis?reqId=".$reqId);


// Define the Header/Footer before writing anything so they appear on the first page
$mpdf->SetHTMLHeader('
	<table cellspacing="0" cellpadding="0" style="width: 100%">
  
  <tr>
    <td rowspan="2" width="30%"><img src="http://valsix.xyz/erica/images/logo-ttl.png" style="height: 50px;"></td>
    <td width="70%" style="float: left;
width: calc(100% - 200px);
text-align: center;
font-size: 34px;
line-height: 24px;
text-transform: uppercase;
padding-top: 10px;">Kartu Peserta Pelamar</td>
  </tr>
  <tr>
    <td width="70%" align="center" style="padding-top:10px"><span style="display: inline-block;
width: 100%;
font-size: 14px;
letter-spacing: 2px;
text-transform: none;text-align:center;margin-top:10px" >PTPN 1 </span></td>
  </tr>
</table>
<div  style="border-bottom: 2px solid #000000;
    border-bottom-style: solid;
    border-bottom-width: 2px;
border-style: double;
border-width: 0px 0px 4px 0px;
padding-bottom: 20px;
margin-bottom: 20px;">
    
</div>','',TRUE);
// $mpdf->SetHTMLFooter('
// <div style="text-align: center; font-family: sans-serif; font-size: 7pt;">
//     <div>PTPN 1</div>
// 	<div>Jl. Raya Tambak Osowilangun Km. 12 Surabaya</div>
// 	<div>Telepon/Faksimili : (031) 99001500 / (031) 99001490</div>
// 	<div>Website : <span style="text-decoration: underline; color: blue;">www.teluklamong.co.id</span> Email : terminal@teluklamong.co.id </div>
// </div>');

$mpdf->WriteHTML($html,2);

$mpdf->Output('ba_opening.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
?>

