<? 
  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class Konten extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Konten()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTEN_ID", $this->getSeqId("KONTEN_ID","KONTEN")); 
		
		$str = "INSERT INTO KONTEN(KONTEN_ID, NAMA, KETERANGAN) 
				VALUES(
				  ".$this->getField("KONTEN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE KONTEN SET
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateKonten()
	{
		$str = "UPDATE KONTEN SET
					  NAMA = '".$this->getField("NAMA")."',
					  KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				
		$this->query = $str;
		return $this->execQuery($str);
	}
	
	
	function delete()
	{
        $str = "DELETE FROM KONTEN
                WHERE 
                  KONTEN_ID = '".$this->getField("KONTEN_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT KONTEN_ID, NAMA, KETERANGAN
				FROM KONTEN WHERE KONTEN_ID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = $val ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY KONTEN_ID ASC";
				
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT KONTEN_ID, NAMA, KETERANGAN
				FROM KONTEN WHERE KONTEN_ID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY urut ASC, NAMA ASC";
				
		return $this->selectLimit($str,$limit,$from);
    }	
   
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(KONTEN_ID) AS ROWCOUNT FROM KONTEN WHERE KONTEN_ID IS NOT NULL "; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(KONTEN_ID) AS ROWCOUNT FROM KONTEN WHERE KONTEN_ID IS NOT NULL "; 
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
	
	function getKontenTitle($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		
		return $this->getField('NAMA');
	}
	
	function getKontenText($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		
		return $this->getField('KETERANGAN');
	}
	
  } 
?>