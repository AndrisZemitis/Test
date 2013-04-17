<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
 include ('db.inc.php');
 include ("../check_login.php");
 if ($mlietotajs['g_report']!='Y') return;

 menu($_GET['h']);

 $pavadzime    = $_GET['pavadzime'];
 $h            = $_GET['h'];
 $skaits_Balki = 0;
 
 $batch_query_select_balkis = getCorrectBatch($h,"table_balkis");
 list($ColumnNames,$ColumnValues,$ColumnData,$skaits_Balki) = returnColData($batch_query_select_balkis, $pavadzime);

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