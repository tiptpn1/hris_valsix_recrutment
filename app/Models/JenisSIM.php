<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class JenisSIM extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function JenisSIM()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_SIM_ID", $this->getSeqId("JENIS_SIM_ID","JENIS_SIM")); 		

		$str = "
				INSERT INTO JENIS_SIM
						(JENIS_SIM_ID, KODE, NAMA, KETERANGAN,URUT)
				 VALUES ('".$this->getField("JENIS_SIM_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."','".$this->getField("URUT")."')
				"; 
		$this->id = $this->getField("JENIS_SIM_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE JENIS_SIM
				   SET KODE = '".$this->getField("KODE")."',
					   NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   URUT = '".$this->getField("URUT")."'
				WHERE  JENIS_SIM_ID     = '".$this->getField("JENIS_SIM_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM JENIS_SIM
                WHERE 
                  JENIS_SIM_ID = ".$this->getField("JENIS_SIM_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY JENIS_SIM_ID ASC ")
	{
		$str = "
				SELECT JENIS_SIM_ID, KODE, NAMA, KETERANGAN, URUT
				  FROM JENIS_SIM A
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
				SELECT JENIS_SIM_ID, KODE, NAMA, KETERANGAN, URUT
				FROM JENIS_SIM A
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
		$str = "SELECT COUNT(JENIS_SIM_ID) AS ROWCOUNT FROM JENIS_SIM A
		        WHERE JENIS_SIM_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JENIS_SIM_ID) AS ROWCOUNT FROM JENIS_SIM
		        WHERE JENIS_SIM_ID IS NOT NULL ".$statement; 
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