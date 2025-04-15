<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Bidang extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Bidang()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BIDANG_ID", $this->getSeqId("BIDANG_ID","BIDANG")); 		

		$str = "
				INSERT INTO BIDANG
						(BIDANG_ID, KODE, NAMA, KETERANGAN, CREATED_BY,
						 CREATED_DATE)
				 VALUES ('".$this->getField("BIDANG_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."', 
				 		'".$this->getField("KETERANGAN")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("BIDANG_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE BIDANG
				   SET KODE = '".$this->getField("KODE")."',
					   NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  BIDANG_ID     = '".$this->getField("BIDANG_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM BIDANG
                WHERE 
                  BIDANG_ID = ".$this->getField("BIDANG_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY BIDANG_ID ASC ")
	{
		$str = "
				SELECT BIDANG_ID, KODE, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE
				  FROM BIDANG A
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
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, AMBIL_STATUS_CHEKLIST(STATUS) STATUS_NAMA, AMBIL_STATUS_KELOMPOK_JABATAN(KELOMPOK) KELOMPOK
				FROM JABATAN
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
		$str = "SELECT COUNT(BIDANG_ID) AS ROWCOUNT FROM BIDANG A
		        WHERE BIDANG_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BIDANG_ID) AS ROWCOUNT FROM BIDANG
		        WHERE BIDANG_ID IS NOT NULL ".$statement; 
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