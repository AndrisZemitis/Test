<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

menu($_GET['h']);

// $pavadzime    = $_GET['pavadzime'];
$h            = $_GET['h'];
$skaits_Balki = 0;

$datums_no = $_POST['datums_no'];
$datums_lidz = $_POST['datums_lidz'];
$garums_no = $_POST['garums_no'];
$garums_lidz = $_POST['garums_lidz'];
$diametrs_no = $_POST['diametrs_no'];
$diametrs_lidz = $_POST['diametrs_lidz'];

?>
<script type='text/JavaScript' src="/common/scw.js"></script>
<script type='text/JavaScript'>
	scwDateDisplayFormat = 'dd/mm/yyyy'; 
	scwDateOutputFormat  = 'dd/mm/yyyy';
	scwDateInputSequence = 'DMY'; 
</script>

<form name="filtrs">
	<div style="width:550px; margin-left:auto; margin-right:auto;">
		<div style="width:50%;float:left">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Datums no:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="datums_no" id="datums_no" value="<?=$datums_no?>" />&nbsp;<img alt="Kalendārs" src="/common/scw.gif" onClick="scwShow (document.getElementById('datums_no'), this);" onmouseover="this.style.cursor='hand'" onmouseout="this.style.cursor='default'">
			</div>
		</div>
		<div style="width:50%;float:right;">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Datums līdz:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="datums_lidz" id="datums_lidz" value="<?=$datums_lidz?>" />&nbsp;<img alt="Kalendārs" src="/common/scw.gif" onClick="scwShow (document.getElementById('datums_lidz'), this);" onmouseover="this.style.cursor='hand'" onmouseout="this.style.cursor='default'">
			</div>
		</div>
		<div style="width:50%;float:left">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Garums no:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="garums_no" value="<?=$garums_no?>" />
			</div>
		</div>
		<div style="width:50%;float:right;">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Garums līdz:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="garums_lidz" value="<?=$garums_lidz?>" />
			</div>
		</div>
		<div style="width:50%;float:left">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Diametrs no:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="diametrs_no" value="<?=$diametrs_no?>" />
			</div>
		</div>
		<div style="width:50%;float:right;">
			<div style="width:100px; float:left; text-align:right; margin-left:auto; margin-right:2px;">Diametrs līdz:</div>
			<div style="float:left; margin-right:auto">
				<input type="text" name="diametrs_lidz" value="<?=$diametrs_lidz?>" />
			</div>
		</div>
		<br />
		<div style="width:60px;margin-left:auto;margin-right:auto;">
			<input type="submit" name="submit" value="Atlasīt" />
		</div>
	</div>
</form>
<?
//$batch_query_select_balkis = getCorrectBatch($h,"table_balkis");
//list($ColumnNames,$ColumnValues,$ColumnData,$skaits_Balki) = returnColData($batch_query_select_balkis, $pavadzime);

?><center>Ielasīto saraksts skaits: <?=$skaits_Balki?><? if(!$skaits_Balki){die('Šai pavadzīmei netika atrasts neviens baļķis!'); } ?>

<table border=1 cellspacing=0 cellpadding=2>
<tr bgcolor=#7EBF7E><? foreach($ColumnNames as $Col_var){ ?><th><?=$Col_var?></th><? } ?></tr>
      
<? foreach($ColumnData as $value){ ?>
   <tr>
     <? foreach($ColumnValues as $nosaukums){ ?>
		<td align=right><nobr><?=$value[$nosaukums]?></a>&nbsp;</td>
     <? } ?>
     <td align=left ><nobr><a href=balkis_edit.php?id=<?=$value[id]?>&h=<?=$h?>>Labot</a>&nbsp;</td>
   </tr>
<? } ?>

    </table>
  </center>
 </body>
</html>

<?
function returnColData($batch_query_select_balkis, $pavadzime){
     $ColValues = array('id','datums_laiks','gar_pirms_red','gar_pec_red','suga',
                              'skira','miza','braka_kods','diametrs_1','diametrs_3',
                              'diametrs_2','diametrs_4','tilpums_1','tilpums_2');

     $ColNames = array('ID','Laiks','Garums pirms redukcijas','Garums pēc redukcijas','Suga',
                              'Šķira','Miza','Brāķa kods','Tievgalis','Diametrs pirms redukcijas',
                              'Diametrs pēc redukcijas','Resgalis','Tilpums 1','Tilpums 2','LABOT');

     $query_001 = "SELECT id as id, datums_laiks as datums_laiks, garums as gar_pirms_red, gar_pec_red as gar_pec_red, 
                   suga as suga, skira as skira, miza as miza, brakis as braka_kods, mind_pirms_red as diametrs_1, 
                   mind_pec_red as diametrs_2, mind_miza as diametrs_3, maxd_miza as diametrs_4, tilpums as tilpums_1, tilpums_scan as tilpums_2 
                   FROM ".$batch_query_select_balkis." 
                   WHERE pavadzime = $pavadzime 
                   ORDER BY id";

     $query_arr = mysql_query($query_001);

     While($temp_ColumnValues = mysql_fetch_assoc($query_arr)){$temp_Col_Data[] = $temp_ColumnValues; $skaits_Balki++;}

     return array($ColNames,$ColValues,$temp_Col_Data,$skaits_Balki);
}
?>