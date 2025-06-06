<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: date.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle date operations
***************************************************************************************************** */
function validateDate($date, $format = 'Y-m-d') {

	if(trim($date) == "")
		return true;
	
    DateTime::createFromFormat($format, $date);
    $errors = DateTime::getLastErrors();
	
	if(is_array($errors))
	    return $errors['warning_count'] === 0 && $errors['error_count'] === 0;
	else 
		return true;
}

function dateToPage($_date)
{
	if ($_date == "")
		return "";
	$arrDate = explode("-", $_date);
	$_date = $arrDate[0] . "-" . $arrDate[1] . "-" . $arrDate[2];
	return $_date;
}

function dateToPage2($_date)
{
	if ($_date == "")
		return "";
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
	return $_date;
}

function addWIB($_date)
{
	if ($_date == "")
		return $_date;
	else
		return ", " . $_date . " WIB";
}

function datetimeToPage($_date, $_type)
{
	if ($_date == "")
		return "";
	$arrDateTime = explode(" ", $_date);
	if ($_type == "date") {
		$arrDate = explode("-", $arrDateTime[0]);
		$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
		return $_date;
	} else {
		$_date = $arrDateTime[1];
		$arrTime = explode(":", $_date);
		if ($_type == "hour")
			return $arrTime[0];
		elseif ($_type == "minutes")
			return $arrTime[1];
		else
			return $_date;
	}
}

function dateToPageCheck($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
	return $_date;
}

function dateToPageCheck2($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrDate = explode("/", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
	return $_date;
}

function dateTimeToPageCheck($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrDateTime = explode(" ", $_date);
	$arrDate = explode("-", $arrDateTime[0]);

	if ($arrDateTime[1] == "") {
		$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2);
	} else {
		$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2) . " " . $arrDateTime[1];
	}
	return $_date;
}

function dateToDB($_date)
{
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
	return $_date;
}

function dateToDBCheck($_date)
{
	if ($_date == "") {
		return "NULL";
	}
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2);
	return "STR_TO_DATE('" . $_date . "', '%Y-%m-%d')";
}

function dateToDBCheckImport($_date)
{
	if ($_date == "") {
		return "NULL";
	}
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2);
	return "STR_TO_DATE('" . $_date . "', '%d-%m-%Y')";
}

function dateToDBCheckMsql($_date)
{
	if ($_date == "") {
		return "NULL";
	}
	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2);
	return "STR_TO_DATE('" . $_date . "', '%Y-%m-%d')";
}

function dateTimeToDBCheck($_date)
{
	if ($_date == "") {
		return "NULL";
	}
	$arrDateTime = explode(" ", $_date);
	$arrDate = explode("-", $arrDateTime[0]);

	$_date = $arrDate[2] . "-" . generateZeroDate($arrDate[1], 2) . "-" . generateZeroDate($arrDate[0], 2);
	return "STR_TO_DATE('" . $_date . " " . $arrDateTime[1] . "', 'YYYY-MM-DD HH24:MI:SS')";
}

function dateTimeToDBCheck2($_date)
{
	if ($_date == "") {
		return "NULL";
	}
	$arrDateTime = explode(" ", $_date);
	$arrDate = explode("/", $arrDateTime[0]);

	$_date = generateZeroDate($arrDate[0], 2) . "/" . generateZeroDate($arrDate[1], 2) . "/" . $arrDate[2];
	return "TO_TIMESTAMP('" . $_date . " " . $arrDateTime[1] . "', '%d/%m/%Y %H:%i:%s');";
}

function generateZeroDate($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";

	$lengthZero = $digitGroup - strlen($varId);

	for ($i = 0; $i < $lengthZero; $i++) {
		$newId .= $digitCompletor;
	}

	$newId = $newId . $varId;

	return $newId;
}

function setTime($varId, $tempVal)
{
	if ($tempVal == "")
		return "";
	else {
		$value = date('Y-m-d H:i', $varId * 86400 + mktime(0, 0, 0));
		$arrVarId = explode(" ", $value);
		$hari = $arrVarId[0];
		$time = $arrVarId[1];

		//$temp= $value;
		//$temp= $varId;
		$hari_sekarang = date('Y-m-d');
		if ($hari_sekarang == $hari) {
			if (strlen($time) == 5)
				$temp = $time;
			else
				$temp = '0' . $time;
		} else {
			$temp = "24:00";
		}
		//$temp= $value;
		return $temp;
	}
}
function dateMixToDB($_date)
{
	$arrDate = explode("/", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
	return $_date;
}

function datetimeToDB($_datetime)
{
	if ($_datetime == "") {
		return "NULL";
	}
	//		$arrDate = explode("-", $_date);
	//		$_date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
	return "TO_DATE('" . $_datetime . "', 'DD-MM-YYYY:HH24:MI')";
	//return "'".$_date."'";
}

function getDayMonth($_date)
{
	$tanggal = substr($_date, 0, 2);
	$bulan = substr($_date, 2, 4) * 1;

	return $tanggal . ' ' . getNameMonth($bulan);
}

function getDay($_date)
{
	$arrDate = explode("-", $_date);
	return $arrDate[0];
}

function getMonth($_date)
{
	$arrDate = explode("-", $_date);
	return $arrDate[1];
}

function getYear($_date)
{
	$arrDate = explode("-", $_date);
	return $arrDate[2];
}

function getNamePeriode($periode)
{
	$bulan = substr($periode, 0, 2);
	$tahun = substr($periode, 2, 4);

	return getNameMonth((int)$bulan) . " " . $tahun;
}

function getNamePeriodeExt($periode)
{
	$bulan = substr($periode, 0, 2);
	$tahun = substr($periode, 2, 4);

	return getExtMonth((int)$bulan) . " " . $tahun;
}

function getTahunPeriode($periode)
{
	$bulan = substr($periode, 0, 2);
	$tahun = substr($periode, 2, 4);

	return $tahun;
}

function getBulanPeriode($periode)
{
	$bulan = substr($periode, 0, 2);
	$tahun = substr($periode, 2, 4);

	return $bulan;
}

function getHariTanggal($_date)
{

	$arrDate = explode("-", $_date);
	$_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];

	$hari = date('w', strtotime($_date));

	switch ($hari) {
		case 0:
			$hari = "Minggu";
			break;
		case 1:
			$hari = "Senin";
			break;
		case 2:
			$hari = "Selasa";
			break;
		case 3:
			$hari = "Rabu";
			break;
		case 4:
			$hari = "Kamis";
			break;
		case 5:
			$hari = "Jum'at";
			break;
		case 6:
			$hari = "Sabtu";
			break;
	}
	return $hari;
}

function getHari($hari)
{
	switch ($hari) {
		case 0:
			$hari = "Minggu";
			break;
		case 1:
			$hari = "Senin";
			break;
		case 2:
			$hari = "Selasa";
			break;
		case 3:
			$hari = "Rabu";
			break;
		case 4:
			$hari = "Kamis";
			break;
		case 5:
			$hari = "Jum'at";
			break;
		case 6:
			$hari = "Sabtu";
			break;
	}
	return $hari;
}

function getHariInggris($hari)
{
	switch ($hari) {
		case 'Sun':
			$hari = "Minggu";
			break;
		case 'Mon':
			$hari = "Senin";
			break;
		case 'Tue':
			$hari = "Selasa";
			break;
		case 'Wed':
			$hari = "Rabu";
			break;
		case 'Thu':
			$hari = "Kamis";
			break;
		case 'Fri':
			$hari = "Jum'at";
			break;
		case 'Sat':
			$hari = "Sabtu";
			break;
	}
	return $hari;
}

function getHariEn($hari)
{
	switch ($hari) {
		case 0:
			$hari = "Sunday";
			break;
		case 1:
			$hari = "Monday";
			break;
		case 2:
			$hari = "Tuesday";
			break;
		case 3:
			$hari = "Wednesday";
			break;
		case 4:
			$hari = "Thursday";
			break;
		case 5:
			$hari = "Friday";
			break;
		case 6:
			$hari = "Saturday";
			break;
	}
	return $hari;
}

function getNameMonth($number)
{
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);
	return $arrMonth[$number];
}

function getNameMonth2($number)
{
	$arrMonth = array(
		"01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei",
		"06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);
	return $arrMonth[$number];
}

function getNameDay($number)
{
	$arrMonth = array(
		"0" => "Minggu", "1" => "Senin", "2" => "Selasa", "3" => "Rabu", "4" => "Kamis",
		"5" => "Jum'at", "6" => "Sabtu"
	);
	return $arrMonth[$number];
}

function getExtMonth($number)
{
	$arrMonth = array(
		"1" => "Jan", "2" => "Feb", "3" => "Mar", "4" => "Apr", "5" => "Mei",
		"6" => "Jun", "7" => "Jul", "8" => "Agt", "9" => "Sept", "10" => "Okt",
		"11" => "Nov", "12" => "Des"
	);
	return $arrMonth[$number];
}

function getBulanIndo($month)
{
	$arrMonth = array(
		"Jan" => "Januari", "Feb" => "Februari", "Mar" => "Maret", "Apr" => "April", "May" => "Mei",
		"Juni" => "Jun", "Jul" => "Juli", "Aug" => "Agustus", "Sep" => "September", "Oct" => "Oktober",
		"Nov" => "November", "Dec" => "Dessember"
	);
	return $arrMonth[$month];
}

function getBulanAngka($month)
{
	$arrMonth = array(
		"Jan" => "01", "Feb" => "02", "Mar" => "03", "Apr" => "04", "May" => "05",
		"Jun" => "06", "Jul" => "07", "Aug" => "08", "Sep" => "09", "Oct" => "10",
		"Nov" => "11", "Dec" => "12"
	);
	return $arrMonth[$month];
}

function getRomawiMonth($number)
{
	$arrMonth = array(
		"01" => "I", "02" => "II", "03" => "III", "04" => "IV", "05" => "V",
		"06" => "VI", "07" => "VII", "08" => "VIII", "09" => "IX", "10" => "X",
		"11" => "XI", "12" => "XII"
	);
	return $arrMonth[$number];
}

// date input : database
function getFormattedDateJson($_date)
{
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);


	$date = '' . $arrDate[0] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[2] . '';

	//$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
	return $date;
}

function getValueDate($_date)
{
	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$jumHari = cal_days_in_month(CAL_GREGORIAN, $_month, $arrDate[0]);
	$date = $jumHari;

	return $date;
}

function getFormattedDate($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = '' . $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0] . '';
	return $date;
}

function getFormattedDateDMY($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = '' . $arrDate[0] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[2] . '';
	return $date;
}

function getFormattedDateExt($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrMonth = array("1"=>"Jan", "2"=>"Feb", "3"=>"Mar", "4"=>"Apr", "5"=>"Mei", 
					  "6"=>"Jun", "7"=>"Jul", "8"=>"Agt", "9"=>"Sept", "10"=>"Okt", 
					  "11"=>"Nov", "12"=>"Des");

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = '' . $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0] . '';
	return $date;
}


function getFormattedDateReport($_date)
{
	$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
					  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
					  "11"=>"November", "12"=>"Desember");

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = ''.$arrDate[0].' '.$arrMonth[$_month].' '.$arrDate[2].'';
	return $date;
}



function getFormattedDate2($_date)
{
	if ($_date == "") {
		return "";
	}
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = '' . $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0] . '';
	return $date;
}

// date from view
function getFormattedDateView($_date)
{
	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $_date);
	$_month = intval($arrDate[1]);

	$date = $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0];
	return $date;
}

// date input : database
function getFormattedDateTime($_date, $showTime = true)
{
	if ($_date == "") {
		return "";
	}


	$_date = explode(" ", $_date);

	
	if(!is_array($_date))
		return "";

	try {

		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
	} catch (\Throwable $th) {
		return "";
	}


	if ($explodedTime == "") {
		$showTime = false;
	}

	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $explodedDate);
	$_month = intval($arrDate[1]);

	$date = $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0];
	$timeExplode = explode(".", $explodedTime);
	$time = $timeExplode[0];

	if ($showTime == true)
		$datetime = $date . ',&nbsp;' . $time;
	else
		$datetime = '<span style="white-space:nowrap">' . $date . '</span>';
	return $datetime;
}


function getFormattedDateTimeDMY($_date, $showTime = true)
{
	if ($_date == "") {
		return "";
	}


	$_date = explode(" ", $_date);

	
	if(!is_array($_date))
		return "";

	try {

		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
	} catch (\Throwable $th) {
		return "";
	}


	if ($explodedTime == "") {
		$showTime = false;
	}

	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $explodedDate);
	$_month = intval($arrDate[1]);

	$date = $arrDate[0] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[2];
	$timeExplode = explode(".", $explodedTime);
	$time = $timeExplode[0];

	if ($showTime == true)
		$datetime = $date . ',&nbsp;' . $time;
	else
		$datetime = '<span style="white-space:nowrap">' . $date . '</span>';
	return $datetime;
}

function getFormattedDateTime2($_date)
{
	$_date = explode(" ", $_date);

	$date = $_date[1] . " " . $_date[2] . " " . $_date[4];
	return $date;
}

function getFormattedDateTime3($_date)
{
	if (!$_date) {
		return '-';
	}
	$_date = explode(" ", $_date);

	$time = explode(".", $_date[3]);

	$date = $_date[1] . " " . $_date[2] . " " . $_date[4] . ", " . $time[0];
	return $date;
}

function getFormattedDateTime4($_date)
{
	$_date = explode(" ", $_date);

	$time = explode(".", $_date[3]);

	$date = $_date[1] . "-" . getBulanAngka($_date[2]) . "-" . $_date[4] . ", " . $time[0];
	return $date;
}

// date input : database
function getFormattedDateTimeCheck($_date, $showTime = true)
{
	if ($_date == "") {
		return "";
	}

	$_date = explode(" ", $_date);
	$explodedDate = $_date[0];
	$explodedTime = $_date[1];

	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $explodedDate);
	$_month = intval($arrDate[1]);

	$date = $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0];
	$time = $explodedTime;

	if ($showTime == true)
		$datetime = $date . ',&nbsp;' . $time;
	else
		$datetime = '<span style="white-space:nowrap">' . $date . '</span>';
	return $datetime;
}

// date input : database
function getFormattedDateTimeNoSpace($_date, $showTime = true)
{
	$_date = explode(" ", $_date);
	$explodedDate = $_date[0];
	$explodedTime = $_date[1];

	$arrMonth = array(
		"1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei",
		"6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$arrDate = explode("-", $explodedDate);
	$_month = intval($arrDate[1]);

	$date = $arrDate[2] . ' ' . $arrMonth[$_month] . ' ' . $arrDate[0];
	$time = $explodedTime;

	if ($showTime == true)
		$datetime = $date . ' ' . substr($time, 0, 5);
	else
		$datetime = '<span style="white-space:nowrap">' . $date . '</span>';
	return $datetime;
}

function getJumlahHariTanpaWeekend($tanggal_awal, $tanggal_akhir)
{
	$tanggal = $tanggal_awal;
	while ($tanggal == $tanggal_akhir) {
	}
}
function add_date($givendate, $day = 0, $mth = 0, $yr = 0)
{
	$cd = strtotime($givendate);
	$newdate = date('Y-m-d h:i:s', mktime(
		date('h', $cd),
		date('i', $cd),
		date('s', $cd),
		date('m', $cd) + $mth,
		date('d', $cd) + $day,
		date('Y', $cd) + $yr
	));

	return $newdate;
}

function getSelectFormattedDate($_date)
{
	$arrMonth = array(
		"01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei",
		"06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober",
		"11" => "November", "12" => "Desember"
	);

	$date = $arrMonth[$_date];
	return $date;
}


function getNameMonthEn($number)
{

	$arrMonth = array(
		"1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May",
		"6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October",
		"11" => "November", "12" => "December"
	);

	return $arrMonth[$number];
}

function maxHariPeriode($reqPeriode)
{
	$reqTahun = substr($reqPeriode, 2, 4);
	$reqBulan = substr($reqPeriode, 0, 2);
	$date = $reqTahun . '-' . $reqBulan;
	return date("t", strtotime($date));
}

function getNamaHari($hari, $bulan, $tahun)
{
	//$x= mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$x = mktime(0, 0, 0, $bulan, $hari, $tahun);
	$namahari = date("l", $x);

	if ($namahari == "Sunday") $namahari = "Minggu";
	else if ($namahari == "Monday") $namahari = "Senin";
	else if ($namahari == "Tuesday") $namahari = "Selasa";
	else if ($namahari == "Wednesday") $namahari = "Rabu";
	else if ($namahari == "Thursday") $namahari = "Kamis";
	else if ($namahari == "Friday") $namahari = "Jumat";
	else if ($namahari == "Saturday") $namahari = "Sabtu";

	return $namahari;
}

function getNamaHariIndo($hari)
{
	$hari = trim($hari, " ");

	if ($hari == "Sunday") $hari = "Minggu";
	else if ($hari == "Monday") $hari = "Senin";
	else if ($hari == "Tuesday") $hari = "Selasa";
	else if ($hari == "Wednesday") $hari = "Rabu";
	else if ($hari == "Thursday") $hari = "Kamis";
	else if ($hari == "Friday") $hari = "Jumat";
	else if ($hari == "Saturday") $hari = "Sabtu";


	return $hari;
}


function isDateCheckValNew($date, $format = 'd-m-Y')
{
	$boolean = $date == date($format,strtotime($date));
	if($boolean){
		return 1;
	}else{
		return 0;
	}
}
