<?
require_once ('menu.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/check_login.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/funkcijas.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');

ob_start();

if (isset($_POST['skatits_id'])){
	ieraksts_skatits_zagbalki($_POST['skatits_id']);
	unset($_POST['skatits_id']);
}

menu('clsKraujmers',$valoda);
$head_name = $_GET['h'];
//fb($loadData,'loadData');

if($_POST['labojuma_sadala'] == "update_record"){

  switch($head_name){
    case 'clsKraujmers':

      $tbl_upd_name = 't_h_kraujmers';

      $date_upload = $_POST['date_upload'];
      $darba_uzdevuma_num = $_POST['darba_uzdevuma_num'];
      $uzm_vieta = $_POST['uzm_vieta'];
      $buyer = $_POST['buyer'];
      $seller = $_POST['seller'];
      $reciever = $_POST['reciever'];
      $transport = $_POST['transport'];
      $driver = $_POST['driver'];
      $login_name = $_POST['login_name'];
      $id = $_POST['id'];

      $mysql_update_txt = "UPDATE `{$tbl_upd_name}` 
                            SET `date_upload` = '{$date_upload}', 
                            `darba_uzdevuma_num` = '{$darba_uzdevuma_num}', 
                            `uzm_vieta` = '{$uzm_vieta}', 
                            `buyer` = '{$buyer}', 
                            `seller` = '{$seller}', 
                            `reciever` = '{$reciever}', 
                            `transport` = '{$transport}', 
                            `driver` = '{$driver}', 
                            `login_name` = '{$login_name}' 
                            WHERE `id` = {$id}";
    break;
    case 'clsKraujmersDati':
    
      $tbl_upd_name = 't_b_kraujmers';
    
      $ts = $_POST['ts'];
      $mernieks = $_POST['mernieks'];
      $gredas_numurs = $_POST['gredas_numurs'];
      $sortimenta_kods = $_POST['sortimenta_kods'];
      $suga_1_kods = $_POST['suga_1_kods'];
      $suga_1_proc = $_POST['suga_1_proc'];
      $suga_2_kods = $_POST['suga_2_kods'];
      $suga_2_proc = $_POST['suga_2_proc'];
      $suga_3_kods = $_POST['suga_3_kods'];
      $suga_3_proc = $_POST['suga_3_proc'];
      $garums = $_POST['garums'];
      $augstums_vid = $_POST['augstums_vid'];
      $platums_vid = $_POST['platums_vid'];
      $tilp_koef = $_POST['tilp_koef'];
      $braka_kods = $_POST['braka_kods'];
      $braka_proc = $_POST['braka_proc'];
      
      $id = $_POST['id'];

      $mysql_update_txt = "UPDATE `{$tbl_upd_name}` 
                            SET `ts` = '{$ts}', 
                            `mernieks` = '{$mernieks}', 
                            `gredas_numurs` = '{$gredas_numurs}', 
                            `sortimenta_kods` = '{$sortimenta_kods}', 
                            `suga_1_kods` = '{$suga_1_kods}', 
                            `suga_1_proc` = '{$suga_1_proc}', 
                            `suga_2_kods` = '{$suga_2_kods}', 
                            `suga_2_proc` = '{$suga_2_proc}', 
                            `suga_3_kods` = '{$suga_3_kods}', 
                            `suga_3_proc` = '{$suga_3_proc}',
                            `garums` = '{$garums}', 
                            `augstums_vid` = '{$augstums_vid}', 
                            `platums_vid` = '{$platums_vid}', 
                            `platums_vid` = '{$platums_vid}', 
                            `tilp_koef` = '{$tilp_koef}', 
                            `braka_kods` = '{$braka_kods}', 
                            `braka_proc` = '{$braka_proc}' 
                            WHERE `id` = {$id}";
    break;
  }

  $mysql_query_update = mysql_query($mysql_update_txt);
}

$loadData = new loadDataForSymbol();
$rowCount = 1;

?>

<html>
  <head>
    <title>Plaukstdators</title>
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <script type="text/javascript" src="../jQuery/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="../jQuery/snowfall.jquery.js"></script>
    <script type="text/javascript" src="../jQuery/ui/jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="../jQuery/ui/ui.core.js"></script>
    <script type="text/javascript" src="../jQuery/ui/ui.datepicker.js"></script>
    <script type="text/javascript" src="../jQuery/ui/ui.multiselect.js"></script>
    <script type="text/javascript" src="../jQuery/ui/plugins/localisation/jquery.localisation-min.js"></script>
    <script type="text/javascript" src="../jQuery/ui/plugins/scrollTo/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="../js_jquery/exTransfTable.js"></script>
    <link type="text/css" href="../jQuery/demos/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
    <link type="text/css" href="../jQuery/themes/custom-theme/ui.multiselect.css" rel="stylesheet" />
    <link type="text/css" href="../jQuery/themes/custom-theme/common_multi_select.css" rel="stylesheet" />

    <script type="text/javascript">
//-------------------------------------------------------------------------
      function exportResult(export_id){
        
       var dataString = 'export_id='+ export_id;
       var stringTag = '#'+ export_id;
       $.ajax({
         type: "POST",  
         url: "clsExpResult.php",  
         data: dataString,  
         success: function() {
          $(stringTag).html("&nbsp;");
         }
       });  
       return false;      
      }

//-------------------------------------------------------------------------      
    </script>
    
  </head>
<body >
<?

class loadDataForSymbol {
  function loadDataForSymbol(){
    global $data_structure;
    $this->getTranslation();
    $tmp_head = $_GET['h'];
    switch($tmp_head){
      case 'clsKraujmers';
        $this->loadKraujmersHead();
      break;
      case 'clsKraujmersDati';
        $this->loadKraujmersBody();
      break;

    }
    
    return false;
  }
  
  function loadKraujmersHead(){
    $tmp_table = "t_h_kraujmers";
    $labojuma_id = 0;
    $labojuma_id = $_POST['labojuma_id'];
    $where_state = "";
    if($labojuma_id > 0){$where_state = " AND `id` = {$labojuma_id}";}
    $mysql_query_txt = "SELECT `id`, `date_upload`, `darba_uzdevuma_num`, `uzm_vieta`, `buyer`, `seller`, `reciever`, `transport`, `driver` FROM `{$tmp_table}` WHERE `opcija` = 'A' {$where_state} ORDER BY `id` DESC";
    $mysql_query = mysql_query($mysql_query_txt);
    while($mysql_query_arr = mysql_fetch_assoc($mysql_query)){
      $this->data_structure['data_body'][] = $mysql_query_arr;
    }
    $this->data_structure['data_head'] = array(0 => 'Nr.', 1 => 'Fails ielasīts', 2 => 'Darba uzd. nr.', 3 => 'Uzm. vieta', 
                                                4 => 'Pircējs', 5 => 'Pārdevējs' , 6 => 'Saņēmējs', 7 => 'Transports', 8 => 'Šoferis', 
                                                10 => 'Skatījums', 11 => 'Iespējas');
  }

  function loadKraujmersBody(){
    $merijuma_id = $_GET['darba_id'];
    $tmp_table = "t_b_kraujmers";
    $labojuma_id = 0;
    $labojuma_id = $_POST['labojuma_id'];
    $where_state = "";
    if($labojuma_id > 0){$where_state = " AND `id` = {$labojuma_id}";}
    $mysql_query_txt = "SELECT `id`, `ts`, `mernieks`, `gredas_numurs`, `sortimenta_kods`, `suga_1_kods`, 
                        `suga_1_proc`, `suga_2_kods`, `suga_2_proc`, `suga_3_kods`, `suga_3_proc`, 
                        `garums`, `augstums_vid`, `platums_vid`, `tilp_koef`, `braka_kods`, `braka_proc` 
                        FROM `{$tmp_table}` WHERE `opcija` = 'A' AND `t_h_id` = {$merijuma_id} {$where_state} ORDER BY `id` DESC";
    $mysql_query = mysql_query($mysql_query_txt);
    while($mysql_query_arr = mysql_fetch_assoc($mysql_query)){
      $this->data_structure['data_body'][] = $mysql_query_arr;
    }
    $this->data_structure['data_head'] = array(0 => 'Nr.', 1 => 'Datums', 2 => 'Mērnieks', 3 => 'Grēdas nr.',4 => 'Sortimenta kods', 
                                                5 => '1.suga', 6 => '1.suga (%)', 7 => '2.suga', 8 => '2.suga (%)', 9 => '3.suga', 10 => '3.suga (%)', 
                                                11 => 'Garums', 13 => 'Augstums', 14 => 'Platums', 15 => 'Koef.', 16 => 'Brāķa kods', 
                                                17 => 'Brāķis (%)', 18 => 'Iespējas');
  }
  
  function getTranslation(){
    global $translation;
    $this->translation['ts'] = "Datums";
    $this->translation['mernieks'] = "Mērnieks";
    $this->translation['gredas_numurs'] = "Grēdas nr.";
    $this->translation['sortimenta_kods'] = "Sortimenta kods";
    $this->translation['suga_1_kods'] = "1.suga";
    $this->translation['suga_1_proc'] = "1.suga (%)";
    $this->translation['suga_2_kods'] = "2.suga";
    $this->translation['suga_2_proc'] = "2.suga (%)";
    $this->translation['suga_3_kods'] = "3.suga";
    $this->translation['suga_3_proc'] = "3.suga (%)";
    $this->translation['garums'] = "Garums";
    $this->translation['augstums_vid'] = "Augstums";
    $this->translation['platums_vid'] = "Platums";
    $this->translation['tilp_koef'] = "Koef.";
    $this->translation['braka_kods'] = "Brāķa kods";
    $this->translation['braka_proc'] = "Brāķis (%)";

    $this->translation['id'] = "Identifikators";
    $this->translation['date_upload'] = "Datums";
    $this->translation['uzm_vieta'] = "Uzm. vieta";
    $this->translation['buyer'] = "Pircējs";
    $this->translation['seller'] = "Pārdevējs";
    $this->translation['reciever'] = "Saņēmējs";
    $this->translation['transport'] = "Transports";
    $this->translation['driver'] = "Šoferis";
    $this->translation['login_name'] = "Lietotājs";
    $this->translation['darba_uzdevuma_num'] = "Darba uzd. nr.";
  }
  
  function updatedStatus($id){
    $updated_status_text = "SELECT `eksporta_datums` FROM `t_h_kraujmers` WHERE `id` = {$id}";
    $updated_status_query = mysql_query($updated_status_text);
    while($updated_status_arr = mysql_fetch_assoc($updated_status_query)){
      $date_update = $updated_status_arr['eksporta_datums'];
    }
    
    $result = 0;
    if($date_update != '0000-00-00 00:00:00'){
      $result = 1;
    }
    
    return $result;
  }
}

function dateFormatChange($date_tmp){
  $date_arr = explode(' ',$date_tmp);
  $date_result = substr($date_arr[0],6,4).'-'.substr($date_arr[0],3,2).'-'.substr($date_arr[0],0,2).' '.$date_arr[1];
  return $date_result;
}

?>

<? if($_POST['labojuma_id']){ ?>
<form name="update_record" method="POST">
  <table cellspacing=1 cellpadding=0 border=0 align=center>
    <? foreach($loadData->data_structure['data_body'][0] as $item_key => $item_tmp){ ?>
    <tr>
      <td><?=$loadData->translation[$item_key]?></td><td><input size=20 name=<?=$item_key?> value="<?=$item_tmp?>" <? if($item_key == 'id'){ ?>readonly=readonly<? } ?>></td>
    </tr>
    <? } ?>
    <tr><td><br /></td></tr>
    <tr bgcolor="#CCFFCC">
      <td colspan=2 align=center><a href="#" onClick="document.update_record.submit();return false;"><b>Saglabāt datus</b></a></td>
    </tr>
  </table>
<input type=hidden name="labojuma_sadala" value="update_record">
</form>
<?}else{?>
  <table cellspacing=1 cellpadding=0 border=0 align=center>
    <tr bgcolor="CCFFCC">
    <? foreach($loadData->data_structure['data_head'] as $tmp_head){ ?>
      <td align=center>
        &nbsp;&nbsp;<font size="2"><?=$tmp_head?></font>
      </td>
    <? } ?>
    </tr>

  <? 
  foreach($loadData->data_structure['data_body'] as $tmp_body){
    if ($color == '#E1E1E1'){$color = '#FFFFFF';}else{$color = '#E1E1E1';}
  //	if ($m['skatits'] == 0){$color='#FFCCCC';}
    
   ?>
    <tr bgcolor='<?=$color?>'>
      <td align=center>&nbsp;&nbsp;<?=$rowCount?></td>
      <? foreach($tmp_body as $key => $body_item){ if($key != 'id' && $key != 'eksporta_datums'){ ?>
        <?if($head_name == 'clsKraujmers'){?>
          <td align=center>&nbsp;&nbsp;<a href="clsKraujmers.php?h=clsKraujmersDati&darba_id=<?=$tmp_body['id']?>"><?=$body_item?></a></td>
        <?}else{?>
          <td align=center>&nbsp;&nbsp;<?=$body_item?></td>
        <? } ?>
      <? } } ?>
      <td align=center>&nbsp;&nbsp;<a href="clsKraujmers.php?h=clsKraujmers" onclick="form_edit.labojuma_id.value=<?=$tmp_body['id']?>;form_edit.submit();return false;">Labot</a></td>
      <?
      $updated = $loadData->updatedStatus($tmp_body['id']);
      if($head_name == 'clsKraujmers' && $updated == 0){?>
        <td id="<?=$tmp_body['id']?>" align=center>&nbsp;&nbsp;<a href="#" onclick="exportResult(<?=$tmp_body['id']?>);">Eksportēt</a></td>
      <? }elseif($head_name == 'clsKraujmers'){ ?>
        <td align=center>&nbsp;&nbsp;</td>
      <? } ?>
    </tr>
    <? $rowCount++;} ?>
  </table>
<? } ?>
<form name="form_edit" method="POST">
  <input type="hidden" name="labojuma_id">
</form>
</body>
</html>