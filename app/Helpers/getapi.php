<?php 

class getapi
{
    function __construct()
    {
    }

    public function getArrayData($apiUrl, $apiName, $apiToken, $arrStatement=array(), $method="GET") {


        /* API */
        $ch = curl_init();

        $paramGet = "";
        $isPost = 1;
        $data = $arrStatement;

        if($method=="GET")
        {
            $i = 0;
            foreach ($arrStatement as $key => $value)
            {
                if($i == 0)
                    $paramGet .= "?$key=$value";    
                else
                    $paramGet .= "&$key=$value";

                $i++;
            }

        }    

        $bearerToken = "";
        if(!empty($apiToken))
            $bearerToken = 'Authorization: Bearer ' . $apiToken;

        curl_setopt($ch, CURLOPT_URL, $apiUrl.$apiName.$paramGet);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            $bearerToken
            ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        if($method=="GET")
        {}
        else
        {
            curl_setopt($ch, CURLOPT_POST, $isPost);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);


        $response = str_replace('-"J', 'J', $response);
        $response = str_replace('REBO"', 'REBO', $response);
        $response = str_replace('"AMA"', 'AMA', $response);
        $response = str_replace('MAR"ATUL', 'MARATUL', $response);
        $response = str_replace('-"SIMOREJOSARI', 'SIMOREJOSARI', $response); //U601
        $response = str_replace('SURABAYA" SURABAYA', 'SURABAYA SURABAYA', $response); //U601
        $response = str_replace('-"GENENG', 'GENENG', $response); //U6P1
        $response = str_replace('PECALUKAN"', 'PECALUKAN', $response); //U6P1
        $response = str_replace('Pertanian"STIPER"', 'Pertanian STIPER', $response); //U701
        $response = str_replace('SMK"AHMAD YANI"', 'SMK AHMAD YANI', $response); //U7K1
        $response = str_replace('Nasional"', 'Nasional', $response); //U7K1
        $response = str_replace('-"0822', '0822', $response); //U3K1
        $response = str_replace('MA"RUF', 'MARUF', $response); //U3K1
        $response = str_replace('NISA"I', 'NISAI', $response); //U3K1
        $response = str_replace('-"KRANI', 'KRANI', $response); //U3K1
        $response = str_replace('-"MANDOR', 'MANDOR', $response); //U3K1
        $response = str_replace('-"478', '478', $response); //U3K1
        $response = str_replace('REBO,"', 'REBO","', $response); //U3K1
        $response = str_replace('"nama_karyawan":AMA,', '"nama_karyawan":"AMA",', $response); //U4K1
        $response = str_replace('Nasional,"', 'Nasional","', $response); //ho
        $response = str_replace(':"-"BTN', ':"BTN', $response); //U3K1
        $response = str_replace(':"UPN"VETERAN"', ':"UPN VETERAN', $response); //U3K1
        $response = str_replace(':"STIE"AUB"', ':"STIE AUB', $response); //U3K1
        $response = str_replace(':"SMK"YAPEMA"', ':"SMK YAPEMA', $response); //U3K1
        $response = str_replace('KBP" PADANG', 'KBP PADANG', $response); //U301
        
        $obj = json_decode($response, true);

        if(empty($obj))
        {
            
            echo $response;
            exit;
            
        }

        return $obj;

    }



    public function postFormData($apiUrl,$apiName, $arrStatement) {


        /* API */
        $ch = curl_init();

        $paramGet = "";
        $isPost = 1;
        $data = $arrStatement;


        curl_setopt($ch, CURLOPT_URL, $apiUrl.$apiName.$paramGet);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, $isPost);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);


        curl_close($ch);


        $obj = ($response);
        $obj = json_decode($response, true);

        return $obj;

    }



}

$getApi = new getapi();

?>