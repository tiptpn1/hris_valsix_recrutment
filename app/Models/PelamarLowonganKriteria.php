<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_lowongan_kriteria.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganKriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganKriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_KRITERIA_ID", $this->getSeqId("PELAMAR_LOWONGAN_KRITERIA_ID","pelamar_lowongan_kriteria"));

		$str = "
					INSERT INTO pelamar_lowongan_kriteria(
					            PELAMAR_LOWONGAN_KRITERIA_ID, LOWONGAN_KATEGORI_KRITERIA_ID, LOWONGAN_ID, 
					            TANGGAL_TEST, NILAI_TOTAL, CATATAN, 
					            CREATED_BY, CREATED_DATE, PELAMAR_ID,
					            PENILAI_ID, REKOMENDASI_ID)
					    VALUES ('".$this->getField("PELAMAR_LOWONGAN_KRITERIA_ID")."', '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', '".$this->getField("LOWONGAN_ID")."', 
					            ".$this->getField("TANGGAL_TEST").", ".$this->getField("NILAI_TOTAL").", '".$this->getField("CATATAN")."', 
					            '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").", '".$this->getField("PELAMAR_ID")."', '".$this->getField("PENILAI_ID")."', ".$this->getField("REKOMENDASI_ID").")

			  "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	function import()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_KRITERIA_ID", $this->getSeqId("PELAMAR_LOWONGAN_KRITERIA_ID","pelamar_lowongan_kriteria"));
		
		$str = "
					INSERT INTO pelamar_lowongan_kriteria(
					            PELAMAR_LOWONGAN_KRITERIA_ID, LOWONGAN_ID, 
					            GELOMBANG_ID, NRP, KODE_KRITERIA,
					            CREATED_BY, CREATED_DATE)
					    VALUES ('".$this->getField("PELAMAR_LOWONGAN_KRITERIA_ID")."', '".$this->getField("LOWONGAN_ID")."', 
					            '".$this->getField("GELOMBANG_ID")."', '".$this->getField("NRP")."', '".$this->getField("KODE_KRITERIA")."', 
					            '".$this->getField("CREATED_BY")."', current_timestamp)

			  "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE pelamar_lowongan_kriteria
				   SET LOWONGAN_KATEGORI_KRITERIA_ID 			= '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."',
				       LOWONGAN_ID 						= '".$this->getField("LOWONGAN_ID")."',
				       PENILAI_ID 						= '".$this->getField("PENILAI_ID")."',
				       PELAMAR_ID 						= '".$this->getField("PELAMAR_ID")."',
				       TANGGAL_TEST 					= ".$this->getField("TANGGAL_TEST").",
				       NILAI_TOTAL 						= '".$this->getField("NILAI_TOTAL")."',
				       CATATAN 							= '".$this->getField("CATATAN")."',
				       UPDATED_BY 				= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 				= ".$this->getField("UPDATED_DATE")."
				WHERE  PELAMAR_LOWONGAN_KRITERIA_ID     = '".$this->getField("PELAMAR_LOWONGAN_KRITERIA_ID")."'

			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	
    function sinkronisasiWawancara()
	{
		$str = "
				CALL SINKRONISASI_WAWANCARA('".$this->getField("LOWONGAN_ID")."')
			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
	
	
	function updateEmailPelamar()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					EMAIL_STATUS = '".$this->getField("EMAIL_STATUS")."',
					EMAIL_TANGGAL = current_timestamp
                WHERE 
                  LOWONGAN_ID   = ".$this->getField("LOWONGAN_ID")." AND
                  PELAMAR_ID    = ".$this->getField("PELAMAR_ID")."  AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateLolos()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					LULUS = 'Y'
                WHERE 
                  LOWONGAN_ID   = ".$this->getField("LOWONGAN_ID")." AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' AND
                  NRP   		= ".$this->getField("NRP")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateHadir()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					HADIR = '1',
					TANGGAL_HADIR = current_timestamp
                WHERE 
                  LOWONGAN_ID   = ".$this->getField("LOWONGAN_ID")." AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' AND
                  PELAMAR_ID    = ".$this->getField("PELAMAR_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateProsesEmailPelamar()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					EMAIL_STATUS = '2'
                WHERE 
                  LOWONGAN_ID   = ".$this->getField("LOWONGAN_ID")." AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' AND
				  COALESCE(EMAIL_STATUS, 0) IN (0,2,3) "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateProsesEmailPelamarById()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					EMAIL_STATUS = '2',
					GELOMBANG_ID = '".$this->getField("GELOMBANG_ID")."'
                WHERE 
                  GELOMBANG_PERIODE_ID = '".$this->getField("GELOMBANG_PERIODE_ID")."' AND
                  PELAMAR_ID   = '".$this->getField("PELAMAR_ID")."' AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateProsesEmailPelamarByGelombangId()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					EMAIL_STATUS = '2'
                WHERE 
                  GELOMBANG_ID = '".$this->getField("GELOMBANG_ID")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function updateEmail()
	{
        $str = "UPDATE pelamar_lowongan_kriteria
				SET 
					EMAIL_STATUS = 1
                WHERE 
                  LOWONGAN_ID   = ".$this->getField("LOWONGAN_ID")." AND
				  KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
    function updateNilai()
	{
		$str = "
				UPDATE pelamar_lowongan_kriteria
				   SET NILAI_TOTAL 						= '".$this->getField("NILAI_TOTAL")."',
				       CATATAN 							= '".$this->getField("CATATAN")."',
				       LULUS 							= '".$this->getField("LULUS")."',
				       UPDATED_BY 				= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 				= current_timestamp
				WHERE  NRP     = '".$this->getField("NRP")."' AND
					   LOWONGAN_ID   = '".$this->getField("LOWONGAN_ID")."' AND
					   KODE_KRITERIA = '".$this->getField("KODE_KRITERIA")."'
			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
    
    
	function delete()
	{
        $str = "DELETE FROM pelamar_lowongan_kriteria
                WHERE 
                  LOWONGAN_KATEGORI_KRITERIA_ID = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM pelamar_lowongan_kriteria
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")."
                  AND 
                  PELAMAR_ID  = ".$this->getField("PELAMAR_ID")."
                  AND 
                  LOWONGAN_KATEGORI_KRITERIA_ID  = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")." "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_LOWONGAN_KRITERIA_ID, PENILAI_ID, LOWONGAN_KATEGORI_KRITERIA_ID, 
				       PELAMAR_ID, LOWONGAN_ID, TANGGAL_TEST, NILAI_TOTAL, CATATAN, 
				       CREATED_BY, CREATED_DATE, UPDATED_BY, UPDATED_DATE,
				       REKOMENDASI_ID
				  FROM pelamar_lowongan_kriteria A
		 		 WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY PELAMAR_LOWONGAN_KRITERIA_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsEmail($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID ASC ")
	{
		$str = "
				SELECT A.PELAMAR_ID, B.EMAIL, B.NAMA, B.NRP, A.GELOMBANG_ID, A.LOWONGAN_ID FROM pelamar_lowongan_kriteria A 
				INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID AND COALESCE(A.EMAIL_STATUS, 0) IN (0,2,3)
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_LOWONGAN_KRITERIA_ID, PENILAI_ID, LOWONGAN_KATEGORI_KRITERIA_ID, 
				       PELAMAR_ID, LOWONGAN_ID, TO_CHAR(TANGGAL_TEST, 'DD-MM-YYYY HH24:MI') TANGGAL_TEST, NILAI_TOTAL, CATATAN, 
				       CREATED_BY, CREATED_DATE, UPDATED_BY, UPDATED_DATE, 
                       REKOMENDASI_ID, NIK, PELAMAR, NRP, JENIS_KELAMIN, TELEPON, EMAIL, LAMPIRAN_FOTO, LULUS,
					   GELOMBANG_KE, GELOMBANG_TANGGAL, GELOMBANG_JAM, EMAIL_STATUS
                  FROM pelamar_lowongan_kriteria A
                  WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.PELAMAR ASC ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function selectByParamsNilaiPerTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					TAHAPAN, LOWONGAN_ID, URUT, 
					   PELAMAR_ID, VERIFIKASI_REKOMENDASI, VERIFIKASI_CATATAN
					FROM PELAMAR_NILAI_TAHAPAN A
                  WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.URUT ASC ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

	
    function selectByParamsMonitoringInformasiTahapan($reqTahapan, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR ASC ")
	{
		$str = "
				SELECT A.PELAMAR_LOWONGAN_KRITERIA_ID, A.PENILAI_ID, A.LOWONGAN_KATEGORI_KRITERIA_ID, 
				       A.PELAMAR_ID, A.LOWONGAN_ID, TO_CHAR(A.TANGGAL_TEST, 'DD-MM-YYYY HH24:MI') TANGGAL_TEST, A.NILAI_TOTAL, A.CATATAN, 
				       A.CREATED_BY, A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE,
                       A.REKOMENDASI_ID, A.NIK, A.PELAMAR, A.NRP, A.JENIS_KELAMIN, A.TELEPON, A.EMAIL, A.LAMPIRAN_FOTO, 
					   A.GELOMBANG_KE, A.GELOMBANG_TANGGAL, A.GELOMBANG_JAM, A.EMAIL_STATUS,
                       CASE 
					   	WHEN COALESCE(C.EMAIL, 0) = 1 THEN '<span class=sudah-diemail>Sudah diemail (' || TO_CHAR(C.EMAIL_TANGGAL, 'DD-MM-YYYY HH24:MI') || ')</span>'  
					   	WHEN COALESCE(C.EMAIL, 0) = 2 THEN '<span class=proses-diemail>Proses email</span>'  
					   	WHEN COALESCE(C.EMAIL, 0) = 3 THEN '<span class=gagal-diemail>Kirim email gagal</span>'
						ELSE CASE WHEN C.PELAMAR_ID IS NOT NULL THEN 'Belum Diemail' ELSE NULL END
					   END  
                       EMAIL_SHORTLIST,
                       CASE WHEN C.PELAMAR_ID IS NULL THEN 'Tidak Lulus / Belum Ditentukan' ELSE 'Lulus Gelombang ' || C.GELOMBANG_KE END LULUS,
					   CASE WHEN B.VERIFIKASI_REKOMENDASI IS NULL THEN 'Belum Verifikasi' ELSE B.VERIFIKASI_REKOMENDASI END VERIFIKASI_REKOMENDASI
                  FROM pelamar_lowongan_kriteria A
                    INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
                    LEFT JOIN PENGUMUMAN_TAHAPAN_SELEKSI C ON A.PELAMAR_ID = C.PELAMAR_ID AND A.LOWONGAN_ID = C.LOWONGAN_ID AND C.KODE_KRITERIA = '".$reqTahapan."'
                  WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= "  ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	
    function selectByParamsHasil($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.PENILAI_ID, SUM(NILAI_TOTAL) NILAI_TOTAL, MAX(REKOMENDASI) REKOMENDASI, MAX(CATATAN) CATATAN
                  FROM PELAMAR_LOWONGAN_NILAI A
				  LEFT JOIN PELAMAR_LOWONGAN_REKOM B ON A.KODE_KRITERIA = B.KODE_KRITERIA AND A.LOWONGAN_ID = B.LOWONGAN_ID AND A.PELAMAR_ID = B.PELAMAR_ID AND A.PENILAI_ID = B.PENILAI_ID
                  WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " GROUP BY A.PENILAI_ID ORDER BY A.PENILAI_ID ASC ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_KRITERIA_ID) AS ROWCOUNT 
				  FROM pelamar_lowongan_kriteria A
		         WHERE PELAMAR_LOWONGAN_KRITERIA_ID IS NOT NULL ".$statement; 
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
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_KRITERIA_ID) AS ROWCOUNT 
                  FROM pelamar_lowongan_kriteria A
                  WHERE 1 = 1  ".$statement; 
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
	

    function getCountByParamsMonitoringInformasiTahapan($reqTahapan, $paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
                  FROM pelamar_lowongan_kriteria A
                    LEFT JOIN PENGUMUMAN_TAHAPAN_SELEKSI C ON A.PELAMAR_ID = C.PELAMAR_ID AND A.LOWONGAN_ID = C.LOWONGAN_ID AND C.KODE_KRITERIA = '".$reqTahapan."'
                  WHERE 1 = 1   ".$statement; 
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