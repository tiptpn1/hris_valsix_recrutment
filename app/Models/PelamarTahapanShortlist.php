<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarTahapanShortlist extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarTahapanShortlist()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{

		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_TAHAPAN_SHORTLIST_ID", $this->getSeqId("PELAMAR_TAHAPAN_SHORTLIST_ID","PELAMAR_TAHAPAN_SHORTLIST")); 	

		$str = "
				INSERT INTO PELAMAR_TAHAPAN_SHORTLIST(
				            PELAMAR_TAHAPAN_SHORTLIST_ID, LOWONGAN_KATEGORI_KRITERIA_ID, 
				            PELAMAR_ID, LOWONGAN_ID, 
				            CREATED_BY, CREATED_DATE, STATUS, LOWONGAN_KATEGORI_KRITERIA_PREV_ID)
				    VALUES ('".$this->getField("PELAMAR_TAHAPAN_SHORTLIST_ID")."', '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', 
				            '".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', 
				            '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").", '".$this->getField("STATUS")."', '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_PREV_ID")."')
				"; 
		$this->id = $this->getField("PELAMAR_TAHAPAN_SHORTLIST_ID");
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE PELAMAR_TAHAPAN_SHORTLIST
				   SET  LOWONGAN_KATEGORI_KRITERIA_ID 		= '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', 
				       	PELAMAR_ID 							= '".$this->getField("PELAMAR_ID")."', 
				       	LOWONGAN_ID 						= '".$this->getField("LOWONGAN_ID")."', 
				       	UPDATED_BY 					= '".$this->getField("UPDATED_BY")."', 
				       	UPDATED_DATE 					= ".$this->getField("UPDATED_DATE").", 
				       	STATUS 								= '".$this->getField("STATUS")."', 
				       	LOWONGAN_KATEGORI_KRITERIA_PREV_ID 	= '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_PREV_ID")."'
				 WHERE PELAMAR_TAHAPAN_SHORTLIST_ID			= '".$this->getField("PELAMAR_TAHAPAN_SHORTLIST_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
						
	function delete()
	{
        $str = "DELETE FROM PELAMAR_TAHAPAN_SHORTLIST
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND
                  LOWONGAN_KATEGORI_KRITERIA_ID = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
						
	function deleteAwal()
	{
        $str = "DELETE FROM PELAMAR_TAHAPAN_SHORTLIST
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 

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
				SELECT PELAMAR_TAHAPAN_SHORTLIST_ID, LOWONGAN_KATEGORI_KRITERIA_ID, 
				       PELAMAR_ID, LOWONGAN_ID, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE, STATUS,
				       CASE WHEN STATUS = '2' THEN 'Ya Bypass' WHEN STATUS = '1' THEN 'Ya' ELSE 'Tidak' END STATUS_DESC,
				       LOWONGAN_KATEGORI_KRITERIA_PREV_ID
				  FROM PELAMAR_TAHAPAN_SHORTLIST A
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
		$str = "SELECT COUNT(PELAMAR_ID) AS ROWCOUNT FROM PELAMAR_TAHAPAN_SHORTLIST A
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