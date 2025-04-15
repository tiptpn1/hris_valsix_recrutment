<?


  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_sertifikat.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarSertifikat extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarSertifikat()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_SERTIFIKAT_ID", $this->getSeqId("PELAMAR_SERTIFIKAT_ID","pelamar_sertifikat"));

		$str = "
					INSERT INTO pelamar_sertifikat (
					   PELAMAR_SERTIFIKAT_ID, NAMA, PELAMAR_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT, KETERANGAN, CREATED_BY, CREATED_DATE, SERTIFIKAT_ID,
						 LAMPIRAN)
 			  	VALUES (
				  ".$this->getField("PELAMAR_SERTIFIKAT_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PELAMAR_ID")."',
				  ".$this->getField("TANGGAL_TERBIT").",
				  ".$this->getField("TANGGAL_KADALUARSA").",
				  '".$this->getField("GROUP_SERTIFIKAT")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				  ".$this->getField("SERTIFIKAT_ID").",
				  '".$this->getField("LAMPIRAN")."'
				)";
		$this->id=$this->getField("PELAMAR_SERTIFIKAT_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_sertifikat
				SET
				   NAMA= '".$this->getField("NAMA")."',
				   TANGGAL_TERBIT= ".$this->getField("TANGGAL_TERBIT").",
				   TANGGAL_KADALUARSA= ".$this->getField("TANGGAL_KADALUARSA").",
				   GROUP_SERTIFIKAT= '".$this->getField("GROUP_SERTIFIKAT")."',
				   KETERANGAN= '".$this->getField("KETERANGAN")."',
				   UPDATED_BY= '".$this->getField("UPDATED_BY")."',
				   UPDATED_DATE= ".$this->getField("UPDATED_DATE").",
				   SERTIFIKAT_ID= ".$this->getField("SERTIFIKAT_ID").",
				   LAMPIRAN= '".$this->getField("LAMPIRAN")."'
				WHERE PELAMAR_SERTIFIKAT_ID= '".$this->getField("PELAMAR_SERTIFIKAT_ID")."'

			 ";
		$this->query = $str;
		return $this->execQuery($str);

    }

	function delete()
	{
        $str = "DELETE FROM pelamar_sertifikat
                WHERE
                  PELAMAR_SERTIFIKAT_ID= ".$this->getField("PELAMAR_SERTIFIKAT_ID")." AND
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' ";


		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_SERTIFIKAT_ID_GEN", $this->getSeqId("PELAMAR_SERTIFIKAT_ID","pelamar_sertifikat"));

		$str = "
				INSERT INTO pelamar_sertifikat (
				   PELAMAR_SERTIFIKAT_ID, NAMA, PELAMAR_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT, KETERANGAN, CREATED_BY, CREATED_DATE)
				SELECT ".$this->getField("PELAMAR_SERTIFIKAT_ID_GEN")." PELAMAR_SERTIFIKAT_ID, NAMA, PELAMAR_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT, KETERANGAN, CREATED_BY, CREATED_DATE
				FROM pelamar_sertifikat WHERE PELAMAR_SERTIFIKAT_ID = ".$this->getField("PELAMAR_SERTIFIKAT_ID")."";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_SERTIFIKAT_ID");

		if($this->execQuery($str))
		{
			$str = "DELETE FROM pelamar_sertifikat
					WHERE
					  PELAMAR_SERTIFIKAT_ID = ".$this->getField("PELAMAR_SERTIFIKAT_ID")."";
			return $this->execQuery($str);
		}
    }

	function tolak()
	{
        $str = "DELETE FROM pelamar_sertifikat
                WHERE
                  PELAMAR_SERTIFIKAT_ID = ".$this->getField("PELAMAR_SERTIFIKAT_ID")."";

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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
					SELECT
					PELAMAR_SERTIFIKAT_ID, PELAMAR_ID,
					CASE
						WHEN A.NAMA IS NULL THEN B.NAMA
						ELSE A.NAMA
					END NAMA, A.KETERANGAN, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT, A.SERTIFIKAT_ID, A.SERTIFIKAT,
					A.LAMPIRAN
					FROM pelamar_sertifikat A
					LEFT JOIN SERTIFIKAT B ON B.SERTIFIKAT_ID = A.SERTIFIKAT_ID
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
					PELAMAR_SERTIFIKAT_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT,A.LAMPIRAN
					FROM pelamar_sertifikat A
					UNION
					SELECT 'Master' STATUS,
					PELAMAR_SERTIFIKAT_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT,A.LAMPIRAN
					FROM pelamar_sertifikat A
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
					PELAMAR_SERTIFIKAT_ID, PELAMAR_ID, SERTIFIKAT_PELAMAR_ID,LAMPIRAN
					FROM pelamar_sertifikat A WHERE PELAMAR_SERTIFIKAT_ID IS NOT NULL
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
		$str = "SELECT COUNT(PELAMAR_SERTIFIKAT_ID) AS ROWCOUNT FROM pelamar_sertifikat
		        WHERE PELAMAR_SERTIFIKAT_ID IS NOT NULL ".$statement;

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
		$str = "SELECT COUNT(PELAMAR_SERTIFIKAT_ID) AS ROWCOUNT FROM pelamar_sertifikat
		        WHERE PELAMAR_SERTIFIKAT_ID IS NOT NULL ".$statement;
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