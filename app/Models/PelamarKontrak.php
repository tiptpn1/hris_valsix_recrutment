<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarKontrak extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarKontrak()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("PELAMAR_KONTRAK_ID", $this->getSeqId("PELAMAR_KONTRAK_ID","PELAMAR_KONTRAK")); 		

		$str = "
				INSERT INTO PELAMAR_KONTRAK(
				            PELAMAR_ID, LOWONGAN_ID, NAMA, 
				            JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, 
				            ALAMAT, TELEPON, EMAIL, 
				            KTP_NO, TANGGAL_KONTRAK, LINK_FILE, 
				            JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, KESEHATAN_NO, 
				            KESEHATAN_TANGGAL, KESEHATAN_FASKES, CREATED_BY, 
				            CREATED_DATE)
				    VALUES (".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("NAMA")."', 
				    		'".$this->getField("JENIS_KELAMIN")."', '".$this->getField("TEMPAT_LAHIR")."', ".$this->getField("TANGGAL_LAHIR").", 
				    		'".$this->getField("ALAMAT")."', ?'".$this->getField("TELEPON")."', '".$this->getField("EMAIL")."', 
				    		'".$this->getField("KTP_NO")."', ".$this->getField("TANGGAL_KONTRAK").", '".$this->getField("LINK_FILE")."', 
				    		'".$this->getField("JAMSOSTEK_NO")."', ".$this->getField("JAMSOSTEK_TANGGAL").", '".$this->getField("KESEHATAN_NO")."', 
				    		".$this->getField("KESEHATAN_TANGGAL").", '".$this->getField("KESEHATAN_FASKES")."', '".$this->getField("CREATED_BY")."', 
				    		".$this->getField("CREATED_DATE").")
				"; 
		// $this->id = $this->getField("PELAMAR_KONTRAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "

				UPDATE PELAMAR_KONTRAK
				   SET LOWONGAN_ID 				= '".$this->getField("LOWONGAN_ID")."',
				       NAMA 					= '".$this->getField("NAMA")."',
				       JENIS_KELAMIN 			= '".$this->getField("JENIS_KELAMIN")."',
				       TEMPAT_LAHIR 			= '".$this->getField("TEMPAT_LAHIR")."',
				       TANGGAL_LAHIR 			= ".$this->getField("TANGGAL_LAHIR").",
				       ALAMAT 					= '".$this->getField("ALAMAT")."',
				       TELEPON 					= '".$this->getField("TELEPON")."',
				       EMAIL 					= '".$this->getField("EMAIL")."',
				       KTP_NO 					= '".$this->getField("KTP_NO")."',
				       TANGGAL_KONTRAK 			= ".$this->getField("TANGGAL_KONTRAK").",
				       LINK_FILE 				= '".$this->getField("LINK_FILE")."',
				       JAMSOSTEK_NO 			= '".$this->getField("JAMSOSTEK_NO")."',
				       JAMSOSTEK_TANGGAL 		= ".$this->getField("JAMSOSTEK_TANGGAL").",
				       KESEHATAN_NO 			= '".$this->getField("KESEHATAN_NO")."',
				       KESEHATAN_TANGGAL 		= ".$this->getField("KESEHATAN_TANGGAL").",
				       KESEHATAN_FASKES 		= '".$this->getField("KESEHATAN_FASKES")."',
				       UPDATED_BY 		= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 		= ".$this->getField("UPDATED_DATE")."
				 WHERE PELAMAR_ID 				= '".$this->getField("PELAMAR_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateKontrak()
	{
		$str = "

				UPDATE PELAMAR_KONTRAK
				   SET LINK_FILE 				= '".$this->getField("LINK_FILE")."',
				       TANGGAL_KONTRAK 			= ".$this->getField("TANGGAL_KONTRAK").",
				       UPDATED_BY 		= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 		= ".$this->getField("UPDATED_DATE")."
				 WHERE PELAMAR_ID 				= '".$this->getField("PELAMAR_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateBpjs()
	{
		$str = "

				UPDATE PELAMAR_KONTRAK
				   SET JAMSOSTEK_NO 			= '".$this->getField("JAMSOSTEK_NO")."',
				       JAMSOSTEK_TANGGAL 		= ".$this->getField("JAMSOSTEK_TANGGAL").",
				       KESEHATAN_NO 			= '".$this->getField("KESEHATAN_NO")."',
				       KESEHATAN_TANGGAL 		= ".$this->getField("KESEHATAN_TANGGAL").",
				       KESEHATAN_FASKES 		= '".$this->getField("KESEHATAN_FASKES")."',
				       UPDATED_BY 		= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 		= ".$this->getField("UPDATED_DATE")."
				 WHERE PELAMAR_ID 				= '".$this->getField("PELAMAR_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PELAMAR_KONTRAK
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }


    function insertDataDiterima()
    {
    	$str = "
    			INSERT INTO PELAMAR_KONTRAK(
				            PELAMAR_ID, LOWONGAN_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				            TANGGAL_LAHIR, ALAMAT, TELEPON, EMAIL, KTP_NO, KODE_LOWONGAN, JABATAN_LOWONGAN, PENEMPATAN)
				SELECT A.PELAMAR_ID, B.LOWONGAN_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, A.ALAMAT, TELEPON, A.EMAIL, KTP_NO, 
				G.KODE KODE_LOWONGAN, H.NAMA JABATAN_LOWONGAN, G.PENEMPATAN FROM PELAMAR A 
				INNER JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_DITERIMA F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN LOWONGAN G ON B.LOWONGAN_ID = G.LOWONGAN_ID
				LEFT JOIN JABATAN H ON G.JABATAN_ID = H.JABATAN_ID
				WHERE 1 = 1 AND F.DITERIMA = '1'
				AND F.LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
				"; 

		$this->query = $str;
		
		return $this->execQuery($str);
    }


    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_ID, LOWONGAN_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				       TANGGAL_LAHIR, ALAMAT, TELEPON, EMAIL, KTP_NO, TANGGAL_KONTRAK, 
				       LINK_FILE, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, KESEHATAN_NO, KESEHATAN_TANGGAL, 
				       KESEHATAN_FASKES, CREATED_BY, CREATED_DATE, UPDATED_BY, 
				       UPDATED_DATE
				  FROM PELAMAR_KONTRAK A
 				WHERE 1=1 
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_ID, A.LOWONGAN_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				       TANGGAL_LAHIR, ALAMAT, TELEPON, EMAIL, KTP_NO, TANGGAL_KONTRAK, 
				       A.LINK_FILE, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, KESEHATAN_NO, KESEHATAN_TANGGAL, 
				       KESEHATAN_FASKES, A.CREATED_BY, A.CREATED_DATE, A.UPDATED_BY, 
				       A.UPDATED_DATE, CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki-laki' ELSE 'Perempuan' END JENIS_KELAMIN_KET
				  FROM PELAMAR_KONTRAK A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
				WHERE 1=1 
				";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.PELAMAR_ID, 
						A.TANGGAL_KONTRAK, 
						A.LINK_FILE, 
						A.CREATED_BY, 
		      	 		A.CREATED_DATE, 
		      	 		A.UPDATED_BY, 
		      	 		A.UPDATED_DATE
 					FROM PELAMAR_KONTRAK A
 				WHERE 1=1 
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM PELAMAR_KONTRAK A
		        WHERE PELAMAR_ID IS NOT NULL ".$statement ;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT 
				  FROM PELAMAR_KONTRAK A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
		        WHERE PELAMAR_ID IS NOT NULL ".$statement; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM PELAMAR_KONTRAK
		        WHERE PELAMAR_ID IS NOT NULL ".$statement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
  } 
?>