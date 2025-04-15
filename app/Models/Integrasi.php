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

class Integrasi extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Integrasi()
	{
      parent::__construct(); 
    }
	
    function selectByParamsPelamar($statement="", $tahun="")
	{
		$str = "
				SELECT A.BULAN, COALESCE(JUMLAH, 0) JUMLAH  FROM
                (SELECT ROW_NUMBER() OVER () AS BULAN
                           FROM PEGAWAI
                         LIMIT 12) A
                LEFT JOIN 
                (
                SELECT TO_CHAR(C.CREATED_DATE, 'MM') BULAN, COUNT(1) JUMLAH
                FROM PELAMAR C
                WHERE 1=1 AND TO_CHAR(C.CREATED_DATE, 'YYYY') = '".$tahun."'
                GROUP BY TO_CHAR(C.CREATED_DATE, 'MM')
                ) B ON A.BULAN = B.BULAN
				"; 
		
		
		$str .= " ORDER BY BULAN ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsPeserta($statement="", $tahun="")
	{
		$str = "
				SELECT A.BULAN, COALESCE(JUMLAH, 0) JUMLAH  FROM
                (SELECT ROW_NUMBER() OVER () AS BULAN
                           FROM PEGAWAI
                         LIMIT 12) A
                LEFT JOIN 
                (
                SELECT TO_CHAR(C.TANGGAL_KIRIM, 'MM') BULAN, COUNT(1) JUMLAH
                FROM PELAMAR_LOWONGAN C
                WHERE 1=1 AND TO_CHAR(C.TANGGAL_KIRIM, 'YYYY') = '".$tahun."'
                GROUP BY TO_CHAR(C.TANGGAL_KIRIM, 'MM')
                ) B ON A.BULAN = B.BULAN
				"; 
		
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsPelamarPosisi($statement="", $tahun="")
	{
		$str = "
				SELECT X.NAMA NAMA_JABATAN, COALESCE(JUMLAH, 0) JUMLAH  FROM
                (
				SELECT NAMA FROM LOWONGAN A
					INNER JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
				GROUP BY NAMA
				) X
                LEFT JOIN 
                (
                SELECT NAMA, COUNT(1) JUMLAH FROM LOWONGAN C 
				INNER JOIN JABATAN D ON D.JABATAN_ID = C.JABATAN_ID
				INNER JOIN PELAMAR_LOWONGAN E ON E.LOWONGAN_ID = C.LOWONGAN_ID AND E.TANGGAL_KIRIM IS NOT NULL
                WHERE 1=1 AND TO_CHAR(C.TANGGAL, 'YYYY') = '".$tahun."'
                GROUP BY NAMA
                ) Y ON X.NAMA = Y.NAMA
                ORDER BY X.NAMA
				"; 
		
		
		$str .= "  ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

	function getCountByParamsPelamarPosisi($statement="", $tahun="")
	{
		$str = "SELECT
					SUM (1) JUMLAH
				FROM
					LOWONGAN A
				INNER JOIN JABATAN B ON B.JABATAN_ID = A.JABATAN_ID
				INNER JOIN PELAMAR_LOWONGAN C ON C.LOWONGAN_ID = A.LOWONGAN_ID
				AND C.TANGGAL_KIRIM IS NOT NULL
				WHERE
					1 = 1
				AND TO_CHAR(A .TANGGAL, 'YYYY') = '".$tahun."'
				".$statement;
		
		$this->select($str);
		$this->query = $str; 
	
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
			
    function selectByParamsVisitor($statement="", $tahun="")
	{
		$str = "SELECT A.BULAN, COALESCE(JUMLAH, 0) JUMLAH  FROM
                (SELECT ROW_NUMBER() OVER () AS BULAN
                           FROM PEGAWAI
                         LIMIT 12) A
                LEFT JOIN 
                (
                SELECT TO_CHAR(C.TANGGAL, 'MM') BULAN, sum(HITS) JUMLAH
                FROM visitor C
                WHERE 1=1 AND TO_CHAR(C.TANGGAL, 'YYYY') = '".$tahun."'
                GROUP BY TO_CHAR(C.TANGGAL, 'MM')
                ) B ON A.BULAN = B.BULAN
				"; 
		
		
		$str .= " ORDER BY BULAN ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsPendidikan($statement)
	{
		$str = "SELECT A.PENDIDIKAN_ID, NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
				FROM PENDIDIKAN A 
				LEFT JOIN (
									SELECT  B.PENDIDIKAN_ID, C.KATEGORI, COUNT(1) JUMLAH
									FROM PEGAWAI A 
									LEFT JOIN (SELECT PEGAWAI_ID, PENDIDIKAN_ID FROM PEGAWAI_PENDIDIKAN) B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
									LEFT JOIN PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
									WHERE 1 = 1 ".$statement."
									GROUP BY B.PENDIDIKAN_ID, C.KATEGORI
								) B ON A.PENDIDIKAN_ID = B.PENDIDIKAN_ID
				WHERE A.PENDIDIKAN_ID IS NOT NULL 
			GROUP BY A.PENDIDIKAN_ID, NAMA	   
				"; 
		
		
		$str .= " ORDER BY A.PENDIDIKAN_ID ASC ";
		$this->query = $str;
		
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsUsia($statement)
	{
		$str = "
			SELECT '30' IDKETERANGAN, '<= 30' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA < 31 ".$statement."
								GROUP BY KATEGORI
							) Y   
			UNION ALL				
			SELECT '3135' IDKETERANGAN, '31 - 35' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 31 AND B.USIA < 36 ".$statement."
								GROUP BY KATEGORI
							) Y     
			UNION ALL				
			SELECT '3640' IDKETERANGAN, '36 - 40' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 36 AND B.USIA < 41 ".$statement."
								GROUP BY KATEGORI
							) Y   
			UNION ALL				
			SELECT '4145' IDKETERANGAN, '41 - 45' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 41 AND B.USIA < 46 ".$statement."
								GROUP BY KATEGORI
							) Y    
			UNION ALL				
			SELECT '4650' IDKETERANGAN, '46 - 50' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 46 AND B.USIA <= 50 ".$statement."
								GROUP BY KATEGORI
							) Y     
			UNION ALL		
			SELECT '50' IDKETERANGAN, '> 50' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KATEGORI = 'PS' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'OPS' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN KATEGORI = 'PBR' THEN JUMLAH END), 0) JUMLAH_PBR,
				COALESCE(SUM(CASE WHEN COALESCE(KATEGORI, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KATEGORI, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, REPLACE(AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE), ',', '.') AS USIA, KATEGORI
										FROM PEGAWAI  X LEFT JOIN PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE 1 = 1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA > 50 ".$statement."
								GROUP BY KATEGORI
							) Y      	   
				"; 
		
		
		$str .= "  ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsJenisPegawai($statement)
	{
		$str = "SELECT A.JENIS_PEGAWAI_ID, NAMA, COALESCE(JUMLAH, 0) JUMLAH, COALESCE(JUMLAH, 0) / 100 JUMLAH_PER_100
				FROM JENIS_PEGAWAI  A 
				LEFT JOIN (
									SELECT  B.JENIS_PEGAWAI_ID, COUNT(1) JUMLAH
									FROM PEGAWAI A LEFT JOIN (SELECT PEGAWAI_ID, JENIS_PEGAWAI_ID, TMT_JENIS_PEGAWAI FROM PEGAWAI_JENIS_PEGAWAI_TERAKHIR) B
									ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE 1 = 1  ".$statement."
									GROUP BY B.JENIS_PEGAWAI_ID
								) B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
				WHERE A.JENIS_PEGAWAI_ID IS NOT NULL AND A.NAMA IS NOT NULL    
				"; 
		
		
		$str .= " ORDER BY A.JENIS_PEGAWAI_ID ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
		
  } 
?>