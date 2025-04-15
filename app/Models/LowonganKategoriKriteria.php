<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganKategoriKriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganKategoriKriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_KATEGORI_KRITERIA_ID", $this->getSeqId("LOWONGAN_KATEGORI_KRITERIA_ID","LOWONGAN_KATEGORI_KRITERIA")); 		

		$str = "
				INSERT INTO LOWONGAN_KATEGORI_KRITERIA
						(LOWONGAN_KATEGORI_KRITERIA_ID, LOWONGAN_ID, NAMA, KETERANGAN, TANGGAL_MULAI,TANGGAL_SELESAI, BOBOT, CREATED_BY,
						 CREATED_DATE, KATEGORI_KRITERIA_ID, URUT, LOKASI_TAHAPAN)
				 VALUES (
				 		'".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', 
						'".$this->getField("LOWONGAN_ID")."',
						(SELECT NAMA FROM KATEGORI_KRITERIA WHERE KATEGORI_KRITERIA_ID = '".$this->getField("KATEGORI_KRITERIA_ID")."'), 
				 		(SELECT KETERANGAN FROM KATEGORI_KRITERIA WHERE KATEGORI_KRITERIA_ID = '".$this->getField("KATEGORI_KRITERIA_ID")."'), 
				 		".$this->getField("TANGGAL_MULAI").",
				 		".$this->getField("TANGGAL_SELESAI").",
				 		'".$this->getField("BOBOT")."',
				 		'".$this->getField("CREATED_BY")."', 
				 		".$this->getField("CREATED_DATE").",
				 		'".$this->getField("KATEGORI_KRITERIA_ID")."',
				 		'".$this->getField("URUT")."',
				 		'".$this->getField("LOKASI_TAHAPAN")."'
				 	)
				"; 
		$this->id = $this->getField("LOWONGAN_KATEGORI_KRITERIA_ID");
		$this->query = $str;
		// echo $str; exit;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_KATEGORI_KRITERIA

				   SET TANGGAL_MULAI = ".$this->getField("TANGGAL_MULAI").",
					   TANGGAL_SELESAI = ".$this->getField("TANGGAL_SELESAI").",
					   LOKASI_TAHAPAN = '".$this->getField("LOKASI_TAHAPAN")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = ".$this->getField("UPDATED_DATE").",
					   URUT = '".$this->getField("URUT")."',
					   BOBOT = '".$this->getField("BOBOT")."',
					   KATEGORI_KRITERIA_ID = '".$this->getField("KATEGORI_KRITERIA_ID")."'
				WHERE  LOWONGAN_KATEGORI_KRITERIA_ID     = '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	
    function publish()
	{
		$str = "
				UPDATE LOWONGAN_KATEGORI_KRITERIA
				   SET PUBLISH_BY = '".$this->getField("PUBLISH_BY")."',
					   PUBLISH_DATE = CURRENT_DATE
				WHERE  LOWONGAN_KATEGORI_KRITERIA_ID     = '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }


    function publishByKode()
	{
		$str = "
				UPDATE LOWONGAN_KATEGORI_KRITERIA
				   SET PUBLISH_BY = '".$this->getField("PUBLISH_BY")."',
					   PUBLISH_DATE = CURRENT_DATE
				WHERE  KODE_KRITERIA     = '".$this->getField("KODE_KRITERIA")."' AND LOWONGAN_ID  = '".$this->getField("LOWONGAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }


    function unpublish()
	{
		$str = "
				UPDATE LOWONGAN_KATEGORI_KRITERIA
				   SET PUBLISH_BY = NULL,
					   PUBLISH_DATE = NULL
				WHERE  LOWONGAN_KATEGORI_KRITERIA_ID     = '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	
    function updateBobot()
	{
		$str = "
				UPDATE LOWONGAN_KATEGORI_KRITERIA
				   SET TANGGAL_MULAI = ".$this->getField("TANGGAL_MULAI").",
					   TANGGAL_SELESAI = ".$this->getField("TANGGAL_SELESAI").",
					   BOBOT = ".$this->getField("BOBOT").",
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = CURRENT_DATE
				WHERE  LOWONGAN_KATEGORI_KRITERIA_ID     = '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM LOWONGAN_KATEGORI_KRITERIA
                WHERE 
                  LOWONGAN_KATEGORI_KRITERIA_ID = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY URUT ASC ")
	{
		$str = "
				SELECT KODE_KRITERIA, LOWONGAN_KATEGORI_KRITERIA_ID, LOWONGAN_ID, NAMA, LOKASI_TAHAPAN, KETERANGAN, TANGGAL_MULAI , 
					   PUBLISH_BY, PUBLISH_DATE, TANGGAL_SELESAI , BOBOT ,CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE , KATEGORI_KRITERIA_ID, URUT, 
					   (SELECT MAX(URUT) FROM LOWONGAN_KATEGORI_KRITERIA X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID) URUT_AKHIR,
					   CASE WHEN TANGGAL_SELESAI < current_timestamp THEN '0' ELSE '1' END AKTIF,
					   CASE WHEN current_date BETWEEN TANGGAL_MULAI AND COALESCE(TANGGAL_SELESAI, TANGGAL_MULAI) THEN 'aktif' ELSE '' END TAHAP_AKTIF,
					   CASE WHEN PUBLISH_DATE IS NULL THEN 0 ELSE 1 END STATUS_PUBLISH
				  FROM LOWONGAN_KATEGORI_KRITERIA A
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
	
	

    function selectByParamsPengumuman($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR ASC ")
	{
		$str = "
				SELECT 
					KODE_KRITERIA, PELAMAR_ID, LOWONGAN_ID, 
					   PELAMAR, PELAMAR_NRP, GELOMBANG_KE, 
					   GELOMBANG_TANGGAL, GELOMBANG_JAM, EMAIL, 
					   SMS, HADIR, TANGGAL_HADIR, GELOMBANG_LOKASI
					FROM PENGUMUMAN_TAHAPAN_SELEKSI A
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
	
	

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.URUT ASC ")
	{
		$str = "
				SELECT LOWONGAN_KATEGORI_KRITERIA_ID, A.LOWONGAN_ID, A.NAMA, A.LOKASI_TAHAPAN,
						A.KETERANGAN, TANGGAL_MULAI , TANGGAL_SELESAI, A.BOBOT ,A.CREATED_BY, A.CREATED_DATE,
					   A.UPDATED_BY, A.UPDATED_DATE , A.KATEGORI_KRITERIA_ID, B.NAMA NAMA_KATEGORI_KRITERIA, 
					   A.URUT, (SELECT MAX(URUT) FROM LOWONGAN_KATEGORI_KRITERIA X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID) URUT_AKHIR,
					   B.PERLU_VALIDATOR
				  FROM LOWONGAN_KATEGORI_KRITERIA A
				  LEFT JOIN KATEGORI_KRITERIA B ON A.KATEGORI_KRITERIA_ID = B.KATEGORI_KRITERIA_ID
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
	
	
    function selectByParamsEntri($lowonganId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.URUT ASC ")
	{
		$str = "
				SELECT LOWONGAN_KATEGORI_KRITERIA_ID, B.LOWONGAN_ID, A.NAMA, B.LOKASI_TAHAPAN,
                        A.KETERANGAN, TANGGAL_MULAI , TANGGAL_SELESAI, A.BOBOT ,A.CREATED_BY, A.CREATED_DATE,
                       A.UPDATED_BY, A.UPDATED_DATE , A.KATEGORI_KRITERIA_ID, B.NAMA NAMA_KATEGORI_KRITERIA, 
                       COALESCE(B.URUT, A.KATEGORI_KRITERIA_ID) URUT, B.PUBLISH_DATE, B.PUBLISH_BY
                  FROM KATEGORI_KRITERIA A
                  LEFT JOIN LOWONGAN_KATEGORI_KRITERIA B ON A.KATEGORI_KRITERIA_ID = B.KATEGORI_KRITERIA_ID AND B.LOWONGAN_ID = '".$lowonganId."'
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

    function selectByParamsMonitoringNext($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_KATEGORI_KRITERIA_ID ASC ")
	{
		$str = "
				SELECT URUT, LOWONGAN_KATEGORI_KRITERIA_ID, LOWONGAN_KATEGORI_KRITERIA_ID_NEXT 
				  FROM LOWONGAN_KATEGORI_KRITERIA_NEXT A 
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
		$str = "SELECT COUNT(LOWONGAN_KATEGORI_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_KATEGORI_KRITERIA A
		        WHERE LOWONGAN_KATEGORI_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_KATEGORI_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_KATEGORI_KRITERIA
		        WHERE LOWONGAN_KATEGORI_KRITERIA_ID IS NOT NULL ".$statement; 
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