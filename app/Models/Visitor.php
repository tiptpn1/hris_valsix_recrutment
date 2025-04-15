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

class Visitor extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Visitor()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("AANWIJZING_ID", $this->getSeqId("AANWIJZING_ID","AANWIJZING")); 

		$str = "
				INSERT INTO VISITOR (
				   IP, TANGGAL, HITS, 
   					STATUS) 
				VALUES (
				  '".$this->getField("IP")."', 
				  CURRENT_DATE, 
				  '".$this->getField("HITS")."', 
				  '".$this->getField("STATUS")."'
				)"; 
				//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function getOnline($time='', $ip='')
	{
		$str = " SELECT 1 TOTAL FROM VISITOR WHERE IP = '" . $ip . "' AND TANGGAL = CURRENT_DATE "; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("TOTAL"); 
		else 
			return 0; 
    }
	
    function hitsToday()
	{
		$str = " SELECT SUM(HITS) TOTAL FROM VISITOR
				 WHERE TANGGAL = CURRENT_DATE  GROUP BY CURRENT_DATE "; 
		
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("TOTAL"); 
		else 
			return 0; 
    }
	
	function totalHits()
	{
		$str = " SELECT SUM(HITS) as TOTAL FROM VISITOR "; 
		
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("TOTAL"); 
		else 
			return 0; 
    }

	function countOnline($diff='')
	{
		$str = " SELECT COUNT(*) TOTAL FROM VISITOR WHERE STATUS > " . $diff . " "; 
		
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("TOTAL"); 
		else 
			return 0; 
    }
  } 
?>