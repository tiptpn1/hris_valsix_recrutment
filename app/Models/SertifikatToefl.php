<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class SertifikatToefl extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function SertifikatToefl()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SERTIFIKAT_TOEFL_ID", $this->getSeqId("SERTIFIKAT_TOEFL_ID","sertifikat_toefl")); 		

		$str = "
				INSERT INTO sertifikat_toefl
							(SERTIFIKAT_TOEFL_ID, SERTIFIKAT_PARENT_ID, KODE, NAMA, 
							 KETERANGAN, SKOR_MINIMAL, SKOR_MAKSIMAL, 
							 CREATED_BY, CREATED_DATE
							)
					 VALUES ('".$this->getField("SERTIFIKAT_TOEFL_ID")."', '".$this->getField("SERTIFIKAT_PARENT_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."',
					 		 '".$this->getField("KETERANGAN")."', 
							 '".$this->getField("SKOR_MINIMAL")."', '".$this->getField("SKOR_MAKSIMAL")."', 
							 '".$this->getField("CREATED_BY")."', current_timestamp
							)
				
				"; 
		$this->id = $this->getField("SERTIFIKAT_TOEFL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE sertifikat_toefl
				   SET KODE = '".$this->getField("KODE")."',
					   NAMA = '".$this->getField("NAMA")."',
					   SKOR_MINIMAL = '".$this->getField("SKOR_MINIMAL")."',
					   SKOR_MAKSIMAL = '".$this->getField("SKOR_MAKSIMAL")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = current_timestamp
				WHERE  SERTIFIKAT_TOEFL_ID     = '".$this->getField("SERTIFIKAT_TOEFL_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM sertifikat_toefl
                WHERE 
                  SERTIFIKAT_TOEFL_ID = ".$this->getField("SERTIFIKAT_TOEFL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY SERTIFIKAT_TOEFL_ID ASC ")
	{
		$str = "
				SELECT SERTIFIKAT_TOEFL_ID, KODE, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE, SKOR_MINIMAL, SKOR_MAKSIMAL
				  FROM sertifikat_toefl A
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
		$str = "SELECT COUNT(SERTIFIKAT_TOEFL_ID) AS ROWCOUNT FROM sertifikat_toefl A
		        WHERE SERTIFIKAT_TOEFL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SERTIFIKAT_TOEFL_ID) AS ROWCOUNT FROM sertifikat_toefl
		        WHERE SERTIFIKAT_TOEFL_ID IS NOT NULL ".$statement; 
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