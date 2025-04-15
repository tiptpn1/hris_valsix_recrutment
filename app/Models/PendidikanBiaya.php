<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel pendidikan_biaya.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PendidikanBiaya extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PendidikanBiaya()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENDIDIKAN_BIAYA_ID", $this->getSeqId("PENDIDIKAN_BIAYA_ID","pendidikan_biaya")); 		

		$str = "
				INSERT INTO pendidikan_biaya (
				   PENDIDIKAN_BIAYA_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE)   
 			  	VALUES (
				  ".$this->getField("PENDIDIKAN_BIAYA_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pendidikan_biaya
				SET    
					   NAMA           		= '".$this->getField("NAMA")."',
					   KETERANGAN    		= '".$this->getField("KETERANGAN")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  PENDIDIKAN_BIAYA_ID  = '".$this->getField("PENDIDIKAN_BIAYA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pendidikan_biaya
                WHERE 
                  PENDIDIKAN_BIAYA_ID = ".$this->getField("PENDIDIKAN_BIAYA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT PENDIDIKAN_BIAYA_ID, NAMA, KETERANGAN
				FROM pendidikan_biaya
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
				SELECT PENDIDIKAN_BIAYA_ID, NAMA, KETERANGAN
				FROM pendidikan_biaya
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
		$str = "SELECT COUNT(PENDIDIKAN_BIAYA_ID) AS ROWCOUNT FROM pendidikan_biaya
		        WHERE PENDIDIKAN_BIAYA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENDIDIKAN_BIAYA_ID) AS ROWCOUNT FROM pendidikan_biaya
		        WHERE PENDIDIKAN_BIAYA_ID IS NOT NULL ".$statement; 
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