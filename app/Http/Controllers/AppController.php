<?php

namespace App\Http\Controllers;
error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use KAuth;
use KMail;
use KDatabase;
use ProsesDokumen;


class AppController extends Controller
{
    public function route_web()
    {
        Route::get('/', [AppController::class, 'index'])->middleware('guest');
        Route::get('/app/index/{pg}', [AppController::class, 'index'])->middleware('auth');
        Route::get('/app/index/{pg}/{reqParse1}', [AppController::class, 'index'])->middleware('auth');
        Route::post('/app/index/{pg}', [AppController::class, 'index'])->middleware('auth');
        Route::post('/app/index/{pg}/{reqParse1}', [AppController::class, 'index'])->middleware('auth');
        Route::get('/app/index', [AppController::class, 'index'])->middleware('guest');
        Route::get('/app/tesmail', [AppController::class, 'tesmail'])->middleware('guest');
        Route::get('/app/coba', [AppController::class, 'coba'])->middleware('guest');
        Route::get('/app/loadUrl/{reqFolder}/{reqFilename}', [AppController::class, 'loadUrl']);
        Route::get('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}', [AppController::class, 'loadUrl']);
        Route::get('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}', [AppController::class, 'loadUrl']);
        Route::get('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}/{reqParse3}', [AppController::class, 'loadUrl']);

        
        Route::post('/app/loadUrl/{reqFolder}/{reqFilename}', [AppController::class, 'loadUrl']);
        Route::post('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}', [AppController::class, 'loadUrl']);
        Route::post('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}', [AppController::class, 'loadUrl']);
        Route::post('/app/loadUrl/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}/{reqParse3}', [AppController::class, 'loadUrl']);

        
        Route::get('/app/loadEntri/{reqFolder}/{reqFilename}', [AppController::class, 'loadEntri']);
        Route::get('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}', [AppController::class, 'loadEntri']);
        Route::get('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}', [AppController::class, 'loadEntri']);
        Route::get('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}/{reqParse3}', [AppController::class, 'loadEntri']);


        Route::post('/app/loadEntri/{reqFolder}/{reqFilename}', [AppController::class, 'loadEntri']);
        Route::post('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}', [AppController::class, 'loadEntri']);
        Route::post('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}', [AppController::class, 'loadEntri']);
        Route::post('/app/loadEntri/{reqFolder}/{reqFilename}/{reqParse1}/{reqParse2}/{reqParse3}', [AppController::class, 'loadEntri']);

        Route::post('/app/ubah_password', [AppController::class, 'ubah_password'])->middleware('guest');
        Route::get('/app', [AppController::class, 'index'])->middleware('guest');
    }

    
	function ubah_password(Request $request)
	{

		$reqPassword = $request->reqPassword;

		$sql = " UPDATE user_login SET USER_PASSWORD = md5('$reqPassword') WHERE USER_LOGIN_ID = '".$this->UID."' ";
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

        
        if (!view()->exists('main/'.$pg)) 
            return view('error_404');

        if($pg == "home" && !empty($auth->PELAMAR_ID))
        {
            $pg = "daftar_lowongan";
        }
        
		$sub_data = array(
			'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
            'reqParse1' => $reqParse1,
            "MD5KEY" => $MD5KEY,
            "auth" => $auth
		);	
        $data = [
            'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
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

    public function registrasi(Request $request, $pg = "register", $reqParse1="")
    {

        $MD5KEY  = config("app.md5key");
        $auth    = KAuth::getIdentity();

        
        if (!view()->exists('main/'.$pg)) 
            return view('error_404');

        $NIK_DAFTAR = $request->session()->get('NIK_DAFTAR');


		$sub_data = array(
			'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
            'NIK_DAFTAR' => $NIK_DAFTAR,
            "MD5KEY" => $MD5KEY,
            "auth" => $auth
		);	
        $data = [
            'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
            'content' => view("main/".$pg, $sub_data),
            "pesan" => "",
            "auth" => $auth,
            "request" => $request,
            "data" => $sub_data,
            "MD5KEY" => $MD5KEY,
            'NIK_DAFTAR' => $NIK_DAFTAR,
        ];

        $index = "index";
        
        if (view()->exists('main/'.$index)) {
            return view('main/'.$index, $data);
        } else {
            return view('error_404');
        }


    }

    public function loadUrl(Request $request, $reqFolder, $reqFilename, $reqParse1="", $reqParse2="", $reqParse3="")
    {

        $MD5KEY  = config("app.md5key");
        $auth    = KAuth::getIdentity();
        $data = [
            "reqParse1" => $reqParse1,
            "reqParse2" => $reqParse2,
            "reqParse3" => $reqParse3,
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

    public function loadEntri(Request $request, $reqFolder, $reqFilename, $reqParse1="", $reqParse2="", $reqParse3="")
    {

        $MD5KEY  = config("app.md5key");
        $auth    = KAuth::getIdentity();

        if(empty($auth->UID))
        {
            return view('error_restrict');
        }
        
		$sub_data = array(
            'reqFolder' => $reqFolder,
            'reqFilename' => $reqFilename,
            'reqParse1' =>$reqParse1,
            'reqParse2' => $reqParse2,
            'reqParse3' =>$reqParse3,
            'auth' =>$auth
		);	

        $data = [
            'content' => view("main/".$reqFilename, $sub_data),
            "pesan" => "",
            "auth" => $auth,
            "request" => $request,
            "data" => $sub_data,
            "MD5KEY" => $MD5KEY,
            'reqParse1' =>$reqParse1,
            'reqParse2' => $reqParse2,
            'reqParse3' =>$reqParse3
        ];


        if (view()->exists($reqFolder . '/' . $reqFilename)) {
            return view($reqFolder . '/wrapper', $data);
        } else {
            return view('error_404');
        }
    }


}
