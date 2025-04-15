<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class ViewDblink extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function ViewDblink()
	{
      parent::__construct(); 
    }
	

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParamsPendidikan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PENDIDIKAN_ID ASC ")
	{
		$str = "
				  SELECT PENDIDIKAN_ID, NAMA, KETERANGAN, KODE, CREATED_BY, CREATED_DATE, 
					       UPDATED_BY, UPDATED_DATE, URUT
					  FROM PENDIDIKAN A
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

    function selectByParamsPermintaan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PERMINTAAN_ID ASC ")
	{
		$str = "
				  SELECT A.PERMINTAAN_ID, (B.NAMA) NAMA_PERUSAHAAN, A.KODE_PROJECT, A.NAMA, A.KETERANGAN,(C.NAMA) NAMA_PERUSAHAAN_CABANG, (D.NAMA) 
				  NAMA_KATEGORI_PEGAWAI
					FROM PERMINTAAN A 
					LEFT JOIN PERUSAHAAN B ON A.PERUSAHAAN_ID = B.PERUSAHAAN_ID
					LEFT JOIN PERUSAHAAN_CABANG C ON A.PERUSAHAAN_CABANG_ID = C.PERUSAHAAN_CABANG_ID AND A.PERUSAHAAN_ID = C.PERUSAHAAN_ID 
					LEFT JOIN KATEGORI_PEGAWAI D ON  A.KATEGORI_PEGAWAI_ID = D.KATEGORI_PEGAWAI_ID
					LEFT JOIN PERMINTAAN_KEBUTUHAN E ON A.PERMINTAAN_ID = E.PERMINTAAN_ID
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

    function selectByParamsMonitoringPermohonan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PERMOHONAN_ID ASC ")
	{
		$str = "
				  SELECT KATEGORI, PERMOHONAN_ID, KODE_PROJECT, NAMA, KETERANGAN, NAMA_PERUSAHAAN, 
				       NAMA_PERUSAHAAN_CABANG, NAMA_KATEGORI_PEGAWAI, NAMA_JABATAN, 
				       JUMLAH_KEBUTUHAN, TANGGAL_PENEMPATAN, DEADLINE, LOWONGAN_ID,
				       STATUS_LOWONGAN
				  FROM MONITORING_PERMOHONAN
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
	
	function selectByParamsPermintaanJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY  PERUSAHAAN_JABATAN_ID ASC ")
	{
		$str = "
					SELECT PERMINTAAN_KEBUTUHAN_ID, PERMINTAAN_ID, A.PERUSAHAAN_ID, A.PERUSAHAAN_JABATAN_ID, 
					       PENEMPATAN, NAMA_JABATAN, JAM_KERJA, JUMLAH_KEBUTUHAN, TANGGAL_PENEMPATAN, 
					       PENDIDIKAN, PENDIDIKAN_JURUSAN, USIA, USIA_TMT, JENIS_KELAMIN, 
					       DEADLINE, STATUS_SELESAI, A.CREATED_BY, A.CREATED_DATE, 
					       A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_JABATAN_PERMINTAAN
					  FROM PERMINTAAN_KEBUTUHAN A 
					LEFT JOIN PERUSAHAAN_JABATAN B ON A.PERUSAHAAN_JABATAN_ID = B.PERUSAHAAN_JABATAN_ID
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

	function selectByParamsProjectJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY  PERUSAHAAN_JABATAN_ID ASC ")
	{
		$str = "
					SELECT PROJECT_KEBUTUHAN_ID, PROJECT_ID, A.PERUSAHAAN_ID, A.PERUSAHAAN_JABATAN_ID, 
					       PENEMPATAN, NAMA_JABATAN, JAM_KERJA, JUMLAH_KEBUTUHAN, TANGGAL_PENEMPATAN, 
					       PENDIDIKAN, PENDIDIKAN_JURUSAN, USIA, USIA_TMT, JENIS_KELAMIN, 
					       DEADLINE, STATUS_SELESAI, A.CREATED_BY, A.CREATED_DATE, 
					       A.UPDATED_BY, A.UPDATED_DATE, B.NAMA NAMA_JABATAN_PERMINTAAN
					  FROM PROJECT_KEBUTUHAN A 
					LEFT JOIN PERUSAHAAN_JABATAN B ON A.PERUSAHAAN_JABATAN_ID = B.PERUSAHAAN_JABATAN_ID
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
	
	function selectByParamsPermintaanPersyaratan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY PERUSAHAAN_JABATAN_ID ASC ")
	{
		$str = "
				SELECT PERMINTAAN_PERSYARATAN_ID, PERMINTAAN_ID, PERUSAHAAN_JABATAN_ID, 
				       SYARAT NAMA, CREATED_BY, CREATED_DATE, UPDATED_BY, 
				       UPDATED_DATE
				  FROM PERMINTAAN_PERSYARATAN A
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

	function selectByParamsProjectPersyaratan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="  ")
	{
		$str = "
				SELECT PROJECT_KEBUTUHAN_ID, 
				       SYARAT NAMA, CREATED_BY, CREATED_DATE, UPDATED_BY, 
				       UPDATED_DATE
				  FROM PROJECT_KEBUTUHAN_PERSYARATAN A
				  WHERE 1 = 1
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;
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
		$str = "SELECT COUNT(JURUSAN_ID) AS ROWCOUNT FROM JURUSAN A
		        WHERE JURUSAN_ID IS NOT NULL ".$statement; 
		
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
 
    function getCountByParamsPermintaan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PERMINTAAN_ID) AS ROWCOUNT 
				FROM PERMINTAAN A 
				LEFT JOIN PERUSAHAAN B ON A.PERUSAHAAN_ID = B.PERUSAHAAN_ID
				LEFT JOIN PERUSAHAAN_CABANG C ON A.PERUSAHAAN_CABANG_ID = C.PERUSAHAAN_CABANG_ID AND A.PERUSAHAAN_ID = C.PERUSAHAAN_ID 
				LEFT JOIN KATEGORI_PEGAWAI D ON  A.KATEGORI_PEGAWAI_ID = D.KATEGORI_PEGAWAI_ID
				LEFT JOIN PERMINTAAN_KEBUTUHAN E ON A.PERMINTAAN_ID = E.PERMINTAAN_ID
		        WHERE A.PERMINTAAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMonitoringPermohonan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM MONITORING_PERMOHONAN
				  WHERE 1 = 1"; 
		
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