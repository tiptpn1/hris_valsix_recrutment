<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel TAHAPAN_TES.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class TahapanTes extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function TahapanTes()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TAHAPAN_TES_ID", $this->getSeqId("TAHAPAN_TES_ID","TAHAPAN_TES"));
		$this->setField("URUT", $this->getNextUrutId("URUT","TAHAPAN_TES"));

		$str = "
				INSERT INTO TAHAPAN_TES (
				   TAHAPAN_TES_ID, URUT, NAMA, UPDATED_BY, UPDATED_DATE) 
 			  	VALUES (
				  ".$this->getField("TAHAPAN_TES_ID").",
				  ".$this->getField("URUT").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->id = $this->getField("TAHAPAN_TES_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE TAHAPAN_TES
				SET    
					   NAMA	 				= '".$this->getField("NAMA")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  TAHAPAN_TES_ID  		= '".$this->getField("TAHAPAN_TES_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM TAHAPAN_TES
                WHERE 
                  TAHAPAN_TES_ID = ".$this->getField("TAHAPAN_TES_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA DESC")
	{
		$str = "
					SELECT TAHAPAN_TES_ID, A.URUT, A.NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
					FROM TAHAPAN_TES A
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
					SELECT TAHAPAN_TES_ID, A.URUT, A.NAMA, B.NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
					FROM TAHAPAN_TES A 
					LEFT JOIN PELAMAR B ON B.URUT = A.URUT
					WHERE 1=1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TAHAPAN_TES_ID) AS ROWCOUNT FROM TAHAPAN_TES A
				TAHAPAN_TES B ON B.URUT = A.URUT
		        WHERE 1=1 ".$statement; 
		
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
		$str = "SELECT COUNT(TAHAPAN_TES_ID) AS ROWCOUNT FROM TAHAPAN_TES A
				TAHAPAN_TES B ON B.URUT = A.URUT
		        WHERE 1=1 ".$statement; 
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