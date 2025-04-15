<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_lowongan.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowongan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowongan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_ID", $this->getSeqId("PELAMAR_LOWONGAN_ID","pelamar_lowongan"));

		$str = "
					INSERT INTO pelamar_lowongan (
					   PELAMAR_LOWONGAN_ID, PELAMAR_ID, TANGGAL, TANGGAL_KIRIM, LOWONGAN_ID, LINK_FILE, TANGGAL_KIRIM_FILE)
 			  	VALUES (
				  ".$this->getField("PELAMAR_LOWONGAN_ID").",
				  '".$this->getField("PELAMAR_ID")."',
				  CURRENT_DATE,
				  ".$this->getField("TANGGAL_KIRIM").",
				  ".$this->getField("LOWONGAN_ID").",
				  '".$this->getField("LINK_FILE")."',
				  ".$this->getField("TANGGAL_KIRIM_FILE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertDataUndangan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_ID", $this->getSeqId("PELAMAR_LOWONGAN_ID","pelamar_lowongan"));

		$str = "
					INSERT INTO pelamar_lowongan (
					   PELAMAR_LOWONGAN_ID, PELAMAR_ID, TANGGAL, TANGGAL_UNDANGAN, TANGGAL_KIRIM, LOWONGAN_ID, TIPE_KIRIM)
 			  	VALUES (
				  ".$this->getField("PELAMAR_LOWONGAN_ID").",
				  '".$this->getField("PELAMAR_ID")."',
				  CURRENT_DATE,
				  CURRENT_DATE,
				  CURRENT_DATE,
				  ".$this->getField("LOWONGAN_ID").", 
				  'OFFLINEE'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }	
	
    function updateData()
	{
		$str = "
				UPDATE pelamar_lowongan
				SET    
					   PELAMAR_ID          = '".$this->getField("PELAMAR_ID")."',
					   LOWONGAN_ID= ".$this->getField("LOWONGAN_ID")."
				WHERE  PELAMAR_LOWONGAN_ID     = '".$this->getField("PELAMAR_LOWONGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pelamar_lowongan A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PELAMAR_LOWONGAN_ID = ".$this->getField("PELAMAR_LOWONGAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

    function updateByField2()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pelamar_lowongan A SET
				  ".$this->getField("FIELD")." = ".$this->getField("FIELD_VALUE")."
				WHERE PELAMAR_LOWONGAN_ID = ".$this->getField("PELAMAR_LOWONGAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	
	
	function delete()
	{
        $str = "DELETE FROM pelamar_lowongan
                WHERE 
                  PELAMAR_LOWONGAN_ID = ".$this->getField("PELAMAR_LOWONGAN_ID").""; 
				  
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
				SELECT   PELAMAR_LOWONGAN_ID, PELAMAR_ID, TANGGAL, LOWONGAN_ID 
 	 	 			FROM pelamar_lowongan A 
		 		WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY TANGGAL DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDaftarLamaran($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.LOWONGAN_ID, B.KODE, B.NAMA JABATAN, B.PENEMPATAN, TANGGAL_KIRIM, 
				CASE WHEN D.PELAMAR_ID IS NULL THEN 'Tidak' ELSE 'Ya' END SHORTLIST 
				FROM pelamar_lowongan A 
				INNER JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_LOWONGAN_SHORTLIST D ON A.PELAMAR_ID = D.PELAMAR_ID AND A.LOWONGAN_ID = D.LOWONGAN_ID
		 		WHERE 1 = 1
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.TANGGAL_KIRIM DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDaftarPelamar($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT DISTINCT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, EMAIL, LAMPIRAN_FOTO, F.NAMA NAMA_KOTA, B.LOWONGAN_ID,
					   A.VERIFIKASI_REKOMENDASI, A.VERIFIKASI_BY
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN KOTA F ON A.KOTA_ID = F.KOTA_ID
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPelamarLowonganRekap($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.RANKING ASC")
	{
		$str = "
				SELECT 
					LOWONGAN_ID, KODE_KRITERIA, NRP, 
					   PELAMAR, EMAIL, TELEPON, JUMLAH_PENILAI, NILAI1, 
					   NILAI2, NILAI3, NILAI4, 
					   NILAI5, NILAI_TOTAL, REKOM1, 
					   REKOM2, REKOM3, REKOM4, 
					   REKOM5, NILAI_REKOMENDASI, RANKING, LULUS_KETERANGAN
					FROM PELAMAR_LOWONGAN_REKAP A
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }




    function selectByParamsDaftarHistoryTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT DISTINCT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, EMAIL, LAMPIRAN_FOTO, F.NAMA NAMA_KOTA, B.LOWONGAN_ID,
					   A.VERIFIKASI_REKOMENDASI, A.VERIFIKASI_BY, AA.PENILAI_ID
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN KOTA F ON A.KOTA_ID = F.KOTA_ID
                LEFT JOIN PELAMAR_LOWONGAN_NILAI AA ON AA.PELAMAR_ID = B.PELAMAR_ID AND AA.LOWONGAN_ID = B.LOWONGAN_ID 
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDaftarPelamarInformasiTahapan($reqTahapan, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT  A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,
                       TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, B.LOWONGAN_ID,
                       C.GELOMBANG_KE, C.EMAIL EMAIL_STATUS,
                       CASE 
					   	WHEN COALESCE(C.EMAIL, 0) = 1 THEN '<span class=sudah-diemail>Sudah diemail (' || TO_CHAR(C.EMAIL_TANGGAL, 'DD-MM-YYYY HH24:MI') || ')</span>'  
					   	WHEN COALESCE(C.EMAIL, 0) = 2 THEN '<span class=proses-diemail>Proses email</span>'  
					   	WHEN COALESCE(C.EMAIL, 0) = 3 THEN '<span class=gagal-diemail>Kirim email gagal</span>'
						ELSE CASE WHEN C.PELAMAR_ID IS NOT NULL THEN 'Belum Diemail' ELSE NULL END
					   END  
					   EMAIL_SHORTLIST,
					   CASE WHEN C.PELAMAR_ID IS NULL THEN 'Tidak Lulus / Belum Ditentukan' ELSE 'Lulus Gelombang ' || C.GELOMBANG_KE END LULUS,
					   CASE WHEN A.VERIFIKASI_REKOMENDASI IS NULL THEN 'Belum Verifikasi<br><a href=''admin/loadUrl/admin/penilai_verifikasi_monitoring_add/?reqId=' || A.PELAMAR_ID || ''' target=''_blank''>Verifikasi Sekarang</a>' ELSE A.VERIFIKASI_REKOMENDASI END VERIFIKASI_REKOMENDASI
                FROM PELAMAR A 
                INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
                LEFT JOIN PENGUMUMAN_TAHAPAN_SELEKSI C ON A.PELAMAR_ID = C.PELAMAR_ID AND B.LOWONGAN_ID = C.LOWONGAN_ID AND C.KODE_KRITERIA = '".$reqTahapan."'
                 WHERE 1 = 1        
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsQR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT A.PELAMAR_ID, B.LOWONGAN_ID, NRP, KTP_NO, A.NAMA, 
           		 TELEPON, EMAIL, LAMPIRAN_FOTO, C.JABATAN, B.TANGGAL_KIRIM
                FROM PELAMAR A 
                INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
                INNER JOIN LOWONGAN C ON B.LOWONGAN_ID = C.LOWONGAN_ID
                 WHERE 1 = 1             
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

 function selectPelamarInformasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID DESC")
	{
		$str = "
				SELECT DISTINCT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, JENIS_KELAMIN,             
                       AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
                       AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
                       B.TANGGAL_KIRIM,
                       TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, EMAIL, LAMPIRAN_FOTO, C.JABATAN
                FROM PELAMAR A 
                INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
                INNER JOIN LOWONGAN C ON B.LOWONGAN_ID = C.LOWONGAN_ID
                WHERE 1 = 1                          
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

 function selectByParamsQRAbsen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR DESC")
	{
		$str = "
				SELECT A.PELAMAR_ID, A.LOWONGAN_ID, A.PELAMAR_NRP NRP, A.PELAMAR NAMA, 
           		  EMAIL, PELAMAR_FOTO LAMPIRAN_FOTO, C.JABATAN, A.KODE_KRITERIA, A.GELOMBANG_ID
                FROM PENGUMUMAN_TAHAPAN_SELEKSI A 
                INNER JOIN LOWONGAN C ON A.LOWONGAN_ID = C.LOWONGAN_ID
                 WHERE 1 = 1                 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPelamarTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR DESC")
	{
		$str = "
				SELECT 
				KODE_KRITERIA, PELAMAR_ID, PERIODE_ID, 
				   LOWONGAN_ID, PELAMAR, PELAMAR_NRP, 
				   GELOMBANG_KE, GELOMBANG_TANGGAL, GELOMBANG_JAM, 
				   GELOMBANG_LOKASI, EMAIL, SMS, 
				   HADIR, TANGGAL_HADIR
				FROM PENGUMUMAN_TAHAPAN_SELEKSI A
                 WHERE 1 = 1             
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function selectByParamsDaftarPelamarCutoff($cutOff, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT A.NAMA, A.PELAMAR_ID, NRP, KTP_NO, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_MASA_KERJA(TANGGAL_LAHIR, TO_DATE('".$cutOff."', 'DD-MM-YYYY')) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || '-' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, D.DURASI, A.ALAMAT,
					   AMBIL_PELAMAR_SERTIF_SIMPLE(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE '' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, EMAIL, LAMPIRAN_FOTO, F.NAMA NAMA_KOTA,
					   CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki-laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' ELSE '' END JENIS_KELAMIN_KET,
					   VERIFIKASI, LAST_VERIFIED_USER, LAST_VERIFIED_DATE, 
					   AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_NIKAH, DOMISILI, A.KOTA_ID, 
					   AMBIL_PELAMAR_MINAT_JABATAN(A.PELAMAR_ID) PEMINATAN_JABATAN,
					   AMBIL_PELAMAR_PEMINATAN_LOKASI(A.PELAMAR_ID) PEMINATAN_LOKASI,
					   G.JABATAN, G.DURASI DURASI_JABATAN, G.PERUSAHAAN, C.SEKOLAH, C.IPK,
					   AMBIL_PELAMAR_SIM(A.PELAMAR_ID) SIM,
					   AMBIL_PELAMAR_TOEFL(A.PELAMAR_ID) TOEFL
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID AND (COALESCE(NULLIF(C.IPK, ''), 'X') != 'X' OR COALESCE(NULLIF(C.JURUSAN_PENDIDIKAN, ''), 'X') != 'X')
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN KOTA F ON A.KOTA_ID = F.KOTA_ID
				LEFT JOIN PELAMAR_PEKERJAAN G ON A.PELAMAR_ID = G.PELAMAR_ID
		 		WHERE 1 = 1			 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsDaftarPelamarEksport($cutOff, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC")
	{
		$str = "SELECT A.PELAMAR_ID, NRP, KTP_NO NIK, A.NAMA NAMA_LENGKAP, A.ALAMAT, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, AMBIL_MASA_KERJA(TANGGAL_LAHIR, TO_DATE('29-01-2020', 'DD-MM-YYYY')) UMUR, 
        TELEPON, EMAIL, E.NAMA AGAMA, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, CASE WHEN LAMPIRAN_FOTO IS NULL THEN 'Tidak melampirkan' ELSE 'Melampirkan' END  FOTO,  LAMPIRAN_FOTO,                 
                       C.PENDIDIKAN PENDIDIKAN_TERAKHIR, C.JURUSAN_PENDIDIKAN PENDIDIKAN_JURUSAN, 
                       C.SEKOLAH PENDIDIKAN_INSTANSI, C.JURUSAN_AKREDITASI PENDIDIKAN_AKREDITASI, COALESCE(C.IS_SURAT_KETERANGAN, 'T') PENDIDIKAN_SKL_STATUS,  C.IPK PENDIDIKAN_IPK,
                       AMBIL_PELAMAR_SERTIF_SIMPLE(A.PELAMAR_ID) SERTIFIKAT,
                       AMBIL_PELAMAR_SIM(A.PELAMAR_ID) SIM,
                       AMBIL_PELAMAR_TOEFL(A.PELAMAR_ID) TOEFL
                FROM PELAMAR A 
                INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
                LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID AND (COALESCE(NULLIF(C.IPK, ''), 'X') != 'X' OR COALESCE(NULLIF(C.JURUSAN_PENDIDIKAN, ''), 'X') != 'X')
                LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
                LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
                 WHERE 1 = 1          	 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDaftarPelamarShortlist($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, 
					   CASE 
					   	WHEN COALESCE(F.EMAIL, 0) = 1 THEN '<span class=sudah-diemail>Sudah diemail (' || TO_CHAR(F.EMAIL_TANGGAL, 'DD-MM-YYYY HH24:MI') || ')</span>'  
					   	WHEN COALESCE(F.EMAIL, 0) = 2 THEN '<span class=proses-diemail>Proses email</span>'  
					   	WHEN COALESCE(F.EMAIL, 0) = 3 THEN '<span class=gagal-diemail>Kirim email gagal</span>'
						ELSE NULL
					   END  
					   EMAIL_SHORTLIST, 
					   F.SMS, CASE WHEN F.HADIR = 1 THEN 'Ya' WHEN F.HADIR = 2 THEN 'Tidak' ELSE '' END HADIR, TO_CHAR(F.TANGGAL_HADIR, 'DD-MM-YYYY HH24:MI') TANGGAL_HADIR,
					   F.GELOMBANG_KE
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_SHORTLIST F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsDaftarPelamarShortlistLolos($reqLowonganKategoriKriteriaId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, F.EMAIL EMAIL_SHORTLIST, F.SMS, TO_CHAR(F.TANGGAL_HADIR, 'DD-MM-YYYY HH24:MI') TANGGAL_HADIR,
					   CASE 
					   		WHEN G.REKOMENDASI_ID = 1 THEN 'DISARANKAN'
					   		WHEN G.REKOMENDASI_ID = 2 THEN 'DIPERTIMBANGKAN'
					   		WHEN G.REKOMENDASI_ID = 3 THEN 'TIDAK DISARANKAN'
					   END REKOMENDASI,
					   (SELECT COUNT(1) FROM PELAMAR_TAHAPAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_KATEGORI_KRITERIA_ID = G.LOWONGAN_KATEGORI_KRITERIA_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) STATUS_CHECK, F.HADIR,
					   CASE WHEN F.HADIR = 1 THEN 'Ya' WHEN F.HADIR = 2 THEN 'Tidak' ELSE '' END HADIR_DESC, F.ALASAN, 
					   (SELECT 
						H.STATUS
						 FROM PELAMAR_TAHAPAN_SHORTLIST H WHERE H.PELAMAR_ID = A.PELAMAR_ID
						AND H.LOWONGAN_ID = B.LOWONGAN_ID
						AND H.LOWONGAN_KATEGORI_KRITERIA_PREV_ID = '".(int)$reqLowonganKategoriKriteriaId."' ) STATUS_TAHAPAN,
					   (SELECT CASE WHEN COUNT(1) > 0 THEN 'Ya' ELSE 'Tidak' END FROM PELAMAR_LOWONGAN_NILAI X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_KATEGORI_KRITERIA_ID = G.LOWONGAN_KATEGORI_KRITERIA_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) SUDAH_NILAI, G.REKOMENDASI_ID
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_SHORTLIST F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN PELAMAR_KATEGORI_LOLOS G ON B.PELAMAR_ID = G.PELAMAR_ID AND B.LOWONGAN_ID = G.LOWONGAN_ID AND LOWONGAN_KATEGORI_KRITERIA_ID = '".(int)$reqLowonganKategoriKriteriaId."'
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		// echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsDaftarPelamarDiterima($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NILAI DESC", $reqLowonganKategoriKriteriaId = "NULL")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, F.EMAIL EMAIL_SHORTLIST, F.SMS, CASE WHEN F.HADIR = 1 THEN 'Ya' ELSE '' END HADIR, TO_CHAR(F.TANGGAL_HADIR, 'DD-MM-YYYY HH24:MI') TANGGAL_HADIR,
					   F.NO_BERITA_ACARA, F.DOKUMEN_BERITA_ACARA,
					   CASE WHEN POSTING_SELESAI = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_SELESAI,
					   CASE WHEN POSTING_KONTRAK = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_KONTRAK,
					   CASE WHEN POSTING_ALAT = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_ALAT,
					   CASE WHEN POSTING_BPJS = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_BPJS,
					   COALESCE(NULLIF(POSTING_SELESAI, ''), '0') POSTING_SELESAI, 
					   COALESCE(NULLIF(POSTING_KONTRAK, ''), '0') POSTING_KONTRAK, 
					   COALESCE(NULLIF(POSTING_ALAT, ''), '0') POSTING_ALAT, 
					   COALESCE(NULLIF(POSTING_BPJS, ''), '0') POSTING_BPJS,
					   F.NILAI NILAI_AKHIR,
					   ambil_rincian_nilai(B.LOWONGAN_ID, B.PELAMAR_ID) NILAI_RINCIAN,
					   CASE WHEN F.DITERIMA = '1' THEN 'Diterima' WHEN F.DITERIMA = '0' THEN 'Tidak Diterima' ELSE 'Belum Ditentukan' END STATUS_LULUS,  G.LOWONGAN_ID, COALESCE(NULLIF((SELECT NILAI FROM PELAMAR_LOWONGAN_DITERIMA_NILAI H WHERE H.LOWONGAN_ID = B.LOWONGAN_ID AND H.PELAMAR_ID = A.PELAMAR_ID AND H.LOWONGAN_KATEGORI_KRITERIA_ID = $reqLowonganKategoriKriteriaId), 0), '0') NILAI
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_DITERIMA F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN LOWONGAN G ON B.LOWONGAN_ID = G.LOWONGAN_ID
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsDaftarPelamarGagal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NILAI DESC", $reqLowonganKategoriKriteriaId = "NULL")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, F.EMAIL EMAIL_SHORTLIST, F.SMS, CASE WHEN F.HADIR = 1 THEN 'Ya' ELSE '' END HADIR, TO_CHAR(F.TANGGAL_HADIR, 'DD-MM-YYYY HH24:MI') TANGGAL_HADIR,
					   F.NO_BERITA_ACARA, F.DOKUMEN_BERITA_ACARA,
					   CASE WHEN POSTING_SELESAI = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_SELESAI,
					   CASE WHEN POSTING_KONTRAK = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_KONTRAK,
					   CASE WHEN POSTING_ALAT = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_ALAT,
					   CASE WHEN POSTING_BPJS = '1' THEN 'Sudah Posting' ELSE 'Belum Posting' END STATUS_BPJS,
					   COALESCE(NULLIF(POSTING_SELESAI, ''), '0') POSTING_SELESAI, 
					   COALESCE(NULLIF(POSTING_KONTRAK, ''), '0') POSTING_KONTRAK, 
					   COALESCE(NULLIF(POSTING_ALAT, ''), '0') POSTING_ALAT, 
					   COALESCE(NULLIF(POSTING_BPJS, ''), '0') POSTING_BPJS,
					   F.NILAI NILAI_AKHIR,
					   ambil_rincian_nilai_gagal(B.LOWONGAN_ID, B.PELAMAR_ID) NILAI_RINCIAN,
					   CASE WHEN F.DITERIMA = '1' THEN 'Diterima' WHEN F.DITERIMA = '0' THEN 'Tidak Diterima' ELSE 'Belum Ditentukan' END STATUS_LULUS,  G.LOWONGAN_ID, COALESCE(NULLIF((SELECT NILAI FROM PELAMAR_LOWONGAN_DITERIMA_NILAI H WHERE H.LOWONGAN_ID = B.LOWONGAN_ID AND H.PELAMAR_ID = A.PELAMAR_ID AND H.LOWONGAN_KATEGORI_KRITERIA_ID = $reqLowonganKategoriKriteriaId), 0), '0') NILAI
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_GAGAL F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN LOWONGAN G ON B.LOWONGAN_ID = G.LOWONGAN_ID
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsDaftarPelamarTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA DESC")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, KTP_NO, A.NAMA, E.NAMA AGAMA, JENIS_KELAMIN, AMBIL_UMUR(TANGGAL_LAHIR) UMUR, TINGGI, BERAT_BADAN, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN,					   
					   C.PENDIDIKAN || ' ' || C.JURUSAN_PENDIDIKAN PENDIDIKAN_TERAKHIR, DURASI,
					   AMBIL_PELAMAR_SERTIFIKAT(A.PELAMAR_ID) SERTIFIKAT,
					   AMBIL_PELAMAR_PENDIDIKAN(A.PELAMAR_ID) PENDIDIKAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.LOWONGAN_ID = B.LOWONGAN_ID) > 0 THEN 'Ya' ELSE 'Tidak' END SHORTLIST,
					   (SELECT COUNT(1) FROM pelamar_lowongan X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND NOT X.LOWONGAN_ID = B.LOWONGAN_ID) LAMARAN_LAIN,
					   TEMPAT_LAHIR, TANGGAL_LAHIR, TELEPON, A.EMAIL, LAMPIRAN_FOTO, F.EMAIL EMAIL_SHORTLIST, F.SMS, F.NILAI, TO_CHAR(F.TANGGAL_HADIR, 'DD-MM-YYYY HH24:MI') TANGGAL_HADIR,
					   CASE WHEN F.LOLOS = 1 THEN 'Ya' WHEN F.LOLOS = 2 THEN 'Tidak' ELSE '' END LOLOS, WAWANCARA_RATA_NILAI, WAWANCARA_RATA_REKOM, PSIKOTES_NILAI, PSIKOTES_REKOM, KESEHATAN_KESIMPULAN, KESEHATAN_KETERANGAN, KESEHATAN_SARAN,
					   CASE WHEN (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_TAHAPAN_NILAI X WHERE X.PELAMAR_ID = A.PELAMAR_ID  AND X.LOWONGAN_ID = B.LOWONGAN_ID  AND X.LOWONGAN_TAHAPAN_ID = F.LOWONGAN_TAHAPAN_ID AND X.NILAI IS NOT NULL) > 0 THEN 'Sudah' ELSE 'Belum' END SUDAH_NILAI
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_TAHAPAN F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1		 	
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
		
    function selectByParamsDaftarLowongan($pelamarId, $paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.LOWONGAN_ID, A.KODE, A.NAMA JABATAN, A.PENEMPATAN, A.TANGGAL, A.TANGGAL_AKHIR, C.TANGGAL_KIRIM,
				CASE WHEN A.TANGGAL_AKHIR < current_timestamp THEN 0 ELSE 1 END STATUS_AKTIF
				FROM
				LOWONGAN A 
				LEFT JOIN pelamar_lowongan C ON A.LOWONGAN_ID = C.LOWONGAN_ID AND C.PELAMAR_ID = '".$pelamarId."'
		 		WHERE 1 = 1 AND LOWER(JENIS_LOWONGAN) = 'eksternal'
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.TANGGAL DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDaftarBerkas($lowonganId, $pelamarId)
	{
		$str = "
				SELECT A.NAMA, D.LINK_FILE FROM LOWONGAN_DOKUMEN A
				INNER JOIN pelamar_lowongan C ON C.LOWONGAN_ID = A.LOWONGAN_ID 
				LEFT JOIN PELAMAR_LOWONGAN_DOKUMEN D ON D.PELAMAR_LOWONGAN_ID = C.PELAMAR_LOWONGAN_ID AND A.LOWONGAN_DOKUMEN_ID = D.LOWONGAN_DOKUMEN_ID 
				WHERE 1=1 AND A.LOWONGAN_ID = '".$lowonganId."' AND C.PELAMAR_ID = '".$pelamarId."'
				"; 

		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getPelamarLowonganId($paramsArray=array(), $statement="")
	{
		$str = "SELECT PELAMAR_LOWONGAN_ID AS ROWCOUNT FROM pelamar_lowongan A
		        WHERE PELAMAR_LOWONGAN_ID IS NOT NULL ".$statement; 
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
	
	

    function getValidasiKirimLamaran($lowongan_id, $pelamar_lowongan_id, $statement="")
	{
		$str = "SELECT CASE WHEN (SELECT COUNT(1) FROM LOWONGAN_DOKUMEN A WHERE LOWONGAN_ID = ".$lowongan_id." AND WAJIB = '1') = (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_DOKUMEN A INNER JOIN LOWONGAN_DOKUMEN B ON A.LOWONGAN_DOKUMEN_ID = B.LOWONGAN_DOKUMEN_ID WHERE A.PELAMAR_LOWONGAN_ID = ".$pelamar_lowongan_id." AND B.WAJIB = '1') THEN 1 ELSE 0 END ROWCOUNT ".$statement; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }

	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT FROM pelamar_lowongan
		        WHERE PELAMAR_LOWONGAN_ID IS NOT NULL ".$statement; 
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
	
	
    function getCountByParamsDaftarPelamar($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DISTINCT A.PELAMAR_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID AND (COALESCE(NULLIF(C.IPK, ''), 'X') != 'X' OR COALESCE(NULLIF(C.JURUSAN_PENDIDIKAN, ''), 'X') != 'X')
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN KOTA F ON A.KOTA_ID = F.KOTA_ID
				LEFT JOIN PELAMAR_PEKERJAAN G ON A.PELAMAR_ID = G.PELAMAR_ID
		 		WHERE 1 = 1			 ".$statement; 
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
	
	
    function getCountByParamsDaftarPelamarInformasiTahapan($reqTahapan, $paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DISTINCT A.PELAMAR_ID) AS ROWCOUNT 
				 FROM PELAMAR A 
                INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
                LEFT JOIN PENGUMUMAN_TAHAPAN_SELEKSI C ON A.PELAMAR_ID = C.PELAMAR_ID AND B.LOWONGAN_ID = C.LOWONGAN_ID AND C.KODE_KRITERIA = '".$reqTahapan."'
                 WHERE 1 = 1     	 ".$statement; 
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
	

    function getCountByParamsDaftarPelamarShortlist($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_SHORTLIST F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1			 ".$statement; 
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

    function getCountByParamsDaftarPelamarDiterima($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_DITERIMA F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1			 ".$statement; 
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
	
    function getCountByParamsDaftarPelamarGagal($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_GAGAL F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1			 ".$statement; 
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
	
    function getCountByParamsDaftarPelamarTahapan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				INNER JOIN PELAMAR_LOWONGAN_TAHAPAN F ON A.PELAMAR_ID = F.PELAMAR_ID AND F.LOWONGAN_ID = B.LOWONGAN_ID
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
		 		WHERE 1 = 1	 ".$statement; 
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


    function getCountByParamsDaftarHistoryTahapan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_ID) AS ROWCOUNT 
				FROM PELAMAR A 
				INNER JOIN pelamar_lowongan B ON A.PELAMAR_ID = B.PELAMAR_ID AND B.TANGGAL_KIRIM IS NOT NULL
				LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR C ON A.PELAMAR_ID = C.PELAMAR_ID
				LEFT JOIN PELAMAR_PENGALAMAN_DURASI D ON A.PELAMAR_ID = D.PELAMAR_ID
				LEFT JOIN AGAMA E ON A.AGAMA_ID = E.AGAMA_ID
				LEFT JOIN KOTA F ON A.KOTA_ID = F.KOTA_ID
                LEFT JOIN PELAMAR_LOWONGAN_NILAI AA ON AA.PELAMAR_ID = B.PELAMAR_ID AND AA.LOWONGAN_ID = B.LOWONGAN_ID
		 		WHERE 1 = 1		 ".$statement; 
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