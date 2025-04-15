<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Provinsi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Provinsi()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PROVINSI_ID", $this->getSeqId("PROVINSI_ID","PROVINSI")); 		

		$str = "
				INSERT INTO PROVINSI
						(PROVINSI_ID, NAMA, KETERANGAN)
				 VALUES ('".$this->getField("PROVINSI_ID")."',  '".$this->getField("NAMA")."', 
				 		'".$this->getField("KETERANGAN")."')
				"; 
		$this->id = $this->getField("PROVINSI_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE PROVINSI
				   SET NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  PROVINSI_ID     = '".$this->getField("PROVINSI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PROVINSI
                WHERE 
                  PROVINSI_ID = ".$this->getField("PROVINSI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC ")
	{

		$str = "
				SELECT PROVINSI_ID, NAMA, KETERANGAN
  				FROM PROVINSI
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
	 
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC ")
	{
		$str = "
				SELECT PROVINSI_ID, NAMA, KETERANGAN
  				FROM PROVINSI
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
				SELECT PROVINSI_ID, NAMA, KETERANGAN
  				FROM PROVINSI
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
		$str = "SELECT COUNT(PROVINSI_ID) AS ROWCOUNT FROM PROVINSI A
		        WHERE PROVINSI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(A.PROVINSI_ID) AS ROWCOUNT 
				 FROM PROVINSI 
				  WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(PROVINSI_ID) AS ROWCOUNT FROM PROVINSI
		        WHERE PROVINSI_ID IS NOT NULL ".$statement; 
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