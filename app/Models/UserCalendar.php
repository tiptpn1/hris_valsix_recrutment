<? 
/* *******************************************************************************************************
MODUL NAME 			: E LEARNING
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KontakPegawai.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  
class UserCalendar extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function UserCalendar()
	{
      parent::__construct(); 
    }
	
    function getTokenGoogle($pegawaiId='')
    {
    	if($pegawaiId == ''){
    		return '';
    	}else{
    		$str = "SELECT TOKEN_GOOGLE FROM USER_CALENDAR 
		        WHERE USER_LOGIN_ID = '".$pegawaiId."'"; 
			
			$this->select($str); 
			if($this->firstRow()) 
				return $this->getField("TOKEN_GOOGLE"); 
			else 
				return null; 
    	}
    }

    function setTokenGoogle($pegawaiId='', $tokenGoogle='')
    {
    	$str = "
				DELETE FROM USER_CALENDAR
				WHERE  	USER_LOGIN_ID 			= '".$pegawaiId."'
			"; 
      $this->execQuery($str);


  		$str = "
  			INSERT INTO USER_CALENDAR ( USER_LOGIN_ID, TOKEN_GOOGLE )
  			VALUES ('".$pegawaiId."', '".$tokenGoogle."') 
  		"; 
  		return $this->execQuery($str);
    }

  } 
?>