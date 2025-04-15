<?php 

use App\Models\ApprovalManager;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Config;



class usermobile extends PHPMailer{
	
    public static $rowResult;
	var $UID;
	var $pegawaiId;
	var $jabatan;
	var $cabang;
	var $perusahaanId;
	var $perusahaanCabangId;
	var $userPublish;			
	var $idUser;
	var $nama;
	var $perusahaan;
	var $userNRP;
	var $aksesDashboard;
	var $cabangP3Id;
	
    function __construct($exceptions = false)
    {
        parent::__construct($exceptions);

        $this->IsSMTP();
        $this->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $this->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $this->Host     = Config::get('app.email_Host');
        $this->Port     = Config::get('app.email_Port');
        $this->SMTPAuth = Config::get('app.email_SMTPAuth');   
        $this->Username = Config::get('app.email_Username');  
        $this->Password = Config::get('app.email_Password'); 

        $this->From     = Config::get('app.email_From');
        $this->FromName = Config::get('app.email_FromName');
		
        


        $this->WordWrap = 50;     
        $this->Priority = 1;
        $this->CharSet = "UTF-8";
        $this->IsHTML(TRUE);
        $this->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        
    }
	
    /******************** CONSTRUCTOR **************************************/
    function usermobile(){
	
    }

	
	function pushNotifikasi($reqApprovalId, $reqPegawaiId, $reqPegawai, $reqPermohonanId, $reqPermohonanNomor, $reqPermohonan, $reqTabel, $reqTabelKolom, $reqUrut=1, $sentEmail=true)
	{	
		if($reqApprovalId == "")
			return;
			

		
		$reqType = $reqPermohonan;
		$reqId = $reqPermohonanId;
		$reqJenis = $reqPermohonan;
		$reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
		$reqBody = $reqPegawai." Mengajukan ".$reqTitle." nomor ".$reqPermohonanNomor;
		
		
		$rowResult = $this->query(" SELECT nrp, nama, jabatan, email, telepon FROM PEGAWAI ")->first_row();
		$approvalTelepon = $rowResult->telepon;
		$approvalEmail   = $rowResult->email;
		$approvalNama    = $rowResult->nama;
		$approvalJabatan = $rowResult->jabatan;


		$statusAktif = ($sentEmail == true) ? "1" : "0";

		/* HIT KE PROSES APPROVAL */
		$approval_manager = new ApprovalManager();
		$approval_manager->setField("NOMOR", $reqPermohonanNomor);
		$approval_manager->setField("JUDUL", $reqPermohonan);
		$approval_manager->setField("TABEL", $reqTabel);
		$approval_manager->setField("TABEL_ID", $reqTabel."_ID");
		$approval_manager->setField("TABEL_APPROVAL_KOLOM", $reqTabelKolom);
		$approval_manager->setField("PEGAWAI_ID", $reqPegawaiId);
		$approval_manager->setField("PEGAWAI_APPROVAL_ID", $reqApprovalId);
		$approval_manager->setField("PEGAWAI_APPROVAL_JENIS", "INTERNAL");
		$approval_manager->setField("STATUS_AKTIF", $statusAktif);
		$approval_manager->setField("URUT", $reqUrut);
		$approval_manager->setField("PERMOHONAN_ID", $reqId);
		$approval_manager->insertData();
		$approvalId = $approval_manager->id;
		

		if($sentEmail == true)
		{
			$emailStatus = "";
			$emailPesan = "";
			/* HIT KE EMAIL */
			if(!empty($approvalEmail))
			{
				
				$approvalEmail = "helpdesk@valsix.xyz";
				$this->Subject = $reqBody;
				$this->AddAddress($approvalEmail,$approvalNama);	

				$data = array(
						"reqId" => $approvalId,
						"reqPermohonanNomor" => ""
				);
				$body = view("email/permohonan_approval", $data)->render();
				$this->MsgHTML($body);
					
				if($this->Send())
				{
					$emailPesan = "Email persetujuan sukses dikirim ke ".$approvalNama;
					$emailStatus = "SUKSES";
				}
				else
				{
					$emailPesan = "Email persetujuan sukses dikirim ke ".$approvalNama;
					$emailStatus = "FAILED";
				}
					
				$this->query(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
			}
			
			return $emailPesan;
			return "SUKSES";
		}
		else
			return "SUKSES";

	}
			  

	function pushEmail($reqPegawaiId, $reqPermohonanId, $reqTabel, $reqTabelKolom)
	{	

		$emailStatus = "";
		$emailPesan = "";
		//$statusAktif = ($sentEmail == true) ? "1" : "0";
		

		$sql = "SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, A.JABATAN
				FROM PEGAWAI A 
				WHERE A.PEGAWAI_ID = '$reqPegawaiId'
				";

		$rowResult = $this->query($sql)->row();

		/* UBAH NAMA APPROVAL NYA SUPAYA BUKAN PEMBUAT UTAMA */
		$this->query("
				UPDATE approval_manager SET
				 PEGAWAI_ID        = '".$reqPegawaiId."',
				 PEGAWAI_NRP       = '".$rowResult->nrp."',
				 PEGAWAI           = '".str_replace("'", "''", $rowResult->nama)."',
				 JABATAN 	       = '".$rowResult->jabatan."'
				WHERE TABEL = '$reqTabel' AND PERMOHONAN_ID = '$reqPermohonanId' AND TABEL_APPROVAL_KOLOM = '".$reqTabelKolom."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' 
			");


		$rowResult = $this->query(" SELECT approval_manager_id, pegawai_approval_email, pegawai_approval_nama, pegawai_approval_jabatan, pegawai, judul
									FROM APPROVAL_MANAGER WHERE TABEL = '$reqTabel' AND PERMOHONAN_ID = '$reqPermohonanId' AND TABEL_APPROVAL_KOLOM = '".$reqTabelKolom."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ")->row();

		$approvalId      = $rowResult->approval_manager_id;
		$approvalEmail   = $rowResult->pegawai_approval_email;
		$approvalNama    = $rowResult->pegawai_approval_nama;
		$approvalJabatan = $rowResult->pegawai_approval_jabatan;
		$reqPegawai      = $rowResult->pegawai;
		$reqPermohonan   = $rowResult->judul;

		$reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
		$reqBody = $reqPegawai." Mengajukan ".$reqTitle;



		
		/* HIT KE EMAIL */
		if(!empty($approvalEmail))
		{
			
			$mail = new KMail();
			$mail->Subject = $reqBody;
			$approvalEmail = "helpdesk@valsix.xyz";
			$mail->AddAddress($approvalEmail,$approvalNama);
			
			$data = array(
				"reqId" => $approvalId,
				"reqPermohonanNomor" => ""
			);
			$body = view("email/permohonan_approval", $data)->render();
			$mail->MsgHTML($body);
							
			if($mail->Send())
			{
				$emailPesan = "Email persetujuan sukses dikirim ke ".$approvalNama.". ";
				$emailStatus = "SUKSES";
			}
			else
			{
				$emailPesan = "Email persetujuan gagal dikirim ke ".$approvalNama.". ";
				$emailStatus = "FAILED";
			}
				
		}
		
		$this->query(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."', STATUS_AKTIF = '1' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");

		return $emailPesan;


	}

	function setLogApproval($reqId, $reqTabel)
	{

		$sql = "
				INSERT INTO approval_manager_log(
					approval_manager_id, tabel, tabel_id, tabel_approval_kolom, permohonan_id, 
					nomor, judul, pegawai_id, pegawai_nrp, pegawai, jabatan, pegawai_approval_jenis, 
					pegawai_approval_id, pegawai_approval_nrp, pegawai_approval_nama, 
					pegawai_approval_jabatan, pegawai_approval_email, pegawai_approval_telepon, 
					approval, approval_alasan, approval_tanggal, email_status, whatsapp_status, 
					urut, status_aktif, created_by, created_date)
				select 
					approval_manager_id, tabel, tabel_id, tabel_approval_kolom, permohonan_id, 
					nomor, judul, pegawai_id, pegawai_nrp, pegawai, jabatan, pegawai_approval_jenis, 
					pegawai_approval_id, pegawai_approval_nrp, pegawai_approval_nama, 
					pegawai_approval_jabatan, pegawai_approval_email, pegawai_approval_telepon, 
					approval, approval_alasan, approval_tanggal, email_status, whatsapp_status, 
					urut, status_aktif, created_by, created_date
				from approval_manager 
				WHERE permohonan_id = '$reqId' and tabel = '$reqTabel' and coalesce(nullif(approval, ''), 'X') in ('Y', 'T')
		";
		$this->query($sql);

		$sql = " delete from approval_manager WHERE permohonan_id = '$reqId' and tabel = '$reqTabel' ";
		$this->query($sql);

		return "SUKSES";

	}
			  
    public static function query($sql) {
        self::$rowResult = DB::select(strtolower($sql));
        return new static();
    }

    public static function first_row()
    {

        return self::$rowResult[0];
    }

    public static function row()
    {

        return self::$rowResult[0];
    }

    
    public static function result_array()
    {

        $rowResult =  self::$rowResult;
        $rowResult = json_decode(json_encode($rowResult), true);

        return $rowResult;
    }

    
    public static function row_array()
    {

        $rowResult =  self::$rowResult[0];
        $rowResult = json_decode(json_encode($rowResult), true);

        return $rowResult;
    }


}
	
  /***** INSTANTIATE THE GLOBAL OBJECT 
  $userMobile = new usermobile();*/
	
?>
