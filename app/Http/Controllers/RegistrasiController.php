<?php

namespace App\Http\Controllers;
error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use KAuth;
use FileHandler;
use KDatabase;
use KirimNotifikasi;
use App\Models\Pelamar;
use App\Models\PelamarLowonganDokumen;
use App\Models\PelamarLowongan;
use App\Models\LowonganDokumen;
use App\Models\PelamarLowonganPersyaratan;
use App\Models\UsersBase;
use Illuminate\Support\Facades\DB;

use App\Models\PelamarPendidikan;
use App\Models\PelamarPengalaman;
use App\Models\PelamarSertifikat;
use App\Models\PelamarPelatihan;
use App\Models\PelamarKeluarga;
use App\Models\PelamarSim;
use App\Models\PelamarToefl;

class RegistrasiController extends Controller
{
    public function route_web()
    {
        Route::get('/registrasi', [RegistrasiController::class, 'registrasi'])->middleware('guest');
        Route::post('/registrasi_akun', [RegistrasiController::class, 'registrasi_akun'])->middleware('guest');
        Route::get('/verifikasi', [RegistrasiController::class, 'verifikasi'])->middleware('guest');
        Route::get('/verifikasi/{TOKEN}', [RegistrasiController::class, 'verifikasi'])->middleware('guest');
        Route::get('/verifikasi/expired', [RegistrasiController::class, 'expired'])->middleware('guest');
        Route::post('/verifikasi/akun', [RegistrasiController::class, 'verifikasi_akun'])->middleware('guest');
        Route::post('/data_lampiran_add', [RegistrasiController::class, 'data_lampiran_add'])->middleware('auth');
        Route::post('/data_pribadi_add', [RegistrasiController::class, 'data_pribadi_add'])->middleware('auth');
        Route::get('/isian_hapus/{TABEL}', [RegistrasiController::class, 'isian_hapus'])->middleware('auth');
        Route::post('/verifikasi_isian_formulir', [RegistrasiController::class, 'verifikasi_isian_formulir'])->middleware('guest');
        Route::post('/kirim_aktivasi', [RegistrasiController::class, 'kirim_aktivasi'])->middleware('guest');
        Route::post('/kirim_reset_password', [RegistrasiController::class, 'kirim_reset_password'])->middleware('guest');
        Route::post('/reset_password', [RegistrasiController::class, 'reset_password'])->middleware('guest');
        Route::post('/lamaran', [RegistrasiController::class, 'lamaran'])->middleware('auth');
		
        Route::post('/data_pendidikan_formal_add', [RegistrasiController::class, 'data_pendidikan_formal_add'])->middleware('auth');
        Route::post('/data_pengalaman_add', [RegistrasiController::class, 'data_pengalaman_add'])->middleware('auth');
        Route::post('/data_sertifikat_add', [RegistrasiController::class, 'data_sertifikat_add'])->middleware('auth');
        Route::post('/data_pelatihan_add', [RegistrasiController::class, 'data_pelatihan_add'])->middleware('auth');
        Route::post('/data_keluarga_add', [RegistrasiController::class, 'data_keluarga_add'])->middleware('auth');
        Route::post('/data_sim_add', [RegistrasiController::class, 'data_sim_add'])->middleware('auth');
        Route::post('/data_toefl_add', [RegistrasiController::class, 'data_toefl_add'])->middleware('auth');


    }

	
	public function isian_hapus(Request $request, $TABEL)
	{

		$reqId = $request->reqId;
		
		if($TABEL == "data_pendidikan_formal")
		{
			$set= new PelamarPendidikan();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_PENDIDIKAN_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	

		if($TABEL == "data_pengalaman")
		{
			$set= new PelamarPengalaman();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_PENGALAMAN_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	

		if($TABEL == "data_sertifikat")
		{
			$set= new PelamarSertifikat();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_SERTIFIKAT_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	
		
		if($TABEL == "data_pelatihan")
		{
			$set= new PelamarPelatihan();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_PELATIHAN_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	
		
		if($TABEL == "data_keluarga")
		{
			$set= new PelamarPelatihan();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_PELATIHAN_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	
		
		if($TABEL == "data_sim")
		{
			$set= new PelamarSim();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_SIM_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	
		
		if($TABEL == "data_toefl")
		{
			$set= new PelamarToefl();
			$set->setField("PELAMAR_ID", $this->userPelamarId);
			$set->setField("PELAMAR_TOEFL_ID", $reqId);
			if($set->delete())
				echo "Data berhasil dihapus.";
			else
				echo "Data gagal dihapus.";
			
		}	
	}

	
	public function data_toefl_add(Request $request)
	{

		$pelamar_toefl = new PelamarToefl();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;

		$reqNama = $request->reqNama;
		$reqTanggal	= $request->reqTanggal;
		$reqNilai = $request->reqNilai;
		$reqKeterangan = $request->reqKeterangan;
		$reqSertifikat = $request->reqSertifikat;

		$reqLampiran_ = $_FILES['reqLampiran'];
		$reqLampiranOld = $request->reqLampiranOld;

		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$reqLampiran = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiran_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiran_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile = date("dmYHis") . "_" . md5($reqLampiran_['name']) . "_BAHASA_" . $this->userNoRegister . "." . getExtension($reqLampiran_['name']);
				if (move_uploaded_file($reqLampiran_['tmp_name'], $FILE_DIR . $renameFile)) {
					$reqLampiran = $renameFile;
				}
			}
		}
		if($reqLampiran=='' && $reqLampiranOld !='')
			$reqLampiran = $reqLampiranOld;

		$pelamar_toefl->setField("PELAMAR_TOEFL_ID", $reqId);
		$pelamar_toefl->setField("SERTIFIKAT_ID", ($reqSertifikat));
		$pelamar_toefl->setField("KETERANGAN", $reqKeterangan);
		$pelamar_toefl->setField("TANGGAL", dateToDBCheck($reqTanggal));
		$pelamar_toefl->setField("NILAI", $reqNilai);
		$pelamar_toefl->setField("LAMPIRAN", $reqLampiran);
		$pelamar_toefl->setField("PELAMAR_ID", $this->userPelamarId);

		if ($reqMode == "insert") {
			$pelamar_toefl->setField("CREATED_BY", $this->NIP);
			$pelamar_toefl->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_toefl->insertData()) {
				echo "Data berhasil disimpan.";
			}
		} else {
			$pelamar_toefl->setField("PELAMAR_SERTIFIKAT_ID", $reqRowId);
			$pelamar_toefl->setField("UPDATED_BY", $this->NIP);
			$pelamar_toefl->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_toefl->updateData()) {
				echo "Data berhasil disimpan.";
			}
		}
	}
	public function data_sim_add(Request $request)
	{

		$file = new FileHandler();
		$pelamar_sim = new PelamarSim();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;

		$reqNoSim 			= $request->reqNoSim;
		$reqTanggalKadaluarsa 		= $request->reqTanggalKadaluarsa;
		$reqJenisSimId = $request->reqJenisSimId;
		$reqLinkFile = $_FILES['reqLinkFile'];
		$reqLinkFileTemp = $request->reqLinkFileTemp;

		$FILE_DIR = "uploads/sim/";
		$_THUMB_PREFIX = "z__thumb_";

		$pelamar_sim->setField("JENIS_SIM_ID", $reqJenisSimId);
		$pelamar_sim->setField("NO_SIM", $reqNoSim);
		$pelamar_sim->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa));
		$pelamar_sim->setField("PELAMAR_ID", $this->userPelamarId);

		if ($reqMode == "insert") {
			$pelamar_sim->setField("CREATED_BY", $this->NIP);
			$pelamar_sim->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_sim->insertData()) {
				echo "Data berhasil disimpan.";
				$reqDetilId = $pelamar_sim->id;
			}
		} else {
			$pelamar_sim->setField("PELAMAR_SIM_ID", $reqRowId);
			$pelamar_sim->setField("UPDATED_BY", $this->NIP);
			$pelamar_sim->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_sim->updateData()) {
				echo "Data berhasil disimpan.";
				$reqDetilId = $reqId;
			}
		}


		$ekstensi = "jpg,jpeg,png";
		$ket = "JPG/JPEG/PNG";
		$insertLinkFile = "";
		for ($i = 0; $i < count($reqLinkFile); $i++) {
			if ($reqLinkFile['name'][$i] == "") {
			} else {
				$renameFile = date("dmYHis").str_replace("'", "", str_replace(" ", "", $reqLinkFile['name'][$i]));
				
				$file_ext = strtolower(end(explode('.', $reqLinkFile['name'][$i])));
				if (!strstr($ekstensi, $file_ext)) {
					echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
					return;
				}
				
				if (move_uploaded_file($reqLinkFile['tmp_name'][$i], $FILE_DIR . $renameFile)) {
					if ($i == 0) {
						$insertLinkFile = $renameFile;
					} else {
						$insertLinkFile .= "," . $renameFile;
					}
				}
			}
		}

		if ($insertLinkFile == "") {
		} else {
			$set_file = new PelamarSim();
			$set_file->setField('PELAMAR_SIM_ID', $reqDetilId);
			$set_file->setField('LINK_FILE', $insertLinkFile);
			$set_file->update_file();
		}
	}

    public function data_keluarga_add(Request $request)
    {

        $pelamar_keluarga = new PelamarKeluarga();

        $reqId = $request->reqId;
        $reqMode = $request->reqMode;
        $reqRowId = $request->reqRowId;

        $reqHubunganKeluargaId = $request->reqHubunganKeluargaId;
        $reqStatusKawin = $request->reqStatusKawin;
        $reqJenisKelamin = $request->reqJenisKelamin;
        $reqStatusTunjangan = $request->reqStatusTunjangan;
        $reqNama = $request->reqNama;
        $reqTanggalWafat = $request->reqTanggalWafat;
        $reqTanggalLahir = $request->reqTanggalLahir;
        $reqStatusTanggung = $request->reqStatusTanggung;
        $reqTempatLahir = $request->reqTempatLahir;
        $reqPendidikanId = $request->reqPendidikanId;
        $reqPekerjaan = $request->reqPekerjaan;
        $reqKesehatan = $request->reqKesehatan;
        $reqKesehatanTanggal = $request->reqKesehatanTanggal;
        $reqKesehatanFaskes = $request->reqKesehatanFaskes;
        $reqKtpNo = $request->reqKtpNo;

        $pelamar_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqHubunganKeluargaId);
        $pelamar_keluarga->setField('STATUS_KAWIN', setNULL($reqStatusKawin));
        $pelamar_keluarga->setField('JENIS_KELAMIN', $reqJenisKelamin);
        $pelamar_keluarga->setField('STATUS_TUNJANGAN', setNULL($reqStatusTunjangan));
        $pelamar_keluarga->setField('NAMA', $reqNama);
        $pelamar_keluarga->setField('TANGGAL_WAFAT', dateToDBCheck($reqTanggalWafat));
        $pelamar_keluarga->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
        $pelamar_keluarga->setField('STATUS_TANGGUNG', setNULL($reqStatusTanggung));
        $pelamar_keluarga->setField('TEMPAT_LAHIR', $reqTempatLahir);
        $pelamar_keluarga->setField('PENDIDIKAN_ID', $reqPendidikanId);
        $pelamar_keluarga->setField('PEKERJAAN', $reqPekerjaan);
        $pelamar_keluarga->setField('PELAMAR_KELUARGA_ID', $reqRowId);
        $pelamar_keluarga->setField('PELAMAR_ID', $this->userPelamarId);
        $pelamar_keluarga->setField('KESEHATAN_NO', $reqKesehatan);
        $pelamar_keluarga->setField('KESEHATAN_TANGGAL', dateToDBCheck($reqKesehatanTanggal));
        $pelamar_keluarga->setField('KESEHATAN_FASKES', $reqKesehatanFaskes);
        $pelamar_keluarga->setField('KTP_NO', $reqKtpNo);

        if ($reqMode == "insert") {
            $pelamar_keluarga->setField("CREATED_BY", $this->NIP);
            $pelamar_keluarga->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
            if ($pelamar_keluarga->insertData()) {
                $reqRowId = $pelamar_keluarga->id;
                echo "Data berhasil disimpan.";
            }
        } else {
            $pelamar_keluarga->setField("UPDATED_BY", $this->NIP);
            $pelamar_keluarga->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
            if ($pelamar_keluarga->updateData()) {
                echo "Data berhasil disimpan.";
            }
        }
    }

	public function data_pelatihan_add(Request $request)
	{

		$pelamar_pelatihan = new PelamarPelatihan();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;

		$reqWaktu = $request->reqWaktu;
		$reqJenis = $request->reqJenis;
		$reqJumlah = $request->reqJumlah;
		$reqPelatih = $request->reqPelatih;
		$reqTahun = $request->reqTahun;
		$reqLampiran_ = $_FILES['reqLampiran'];
		$reqLampiranOld = $request->reqLampiranOld;

		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$reqLampiran = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiran_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiran_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile = date("dmYHis") . "_" . md5($reqLampiran_['name']) . "_PELATIHAN_" . $this->userNoRegister . "." . getExtension($reqLampiran_['name']);
				if (move_uploaded_file($reqLampiran_['tmp_name'], $FILE_DIR . $renameFile)) {
					$reqLampiran = $renameFile;
				}
			}
		}
		if($reqLampiran=='' && $reqLampiranOld !='')
			$reqLampiran = $reqLampiranOld;

		$pelamar_pelatihan->setField('WAKTU', $reqWaktu);
		$pelamar_pelatihan->setField('JENIS', $reqJenis);
		$pelamar_pelatihan->setField('JUMLAH', $reqJumlah);
		$pelamar_pelatihan->setField('PELATIH', $reqPelatih);
		$pelamar_pelatihan->setField('TAHUN', $reqTahun);
		$pelamar_pelatihan->setField('LAMPIRAN', $reqLampiran);
		$pelamar_pelatihan->setField('PELAMAR_ID', $this->userPelamarId);

		if ($reqMode == "insert") {
			if ($pelamar_pelatihan->insertData()) {
				$reqRowId = $pelamar_pelatihan->id;
				echo "Data berhasil disimpan.";
			}
			//echo $pelamar_pelatihan->query;
		} else {
			$pelamar_pelatihan->setField('PELAMAR_PELATIHAN_ID', $reqRowId);

			if ($pelamar_pelatihan->updateData()) {
				echo "Data berhasil disimpan.";
			}
			//echo $pelamar_pelatihan->query;
		}
	}

	
	public function data_sertifikat_add(Request $request)
	{

		$pelamar_sertifikat = new PelamarSertifikat();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;

		$reqNama = $request->reqNama;
		$reqTanggalTerbit 			= $request->reqTanggalTerbit;
		$reqTanggalKadaluarsa 		= $request->reqTanggalKadaluarsa;
		$reqGroup = $request->reqGroup;
		$reqKeterangan = $request->reqKeterangan;
		$reqSertifikatId = $request->reqSertifikatId;

		$reqLampiran_ = $_FILES['reqLampiran'];
		$reqLampiranOld = $request->reqLampiranOld;

		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$reqLampiran = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiran_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiran_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile = date("dmYHis") . "_" . md5($reqLampiran_['name']) . "_SERTIFIKAT_" . $this->userNoRegister . "." . getExtension($reqLampiran_['name']);
				if (move_uploaded_file($reqLampiran_['tmp_name'], $FILE_DIR . $renameFile)) {
					$reqLampiran = $renameFile;
				}
			}
		}
		if($reqLampiran=='' && $reqLampiranOld !='')
			$reqLampiran = $reqLampiranOld;

		$pelamar_sertifikat->setField("NAMA", $reqNama);
		$pelamar_sertifikat->setField("TANGGAL_TERBIT", dateToDBCheck($reqTanggalTerbit));
		$pelamar_sertifikat->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa));
		$pelamar_sertifikat->setField("GROUP_SERTIFIKAT", $reqGroup);
		$pelamar_sertifikat->setField("KETERANGAN", $reqKeterangan);
		$pelamar_sertifikat->setField("SERTIFIKAT_ID", ValToNullDB($reqSertifikatId));
		$pelamar_sertifikat->setField("LAMPIRAN", $reqLampiran);
		$pelamar_sertifikat->setField("PELAMAR_ID", $this->userPelamarId);

		if ($reqMode == "insert") {
			$pelamar_sertifikat->setField("CREATED_BY", $this->NIP);
			$pelamar_sertifikat->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_sertifikat->insertData()) {
				echo "Data berhasil disimpan.";
			}
		} else {
			$pelamar_sertifikat->setField("PELAMAR_SERTIFIKAT_ID", $reqRowId);
			$pelamar_sertifikat->setField("UPDATED_BY", $this->NIP);
			$pelamar_sertifikat->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_sertifikat->updateData()) {
				echo "Data berhasil disimpan.";
			}
		}
	}

	
	public function data_pengalaman_add(Request $request)
	{

		$pelamar_pengalaman = new PelamarPengalaman();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;

		$reqJabatan = $request->reqJabatan;
		$reqPerusahaan = $request->reqPerusahaan;
		$DESKRIPSI = $request->DESKRIPSI;
		$PRESTASI = $request->PRESTASI;
		$reqDurasi = $request->reqDurasi;
		$reqTahun = $request->reqTahun;
		$reqTanggalMasuk = $request->reqTanggalMasuk;
		$reqTanggalKeluar = $request->reqTanggalKeluar;
		$reqLampiran_ = $_FILES['reqLampiran'];
		$reqLampiranOld = $request->reqLampiranOld;

		if ($reqDurasi == "" && $reqTahun == "") {
			$reqDurasi = 0;
			$reqTahun = 0;
		} elseif ($reqDurasi == "") {
			$reqDurasi = 0;
		} elseif ($reqTahun == "") {
			$reqTahun = 0;
		} else {
			$reqDurasi = $reqDurasi;
			$reqTahun = $reqTahun;
		}
		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$reqLampiran = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiran_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiran_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile = date("dmYHis") . "_" . md5($reqLampiran_['name']) . "_PENGALAMAN_" . $this->userNoRegister . "." . getExtension($reqLampiran_['name']);
				if (move_uploaded_file($reqLampiran_['tmp_name'], $FILE_DIR . $renameFile)) {
					$reqLampiran = $renameFile;
				}
			}
		}
		if($reqLampiran=='' && $reqLampiranOld !='')
			$reqLampiran = $reqLampiranOld;


		$pelamar_pengalaman->setField('JABATAN', setQuote($reqJabatan));
		$pelamar_pengalaman->setField('PERUSAHAAN', setQuote($reqPerusahaan));
		$pelamar_pengalaman->setField('DESKRIPSI', setQuote($DESKRIPSI));
		$pelamar_pengalaman->setField('PRESTASI', setQuote($PRESTASI));
		$pelamar_pengalaman->setField('DURASI', $reqDurasi);
		$pelamar_pengalaman->setField('TANGGAL_MASUK', dateToDBCheck($reqTanggalMasuk));
		$pelamar_pengalaman->setField('TANGGAL_KELUAR', dateToDBCheck($reqTanggalKeluar));
		$pelamar_pengalaman->setField('TAHUN', $reqTahun);
		$pelamar_pengalaman->setField('LAMPIRAN', $reqLampiran);
		$pelamar_pengalaman->setField('PELAMAR_ID', $this->userPelamarId);

		if ($reqMode == "insert") {
			if ($pelamar_pengalaman->insertData()) {
				$reqRowId = $pelamar_pengalaman->id;
				echo "Data berhasil disimpan.";
			}
		} else {
			$pelamar_pengalaman->setField('PELAMAR_PENGALAMAN_ID', $reqRowId);

			if ($pelamar_pengalaman->updateData()) {
				echo "Data berhasil disimpan.";
			}
			//echo $pelamar_pengalaman->query;
		}
	}
	

	function lamaran(Request $request)
	{
		

		$reqSubmit = $request->reqSubmit;
		$reqId = $request->reqId;

		$insertLinkFile = "";
		$reqLowonganPersyaratanId = $request->reqLowonganPersyaratanId;
		$reqNamaJenisPersyaratan = $request->reqNamaJenisPersyaratan;
		$reqKeterangan = $request->reqKeterangan;
		$reqPersyaratan = $request->reqPersyaratan;
	

		// $sql = " select count(1) ada from pelamar_lowongan where pelamar_id = '".$this->userPelamarId."' ";
		// $adaData = KDatabase::query($sql)->first_row()->ada;

		// if($adaData > 0)
		// {
		// 	echo "Anda telah melakukan submit pada lowongan yang lain.";
		// 	return;	
		// }


		if ($reqSubmit == "update") 
		{

			$pelamar_lowongan = new PelamarLowongan();
			$lowongan_dokumen = new LowonganDokumen();
			$pelamar_lowongan_persyaratan = new PelamarLowonganPersyaratan();
			$pelamar_dokumen = new PelamarLowonganDokumen();

			$ada = $lowongan_dokumen->getCountByParams(array("A.LOWONGAN_ID" => $reqId));
			$adaUpload = $pelamar_dokumen->getCountByParams(array("A.LOWONGAN_ID" => $reqId, "A.PELAMAR_ID" => $this->userPelamarId));
			if ($ada == $adaUpload)
			{}
			else
			{
				echo "Silahkan upload terlebih dahulu kelengkapan berkas.";
				return;	
			}


			$pelamar_lowongan_id = $pelamar_lowongan->getPelamarLowonganId(array("A.PELAMAR_ID" => $this->userPelamarId, "A.LOWONGAN_ID" => $reqId));
			
			if ((int)$pelamar_lowongan_id == "0") 
			{
				$pelamar_lowongan->setField("LOWONGAN_ID", $reqId);
				$pelamar_lowongan->setField("TANGGAL_KIRIM", "CURRENT_TIMESTAMP");
				$pelamar_lowongan->setField("PELAMAR_ID", $this->userPelamarId);
				$pelamar_lowongan->setField("LINK_FILE", $insertLinkFile);
				$pelamar_lowongan->setField("TANGGAL_KIRIM_FILE", "CURRENT_TIMESTAMP");

				if ($pelamar_lowongan->insertData()) 
				{
					$pelamar = new Pelamar();
					$pelamar->setField("PELAMAR_ID", $this->userPelamarId);
					$pelamar->kirimLamaran();
					
					for ($i = 0; $i < count($reqLowonganPersyaratanId); $i++) {
						$pelamar_lowongan_persyaratan->setField("PELAMAR_ID", $this->userPelamarId);
						$pelamar_lowongan_persyaratan->setField("LOWONGAN_ID", $reqId);
						$pelamar_lowongan_persyaratan->setField("LOWONGAN_PERSYARATAN_ID", $reqLowonganPersyaratanId[$i]);
						$pelamar_lowongan_persyaratan->setField("NAMA_JENIS_PERSYARATAN", $reqNamaJenisPersyaratan[$i]);
						$pelamar_lowongan_persyaratan->setField("KETERANGAN", $reqKeterangan[$i]);
						$pelamar_lowongan_persyaratan->setField("PERSYARATAN", $reqPersyaratan[$i]);
						$pelamar_lowongan_persyaratan->setField("CREATED_BY", $this->userPelamarId);
						$pelamar_lowongan_persyaratan->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
						$pelamar_lowongan_persyaratan->insertData();
					}
					
					echo "";
				}
			} 
			else
				echo "Anda sudah melamar lowongan ini sebelumnya. Apabila anda belum melengkapi Dokumen, pilih Main Menu -> Daftar Lamaran Anda.";
		}
		
	}
	
	function reset_password(Request $request)
	{
		$reqPassword 		= setQuote($request->reqPassword);
		$reqPasswordUlangi 	= setQuote($request->reqPasswordUlangi);
		$PELAMAR_ID 	 	= setQuote($request->PELAMAR_ID);
        $MD5KEY  = config("app.md5key");

		if($reqPassword == $reqPasswordUlangi)
		{}
		else
		{
			$result["status"]  = "failed";
			$result["message"] = "Password tidak sesuai, cek kembali password anda.";
			echo json_encode($result);
			return;
		}

		$sql = " update user_login set 
					user_pass = md5('$reqPassword') 
				 where  md5(concat(pelamar_id , 'pelamar', '$MD5KEY')) = '$PELAMAR_ID' ";
		$hasil = KDatabase::exec($sql);
		if($hasil)
		{
			$result["status"]  = "success";
			$result["message"] = "Reset password berhasil.";
			echo json_encode($result);
			return;
		}
		else
		{
			$result["status"]  = "failed";
			$result["message"] = "Reset password gagal.";
			echo json_encode($result);
			return;
		}

	}

	function kirim_reset_password(Request $request)
	{
		$reqKtp = setQuote($request->reqKtp);
		
		$pelamar = new Pelamar();

		$pelamar->selectByParamsSimple(array(), -1, -1, " AND KTP_NO = '" . $reqKtp . "'");
		$pelamar->firstRow();

		$PELAMAR_ID = $pelamar->getField("PELAMAR_ID");

		if($pelamar->getField("KTP_NO") == "")
		{	
			$status   = "failed";
			$pesan	  = "NIK tidak terdaftar.";
		}
		else
		{
			$kirimNotifikasi = new KirimNotifikasi();
			$hasil = $kirimNotifikasi->reset_password($PELAMAR_ID);
			if($hasil == "SUKSES")
			{					
				$status = "success";
				$pesan = "Email reset password berhasil dikirim. Silahkan cek email anda.";
			}
			else
			{
				$status = "failed";
				$pesan = "Email reset password gagal dikirim, hubungi administrator.";
			}
		}

		$result["status"]  = $status;
		$result["message"] = $pesan;
		
		echo json_encode($result);
	}

	function kirim_aktivasi(Request $request)
	{

		$reqKtp = setQuote($request->reqKtp);
		
		$pelamar = new Pelamar();

		$pelamar->selectByParamsSimple(array(), -1, -1, " AND KTP_NO = '" . $reqKtp . "'");
		$pelamar->firstRow();

		$PELAMAR_ID = $pelamar->getField("PELAMAR_ID");
		$AKTIVASI = $pelamar->getField("AKTIVASI");

		if($AKTIVASI == "1")
		{
			$status = "failed";
			$pesan = "Akun sudah aktif.";
		}
		else
		{
			if($pelamar->getField("KTP_NO") == "")
			{	
				$status   = "failed";
				$pesan	  = "NIK tidak terdaftar.";
			}
			else
			{
				$kirimNotifikasi = new KirimNotifikasi();
				$hasil = $kirimNotifikasi->verifikasi_akun($PELAMAR_ID);
				if($hasil == "SUKSES")
				{					
					$status = "success";
					$pesan = "Email aktivasi berhasil dikirim. Silahkan cek email anda.";
				}
				else
				{
					$status = "failed";
					$pesan = "Email aktivasi gagal dikirim, hubungi administrator.";
				}
			}
		}

		$result["status"]  = $status;
		$result["message"] = $pesan;
		
		echo json_encode($result);
	}

	public function verifikasi_isian_formulir()
	{
		  $pelamar = new Pelamar();
		  
		  $pelamar->setField("PELAMAR_ID", $this->userPelamarId);
		  
		  
		  if($pelamar->kirimLamaran())
		  {	
			  $validasi = 1;
			  $pesan	  = "success";
		  }
		  else
		  {
			  $validasi = 0;
			  $pesan	  = "Aktivasi gagal.";
		  }
		  $arrFinal = array("VALIDASI" => $validasi,
							"PESAN" => $pesan);
		  
		  echo json_encode($arrFinal);
	}

	function data_pribadi_add(Request $request)
	{
		
		$pelamar = new Pelamar();

		$reqId = $request->reqId;
		$reqMode = $request->reqMode;

		$reqNPP = $request->reqNPP;
		$reqNama = $request->reqNama;
		$reqAgamaId = $request->reqAgamaId;
		$reqJenisKelamin = $request->reqJenisKelamin;
		$reqAsalPelabuhanId = $request->reqAsalPelabuhanId;
		$reqDepartemen = $request->reqDepartemen;
		$reqTempat = $request->reqTempat;
		$reqTempatFree = $request->reqTempatFree;
		
		if($reqTempat == "")
			$reqTempat = $reqTempatFree;
		
		$reqTanggal = $request->reqTanggal;
		$reqTanggalNpwp = $request->reqTanggalNpwp;
		$reqAlamat = $request->reqAlamat;
		$reqAlamatDomisili = $request->reqAlamatDomisili;
		$reqTelepon = $request->reqTelepon;
		$reqWhatsapp = $request->reqWhatsapp;
		$reqEmail = $request->reqEmail;
		$reqGolDarah = $request->reqGolDarah;
		$reqStatusPernikahan = $request->reqStatusPernikahan;
		$reqNRP = $request->reqNRP;
		$reqFingerId = $request->reqFingerId;

		$reqStatusPegawai = $request->reqStatusPegawai;
		$reqStatusKeluarga = $request->reqStatusKeluarga;
		$reqBankId = $request->reqBankId;
		$reqRekeningNo = $request->reqRekeningNo;
		$reqRekeningNama = $request->reqRekeningNama;
		$reqNPWP = $request->reqNPWP;
		$reqTglPensiun = $request->reqTglPensiun;
		$reqTglMutasiKeluar = $request->reqTglMutasiKeluar;
		$reqTglWafat = $request->reqTglWafat;
		$reqNoSKMPP = $request->reqNoSKMPP;
		$reqTMTMPP = $request->reqTMTMPP;
		$reqHobby = $request->reqHobby;
		$reqFingerId = $request->reqFingerId;
		$reqKtpNo = $request->reqKtpNo;
		$reqTMTNONAKTIF = $request->reqTMTNONAKTIF;
		$reqTglKeluar = $request->reqTglKeluar;
		$reqTglKontrakAkhir = $request->reqTglKontrakAkhir;
		$reqKelompokPegawai = $request->reqKelompokPegawai;

		$reqTinggi = $request->reqTinggi;
		$reqBeratBadan = $request->reqBeratBadan;
		$reqNoSepatu = $request->reqNoSepatu;
		$reqDomisili = $request->reqDomisili;
		$reqKotaId = $request->reqKotaId;

		$reqJamsostek = $request->reqJamsostek;
		$reqJamsostekTanggal = $request->reqJamsostekTanggal;
		$reqKesehatan = $request->reqKesehatan;
		$reqKesehatanTanggal = $request->reqKesehatanTanggal;
		$reqKesehatanFaskes = $request->reqKesehatanFaskes;
		$reqKkNo = $request->reqKkNo;

		$reqProvinsi = $request->reqProvinsi;
		$reqKota = $request->reqKota;
		$reqKecamatan = $request->reqKecamatan;
		$reqKelurahan = $request->reqKelurahan;
		
		
		$reqFacebook = $request->reqFacebook;
		$reqInstagram = $request->reqInstagram;
		$reqTwitter = $request->reqTwitter;
		$reqLinkedin = $request->reqLinkedin;
		

		$reqLampiran = $_FILES['reqLampiran'];
		$reqLampiranTemp = $request->reqLampiranTemp;

		if ($reqDepartemen == 0)
			$reqDepartemen = "NULL";


		$pelamar->setField('PELAMAR_ID', $this->userPelamarId);
		$pelamar->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pelamar->setField('NRP', $reqNRP);
		$pelamar->setField('NIPP', $reqNPP);
		$pelamar->setField('NAMA', setQuote($reqNama, 1));
		$pelamar->setField('AGAMA_ID', $reqAgamaId);
		$pelamar->setField('JENIS_KELAMIN', $reqJenisKelamin);
		$pelamar->setField('PELABUHAN_ID', $reqAsalPelabuhanId);
		$pelamar->setField('TEMPAT_LAHIR', $reqTempat);
		$pelamar->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggal));
		$pelamar->setField('ALAMAT', $reqAlamat);
		$pelamar->setField('TELEPON', $reqTelepon);
		$pelamar->setField('WHATSAPP', $reqWhatsapp);
		$pelamar->setField('EMAIL', $reqEmail);
		$pelamar->setField('GOLONGAN_DARAH', $reqGolDarah);
		$pelamar->setField('STATUS_KAWIN', $reqStatusPernikahan);
		$pelamar->setField('STATUS_PELAMAR_ID', $reqStatusPegawai);
		$pelamar->setField('BANK_ID', $reqBankId);
		$pelamar->setField('REKENING_NO', $reqRekeningNo);
		$pelamar->setField('REKENING_NAMA', $reqRekeningNama);
		$pelamar->setField('NPWP', $reqNPWP);
		$pelamar->setField('STATUS_KELUARGA_ID', $reqStatusKeluarga);
		$pelamar->setField('JAMSOSTEK_NO', $reqJamsostek);
		$pelamar->setField('JAMSOSTEK_TANGGAL', dateToDBCheck($reqJamsostekTanggal));
		$pelamar->setField('KESEHATAN_NO', $reqKesehatan);
		$pelamar->setField('KESEHATAN_TANGGAL', dateToDBCheck($reqKesehatanTanggal));
		$pelamar->setField('HOBBY', $reqHobby);
		$pelamar->setField('FINGER_ID', ValToNullDB($reqFingerId));
		$pelamar->setField('TANGGAL_NPWP', dateToDBCheck($reqTanggalNpwp));
		$pelamar->setField('TINGGI', $reqTinggi);
		$pelamar->setField('BERAT_BADAN', $reqBeratBadan);
		$pelamar->setField('NO_SEPATU', $reqNoSepatu);
		$pelamar->setField('KTP_NO', $reqKtpNo);
		$pelamar->setField('KELOMPOK_PEGAWAI', $reqKelompokPegawai);
		$pelamar->setField('KK_NO', $reqKkNo);
		$pelamar->setField('KESEHATAN_FASKES', $reqKesehatanFaskes);
		$pelamar->setField('TANGGAL_PENSIUN', 'NULL');
		$pelamar->setField('TANGGAL_MUTASI_KELUAR', 'NULL');
		$pelamar->setField('TANGGAL_WAFAT', 'NULL');
		$pelamar->setField('NO_MPP', 'NULL');
		$pelamar->setField('TANGGAL_MPP', 'NULL');
		$pelamar->setField('TGL_NON_AKTIF', 'NULL');
		$pelamar->setField('TGL_DIKELUARKAN', 'NULL');
		$pelamar->setField('TGL_KONTRAK_AKHIR', 'NULL');
		$pelamar->setField('DOMISILI', $reqAlamatDomisili);
		$pelamar->setField('KOTA_ID', $reqDomisili);
		$pelamar->setField('ALAMAT_PROVINSI_ID', $reqProvinsi);
		$pelamar->setField('ALAMAT_KECAMATAN_ID', $reqKecamatan);
		$pelamar->setField('ALAMAT_KELURAHAN_ID', $reqKelurahan);
		$pelamar->setField('ALAMAT_KOTA_ID', $reqKota);
		$pelamar->setField('FACEBOOK', $reqFacebook);
		$pelamar->setField('INSTAGRAM', $reqInstagram);
		$pelamar->setField('TWITTER', $reqTwitter);
		$pelamar->setField('LINKEDIN', $reqLinkedin);
		$pelamar->setField("UPDATED_BY", $this->NIP);
		$pelamar->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
		$pelamar->updateData();

		echo "Data berhasil disimpan.";
	}

	

	public function data_pendidikan_formal_add(Request $request)
	{
		
		$pelamar_pendidikan = new PelamarPendidikan();



		$reqId = $request->reqId;
		$reqMode = $request->reqMode;
		$reqRowId = $request->reqRowId;
		$reqAkreditasi = $request->reqAkreditasi;



		$reqPendidikanId = $request->reqPendidikanId;
		$reqPendidikanBiayaId = $request->reqPendidikanBiayaId;

		// echo 'x'.$reqPendidikanId; exit;

		$reqNama0 = $request->reqNama0;
		$reqUniversitasId = $request->reqUniversitasId;
		$reqNamaInstansi = $request->reqNamaInstansi;

		if ($reqNama0 == "") {
			$reqNama = $reqNamaInstansi;
		} else {
			$reqNama = $reqNama0;
		}

		$reqKota = $request->reqKota;
		$reqKotaFree = $request->reqKotaFree;
		
		
		if($reqKota == "")
			$reqKota = $reqKotaFree;
		
				
		$reqTanggalIjasah = $request->reqTanggalIjasah;
		$reqLulus = $request->reqLulus;
		$reqNoIjasah = $request->reqNoIjasah;
		$reqTtdIjazah = $request->reqTtdIjazah;
		$reqJurusan0 = $request->reqJurusan0;
		$reqJurusanId = $request->reqJurusanId;
		$reqNamaJurusan = $request->reqNamaJurusan;
		$reqInstansi = $request->reqInstansi;
		$reqIsSuratKeterangan = $request->reqIsSuratKeterangan;
		$reqLampiranIjasahOld = $request->reqLampiranIjasahOld?$request->reqLampiranIjasahOld:'';
		$reqLampiranTranskripOld = $request->reqLampiranTranskripOld?$request->reqLampiranIjasahOld:'';
		$reqLampiranIjasah_ = $_FILES["reqLampiranIjasah"];
		$reqLampiranTranskrip_ = $_FILES["reqLampiranTranskrip"];

		if ($reqJurusan0 == "") {
			$reqJurusan = $reqNamaJurusan;
		} else {
			$reqJurusan = $reqJurusan0;
		}

		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$reqLampiranIjasah = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiranIjasah_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiranIjasah_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile1 = date("dmYHis") . "_" . md5($reqLampiranIjasah_['name']) . "_IJASAH_" . $this->userNoRegister . "." . getExtension($reqLampiranIjasah_['name']);
				if (move_uploaded_file($reqLampiranIjasah_['tmp_name'], $FILE_DIR . $renameFile1)) {
					$reqLampiranIjasah = $renameFile1;
				}
			}
		}
		if($reqLampiranIjasah=='' && $reqLampiranIjasahOld !='')
			$reqLampiranIjasah = $reqLampiranIjasahOld;
		$reqLampiranTranskrip = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiranTranskrip_['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiranTranskrip_['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				echo "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
				exit(0);
			} else {
				$renameFile2 = date("dmYHis") . "_" . md5($reqLampiranTranskrip_['name']) . "_IJASAH_" . $this->userNoRegister . "." . getExtension($reqLampiranTranskrip_['name']);
				if (move_uploaded_file($reqLampiranTranskrip_['tmp_name'], $FILE_DIR . $renameFile2)) {
					$reqLampiranTranskrip = $renameFile2;
				}
			}
		}
		if($reqLampiranTranskrip=='' && $reqLampiranTranskripOld !='')
			$reqLampiranTranskrip = $reqLampiranTranskripOld;

		$reqJurusanId = $request->reqJurusanId;
		$reqTanggalAcc = $request->reqTanggalAcc;
		$reqIPK = $request->reqIPK;

		$pelamar_pendidikan->setField('PENDIDIKAN_ID', $reqPendidikanId);
		$pelamar_pendidikan->setField('PENDIDIKAN_BIAYA_ID', ValToNullDB($reqPendidikanBiayaId));
		$pelamar_pendidikan->setField('NAMA', $reqNama);
		$pelamar_pendidikan->setField('KOTA', $reqKota);
		$pelamar_pendidikan->setField('UNIVERSITAS_ID', ValToNullDB($reqUniversitasId));
		$pelamar_pendidikan->setField('TANGGAL_IJASAH', dateToDBCheck($reqTanggalIjasah));
		$pelamar_pendidikan->setField('LULUS', $reqLulus);
		$pelamar_pendidikan->setField('NO_IJASAH', $reqNoIjasah);
		$pelamar_pendidikan->setField('TTD_IJASAH', $reqTtdIjazah);
		$pelamar_pendidikan->setField('JURUSAN', $reqJurusan);
		$pelamar_pendidikan->setField('JURUSAN_ID', ValToNullDB($reqJurusanId));
		$pelamar_pendidikan->setField('TANGGAL_ACC', dateToDBCheck($reqTanggalAcc));
		$pelamar_pendidikan->setField('IPK', $reqIPK);
		$pelamar_pendidikan->setField('PELAMAR_PENDIDIKAN_ID', $reqRowId);
		$pelamar_pendidikan->setField('PELAMAR_ID', $this->userPelamarId);
		$pelamar_pendidikan->setField('JURUSAN_AKREDITASI', $reqAkreditasi);
		$pelamar_pendidikan->setField('INSTANSI', $reqInstansi);
		$pelamar_pendidikan->setField('LAMPIRAN_IJASAH', $reqLampiranIjasah);
		$pelamar_pendidikan->setField('LAMPIRAN_TRANSKRIP', $reqLampiranTranskrip);
		$pelamar_pendidikan->setField('IS_SURAT_KETERANGAN', $reqIsSuratKeterangan);


		if ($reqMode == "insert") {
			$pelamar_pendidikan->setField("CREATED_BY", $this->NIP);
			$pelamar_pendidikan->setField("CREATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_pendidikan->insertData()) {
				$reqRowId = $pelamar_pendidikan->id;
				echo "Data berhasil disimpan.";
			}
			//echo $pelamar_pendidikan->query;
		} else {
			$pelamar_pendidikan->setField("UPDATED_BY", $this->NIP);
			$pelamar_pendidikan->setField("UPDATED_DATE", "CURRENT_TIMESTAMP");
			if ($pelamar_pendidikan->updateData()) {
				echo "Data berhasil disimpan.";
			}
			//echo $pelamar_pendidikan->query;
		}
	
	}

	

	public function data_lampiran_add(Request $request)
	{
		$pelamar = new Pelamar();
		
		$reqNamaDokumen = $request->reqNamaDokumen;
		$reqLampiran = $_FILES["reqLampiran"];

		$ekstensi = "jpg,jpeg,png,pdf";
		$ket = "JPG/JPEG/PNG/PDF";
		/* START UPLOAD FILE */
		$insertLinkFile = "";
		$errorMsg = "";
		$successMsg = "";
		$FILE_DIR = "uploads/";
		if ($reqLampiran['name'] == "") {
		} else {
			$file_ext = strtolower(end(explode('.', $reqLampiran['name'])));
			//if($file_ext != $ekstensi)
			if (!strstr($ekstensi, $file_ext)) {
				$errorMsg .= "Ekstensi tidak diperbolehkan, silahkan pilih file " . $ket . ".";
			} else {
				$renameFile = date("dmYHis")."_".$reqNamaDokumen."_".$this->userNoRegister.".".getExtension($reqLampiran['name']);
				if (move_uploaded_file($reqLampiran['tmp_name'], $FILE_DIR . $renameFile)) {
					$insertLinkFile = $renameFile;
				}
			}
		}
		
		if ($insertLinkFile == "") {
		} else {
			$pelamar->setField("FIELD", $reqNamaDokumen);
			$pelamar->setField("FIELD_VALUE", $insertLinkFile);
			$pelamar->setField("PELAMAR_ID", $this->userPelamarId);
			$pelamar->updateByField();

			$successMsg = "Data berhasil diupload.";
		}
		
		if($successMsg == "")
		{
			$arrResult["result"] = "failed";
			$arrResult["message"] = $errorMsg;
		}
		else
		{
			$arrResult["result"] = "success";
			$arrResult["message"] = $insertLinkFile;
		}
		
		echo json_encode($arrResult);
	
	}

	public function verifikasi_akun(Request $request)
	{
		$TOKEN = $request->TOKEN;
 
		$respon = KAuth::verifyUserToken($TOKEN);
		if($respon["status"] == "success")
		{
			return redirect('app/index/isian_formulir');
		}
		else
		{
			return view('error_restrict');
		}
	
	}


    function verifikasi(Request $request, $TOKEN="")
    {
        if(empty($TOKEN))
            return view('error_restrict');

		$pelamar = new Pelamar();
		
		$pelamar->selectByParamsSimple(array("md5(CONCAT(PELAMAR_ID , 'pelamar' , '$this->MD5KEY'))" => $TOKEN));
		$pelamar->firstRow();
		$reqId = $pelamar->getField("PELAMAR_ID");
		
		$pelamar = new Pelamar();
		$pelamar->setField("PELAMAR_ID", $reqId);
		$pelamar->aktivasi();
		
		if($reqId == "")
			return view('error_restrict');
		else
		{
            $data = array(
                'TOKEN' => $TOKEN,
                "MD5KEY" => $this->MD5KEY
            );	
            return view('persetujuan/verifikasi', $data);
		}

    }


    function registrasi(Request $request, $pg = "register", $reqParse1="")
    {

        $MD5KEY  = config("app.md5key");
        $auth    = KAuth::getIdentity();

        
        if (!view()->exists('main/'.$pg)) 
            return view('error_404');

        $NIK_DAFTAR = $request->session()->get('NIK_DAFTAR');


		$sub_data = array(
			'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
            'NIK_DAFTAR' => $NIK_DAFTAR,
            "MD5KEY" => $MD5KEY,
            "auth" => $auth
		);	
        $data = [
            'pg' => $pg,
			'pg_nama' => strtolower(str_replace("_", " ", $pg)),
            'content' => view("main/".$pg, $sub_data),
            "pesan" => "",
            "auth" => $auth,
            "request" => $request,
            "data" => $sub_data,
            "MD5KEY" => $MD5KEY,
            'NIK_DAFTAR' => $NIK_DAFTAR,
        ];

        $index = "index";
        
        if (view()->exists('main/'.$index)) {
            return view('main/'.$index, $data);
        } else {
            return view('error_404');
        }


    }

    
	public function registrasi_akun(Request $request)
	{

		$reqSubmit = $request->reqSubmit;
		$reqNPP = $request->reqNPP;
		$reqNoKtp =  $request->session()->get('NIK_DAFTAR');
		$reqPassword = $request->reqPassword;
		$reqNama = $request->reqNama;
		$reqTelepon = $request->reqTelepon;
		$reqEmail = $request->reqEmail;
		$reqSecurity = $request->reqSecurity;
		$reqTempat = $request->reqTempat;
		$reqTempatFree = $request->reqTempatFree;
		
		
		if($reqTempat == "")
			$reqTempat = $reqTempatFree;
		
		$reqTanggal = $request->reqTanggal;
		$reqLowonganId = null;

		
        DB::beginTransaction();

		$reqEmail = strtolower($reqEmail);
      
		if ($reqSubmit == "Daftar") {
            $valCaptcha = $request->session()->get('CAPTCHA');

			if (strtoupper($reqSecurity) == strtoupper($valCaptcha)) 
            {
				$pelamar_cek = new Pelamar();
				$statement = " AND (KTP_NO = '" . $reqNoKtp . "' OR UPPER(EMAIL) = '" . strtoupper($reqEmail) . "')";
				$jumlahPelamar = $pelamar_cek->getCountByParams(array(), -1, -1, $statement);

				if (strlen($reqNoKtp) != '16') {
					DB::rollback();
                    $result["status"]   = "failed";
                    $result["message"]  = "Masukkan 16 digit nomor KTP.";
                    echo json_encode($result);
					return;

				} else if ($jumlahPelamar > 0) {
					DB::rollback();
                    $result["status"]   = "failed";
                    $result["message"]  = "No Identitas atau Email sudah terdaftar.";
                    echo json_encode($result);
					return;
				}

				$pelamar = new Pelamar();
				$user_base = new UsersBase();


				$pelamar->setField('NIPP', $reqNPP);
				$pelamar->setField('NAMA', setQuote(strtoupper($reqNama), 1));
				$pelamar->setField('TEMPAT_LAHIR', setQuote($reqTempat));
				$pelamar->setField('EMAIL', setQuote($reqEmail));
				$pelamar->setField('TELEPON', setQuote($reqTelepon));
				$pelamar->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggal));
				$pelamar->setField('KTP_NO', $reqNoKtp);
				$pelamar->setField("CREATED_BY", "PELAMAR");
				$pelamar->setField('KOTA_ID', 'NULL');
				$pelamar->setField('ALAMAT_PROVINSI_ID', 'NULL');
				$pelamar->setField('ALAMAT_KOTA_ID', 'NULL');
				$pelamar->setField('ALAMAT_KECAMATAN_ID', 'NULL');
				$pelamar->setField('ALAMAT_KELURAHAN_ID', 'NULL');
				$pelamar->setField('PERIODE_ID', "1");
				$pelamar->setField('LOWONGAN_ID', "0");


				if ($pelamar->insertData()) {
					$id = $pelamar->id;

					$user_base->setField("NAMA", setQuote($reqNama));
					$user_base->setField("EMAIL", setQuote($reqEmail));
					$user_base->setField("TELEPON", setQuote($reqTelepon));
					$user_base->setField("USER_LOGIN", setQuote($reqNoKtp));
					$user_base->setField("USER_PASS", setQuote($reqPassword));
					$user_base->setField("STATUS", 1);
					$user_base->setField("CREATED_BY", "PELAMAR");
					$user_base->setField("PELAMAR_ID", $id);

					if ($user_base->insertData()) {

                        $kirimNotifikasi = new KirimNotifikasi();
                        $hasil = $kirimNotifikasi->verifikasi_akun($id);
                        
						if ($hasil == "SUKSES") {
							DB::commit();
                            $message  = "Pendaftaran Akun berhasil, silahkan cek email anda untuk melanjutkan proses pendaftaran. Terima kasih.";
                            session()->forget('NIK_DAFTAR');
                            session()->forget('LOWONGAN_DAFTAR');
                                        
                            $result["status"]   = "success";
                            $result["message"]  = $message;
                            echo json_encode($result);
                            return;
                            
						} else {
							DB::rollback();
                            $result["status"]   = "failed";
                            $result["message"]  = "Gagal mengirim email, silahkan hubungi administrator.";
                            echo json_encode($result);
                            return;
						}
					}
				}
			} 
            else
            {
				DB::rollback();
                $result["status"]   = "failed";
                $result["message"]  = "Masukkan captcha dengan benar.";
                echo json_encode($result);
                return;
            }
		}
	}
}
