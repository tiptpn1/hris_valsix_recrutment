<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use KDatabase;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Http\Controllers\web\DemografiController;
use App\Http\Controllers\web\DemografiTidakTetapController;
use App\Http\Controllers\web\DemografiKbumnController;
use App\Http\Controllers\web\DemografiPenugasanController;
use App\Http\Controllers\web\DemografiMagentaController;
use App\Http\Controllers\web\DemografiRincianJabatanController;

class TemplateController extends Controller 
{

    
    private $rows;
    private $map;
    private $heading;
    private $title;



    public function route_web()
    {
        Route::get('/template/riwayat_pelatihan', [TemplateController::class, 'template_riwayat_pelatihan']);
        Route::get('/template/riwayat_pendidikan/{REGIONAL_KODE}', [TemplateController::class, 'template_riwayat_pendidikan']);
        Route::get('/template/riwayat_rangkap_jabatan', [TemplateController::class, 'template_riwayat_rangkap_jabatan']);
        Route::get('/template/riwayat_penugasan', [TemplateController::class, 'template_riwayat_penugasan']);
        Route::get('/template/riwayat_jabatan_hris', [TemplateController::class, 'template_riwayat_jabatan_hris']);
        Route::get('/template/riwayat_jabatan/{REGIONAL_KODE}', [TemplateController::class, 'template_riwayat_jabatan']);
        Route::get('/template/komoditi_kso/', [TemplateController::class, 'template_komoditi_kso']);
        Route::get('/template/pegawai_disabilitas/', [TemplateController::class, 'pegawai_disabilitas']);
        Route::get('/template/magenta/', [TemplateController::class, 'magenta']);
        Route::get('/template/job_profil/', [TemplateController::class, 'job_profil']);
        Route::get('/template/jabatan/', [TemplateController::class, 'template_jabatan']);
        Route::get('/template/area/', [TemplateController::class, 'template_area']);

        Route::post('/report/demografi_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_detil']);
        Route::post('/report/demografi_tidak_tetap_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_tidak_tetap_detil']);
        Route::post('/report/demografi_kbumn_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_kbumn_detil']);
        Route::post('/report/demografi_penugasan_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_penugasan_detil']);
        Route::post('/report/demografi_magenta_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_magenta_detil']);
        Route::post('/report/demografi_rincian_jabatan_detil/{FORM_ID}', [TemplateController::class, 'report_demografi_rincian_jabatan_detil']);
        Route::post('/report/dinamis', [TemplateController::class, 'report_dinamis']);

        
        Route::post('/report/demografi_karyawan/{FORM_ID}', [TemplateController::class, 'demografi_karyawan']);
        Route::post('/report/demografi_karyawan_tidak_tetap/{FORM_ID}', [TemplateController::class, 'demografi_karyawan_tidak_tetap']);
        Route::post('/report/demografi_karyawan_kbumn/{FORM_ID}', [TemplateController::class, 'demografi_karyawan_kbumn']);
        Route::post('/report/demografi_karyawan_penugasan/{FORM_ID}', [TemplateController::class, 'demografi_karyawan_penugasan']);
        Route::post('/report/demografi_magenta/{FORM_ID}', [TemplateController::class, 'demografi_magenta']);
        Route::post('/report/demografi_rincian_jabatan/bod/{FORM_ID}/{KATEGORI_JABATAN_KODE}', [TemplateController::class, 'demografi_rincian_jabatan']);
        
        Route::post('/report/demografi_formasi_karyawan', [TemplateController::class, 'demografi_formasi_karyawan']);
        Route::post('/report/demografi_mpp', [TemplateController::class, 'demografi_mpp']);
        
    }

    
    
    public function demografi_mpp(Request $request)
    {

        $fileName = "demografi_mpp";
        $fileName = strtoupper($fileName);
        
        $arrResult = DemografiController::rekap_mpp($request, "JSON");
        $arrResultKolom = array( "REGIONAL", "DIREKTORAT", "KOMODITI", 
                           "BIDANG_JABATAN", "BIDANG_KERJA", "KATEGORI_JABATAN", "JABATAN_UTAMA", "MAN_POWER",
                           "TETAP", "PKWT", "HL", "OUTSOURCE", "TIDAK_TETAP", "TOTAL", "SELISIH");
        $judulKolom = array("REGIONAL", "DIREKTORAT", "KOMODITI", 
                                "BIDANG JABATAN", "BIDANG KERJA", "KATEGORI JABATAN", "JABATAN UTAMA", "MAN POWER",
                                "TETAP", "PKWT", "HL", "OUTSOURCE", "TIDAK TETAP", "TOTAL", "SELISIH");

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }

    public function demografi_formasi_karyawan(Request $request)
    {

        $fileName = "demografi_formasi_karyawan";
        $fileName = strtoupper($fileName);
        
        $arrResult = DemografiController::formasi_karyawan($request, "JSON");
        $arrResultKolom = array( "ORG_JABATAN", "NAMA", "JENIS_KELAMIN_KODE", "KELOMPOK_GRADE", "KATEGORI_JABATAN_KODE", "NIK", "KELOMPOK_PEGAWAI", 
                                    "USIA", "TANGGAL_MASUK", "TANGGAL_PENGANGKATAN_KARPIM", "TMT_JABATAN", "TAHUN_JABATAN", "BULAN_JABATAN", "TANGGAL_MBT", 
                                    "TANGGAL_PENSIUN", "PENDIDIKAN_TERAKHIR", "PENUGASAN");
        $judulKolom = array("JABATAN", "NAMA", "L/P", "PERSON GRADE", "JOB GRADE", "NIK SAP", "STATUS", 
                            "UMUR", "TMT KERJA", "TGL. DIANGKAT", "TMT DI B/D/K/U", "LAMA DI B/D/K/U (TAHUN)", "LAMA DI B/D/K/U (BULAN)", "MBT", 
                            "PENSIUN", "PENDIDIKAN", "PENUGASAN");

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    public function demografi_rincian_jabatan(Request $request, $FORM_ID="", $KATEGORI_JABATAN_KODE="")
    {

        $fileName = "demografi_rincian_jabatan_".$FORM_ID;
        $fileName = strtoupper($fileName);
        
        if(stristr($FORM_ID,  "bod"))
        {
            $arrResult = DemografiRincianJabatanController::bod($request, $FORM_ID, $KATEGORI_JABATAN_KODE, "JSON");
            $arrResultKolom = array("NAMA", "TETAP", "TIDAK_TETAP", "TOTAL");
            $judulKolom = array($KATEGORI_JABATAN_KODE, "TETAP", "TIDAK_TETAP", "TOTAL");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    
    public function demografi_magenta(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if(stristr($FORM_ID,  "peserta"))
        {
            $arrResult = DemografiMagentaController::peserta($request, "JSON");
            $arrResultKolom = array("NAMA", "TANGGAL_AWAL", "TANGGAL_AKHIR", "TARGET", "REALISASI", "KETERANGAN");
            $judulKolom = array("BATCH", "TANGGAL_AWAL", "TANGGAL_AKHIR", "TARGET", "REALISASI", "KETERANGAN");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }



    public function demografi_karyawan_penugasan(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        $aColumnsJudul = array("LEVEL JABATAN");
        $aColumns = array("KODE");
        if(stristr($FORM_ID,  "tugas"))
        {
            $arrResult = DemografiPenugasanController::tugas($request, "JSON");

            $res = DB::table('regional_grup')->orderBy('regional_grup.regional_grup_id', 'asc')->get();
            $res = array_map(function($item) {
                return (array)$item; 
            }, $res->toArray());
            $resKolom = array_column($res, 'kode');
            $resJudul = array_column($res, 'nama');
            
            $aColumnsJudul = array_merge($aColumnsJudul, $resJudul);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TOTAL"]);

            $aColumns = array_merge($aColumns, $resKolom);
            $aColumns = array_merge($aColumns, ["TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }




    public function demografi_karyawan_kbumn(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if(stristr($FORM_ID,  "wilayah"))
        {
            $arrResult = DemografiKbumnController::wilayah($request, "JSON");
            $arrResultKolom = array("NAMA", "TETAP_KARPIM","TETAP_KARPEL", "TIDAK_KARPIM", "TIDAK_KARPEL", "TOTAL");
            $judulKolom = array("WILAYAH INDONESIA", "KARYAWAN TETAP (KARPIM)","KARYAWAN TETAP (KARPEL)", "KARYAWAN TIDAK TETAP (KARPIM)", "KARYAWAN TIDAK TETAP (KARPEL)", "TOTAL");
        }
        elseif(stristr($FORM_ID,  "disabilitas"))
        {
            $arrResult = DemografiKbumnController::disabilitas($request, "JSON");

            $arrResultKolom = array( "NAMA", "TETAP_KARPIM","TETAP_KARPEL", "TIDAK_KARPIM", "TIDAK_KARPEL", "TOTAL");
            $judulKolom = array("KATEGORI DISABILITAS", "KARYAWAN TETAP (KARPIM)","KARYAWAN TETAP (KARPEL)", "KARYAWAN TIDAK TETAP (KARPIM)", "KARYAWAN TIDAK TETAP (KARPEL)", "TOTAL");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    
    public function demografi_karyawan_tidak_tetap(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if(stristr($FORM_ID,  "gender"))
        {
            $arrResult = DemografiTidakTetapController::gender($request, "JSON");
            $arrResultKolom = array("KODE", "L_KARPIM","P_KARPIM", "TD_KARPIM", "L_KARPEL","P_KARPEL", "TD_KARPEL");
            $judulKolom = array("STATUS KARYAWAN", "L (KARPIM)","P (KARPIM)", "TTANPA DATAD (KARPIM)", "L (KARPEL)","P (KARPEL)", "TANPA DATA (KARPEL)");
        }
        elseif(stristr($FORM_ID,  "unitkerja"))
        {
            $arrResult = DemografiTidakTetapController::unitkerja($request, "JSON");

            $arrResultKolom = array( "KODE", 
                            "HO_KARPIM","DISTRIK_KARPIM", "KEBUN_KARPIM", "PABRIK_KARPIM", 
                            "HO_KARPEL","DISTRIK_KARPEL", "KEBUN_KARPEL", "PABRIK_KARPEL", 
                            "TOTAL");
            $judulKolom = array("STATUS KARYAWAN", 
                            "HO (KARPIM)","DISTRIK (KARPIM)", "KEBUN (KARPIM)", "PABRIK (KARPIM)", 
                            "HO (KARPEL)","DISTRIK (KARPEL)", "KEBUN (KARPEL)", "PABRIK (KARPEL)", 
                            "TOTAL");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    public function demografi_karyawan(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        $aColumnsJudul = array("LEVEL JABATAN");
        $aColumns = array("KODE");
        if(stristr($FORM_ID,  "pendidikan"))
        {
            $arrResult = DemografiController::pendidikan($request, "JSON");

            $res = DB::table('tingkat_pendidikan')->select('tingkat_pendidikan.kode')->orderBy('tingkat_pendidikan.tingkat_pendidikan_id', 'asc')->get();
            $res = array_map(function($item) {
                return (array)$item; 
            }, $res->toArray());
            $res = array_column($res, 'kode');
            
            $aColumnsJudul = array_merge($aColumnsJudul, $res);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TANPA DATA", "TOTAL"]);

            $aColumns = array_merge($aColumns, $res);
            $aColumns = array_merge($aColumns, ["TANPA_DATA", "TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }
        elseif(stristr($FORM_ID,  "grading"))
        {
            $arrResult = DemografiController::grading($request, "JSON");

            $res = DB::table('grade_utama')->orderBy('kode', 'asc')->get();
            $res = array_map(function($item) {
                return (array)$item; 
            }, $res->toArray());
            $resKolom = array_column($res, 'kolom');
            $resJudul = array_column($res, 'kode');
            
            $aColumnsJudul = array_merge($aColumnsJudul, $resJudul);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TANPA DATA", "TOTAL"]);

            $aColumns = array_merge($aColumns, $resKolom);
            $aColumns = array_merge($aColumns, ["TANPA_DATA", "TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }
        elseif(stristr($FORM_ID,  "gender"))
        {
            $arrResult = DemografiController::gender($request, "JSON");

            $res = DB::table('jenis_kelamin')->select('kode')->orderBy('kode', 'asc')->get();
            $res = array_map(function($item) {
                return (array)$item; 
            }, $res->toArray());
            $res = array_column($res, 'kode');;
            
            $aColumnsJudul = array_merge($aColumnsJudul, $res);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TANPA DATA", "TOTAL"]);

            $aColumns = array_merge($aColumns, $res);
            $aColumns = array_merge($aColumns, ["TANPA_DATA", "TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }
        elseif(stristr($FORM_ID,  "unitkerja"))
        {
            $arrResult = DemografiController::unitkerja($request, "JSON");

            $arrResultKolom = array("KODE", "HO", "DISTRIK", "KEBUN", "PABRIK", "TOTAL");
            $judulKolom = array("LEVEL JABATAN", "HO", "DISTRIK", "KEBUN", "PABRIK", "TOTAL");
        }
        elseif(stristr($FORM_ID,  "usia"))
        {
            $arrResult = DemografiController::usia($request, "JSON");

            $arrResultKolom = array("KODE", "U26", "U2630", "U3135", "U3640", "U4145", "U4650", "U51", "TOTAL");
            $judulKolom = array("LEVEL JABATAN", "<26", "26-30", "31-35", "36-40", "41-45", "46-50", ">50", "TOTAL");
        }
        elseif(stristr($FORM_ID,  "status"))
        {
            $arrResult = DemografiController::status($request, "JSON");

            $arrResultKolom = array("KODE", 
                                    "HO_AKTIF", "HO_PENUGASAN", "HO_MBT", "HO_CDT", "HO_TANPA_DATA", 
                                    "DISTRIK_AKTIF", "DISTRIK_PENUGASAN", "DISTRIK_MBT", "DISTRIK_CDT", "DISTRIK_TANPA_DATA",
                                    "KEBUN_AKTIF", "KEBUN_PENUGASAN", "KEBUN_MBT", "KEBUN_CDT", "KEBUN_TANPA_DATA",
                                    "PABRIK_AKTIF", "PABRIK_PENUGASAN", "PABRIK_MBT", "PABRIK_CDT", "PABRIK_TANPA_DATA", 
                                    "TOTAL");
            $judulKolom = array("LEVEL JABATAN", "HO (AKTIF", "HO (PENUGASAN)",  "HO (MBT)",  "HO (CDT)",  "HO (TANPA DATA)",  
                            "DISTRIK (AKTIF)",  "DISTRIK (PENUGASAN)",  "DISTRIK (MBT)",  "DISTRIK (CDT)",  "DISTRIK (TANPA DATA)",  
                            "KEBUN (AKTIF)",  "KEBUN (PENUGASAN)",  "KEBUN (MBT)",  "KEBUN (CDT)",  "KEBUN (TANPA DATA)", 
                            "PABRIK (AKTIF)",  "PABRIK (PENUGASAN)",  "PABRIK (MBT)",  "PABRIK (CDT)",  "PABRIK (TANPA DATA)",  "TOTAL");
        }
        elseif(stristr($FORM_ID,  "aktif_mbt_cdt"))
        {
            $arrResult = DemografiController::status($request, "JSON");

            $arrResultKolom = array("KODE", "HO_AKTIF", "HO_MBT", "HO_CDT", 
                                    "DISTRIK_AKTIF", "DISTRIK_MBT", "DISTRIK_CDT", 
                                    "KEBUN_AKTIF", "KEBUN_MBT", "KEBUN_CDT", 
                                    "PABRIK_AKTIF", "PABRIK_MBT", "PABRIK_CDT", "TOTAL_AKTIF_MBT_CDT");
            $judulKolom = array("LEVEL JABATAN", "HO (AKTIF)", "HO (MBT)", "HO (CDT)", 
                                    "DISTRIK (AKTIF)", "DISTRIK (MBT)", "DISTRIK (CDT)", 
                                    "KEBUN (AKTIF)", "KEBUN (MBT)", "KEBUN (CDT)", 
                                    "PABRIK (AKTIF)", "PABRIK (MBT)", "PABRIK (CDT)", "TOTAL");
        }
        elseif(stristr($FORM_ID,  "penugasan"))
        {
            $arrResult = DemografiController::status($request, "JSON");

            $arrResultKolom = array("KODE", "HO_PENUGASAN", "DISTRIK_PENUGASAN", "KEBUN_PENUGASAN", "PABRIK_PENUGASAN", "TOTAL_PENUGASAN");
            $judulKolom = array("LEVEL JABATAN", "HO", "DISTRIK", "KEBUN", "PABRIK", "TOTAL");
        }
        elseif(stristr($FORM_ID,  "mbt"))
        {
            $arrResult = DemografiController::mbt($request, "JSON");

            $AWAL   = $request->AWAL;
            $AKHIR  = $request->AKHIR;
            $AWAL = coalesce($AWAL, date("Y"));
            $AKHIR = coalesce($AKHIR, date("Y")+5);
    
            $aColumns = array("KODE");
            $aColumnsJudul = array("LEVEL JABATAN");
    
            $res = [];
            $arrTahun = [];
            for($i=$AWAL;$i<=$AKHIR;$i++)
            {
                $res[] = "JUMLAH_".$i;
                $arrTahun[] = $i;
            }
            $aColumns = array_merge($aColumns, $res);
            $aColumns = array_merge($aColumns, ["TOTAL"]);
            $aColumnsJudul = array_merge($aColumnsJudul, $arrTahun);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }
        elseif(stristr($FORM_ID,  "pensiun"))
        {
            $arrResult = DemografiController::pensiun($request, "JSON");

            $AWAL   = $request->AWAL;
            $AKHIR  = $request->AKHIR;
            $AWAL = coalesce($AWAL, date("Y"));
            $AKHIR = coalesce($AKHIR, date("Y")+5);
    
            $aColumns = array("KODE");
            $aColumnsJudul = array("LEVEL JABATAN");
    
            $res = [];
            $arrTahun = [];
            for($i=$AWAL;$i<=$AKHIR;$i++)
            {
                $res[] = "JUMLAH_".$i;
                $arrTahun[] = $i;
            }
            $aColumns = array_merge($aColumns, $res);
            $aColumns = array_merge($aColumns, ["TOTAL"]);
            $aColumnsJudul = array_merge($aColumnsJudul, $arrTahun);
            $aColumnsJudul = array_merge($aColumnsJudul, ["TOTAL"]);

            $arrResultKolom = $aColumns;
            $judulKolom = $aColumnsJudul;
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }



    public function template_riwayat_pelatihan(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK"];
        $judulKolom = ["NIK", "KATEGORI (LEADERSHIP/TEKNIS)", "JENIS PELATIHAN", "PELATIHAN", "TINGKAT", "LOKASI", "PENYELENGGARA", "TANGGAL MULAI", "TANGGAL SELESAI", "JUMLAH JAM", "NO. SERTIFIKAT", "TGL. BERAKHIR SERTIFIKAT"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,   
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        $sql = " SELECT A.KODE FROM jenis_pelatihan A 
                 ORDER BY A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE"];
        $judulKolom = ["JENIS PELATIHAN"];
        $judulSheet = "Data Jenis Pelatihan";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }


    
    
    public function template_riwayat_pendidikan(Request $request, $REGIONAL_KODE="")
    {
        if(empty($REGIONAL_KODE))
            $REGIONAL_KODE = $request->REGIONAL_KODE;
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{REGIONAL_KODE}", $REGIONAL_KODE, $fileName);

        $sql = " select a.pegawai_pendidikan_id, a.pegawai_id, a.pegawai_nik, b.nama pegawai, a.tingkat_pendidikan, 
                a.institusi, a.kota, a.negara, a.jurusan, a.no_ijasah, a.tahun_masuk, a.tahun_lulus, a.penghargaan
                from pegawai_pendidikan a inner join pegawai b on a.pegawai_nik = b.nik 
                where b.regional_kode = '$REGIONAL_KODE'
                order by a.pegawai_nik, a.tingkat_pendidikan ";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["PEGAWAI_PENDIDIKAN_ID", "PEGAWAI_NIK", "PEGAWAI", "TINGKAT_PENDIDIKAN", "INSTITUSI", "KOTA", "NEGARA", "JURUSAN", "NO_IJASAH", "TAHUN_MASUK", "TAHUN_LULUS", "PENGHARGAAN"];
        $judulKolom = ["PRIMARY_ID", "NIK", "NAMA PEGAWAI", "TINGKAT_PENDIDIKAN", "INSTITUSI", "KOTA", "NEGARA", "JURUSAN", "NO_IJASAH", "TAHUN_MASUK", "TAHUN_LULUS", "PENGHARGAAN"];
        $judulSheet = "Import Data";
        $formatKolom = [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,   
            'C' => NumberFormat::FORMAT_TEXT,   
            'D' => NumberFormat::FORMAT_TEXT,   
            'E' => NumberFormat::FORMAT_TEXT,  
            'F' => NumberFormat::FORMAT_TEXT,   
            'G' => NumberFormat::FORMAT_TEXT,   
            'H' => NumberFormat::FORMAT_TEXT,   
            'I' => NumberFormat::FORMAT_TEXT,   
            'J' => NumberFormat::FORMAT_TEXT,   
            'K' => NumberFormat::FORMAT_TEXT,   
            'L' => NumberFormat::FORMAT_TEXT,   
            'M' => NumberFormat::FORMAT_TEXT,   
            'N' => NumberFormat::FORMAT_TEXT,   
            'O' => NumberFormat::FORMAT_TEXT,   
            'P' => NumberFormat::FORMAT_TEXT,   
            'Q' => NumberFormat::FORMAT_TEXT,    
            ];
        $colorFormat = [
            'F' => "41B628",
            'G' => "41B628",
            'H' => "41B628",
            'I' => "41B628",
            'J' => "41B628",
            'K' => "41B628",
            'L' => "41B628"
        ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom, $colorFormat);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }

    
    
    public function template_riwayat_rangkap_jabatan(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK"];
        $judulKolom = ["NIK", "SEBAGAI (PLT/PTR)", "KODE JABATAN", "JABATAN", "PAREA", "PSUBAREA", "NO. SK", "TANGGAL SK", "TANGGAL MULAI", "TANGGAL BERAKHIR"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        $sql = " SELECT A.REGIONAL_KODE, A.KODE, A.REGIONAL, A.NAMA FROM regional_sub A 
                 ORDER BY A.REGIONAL_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["REGIONAL_KODE", "KODE", "REGIONAL", "NAMA"];
        $judulKolom = ["PAREA", "PSUBAREA", "PERSONNEL AREA", "PERSONNEL SUBAREA"];
        $judulSheet = "Data Personnel Area";
        $sheet4 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet4;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }

    public function template_riwayat_penugasan(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK"];
        $judulKolom = ["NIK", "KE/DARI", "KODE PERUSAHAAN", "KODE BAGIAN", "PERUSAHAAN", "BAGIAN", "JABATAN", "NO. SK", "TANGGAL SK", "TANGGAL MULAI", "TANGGAL BERAKHIR"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        $sql = " SELECT A.PERUSAHAAN_PENUGASAN_KODE, A.KODE, A.PERUSAHAAN_PENUGASAN, A.NAMA FROM bagian_penugasan A 
                 INNER JOIN  perusahaan_penugasan B on A.PERUSAHAAN_PENUGASAN_KODE = B.KODE AND B.JENIS_PERUSAHAAN = 'INTERNAL'
                 ORDER BY A.PERUSAHAAN_PENUGASAN_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["PERUSAHAAN_PENUGASAN_KODE", "KODE", "PERUSAHAAN_PENUGASAN", "NAMA"];
        $judulKolom = ["KODE PERUSAHAAN", "KODE BAGIAN", "PERUSAHAAN", "BAGIAN"];
        $judulSheet = "Data Bagian";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }


    
    public function template_jabatan(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $formatKolom = [
            'A' => NumberFormat::FORMAT_TEXT,   
            'B' => NumberFormat::FORMAT_TEXT,   
            'C' => NumberFormat::FORMAT_TEXT,    
           ];
        
        $sql = " SELECT A.KODE, A.NAMA FROM jabatan A 
                 ORDER BY A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "NAMA"];
        $judulKolom = ["KODE JABATAN", "JABATAN"];
        $judulSheet = "Data Jabatan";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);

        
        return Excel::download($templateMulti, $fileName.'.xls');

    }

    
    public function template_area(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $formatKolom = [
            'A' => NumberFormat::FORMAT_TEXT,   
            'B' => NumberFormat::FORMAT_TEXT,   
            'C' => NumberFormat::FORMAT_TEXT,    
           ];
        
        $sql = " SELECT A.REGIONAL_KODE, A.KODE, A.REGIONAL, A.NAMA FROM regional_sub A 
                 ORDER BY A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["REGIONAL_KODE", "KODE", "REGIONAL", "NAMA"];
        $judulKolom = ["PAREA", "PSUBAREA", "PERSONNEL AREA", "PERSONNEL SUBAREA"];
        $judulSheet = "Data Personnel Area";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);

        
        return Excel::download($templateMulti, $fileName.'.xls');

    }


    public function template_riwayat_jabatan_hris(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik, null kode_jabatan, null nama_jabatan, null level_bod, null kode_perusahaan, null kode_bagian, null perusahaan, null bagian, null parea, null psubarea, null no_sk, null tanggal_sk, null tanggal_mulai, null tanggal_berakhir";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK", "KODE_JABATAN", "NAMA_JABATAN", "LEVEL_BOD", "KODE_PERUSAHAAN", "KODE_BAGIAN", "PERUSAHAAN", "BAGIAN", "PAREA", "PSUBAREA", "NO_SK", "TANGGAL_SK", "TANGGAL_MULAI", "TANGGAL_BERAKHIR"];
        $judulKolom = ["NIK", "KODE JABATAN", "JABATAN", "LEVEL_JABATAN", "KODE PERUSAHAAN", "KODE BAGIAN", "PERUSAHAAN", "BAGIAN", "PAREA", "PSUBAREA", "NO. SK", "TANGGAL SK", "TANGGAL MULAI", "TANGGAL BERAKHIR"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        $sql = " SELECT A.PERUSAHAAN_PENUGASAN_KODE, A.KODE, A.PERUSAHAAN_PENUGASAN, A.NAMA FROM bagian_penugasan A 
                 INNER JOIN  perusahaan_penugasan B on A.PERUSAHAAN_PENUGASAN_KODE = B.KODE AND B.JENIS_PERUSAHAAN = 'INTERNAL'
                 ORDER BY A.PERUSAHAAN_PENUGASAN_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["PERUSAHAAN_PENUGASAN_KODE", "KODE", "PERUSAHAAN_PENUGASAN", "NAMA"];
        $judulKolom = ["KODE PERUSAHAAN", "KODE BAGIAN", "PERUSAHAAN", "BAGIAN"];
        $judulSheet = "Data Bagian";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);


        $sql = " SELECT A.kode FROM kategori_jabatan A 
                 ORDER BY A.kategori_jabatan_id ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE"];
        $judulKolom = ["LEVEL JABATAN"];
        $judulSheet = "Data Level Jabatan";
        $sheet3 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet3;
        $templateMulti = new TemplateMultiController($sheets);

        
        $sql = " SELECT A.REGIONAL_KODE, A.KODE, A.REGIONAL, A.NAMA FROM regional_sub A 
                 ORDER BY A.REGIONAL_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["REGIONAL_KODE", "KODE", "REGIONAL", "NAMA"];
        $judulKolom = ["PAREA", "PSUBAREA", "PERSONNEL AREA", "PERSONNEL SUBAREA"];
        $judulSheet = "Data Personnel Area";
        $sheet4 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet4;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }


    
    public function template_riwayat_jabatan(Request $request, $REGIONAL_KODE="")
    {
        if(empty($REGIONAL_KODE))
            $REGIONAL_KODE = $request->REGIONAL_KODE;
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{REGIONAL_KODE}", $REGIONAL_KODE, $fileName);

        $sql = " select a.pegawai_jabatan_id, a.pegawai_nik, b.nama pegawai, a.jabatan_kode, a.jabatan, a.tmt_jabatan, a.tmt_berakhir, a.no_sk, a.tanggal_sk 
                from pegawai_jabatan a inner join pegawai b on a.pegawai_nik = b.nik 
                where b.regional_kode = '$REGIONAL_KODE'
                order by a.pegawai_nik, tmt_jabatan ";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["PEGAWAI_JABATAN_ID", "PEGAWAI_NIK", "PEGAWAI", "JABATAN_KODE", "JABATAN", "TMT_JABATAN", "TMT_BERAKHIR", "NO_SK", "TANGGAL_SK"];
        $judulKolom = ["PRIMARY_ID", "NIK", "NAMA PEGAWAI", "POSITION_ID", "POSITION", "TMT_JABATAN", "TMT_BERAKHIR", "NO_SK", "TANGGAL_SK"];
        $judulSheet = "Import Data";
        $formatKolom = [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,   
            'C' => NumberFormat::FORMAT_TEXT,   
            'D' => NumberFormat::FORMAT_TEXT,   
            'E' => NumberFormat::FORMAT_TEXT,  
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,   
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,   
            'H' => NumberFormat::FORMAT_TEXT,   
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,   
            'J' => NumberFormat::FORMAT_TEXT,   
            'K' => NumberFormat::FORMAT_TEXT,   
            'L' => NumberFormat::FORMAT_TEXT,   
            'M' => NumberFormat::FORMAT_TEXT,   
            'N' => NumberFormat::FORMAT_TEXT,   
            'O' => NumberFormat::FORMAT_TEXT,   
            'P' => NumberFormat::FORMAT_TEXT,   
            'Q' => NumberFormat::FORMAT_TEXT,    
            ];
        $colorFormat = [
            'H' => "41B628",
            'I' => "41B628"
        ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom, $colorFormat);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);


        return Excel::download($templateMulti, $fileName.'.xls');

    }

    

    public function report_dinamis(Request $request, $FORM_ID="")
    {

        $data = $request->DATA_JSON;
        $ARR_DATA = json_decode($data, true);
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        $arrResult = DemografiController::report_dinamis($request, "JSON");


        $arrResultKolom = array_column($ARR_DATA["kolom"], 'alias');
        $judulKolom = array_column($ARR_DATA["kolom"], 'nama');
      

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    
    public function report_demografi_rincian_jabatan_detil(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if(stristr($FORM_ID,  "bod"))
        {
            $arrResult = DemografiRincianJabatanController::bod_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KELOMPOK_JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "JOB GROUP", "JOB LEVEL", "PERSONNEL AREA", "PERSONNEL SUBAREA", "EMPLOYEE_GROUP", "EMPLOYEE_SUBGROUP");
        }

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }




    public function report_demografi_magenta_detil(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if($FORM_ID == "peserta")
        {
            $arrResult = DemografiMagentaController::peserta_detil($request, "JSON");

            $arrResultKolom = array("NO_KTP", "NAMA", "INSTANSI", "JURUSAN", "STATUS_PELAJAR", "REGIONAL", "AREA", "PROGRAM_MAGENTA");
            $judulKolom = array("NO_KTP", "NAMA", "INSTANSI", "JURUSAN", "STATUS_PELAJAR", "PERSONNEL AREA", "PERSONNEL SUBAREA", "PROGRAM_MAGENTA");
        }

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }



    public function report_demografi_penugasan_detil(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if($FORM_ID == "tugas")
        {
            $arrResult = DemografiPenugasanController::tugas_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "REGIONAL_GRUP");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "PENUGASAN");
        }

        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }
    
    public function report_demografi_kbumn_detil(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if($FORM_ID == "disabilitas")
        {
            $arrResult = DemografiKbumnController::disabilitas_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "KATEGORI_DISABILITAS", "DISABILITAS");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "EMPLOYEE GROUP", "EMPLOYEE SUBGROUP", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "KATEGORI DISABILITAS", "DISABILITAS");
        }
        elseif($FORM_ID == "wilayah")
        {
            $arrResult = DemografiKbumnController::wilayah_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "SUKU");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "EMPLOYEE GROUP", "EMPLOYEE SUBGROUP", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "SUKU");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }


    
    public function report_demografi_tidak_tetap_detil(Request $request, $FORM_ID="")
    {

        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if($FORM_ID == "gender")
        {
            $arrResult = DemografiTidakTetapController::gender_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "JENIS_KELAMIN_KODE");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "EMPLOYEE GROUP", "EMPLOYEE SUBGROUP", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "JENIS_KELAMIN");  
        }
        elseif($FORM_ID == "unitkerja")
        {
            $arrResult = DemografiTidakTetapController::unitkerja_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "EMPLOYEE GROUP", "EMPLOYEE SUBGROUP", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }




    public function report_demografi_detil(Request $request, $FORM_ID="")
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);
        $fileName = str_replace("{FORM_ID}", $FORM_ID, $fileName);
        $fileName = strtoupper($fileName);
        
        if($FORM_ID == "pendidikan")
        {
            $arrResult = DemografiController::pendidikan_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "PENDIDIKAN_TERAKHIR");
            $judulKolom     = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "PENDIDIKAN TERAKHIR");    
        }
        elseif($FORM_ID == "grading")
        {
            $arrResult = DemografiController::grading_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "KELOMPOK_GRADE");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "KELOMPOK_GRADE");
        }
        elseif($FORM_ID == "gender")
        {
            $arrResult = DemografiController::gender_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "JENIS_KELAMIN");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "JENIS_KELAMIN");
        }
        elseif($FORM_ID == "usia")
        {
            $arrResult = DemografiController::usia_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "TANGGAL_LAHIR", "USIA");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "TANGGAL_LAHIR", "USIA");
        }
        elseif($FORM_ID == "unitkerja")
        {
            $arrResult = DemografiController::unitkerja_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA");
        }
        elseif($FORM_ID == "status")
        {
            $arrResult = DemografiController::status_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "STATUS_PENUGASAN");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "STATUS");
        }
        elseif($FORM_ID == "rekap_pegawai")
        {
            $arrResult = DemografiController::rekap_pegawai_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "KELOMPOK_JABATAN", "FUNGSI_JABATAN", "REGIONAL", "AREA", "STRUKTUR_ORGAN", "STATUS_PENUGASAN");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "JOB GROUP", "JOB FUNCTION", "PERSONNEL AREA", "PERSONNEL SUBAREA", "ORG UNIT", "STATUS");
        }
        elseif($FORM_ID == "rekap_mpp")
        {
            $arrResult = DemografiController::rekap_mpp_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "STRUKTUR_ORGAN", "KELOMPOK_PEGAWAI", "KELOMPOK_PEGAWAI_SUB");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "ORG UNIT", "EMPLOYEE_GROUP", "EMPLOYEE_SUBGROUP");
        }
        elseif($FORM_ID == "mbt")
        {
            $arrResult = DemografiController::mbt_detil($request, "JSON");

            $arrResultKolom = array("NIK", "NAMA", "JABATAN", "KATEGORI_JABATAN_KODE", "REGIONAL", "AREA", "TANGGAL_MBT");
            $judulKolom = array("NIK", "NAMA", "JABATAN", "LEVEL JABATAN", "PERSONNEL AREA", "PERSONNEL SUBAREA", "TANGGAL MBT");
        }


        $judulSheet = "Report";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,   
             'D' => NumberFormat::FORMAT_TEXT,   
             'E' => NumberFormat::FORMAT_TEXT,  
             'F' => NumberFormat::FORMAT_TEXT,   
             'G' => NumberFormat::FORMAT_TEXT,   
             'H' => NumberFormat::FORMAT_TEXT,   
             'I' => NumberFormat::FORMAT_TEXT,   
             'J' => NumberFormat::FORMAT_TEXT,   
             'K' => NumberFormat::FORMAT_TEXT,   
             'L' => NumberFormat::FORMAT_TEXT,   
             'M' => NumberFormat::FORMAT_TEXT,   
             'N' => NumberFormat::FORMAT_TEXT,   
             'O' => NumberFormat::FORMAT_TEXT,   
             'P' => NumberFormat::FORMAT_TEXT,   
             'Q' => NumberFormat::FORMAT_TEXT,   
             'R' => NumberFormat::FORMAT_TEXT,   
             'S' => NumberFormat::FORMAT_TEXT,   
             'T' => NumberFormat::FORMAT_TEXT,   
             'U' => NumberFormat::FORMAT_TEXT,   
             'V' => NumberFormat::FORMAT_TEXT,   
             'W' => NumberFormat::FORMAT_TEXT,   
             'X' => NumberFormat::FORMAT_TEXT,   
             'Y' => NumberFormat::FORMAT_TEXT,   
             'Z' => NumberFormat::FORMAT_TEXT,     
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;

        $templateMulti = new TemplateMultiController($sheets);

        return Excel::download($templateMulti, $fileName.'.xls');
    }





    public function job_profil(Request $request)
    {
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        


        $sql = " select NULL KODE_JABATAN";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE_JABATAN", "BOD_LEVEL", "JOB_GRADE", "KODE_KOMODITI", "BIDANG_JABATAN", "TANGGAL_BERLAKU", "MAN_POWER"];
        $judulKolom = ["KODE JABATAN", "BOD LEVEL", "JOB GRADE", "KODE KOMODITI", "BIDANG JABATAN", "TANGGAL BERLAKU", "MAN POWER"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);

        
        $sql = " SELECT A.KODE FROM kategori_jabatan A 
                 ORDER BY A.kategori_jabatan_id ASC ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE"];
        $judulKolom = ["BOD LEVEL"];
        $judulSheet = "BOD Level";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);

        $sql = " SELECT A.KODE FROM grade_utama A 
                 ORDER BY A.KODE ASC ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE"];
        $judulKolom = ["JOB GRADE"];
        $judulSheet = "Job Grade";
        $sheet3 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet3;
        $templateMulti = new TemplateMultiController($sheets);

        $sql = " SELECT A.KODE, NAMA FROM komoditi A 
                 ORDER BY A.KODE ASC ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "NAMA"];
        $judulKolom = ["KODE KOMODITI", "KOMODITI"];
        $judulSheet = "Komoditi";
        $sheet4 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet4;
        $templateMulti = new TemplateMultiController($sheets);

        
        return Excel::download($templateMulti, $fileName.'.xls');

    }


    public function magenta(Request $request)
    {
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        


        $sql = " select NULL NO_KTP, NULL NAMA, NULL TELEPON, NULL EMAIL, NULL ALAMAT_DOMISILI, NULL INSTANSI, NULL JURUSAN, NULL STATUS_PELAJAR, 
                        NULL PROGRAM_MAGENTA_KODE, NULL REGIONAL_KODE, NULL AREA_KODE, NULL BANK, NULL NO_REKENING, NULL NAMA_REKENING";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NO_KTP", "NAMA", "TELEPON", "EMAIL", "ALAMAT_DOMISILI", "INSTANSI", "JURUSAN", "STATUS_PELAJAR", "PROGRAM_MAGENTA_KODE", "REGIONAL_KODE", "AREA_KODE", "BANK", "NO_REKENING", "NAMA_REKENING"];
        $judulKolom = ["NO KTP", "NAMA LENGKAP", "TELEPON", "EMAIL", "ALAMAT DOMISILI", "UNIVERSITAS", "JURUSAN", "FRESH GRADUATE/MAHASISWA", "KODE PROGRAM", "PAREA", "PSUBAREA", "BANK", "NO REKENING", "NAMA REKENING"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);

        
        $sql = " SELECT A.KODE, NAMA, TANGGAL_AWAL, TANGGAL_AKHIR FROM program_magenta A 
                 ORDER BY A.tanggal_awal desc ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "NAMA", "TANGGAL_AWAL", "TANGGAL_AKHIR"];
        $judulKolom = ["KODE PROGRAM", "PROGRAM MAGENTA", "MULAI", "SAMPAI DENGAN"];
        $judulSheet = "Program Magenta";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);

        $sql = " SELECT A.REGIONAL_KODE, KODE, REGIONAL, NAMA FROM regional_sub A 
                 ORDER BY A.REGIONAL_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["REGIONAL_KODE", "KODE", "REGIONAL", "NAMA"];
        $judulKolom = ["PAREA", "PSUBAREA", "AREA", "SUB AREA"];
        $judulSheet = "Unit Kerja";
        $sheet3 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet3;
        $templateMulti = new TemplateMultiController($sheets);


        
        return Excel::download($templateMulti, $fileName.'.xls');

    }

    public function pegawai_disabilitas(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik, null kode, null keterangan";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK", "KODE", "KETERANGAN"];
        $judulKolom = ["NIK", "KODE DISABILITAS", "CATATAN"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);

        
        $sql = " SELECT A.KODE, A.KATEGORI_DISABILITAS, NAMA, KETERANGAN FROM disabilitas A 
                 ORDER BY A.KATEGORI_DISABILITAS_KODE, A.KODE ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "KATEGORI_DISABILITAS", "NAMA", "KETERANGAN"];
        $judulKolom = ["KODE DISABILITAS", "KATEGORI_DISABILITAS", "DISABILITAS", "KETERANGAN"];
        $judulSheet = "Data Disabilitas";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);


        
        return Excel::download($templateMulti, $fileName.'.xls');

    }


    public function template_komoditi_kso(Request $request)
    {
        
        
		$fileName = Route::getCurrentRoute()->uri;
        $fileName = str_replace("/", "_", $fileName);

        $sql = " select null nik, null komoditi, null status_kso";

        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["NIK", "KOMODITI", "STATUS_KSO"];
        $judulKolom = ["NIK", "KODE KOMODITI", "KODE STATUS KSO"];
        $judulSheet = "Import Data";
        $formatKolom = [
             'A' => NumberFormat::FORMAT_TEXT,   
             'B' => NumberFormat::FORMAT_TEXT,   
             'C' => NumberFormat::FORMAT_TEXT,    
            ];
        $sheet1 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
         
        $sheets[] = $sheet1;
        $templateMulti = new TemplateMultiController($sheets);

        
        $sql = " SELECT A.KODE, A.NAMA FROM komoditi A 
                 ORDER BY A.NAMA ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "NAMA"];
        $judulKolom = ["KODE KOMODITI", "KOMODITI"];
        $judulSheet = "Data Komoditi";
        $sheet2 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet2;
        $templateMulti = new TemplateMultiController($sheets);

        $sql = " SELECT A.KODE, A.NAMA FROM status_kso A 
                 ORDER BY A.NAMA ";
        $arrResult = KDatabase::query($sql)->result_array();
        $arrResultKolom = ["KODE", "NAMA"];
        $judulKolom = ["KODE STATUS KSO", "STATUS_KSO"];
        $judulSheet = "Data Status KSO";
        $sheet3 = new TemplateQueryController($arrResult, $arrResultKolom, $judulKolom, $judulSheet, $formatKolom);
        $sheets[] = $sheet3;
        $templateMulti = new TemplateMultiController($sheets);

        
        return Excel::download($templateMulti, $fileName.'.xls');

    }

    

}
