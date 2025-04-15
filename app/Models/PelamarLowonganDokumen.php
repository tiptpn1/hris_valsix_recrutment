<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PELAMAR_LOWONGAN_DOKUMEN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganDokumen extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganDokumen()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_LOWONGAN_DOKUMEN_ID", $this->getSeqId("PELAMAR_LOWONGAN_DOKUMEN_ID","PELAMAR_LOWONGAN_DOKUMEN"));

		$str = "
					INSERT INTO PELAMAR_LOWONGAN_DOKUMEN (
					   PELAMAR_LOWONGAN_DOKUMEN_ID, LOWONGAN_ID, PELAMAR_ID, TANGGAL, LOWONGAN_DOKUMEN_ID, LINK_FILE)
 			  	VALUES (
				  ".$this->getField("PELAMAR_LOWONGAN_DOKUMEN_ID").",
				  '".$this->getField("LOWONGAN_ID")."',
				  '".$this->getField("PELAMAR_ID")."',
				  CURRENT_DATE,
				  ".$this->getField("LOWONGAN_DOKUMEN_ID").",
				  '".$this->getField("LINK_FILE")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE PELAMAR_LOWONGAN_DOKUMEN
				SET    
					   PELAMAR_LOWONGAN_ID          = '".$this->getField("PELAMAR_LOWONGAN_ID")."',
					   LOWONGAN_DOKUMEN_ID= ".$this->getField("LOWONGAN_DOKUMEN_ID")."
				WHERE  PELAMAR_LOWONGAN_DOKUMEN_ID     = '".$this->getField("PELAMAR_LOWONGAN_DOKUMEN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PELAMAR_LOWONGAN_DOKUMEN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PELAMAR_LOWONGAN_DOKUMEN_ID = ".$this->getField("PELAMAR_LOWONGAN_DOKUMEN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_DOKUMEN
                WHERE 
                  PELAMAR_LOWONGAN_DOKUMEN_ID = ".$this->getField("PELAMAR_LOWONGAN_DOKUMEN_ID").""; 
				  
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
				SELECT   PELAMAR_LOWONGAN_DOKUMEN_ID, PELAMAR_LOWONGAN_ID, TANGGAL, LOWONGAN_DOKUMEN_ID, LINK_FILE
 	 	 			FROM PELAMAR_LOWONGAN_DOKUMEN A 
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

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
		
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_DOKUMEN_ID) AS ROWCOUNT FROM PELAMAR_LOWONGAN_DOKUMEN A
		        WHERE PELAMAR_LOWONGAN_DOKUMEN_ID IS NOT NULL ".$statement; 
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