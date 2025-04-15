<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use KDatabase;

use App\Models\SertifikatToefl;

class ComboController extends Controller 
{



    public function route_web()
    {
        
        Route::get('combo_json/provinsi', [ComboController::class, 'provinsi'])->middleware('auth');
        Route::get('combo_json/kota', [ComboController::class, 'kota'])->middleware('auth');
        Route::get('combo_json/kota_text', [ComboController::class, 'kota_text'])->middleware('guest');
        Route::get('combo_json/kecamatan', [ComboController::class, 'kecamatan'])->middleware('auth');
        Route::get('combo_json/kelurahan', [ComboController::class, 'kelurahan'])->middleware('auth');
        Route::get('combo_json/pendidikan', [ComboController::class, 'pendidikan'])->middleware('auth');
        Route::get('combo_json/sertifikat', [ComboController::class, 'sertifikat'])->middleware('auth');
        Route::get('combo_json/toefl', [ComboController::class, 'toefl'])->middleware('auth');
        
    }
	

	public function toefl(Request $request)
	{
		/* create objects */
		$sertifikat = new SertifikatToefl();

		$reqId = $request->reqId;

		$sertifikat->selectByParams(array("SERTIFIKAT_PARENT_ID" => "0"));
		//echo $sertifikat->query;
		$arr_json = array();
		$i = 0;

		while ($sertifikat->nextRow()) {
			$arr_json[$i]['id'] = $sertifikat->getField("SERTIFIKAT_TOEFL_ID");
			$arr_json[$i]['text'] = $sertifikat->getField("NAMA");
			$arr_json[$i]['SKOR'] = "(".$sertifikat->getField("SKOR_MINIMAL")." - ".$sertifikat->getField("SKOR_MAKSIMAL").")";
			
			$sertifikat_child = new SertifikatToefl();
			$sertifikat_child->selectByParams(array("SERTIFIKAT_PARENT_ID" => $sertifikat->getField("SERTIFIKAT_TOEFL_ID")));
			$arr_child = array();
			$j = 0;
			while($sertifikat_child->nextRow())
			{
				$arr_child[$j]['id'] = $sertifikat_child->getField("SERTIFIKAT_TOEFL_ID");
				$arr_child[$j]['text'] = $sertifikat_child->getField("NAMA");
				$arr_child[$j]['SKOR'] = "(".$sertifikat_child->getField("SKOR_MINIMAL")." - ".$sertifikat_child->getField("SKOR_MAKSIMAL").")";
				$j++;
			}
			
			$arr_json[$i]['children'] = $arr_child;
			$i++;
		}

		echo json_encode($arr_json);
	}

	
	function sertifikat(Request $request)
	{

        $sql = " SELECT 
                    sertifikat_id, nama
                    FROM sertifikat a
				WHERE 1 = 1 
                ORDER BY a.sertifikat_id ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["sertifikat_id"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}


	function pendidikan(Request $request)
	{

        $sql = " SELECT 
                    pendidikan_id, urut, nama
                    FROM pendidikan a
				WHERE 1 = 1 AND pendidikan_id > 10002
                ORDER BY a.urut ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["pendidikan_id"];
			$arr_json[$i]['urut']	= $row["urut"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}

	function kelurahan(Request $request)
	{

		$kecamatan_id = $request->reqKecamatan;

		$statement = " and kecamatan_id = '$kecamatan_id' ";

        $sql = " SELECT 
                    kelurahan_id, nama
                    FROM kelurahan a
				WHERE 1 = 1 ".$statement."
                ORDER BY a.nama ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["kelurahan_id"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}


	function kecamatan(Request $request)
	{

		$kota_id = $request->reqKota;

		$statement = " and kota_id = '$kota_id' ";

        $sql = " SELECT 
                    kecamatan_id, nama
                    FROM kecamatan a
				WHERE 1 = 1 ".$statement."
                ORDER BY a.nama ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["kecamatan_id"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}

	function kota(Request $request)
	{

		$provinsi_id = $request->reqProvinsi;
		
		if(!empty($provinsi_id))
			$statement = " and provinsi_id = '$provinsi_id' ";

        $sql = " SELECT 
                    kota_id, nama
                    FROM kota a
				WHERE 1 = 1 ".$statement."
                ORDER BY a.nama ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["kota_id"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}

	function kota_text(Request $request)
	{

        $sql = " SELECT 
                    kota_id, nama
                    FROM kota a
				WHERE 1 = 1 
                ORDER BY a.nama ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["nama"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}

	function provinsi()
	{

        $sql = " SELECT 
                    provinsi_id, nama
                    FROM provinsi a
				WHERE 1 = 1 
                ORDER BY a.nama ASC  ";

		$rowResult = KDatabase::query($sql)->result_array();
		$i = 0;
		$arr_json = array();
		foreach ($rowResult as $row)
		{
			$arr_json[$i]['id']		= $row["provinsi_id"];
			$arr_json[$i]['text']	= $row["nama"];
			$i++;
		}
		
		echo json_encode($arr_json);

	}


}