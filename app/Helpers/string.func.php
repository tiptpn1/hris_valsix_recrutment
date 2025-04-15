<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: string.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */



/* fungsi untuk mengatur tampilan mata uang
 * $value = string
 * $digit = pengelompokan setiap berapa digit, default : 3
 * $symbol = menampilkan simbol mata uang (Rupiah), default : false
 * $minusToBracket = beri tanda kurung pada nilai negatif, default : true
 */

 function grafik_column_stack($TITLE, $X_DATA, $ARR_SERIES)
 {
	 $grafik =  [
		 "chart"=>[
		   "type"=> "column",
		   // "marginTop"=> 85,
		   // "marginBottom"=> 80,
		   // "height"=> count($ARR_SERIES[0]["data"]) * 75 + 165,
		   // "height"=> count($ARR_SERIES[0]["data"]) * 150 + 0,
		   // "height"=> count($ARR_SERIES) * 75 + 165,
		   // "height"=> count($ARR_SERIES) * 75 + 0,
		 ],
		 "exporting"=>[
		   "enabled"=>false
		 ],
		 "title"=>[
		   "text"=>$TITLE
		 ],
		 "subtitle"=>[
		   "text"=>null
		 ],
		 "tooltip"=>[
			 "pointFormat" => "<div style='font-size: 9px;'>{series.name}</div>: <b  style='font-size: 9px;'>{point.y:.f}</b><br/>",
			 "valueSuffix" => ' karyawan',
		 ],
		 "xAxis"=> [
			 "categories"=> $X_DATA,
			 "title"=> [
				 "text"=> null
			 ],
			 "gridLineWidth"=> 1,
			 "lineWidth"=> 0
		 ],
		 // "plotOptions"=> [
		 //     "bar"=> [
		 //         "borderRadius"=> '100%',
		 //         "dataLabels"=> [
		 //             "enabled"=> true
		 //         ],
		 //         "groupPadding"=> 0.1
		 //     ]
		 // ],
		 "plotOptions"=> [
			 "series"=> [
				 // "pointWidth"=> 10,
				 "groupPadding"=> 0.1,
				 "pointPadding"=> 0
			 ],
			 "column" => [ "stacking" => "normal" ]
		 ],
		 "yAxis"=> [
			 "allowDecimals"=> false,
			 "min"=> 0,
			 "title"=> [
				 "text"=> 'total karyawan',
				 "align"=> 'high'
			 ],
			 "gridLineWidth"=> 0,
			 "stackLabels" => []
		 ],
		 "legend"=>[
		   "enabled"=>true,
		   "itemStyle" => [
			   "fontSize"=>"8px"
		   ]
		 ],
		 "credits"=>[
		   "enabled"=>false
		 ],
		 "series"=> $ARR_SERIES,
		 "responsive"=>[
		   "rules"=>[
			 [
			   "condition"=>[
				 "maxWidth"=>500
			   ],
			   "chartOptions"=>[
				 "legend"=>[
				   "layout"=>"horizontal",
				   "align"=>"center",
				   "verticalAlign"=>"bottom"
				 ]
			   ]
			 ]
		   ]
		 ]
	 ];

	 return $grafik;
 }

 function grafik_bar($TITLE, $X_DATA, $ARR_SERIES)
 {
	 $grafik =  [
		 "chart"=>[
		   "type"=> "bar",
		   // "marginTop"=> 85,
		   // "marginBottom"=> 80,
		   // "height"=> count($ARR_SERIES[0]["data"]) * 75 + 165,
		   // "height"=> count($ARR_SERIES[0]["data"]) * 150 + 0,
		   // "height"=> count($ARR_SERIES) * 75 + 165,
		   // "height"=> count($ARR_SERIES) * 75 + 0,
		 ],
		 "exporting"=>[
		   "enabled"=>false
		 ],
		 "title"=>[
		   "text"=>$TITLE
		 ],
		 "subtitle"=>[
		   "text"=>null
		 ],
		 "tooltip"=>[
			 "pointFormat" => "<div style='font-size: 9px;'>{series.name}</div>: <b  style='font-size: 9px;'>{point.y:.f}</b><br/>",
			 "valueSuffix" => ' karyawan',
			 "shared" => true
		 ],
		 "xAxis"=> [
			 "categories"=> $X_DATA,
			 "title"=> [
				 "text"=> null
			 ],
			 "gridLineWidth"=> 1,
			 "lineWidth"=> 0
		 ],
		 // "plotOptions"=> [
		 //     "bar"=> [
		 //         "borderRadius"=> '100%',
		 //         "dataLabels"=> [
		 //             "enabled"=> true
		 //         ],
		 //         "groupPadding"=> 0.1
		 //     ]
		 // ],
		 "plotOptions"=> [
			 "series"=> [
				 // "pointWidth"=> 10,
				 "groupPadding"=> 0.1,
				 "pointPadding"=> 0
			 ]
		 ],
		 "yAxis"=> [
			 "min"=> 0,
			 "title"=> [
				 "text"=> 'total karyawan',
				 "align"=> 'high'
			 ],
			 "gridLineWidth"=> 0
		 ],
		 "legend"=>[
		   "enabled"=>true,
		   "itemStyle" => [
			   "fontSize"=>"8px"
		   ]
		 ],
		 "credits"=>[
		   "enabled"=>false
		 ],
		 "series"=> $ARR_SERIES,
		 "responsive"=>[
		   "rules"=>[
			 [
			   "condition"=>[
				 "maxWidth"=>500
			   ],
			   "chartOptions"=>[
				 "legend"=>[
				   "layout"=>"horizontal",
				   "align"=>"center",
				   "verticalAlign"=>"bottom"
				 ]
			   ]
			 ]
		   ]
		 ]
	 ];

	 return $grafik;
 }

 
function downloadSingle($DATA_JSON)
{
	$rowDok = json_decode($DATA_JSON, true);
	$judul_file = $rowDok["nama_file"];
	$file       = $rowDok["file"];
	$link_file  = '<a class="label label-primary" style="padding:5px;" onclick="openAdd(\'uploads/'.$file.'\')"><i class="fa fa-download fa-lg" aria-hidden="true"></i> '.$judul_file.'</a>';

	return $link_file;
}


function downloadMulti($DATA_JSON)
{
	if($DATA_JSON == "")
		return "";

	$ARR_DOKUMEN = json_decode($DATA_JSON, true);

	if(!is_array($ARR_DOKUMEN))
		return "";

	$dok = "";
	foreach($ARR_DOKUMEN as $rowDok)
	{
		$judul_file = $rowDok["nama"];
		$file       = $rowDok["file"];

		$link_file  = '<a class="label label-primary" style="padding:5px;" onclick="openAdd(\'uploads/'.$file.'\')"><i class="fa fa-download fa-lg" aria-hidden="true"></i> '.$judul_file.'</a>';
		
		if($dok == "")
			$dok .= $link_file;
		else
			$dok .= " ".$link_file;

	}
	
	return $dok;
}


function statusPublish($STATUS)
{
	$css = "";
	if($STATUS == "DRAFT")
		$css = "warning";
	if($STATUS == "PUBLISH")
		$css = "success";


	$element  = '<span class="label label-'.$css.'" style="padding:5px 10px 5px 10px; font-size:12px">'.$STATUS.'</span>';
	return $element;
}

function statusAktif($STATUS)
{
	$css = "";
	if($STATUS == "AKTIF")
		$css = "success";
	if($STATUS == "NONAKTIF")
		$css = "danger";


	$element  = '<span class="label label-'.$css.'" style="padding:5px 10px 5px 10px; font-size:12px">'.$STATUS.'</span>';
	return $element;
}




function stukturOrganisasi($reqId, $PARENT_ID, $PARENT_LEVEL)
{

?>
    <ul>
    <?
    $rowResult = KDatabase::query(" SELECT A.PRIMARY_ID, A.LEVEL_ID, A.JABATAN, A.NAMA UNIT_KERJA, B.NAMA pegawai, B.NIK, B.PEGAWAI_ID, COALESCE(B.JENIS_KELAMIN_KODE, 'L') JENIS_KELAMIN FROM struktur_organ A  
                                                            LEFT JOIN pegawai B ON A.JABATAN_KODE = B.JABATAN_KODE
                                                            WHERE A.STRUKTUR_ID = '$reqId' AND PARENT_ID = '$PARENT_ID' 
                                    ORDER BY A.PRIMARY_ID ")->result_array();

    foreach($rowResult as $row)
    {

        $PEGAWAI_ID     = $row["pegawai_id"];
		$NIK           	= $row["nik"];
        $PRIMARY_ID     = $row["primary_id"];
        $NAMA           = $row["pegawai"];
        $JABATAN        = $row["jabatan"];
		$UNIT_KERJA     = $row["unit_kerja"];
        $JENIS_KELAMIN  = $row["jenis_kelamin"];
        $LEVEL_ID       = $row["level_id"];

        


        $FOTO    = "uploads/foto/".$JENIS_KELAMIN.".jpg";
        
        $LINK_FOTO = "uploads/foto/".$NIK.".jpg";
        if(file_exists($LINK_FOTO))
            $FOTO = $LINK_FOTO;
        $LINK_FOTO = "uploads/foto/".$NIK.".jpeg";
        if(file_exists($LINK_FOTO))
            $FOTO = $LINK_FOTO;

        if($PARENT_LEVEL == "1" && $LEVEL_ID == "3")
        {
        ?>
            <li class="node-kosong">
                <ul>
                  <li>
                      <div><img height="100" src="<?=$FOTO?>"></div>
                      <span style="font-size:11px"><?=$NAMA?></span><br>
                      <span class='title'><?=coalesce($JABATAN, $UNIT_KERJA)?></span>
                  

                      <?
                      $adaChild = KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$reqId' AND PARENT_ID = '".$PRIMARY_ID."' ")->row()->ada;

                      if($adaChild > 0)
                          stukturOrganisasi($reqId, $PRIMARY_ID, $LEVEL_ID);
                    //   elseif($adaChild == 0)
                    //       staffDataOrganisasi($PEGAWAI_ID);

                      echo "</li>";
                  ?>
                </ul>
            </li>
        <?
        }
        else
        {
        ?>
            <li>
                <div><img height="100" src="<?=$FOTO?>"></div>
                <span style="font-size:11px"><?=$NAMA?></span><br>
                <span class='title'><?=coalesce($JABATAN, $UNIT_KERJA)?></span>
            

        <?
            $adaChild = KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$reqId' AND PARENT_ID = '".$PRIMARY_ID."' ")->row()->ada;

            if($adaChild > 0)
            {
                stukturOrganisasi($reqId, $PRIMARY_ID, $LEVEL_ID);
            }
            // elseif($adaChild == 0)
            //     staffDataOrganisasi($PEGAWAI_ID);



            echo "</li>";

        }

    }

    $adaChildStaff = KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$reqId' AND PARENT_ID = '$PARENT_ID'  AND LEVEL_ID = '6' ")->row()->ada;
    if($adaChildStaff > 0)
    {



        $sql = " SELECT A.PRIMARY_ID, A.LEVEL_ID, A.JABATAN, B.NAMA pegawai, B.PEGAWAI_ID, COALESCE(B.JENIS_KELAMIN_KODE, 'L') JENIS_KELAMIN FROM struktur_organ A  
                                                            LEFT JOIN pegawai B ON A.JABATAN_ID = B.JABATAN_ID
                                                            WHERE A.STRUKTUR_ID = '$reqId' AND PARENT_ID = '$PARENT_ID' AND LEVEL_ID = '6'
                                    ORDER BY A.PRIMARY_ID ";
        $rowResultStaff = KDatabase::query($sql)->result_array();
    ?>
          <li class="node-staff">
            <div class="daftar-staff">
              <?
              foreach($rowResultStaff as $rowStaff)
              {
              ?>
                <div class="item">
                  <span class="nama"><?=$rowStaff["pegawai"]?></span>
                  <span class="jabatan"><?=$rowStaff["jabatan"]?></span>
                </div>
              <?
              }
              ?>
            </div>
          </li>
    <?
    }


    ?>
    </ul>
    <?

}

function staffDataOrganisasi($ATASAN_ID)
{

    $sql = " SELECT NID, NAMA, JABATAN FROM hirarki_approve WHERE NID_1 = '$ATASAN_ID' ORDER BY NAMA ";
    $rowResult = KDatabase::query($sql)->result_array();

    if(count($rowResult) == 0)
        return;
  ?>

    <ul>
      <li class="node-staff">
        <div class="daftar-staff">
          <?
          foreach($rowResult as $row)
          {
          ?>
            <div class="item">
              <span class="nama"><?=$row["NAMA"]?></span>
              <span class="jabatan"><?=$row["JABATAN"]?></span>
            </div>
          <?
          }
          ?>
        </div>
      </li>
    </ul>
  <?

}





 function stukturOrgan($STRUKTUR_ID, $PARENT_ID, $PARENT_LEVEL, $JABATAN_KODE="")
 {
 
	 ?>
	 <ul>
	 <?
 
	 if(!empty($JABATAN_KODE))
		 $statementJabatan = " AND A.JABATAN_KODE = '$JABATAN_KODE' ";
 
	 $rowResult = KDatabase::query(" SELECT A.PRIMARY_ID, A.LEVEL_ID, A.NAMA, A.JABATAN JABATAN FROM struktur_organ A  
															 WHERE STRUKTUR_ID = '$STRUKTUR_ID' AND PARENT_ID = '$PARENT_ID' ".$statementJabatan."
									 ORDER BY A.PRIMARY_ID ")->result_array();
 
	 foreach($rowResult as $row)
	 {
 
		 $PEGAWAI_ID     = $row["pegawai_id"];
		 $PRIMARY_ID     = $row["primary_id"];
		 $NAMA           = $row["pegawai"];
		 $UNIT_KERJA     = $row["nama"];
		 $JABATAN        = $row["jabatan"];
		 $JENIS_KELAMIN  = $row["jenis_kelamin"];
		 $LEVEL_ID       = $row["level_id"];
 
 
		 $FOTO    = "uploads/foto/".$JENIS_KELAMIN.".jpg";
		 
		 $LINK_FOTO = "uploads/foto/".$PEGAWAI_ID.".jpg";
		 if(file_exists($LINK_FOTO))
			 $FOTO = $LINK_FOTO;
		 $LINK_FOTO = "uploads/foto/".$PEGAWAI_ID.".jpeg";
		 if(file_exists($LINK_FOTO))
			 $FOTO = $LINK_FOTO;
 
		 if($PARENT_LEVEL == "1" && $LEVEL_ID == "3")
		 {
		 ?>
			 <li class="node-kosong">
				 <ul>
				   <li>
					   <span style="font-size:10px"><?=coalesce($JABATAN, $UNIT_KERJA)?></span><br>
					   <?
					   $adaChild = KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$STRUKTUR_ID' AND PARENT_ID = '".$PRIMARY_ID."' ")->row()->ada;
 
					   if($adaChild > 0)
						   stukturOrgan($STRUKTUR_ID, $PRIMARY_ID, $LEVEL_ID);
					   elseif($adaChild == 0)
						   staffData($PEGAWAI_ID);
 
					   echo "</li>";
				   ?>
				 </ul>
			 </li>
		 <?
		 }
		 else
		 {
		 ?>
			 <li>
				 <span style="font-size:10px"><?=coalesce($JABATAN, $UNIT_KERJA)?></span><br>
			 
 
		 <?
			 $adaChild = KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$STRUKTUR_ID' AND PARENT_ID = '".$PRIMARY_ID."' ")->row()->ada;
 
			 if($adaChild > 0)
			 {
				 stukturOrgan($STRUKTUR_ID, $PRIMARY_ID, $LEVEL_ID);
			 }
			 /*elseif($adaChild == 0)
				 staffData($PEGAWAI_ID);*/
 
 
 
			 echo "</li>";
 
		 }
 
	 }
 
	 $adaChildStaff = 0; // KDatabase::query(" SELECT COUNT(1) ADA FROM struktur_organ WHERE STRUKTUR_ID = '$STRUKTUR_ID' AND PARENT_ID = '$PARENT_ID'  AND LEVEL_ID = '6' ")->row()->ada;
	 if($adaChildStaff > 0)
	 {
 
 
		 $sql = " SELECT A.PRIMARY_ID, A.LEVEL_ID, A.NAMA JABATAN FROM struktur_organ A  
															 WHERE STRUKTUR_ID = '$STRUKTUR_ID' AND PARENT_ID = '$PARENT_ID' AND LEVEL_ID = '6'
									 ORDER BY A.PRIMARY_ID ";
		 $rowResultStaff = KDatabase::query($sql)->result_array();
	 ?>
		   <li class="node-staff">
			 <div class="daftar-staff">
			   <?
			   foreach($rowResultStaff as $rowStaff)
			   {
			   ?>
				 <div class="item">
				   <span class="jabatan"><?=$rowStaff["JABATAN"]?></span>
				 </div>
			   <?
			   }
			   ?>
			 </div>
		   </li>
	 <?
	 }
 
 
	 ?>
	 </ul>
	 <?
 
 }
 
 function staffData($ATASAN_ID)
 {
 
	 $sql = " SELECT NID, NAMA, JABATAN FROM hirarki_approve WHERE NID_1 = '$ATASAN_ID' ORDER BY NAMA ";
	 $rowResult = KDatabase::query($sql)->result_array();
 
	 if(count($rowResult) == 0)
		 return;
   ?>
 
	 <ul>
	   <li class="node-staff">
		 <div class="daftar-staff">
		   <?
		   foreach($rowResult as $row)
		   {
		   ?>
			 <div class="item">
			   <span class="nama"><?=$row["JABATAN"]?></span>
			 </div>
		   <?
		   }
		   ?>
		 </div>
	   </li>
	 </ul>
   <?
 
 }


function getBagi($value=0)
{
	$value = explode('.', $value);
	$count = strlen((string)$value[0]);
	$bagi = floor($count / 3);
	if($count % 3 == 0){
		$bagi -= 1;
	}
	$satuan = array("", "rb", "jt", "M", "T");
	$pembagi = pow(1000, $bagi);
	$res[0] = $pembagi;
	$res[1] = $satuan[$bagi];
	return $res;
}

function setChecked($param, $value, $hasil)
{
	if($param == $value)
		return $hasil;


	return "0";
}




function numberToInaPersen($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		
		$resValueNegatif = $resValue;
		$resValue = "-".$resValue."";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
	{
		if($resValueNegatif == "")
		{
			if(substr($resValue, 0, 1) == "-")
				$resValue = "-".str_replace("-", "", $resValue).",".$arr_value[1]."";
			else
				$resValue = $resValue.",".$arr_value[1];
		}
		else
			$resValue = "-".$resValueNegatif.",".$arr_value[1]."";
		
	}
	
	if(substr($resValue, 0, 1) == ',')
		$resValue = '0'.$resValue;	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}


function getTruncatedValue( $value, $precision )
{
	//Casts provided value
	$value = ( string )$value;

	//Gets pattern matches
	preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );

	//Returns the full pattern match
	return $matches[0];            
};
	


function percentView($varId)
{
	if((int)$varId >= 100)
		return str_replace(".", "", numberToInaPersen($varId));
	if((int)$varId <= -100)
		return -100;
	return str_replace(".", ",", str_replace(".", "", numberToInaPersen($varId)));	
}

function konversiBilangan($value)
{
	if($value == 0)
		return 0;
	$resKini = getBagi($value);
	return numberToIna(getTruncatedValue($value/$resKini[0], 2))." ".$resKini[1];
}


function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = "Rp. ".$resValue."";
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";
	$resValue = str_replace("..", ",", $resValue);
	return $resValue;
}

function nomorDigit($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arrValue = explode(".", $value);
	$value = $arrValue[0];
	if(count($arrValue) == 1)
		$belakang_koma = "";
	else
		$belakang_koma = $arrValue[1];
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($belakang_koma == "")
		$resValue = $symbol." ".$resValue;
	else
		$resValue = $symbol." ".$resValue.",".$belakang_koma;
	
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}


function numberToInaMinus($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "-".$resValue."";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}



function numberToInas($value, $reqExcel)
{

  if($reqExcel == "1")
    return $value; 

    
  $symbol=true;
  $minusToBracket=true;
  $minusLess=false;
  $digit=3;

	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}



function numberToKoma($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ",";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.",".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.".".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function numberToInaReport($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	$endValue = "";
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ",";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.",".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.".".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function getNameValueYaTidak($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}

function getNameValueKategori($number) {
	$number = (int)$number;
	$arrValue = array("1"=>"Sangat Baik", "2"=>"Baik", "3"=>"Cukup", "4"=>"Kurang");
	return $arrValue[$number];
}	

function getNameValue($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}	

function getNameValueAktif($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak Aktif", "1"=>"Aktif");
	return $arrValue[$number];
}

function getNameValidasi($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Menunggu Konfirmasi","1"=>"Disetujui", "2"=>"Ditolak");
	return $arrValue[$number];
}	

function getNameInputOutput($char) {
	$arrValue = array("I"=>"Datang", "O"=>"Pulang");
	return $arrValue[$char];
}		
	
function dotToComma($varId)
{
	$newId = str_replace(".", ",", $varId);	
	return $newId;
}

function CommaToQuery($varId)
{
	$newId = str_replace(",", "','", $varId);	
	return $newId;
}

function dotToNo($varId)
{
	$newId = str_replace(".", "", $varId);	
	$newId = str_replace(",", ".", $newId);	
	return $newId;
}
function CommaToNo($varId)
{
	$newId = str_replace(",", "", $varId);	
	return $newId;
}
function CommaTodot($varId)
{
	$newId = str_replace(",", ".", $varId);	
	return $newId;
}

function CrashToNo($varId)
{
	$newId = str_replace("#", "", $varId);	
	return $newId;
}

function StarToNo($varId)
{
	$newId = str_replace("* ", "", $varId);	
	return $newId;
}

function NullDotToNo($varId)
{
	$newId = str_replace(".00", "", $varId);
	return $newId;
}

function ExcelToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = CommaToNo($newId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNull($varId)
{
	if($varId == '')
		return 0;
	else
		return $varId;
}

function ValToNullDB($varId)
{
	if($varId == '')
		return 'NULL';
	elseif($varId == 'null')
		return 'NULL';
	else
		return "'".$varId."'";
}

function setQuote($var, $status='')
{	
	if($status == 1)
		$tmp= str_replace("\'", "''", $var);
	else
		$tmp= str_replace("'", "''", $var);
	return $tmp;
}

// fungsi untuk generate nol untuk melengkapi digit

function generateZero($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";
	
	$lengthZero = $digitGroup - strlen($varId);
	
	for($i = 0; $i < $lengthZero; $i++)
	{
		$newId .= $digitCompletor;
	}
	
	$newId = $newId.$varId;
	
	return $newId;
}

// truncate text into desired word counts.
// to support dropDirtyHtml function, include default.func.php
function truncate($text, $limit, $dropDirtyHtml=true)
{
	$tmp_truncate = array();
	$text = str_replace("&nbsp;", " ", $text);
	$tmp = explode(" ", $text);
	
	for($i = 0; $i <= $limit; $i++)		//truncate how many words?
	{
		try {

			$tmp_truncate[$i] = $tmp[$i];
		} catch (\Throwable $th) {
			return "";
		}
	}
	
	$truncated = implode(" ", $tmp_truncate);
	
	if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
		return dropAllHtml($truncated);
	else
		return $truncated;
}

function arrayMultiCount($array, $field_name, $search)
{
	$summary = 0;
	for($i = 0; $i < count($array); $i++)
	{
		if($array[$i][$field_name] == $search)
			$summary += 1;
	}
	return $summary;
}

function getValueArray($var)
{
	//$tmp = "";
	$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= $var[$i];
		else
			$tmp .= ",".$var[$i];
	}
	
	return $tmp;
}

function getValueArrayMonth($var)
{
	//$tmp = "";
	$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= "'".$var[$i]."'";
		else
			$tmp .= ", '".$var[$i]."'";
	}
	
	return $tmp;
}

function getColoms($var)
{
	$tmp = "";
	if($var == 0)	$tmp = 'D';
	elseif($var == 1)	$tmp = 'E';
	elseif($var == 2)	$tmp = 'F';
	elseif($var == 3)	$tmp = 'G';
	elseif($var == 4)	$tmp = 'H';
	elseif($var == 5)	$tmp = 'I';
	elseif($var == 6)	$tmp = 'J';
	elseif($var == 7)	$tmp = 'K';
	
	return $tmp;
}

function setNULL($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = $var;
	
	return $tmp;
}

function setNULLModif($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = "'".$var."'";
	
	return $tmp;
}

function setVal_0($var)
{	
	if($var == '')
		$tmp = '0';
	else
		$tmp = $var;
	
	return $tmp;
}

function get_null_10($varId)
{
	if($varId == '') return '';
	if($varId < 10)	$temp= '0'.$varId;
	else			$temp= $varId;
			
	return $temp;
}

function _ip() 
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function searchWordDelimeter($varSource, $varSearch, $varDelimeter=",")
{

	$arrSource = explode($varDelimeter, $varSource);
	
	for($i=0; $i<count($arrSource);$i++)
	{
		if(trim($arrSource[$i]) == $varSearch)
			return true;
	}
	
	return false;
}

function getZodiac($day,$month){
	if(($month==1 && $day>20)||($month==2 && $day<20)){
	$mysign = "Aquarius";
	}
	if(($month==2 && $day>18 )||($month==3 && $day<21)){
	$mysign = "Pisces";
	}
	if(($month==3 && $day>20)||($month==4 && $day<21)){
	$mysign = "Aries";
	}
	if(($month==4 && $day>20)||($month==5 && $day<22)){
	$mysign = "Taurus";
	}
	if(($month==5 && $day>21)||($month==6 && $day<22)){
	$mysign = "Gemini";
	}
	if(($month==6 && $day>21)||($month==7 && $day<24)){
	$mysign = "Cancer";
	}
	if(($month==7 && $day>23)||($month==8 && $day<24)){
	$mysign = "Leo";
	}
	if(($month==8 && $day>23)||($month==9 && $day<24)){
	$mysign = "Virgo";
	}
	if(($month==9 && $day>23)||($month==10 && $day<24)){
	$mysign = "Libra";
	}
	if(($month==10 && $day>23)||($month==11 && $day<23)){
	$mysign = "Scorpio";
	}
	if(($month==11 && $day>22)||($month==12 && $day<23)){
	$mysign = "Sagitarius";
	}
	if(($month==12 && $day>22)||($month==1 && $day<21)){
	$mysign = "Capricorn";
	}
	return $mysign;
}

function getValueANDOperator($var)
{
	$tmp = ' AND ';
	
	return $tmp;
}

function getValueKoma($var)
{
	if($var == '')
		$tmp = '';
	else
		$tmp = ',';	
	
	return $tmp;
}

function import_format($val)
{
	if($val == ":02")
	{
		$temp= str_replace(":02","24:00",$val);
	}
	else
	{	
		$temp="";
		if($val == "[hh]:mm" || $val == "[h]:mm"){}
		else
			$temp= $val;
	}
	return $temp;
	//return $val;
}

function kekata($x) 
{
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) 
	{
		$temp = " ". $angka[$x];
	} 
	else if ($x <20) 
	{
		$temp = kekata($x - 10). " belas";
	} 
	else if ($x <100) 
	{
		$temp = kekata($x/10)." puluh". kekata($x % 10);
	} 
	else if ($x <200) 
	{
		$temp = " seratus" . kekata($x - 100);
	} 
	else if ($x <1000) 
	{
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
	} 
	else if ($x <2000) 
	{
		$temp = " seribu" . kekata($x - 1000);
	} 
	else if ($x <1000000) 
	{
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	} 
	else if ($x <1000000000) 
	{
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	} 
	else if ($x <1000000000000) 
	{
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	} 
	else if ($x <1000000000000000) 
	{
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	}      
	
	return $temp;
}

function terbilang($x, $style=4) 
{
	if($x == 0)
	{
		return "nol";
	}
	if($x < 0) 
	{
		$hasil = "minus ". trim(kekata($x));
	} 
	else 
	{
		$hasil = trim(kekata($x));
	}      
	switch ($style) 
	{
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}      
	return $hasil;
}

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
}

function getExe($tipe)
{
	switch ($tipe) {
	  case "application/pdf": $ctype="pdf"; break;
	  case "application/octet-stream": $ctype="exe"; break;
	  case "application/zip": $ctype="zip"; break;
	  case "application/msword": $ctype="doc"; break;
	  case "application/vnd.ms-excel": $ctype="xls"; break;
	  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
	  case "image/gif": $ctype="gif"; break;
	  case "image/png": $ctype="png"; break;
	  case "image/jpeg": $ctype="jpeg"; break;
	  case "image/jpg": $ctype="jpg"; break;
	  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
	  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
	  default: $ctype="application/force-download";
	} 
	
	return $ctype;
} 

function getExtension($varSource)
{
	$temp = explode(".", $varSource);
	return end($temp);
}


function getThumbs($varSource)
{
	$ext = explode(".", $varSource);
	$ext = end($ext);

	$ext = ".".$ext;
	$temp = str_replace($ext, "THUMBS".$ext, $varSource);

	return ($temp);
}

function coalesce($varSource, $varReplace)
{
	
	if($varSource == "")
		return $varReplace;
		
	return $varSource;
}

function coalesceVal($varSource, $varReplace, $varVal="-")
{
	
	if($varSource == "" || $varSource == $varVal)
		return $varReplace;
		
	return $varSource;
}

function getFotoProfile($id)
{
	$filename = "uploads/foto/".$id.".jpg";
	if (file_exists($filename)) {
	} else {
		$filename = "images/img-foto.png";
	}	
	return $filename;
}

function sum_array($array) {
	$total = 0;
	if(empty($array)){}
	else
	{
		foreach ($array as $element) {
			if(is_array($element)) {
				$total += sum_array($element);
			} else {
				$total += $element;
			}
		} 
	}
	return $total;
}

function periode_lalu($periode)
{
	$bulan = substr($periode, 0, 2);
	$tahun = substr($periode, 2, 4);
	
	$bulan = (int)$bulan - 1;
	if($bulan == 0)
		$bulan = "12";
	else
		$bulan = generateZero($bulan, 2);
	
	return $bulan.$tahun;
			
}

function create_default_password($_date)
{
	//PASSWORD MENGAMBIL TAHUN DAN BULAN
	if($_date == "")
	{
		return "peraktimur480";	
	}
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2].generateZero($arrDate[1],2);
	
	return $_date;
}

function aksesMenu($tipe)
{
	if($tipe == "R" || $tipe == "view")	
		return " style='display:none' ";
	else
		return "";
}

function ambil_bpjs_rumus($rumus)
{
	$replace_rumus =  str_replace(['[', '"', '/', ']'], '', $rumus);


	$komponen_rumus = explode(",", $replace_rumus);

	$selain_prosentase = 0;
	$rumus_fix = "";
	for($i=0; $i<count($komponen_rumus); $i++)
	{
		$komponen_rumus_d[] = explode(":", $komponen_rumus[$i]);

		if($komponen_rumus_d[$i][0] == "PROSENTASE")
		{
			if($i == 0)
				$rumus_fix .= ($komponen_rumus_d[$i][1]*100).'% X ';
			else
				$rumus_fix .= ' X '.($komponen_rumus_d[$i][1]*100).'% ';
		}
		else
		{
			$rumus_fix .= ' '.numberToIna($komponen_rumus_d[$i][1]);
		}
	}

	echo $rumus_fix;
	// print_r($komponen_rumus_d);

/*
	foreach($komponen_rumus as $komponen) {
	    $komponen = trim($komponen);
	    $hasil .= $komponen . "<br/>";
	}

	return $hasil;
*/
}

function checkData($data, $search)
{
	$arrData = explode(",", $data);
	for($i=0;$i<count($arrData);$i++)
	{
		if($arrData[$i] == $search)
			return true;
	}	
	
	return false;
}
?>