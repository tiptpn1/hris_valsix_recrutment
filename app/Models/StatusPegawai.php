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
  * Entity-base class untuk mengimplementasikan tabel STATUS_PEGAWAI.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class StatusPegawai extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function StatusPegawai()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("STATUS_PEGAWAI_ID", $this->getSeqId("STATUS_PEGAWAI_ID","STATUS_PEGAWAI")); 		
		$str = "
				INSERT INTO STATUS_PEGAWAI (
				   STATUS_PEGAWAI_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE)  
 			  	VALUES (
				  ".$this->getField("STATUS_PEGAWAI_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->id = $this->getField("STATUS_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE STATUS_PEGAWAI
				SET    
					   NAMA           		= '".$this->getField("NAMA")."',
					   KETERANGAN         	= '".$this->getField("KETERANGAN")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  STATUS_PEGAWAI_ID    = '".$this->getField("STATUS_PEGAWAI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM STATUS_PEGAWAI
                WHERE 
                  STATUS_PEGAWAI_ID = ".$this->getField("STATUS_PEGAWAI_ID").""; 
				  
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
				STATUS_PEGAWAI_ID, NAMA, KETERANGAN
				FROM STATUS_PEGAWAI
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
				SELECT STATUS_PEGAWAI_ID, NAMA, KETERANGAN
				FROM STATUS_PEGAWAI
				WHERE 1 = 1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(STATUS_PEGAWAI_ID) AS ROWCOUNT FROM STATUS_PEGAWAI
		        WHERE STATUS_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(STATUS_PEGAWAI_ID) AS ROWCOUNT FROM STATUS_PEGAWAI
		        WHERE STATUS_PEGAWAI_ID IS NOT NULL ".$statement; 
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