<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;
ob_start();

menu($_GET['h']);
$h = $_GET['h'];

$batch_query_count = getCorrectBatch($h,"batch_count");
$batch_query_select = getCorrectBatch($h,"batch");
$pavadzimes_tabula = getCorrectBatch($h,"table_pavadzime");
$nosaukums = getCorrectBatch($h,"nosaukums");
$nosaukums_dir = "batch_".$nosaukums;

//fb($_POST,'POST');
if($_POST['komanda'] == 'update'){
	$id = $_POST['ident'];
	$qry_UpdateDel = "UPDATE `{$pavadzimes_tabula}` SET `opcija` = 'D' WHERE `batch_fails` = {$ident}";
//  echo $qry_UpdateDel;
	mysql_query($qry_UpdateDel);
}

?>
<center>
<?
//echo $batch_query_count;
$rc = mysql_query($batch_query_count);
$mc = mysql_fetch_array($rc);
?> Ielasīto failu skaits: <?=$mc['c']?><?

if ($mc[c])
{
	?>
	<table border=1 cellspacing=0 cellpadding=2>
	<tr  bgcolor=#7EBF7E>
		<th>&nbsp;ID&nbsp;</th>
		<th>&nbsp;Nosaukums&nbsp;</th>
		<th>&nbsp;Ielasīts&nbsp;</th>
		<th>&nbsp;Līgums&nbsp;</th>
		<th>&nbsp;Fails&nbsp;</th>
		<th>&nbsp;Darbība&nbsp;</th>
	</tr>
	<?
//print_r($_SERVER);
	$r = mysql_query($batch_query_select);
	while ($m=mysql_fetch_array($r)){
    $fails_final = $m['nosaukums'];
    $fails = str_replace(" ","%20",$fails_final);
    $similarFile = get_SimilarBatch($m['id'],$h);
    
    $dataCompare_arr = get_PavadzimeOptions($m['id'],$pavadzimes_tabula);
    fb($dataCompare_arr,'dataCompare_arr');

    $krasa = 'bgcolor="#FFFFFF"';
    if($dataCompare_arr['c_similar'] > 0){
      $krasa = 'bgcolor="#F09999"';
    }

    if($dataCompare_arr['option'] == 'D'){
      $krasa = 'bgcolor="#66CCFF"';
    }

    if($dataCompare_arr['option'] == 'L'){
      $krasa = 'bgcolor="#66FF66"';
    }
    
      ?><tr <?=$krasa?>><?
			?><td align=right>&nbsp;<?=$m['id']?>&nbsp;</td><?
			?><td align=left >&nbsp;<a href=pavadzime_list.php?fails=<?=$m['id']?>&h=<?=$h?>><?=$m['nosaukums']?></a>&nbsp;</td><?
			?><td>&nbsp;<?=$m['datums']?>&nbsp;</td><?
			?><td>&nbsp;Test&nbsp;</td><?
			?><td>
			<?

		if (file_exists("/home/vmf/htdocs/batch/batch_all/".$nosaukums_dir."/".$fails."")) {
			    echo "&nbsp;&nbsp;<a href=/../batch/client/batch_all/".$fails.">Fails</a>"; //Ja failu augšuplādējis admins, tad fails ir kopējā folderī
			} else {
			   echo "&nbsp;&nbsp;<a href=/../batch/client/".$nosaukums_dir."/".$fails.">Fails</a>";
			} ?>
               </td><?
			?><td>&nbsp;<a href="#" onclick="darbiba.komanda.value='update';darbiba.ident.value=<?=$m['id']?>;darbiba.submit();return false;">Dzēst failu</a></td><?
		?></tr><?
	}
	?></table><?
}
?>

<form name=darbiba method=POST action="batch_list.php?h=<?=$h?>">
	<input type=hidden name=komanda>
	<input type=hidden name=ident>
</form>

</center>
</body>
</html>

<?
function get_PavadzimeOptions($batch_id, $pavadzimes_tabula){
  $query = "SELECT `count_similar`, `opcija` FROM `{$pavadzimes_tabula}` WHERE batch_fails = ".$batch_id;
  $chk_Similar = mysql_query($query);
  while($arr_tmp = mysql_fetch_assoc($chk_Similar)){
    $result['c_similar'] = $arr_tmp['count_similar'];
    $result['option'] = $arr_tmp['opcija'];
  }
  return $result;
}
?>