<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel TAHAPAN_TES_NILAI.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class TahapanTesNilai extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function TahapanTesNilai()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TAHAPAN_TES_NILAI_ID", $this->getSeqId("TAHAPAN_TES_NILAI_ID","TAHAPAN_TES_NILAI"));

		$str = "
				INSERT INTO TAHAPAN_TES_NILAI (
				   TAHAPAN_TES_NILAI_ID, TAHAPAN_TES_ID, NAMA, UPDATED_BY, UPDATED_DATE) 
 			  	VALUES (
				  ".$this->getField("TAHAPAN_TES_NILAI_ID").",
				  '".$this->getField("TAHAPAN_TES_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE TAHAPAN_TES_NILAI
				SET    
					   NAMA	 				= '".$this->getField("NAMA")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  TAHAPAN_TES_NILAI_ID  		= '".$this->getField("TAHAPAN_TES_NILAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM TAHAPAN_TES_NILAI
                WHERE 
                  TAHAPAN_TES_NILAI_ID = ".$this->getField("TAHAPAN_TES_NILAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TAHAPAN_TES_NILAI_ID ASC")
	{
		$str = "
					SELECT TAHAPAN_TES_NILAI_ID, A.TAHAPAN_TES_ID, A.NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
					FROM TAHAPAN_TES_NILAI A
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

    function selectByParamsNilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY B.PENILAI_KE, A.TAHAPAN_TES_NILAI_ID ASC ")
	{
		$str = "
					SELECT A.TAHAPAN_TES_NILAI_ID, B.PENILAI_KE, A.NAMA, B.NILAI 
					FROM TAHAPAN_TES_NILAI A
					INNER JOIN PELAMAR_LOWONGAN_TAHAPAN_NILAI B ON A.TAHAPAN_TES_NILAI_ID = B.TAHAPAN_TES_NILAI_ID
					WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
        
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
					SELECT TAHAPAN_TES_NILAI_ID, A.TAHAPAN_TES_ID, A.NAMA, B.NAMA, A.CREATED_BY,
					A.CREATED_DATE, A.UPDATED_BY, A.UPDATED_DATE
					FROM TAHAPAN_TES_NILAI A 
					LEFT JOIN PELAMAR B ON B.TAHAPAN_TES_ID = A.TAHAPAN_TES_ID
					WHERE 1=1
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TAHAPAN_TES_NILAI_ID) AS ROWCOUNT FROM TAHAPAN_TES_NILAI A
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
		$str = "SELECT COUNT(TAHAPAN_TES_NILAI_ID) AS ROWCOUNT FROM TAHAPAN_TES_NILAI A
				TAHAPAN_TES_NILAI B ON B.TAHAPAN_TES_ID = A.TAHAPAN_TES_ID
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