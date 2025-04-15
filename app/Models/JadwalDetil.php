<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class JadwalDetil extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function JadwalDetil()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JADWAL_DETIL_ID", $this->getSeqId("JADWAL_DETIL_ID","JADWAL_DETIL")); 

		$str = "INSERT INTO JADWAL_DETIL(
					JADWAL_DETIL_ID, JADWAL_ID, NAMA, TANGGAL_MULAI, TANGGAL_SAMPAI
				  )
				VALUES(
				  ".$this->getField("JADWAL_DETIL_ID").",
				  ".$this->getField("JADWAL_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL_MULAI").",
				  ".$this->getField("TANGGAL_SAMPAI")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("JADWAL_DETIL_ID");
		return $this->execQuery($str);
    }
	
	function insertDataSahli()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JADWAL_DETIL_ID", $this->getSeqId("JADWAL_DETIL_ID","JADWAL_DETIL_SAHLI")); 

		$str = "INSERT INTO JADWAL_DETIL_SAHLI(
					JADWAL_DETIL_ID, JADWAL_ID, NAMA, TANGGAL_MULAI, TANGGAL_SAMPAI
				  )
				VALUES(
				  ".$this->getField("JADWAL_DETIL_ID").",
				  ".$this->getField("JADWAL_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL_MULAI").",
				  ".$this->getField("TANGGAL_SAMPAI")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("JADWAL_DETIL_ID");
		return $this->execQuery($str);
    }
	
	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE JADWAL_DETIL SET
				  NAMA= '".$this->getField("NAMA")."',
				  TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI").",
				  TANGGAL_SAMPAI= ".$this->getField("TANGGAL_SAMPAI")."
				WHERE JADWAL_DETIL_ID= '".$this->getField("JADWAL_DETIL_ID")."'
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateSahli()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE JADWAL_DETIL_SAHLI SET
				  NAMA= '".$this->getField("NAMA")."',
				  TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI").",
				  TANGGAL_SAMPAI= ".$this->getField("TANGGAL_SAMPAI")."
				WHERE JADWAL_DETIL_ID= '".$this->getField("JADWAL_DETIL_ID")."'
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateFormatDynamis()
	{
		$str = "
				UPDATE ".$this->getField("TABLE")."
				SET
					   ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE ".$this->getField("FIELD_ID")." = '".$this->getField("FIELD_VALUE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM JADWAL_DETIL
                WHERE 
                  JADWAL_DETIL_ID = '".$this->getField("JADWAL_DETIL_ID")."'
			"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteSahli()
	{
        $str = "
				DELETE FROM JADWAL_DETIL_SAHLI
                WHERE 
                  JADWAL_DETIL_ID = '".$this->getField("JADWAL_DETIL_ID")."'
			"; 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT JADWAL_DETIL_ID, md5(CAST(JADWAL_DETIL_ID as TEXT)) JADWAL_DETIL_ID_ENKRIP, JADWAL_ID,
				  NAMA, TANGGAL_MULAI, TANGGAL_SAMPAI
				FROM JADWAL_DETIL WHERE 1=1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
	 function selectByParamsSahli($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT JADWAL_DETIL_ID, md5(CAST(JADWAL_DETIL_ID as TEXT)) JADWAL_DETIL_ID_ENKRIP, JADWAL_ID,
				  NAMA, TANGGAL_MULAI, TANGGAL_SAMPAI
				FROM JADWAL_DETIL_SAHLI WHERE 1=1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM JADWAL_DETIL WHERE 1=1 ".$statement; 
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
	
	  function getCountByParamsSahli($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM JADWAL_DETIL_SAHLI WHERE 1=1 ".$statement; 
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