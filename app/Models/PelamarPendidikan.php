<?


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_pendidikan.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarPendidikan extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPendidikan()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PENDIDIKAN_ID", $this->getSeqId("PELAMAR_PENDIDIKAN_ID","pelamar_pendidikan"));

		$str = "
				INSERT INTO pelamar_pendidikan (
				   PELAMAR_PENDIDIKAN_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, KOTA, LULUS,
				   TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH,
				   TANGGAL_ACC, JURUSAN, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID, CREATED_BY, CREATED_DATE,
				   JURUSAN_ID, IPK, JURUSAN_AKREDITASI,
					 LAMPIRAN_IJASAH,LAMPIRAN_TRANSKRIP,IS_SURAT_KETERANGAN,
					 INSTANSI
				   )
 			  	VALUES (
				  ".$this->getField("PELAMAR_PENDIDIKAN_ID").",
				  '".$this->getField("PENDIDIKAN_ID")."',
				  '".$this->getField("PELAMAR_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("LULUS")."',
				  ".$this->getField("TANGGAL_IJASAH").",
				  '".$this->getField("NO_IJASAH")."',
				  '".$this->getField("TTD_IJASAH")."',
				  ".$this->getField("TANGGAL_ACC").",
				  '".$this->getField("JURUSAN")."',
				  ".$this->getField("UNIVERSITAS_ID").",
				  ".$this->getField("PENDIDIKAN_BIAYA_ID").",
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				  ".$this->getField("JURUSAN_ID").",
				  '".$this->getField("IPK")."',
				  '".$this->getField("JURUSAN_AKREDITASI")."',
				  '".$this->getField("LAMPIRAN_IJASAH")."',
				  '".$this->getField("LAMPIRAN_TRANSKRIP")."',
				  '".$this->getField("IS_SURAT_KETERANGAN")."',
				  '".$this->getField("INSTANSI")."'
				)";
		$this->id = $this->getField("PELAMAR_PENDIDIKAN_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_pendidikan
				SET
					   PENDIDIKAN_ID           	= '".$this->getField("PENDIDIKAN_ID")."',
					   PELAMAR_ID      			= '".$this->getField("PELAMAR_ID")."',
					   NAMA    					= '".$this->getField("NAMA")."',
					   KOTA         			= '".$this->getField("KOTA")."',
					   LULUS					= '".$this->getField("LULUS")."',
					   TANGGAL_IJASAH			= ".$this->getField("TANGGAL_IJASAH").",
					   NO_IJASAH				= '".$this->getField("NO_IJASAH")."',
					   TTD_IJASAH				= '".$this->getField("TTD_IJASAH")."',
					   TANGGAL_ACC				= ".$this->getField("TANGGAL_ACC").",
					   JURUSAN					= '".$this->getField("JURUSAN")."',
					   UNIVERSITAS_ID			= ".$this->getField("UNIVERSITAS_ID").",
					   PENDIDIKAN_BIAYA_ID		= ".$this->getField("PENDIDIKAN_BIAYA_ID").",
					   UPDATED_BY			= '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE			= ".$this->getField("UPDATED_DATE").",
					   JURUSAN_ID				= ".$this->getField("JURUSAN_ID").",
					   IPK						= '".$this->getField("IPK")."',
					   JURUSAN_AKREDITASI		= '".$this->getField("JURUSAN_AKREDITASI")."',
					   LAMPIRAN_IJASAH		= '".$this->getField("LAMPIRAN_IJASAH")."',
					   LAMPIRAN_TRANSKRIP		= '".$this->getField("LAMPIRAN_TRANSKRIP")."',
					   IS_SURAT_KETERANGAN		= '".$this->getField("IS_SURAT_KETERANGAN")."',
					   INSTANSI				 	= '".$this->getField("INSTANSI")."'
				WHERE  PELAMAR_PENDIDIKAN_ID    = '".$this->getField("PELAMAR_PENDIDIKAN_ID")."'

			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pelamar_pendidikan
                WHERE
                  PELAMAR_PENDIDIKAN_ID = ".$this->getField("PELAMAR_PENDIDIKAN_ID")." AND
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' ";


		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PENDIDIKAN_ID_GEN", $this->getSeqId("PELAMAR_PENDIDIKAN_ID","pelamar_pendidikan"));

		$str = "
				INSERT INTO pelamar_pendidikan (
				   PELAMAR_PENDIDIKAN_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, KOTA, LULUS,
				   TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH,
				   TANGGAL_ACC, JURUSAN, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID, CREATED_BY, CREATED_DATE)
				SELECT ".$this->getField("PELAMAR_PENDIDIKAN_ID_GEN")." PELAMAR_PENDIDIKAN_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, KOTA, LULUS,
				   TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH,
				   TANGGAL_ACC, JURUSAN, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID, CREATED_BY, CREATED_DATE
				FROM pds_validasi.pelamar_pendidikan WHERE PELAMAR_PENDIDIKAN_ID = ".$this->getField("PELAMAR_PENDIDIKAN_ID")."";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PENDIDIKAN_ID");

		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.pelamar_pendidikan
					WHERE
					  PELAMAR_PENDIDIKAN_ID = ".$this->getField("PELAMAR_PENDIDIKAN_ID")."";
			return $this->execQuery($str);
		}
    }

	function tolak()
	{
        $str = "DELETE FROM pds_validasi.pelamar_pendidikan
                WHERE
                  PELAMAR_PENDIDIKAN_ID = ".$this->getField("PELAMAR_PENDIDIKAN_ID")."";

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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TANGGAL_IJASAH DESC ")
	{
		$str = "
				SELECT
                    PELAMAR_PENDIDIKAN_ID, A.PENDIDIKAN_ID, PELAMAR_ID, A.NAMA, KOTA, LULUS,
                    TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH, TANGGAL_ACC,LAMPIRAN_IJASAH,LAMPIRAN_TRANSKRIP,
                    CASE
                        WHEN A.JURUSAN IS NULL THEN E.NAMA
                        ELSE A.JURUSAN
                    END JURUSAN, A.UNIVERSITAS_ID, A.PENDIDIKAN_BIAYA_ID,
                    A.JURUSAN_ID, CASE WHEN A.INSTANSI = 'DALAM' THEN B.NAMA ELSE B.NAMA_EN END PENDIDIKAN_NAMA, C.NAMA UNIVERSITAS_NAMA, D.NAMA PENDIDIKAN_BIAYA_NAMA, IPK, A.JURUSAN_AKREDITASI,
                    A.INSTANSI,
                    A.IS_SURAT_KETERANGAN
                FROM pelamar_pendidikan A
                LEFT JOIN PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
                LEFT JOIN UNIVERSITAS C ON A.UNIVERSITAS_ID=C.UNIVERSITAS_ID
                LEFT JOIN PENDIDIKAN_BIAYA D ON A.PENDIDIKAN_BIAYA_ID=D.PENDIDIKAN_BIAYA_ID
                LEFT JOIN JURUSAN E ON A.JURUSAN_ID = E.JURUSAN_ID
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
				SELECT PELAMAR_PENDIDIKAN_ID, PENDIDIKAN_ID, PELAMAR_ID, NAMA, KOTA, LULUS,
				TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH, TANGGAL_ACC, JURUSAN, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID
				FROM pelamar_pendidikan
				WHERE 1 = 1
			    ";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}

		$this->query = $str;
		$str .= $statement." ORDER BY PENDIDIKAN_ID ASC";
		return $this->selectLimit($str,$limit,$from);
    }
    /**
    * Hitung jumlah record berdasarkan parameter (array).
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy")
    * @return long Jumlah record yang sesuai kriteria
    **/
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_PENDIDIKAN_ID) AS ROWCOUNT FROM pelamar_pendidikan
		        WHERE PELAMAR_PENDIDIKAN_ID IS NOT NULL ".$statement;

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
		$str = "SELECT COUNT(PELAMAR_PENDIDIKAN_ID) AS ROWCOUNT FROM pelamar_pendidikan
		        WHERE PELAMAR_PENDIDIKAN_ID IS NOT NULL ".$statement;
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