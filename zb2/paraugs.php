<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

if ($_GET[action]=='del')
{
	mysql_query("delete from paraugs where id = ".$_GET[id]);
}

if ($_POST[action]=='insert' && $_GET[tips])
{
	mysql_query("insert into paraugs (tips,vertiba,nosaukums) values ('".$_GET[tips]."','".$_POST[jauns]."','".$_POST[nosaukums]."')");
}
?>
<html>
<head>
 <title>Paraugs</title>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<form name=forma method=post action=paraugs.php?tips=<?=$_GET[tips]?>&field=<?=$_GET[field]?>>
<strong>Firma:</strong> <select name="firma" onchange="window.location = 'paraugs.php?tips=<?=$_GET[tips]?>&field=<?=$_GET[field]?>&firma=' + this.value;">
	<!--<option value="">[Visas]</option>-->
	<?
	$query = "select DISTINCT firma from paraugs ORDER BY firma";
	$r = mysql_query($query);
	?><option value="">[Visas]</option><?
	while ($m = mysql_fetch_array($r)) {
		?>
			<option value="<?=$m['firma']?>" <?if ($_GET['firma'] == $m['firma']) {echo 'selected';}?>>
				<? if ($m['firma'] != '') {echo $m['firma'];} else {?>[Visas]<?}?>
			</option>
		<?
	}
	?>
</select>
<? 

$query = "select * from paraugs where aktivs='Y' ";
if ($_GET[tips]) 
	$query = $query . " and tips = '".$_GET[tips]."'";

if ($_GET[firma]) {
	$query = $query . " AND firma = '".$_GET[firma]."'";
}

$query = $query . " order by vertiba ";

?>
<center>
<div style="border-width: thin; border: solid thin; overflow: auto; width: 800; height: 400;">
<table>
<?

$r = mysql_query($query);
while ($m = mysql_fetch_array($r))
{
	echo "<tr><td><input type=radio name=rad onclick='forma.selected.value=".$m[id].";forma.selected_value.value=\"".$m[vertiba]."\"'></td>";
	echo "<td>" . $m[nosaukums] . "</td>" ;
	echo "<td>" . $m[vertiba] . "</td>" ;
	echo "</tr>";
}

?>
</table>
</div>
<input type=hidden name=selected>
<input type=hidden name=selected_value>
<input type=hidden name=action>
<br>
<table>
	<tr>
		<td>
			Nosaukums
		</td>
		<td>
			<input type=text size=40 name=nosaukums> 
		</td>
	</tr>
	<tr>
		<td>
			Vērtība
		</td>
		<td>
			<input type=text size=40 name=jauns> 
		</td>
	</tr>
</table>
<br>
<a href=Pievienot onclick="
	forma.action.value='insert';forma.submit();return false;">[Pievienot]</a>
<br><br>
[<a href=Izvēlēties
	onclick="
		opener.<?=$_GET[field]?>.value=forma.selected_value.value;
		window.close();
		return false;
	"
>Izvēlēties</a>]
[<a href=Dzēst 
	onclick="
		if (!confirm('Dzēst?')) return false;
		window.location = 'paraugs.php?tips=<?=$_GET[tips]?>&field=<?=$_GET[field]?>&action=del&id='+forma.selected.value;
		return false;
	"
>Dzēst</a>]




</form>
</body>
</html>