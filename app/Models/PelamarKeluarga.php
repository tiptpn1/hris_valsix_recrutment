<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PELAMAR_KELUARGA.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarKeluarga extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarKeluarga()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_KELUARGA_ID", $this->getSeqId("PELAMAR_KELUARGA_ID","PELAMAR_KELUARGA"));

		$str = "
				INSERT INTO PELAMAR_KELUARGA (
				   PELAMAR_KELUARGA_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT,
				   STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID, CREATED_BY, CREATED_DATE, 
				   KESEHATAN_NO, KESEHATAN_TANGGAL, KESEHATAN_FASKES, KTP_NO
				   ) 
 			  	VALUES (
				  ".$this->getField("PELAMAR_KELUARGA_ID").",
				  '".$this->getField("PENDIDIKAN_ID")."',
				  '".$this->getField("PELAMAR_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  '".$this->getField("PEKERJAAN")."',
				  ".$this->getField("TANGGAL_WAFAT").",
				  ".$this->getField("STATUS_KAWIN").",
				  ".$this->getField("STATUS_TUNJANGAN").",
				  ".$this->getField("STATUS_TANGGUNG").",
				  '".$this->getField("HUBUNGAN_KELUARGA_ID")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				  '".$this->getField("KESEHATAN_NO")."',
				  ".$this->getField("KESEHATAN_TANGGAL").",
				  '".$this->getField("KESEHATAN_FASKES")."',
				  '".$this->getField("KTP_NO")."'
				)"; 
		$this->id = $this->getField("PELAMAR_KELUARGA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE PELAMAR_KELUARGA
				SET    
					   PENDIDIKAN_ID        = '".$this->getField("PENDIDIKAN_ID")."',
					   NAMA    				= '".$this->getField("NAMA")."',
					   JENIS_KELAMIN        = '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR			= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR		= ".$this->getField("TANGGAL_LAHIR").",
					   PEKERJAAN			= '".$this->getField("PEKERJAAN")."',
					   TANGGAL_WAFAT		= ".$this->getField("TANGGAL_WAFAT").",
					   STATUS_KAWIN			= ".$this->getField("STATUS_KAWIN").",
					   STATUS_TUNJANGAN		= ".$this->getField("STATUS_TUNJANGAN").",
					   STATUS_TANGGUNG		= ".$this->getField("STATUS_TANGGUNG").",
					   HUBUNGAN_KELUARGA_ID	= '".$this->getField("HUBUNGAN_KELUARGA_ID")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE").",
					   KESEHATAN_NO			= '".$this->getField("KESEHATAN_NO")."',
					   KESEHATAN_TANGGAL	= ".$this->getField("KESEHATAN_TANGGAL").",
					   KESEHATAN_FASKES		= '".$this->getField("KESEHATAN_FASKES")."',
					   KTP_NO				= '".$this->getField("KTP_NO")."'
				WHERE  PELAMAR_KELUARGA_ID  = '".$this->getField("PELAMAR_KELUARGA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PELAMAR_KELUARGA
                WHERE 
                  PELAMAR_KELUARGA_ID = ".$this->getField("PELAMAR_KELUARGA_ID")." AND 
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_KELUARGA_ID_GEN", $this->getSeqId("PELAMAR_KELUARGA_ID","PELAMAR_KELUARGA")); 		

		$str = "
				INSERT INTO PELAMAR_KELUARGA (
				   PELAMAR_KELUARGA_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT,
				   STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID, CREATED_BY, CREATED_DATE, 
				   KESEHATAN_NO, KESEHATAN_TANGGAL, KESEHATAN_FASKES, KTP_NO) 
				SELECT ".$this->getField("PELAMAR_KELUARGA_ID_GEN")." PELAMAR_KELUARGA_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT,
				   STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID, CREATED_BY, CREATED_DATE, 
				   KESEHATAN_NO, KESEHATAN_TANGGAL, KESEHATAN_FASKES, KTP_NO
				FROM pds_validasi.PELAMAR_KELUARGA WHERE PELAMAR_KELUARGA_ID = ".$this->getField("PELAMAR_KELUARGA_ID").""; 
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_KELUARGA_ID");
		
		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.PELAMAR_KELUARGA
					WHERE 
					  PELAMAR_KELUARGA_ID = ".$this->getField("PELAMAR_KELUARGA_ID").""; 		
			return $this->execQuery($str);
		}
    }
	
	function tolak()
	{
        $str = "DELETE FROM pds_validasi.PELAMAR_KELUARGA
                WHERE 
                  PELAMAR_KELUARGA_ID = ".$this->getField("PELAMAR_KELUARGA_ID").""; 
				  
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
				SELECT 
					PELAMAR_KELUARGA_ID, A.PENDIDIKAN_ID, PELAMAR_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
					TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, A.HUBUNGAN_KELUARGA_ID,
					B.NAMA PENDIDIKAN_NAMA, C.NAMA HUBUNGAN_KELUARGA_NAMA,
					AMBIL_STATUS_CHEKLIST(STATUS_KAWIN) STATUS_KAWIN_NAMA, AMBIL_STATUS_CHEKLIST(STATUS_TUNJANGAN) STATUS_TUNJANGAN_NAMA, 
					AMBIL_STATUS_CHEKLIST(STATUS_TANGGUNG) STATUS_TANGGUNG_NAMA, KESEHATAN_NO, KESEHATAN_TANGGAL,
					KESEHATAN_FASKES, KTP_NO
				FROM PELAMAR_KELUARGA A
				LEFT JOIN PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
				LEFT JOIN HUBUNGAN_KELUARGA C ON A.HUBUNGAN_KELUARGA_ID=C.HUBUNGAN_KELUARGA_ID
				WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_LAHIR DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsValidasi($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT * FROM
				(
				SELECT 'Validasi' STATUS, 
					PELAMAR_KELUARGA_ID, A.PENDIDIKAN_ID, PELAMAR_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
					TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, A.HUBUNGAN_KELUARGA_ID,
					B.NAMA PENDIDIKAN_NAMA, C.NAMA HUBUNGAN_KELUARGA_NAMA,
					AMBIL_STATUS_CHEKLIST(STATUS_KAWIN) STATUS_KAWIN_NAMA, AMBIL_STATUS_CHEKLIST(STATUS_TUNJANGAN) STATUS_TUNJANGAN_NAMA, 
					AMBIL_STATUS_CHEKLIST(STATUS_TANGGUNG) STATUS_TANGGUNG_NAMA, KESEHATAN_NO, KESEHATAN_TANGGAL,
					KESEHATAN_FASKES, KTP_NO
				FROM pds_validasi.PELAMAR_KELUARGA A
				LEFT JOIN PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
				LEFT JOIN HUBUNGAN_KELUARGA C ON A.HUBUNGAN_KELUARGA_ID=C.HUBUNGAN_KELUARGA_ID
				UNION
				SELECT 'Master' STATUS, 
					PELAMAR_KELUARGA_ID, A.PENDIDIKAN_ID, PELAMAR_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
					TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, A.HUBUNGAN_KELUARGA_ID,
					B.NAMA PENDIDIKAN_NAMA, C.NAMA HUBUNGAN_KELUARGA_NAMA,
					AMBIL_STATUS_CHEKLIST(STATUS_KAWIN) STATUS_KAWIN_NAMA, AMBIL_STATUS_CHEKLIST(STATUS_TUNJANGAN) STATUS_TUNJANGAN_NAMA, 
					AMBIL_STATUS_CHEKLIST(STATUS_TANGGUNG) STATUS_TANGGUNG_NAMA, KESEHATAN_NO, KESEHATAN_TANGGAL,
					KESEHATAN_FASKES, KTP_NO
				FROM PELAMAR_KELUARGA A
				LEFT JOIN PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
				LEFT JOIN HUBUNGAN_KELUARGA C ON A.HUBUNGAN_KELUARGA_ID=C.HUBUNGAN_KELUARGA_ID
				) A
				WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_LAHIR DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_KELUARGA_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR,
				TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID
				FROM PELAMAR_KELUARGA
				WHERE 1 = 1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PENDIDIKAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_KELUARGA_ID) AS ROWCOUNT FROM PELAMAR_KELUARGA
		        WHERE PELAMAR_KELUARGA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELAMAR_KELUARGA_ID) AS ROWCOUNT FROM PELAMAR_KELUARGA
		        WHERE PELAMAR_KELUARGA_ID IS NOT NULL ".$statement; 
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