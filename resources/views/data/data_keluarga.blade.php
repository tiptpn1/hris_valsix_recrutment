<?
use App\Models\PelamarKeluarga;
$pelamar_keluarga = new PelamarKeluarga();
$pelamar_keluarga->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
while($pelamar_keluarga->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_keluarga->getField("HUBUNGAN_KELUARGA_NAMA")?></td>
		<td><?=$pelamar_keluarga->getField("NAMA")?></td>
		<td><?=$pelamar_keluarga->getField("JENIS_KELAMIN")?></td>
		<td>
			<a onClick="$('#divKeluarga').show(); $('#frameKeluarga').prop('src', 'app/loadEntri/main/data_keluarga/?reqRowId=<?=$pelamar_keluarga->getField("PELAMAR_KELUARGA_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
            <a onClick="deleteIsian('tbodyKeluarga', 'data_keluarga', '<?=$pelamar_keluarga->getField("PELAMAR_KELUARGA_ID")?>')"><i class="fa fa-trash"></i></a>
		</td>
	</tr>    
<?
}
?>   