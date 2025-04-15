<? 

namespace App\Models;
use App\Models\Entity;

class Testimonial extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Testimonial()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TID", $this->getSeqId("TID","testimonial")); 

		$str = "INSERT INTO testimonial(TID, nama, keterangan) 
				VALUES(
				  ".$this->getField("TID").",
				  '".$this->getField("nama")."',
				  '".$this->getField("keterangan")."'
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE testimonial SET
				  nama = '".$this->getField("nama")."',
				  keterangan = '".$this->getField("keterangan")."'
				WHERE TID = '".$this->getField("TID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM testimonial
                WHERE 
                  TID = '".$this->getField("TID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT TID, nama, keterangan
				FROM testimonial WHERE TID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = $val ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY RAND()";
				
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT ALKID, nama, keterangan
				FROM alumni_kategori WHERE ALKID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY nama ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(TID) AS ROWCOUNT FROM testimonial WHERE TID IS NOT NULL "; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(ALKID) AS ROWCOUNT FROM alumni_kategori WHERE ALKID IS NOT NULL "; 
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