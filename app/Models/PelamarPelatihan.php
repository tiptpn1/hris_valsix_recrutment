<?


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_pelatihan.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarPelatihan extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarPelatihan()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PELATIHAN_ID", $this->getSeqId("PELAMAR_PELATIHAN_ID","pelamar_pelatihan"));

		$str = "
				INSERT INTO pelamar_pelatihan (
				   PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN,LAMPIRAN)
 			  	VALUES (
				  ".$this->getField("PELAMAR_PELATIHAN_ID").",
				  ".$this->getField("PELAMAR_ID").",
				  '".$this->getField("JENIS")."',
				  '".$this->getField("JUMLAH")."',
				  '".$this->getField("WAKTU")."',
				  '".$this->getField("PELATIH")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("LAMPIRAN")."'
				)";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PELATIHAN_ID");
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_pelatihan
				SET
					   PELAMAR_ID	= ".$this->getField("PELAMAR_ID").",
				  	   JENIS		= '".$this->getField("JENIS")."',
				       JUMLAH		= '".$this->getField("JUMLAH")."',
				  	   WAKTU		= '".$this->getField("WAKTU")."',
				  	   PELATIH		= '".$this->getField("PELATIH")."',
				  	   TAHUN		= '".$this->getField("TAHUN")."',
				  	   LAMPIRAN		= '".$this->getField("LAMPIRAN")."'
				WHERE  PELAMAR_PELATIHAN_ID     	= '".$this->getField("PELAMAR_PELATIHAN_ID")."'

			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pelamar_pelatihan
                WHERE
                  PELAMAR_PELATIHAN_ID = ".$this->getField("PELAMAR_PELATIHAN_ID")." AND
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' ";


		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_PELATIHAN_ID_GEN", $this->getSeqId("PELAMAR_PELATIHAN_ID","pelamar_pelatihan"));

		$str = "
				INSERT INTO pelamar_pelatihan (
				   PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN)
				SELECT ".$this->getField("PELAMAR_PELATIHAN_ID_GEN")." PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN
				FROM pds_validasi.pelamar_pelatihan WHERE PELAMAR_PELATIHAN_ID = ".$this->getField("PELAMAR_PELATIHAN_ID")."";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_PELATIHAN_ID");

		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.pelamar_pelatihan
					WHERE
					  PELAMAR_PELATIHAN_ID = ".$this->getField("PELAMAR_PELATIHAN_ID")."";
			return $this->execQuery($str);
		}
    }

	function tolak()
	{
        $str = "DELETE FROM pds_validasi.pelamar_pelatihan
                WHERE
                  PELAMAR_PELATIHAN_ID = ".$this->getField("PELAMAR_PELATIHAN_ID")."";

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
				SELECT PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN,LAMPIRAN
				FROM pelamar_pelatihan
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
				SELECT 'Validasi' STATUS, PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN
				FROM pds_validasi.pelamar_pelatihan
				UNION
				SELECT 'Master' STATUS, PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN
				FROM pelamar_pelatihan
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

	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PELAMAR_PELATIHAN_ID, PELAMAR_ID, JENIS, JUMLAH, WAKTU, PELATIH, TAHUN,LAMPIRAN
				FROM pelamar_pelatihan
				WHERE 1 = 1
			    ";

		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}

		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_AWAL DESC";
		return $this->selectLimit($str,$limit,$from);
    }
    /**
    * Hitung jumlah record berdasarkan parameter (array).
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy")
    * @return long Jumlah record yang sesuai kriteria
    **/
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELAMAR_PELATIHAN_ID) AS ROWCOUNT FROM pelamar_pelatihan
		        WHERE PELAMAR_PELATIHAN_ID IS NOT NULL ".$statement;

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
		$str = "SELECT COUNT(PELAMAR_PELATIHAN_ID) AS ROWCOUNT FROM pelamar_pelatihan
		        WHERE PELAMAR_PELATIHAN_ID IS NOT NULL ".$statement;
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