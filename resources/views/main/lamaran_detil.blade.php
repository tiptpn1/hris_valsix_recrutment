<?


use App\Models\Lowongan;
use App\Models\PelamarLowongan;
use App\Models\Laporan;
use App\Models\LowonganKategoriKriteria;



$reqId= request()->reqId;
//$reqId= 160119666;

$lowongan = new Lowongan();
$laporan= new Laporan();
$lowongan_kategori_kriteria = new LowonganKategoriKriteria();
$jumlahKategori = $lowongan_kategori_kriteria->getCountByParams(array("LOWONGAN_ID" => $reqId));
$lowongan_kategori_kriteria->selectByParams(array("LOWONGAN_ID" => $reqId));

$i = 0;
while($lowongan_kategori_kriteria->nextRow())
{
    $arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"] = $lowongan_kategori_kriteria->getField("LOWONGAN_KATEGORI_KRITERIA_ID");
    $arrKategori[$i]["NAMA"] = $lowongan_kategori_kriteria->getField("NAMA");
    $i++;   
}
$lowongan->selectByParams(array("A.LOWONGAN_ID" => $reqId));
$lowongan->firstRow();

$laporan->selectByParamsRekapHasilSeleksi($arrKategori, array("A.LOWONGAN_ID" => $reqId, "A.PELAMAR_ID" => $auth->userPelamarId),-1,-1, "", "");

?>
<script type="text/javascript" src="libraries/easyui/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/easyui/themes/default/easyui.css">
<script type="text/javascript" src="libraries/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="libraries/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="libraries/easyui/globalfunction.js"></script>

<div class="col-lg-8">
    <div id="judul-halaman">Histori Tahapan Test (<?=$lowongan->getField("KODE")?> - <?=$lowongan->getField("JABATAN")?>)</div>
    <div class="konten-10">    
    <?
    if($reqKonfirmasi == "")
	{}
	else
	{
	?>
	    <div class="alert alert-info"><i class="fa fa-info-circle fa-lg"></i> Terima Kasih, anda telah berhasil mendaftar <?=$judul_lowongan?> (<?=$kode_lowongan?>).</div>    
    <?
	}
	?>
    </div>    
   	<div class="data-monitoring">
        <table class="table table-hover">
            <?php /*?><thead>
                <tr>
                <th rowspan="3" width="43">No</th>
                <th rowspan="3" width="101">No Registrasi</th>
                <th rowspan="3" width="171">Nama Peserta</th>
                <th rowspan="3" width="130">Jenis Kelamin</th>
                <th rowspan="3" width="130">Tempat Lahir</th>
                <th rowspan="3" width="130">Tanggal Lahir</th>
                <th rowspan="3" width="130">Riwayat Pendidikan</th>
                <th rowspan="3" width="130">Sertifikat SIO/GP/K3</th>
                <th colspan="<?=($jumlahKategori*3)?>" width="1605" align="center">Tahapan Seleksi</th>
                <th rowspan="3" width="120">Keterangan</th>
                </tr>
                <tr>
                <?
                for($i=0;$i<count($arrKategori);$i++) //[$i]["NAMA"]
                {
                ?>
                    <th colspan="3" align="center"><?=$arrKategori[$i]["NAMA"]?></th>
                <?
                }
                ?>
                </tr>
                <tr>
                <?
                for($i=1;$i<=$jumlahKategori;$i++)
                {
                ?>
                <th>Rekomendasi</th>
                <th>Nilai</th>
                <th>Catatan</th>
                <?
                }
                ?>
                </tr>
            </thead><?php */?>
            <tbody>
              <?
              $no = 1;
              while ($laporan->nextRow()) 
              {
              ?>
                  <tr>
         	        <td>No Registrasi</td>
                    <td ><?=$laporan->getField("NRP")?></td>
                  </tr>
                  <tr>
         	        <td>Nama</td>
                    <td ><?=$laporan->getField("NAMA")?></td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td><?=$laporan->getField("JENIS_KELAMIN")?></td>
                  </tr>
                  <tr>
                    <td>Tempat Lahir</td>
                    <td><?=$laporan->getField("TEMPAT_LAHIR")?></td>
                  </tr>
                  <tr>
                    <td>Tanggal Lahir</td>
                    <td><?=getFormattedDate($laporan->getField("TANGGAL_LAHIR"))?></td>
                  </tr>
                  <tr>
                    <td>Riwayat Pendidikan </td>
                    <td><?=$laporan->getField("PENDIDIKAN_TERAKHIR")?></td>
                  </tr>
                  <tr>
                    <td>Sertifikat SIO/GP/K3</td>
                    <td><?=$laporan->getField("AMBIL_PELAMAR_SERTIFIKAT_NEW_FORMAT")?></td>
                  </tr>
<?php /*?>                    <td><?=$laporan->getField("JENIS_KELAMIN")?></td>
                    <td><?=$laporan->getField("TEMPAT_LAHIR")?></td>
                    <td><?=getFormattedDate($laporan->getField("TANGGAL_LAHIR"))?></td>
                    <td><?=$laporan->getField("PENDIDIKAN_TERAKHIR")?></td>
                    <td><?=$laporan->getField("AMBIL_PELAMAR_SERTIFIKAT_NEW_FORMAT")?></td><?php */?>
                    <?
                    for($i=0;$i<count($arrKategori);$i++) //[$i]["NAMA"]
                    {
                        $idKategori = $arrKategori[$i]["LOWONGAN_KATEGORI_KRITERIA_ID"];
                    ?>     
                    	<tr>
                        <td><?=$arrKategori[$i]["NAMA"]?></td>
						<td>                        
                        	<table style="width:100%">
                            <tr>
                            <th style="width:30%">Rekomendasi</th>
                            <th style="width:20%">Nilai</th>
                            <th>Catatan</th>
                            </tr>
                            <tr>
                            <td><?=$laporan->getField("REKOMENDASI_".$idKategori)?></td>
                            <td><?=$laporan->getField("NILAI_".$idKategori)?></td>
                            <td><?=$laporan->getField("CATATAN_".$idKategori)?></td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                    <?
                    }
                    ?>   
                  <tr>
         	        <td>Keterangan</td>
                    <td ><?=$laporan->getField("KETERANGAN")?></td>
                  </tr>      
              <?
                $no++;
               }
              ?>
            </tbody>
        </table>
        <br>
        <input type="submit" value="Kembali" onClick="document.location.href='app/index/histori_lamaran'">
    </div>  
</div>