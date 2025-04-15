<?

use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Config;

class KMail extends PHPMailer
{
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
}
