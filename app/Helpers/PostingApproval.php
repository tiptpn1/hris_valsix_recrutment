<?php
use App\Models\ApprovalManager;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Config; 

class PostingApproval extends PHPMailer {

    public static $rowResult;
    /******************** CONSTRUCTOR **************************************/
    
    function __construct($exceptions = false)
    {
        parent::__construct($exceptions);

    }

    function setConnection()
    {
        
        $this->IsSMTP();
        $this->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages


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
    function PostingApproval(){
	
    }

	
    function clearApprovalByParent($reqParentId, $reqParent, $KATEGORI_APPROVAL)
    {


        $sql = " INSERT INTO approval_manager_log(
                    approval_manager_id, tabel, tabel_key, tabel_id, tabel_approval_kolom, kategori_approval, 
                    user_group_kode, user_login_id, pegawai_id, pegawai_nrp, pegawai, jabatan, regional, cabang, 
                    pegawai_approval_jenis, pegawai_approval_id, 
                    pegawai_approval_nrp, pegawai_approval_nama, pegawai_approval_jabatan, 
                    pegawai_approval_email, pegawai_approval_whatsapp, approval, 
                    approval_alasan, approval_tanggal, created_date, nomor, keterangan, 
                    urut, email_status, whatsapp_status, status_aktif, tabel_parent, tabel_parent_id)
                SELECT  approval_manager_id, tabel, tabel_key, tabel_id, tabel_approval_kolom, kategori_approval, 
                    user_group_kode, user_login_id, pegawai_id, pegawai_nrp, pegawai, jabatan, regional, cabang, 
                    pegawai_approval_jenis, pegawai_approval_id, 
                    pegawai_approval_nrp, pegawai_approval_nama, pegawai_approval_jabatan, 
                    pegawai_approval_email, pegawai_approval_whatsapp, approval, 
                    approval_alasan, approval_tanggal, created_date, nomor, keterangan, 
                    urut, email_status, whatsapp_status, status_aktif, tabel_parent, tabel_parent_id
                FROM approval_manager 
                WHERE tabel_parent = '$reqParent' and tabel_parent_id = '$reqParentId' and kategori_approval = '$KATEGORI_APPROVAL' and not coalesce(approval, 'X') = 'X' ";

        $this->exec($sql); 
        
        $sql = " DELETE FROM approval_manager 
                 WHERE tabel_parent = '$reqParent' and tabel_parent_id = '$reqParentId' and kategori_approval = '$KATEGORI_APPROVAL' ";       
        $this->exec($sql); 
        
    }



    function clearApproval($reqPermohonanId, $reqTabel)
    {


        $sql = " INSERT INTO approval_manager_log(
                    approval_manager_id, tabel, tabel_key, tabel_id, tabel_approval_kolom, kategori_approval, 
                    user_group_kode, user_login_id, pegawai_id, pegawai_nrp, pegawai, jabatan, regional, cabang, 
                    pegawai_approval_jenis, pegawai_approval_id, 
                    pegawai_approval_nrp, pegawai_approval_nama, pegawai_approval_jabatan, 
                    pegawai_approval_email, pegawai_approval_whatsapp, approval, 
                    approval_alasan, approval_tanggal, created_date, nomor, keterangan, 
                    urut, email_status, whatsapp_status, status_aktif)
                SELECT  approval_manager_id, tabel, tabel_key, tabel_id, tabel_approval_kolom, kategori_approval, 
                    user_group_kode, user_login_id, pegawai_id, pegawai_nrp, pegawai, jabatan, regional, cabang, 
                    pegawai_approval_jenis, pegawai_approval_id, 
                    pegawai_approval_nrp, pegawai_approval_nama, pegawai_approval_jabatan, 
                    pegawai_approval_email, pegawai_approval_whatsapp, approval, 
                    approval_alasan, approval_tanggal, created_date, nomor, keterangan, 
                    urut, email_status, whatsapp_status, status_aktif
                FROM approval_manager 
                WHERE tabel = '$reqTabel' and tabel_id = '$reqPermohonanId' and not coalesce(approval, 'X') = 'X' ";
        $this->exec($sql); 
        
        $sql = " DELETE FROM approval_manager 
                 WHERE tabel = '$reqTabel' and tabel_id = '$reqPermohonanId' ";       
        $this->exec($sql); 
        
    }


    function pushNotifikasi($reqApprovalId, $reqApprovalUserGroup, $reqPegawaiId, $reqPegawai, $reqPermohonanId, $reqPermohonan, $reqTabel, $reqTabelKolom, $KATEGORI_APPROVAL="", $reqUrut=1, $sentEmail=true)
    {   

        


        if($reqApprovalId == "" && $reqApprovalUserGroup == "")
            return;


        if(empty($reqApprovalId))
        {
        	$reqApprovalId = $this->query(" select user_login_id from user_login where user_group = '$reqApprovalUserGroup' ")->row()->user_login_id;
        }

        if($reqApprovalId == "")
            return;


            

        $this->setConnection();



        $reqType = $reqPermohonan;
        $reqId = $reqPermohonanId;
        $reqJenis = $reqPermohonan;
        $reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
        $reqBody = $reqPegawai." Mengajukan Persetujuan ".$reqPermohonan;
        
        $reqApprovalId      = $reqApprovalId;   
        $reqApprovalTipe    = "INTERNAL";   
        

        $rowResult = $this->query(" SELECT USER_LOGIN_ID, NRP, NAMA, JABATAN, EMAIL, TELEPON WHATSAPP FROM USER_LOGIN WHERE USER_LOGIN_ID = '".$reqApprovalId."'  ")->row();

        
        $approvalEmail    = $rowResult->email;
        $approvalNama     = $rowResult->nama;
        $approvalJabatan  = $rowResult->jabatan;
        $approvalWhatsapp = $rowResult->whatsapp;
        
        $statusAktif = ($sentEmail == true) ? "1" : "0";

        /* HIT KE PROSES APPROVAL */
        $approval_manager = new approvalmanager();
        $approval_manager->setField("TABEL", $reqTabel);
        $approval_manager->setField("TABEL_KEY", $reqTabel."_ID");
        $approval_manager->setField("TABEL_ID", $reqPermohonanId);
        $approval_manager->setField("USER_GROUP_KODE", $reqApprovalUserGroup);
        $approval_manager->setField("TABEL_APPROVAL_KOLOM", $reqTabelKolom);
        $approval_manager->setField("KATEGORI_APPROVAL", $KATEGORI_APPROVAL);
        $approval_manager->setField("PEGAWAI_ID", $reqPegawaiId);
        $approval_manager->setField("PEGAWAI_APPROVAL_ID", $reqApprovalId);
        $approval_manager->setField("PEGAWAI_APPROVAL_JENIS", $reqApprovalTipe);
        $approval_manager->setField("STATUS_AKTIF", $statusAktif);
        $approval_manager->setField("URUT", $reqUrut);
        $approval_manager->setField("KETERANGAN", $this->setQuote($reqPermohonan));

        $approval_manager->insertData();
        $approvalId = $approval_manager->id;
        

        if($sentEmail == true && !empty(Config::get('app.email_Host')))
        {
            /* HIT KE EMAIL */
            if(!empty($approvalEmail))
            {
                
                $mail = $this;
                $mail->Subject = $reqBody;
                $mail->AddAddress($approvalEmail,$approvalNama);          
				$data = array(
					'approvalId' => $approvalId
				);
                
                $body = view("email/permohonan_approval", $data)->render();
		       	$mail->MsgHTML($body);

                if($mail->Send())
                {
                    $emailPesan = "Email approval sukses dikirim ke ".$approvalNama;
                    $emailStatus = "SUKSES";
                }
                else
                {
                    $emailPesan = "Email approval gagal dikirim ke ".$approvalNama;
                    $emailStatus = "FAILED";
                }
                    
                $this->exec(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
            }

            
            return $emailPesan;
        }
        else
            return "SUKSES";

    }



    function pushNotifikasiParent($reqNomor, $reqApprovalId, $reqApprovalUserGroup, $reqUserLoginId, $reqPegawai, $reqPermohonanId, $reqPermohonan, 
                                 $reqTabel, $reqTabelKolom, $reqParentTabel, $reqParentTabelId, $KATEGORI_APPROVAL="", $reqUrut=1, $sentEmail=true)
    {   

        

        if($reqApprovalId == "" && $reqApprovalUserGroup == "")
            return;


        $this->setConnection();


        $reqType = $reqPermohonan;
        $reqId = $reqPermohonanId;
        $reqJenis = $reqPermohonan;
        $reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
        $reqBody = $reqPegawai." Mengajukan Persetujuan ".$reqPermohonan;
        
        $reqApprovalId      = $reqApprovalId;   
        $reqApprovalTipe    = "INTERNAL";   
        

        $rowResult = $this->query(" SELECT PEJABAT_ID, NRP, NAMA, JABATAN, EMAIL, TELEPON WHATSAPP FROM PEJABAT WHERE PEJABAT_ID = '".$reqApprovalId."'  ")->row();

        
        $approvalEmail    = $rowResult->email;
        $approvalNama     = $rowResult->nama;
        $approvalJabatan  = $rowResult->jabatan;
        $approvalWhatsapp = $rowResult->whatsapp;
        
        $statusAktif = ($sentEmail == true) ? "1" : "0";

        /* HIT KE PROSES APPROVAL */
        
        $approval_manager = new approvalmanager();
        $approval_manager->setField("NOMOR", $reqNomor);
        $approval_manager->setField("TABEL", $reqTabel);
        $approval_manager->setField("TABEL_KEY", $reqTabel."_ID");
        $approval_manager->setField("TABEL_ID", $reqPermohonanId);
        $approval_manager->setField("USER_GROUP_KODE", $reqApprovalUserGroup);
        $approval_manager->setField("TABEL_APPROVAL_KOLOM", $reqTabelKolom);
        $approval_manager->setField("KATEGORI_APPROVAL", $KATEGORI_APPROVAL);
        $approval_manager->setField("USER_LOGIN_ID", $reqUserLoginId);
        $approval_manager->setField("PEGAWAI_APPROVAL_ID", $reqApprovalId);
        $approval_manager->setField("PEGAWAI_APPROVAL_JENIS", $reqApprovalTipe);
        $approval_manager->setField("STATUS_AKTIF", $statusAktif);
        $approval_manager->setField("URUT", $reqUrut);
        $approval_manager->setField("KETERANGAN", $this->setQuote($reqPermohonan));

        $approval_manager->setField("TABEL_PARENT", $reqParentTabel);
        $approval_manager->setField("TABEL_PARENT_ID", $reqParentTabelId);
        
        $approval_manager->insertData();

        //var_dump($approval_manager->record->approval_manager_id);
        $approvalId = ($approval_manager->record->approval_manager_id); //$approval_manager->id;
        

        if($sentEmail == true && !empty(Config::get('app.email_Host')))
        {
            /* HIT KE EMAIL */
            if(!empty($approvalEmail))
            {
                
                $mail = $this;
                $mail->Subject = $reqBody;
                $mail->AddAddress($approvalEmail,$approvalNama);          
                $data = array(
                    'reqId' => $approvalId
                );
                $body = view("email/permohonan_approval", $data)->render();
                $mail->MsgHTML($body);

                if($mail->Send())
                {
                    $emailPesan = "Email approval sukses dikirim ke ".$approvalNama;
                    $emailStatus = "SUKSES";
                }
                else
                {
                    $emailPesan = "Email approval gagal dikirim ke ".$approvalNama;
                    $emailStatus = "FAILED";
                }
                    
                $this->query(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
            }

            
            return $emailPesan;
        }
        else
            return "SUKSES";

    }




    function pushEmail($reqPegawaiId, $reqPermohonanId, $reqTabel, $KATEGORI_APPROVAL, $reqUrut)
    {   
        

        $this->setConnection();

        /* UBAH NAMA APPROVAL NYA SUPAYA BUKAN PEMBUAT UTAMA */
        $this->query("
                UPDATE approval_manager SET
                 STATUS_AKTIF      = '1',
                 PEGAWAI_ID        = '".$reqPegawaiId."',
                 CREATED_DATE      = CURRENT_TIMESTAMP
                WHERE TABEL = '$reqTabel' AND TABEL_ID = '$reqPermohonanId' AND KATEGORI_APPROVAL = '$KATEGORI_APPROVAL' AND URUT = '".$reqUrut."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ");


        $rowResult = $this->query(" SELECT approval_manager_id, pegawai_approval_id, pegawai_approval_email, pegawai_approval_whatsapp, pegawai_approval_nama, pegawai_approval_jabatan, pegawai, keterangan
                                      FROM approval_manager 
                                      WHERE TABEL = '$reqTabel' AND KATEGORI_APPROVAL = '$KATEGORI_APPROVAL' AND TABEL_ID = '$reqPermohonanId' AND URUT = '".$reqUrut."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ")->row();

        $approvalId         = $rowResult->approval_manager_id;
        $approvalPegawaiId  = $rowResult->pegawai_approval_id;
        $approvalEmail      = $rowResult->pegawai_approval_email;
        $approvalWhatsapp   = $rowResult->pegawai_approval_whatsapp;
        $approvalNama       = $rowResult->pegawai_approval_nama;
        $approvalJabatan    = $rowResult->pegawai_approval_jabatan;
        $reqPegawai         = $rowResult->pegawai;
        $reqPermohonan      = $rowResult->keterangan;


        $reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
        $reqBody = $reqPegawai." Mengajukan Persetujuan ".$reqPermohonan;


        /* HIT KE EMAIL */
        if(!empty($approvalEmail) && !empty(Config::get('app.email_Host')))
        {
            
            $mail = $this;
            $mail->Subject = $reqBody;
            $mail->AddAddress($approvalEmail,$approvalNama);          
            $data = array(
                'approvalId' => $approvalId
            );
            $body = view("email/permohonan_approval", $data)->render();
            $mail->MsgHTML($body);

            if($mail->Send())
            {
                $emailPesan = "Email approval sukses dikirim ke ".$approvalNama;
                $emailStatus = "SUKSES";
            }
            else
            {
                $emailPesan = "Email approval gagal dikirim ke ".$approvalNama;
                $emailStatus = "FAILED";
            }
                
            $this->exec(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
        }

        return $emailPesan;


    }
              

    

    function pushEmailParent($reqPegawaiId, $reqTabelParentId, $reqTabelParent, $KATEGORI_APPROVAL, $reqUrut, $reqApprovalJenis="INTERNAL", $reqPegawaiIdSebelumnya="0")
    {   
        

        $this->setConnection();


        

        if($reqApprovalJenis == "INTERNAL")
        {
            /* UBAH NAMA APPROVAL NYA SUPAYA BUKAN PEMBUAT UTAMA */
            $this->exec("
                    UPDATE approval_manager SET
                     STATUS_AKTIF      = '1',
                     PEGAWAI_ID        = '".$reqPegawaiId."',
                     CREATED_DATE      = CURRENT_TIMESTAMP
                    WHERE TABEL_PARENT = '$reqTabelParent' AND TABEL_PARENT_ID = '$reqTabelParentId' AND KATEGORI_APPROVAL = '$KATEGORI_APPROVAL' AND URUT = '".$reqUrut."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ");
        }
        else
        {
            /* JIKA DARI EKSTERNAL TIDAK PERLU UBAH2 NAMA */
            $this->exec("
                    UPDATE approval_manager SET
                     STATUS_AKTIF      = '1',
                     PEGAWAI_ID        = '".$reqPegawaiIdSebelumnya."',
                     CREATED_DATE      = CURRENT_TIMESTAMP
                    WHERE TABEL_PARENT = '$reqTabelParent' AND TABEL_PARENT_ID = '$reqTabelParentId' AND KATEGORI_APPROVAL = '$KATEGORI_APPROVAL' AND URUT = '".$reqUrut."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ");
        }


        $rowResult = $this->query(" SELECT approval_manager_id, pegawai_approval_id, pegawai_approval_email, pegawai_approval_whatsapp, pegawai_approval_nama, pegawai_approval_jabatan, pegawai, keterangan
                                      FROM APPROVAL_MANAGER 
                                      WHERE TABEL_PARENT = '$reqTabelParent' AND TABEL_PARENT_ID = '$reqTabelParentId' AND KATEGORI_APPROVAL = '$KATEGORI_APPROVAL' AND URUT = '".$reqUrut."' AND COALESCE(NULLIF(approval, ''), 'X') = 'X' ")->result_array();

        foreach($rowResult as $row)
        {

            $approvalId         = $row["approval_manager_id"];
            $approvalPegawaiId  = $row["pegawai_approval_id"];
            $approvalEmail      = $row["pegawai_approval_email"]; 
            $approvalWhatsapp   = $row["pegawai_approval_whatsapp"];
            $approvalNama       = $row["pegawai_approval_nama"]; 
            $approvalJabatan    = $row["pegawai_approval_jabatan"]; 
            $reqPegawai         = $row["pegawai"]; 
            $reqPermohonan      = $row["keterangan"]; 


            $reqTitle = ucwords(str_replace("_", " ", strtolower($reqPermohonan)));
            $reqBody = $reqPegawai." Mengajukan Persetujuan ".$reqPermohonan;


            /* HIT KE EMAIL */
            if(!empty($approvalEmail) && !empty(Config::get('app.email_Host')))
            {
                
                $mail = $this;
                $mail->Subject = $reqBody;
                $mail->AddAddress($approvalEmail,$approvalNama);          
                $data = array(
                    'approvalId' => $approvalId
                );
                $body = view("email/permohonan_approval", $data)->render();
                $mail->MsgHTML($body);

                if($mail->Send())
                {
                    $emailPesan = "Email approval sukses dikirim ke ".$approvalNama;
                    $emailStatus = "SUKSES";
                }
                else
                {
                    $emailPesan = "Email approval gagal dikirim ke ".$approvalNama;
                    $emailStatus = "FAILED";
                }
                    
                $this->exec(" UPDATE approval_manager SET EMAIL_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
            }

        }

        return $emailPesan;


    }


    function notifikasiPersetujuan($reqId, $reqNomor, $reqPersetujuan)
    {
        
        $this->setConnection();

        $sql = " SELECT approval_manager_id, pegawai, pegawai_email, keterangan FROM approval_manager WHERE nomor = '$reqNomor' and urut = 1 and approval_tanggal is not null ";
        $rowResult = $this->query($sql)->first_row();
        
        $pegawaiNama = $rowResult->pegawai;
        $pegawaiEmail = $rowResult->pegawai_email;
        $reqPermohonan = $rowResult->keterangan;
        $approvalId = $rowResult->approval_manager_id;

        $reqBody = $reqPermohonan." Nomor ".$reqNomor." ".(($reqPersetujuan == "Y") ? "Disetujui" : "Ditolak");

        /* HIT KE EMAIL */
        if(!empty($pegawaiEmail) && !empty(Config::get('app.email_Host')))
        {
            
            $mail = $this;
            $mail->Subject = $reqBody;
            $mail->AddAddress($pegawaiEmail,$pegawaiNama);          
            $data = array(
                'approvalId' => $reqId,
                'pegawaiNama' => $pegawaiNama
            );
            $body = view("email/informasi_approval", $data)->render();

            $mail->MsgHTML($body);

            if($mail->Send())
            {
                $emailPesan = "Email approval sukses dikirim ke ".$pegawaiNama;
                $emailStatus = "SUKSES";
            }
            else
            {
                $emailPesan = "Email approval gagal dikirim ke ".$pegawaiNama;
                $emailStatus = "FAILED";
            }
                
            $this->exec(" UPDATE approval_manager SET INFO_STATUS = '".$emailStatus."' WHERE APPROVAL_MANAGER_ID = '".$approvalId."' ");
        }

        
    }
              
    function setQuote($var, $status='')
    {	
        if($status == 1)
            $tmp= str_replace("\'", "''", $var);
        else
            $tmp= str_replace("'", "''", $var);
        return $tmp;
    }

    public static function exec($sql) {
        
		try {
			$result = DB::select($sql);
			return true;
        } catch (\Illuminate\Database\QueryException $e) {
            return false;
        }
    }
    

    public static function query($sql) {
		$sql = strtolower($sql);
		$sql = str_replace("%d-%m-%y", "%d-%m-%Y", $sql);
		$sql = str_replace("%h:%i:%s", "%H:%i:%s", $sql);

        self::$rowResult = DB::select($sql);
        return new static();
    }

    public static function first_row()
    {

        if(empty(self::$rowResult[0]))
        {
            return self::$rowResult;
        }

        return self::$rowResult[0];
    }

    public static function result()
    {
        if(empty(self::$rowResult[0]))
        {
            return self::$rowResult;
        }

        return self::$rowResult;
    }

    public static function row()
    {

        if(empty(self::$rowResult[0]))
        {
            return self::$rowResult;
        }

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

        if(empty(self::$rowResult[0]))
        {
            return self::$rowResult;
        }
        
        $rowResult =  self::$rowResult[0];
        $rowResult = json_decode(json_encode($rowResult), true);

        return $rowResult;
    }


    
}


/***** INSTANTIATE THE GLOBAL OBJECT */
$postingApproval = new PostingApproval();

?>