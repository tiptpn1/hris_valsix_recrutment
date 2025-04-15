<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class LowonganKriteria extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function LowonganKriteria()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LOWONGAN_KRITERIA_ID", $this->getSeqId("LOWONGAN_KRITERIA_ID","LOWONGAN_KRITERIA")); 		

		$str = "
				INSERT INTO LOWONGAN_KRITERIA(
			            LOWONGAN_KRITERIA_ID, LOWONGAN_KATEGORI_KRITERIA_ID, LOWONGAN_ID, 
					   NAMA, KETERANGAN, BOBOT, URUT, 
					   NILAI_HURUF, NILAI_ANGKA, 
					   CREATED_BY, CREATED_DATE)
			    VALUES ('".$this->getField("LOWONGAN_KRITERIA_ID")."', '".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID")."', '".$this->getField("LOWONGAN_ID")."', 
						'".$this->getField("NAMA")."', 
						'".$this->getField("KETERANGAN")."', '".$this->getField("BOBOT")."', 
			    		'".$this->getField("URUT")."', 
						'".$this->getField("NILAI_HURUF")."', '".$this->getField("NILAI_ANGKA")."', 
						'".$this->getField("CREATED_BY")."', current_timestamp)
				"; 
		$this->id = $this->getField("LOWONGAN_KRITERIA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE LOWONGAN_KRITERIA
				   SET NAMA 				= '".$this->getField("NAMA")."',
				       KETERANGAN 			= '".$this->getField("KETERANGAN")."',
				       BOBOT 				= '".$this->getField("BOBOT")."',
				       UPDATED_BY 	= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 	= ".$this->getField("UPDATED_DATE")."
				 WHERE LOWONGAN_KRITERIA_ID	= '".$this->getField("LOWONGAN_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateBobot()
	{
		$str = "
				UPDATE LOWONGAN_KRITERIA
				   SET BOBOT 				= '".$this->getField("BOBOT")."',
				       UPDATED_BY 	= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 	= CURRENT_DATE
				 WHERE LOWONGAN_KRITERIA_ID	= '".$this->getField("LOWONGAN_KRITERIA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM LOWONGAN_KRITERIA
                WHERE 
                  LOWONGAN_KRITERIA_ID = ".$this->getField("LOWONGAN_KRITERIA_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM LOWONGAN_KRITERIA
                WHERE 
                  LOWONGAN_ID = ".$this->getField("LOWONGAN_ID")." AND
				  LOWONGAN_KATEGORI_KRITERIA_ID = ".$this->getField("LOWONGAN_KATEGORI_KRITERIA_ID"); 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY URUT ASC ")
	{
		$str = "
				SELECT LOWONGAN_KRITERIA_ID, LOWONGAN_ID,  
				       NAMA, KETERANGAN, BOBOT, URUT, NILAI_HURUF, NILAI_ANGKA, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE, AMBIL_LOWONGAN_KRITERIA_NILAI(LOWONGAN_KRITERIA_ID) NILAI
				  FROM LOWONGAN_KRITERIA A
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

    function selectByParamsPenilai($pelamarId, $penilaiId, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.URUT ASC ")
	{
		$str = "
				SELECT A.LOWONGAN_KRITERIA_ID, A.LOWONGAN_ID, A.LOWONGAN_KATEGORI_KRITERIA_ID,
				       A.NAMA, A.KETERANGAN, A.BOBOT, B.NILAI_ANGKA, B.NILAI_TOTAL
				  FROM LOWONGAN_KRITERIA A
                  LEFT JOIN PELAMAR_LOWONGAN_NILAI B ON A.LOWONGAN_ID = B.LOWONGAN_ID AND A.LOWONGAN_KRITERIA_ID = B.LOWONGAN_KRITERIA_ID AND B.PELAMAR_ID = '".$pelamarId."' AND B.PENILAI_ID = '".$penilaiId."'
				  WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY LOWONGAN_KRITERIA_ID ASC ")
	{
		$str = "
				SELECT LOWONGAN_KRITERIA_ID, A.LOWONGAN_ID, 
				       A.NAMA, A.KETERANGAN, BOBOT, A.CREATED_BY, A.CREATED_DATE, 
				       A.UPDATED_BY, A.UPDATED_DATE, B.PENEMPATAN || ' ( ' || B.KODE || ' )' NAMA_LOWONGAN
				  FROM LOWONGAN_KRITERIA A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
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
				SELECT LOWONGAN_KRITERIA_ID, LOWONGAN_ID, 
				       NAMA, KETERANGAN, BOBOT, CREATED_BY, CREATED_DATE, 
				       UPDATED_BY, UPDATED_DATE
				  FROM LOWONGAN_KRITERIA A
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
    * @return long Jumlah record yang sesuai LOWONGAN_KRITERIA 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_KRITERIA A
		        WHERE LOWONGAN_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
	
	
    function getCountByParamsPenilai($pelamarId, $penilaiId, $paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM LOWONGAN_KRITERIA A
                  INNER JOIN PELAMAR_LOWONGAN_NILAI B ON A.LOWONGAN_ID = B.LOWONGAN_ID AND A.LOWONGAN_KRITERIA_ID = B.LOWONGAN_KRITERIA_ID AND B.PELAMAR_ID = '".$pelamarId."' AND B.PENILAI_ID = '".$penilaiId."'
				  WHERE 1 = 1 ".$statement; 
		
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
	
	
	function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_ID) AS ROWCOUNT 
				  FROM LOWONGAN_KRITERIA A
			 LEFT JOIN LOWONGAN B ON A.LOWONGAN_ID = B.LOWONGAN_ID
		         WHERE LOWONGAN_KRITERIA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOWONGAN_KRITERIA_ID) AS ROWCOUNT FROM LOWONGAN_KRITERIA A
		        WHERE LOWONGAN_KRITERIA_ID IS NOT NULL ".$statement; 
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