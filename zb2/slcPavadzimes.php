<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

$atskaites_veids = $_GET['type'];

switch($atskaites_veids){
    case "all":
     $tabulaName = "pavadzime";
    break;
    case "laiko":
     $tabulaName = "pavadzime";
    break;
    case "vika":
     $tabulaName = "vikawood_";
    break;
    case "akrs":
     $tabulaName = "pavadzime";
    break;
    case "nelss":
     $tabulaName = "nelss_";
    break;
    case "bruto":
     $tabulaName = "pavadzime";
    break;
    case "xml":
     $tabulaName = "vikawood_";
    break;
    case "gaujaskoks":
     $tabulaName = "gaujaskoks_";
    break;
    case "smiltene":
     $tabulaName = "smiltene_";
    break;
    case "bsw":
     $tabulaName = "bsw_";
    break;
    case "vudlande":
     $tabulaName = "vudlande_";
    break;
    case "incukalns":
     $tabulaName = "i_";
    break;
    case "pata_ab":
     $tabulaName = "pata_ab_";
    break;
    case "stora_enso":
     $tabulaName = "stora_enso_";
    break;
    case "latvijas_finieris":
     $tabulaName = "latvijas_finieris_";
    break;
    case "piebalgas":
     $tabulaName = "piebalgas_";
    break;
    case "kurekss":
     $tabulaName = "k_";
    break;
    case "osukalni":
     $tabulaName = "osukalni_";
    break;
    case "4plus":
     $tabulaName = "4plus_";
    break;
}


?>
<HTML>
<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<?

$batches = "";
foreach($_POST as $key=>$value)
{
	if (substr($key,0,7) == 'batchid')
	{
		if ($batches) $batches = $batches . ',';
		$batches = $batches . $value;
	}
}

?>
<form name=form1 method=POST>
<center>
<?
//$r = mysql_query("select * from ".$pavadzime." where batch_fails in (".$batches.") order by id");
$tmp_Query_1 = "SELECT ".$tabulaName."pavadzime.id as pvdz_id,".$tabulaName."pavadzime.pavadzime as pavadzime,".$tabulaName."pavadzime.piegad_grupa as piegad_grupa,".$tabulaName."pavadzime.kad_piegad as kad_piegad,".$tabulaName."pavadzime.iecirknis as iecirknis,".$tabulaName."pavadzime.cirsmas_kods as cirsmas_kods,".$tabulaName."pavadzime.fsc as fsc,".$tabulaName."pavadzime.piegad_kods as piegad_kods,".$tabulaName."pavadzime.iecirknis_pieg as iecirknis_pieg,".$tabulaName."pavadzime.auto as auto, ".$tabulaName."pavadzime.soferis as soferis,".$tabulaName."pavadzime.kravas_id as kravas_id,".$tabulaName."batch_fails.nosaukums as nosaukums FROM ".$tabulaName."pavadzime LEFT JOIN ".$tabulaName."batch_fails ON (".$tabulaName."pavadzime.batch_fails = ".$tabulaName."batch_fails.id) GROUP BY ".$tabulaName."pavadzime.id order by ".$tabulaName."pavadzime.id DESC LIMIT 0,500";
$r = mysql_query($tmp_Query_1);
//echo "SELECT * FROM nelss_batch_fails INNER JOIN ".$pavadzime." where 1=1 GROUP BY pavadzime.pavadzime order by id LIMIT 0,30";

?>
<table border=1 cellspacing=0 cellpadding=2>
<tr  bgcolor=#7EBF7E>
	<th></th>
	<th>ID</th>
	<th>Faila nosaukums</th>
	<th>Numurs</th>
	<th>Pieg.</th>
	<th>Piegādāts</th>
	<th>Iecirknis</th>
	<th>Iecirknis pieg.</th>
	<th>Auto</th>
	<th>Šoferis</th>
</tr>
<?
while ($m=mysql_fetch_array($r))
{
	?><tr><?
		?><td><input type=checkbox name="pv_id" value="<?=$m['pvdz_id']?>"></td><?
		?><td align=right><nobr><?=$m['pvdz_id']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['nosaukums']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['pavadzime']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['piegad_grupa']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['kad_piegad']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['iecirknis']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['iecirknis_pieg']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['auto']?>&nbsp;</td><?
		?><td align=left ><nobr><?=$m['soferis']?>&nbsp;</td><?
	?></tr><?
}
?></table>
<BR><BR>
<!-- <input type=submit name=subm2 value="Izvēlēties"> -->
</form>
</center>
</body>
</html>