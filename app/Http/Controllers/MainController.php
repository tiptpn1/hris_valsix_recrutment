<?php

namespace App\Http\Controllers;
error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use KAuth;
use KMail;
use KDatabase;


class MainController extends Controller
{
    public function route_web()
    {
        Route::get('/', [MainController::class, 'index'])->middleware('guest');
        Route::get('/main/index/{pg}', [MainController::class, 'index'])->middleware('auth');
        Route::get('/main/index/{pg}/{reqParse1}', [MainController::class, 'index'])->middleware('auth');
        Route::get('/main/index', [MainController::class, 'index'])->middleware('auth');
        Route::get('/main/tesmail', [MainController::class, 'tesmail'])->middleware('auth');
        Route::get('/main/dashboard_grafik', [MainController::class, 'dashboard_grafik'])->middleware('auth');
        Route::get('/main/loadUrl/{reqFolder}/{reqFilename}', [MainController::class, 'loadUrl']);
        Route::get('/main/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}', [MainController::class, 'loadUrl']);
        Route::get('/main/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}', [MainController::class, 'loadUrl']);
        Route::post('/main/ubah_password', [MainController::class, 'ubah_password'])->middleware('auth');
        Route::get('/main', [MainController::class, 'index'])->middleware('auth');
    }

    
	function ubah_password(Request $request)
	{

		$reqPassword = $request->reqPassword;

		$sql = " UPDATE user_login SET USER_PASSWORD = md5('$reqPassword') WHERE USER_LOGIN_ID = '".$this->USER_LOGIN_ID."' ";
		$sukses = KDatabase::exec($sql);

        if($sukses)
        {
			$arrResult["status"]  = "success";
			$arrResult["message"] = "Ubah password berhasil.";
			echo json_encode($arrResult);
		}
		else
		{
			$arrResult["status"]  = "failed";
			$arrResult["message"] = "Ubah password gagal.";
			echo json_encode($arrResult);
		}



	}


    public function index(Request $request, $pg = "home", $reqParse1="")
    {

        $MD5KEY  = config("app.md5key");
        $auth    = KAuth::getIdentity();

        if(empty($auth->USER_LOGIN_ID))
        {
            return redirect('login');
            
        }


        if ($auth) {
            foreach ($auth as $key => $value) {
                $auth->{strtolower($key)} = $value;
            }
        }

		
		$pg_monitoring = str_replace("_add_ttd", "", $pg);
		$pg_monitoring = str_replace("_add", "", $pg_monitoring);
		$pg_monitoring = str_replace("_revisi", "", $pg_monitoring);
		$pg_monitoring = str_replace("_kelola", "", $pg_monitoring);
		$pg_monitoring = str_replace("_import", "", $pg_monitoring);
		$pg_monitoring = str_replace("_lihat", "", $pg_monitoring);
		$pg_monitoring = str_replace("_detil", "", $pg_monitoring);
		$pg_monitoring = str_replace("_lampiran", "", $pg_monitoring);

		$pg_monitoring_nama = strtolower(str_replace("_", " ", $pg_monitoring));
		$pg_monitoring_nama = ucwords($pg_monitoring_nama);

        if (!view()->exists('main/'.$pg)) 
            return view('error_404');

        if(stristr($pg, "master_regional"))
        {
            if($this->USER_TYPE == "SUPER")
            {}
            else
                return redirect("main");
        }
		
        if(stristr($pg, "master_unit_kerja"))
        {
            if($this->USER_TYPE == "SUPER" || $this->USER_TYPE == "REGIONAL")
            {}
            else
                return redirect("main");
        }

		$sub_data = array(
			'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
			'pg_monitoring' => $pg_monitoring,
			'pg_monitoring_nama' => $pg_monitoring_nama,
            'reqParse1' => $reqParse1,
            "MD5KEY" => $MD5KEY,
            "auth" => $auth
		);	
        $data = [
            'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
			'pg_monitoring' => $pg_monitoring,
			'pg_monitoring_nama' => $pg_monitoring_nama,
            'content' => view("main/".$pg, $sub_data),
            "pesan" => "",
            "auth" => $auth,
            "request" => $request,
            "data" => $sub_data,
            "MD5KEY" => $MD5KEY,
            'reqParse1' => $reqParse1
        ];

        $index = "index";
        
        if (view()->exists('main/'.$index)) {
            return view('main/'.$index, $data);
        } else {
            return view('error_404');
        }


    }


    
    public function loadUrl(Request $request, $reqFolder, $reqFilename, $reqParse1="", $reqParse2="")
    {

        $MD5KEY  = config("app.md5key");
        
        $auth    = KAuth::getIdentity();
        $data = [
            "reqParse1" => $reqParse1,
            "reqParse2" => $reqParse2,
            "auth" => $auth,
            'request' => $request,
            "MD5KEY" => $MD5KEY,
            'mode' => '',
            'pesan' => '',
        ];
        if (view()->exists($reqFolder . '/' . $reqFilename)) {
            return view($reqFolder . '/' . $reqFilename, $data);
        } else {
            return view('error_404');
        }
    }

}
