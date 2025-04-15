<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;
use App\Models\base\LoginLog;


use Illuminate\Support\Facades\Route;
use KAuth;

class LoginController extends Controller
{

    public function route_web()
    {
        Route::post('app/login', [LoginController::class, 'action'])->middleware('guest');
        Route::get('/app/logout', [LoginController::class, 'logout'])->middleware('guest');
        Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
        Route::get('/login/logout', [LoginController::class, 'logout'])->middleware('guest');
        Route::get('/login/getCapcha', [LoginController::class, 'getCapcha'])->middleware('guest');
        Route::get('/login/captcha', [LoginController::class, 'captcha'])->middleware('guest');
    }


	public function getCapcha(Request $request)
	{
		$CAPTCHA = $this->generateCaptcha(); 
		$request->session()->put('CAPTCHA', $CAPTCHA);
		echo $CAPTCHA;
	}

	function generateCaptcha()
	{
		$color = date("dmYHis").substr(uniqid(), -2);
		$captcha = strtoupper(substr(md5($color), 0, 5));
		return $captcha;
	}
	
	function captcha_dev()
	{
		session_start();
		$kode = $_GET["reqId"];
		$image = imagecreatefrompng("fonts/bg.png"); // Generating CAPTCHA

        $foreground = imagecolorallocate($image, 13, 86, 117); // Font Color
		$font = 'fonts/Raleway-Black.ttf';

		 // imagestring($image, 30, 35, 10,$kode , $foreground);
		imagettftext($image, 20, 0, 20, 30, $foreground, $font,$kode);

		// echo $_SESSION["capcha"];
		header('Content-type: image/png');
		imagepng($image);

		imagedestroy($image);

	}


	function captcha()
	{

		$kode=$_GET["reqId"];
		$image = imagecreatefrompng(public_path()."/fonts/bg.png"); // Generating CAPTCHA

        $foreground = imagecolorallocate($image, 13, 86, 117); // Font Color
		$font = public_path().'/fonts/Raleway-Black.ttf';


		 // imagestring($image, 30, 35, 10,$kode , $foreground);
		imagettftext($image, 20, 0, 20, 30, $foreground, $font,$kode);

		// echo $_SESSION["capcha"];
		header('Content-type: image/png');
		imagepng($image);

		imagedestroy($image);

	}


    public function index(Request $request, $pg = "home")
	{

		return redirect("app");
        
	}

    public function action(Request $request)
    {

		// echo 'esad';exit;
		//if submitted
		$reqUser = setQuote($request->reqUser);
		$reqPasswd = setQuote($request->reqPasswd);
		$reqCaptcha = $request->reqCaptcha;

		$valCaptcha = $request->session()->get('CAPTCHA');

		if ($valCaptcha != $reqCaptcha) 
		{
			$sub_data = array();	
			$data['content']= view("main/home", $sub_data);
			$data['pesan']= "Kode captcha yang anda masukkan salah.";
			return view('main/index', $data);
		}


		if(!empty($reqUser) AND !empty($reqPasswd))
		{

			$arrResult =  KAuth::verifyUserLogin($reqUser,$reqPasswd);
			
			if($arrResult["status"] == "success")
			{
				if($arrResult["kirim_lamaran"] == "0")
					return redirect('app/index/isian_formulir');
				else
					return redirect('main');
			}
			else
			{
				$sub_data = array();	
				$data['content']= view("main/home", $sub_data);
				$data['pesan']= $arrResult["message"];
				return view('main/index', $data);
			}
		}
		else
		{
			$data['pesan'] = "Masukkan username dan password.";
			return view('app/login', $data);
		}

    }

    public function multi(Request $request)
	{

		$USER_GROUP_ID = $request->USER_GROUP_ID;

		
        $auth    = KAuth::getIdentity();

		if (trim($auth->USER_TYPE) == "")
			redirect("main");


		$arrHakAkses = explode(",", $auth->HAK_AKSES);


		/* CHECK APAKAH ADA AKSES */
		$adaAkses = 0;
		for ($i = 0; $i < count($arrHakAkses); $i++) {
			if (trim($USER_GROUP_ID) == trim($arrHakAkses[$i]))
				$adaAkses = 1;
		}
		if ($adaAkses == 0)
			redirect("main");

		$respon = KAuth::multiAkses($USER_GROUP_ID, $auth);

		if ($respon == "1")
		{

			$auth    = KAuth::getIdentity();

			$USER_TYPE = $auth->USER_TYPE;
			
			return redirect('app');
			
		}

	}

	public function logout()
	{

		KAuth::clearIdentity();
		return redirect ('login');
		
	}
}