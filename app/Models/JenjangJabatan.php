<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JENJANG_JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class JenjangJabatan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function JenjangJabatan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENJANG_JABATAN_ID", $this->getSeqId("JENJANG_JABATAN_ID","JENJANG_JABATAN")); 		

		$str = "
				INSERT INTO JENJANG_JABATAN (
				   JENJANG_JABATAN_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE 
 			  	VALUES (
				  ".$this->getField("JENJANG_JABATAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE JENJANG_JABATAN
				SET    
					   NAMA           	= '".$this->getField("NAMA")."',
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE").",
				WHERE  JENJANG_JABATAN_ID     = '".$this->getField("JENJANG_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM JENJANG_JABATAN
                WHERE 
                  JENJANG_JABATAN_ID = ".$this->getField("JENJANG_JABATAN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
		//echo $str;
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY JENJANG_JABATAN_ID ASC ")
	{
		$str = "
				  SELECT JENJANG_JABATAN_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM JENJANG_JABATAN A
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
				SELECT JENJANG_JABATAN_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM JENJANG_JABATAN A
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
		$str = "SELECT COUNT(JENJANG_JABATAN_ID) AS ROWCOUNT 
				FROM JENJANG_JABATAN A
		        WHERE JENJANG_JABATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JENJANG_JABATAN_ID) AS ROWCOUNT 
				FROM JENJANG_JABATAN
		        WHERE JENJANG_JABATAN_ID IS NOT NULL ".$statement; 
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