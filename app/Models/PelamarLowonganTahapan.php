<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganTahapan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganTahapan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{

		$str = "
				INSERT INTO pelamar_lowongan_tahapan
							(PELAMAR_ID, LOWONGAN_ID, LOWONGAN_TAHAPAN_ID, 
							 LOLOS, CREATED_BY, CREATED_DATE
							)
					 VALUES ('".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("LOWONGAN_TAHAPAN_ID")."',
					 		 '".$this->getField("LOLOS")."', '".$this->getField("CREATED_BY")."', CURRENT_DATE
							)
				
				"; 
		$this->id = $this->getField("PELAMAR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertDataAwal()
	{

		$str = "
				INSERT INTO pelamar_lowongan_tahapan
							(PELAMAR_ID, LOWONGAN_ID, LOWONGAN_TAHAPAN_ID, 
							 LOLOS, EMAIL, SMS, TANGGAL_HADIR, CREATED_BY, CREATED_DATE
							)
					 VALUES ('".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("LOWONGAN_TAHAPAN_ID")."',
					 		 '".$this->getField("LOLOS")."', 
							 (SELECT EMAIL FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' AND X.LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'),
							 (SELECT SMS FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' AND X.LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'),
							 (SELECT TANGGAL_HADIR FROM PELAMAR_LOWONGAN_SHORTLIST X WHERE X.PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' AND X.LOWONGAN_ID = '".$this->getField("LOWONGAN_ID")."'),
							 '".$this->getField("CREATED_BY")."', CURRENT_DATE
							)
				
				"; 
		$this->id = $this->getField("PELAMAR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateNilaiWawancara()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   WAWANCARA_NILAI1 = ".$this->getField("WAWANCARA_NILAI1").",
					   WAWANCARA_NILAI2 = ".$this->getField("WAWANCARA_NILAI2").",
					   WAWANCARA_NILAI3 = ".$this->getField("WAWANCARA_NILAI3").",
					   WAWANCARA_NILAI4 = ".$this->getField("WAWANCARA_NILAI4").",
					   WAWANCARA_NILAI5 = ".$this->getField("WAWANCARA_NILAI5").",
					   WAWANCARA_REKOM1 = ".$this->getField("WAWANCARA_REKOM1").",
					   WAWANCARA_REKOM2 = ".$this->getField("WAWANCARA_REKOM2").",
					   WAWANCARA_REKOM3 = ".$this->getField("WAWANCARA_REKOM3").",
					   WAWANCARA_REKOM4 = ".$this->getField("WAWANCARA_REKOM4").",
					   WAWANCARA_REKOM5 = ".$this->getField("WAWANCARA_REKOM5").",
					   WAWANCARA_RATA_NILAI = ".$this->getField("WAWANCARA_RATA_NILAI").",
					   WAWANCARA_RATA_REKOM = ".$this->getField("WAWANCARA_RATA_REKOM").",
					   UPDATED_DATE = CURRENT_DATE
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateNilaiPsikotes()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   PSIKOTES_NILAI = ".$this->getField("PSIKOTES_NILAI").",
					   PSIKOTES_REKOM = ".$this->getField("PSIKOTES_REKOM").",
					   UPDATED_DATE = CURRENT_DATE
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateNilaiKesehatan()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   KESEHATAN_KESIMPULAN = '".$this->getField("KESEHATAN_KESIMPULAN")."',
					   KESEHATAN_KETERANGAN = '".$this->getField("KESEHATAN_KETERANGAN")."',
					   KESEHATAN_SARAN = '".$this->getField("KESEHATAN_SARAN")."',
					   UPDATED_DATE = CURRENT_DATE
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateNilai()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   NILAI = '".$this->getField("NILAI")."',
					   UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = CURRENT_DATE
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateLolos()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   LOLOS = 1
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateTidakLolos()
	{
		$str = "
				UPDATE pelamar_lowongan_tahapan
				   SET 
					   LOLOS = 2
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 

		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateEmail()
	{
        $str = "UPDATE pelamar_lowongan_tahapan
				SET 
					TANGGAL_HADIR = ".$this->getField("TANGGAL_HADIR").",
					EMAIL = COALESCE(EMAIL, 0) + 1
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM pelamar_lowongan_tahapan
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteData()
	{
        $str = "DELETE FROM pelamar_lowongan_tahapan
                WHERE  
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND
                  LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_ID, LOWONGAN_ID, LOWONGAN_TAHAPAN_ID, NILAI, EMAIL, SMS, 
					   LOLOS, TANGGAL_HADIR, CREATED_BY, CREATED_DATE, UPDATED_BY, 
					   UPDATED_DATE, WAWANCARA_NILAI1, WAWANCARA_NILAI2, WAWANCARA_NILAI3, 
					   WAWANCARA_NILAI4, WAWANCARA_NILAI5, WAWANCARA_REKOM1, WAWANCARA_REKOM2, 
					   WAWANCARA_REKOM3, WAWANCARA_REKOM4, WAWANCARA_REKOM5, WAWANCARA_RATA_NILAI, 
					   WAWANCARA_RATA_REKOM, PSIKOTES_NILAI, PSIKOTES_REKOM, KESEHATAN_KESIMPULAN, 
					   KESEHATAN_KETERANGAN, KESEHATAN_SARAN
				  FROM pelamar_lowongan_tahapan A
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

    function selectByParamsInformasiEmail($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT A.PELAMAR_ID, A.LOWONGAN_ID, TANGGAL_HADIR, TO_CHAR(TANGGAL_HADIR, 'D') HARI, TO_CHAR(TANGGAL_HADIR, 'YYYY-MM-DD') TANGGAL, TO_CHAR(TANGGAL_HADIR, 'HH24:MI') WAKTU,
					   B.TANGGAL_KIRIM, initcap(C.NAMA) NAMA, D.NAMA AGENDA
				  FROM pelamar_lowongan_tahapan A
				  LEFT JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID AND A.LOWONGAN_ID = B.LOWONGAN_ID
				  LEFT JOIN PELAMAR C ON A.PELAMAR_ID = C.PELAMAR_ID
				  LEFT JOIN LOWONGAN_TAHAPAN D ON A.LOWONGAN_TAHAPAN_ID = D.LOWONGAN_TAHAPAN_ID
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
		
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM pelamar_lowongan_tahapan A
		        WHERE PELAMAR_ID IS NOT NULL ".$statement; 
		
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