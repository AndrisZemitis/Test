<? 

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=excel_eksports.xls");

include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;
//print_r($mlietotajs);
menu($_GET['h']); 

$getData = new getTableVal();
$value_arr = $getData->buildQuery();
//print_r($value_arr);

?>
    <table border="0" align="center">
    <font size="10">
      <? foreach($value_arr as $uzn_key => $uzn_value){ ?>
      <tr bgcolor=CCFFCC>
        <td colspan="8" align="center"><b><?=$uzn_key?><b></td>
      </tr>
      <tr bgcolor=F0F0F0>
        <td align="center">Pavadzīme</td>
        <td align="center">Suga</td>
        <td align="center">Šķira</td>
        <td align="center">Diametrs grupa</td>
        <td align="center">Brāķa iemesls</td>
        <td align="center">Bruto m3</td>
        <td align="center">Brāķis m3</td>
        <td align="center">Brāķis %</td>
      </tr>
       <? foreach($uzn_value as $key_0 => $value_0){?>
        <? foreach($value_0 as $key_1 => $value_1){?>
          <? foreach($value_1 as $key_2 => $value_2){ ?>
            <? foreach($value_2 as $key_3 => $value_3){ ?>
              <? foreach($value_3 as $key_4 => $value_4){ ?>
                <? if($key_4 != "bruto_tilpums" && ($key_4 == "Līkumainība" || $key_4 == "Zari" || $key_4 == "Saussāns" || $key_4 == "")){?>
        <tr bgcolor=FFFFFF>
          <td rowspan="1"><?=$key_0?></td>
          <td rowspan="1"><?=$key_1?></td>
          <td rowspan="1"><?=$key_2?></td>
          <td rowspan="1"><?=$key_3?></td>
          <td rowspan="1"><?=$key_4?></td>
          <td rowspan="1"><?=$value_3['bruto_tilpums']?></td>
          <td rowspan="1"><?=$value_4?></td>
          <td rowspan="1"><?=getProc($value_3['bruto_tilpums'],$value_4)?></td>
        </tr>
               <?}?>
              <?}?>
            <?}?>
          <?}?>
        <? } ?>
       <? } ?>
        <tr>
          <td colspan="6">&nbsp;</td>
        <tr>
      <? } ?>
    </table>
  </body>
</html>

<?
//print_r($query);

class getTableVal{
  function getTableVal(){
    return true;
  }
  
  function buildQuery(){
    $gads = "2013";
    $menesis = "02";
    $diena = "24";
    
    $query_text = "SELECT `g_registrs`.`pircejs` as uznemums,
                    `g_registrs_sub`.`pavadzime` as pavadzime, 
                    `g_registrs_sub`.`skira` as skira, 
                    `g_registrs_sub`.`suga` as suga, 
                    `g_registrs_sub`.`diametrs_grupa` as diametrs_grupa, 
                    `g_registrs_sub`.`brakis_iemesls` as brakis_iemesls, 
                    SUM(`g_registrs_sub`.`brakis`) as brakis, 
                    SUM(`g_registrs_sub`.`bruto`) as bruto_tilpums 
                    FROM `g_registrs` 
                    INNER JOIN `g_registrs_sub` ON (`g_registrs`.`id` = `g_registrs_sub`.`registrs_id`)";
    $where_statement = " WHERE `g_registrs`.`datums_uzmer` > '{$gads}-{$menesis}-{$diena}' AND `g_registrs`.`pircejs` != '' AND `g_registrs`.`opcija` = 'A'";
    $group_by_statemant = " GROUP BY `g_registrs`.`pircejs`, `g_registrs_sub`.`pavadzime`, `g_registrs_sub`.`skira`,`g_registrs_sub`.`suga`,`g_registrs_sub`.`diametrs_grupa`,`g_registrs_sub`.`brakis_iemesls`";
    $query_final = $query_text.$where_statement.$group_by_statemant;

//    echo $query_final;
    $query = mysql_query($query_final);
    $counter = 0;
    while($query_arr = mysql_fetch_assoc($query)){
      $uznemums = $this->getUznemums($query_arr['uznemums']);
//      $result_arr[$uznemums][$counter]['suga'] = $query_arr['suga'];
//      $result_arr[$uznemums][$counter]['skira'] = $query_arr['skira'];
//      $result_arr[$uznemums][$counter]['brakis_iemesls'] = $query_arr['brakis_iemesls'];
//      $result_arr[$uznemums][$counter]['bruto_tilpums'] = $sub_result[$query_arr['uznemums']][$query_arr['suga']][$query_arr['diametrs_grupa']]['bruto_tilpums'];
//      $result_arr[$uznemums][$counter]['diametrs_grupa'] = $query_arr['diametrs_grupa'];
//      $result_arr[$uznemums][$counter]['brakis'] = $query_arr['brakis'];
//      $result_arr[$uznemums][$counter]['braka_procents'] = round(($query_arr['brakis']/$sub_result[$query_arr['uznemums']][$query_arr['suga']][$query_arr['diametrs_grupa']]['bruto_tilpums']) * 100,2);
//      $skira = 9;
      $skira = $query_arr['skira'];
      $result_arr[$uznemums][$query_arr['pavadzime']][$query_arr['suga']][$skira][$query_arr['diametrs_grupa']]['bruto_tilpums'] += $query_arr['bruto_tilpums'];
      $result_arr[$uznemums][$query_arr['pavadzime']][$query_arr['suga']][$skira][$query_arr['diametrs_grupa']][$query_arr['brakis_iemesls']] = $query_arr['brakis'];
      
      $counter++;
    }
    
    
    
    return $result_arr;
  }
  
  function getUznemums($temp_value){
    $ex_value = explode(',', $temp_value);
    $value = $ex_value[0];
    return $value;
  }
}

function getProc($main, $substant){
  return round($substant/$main*100,2);
}

?>