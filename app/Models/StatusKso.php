<?php
namespace App\Models;
use App\Models\Entity;

class StatusKso extends Entity
{

    var $query;
	var $id;
    /**
     * Class constructor.
     **/
    function StatusKso()
    {
        parent::__construct();
    }

    function insertDataData()
    {
        /*Auto-generate primary key(s) by next max value (integer) */
        $this->setField("STATUS_KSO_ID", $this->getSeqId("STATUS_KSO_ID", "status_kso"));
        $str = "INSERT INTO status_kso(
                    STATUS_KSO_ID, KODE, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE)
                    VALUES (
				  " . $this->getField("STATUS_KSO_ID") . ",
				  '" . $this->getField("KODE") . "',
				  '" . $this->getField("NAMA") . "',
				  '" . $this->getField("KETERANGAN") . "',
				  '" . $this->getField("CREATED_BY") . "',
				  CURRENT_TIMESTAMP
				)";
        $this->id = $this->getField("STATUS_KSO_ID");
        $this->query = $str;
        // echo $str;
        // exit;
        return $this->execQuery($str);
    }

    function updateData()
    {
        $str = "UPDATE status_kso
				SET    
					NAMA = '" . $this->getField("NAMA") . "',
					KETERANGAN = '" . $this->getField("KETERANGAN") . "',
					UPDATED_BY = '" . $this->getField("UPDATED_BY") . "',
					UPDATED_DATE = CURRENT_TIMESTAMP
				WHERE  STATUS_KSO_ID = " . $this->getField("STATUS_KSO_ID") . "
			 ";
        $this->query = $str;
        // echo $str;
        // exit;
        return $this->execQuery($str);
    }

    function delete()
    {
        $str = "DELETE FROM status_kso
                WHERE 
                STATUS_KSO_ID = '" . $this->getField("STATUS_KSO_ID") . "'
			";
        $this->query = $str;
        // echo $str;
        // exit;
        return $this->execQuery($str);
    }

    /** 
     * Cari record berdasarkan array parameter dan limit tampilan 
     * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
     * @param int limit Jumlah maksimal record yang akan diambil 
     * @param int from Awal record yang diambil 
     * @return boolean True jika sukses, false jika tidak 
     **/
    function selectByParams($paramsArray = array(), $limit = -1, $from = -1, $statement = "", $order = "order by STATUS_KSO_ID asc")
    {
        $str = " SELECT STATUS_KSO_ID, KODE, NAMA, KETERANGAN, CREATED_BY, CREATED_DATE, UPDATED_BY, UPDATED_DATE
                FROM status_kso A
				WHERE 1 = 1
			";
        foreach ($paramsArray as $key => $val) {
            $str .= " AND $key = '$val' ";
        }

        $str .= $statement . " " . $order;
        $this->query = $str;
        // echo $str;
        // exit;
        return $this->selectLimit($str, $limit, $from);
    }

    /** 
     * Hitung jumlah record berdasarkan parameter (array). 
     * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
     * @return long Jumlah record yang sesuai kriteria 
     **/
    function getCountByParams($paramsArray = array(), $statement = "")
    {
        $str = "SELECT COUNT(STATUS_KSO_ID) AS ROWCOUNT FROM status_kso A
		        WHERE STATUS_KSO_ID IS NOT NULL " . $statement;

        foreach ($paramsArray as $key => $val) {
            $str .= " AND $key = '$val' ";
        }

        $this->select($str);
        $this->query = $str;
        if ($this->firstRow())
            return $this->getField("ROWCOUNT");
        else
            return 0;
    }

}
