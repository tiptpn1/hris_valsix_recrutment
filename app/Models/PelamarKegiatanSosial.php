<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class PelamarKegiatanSosial extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarKegiatanSosial()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_KEGIATAN_SOSIAL_ID", $this->getSeqId("PELAMAR_KEGIATAN_SOSIAL_ID","PELAMAR_KEGIATAN_SOSIAL")); 

		$str = "INSERT INTO PELAMAR_KEGIATAN_SOSIAL(PELAMAR_KEGIATAN_SOSIAL_ID, PELAMAR_ID, JABATAN, TAHUN, NAMA, TANGGAL)
				VALUES(
				  ".$this->getField("PELAMAR_KEGIATAN_SOSIAL_ID").",
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("JABATAN")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_KEGIATAN_SOSIAL_ID");
		return $this->execQuery($str);
    }
	
	function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PELAMAR_KEGIATAN_SOSIAL SET
				  JABATAN= '".$this->getField("JABATAN")."',
				  TAHUN= '".$this->getField("TAHUN")."',
				  NAMA= '".$this->getField("NAMA")."',
				  TANGGAL= ".$this->getField("TANGGAL")."
				WHERE PELAMAR_KEGIATAN_SOSIAL_ID= '".$this->getField("PELAMAR_KEGIATAN_SOSIAL_ID")."'
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
				DELETE FROM PELAMAR_KEGIATAN_SOSIAL
                WHERE 
                  PELAMAR_KEGIATAN_SOSIAL_ID= ".$this->getField("PELAMAR_KEGIATAN_SOSIAL_ID")."
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
		$str = "SELECT PELAMAR_KEGIATAN_SOSIAL_ID, MD5(PELAMAR_ID) PELAMAR_ID_ENKRIP, PELAMAR_ID, JABATAN, TAHUN, NAMA, TANGGAL
				FROM PELAMAR_KEGIATAN_SOSIAL WHERE 1=1"; 
		
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
		$str = "SELECT A.PELAMAR_KEGIATAN_SOSIAL_ID, md5(CAST(A.PELAMAR_ID as TEXT)) PELAMAR_ID_ENKRIP, A.PELAMAR_ID, A.JABATAN, A.TAHUN, A.NAMA
				, A.TANGGAL
				FROM PELAMAR_KEGIATAN_SOSIAL A WHERE 1=1 "; 
		
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
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM PELAMAR_KEGIATAN_SOSIAL WHERE 1=1 ".$statement; 
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