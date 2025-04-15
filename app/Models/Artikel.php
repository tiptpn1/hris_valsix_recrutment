<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Artikel extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Artikel()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ARID", $this->getSeqId("ARID","artikel")); 
		$this->tanggal = date("Y-m-d H:i:s");

		$str = "INSERT INTO artikel(ARID, AKID, UID, tanggal, judul, isi, status_approve) 
				VALUES(
				  ".$this->getField("ARID").",
				  '".$this->getField("AKID")."',
				  '".$this->getField("UID")."',
				  '".$this->tanggal."',
				  '".$this->getField("judul")."',
				  '".$this->getField("isi")."',
				  '".$this->getField("status_approve")."'				  				  				  
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE artikel SET
				  AKID = '".$this->getField("AKID")."',
				  judul = '".$this->getField("judul")."',
				  isi = '".$this->getField("isi")."',
				  status_approve = '".$this->getField("status_approve")."'
				WHERE ARID = '".$this->getField("ARID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatusAktif()
	{
		$str = "UPDATE artikel SET
				  status_approve = '".$this->getField("status_approve")."'
				WHERE ARID = '".$this->getField("ARID")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM artikel
                WHERE 
                  ARID = '".$this->getField("ARID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$varStatement="")
	{
		$str = "SELECT a.ARID, a.AKID, a.UID, a.tanggal, a.judul, a.isi, a.status_approve,
					   ak.AKID, ak.nama as ak_nama,
					   u.UID, u.nama as u_nama, u.level
				FROM artikel a, artikel_kategori ak, users u WHERE ARID IS NOT NULL AND ak.AKID = a.AKID AND u.UID = a.UID"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = $val ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY ARID DESC";
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $varStatement="")
	{
		$str = "SELECT a.ARID, a.AKID, a.UID, a.tanggal, a.judul, a.isi, a.status_approve,
					   ak.AKID, ak.nama as ak_nama,
					   u.UID, u.nama as u_nama
				FROM artikel a, artikel_kategori ak, users u WHERE ARID IS NOT NULL AND ak.AKID = a.AKID AND u.UID = a.UID"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY ARID DESC";
				
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(),$varStatement="")
	{
		$str = "SELECT COUNT(a.ARID) AS ROWCOUNT FROM artikel a, users u, artikel_kategori ak  WHERE a.ARID IS NOT NULL AND ak.AKID = a.AKID AND u.UID = a.UID ".$varStatement; 
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

    function getCountByParamsLike($paramsArray=array(),$varStatement="")
	{
		$str = "SELECT COUNT(a.ARID) AS ROWCOUNT FROM artikel a, users u, artikel_kategori ak WHERE a.ARID IS NOT NULL AND ak.AKID = a.AKID AND u.UID = a.UID ".$varStatement; 
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