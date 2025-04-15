<?php

/*
	* To change this template, choose Tools | Templates
	* and open the template in the editor.
	*/

/**
 * Description of Kauth
 *
 * @author user
 */
class ApprovalInfo{

	var $approvalId1;
	var $approvalNama1;
	
	var $tanggal;
	var $alasan;
	var $divAlasan;
	var $nrp;
	var $nama;
	var $jabatan;
	var $qr;
	var $nama_pemohon;
	var $jabatan_pemohon;
	var $linkqr;
	var $imageqr;
	var $approvalId;
	var $approvalNama;
	
    /******************** CONSTRUCTOR **************************************/
    function ApprovalInfo(){
		 $this->emptyProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->approvalId1 = "";
		$this->approvalNama1 = "";
    }
	
	function generateQRFile($fileReport, $reqNomor, $approvalId="")
	{		
		
		/* GENERATE QRCODE */
		if($approvalId == "")
			$qrParaf   = config('app.base_publish')."qr/".strtolower($fileReport)."/".strtoupper($reqNomor);
		else
			$qrParaf   = config('app.base_publish')."qr/".strtolower($fileReport)."/".strtoupper($reqNomor)."/".($approvalId);
		
		$fileQR = "uploads/qr/".strtoupper($fileReport."_".$reqNomor.$approvalId).".png";
		QRcode::png($qrParaf, $fileQR);

		if(file_exists($fileQR))
			return $fileQR;
		else
			return "";

		
	}

	
	function generateCustomQRFile($fileReport, $qrParaf, $dokumenId="")
	{		
		
		/* GENERATE QRCODE */
		
		$fileQR = "uploads/qr/".strtoupper($fileReport."_".$dokumenId).".png";
		QRcode::png($qrParaf, $fileQR);

		if(file_exists($fileQR))
			return $fileQR;
		else
			return "";

		
	}
		
	function generateQR($fileReport, $reqNomor, $approvalId="")
	{		
		
		/* GENERATE QRCODE */
		if($approvalId == "")
			$qrParaf   = config('app.base_publish')."qr/index/".strtolower($fileReport)."/".md5($reqNomor);
		else
			$qrParaf   = config('app.base_publish')."qr/index/".strtolower($fileReport)."/".md5($reqNomor)."/".md5($approvalId);
			
		$txt = QRcode::text($qrParaf);
		$image = QRimage::image($txt,2,2);
		ob_start();
		imagepng($image);
		$contents =  ob_get_clean();
		imagedestroy($image);
		return "<img src='data:image/png;base64,".base64_encode($contents)."' style='height:80px' />";
		
	}
		
			   
}


/***** INSTANTIATE THE GLOBAL OBJECT */
$approvalinfo = new ApprovalInfo();

?>