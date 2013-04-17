<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

menu($_GET['h']);


// tabulas id
$tabula_id = $_POST['tabula_id'];
if (!$tabula_id) $tabula_id = 1;

?>
<center>
<h2>GOST tabulas</h2>
<form name=form1 method=POST>
<select name=tabula_id>
<?$rw = mysql_query("select * from gostu_tabulas");?>
<option value="0">-- izvēlieties --</option><?
while ($mw=mysql_fetch_array($rw))
{
	?><option value="<?=$mw['id']?>"
	<? if ($tabula_id==$mw['id']) echo ' selected ';?>
	><?=$mw['nosaukums']?></option><?
}
?></select>
<input type=submit value="Parādīt">
<br>
</form>
<?

$krasa = 0;
$r=mysql_query("select * from gostu_dati where tabula = $tabula_id order by g_min,d_min");?>

<table border="0" align="center">
<font size="10">
<tr bgcolor=CCFFCC>
		<td>ID</td>
		<td>Tabula</td>
		<td>Minimālais diametrs</td>
		<td>Maksimālais diametrs</td>
		<td>Minimālais garums</td>
		<td>Maksimālais garums</td>
		<td>Tilpums</td>
	</tr><?
	$color = "#FFFFFF";
	while ($m=mysql_fetch_array($r))
	{ 
	?>
	<tr bgcolor="<?=$color?>">
		<?
		
		if ($color=="#FFFFFF") 
			$color = "#EEEEEE";
		else 
			$color = "#FFFFFF";
		?>
		<td><?=$m['id']?></td>
		<? $rTabula=mysql_query("select * from gostu_tabulas where id = " . $m['tabula'] . " order by id "); ?>
		<td><?if ($mTabula = mysql_fetch_array($rTabula)) { echo $mTabula['nosaukums']; }?></td>
		<td><?=$m['d_min']?></td>
		<td><?=$m['d_max']?></td>
		<td><?=$m['g_min']?></td>
		<td><?=$m['g_max']?></td>
		<td><?=$m['tilpums']?></td>
	</tr><?
	
	}
	?>
</font>
</table>

</body>
</html>