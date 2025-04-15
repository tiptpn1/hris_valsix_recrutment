<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PERIODE.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Periode extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Periode()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERIODE_ID", $this->getSeqId("PERIODE_ID","PERIODE")); 		

		$str = "
				INSERT INTO PERIODE (
				   PERIODE_ID, NAMA, KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, CREATED_BY, CREATED_DATE)  
 			  	VALUES (
				  ".$this->getField("PERIODE_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PERIODE");
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE PERIODE
				SET    
					   NAMA           		= '".$this->getField("NAMA")."',
					   KETERANGAN    		= '".$this->getField("KETERANGAN")."',
					   TANGGAL_AWAL			= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR		= ".$this->getField("TANGGAL_AKHIR").",
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  PERIODE_ID     	= '".$this->getField("PERIODE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PERIODE
                WHERE 
                  PERIODE_ID = '".$this->getField("PERIODE_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function aktif()
	{
		
        $str = "UPDATE PERIODE
				SET    
					   STATUS_AKTIF         = 'T',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= current_timestamp "; 
				  
		$this->execQuery($str);	  
        $str = "UPDATE PERIODE
				SET    
					   STATUS_AKTIF         = 'Y',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= current_timestamp
				WHERE  PERIODE_ID     	= '".$this->getField("PERIODE_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function nonaktif()
	{
        $str = "UPDATE PERIODE
				SET    
					   STATUS_AKTIF         = 'T',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= current_timestamp
				WHERE  PERIODE_ID     	= '".$this->getField("PERIODE_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT PERIODE_ID, NAMA, KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, STATUS_AKTIF
				FROM PERIODE A
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
		$str = "SELECT COUNT(PERIODE_ID) AS ROWCOUNT FROM PERIODE A
		        WHERE PERIODE_ID IS NOT NULL ".$statement; 
		
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