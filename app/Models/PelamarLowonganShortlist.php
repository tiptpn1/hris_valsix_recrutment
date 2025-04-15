<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganShortlist extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganShortlist()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{

		$str = "
				INSERT INTO pelamar_lowongan_shortlist
							(PELAMAR_ID, LOWONGAN_ID, GELOMBANG_ID,
							 CREATED_BY, CREATED_DATE
							)
					 VALUES ('".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', '".$this->getField("GELOMBANG_ID")."',
					 		 '".$this->getField("CREATED_BY")."', CURRENT_DATE
							)
				
				"; 
		$this->id = $this->getField("PELAMAR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function updateEmail()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					EMAIL = 1
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateEmailPelamar()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					EMAIL = '".$this->getField("EMAIL")."',
					EMAIL_TANGGAL = current_timestamp
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function updateProsesEmailPelamar()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					EMAIL = '2'
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND
				  COALESCE(EMAIL, 0) IN (0,2,3) "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }


	function updateProsesEmailPelamarById()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					EMAIL = '2',
					GELOMBANG_ID = '".$this->getField("GELOMBANG_ID")."'
                WHERE 
                  GELOMBANG_PERIODE_ID = '".$this->getField("GELOMBANG_PERIODE_ID")."' AND
                  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."'  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }



	function updateProsesEmailPelamarByGelombangId()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					EMAIL = '2'
                WHERE 
                  GELOMBANG_ID = '".$this->getField("GELOMBANG_ID")."'  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }


	function updateHadir()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					HADIR = 1,
					TANGGAL_HADIR = current_timestamp
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function updateTidakHadir()
	{
        $str = "UPDATE pelamar_lowongan_shortlist
				SET 
					HADIR = 2,
					ALASAN = '".$this->getField("ALASAN")."' 
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
					
	function delete()
	{
        $str = "DELETE FROM pelamar_lowongan_shortlist
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_ID, LOWONGAN_ID, CREATED_BY, CREATED_DATE,
					   UPDATED_BY, UPDATED_DATE
				  FROM pelamar_lowongan_shortlist A
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
	
	
    function selectByParamsEmail($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID ASC ")
	{
		$str = "
				SELECT A.PELAMAR_ID, B.EMAIL, B.NAMA, B.NRP, A.GELOMBANG_ID, A.LOWONGAN_ID FROM pelamar_lowongan_shortlist A 
				INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID AND COALESCE(A.EMAIL, 0) IN (0, 2, 3)
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



	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID ASC ")
	{
		$str = "
				SELECT 
				PELAMAR_ID, LOWONGAN_ID, EMAIL, 
				   SMS, HADIR, TANGGAL_HADIR, 
				   CREATED_BY, CREATED_DATE, UPDATED_BY, 
				   UPDATED_DATE, ALASAN, GELOMBANG_ID, 
				   GELOMBANG_KE, PELAMAR, PELAMAR_NRP, 
				   GELOMBANG_TANGGAL, GELOMBANG_JAM, GELOMBANG_LOKASI, 
				   PELAMAR_FOTO, EMAIL_TANGGAL, GELOMBANG_PERIODE_ID
				FROM pelamar_lowongan_shortlist A
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


	
    function selectByParamsMonitoringSesi($reqSesiId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID ASC ")
	{
		$str = "
				SELECT 
				A.PELAMAR_ID, A.LOWONGAN_ID, EMAIL, 
				   SMS, HADIR, TANGGAL_HADIR, ALASAN, GELOMBANG_ID, 
				   GELOMBANG_KE, PELAMAR, PELAMAR_NRP, 
				   GELOMBANG_TANGGAL, GELOMBANG_JAM, GELOMBANG_LOKASI, 
				   PELAMAR_FOTO, EMAIL_TANGGAL, GELOMBANG_PERIODE_ID
				FROM pelamar_lowongan_shortlist A
				INNER JOIN  UJIAN_PEGAWAI_DAFTAR B ON A.PELAMAR_ID = B.PEGAWAI_ID AND A.LOWONGAN_ID = B.LOWONGAN_ID AND B.UJIAN_SESI_ID = '$reqSesiId'
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
				  FROM pelamar_lowongan_shortlist A
				  LEFT JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID AND A.LOWONGAN_ID = B.LOWONGAN_ID
				  LEFT JOIN PELAMAR C ON A.PELAMAR_ID = C.PELAMAR_ID
				  LEFT JOIN LOWONGAN_TAHAPAN D ON A.LOWONGAN_ID = D.LOWONGAN_ID AND D.URUT = 1
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
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM pelamar_lowongan_shortlist A
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