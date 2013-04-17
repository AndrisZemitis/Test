<?
include '../connect.php';
include '../check_login.php';

include '../funkcijas_edit.php';
include 'menu.php';
?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<style>
	#papirmalka tr td {text-align:center;}
</style>
</HEAD>
<BODY>

<?
if (isset($_POST['skatits_id']))
	{
	ieraksts_skatits($_POST['skatits_id']);
	unset($_POST['skatits_id']);
	}

menu('papirmalka',$valoda);

$non_arch = "n";
$today = getdate();
$month = $today['mon'];
$year = $today['year'];
$month_s = ($month - 4) + $year * 12;
//echo " SELECT papirmalka.id, nr, me, so, sg, pk, rn, IFNULL(height,ag) as ag, IFNULL(length,gr) as gr, IFNULL(width,pl) as pl, ti, IFNULL(defect_code,bk) as bk, IFNULL(defect_percent,bp) as bp, sk1, si1, sk2, si2, sk3, si3, ts, te, metode, doc_nr, skatits  FROM papirmalka LEFT OUTER JOIN e_bundle ON e_bundle.control_num = papirmalka.nr AND e_bundle.record_state = 'N' where MID( ts, 7, 4 ) *12 + MID( ts, 4, 2 ) > ".$month_s." order by papirmalka.id desc ";
$r = mysql_query(" SELECT papirmalka.id, nr, me, so, ps, sg, pk, rn, pz, sf, fs, IFNULL(height,ag) as ag, IFNULL(length,gr) as gr, IFNULL(width,pl) as pl, ti, IFNULL(defect_code,bk) as bk, IFNULL(defect_percent,bp) as bp, sk1, si1, sk2, si2, sk3, si3, ts, te, metode, doc_nr, skatits  FROM papirmalka LEFT OUTER JOIN e_bundle ON e_bundle.control_num = papirmalka.nr AND e_bundle.record_state = 'N' where MID( ts, 7, 4 ) *12 + MID( ts, 4, 2 ) > ".$month_s." order by papirmalka.id desc ");
?>
<div align=center><input type=button name=excel_formats onclick="location='papirmalka_excel.php?excel=<?=$non_arch?>'" value="Excel formātā"></div><br>

<table cellspacing=1 cellpadding=0 border=0 align=center id="papirmalka">
<tr bgcolor="CCFFCC">
	<td>
		<font size="2">Pakas nr</font>
	</td>
	<td>
		<font size="2">Mērnieks</font>
	</td>
	<td>
		<font size="2">Sortimenta kods</font>
	</td>
	<td>
		<font size="2">Suga</font>
	</td>
	<td>
		<font size="2">Paka uz masin</font>
	</td>
	<td>
		<font size="2">Rezer ves nr</font>
	</td>
	<td>
		<font size="2">Augstums cm</font>
	</td>
	<td>
		<font size="2">Garums cm</font>
	</td>
	<td>
		<font size="2">Platums cm</font>
	</td>
	<td>
		<font size="2">Tilpuma %</font>
	</td>
	<td>
		<font size="2">Brāķa kods</font>
	</td>
	<td>
		<font size="2">Brāķa %</font>
	</td>
	<td>
		<font size="2">1.Sugas kods</font>
	</td>
	<td>
		<font size="2">1.Īpatsv. %</font>
	</td>
	<td>
		<font size="2">2.Sugas kods</font>
	</td>
	<td>
		<font size="2">2.Īpatsv. %</font>
	</td>
	<td>
		<font size="2">3.Sugas kods</font>
	</td>
	<td>
		<font size="2">3.Īpatsv. %</font>
	</td>
	<td>
		<font size="2">ts</font>
	</td>
	<td>
		<font size="2">te</font>
	</td>
	<td>
		
	</td>
	<td>
		Atskaite
	</td>
	<td>
		Skatīts
	</td>
	<td>
		<font size="2">Piezīmes</font>
	</td>
	<td>
		<font size="2">Pavadzīme</font>
	</td>
	<td>
		<font size="2">Šoferis</font>
	</td>
	<td>
		<font size="2">Firma</font>
	</td>
</tr>

<? 
$color = '#E1E1E1';
while ($m = mysql_fetch_array($r))
{	
	if ($color == '#E1E1E1')
	$color = '#FFFFFF';
	else
	$color = '#E1E1E1';
	if ($m['skatits'] == 0)
		$color='#FFCCCC';
	?>
<tr bgcolor='<?=$color?>'>
	<td>
		<?=$m['nr']?>
	</td>
	<td>
		<?=$m['me']?>
	</td>
	<td>
		<?=$m['so']?>
	</td>
	<td>
		<?=$m['sg']?>
	</td>
	<td>
		<?=$m['pk']?>
	</td>
	<td>
		<?if ($m['rn'] != 'NULL' and $m['rn'] != 'NUL') echo $m['rn'];?>
	</td>
	<td>
		<?=$m['ag']?>
	</td>
	<td>
		<?=$m['gr']?>
	</td>
	<td>
		<?=$m['pl']?>
	</td>
	<td>
		<?=$m['ti']?>
	</td>
	<td>
		<?=$m['bk']?>
	</td>
	<td>
		<?=$m['bp']?>
	</td>
	<td>
		<?=$m['sk1']?>
	</td>
	<td>
		<?=$m['si1']?>
	</td>
	<td>
		<?=$m['sk2']?>
	</td>
	<td>
		<?=$m['si2']?>
	</td>
	<td>
		<?=$m['sk3']?>
	</td>
	<td>
		<?=$m['si3']?>
	</td>
	<td>
		<?=$m['ts']?>
	</td>
	<td>
		<?=$m['te']?>
	</td>
	<td>
		<a href="papirmalka_merijumi.php?darba_id=<?=$m['id']?>">Mērījumi</a>
	</td>
	<td>
		<a href="papirmalka_metode.php?darba_id=<?=$m['id']?>">Atskaite</a>
	</td>
	<td>
			<form name="form_sk" method="POST" id="form_sk">
			<input type="hidden" name="skatits_id" id="skatits_id">
			</form>
		<?
		if ($m['skatits'] == 0){?><a href="#" onclick="
		document.getElementById('skatits_id').value='<?=$m['id']?>';
		document.getElementById('form_sk').submit();">Apskatīts</a><?}?>
	</td>
	<td>
		<?=trim($m['ps'])?>
	</td>
	<td>
		<?=trim($m['pz'])?>
	</td>
	<td>
		<?=trim($m['sf'])?>
	</td>
	<td>
		<?=trim($m['fs'])?>
	</td>
</tr><?
} ?>
</table>

