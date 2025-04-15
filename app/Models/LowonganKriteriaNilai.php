<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganKriteriaNilai extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganKriteriaNilai()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_KRITERIA_NILAI_ID", $this->getSeqId("LOWONGAN_KRITERIA_NILAI_ID","LOWONGAN_KRITERIA_NILAI")); 		

		$str = "
				INSERT INTO LOWONGAN_KRITERIA_NILAI(
				            LOWONGAN_KRITERIA_NILAI_ID, LOWONGAN_KRITERIA_ID, LOWONGAN_ID, 
				            NAMA, KETERANGAN, NILAI_HURUF, 
				            NILAI_ANGKA, CREATED_BY, CREATED_DATE)
				    VALUES ('".$this->getField("LOWONGAN_KRITERIA_NILAI_ID")."', '".$this->getField("LOWONGAN_KRITERIA_ID")."', '".$this->getField("LOWONGAN_ID")."', 
				            '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."', '".$this->getField("NILAI_HURUF")."', 
				            '".$this->getField("NILAI_ANGKA")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("LOWONGAN_KRITERIA_NILAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_KRITERIA_NILAI
				   SET LOWONGAN_KRITERIA_ID 		= '".$this->getField("LOWONGAN_KRITERIA_ID")."',
				       LOWONGAN_ID 					= '".$this->getField("LOWONGAN_ID")."',
				       NAMA 						= '".$this->getField("NAMA")."',
				       KETERANGAN 					= '".$this->getField("KETERANGAN")."',
				       NILAI_HURUF 					= '".$this->getField("NILAI_HURUF")."',
				       NILAI_ANGKA 					= '".$this->getField("NILAI_ANGKA")."',
				       UPDATED_BY 			= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 			= ".$this->getField("UPDATED_DATE")."
				 WHERE LOWONGAN_KRITERIA_NILAI_ID	= '".$this->getField("LOWONGAN_KRITERIA_NILAI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM LOWONGAN_KRITERIA_NILAI
                WHERE 
                  LOWONGAN_KRITERIA_NILAI_ID = ".$this->getField("LOWONGAN_KRITERIA_NILAI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM LOWONGAN_KRITERIA_NILAI
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_KRITERIA_NILAI_ID ASC ")
	{
		$str = "
				SELECT LOWONGAN_KRITERIA_NILAI_ID, LOWONGAN_KRITERIA_ID, LOWONGAN_ID, 
				       NAMA, KETERANGAN, NILAI_HURUF, NILAI_ANGKA, CREATED_BY, 
				       CREATED_DATE, UPDATED_BY, UPDATED_DATE
				  FROM LOWONGAN_KRITERIA_NILAI A
			  	 WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_KRITERIA_NILAI_ID ASC ")
	{
		$str = "
				SELECT LOWONGAN_KRITERIA_NILAI_ID, A.LOWONGAN_KRITERIA_ID, A.LOWONGAN_ID, 
				       A.NAMA, A.KETERANGAN, NILAI_HURUF, NILAI_ANGKA, A.CREATED_BY, 
				       A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE,
				       B.NAMA NAMA_KRITERIA_LOWONGAN, C.NAMA NAMA_LOWONGAN
				  FROM LOWONGAN_KRITERIA_NILAI A
			 LEFT JOIN LOWONGAN_KRITERIA B ON A.LOWONGAN_KRITERIA_ID = B.LOWONGAN_KRITERIA_ID
			 LEFT JOIN LOWONGAN C ON A.LOWONGAN_ID = C.LOWONGAN_ID
				  WHERE 1 = 1
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
				SELECT LOWONGAN_KRITERIA_NILAI_ID, LOWONGAN_KRITERIA_ID, LOWONGAN_ID, 
				       NAMA, KETERANGAN, NILAI_HURUF, NILAI_ANGKA, CREATED_BY, 
				       CREATED_DATE, UPDATED_BY, UPDATED_DATE
				  FROM LOWONGAN_KRITERIA_NILAI A
			  	 WHERE 1 = 1
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
    * @return long Jumlah record yang sesuai LOWONGAN_KRITERIA_NILAI 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_NILAI_ID) AS ROWCOUNT FROM LOWONGAN_KRITERIA_NILAI A
		        WHERE LOWONGAN_KRITERIA_NILAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_NILAI_ID) AS ROWCOUNT 
				  FROM LOWONGAN_KRITERIA_NILAI A
			 LEFT JOIN LOWONGAN_KRITERIA B ON A.LOWONGAN_KRITERIA_ID = B.LOWONGAN_KRITERIA_ID
			 LEFT JOIN LOWONGAN C ON A.LOWONGAN_ID = C.LOWONGAN_ID
		         WHERE LOWONGAN_KRITERIA_NILAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_NILAI_ID) AS ROWCOUNT FROM LOWONGAN_KRITERIA_NILAI A
		        WHERE LOWONGAN_KRITERIA_NILAI_ID IS NOT NULL ".$statement; 
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