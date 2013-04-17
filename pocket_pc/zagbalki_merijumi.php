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
menu('zagbalku_merijumi',$valoda);

$r = mysql_query(" select * from zagbalki_merijumi where zagbalki_id = $darba_id order by id ");
?>
<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;<font size="2">Balkas numurs</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Merītājs</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Suga</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Mizas tips</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Tievgala caurmērs mm</font>
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
		&nbsp;&nbsp;<font size="2">Redukc. pa caurmēru cm</font>
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
		&nbsp;&nbsp;<font size="2">Ts</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Te</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Kb</font>
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
		<td align=center>
			&nbsp;&nbsp;<?=$m['nr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pg']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['sg']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['mt']?>
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
			&nbsp;<?=$m['ts']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['te']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['kb']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="#"><!--Labot--></a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="#"><!--Dzēst--></a>
		</td>
	</tr><?
} ?>
</table>
