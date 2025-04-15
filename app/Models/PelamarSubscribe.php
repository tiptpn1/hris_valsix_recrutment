<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarSubscribe extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarSubscribe()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_SUBSCRIBE_ID", $this->getSeqId("PELAMAR_SUBSCRIBE_ID","pelamar_subscribe")); 		

		$str = "
				 INSERT INTO pelamar_subscribe(
				     PELAMAR_SUBSCRIBE_ID, BIDANG_ID, PELAMAR_ID, CREATED_BY, 
				     CREATED_DATE)
				 
				 VALUES ('".$this->getField("PELAMAR_SUBSCRIBE_ID")."', '".$this->getField("BIDANG_ID")."', '".$this->getField("PELAMAR_ID")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("PELAMAR_SUBSCRIBE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE pelamar_subscribe
				   SET PELAMAR_ID = '".$this->getField("PELAMAR_SUBSCRIBE_ID")."',
					   BIDANG = '".$this->getField("BIDANG_ID")."',
					   PELAMAR_ID = '".$this->getField("PELAMAR_ID")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  pelamar_subscribe     = '".$this->getField("pelamar_subscribe")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM pelamar_subscribe
                WHERE 
                  PELAMAR_SUBSCRIBE_ID = ".$this->getField("PELAMAR_SUBSCRIBE_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function deleteByPelamar()
	{
        $str = "DELETE FROM pelamar_subscribe
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY BIDANG_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_SUBSCRIBE_ID, A.BIDANG_ID, A.PELAMAR_ID, A,CREATED_BY, 
      	 			A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
 					FROM pelamar_subscribe A
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

    function selectByParamsKirimSubscribe($lowonganId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY B.EMAIL ASC ")
	{
		$str = "
				SELECT B.EMAIL, B.NAMA, B.PELAMAR_ID FROM pelamar_subscribe A
				INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				WHERE EXISTS(
					SELECT 1 FROM LOWONGAN X 
					INNER JOIN JABATAN Y ON X.JABATAN_ID = Y.JABATAN_ID 
					WHERE Y.BIDANG_ID = A.BIDANG_ID AND X.LOWONGAN_ID = '".$lowonganId."'
				)
				
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY BIDANG_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_SUBSCRIBE_ID, A.BIDANG_ID, A.PELAMAR_ID, A.CREATED_BY, 
      	 			A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_PELAMAR,
      	 			B.EMAIL, C.NAMA NAMA_BIDANG
 					FROM pelamar_subscribe A
 					LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
 					LEFT JOIN BIDANG C ON A.BIDANG_ID = C.BIDANG_ID
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
				SELECT PELAMAR_SUBSCRIBE_ID, A.BIDANG_ID, A.PELAMAR_ID, A.CREATED_BY, 
      	 			A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
 					FROM pelamar_subscribe A
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
		$str = "SELECT COUNT(PELAMAR_SUBSCRIBE_ID) AS ROWCOUNT FROM pelamar_subscribe A
		        WHERE PELAMAR_SUBSCRIBE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELAMAR_SUBSCRIBE_ID) AS ROWCOUNT 
				FROM pelamar_subscribe A
				LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				LEFT JOIN BIDANG C ON A.BIDANG_ID = C.BIDANG_ID
		        WHERE PELAMAR_SUBSCRIBE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELAMAR_SUBSCRIBE_ID) AS ROWCOUNT FROM pelamar_subscribe
		        WHERE PELAMAR_SUBSCRIBE_ID IS NOT NULL ".$statement; 
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