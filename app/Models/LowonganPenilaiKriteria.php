<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganPenilaiKriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganPenilaiKriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_PENILAI_KRITERIA_ID", $this->getSeqId("LOWONGAN_PENILAI_KRITERIA_ID","LOWONGAN_PENILAI_KRITERIA")); 		

		$str = "
				INSERT INTO LOWONGAN_PENILAI_KRITERIA(
				            LOWONGAN_PENILAI_KRITERIA_ID,
				            LOWONGAN_ID,
				            PENILAI_ID,
				            LOWONGAN_KATEGORI_KRITERIA_ID, 
				           CREATED_BY, CREATED_DATE)
				           
				    VALUES ('".$this->getField("LOWONGAN_PENILAI_KRITERIA_ID")."',
						     '".$this->getField("LOWONGAN_ID")."', 
						     '".$this->getField("PENILAI_ID")."', 
						     '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', 
				             '".$this->getField("CREATED_BY")."',
				             ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("LOWONGAN_PENILAI_KRITERIA_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_PENILAI_KRITERIA
				   SET PENILAI_ID 		= '".$this->getField("PENILAI_ID")."',
				       LOWONGAN_KATEGORI_KRITERIA_ID 					= '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."',
				      UPDATED_BY 			= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 			= ".$this->getField("UPDATED_DATE")."
				 WHERE LOWONGAN_PENILAI_KRITERIA_ID	= '".$this->getField("LOWONGAN_PENILAI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM LOWONGAN_PENILAI_KRITERIA
                WHERE 
                  LOWONGAN_PENILAI_KRITERIA_ID = ".$this->getField("LOWONGAN_PENILAI_KRITERIA_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM LOWONGAN_PENILAI_KRITERIA
                WHERE 
                  LOWONGAN_KATEGORI_KRITERIA_ID = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_PENILAI_KRITERIA_ID ASC ")
	{
		$str = "
				SELECT LOWONGAN_PENILAI_KRITERIA_ID, 
						A.PENILAI_ID, 
						A.PENILAI,
						LOWONGAN_KATEGORI_KRITERIA_ID, 
						B.NAMA,
						B.JABATAN
				  FROM LOWONGAN_PENILAI_KRITERIA A
				  LEFT JOIN PENILAI B ON A.PENILAI_ID = B.PENILAI_ID
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_PENILAI_KRITERIA_ID ASC ")
	{
		$str = "
				SELECT LOWONGAN_PENILAI_KRITERIA_ID, A.PENILAI_ID, A.LOWONGAN_KATEGORI_KRITERIA_ID, 
				       A.CREATED_BY, 
				       A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_PENILAI, B.JABATAN JABATAN_PENILAI
				  FROM LOWONGAN_PENILAI_KRITERIA A
			 LEFT JOIN PENILAI B ON A.PENILAI_ID = B.PENILAI_ID
			 LEFT JOIN LOWONGAN_KATEGORI_KRITERIA C ON A.LOWONGAN_KATEGORI_KRITERIA_ID = C.LOWONGAN_KATEGORI_KRITERIA_ID
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
				SELECT LOWONGAN_PENILAI_KRITERIA_ID, PENILAI_ID, LOWONGAN_KATEGORI_KRITERIA_ID, 
				       CREATED_BY, 
				       CREATED_DATE, UPDATED_BY, UPDATED_DATE
				  FROM LOWONGAN_PENILAI_KRITERIA A
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
    * @return long Jumlah record yang sesuai LOWONGAN_PENILAI_KRITERIA 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_PENILAI_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_PENILAI_KRITERIA A
		        WHERE LOWONGAN_PENILAI_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_PENILAI_KRITERIA_ID) AS ROWCOUNT 
				  FROM LOWONGAN_PENILAI_KRITERIA A
			 LEFT JOIN PENILAI B ON A.PENILAI_ID = B.PENILAI_ID
			 LEFT JOIN LOWONGAN_KATEGORI_KRITERIA C ON A.LOWONGAN_KATEGORI_KRITERIA_ID = C.LOWONGAN_KATEGORI_KRITERIA_ID
		         WHERE LOWONGAN_PENILAI_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_PENILAI_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_PENILAI_KRITERIA A
		        WHERE LOWONGAN_PENILAI_KRITERIA_ID IS NOT NULL ".$statement; 
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