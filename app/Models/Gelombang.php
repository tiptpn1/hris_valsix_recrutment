<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Gelombang extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Gelombang()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GELOMBANG_ID", $this->getSeqId("GELOMBANG_ID","GELOMBANG")); 		

		$str = "
				INSERT INTO GELOMBANG
						(GELOMBANG_ID, LOWONGAN_ID, PERIODE_ID, KODE, NAMA, TANGGAL, JAM, CREATED_BY, 
						 CREATED_DATE)
				 VALUES ('".$this->getField("GELOMBANG_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("PERIODE_ID")."', '".$this->getField("KODE")."', '".$this->getField("NAMA")."', 
				 		".$this->getField("TANGGAL").", '".$this->getField("JAM")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("GELOMBANG_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE GELOMBANG
				   SET KODE = '".$this->getField("KODE")."',
					   NAMA = '".$this->getField("NAMA")."',
					   TANGGAL = ".$this->getField("TANGGAL").",
					   JAM = '".$this->getField("JAM")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE")."
				WHERE  GELOMBANG_ID     = '".$this->getField("GELOMBANG_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM GELOMBANG
                WHERE 
                  GELOMBANG_ID = ".$this->getField("GELOMBANG_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL, NAMA ASC ")
	{
		$str = "
				SELECT GELOMBANG_ID, PERIODE_ID, KODE, NAMA, TANGGAL, JAM, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE, LOWONGAN, LOWONGAN_ID, TAHAPAN
				  FROM GELOMBANG A
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
				SELECT A.GELOMBANG_ID, A.PERIODE_ID, A.KODE, A.NAMA, A.TANGGAL, A.JAM, COALESCE(B.JUMLAH, 0)  JUMLAH
                  FROM GELOMBANG A
                  LEFT JOIN 
                  (
                    SELECT LOWONGAN_ID, GELOMBANG_KE, KODE_KRITERIA, COUNT(1) JUMLAH FROM PENGUMUMAN_TAHAPAN_SELEKSI X
                    WHERE EMAIL IS NULL
                    GROUP BY LOWONGAN_ID, GELOMBANG_KE, KODE_KRITERIA
                  ) B ON A.LOWONGAN_ID = B.LOWONGAN_ID AND A.NAMA = B.GELOMBANG_KE AND A.KODE = B.KODE_KRITERIA
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
	
	
    function selectByParamsHasilSeleksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="  ")
	{
		$str = "
				SELECT COUNT(1) JUMLAH_PELAMAR, SUM(CASE WHEN EMAIL = '1' THEN 1 ELSE 0 END) JUMLAH_EMAIL 
				FROM PENGUMUMAN_TAHAPAN_SELEKSI A
				WHERE KODE_KRITERIA = 'PENGUMUMAN'
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
		$str = "SELECT COUNT(GELOMBANG_ID) AS ROWCOUNT FROM GELOMBANG A
		        WHERE GELOMBANG_ID IS NOT NULL ".$statement; 
		
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
	
	
    function getGelombang($lowonganId, $kodeKriteria)
	{
		$str = "SELECT AMBIL_GELOMBANG('".$lowonganId."', '".$kodeKriteria."') ROWCOUNT FROM DUAL "; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GELOMBANG_ID) AS ROWCOUNT FROM GELOMBANG
		        WHERE GELOMBANG_ID IS NOT NULL ".$statement; 
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