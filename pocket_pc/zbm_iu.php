<?
include '../connect.php';
include '../check_login.php';
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
menu('zbm_iu',$valoda);

$r = mysql_query(" select * from fails_zbm_ui where fails_zbm_id = $zbm_id order by id ");
?>
<div align=center><input type=button name=excel_formats onclick="location='zbm_iu_excel.php?zbm_id=<?=$zbm_id?>'" value="Excel formātā"></div><br>

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
		&nbsp;&nbsp;<font size="2">Resgaļa caurmērs mm</font>
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
</tr>
<? while ($m = mysql_fetch_array($r))
{ ?>
	<tr>
		<td align=center>
			&nbsp;&nbsp;<?=$m['sg']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['tc']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['vc']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['rcc']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['gr']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['rg']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['rc']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['sk']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['im']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['pi']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['kb']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['ts']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['te']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['anuled']?>
		</td>
	</tr><?
} ?>
</table>
