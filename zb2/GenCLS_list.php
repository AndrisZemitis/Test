<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/zb2/db.inc.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/check_login.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/zb2/GenCLS_update.php');

if ($mlietotajs['g_report']!='Y') return;
ob_start();

$getDataList = new cls_slcFileCont();
menu($_GET['h']);
$tmp_header = $_GET['h'];
$report_id = $_GET['report_id'];

if($tmp_header == 2){

  $menuSelectItem = $getDataList->getMenuValues();
  ?>
  <style>
  .normal {color:white; font-family:arial; size:12pt; text-decoration: none;}
  .normal:hover {color:yellow; font-family:arial; size:12pt; text-decoration: none;}
  .head {color:white; size:24pt; font-weight:bold;}
  </style>
  <html>
    <head>
      <title>VMF</title>
    </head>
  <body>
    <table cellspacing=0 cellpadding=0 border=0 width=300 align=center>
      <? foreach($menuSelectItem as $tmp_key => $tmp_item_menu){?>
      <tr><td bgcolor=#336633 align=center><a href="GenCLS_list.php?h=<?=$tmp_key?>&report_id=<?=$tmp_item_menu['report_id']?>" class="normal"><?=$tmp_item_menu['name']?></a></td></tr>
      <tr><td bgcolor=white align=center>&nbsp;</td></tr>
      <? } ?>          
    </table>
  <?
}else{

  $getParams_tmp = $getDataList->slcBacthFile($tmp_header);
  $getCount = $getDataList->rowCount;
  $nosaukums_dir = $getDataList->failsPlace;

  if($_POST['komanda'] == 'update'){
    $id = $_POST['ident'];
    $qry_UpdateDel = "UPDATE `{$pavadzimes_tabula}` SET `opcija` = 'D' WHERE `batch_fails` = {$ident}";
    mysql_query($qry_UpdateDel);
  }

  ?>
  <body>
  <center>
    <table border=1 cellspacing=0 cellpadding=2>
    <tr align=center><td colspan=6><b>Baļķu skaits: <?=$getCount?></b></td></tr>
    <tr  bgcolor=#7EBF7E>
      <th>&nbsp;ID&nbsp;</th>
      <th>&nbsp;Nosaukums&nbsp;</th>
      <th>&nbsp;Ielasīts&nbsp;</th>
      <th>&nbsp;Līgums&nbsp;</th>
      <th>&nbsp;Fails&nbsp;</th>
      <th>&nbsp;Darbība&nbsp;</th>
    </tr>
    <?

  if ($getParams_tmp)
  {

    foreach($getParams_tmp as $arr_tmp){
      $fails_final = $arr_tmp['file_name'];
      $fails = str_replace(" ","%20",$fails_final);
                
      $krasa = 'bgcolor="#FFFFFF"';
      if($arr_tmp['waybill_similar'] > 0){$krasa = 'bgcolor="#F09999"';}
      if($arr_tmp['waybill_opt'] == 'D'){$krasa = 'bgcolor="#66CCFF"';}
      if($arr_tmp['waybill_opt'] == 'L'){$krasa = 'bgcolor="#66FF66"';}

      if(trim($arr_tmp['waybill_prcopt']) == "VA" && $arr_tmp['file_id'] > 17211){
        $krasa = 'bgcolor="#CCCCCC"';
      }

      if(trim($arr_tmp['waybill_prcopt']) == "3M"){
        $krasa = 'bgcolor="#66FF66"';
      }

      if(trim($arr_tmp['waybill_prcopt']) == "BK"){
        $krasa = 'bgcolor="#66FF66"';
      }

      if(trim($arr_tmp['waybill_prcopt']) == "LJ"){
        $krasa = 'bgcolor="#66FF66"';
      }

      if(trim($arr_tmp['waybill_prcopt']) == "J3"){
        $krasa = 'bgcolor="#66FF66"';
      }
      
       ?>
       
       <tr <?=$krasa?>>
       <td align=center><?=$arr_tmp['file_id']?></td>
       <td align=center><a href=pavadzime_list.php?fails=<?=$arr_tmp['file_id']?>&h=<?=$tmp_header?>&report_id=<?=$report_id?>><?=$arr_tmp['file_name']?></a></td>
       <td align=center><?=$arr_tmp['file_date']?></td>
       <td align=center><?=$getDataList->getLigName($arr_tmp['waybill_prcopt'])?></td>
       <td>
       <?
        if (file_exists("/home/vmf/htdocs/batch/batch_all/".$nosaukums_dir."/".$fails."")) {
           echo "&nbsp;&nbsp;<a href=/../batch/client/batch_all/".$fails.">Fails</a>"; //Ja failu augšuplādējis admins, tad fails ir kopējā folderī
        } else {
           echo "&nbsp;&nbsp;<a href=/../batch/client/".$nosaukums_dir."/".$fails.">Fails</a>";
        } 
       ?>
       </td>
       <td>&nbsp;<a href="#" onclick="darbiba.komanda.value='update';darbiba.ident.value=<?=$arr_tmp['file_id']?>;darbiba.submit();return false;">Dzēst failu</a></td>
      </tr>
    <? } ?>
  </table>
  <? } ?>

  <form name=darbiba method=POST action="batch_list.php?h=<?=$tmp_header?>">
    <input type=hidden name=komanda>
    <input type=hidden name=ident>
  </form>
  </center>
<?}?>
  </body>
</html>