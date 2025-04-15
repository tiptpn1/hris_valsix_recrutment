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

class JenisPersyaratan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function JenisPersyaratan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_PERSYARATAN_ID", $this->getSeqId("JENIS_PERSYARATAN_ID","JENIS_PERSYARATAN")); 

		$str = "INSERT INTO JENIS_PERSYARATAN(JENIS_PERSYARATAN_ID, JENIS_PERSYARATAN_PARENT_ID, NAMA, 
				KETERANGAN, PREFIX, URUT) 
				VALUES(
				  '".$this->getField("JENIS_PERSYARATAN_ID")."',
				  '".$this->getField("JENIS_PERSYARATAN_PARENT_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("PREFIX")."',
				  '".$this->getField("URUT")."'
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE JENIS_PERSYARATAN SET
				  NAMA 			= '".$this->getField("NAMA")."',
				  KETERANGAN 	= '".$this->getField("KETERANGAN")."',
				  PREFIX		= '".$this->getField("PREFIX")."'
				WHERE 
					JENIS_PERSYARATAN_ID = '".$this->getField("JENIS_PERSYARATAN_ID")."'
					AND
					JENIS_PERSYARATAN_PARENT_ID = '".$this->getField("JENIS_PERSYARATAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM JENIS_PERSYARATAN
                WHERE 
                  JENIS_PERSYARATAN_ID = '".$this->getField("JENIS_PERSYARATAN_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","GKID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$varStatement="")
	{
		$str = "
				SELECT JENIS_PERSYARATAN_ID, JENIS_PERSYARATAN_PARENT_ID, NAMA, 
					   KETERANGAN, PREFIX, URUT
				  FROM JENIS_PERSYARATAN
				 WHERE 1=1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY JENIS_PERSYARATAN_ID ASC";
		// echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1,$varStatement="")
	{
		$str = "
				SELECT JENIS_PERSYARATAN_ID, JENIS_PERSYARATAN_PARENT_ID, NAMA, 
					   KETERANGAN, PREFIX, URUT
				  FROM JENIS_PERSYARATAN
				 WHERE 1=1 
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY JENIS_PERSYARATAN_ID DESC";
				
		return $this->selectLimit($str,$limit,$from); 
    }
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","GKID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(),$varStatement="")
	{
		$str = "
				SELECT COUNT(JENIS_PERSYARATAN_ID) AS ROWCOUNT 
				  FROM JENIS_PERSYARATAN 
				 WHERE JENIS_PERSYARATAN_ID IS NOT NULL
				".$varStatement; 
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

    function getCountByParamsLike($paramsArray=array(),$varStatement="")
	{
		$str = "
				SELECT COUNT(JENIS_PERSYARATAN_ID) AS ROWCOUNT 
				  FROM JENIS_PERSYARATAN 
				 WHERE JENIS_PERSYARATAN_ID IS NOT NULL
				".$varStatement; 
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