<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PeriodeGelombang extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PeriodeGelombang()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERIODE_GELOMBANG_ID", $this->getSeqId("PERIODE_GELOMBANG_ID","PERIODE_GELOMBANG")); 		

		$str = "
				INSERT INTO PERIODE_GELOMBANG
						(PERIODE_GELOMBANG_ID, PERIODE_ID, KODE, NAMA, TANGGAL, JAM, LOKASI, CREATED_BY, 
						 CREATED_DATE)
				 VALUES ('".$this->getField("PERIODE_GELOMBANG_ID")."', '".$this->getField("PERIODE_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."', 
				 		".$this->getField("TANGGAL").", '".$this->getField("JAM")."', '".$this->getField("LOKASI")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("PERIODE_GELOMBANG_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE PERIODE_GELOMBANG
				   SET NAMA = '".$this->getField("NAMA")."',
					   TANGGAL = ".$this->getField("TANGGAL").",
					   JAM = '".$this->getField("JAM")."',
					   LOKASI = '".$this->getField("LOKASI")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  PERIODE_GELOMBANG_ID     = '".$this->getField("PERIODE_GELOMBANG_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	
    function reschedule()
	{
		$str = "
				UPDATE PERIODE_GELOMBANG
				   SET TANGGAL = ".$this->getField("TANGGAL").",
					   JAM = '".$this->getField("JAM")."',
					   LOKASI = '".$this->getField("LOKASI")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  PERIODE_GELOMBANG_ID     = '".$this->getField("PERIODE_GELOMBANG_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PERIODE_GELOMBANG
                WHERE 
                  PERIODE_GELOMBANG_ID = ".$this->getField("PERIODE_GELOMBANG_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TAHAPAN_URUT, NAMA ASC ")
	{
		$str = "
				SELECT 
					PERIODE_GELOMBANG_ID, PERIODE_ID, KODE, 
					   NAMA, TANGGAL, JAM, 
					   TAHAPAN, TAHAPAN_URUT, LOKASI, 
					   CREATED_BY, CREATED_DATE, UPDATED_BY, 
					   UPDATED_DATE
					FROM PERIODE_GELOMBANG A
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
	
	
    function selectByParamsGelombangLowongan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC ")
	{
		$str = "
				SELECT A.PERIODE_GELOMBANG_ID, A.PERIODE_ID, A.KODE, A.NAMA, A.LOKASI, A.TANGGAL, A.JAM, COALESCE(B.JUMLAH, 0)  JUMLAH
                  FROM PERIODE_GELOMBANG A
                  LEFT JOIN 
                  (
                    SELECT LOWONGAN_ID, GELOMBANG_KE, KODE_KRITERIA, COUNT(1) JUMLAH FROM PENGUMUMAN_TAHAPAN_SELEKSI X
                    WHERE COALESCE(X.EMAIL, 0) IN (0, 2, 3)
                    GROUP BY LOWONGAN_ID, GELOMBANG_KE, KODE_KRITERIA
                  ) B ON A.NAMA = B.GELOMBANG_KE AND A.KODE = B.KODE_KRITERIA
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
		$str = "SELECT COUNT(PERIODE_GELOMBANG_ID) AS ROWCOUNT FROM PERIODE_GELOMBANG A
		        WHERE PERIODE_GELOMBANG_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PERIODE_GELOMBANG_ID) AS ROWCOUNT FROM PERIODE_GELOMBANG
		        WHERE PERIODE_GELOMBANG_ID IS NOT NULL ".$statement; 
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