<?
  require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

  if($_POST){
    $dataExport = new dataCopyTransf();
    return true;
  }

class dataCopyTransf{
  function dataCopyTransf(){

    $dataFromArray = $this->getData();
    $result = $this->insertData($dataFromArray);
    
    return false;
  }
  
  function getData(){
  
    $export_id = $_POST['export_id'];
    $table_name_3 = "t_h_kraujmers";
    $mysql_text_1 = "SELECT `h`.`uzm_vieta` as terminals, `h`.`darba_uzdevuma_num` as document, `h`.`date_upload` as datums, `h`.`date_pavadzime` as datums_pvdz, `h`.`buyer` as pircejs, `h`.`seller` as pardevejs, `h`.`reciever` as sanemejs, `h`.`transport` as transports, `h`.`driver` as vaditajs, `h`.`login_name` 
                      FROM `{$table_name_3}` as h WHERE `h`.opcija = 'A' AND `h`.`id` = {$export_id}";
    $mysql_query_1 = mysql_query($mysql_text_1);

    while($mysql_arr_1 = mysql_fetch_assoc($mysql_query_1)){
      $result['head']['workstation_id'] = "1000000";
      $result['head']['terminal_code'] = $mysql_arr_1['terminals'];
      $result['head']['id'] = $this->getMaxID();
      $result['head']['num'] = $this->getMaxNum();
      $result['head']['agreement_id'] = 0;
      $result['head']['document'] = strtoupper($mysql_arr_1['document']);
      $result['head']['date'] = $mysql_arr_1['datums'];
      $pavadzimes_datums = $mysql_arr_1['datums_pvdz'];
      $result['head']['buyer_id'] = $this->getCompany($mysql_arr_1['pircejs']);
      $pircejs_code = $mysql_arr_1['pircejs'];
      $result['head']['seller_id'] = $this->getCompany($mysql_arr_1['pardevejs']);
      $result['head']['reciever_id'] = $this->getCompany($mysql_arr_1['sanemejs']);
      $transport_name = strtoupper($mysql_arr_1['transports']);
//      $result['head']['transport_id'] = $this->getTransport($mysql_arr_1['transports']);
      $result['head']['driver_id'] = $this->getDriver($mysql_arr_1['vaditajs']);
      $result['head']['login'] = $mysql_arr_1['login_name'];
      $pircejs_id = $mysql_arr_1['pircejs'];
    }

    $table_name_4 = "t_b_kraujmers";
    $mysql_text_2 = "SELECT *  
                      FROM `{$table_name_4}` as b WHERE `b`.opcija = 'A' AND `b`.`t_h_id` = {$export_id}";
    $mysql_query_2 = mysql_query($mysql_text_2);

    $bCounter = 0;
    while($mysql_arr_2 = mysql_fetch_assoc($mysql_query_2)){

      $augstums = $this->resetToInt($mysql_arr_2['augstums_vid']);
      $platums = $this->resetToInt($mysql_arr_2['platums_vid']);
      $platums = $this->getCorrectMinL($platums,$pircejs_code);
      
      $bruto = round(($augstums / 100) * ($platums / 100) * ($mysql_arr_2['garums'] / 100) * ($mysql_arr_2['tilp_koef'] / 100),2);
      $defect_volume = round($bruto * ($mysql_arr_2['braka_proc'] / 100),2);
      $neto = $bruto - $defect_volume;
    
      $result['body'][$bCounter]['workstation_id'] = "1000000";
      $result['body'][$bCounter]['id'] = $result['head']['id'];
      $result['body'][$bCounter]['document_id'] = $result['head']['id'];
      $document_id = $result['head']['id'];
      $login_id = $mysql_arr_2['mernieks'];
      $result['body'][$bCounter]['num'] = $bCounter + 1;
      $result['body'][$bCounter]['date_time'] = $result['head']['date'];
//      $result['body'][$bCounter]['date_time_pvdz'] = $result['head']['date_pvdz'];
      $result['body'][$bCounter]['height'] = $mysql_arr_2['garums'];
      $result['body'][$bCounter]['width'] = $augstums;
      $result['body'][$bCounter]['length'] = $platums;
      $result['body'][$bCounter]['sort1'] = 100;
      $result['body'][$bCounter]['sort2'] = 0;
      $result['body'][$bCounter]['coeficient'] = $mysql_arr_2['tilp_koef'];
      $result['body'][$bCounter]['defect_percent'] = $mysql_arr_2['braka_proc'];
      $result['body'][$bCounter]['defect_code'] = $mysql_arr_2['braka_kods'];
      $result['body'][$bCounter]['defect_volume'] = $defect_volume;
      $result['body'][$bCounter]['specie'] = $mysql_arr_2['suga_1_kods'];
      $result['body'][$bCounter]['store_id'] = $this->getStoreName($result['head']['terminal_code']);
      $result['body'][$bCounter]['heap_id'] = $this->getHeapId($mysql_arr_2['gredas_numurs']);
      $result['body'][$bCounter]['sertification'] = "Kontrolēts";
      $result['body'][$bCounter]['transport'] = trim($transport_name);
      if($pircejs_id == 121 && $mysql_arr_2['sortimenta_kods'] == '01'){
        $result['body'][$bCounter]['sortiment'] = $mysql_arr_2['sortimenta_kods'].$mysql_arr_2['suga_1_kods']."2";
      }else{
        $result['body'][$bCounter]['sortiment'] = $mysql_arr_2['sortimenta_kods'].$mysql_arr_2['suga_1_kods']."0";
      }
      $result['body'][$bCounter]['bruto'] = $bruto;
      $result['body'][$bCounter]['neto'] = $neto;
      $result['body'][$bCounter]['neto1'] = $neto;
      $result['body'][$bCounter]['neto2'] = 0.00;
      $result['body'][$bCounter]['c_bruto'] = 1.00;
      $result['body'][$bCounter]['c_neto'] = 1.00;
      $result['body'][$bCounter]['bruto_c'] = $bruto;
      $result['body'][$bCounter]['neto_c'] = $neto;
      $result['body'][$bCounter]['neto1_c'] = $neto;
      $result['body'][$bCounter]['neto2_c'] = 0.00;
      $result['body'][$bCounter]['coeficient_c'] = $mysql_arr_2['tilp_koef'];
      $result['body'][$bCounter]['defect_volume_c'] = $defect_volume;
      $result['body'][$bCounter]['defect_percent_c'] = $mysql_arr_2['braka_proc'];
      $result['body'][$bCounter]['record_state'] = "N";
      $result['body'][$bCounter]['out'] = 0;

      $sortiments = $this->getSortiment($mysql_arr_2['sortimenta_kods'].$mysql_arr_2['suga_1_kods']."0");
      $koef_brakis = $this->getKoef($pavadzimes_datums,$mysql_arr_2['suga_1_kods'],$sortiments);
      
      if($koef_brakis > 0.000){
        $jaunais_braka_tilp = round(($koef_brakis/100) * $result['body'][$bCounter]['bruto'],2);
//        echo $koef_brakis;
//        $result['body'][$bCounter]['defect_volume'] = $result['body'][$bCounter]['defect_volume'] + $jaunais_braka_tilp;
        $result['body'][$bCounter]['defect_volume_c'] = $result['body'][$bCounter]['defect_volume_c'] + $jaunais_braka_tilp;
//        $result['body'][$bCounter]['neto'] = $result['body'][$bCounter]['neto'] - $jaunais_braka_tilp;
        $result['body'][$bCounter]['neto_c'] = $result['body'][$bCounter]['neto_c'] - $jaunais_braka_tilp;
      }

      $bCounter++;

    }

    return $result;
  }

  function getSortiment($tmp_value){
      if (substr($tmp_value,0,2) == "52"){
        $tmp_result = "TM";
      }
      if (substr($tmp_value,0,2) == "50"){
        $tmp_result = "M";
      }

      if (substr($tmp_value,0,2) == "38"){
        $tmp_result = "60-99";
      }

      if ($tmp_value == "0110" || $tmp_value == "0120"){
        $tmp_result = "100-139";
      }

      if ($tmp_value == "3810" || $tmp_value == "3820"){
        $tmp_result = "60-99";
      }

      if ($tmp_value == "0130" || $tmp_value == "0100"){
        $tmp_result = "140-159";
      }

      if ($tmp_value == "0131"){
        $tmp_result = "180-239";
      }

      if ($tmp_value == "0111"){
        $tmp_result = "140-179";
      }

      if ($tmp_value == "0900"){
        $tmp_result = "GULSNIS";
      }

      if ($tmp_value == "0133"){
        $tmp_result = "120-239";
      }

      if ($tmp_value == "0132" || $tmp_value == "0102" || $tmp_value == "0103" || $tmp_value == "0122" || $tmp_value == "0112"){
        $tmp_result = "120-179";
      }


      if ($tmp_value == "0180"){
        $tmp_result = "300-319";
      }
      
      if (substr($tmp_value,0,2) == "09"){
        $tmp_result = "GULSNIS";
      }
      if ($tmp_value == "1000"){
        $tmp_result = "PMSK";
      }
      if ($tmp_value == "1010"){
        $tmp_result = "PMP";
      }
      if ($tmp_value == "1100" || $tmp_value == "1110" || $tmp_value == "1120"){
        $tmp_result = "TKSK";
      }
      if ($tmp_value == "1020" || $tmp_value == "1030" || $tmp_value == "1040" || $tmp_value == "1050" || $tmp_value == "1060" || $tmp_value == "1070" || $tmp_value == "1080" || $tmp_value == "1090"){
        $tmp_result = "PM";
      }
      if ($tmp_value == "1130" || $tmp_value == "1140" || $tmp_value == "1150" || $tmp_value == "1160" || $tmp_value == "1170" || $tmp_value == "1180" || $tmp_value == "1190"){
        $tmp_result = "TKLK";
      }
    return $tmp_result;
  }

  function getKoef($pavadzimes_datums, $suga, $sortiments){
    $pavadzimes_datums = trim($pavadzimes_datums);
    $suga = trim($suga);
    $sortiments = strtoupper(trim($sortiments));
    
    $sql_text = "SELECT SUM(`koef`) as koeficients FROM `t_h_koef` WHERE `lig_datums_no` <= '{$pavadzimes_datums}' AND `lig_datums_lidz` > '{$pavadzimes_datums}' AND `suga` = {$suga} AND `sortiments` = '{$sortiments}'";
//    echo $sql_text;
    $sql = mysql_query($sql_text);
    While($sql_arr = mysql_fetch_assoc($sql)){
      $result = $sql_arr['koeficients'];
    }
    return $result;
  }

  function insertData($dataArr){
    $doc_insert_columns = "";
    $doc_insert_values = "";
    
    foreach($dataArr['head'] as $main_key => $main_item){
        $doc_insert_columns .= " `$main_key`,";
        $doc_insert_values .= " '$main_item',";
    }
    
    $doc_insert_columns = substr($doc_insert_columns,0,-1);
    $doc_insert_values = substr($doc_insert_values,0,-1);
    
    foreach($dataArr['body'] as $body_key => $body_item){
      $bundle_insert_columns = "";
      $bundle_insert_values = "";

      foreach($body_item as $main_body_key => $main_body_item){
        if($main_body_key == 'id'){
          $main_body_item = $this->getMaxBundleID();

          if($body_key != 0){
            $main_body_item += $body_key;
          }        
        }
              
        $bundle_insert_columns .= " `$main_body_key`,";
        $bundle_insert_values .= " '$main_body_item',";
      
      }
      
      $bundle_insert_arr[$body_key]['variables'] = substr($bundle_insert_columns,0,-1);
      $bundle_insert_arr[$body_key]['values'] = substr($bundle_insert_values,0,-1);
    }
    
    $insert_document_text = "INSERT INTO `e_document` ({$doc_insert_columns}) VALUES ({$doc_insert_values})";
//    echo $insert_document_text.'<br />';    
    mysql_query($insert_document_text);    

//    $update_doc_text = "UPDATE `e_document` SET `login` = '{$login_id}' WHERE `workstation_id` LIKE '1000000' AND `id` = {$document_id}";
//    $update_doc = mysql_query($update_doc_text);
    
    foreach($bundle_insert_arr as $body_insert_item){
      $tmp_variables = $body_insert_item['variables'];
      $tmp_values = $body_insert_item['values'];
      
      $insert_bundle_text = "INSERT INTO `e_bundle` ({$tmp_variables}) VALUES ({$tmp_values})";
//      echo $insert_bundle_text.'<br />';
      mysql_query($insert_bundle_text);
    }
    
    $updated_id = $_POST['export_id'];
    $update_date = date("Y-m-d H:i:s");
    $mysql_eksportets = "UPDATE `t_h_kraujmers` SET `eksporta_datums` = '{$update_date}' WHERE `id` = {$updated_id}";
//    echo $mysql_eksportets.'<br />';
    mysql_query($mysql_eksportets);
    
    return true;
  }

  function resetToInt($oldNum){
    $num_arr = explode(".",$oldNum);
    $first_int = $num_arr[0];
    $new_num = str_replace('~','',$first_int);
    $result = $new_num;
    return $result;
  }

  function getCorrectMinL($garums_ar_virsm, $pircejs){
    $result = $garums_ar_virsm;
  
    $_Sablons_txt = "SELECT `nom_garumi` FROM `t_b_sabloni` WHERE `pircejs_assigned` = {$pircejs}";
    $_Sablons = mysql_query($_Sablons_txt);
    while($_Sablons_arr = mysql_fetch_assoc($_Sablons)){
      $nominalie_garumi = explode(',', $_Sablons_arr['nom_garumi']);
    }

    $item_prev = 0;
    foreach($nominalie_garumi as $item){
      if($item < $garums_ar_virsm){

        $diff_prev = $garums_ar_virsm - $item_prev;
        $diff_curr = $garums_ar_virsm - $item;
        if($diff_curr < $diff_prev){
          $result = $item;
        }
        $item_prev = $item;
      }
    }
    
    return $result;
  }

  function getHeapId($heapName){
    $heapName = strtoupper(trim($heapName));
    $table_name_0 = "e_heap";
    $mysql_text = "SELECT `id` as heap_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000' AND `title` LIKE '$heapName'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['heap_id'];
    }
    
    if($result < 1){
      $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
      $mysql_query = mysql_query($mysql_text);
      while($mysql_arr = mysql_fetch_assoc($mysql_query)){
        $max_id = $mysql_arr['max_id'] + 1;
      }
    
      $mysql_text = "INSERT INTO `{$table_name_0}` (`workstation_id`,`id`,`title`,`record_state`,`passive`,`typ`) VALUES ('1000000',$max_id,'$heapName','N',0,'P')";
      $mysql_query = mysql_query($mysql_text);
      $result = $max_id;
    }
    
    return $result;
  }

  function getMaxNum(){
    $table_name_0 = "e_document";
    $mysql_text = "SELECT MAX(`num`) as max_num FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['max_num'] + 1;
    }
    return $result;
  }

  function getStoreName($termName){
    switch($termName){
      case '6373':
        $storeName = "Stende";
      break;
      case '5940':
        $storeName = "Salacgrīva";      
      break;
      case '6342':
        $storeName = "Liepas AK";      
      break;
      case '6362':
        $storeName = "SGA Plus";      
      break;
      case '6379':
        $storeName = "G.Matroža kokzāģētava";      
      break;
      default:
        $storeName = "Noliktava";
      break;
    }
    
    $result = $this->getStoreId($storeName);
    
    return $result;
  }

  function getStoreId($storeName){
    $storeName = trim($storeName);
    $table_name_0 = "e_stores";
    $mysql_text = "SELECT `id` as store_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000' AND `title` LIKE '%$storeName%'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['store_id'];
    }
    
    if($result < 1){
      $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
      $mysql_query = mysql_query($mysql_text);
      while($mysql_arr = mysql_fetch_assoc($mysql_query)){
        $max_id = $mysql_arr['max_id'] + 1;
      }
    
      $mysql_text = "INSERT INTO `{$table_name_0}` (`workstation_id`,`id`,`title`) VALUES ('1000000',$max_id,'$storeName')";
      $mysql_query = mysql_query($mysql_text);
      $result = $max_id;
    }
    
    return $result;
  }

  function getMaxID(){
    $table_name_0 = "e_document";
    $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['max_id'] + 1;
    }
    return $result;
  }

  function getMaxBundleID(){
    $table_name_0 = "e_bundle";
    $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['max_id'] + 1;
    }
    return $result;
  }

  function getCompany($companyCode){
    switch($companyCode){
      case '21':
        $result = 1;
      break;
      case '144':
        $result = 2;
      break;
      case '64':
        $result = 3;
      break;
      case '133':
        $result = 4;
      break;
      case '154':
        $result = 5;
      break;
      case '121':
        $result = 6;
      break;
      default:
        $result = 0;
      break;
    }
    return $result;
  }

  function getTransport($autoName){
    $autoName = trim($autoName);
    $table_name_0 = "e_transport";
    $mysql_text = "SELECT `id` as auto_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000' AND `num` LIKE '%$autoName%'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['auto_id'];
    }
    
    if($result < 1){
      $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
      $mysql_query = mysql_query($mysql_text);
      while($mysql_arr = mysql_fetch_assoc($mysql_query)){
        $max_id = $mysql_arr['max_id'] + 1;
      }
    
      $mysql_text = "INSERT INTO `{$table_name_0}` (`workstation_id`,`id`,`num`,`typ`) VALUES ('1000000',$max_id,'$autoName','A')";
      $mysql_query = mysql_query($mysql_text);
      $result = $max_id;
    }
    
    return $result;
  }

  function getDriver($driverName){
    $driverName = trim($driverName);
    $driver_arr = explode(" ",$driverName);
    $Name = ucfirst($driver_arr[0]);
    $Surname = ucfirst($driver_arr[1]);
    $table_name_0 = "e_driver";
    $mysql_text = "SELECT `id` as driver_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000' AND `firstname` LIKE '%$Name%' AND `lastname` LIKE '%$Surname%'";
    $mysql_query = mysql_query($mysql_text);
    while($mysql_arr = mysql_fetch_assoc($mysql_query)){
      $result = $mysql_arr['driver_id'];
    }
    
    if($result < 1){
      $mysql_text = "SELECT MAX(`id`) as max_id FROM `{$table_name_0}` WHERE `workstation_id` LIKE '1000000'";
      $mysql_query = mysql_query($mysql_text);
      while($mysql_arr = mysql_fetch_assoc($mysql_query)){
        $max_id = $mysql_arr['max_id'] + 1;
      }
    
      $mysql_text = "INSERT INTO `{$table_name_0}` (`workstation_id`,`id`,`firstname`,`lastname`) VALUES ('1000000',$max_id,'$Name','$Surname')";
      $mysql_query = mysql_query($mysql_text);
      $result = $max_id;
    }
    
    return $result;
  }
}

?>