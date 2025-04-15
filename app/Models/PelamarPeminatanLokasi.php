<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel PELAMAR_PEMINATAN_LOKASI.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarPeminatanLokasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPeminatanLokasi()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PEMINATAN_LOKASI_ID", $this->getSeqId("PELAMAR_PEMINATAN_LOKASI_ID","PELAMAR_PEMINATAN_LOKASI"));

		$str = "
				INSERT INTO PELAMAR_PEMINATAN_LOKASI(
						PELAMAR_PEMINATAN_LOKASI_ID, PELAMAR_ID, CABANG_ID, URUT)
				VALUES (
				".$this->getField("PELAMAR_PEMINATAN_LOKASI_ID").",
				".$this->getField("PELAMAR_ID").", 
				".$this->CABANG_ID.", 
				".$this->getField("URUT")."
				)"; 
		$this->id=$this->getField("PELAMAR_PEMINATAN_LOKASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE PELAMAR_PEMINATAN_LOKASI
				   SET 
				   	   PELAMAR_ID= '".$this->getField("PELAMAR_ID")."', 
					   CABANG_ID= '".$this->CABANG_ID."'
				 WHERE PELAMAR_PEMINATAN_LOKASI_ID= '".$this->getField("PELAMAR_PEMINATAN_LOKASI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PELAMAR_PEMINATAN_LOKASI
                WHERE 
                  PELAMAR_ID= ".$this->getField("PELAMAR_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY URUT")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}
		$str = "
					SELECT PELAMAR_PEMINATAN_LOKASI_ID, A.PELAMAR_ID, A.CABANG_ID,
					C.NAMA NAMA_LOKASI
  					FROM PELAMAR_PEMINATAN_LOKASI A
					LEFT JOIN PELAMAR B ON B.PELAMAR_ID = A.PELAMAR_ID
					LEFT JOIN CABANG C ON C.CABANG_ID = A.CABANG_ID
					WHERE 1=1
				".$add_cabang; 
		
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
					SELECT 
					PELAMAR_PEMINATAN_LOKASI_ID, PELAMAR_ID, SERTIFIKAT_PELAMAR_ID
					FROM PELAMAR_PEMINATAN_LOKASI A WHERE PELAMAR_PEMINATAN_LOKASI_ID IS NOT NULL
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PELAMAR_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function getUrutLokasi($pelamarId, $urut)
	{
		$str = "SELECT CABANG_ID FROM PELAMAR_PEMINATAN_LOKASI A
				WHERE 1=1 AND PELAMAR_ID = ".$pelamarId." AND URUT = ".$urut." "; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("CABANG_ID"); 
		else 
			return 0; 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}
		$str = "SELECT COUNT(PELAMAR_PEMINATAN_LOKASI_ID) AS ROWCOUNT FROM PELAMAR_PEMINATAN_LOKASI
		        WHERE PELAMAR_PEMINATAN_LOKASI_ID IS NOT NULL				
				LEFT JOIN PELAMAR B ON B.PELAMAR_ID = A.PELAMAR_ID
				LEFT JOIN CABANG C ON C.CABANG_ID = A.CABANG_ID
				 ".$add_cabang.$statement; 
		
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
		$add_cabang ="";
		if(!empty($this->CABANG_ID)){
			$add_cabang  = " AND A.CABANG_ID='".$this->CABANG_ID."'";
		}
		$str = "SELECT COUNT(PELAMAR_PEMINATAN_LOKASI_ID) AS ROWCOUNT FROM PELAMAR_PEMINATAN_LOKASI
		        WHERE PELAMAR_PEMINATAN_LOKASI_ID IS NOT NULL ".$add_cabang.$statement; 
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