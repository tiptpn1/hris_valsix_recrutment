<?
use App\Models\PelamarPelatihan;
$pelamar_pelatihan = new PelamarPelatihan();
$pelamar_pelatihan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
while($pelamar_pelatihan->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_pelatihan->getField("JENIS")?></td>
		<td><?=$pelamar_pelatihan->getField("WAKTU")?></td>
		<td><?=$pelamar_pelatihan->getField("TAHUN")?></td>
		<td><?=$pelamar_pelatihan->getField("PELATIH")?></td>
		<td>
		<a onClick="$('#divPelatihan').show(); $('#framePelatihan').prop('src', 'app/loadEntri/main/data_pelatihan?reqId=<?=$pelamar_pelatihan->getField("PELAMAR_PELATIHAN_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
        <a onClick="deleteIsian('tbodyPelatihan', 'data_pelatihan', '<?=$pelamar_pelatihan->getField("PELAMAR_PELATIHAN_ID")?>')"><i class="fa fa-trash"></i></a>
	</tr>     
<?
}
?>   