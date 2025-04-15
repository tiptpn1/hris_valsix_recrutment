<?


  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  //include_once("$INDEX_ROOT/$INDEX_SUB/src/valsix/WEB-INF/classes/db/Entity.php");

class Laporan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Laporan()
	{
      parent::__construct(); 
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParamsRekapHasilSeleksi($arrKategori, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PELAMAR_ID DESC")
	{
		$str = "SELECT A.LOWONGAN_ID, A.PELAMAR_ID, NRP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				       TANGGAL_LAHIR, PENDIDIKAN_TERAKHIR, AMBIL_PELAMAR_SERTIF_N_FORMAT
			   ";
		for($i=0;$i<count($arrKategori);$i++)
		{
		$str .= "
				       , MAX(CASE WHEN B.LOWONGAN_KATEGORI_KRITERIA_ID = '".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."' THEN C.NAMA ELSE NULL END) REKOMENDASI_".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."
				       , MAX(CASE WHEN B.LOWONGAN_KATEGORI_KRITERIA_ID = '".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."' THEN COALESCE(ROUND((BOBOT * (PROSENTASE / 100)), 2), 0) ELSE NULL END) NILAI_".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."
				       , MAX(CASE WHEN B.LOWONGAN_KATEGORI_KRITERIA_ID = '".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."' THEN B.CATATAN ELSE NULL END) CATATAN_".$arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"]."
			     ";																																
		}
		
		$str .= "
				  ,
				  CASE 
					WHEN E.DITERIMA = '0' THEN 'Tidak Lolos Seleksi'
				    WHEN E.DITERIMA = '1' THEN 'Lolos Seleksi'
				    ELSE ''
				  END KETERANGAN
				  FROM REKAP_TAHAPAN_SELEKSI A
				  LEFT JOIN PELAMAR_KATEGORI_LOLOS B ON A.LOWONGAN_ID = B.LOWONGAN_ID AND A.PELAMAR_ID = B.PELAMAR_ID
				  LEFT JOIN REKOMENDASI C ON C.REKOMENDASI_ID = B.REKOMENDASI_ID
				  LEFT JOIN LOWONGAN_KATEGORI_KRITERIA D ON B.LOWONGAN_KATEGORI_KRITERIA_ID = D.LOWONGAN_KATEGORI_KRITERIA_ID
				  LEFT JOIN PELAMAR_LOWONGAN_DITERIMA E ON A.PELAMAR_ID = E.PELAMAR_ID AND A.LOWONGAN_ID = E.LOWONGAN_ID
				 WHERE 1=1  
			  "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}		
		$str .= $statement." 
		GROUP BY A.LOWONGAN_ID, A.PELAMAR_ID, NRP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				       TANGGAL_LAHIR, PENDIDIKAN_TERAKHIR, AMBIL_PELAMAR_SERTIF_N_FORMAT, E.DITERIMA
		".$order;
		$this->query = $str;		
			
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsRekapHasilRekrutmen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL DESC")
	{
		$str = "SELECT LOWONGAN_ID, PELAMAR_ID, NRP, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, 
				       TANGGAL_LAHIR
				  FROM REKAP_HASIL_REKRUTMEN
				 WHERE 1=1 "; 
		
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
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM LOWONGAN A WHERE 1=1 ".$statement; 
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