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

class Rekapitulasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Rekapitulasi()
	{
      parent::__construct(); 
    }
	

	
    function selectByParamsRekapGelombang($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KATEGORI_KRITERIA_ID ")
	{
		$str = "SELECT 
					PERIODE_ID, KODE_KRITERIA, KETERANGAN, 
					   GELOMBANG_KE, GELOMBANG_TANGGAL, GELOMBANG_JAM, 
					   GELOMBANG_LOKASI, TOTAL_PELAMAR, TOTAL_HADIR
					FROM REKAP_GELOMBANG A
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
	
	function getCountByParamsRekapGelombang($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM REKAP_GELOMBANG A
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