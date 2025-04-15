<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel LOWONGAN_TAHAPAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganTahapan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganTahapan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_TAHAPAN_ID", $this->getSeqId("LOWONGAN_TAHAPAN_ID","LOWONGAN_TAHAPAN"));

		$str = "
					INSERT INTO LOWONGAN_TAHAPAN (
					   LOWONGAN_TAHAPAN_ID, LOWONGAN_ID, NAMA, KETERANGAN, URUT, TANGGAL_TAHAPAN, TEMPAT_TAHAPAN, TAHAPAN_TES_ID)
 			  	VALUES (
				  ".$this->getField("LOWONGAN_TAHAPAN_ID").",
				  '".$this->getField("LOWONGAN_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("URUT")."',
				  ".$this->getField("TANGGAL_TAHAPAN").",
				  '".$this->getField("TEMPAT_TAHAPAN")."',
				  '".$this->getField("TAHAPAN_TES_ID")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_TAHAPAN
				SET    
					   NAMA = '".$this->getField("NAMA")."',
					   KETERANGAN = '".$this->getField("KETERANGAN")."',
					   URUT = '".$this->getField("URUT")."',
					   TANGGAL_TAHAPAN = ".$this->getField("TANGGAL_TAHAPAN").",
					   TEMPAT_TAHAPAN = '".$this->getField("TEMPAT_TAHAPAN")."',
					   TAHAPAN_TES_ID = '".$this->getField("TAHAPAN_TES_ID")."'
				WHERE  LOWONGAN_TAHAPAN_ID     = '".$this->getField("LOWONGAN_TAHAPAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		$str = "UPDATE LOWONGAN_TAHAPAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE LOWONGAN_TAHAPAN_ID = ".$this->getField("LOWONGAN_TAHAPAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM LOWONGAN_TAHAPAN
                WHERE 
                  LOWONGAN_TAHAPAN_ID = '".$this->getField("LOWONGAN_TAHAPAN_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY URUT ASC")
	{
		$str = "
				SELECT   LOWONGAN_TAHAPAN_ID, LOWONGAN_ID, NAMA, KETERANGAN, URUT, (SELECT MAX(URUT) FROM LOWONGAN_TAHAPAN X WHERE X.LOWONGAN_ID = A.LOWONGAN_ID) URUT_AKHIR,
						 TANGGAL_TAHAPAN, TEMPAT_TAHAPAN, TAHAPAN_TES_ID
 	 	 			FROM LOWONGAN_TAHAPAN A 
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
		$str = "SELECT COUNT(LOWONGAN_TAHAPAN_ID) AS ROWCOUNT FROM LOWONGAN_TAHAPAN A
		        WHERE LOWONGAN_TAHAPAN_ID IS NOT NULL ".$statement; 
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