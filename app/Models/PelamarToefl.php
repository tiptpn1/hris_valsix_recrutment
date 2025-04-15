<?
  /***
  * Entity-base class untuk mengimplementasikan tabel pelamar_toefl.
  *
  ***/
namespace App\Models;
use App\Models\Entity;

class PelamarToefl extends Entity{

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PelamarToefl()
	{
      parent::__construct();
    }

	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_TOEFL_ID", $this->getSeqId("PELAMAR_TOEFL_ID","pelamar_toefl"));

		$str = "
					INSERT INTO pelamar_toefl (
					   PELAMAR_TOEFL_ID, NAMA, PELAMAR_ID, SERTIFIKAT_ID, TANGGAL, KETERANGAN, NILAI, CREATED_BY, CREATED_DATE,LAMPIRAN)
 			  	VALUES (
				  ".$this->getField("PELAMAR_TOEFL_ID").",
				  AMBIL_TOEFL('".$this->getField("SERTIFIKAT_ID")."'),
				  '".$this->getField("PELAMAR_ID")."',
				  '".$this->getField("SERTIFIKAT_ID")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("NILAI")."',
				  '".$this->getField("CREATED_BY")."',
				  ".$this->getField("CREATED_DATE").",
				  '".$this->getField("LAMPIRAN")."'
				)";
		$this->id=$this->getField("PELAMAR_TOEFL_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE pelamar_toefl
				SET
				   SERTIFIKAT_ID = '".$this->getField("SERTIFIKAT_ID")."',
				   NAMA= AMBIL_TOEFL('".$this->getField("SERTIFIKAT_ID")."'),
				   TANGGAL= ".$this->getField("TANGGAL").",
				   KETERANGAN= '".$this->getField("KETERANGAN")."',
				   NILAI= '".$this->getField("NILAI")."',
				   UPDATED_BY= '".$this->getField("UPDATED_BY")."',
				   UPDATED_DATE= ".$this->getField("UPDATED_DATE").",
				   LAMPIRAN= '".$this->getField("LAMPIRAN")."'
				WHERE PELAMAR_TOEFL_ID= '".$this->getField("PELAMAR_TOEFL_ID")."'

			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM pelamar_toefl
                WHERE
                  PELAMAR_TOEFL_ID= ".$this->getField("PELAMAR_TOEFL_ID")." AND
				  PELAMAR_ID = '".$this->getField("PELAMAR_ID")."' ";

		$this->query = $str;
        return $this->execQuery($str);
    }

	function setuju()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELAMAR_TOEFL_ID_GEN", $this->getSeqId("PELAMAR_TOEFL_ID","pelamar_toefl"));

		$str = "
				INSERT INTO pelamar_toefl (
				   PELAMAR_TOEFL_ID, NAMA, PELAMAR_ID, TANGGAL, KETERANGAN, CREATED_BY, CREATED_DATE)
				SELECT ".$this->getField("PELAMAR_TOEFL_ID_GEN")." PELAMAR_TOEFL_ID, NAMA, PELAMAR_ID, TANGGAL, KETERANGAN, CREATED_BY, CREATED_DATE
				FROM pds_validasi.pelamar_toefl WHERE PELAMAR_TOEFL_ID = ".$this->getField("PELAMAR_TOEFL_ID")."";
		$this->query = $str;
		$this->id = $this->getField("PELAMAR_TOEFL_ID");

		if($this->execQuery($str))
		{
			$str = "DELETE FROM pds_validasi.pelamar_toefl
					WHERE
					  PELAMAR_TOEFL_ID = ".$this->getField("PELAMAR_TOEFL_ID")."";
			return $this->execQuery($str);
		}
    }

	function tolak()
	{
        $str = "DELETE FROM pds_validasi.pelamar_toefl
                WHERE
                  PELAMAR_TOEFL_ID = ".$this->getField("PELAMAR_TOEFL_ID")."";

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
                    PELAMAR_TOEFL_ID, PELAMAR_ID,
                    CASE
                        WHEN A.NAMA IS NOT NULL THEN A.NAMA
                        WHEN A.NAMA = '' THEN B.NAMA
                    END NAMA, A.KETERANGAN, TANGGAL, A.SERTIFIKAT_ID, NILAI, SKOR_MINIMAL, SKOR_MAKSIMAL,
										LAMPIRAN
                    FROM pelamar_toefl A
                    LEFT JOIN SERTIFIKAT_TOEFL B ON B.SERTIFIKAT_TOEFL_ID = A.SERTIFIKAT_ID
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
					PELAMAR_TOEFL_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL, NILAI
					FROM pds_validasi.pelamar_toefl A
					UNION
					SELECT 'Master' STATUS,
					PELAMAR_TOEFL_ID, PELAMAR_ID, NAMA, KETERANGAN, TANGGAL, NILAI
					FROM pelamar_toefl A
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
					PELAMAR_TOEFL_ID, PELAMAR_ID, SERTIFIKAT_PELAMAR_ID,LAMPIRAN
					FROM pelamar_toefl A WHERE PELAMAR_TOEFL_ID IS NOT NULL
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
		$str = "SELECT COUNT(PELAMAR_TOEFL_ID) AS ROWCOUNT FROM pelamar_toefl
		        WHERE PELAMAR_TOEFL_ID IS NOT NULL ".$statement;

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
		$str = "SELECT COUNT(PELAMAR_TOEFL_ID) AS ROWCOUNT FROM pelamar_toefl
		        WHERE PELAMAR_TOEFL_ID IS NOT NULL ".$statement;
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