<?
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

?>

<html>
<head>
	 <title>Grupēšanas nosacījumi</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body onload="window.moveTo(0,0);">					
<center>
<STYLE TYPE="text/css">
  TD { font-size: 12px; }
</STYLE>

<?
$sablons_id = $_GET['sablons'];
$query_head = "SELECT * FROM g_sabloni WHERE id = $sablons_id";
$query_head_1 = mysql_query($query_head);
while($show_1 = mysql_fetch_array($query_head_1)){
  $nosaukums = $show_1['nosaukums'];
  $informacija = $show_1['info'];
}

echo $nosaukums.'<br />';
echo $informacija.'<br />'.'<br />';

$query_body = "SELECT * FROM g_sab_saturs WHERE sablona_id = $sablons_id";
$query_body_1 = mysql_query($query_body);
while($show_2 = mysql_fetch_array($query_body_1)){
  $lauks = $show_2['lauks'];
  $vertiba = $show_2['vertiba'];
}

  
?>
<input type=button value="Aizvērt" onclick="window.close();"><BR>

</form>