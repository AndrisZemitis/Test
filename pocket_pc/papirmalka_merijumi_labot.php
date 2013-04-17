<? 
include '../connect.php';
include '../check_login.php';
include '../funkcijas.php';
include 'menu.php';

if ($_GET['darba_id'] and $_GET['merijuma_id'])
{
	$darba_id = $_GET['darba_id'];
	$merijuma_id = $_GET['merijuma_id'];
	if ($_POST['ir'] == '1')
	{
		echo "<font color='red'>Pašlaik saglabāšana nestrādā!</font>";
		//echo " \ ".$_POST['sx']." / \ ".$_POST['kx']." / \ ".$_POST['bx']." / \ ".$_POST['d1']." / \ ".$_POST['lx']." / \ ".$_POST['d2']." / \ ".$_POST['rx']." / \ ".$_POST['re']." / \ ".$_POST['kb']." / ";

		$sx = $_POST['sx'];
		$kx = $_POST['kx'];
		$bx = $_POST['bx'];
		$d1 = $_POST['d1'];
		$lx = $_POST['lx'];
		$d2 = $_POST['d2'];
		$rx = $_POST['rx'];
		$re = $_POST['re'];
		$kb = $_POST['kb'];

		if ($sx == '') $sx = 'NULL';
		if ($kx == '') $kx = 'NULL';
		if ($bx == '') $bx = 'NULL';
		if ($d1 == '') $d1 = 'NULL';
		if ($lx == '') $lx = 'NULL';
		if ($d2 == '') $d2 = 'NULL';
		if ($rx == '') $rx = 'NULL';
		if ($re == '') $re = 'NULL';
		if ($kb == '') $kb = 'NULL';

		mysql_query(" update papirmalka_merijumi set sx = '".$sx."', kx = '".$kx."', bx = '".$bx."', dl = '".$d1."', lx = '".$lx."', d2 = '".$d2."', rx = '".$rx."', re = '".$re."', kb = '".$kb."' where papirmalka_id = ".$darba_id." and id = ".$merijuma_id);
		//echo " update papirmalka_merijumi set sx = '".$sx."', kx = '".$kx."', bx = '".$bx."', dl = '".$d1."', lx = '".$lx."', d2 = '".$d2."', rx = '".$rx."', re = '".$re."', kb = '".$kb."' where papirmalka_id = ".$darba_id." and id = ".$merijuma_id;
		//return;
		?>
		<script language="javascript">
			window.location='papirmalka_merijumi.php?darba_id=<?=$darba_id?>';
		</script>
		<?
	}

}
else
{
	echo '<div align="center"><font color="red">K&#316;&#363;da! Nav sa&#326;emti visi dati!<br> M&#275;&#291;iniet v&#275;lreiz!</font></div>';
	return;
}
$rdat = mysql_query(" select * from papirmalka_merijumi where papirmalka_id = ".$darba_id." and id = ".$merijuma_id);
if ($mdat = mysql_fetch_array($rdat))
{
	$sx = $mdat['sx'];
	$kx = $mdat['kx'];
	$bx = $mdat['bx'];
	$d1 = $mdat['dl'];
	$lx = $mdat['lx'];
	$d2 = $mdat['d2'];
	$rx = $mdat['rx'];
	$re = $mdat['re'];
	$kb = $mdat['kb'];
	if ($kb == 'NULL') $kb = '';
}
else
{
	echo '<div align="center"><font color="red">K&#316;&#363;da! Nav datu!<br> M&#275;&#291;iniet v&#275;lreiz!</font></div>';
	return;
}
?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY>

<?
menu('papirmalkas_merijumi',$valoda);
?>
<form name="form1" method="POST">
<table cellspacing="0" cellpadding="0" border="0" align="center">
<tr bgcolor="CCFFCC">
	<td colspan="2" align="center"><b>Mērījuma labošana</b></td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr>
	<td width="30">
		sx:&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name="sx" value="<?=$sx?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr bgcolor="#E1E1E1">
	<td>
		kx:&nbsp;&nbsp;
	</td>
	<td>
		<input style="background:#E1E1E1;" type="text" name="kx" value="<?=$kx?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr>
	<td>
		bx:&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name="bx" value="<?=$bx?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr bgcolor="#E1E1E1">
	<td>
		d1:&nbsp;&nbsp;
	</td>
	<td>
		<input style="background:#E1E1E1;" type="text" name="d1" value="<?=$d1?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr>
	<td>
		lx:&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name="lx" value="<?=$lx?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr bgcolor="#E1E1E1">
	<td>
		d2:&nbsp;&nbsp;
	</td>
	<td>
		<input style="background:#E1E1E1;" type="text" name="d2" value="<?=$d2?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr>
	<td>
		rx:&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name="rx" value="<?=$rx?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr bgcolor="#E1E1E1">
	<td>
		re:&nbsp;&nbsp;
	</td>
	<td>
		<input style="background:#E1E1E1;" type="text" name="re" value="<?=$re?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="3">
	</td>
</tr>
<tr>
	<td>
		kb:&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name="kb" value="<?=$kb?>">
	</td>
</tr>
<tr>
	<td colspan="2" height="12">
	</td>
</tr>
<tr align="right">
	<td colspan="2" align="right">
		<input type="button" value="Saglab&#257;t" onclick="form1.ir.value='1';form1.submit();">&nbsp;&nbsp;<input type="button" value="Atcelt" onclick="self.location='papirmalka_merijumi.php?darba_id=<?=$darba_id?>'">
	</td>
</tr>
</table>
<input type="hidden" name="ir" value="0">
</form>