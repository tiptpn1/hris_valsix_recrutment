<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel BLACKLIST.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Blacklist extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Blacklist()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BLACKLIST_ID", $this->getSeqId("BLACKLIST_ID","BLACKLIST"));

		$str = "
				INSERT INTO BLACKLIST (
				   BLACKLIST_ID, KTP_NO, TANGGAL, UPDATED_BY, UPDATED_DATE,
				   NAMA, TEMPAT_LAHIR, TANGGAL_LAHIR) 
 			  	VALUES (
				  ".$this->getField("BLACKLIST_ID").",
				  '".$this->getField("KTP_NO")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("UPDATED_BY")."',
				  ".$this->getField("UPDATED_DATE").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE BLACKLIST
				SET    
					   KTP_NO				= '".$this->getField("KTP_NO")."',
					   TANGGAL	 			= ".$this->getField("TANGGAL").",
					   NAMA	 				= '".$this->getField("NAMA")."',
					   TEMPAT_LAHIR	 		= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR	 	= ".$this->getField("TANGGAL_LAHIR").",
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  BLACKLIST_ID  		= '".$this->getField("BLACKLIST_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM BLACKLIST
                WHERE 
                  BLACKLIST_ID = ".$this->getField("BLACKLIST_ID").""; 
				  
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
					SELECT DISTINCT BLACKLIST_ID, A.KTP_NO, A.TANGGAL, COALESCE(NULLIF(A.NAMA, ''), B.NAMA) NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE, (A.TEMPAT_LAHIR) TEMPAT, A.TANGGAL_LAHIR,
					PERUSAHAAN, CABANG, COALESCE(NULLIF(A.UPDATED_BY, ''), A.CREATED_BY) USER_OPERATOR
					FROM BLACKLIST A 
					LEFT JOIN PELAMAR B ON B.KTP_NO = A.KTP_NO
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
					SELECT BLACKLIST_ID, A.KTP_NO, A.TANGGAL, B.NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
					FROM BLACKLIST A 
					LEFT JOIN PELAMAR B ON B.KTP_NO = A.KTP_NO
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
		$str = "SELECT COUNT(BLACKLIST_ID) AS ROWCOUNT FROM BLACKLIST A
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
		$str = "SELECT COUNT(BLACKLIST_ID) AS ROWCOUNT FROM BLACKLIST A
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