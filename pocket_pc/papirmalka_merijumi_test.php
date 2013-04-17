<?
include '../connect.php';
include '../check_login.php';
include '../funkcijas.php';
include 'menu.php';

if ($_GET['darba_id'])
$darba_id = $_GET['darba_id'];

?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY>

<?
menu('papirmalkas_merijumi',$valoda);

//mysql_query("delete from papirmalka_merijumi where papirmalka_id = 10 and sx <> 4");
?>
<div align=center>
<input type=button onclick="location.href='papirmalka_merijumi_excel.php?darba_id=<?=$_GET['darba_id']?>';" value="Excel formātā"></div><br>
<?

$txtQuery = "SELECT * FROM papirmalka WHERE id = ".$darba_id;
$tQuery = mysql_query($txtQuery);

$r = mysql_query(" select * from papirmalka_merijumi where papirmalka_id = $darba_id order by id ");
?>

<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">S</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">K</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">B</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">Dl</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">L</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">D2</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">R</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">re</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">Kb</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">Anuled</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;&nbsp;&nbsp;
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
	?>
	<tr bgcolor="<?=$color?>">
		<td align=center>
			<?=$m['sx']?>
		</td>
		<td align=center>
			<?=$m['kx']?>
		</td>
		<td align=center>
			<?=$m['bx']?>
		</td>
		<td align=center>
			<?=$m['dl']?>
		</td>
		<td align=center>
			<?=$m['lx']?>
		</td>
		<td align=center>
			<?=$m['d2']?>
		</td>
		<td align=center>
			<?=$m['rx']?>
		</td>
		<td align=center>
			<?=$m['re']?>
		</td>
		<td align=center>
			<? if ($m['kb'] != 'NULL') echo $m['kb']; ?>
		</td>
		<td align=center>
			<?=$m['anuled']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="papirmalka_merijumi_labot.php?darba_id=<?=$_GET['darba_id']?>&merijuma_id=<?=$m['id']?>">&nbsp;Labot&nbsp;</a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="#" onclick="if (confirm('Dzēst mērījumu?')){self.location='papirmalka_merijumi_dzest.php?darba_id=<?=$_GET['darba_id']?>&merijuma_id=<?=$m['id']?>';return false;}else{return false;}">&nbsp;Dzēst&nbsp;</a>
		</td>
	</tr><?
} ?>
</table>
