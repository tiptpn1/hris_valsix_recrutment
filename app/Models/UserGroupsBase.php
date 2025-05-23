<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: UserGroupsBase.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel usergroups implementation
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel usergroups.
  * 
  * @author M Reza Faisal
  * @generated by Entity Generator 5.8.3
  * @generated on 27-Apr-2005,14:15
  ***/
namespace App\Models;
use App\Models\Entity;

class UserGroupsBase extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    * @author M Reza Faisal
    **/
    function UserGroupsBase(){
      parent::__construct(); 
    }

    /**
    * Cek apakah operasi insert dapat dilakukan atau tidak 
    * @author M Reza Faisal
    * @return boolean True jika insert boleh dilakukan, false jika tidak.
    **/
    function canInsert(){
      return true;
    }

    /**
    * Insert record ke database. 
    * @author M Reza Faisal
    * @return boolean True jika insert sukses, false jika tidak.
    **/
    function insertData(){
      if(!$this->canInsert())
        showMessageDlg("Data UserGroups tidak dapat di-insert",true);
      else{			
		$str = "INSERT INTO usergroups 
                (UGID, NAMA) 
                VALUES(
				  '".$this->getField("UGID")."',
                  '".$this->getField("NAMA")."'
                )"; 
		$this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah operasi update dapat dilakukan atau tidak. 
    * @author M Reza Faisal
    * @return boolean True jika update dapat dilakukan, false jika tidak.
    **/
    function canUpdate(){
      return true;
    }

    /**
    * Update record. 
    * @author M Reza Faisal
    * @return boolean True jika update sukses, false jika tidak.
    **/
    function updateData(){
      if(!$this->canUpdate())
        showMessageDlg("Data usergroups tidak dapat diupdate",true);
      else{
        //$this->setField("PASSWORD", md5($this->getField("PASSWORD")."BAKWAN"));
		$str = "UPDATE usergroups 
                SET 
				  UGID = '".$this->getField("UGID")."',
                  NAMA = '".$this->getField("NAMA")."'
                WHERE 
                  UGID = '".$this->getField("tempUGID")."'"; 
				  $this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah record dapat dihapus atau tidak. 
    * @author M Reza Faisal
    * @return boolean True jika record dapat dihapus, false jika tidak.
    **/
    function canDelete(){
      return true;
    }

    /**
    * Menghapus record sesuai id-nya. 
    * @author M Reza Faisal
    * @return boolean True jika penghapusan sukses, false jika tidak.
    **/
    function delete(){
      if(!$this->canDelete())
        showMessageDlg("Data usergroups tidak dapat di-hapus",true);
      else{
        $str = "DELETE FROM usergroups 
                WHERE 
                  UGID = '".$this->getField("UGID")."'"; 
        return $this->execQuery($str);
      }
    }

    /**
    * Cari record berdasarkan id-nya. 
    * @author M Reza Faisal
    * @param string USER_NAME Id record 
    * @return boolean True jika pencarian sukses, false jika tidak.
    **/
    function selectById($UGID){
      $str = "SELECT * FROM usergroups
              WHERE 
                UGID = '".$UGID."'"; 
				
		$this->query = $str;
		
      $this->select($str);
	  if($this->firstRow()) 
        return true; 
      else 
         return false; 
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @author M Reza Faisal
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1){
      $str = "SELECT * FROM usergroups WHERE UGID IS NOT NULL "; 
      foreach ($paramsArray as $key => $val){
        $str .= " AND $key LIKE '%$val%' ";
      }
      $str .= " ORDER BY NAMA";
	  $this->query = $str;
      return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @author M Reza Faisal
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $varStatement=""){
      $str = "SELECT COUNT(UGID) AS ROWCOUNT FROM usergroups WHERE UGID IS NOT NULL ".$varStatement; 
      foreach ($paramsArray as $key => $val){
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