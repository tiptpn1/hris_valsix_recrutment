<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PELAMAR_KATEGORI_LOLOS.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarKategoriLolos extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarKategoriLolos()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_KATEGORI_LOLOS_ID", $this->getSeqId("PELAMAR_KATEGORI_LOLOS_ID","PELAMAR_KATEGORI_LOLOS"));

		$str = "
					INSERT INTO PELAMAR_KATEGORI_LOLOS(
					            PELAMAR_KATEGORI_LOLOS_ID, LOWONGAN_KATEGORI_KRITERIA_ID, PELAMAR_ID, 
					            LOWONGAN_ID, REKOMENDASI_ID, CREATED_BY, CREATED_DATE, CATATAN)
					    VALUES ('".$this->getField("PELAMAR_KATEGORI_LOLOS_ID")."', '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', '".$this->getField("PELAMAR_ID")."', 
					            '".$this->getField("LOWONGAN_ID")."', '".$this->getField("REKOMENDASI_ID")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").",
					        '".$this->getField("CATATAN")."')
			  "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE PELAMAR_KATEGORI_LOLOS
				   SET LOWONGAN_KATEGORI_KRITERIA_ID 	= '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."',
				       PELAMAR_ID 						= '".$this->getField("PELAMAR_ID")."',
				       LOWONGAN_ID 						= '".$this->getField("LOWONGAN_ID")."',
				       REKOMENDASI_ID 					= '".$this->getField("REKOMENDASI_ID")."',
				       UPDATED_BY 				= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 				= ".$this->getField("UPDATED_DATE").",
				       CATATAN 							= '".$this->getField("CATATAN")."'
				WHERE  PELAMAR_KATEGORI_LOLOS_ID     	= '".$this->getField("PELAMAR_KATEGORI_LOLOS_ID")."'

			 "; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
    
	function delete()
	{
        $str = "DELETE FROM PELAMAR_KATEGORI_LOLOS
                WHERE 
                  PELAMAR_KATEGORI_LOLOS_ID = ".$this->getField("PELAMAR_KATEGORI_LOLOS_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM PELAMAR_KATEGORI_LOLOS
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")."
                  AND 
                  PELAMAR_ID  = ".$this->getField("PELAMAR_ID")."
                  AND 
                  LOWONGAN_KATEGORI_KRITERIA_ID  = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")." "; 
				  
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
				SELECT PELAMAR_KATEGORI_LOLOS_ID, LOWONGAN_KATEGORI_KRITERIA_ID, PELAMAR_ID, 
				       LOWONGAN_ID, REKOMENDASI_ID, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM PELAMAR_KATEGORI_LOLOS A
		 		 WHERE 1 = 1
				"; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY PELAMAR_KATEGORI_LOLOS_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_KATEGORI_LOLOS_ID, A.LOWONGAN_KATEGORI_KRITERIA_ID, A.PELAMAR_ID, 
				       A.LOWONGAN_ID, REKOMENDASI_ID, A.CREATED_BY, A.CREATED_DATE, 
				       A.UPDATED_BY, A.UPDATED_DATE, A.CATATAN
				  FROM PELAMAR_KATEGORI_LOLOS A
			 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
			 LEFT JOIN LOWONGAN_KATEGORI_KRITERIA C ON A.LOWONGAN_KATEGORI_KRITERIA_ID = C.LOWONGAN_KATEGORI_KRITERIA_ID
		 		 WHERE 1 = 1 
				".$statement; 

		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY A.PELAMAR_ID DESC";
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
		$str = "SELECT COUNT(PELAMAR_KATEGORI_LOLOS_ID) AS ROWCOUNT 
				  FROM PELAMAR_KATEGORI_LOLOS A
		         WHERE PELAMAR_KATEGORI_LOLOS_ID IS NOT NULL ".$statement; 
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
		$str = "SELECT COUNT(PELAMAR_KATEGORI_LOLOS_ID) AS ROWCOUNT 
				  FROM PELAMAR_KATEGORI_LOLOS A
			 LEFT JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
			 LEFT JOIN LOWONGAN_KATEGORI_KRITERIA C ON A.LOWONGAN_KATEGORI_KRITERIA_ID = C.LOWONGAN_KATEGORI_KRITERIA_ID
		         WHERE PELAMAR_KATEGORI_LOLOS_ID IS NOT NULL ".$statement; 
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