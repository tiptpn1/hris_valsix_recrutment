<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: MenuBase.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel Menu implementation
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel Menu.
  * 
  * @author M Reza Faisal
  * @generated by Entity Generator 5.8.3
  * @generated on 20-Apr-2005,20:28
  ***/
namespace App\Models;
use App\Models\Entity;

class MenuBase extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    * @author M Reza Faisal
    **/
    function MenuBase(){
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
        showMessageDlg("Data menu tidak dapat di-insert",true);
      else{  				
        $str = "INSERT INTO menu 
                (id_menu,id_induk,nama_menu,caption,urut_menu,ket_menu,link,target,status_aktif) 
                VALUES(
                  '".$this->getField("id_menu")."',
                  '".$this->getField("id_induk")."',
                  '".$this->getField("nama_menu")."',
                  '".$this->getField("caption")."',
                  ".$this->getField("urut_menu").",
                  '".$this->getField("ket_menu")."',
                  '".$this->getField("link")."',
                  '".$this->getField("target")."',
				  '".$this->getField("status_aktif")."'
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
        showMessageDlg("Data menu tidak dapat diupdate",true);
      else{
        $str = "UPDATE menu 
                SET 
                  id_induk = '".$this->getField("id_induk")."',
                  nama_menu = '".$this->getField("nama_menu")."',
                  caption = '".$this->getField("caption")."',
                  urut_menu = ".$this->getField("urut_menu").",
                  ket_menu = '".$this->getField("ket_menu")."',
                  link = '".$this->getField("link")."',
                  target = '".$this->getField("target")."'
                WHERE 
                  id_menu = '".$this->getField("id_menu")."'"; 
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
        showMessageDlg("Data menu tidak dapat di-hapus",true);
      else{
        $str = "DELETE FROM menu 
                WHERE 
                  id_menu = '".$this->getField("id_menu")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cari record berdasarkan id-nya. 
    * @author M Reza Faisal
    * @param string id_menu Id record 
    * @return boolean True jika pencarian sukses, false jika tidak.
    **/
    function selectById($id_menu){
      $str = "SELECT * FROM menu
              WHERE 
                id_menu = '".$id_menu."'"; 
      return $this->select($str);
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
      $str = "SELECT * FROM menu WHERE id_menu IS NOT NULL "; 
      foreach ($paramsArray as $key => $val){
        $str .= " AND $key = '$val' ";
      }
      $str .= " ORDER BY urut_menu ASC, caption ASC";
	  $this->query = $str;
      return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @author M Reza Faisal
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array()){
      $str = "SELECT COUNT(id_menu) AS ROWCOUNT FROM menu WHERE id_menu IS NOT NULL "; 
      foreach ($paramsArray as $key => $val){
        $str .= " AND $key = '$val' ";
      }
      $this->select($str); 
      if($this->firstRow()) 
        return $this->getField("ROWCOUNT"); 
      else 
         return 0; 
    }
  } 
?>