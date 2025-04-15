<?


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_pengalaman.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarPengalaman extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPengalaman()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PENGALAMAN_ID", $this->getSeqId("PELAMAR_PENGALAMAN_ID","pelamar_pengalaman"));

		$str = "
				INSERT INTO pelamar_pengalaman (
				   PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI, TAHUN, DESKRIPSI, PRESTASI, TANGGAL_MASUK, TANGGAL_KELUAR,LAMPIRAN)
 			  	VALUES (
				  ".$this->getField("PELAMAR_PENGALAMAN_ID").",
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("JABATAN")."',
				  '".$this->getField("PERUSAHAAN")."',
				  '".$this->getField("DURASI")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("DESKRIPSI")."',
				  '".$this->getField("PRESTASI")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR").",
				  '".$this->getField("LAMPIRAN")."'
				)";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PENGALAMAN_ID");
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_pengalaman
				SET
					    PELAMAR_ID		= ".$this->getField("PELAMAR_ID").",
				        JABATAN     	= '".$this->getField("JABATAN")."',
				  		PERUSAHAAN		= '".$this->getField("PERUSAHAAN")."',
				  		DESKRIPSI		= '".$this->getField("DESKRIPSI")."',
				  		PRESTASI		= '".$this->getField("PRESTASI")."',
				  		DURASI			= '".$this->getField("DURASI")."',
				  		TAHUN 			= '".$this->getField("TAHUN")."',
				  		TANGGAL_MASUK	= ".$this->getField("TANGGAL_MASUK").",
				  		TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR").",
				  		LAMPIRAN	= '".$this->getField("LAMPIRAN")."'
				WHERE  PELAMAR_PENGALAMAN_ID = '".$this->getField("PELAMAR_PENGALAMAN_ID")."'

			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pelamar_pengalaman
                WHERE
                  PELAMAR_PENGALAMAN_ID = ".$this->getField("PELAMAR_PENGALAMAN_ID")." AND
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' ";


		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PENGALAMAN_ID_GEN", $this->getSeqId("PELAMAR_PENGALAMAN_ID","pelamar_pengalaman"));

		$str = "
				INSERT INTO pelamar_pengalaman (
				   PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI,
       				TANGGAL_MASUK, TAHUN)
				SELECT ".$this->getField("PELAMAR_PENGALAMAN_ID_GEN")." PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI,
       				TANGGAL_MASUK, TAHUN
				FROM pds_validasi.pelamar_pengalaman WHERE PELAMAR_PENGALAMAN_ID = ".$this->getField("PELAMAR_PENGALAMAN_ID")."";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PENGALAMAN_ID");

		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.pelamar_pengalaman
					WHERE
					  PELAMAR_PENGALAMAN_ID = ".$this->getField("PELAMAR_PENGALAMAN_ID")."";
			return $this->execQuery($str);
		}
    }

	function tolak()
	{
        $str = "DELETE FROM pds_validasi.pelamar_pengalaman
                WHERE
                  PELAMAR_PENGALAMAN_ID = ".$this->getField("PELAMAR_PENGALAMAN_ID")."";

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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, COALESCE(DURASI, '0') DURASI,
       			TANGGAL_MASUK, TANGGAL_KELUAR, COALESCE(TAHUN, '0') TAHUN, STATUS_GROUP,LAMPIRAN,
				DESKRIPSI, PRESTASI
				FROM pelamar_pengalaman
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

    function selectByParamsValidasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT * FROM
				(
				SELECT 'Validasi' STATUS, PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI,
       			TANGGAL_MASUK, TAHUN
				FROM pds_validasi.pelamar_pengalaman
				UNION
				SELECT 'Master' STATUS, PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI,
       			TANGGAL_MASUK, TAHUN
				FROM pelamar_pengalaman
				) A
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

	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT PELAMAR_PENGALAMAN_ID, PELAMAR_ID, JABATAN, PERUSAHAAN, DURASI,
       			TANGGAL_MASUK, TAHUN,LAMPIRAN
				FROM pelamar_pengalaman
				WHERE 1 = 1
			    ";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}

		$this->query = $str;
		$str .= $statement." ".$order;
		return $this->selectLimit($str,$limit,$from);
    }
    /**
    * Hitung jumlah record berdasarkan parameter (array).
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy")
    * @return long Jumlah record yang sesuai kriteria
    **/
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_PENGALAMAN_ID) AS ROWCOUNT FROM pelamar_pengalaman
		        WHERE PELAMAR_PENGALAMAN_ID IS NOT NULL ".$statement;

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
		$str = "SELECT COUNT(PELAMAR_PENGALAMAN_ID) AS ROWCOUNT FROM pelamar_pengalaman
		        WHERE PELAMAR_PENGALAMAN_ID IS NOT NULL ".$statement;
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