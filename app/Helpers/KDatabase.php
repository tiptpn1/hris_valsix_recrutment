<?

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class KDatabase
{
    public static $rowResult;

    public static function exec($sql) {
        
        try {
            $result = DB::select($sql);
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            echo $sql;
            dd($e);
            return false;
        }
    }

    public static function query($sql) {
        
		$sql = strtolower($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);
        $sql = str_replace("%y-%m-%d", "%Y-%m-%d", $sql);

        try {
            self::$rowResult = DB::select($sql);
            return new static();
        } catch (\Illuminate\Database\QueryException $e) {
            // echo $sql;
            // dd($e);
            return false;
        }
    }

    public static function query2($sql) {
        
		$sql = ($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);
        $sql = str_replace("%y-%m-%d", "%Y-%m-%d", $sql);

        self::$rowResult = DB::select($sql);
        return new static();
    }

    
    
    public static function execRekrutmen($sql) {
        
        try {
            $result = DB::connection('rekrutmen')->select($sql);
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            echo $sql;
            dd($e);
            return false;
        }
    }

    
    public static function queryRekrutmen($sql) {
        
		$sql = strtolower($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);
        $sql = str_replace("%y-%m-%d", "%Y-%m-%d", $sql);

        try {
            self::$rowResult = DB::connection('rekrutmen')->select($sql);
            return new static();
        } catch (\Illuminate\Database\QueryException $e) {
            // echo $sql;
            // dd($e);
            return false;
        }
    }


    public static function first_row()
    {

        return self::$rowResult[0];
    }

    public static function result()
    {

        return self::$rowResult;
    }

    public static function row()
    {

        return self::$rowResult[0];
    }

    
    public static function result_array()
    {

        $rowResult =  self::$rowResult;
        $rowResult = json_decode(json_encode($rowResult), true);

        return $rowResult;
    }

    
    public static function row_array()
    {

        $rowResult =  self::$rowResult[0];
        $rowResult = json_decode(json_encode($rowResult), true);

        return $rowResult;
    }

}