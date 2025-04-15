<?
use App\Models\PelamarSim;
$pelamar_sim = new PelamarSim();
$pelamar_sim->selectByParams(array("PELAMAR_ID" => $auth->userPelamarId));
while($pelamar_sim->nextRow())
{
?>
	<tr>
		<td><?=$pelamar_sim->getField("KODE_SIM")?></td>
		<td><?=$pelamar_sim->getField("NO_SIM")?></td>
		<td><?=dateToPageCheck($pelamar_sim->getField("TANGGAL_KADALUARSA"))?></td>
		<td>
			<? 
			if($pelamar_sim->getField("LINK_FILE") == "") 
			{}
			else
			{
			?>
			<a href="uploads/sim/<?=$pelamar_sim->getField("LINK_FILE")?>" target="_blank"><i class="fa fa-download"></i> download</a>
			<?
			}
			?>
		</td>
		<td>
			<a onClick="$('#divSim').show(); $('#frameSim').prop('src', 'app/loadEntri/main/data_sim?reqId=<?=$pelamar_sim->getField("PELAMAR_SIM_ID")?>');"><i class="fa fa-pencil"></i></a>&nbsp;
	        <a onClick="deleteIsian('tbodySim', 'data_sim', '<?=$pelamar_sim->getField("PELAMAR_SIM_ID")?>')"><i class="fa fa-trash"></i></a>
		</td>
	</tr>    
<?
}
?> 