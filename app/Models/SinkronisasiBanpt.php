<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class SinkronisasiBanpt extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function SinkronisasiBanpt()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("UNIVERSITAS", $this->getSeqId("UNIVERSITAS","SINKRONISASI_BANPT")); 		

		$str = "
				INSERT INTO SINKRONISASI_BANPT
						(UNIVERSITAS, JURUSAN, STRATA, AKREDITASI, TANGGAL_KADALUARSA, STATUS, LAST_SINKRON_DATE)
				 VALUES ('".$this->getField("UNIVERSITAS")."', '".$this->getField("JURUSAN")."', 
				 		 '".$this->getField("STRATA")."', '".$this->getField("AKREDITASI")."', 
						 '".$this->getField("TANGGAL_KADALUARSA")."', '".$this->getField("STATUS")."', CURRENT_DATE)
				"; 
		// $this->id = $this->getField("UNIVERSITAS");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE SINKRONISASI_BANPT
				   SET JURUSAN 				= '".$this->getField("JURUSAN")."',
					   LAST_SINKRON_DATE 	= ".$this->getField("LAST_SINKRON_DATE")."
				WHERE  UNIVERSITAS     		= '".$this->getField("UNIVERSITAS")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SINKRONISASI_BANPT
                WHERE 
                  UNIVERSITAS = ".$this->getField("UNIVERSITAS").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function truncate()
	{
        $str = " TRUNCATE TABLE SINKRONISASI_BANPT "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY UNIVERSITAS ASC ")
	{
		$str = "
				SELECT UNIVERSITAS, JURUSAN, LAST_SINKRON_DATE
				  FROM SINKRONISASI_BANPT A
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
				SELECT UNIVERSITAS, JURUSAN, LAST_SINKRON_DATE
				  FROM SINKRONISASI_BANPT A
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
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(UNIVERSITAS) AS ROWCOUNT FROM SINKRONISASI_BANPT A
		        WHERE UNIVERSITAS IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(UNIVERSITAS) AS ROWCOUNT FROM SINKRONISASI_BANPT
		        WHERE UNIVERSITAS IS NOT NULL ".$statement; 
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