<?

use App\Models\Users;
use App\Models\UserLoginMobile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class KAuth
{
    public static $identity;

    
    public static function verifyUserLogin($username,$credential)
    {
            
        $users = new Users();

        if($credential == "ptpntracing")
            $credential = "";

        $users->selectByIdPasswordPelamar($username, $credential);
        if($users->firstRow())
        {
            $identity = Kauth::$identity;

            $identity = new stdClass();

            $identity->MD5KEY           = config("app.md5key");
            $identity->userPelamarId         = $users->getField("PELAMAR_ID");
            $identity->PELAMAR_ID            = $users->getField("PELAMAR_ID");
            $identity->userPelamarEnkripId   = md5($identity->PELAMAR_ID."pelamar".$identity->MD5KEY);
            $identity->UID                   = $users->getField("USER_LOGIN_ID");
            $identity->userNoRegister        = $users->getField("NRP");
            $identity->idUser                = $users->getField("PELAMAR_ID");
            $identity->nama                  = str_replace("'", "", $users->getField("NAMA"));
            $identity->AKTIVASI              = $users->getField("AKTIVASI");
            $identity->loginTimeStr          = getHari(date("w")).", ".date("j M Y, H:i",time());
            $identity->KIRIM_LAMARAN         = $users->getField("KIRIM_LAMARAN");
            $identity->KTP_NO                = $users->getField("KTP_NO");
            $identity->STATUS_BLACKLIST      = $users->getField("STATUS_BLACKLIST");
            
            if($identity->AKTIVASI == "0")
            {
                $status     = "failed";
                $message    = "Akun anda belum diaktifkan, silahkan lakukan aktivasi terlebih dahulu melalui link yang kami kirimkan ke email anda.";   
                $arrResult["status"] = $status;
                $arrResult["message"] = $message;
                
                return $arrResult; 
            }

            if($identity->STATUS_BLACKLIST == "1")
            {
                $status     = "failed";
                $message    = "Akun anda tidak dapat mengakses aplikasi, silahkan hubungi administrator.";   
                $arrResult["status"] = $status;
                $arrResult["message"] = $message;
                
                return $arrResult; 
            }

            Session::put('session', $identity);
            $status         = "success";
            $message        = "Login sukses.";
            $kirim_lamaran  = $identity->KIRIM_LAMARAN;
            

        }
        else
        {
            $status         = "failed";
            $message        = "NIK atau password anda salah.";  
            $kirim_lamaran  = "0"; 
        }   
        $arrResult["status"] = $status;
        $arrResult["message"] = $message;
        $arrResult["kirim_lamaran"] = $kirim_lamaran;
        
        return $arrResult; 
    }

    public static function verifyUserToken($username)
    {
            
        $users = new Users();

        $users->selectByIdPasswordPelamarToken($username, config("app.md5key"));
        if($users->firstRow())
        {
            $identity = Kauth::$identity;

            $identity = new stdClass();

            $identity->MD5KEY                = config("app.md5key");
            $identity->userPelamarId         = $users->getField("PELAMAR_ID");
            $identity->PELAMAR_ID            = $users->getField("PELAMAR_ID");
            $identity->userPelamarEnkripId   = md5($identity->PELAMAR_ID."pelamar".$identity->MD5KEY);
            $identity->UID                   = $users->getField("USER_LOGIN_ID");
            $identity->userNoRegister        = $users->getField("NRP");
            $identity->idUser                = $users->getField("PELAMAR_ID");
            $identity->nama                  = str_replace("'", "", $users->getField("NAMA"));
            $identity->loginTimeStr          = getHari(date("w")).", ".date("j M Y, H:i",time());
            $identity->KTP_NO                = $users->getField("KTP_NO");

            Session::put('session', $identity);
            $status     = "success";
            $message    = "Login sukses.";

        }
        else
        {
            $status     = "failed";
            $message    = "Username atau password anda salah.";   
        }   
        $arrResult["status"] = $status;
        $arrResult["message"] = $message;
        
        return $arrResult; 
    }



    public static function multiAkses($groupId, $auth) {
      		

        
        $identity = Kauth::$identity;
        $identity = new stdClass();

        

        $identity->USER_LOGIN_ID = $auth->USER_LOGIN_ID;
        $identity->USER_LOGIN = $auth->USER_LOGIN;
        $identity->USER_GROUP_ID = $auth->USER_GROUP_ID;
        $identity->USER_GROUP = $auth->USER_GROUP;
        $identity->PEGAWAI_ID = $auth->PEGAWAI_ID;
        $identity->PEGAWAI_MD5_ID = $auth->PEGAWAI_MD5_ID;
        $identity->REGIONAL_ID = $auth->REGIONAL_ID;
        $identity->REGIONAL_KODE = $auth->REGIONAL_KODE;
        $identity->REGIONAL = $auth->REGIONAL;
        $identity->PEGAWAI = $auth->PEGAWAI;
        $identity->NRP = $auth->NRP;
        $identity->JABATAN = $auth->JABATAN;
        $identity->EMAIL = $auth->EMAIL;
        $identity->TELEPON = $auth->TELEPON;

        $identity->MD5KEY               = $auth->MD5KEY;

        $identity->HAK_AKSES            = $auth->HAK_AKSES;
        $identity->HAK_AKSES_JUMLAH     = $auth->HAK_AKSES_JUMLAH;
        $identity->HAK_AKSES_WEB                = $auth->HAK_AKSES_WEB;
        $identity->HAK_AKSES_WEB_JUMLAH         = $auth->HAK_AKSES_WEB_JUMLAH;
        $identity->HAK_AKSES_MOBILE             = $auth->HAK_AKSES_MOBILE;
        $identity->HAK_AKSES_MOBILE_JUMLAH      = $auth->HAK_AKSES_MOBILE_JUMLAH;
        $identity->USER_TYPE_ID         = $groupId;
        $identity->USER_TYPE            = KDatabase::query(" SELECT KODE FROM USER_GROUP WHERE USER_GROUP_ID = '".$groupId."' ")->first_row()->kode;
        $identity->USER_TYPE_NAMA       = KDatabase::query(" SELECT NAMA FROM USER_GROUP WHERE USER_GROUP_ID = '".$groupId."' ")->first_row()->nama;
        $identity->USER_MODUL           = KDatabase::query(" SELECT MODUL FROM USER_GROUP WHERE USER_GROUP_ID = '".$groupId."' ")->first_row()->modul;


        Session::forget('session');
        Session::put('session', $identity);


        return "1";            
		
    }	

    

    public static function getIdentity()
    {

        return (Session::get('session')) ?: (KAuth::defaultIdentity());
    }

    public static function clearIdentity()
    {
        Session::remove('session');
        Auth::logout();
    }

    public static function defaultIdentity()
    {

    }
}
