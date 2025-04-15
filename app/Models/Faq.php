<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel FAQ.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Faq extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Faq()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("FAQ_ID", $this->getSeqId("FAQ_ID","FAQ"));

		$str = "
				INSERT INTO FAQ (
				   FAQ_ID, PERTANYAAN, JAWABAN, NO_URUT) 
 			  	VALUES (
				  ".$this->getField("FAQ_ID").",
				  '".$this->getField("PERTANYAAN")."',
				  '".$this->getField("JAWABAN")."',
				  '".$this->getField("NO_URUT")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE FAQ
				SET    
					   PERTANYAAN	= '".$this->getField("PERTANYAAN")."',
					   JAWABAN	 	= '".$this->getField("JAWABAN")."',
					   NO_URUT	 	= '".$this->getField("NO_URUT")."'
				WHERE  FAQ_ID  		= '".$this->getField("FAQ_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM FAQ
                WHERE 
                  FAQ_ID = ".$this->getField("FAQ_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NO_URUT ASC")
	{
		$str = "
					SELECT FAQ_ID, PERTANYAAN, JAWABAN, NO_URUT
					FROM FAQ A WHERE FAQ_ID IS NOT NULL
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
					SELECT FAQ_ID, PERTANYAAN, JAWABAN, NO_URUT
					FROM FAQ A WHERE FAQ_ID IS NOT NULL
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_URUT ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(FAQ_ID) AS ROWCOUNT FROM FAQ
		        WHERE FAQ_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(FAQ_ID) AS ROWCOUNT FROM FAQ
		        WHERE FAQ_ID IS NOT NULL ".$statement; 
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