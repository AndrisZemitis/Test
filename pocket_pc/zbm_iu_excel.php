<?
header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=zbm.xls"); 
header("Content-transfer-encoding: binary");

include '../connect.php';
include '../funkcijas.php';
include 'menu.php';

$zbm_id = $_GET['zbm_id'];

?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY>

<?
$r = mysql_query(" select * from fails_zbm_ui where fails_zbm_id = $zbm_id order by id ");
?>
<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;<font size="2">Suga</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Tievgaļa caurmērs mm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Vidus caurmērs mm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Resgaļa caurmeers mm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Garums cm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Redukc. pa garumu dm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Redukc. pa caurmeru cm</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Šķira</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Iemesls</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Piezīmes</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">KB</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Sākts</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Beigts</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Anuled</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
</tr>
<? while ($m = mysql_fetch_array($r))
{ ?>
	<tr>
		<td x:num>
			<?=$m['sg']?>
		</td>
		<td x:num>
			<?=$m['tc']?>
		</td>
		<td x:num>
			<?=$m['vc']?>
		</td>
		<td x:num>
			<?=$m['rcc']?>
		</td>
		<td x:num>
			<?=$m['gr']?>
		</td>
		<td x:num>
			<?=$m['rg']?>
		</td>
		<td x:num>
			<?=$m['rc']?>
		</td>
		<td x:num>
			<?=$m['sk']?>
		</td>
		<td x:num>
			<?=$m['im']?>
		</td>
		<td x:num>
			<?=$m['pi']?>
		</td>
		<td x:num>
			<?=$m['kb']?>
		</td>
		<td x:num>
			<?=$m['ts']?>
		</td>
		<td x:num>
			<?=$m['te']?>
		</td>
		<td x:num>
			<?=$m['anuled']?>
		</td>
	</tr><?
} ?>
</table>
