<?


use App\Models\PelamarLowongan;




$pelamar_lowongan = new PelamarLowongan();


$statement = " AND (COALESCE(NULLIF(A.STATUS_UNDANGAN, ''), '0') = '0' OR 
                    (
                    COALESCE(NULLIF(A.STATUS_UNDANGAN, ''), '0') = '1' AND
                    EXISTS(select 1 from lowongan_undangan x where  x.lowongan_id = a.lowongan_id and x.nik = '".$auth->KTP_NO."')
                    )
                ) ";
$arrStatement = array("A.PUBLISH" => "1");
$pelamar_lowongan->selectByParamsDaftarLowongan($auth->userPelamarId, $arrStatement, -1, -1, $statement);

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<!--<div class="col-lg-8">-->
<div class="col-sm-8 col-sm-pull-4">

    <div id="judul-halaman">Daftar Lowongan Aktif</div>
    <?
    if($auth->LOWONGAN_ID == "")
	{
	?>
    <div class="konten-10">
	    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Anda hanya dapat memilih salah satu dari lowongan di bawah ini, silahkan memilih lowongan yang ingin anda lamar.</div>
    </div>
   	<?
	}
	?>
    <div class="data-monitoring">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Kode</th>
                <th scope="col">Judul Lowongan</th>
                <th scope="col">Batas Akhir</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?
            while($pelamar_lowongan->nextRow())
            {
                $reqLowonganId = $pelamar_lowongan->getField("LOWONGAN_ID");
				if($pelamar_lowongan->getField("TANGGAL_KIRIM") == "")
					$url = "lowongan_detil";
				else
					$url = "daftar_lowongan_detil";
				
            ?>
                <tr>
                    <td><?=$pelamar_lowongan->getField("KODE")?></td>
                    <td><a href="app/index/<?=$url?>/<?=md5($reqLowonganId.'lowongan'.$MD5KEY)?>"><?=$pelamar_lowongan->getField("JABATAN")?></a></td>
                    <td><?=getFormattedDate($pelamar_lowongan->getField("TANGGAL_AKHIR"))?>, 23:59</td>
                    <td>
                    <?
                    if($pelamar_lowongan->getField("TANGGAL_KIRIM") == "")
					{
                        if($pelamar_lowongan->getField("STATUS_AKTIF") == "1")
                        {
					?>
                    <a href="app/index/lamaran/<?=md5($reqLowonganId.'lowongan'.$MD5KEY)?>"><i class="fa fa-paper-plane"></i> Kirim Lamaran</a>
                    <?
                        }
                        else
                            echo "Registrasi ditutup.";
					}
					else
						echo "Sudah mendaftar tanggal ".($pelamar_lowongan->getField("TANGGAL_KIRIM")).". <br>cetak kartu registrasi <a href='app/index/cetak_registrasi'>disini</a>.";
					?>
                    </td>
                </tr>    
            <?
            }
            ?>
            </tbody>
        </table>
    	
    </div>    
    <?php /*?>
	?>
    <div class="area-tahapan-seleksi after-login">
        <div class="judul">Tahapan Seleksi</div>
        <div class="tabel-tahapan">
            <table>
            <tbody>
            <?
			use App\Models\LowonganKategoriKriteria;
			$lowongan_kriteria = new LowonganKategoriKriteria();
			$lowongan_kriteria->selectByParams(array("A.LOWONGAN_ID" => $auth->LOWONGAN_ID), -1, -1, " AND A.PUBLISH_DATE IS NOT NULL ");
			$isAktif = 0;
			while($lowongan_kriteria->nextRow())
			{
				$kodeTahap = $lowongan_kriteria->getField("KODE_KRITERIA");
				$isAktif   = $lowongan_kriteria->getField("TAHAP_AKTIF");
				
				if($lastAktif == $isAktif && $isAktif == "aktif")
					$isAktif = "";
			?>
            	<tr class="<?=$isAktif?>">
                    <td class="tanggal"><?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_MULAI"))?> - <?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_SELESAI"))?></td>
                    <td class="tahapan">- <?=$lowongan_kriteria->getField("KETERANGAN")?></td>
                    <td class="keterangan">
                    	<?
                        if($kodeTahap == "REGISTRASI")
						{
							if($this->KIRIM_LAMARAN == "0")
								echo "Silahkan melengkapi dokumen administrasi terlebih dahulu, kemudian kirim lamaran.";
							else
							{
								if($this->VERIFIKASI == "0")
									echo "Proses verifikasi dokumen administrasi.";
								elseif($this->VERIFIKASI == "1")
									echo "Data anda lolos tahap verifikasi administrasi.";
								else
									echo "Anda gagal tahap verifikasi administrasi.";
								
							}
						}
						?>
                    </td>
                </tr>
            <?
				$lastAktif   = $lowongan_kriteria->getField("TAHAP_AKTIF");	
			}
			?>
			</tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div><?php */?>
    
</div>