<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Kecamatan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Kecamatan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KECAMATAN_ID", $this->getSeqId("KECAMATAN_ID","KECAMATAN")); 		

		$str = "
				INSERT INTO KECAMATAN
						(KECAMATAN_ID, KOTA_ID, NAMA, KETERAGAN)
				 VALUES (".$this->getField("KECAMATAN_ID").",  ".$this->getField("KOTA_ID").", 
				 		'".$this->getField("NAMA")."' ,'".$this->getField("KETERANGAN")."')
				"; 
		$this->id = $this->getField("KECAMATAN_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE KECAMATAN
				   SET NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  KECAMATAN_ID     = '".$this->getField("KECAMATAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KECAMATAN
                WHERE 
                  KECAMATAN_ID = ".$this->getField("KECAMATAN_ID").""; 
				  
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

		$str = "SELECT KECAMATAN_ID, KOTA_ID, NAMA, KETERAGAN
  				FROM KECAMATAN
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
		$str = "SELECT KECAMATAN_ID, A.KOTA_ID, A.NAMA KECAMATAN, A.KETERAGAN, B.NAMA KOTA, C.NAMA PROVINSI
  				FROM KECAMATAN A
  				LEFT JOIN KOTA B ON A.KOTA_ID = B.KOTA_ID
  				LEFT JOIN PROVINSI C ON B.PROVINSI_ID = C.PROVINSI_ID 
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
		$str = "SELECT KECAMATAN_ID, KOTA_ID, NAMA, KETERAGAN
  				FROM KECAMATAN
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
		$str = "SELECT COUNT(KECAMATAN_ID) AS ROWCOUNT FROM KECAMATAN A
		        WHERE KECAMATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(A.KECAMATAN_ID) AS ROWCOUNT 
				FROM KECAMATAN A
  				LEFT JOIN KOTA B ON A.KOTA_ID = B.KOTA_ID
  				LEFT JOIN PROVINSI C ON B.PROVINSI_ID = C.PROVINSI_ID 
				WHERE 1 = 1".$statement; 
		
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
		$str = "SELECT COUNT(KECAMATAN_ID) AS ROWCOUNT FROM KECAMATAN
		        WHERE KECAMATAN_ID IS NOT NULL ".$statement; 
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