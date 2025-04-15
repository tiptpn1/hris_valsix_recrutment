<?



$this->load->library("PageNumber"); $pageNumber = new PageNumber(); 
use App\Models\Lowongan;
use App\Models\LowonganKategoriKriteria;

$lowongan= new Lowongan();


/* DEFAULT VALUES */
$pageView = "app/index/home";
$showRecord = 15;

$allRecord = $lowongan->getCountByParams(array("A.PERIODE_ID" => $auth->PERIODE_ID_AKTIF, "A.STATUS_UNDANGAN" => "0", "A.PUBLISH" => "1")); 
$pageNumber->initialize($allRecord, $showRecord, $reqPage, $pageView);
$lowongan->selectByParamsMonitoringWeb(array("A.PERIODE_ID" => $auth->PERIODE_ID_AKTIF, "A.STATUS_UNDANGAN" => "0", "A.PUBLISH" => "1"), $pageNumber->limit, $pageNumber->from);



?>

<style>
.lowongan-area{
	*min-height:600px;
}
.navigasi-area{
	border:0px solid red; margin-top:-50px; 
	margin-bottom:-30px;
}
@media screen and (max-width:767px) {
	.navigasi-area{
		border:0px solid red; 
		margin-top:10px; 
		margin-bottom:-30px;
	}	
}
</style>    
<script>
	function showHide(id) {
	  var dots = document.getElementById("dots"+id);
	  var moreText = document.getElementById("more"+id);
	  var btnText = document.getElementById("myBtn"+id);
	
	  if (dots.style.display === "none") {
		dots.style.display = "inline-block";
		btnText.innerHTML = "Perlihatkan lebih banyak &#x25BC;";
		moreText.style.display = "none";
	  } else {
		dots.style.display = "none";
		btnText.innerHTML = "Perlihatkan lebih sedikit &#x25B2;";
		moreText.style.display = "inline-block";
	  }
	} 
</script>
<!--<div class="col-lg-8">-->
<!--<div class="col-lg-8 col-lg-pull-4">-->
<!--col-sm-pull-4-->

<div class="col-sm-8 col-sm-pull-4">
	
    <div class="lowongan-area">
    	<div class="judul">Lowongan <?=$auth->PERIODE_AKTIF?></div>
        <?
        while($lowongan->nextRow())
		{
			$reqLowonganId = $lowongan->getField("LOWONGAN_ID");
		?>
            <div class="list-baru">
                <div class="informasi">
                    <div class="judul"><a href="app/index/home_detil?reqId=<?=md5($reqLowonganId)?>"><?=$lowongan->getField("JABATAN")?> (<?=$lowongan->getField("KODE")?>)</a></div>
                    <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : <?=$lowongan->getField("CABANG")?> </div>
                    <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> <?=getFormattedDateExt($lowongan->getField("TANGGAL_AWAL"))?> - <?=getFormattedDateExt($lowongan->getField("TANGGAL_AKHIR"))?></div>
                    <div class="kualifikasi">
                    <?=str_replace("($$)", ", ", $lowongan->getField("PERSYARATAN"))?>
                    </div>
                    <div class="waktu"><?=getFormattedDate($lowongan->getField("TANGGAL"))?> • <button onclick="showHide('<?=$reqLowonganId?>')" class="myBtn" id="myBtn<?=$reqLowonganId?>">Perlihatkan lebih banyak &#x25BC;</button> <span class="dots" id="dots<?=$reqLowonganId?>">...</span></div>
                </div>
                <div class="ikon">
                    <img src="images/logo-ttl.png">
                </div>
                <div class="more" id="more<?=$reqLowonganId?>">
                    <div class="area-tahapan-seleksi">
                        <div class="judul">Tahapan Seleksi</div>
                        <div class="tabel-tahapan">
                            <table>
                            <?
                            $lowongan_kriteria = new LowonganKategoriKriteria();
							$lowongan_kriteria->selectByParams(array("A.LOWONGAN_ID" => $reqLowonganId), -1, -1, " AND A.PUBLISH_DATE IS NOT NULL ");
							while($lowongan_kriteria->nextRow())
							{
							?>
                                <tr>
                                    <td class="tanggal"><?=getFormattedDateExt($lowongan_kriteria->getField("TANGGAL_MULAI"))?></td>
                                    <td class="tahapan">- <?=$lowongan_kriteria->getField("KETERANGAN")?></td>
                                    <td class="keterangan">
                                    <?
                                    if($lowongan_kriteria->getField("PUBLISH_LOLOS_DATE") == "")
									{}
									else
									{
									?>
                                    	<a href="app/index/tahapan_seleksi_detil">Lihat pelamar yang lolos tes</a>
                                    <?
									}
									?>
                                    </td>
                                </tr>
                            <?
							}
							?>
                            </table>
                        </div>
                        <div class="area-apply">
                            <button onclick="location.href='app/index/lowongan_detil?reqId=<?=md5($reqLowonganId)?>';">Detil &rsaquo;</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?
		}
		?>
        
        <div class="list-baru">
            <div class="informasi">
                <div class="judul"><a href="app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b">Cleaning Service (CSV-00)</a></div>
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : PTPN 1 </div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> 01 Feb 2020 - 29 Feb 2020</div>
                <div class="kualifikasi">
                Wanita, Min D3, Maksimal S1, Usia Maksimal 40, Belum Menikah, Memilki SIM A, Minimal Skor TOEFL 250, Apakah anda buta warna?                    </div>
                <div class="waktu">01 Maret 2020 • <button onclick="showHide()" class="myBtn" id="myBtn1">Perlihatkan lebih banyak ▼</button> <span class="dots" id="dots1" style="display: inline-block;">...</span></div>
            </div>
            <div class="ikon">
                <img src="images/logo-ttl.png">
            </div>
            <div class="more" id="more1" style="display: none;">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                        <tbody><tr>
                                <td class="tanggal">02 Mar 2020</td>
                                <td class="tahapan">- Tahap Registrasi Peserta</td>
                                <td class="keterangan">&nbsp;</td>
                            </tr>
						</tbody></table>
                    </div>
                    <div class="area-apply">
                        <button onclick="location.href='app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b';">Detil ›</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="list-baru">
            <div class="informasi">
                <div class="judul"><a href="app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b">Driver (DRV-29)</a></div>
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : PTPN 1 </div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> 01 Feb 2020 - 29 Feb 2020</div>
                <div class="kualifikasi">
                Wanita, Min D3, Maksimal S1, Usia Maksimal 40, Belum Menikah, Memilki SIM A, Minimal Skor TOEFL 250, Apakah anda buta warna?                    </div>
                <div class="waktu">01 Maret 2020 • <button onclick="showHide()" class="myBtn" id="myBtn1">Perlihatkan lebih banyak ▼</button> <span class="dots" id="dots1" style="display: inline-block;">...</span></div>
            </div>
            <div class="ikon">
                <img src="images/logo-ttl.png">
            </div>
            <div class="more" id="more1" style="display: none;">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                        <tbody><tr>
                                <td class="tanggal">02 Mar 2020</td>
                                <td class="tahapan">- Tahap Registrasi Peserta</td>
                                <td class="keterangan">&nbsp;</td>
                            </tr>
						</tbody></table>
                    </div>
                    <div class="area-apply">
                        <button onclick="location.href='app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b';">Detil ›</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="list-baru">
            <div class="informasi">
                <div class="judul"><a href="app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b">Foreman Lapangan (FRL-44)</a></div>
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : PTPN 1 </div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> 01 Feb 2020 - 29 Feb 2020</div>
                <div class="kualifikasi">
                Wanita, Min D3, Maksimal S1, Usia Maksimal 40, Belum Menikah, Memilki SIM A, Minimal Skor TOEFL 250, Apakah anda buta warna?                    </div>
                <div class="waktu">01 Maret 2020 • <button onclick="showHide()" class="myBtn" id="myBtn1">Perlihatkan lebih banyak ▼</button> <span class="dots" id="dots1" style="display: inline-block;">...</span></div>
            </div>
            <div class="ikon">
                <img src="images/logo-ttl.png">
            </div>
            <div class="more" id="more1" style="display: none;">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                        <tbody><tr>
                                <td class="tanggal">02 Mar 2020</td>
                                <td class="tahapan">- Tahap Registrasi Peserta</td>
                                <td class="keterangan">&nbsp;</td>
                            </tr>
						</tbody></table>
                    </div>
                    <div class="area-apply">
                        <button onclick="location.href='app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b';">Detil ›</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="list-baru">
            <div class="informasi">
                <div class="judul"><a href="app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b">Helper (HLP-30)</a></div>
                <div class="lokasi"><i class="fa fa-map-marker"></i> Lokasi : PTPN 1 </div>
                <div class="tgl-awal-akhir"><i class="fa fa-calendar"></i> 01 Feb 2020 - 29 Feb 2020</div>
                <div class="kualifikasi">
                Wanita, Min D3, Maksimal S1, Usia Maksimal 40, Belum Menikah, Memilki SIM A, Minimal Skor TOEFL 250, Apakah anda buta warna?                    </div>
                <div class="waktu">01 Maret 2020 • <button onclick="showHide()" class="myBtn" id="myBtn1">Perlihatkan lebih banyak ▼</button> <span class="dots" id="dots1" style="display: inline-block;">...</span></div>
            </div>
            <div class="ikon">
                <img src="images/logo-ttl.png">
            </div>
            <div class="more" id="more1" style="display: none;">
                <div class="area-tahapan-seleksi">
                    <div class="judul">Tahapan Seleksi</div>
                    <div class="tabel-tahapan">
                        <table>
                        <tbody><tr>
                                <td class="tanggal">02 Mar 2020</td>
                                <td class="tahapan">- Tahap Registrasi Peserta</td>
                                <td class="keterangan">&nbsp;</td>
                            </tr>
						</tbody></table>
                    </div>
                    <div class="area-apply">
                        <button onclick="location.href='app/index/home_detil?reqId=c4ca4238a0b923820dcc509a6f75849b';">Detil ›</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <!-- PAGING -->
        <div style="clear:both; padding-bottom:20px">
            <div class="pagesLL">
              <div class="pagesLL-margin">
                <?=$pageNumber->drawPageFlex()?>
              </div>
            </div>
        </div>
    </div>
</div>

