<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel LOWONGAN_PERSYARATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganPersyaratan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganPersyaratan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_PERSYARATAN_ID", $this->getSeqId("LOWONGAN_PERSYARATAN_ID","LOWONGAN_PERSYARATAN"));

		$str = "
				INSERT INTO LOWONGAN_PERSYARATAN(
			            LOWONGAN_PERSYARATAN_ID, LOWONGAN_ID, NAMA, TAMPILKAN, 
			            JENIS_PERSYARATAN_ID, JENIS_KELAMIN, MIN_UMUR, 
			            MAX_UMUR, TMT_UMUR, MIN_PENDIDIKAN_ID, 
			            MAX_PENDIDIKAN_ID, TAHUN_PENGALAMAN, JABATAN_ID, 
			            STATUS_KAWIN, JURUSAN_ID, KOTA_ID, 
			            STATUS_ENTRI, NAMA_JENIS_PERSYARATAN, JENIS_SIM_ID, 
			            SERTIFIKAT_ID, SCORE_TOEFL, TINGGI_BADAN, BERAT_BADAN, OPERASI_DOMISILI)
			    VALUES ('".$this->getField("LOWONGAN_PERSYARATAN_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("NAMA")."', '".$this->getField("TAMPILKAN")."', 
			    		'".$this->getField("JENIS_PERSYARATAN_ID")."', '".$this->getField("JENIS_KELAMIN")."', '".$this->getField("MIN_UMUR")."', 
			    		'".$this->getField("MAX_UMUR")."', ".$this->getField("TMT_UMUR").", ".$this->getField("MIN_PENDIDIKAN_ID").", 
			            ".$this->getField("MAX_PENDIDIKAN_ID").", '".$this->getField("TAHUN_PENGALAMAN")."', ".$this->getField("JABATAN_ID").", 
			            '".$this->getField("STATUS_KAWIN")."', ".$this->getField("JURUSAN_ID").", ".$this->getField("KOTA_ID").", 
			            '".$this->getField("STATUS_ENTRI")."', '".$this->getField("NAMA_JENIS_PERSYARATAN")."', ".$this->getField("JENIS_SIM_ID").",
			            ".$this->getField("SERTIFIKAT_ID").", '".$this->getField("SCORE_TOEFL")."', '".$this->getField("TINGGI_BADAN")."', '".$this->getField("BERAT_BADAN")."', '".$this->getField("OPERASI_DOMISILI")."'

				)"; 
				
				// echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_PERSYARATAN
				   SET NAMA 					= '".$this->getField("NAMA")."',
				       JENIS_PERSYARATAN_ID 	= '".$this->getField("JENIS_PERSYARATAN_ID")."',
				       JENIS_KELAMIN 			= '".$this->getField("JENIS_KELAMIN")."',
				       MIN_UMUR 				= '".$this->getField("MIN_UMUR")."',
				       MAX_UMUR 				= '".$this->getField("MAX_UMUR")."',
				       TMT_UMUR 				= ".$this->getField("TMT_UMUR").",
				       MIN_PENDIDIKAN_ID 		= ".$this->getField("MIN_PENDIDIKAN_ID").",
				       MAX_PENDIDIKAN_ID 		= ".$this->getField("MAX_PENDIDIKAN_ID").",
				       TAHUN_PENGALAMAN 		= '".$this->getField("TAHUN_PENGALAMAN")."',
				       JABATAN_ID 				= ".$this->getField("JABATAN_ID").",
				       STATUS_KAWIN 			= '".$this->getField("STATUS_KAWIN")."',
				       JURUSAN_ID 				= ".$this->getField("JURUSAN_ID").",
				       KOTA_ID 					= ".$this->getField("KOTA_ID").",
				       STATUS_ENTRI 			= '".$this->getField("STATUS_ENTRI")."',
				       JENIS_SIM_ID				= ".$this->getField("JENIS_SIM_ID").",
				       SERTIFIKAT_ID			= ".$this->getField("SERTIFIKAT_ID").",
				       SCORE_TOEFL				= '".$this->getField("SCORE_TOEFL")."',
				       TINGGI_BADAN				= '".$this->getField("TINGGI_BADAN")."',
				       BERAT_BADAN				= '".$this->getField("BERAT_BADAN")."',
				       OPERASI_DOMISILI			= '".$this->getField("OPERASI_DOMISILI")."',
				       TAMPILKAN				= '".$this->getField("TAMPILKAN")."'
				WHERE  LOWONGAN_PERSYARATAN_ID 	= '".$this->getField("LOWONGAN_PERSYARATAN_ID")."'
			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		$str = "UPDATE LOWONGAN_PERSYARATAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE LOWONGAN_PERSYARATAN_ID = ".$this->getField("LOWONGAN_PERSYARATAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM LOWONGAN_PERSYARATAN
                WHERE 
                  LOWONGAN_PERSYARATAN_ID = '".$this->getField("LOWONGAN_PERSYARATAN_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM LOWONGAN_PERSYARATAN
                WHERE 
                  LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_PERSYARATAN_ID ASC")
	{
		$str = "
				SELECT 
						A.LOWONGAN_PERSYARATAN_ID, 
						A.LOWONGAN_ID, 
						A.NAMA, 
						A.JENIS_PERSYARATAN_ID, 
						A.JENIS_KELAMIN, 
						A.MIN_UMUR, 
						A.MAX_UMUR, 
						A.TMT_UMUR, 
						A.MIN_PENDIDIKAN_ID,
						A.MAX_PENDIDIKAN_ID, 
						A.TAHUN_PENGALAMAN, 
						A.JABATAN_ID, 
						A.STATUS_KAWIN, 
						A.JURUSAN_ID, 
						A.KOTA_ID, 
						A.STATUS_ENTRI, 
						B.NAMA JENIS_PERSYARATAN, 
						A.JENIS_SIM_ID,
						A.SERTIFIKAT_ID, 
						A.SCORE_TOEFL, 
						A.TINGGI_BADAN, 
						A.BERAT_BADAN, 
						B.PREFIX, 
						A.TAMPILKAN,
						CASE 
							WHEN B.PREFIX = 'JENIS_KELAMIN' THEN 
								CONCAT('Jenis Kelamin: ', 
									CASE 
										WHEN A.JENIS_KELAMIN = 'L' THEN 'Laki-laki'
										WHEN A.JENIS_KELAMIN = 'P' THEN 'Perempuan'
										WHEN A.JENIS_KELAMIN = 'L/P' THEN 'Laki-laki / Perempuan'
									END
								)
							WHEN B.PREFIX = 'PENDIDIKAN' THEN 
								CONCAT('Min: ', (SELECT NAMA FROM PENDIDIKAN WHERE PENDIDIKAN_ID = A.MIN_PENDIDIKAN_ID), 
									', Max: ', (SELECT NAMA FROM PENDIDIKAN WHERE PENDIDIKAN_ID = A.MAX_PENDIDIKAN_ID), 
									', Keahlian: ', (SELECT NAMA FROM JURUSAN_KELOMPOK WHERE JURUSAN_KELOMPOK_ID = A.JURUSAN_ID))
							WHEN B.PREFIX = 'USIA' THEN 
								CONCAT('Min: ', A.MIN_UMUR, ' Th, Max: ', A.MAX_UMUR, ' Th, TMT: ', DATE_FORMAT(A.TMT_UMUR, '%d-%m-%Y'))
							WHEN B.PREFIX = 'PENGALAMAN' THEN 
								CONCAT('Pengalaman: ', A.TAHUN_PENGALAMAN, ' Th, Jabatan: ', 
									(SELECT NAMA FROM JENJANG_JABATAN WHERE JENJANG_JABATAN_ID = A.JABATAN_ID))
							WHEN B.PREFIX = 'DOMISILI' THEN 
								CONCAT('Domisili: ', (SELECT NAMA FROM KOTA WHERE KOTA_ID = A.KOTA_ID))
							WHEN B.PREFIX = 'STATUS_KAWIN' THEN 
								CONCAT('Status Kawin: ', 
									CASE 
										WHEN A.STATUS_KAWIN = 'Y' THEN 'Ya'
										WHEN A.STATUS_KAWIN = 'T' THEN 'Tidak'
									END
								)
							WHEN B.PREFIX = 'SIM' THEN 
								CONCAT('SIM: ', (SELECT NAMA FROM JENIS_SIM WHERE JENIS_SIM_ID = A.JENIS_SIM_ID))
							WHEN B.PREFIX = 'ENTRI' THEN 
								CONCAT('Entri: ', 
									CASE 
										WHEN A.STATUS_ENTRI = 'Y' THEN 'Ya'
										WHEN A.STATUS_ENTRI = 'T' THEN 'Tidak'
									END
								)
							WHEN B.PREFIX = 'SERTIFIKAT' THEN 
								CONCAT('Sertifikat: ', (SELECT NAMA FROM SERTIFIKAT WHERE SERTIFIKAT_ID = A.SERTIFIKAT_ID))
							WHEN B.PREFIX = 'TOEFL' THEN 
								CONCAT('Toefl: ', A.SCORE_TOEFL)
							WHEN B.PREFIX = 'TINGGI_BADAN' THEN 
								CONCAT('Tinggi: ', A.TINGGI_BADAN)
							WHEN B.PREFIX = 'BERAT_BADAN' THEN 
								CONCAT('Berat: ', A.BERAT_BADAN)
						END AS NAMA_PERSYARATAN
					FROM LOWONGAN_PERSYARATAN A
					LEFT JOIN JENIS_PERSYARATAN B ON A.JENIS_PERSYARATAN_ID = B.JENIS_PERSYARATAN_ID
					WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ".$order;
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
		$str = "SELECT COUNT(LOWONGAN_PERSYARATAN_ID) AS ROWCOUNT 
				FROM LOWONGAN_PERSYARATAN A
		        WHERE LOWONGAN_PERSYARATAN_ID IS NOT NULL ".$statement; 
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