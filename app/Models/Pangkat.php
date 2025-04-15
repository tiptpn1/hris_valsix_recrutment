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

class Pangkat extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Pangkat()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("pangkat_id", $this->getSeqId("pangkat_id","pangkat")); 		

		$str = "INSERT INTO pangkat(pangkat_id, nama, kode)
				VALUES(
				  ".$this->getField("pangkat_id").",
				  '".$this->getField("nama")."',
				  '".$this->getField("kode")."'
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pangkat SET
				  nama = '".$this->getField("nama")."',
				  kode = '".$this->getField("kode")."'
				WHERE pangkat_id = '".$this->getField("pangkat_id")."'
				"; 
				$this->query = $str;
				//echo $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM pangkat
                WHERE 
                  pangkat_id = '".$this->getField("pangkat_id")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement = "")
	{
		$str = "SELECT pangkat_id, nama, kode FROM pangkat WHERE pangkat_id IS NOT NULL "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY pangkat_id ASC";
		//echo $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }	
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement = "")
	{
		$str = "SELECT pangkat_id, nama, kode FROM pangkat WHERE pangkat_id IS NOT NULL "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY pangkat_id ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement = "")
	{
		$str = "SELECT COUNT(pangkat_id) AS ROWCOUNT FROM pangkat WHERE i.pangkat_id IS NOT NULL ".$statement; 
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

    function getCountByParamsLike($paramsArray=array(), $statement = "")
	{
		$str = "SELECT COUNT(pangkat_id) AS ROWCOUNT FROM pangkat WHERE i.pangkat_id IS NOT NULL ".$statement; 
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