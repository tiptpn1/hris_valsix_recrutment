<? 

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Content extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Content()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTEN_ID", $this->getSeqId("KONTEN_ID","KONTEN")); 
		
		$str = "INSERT INTO KONTEN(KONTEN_ID, PARENT_KONTEN_ID, URUT, NAMA, KETERANGAN, ISI, STATUS_CONTENT_MENU, STATUS_LOCKED) 
				VALUES(
				  ".$this->getField("KONTEN_ID").",
				  ".$this->getField("PARENT_KONTEN_ID").",
				  ".$this->getField("URUT").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("ISI")."',
				  ".$this->getField("STATUS_CONTENT_MENU").",
				  ".$this->getField("STATUS_LOCKED")."
				)"; 
				
		$this->id = $this->getField("KONTEN_ID");		
		$this->query = $str;
		return $this->execQuery($str);
    }

	function update_file()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE KONTEN SET
				  LINK_URL = '".$this->getField("LINK_URL")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				$this->query = $str;
				//echo $str;
		return $this->execQuery($str);
    }

    function updateINA()
	{
		$str = "UPDATE KONTEN SET
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateEN()
	{
		$str = "UPDATE KONTEN SET
				  DESCRIPTION = '".$this->getField("DESCRIPTION")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }	
	
	function updateContent()
	{
		$str = "UPDATE KONTEN SET
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE KONTEN_ID = '".$this->getField("KONTEN_ID")."'
				"; 
				
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
	}
	
	function updateStatusContentMenu($KONTEN_ID, $value)
	{
		$str = "UPDATE KONTEN SET
				  STATUS_CONTENT_MENU = '".$value."'
				WHERE KONTEN_ID = '".$KONTEN_ID."'
				"; 
				
		$this->query = $str;
		return $this->execQuery($str);
	}
	
	function updateUrut($KONTEN_ID, $value)
	{
		$str = "UPDATE KONTEN SET
				  URUT = '".$value."'
				WHERE KONTEN_ID = '".$KONTEN_ID."'
				"; 
				
		$this->query = $str;
		return $this->execQuery($str);
	}
	
	function delete()
	{
        $str = "DELETE FROM KONTEN
                WHERE 
                  KONTEN_ID = '".$this->getField("KONTEN_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT KONTEN_ID, PARENT_KONTEN_ID, URUT, NAMA, KETERANGAN, ISI, LINK_URL, STATUS_CONTENT_MENU, STATUS_LOCKED, DESCRIPTION, NAME
				FROM KONTEN WHERE KONTEN_ID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = $val ";
		}
		$this->query = $str;
		$str .= " ORDER BY URUT ASC, NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPage($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT A.KONTEN_ID, A.PARENT_KONTEN_ID, A.URUT, A.NAMA, A.KETERANGAN, A.ISI, A.LINK_URL, A.STATUS_CONTENT_MENU, A.STATUS_LOCKED, A.DESCRIPTION, A.NAME
				FROM KONTEN A INNER JOIN MENU B ON A.KONTEN_ID = B.KONTEN_ID WHERE 1 = 1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= " ORDER BY A.URUT ASC, A.NAMA ASC";
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "SELECT KONTEN_ID, PARENT_KONTEN_ID, URUT, NAMA, KETERANGAN, ISI, LINK_URL, STATUS_CONTENT_MENU, STATUS_LOCKED
				FROM KONTEN WHERE KONTEN_ID IS NOT NULL"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY URUT ASC, NAMA ASC";
				
		return $this->selectLimit($str,$limit,$from);
    }	
   
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(KONTEN_ID) AS ROWCOUNT FROM KONTEN WHERE KONTEN_ID IS NOT NULL "; 
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

    function getMenuCaption($link_web)
	{
		$str = "SELECT NAMA_MENU  FROM MENU WHERE 1 = 1 AND LINK_WEB = '".$link_web."' "; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("NAMA_MENU"); 
		else 
			return ""; 
    }
	
    function getMenuCaptionEnglish($link_web)
	{
		$str = "SELECT NAMA_MENU_EN FROM MENU WHERE 1 = 1 AND LINK_WEB = '".$link_web."' "; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("NAMA_MENU_EN"); 
		else 
			return ""; 
    }	

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(KONTEN_ID) AS ROWCOUNT FROM KONTEN WHERE KONTEN_ID IS NOT NULL "; 
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
	
	function getContentTitle($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		return $this->getField('NAMA');
	}

	function getContentTitleEnglish($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		
		return $this->getField('NAME');
	}
		
	function getContentText($pg)
	{
		$this->selectByParamsPage(array('LINK_WEB' => $pg));
		$this->firstRow();
		
		return $this->getField('KETERANGAN');
	}

	function getContentTextEnglish($pg)
	{
		$this->selectByParamsPage(array('LINK_WEB' => $pg));
		$this->firstRow();
		if($this->getField('DESCRIPTION') == "")
			return $this->getField('KETERANGAN'); 
		else
			return $this->getField('DESCRIPTION');
	}
	
	function getContent($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		
		return $this->getField('ISI');
	}

	function getLinkUrl($varKONTEN_ID)
	{
		$this->selectByParams(array('KONTEN_ID' => $varKONTEN_ID));
		$this->firstRow();
		
		return $this->getField('LINK_URL');
	}
		
  } 
?>