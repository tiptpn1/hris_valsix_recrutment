<?php 
class UploadMiddleware{
	
    
    /** Verify user login. True when login is valid**/
    function upload($reqLinkFile, $prefixFile, $pegawaiId){		
	
		/* API */
		$ch = curl_init();
		$jumlahFile = count($reqLinkFile);
		
		$FILE_DIR = "uploads/";
		
		if($reqLinkFile['name'][0] == "")
		{}
		else
		{
			$renameFile1 = md5($prefixFile)."_1.".getExtension($reqLinkFile['name'][0]);
			move_uploaded_file($reqLinkFile['tmp_name'][0], $FILE_DIR.$renameFile1);
			
			$cfile1 = new CURLFile(
				realpath($FILE_DIR.$renameFile1),
				$reqLinkFile['type'][0],
				$reqLinkFile['name'][0]
			);
		}
			
		
		if($reqLinkFile['name'][1] == "")
		{}
		else
		{
			$renameFile2 = md5($prefixFile)."_2.".getExtension($reqLinkFile['name'][1]);
			move_uploaded_file($reqLinkFile['tmp_name'][1], $FILE_DIR.$renameFile2);
			
			$cfile2 = new CURLFile(
				realpath($FILE_DIR.$renameFile2),
				$reqLinkFile['type'][1],
				$reqLinkFile['name'][1]
			);
		}
			
		if($reqLinkFile['name'][2] == "")
		{}
		else
		{
			$renameFile3 = md5($prefixFile)."_2.".getExtension($reqLinkFile['name'][2]);
			move_uploaded_file($reqLinkFile['tmp_name'][2], $FILE_DIR.$renameFile3);
			
			$cfile3 = new CURLFile(
				realpath($FILE_DIR.$renameFile3),
				$reqLinkFile['type'][2],
				$reqLinkFile['name'][2]
			);
		}
		
	
		$data = array('reqLinkFile1' => $cfile1, 'reqLinkFile2' => $cfile2, 'reqLinkFile3' => $cfile3, 
					  "reqPrefixFile" => $prefixFile,
					  "reqToken" => "BYPASSHUMANIS");
		
		curl_setopt($ch, CURLOPT_URL, config('app.base_api')."apiapproval/uploads_json");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		
		if(!empty($renameFile1))
			unlink($FILE_DIR.$renameFile1);
		
		if(!empty($renameFile2))
			unlink($FILE_DIR.$renameFile2);
		
		if(!empty($renameFile3))
			unlink($FILE_DIR.$renameFile3);
		
		return $response;


    }
			   
}
	
?>
