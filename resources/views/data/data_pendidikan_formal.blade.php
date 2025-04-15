<?
use App\Models\PelamarPendidikan;
$pelamar_pendidikan = new PelamarPendidikan();
$pelamar_pendidikan->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
$adaData = "";
while($pelamar_pendidikan->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_pendidikan->getField("PENDIDIKAN_NAMA")?></td>
		<td><?=$pelamar_pendidikan->getField("NAMA")?></td>
		<td><?=$pelamar_pendidikan->getField("JURUSAN")?></td>
		<td><?=$pelamar_pendidikan->getField("IPK")?></td>
		<td>
			<a onClick="$('#divPendidikan').show(); $('#framePendidikan').prop('src', 'app/loadEntri/main/data_pendidikan_formal?reqId=<?=$pelamar_pendidikan->getField("PELAMAR_PENDIDIKAN_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
			<a onClick="deleteIsian('tbodyPendidikan', 'data_pendidikan_formal', '<?=$pelamar_pendidikan->getField("PELAMAR_PENDIDIKAN_ID")?>')"><i class="fa fa-trash"></i></a>
		</td>
	</tr>    
<?
	$adaData = "1";
}
if($adaData == "")
{
?>
	<tr>
		<td colspan="5" style="text-align:center">Data pendidikan belum dientri.
        <input type="text" required style="position:absolute; z-index:-1" value="<?=$adaData?>">
        </td>
	</tr>
<?
}
?> 