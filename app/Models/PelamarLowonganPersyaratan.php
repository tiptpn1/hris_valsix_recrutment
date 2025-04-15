<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarLowonganPersyaratan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarLowonganPersyaratan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		$this->setField("PELAMAR_LOWONGAN_PERSYARATAN_ID", $this->getSeqId("PELAMAR_LOWONGAN_PERSYARATAN_ID","pelamar_lowongan_persyaratan"));

		$str = "
				INSERT INTO pelamar_lowongan_persyaratan(
			            PELAMAR_LOWONGAN_PERSYARATAN_ID, PELAMAR_ID, LOWONGAN_ID, LOWONGAN_PERSYARATAN_ID, 
			            NAMA_JENIS_PERSYARATAN, KETERANGAN, PERSYARATAN, CREATED_BY, 
			            CREATED_DATE)
			    VALUES ('".$this->getField("PELAMAR_LOWONGAN_PERSYARATAN_ID")."', '".$this->getField("PELAMAR_ID")."', '".$this->getField("LOWONGAN_ID")."', 
			    		'".$this->getField("LOWONGAN_PERSYARATAN_ID")."', '".$this->getField("NAMA_JENIS_PERSYARATAN")."', '".$this->getField("KETERANGAN")."', 
			    		'".$this->getField("PERSYARATAN")."', '".$this->getField("CREATED_BY")."', ".$this->getField("CREATED_DATE").")				
				"; 
		$this->id = $this->getField("PELAMAR_LOWONGAN_PERSYARATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_lowongan_persyaratan
			       SET PELAMAR_ID 						= '".$this->getField("PELAMAR_ID")."',
			           LOWONGAN_ID 						= '".$this->getField("LOWONGAN_ID")."',
			           LOWONGAN_PERSYARATAN_ID 			= '".$this->getField("LOWONGAN_PERSYARATAN_ID")."',
			           NAMA_JENIS_PERSYARATAN 			= '".$this->getField("NAMA_JENIS_PERSYARATAN")."',
			           KETERANGAN 						= '".$this->getField("KETERANGAN")."',
			           PERSYARATAN 						= '".$this->getField("PERSYARATAN")."',
			           UPDATED_BY 				= '".$this->getField("UPDATED_BY")."',
			           UPDATED_DATE 				= ".$this->getField("UPDATED_DATE")."
				WHERE  PELAMAR_LOWONGAN_PERSYARATAN_ID 	= '".$this->getField("PELAMAR_LOWONGAN_PERSYARATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_TAHAPAN
                WHERE 
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function prosesRefresh($reqId)
	{
        $str = "SELECT PELAMAR_PERSYARATAN_REFREH(".$reqId.")"; 

		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM PELAMAR_LOWONGAN_TAHAPAN
                WHERE  
                  PELAMAR_ID = ".$this->getField("PELAMAR_ID")." AND
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." "; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PELAMAR_ID ASC ")
	{
		$str = "
				SELECT PELAMAR_LOWONGAN_PERSYARATANID, PELAMAR_ID, LOWONGAN_ID,
				       LOWONGAN_PERSYARATAN_ID, NAMA_JENIS_PERSYARATAN, KETERANGAN,
				       PERSYARATAN, CREATED_BY, CREATED_DATE, UPDATED_BY,
				       UPDATED_DATE
				  FROM pelamar_lowongan_persyaratan A
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
		
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_LOWONGAN_PERSYARATANID) AS ROWCOUNT FROM pelamar_lowongan_persyaratan A
		        WHERE PELAMAR_LOWONGAN_PERSYARATANID IS NOT NULL ".$statement; 
		
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