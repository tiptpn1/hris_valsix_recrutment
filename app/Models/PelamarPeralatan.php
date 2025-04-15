<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarPeralatan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPeralatan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PERALATAN_ID", $this->getSeqId("PELAMAR_PERALATAN_ID","pelamar_peralatan")); 		

		$str = "

				 INSERT INTO pelamar_peralatan(
			            PELAMAR_PERALATAN_ID, 
			            PELAMAR_ID, 
			            PERMINTAAN_KEBUTUHAN_ALAT_ID, 
			            NAMA_ALAT, 
			            STATUS, 
			            CREATED_BY, 
			            CREATED_DATE
			            )
			    				 
				 VALUES ('".$this->getField("PELAMAR_PERALATAN_ID")."', '".$this->getField("PELAMAR_ID")."', '".$this->getField("PERMINTAAN_KEBUTUHAN_ALAT_ID")."', ".$this->getField("NAMA_ALAT").", '".$this->getField("STATUS")."','".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("PELAMAR_PERALATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "

					 UPDATE pelamar_peralatan
					   SET PELAMAR_ID 							='".$this->getField("PELAMAR_ID")."', 
					   		PERMINTAAN_KEBUTUHAN_ALAT_ID		='".$this->getField("PERMINTAAN_KEBUTUHAN_ALAT_ID")."', 
					   		NAMA_ALAT							=".$this->getField("NAMA_ALAT").", 
					        STATUS								='".$this->getField("STATUS")."', 
					        UPDATED_BY					='".$this->getField("UPDATED_BY")."', 
					        UPDATED_DATE					=".$this->getField("UPDATED_DATE")."
					 WHERE PELAMAR_PERALATAN_ID 				= '".$this->getField("PELAMAR_PERALATAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM pelamar_peralatan
                WHERE 
                  PELAMAR_PERALATAN_ID = ".$this->getField("PELAMAR_PERALATAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_PERALATAN_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_PERALATAN_ID, 
							A.PELAMAR_ID, 
							A.PERMINTAAN_KEBUTUHAN_ALAT_ID,
							A.NAMA_ALAT, 
							A.STATUS,
							A.CREATED_BY, 
		      	 			A.CREATED_DATE, 
		      	 			A.UPDATED_BY, 
		      	 			A.UPDATED_DATE
 					FROM pelamar_peralatan A
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
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_PERALATAN_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_PERALATAN_ID, 
							A.PELAMAR_ID, 
							A.PERMINTAAN_KEBUTUHAN_ALAT_ID, 
							A.NAMA_ALAT,
							A.STATUS,
							A.CREATED_BY, 
			      	 		A.CREATED_DATE, 
			      	 		A.UPDATED_BY, 
			      	 		A.UPDATED_DATE,
			      	 		B.NAMA NAMA_PELAMAR
 				FROM pelamar_peralatan A
 					LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
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
				SELECT PELAMAR_PERALATAN_ID, 
						A.PELAMAR_ID, 
						A.PERMINTAAN_KEBUTUHAN_ALAT_ID, 
						A.NAMA_ALAT,
						A.STATUS,
						A.CREATED_BY, 
		      	 		A.CREATED_DATE, 
		      	 		A.UPDATED_BY, 
		      	 		A.UPDATED_DATE
 				FROM pelamar_peralatan A
 				WHERE 1=1 
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_PERALATAN_ID) AS ROWCOUNT FROM pelamar_peralatan A
		        WHERE PELAMAR_PERALATAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_PERALATAN_ID) AS ROWCOUNT 
				FROM pelamar_peralatan A
				LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
		        WHERE PELAMAR_PERALATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELAMAR_PERALATAN_ID) AS ROWCOUNT FROM pelamar_peralatan
		        WHERE PELAMAR_PERALATAN_ID IS NOT NULL ".$statement; 
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