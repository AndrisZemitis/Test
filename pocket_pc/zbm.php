<?
include '../connect.php';
include '../check_login.php';
include '../funkcijas.php';
include 'menu.php';
?>

<html>
<HEAD>
<TITLE></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <script type="text/javascript" src="../jQuery/jquery-1.6.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){
        
      function last_msg_funtion(){

        var ID=$(".message_box:last").attr("id");
        $('div#last_msg_loader').html('<img src="bigLoader.gif">');
        $.post("zbm.php?action=get&last_msg_id="+ID,
        
        function(data){
          if (data != "") {
            $(".message_box:last").after(data);			
          }
          $('div#last_msg_loader').empty();
        });
      };  
      
      $(window).scroll(function(){
        if($(window).scrollTop() == $(document).height() - $(window).height()){
           last_msg_funtion();
        }
      }); 
    });
	</script>
</HEAD>
<BODY >


<?

$last_msg_id = $_GET['last_msg_id'];
$action = $_GET['action'];

menu('zbm',$valoda);

$non_arch = "n";
$today = getdate();
$month = $today['mon'];
$year = $today['year'];
$month_s = ($month - 3) + $year * 12;

//$r = mysql_query(" select * from fails_zbm order by id ");
//echo ("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) > ".$month_s." order by id ");
//$r = mysql_query("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) > ".$month_s." order by id desc");

//$r = mysql_query("SELECT * FROM `fails_zbm` ORDER BY `id` DESC LIMIT 50");
$r = mysql_query("select * from fails_zbm where MID( started, 7, 4 ) *12 + MID( started, 4, 2 ) > ".$month_s." order by id desc");

if($last_msg_id > 0 && $action == 'get'){
  $r = mysql_query("SELECT * FROM `fails_zbm` WHERE `id` < {$last_msg_id} ORDER BY `id` DESC LIMIT 10");
}

?>

<div align=center><input type=button name=excel_formats onclick="location='zbm_excel.php?excel=<?=$non_arch?>'" value="Excel formātā"></div><br>

<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pasūtītājs</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Vietas kods</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Kontrolmērnieks</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pasnr</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pavadzīmes datums</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Mērīšanas datums</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pas_nos</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pavaddokuments</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">TDU</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Automašīna</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Piekabe</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Šoferis</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Metode</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Mērnieks</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Baļķu skaits</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Anulēti</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Šķiras</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Sugas</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Vid. garums</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Vai ir "8" br. kods?</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Kļūdas</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
	<td align=center>
		&nbsp;&nbsp;
	</td>
</tr>
<? 
$color = '#E1E1E1';
while ($m = mysql_fetch_array($r))
{

//-----------------------------------------------------------
$tmp_QueryText_0 = "SELECT count(*) as cnt FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." AND anuled = 0";
$tmp_Query_0 = mysql_query($tmp_QueryText_0);
$tmp_QueryResult_0 = mysql_fetch_array($tmp_Query_0);
//---
$tmp_QueryText_6 = "SELECT (SUM(`gr`) / COUNT(*)) as vid_gar FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." AND anuled = 0";
$tmp_Query_6 = mysql_query($tmp_QueryText_6);
$tmp_QueryResult_6 = mysql_fetch_array($tmp_Query_6);
//---
$tmp_QueryText_1 = "SELECT distinct(sk) as skira FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." ORDER BY skira ASC";
$tmp_Query_1 = mysql_query($tmp_QueryText_1);
$tmp_Skiras = '';
While($tmp_QueryResult_1 = mysql_fetch_array($tmp_Query_1)){
  $tmp_Skiras .= $tmp_QueryResult_1['skira'].',';
}
$tmp_Skiras = substr($tmp_Skiras,0,-1);
//---
$tmp_QueryText_2 = "SELECT distinct(sg) as suga FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." ORDER BY suga ASC";
$tmp_Query_2 = mysql_query($tmp_QueryText_2);
$tmp_Sugas = '';
while($tmp_QueryResult_2 = mysql_fetch_array($tmp_Query_2)){
  $tmp_Sugas .= $tmp_QueryResult_2['suga'].',';
}
$tmp_Sugas = substr($tmp_Sugas,0,-1);
//---
$tmp_QueryText_3 = "SELECT count(*) as cnt_barkis_8 FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." AND im = 8";
$tmp_Query_3 = mysql_query($tmp_QueryText_3);
$tmp_QueryResult_3 = mysql_fetch_array($tmp_Query_3);
$tmp_IrBrakis8 = $tmp_QueryResult_3['cnt_barkis_8'];
if($tmp_QueryResult_3['cnt_barkis_8'] == 0){$tmp_IrBrakis8 = "Nav";}
//---
$tmp_QueryText_4 = "SELECT count(*) as cnt_anuled FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id']." AND anuled = 1";
$tmp_Query_4 = mysql_query($tmp_QueryText_4);
$tmp_QueryResult_4 = mysql_fetch_array($tmp_Query_4);
$tmp_Anuleti = $tmp_QueryResult_4['cnt_anuled'];
if($tmp_QueryResult_4['cnt_anuled'] == 0){$tmp_Anuleti = "Nav";}
//---
$tmp_NepTievg = '';
$tmp_QueryText_5 = "SELECT MOD(tc,10) as atlikums FROM fails_zbm_ui WHERE fails_zbm_id = ".$m['id'];
$tmp_Query_5 = mysql_query($tmp_QueryText_5);
$tmp_QueryResult_5 = mysql_fetch_array($tmp_Query_5);
//$tmp_NepTievg = $tmp_QueryResult_5['atlikums'];
if($tmp_QueryResult_5['atlikums'] > 0){$tmp_NepTievg = "Kļūda tievgalī!";}
//echo $tmp_NepTievg;
//-----------------------------------------------------------

 	if ($color == '#E1E1E1')
    $color = '#FFFFFF';
	else
    $color = '#E1E1E1';
	if ($m['export_id'] < 1)
		$color='#FFCCCC';
 ?>
<tr bgcolor='<?=$color?>'>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pasutitajs']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['viet_kods']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['kontrolmernieks']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pasnr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=getPavadzimesDatums($m['pasnr'])?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=getMerisanasDatums($m['id'])?>
		</td>		
		<td align=center>
			&nbsp;&nbsp;<?=$m['pas_nos']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pavaddok']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['transp_darba_uzd']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['autonr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['piekabnr']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['sofer']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['metode']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['me']?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_QueryResult_0['cnt']?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_Anuleti?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_Skiras?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_Sugas?>
		</td>
		<td align=center>
			&nbsp;<?=round($tmp_QueryResult_6['vid_gar'],0)?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_IrBrakis8?>
		</td>
		<td align=center>
			&nbsp;<?=$tmp_NepTievg?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="zbm_iu.php?zbm_id=<?=$m['id']?>">Mērījumi</a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="movedata.php?zbm_id=<?=$m['id']?>">Kopēt</a>
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="movedata.php?zbm_id=<?=$m['id']?>&round=no">Kopēt neapaļojot diametru</a>
		</td>
	</tr><?
} ?>
</table>
<?

function getPavadzimesDatums($datums_akts){
  $diena = substr($datums_akts,0,2);
  $menesis = substr($datums_akts,2,2);
  $gads = "2013";
  $result = $diena."-".$menesis."-".$gads;
  return $result;
}

function getMerisanasDatums($merijuma_id){
  $mysql_text = "SELECT `ts` FROM `fails_zbm_ui` WHERE `fails_zbm_id` = {$merijuma_id} ORDER BY `id` ASC LIMIT 0, 1";
  $mysql = mysql_query($mysql_text);
  while($mysql_arr = mysql_fetch_assoc($mysql)){
    $datums = $mysql_arr['ts'];
  }
  
  $datums_tmp = explode(" ",$datums);
  $result = str_replace("/","-",$datums_tmp[0]);
  return $result;
}

?>