<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_sim.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarSim extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarSim()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_SIM_ID", $this->getSeqId("PELAMAR_SIM_ID","pelamar_sim"));

		$str = "
					INSERT INTO pelamar_sim(
				            PELAMAR_SIM_ID, PELAMAR_ID, JENIS_SIM_ID, NO_SIM, TANGGAL_KADALUARSA, 
				            CREATED_BY, CREATED_DATE)
				    VALUES (
				    '".$this->getField("PELAMAR_SIM_ID")."',
					'".$this->getField("PELAMAR_ID")."',
					'".$this->getField("JENIS_SIM_ID")."',
					'".$this->getField("NO_SIM")."',
				    ".$this->getField("TANGGAL_KADALUARSA").",
					'".$this->getField("CREATED_BY")."',
					".$this->getField("CREATED_DATE")."
				)"; 
		$this->id=$this->getField("PELAMAR_SIM_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_sim
				   SET PELAMAR_ID 			= '".$this->getField("PELAMAR_ID")."',
				       JENIS_SIM_ID 		= '".$this->getField("JENIS_SIM_ID")."',
				       NO_SIM 				= '".$this->getField("NO_SIM")."',
				       TANGGAL_KADALUARSA 	= ".$this->getField("TANGGAL_KADALUARSA").",
				       UPDATED_BY 	= '".$this->getField("UPDATED_BY")."',
				       UPDATED_DATE 	= ".$this->getField("UPDATED_DATE")."
				WHERE PELAMAR_SIM_ID 		= '".$this->getField("PELAMAR_SIM_ID")."'

			 "; 
			 // echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pelamar_sim
                WHERE 
                  PELAMAR_SIM_ID= ".$this->getField("PELAMAR_SIM_ID")." AND 
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' "; 
				   
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_SIM_ID_GEN", $this->getSeqId("PELAMAR_SIM_ID","pelamar_sim")); 		

		$str = "
				INSERT INTO pelamar_sim (
				   PELAMAR_SIM_ID, PELAMAR_ID, JENIS_SIM_ID, NO_SIM, TANGGAL_KADALUARSA, 
				            LINK_FILE, CREATED_BY, CREATED_DATE) 
				SELECT ".$this->getField("PELAMAR_SIM_ID_GEN")." PELAMAR_SIM_ID, PELAMAR_SIM_ID, PELAMAR_ID, JENIS_SIM_ID, NO_SIM, TANGGAL_KADALUARSA, LINK_FILE, CREATED_BY, CREATED_DATE
				FROM pds_validasi.PEGAWAI_SIM WHERE PEGAWAI_SIM_ID = ".$this->getField("PELAMAR_SIM_ID").""; 
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_SIM_ID");
		
		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.PEGAWAI_SIM
					WHERE 
					  PEGAWAI_SIM_ID = ".$this->getField("PEGAWAI_SIM_ID").""; 		
			return $this->execQuery($str);
		}
    }
	
	function tolak()
	{
        $str = "DELETE FROM pds_validasi.PEGAWAI_SIM
                WHERE 
                  PEGAWAI_SIM_ID = ".$this->getField("PEGAWAI_SIM_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function update_file()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE pelamar_sim  SET
				  LINK_FILE = '".$this->getField("LINK_FILE")."'
				WHERE PELAMAR_SIM_ID = '".$this->getField("PELAMAR_SIM_ID")."'
				"; 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.TANGGAL_KADALUARSA DESC")
	{
		$str = "
					SELECT PELAMAR_SIM_ID, PELAMAR_ID, A.JENIS_SIM_ID, NO_SIM, TANGGAL_KADALUARSA, 
					       LINK_FILE, CREATED_BY, CREATED_DATE, UPDATED_BY, 
					       UPDATED_DATE, B.KODE KODE_SIM
					  FROM pelamar_sim A
				LEFT JOIN  JENIS_SIM B ON A.JENIS_SIM_ID = B.JENIS_SIM_ID
					WHERE 1=1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

   function selectByParamsValidasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
					SELECT * FROM
					(
					SELECT 'Validasi' STATUS, 
					PELAMAR_SIM_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT
					FROM pds_validasi.pelamar_sim A
					UNION
					SELECT 'Master' STATUS, 
					PELAMAR_SIM_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT
					FROM pelamar_sim A
					) A 
					WHERE 1=1
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
					SELECT 
					PELAMAR_SIM_ID, PELAMAR_ID, JENIS_SIM_ID
					FROM pelamar_sim A WHERE PELAMAR_SIM_ID IS NOT NULL
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PELAMAR_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_SIM_ID) AS ROWCOUNT FROM pelamar_sim
		        WHERE PELAMAR_SIM_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELAMAR_SIM_ID) AS ROWCOUNT FROM pelamar_sim
		        WHERE PELAMAR_SIM_ID IS NOT NULL ".$statement; 
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