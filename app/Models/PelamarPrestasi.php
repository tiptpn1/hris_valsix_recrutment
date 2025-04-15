<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class PelamarPrestasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPrestasi()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PRESTASI_ID", $this->getSeqId("PELAMAR_PRESTASI_ID","pelamar_prestasi")); 

		$str = "INSERT INTO pelamar_prestasi(PELAMAR_PRESTASI_ID, PELAMAR_ID, TINGKAT, TAHUN, NAMA, PENGHARGAAN, TANGGAL)
				VALUES(
				  ".$this->getField("PELAMAR_PRESTASI_ID").",
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("TINGKAT")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PENGHARGAAN")."',
				  ".$this->getField("TANGGAL")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PRESTASI_ID");
		return $this->execQuery($str);
    }
	
	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pelamar_prestasi SET
				  TINGKAT= '".$this->getField("TINGKAT")."',
				  TAHUN= '".$this->getField("TAHUN")."',
				  NAMA= '".$this->getField("NAMA")."',
				  PENGHARGAAN= '".$this->getField("PENGHARGAAN")."',
				  TANGGAL= ".$this->getField("TANGGAL")."
				WHERE PELAMAR_PRESTASI_ID= '".$this->getField("PELAMAR_PRESTASI_ID")."'
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateFormatDynamis()
	{
		$str = "
				UPDATE ".$this->getField("TABLE")."
				SET
					   ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE ".$this->getField("FIELD_ID")." = '".$this->getField("FIELD_VALUE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM pelamar_prestasi
                WHERE 
                  PELAMAR_PRESTASI_ID= ".$this->getField("PELAMAR_PRESTASI_ID")."
			"; 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT PELAMAR_PRESTASI_ID, MD5(PELAMAR_ID) PELAMAR_ID_ENKRIP, PELAMAR_ID, TINGKAT, TAHUN, NAMA, PENGHARGAAN, TANGGAL
				FROM pelamar_prestasi WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$order;
		$this->query = $str;		
				
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsData($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT A.PELAMAR_PRESTASI_ID, md5(CAST(A.PELAMAR_ID as TEXT)) PELAMAR_ID_ENKRIP, A.PELAMAR_ID, A.TINGKAT, A.TAHUN, A.NAMA, A.PENGHARGAAN
				, A.TANGGAL
				FROM pelamar_prestasi A WHERE 1=1 "; 
		
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
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM pelamar_prestasi WHERE 1=1 ".$statement; 
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