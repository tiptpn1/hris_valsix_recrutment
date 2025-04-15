<?php
use App\Models\ApprovalManager;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Config;

class KirimNotifikasi extends PHPMailer {

    public static $rowResult;
    var $publishUrl;
    var $MD5KEY;
    /******************** CONSTRUCTOR **************************************/
    
    function __construct($exceptions = false)
    {
        parent::__construct($exceptions);

    }

    function setPublishUrl()
    {
        $this->publishUrl   = Config::get('app.base_publish');
        $this->MD5KEY       = Config::get('app.md5key');
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
    function KirimNotifikasi(){
	
    }

    function email($viewPage, $arrParameterView, $subject, $emailAddress, $emailName, $attachment="", $emailCC=array(), $attachmentJudul="")
    {

        $this->setConnection();

        $mail = $this;
        $mail->Subject = $subject;

        if(is_array($emailAddress))
        {

            $adaEmail = 0;
            for($i=0;$i<count($emailAddress);$i++)
            {
                $EMAIL = $emailAddress[$i];
                if(!empty($EMAIL))
                {
                    $mail->AddAddress($EMAIL,$emailName); 
                    $adaEmail++;
                }
            }

            if($adaEmail == 0)
                return;

        }
        else
            $mail->AddAddress($emailAddress,$emailName);  


        foreach($emailCC as $row)
        {

          $NAMA           = $row["nama"];
          $EMAIL          = $row["email"];
          $mail->AddCC($EMAIL, $NAMA);

        }


        $body = view($viewPage, $arrParameterView)->render();
        $mail->MsgHTML($body);

        if(is_array($attachment))
        {


            for($i=0;$i<count($attachment);$i++)
            {

              $vattachment = $attachment[$i];
              $linkAttachement = $vattachment;
              if(file_exists($linkAttachement))
              {
                  $mail->AddAttachment($linkAttachement, $attachmentJudul." - ".($i+1).".".getExtension($linkAttachement));
              }
            
            }


        }
        else
        {
            $linkAttachement = $attachment;
            if(file_exists($linkAttachement))
            {
                $mail->AddAttachment($linkAttachement, $attachmentJudul.".".getExtension($linkAttachement));
            }
        }

        if($mail->Send())
            return "SUKSES";
        else 
            return "GAGAL";

    }

    
    function verifikasi_akun($PELAMAR_ID, $JOB_ID="")
    {   
        $this->setPublishUrl();
        
        $sql = " SELECT nama, email, whatsapp FROM pelamar WHERE pelamar_id = '$PELAMAR_ID' ";
        $rowResult = $this->query($sql)->first_row();

        $PENERIMA_EMAIL         = $rowResult->email;
        $PENERIMA_WHATSAPP      = $rowResult->whatsapp;
        $PENERIMA               = $rowResult->nama;

        $emailStatus = "";
        $JUDUL_NOTIFIKASI = "Verifikasi Akun - ".config("app.nama_aplikasi");

        $ARR_ATTACHMENT = "";

        /* HIT KE EMAIL */
        if(!empty($PENERIMA_EMAIL))
        {
            
            $emailStatus = $this->email("email/verifikasi_akun", 
                            array('PELAMAR_ID' => $PELAMAR_ID), 
                            $JUDUL_NOTIFIKASI, $PENERIMA_EMAIL, $PENERIMA);
                         
            $this->query(" UPDATE pelamar SET email_status = '".$emailStatus."' WHERE pelamar_id = '".$PELAMAR_ID."' ");
            
            if(!empty($JOB_ID))
            {
                $sql = "UPDATE jobs_log SET 
                        STATUS = 'SUCCESS',
                        STATUS_RESULT = '$emailStatus',
                        UPDATED_BY    = 'JOBS',
                        UPDATED_DATE  = CURRENT_TIMESTAMP
                    WHERE JOBS_LOG_ID = '$JOB_ID' ";
                $this->query($sql);
            }
            

        }

        return $emailStatus;

    }
              

    function reset_password($PELAMAR_ID, $JOB_ID="")
    {   
        $this->setPublishUrl();
        
        $sql = " SELECT nama, email, whatsapp FROM pelamar WHERE pelamar_id = '$PELAMAR_ID' ";
        $rowResult = $this->query($sql)->first_row();

        $PENERIMA_EMAIL         = $rowResult->email;
        $PENERIMA_WHATSAPP      = $rowResult->whatsapp;
        $PENERIMA               = $rowResult->nama;

        $emailStatus = "";
        $JUDUL_NOTIFIKASI = "Reset Password - ".config("app.nama_aplikasi");

        $ARR_ATTACHMENT = "";

        /* HIT KE EMAIL */
        if(!empty($PENERIMA_EMAIL))
        {
            
            $emailStatus = $this->email("email/reset_password", 
                            array('PELAMAR_ID' => $PELAMAR_ID), 
                            $JUDUL_NOTIFIKASI, $PENERIMA_EMAIL, $PENERIMA);
                         
            $this->query(" UPDATE pelamar SET email_status = '".$emailStatus."' WHERE pelamar_id = '".$PELAMAR_ID."' ");
            
            if(!empty($JOB_ID))
            {
                $sql = "UPDATE jobs_log SET 
                        STATUS = 'SUCCESS',
                        STATUS_RESULT = '$emailStatus',
                        UPDATED_BY    = 'JOBS',
                        UPDATED_DATE  = CURRENT_TIMESTAMP
                    WHERE JOBS_LOG_ID = '$JOB_ID' ";
                $this->query($sql);
            }
            

        }

        return $emailStatus;

    }
              
              
    public static function query($sql) {
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
$kirimNotifikasi = new KirimNotifikasi();

?>