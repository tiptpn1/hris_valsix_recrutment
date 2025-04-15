<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganDiterima extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganDiterima()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{

		$str = "
				INSERT INTO PELAMAR_LOWONGAN_DITERIMA
							(PELAMAR_ID, LOWONGAN_ID, 
							 CREATED_BY, CREATED_DATE
							)
					 VALUES ('".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."',
					 		 '".$this->getField("CREATED_BY")."', CURRENT_DATE
							)
				
				"; 
		$this->id = $this->getField("PELAMAR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }



	function kalkulasiKelulusan()
	{
        $str = "SELECT proses_kelulusan('".$this->getField("LOWONGAN_ID")."') "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function updateEmail()
	{
        $str = "UPDATE PELAMAR_LOWONGAN_DITERIMA
				SET 
					TANGGAL_HADIR = ".$this->getField("TANGGAL_HADIR").",
					EMAIL = COALESCE(EMAIL, 0) + 1
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function updateHadir()
	{
        $str = "UPDATE PELAMAR_LOWONGAN_DITERIMA
				SET 
					HADIR = 1
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function updateBeritaAcara()
	{
        $str = "UPDATE PELAMAR_LOWONGAN_DITERIMA
				SET 
					NO_BERITA_ACARA 		= '".$this->getField("NO_BERITA_ACARA")."',
					DOKUMEN_BERITA_ACARA 	= '".$this->getField("DOKUMEN_BERITA_ACARA")."'
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function updateKelulusan()
	{
        $str = "UPDATE PELAMAR_LOWONGAN_DITERIMA
				SET 
					DITERIMA 		= '".$this->getField("DITERIMA")."'
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		
				
	function delete()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_DITERIMA
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
					   UPDATED_BY, UPDATED_DATE, NO_BERITA_ACARA, DOKUMEN_BERITA_ACARA
				  FROM PELAMAR_LOWONGAN_DITERIMA A
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
					   B.TANGGAL_KIRIM, initcap(C.NAMA) NAMA
				  FROM PELAMAR_LOWONGAN_DITERIMA A
				  LEFT JOIN PELAMAR_LOWONGAN B ON A.PELAMAR_ID = B.PELAMAR_ID AND A.LOWONGAN_ID = B.LOWONGAN_ID
				  LEFT JOIN PELAMAR C ON A.PELAMAR_ID = C.PELAMAR_ID
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
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM PELAMAR_LOWONGAN_DITERIMA A
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