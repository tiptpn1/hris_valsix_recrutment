<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Kota extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Kota()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KOTA_ID", $this->getSeqId("KOTA_ID","KOTA")); 		

		$str = "
				INSERT INTO KOTA
						(KOTA_ID, PROVINSI_ID, NAMA, KETERAGAN)
				 VALUES (".$this->getField("KOTA_ID").",  ".$this->getField("PROVINSI_ID").", 
				 		'".$this->getField("NAMA")."' ,'".$this->getField("KETERANGAN")."')
				"; 
		$this->id = $this->getField("KOTA_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE KOTA
				   SET NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  KOTA_ID     = '".$this->getField("KOTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KOTA
                WHERE 
                  KOTA_ID = ".$this->getField("KOTA_ID").""; 
				  
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

		$str = "SELECT KOTA_ID, PROVINSI_ID, NAMA, KETERAGAN
  				FROM KOTA
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
		$str = "SELECT KOTA_ID, A.PROVINSI_ID, A.NAMA KOTA, KETERAGAN, B.NAMA PROVINSI
  				FROM KOTA A
  				LEFT JOIN PROVINSI B ON A.PROVINSI_ID = B.PROVINSI_ID 
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
		$str = "SELECT KOTA_ID, PROVINSI_ID, NAMA, KETERAGAN
  				FROM KOTA
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
		$str = "SELECT COUNT(KOTA_ID) AS ROWCOUNT FROM KOTA A
		        WHERE KOTA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(A.KOTA_ID) AS ROWCOUNT 
				 FROM KOTA A
  				LEFT JOIN PROVINSI B ON A.PROVINSI_ID = B.PROVINSI_ID 
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
		$str = "SELECT COUNT(KOTA_ID) AS ROWCOUNT FROM KOTA
		        WHERE KOTA_ID IS NOT NULL ".$statement; 
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