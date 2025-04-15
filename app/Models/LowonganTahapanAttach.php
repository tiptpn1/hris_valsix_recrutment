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
  * Entity-base class untuk mengimplementasikan tabel LOWONGAN_TAHAPAN_ATTACH.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganTahapanAttach extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganTahapanAttach()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_TAHAPAN_ATTACH_ID", $this->getSeqId("LOWONGAN_TAHAPAN_ATTACH_ID","LOWONGAN_TAHAPAN_ATTACH")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO LOWONGAN_TAHAPAN_ATTACH (
				   LOWONGAN_TAHAPAN_ATTACH_ID, LOWONGAN_ID, TAHAPAN, DOKUMEN, CREATED_BY, CREATED_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("LOWONGAN_TAHAPAN_ATTACH_ID").",
				  '".$this->getField("LOWONGAN_ID")."',
				  '".$this->getField("TAHAPAN")."',
				  '".$this->getField("DOKUMEN")."',
				  '".$this->getField("CREATED_BY")."',
				  current_timestamp
				)"; 
		$this->id = $this->getField("LOWONGAN_TAHAPAN_ATTACH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM LOWONGAN_TAHAPAN_ATTACH
                WHERE 
                  LOWONGAN_TAHAPAN_ATTACH_ID = ".$this->getField("LOWONGAN_TAHAPAN_ATTACH_ID").""; 
				  
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
				SELECT 
				LOWONGAN_TAHAPAN_ATTACH_ID, LOWONGAN_ID, TAHAPAN, DOKUMEN
				FROM LOWONGAN_TAHAPAN_ATTACH
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT LOWONGAN_TAHAPAN_ATTACH_ID, LOWONGAN_ID, TAHAPAN
				FROM LOWONGAN_TAHAPAN_ATTACH
				WHERE 1 = 1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY LOWONGAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_TAHAPAN_ATTACH_ID) AS ROWCOUNT FROM LOWONGAN_TAHAPAN_ATTACH
		        WHERE LOWONGAN_TAHAPAN_ATTACH_ID IS NOT NULL ".$statement; 
		
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
	
	
    function getDokumen($paramsArray=array())
	{
		$str = "SELECT DOKUMEN AS DOKUMEN FROM LOWONGAN_TAHAPAN_ATTACH A
		        WHERE 1 = 1 ".$statement; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("DOKUMEN"); 
		else 
			return ""; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_TAHAPAN_ATTACH_ID) AS ROWCOUNT FROM LOWONGAN_TAHAPAN_ATTACH
		        WHERE LOWONGAN_TAHAPAN_ATTACH_ID IS NOT NULL ".$statement; 
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