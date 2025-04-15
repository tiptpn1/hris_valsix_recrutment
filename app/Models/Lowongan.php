<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class Lowongan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Lowongan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_ID", $this->getSeqId("LOWONGAN_ID","LOWONGAN")); 

		$str = "
				INSERT INTO LOWONGAN(
						LOWONGAN_ID, KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, JABATAN_ID, 
						JUMLAH, PENEMPATAN, PERSYARATAN, CREATED_BY, 
						CREATED_DATE, DOKUMEN, DOKUMEN_WAJIB, 
						MANUAL, KETERANGAN, CABANG_ID, 
						PERMINTAAN_ID, PROJECT_ID, PERMINTAAN_KEBUTUHAN_ID,
						MAKSIMAL_PELAMAR, ALAMAT_KIRIM, PERIODE_ID, STATUS_UNDANGAN)
				VALUES ('".$this->getField("LOWONGAN_ID")."', '".$this->getField("KODE")."', current_timestamp, ".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", '".$this->getField("JABATAN_ID")."',
						'".$this->getField("JUMLAH")."', '".$this->getField("PENEMPATAN")."', '".$this->getField("PERSYARATAN")."', '".$this->getField("CREATED_BY")."',
						".$this->getField("CREATED_DATE").", '".$this->getField("DOKUMEN")."', '".$this->getField("DOKUMEN_WAJIB")."', '".$this->getField("MANUAL")."', '".$this->getField("KETERANGAN")."', '".$this->CABANG_ID."', ".$this->getField("PERMINTAAN_ID").", ".$this->getField("PROJECT_ID").", ".$this->getField("PERMINTAAN_KEBUTUHAN_ID").",
						'".$this->getField("MAKSIMAL_PELAMAR")."', '".$this->getField("ALAMAT_KIRIM")."', '".$this->getField("PERIODE_ID")."', '".$this->getField("STATUS_UNDANGAN")."')
				"; 
		$this->query = $str;
		// echo $str;exit;
		$this->id = $this->getField("LOWONGAN_ID");
		return $this->execQuery($str);
    }

	function insertDataUndangan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_ID", $this->getSeqId("LOWONGAN_ID","LOWONGAN")); 

		$str = "
				INSERT INTO LOWONGAN(
						LOWONGAN_ID, KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, JABATAN_ID, 
						JUMLAH, PENEMPATAN, PERSYARATAN, CREATED_BY, 
						CREATED_DATE, DOKUMEN, DOKUMEN_WAJIB, STATUS, UNDANGAN, KETERANGAN, CABANG_ID)
				VALUES ('".$this->getField("LOWONGAN_ID")."', '".$this->getField("KODE")."', ".$this->getField("TANGGAL").", ".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", '".$this->getField("JABATAN_ID")."',
						'".$this->getField("JUMLAH")."', '".$this->getField("PENEMPATAN")."', '".$this->getField("PERSYARATAN")."', '".$this->getField("CREATED_BY")."',
						".$this->getField("CREATED_DATE").", '".$this->getField("DOKUMEN")."', '".$this->getField("DOKUMEN_WAJIB")."', 0, 'Y', '".$this->getField("KETERANGAN")."', ".$this->CABANG_ID.")
				"; 
		$this->query = $str;
		$this->id = $this->getField("LOWONGAN_ID");
		// echo $str;
		return $this->execQuery($str);
    }
		
		
    function publish()
	{
		$str = "
				UPDATE LOWONGAN
				   SET PUBLISH_BY = '".$this->getField("PUBLISH_BY")."',
					   PUBLISH = '1',
					   PUBLISH_DATE = CURRENT_DATE
				WHERE  LOWONGAN_ID     = '".$this->getField("LOWONGAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function unpublish()
	{
		$str = "
				UPDATE LOWONGAN
				   SET PUBLISH_BY = '".$this->getField("PUBLISH_BY")."',
					   PUBLISH = '0',
					   PUBLISH_DATE = NULL
				WHERE  LOWONGAN_ID     = '".$this->getField("LOWONGAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }


	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE LOWONGAN SET 
					KODE 				= '".$this->getField("KODE")."',
					JABATAN_ID 			= '".$this->getField("JABATAN_ID")."',
					TANGGAL_AWAL 		= ".$this->getField("TANGGAL_AWAL").",
					TANGGAL_AKHIR 		= ".$this->getField("TANGGAL_AKHIR").", 
					JUMLAH 				= '".$this->getField("JUMLAH")."', 
					PENEMPATAN 			= '".$this->getField("PENEMPATAN")."', 
					PERSYARATAN 		= '".$this->getField("PERSYARATAN")."', 
					DOKUMEN 			= '".$this->getField("DOKUMEN")."', 
					DOKUMEN_WAJIB 		= '".$this->getField("DOKUMEN_WAJIB")."', 
					UPDATED_BY 	= '".$this->getField("UPDATED_BY")."', 
					UPDATED_DATE 	= ".$this->getField("UPDATED_DATE").",
					MANUAL 				= '".$this->getField("MANUAL")."',
					KETERANGAN			= '".$this->getField("KETERANGAN")."',
					CABANG_ID		= '".$this->CABANG_ID."',
					MAKSIMAL_PELAMAR	= '".$this->getField("MAKSIMAL_PELAMAR")."',
					ALAMAT_KIRIM 		= '".$this->getField("ALAMAT_KIRIM")."',
					PERIODE_ID		    = '".$this->getField("PERIODE_ID")."',
					STATUS_UNDANGAN		= '".$this->getField("STATUS_UNDANGAN")."'
			 	WHERE LOWONGAN_ID		= '".$this->getField("LOWONGAN_ID")."'
				"; 
				
				$this->query = $str;
				
		return $this->execQuery($str);
    }

	function callProsesCopyLowongan()
	{
		$str = "
				SELECT PROSES_COPY_LOWONGAN(".$this->getField("LOWONGAN_ID").")
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function update_file()
	{
		$str = "UPDATE LOWONGAN SET
				  LINK_FILE = '".$this->getField("LINK_FILE")."'
				WHERE LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateSubscribe()
	{
		$str = "UPDATE LOWONGAN SET
				  SUBSCRIBE = COALESCE(SUBSCRIBE, 0) + 1
				WHERE LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
				"; 
				$this->query = $str;
				//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function update_file_surat()
	{
		$str = "UPDATE LOWONGAN SET
				  TEMPLATE_SURAT_LAMARAN = '".$this->getField("TEMPLATE_SURAT_LAMARAN")."'
				WHERE LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateFormatDynamis()
	{
		$str = "
				UPDATE ".$this->getField("TABLE")."
				SET
					   ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE ".$this->getField("FIELD_ID")." = '".$this->getField("FIELD_VALUE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE LOWONGAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")."
				"; 
				$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "
				DELETE FROM LOWONGAN
                WHERE 
                  LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'
			"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
					   A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Internal' ELSE 'Eksternal' END STATUS_UNDANGAN_KETERANGAN, A.CABANG_ID, STATUS_SELESAI,
					   CASE WHEN (CASE WHEN TANGGAL_AKHIR < CURRENT_DATE THEN 1 ELSE 0 END ) = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_SELESAI_KETERANGAN, 
					   MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM, A.TEMPLATE_SURAT_LAMARAN,
					   POSTING_SELESAI, POSTING_KONTRAK, PERIODE_ID,
					   A.PUBLISH_BY, A.PUBLISH_DATE
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsVerifikasiData($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
					   A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Internal' ELSE 'Eksternal' END STATUS_UNDANGAN_KETERANGAN, A.CABANG_ID, STATUS_SELESAI,
					   CASE WHEN (CASE WHEN TANGGAL_AKHIR < CURRENT_DATE THEN 1 ELSE 0 END ) = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_SELESAI_KETERANGAN, 
					   MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM, A.TEMPLATE_SURAT_LAMARAN,
					   POSTING_SELESAI, POSTING_KONTRAK, PERIODE_ID,
					   A.PUBLISH_BY, A.PUBLISH_DATE, COALESCE(C.JUMLAH_PELAMAR, 0) JUMLAH_PELAMAR
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
                  LEFT JOIN (
                        SELECT LOWONGAN_ID, COUNT(1) JUMLAH_PELAMAR FROM PELAMAR_LOWONGAN
                        GROUP BY LOWONGAN_ID
                        ) C ON A.LOWONGAN_ID = C.LOWONGAN_ID
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsWawancara($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
					   A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Internal' ELSE 'Eksternal' END STATUS_UNDANGAN_KETERANGAN, A.CABANG_ID, STATUS_SELESAI,
					   CASE WHEN (CASE WHEN TANGGAL_AKHIR < CURRENT_DATE THEN 1 ELSE 0 END ) = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_SELESAI_KETERANGAN, 
					   MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM, A.TEMPLATE_SURAT_LAMARAN,
					   POSTING_SELESAI, POSTING_KONTRAK, PERIODE_ID,
					   A.PUBLISH_BY, A.PUBLISH_DATE, COALESCE(C.JUMLAH_PELAMAR, 0) JUMLAH_PELAMAR
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
                  LEFT JOIN (
                        SELECT LOWONGAN_ID, COUNT(1) JUMLAH_PELAMAR FROM PELAMAR_LOWONGAN_KRITERIA
						WHERE KODE_KRITERIA = 'WAWANCARA'
                        GROUP BY LOWONGAN_ID
                        ) C ON A.LOWONGAN_ID = C.LOWONGAN_ID
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSubscribe($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
					   A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_UNDANGAN_KETERANGAN, A.CABANG_ID, STATUS_SELESAI,
					   CASE WHEN (CASE WHEN TANGGAL_AKHIR < CURRENT_DATE THEN 1 ELSE 0 END ) = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_SELESAI_KETERANGAN, 
					   MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM, A.TEMPLATE_SURAT_LAMARAN,
					   POSTING_SELESAI, POSTING_KONTRAK, COALESCE(A.SUBSCRIBE, 0) SUBSCRIBE, COALESCE(C.JUMLAH_SUBSCRIBE, 0) JUMLAH_SUBSCRIBE
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
				  LEFT JOIN PELAMAR_SUBSCRIBE_TOTAL C ON B.BIDANG_ID = C.BIDANG_ID
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoringWeb($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$str = "SELECT A.LOWONGAN_ID, A.KODE, A.NAMA, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, REGIONAL, AREA,
                       JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
                       A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
                       A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
                       A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_UNDANGAN_KETERANGAN, A.CABANG_ID, STATUS_SELESAI,
                       CASE WHEN (CASE WHEN TANGGAL_AKHIR < CURRENT_DATE THEN 1 ELSE 0 END ) = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_SELESAI_KETERANGAN, MAKSIMAL_PELAMAR,
                       COALESCE(C.JUMLAH_PELAMAR, 0) JUMLAH_PELAMAR, A.ALAMAT_KIRIM, D.NAMA CABANG, D.LOGO
                  FROM LOWONGAN A
                  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
                  LEFT JOIN LOWONGAN_PELAMAR_TOTAL C ON A.LOWONGAN_ID = C.LOWONGAN_ID
                  LEFT JOIN CABANG D ON A.CABANG_ID = D.CABANG_ID
                 WHERE 1=1 AND LOWER(JENIS_LOWONGAN) = 'eksternal' AND CURRENT_DATE BETWEEN A.TANGGAL_AWAL AND A.TANGGAL_AKHIR "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
		
	
    function getCountByParamsMonitoringWeb($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
                  FROM LOWONGAN A
                  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
                  LEFT JOIN LOWONGAN_PELAMAR_TOTAL C ON A.LOWONGAN_ID = C.LOWONGAN_ID
                  LEFT JOIN CABANG D ON A.CABANG_ID = D.CABANG_ID
                 WHERE 1=1 AND LOWER(JENIS_LOWONGAN) = 'eksternal' AND CURRENT_DATE BETWEEN A.TANGGAL_AWAL AND A.TANGGAL_AKHIR  ".$statement; 
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


    function selectByParamsUndangan($pelamarId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, A.TANGGAL, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   A.PUBLISH, CASE WHEN A.STATUS = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_KETERANGAN, MANUAL, A.KETERANGAN,
					   A.STATUS_UNDANGAN,  CASE WHEN A.STATUS_UNDANGAN = 1 THEN 'Ya' ELSE 'Tidak' END STATUS_UNDANGAN_KETERANGAN,
					   (SELECT COUNT(1) FROM PELAMAR_LOWONGAN X WHERE A.LOWONGAN_ID = X.LOWONGAN_ID) JUMLAH_UNDANGAN,
					   (SELECT COUNT(1) FROM PELAMAR_LOWONGAN X WHERE A.LOWONGAN_ID = X.LOWONGAN_ID AND X.TANGGAL_KIRIM IS NOT NULL) JUMLAH_PELAMAR,
					   C.PELAMAR_ID, A.CABANG_ID, MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID			
				  LEFT JOIN PELAMAR_LOWONGAN C ON A.LOWONGAN_ID = C.LOWONGAN_ID AND C.PELAMAR_ID = ".$pelamarId."		  
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPelamar($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   (SELECT COUNT(1) FROM PELAMAR_LOWONGAN X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID AND TANGGAL_KIRIM IS NOT NULL) JUMLAH_PELAMAR,
					   (SELECT COUNT(1) FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID) JUMLAH_SHORTLIST,
					   A.CABANG_ID, MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
		
		
    function selectByParamsPelamarTahapan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT A.LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, PENEMPATAN, PERSYARATAN, DOKUMEN_WAJIB, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, B.NAMA JABATAN, A.DOKUMEN,
					   COALESCE(C.JUMLAH_PELAMAR, 0) JUMLAH_PELAMAR,
					   COALESCE(D.JUMLAH_SHORTLIST, 0) JUMLAH_SHORTLIST,
					   COALESCE(E.JUMLAH_VERIFIKASI, 0) JUMLAH_VERIFIKASI,
					   A.CABANG_ID, MAKSIMAL_PELAMAR
				  FROM LOWONGAN A
				  LEFT JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
                  LEFT JOIN LOWONGAN_PELAMAR_TOTAL C ON A.LOWONGAN_ID = C.LOWONGAN_ID
                  LEFT JOIN LOWONGAN_PELAMAR_SHORLIST D ON A.LOWONGAN_ID = D.LOWONGAN_ID
                  LEFT JOIN LOWONGAN_PELAMAR_VERIFIKASI E ON A.LOWONGAN_ID = E.LOWONGAN_ID
				 WHERE 1=1  ".$add_cabang; ; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
		
		
	function selectByParamsInformasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}
		$str = "SELECT LOWONGAN_ID, A.KODE, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, A.JABATAN_ID, 
					   JUMLAH, LINK_FILE, REPLACE(PENEMPATAN, '($$)', ',') PENEMPATAN, PERSYARATAN, A.CREATED_BY, 
					   A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, A.NAMA, A.DOKUMEN, MAKSIMAL_PELAMAR, A.ALAMAT_KIRIM,
					   TEMPLATE_SURAT_LAMARAN, A.PUBLISH, A.REGIONAL, A.AREA
				  FROM LOWONGAN A
				 WHERE 1=1 ".$add_cabang; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
			
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectByParamsComboPersyaratan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT 
					   ".$sField."
				FROM PELAMAR_PERSYARATAN A
				WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY ".$sField." ORDER BY ".$sField;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsComboPenempatan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT 
					   ".$sField."
				FROM PELAMAR_PENEMPATAN A
				WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY ".$sField." ORDER BY ".$sField;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsComboDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sField="")
	{
		$str = "SELECT 
					   ".$sField."
				FROM PELAMAR_DOKUMEN A
				WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY ".$sField." ORDER BY ".$sField;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}

		$str = "SELECT COUNT(1) AS ROWCOUNT FROM LOWONGAN A WHERE 1=1 ".$add_cabang.$statement; 
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
	
    
    function getJadwalBerikutnya($lowonganId, $tahapanId)
	{
		$str = "SELECT AMBIL_JADWAL_BERIKUTNYA('".$lowonganId."', '".$tahapanId."') TAHAP FROM DUAL "; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("TAHAP"); 
		else 
			return ""; 
    }
	
    function getId($paramsArray=array(), $statement="")
	{
		$str = "SELECT LOWONGAN_ID FROM LOWONGAN A WHERE 1=1 ".$statement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("LOWONGAN_ID"); 
		else 
			return 0; 
    }

    
    function getCountByParamsSubscribe($paramsArray=array(), $statement="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM LOWONGAN A WHERE 1=1 ".$add_cabang.$statement; 
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