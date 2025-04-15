<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class LowonganDokumen extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganDokumen()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_DOKUMEN_ID", $this->getSeqId("LOWONGAN_DOKUMEN_ID","LOWONGAN_DOKUMEN")); 

		$str = "
				INSERT INTO LOWONGAN_DOKUMEN(
						LOWONGAN_DOKUMEN_ID, LOWONGAN_ID, NAMA, KETERANGAN, WAJIB)
				VALUES ('".$this->getField("LOWONGAN_DOKUMEN_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."', '".$this->getField("WAJIB")."')
				"; 
		$this->query = $str;
		$this->id = $this->getField("LOWONGAN_DOKUMEN_ID");
		return $this->execQuery($str);
    }
	
	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE LOWONGAN_DOKUMEN SET 
				WAJIB						= '".$this->getField("WAJIB")."', 
				NAMA						= '".$this->getField("NAMA")."', 
				KETERANGAN					= '".$this->getField("KETERANGAN")."'
			 	WHERE LOWONGAN_DOKUMEN_ID	= '".$this->getField("LOWONGAN_DOKUMEN_ID")."'
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
				DELETE FROM LOWONGAN_DOKUMEN
                WHERE 
                  LOWONGAN_DOKUMEN_ID = '".$this->getField("LOWONGAN_DOKUMEN_ID")."'
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
		$str = "SELECT A.LOWONGAN_DOKUMEN_ID, A.LOWONGAN_ID, A.NAMA, A.KETERANGAN, A.WAJIB
				  FROM LOWONGAN_DOKUMEN A
				  LEFT JOIN LOWONGAN B ON B.LOWONGAN_ID = A.LOWONGAN_ID
				 WHERE 1=1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPelamarLowongan($pelamarId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT A.LOWONGAN_DOKUMEN_ID, A.LOWONGAN_ID, A.NAMA, A.KETERANGAN, C.LINK_FILE, A.WAJIB
				  FROM LOWONGAN_DOKUMEN A
				  LEFT JOIN LOWONGAN B ON B.LOWONGAN_ID = A.LOWONGAN_ID
				  LEFT JOIN PELAMAR_LOWONGAN_DOKUMEN C ON C.LOWONGAN_DOKUMEN_ID = A.LOWONGAN_DOKUMEN_ID AND C.PELAMAR_ID = '".$pelamarId."'
				 WHERE 1=1 "; 
		
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
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM LOWONGAN_DOKUMEN A WHERE 1=1 ".$statement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		//echo $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
  } 
?>