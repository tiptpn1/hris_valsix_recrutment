<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Rekomendasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Rekomendasi()
	{
      parent::__construct(); 
    }
	

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("REKOMENDASI_ID", $this->getNextUrutId("REKOMENDASI_ID","REKOMENDASI"));
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO REKOMENDASI (
				   REKOMENDASI_ID, NAMA, PROSENTASE
				   ) 
 			  	VALUES (
				  ".$this->getField("REKOMENDASI_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PROSENTASE")."'
				)"; 
		$this->id = $this->getField("REKOMENDASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE REKOMENDASI
			   SET 
			   	   NAMA = '".$this->getField("NAMA")."',
			   	   PROSENTASE = '".$this->getField("PROSENTASE")."'
			 WHERE REKOMENDASI_ID = '".$this->getField("REKOMENDASI_ID")."'
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "SELECT REKOMENDASI_ID, NAMA, PROSENTASE
  				FROM REKOMENDASI
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
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NAMA) AS ROWCOUNT FROM REKOMENDASI A
		        WHERE 0=0 ".$statement; 
		
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
  } 
?>