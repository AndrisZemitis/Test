<?
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;


$pv = $_POST['pv'];

if ($_POST['subm']=='pieg')
{
	if ($_POST['jauns_parvadatajs'])
	{
		mysql_query("insert into parvadatajs (nosaukums) values ('".$_POST['jauns_parvadatajs']."')");
		$r = mysql_query("select id from parvadatajs where nosaukums = '".$_POST['jauns_parvadatajs']."'");
		$m=mysql_fetch_array($r);
		$pid = $m['id'];
		mysql_query("insert into auto (numurs,parvadatajs) values ('".strtoupper($_POST['numurs'])."',$pid)");
	}
	else
	{
		mysql_query("insert into auto (numurs,parvadatajs) values ('".strtoupper($_POST['numurs'])."',".$_POST['parvadatajs'].")");
	}
}

$r = mysql_query("select * from pavadzime where id in ($pv) and piegad_grupa = 'LVM'");
while ($m=mysql_fetch_array($r))
{
	$rAuto = mysql_query("select * from auto where numurs = '".strtoupper($m['auto'])."'");
	if (!($mAuto=mysql_fetch_array($rAuto)))
	{
		// ja kādam nav piegādātāja uzreiz piedāvājam ievadīt
		?>
		<HTML>
			<head>
				<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
			</head>
		<BODY>
			<FORM method=POST>
			<CENTER>
			Norādiet pārvadātāju<BR>
			Auto: <b><?=$m['auto']?></b><BR><BR>
			Izvēlēties no saraksta:
			<SELECT name=parvadatajs onchange="if (parvadatajs.value=='JAUNS') {jauns.innerHTML='vai jauns pārvadātājs:<INPUT type=text name=jauns_parvadatajs ><BR>'} else jauns.innerHTML = '';">
				<option value=0>Nav pārvadātāja</option>
				<option value=JAUNS>Jauns pārvadātājs</option>
				<?
				$rParv = mysql_query("select * from parvadatajs order by nosaukums");
				while ($mParv=mysql_fetch_array($rParv))
				{
					?><option value=<?=$mParv['id']?>><?=$mParv['nosaukums']?></option><?
				}
				?>

			</SELECT>
			<BR>

			<span id=jauns></span>
			<BR>
			<INPUT type=hidden name=pv value="<?=$pv?>">
			<INPUT type=hidden name=numurs value="<?=$m['auto']?>">
			<INPUT type=hidden name=subm value="pieg">
			<INPUT type=submit value=Saglabāt >
			<INPUT type=submit value=Atcelt onclick="window.close();return false;" >
			</FORM>
		</BODY>
		</HTML>
		<?
		return;
	}
}
?>

<HTML>
<BODY onload="opener.forma.pv.value='<?=$pv?>';window.close();">
	
</BODY>
</HTML>
