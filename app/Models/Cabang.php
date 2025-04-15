<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel CABANG.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Cabang extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Cabang()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CABANG_ID", $this->getSeqId("CABANG_ID","CABANG"));
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO CABANG (
				   CABANG_ID, NAMA, KELAS_PELABUHAN, KODE_CABANG, KETERANGAN, CREATED_BY, CREATED_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("CABANG_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KELAS_PELABUHAN")."',
				  '".$this->getField("KODE_CABANG")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->id = $this->getField("CABANG_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE CABANG
				SET    
					   NAMA= '".$this->getField("NAMA")."',
					   KELAS_PELABUHAN= '".$this->getField("KELAS_PELABUHAN")."',
					   KODE_CABANG= '".$this->getField("KODE_CABANG")."',
					   KETERANGAN= '".$this->getField("KETERANGAN")."',
					   UPDATED_BY= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE= ".$this->getField("UPDATED_DATE")."
				WHERE  CABANG_ID     = '".$this->getField("CABANG_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM CABANG
                WHERE 
                  CABANG_ID = ".$this->getField("CABANG_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC")
	{
		$str = "
				SELECT 
				CABANG_ID, NAMA, KELAS_PELABUHAN, KETERANGAN, KODE_CABANG
				FROM CABANG A
				WHERE 1 = 1 
				"; 
		//, FOTO
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY NAMA DESC")
	{
		$str = "
				SELECT 
					A.CABANG_ID, KELAS_PELABUHAN, 
					CASE WHEN KELAS_PELABUHAN = '1' THEN 'I' WHEN KELAS_PELABUHAN = '2' THEN 'II' WHEN KELAS_PELABUHAN = '3' THEN 'III' ELSE '' END KELAS_PELABUHAN_NAMA,
					NAMA, KETERANGAN, KODE_CABANG
				FROM CABANG A
				WHERE 1=1 
				"; 

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT CABANG_ID, NAMA, KELAS_PELABUHAN, KETERANGAN
				FROM CABANG
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
	
	function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM CABANG A
				WHERE 1=1 
				".$statement; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(CABANG_ID) AS ROWCOUNT FROM CABANG
		        WHERE CABANG_ID IS NOT NULL ".$statement; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(CABANG_ID) AS ROWCOUNT FROM CABANG
		        WHERE CABANG_ID IS NOT NULL ".$statement; 
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