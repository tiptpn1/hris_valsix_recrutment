<?
use App\Models\PelamarPengalaman;
$pelamar_pengalaman = new PelamarPengalaman();
$pelamar_pengalaman->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
while($pelamar_pengalaman->nextRow())
{
?>
<tr>
	<td><?=$pelamar_pengalaman->getField("JABATAN")?></td>
	<td><?=$pelamar_pengalaman->getField("PERUSAHAAN")?></td>
	<td><?=dateToPageCheck($pelamar_pengalaman->getField("TANGGAL_MASUK"))?></td>
	<td><?=$pelamar_pengalaman->getField("TAHUN")?></td>
	<td><?=$pelamar_pengalaman->getField("DURASI")?></td>
	<td>
		<a onClick="$('#divPengalaman').show(); $('#framePengalaman').prop('src', 'app/loadEntri/main/data_pengalaman?reqId=<?=$pelamar_pengalaman->getField("PELAMAR_PENGALAMAN_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
        <a onClick="deleteIsian('tbodyPengalaman', 'data_pengalaman', '<?=$pelamar_pengalaman->getField("PELAMAR_PENGALAMAN_ID")?>')"><i class="fa fa-trash"></i></a>
	</td>
</tr>    
<?
}
?>   