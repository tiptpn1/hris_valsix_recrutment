<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PENDIDIKAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Pendidikan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Pendidikan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENDIDIKAN_ID", $this->getSeqId("PENDIDIKAN_ID","PENDIDIKAN")); 		

		$str = "
				INSERT INTO PENDIDIKAN (
				   PENDIDIKAN_ID, NAMA, NAMA_EN, KETERANGAN, CREATED_BY, CREATED_DATE)  
 			  	VALUES (
				  ".$this->getField("PENDIDIKAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NAMA_EN")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE PENDIDIKAN
				SET    
					   NAMA           		= '".$this->getField("NAMA")."',
					   NAMA_EN           		= '".$this->getField("NAMA_EN")."',
					   KETERANGAN    		= '".$this->getField("KETERANGAN")."',
					   UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE		= ".$this->getField("UPDATED_DATE")."
				WHERE  PENDIDIKAN_ID     	= '".$this->getField("PENDIDIKAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PENDIDIKAN
                WHERE 
                  PENDIDIKAN_ID = '".$this->getField("PENDIDIKAN_ID")."'"; 
				  
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
				SELECT PENDIDIKAN_ID, NAMA, NAMA_EN, KETERANGAN, KODE, URUT
				FROM PENDIDIKAN
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
				SELECT PENDIDIKAN_ID, NAMA, KETERANGAN
				FROM PENDIDIKAN
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
	
	 function selectByParamsPendidikanStatistik($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "SELECT  A.NAMA, COUNT (B.PENDIDIKAN_ID) JUMLAH
						FROM PENDIDIKAN A LEFT JOIN PEGAWAI_PENDIDIKAN_TERAKHIR B
					   ON A.PENDIDIKAN_ID = B.PENDIDIKAN_ID AND  EXISTS (SELECT 1 FROM PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID = 1)
					GROUP BY B.PENDIDIKAN_ID, A.NAMA "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY B.PENDIDIKAN_ID ASC";
				
		return $this->selectLimit($str,$limit,$from); 
    }
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PENDIDIKAN_ID) AS ROWCOUNT FROM PENDIDIKAN
		        WHERE PENDIDIKAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENDIDIKAN_ID) AS ROWCOUNT FROM PENDIDIKAN
		        WHERE PENDIDIKAN_ID IS NOT NULL ".$statement; 
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