<?
use App\Models\PelamarToefl;
$pelamar_toefl = new PelamarToefl();
$pelamar_toefl->selectByParams(array("PELAMAR_ID" => (int)$auth->userPelamarId));
while($pelamar_toefl->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_toefl->getField("NAMA")?></td>
		<td><?=$pelamar_toefl->getField("KETERANGAN")?></td>
		<td><?=dateToPageCheck($pelamar_toefl->getField("TANGGAL"))?></td>
		<td><?=$pelamar_toefl->getField("NILAI")?></td>
		<td>
			<a onClick="$('#divToefl').show(); $('#frameToefl').prop('src', 'app/loadEntri/main/data_toefl?reqId=<?=$pelamar_toefl->getField("PELAMAR_TOEFL_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
	        <a onClick="deleteIsian('tbodyToefl', 'data_toefl', '<?=$pelamar_toefl->getField("PELAMAR_TOEFL_ID")?>')"><i class="fa fa-trash"></i></a>
		</td>
	</tr>    
<?
}
?>    