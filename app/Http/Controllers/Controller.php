<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use KAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected $MD5KEY;
    protected $userPelamarId;
    protected $PELAMAR_ID;
    protected $userPelamarEnkripId;
    protected $UID ;
    protected $userNoRegister;
    protected $idUser;
    protected $nama;
    protected $NIP;
    protected $KTP_NO;
    protected $loginTimeStr;
    

	public function __construct(){
        
    
        $auth = KAuth::getIdentity();
    
        if($auth)
        {
            /* GLOBAL VARIABLE */
            $this->userPelamarId = $auth->userPelamarId;
            $this->PELAMAR_ID = $auth->PELAMAR_ID;
            $this->UID = $auth->UID;
            $this->userPelamarEnkripId = $auth->userPelamarEnkripId;
            $this->userNoRegister = $auth->userNoRegister;
            $this->idUser = $auth->idUser;
            $this->nama = $auth->nama;
            $this->NIP = $auth->PELAMAR_ID;
            $this->KTP_NO = $auth->KTP_NO;
            $this->loginTimeStr = $auth->loginTimeStr;
        }
        
        $this->MD5KEY = config("app.md5key");



	}	

}
