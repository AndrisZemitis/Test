<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

?>

<html>
<head>
	 <title>Izvēlieties failus</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <script type="text/javascript" src="../js_jquery/jquery-1.4.2.js"></script>

  <style type="text/css">
    td.inactive {
      background: #ffffff;
    }

    td.active {
      background: #ffcc66;
    }
    
  </style>
   
</head>
<body onload="window.moveTo(0,0);window.resizeTo(screen.width,screen.height);">					
					<center>
<STYLE TYPE="text/css">
  TD { font-size: 12px; }
</STYLE>

<?
$atskaites_veids = $_GET['type'];
switch($atskaites_veids){
    case "all":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc LIMIT 0,1000');
    break;
    case "laiko":
    $r = mysql_query('select id,nosaukums from batch_fails where nosaukums like "%LAIKO%" order by id desc LIMIT 0,1000');
    break;
    case "vika":
    $r = mysql_query('select id,nosaukums from vikawood_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "akrs":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc LIMIT 0,1000');
    break;
    case "nelss":
    $r = mysql_query('select id,nosaukums from nelss_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "bruto":
    $r = mysql_query('select id,nosaukums from batch_fails order by id desc LIMIT 0,1000');    
    break;
    case "xml":
    $r = mysql_query('select id,nosaukums from vikawood_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "gaujaskoks":
    $r = mysql_query('select id,nosaukums from gaujaskoks_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "smiltene":
    $r = mysql_query('select id,nosaukums from smiltene_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "bsw":
    $r = mysql_query('select id,nosaukums from bsw_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "vudlande":
    $r = mysql_query('select id,nosaukums from vudlande_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "incukalns":
    $r = mysql_query('select id,nosaukums from i_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "pata_ab":
    $r = mysql_query('select id,nosaukums from pata_ab_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "stora_enso":
    $r = mysql_query('select id,nosaukums from stora_enso_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "latvijas_finieris":
    $r = mysql_query('select id,nosaukums from latvijas_finieris_batch_fails order by id desc LIMIT 0,2000');
    break;
    case "piebalgas":
    $r = mysql_query('select id,nosaukums from piebalgas_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "kurekss":
    $r = mysql_query('select id,nosaukums from k_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "osukalni":
    $r = mysql_query('select id,nosaukums from osukalni_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "4plus":
    $r = mysql_query('select id,nosaukums from 4plus_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "tezei_s":
    $r = mysql_query('select id,nosaukums from tezei_s_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "varpas1":
    $r = mysql_query('select id,nosaukums from varpas1_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "kubikmetrs":
    $r = mysql_query('select id,nosaukums from kubikmetrs_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "latvani":
    $r = mysql_query('select id,nosaukums from latvani_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "jekabpils_mr":
    $r = mysql_query('select id,nosaukums from jekabpils_mr_batch_fails order by id desc LIMIT 0,1000');
    break;
    case "timberex_group":
    $r = mysql_query('select id,nosaukums from timberex_group_batch_fails order by id desc LIMIT 0,1000');
    break;
}

?>
<form name=form1 method=POST action=select_pavadzimes.php?type=<?=$atskaites_veids?>>
<input type=submit name=subm value="Izvēlēties">
<input type=button value="Atcelt" onclick="window.close();"><BR>
<table border=1 cellspacing=0 cellpadding=2>
<tr>
<th colspan=2>Fails</th>
</tr>
<?
while ($m = mysql_fetch_array($r))
{
	?>
	<tr>
		<td align=center class="inactive"><input type=checkbox name=batchid<?=$m['id']?> value="<?=$m['id']?>"></td>
		<td align=center class="inactive"><?=$m['nosaukums']?></td>
	</tr>
	<?
}
?></table>
<script>
  $('tr').click(function() {
     $('td', this).toggleClass('active');
   });
</script>
</form>
