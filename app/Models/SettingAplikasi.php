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

class SettingAplikasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function SettingAplikasi()
	{
      parent::__construct(); 
    }
	
	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE SETTING_APLIKASI
			   SET 
			   	   NILAI = '".$this->getField("NILAI")."'
			 WHERE NAMA = '".$this->getField("NAMA")."'
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				NAMA, KETERANGAN, NILAI
				FROM SETTING_APLIKASI A
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
		$str = "SELECT COUNT(NAMA) AS ROWCOUNT FROM SETTING_APLIKASI A
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