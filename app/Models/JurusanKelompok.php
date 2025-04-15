<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class JurusanKelompok extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function JurusanKelompok()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JURUSAN_KELOMPOK_ID", $this->getSeqId("JURUSAN_KELOMPOK_ID","JURUSAN_KELOMPOK")); 		

		$str = "
				INSERT INTO JURUSAN_KELOMPOK
						(JURUSAN_KELOMPOK_ID, NAMA, KETERANGAN, CREATED_BY,
						 CREATED_DATE)
				 VALUES ('".$this->getField("JURUSAN_KELOMPOK_ID")."', '".$this->getField("NAMA")."', 
				 		'".$this->getField("KETERANGAN")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("JURUSAN_KELOMPOK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE JURUSAN_KELOMPOK
				   SET NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  JURUSAN_KELOMPOK_ID     = '".$this->getField("JURUSAN_KELOMPOK_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM JURUSAN_KELOMPOK
                WHERE 
                  JURUSAN_KELOMPOK_ID = ".$this->getField("JURUSAN_KELOMPOK_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY JURUSAN_KELOMPOK_ID ASC ")
	{
		$str = "
				SELECT JURUSAN_KELOMPOK_ID, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE
				  FROM JURUSAN_KELOMPOK A
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
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JURUSAN_KELOMPOK_ID) AS ROWCOUNT FROM JURUSAN_KELOMPOK A
		        WHERE JURUSAN_KELOMPOK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JURUSAN_KELOMPOK_ID) AS ROWCOUNT FROM JURUSAN_KELOMPOK
		        WHERE JURUSAN_KELOMPOK_ID IS NOT NULL ".$statement; 
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