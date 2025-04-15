<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Jabatan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Jabatan()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JABATAN_ID", $this->getSeqId("JABATAN_ID","JABATAN")); 		

		$str = "
				INSERT INTO JABATAN (
				   JABATAN_ID, NAMA, KODE, STATUS, KELOMPOK, KETERANGAN, BIDANG_ID) 
 			  	VALUES (
				  ".$this->getField("JABATAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("STATUS")."',
				  '".$this->getField("KELOMPOK")."',
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("BIDANG_ID")."
				)"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }
	
    function updateData()
	{
		$str = "
				UPDATE JABATAN
				SET    
					   NAMA           	= '".$this->getField("NAMA")."',
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   KODE      		= '".$this->getField("KODE")."',
					   STATUS      		= '".$this->getField("STATUS")."',
					   KELOMPOK    		= '".$this->getField("KELOMPOK")."',
					   BIDANG_ID    	= ".$this->getField("BIDANG_ID")."
				WHERE  JABATAN_ID     = '".$this->getField("JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateCabangP3()
	{
		$str = "
				UPDATE JABATAN
				SET    
				    NAMA           	= '".$this->getField("NAMA")."',
				    KODE      		= '".$this->getField("KODE")."',
				    NO_URUT    		= '".$this->getField("NO_URUT")."',
					KETERANGAN		= '".$this->getField("KETERANGAN")."',
				    KELAS         	= '".$this->getField("KELAS")."',
				    STATUS			= ".$this->getField("STATUS").",
				    KELOMPOK			= '".$this->getField("KELOMPOK")."',
					UPDATED_BY	= '".$this->getField("UPDATED_BY")."',
					UPDATED_DATE	= ".$this->getField("UPDATED_DATE").",
					PPH				= ".$this->getField("PPH").",
					NAMA_SLIP		= '".$this->getField("NAMA_SLIP")."',
					KATEGORI	= '".$this->getField("KATEGORI")."',
					MAKSIMAL_USIA = ".$this->getField("MAKSIMAL_USIA").",
				    CABANG_PROSENTASE_UMK = ".$this->getField("CABANG_PROSENTASE_UMK").",
				    CABANG_ID = ".$this->getField("CABANG_ID")."
				    BIDANG_ID = ".$this->getField("BIDANG_ID")."
				WHERE  JABATAN_ID     = '".$this->getField("JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM JABATAN
                WHERE 
                  JABATAN_ID = ".$this->getField("JABATAN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
		//echo $str;
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY JABATAN_ID ASC ")
	{
		$str = "
				SELECT JABATAN_ID, A.NAMA, A.KODE, NO_URUT, A.KETERANGAN, A.BIDANG_ID, B.NAMA NAMA_BIDANG		
				FROM JABATAN A
				LEFT JOIN BIDANG B ON A.BIDANG_ID = B.BIDANG_ID
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
	

    function selectByParamsKandidatJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.JABATAN_ID, A.NAMA JABATAN, A.KELAS, B.PEGAWAI_ID, C.NRP, C.NAMA
				FROM JABATAN A
				LEFT JOIN PEGAWAI_JABATAN_TERAKHIR B  ON A.JABATAN_ID = B.JABATAN_ID AND EXISTS(SELECT 1 FROM PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID IN (1, 5))
				LEFT JOIN PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1 AND A.KELOMPOK = 'D' AND TO_NUMBER(A.KELAS, '99') BETWEEN 5 AND 9 
                AND (
                      UPPER(A.NAMA) LIKE 'MANAGER%' OR
                      UPPER(A.NAMA) LIKE 'KEPALA%' OR
                      UPPER(A.NAMA) LIKE 'ASISTEN%' OR
                      UPPER(A.NAMA) LIKE 'SUPERVISOR%'                         
                    )
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function selectByParamsJabatanHasilRapat($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT A.JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, B.JABATAN_ID JABATAN_ID_HASIL_RAPAT
				FROM JABATAN A LEFT JOIN HASIL_RAPAT_JABATAN B ON A.JABATAN_ID = B.JABATAN_ID AND B.HASIL_RAPAT_ID = '".$reqId."'
				WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TO_NUMBER(KELAS, '9999') ASC, A.JABATAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJabatanDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT A.JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, B.JABATAN_ID JABATAN_ID_DOKUMEN
				FROM JABATAN A LEFT JOIN pds_hukum.DOKUMEN_JABATAN B ON A.JABATAN_ID = B.JABATAN_ID 
				";
				if($reqId == ""){}
				else
				{
				$str .="
				AND B.DOKUMEN_ID = '".$reqId."'
				";
				}
				$str .="
				WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TO_NUMBER(KELAS, '9999') ASC, A.JABATAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KELAS
				  FROM JABATAN
				 WHERE 1 = 1 AND KELOMPOK IN ('D', 'K') 
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."GROUP BY KELAS  ORDER BY TO_NUMBER(KELAS, '9999') ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT JABATAN_ID, NAMA, KELAS
				  FROM JABATAN A
				 WHERE 1 = 1 
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, AMBIL_STATUS_CHEKLIST(STATUS) STATUS_NAMA, AMBIL_STATUS_KELOMPOK_JABATAN(KELOMPOK) KELOMPOK
				FROM JABATAN
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
	
	function selectByParamsJumlah($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA", $groupBy="GROUP BY A.NAMA,  A.JABATAN_ID")
	{
		$str = "SELECT A.JABATAN_ID, A.NAMA, COUNT(1) AS TOTAL FROM JABATAN A
		INNER JOIN LOWONGAN B ON B.JABATAN_ID=A.JABATAN_ID AND B.STATUS = 1 AND B.STATUS_SELESAI = 0
		WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." ".$groupBy." ".$order;	
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
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM JABATAN A
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParamsKandidatJabatan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.JABATAN_ID) ROWCOUNT
				FROM JABATAN A
				LEFT JOIN PEGAWAI_JABATAN_TERAKHIR B  ON A.JABATAN_ID = B.JABATAN_ID AND EXISTS(SELECT 1 FROM PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID IN (1, 5))
				LEFT JOIN PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1 AND A.KELOMPOK = 'D' AND A.KELAS BETWEEN 5 AND 9 
                AND (
                      UPPER(A.NAMA) LIKE 'MANAGER%' OR
                      UPPER(A.NAMA) LIKE 'KEPALA%' OR
                      UPPER(A.NAMA) LIKE 'ASISTEN%' OR
                      UPPER(A.NAMA) LIKE 'SUPERVISOR%'                         
                    ) ".$statement; 
		
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
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
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