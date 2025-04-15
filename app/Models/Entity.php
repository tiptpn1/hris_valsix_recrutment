<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use stdClass;

class Entity extends User
{
	var $records;
	var $record;
	var $recordIndex;
	var $currentRow;
    var $rowResult=array();
	var $currentRowIndex;

	protected $dateFormat = 'D d M H:i:s.u Y';

	public function __construct()
	{
		$this->recordIndex = 0;
		$this->record = new stdClass();
		$this->records = array();
	}

    public function getTable()
    {
        $class = get_class($this);
        $tables = explode("\_", strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class)));
        $table = $tables[count($tables) - 1];
        return $table;
    }

	public function getNextId($primaryKey, $table)
	{
		$sql = "SELECT MAX($primaryKey::numeric) AS JUMLAH FROM $table ";
		$jumlah = DB::select($sql)[0]->jumlah;
		return $jumlah + 1;
	}

	public function getSeqId($primaryKey, $table)
	{
		
		$sequenceCode = strtolower($table)."_seq";

		$sql = "SELECT GetSequenceVal('$sequenceCode', 1) AS jumlah  ";
		$jumlah = DB::select($sql)[0]->jumlah;
		return $jumlah;
	}

	
	public function getSequenceId($primaryKey, $table)
	{
		
		$sequenceCode = strtolower($table)."_id";

		$sql = "SELECT GetSequenceVal('$sequenceCode', 1) AS jumlah  ";
		$jumlah = DB::select($sql)[0]->jumlah;
		return $jumlah;
	}

	public function getToken($idPegawai,$filter=""){
			$sql = "SELECT MD5(CONCAT('".$idPegawai."', 't0k333naPl1K4si1!@#$!', DATE_FORMAT(CURRENT_TIMESTAMP, '%d%m%Y%T'))) AS jumlah  ";
			if($filter != "")
			$sql = $sql . " WHERE $filter";		

			$jumlah = DB::select($sql)[0]->jumlah;
			return $jumlah;
	}
	

	public function getIdAttribute($value)
	{
		return $this->{$this->primaryKey};
	}

	public function execQuery($sql)
	{
		try {
				
			$sql = ($sql);
			$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
			$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);
			$sql = str_replace("%y-%m-%d", "%Y-%m-%d", $sql);
			
			$result = DB::select($sql);
			return true;
        } catch (\Illuminate\Database\QueryException $e) {
			echo $sql;
			dd($e);
            return false;
        }
	}

	public function select($sql)
	{
		$sql = strtolower($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);
		$sql = str_replace("%y-%m-%d", "%Y-%m-%d", $sql);

		$this->records = DB::select(($sql));
		$this->recordIndex = 0;
		return $this->records;
	}

	public function selectNoLower($sql)
	{

		$this->records = DB::select(($sql));
		$this->recordIndex = 0;
		return $this->records;
	}


	public function selectLimit($sql, $numrow = -1, $offset = -1)
	{
		if ($numrow > 0) {
			$sql .= " LIMIT $numrow";
		}
		if ($offset > 0) {
			$sql .= " OFFSET $offset";
		}

		$sql = strtolower($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);


		$this->records = DB::select($sql);

		
		$this->recordIndex = 0;
		$this->currentRowIndex = -1;
		return $this->records;
	}

	
	public function selectLimitNoLower($sql, $numrow = -1, $offset = -1)
	{
		if ($numrow > 0) {
			$sql .= " LIMIT $numrow";
		}
		if ($offset > 0) {
			$sql .= " OFFSET $offset";
		}

		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);


		$this->records = DB::select($sql);

		
		$this->recordIndex = 0;
		$this->currentRowIndex = -1;
		return $this->records;
	}


	public function getField($column)
	{
		if (property_exists($this->record, strtolower($column))) {

			return $this->record->{strtolower($column)};
		}
		return null;
	}

	public function setField($column, $value)
	{
		$this->record->{strtolower($column)} = $value;
	}

	public function firstRow()
	{
		if (isset($this->records[$this->recordIndex])) {
			$this->record = $this->records[$this->recordIndex];
			foreach ($this->record as $key => $value) {
				$this->{strtolower($key)} = $value;
			}
			$this->recordIndex++;
			return true;
		} else {
			return false;
		}
	}

	public function nextRow()
	{
		if (isset($this->records[$this->recordIndex])) {
			$this->record = $this->records[$this->recordIndex];

			$this->currentRow = json_decode(json_encode($this->record), true);

			foreach ($this->record as $key => $value) {
				$this->{strtolower($key)} = $value;
			}
			$this->recordIndex++;
			return true;
		} else {
			return false;
		}
	}

	public function toArray()
	{
		$record = [];
		$record = array_map(function ($value) {
			return (array)$value;
		}, $this->records);

		return $record;

	}
}
