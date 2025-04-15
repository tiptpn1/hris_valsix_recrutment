<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Kriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Kriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KRITERIA_ID", $this->getSeqId("KRITERIA_ID","KRITERIA")); 		

		$str = "
				INSERT INTO KRITERIA(
			            KRITERIA_ID, KATEGORI_KRITERIA_ID, NAMA, KETERANGAN, 
			            BOBOT, CREATED_BY, CREATED_DATE)
			    VALUES ('".$this->getField("KRITERIA_ID")."', '".$this->getField("KATEGORI_KRITERIA_ID")."', '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."', 
			    		'".$this->getField("BOBOT")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("KRITERIA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE KRITERIA
				   SET NAMA 				= '".$this->getField("NAMA")."', 
				   	   KETERANGAN			= '".$this->getField("KETERANGAN")."', 
				   	   BOBOT				= '".$this->getField("BOBOT")."', 
				       UPDATED_BY		= '".$this->getField("UPDATED_BY")."', 
				       UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				 WHERE KRITERIA_ID     		= '".$this->getField("KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KRITERIA
                WHERE 
                  KRITERIA_ID = ".$this->getField("KRITERIA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY KRITERIA_ID ASC ")
	{
		$str = "
				SELECT A.KRITERIA_ID, A.KATEGORI_KRITERIA_ID, A.NAMA, A.KETERANGAN, BOBOT, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM KRITERIA A
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
	
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY KRITERIA_ID ASC ")
	{
		$str = "
				SELECT A.KRITERIA_ID, A.KATEGORI_KRITERIA_ID, B.NAMA KATEGORI, A.NAMA, A.KETERANGAN, A.BOBOT, A.CREATED_BY, A.CREATED_DATE, 
				       A.UPDATED_BY, A.UPDATED_DATE
				  FROM KRITERIA A
				  INNER JOIN KATEGORI_KRITERIA B ON A.KATEGORI_KRITERIA_ID = B.KATEGORI_KRITERIA_ID
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
				SELECT KRITERIA_ID, NAMA, KETERANGAN, BOBOT, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM KRITERIA A
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
		$str = "SELECT COUNT(KRITERIA_ID) AS ROWCOUNT FROM KRITERIA A
		        WHERE KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KRITERIA_ID) AS ROWCOUNT 
				FROM KRITERIA A
				INNER JOIN KATEGORI_KRITERIA B ON A.KATEGORI_KRITERIA_ID = B.KATEGORI_KRITERIA_ID
		        WHERE KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KRITERIA_ID) AS ROWCOUNT FROM KRITERIA A
		        WHERE KRITERIA_ID IS NOT NULL ".$statement; 
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