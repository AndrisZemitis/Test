<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

$id = $_GET['id'];
$h = $_GET['h'];

$batch_query_pavadzime = getCorrectBatch($h,"table_pavadzime");
$batch_query_select_balkis = getCorrectBatch($h,"table_balkis");
$batch_query_batch = getCorrectBatch($h,"table_batch");

//$rp = mysql_query("select id from ".$batch_query_pavadzime." where batch_fails = $id");
//while ($mp = mysql_fetch_array($rp))
//	mysql_query("delete from ".$batch_query_select_balkis." where pavadzime = ".$mp[id]);

mysql_query("UPDATE ".$batch_query_pavadzime." SET opcija = 'D' where batch_fails = $id");
//mysql_query("delete from ".$batch_query_batch." where id = $id");

menu(0);
?>
<br><br>
Fails izdzēsts.