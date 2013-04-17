<?
include '../connect.php';
include '../check_login.php';
include '../funkcijas.php';
include 'menu.php';
?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY >

<?
menu('zbm_arhivs',$valoda);

$non_arch = "a";
$today = getdate();
$month = $today['mon'];
$year = $today['year'];
$month_s = ($month - 3) + $year * 12;

$r = mysql_query("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) <= ".$month_s." order by id desc");
?>

<div align=center><input type=button name=excel_formats onclick="location='zbm_excel.php?excel=<?=$non_arch?>'" value="Excel formātā"></div><br>

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
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
</tr>
<?
$color = '#E1E1E1';
while ($m = mysql_fetch_array($r))
{ 	if ($color == '#E1E1E1')
	$color = '#FFFFFF';
	else
	$color = '#E1E1E1';
	if ($m['export_id'] < 1)
		$color='#FFCCCC';
 ?>
<tr bgcolor='<?=$color?>'>
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
		<td align=center>
			&nbsp;&nbsp;<a href="#"><!--Labot--></a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="zbm_iu.php?zbm_id=<?=$m['id']?>">Mērījumi</a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="movedata.php?zbm_id=<?=$m['id']?>">Kopēt</a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="movedata.php?zbm_id=<?=$m['id']?>&round=no">Kopēt neapaļojot diametru</a>
		</td>
	</tr><?
} ?>
</table>
