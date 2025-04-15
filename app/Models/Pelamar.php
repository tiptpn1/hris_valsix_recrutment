<?


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class Pelamar extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Pelamar()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_ID", $this->getSeqId("PELAMAR_ID","pelamar"));
		
		$NRP = date("Y").generateZero($this->getField("PELAMAR_ID"), 5);
		$this->setField("NRP", $NRP);

		$str = "
				INSERT INTO pelamar (
				   PELAMAR_ID, NAMA, NIPP, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR,
				   STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT,
   				   TELEPON, WHATSAPP, EMAIL, NRP, REKENING_NO, REKENING_NAMA, NPWP, NO_MPP, CREATED_BY, 
				   JAMSOSTEK_NO, HOBBY, TINGGI, BERAT_BADAN, NO_SEPATU, KTP_NO, KELOMPOK_PELAMAR, KESEHATAN_FASKES, KK_NO, DOMISILI
				   )
 			  	VALUES (
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIPP")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  '".$this->getField("STATUS_KAWIN")."',
				  '".$this->getField("GOLONGAN_DARAH")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("NRP")."',
				  '".$this->getField("REKENING_NO")."',
				  '".$this->getField("REKENING_NAMA")."',
				  '".$this->getField("NPWP")."',
				  '".$this->getField("NO_MPP")."',
				  '".$this->getField("CREATED_BY")."',
				  '".$this->getField("JAMSOSTEK_NO")."',
				  '".$this->getField("HOBBY")."',
				  '".$this->getField("TINGGI")."',
				  '".$this->getField("BERAT_BADAN")."',
				  '".$this->getField("NO_SEPATU")."',
				  '".$this->getField("KTP_NO")."',
				  '".$this->getField("KELOMPOK_PELAMAR")."',
				  '".$this->getField("KESEHATAN_FASKES")."',
				  '".$this->getField("KK_NO")."',
				  '".$this->getField("DOMISILI")."'
				)";
		$this->id = $this->getField("PELAMAR_ID");
		// echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertDataImport()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_ID", $this->getSeqId("PELAMAR_ID","pelamar"));
		$str = "
				INSERT INTO pelamar (
				   PELAMAR_ID, NAMA, NRP, JENIS_KELAMIN, TELEPON, EMAIL, KTP_NO, PERIODE_ID, OFFLINEE, AKTIVASI, CREATED_DATE
				   )
 			  	VALUES (
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NRP")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("KTP_NO")."',
				  '".$this->getField("PERIODE_ID")."',
				  '1',
				  '1',
				  current_timestamp
				 ) ";
		$this->id = $this->getField("PELAMAR_ID");
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertDataOffline()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_ID", $this->getSeqId("PELAMAR_ID","pelamar"));
		$str = "
				INSERT INTO pelamar (
				   PELAMAR_ID, NAMA, NIPP, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR,
				   STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT,
   				   TELEPON, EMAIL, NRP, REKENING_NO, REKENING_NAMA, NPWP, TANGGAL_PENSIUN,
				   TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, CREATED_BY, CREATED_DATE,
				   JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, KESEHATAN_NO, KESEHATAN_TANGGAL, HOBBY, FINGER_ID, TANGGAL_NPWP, TINGGI, BERAT_BADAN, NO_SEPATU, KTP_NO, TGL_NON_AKTIF, TGL_DIKELUARKAN,
				   TGL_KONTRAK_AKHIR, KELOMPOK_PELAMAR, KESEHATAN_FASKES, KK_NO, DOMISILI, KOTA_ID,
				    ALAMAT_PROVINSI_ID, ALAMAT_KOTA_ID, ALAMAT_KECAMATAN_ID, ALAMAT_KELURAHAN_ID, OFFLINEE
				   )
 			  	VALUES (
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIPP")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  '".$this->getField("STATUS_KAWIN")."',
				  '".$this->getField("GOLONGAN_DARAH")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("NRP")."',
				  '".$this->getField("REKENING_NO")."',
				  '".$this->getField("REKENING_NAMA")."',
				  '".$this->getField("NPWP")."',
				  ".$this->getField("TANGGAL_PENSIUN").",
				  ".$this->getField("TANGGAL_MUTASI_KELUAR").",
				  ".$this->getField("TANGGAL_WAFAT").",
				  ".$this->getField("TANGGAL_MPP").",
				  '".$this->getField("NO_MPP")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				  '".$this->getField("JAMSOSTEK_NO")."',
				  ".$this->getField("JAMSOSTEK_TANGGAL").",
				  '".$this->getField("KESEHATAN_NO")."',
				  ".$this->getField("KESEHATAN_TANGGAL").",
				  '".$this->getField("HOBBY")."',
				  ".$this->getField("FINGER_ID").",
				  ".$this->getField("TANGGAL_NPWP").",
				  '".$this->getField("TINGGI")."',
				  '".$this->getField("BERAT_BADAN")."',
				  '".$this->getField("NO_SEPATU")."',
				  '".$this->getField("KTP_NO")."',
				  ".$this->getField("TGL_NON_AKTIF").",
				  ".$this->getField("TGL_DIKELUARKAN").",
				  ".$this->getField("TGL_KONTRAK_AKHIR").",
				  '".$this->getField("KELOMPOK_PELAMAR")."',
				  '".$this->getField("KESEHATAN_FASKES")."',
				  '".$this->getField("KK_NO")."',
				  '".$this->getField("DOMISILI")."',
				  ".$this->getField("KOTA_ID").",
				  ".$this->getField("ALAMAT_PROVINSI_ID").",
				  ".$this->getField("ALAMAT_KOTA_ID").",
				  ".$this->getField("ALAMAT_KECAMATAN_ID").",
				  ".$this->getField("ALAMAT_KELURAHAN_ID").",
				  '1'
				)";
		$this->id = $this->getField("PELAMAR_ID");
		// echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar
				SET
					   NAMA           			= '".$this->getField("NAMA")."',
					   NIPP      				= '".$this->getField("NIPP")."',
					   JENIS_KELAMIN    		= '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR     		= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR			= ".$this->getField("TANGGAL_LAHIR").",
					   STATUS_KAWIN				= '".$this->getField("STATUS_KAWIN")."',
					   GOLONGAN_DARAH			= '".$this->getField("GOLONGAN_DARAH")."',
					   ALAMAT					= '".$this->getField("ALAMAT")."',
					   TELEPON					= '".$this->getField("TELEPON")."',
					   WHATSAPP					= '".$this->getField("WHATSAPP")."',
					   EMAIL					= '".$this->getField("EMAIL")."',
					   NRP						= '".$this->getField("NRP")."',
					   DEPARTEMEN_ID			= ".$this->getField("DEPARTEMEN_ID").",
					   AGAMA_ID					= '".$this->getField("AGAMA_ID")."',
					   REKENING_NAMA			= '".$this->getField("REKENING_NAMA")."',
					   NPWP						= '".$this->getField("NPWP")."',
					   TANGGAL_PENSIUN			= ".$this->getField("TANGGAL_PENSIUN").",
					   TANGGAL_MUTASI_KELUAR	= ".$this->getField("TANGGAL_MUTASI_KELUAR").",
					   TANGGAL_WAFAT			= ".$this->getField("TANGGAL_WAFAT").",
					   TANGGAL_MPP				= ".$this->getField("TANGGAL_MPP").",
				  	   NO_MPP					= '".$this->getField("NO_MPP")."',
					   STATUS_KELUARGA_ID		= '".$this->getField("STATUS_KELUARGA_ID")."',
					   UPDATED_BY			= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE			= ".$this->getField("UPDATED_DATE").",
					   JAMSOSTEK_NO				= '".$this->getField("JAMSOSTEK_NO")."',
					   JAMSOSTEK_TANGGAL		= ".$this->getField("JAMSOSTEK_TANGGAL").",
					   KESEHATAN_NO				= '".$this->getField("KESEHATAN_NO")."',
					   KESEHATAN_TANGGAL		= ".$this->getField("KESEHATAN_TANGGAL").",
					   KESEHATAN_FASKES			= '".$this->getField("KESEHATAN_FASKES")."',
					   KK_NO					= '".$this->getField("KK_NO")."',
					   HOBBY					= '".$this->getField("HOBBY")."',
					   FINGER_ID				= ".$this->getField("FINGER_ID").",
					   TANGGAL_NPWP				= ".$this->getField("TANGGAL_NPWP").",
					   TINGGI					= '".$this->getField("TINGGI")."',
				  	   BERAT_BADAN				= '".$this->getField("BERAT_BADAN")."',
				  	   NO_SEPATU				= '".$this->getField("NO_SEPATU")."',
					   KTP_NO					= '".$this->getField("KTP_NO")."',
				  	   TGL_DIKELUARKAN			= ".$this->getField("TGL_DIKELUARKAN").",
				  	   TGL_KONTRAK_AKHIR		= ".$this->getField("TGL_KONTRAK_AKHIR").",
					   TGL_NON_AKTIF 			= ".$this->getField("TGL_NON_AKTIF").",
					   DOMISILI		 			= '".$this->getField("DOMISILI")."',
					   FACEBOOK		 			= '".$this->getField("FACEBOOK")."',
					   INSTAGRAM		 		= '".$this->getField("INSTAGRAM")."',
					   TWITTER		 			= '".$this->getField("TWITTER")."',
					   LINKEDIN		 			= '".$this->getField("LINKEDIN")."',
					   KOTA_ID		 			= '".$this->getField("KOTA_ID")."',
				  	   ALAMAT_PROVINSI_ID 		= ".$this->getField("ALAMAT_PROVINSI_ID").",
				   	   ALAMAT_KOTA_ID 			= ".$this->getField("ALAMAT_KOTA_ID").",
				  	   ALAMAT_KECAMATAN_ID 		= ".$this->getField("ALAMAT_KECAMATAN_ID").",
				  	   ALAMAT_KELURAHAN_ID 		= ".$this->getField("ALAMAT_KELURAHAN_ID")."
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateOffline()
	{
		$str = "
				UPDATE pelamar
				SET
					   NAMA           			= '".$this->getField("NAMA")."',
					   NIPP      				= '".$this->getField("NIPP")."',
					   JENIS_KELAMIN    		= '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR     		= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR			= ".$this->getField("TANGGAL_LAHIR").",
					   STATUS_KAWIN				= '".$this->getField("STATUS_KAWIN")."',
					   GOLONGAN_DARAH			= '".$this->getField("GOLONGAN_DARAH")."',
					   ALAMAT					= '".$this->getField("ALAMAT")."',
					   TELEPON					= '".$this->getField("TELEPON")."',
					   EMAIL					= '".$this->getField("EMAIL")."',
					   NRP						= '".$this->getField("NRP")."',
					   DEPARTEMEN_ID			= ".$this->getField("DEPARTEMEN_ID").",
					   AGAMA_ID					= '".$this->getField("AGAMA_ID")."',
					   REKENING_NAMA			= '".$this->getField("REKENING_NAMA")."',
					   NPWP						= '".$this->getField("NPWP")."',
					   TANGGAL_PENSIUN			= ".$this->getField("TANGGAL_PENSIUN").",
					   TANGGAL_MUTASI_KELUAR	= ".$this->getField("TANGGAL_MUTASI_KELUAR").",
					   TANGGAL_WAFAT			= ".$this->getField("TANGGAL_WAFAT").",
					   TANGGAL_MPP				= ".$this->getField("TANGGAL_MPP").",
				  	   NO_MPP					= '".$this->getField("NO_MPP")."',
					   STATUS_KELUARGA_ID		= ".$this->getField("STATUS_KELUARGA_ID").",
					   UPDATED_BY			= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE			= ".$this->getField("UPDATED_DATE").",
					   JAMSOSTEK_NO				= '".$this->getField("JAMSOSTEK_NO")."',
					   JAMSOSTEK_TANGGAL		= ".$this->getField("JAMSOSTEK_TANGGAL").",
					   KESEHATAN_NO				= '".$this->getField("KESEHATAN_NO")."',
					   KESEHATAN_TANGGAL		= ".$this->getField("KESEHATAN_TANGGAL").",
					   KESEHATAN_FASKES			= '".$this->getField("KESEHATAN_FASKES")."',
					   KK_NO					= '".$this->getField("KK_NO")."',
					   HOBBY					= '".$this->getField("HOBBY")."',
					   FINGER_ID				= ".$this->getField("FINGER_ID").",
					   TANGGAL_NPWP				= ".$this->getField("TANGGAL_NPWP").",
					   TINGGI					= '".$this->getField("TINGGI")."',
				  	   BERAT_BADAN				= '".$this->getField("BERAT_BADAN")."',
				  	   NO_SEPATU				= '".$this->getField("NO_SEPATU")."',
					   KTP_NO					= '".$this->getField("KTP_NO")."',
				  	   TGL_DIKELUARKAN			= ".$this->getField("TGL_DIKELUARKAN").",
				  	   TGL_KONTRAK_AKHIR		= ".$this->getField("TGL_KONTRAK_AKHIR").",
					   TGL_NON_AKTIF 			= ".$this->getField("TGL_NON_AKTIF").",
					   DOMISILI		 			= '".$this->getField("DOMISILI")."',
					   KOTA_ID		 			= ".$this->getField("KOTA_ID").",
				  	   ALAMAT_PROVINSI_ID 		= ".$this->getField("ALAMAT_PROVINSI_ID").",
				   	   ALAMAT_KOTA_ID 			= ".$this->getField("ALAMAT_KOTA_ID").",
				  	   ALAMAT_KECAMATAN_ID 		= ".$this->getField("ALAMAT_KECAMATAN_ID").",
				  	   ALAMAT_KELURAHAN_ID 		= ".$this->getField("ALAMAT_KELURAHAN_ID")."
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function verifikasi()
	{
		$str = "
				UPDATE pelamar
				SET
					   VERIFIKASI     			= '".$this->getField("VERIFIKASI")."',
					   VERIFIKASI_REKOMENDASI   = '".$this->getField("VERIFIKASI_REKOMENDASI")."',
					   VERIFIKASI_CATATAN     	= '".$this->getField("VERIFIKASI_CATATAN")."',
					   VERIFIKASI_BY     		= '".$this->getField("VERIFIKASI_BY")."',
					   VERIFIKASI_DATE	     	= current_timestamp,
					   VERIFIKASI_REVISI_TANGGAL = current_timestamp
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;

		return $this->execQuery($str);
    }


	function verifikasi_revisi()
	{
		$str = "
				UPDATE pelamar
				SET
					   VERIFIKASI     			= '".$this->getField("VERIFIKASI")."',
					   VERIFIKASI_REKOMENDASI   = '".$this->getField("VERIFIKASI_REKOMENDASI")."',
					   VERIFIKASI_CATATAN     	= '".$this->getField("VERIFIKASI_CATATAN")."',
					   VERIFIKASI_BY     		= '".$this->getField("VERIFIKASI_BY")."',
					   VERIFIKASI_DATE	     	= current_timestamp
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;

		return $this->execQuery($str);
    }


	function verifikasiDokumen()
	{
		$str = "
				UPDATE pelamar
				SET
					   ".$this->getField("KOLOM_VERIFIKASI")."  = '".$this->getField("VERIFIKASI")."',
					   ".$this->getField("KOLOM_ALASAN")."  = '".$this->getField("ALASAN")."',
					   LAST_VERIFIED_USER     	= '".$this->getField("LAST_VERIFIED_USER")."',
					   LAST_VERIFIED_DATE     	= current_timestamp
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }


	function revisi()
	{
		$str = " CALL PELAMAR_VERIFIKASI_REVISI('".$this->getField("PELAMAR_ID")."') ";
		$this->query = $str;
		return $this->execQuery($str);
    }


	function aktivasi()
	{
		$str = "
				UPDATE pelamar
				SET
					   AKTIVASI     			= '1'
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }

	function kirimLamaran()
	{
		$str = "
				UPDATE pelamar
				SET
					   KIRIM_LAMARAN     		= '1',
					   PERIODE_ID     			= '".$this->getField("PERIODE_ID")."'
				WHERE  PELAMAR_ID     			= '".$this->getField("PELAMAR_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	 function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pelamar SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PELAMAR_ID = ".$this->getField("PELAMAR_ID")."
				";
				$this->query = $str;
		return $this->execQuery($str);
    }


	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }

	function delete()
	{
        $str = "UPDATE pelamar
				SET
					   STATUS_PELAMAR_ID	 = 6,
					   TGL_NON_AKTIF 	     = TO_DATE('01-01-1990', 'DD-MM-YYYY'),
					   STATUS_HAPUS 		 = 1
				WHERE  PELAMAR_ID     		 = '".$this->getField("PELAMAR_ID")."' ";

		$this->query = $str;
        return $this->execQuery($str);
    }

	function execExpired()
	{
        $str = "SELECT PROSES_HAPUS_EXPIRED_PELAMAR() ";

		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
					PELAMAR_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
					TANGGAL_LAHIR, STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT, TELEPON, WHATSAPP, EMAIL,
					FOTO, DEPARTEMEN_ID, A.AGAMA_ID, STATUS_PELAMAR_ID, BANK_ID, REKENING_NO,
					REKENING_NAMA, NPWP, TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR,
					TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, FINGER_ID,
					JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, NIS, TANGGAL_NPWP, TINGGI,
					BERAT_BADAN, MAGANG_TIPE, KTP_NO, TGL_NON_AKTIF, KELOMPOK_PELAMAR,
					REKENING_NO2, PENDIDIKAN_TERAKHIR, STATUS_HAPUS, TGL_DIKELUARKAN,
					LINK_BLANKO_KGB1, LINK_BLANKO_KGB2, LINK_BLANKO_KGB3,
					TGL_KONTRAK_AKHIR, KESEHATAN_NO, KESEHATAN_TANGGAL, KESEHATAN_FASKES,
					KK_NO, NO_SEPATU, A.CREATED_BY, A.CREATED_DATE, A.UPDATED_BY,
					A.UPDATED_DATE, PAKTA_INTEGRITAS, LAMPIRAN_CV, LAMPIRAN_KTP, LAMPIRAN_NOKK,
					LAMPIRAN_FOTO, LAMPIRAN_IJASAH, LAMPIRAN_TRANSKRIP, LAMPIRAN_SKCK,
					LAMPIRAN_SKS, LAMPIRAN_SURAT_LAMARAN,
					CASE 
						WHEN JENIS_KELAMIN = 'L' THEN 'Laki-laki' 
						WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' 
						ELSE '' 
					END AS JENIS_KELAMIN_KET,
					ambil_umur(TANGGAL_LAHIR) AS UMUR, 
					VERIFIKASI, 
					DATE_FORMAT(VERIFIKASI_DATE, '%d-%m-%Y %H:%i') AS VERIFIKASI_DATE, 
					VERIFIKASI_BY, LAST_VERIFIED_USER, LAST_VERIFIED_DATE, 
					B.NAMA AS AGAMA,
					AMBIL_STATUS_NIKAH(STATUS_KAWIN) AS STATUS_NIKAH, 
					DOMISILI, A.KOTA_ID, C.NAMA AS NAMA_KOTA, 
					D.NAMA AS NAMA_PROVINSI, A.ALAMAT_KELURAHAN_ID, A.ALAMAT_KECAMATAN_ID,
					A.ALAMAT_KOTA_ID, A.ALAMAT_PROVINSI_ID, 
					ambil_pelamar_sim(A.PELAMAR_ID) AS SIM, 
					ambil_pelamar_sim_id(A.PELAMAR_ID) AS SIM_ID,
					AMBIL_PELAMAR_SERTIF_N_FORMAT(A.PELAMAR_ID) AS SERTIFIKAT, 
					AMBIL_PEL_SERTIF_N_FORMAT_ID(A.PELAMAR_ID) AS SERTIFIKAT_ID,
					DATE_FORMAT(A.CREATED_DATE, '%d-%m-%Y %H:%i:%s') AS TANGGAL_DAFTAR,
					FACEBOOK, INSTAGRAM, TWITTER, LINKEDIN, 
					VERIFIKASI_CV, VERIFIKASI_KTP, VERIFIKASI_FOTO,
					VERIFIKASI_IJASAH, VERIFIKASI_TRANSKRIP, VERIFIKASI_SKCK,
					VERIFIKASI_SKS, ALASAN_CV, ALASAN_KTP,
					ALASAN_FOTO, ALASAN_IJASAH, ALASAN_TRANSKRIP,
					ALASAN_SKCK, ALASAN_SKS, VERIFIKASI_SURAT_LAMARAN,
					ALASAN_SURAT_LAMARAN, VERIFIKASI_REKOMENDASI, VERIFIKASI_CATATAN, 
					VERIFIKASI_REVISI, VERIFIKASI_REVISI_TANGGAL
				FROM pelamar A
				LEFT JOIN AGAMA B ON A.AGAMA_ID = B.AGAMA_ID
				LEFT JOIN KOTA C ON A.KOTA_ID = C.KOTA_ID
				LEFT JOIN PROVINSI D ON C.PROVINSI_ID = D.PROVINSI_ID
				WHERE 1 = 1

			";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;
		 //echo $str; exit;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }


    function selectByParamsTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				TAHAPAN, PERIODE_ID, PELAMAR_ID, 
				   PELAMAR_NRP, pelamar, GELOMBANG_ID, 
				   GELOMBANG_KE, GELOMBANG_TANGGAL, GELOMBANG_JAM, 
				   GELOMBANG_LOKASI, EMAIL_TANGGAL
				FROM PELAMAR_TAHAPAN_GELOMBANG A
				WHERE 1 = 1
			";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;
		// echo $str;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }


    function selectByParamsCutOff($cutOff, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT A.PELAMAR_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
					   TANGGAL_LAHIR, STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT, TELEPON, EMAIL,
					   FOTO, DEPARTEMEN_ID, A.AGAMA_ID, STATUS_PELAMAR_ID, BANK_ID, REKENING_NO,
					   REKENING_NAMA, NPWP, TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR,
					   TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, FINGER_ID,
					   JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, NIS, TANGGAL_NPWP, TINGGI,
					   BERAT_BADAN, MAGANG_TIPE, KTP_NO, TGL_NON_AKTIF, KELOMPOK_PELAMAR,
					   REKENING_NO2, PENDIDIKAN_TERAKHIR, STATUS_HAPUS, TGL_DIKELUARKAN,
					   LINK_BLANKO_KGB1, LINK_BLANKO_KGB2, LINK_BLANKO_KGB3,
					   TGL_KONTRAK_AKHIR, KESEHATAN_NO, KESEHATAN_TANGGAL, KESEHATAN_FASKES,
					   KK_NO, NO_SEPATU, A.CREATED_BY, A.CREATED_DATE, A.UPDATED_BY,
					   A.UPDATED_DATE, PAKTA_INTEGRITAS, LAMPIRAN_CV, LAMPIRAN_KTP,LAMPIRAN_NOKK,
					   LAMPIRAN_FOTO, LAMPIRAN_IJASAH, LAMPIRAN_TRANSKRIP, LAMPIRAN_SKCK,
					   LAMPIRAN_SKS, LAMPIRAN_SURAT_LAMARAN,
					   CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki-laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' ELSE '' END JENIS_KELAMIN_KET,
					   ambil_masa_kerja(TANGGAL_LAHIR, TO_DATE('".$cutOff."', 'DD-MM-YYYY')) UMUR, VERIFIKASI, LAST_VERIFIED_USER, LAST_VERIFIED_DATE, B.NAMA AGAMA,
					   AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_NIKAH, DOMISILI, A.KOTA_ID, C.NAMA NAMA_KOTA,
					   AMBIL_PELAMAR_MINAT_JABATAN(A.PELAMAR_ID) PEMINATAN_JABATAN,
					   AMBIL_PELAMAR_PEMINATAN_LOKASI(A.PELAMAR_ID) PEMINATAN_LOKASI,

					    A.ALAMAT_KELURAHAN_ID, A.ALAMAT_KECAMATAN_ID,
					   A.ALAMAT_KOTA_ID, A.ALAMAT_PROVINSI_ID, A.OFFLINEE,
					   CASE
					   		WHEN A.OFFLINEE = '1' THEN 'Offline'
					   		ELSE 'Online'
					   	END STATUS_PELAMAR
				  FROM pelamar A
				LEFT JOIN AGAMA B ON A.AGAMA_ID = B.AGAMA_ID
				LEFT JOIN KOTA C ON A.KOTA_ID = C.KOTA_ID
				WHERE 1 = 1 AND NOT EXISTS(SELECT 1 FROM PELAMAR_LOWONGAN_DITERIMA X WHERE X.PELAMAR_ID = A.PELAMAR_ID AND X.HADIR = 1)
			";
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;

		//" ORDER BY A.NAMA ASC"
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }
    function selectByParamsCutOffSimple($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
						A.PELAMAR_ID, 
						A.NRP, 
						A.NAMA, 
						CASE 
							WHEN A.JENIS_KELAMIN = 'L' THEN 'Laki-laki' 
							WHEN A.JENIS_KELAMIN = 'P' THEN 'Perempuan' 
							ELSE '' 
						END AS JENIS_KELAMIN_KET, 
						A.TEMPAT_LAHIR,
						C.NAMA AS DOMISILI,
						A.ALAMAT, 
						A.KTP_NO, 
						A.TELEPON, 
						COALESCE(D.PENDIDIKAN, '-') AS PENDIDIKAN_TERAKHIR, 
						E.JABATAN, 
						E.DURASI, 
						E.PERUSAHAAN,
						B.NAMA AS AGAMA, 
						CASE 
							WHEN A.STATUS_KAWIN = 'Y' THEN 'Menikah'
							WHEN A.STATUS_KAWIN = 'T' THEN 'Belum Menikah'
							ELSE 'Tidak Diketahui' 
						END AS STATUS_NIKAH,
						A.TINGGI, 
						A.BERAT_BADAN,
						DATE_FORMAT(A.CREATED_DATE, '%d-%m-%Y %H:%i:%s') AS TANGGAL_DAFTAR,
						DATE_FORMAT(A.TANGGAL_LAHIR, '%d-%m-%Y') AS TANGGAL_LAHIR,
						A.LAMPIRAN_FOTO
					FROM pelamar A
					LEFT JOIN AGAMA B ON A.AGAMA_ID = B.AGAMA_ID
					LEFT JOIN KOTA C ON A.KOTA_ID = C.KOTA_ID
					LEFT JOIN PELAMAR_PENDIDIKAN_TERAKHIR D ON A.PELAMAR_ID = D.PELAMAR_ID
					LEFT JOIN PELAMAR_PEKERJAAN E ON A.PELAMAR_ID = E.PELAMAR_ID
					WHERE 1 = 1
			";
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;

		//" ORDER BY A.NAMA ASC"
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }

    function selectByParamsDaftarEntrian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY DAFTAR_ENTRIAN_ID ASC ")
	{
		$str = "
				SELECT DAFTAR_ENTRIAN_ID, PELAMAR_ID, A.NAMA, LINK_FILE, ADA, WAJIB_ISI
				FROM DAFTAR_ENTRIAN_PELAMAR A
				WHERE 1 = 1
			";
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;

		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }


	function selectByParamsComboNoKTP($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT
					   ".$sField."
				FROM pelamar A
				WHERE 1=1";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement." GROUP BY ".$sField." ORDER BY ".$sField;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from);
    }


	function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT
					   A.PELAMAR_ID, A.NAMA, A.KTP_NO, EMAIL, KIRIM_LAMARAN, AKTIVASI, VERIFIKASI, LAMPIRAN_FOTO, JENIS_KELAMIN
				FROM pelamar A
				WHERE 1=1";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from);
    }


	function selectByParamsSimpleUjian($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT
					   A.PELAMAR_ID, A.NAMA, A.KTP_NO, EMAIL, KIRIM_LAMARAN, AKTIVASI, VERIFIKASI, B.LOWONGAN_ID, LAMPIRAN_FOTO, JENIS_KELAMIN,
                       C.UJIAN_ID
				FROM pelamar A
                LEFT JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID AND A.PERIODE_ID = B.PERIODE_ID_LAMAR
                LEFT JOIN UJIAN C ON B.LOWONGAN_ID = C.LOWONGAN_ID
                WHERE 1=1 ";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from);
    }

	function selectByParamsCV($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT PELAMAR_ID, NRP, KTP_NO, NIPP, A.NAMA, KK_NO, ALAMAT, TELEPON, CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki-laki' ELSE 'Perempuan' END JENIS_KELAMIN,
					   TEMPAT_LAHIR || ', ' || TO_CHAR(TANGGAL_LAHIR, 'DD-MM-YYYY') TTL, B.NAMA AGAMA_NAMA,
					   AMBIL_STATUS_NIKAH(STATUS_KAWIN) || ', ' || SUBSTR(C.KODE, 3,1) || ' Anak' STATUS_PERNIKAHAN,
					   GOLONGAN_DARAH, LAMPIRAN_FOTO, EMAIL, D.NAMA DOMISILI, NPWP, TANGGAL_NPWP, TINGGI || ' / ' || BERAT_BADAN TINGGIBB,  A.ALAMAT_KELURAHAN_ID, A.ALAMAT_KECAMATAN_ID,
					   A.ALAMAT_KOTA_ID, A.ALAMAT_PROVINSI_ID
				  FROM pelamar A
				LEFT JOIN AGAMA B ON A.AGAMA_ID = B.AGAMA_ID
				LEFT JOIN STATUS_KELUARGA C ON A.STATUS_KELUARGA_ID = C.STATUS_KELUARGA_ID
				LEFT JOIN KOTA D ON A.KOTA_ID = D.KOTA_ID
				WHERE 1 = 1
			";
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}

		$str .= $statement.$sOrder;

		//" ORDER BY A.NAMA ASC"
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from);
    }

    function getCountByParamsDaftarEntrian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM DAFTAR_ENTRIAN_PELAMAR A
				WHERE 1 = 1 ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }


    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT
				COUNT(A.PELAMAR_ID) ROWCOUNT
               FROM pelamar A
				LEFT JOIN AGAMA B ON A.AGAMA_ID = B.AGAMA_ID
				LEFT JOIN KOTA C ON A.KOTA_ID = C.KOTA_ID
                WHERE 1 = 1  ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }


    function getCountByParamsTahapan($paramsArray=array(), $statement="")
	{
		$str = "SELECT
				COUNT(1) ROWCOUNT
               FROM PELAMAR_TAHAPAN_GELOMBANG A
                WHERE 1 = 1  ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }

    function getDaftarEntrianTerakhir($paramsArray=array(), $statement="")
	{
		$str = "SELECT
				DAFTAR_ENTRIAN_TERAKHIR
               FROM daftar_entrian_terakhir A
                WHERE 1 = 1  ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("DAFTAR_ENTRIAN_TERAKHIR");
		else
			return "9";
    }


    function getPelamarId($paramsArray=array(), $statement="")
	{
		$str = "SELECT
				A.PELAMAR_ID
               FROM pelamar A
				INNER JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID
                WHERE 1 = 1  ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("PELAMAR_ID");
		else
			return "";
    }



    function getValidasiDokumen($paramsArray=array(), $statement="")
	{
		$str = "SELECT
				CASE WHEN VERIFIKASI_CV = 'S' AND
						  VERIFIKASI_KTP = 'S' AND
						  VERIFIKASI_FOTO = 'S' AND
						  VERIFIKASI_IJASAH = 'S' AND
						  VERIFIKASI_TRANSKRIP = 'S' AND
						  VERIFIKASI_SKCK = 'S' AND
						  VERIFIKASI_SURAT_LAMARAN = 'S' THEN 'S'
					 WHEN VERIFIKASI_CV IS NULL OR
						  VERIFIKASI_KTP IS NULL OR
						  VERIFIKASI_FOTO IS NULL OR
						  VERIFIKASI_IJASAH IS NULL OR
						  VERIFIKASI_TRANSKRIP IS NULL OR
						  VERIFIKASI_SKCK IS NULL OR
						  VERIFIKASI_SURAT_LAMARAN IS NULL THEN ''
						  ELSE 'T' END VERIFIKASI
				FROM pelamar A
                WHERE 1 = 1  ".$statement;

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("VERIFIKASI");
		else
			return 0;
    }

	function getUsia($tanggal)
	{
		$str = "SELECT AMBIL_MASA_KERJA(TO_DATE('".$tanggal."', 'DD-MM-YYYY')) ROWCOUNT FROM DUAL  ";
		//echo $str;
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }



    function getFieldById($field, $id)
	{
		$str = "SELECT
				".$field." ROWCOUNT
               FROM pelamar A
                WHERE 1 = 1 AND PELAMAR_ID = '".$id."' ";
		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return "";
    }


    function getUrut()
	{
		$str = "SELECT TO_CHAR(CURRENT_DATE, 'YYYYMM') || LPAD((COALESCE(MAX(TO_NUMBER(SUBSTR(NRP, 7, 5), 'FM99999')), 0) + 1), 5, '0') ROWCOUNT FROM pelamar WHERE SUBSTR(NRP, 1, 6) = TO_CHAR(CURRENT_DATE, 'YYYYMM') ";

		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }


    function getUrutImport()
	{
		$str = "SELECT TO_CHAR(CURRENT_DATE, 'YYMM') || LPAD((COALESCE(MAX(TO_NUMBER(SUBSTR(NRP, 5, 5), 'FM99999')), 0) + 1), 5, '0') ROWCOUNT FROM pelamar WHERE SUBSTR(NRP, 1, 4) = TO_CHAR(CURRENT_DATE, 'YYMM') ";

		$this->select($str);
		$this->query = $str;
		if($this->firstRow())
			return $this->getField("ROWCOUNT");
		else
			return 0;
    }

  }
?>