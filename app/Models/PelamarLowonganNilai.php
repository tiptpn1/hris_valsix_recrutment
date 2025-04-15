<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PELAMAR_LOWONGAN_NILAI.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganNilai extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganNilai()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_NILAI_ID", $this->getSeqId("PELAMAR_LOWONGAN_NILAI_ID","PELAMAR_LOWONGAN_NILAI"));

		$str = "
				INSERT INTO PELAMAR_LOWONGAN_NILAI(
				            PELAMAR_LOWONGAN_NILAI_ID, LOWONGAN_ID, PELAMAR_ID, 
				            LOWONGAN_KRITERIA_ID, NILAI_HURUF, NILAI_ANGKA, 
				            CREATED_BY, CREATED_DATE, PENILAI_ID,
				            LOWONGAN_KATEGORI_KRITERIA_ID, KODE_KRITERIA)
				    VALUES ('".$this->getField("PELAMAR_LOWONGAN_NILAI_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("PELAMAR_ID")."', 
				    		'".$this->getField("LOWONGAN_KRITERIA_ID")."', '".$this->getField("NILAI_HURUF")."', '".$this->getField("NILAI_ANGKA")."', 
				    		'".$this->getField("CREATED_BY")."', current_timestamp, '".$this->getField("PENILAI_ID")."',
				    		'".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', '".$this->getField("KODE_KRITERIA")."')
			  "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	
	function insertDataRekom()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_REKOM_ID", $this->getSeqId("PELAMAR_LOWONGAN_REKOM_ID","PELAMAR_LOWONGAN_REKOM"));

		$str = "
				INSERT INTO PELAMAR_LOWONGAN_REKOM(
				            PELAMAR_LOWONGAN_REKOM_ID, LOWONGAN_ID, PELAMAR_ID, 
				            PENILAI_ID, KODE_KRITERIA, REKOMENDASI, CATATAN,
				            CREATED_BY, CREATED_DATE)
				    VALUES ('".$this->getField("PELAMAR_LOWONGAN_REKOM_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("PELAMAR_ID")."', 
				    		'".$this->getField("PENILAI_ID")."', '".$this->getField("KODE_KRITERIA")."', '".$this->getField("REKOMENDASI")."', 
							'".$this->getField("CATATAN")."', 
				    		'".$this->getField("CREATED_BY")."', current_timestamp)
			  "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	
    function updateData()
	{
		$str = "
				UPDATE PELAMAR_LOWONGAN_NILAI
				   SET LOWONGAN_ID 						= '".$this->getField("LOWONGAN_ID")."',
				       PELAMAR_ID 						= '".$this->getField("PELAMAR_ID")."',
				       LOWONGAN_KRITERIA_ID 			= '".$this->getField("LOWONGAN_KRITERIA_ID")."',
				       NILAI_HURUF 						= '".$this->getField("NILAI_HURUF")."',
				       NILAI_ANGKA 						= '".$this->getField("NILAI_ANGKA")."',
				       UPDATED_BY 				= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 				= ".$this->getField("UPDATED_DATE").",
				       PENILAI_ID 						= '".$this->getField("PENILAI_ID")."'
				WHERE  PELAMAR_LOWONGAN_NILAI_ID     	= '".$this->getField("PELAMAR_LOWONGAN_NILAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
    
	function delete()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_NILAI
                WHERE 
                  PELAMAR_LOWONGAN_NILAI_ID = ".$this->getField("PELAMAR_LOWONGAN_NILAI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_NILAI
                WHERE 
                  LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
                  AND
                  PENILAI_ID  = '".$this->getField("PENILAI_ID")."'
                  AND 
                  PELAMAR_ID  = '".$this->getField("PELAMAR_ID")."'
                  AND 
                  KODE_KRITERIA  = '".$this->getField("KODE_KRITERIA")."' "; 
				  
		$this->query = $str;
		$this->execQuery($str);
		
		
		 $str = "DELETE FROM PELAMAR_LOWONGAN_REKOM
                WHERE 
                  LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
                  AND
                  PENILAI_ID  = '".$this->getField("PENILAI_ID")."'
                  AND 
                  PELAMAR_ID  = '".$this->getField("PELAMAR_ID")."'
                  AND 
                  KODE_KRITERIA  = '".$this->getField("KODE_KRITERIA")."' "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_LOWONGAN_NILAI_ID, LOWONGAN_ID, PELAMAR_ID, LOWONGAN_KRITERIA_ID, 
				       NILAI_HURUF, NILAI_ANGKA, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE, PENILAI_ID
				  FROM PELAMAR_LOWONGAN_NILAI A
		 		 WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY PELAMAR_LOWONGAN_NILAI_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsRekom($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					PELAMAR_LOWONGAN_REKOM_ID, LOWONGAN_ID, PELAMAR_ID, 
					   PENILAI_ID, KODE_KRITERIA, REKOMENDASI, 
					   CATATAN, CREATED_BY, CREATED_DATE, 
					   UPDATED_BY, UPDATED_DATE
					FROM PELAMAR_LOWONGAN_REKOM A
		 		 WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY PELAMAR_LOWONGAN_REKOM_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_LOWONGAN_NILAI_ID, A.LOWONGAN_ID, A.PELAMAR_ID, A.LOWONGAN_KRITERIA_ID, 
				       NILAI_HURUF, NILAI_ANGKA, A.CREATED_BY, A.CREATED_DATE, 
				       A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_LOWONGAN, C.NAMA NAMA_PELAMAR, 
				       PENILAI_ID
				  FROM PELAMAR_LOWONGAN_NILAI A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
			 LEFT JOIN PELAMAR C ON A.PELAMAR_ID = C.PELAMAR_ID
		 		 WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.TANGGAL_KIRIM DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_NILAI_ID) AS ROWCOUNT 
				  FROM PELAMAR_LOWONGAN_NILAI A
		         WHERE PELAMAR_LOWONGAN_NILAI_ID IS NOT NULL ".$statement; 
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
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_NILAI_ID) AS ROWCOUNT 
				  FROM PELAMAR_LOWONGAN_NILAI A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
			 LEFT JOIN PELAMAR C ON A.PELAMAR_ID = C.PELAMAR_ID
		         WHERE PELAMAR_LOWONGAN_NILAI_ID IS NOT NULL ".$statement; 
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
	
  } 
?>