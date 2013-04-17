<?
header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=zbm.xls"); 
header("Content-transfer-encoding: binary");

include '../connect.php';
include '../funkcijas.php';

$non_arch = $_GET['excel'];
?>

<BODY>

<?

$today = getdate();
$month = $today['mon'];
$year = $today['year'];
$month_s = ($month - 3) + $year * 12;

if ($non_arch == "n") {
$r = mysql_query("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) > ".$month_s." order by id ");
} else {
$r = mysql_query("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) <= ".$month_s." order by id ");
}
?>

<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pasūtītājs</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Vietas kods</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Kontrolmērnieks</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pasnr</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pas_nos</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pavaddokuments</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Automašīna</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Piekabe</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Šoferis</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Metode</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Mērnieks</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Started</font>
	</td>
</tr>
<? while ($m = mysql_fetch_array($r))
{ ?>
	<tr>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pasutitajs']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['viet_kods']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['kontrolmernieks']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pasnr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pas_nos']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pavaddok']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['autonr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['piekabnr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['sofer']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['metode']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['me']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['started']?>
		</td>
	</tr><?
} ?>
</table>
