<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel ARCHIVE_PELAMAR.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class ArchivePelamar extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function ArchivePelamar()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ARCHIVE_PELAMAR_ID", $this->getSeqId("ARCHIVE_PELAMAR_ID","ARCHIVE_PELAMAR"));

		$str = "
				INSERT INTO ARCHIVE_PELAMAR(
			            ARCHIVE_PELAMAR_ID, PELAMAR_ID, TMT)
			    VALUES ('".$this->getField("ARCHIVE_PELAMAR_ID")."', '".$this->getField("PELAMAR_ID")."', ".$this->getField("TMT")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE ARCHIVE_PELAMAR
				SET    
					   TMT				= ".$this->getField("KTP_NO")."
				WHERE  ARCHIVE_PELAMAR_ID  		= '".$this->getField("ARCHIVE_PELAMAR_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM ARCHIVE_PELAMAR
                WHERE 
                  ARCHIVE_PELAMAR_ID = ".$this->getField("ARCHIVE_PELAMAR_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TANGGAL DESC")
	{
		$str = "
					SELECT ARCHIVE_PELAMAR_ID, A.PELAMAR_ID, TMT,
						   NRP, KTP_NO, B.NAMA, JENIS_KELAMIN, C.NAMA AGAMA, TEMPAT_LAHIR, TANGGAL_LAHIR, ambil_masa_kerja(TANGGAL_LAHIR, CURRENT_DATE) UMUR,
						    TINGGI, BERAT_BADAN, EMAIL, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_NIKAH
  					  FROM ARCHIVE_PELAMAR A
  				 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				 LEFT JOIN AGAMA C ON B.AGAMA_ID = C.AGAMA_ID
					 WHERE 1=1
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
					SELECT ARCHIVE_PELAMAR_ID, A.PELAMAR_ID, TMT,
						   NRP, KTP_NO, B.NAMA, JENIS_KELAMIN, C.NAMA AGAMA, TEMPAT_LAHIR, TANGGAL_LAHIR, ambil_masa_kerja(TANGGAL_LAHIR, CURRENT_DATE) UMUR, TINGGI, BERAT_BADAN, EMAIL, AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_NIKAH
  					  FROM ARCHIVE_PELAMAR A
  				 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				 LEFT JOIN AGAMA C ON B.AGAMA_ID = C.AGAMA_ID
					 WHERE 1=1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ARCHIVE_PELAMAR_ID) AS ROWCOUNT 
					FROM ARCHIVE_PELAMAR A
  				 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				 LEFT JOIN AGAMA C ON B.AGAMA_ID = C.AGAMA_ID
		        WHERE 1=1 ".$statement; 
		
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
		$str = "SELECT COUNT(ARCHIVE_PELAMAR_ID) AS ROWCOUNT 
					FROM ARCHIVE_PELAMAR A
  				 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
				 LEFT JOIN AGAMA C ON B.AGAMA_ID = C.AGAMA_ID
		        WHERE 1=1 ".$statement; 
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