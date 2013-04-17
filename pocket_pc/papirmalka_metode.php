<?
include '../connect.php';
include '../check_login.php';
include 'menu.php';
?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY>

<?
menu('papirmalka_metode',$valoda);

$kluda = '';

$r = mysql_query(" select * from papirmalka where id =".$_GET['darba_id']);
if ($m = mysql_fetch_array($r))
{
	if ($m['metode']) {$met = $m['metode'];} 
}
else
{
	$kluda = 'Kļūda! Šāds pakas numurs neeksistē!';
}
?>

<div align=center></div>

<form name=formf method=POST action="bld_papirmalka.php?darba_id=<?=$_GET['darba_id']?>">
	
<table cellspacing=0 cellpadding=0 border=0 align=center>
<tr>
	<td align="center">
	<font color="red"><b><?=$kluda?></b></font>
	</td>
</tr>
<tr>
	<td height="6">
	</td>
</tr>
<tr>
	<td align=right>
		Mērīšanas metode:&nbsp;
	<select name=metode_id>
		<option "selected" value=1>pēc LVS 82:2003</option>
		<option value=2>pēc VMR 1-06</option>
		<option value=3>pēc STB 1667</option>
	</select>
	</td>
</tr>
<tr>
	<td align=left><br />
		Atskaites valoda:&nbsp;&nbsp;&nbsp;&nbsp;
	<select name=valoda_id>
		<option "selected" value=1>Latviešu</option>
		<option value=2>Angļu</option>
	</select>
	</td>
</tr>
<tr>
  <td align=center><br /><input type=submit name=atskaite value="Atskaite" align=center></td>
</tr>
</table>
</form>

