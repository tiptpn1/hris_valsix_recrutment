<? 


  /***
  * Entity-base class untuk mengimplementasikan tabel MENU.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Menu extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Menu()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO MENU (
					   MENU_ID, MENU_PARENT_ID, MENU_GROUP_ID, NAMA, KETERANGAN, LINK_FILE)
 			  	VALUES (
				  ".$this->getField("MENU_ID").",
				  '".$this->getField("MENU_PARENT_ID")."',
				  '".$this->getField("MENU_GROUP_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LINK_FILE")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		$str = "
				UPDATE MENU
				SET    
					   MENU_PARENT_ID   = '".$this->getField("MENU_PARENT_ID")."',
					   MENU_GROUP_ID    = '".$this->getField("MENU_GROUP_ID")."',
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN       = '".$this->getField("KETERANGAN")."',
					   LINK_FILE        = '".$this->getField("LINK_FILE")."'
				WHERE  MENU_ID  		= '".$this->getField("MENU_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM MENU
                WHERE 
                  MENU_ID = ".$this->getField("MENU_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $akses_adm_intranet_id="", $table="", $order="ORDER BY A.MENU_ID ASC")
	{
		$str = "
                SELECT 
				A.MENU_ID, MENU_PARENT_ID, MENU_GROUP_ID, A.NAMA MENU, KETERANGAN, LINK_FILE, COALESCE(B.AKSES, 'A') AKSES, C.NAMA 
				FROM MENU A 
                LEFT JOIN ".$table."_MENU B ON A.MENU_ID = B.MENU_ID AND B.".$table."_ID = '".$akses_adm_intranet_id."' 
                LEFT JOIN ".$table." C ON C.".$table."_ID = '".$akses_adm_intranet_id."' 
                WHERE A.MENU_ID IS NOT NULL 
				"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsMenu($group_id, $akses_id, $table_prefix, $statement = "", $order="ORDER BY URUT, A.MENU_ID ASC")
	{
		$str = "
				SELECT A.MENU_ID, NAMA, LINK_FILE, AKSES,
				(SELECT COUNT(".$table_prefix."_ID) FROM ".$table_prefix."_MENU X WHERE SUBSTR(X.MENU_ID, 1, 2) = A.MENU_ID AND ".$table_prefix."_ID = ".$akses_id.") JUMLAH_MENU, 
				(SELECT COUNT(".$table_prefix."_ID) FROM ".$table_prefix."_MENU X WHERE SUBSTR(X.MENU_ID, 1, 2) = A.MENU_ID AND ".$table_prefix."_ID = ".$akses_id." AND AKSES = 'D') JUMLAH_DISABLE 				
				FROM MENU  A
				LEFT JOIN ".$table_prefix."_MENU B ON A.MENU_ID = B.MENU_ID AND ".$table_prefix."_ID = ".$akses_id."
				WHERE MENU_GROUP_ID = ".$group_id."
			    "; 
		
		$str .= $statement."  ".$order;
	
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }	

	function selectByParamsMenuSub($group_id, $akses_id, $table_prefix, $statement = "", $order="ORDER BY URUT, A.MENU_ID ASC")
	{
		$str = "
				SELECT A.MENU_ID, NAMA, COALESCE(LINK_FILE, '#') LINK_FILE, AKSES,
				(SELECT COUNT(MENU_ID) FROM MENU X WHERE X.MENU_PARENT_ID = A.MENU_ID AND EXISTS (SELECT 1 FROM ".$table_prefix."_MENU Y WHERE ".$table_prefix."_ID = ".$akses_id." AND Y.MENU_ID = X.MENU_ID)) JUMLAH_MENU, 
				(SELECT COUNT(MENU_ID) FROM MENU X WHERE X.MENU_PARENT_ID = A.MENU_ID AND EXISTS (SELECT 1 FROM ".$table_prefix."_MENU Y WHERE ".$table_prefix."_ID = ".$akses_id." AND Y.MENU_ID = X.MENU_ID AND AKSES = 'D')) JUMLAH_DISABLE 				
				FROM MENU  A
				LEFT JOIN ".$table_prefix."_MENU B ON A.MENU_ID = B.MENU_ID AND ".$table_prefix."_ID = ".$akses_id."
				WHERE MENU_GROUP_ID = ".$group_id."
			    "; 
		
		$this->query = $str;
		$str .= $statement."  ".$order;
		
		return $this->selectLimit($str,-1,-1); 
    }	


	function selectByParamsMenuByPass($group_id, $akses_id, $table_prefix, $statement = "", $order="ORDER BY A.MENU_ID ASC")
	{
		$str = "
				 SELECT A.MENU_ID, NAMA, LINK_FILE, 'A' AKSES, 10 JUMLAH_MENU, 0 JUMLAH_DISABLE
				 FROM MENU  A
				 WHERE MENU_GROUP_ID = ".$group_id."
			    "; 
		
		$this->query = $str;
		$str .= $statement."  ".$order;
		//echo $str;
		return $this->selectLimit($str,-1,-1); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				MENU_ID, MENU_PARENT_ID, MENU_GROUP_ID, NAMA, KETERANGAN, LINK_FILE
				FROM MENU A WHERE MENU_ID IS NOT NULL
			    "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY MENU_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MENU_ID) AS ROWCOUNT FROM MENU WHERE MENU_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(MENU_ID) AS ROWCOUNT FROM MENU WHERE MENU_ID IS NOT NULL ".$statement; 
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