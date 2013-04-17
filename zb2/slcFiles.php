<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

?>

<html>
<head>
	 <title>Izvēlieties failus</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
					<center>
<STYLE TYPE="text/css">
  TD { font-size: 12px; }
</STYLE>

<?
$atskaites_veids = $_GET['type'];
switch($atskaites_veids){
    case "all":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc');
    break;
    case "laiko":
    $r = mysql_query('select id,nosaukums from batch_fails where nosaukums like "%LAIKO%" order by id desc');
    break;
    case "vika":
    $r = mysql_query('select id,nosaukums from vikawood_batch_fails order by id desc');
    break;
    case "akrs":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc');
    break;
    case "nelss":
    $r = mysql_query('select id,nosaukums from nelss_batch_fails order by id desc');
    break;
    case "bruto":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc');    
    break;
    case "xml":
    $r = mysql_query('select id,nosaukums from vikawood_batch_fails order by id desc');
    break;
    case "gaujaskoks":
    $r = mysql_query('select id,nosaukums from gaujaskoks_batch_fails order by id desc');
    break;
    case "smiltene":
    $r = mysql_query('select id,nosaukums from smiltene_batch_fails order by id desc');
    break;
    case "bsw":
    $r = mysql_query('select id,nosaukums from bsw_batch_fails order by id desc');
    break;
    case "vudlande":
    $r = mysql_query('select id,nosaukums from vudlande_batch_fails order by id desc');
    break;
    case "incukalns":
    $r = mysql_query('select id,nosaukums from i_batch_fails order by id desc');
    break;
    case "pata_ab":
    $r = mysql_query('select id,nosaukums from pata_ab_batch_fails order by id desc');
    break;
    case "stora_enso":
    $r = mysql_query('select id,nosaukums from stora_enso_batch_fails order by id desc');
    break;
    case "latvijas_finieris":
    $r = mysql_query('select id,nosaukums from latvijas_finieris_batch_fails order by id desc');
    break;
    case "piebalgas":
    $r = mysql_query('select id,nosaukums from piebalgas_batch_fails order by id desc');
    break;
    case "kurekss":
    $r = mysql_query('select id,nosaukums from k_batch_fails order by id desc');
    break;
    case "osukalni":
    $r = mysql_query('select id,nosaukums from osukalni_batch_fails order by id desc');
    break;
    case "4plus":
    $r = mysql_query('select id,nosaukums from 4plus_batch_fails order by id desc');
    break;
}

?>
<!-- <form name=form1 method=POST action=select_pavadzimes.php?type=<?=$atskaites_veids?>> -->
<form name=form1 method=POST action=select_pavadzimes.php?type=<?=$atskaites_veids?>>
<input type=submit name=subm value="Izvēlēties">
<input type=button value="Atcelt" onclick="Dialog.cancelCallback();"><BR>
<table border=0>
<tr>
<th></th>
<th>Fails</th>
</tr>
<?
$rowcolor1='#FFFFFF';
$rowcolor2='#FFFFFF';
$rowflag=0;
while ($m = mysql_fetch_array($r))
{
	?>
	<tr bgcolor="<? if ($rowflag) echo $rowcolor1; else echo $rowcolor2; ?>">
	<? $rowflag = !$rowflag; ?>
		<td><input type=checkbox name=batchid<?=$m['id']?> value="<?=$m['id']?>" ></td>
		<td><?=$m['nosaukums']?></td>
	</tr>
	<?
}
?></table>
<BR>
</form>