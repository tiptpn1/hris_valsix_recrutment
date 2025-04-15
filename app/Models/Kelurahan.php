<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Kelurahan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Kelurahan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KELURAHAN_ID", $this->getSeqId("KELURAHAN_ID","KELURAHAN")); 		

		$str = "
				INSERT INTO KELURAHAN
						(KELURAHAN_ID, KECAMATAN_ID, NAMA, KETERAGAN)
				 VALUES (".$this->getField("KELURAHAN_ID").",  ".$this->getField("KECAMATAN_ID").", 
				 		'".$this->getField("NAMA")."' ,'".$this->getField("KETERANGAN")."')
				"; 
		$this->id = $this->getField("KELURAHAN_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE KELURAHAN
				   SET NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  KELURAHAN_ID     = '".$this->getField("KELURAHAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KELURAHAN
                WHERE 
                  KELURAHAN_ID = ".$this->getField("KELURAHAN_ID").""; 
				  
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

		$str = "SELECT KELURAHAN_ID, KECAMATAN_ID, NAMA, KETERAGAN
  				FROM KELURAHAN
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
		$str = "SELECT KELURAHAN_ID, A.KECAMATAN_ID, A.NAMA KELURAHAN, A.KETERAGAN, B.NAMA KECAMATAN, C.NAMA KOTA, D.NAMA PROVINSI
  				FROM KELURAHAN A
  				LEFT JOIN KECAMATAN B ON A.KECAMATAN_ID = B.KECAMATAN_ID
  				LEFT JOIN KOTA C ON C.KOTA_ID = B.KOTA_ID
  				LEFT JOIN PROVINSI D ON C.PROVINSI_ID = D.PROVINSI_ID 
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
		$str = "SELECT KELURAHAN_ID, KECAMATAN_ID, NAMA, KETERAGAN
  				FROM KELURAHAN
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
		$str = "SELECT COUNT(KELURAHAN_ID) AS ROWCOUNT FROM KELURAHAN A
		        WHERE KELURAHAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KELURAHAN_ID) AS ROWCOUNT 
				 FROM KELURAHAN A
  				LEFT JOIN KECAMATAN B ON A.KECAMATAN_ID = B.KECAMATAN_ID
  				LEFT JOIN KOTA C ON C.KOTA_ID = B.KOTA_ID
  				LEFT JOIN PROVINSI D ON C.PROVINSI_ID = D.PROVINSI_ID 
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
		$str = "SELECT COUNT(KELURAHAN_ID) AS ROWCOUNT FROM KELURAHAN
		        WHERE KELURAHAN_ID IS NOT NULL ".$statement; 
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