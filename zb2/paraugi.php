<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

if ($_GET[action]=='deactivate')
{
	mysql_query("UPDATE paraugs SET aktivs = 'N' WHERE id = $_GET[id]");
}

if ($_GET[action]=='activate')
{
	mysql_query("UPDATE paraugs SET aktivs = 'Y' WHERE id = $_GET[id]");
}

if ($_GET[action]=='edit')
{
	mysql_query("UPDATE paraugs SET firma = '$_GET[value]' WHERE id = $_GET[id]");
}

?>
<html>
<head>
 <title>Paraugs</title>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<form name=forma method=post action=paraugs.php?tips=<?=$_GET[tips]?>&field=<?=$_GET[field]?>>
<? 

$query = "select * from paraugs where 1=1 ";
if ($_GET[tips]) 
	$query = $query . " and tips = '".$_GET[tips]."'";

$query = $query . " order by firma, nosaukums ";
?>
<center>
<table>
<th>Nosaukums</th><th>Parametri</th><th>Piesaistītā firma</th><th>Darbības</th></tr><tr>
<?

$r = mysql_query($query);
while ($m = mysql_fetch_array($r))
{
	echo "<tr>";
	echo "<td>" . $m[nosaukums] . "</td>" ;
	echo "<td>" . $m[vertiba] . "</td>" ;
	?>
	<td><input type='text' value='<?=$m[firma]?>' onchange="window.location = 'paraugi.php?id=<?=$m[id]?>&value=' + this.value + '&action=edit'; return false;"></td>
	<?
	if ($m[aktivs] == 'Y') {
	?>
	<td nowrap = "nowrap"><a href="#" onclick="window.location = 'paraugi.php?id=<?=$m[id]?>&action=deactivate';return false;">Aktīvs</a></td>
	<? } else { ?>
	<td nowrap = "nowrap"><a href="#" onclick="window.location = 'paraugi.php?id=<?=$m[id]?>&action=activate';return false;">Neaktīvs</a></td>
	<? }
	echo "</tr>";
}

?>
</table>

<input type=hidden name="selected">
<input type=hidden name="selected_value">
<input type=hidden name="action">
<br>

</form>
</body>
</html>