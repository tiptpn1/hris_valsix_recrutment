<? 
/* *******************************************************************************************************
MODUL NAME      : E LEARNING
FILE NAME       : 
AUTHOR        : 
VERSION       : 1.0
MODIFICATION DOC  :
DESCRIPTION     : 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KontakPegawai.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;
  
class Users extends Entity{ 

  var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Users()
  {
      parent::__construct(); 
    }
  
  function selectByIdPassword($username,$password){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
    //$passwd = md5($passwd);
      
    $str = "SELECT A.USER_LOGIN_ID, A.KD_DIT, A.KD_SUBDIT, USER_LOGIN, A.NIP, A.NAMA, NAMA_POSISI JABATAN, A.USER_GROUP, A.USER_GROUP_ID, 
                  B.KD_DIT DIREKTORAT, B.SUB_UNIT SUBDIT FROM USER_APLIKASI A 
                LEFT JOIN PEGAWAI B ON A.NIP = B.NIK
                WHERE USER_LOGIN = '".$username."' ";
      $this->query = $str;
    // echo$str;exit(); AND USER_PASS = '".$password."' 
    return $this->select($str);     
    }
  
  
  function selectByPenilaiId($username,$periodeId){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
    //$passwd = md5($passwd);
      
    $str = "SELECT B.NIK USER_LOGIN_ID, B.KD_DIT, B.KD_SUBDIT, B.NIK USER_LOGIN, B.NIK NIP, B.NAME NAMA, B.NAMA_POSISI JABATAN, 'PENILAI' USER_GROUP, '3' USER_GROUP_ID, 
                  B.KD_DIT DIREKTORAT, B.SUB_UNIT SUBDIT FROM PEGAWAI B 
                WHERE B.NIK = '".$username."' AND  
                EXISTS(SELECT 1 FROM LOWONGAN_PENILAI_KRITERIA X INNER JOIN LOWONGAN Y ON X.LOWONGAN_ID = Y.LOWONGAN_ID WHERE X.PENILAI_ID = B.NIK AND Y.PERIODE_ID = '".$periodeId."' AND X.KODE_TAHAPAN = 'WAWANCARA') ";
      $this->query = $str;
  //  echo$str;exit();
    return $this->select($str);     
    }
  
  function selectByIdPasswordPelamar($id_usr,$passwd){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
    //$passwd = md5($passwd);

    if(!empty($passwd))
      $statement = " AND USER_PASS='".md5($passwd)."' ";

    $str = "
              SELECT USER_LOGIN_ID, NRP, A.PELAMAR_ID, A.NAMA, JABATAN, A.EMAIL, A.TELEPON, STATUS, USER_LOGIN, USER_PASS, KTP_NO, B.VERIFIKASI, B.OFFLINEE, B.AKTIVASI, B.KIRIM_LAMARAN,
                      B.STATUS_BLACKLIST
              FROM user_login A 
              INNER JOIN pelamar B ON A.PELAMAR_ID = B.PELAMAR_ID 
              WHERE 1 = 1 AND USER_LOGIN='".$id_usr."'  ".$statement; //AND B.AKTIVASI = '1' AND USER_PASS='".$passwd."' 
    //echo $str;exit;
      $this->query = $str;
    return $this->select($str);         
    }
  
  
  
  function selectByIdPasswordPelamarUjian($id_usr,$passwd){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
    //$passwd = md5($passwd);
    $str = "
      SELECT USER_LOGIN_ID, NRP, A.PELAMAR_ID, A.NAMA, JABATAN, A.EMAIL, A.TELEPON, STATUS, 
       USER_LOGIN, USER_PASS, KTP_NO, B.VERIFIKASI, B.OFFLINEE, C.LOWONGAN_ID, C.UJIAN_ID,
       C.TANGGAL_TES PEGAWAI_TANGGAL_AWAL, C.TANGGAL_TES_SELESAI PEGAWAI_TANGGAL_AKHIR, 
       C.UJIAN_PEGAWAI_DAFTAR_ID, C.AKTIF_UJIAN
    FROM USER_LOGIN A 
    INNER JOIN PELAMAR B ON A.PELAMAR_ID = B.PELAMAR_ID 
      LEFT JOIN
       (SELECT UJIAN_PEGAWAI_DAFTAR_ID, A.PEGAWAI_ID PELAMAR_ID,
               A.LOWONGAN_ID, A.UJIAN_ID,
               TO_CHAR (TANGGAL_AWAL, 'DD-MM-YYYY HH24:MI') TANGGAL_TES,
               TO_CHAR (TANGGAL_AKHIR,
                        'DD-MM-YYYY HH24:MI') TANGGAL_TES_SELESAI,
               CASE
                  WHEN current_timestamp BETWEEN TANGGAL_AWAL AND TANGGAL_AKHIR
                     THEN 1
                  ELSE 0
               END AKTIF_UJIAN
          FROM UJIAN_PEGAWAI_DAFTAR A INNER JOIN UJIAN B
               ON A.UJIAN_ID = B.UJIAN_ID
         WHERE 1 = 1) C ON A.PELAMAR_ID = C.PELAMAR_ID
    WHERE 1 = 1 AND USER_LOGIN='".$id_usr."' AND USER_PASS='".$passwd."'  "; //AND B.AKTIVASI = '1'
    //echo $str;exit;
      $this->query = $str;
    return $this->select($str);         
    }
  
  

  
  function selectByIdPasswordPelamarToken($id_usr, $MD5KEY){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
    //$passwd = md5($passwd);
    $str = "
    SELECT USER_LOGIN_ID, NRP, A.PELAMAR_ID, A.NAMA, JABATAN, A.EMAIL, A.TELEPON, STATUS, USER_LOGIN, USER_PASS, KTP_NO, B.VERIFIKASI, B.OFFLINEE, B.KIRIM_LAMARAN
    FROM user_login A 
    INNER JOIN pelamar B ON A.PELAMAR_ID = B.PELAMAR_ID 
    WHERE 1 = 1 AND md5(CONCAT(A.PELAMAR_ID , 'pelamar' , '$MD5KEY')) = '".$id_usr."' AND B.AKTIVASI = '1' ";
    //echo $str;exit;
      $this->query = $str;
    return $this->select($str);         
    }
  

  } 
?>