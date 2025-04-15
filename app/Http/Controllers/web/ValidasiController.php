<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use KDatabase;
use App\Models\Pelamar;
use App\Models\Lowongan;

class ValidasiController extends Controller 
{

    protected $TABLE_NAME = "validasi";


    public function route_web()
    {        
        Route::post('validasi_json/ktp', [ValidasiController::class, 'ktp'])->middleware('guest');

    }

        
    public function ktp(Request $request)
    {
            $reqKtp = $request->reqKtp;
            $reqId = $request->reqId;
            
            $pelamar = new Pelamar();
            $lowongan = new Lowongan();
            
            $reqId = $lowongan->getId(array("MD5(A.LOWONGAN_ID)" => $reqId));
            
            $pelamar->selectByParams(array(), -1, -1, " AND KTP_NO = '" . $reqKtp . "'");
            $pelamar->firstRow();
            
            $validasi = 0;
            $pesan	  = "NIK sudah terdaftar.";
            
            if($pelamar->getField("KTP_NO") == "")
            {	
                $request->session()->put('NIK_DAFTAR', $reqKtp);
                $request->session()->put('LOWONGAN_DAFTAR', $reqId);
                $validasi = 1;
                $pesan	  = "success";
            }
            
            $arrFinal = array("KTP" => (string)$pelamar->getField("KTP_NO"),
                            "VALIDASI" => $validasi,
                            "PESAN" => $pesan);
            
            echo json_encode($arrFinal);
    }
        
}
