<?php 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config; 

ini_set("memory_limit","500M");
ini_set('max_execution_time', 0);


class ProsesDokumen
{
    public static $rowResult;
    private $sap_url;

    
    function sap()
    {
        ini_set('max_execution_time', '0');
        $this->sap_url = Config::get("app.sap_url");

        $message = $this->za_hris_kary();
        $sql = " UPDATE log_sinkronisasi SET 
                    status = 'IDLE', 
                    status_result = '$message', 
                    updated_date = current_timestamp,
                    next_date = current_date + interval '1' day
                 where kode = 'za_hris_kary' ";
        $this->exec($sql);

        $message = $this->za_hris_kary01();
        $sql = " UPDATE log_sinkronisasi SET 
                    status = 'IDLE', 
                    status_result = '$message', 
                    updated_date = current_timestamp,
                    next_date = current_date + interval '1' day
                 where kode = 'za_hris_kary01' ";
        $this->exec($sql);

        // $message = $this->za_hris_orgz();
        // $sql = " UPDATE log_sinkronisasi SET 
        //             status = 'IDLE', 
        //             status_result = '$message', 
        //             updated_date = current_timestamp,
        //             next_date = current_date + interval '1' day
        //          where kode = 'za_hris_orgz' ";
        // $this->exec($sql);

        // $message = $this->za_hris_pjbt();
        // $sql = " UPDATE log_sinkronisasi SET 
        //             status = 'IDLE', 
        //             status_result = '$message', 
        //             updated_date = current_timestamp,
        //             next_date = current_date + interval '1' day
        //          where kode = 'za_hris_pjbt' ";
        // $this->exec($sql);

        return "SUKSES";
    }
	
    public function za_hris_pjbt()
    {
        ini_set('max_execution_time', '0');

        $sql = " select awal, akhir from za_hris_pjbt_filter
                 where 1 = 1
                 order by urut ";

        $rowResult = KDatabase::query($sql)->result_array();
        $jumlah = 0;

        foreach($rowResult as $row)
        {
            $awal = $row["awal"];
            $akhir = $row["akhir"];

            $result = $this->za_hris_pjbt_filter($awal, $akhir);
            $jumlah += $result;

        }

        $result  = $jumlah." data berhasil disinkronisasi.";

        return $result;

    }


    public function za_hris_pjbt_filter($awal, $akhir)
    {
        ini_set('max_execution_time', '0');
        $apiName    = "?p_cek=x&p_cds=ZA_HRIS_PJBT&p_user=A0000005&p_pass=PerkebunanNusantara@1&p_filter=o1id;ge;".$awal.";and;o1id;le;".$akhir."";
        $apiToken   = "";
        $created_by = "SAP";

        $sql = " insert into log_api (url, response) values('".$apiName."', 'exec')";
        $this->exec($sql);

        $arrResult = $this->getArrayData($this->sap_url, $apiName, $apiToken, []);

        if(empty($arrResult))
        {
            $message  = "Format JSON tidak sesuai";
            $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
            $this->exec($sql);
            return 0; 
        }
        
        
        $jumlah = 0;
        foreach($arrResult as $row)
        {
            
            $tanggal_mulai = setQuote($row["tanggal_mulai"]);
            $tanggal_selesai = setQuote($row["tanggal_selesai"]);
            $o1id = setQuote($row["o1id"]);
            $o1text = setQuote($row["o1text"]);
            $relasi = setQuote($row["relasi"]);
            $o2id = setQuote($row["o2id"]);
            $o2text = setQuote($row["o2text"]);


            
            $sql = " INSERT INTO za_hris_pjbt
                        (tanggal_mulai, tanggal_selesai, o1id, o1text, relasi, o2id, o2text, created_by)
                        VALUES('$tanggal_mulai', '$tanggal_selesai', '$o1id', '$o1text', '$relasi', '$o2id', '$o2text', '$created_by')
                        ON DUPLICATE KEY UPDATE 
                        tanggal_selesai     = '$tanggal_selesai',
                        o1text              = '$o1text',
                        relasi              = '$relasi',
                        o2id            = '$o2id',
                        o2text          = '$o2text',
                        updated_by      = '$created_by',
                        updated_date    = CURRENT_TIMESTAMP ";

            $hasil = KDatabase::exec($sql);
            if(!$hasil)
            {
                $message  = "Proses sinkronisasi gagal. Cek kembali format o1id : ".$o1id.".";
                $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
                $this->exec($sql);
            }
            else
                $jumlah++;

        }

        $sql = " insert into log_api (url, response) values('".$apiName."', 'finish')";
        $this->exec($sql);

        return $jumlah;
        
        // $result  =  $jumlah." data berhasil disinkronisasi.";

        // return $result;    
    }
    
    public function za_hris_orgz()
    {
        ini_set('max_execution_time', '0');
        $apiName    = "?p_cek=x&p_cds=ZA_HRIS_ORGZ&p_user=A0000005&p_pass=PerkebunanNusantara@1";
        $apiToken   = "";
       
        $created_by = "SAP";

        $sql = " insert into log_api (url, response) values('".$apiName."', 'exec')";
        $this->exec($sql);

        $arrResult = $this->getArrayData($this->sap_url, $apiName, $apiToken, []);

        if(empty($arrResult))
        {
            $message  = "Format JSON tidak sesuai";
            $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
            $this->exec($sql);
            return $message; 
        }
        
       // DB::beginTransaction();
        
        $jumlah = 0;
        foreach($arrResult as $row)
        {
            
            $tanggal_mulai = setQuote($row["tanggal_mulai"]);
            $tanggal_selesai = setQuote($row["tanggal_selesai"]);
            $o1id = setQuote($row["o1id"]);
            $o1text = setQuote($row["o1text"]);
            $relasi = setQuote($row["relasi"]);
            $o2id = setQuote($row["o2id"]);
            $o2text = setQuote($row["o2text"]);


            
            $sql = " INSERT INTO za_hris_orgz
                        (tanggal_mulai, tanggal_selesai, o1id, o1text, relasi, o2id, o2text, created_by)
                        VALUES('$tanggal_mulai', '$tanggal_selesai', '$o1id', '$o1text', '$relasi', '$o2id', '$o2text', '$created_by')
                        ON DUPLICATE KEY UPDATE 
                        tanggal_selesai     = '$tanggal_selesai',
                        o1text              = '$o1text',
                        relasi              = '$relasi',
                        o2id            = '$o2id',
                        o2text          = '$o2text',
                        updated_by      = '$created_by',
                        updated_date    = CURRENT_TIMESTAMP ";

            $hasil = KDatabase::exec($sql);
            if(!$hasil)
            {
                $message  = "Proses sinkronisasi gagal. Cek kembali format o1id : ".$o1id.".";
                $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
                $this->exec($sql);
            }
            else
                $jumlah++;

        }

        $sql = " insert into log_api (url, response) values('".$apiName."', 'finish')";
        $this->exec($sql);
        
        //DB::commit();
        $result  =  $jumlah." data berhasil disinkronisasi.";

        return $result;
    }



    public function za_hris_kary01()
    {
        ini_set('max_execution_time', '0');

        $sql = " select awal, akhir from za_hris_kary01_filter 
                 where 1 = 1
                 order by urut ";

        $rowResult = KDatabase::query($sql)->result_array();
        $jumlah = 0;

        foreach($rowResult as $row)
        {
            $awal = $row["awal"];
            $akhir = $row["akhir"];

            $result = $this->za_hris_kary01_filter($awal, $akhir);
            $jumlah += $result;

        }

        $result  = $jumlah." data berhasil disinkronisasi.";

        return $result;

    }

    public function za_hris_kary01_filter($awal, $akhir)
    {
        ini_set('max_execution_time', '0');
        $apiName    = "?p_cek=x&p_cds=ZA_HRIS_KARY01&p_user=A0000005&p_pass=PerkebunanNusantara@1&p_filter=nik_sap;ge;".$awal.";and;nik_sap;le;".$akhir."";
        $apiToken   = "";
       
        $created_by = "SAP";
        
        $sql = " insert into log_api (url, response) values('".$apiName."', 'exec')";
        $this->exec($sql);

        $arrResult = $this->getArrayData($this->sap_url, $apiName, $apiToken, []);

        if(empty($arrResult))
        {
            $message  = "Format JSON tidak sesuai";
            $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
            $this->exec($sql);
            return 0; 
        }
        
       // DB::beginTransaction();
        
        $jumlah = 0;
        foreach($arrResult as $row)
        {
            
            $nik_sap = setQuote($row["nik_sap"]);
            $tgl_awal = setQuote($row["tgl_awal"]);
            $tgl_akhir = setQuote($row["tgl_akhir"]);
            $kode_posisi = setQuote($row["kode_posisi"]);
            $posisi_jabatan = setQuote($row["posisi_jabatan"]);
            $level_bod = setQuote($row["level_bod"]);
            $bagian = setQuote($row["bagian"]);
            $perusahaan = setQuote($row["perusahaan"]);
            $kode_personnel_area = setQuote($row["kode_personnel_area"]);
            $personnel_area = setQuote($row["personnel_area"]);
            $kode_personnel_subarea = setQuote($row["kode_personnel_subarea"]);
            $personnel_subarea = setQuote($row["personnel_subarea"]);
            $kode_employee_group = setQuote($row["kode_employee_group"]);
            $employee_group = setQuote($row["employee_group"]);
            $kode_employee_subgroup = setQuote($row["kode_employee_subgroup"]);
            $employee_subgroup = setQuote($row["employee_subgroup"]);
            $kode_job_group = setQuote($row["kode_job_group"]);
            $job_group = setQuote($row["job_group"]);
            $person_grade = setQuote($row["person_grade"]);
            $person_level = setQuote($row["person_level"]);
            $gol_phdp_grade = setQuote($row["gol_phdp_grade"]);
            $gol_phdp_level = setQuote($row["gol_phdp_level"]);


            
            $sql = " INSERT INTO za_hris_kary01
                        (nik_sap, tgl_awal, tgl_akhir, kode_posisi, posisi_jabatan, level_bod, bagian, perusahaan, 
                        kode_personnel_area, personnel_area, kode_personnel_subarea, personnel_subarea, kode_employee_group, employee_group, kode_employee_subgroup, 
                        employee_subgroup, kode_job_group, job_group, person_grade, person_level, gol_phdp_grade, gol_phdp_level,
                        created_by)
                        VALUES('$nik_sap', '$tgl_awal', '$tgl_akhir', '$kode_posisi', '$posisi_jabatan', '$level_bod', '$bagian', 
                                '$perusahaan', 
                                '$kode_personnel_area', '$personnel_area', '$kode_personnel_subarea', '$personnel_subarea', '$kode_employee_group', '$employee_group', '$kode_employee_subgroup', 
                                '$employee_subgroup', '$kode_job_group', '$job_group', '$person_grade', '$person_level', '$gol_phdp_grade', '$gol_phdp_level',
                                '$created_by')
                        ON DUPLICATE KEY UPDATE 
                        tgl_akhir       = '$tgl_akhir',
                        kode_posisi     = '$kode_posisi',
                        posisi_jabatan  = '$posisi_jabatan',
                        level_bod       = '$level_bod',
                        bagian          = '$bagian',
                        perusahaan      = '$perusahaan',
                        kode_personnel_area      = '$kode_personnel_area', 
                        personnel_area          = '$personnel_area', 
                        kode_personnel_subarea  = '$kode_personnel_subarea', 
                        personnel_subarea       = '$personnel_subarea', 
                        kode_employee_group     = '$kode_employee_group', 
                        employee_group         = '$employee_group', 
                        kode_employee_subgroup  = '$kode_employee_subgroup', 
                        employee_subgroup      = '$employee_subgroup', 
                        kode_job_group         = '$kode_job_group', 
                        job_group             = '$job_group', 
                        person_grade          = '$person_grade', 
                        person_level          = '$person_level', 
                        gol_phdp_grade        = '$gol_phdp_grade', 
                        gol_phdp_level        = '$gol_phdp_level',
                        updated_by      = '$created_by',
                        updated_date    = CURRENT_TIMESTAMP ";

            $hasil = KDatabase::exec($sql);
            if(!$hasil)
            {
                $message  = "Proses sinkronisasi gagal. Cek kembali format nik : ".$nik_sap.".";
                $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
                $this->exec($sql); 
            }
            else
                $jumlah++;

        }

        //DB::commit();

        $sql = " insert into log_api (url, response) values('".$apiName."', 'finish')";
        $this->exec($sql);
    
        return $jumlah;
        // $result  =  $jumlah." data berhasil disinkronisasi.";
        // return $result;
    }


    public function za_hris_kary()
    {
        ini_set('max_execution_time', '0');
        $regional_kode = "";

        $statement = "";
        if(!empty($regional_kode))
            $statement = " and kode = '$regional_kode' ";

        $sql = " select kode from regional 
                 where 1 = 1 ".$statement." 
                 order by regional_id ";

        $rowResult = KDatabase::query($sql)->result_array();
        $jumlah = 0;

        foreach($rowResult as $row)
        {
            $regional_kode = $row["kode"];

            $result = $this->za_hris_kary_region($regional_kode, $jumlah);
            $jumlah += $result;

        }

        $result  = $jumlah." data berhasil disinkronisasi.";

        return $result;

    }

    public function za_hris_kary_region($region, $jumlah=0)
    {
        ini_set('max_execution_time', '0');
        $apiName    = "?p_cek=x&p_cds=ZA_HRIS_KARY&p_user=A0000005&p_pass=PerkebunanNusantara@1&p_filter=regional;eq;%27".$region."%27";
        $apiToken   = "";
       
        $created_by = "SAP";

        $sql = " insert into log_api (url, response) values('".$apiName."', 'exec')";
        $this->exec($sql);

        $arrResult = $this->getArrayData($this->sap_url, $apiName, $apiToken, []);
        
        if(empty($arrResult))
        {
            $message  = "Format JSON tidak sesuai";
            $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
            $this->exec($sql);
            return 0; 
        }

        //DB::beginTransaction();

        foreach($arrResult as $row)
        {
            
            $perusahaan = setQuote($row["perusahaan"]);
            $regional = setQuote($row["regional"]);
            $nik_sap = setQuote($row["nik_sap"]);
            $nama_karyawan = setQuote($row["nama_karyawan"]);
            $gelar_depan = setQuote($row["gelar_depan"]);
            $gelar_belakang = setQuote($row["gelar_belakang"]);
            $tempat_lahir = setQuote($row["tempat_lahir"]);
            $tanggal_lahir = setQuote($row["tanggal_lahir"]);
            $jenis_kelamin = setQuote($row["jenis_kelamin"]);
            $agama = setQuote($row["agama"]);
            $suku = setQuote($row["suku"]);
            $golongan_darah = setQuote($row["golongan_darah"]);
            $posisi_jabatan = setQuote($row["posisi_jabatan"]);
            $job_group = setQuote($row["job_group"]);
            $job_function = setQuote($row["job_function"]);
            $job = setQuote($row["job"]);
            $status = setQuote($row["status"]);
            $penugasan_ke = setQuote($row["penugasan_ke"]);
            $personnel_area = setQuote($row["personnel_area"]);
            $personnel_subarea_code = setQuote($row["personnel_subarea_code"]);
            $personnel_subarea = setQuote($row["personnel_subarea"]);
            $employee_group = setQuote($row["employee_group"]);
            $employee_subgroup = setQuote($row["employee_subgroup"]);
            $person_grade = setQuote($row["person_grade"]);
            $person_level = setQuote($row["person_level"]);
            $gol_phdp_grade = setQuote($row["gol_phdp_grade"]);
            $gol_phdp_level = setQuote($row["gol_phdp_level"]);
            $level_bod = setQuote($row["level_bod"]);
            $pengangkatan = setQuote($row["pengangkatan"]);
            $pengangkatan_karpim = setQuote($row["pengangkatan_karpim"]);
            $mbt = setQuote($row["mbt"]);
            $pensiun = setQuote($row["pensiun"]);
            $acuan_masa_kerja = setQuote($row["acuan_masa_kerja"]);
            $acuan_cuti_tahunan = setQuote($row["acuan_cuti_tahunan"]);
            $acuan_cuti_panjang = setQuote($row["acuan_cuti_panjang"]);
            $acuan_jubilium = setQuote($row["acuan_jubilium"]);
            $acuan_sht = setQuote($row["acuan_sht"]);
            $nomor_bpjs_tk = setQuote($row["nomor_bpjs_tk"]);
            $nomor_bpjs_ks = setQuote($row["nomor_bpjs_ks"]);
            $nomor_dapenbun = setQuote($row["nomor_dapenbun"]);
            $nomor_dplk_bri = setQuote($row["nomor_dplk_bri"]);
            $nomor_dplk_bni = setQuote($row["nomor_dplk_bni"]);
            $npwp = setQuote($row["npwp"]);
            $ptkp = setQuote($row["ptkp"]);
            $no_ktp = setQuote($row["no_ktp"]);
            $no_kk = setQuote($row["no_kk"]);
            $alamat_ktp = setQuote($row["alamat_ktp"]);
            $alamat_domisili = setQuote($row["alamat_domisili"]);
            $alamat_email = setQuote($row["alamat_email"]);
            $no_tlp = setQuote($row["no_tlp"]);
            $rekening_bank = setQuote($row["rekening_bank"]);
            $nomor_rekening = setQuote($row["nomor_rekening"]);
            $nama_pasangan = setQuote($row["nama_pasangan"]);
            $tanggal_lahir_pasangan = setQuote($row["tanggal_lahir_pasangan"]);
            $nik_ktp_pasangan = setQuote($row["nik_ktp_pasangan"]);
            $nama_anak_1 = setQuote($row["nama_anak_1"]);
            $tanggal_lahir_anak_1 = setQuote($row["tanggal_lahir_anak_1"]);
            $nik_ktp_anak_1 = setQuote($row["nik_ktp_anak_1"]);
            $nama_anak_2 = setQuote($row["nama_anak_2"]);
            $tanggal_lahir_anak_2 = setQuote($row["tanggal_lahir_anak_2"]);
            $nik_ktp_anak_2 = setQuote($row["nik_ktp_anak_2"]);
            $nama_anak_3 = setQuote($row["nama_anak_3"]);
            $tanggal_lahir_anak_3 = setQuote($row["tanggal_lahir_anak_3"]);
            $nik_ktp_anak_3 = setQuote($row["nik_ktp_anak_3"]);
            $nama_anak_4 = setQuote($row["nama_anak_4"]);
            $tanggal_lahir_anak_4 = setQuote($row["tanggal_lahir_anak_4"]);
            $nik_ktp_anak_4 = setQuote($row["nik_ktp_anak_4"]);
            $nama_emergency_contact = setQuote($row["nama_emergency_contact"]);
            $hubungan_emergency_contact = setQuote($row["hubungan_emergency_contact"]);
            $telepon_emergency_contact = setQuote($row["telepon_emergency_contact"]);
            $alamat_emergency_contact = setQuote($row["alamat_emergency_contact"]);
            $pendidikan_akhir = setQuote($row["pendidikan_akhir"]);
            $jurusan_pendidikan_akhir = setQuote($row["jurusan_pendidikan_akhir"]);
            $nama_sekolah_akhir = setQuote($row["nama_sekolah_akhir"]);
            $nama_sd = setQuote($row["nama_sd"]);
            $nama_smp = setQuote($row["nama_smp"]);
            $nama_sma = setQuote($row["nama_sma"]);
            $nama_diploma = setQuote($row["nama_diploma"]);
            $nama_s1 = setQuote($row["nama_s1"]);
            $nama_s2 = setQuote($row["nama_s2"]);
            $nama_s3 = setQuote($row["nama_s3"]);


            $nik_lama = setQuote($row["nik_lama"]);
            $mulai_bekerja = setQuote($row["mulai_bekerja"]);
            $status_pernikahan = setQuote($row["status_pernikahan"]);
            $kode_employee_group = setQuote($row["kode_employee_group"]);
            $kode_employee_subgroup = setQuote($row["kode_employee_subgroup"]);
            $kode_work_contract = setQuote($row["kode_work_contract"]);
            $work_contract = setQuote($row["work_contract"]);
            $kode_unit_organisasi = setQuote($row["kode_unit_organisasi"]);
            $unit_organisasi = setQuote($row["unit_organisasi"]);
            $kode_posisi_jabatan = setQuote($row["kode_posisi_jabatan"]);
            $kode_job = setQuote($row["kode_job"]);
            $kode_job_function = setQuote($row["kode_job_function"]);
            $kode_job_group = setQuote($row["kode_job_group"]);
            $kode_cost_center = setQuote($row["kode_cost_center"]);
            $cost_center = setQuote($row["cost_center"]);
            $kode_payroll_area = setQuote($row["kode_payroll_area"]);
            $payroll_area = setQuote($row["payroll_area"]);
            $kode_bank = setQuote($row["kode_bank"]);
            $nama_bank = setQuote($row["nama_bank"]);
            $married_for_tax_purpose = setQuote($row["married_for_tax_purpose"]);
            $spouse_benefit = setQuote($row["spouse_benefit"]);
            $jumlah_tanggungan = setQuote($row["jumlah_tanggungan"]);
            $kode_aksi = setQuote($row["kode_aksi"]);
            $aksi = setQuote($row["aksi"]);
            $kode_alasan_aksi = setQuote($row["kode_alasan_aksi"]);
            $alasan_aksi = setQuote($row["alasan_aksi"]);
            $afdeling = setQuote($row["afdeling"]);
            $plant = setQuote($row["plant"]);
            $no_bpjs_anak_1 = setQuote($row["no_bpjs_anak_1"]);
            $no_bpjs_anak_2 = setQuote($row["no_bpjs_anak_2"]);
            $no_bpjs_anak_3 = setQuote($row["no_bpjs_anak_3"]);
            $no_bpjs_anak_4 = setQuote($row["no_bpjs_anak_4"]);




            $sql = " INSERT INTO za_hris_kary
                        (perusahaan, regional, nik_sap, nama_karyawan, gelar_depan, gelar_belakang, tempat_lahir, tanggal_lahir, 
                        jenis_kelamin, agama, suku, golongan_darah, posisi_jabatan, job_group, job_function, job, status, 
                        penugasan_ke, personnel_area, personnel_subarea_code, personnel_subarea, employee_group, 
                        employee_subgroup, person_grade, person_level, gol_phdp_grade, gol_phdp_level, level_bod, 
                        pengangkatan, pengangkatan_karpim, mbt, pensiun, acuan_masa_kerja, acuan_cuti_tahunan, 
                        acuan_cuti_panjang, acuan_jubilium, acuan_sht, nomor_bpjs_tk, nomor_bpjs_ks, nomor_dapenbun, 
                        nomor_dplk_bri, nomor_dplk_bni, npwp, ptkp, no_ktp, no_kk, alamat_ktp, alamat_domisili, alamat_email, 
                        no_tlp, rekening_bank, nomor_rekening, nama_pasangan, tanggal_lahir_pasangan, nik_ktp_pasangan, 
                        nama_anak_1, tanggal_lahir_anak_1, nik_ktp_anak_1, nama_anak_2, tanggal_lahir_anak_2, nik_ktp_anak_2, 
                        nama_anak_3, tanggal_lahir_anak_3, nik_ktp_anak_3, nama_anak_4, tanggal_lahir_anak_4, nik_ktp_anak_4, 
                        nama_emergency_contact, hubungan_emergency_contact, telepon_emergency_contact, alamat_emergency_contact, 
                        pendidikan_akhir, jurusan_pendidikan_akhir, nama_sekolah_akhir, nama_sd, nama_smp, nama_sma, nama_diploma, 
                        nama_s1, nama_s2, nama_s3, 
                        nik_lama, mulai_bekerja, status_pernikahan, kode_employee_group, kode_employee_subgroup, 
                        kode_work_contract, work_contract, kode_unit_organisasi, unit_organisasi, kode_posisi_jabatan, 
                        kode_job, kode_job_function, kode_job_group, kode_cost_center, cost_center, kode_payroll_area, 
                        payroll_area, kode_bank, nama_bank, married_for_tax_purpose, spouse_benefit, jumlah_tanggungan, 
                        kode_aksi, aksi, kode_alasan_aksi, alasan_aksi, afdeling, plant, no_bpjs_anak_1, no_bpjs_anak_2, no_bpjs_anak_3, no_bpjs_anak_4,
                        created_by)
                        VALUES('$perusahaan', '$regional', '$nik_sap', '$nama_karyawan', '$gelar_depan', '$gelar_belakang', '$tempat_lahir', 
                                '$tanggal_lahir', '$jenis_kelamin', '$agama', '$suku', '$golongan_darah', '$posisi_jabatan', '$job_group', 
                                '$job_function', '$job', '$status', '$penugasan_ke', '$personnel_area', '$personnel_subarea_code', 
                                '$personnel_subarea', '$employee_group', '$employee_subgroup', '$person_grade', '$person_level', 
                                '$gol_phdp_grade', '$gol_phdp_level', '$level_bod', '$pengangkatan', '$pengangkatan_karpim', '$mbt', 
                                '$pensiun', '$acuan_masa_kerja', '$acuan_cuti_tahunan', '$acuan_cuti_panjang', '$acuan_jubilium', 
                                '$acuan_sht', '$nomor_bpjs_tk', '$nomor_bpjs_ks', '$nomor_dapenbun', '$nomor_dplk_bri', '$nomor_dplk_bni', 
                                '$npwp', '$ptkp', '$no_ktp', '$no_kk', '$alamat_ktp', '$alamat_domisili', '$alamat_email', '$no_tlp', 
                                '$rekening_bank', '$nomor_rekening', '$nama_pasangan', '$tanggal_lahir_pasangan', '$nik_ktp_pasangan', 
                                '$nama_anak_1', '$tanggal_lahir_anak_1', '$nik_ktp_anak_1', '$nama_anak_2', '$tanggal_lahir_anak_2', 
                                '$nik_ktp_anak_2', '$nama_anak_3', '$tanggal_lahir_anak_3', '$nik_ktp_anak_3', '$nama_anak_4', 
                                '$tanggal_lahir_anak_4', '$nik_ktp_anak_4', '$nama_emergency_contact', '$hubungan_emergency_contact', 
                                '$telepon_emergency_contact', '$alamat_emergency_contact', '$pendidikan_akhir', '$jurusan_pendidikan_akhir', 
                                '$nama_sekolah_akhir', '$nama_sd', '$nama_smp', '$nama_sma', '$nama_diploma', '$nama_s1', '$nama_s2', 
                                '$nama_s3', 
                                '$nik_lama', '$mulai_bekerja', '$status_pernikahan', '$kode_employee_group', '$kode_employee_subgroup', 
                                '$kode_work_contract', '$work_contract', '$kode_unit_organisasi', '$unit_organisasi', '$kode_posisi_jabatan', 
                                '$kode_job', '$kode_job_function', '$kode_job_group', '$kode_cost_center', '$cost_center', '$kode_payroll_area', 
                                '$payroll_area', '$kode_bank', '$nama_bank', '$married_for_tax_purpose', '$spouse_benefit', '$jumlah_tanggungan', 
                                '$kode_aksi', '$aksi', '$kode_alasan_aksi', '$alasan_aksi', '$afdeling', '$plant', '$no_bpjs_anak_1', '$no_bpjs_anak_2', '$no_bpjs_anak_3', '$no_bpjs_anak_4',
                                '$created_by')
                        ON DUPLICATE KEY UPDATE 
                        perusahaan = '$perusahaan',
                        regional = '$regional',
                        nik_sap = '$nik_sap',
                        nama_karyawan = '$nama_karyawan',
                        gelar_depan = '$gelar_depan',
                        gelar_belakang = '$gelar_belakang',
                        tempat_lahir = '$tempat_lahir',
                        tanggal_lahir = '$tanggal_lahir',
                        jenis_kelamin = '$jenis_kelamin',
                        agama = '$agama',
                        suku = '$suku',
                        golongan_darah = '$golongan_darah',
                        posisi_jabatan = '$posisi_jabatan',
                        job_group = '$job_group',
                        job_function = '$job_function',
                        job = '$job',
                        status = '$status',
                        penugasan_ke = '$penugasan_ke',
                        personnel_area = '$personnel_area',
                        personnel_subarea_code = '$personnel_subarea_code',
                        personnel_subarea = '$personnel_subarea',
                        employee_group = '$employee_group',
                        employee_subgroup = '$employee_subgroup',
                        person_grade = '$person_grade',
                        person_level = '$person_level',
                        gol_phdp_grade = '$gol_phdp_grade',
                        gol_phdp_level = '$gol_phdp_level',
                        level_bod = '$level_bod',
                        pengangkatan = '$pengangkatan',
                        pengangkatan_karpim = '$pengangkatan_karpim',
                        mbt = '$mbt',
                        pensiun = '$pensiun',
                        acuan_masa_kerja = '$acuan_masa_kerja',
                        acuan_cuti_tahunan = '$acuan_cuti_tahunan',
                        acuan_cuti_panjang = '$acuan_cuti_panjang',
                        acuan_jubilium = '$acuan_jubilium',
                        acuan_sht = '$acuan_sht',
                        nomor_bpjs_tk = '$nomor_bpjs_tk',
                        nomor_bpjs_ks = '$nomor_bpjs_ks',
                        nomor_dapenbun = '$nomor_dapenbun',
                        nomor_dplk_bri = '$nomor_dplk_bri',
                        nomor_dplk_bni = '$nomor_dplk_bni',
                        npwp = '$npwp',
                        ptkp = '$ptkp',
                        no_ktp = '$no_ktp',
                        no_kk = '$no_kk',
                        alamat_ktp = '$alamat_ktp',
                        alamat_domisili = '$alamat_domisili',
                        alamat_email = '$alamat_email',
                        no_tlp = '$no_tlp',
                        rekening_bank = '$rekening_bank',
                        nomor_rekening = '$nomor_rekening',
                        nama_pasangan = '$nama_pasangan',
                        tanggal_lahir_pasangan = '$tanggal_lahir_pasangan',
                        nik_ktp_pasangan = '$nik_ktp_pasangan',
                        nama_anak_1 = '$nama_anak_1',
                        tanggal_lahir_anak_1 = '$tanggal_lahir_anak_1',
                        nik_ktp_anak_1 = '$nik_ktp_anak_1',
                        nama_anak_2 = '$nama_anak_2',
                        tanggal_lahir_anak_2 = '$tanggal_lahir_anak_2',
                        nik_ktp_anak_2 = '$nik_ktp_anak_2',
                        nama_anak_3 = '$nama_anak_3',
                        tanggal_lahir_anak_3 = '$tanggal_lahir_anak_3',
                        nik_ktp_anak_3 = '$nik_ktp_anak_3',
                        nama_anak_4 = '$nama_anak_4',
                        tanggal_lahir_anak_4 = '$tanggal_lahir_anak_4',
                        nik_ktp_anak_4 = '$nik_ktp_anak_4',
                        nama_emergency_contact = '$nama_emergency_contact',
                        hubungan_emergency_contact = '$hubungan_emergency_contact',
                        telepon_emergency_contact = '$telepon_emergency_contact',
                        alamat_emergency_contact = '$alamat_emergency_contact',
                        pendidikan_akhir = '$pendidikan_akhir',
                        jurusan_pendidikan_akhir = '$jurusan_pendidikan_akhir',
                        nama_sekolah_akhir = '$nama_sekolah_akhir',
                        nama_sd = '$nama_sd',
                        nama_smp = '$nama_smp',
                        nama_sma = '$nama_sma',
                        nama_diploma = '$nama_diploma',
                        nama_s1 = '$nama_s1',
                        nama_s2 = '$nama_s2',
                        nama_s3 = '$nama_s3',
                        nik_lama = '$nik_lama', 
                        mulai_bekerja = '$mulai_bekerja', 
                        status_pernikahan = '$status_pernikahan', 
                        kode_employee_group = '$kode_employee_group', 
                        kode_employee_subgroup = '$kode_employee_subgroup', 
                        kode_work_contract = '$kode_work_contract', 
                        work_contract = '$work_contract', 
                        kode_unit_organisasi = '$kode_unit_organisasi', 
                        unit_organisasi = '$unit_organisasi', 
                        kode_posisi_jabatan = '$kode_posisi_jabatan', 
                        kode_job = '$kode_job', 
                        kode_job_function = '$kode_job_function', 
                        kode_job_group = '$kode_job_group', 
                        kode_cost_center = '$kode_cost_center', 
                        cost_center = '$cost_center', 
                        kode_payroll_area = '$kode_payroll_area', 
                        payroll_area = '$payroll_area', 
                        kode_bank = '$kode_bank', 
                        nama_bank = '$nama_bank', 
                        married_for_tax_purpose = '$married_for_tax_purpose', 
                        spouse_benefit = '$spouse_benefit', 
                        jumlah_tanggungan = '$jumlah_tanggungan', 
                        kode_aksi = '$kode_aksi', 
                        aksi = '$aksi', 
                        kode_alasan_aksi = '$kode_alasan_aksi', 
                        alasan_aksi = '$alasan_aksi', 
                        afdeling = '$afdeling', 
                        plant = '$plant', 
                        no_bpjs_anak_1 = '$no_bpjs_anak_1', 
                        no_bpjs_anak_2 = '$no_bpjs_anak_2', 
                        no_bpjs_anak_3 = '$no_bpjs_anak_3', 
                        no_bpjs_anak_4 = '$no_bpjs_anak_4',
                        updated_by      = '$created_by',
                        updated_date    = CURRENT_TIMESTAMP ";

            $hasil = KDatabase::exec($sql);
            if(!$hasil)
            {
                //DB::rollback();
                $message  = "Proses sinkronisasi gagal. Cek kembali format nik : ".$nik_sap.".";
                $sql = " insert into log_api (url, tipe, response) values('".$apiName."', 'error', '$message')";
                $this->exec($sql);
            }
            else
                $jumlah++;
        }

        $sql = " insert into log_api (url, response) values('".$apiName."', 'finish')";
        $this->exec($sql);
        
        //DB::commit();

        return $jumlah; 

    }


    function date($_date)
    {
        if ($_date == "") {
            return "";
        }
        $arrDate = explode("-", $_date);
        $_date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
        return $_date;
    }

    function format_hari($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $arrDate[0];
    }

    function format_bulan($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $arrDate[1];
    }

    function format_tahun($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $arrDate[2];
    }

    function format_hari_kata($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $this->terbilang((int)$arrDate[0]);
    }

    function format_bulan_kata($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $this->terbilang((int)$arrDate[1]);
    }

    function format_tahun_kata($_date)
    {
        $_date = $this->date($_date);

        if ($_date == "")
            return "";

        $arrDate = explode("-", $_date);
        return $this->terbilang((int)$arrDate[2]);
    }

    function format_namahari($hari)
    {
        if ($hari == "")
            return "";

        $hari = strtoupper(trim($hari));

        if ($hari == "SUNDAY") $hari = "Minggu";
        else if ($hari == "MONDAY") $hari = "Senin";
        else if ($hari == "TUESDAY") $hari = "Selasa";
        else if ($hari == "WEDNESDAY") $hari = "Rabu";
        else if ($hari == "THURSDAY") $hari = "Kamis";
        else if ($hari == "FRIDAY") $hari = "Jumat";
        else if ($hari == "SATURDAY") $hari = "Sabtu";
    
    
        return $hari;
    }
        
    function format_tanggal($_date)
    {
        $_date = $this->date($_date);
        
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

    

    function format_tanggaljam($_date)
    {
        if(trim($_date) == "")
            return "";


        $arrDateTime = explode(" ", $_date);
        
        $_date = $arrDateTime[0];
        $_time = $arrDateTime[1];
        

        return $this->format_tanggal($_date)." ".$_time." WIB";

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
        self::$rowResult = DB::select(strtolower($sql));
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

    function setQuote($var, $status='')
    {	
        if($status == 1)
            $tmp= str_replace("\'", "''", $var);
        else
            $tmp= str_replace("'", "''", $var);
        return $tmp;
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
            $hasil = "minus ". trim($this->kekata($x));
        } 
        else 
        {
            $hasil = trim($this->kekata($x));
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
    
	function generateQRFile($fileReport, $reqNomor, $approvalId="")
	{		
		
		/* GENERATE QRCODE */
		if($approvalId == "")
			$qrParaf   = config('app.base_publish')."qr/".strtolower($fileReport)."/".strtoupper($reqNomor);
		else
			$qrParaf   = config('app.base_publish')."qr/".strtolower($fileReport)."/".strtoupper($reqNomor)."/".($approvalId);
        
		$fileQR = public_path()."/uploads/qr/".strtoupper($fileReport."_".$reqNomor.$approvalId).".png";
		QRcode::png($qrParaf, $fileQR);

		if(file_exists($fileQR))
			return $fileQR;
		else
			return "";
	}
        

    
    function getArrayData($apiUrl, $apiName, $apiToken, $arrStatement=array(), $method="GET") {


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


        if($response == "[]")
        {
            $response = setQuote($response);
            $sql = " insert into log_api (url, tipe, response) values('".$apiUrl.$apiName.$paramGet."', 'warning', 'data kosong')";
            $this->exec($sql);
            return "gagal";
        }


        try {
            $obj = json_decode($response, true);
        } catch (\Throwable $th) {
            $response = setQuote($response);
            $sql = " insert into log_api (url, tipe, response) values('".$apiUrl.$apiName.$paramGet."', 'error', 'format json tidak dikenali')";
            $this->exec($sql);
            return "gagal";
        }

       

        if(empty($obj))
        {
            $response = setQuote($response);
            $sql = " insert into log_api (url, tipe, response) values('".$apiUrl.$apiName.$paramGet."', 'error', 'format json tidak dikenali')";
            $hasil = $this->exec($sql);
            return "gagal";
            
        }

        return $obj;

    }



    function postFormData($apiUrl,$apiName, $arrStatement) {


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

/***** INSTANTIATE THE GLOBAL OBJECT */
$prosesDokumen = new ProsesDokumen();
?>
