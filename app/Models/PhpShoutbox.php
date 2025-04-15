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

class PhpShoutbox extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PhpShoutbox()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("JAM", $this->getSeqId("JAM","PHPSHOUTBOX")); 

		$str = "
				INSERT INTO PHPSHOUTBOX (
				   JAM, NAMA, PESAN, 
   					IP_ADDRESS, PELAMAR_ID, HALAMAN, KODE) 
				VALUES (
				  '".$this->getField("JAM")."',
				  '".$this->getField("NAMA")."', 
				  '".$this->getField("PESAN")."', 
				  '".$this->getField("IP_ADDRESS")."', 
				  '".$this->getField("PELAMAR_ID")."', 
				  '".$this->getField("HALAMAN")."', 
				  '".$this->getField("KODE")."'
				)"; 
		$this->query = $str;
		
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PHPSHOUTBOX SET
				  NAMA = '".$this->getField("NAMA")."'
				WHERE JAM = '".$this->getField("JAM")."'
				"; 
				$this->query = $str;
				
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PHPSHOUTBOX
                WHERE 
                  JAM = '".$this->getField("JAM")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParentChild()
	{
        $str = "DELETE FROM PHPSHOUTBOX
                WHERE 
                  NAMA = '".$this->getField("NAMA")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","NAMA"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order=' ORDER BY JAM ASC ')
	{
		$str = "SELECT JAM, NAMA, PESAN, 
   					IP_ADDRESS, PELAMAR_ID, HALAMAN, KODE, TO_CHAR(WAKTU, 'DD/MM/YYYY HH24:MI:SS') WAKTU
				FROM PHPSHOUTBOX A WHERE 1=1 "; 
		//JAM IS NOT NULL
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
	}

    function selectByParamsTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order=' ORDER BY JAM DESC ')
	{
		$str = "SELECT A.PELAMAR_ID, B.NAMA PELAMAR, B.NRP, JAM, A.NAMA, PESAN, 
   					IP_ADDRESS, HALAMAN, KODE, TO_CHAR(WAKTU, 'DD-MM-YYYY HH24:MI:SS') WAKTU
				FROM PHPSHOUTBOX_TERAKHIR A 
                INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
					WHERE 1=1 "; 
		//JAM IS NOT NULL
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
	}
			    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "SELECT JAM, NAMA
				FROM PHPSHOUTBOX WHERE JAM IS NOT NULL"; 
		
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
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","NAMA"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParamsTerakhir($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM PHPSHOUTBOX_TERAKHIR A 
                INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID
					WHERE 1=1 "; 
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
		
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(JAM) AS ROWCOUNT FROM PHPSHOUTBOX WHERE JAM IS NOT NULL "; 
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
		$str = "SELECT COUNT(JAM) AS ROWCOUNT FROM PHPSHOUTBOX WHERE JAM IS NOT NULL "; 
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