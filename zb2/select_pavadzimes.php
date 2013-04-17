<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;
ob_start();

$atskaites_veids = $_GET['type'];
switch($atskaites_veids){
    case "all":
     $pavadzime = "pavadzime";
    break;
    case "laiko":
     $pavadzime = "pavadzime";
    break;
    case "vika":
     $pavadzime = "vikawood_pavadzime";
    break;
    case "akrs":
     $pavadzime = "pavadzime";
    break;
    case "nelss":
     $pavadzime = "nelss_pavadzime";
    break;
    case "bruto":
     $pavadzime = "pavadzime";
    break;
    case "xml":
     $pavadzime = "vikawood_pavadzime";
    break;
    case "gaujaskoks":
     $pavadzime = "gaujaskoks_pavadzime";
    break;
    case "smiltene":
     $pavadzime = "smiltene_pavadzime";
    break;
    case "bsw":
     $pavadzime = "bsw_pavadzime";
    break;
    case "vudlande":
     $pavadzime = "vudlande_pavadzime";
    break;
    case "incukalns":
     $pavadzime = "i_pavadzime";
    break;
    case "pata_ab":
     $pavadzime = "pata_ab_pavadzime";
    break;
    case "stora_enso":
     $pavadzime = "stora_enso_pavadzime";
    break;
    case "latvijas_finieris":
     $pavadzime = "latvijas_finieris_pavadzime";
    break;
    case "piebalgas":
     $pavadzime = "piebalgas_pavadzime";
    break;
    case "kurekss":
     $pavadzime = "k_pavadzime";
    break;
    case "osukalni":
     $pavadzime = "osukalni_pavadzime";
    break;
    case "4plus":
     $pavadzime = "4plus_pavadzime";
    break;
    case "tezei_s":
     $pavadzime = "tezei_s_pavadzime";
    break;
    case "varpas1":
     $pavadzime = "varpas1_pavadzime";
    break;
    case "latvani":
     $pavadzime = "latvani_pavadzime";
    break;
    case "kubikmetrs":
     $pavadzime = "kubikmetrs_pavadzime";
    break;
    case "jekabpils_mr":
     $pavadzime = "jekabpils_mr_pavadzime";
    break;
    case "timberex_group":
     $pavadzime = "timberex_group_pavadzime";
    break;
}

if ($_POST['subm2']){ $pv = substr($_POST['ident'],0,-1); ?>
  <BODY onload="window.opener.document.forma.pv.value='<?=$pv?>';window.close();">
	<form method=post name=forma>
		<input type=hidden name=pv value="<?=$pv?>">
	</form>
	</body>
<? return; } ?>
<HTML>
<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
    div { color:red; font-weight: bolder; font-size: 20px;}
    </style>
    <script type="text/javascript" src="../js_jquery/jquery-1.4.2.js"></script>
</HEAD>
<script type="text/javascript">
  function checkUncheckAll(checkAllState, cbGroup){
    
    if(!cbGroup.value){
      for (i = 0; i < cbGroup.length; i++){
        cbGroup[i].checked = checkAllState.checked;
      }
    }else{
        cbGroup.checked = checkAllState.checked;
    }
  }

  function anyCheck(form){
    var total = '';
    var max = form.chkList.length;

    if(form.chkList.length){
      for (var idx = 0; idx < max; idx++) {
        if (eval("document.form1.chkList[" + idx + "].checked") == true) {
          total +=document.form1.chkList[idx].value + ","
        }
      }
    }else{
          total = document.form1.chkList.value + ","  
    }  
    return total;
  }
</script>
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
$r = mysql_query("select * from ".$pavadzime." where batch_fails in (".$batches.") order by id");
?>
<table border=1 cellspacing=0 cellpadding=2>
<tr  bgcolor=#7EBF7E>
	<th><input type="checkbox" name="Check_ctr" onClick="checkUncheckAll(this, chkList);"></th>
	<th>ID</th>
	<th>Numurs</th>
	<th>Pieg.</th>
	<th>Piegādāts</th>
	<th>Iecirknis</th>
	<th>Cirsma</th>
	<th>FSC</th>
	<th>Pieg. kods</th>
	<th>Iecirknis pieg.</th>
	<th>Attālums</th>
	<th>Auto</th>
	<th>Šoferis</th>
	<th>Cenas</th>
	<th>Kravas id</th>
</tr>
<? while ($m=mysql_fetch_array($r)){ ?>
	<tr>
		<td><input type=checkbox id="<?=$m['id']?>" name="chkList" value="<?=$m['id']?>" ></td>
		<td align=right><nobr><?=$m[id]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[pavadzime]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[piegad_grupa]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[kad_piegad]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[iecirknis]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[cirsmas_kods]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[fsc]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[piegad_kods]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[iecirknis_pieg]?>&nbsp;</td>
		<td align=right><nobr><?=$m[attalums]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[auto]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[soferis]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[cenu_matrica]?>&nbsp;</td>
		<td align=left ><nobr><?=$m[kravas_id]?>&nbsp;</td>
	</tr>
<? } ?>
</table>
<br />
<div></div>
<script>
    function countChecked(){
      var n = $("input:checked").length;
      if (eval("document.form1.Check_ctr.checked") == true) {
        n = n - 1;
      }
      $("div").text(n + (n == 1 ? " fails ir iezīmēts" : " faili ir iezīmēti") + "!");
    }
    countChecked();
    $(":checkbox").click(countChecked);
</script>
<br />
<input type=submit name=subm2 value="Izvēlēties" onclick="form1.ident.value=anyCheck(form1);">
<input type=button value="Atcelt" onclick="window.close();">
<input name="ident" type="hidden">
</form>

</center>
</body>
</html>