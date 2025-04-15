<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Jurusan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Jurusan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JURUSAN_ID", $this->getSeqId("JURUSAN_ID","JURUSAN")); 		

		$str = "
				INSERT INTO JURUSAN
						(JURUSAN_ID, KODE, NAMA, KETERANGAN, CREATED_BY,
						 CREATED_DATE,UNIVERSITAS_ID)
				 VALUES ('".$this->getField("JURUSAN_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."', 
				 		'".$this->getField("KETERANGAN")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").", ".$this->getField("UNIVERSITAS_ID").")
				"; 
		$this->id = $this->getField("JURUSAN_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE JURUSAN
				   SET KODE = '".$this->getField("KODE")."',
					   NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE").",
					   UNIVERSITAS_ID = 	".$this->getField("UNIVERSITAS_ID")."
				WHERE  JURUSAN_ID     = '".$this->getField("JURUSAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM JURUSAN
                WHERE 
                  JURUSAN_ID = ".$this->getField("JURUSAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC ")
	{
		$str = "
				SELECT JURUSAN_ID, KODE, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE, UNIVERSITAS_ID,
					   A.AKREDITASI
				  FROM JURUSAN A
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
	 
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC ")
	{
		$str = "
				SELECT JURUSAN_ID, A.KODE, A.NAMA, A.KETERANGAN, A.CREATED_BY, A.CREATED_DATE,
					   A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_JURUSAN, A.UNIVERSITAS_ID,
					   A.AKREDITASI
				  FROM JURUSAN A
				  LEFT JOIN UNIVERSITAS B ON A.UNIVERSITAS_ID = B.UNIVERSITAS_ID
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
		$str = "SELECT COUNT(JURUSAN_ID) AS ROWCOUNT FROM JURUSAN A
		        WHERE JURUSAN_ID IS NOT NULL ".$statement; 
		
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


    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.JURUSAN_ID) AS ROWCOUNT 
				 FROM JURUSAN A
				  LEFT JOIN UNIVERSITAS B ON A.UNIVERSITAS_ID = B.UNIVERSITAS_ID
				  WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(JURUSAN_ID) AS ROWCOUNT FROM JURUSAN
		        WHERE JURUSAN_ID IS NOT NULL ".$statement; 
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