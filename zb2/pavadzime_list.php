<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
 include ('db.inc.php');
 include ("../check_login.php");
 if ($mlietotajs['g_report']!='Y') return;

 menu($_GET['h']);
 $fails = $_GET['fails'];
 $h = $_GET['h'];
 $report_id = $_GET['report_id'];
 $batch_query_pavadzime = getCorrectBatch($h,"table_pavadzime");

?>
<center>
<?
$rc = mysql_query("select count(*) as c from ".$batch_query_pavadzime." where batch_fails = $fails");
$mc = mysql_fetch_array($rc);
?> Ielasīto pavadzīmju skaits: <?=$mc[c]?><?

if ($mc[c])
{
	$r = mysql_query("select * from ".$batch_query_pavadzime." where batch_fails = $fails order by id");
	?>
	<table border=1 cellspacing=0 cellpadding=2>
	<tr  bgcolor=#7EBF7E>

		<th>ID</th>
		<th>Pavadzīmes num.</th>
		<th>Pas. kods</th>
		<th>Piegādāts</th>
		<th>Uzmērīts</th>
		<th>Iecirknis</th>
		<th>Cirsmas kods</th>
		<th>FSC Sertifikācija</th>
		<th>Pieg. kods</th>
		<th>Iecirknis pieg.</th>
		<th>Transports</th>
		<th>Šoferis</th>
		<th>Kravas ID</th>
		<th>Iespējas</th>
	</tr>
	<?
	while ($m=mysql_fetch_array($r))
	{
		?><tr><?
			?><td align=right><nobr><a href=balkis.php?pavadzime=<?=$m[id]?>&h=<?=$h?>&report_id=<?=$report_id?>><?=$m['id']?></a>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[pavadzime]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[piegad_grupa]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[kad_piegad]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[kad_uzmer]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[iecirknis]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[cirsmas_kods]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[fsc]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[piegad_kods]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[iecirknis_pieg]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[auto]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[soferis]?>&nbsp;</td><?
			?><td align=center ><nobr><?=$m[kravas_id]?>&nbsp;</td><?
			?><td align=center ><nobr><a href=pavadzime_edit.php?id=<?=$m[id]?>&h=<?=$h?>&report_id=<?=$report_id?>>Labot</a>&nbsp;</td><?
		?></tr><?
	}
	?></table><?
}
?>
</center>
</body>
</html>