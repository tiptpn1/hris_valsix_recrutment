<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class KategoriKriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function KategoriKriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KATEGORI_KRITERIA_ID", $this->getSeqId("KATEGORI_KRITERIA_ID","KATEGORI_KRITERIA")); 		

		$str = "
				INSERT INTO KATEGORI_KRITERIA(
			            KATEGORI_KRITERIA_ID, NAMA, KETERANGAN, 
			            BOBOT, CREATED_BY, CREATED_DATE)
			    VALUES ('".$this->getField("KATEGORI_KRITERIA_ID")."', '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."', 
			    		'".$this->getField("BOBOT")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")
				"; 
		$this->id = $this->getField("KATEGORI_KRITERIA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE KATEGORI_KRITERIA
				   SET NAMA 				= '".$this->getField("NAMA")."', 
				   	   KETERANGAN			= '".$this->getField("KETERANGAN")."', 
				   	   BOBOT				= '".$this->getField("BOBOT")."', 
				       UPDATED_BY		= '".$this->getField("UPDATED_BY")."', 
				       UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				 WHERE KATEGORI_KRITERIA_ID     		= '".$this->getField("KATEGORI_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KATEGORI_KRITERIA
                WHERE 
                  KATEGORI_KRITERIA_ID = ".$this->getField("KATEGORI_KRITERIA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY KATEGORI_KRITERIA_ID ASC ")
	{
		$str = "
				SELECT KATEGORI_KRITERIA_ID, KODE, NAMA, KETERANGAN, BOBOT, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM KATEGORI_KRITERIA A
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
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KATEGORI_KRITERIA_ID, NAMA, KETERANGAN, BOBOT, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM KATEGORI_KRITERIA A
				  WHERE 1 = 1
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
		$str = "SELECT COUNT(KATEGORI_KRITERIA_ID) AS ROWCOUNT FROM KATEGORI_KRITERIA A
		        WHERE KATEGORI_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
	
	
    function getFlag($paramsArray=array(), $kolom)
	{
		$str = "SELECT ".$kolom." ROWCOUNT FROM KATEGORI_KRITERIA A
		        WHERE KATEGORI_KRITERIA_ID IS NOT NULL "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KATEGORI_KRITERIA_ID) AS ROWCOUNT FROM KATEGORI_KRITERIA A
		        WHERE KATEGORI_KRITERIA_ID IS NOT NULL ".$statement; 
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