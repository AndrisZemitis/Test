<?
class cls_updPavadzimeData {

  function cls_updPavadzimeData(){
    global $prefix_name;
    global $_lv_finieris;
    global $modChange;
    $this->modChange = false;
    $this->_lv_finieris = false;
    $this->_osukalns = false;
    $this->prefix_name = "";
    $this->getAllPrefix();

    return false;
  }
  
  function getDataFromLVM(){
    return false;
  }
  
  function connToLVM(){
    return false;
  }

  function getAllPrefix(){
    global $arr_prefix;

    $getPrefix_txt = "SELECT `prefix_name` FROM `lietotaji_zagetavas`";
    $getPrefix = mysql_query($getPrefix_txt);
    while($getPrefix_arr = mysql_fetch_assoc($getPrefix)){
      $this->arr_prefix[] = $getPrefix_arr;
    }
    return true;
  }
  
  function updFromExistingData(){
//    $this->getAllPrefix();
    $arrPref = $this->arr_prefix;
    if(!$this->modChange){
      if($arrPref){
        $this->modChange = true;
        foreach ($arrPref as $item_tmp){
          $this->prefix_name = $item_tmp['prefix_name'];
          $this->updFromExistingData();
        }
      }
    }
    
    if($this->prefix_name == "latvijas_finieris_"){
      $this->_lv_finieris = true;      
    }

    if($this->prefix_name == "osukalni_"){
      $this->_osukalns = true;      
    }

    if($this->_osukalns){
    
    }
    
    $updCount = 0;
    
    if($this->_lv_finieris){
      $mysqlGetData_txt = "SELECT AVG(ROUND(`1_cilindra_garums`/10,0)) as lig_garums, `{$this->prefix_name}balkis`.`pavadzime` as pavadzimes_id, `iecirknis` as vieta FROM `{$this->prefix_name}balkis`  LEFT JOIN `{$this->prefix_name}pavadzime` ON `{$this->prefix_name}balkis`.`pavadzime` = `{$this->prefix_name}pavadzime`.`id` GROUP BY `{$this->prefix_name}balkis`.`pavadzime`";
      $mysqlGetData = mysql_query($mysqlGetData_txt);
      while($mysqlGetData_arr = mysql_fetch_assoc($mysqlGetData)){
        $insert_lig = $this->updPavadzime($mysqlGetData_arr['pavadzimes_id'],$mysqlGetData_arr['lig_garums'],$mysqlGetData_arr['vieta']);
        $updCount++;
      }
    }
    
    return $updCount;
  }

  function clearTempTables(){
//    $this->getAllPrefix();
    $arrPref = $this->arr_prefix;
    foreach ($arrPref as $item_tmp){
      $this->prefix_name = $item_tmp['prefix_name'];
      $queryUpdTables = "TRUNCATE TABLE `{$this->prefix_name}balkis_temp`";
      $updResultTrunc = mysql_query($queryUpdTables);
    }
    return true;
  }

  function updPavadzime($pvdz_id,$CompGar,$tmpVieta){
    if($this->prefix_name == "latvijas_finieris_"){  
      $updQuery_txt = "UPDATE `{$this->prefix_name}pavadzime` SET `cenu_matrica` = '{$this->getGarumaLigLF($CompGar,$tmpVieta)}' WHERE `id` = {$pvdz_id}";
      $updQuery = mysql_query($updQuery_txt);
    }
    return true;
  }

  function getGarumaLigLF($tmpGarums,$tmpVieta){
    $result = 'AA';

    if(trim($tmpVieta) == "FV"){
      $result = 'AC';
      if($tmpGarums > 210){
        $result = 'AD';
      }
    }else{
      if($tmpGarums > 180){
        $result = 'AB';
      }
    }
    
    return $result;
  }
  
  function getLigName($ligNum){
    switch($ligNum){
      case 'AA':
        $result = "Īskluči";
      break;
      case 'AC':
        $result = "Īskluči";
      break;
      case '3M':
        $result = "3.00 m";
      break;
      case 'AB':
        $result = "Finierkluči";
      break;
      case 'AD':
        $result = "Finierkluči";
      break;
      case 'VA':
        $result = "Līg. 2011";
      break;
      case 'LV':
        $result = "Līg. 2012";
      break;
      case 'LJ':
        $result = "Līg. 2012, 2. pusg.";
      break;
      case 'ST':
        $result = "Stāķi";
      break;
      case 'JP':
        $result = "Jēkabpils";
      break;
      case 'ML':
        $result = "Mainītas šķiras";
      break;
      case 'BK':
        $result = "Jāpārtaisa";
      break;
      default:
        $result = "Līgums";
      break;
    }
    return $result;
  }

}

class cls_slcFileCont extends cls_updPavadzimeData{

  function cls_slcFileCont(){
    $this->getAllPrefix();
    
    return false;
  }
  
  function slcBacthFile($header_tmp){
    $this->arr_prefix;
    $this->getCorrectIdPrefix($header_tmp);
    $prefix_name_local = $this->getPrefixFromTablebyId($header_tmp);
    
    $mysqlGetBatchList_txt = "SELECT DISTINCT(`{$prefix_name_local}batch_fails`.`id`) as file_id, `{$prefix_name_local}batch_fails`.`nosaukums` as file_name, `{$prefix_name_local}batch_fails`.`datums` as file_date, 
      `{$prefix_name_local}pavadzime`.`opcija` as waybill_opt,
      `{$prefix_name_local}pavadzime`.`cenu_matrica` as waybill_prcopt,
      `{$prefix_name_local}pavadzime`.`count_similar` as waybill_similar
      FROM `{$prefix_name_local}batch_fails` 
      LEFT JOIN `{$prefix_name_local}pavadzime` 
      ON (`{$prefix_name_local}batch_fails`.`id` = `{$prefix_name_local}pavadzime`.`batch_fails`) 
      WHERE `{$prefix_name_local}pavadzime`.`id` IS NOT NULL 
      GROUP BY `{$prefix_name_local}batch_fails`.`id`
      ORDER BY `{$prefix_name_local}batch_fails`.`id` DESC LIMIT 0,700";
    
    $mysqlGetBatchList = mysql_query($mysqlGetBatchList_txt);
    while($mysqlGetBatchList_arr = mysql_fetch_assoc($mysqlGetBatchList)){
      $result[] = $mysqlGetBatchList_arr;
    }
    
    $this->getRowCount($prefix_name_local);
    $this->getFailsPlaceFromTablebyId($header_tmp);
    return $result;
  }
  
  function slcPavadzimeFile(){
    return false;
  }

  function getRowCount($prefix_tmp){
    global $rowCount;
    $mysqlGetRowCount_txt = "SELECT `id` FROM `{$prefix_tmp}batch_fails`";
    $mysqlGetRowCount = mysql_query($mysqlGetRowCount_txt);
    $this->rowCount = mysql_num_rows($mysqlGetRowCount);
  }

  function getPrefixFromTablebyId($tmp_prefix_id){
    $mysqlGetPrefName_txt = "SELECT `prefix_name` FROM `lietotaji_zagetavas` WHERE `id` = {$tmp_prefix_id}";
    $mysqlGetPrefName = mysql_query($mysqlGetPrefName_txt);
    while($mysqlGetPrefName_arr = mysql_fetch_assoc($mysqlGetPrefName)){
      $result = $mysqlGetPrefName_arr['prefix_name'];
    }
    
    return $result;
  }

  function getFailsPlaceFromTablebyId($tmp_prefix_id){
    global $failsPlace;
    $mysqlGetFailsName_txt = "SELECT `batch_path` FROM `lietotaji_zagetavas` WHERE `id` = {$tmp_prefix_id}";
    $mysqlGetFailsName = mysql_query($mysqlGetFailsName_txt);
    while($mysqlGetFailsName_arr = mysql_fetch_assoc($mysqlGetFailsName)){
      $this->failsPlace = $mysqlGetFailsName_arr['batch_path'];
    }
  }

  function getMenuValues(){
    $result = array(
        26 => array('name' => 'Visi', 'report_id' => 1),
        27 => array('name' => 'SIA "Akrs"', 'report_id' => 7),
        33 => array('name' => 'SIA "AKZ"', 'report_id' => 18),
        28 => array('name' => 'SIA "BSW Latvia"', 'report_id' => 20),
        29 => array('name' => 'SIA "Gaujas Koks"', 'report_id' => 21),
        30 => array('name' => 'SIA "Inčukalns Timber"', 'report_id' => 11),
        31 => array('name' => 'SIA "Kurekss"', 'report_id' => 27),
        41 => array('name' => 'A/S "Latvijas Finieris"', 'report_id' => 26),
        47 => array('name' => 'SIA "Ošukalns"', 'report_id' => 29),
        34 => array('name' => 'SIA "Smiltene Impex"', 'report_id' => 23),
        39 => array('name' => 'A/S "Stora Enso Latvia"', 'report_id' => 25),
        51 => array('name' => 'SIA "Tezei-S"', 'report_id' => 16),
        37 => array('name' => 'A/S "Saldus MR"', 'report_id' => 24),
        45 => array('name' => 'SIA "Piebalgas"', 'report_id' => 28),
        35 => array('name' => 'SIA "Vika Wood"', 'report_id' => 2),
        36 => array('name' => 'SIA "Vudlande"', 'report_id' => 22),
        49 => array('name' => 'SIA "4 Plus"', 'report_id' => 33),
        55 => array('name' => 'SIA "Vārpas 1"', 'report_id' => 46),
        59 => array('name' => 'SIA "Jēkabpils MR"', 'report_id' => 55),
        61 => array('name' => 'SIA "Latvāņi"', 'report_id' => 54),
        63 => array('name' => 'SIA "Timberex Group"', 'report_id' => 51),
        57 => array('name' => 'SIA "Kubikmetrs"', 'report_id' => 19)
    );
    
    return $result;
  }
  
  function getCorrectIdPrefix(&$pref_id){
    switch($pref_id){
      case 26:
        $pref_id = 0;
      break;
      case 27:
        $pref_id = 0;
      break;
      case 28:
        $pref_id = 2;
      break;
      case 29:
        $pref_id = 3;
      break;
      case 30:
        $pref_id = 4;
      break;
      case 31:
        $pref_id = 11;
      break;
      case 33:
        $pref_id = 8;
      break;
      case 34:
        $pref_id = 5;
      break;
      case 35:
        $pref_id = 14;
      break;
      case 36:
        $pref_id = 6;
      break;
      case 37:
        $pref_id = 7;
      break;
      case 39:
        $pref_id = 9;
      break;
      case 41:
        $pref_id = 10;
      break;
      case 45:
        $pref_id = 12;
      break;
      case 47:
        $pref_id = 13;
      break;
      case 49:
        $pref_id = 15;
      break;
      case 51:
        $pref_id = 17;
      break;
      case 55:
        $pref_id = 32;
      break;
      case 57:
        $pref_id = 36;
      break;
      case 59:
        $pref_id = 39;
      break;
      case 61:
        $pref_id = 38;
      break;
      case 63:
        $pref_id = 41;
      break;
    }
  }

}

?>