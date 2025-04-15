<?
use App\Models\PelamarSertifikat;
$pelamar_sertifikat = new PelamarSertifikat();
$pelamar_sertifikat->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
while($pelamar_sertifikat->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_sertifikat->getField("NAMA")?></td>
		<td><?=dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_TERBIT"))?></td>
		<td><?=dateToPageCheck($pelamar_sertifikat->getField("TANGGAL_KADALUARSA"))?></td>
		<td><?=$pelamar_sertifikat->getField("KETERANGAN")?></td>
		<td>
			<a onClick="$('#divSertifikat').show(); $('#frameSertifikat').prop('src', 'app/loadEntri/main/data_sertifikat?reqId=<?=$pelamar_sertifikat->getField("PELAMAR_SERTIFIKAT_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
            <a onClick="deleteIsian('tbodySertifikat', 'data_sertifikat', '<?=$pelamar_sertifikat->getField("PELAMAR_SERTIFIKAT_ID")?>')"><i class="fa fa-trash"></i></a>
		</td>
	</tr>    
<?
}
?>    