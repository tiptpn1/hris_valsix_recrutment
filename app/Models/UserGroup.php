<? 
/* *******************************************************************************************************
MODUL NAME 			: RAIS
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
class UserGroup extends Entity{ 

  	var $query;
	var $id;

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.USER_GROUP_ID ASC")
	{
		$str = "
			SELECT 
			USER_GROUP_ID, KODE, NAMA, 
			   CREATED_BY, CREATED_DATE, UPDATED_BY, 
			   UPDATED_DATE
			FROM USER_GROUP A
			WHERE 1=1 ";
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val'";
		}

		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
	}


} 
?>