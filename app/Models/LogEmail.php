<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel LOG_EMAIL.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LogEmail extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LogEmail()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOG_EMAIL_ID", $this->getSeqId("LOG_EMAIL_ID","LOG_EMAIL")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO LOG_EMAIL (
				   LOG_EMAIL_ID, TAHAP, NAMA, 
				   NRP, EMAIL, STATUS, CREATED_DATE) 
 			  	VALUES (
				  ".$this->getField("LOG_EMAIL_ID").",
				  '".$this->getField("TAHAP")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NRP")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("STATUS")."',
				  current_timestamp
				)"; 
		$this->id = $this->getField("LOG_EMAIL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				LOG_EMAIL_ID, TAHAP, NAMA, NRP, EMAIL, STATUS, CREATED_DATE
				FROM LOG_EMAIL
				WHERE 1 = 1
				"; 
		//, FOTO
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOG_EMAIL_ID) AS ROWCOUNT FROM LOG_EMAIL
		        WHERE LOG_EMAIL_ID IS NOT NULL ".$statement; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOG_EMAIL_ID) AS ROWCOUNT FROM LOG_EMAIL
		        WHERE LOG_EMAIL_ID IS NOT NULL ".$statement; 
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