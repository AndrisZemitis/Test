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
</HEAD>
<BODY >
<?

if (isset($_POST['skatits_id']))
	{
	ieraksts_skatits_zagbalki($_POST['skatits_id']);
	unset($_POST['skatits_id']);
	}

menu('zagbalki',$valoda);

$r = mysql_query(" select * from zagbalki order by id DESC ");
?>

<table cellspacing=1 cellpadding=0 border=0 align=center>
<tr bgcolor="CCFFCC">
	<td align=center>
		&nbsp;&nbsp;<font size="2">Pasūtītājs</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Piegādātājs</font>
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
		&nbsp;&nbsp;<font size="2">Pas_nos</font>
	</td>
	<td align=center>
		&nbsp;&nbsp;<font size="2">Started</font>
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
//$color = '#E1E1E1';
while ($m = mysql_fetch_array($r))
{
	if ($color == '#E1E1E1')
	$color = '#FFFFFF';
	else
	$color = '#E1E1E1';
	if ($m['skatits'] == 0)
		$color='#FFCCCC';
 ?>
	<tr bgcolor='<?=$color?>'>
		<td align=center>
			&nbsp;&nbsp;<?=$m['pasutitajs']?>
		</td>
		<td align=center>
			&nbsp;&nbsp;<?=$m['piegadatajs']?>
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
			&nbsp;&nbsp;<?=$m['pas_nos']?>
		</td>
		<td align=center>
			&nbsp;<?=$m['started']?>
		</td>
		<td align=center>
			<? if (file_exists("documents/".$m['pasnr']."zb.dat")) {
			   echo "&nbsp;&nbsp;<a href=documents/".$m['pasnr']."zb.dat>Fails</a>";
			} else {
			   echo "&nbsp;&nbsp;<a href=documents/".$m['pasnr'].".dat>Fails</a>";
			} ?>
		
		</td>
		<td align=center>
			&nbsp;&nbsp;<a href="zagbalki_merijumi.php?darba_id=<?=$m['id']?>">Mērījumi</a>
		</td>
    <td align=center>
         <?
         if ($m['skatits'] == 0){?>&nbsp;&nbsp;<a href="#" onclick="document.getElementById('skatits_id').value='<?=$m['id']?>';document.getElementById('form_sk').submit();">Skatīt</a><?}?>
    </td>
	</tr><?
} ?>
</table>
<form name="form_sk" method="POST" id="form_sk">
<input type="hidden" name="skatits_id" id="skatits_id">
</form>

<?
function ieraksts_skatits_zagbalki($skatits_id){
  $tmpSQL_txt = "SELECT * FROM `zagbalki` WHERE `id` = {$skatits_id}";
  $tmpSQL = mysql_query($tmpSQL_txt);
  while($tmpSQL_arr = mysql_fetch_assoc($tmpSQL)){
    $tmp_kontrolmernieks = $tmpSQL_arr['kontrolmernieks'];
    $tmp_datums_sakums = dateFormatChange($tmpSQL_arr['started']);
    $tmp_pasutitajs = changeReciever($tmpSQL_arr['pasutitajs'],$tmpSQL_arr['viet_kods']);
    $tmp_piegadatajs = $tmpSQL_arr['piegadatajs'];
    $tmp_uzm_vieta = $tmpSQL_arr['viet_kods'];
    
    $tmp_pasut_nr = $tmpSQL_arr['pasnr'];
    
    $tmpSQL_data_txt = "SELECT * FROM `zagbalki_merijumi` WHERE `zagbalki_id` = {$skatits_id}";
    $tmpSQL_data = mysql_query($tmpSQL_data_txt);
    while($tmpSQL_data_arr = mysql_fetch_assoc($tmpSQL_data)){
      $rowIsTrue = true;
      $tmp_mernieks = $tmpSQL_data_arr['pg'];
      $tmp_balka_nr = $tmpSQL_data_arr['nr'];
      $tmp_suga = $tmpSQL_data_arr['sg'];
      $tmp_skira = $tmpSQL_data_arr['sk'];
      $tmp_miza = $tmpSQL_data_arr['mt'];
      $tmp_diam_tievgalis = $tmpSQL_data_arr['tc'];
      $tmp_diam_vidus = $tmpSQL_data_arr['vc'];
      $tmp_diam_resgalis = $tmpSQL_data_arr['rcc'];
      $tmp_garums = $tmpSQL_data_arr['gr'];
      $tmp_redukcija_diam = $tmpSQL_data_arr['rg'];
      $tmp_redukcija_gar = $tmpSQL_data_arr['rc'];
      $tmp_brakis = $tmpSQL_data_arr['im'];
      $tmp_kb_numurs = $tmpSQL_data_arr['kb'];
      $tmp_ts = dateFormatChange($tmpSQL_data_arr['ts']);
      $tmp_te = dateFormatChange($tmpSQL_data_arr['te']);

      if($tmpSQL_arr['pasutitajs'] == '42'){
        $tmp_diam_resgalis = 0;
      }

      if($tmpSQL_arr['pasutitajs'] == '25'){
        $tmp_diam_resgalis = 0;
      }

      if($tmp_brakis === 'NULL'){$tmp_brakis = "";}
      if($tmp_kb_numurs === 'NULL'){$tmp_kb_numurs = "";}

      if($tmp_diam_vidus < 1 && $tmp_diam_tievgalis < 1 && $tmp_diam_resgalis < 1 && $tmp_mernieks < 1){
        $rowIsTrue = false;
      }
    
      $tmpSQL_insert_txt = "INSERT INTO `kontrol_zagbalki` (`datums_sakums`, `kontrolmernieks`, `mernieks`, `pasutitajs`, `piegadatajs`, 
                            `uzm_vieta`, `pasut_nr`, `balka_nr`, `suga`, `skira`, `miza`, `diam_tievgalis`, `diam_vidus`, `diam_resgalis`, 
                            `garums`, `redukcija_diam`, `redukcija_gar`, `brakis`, `kb_numurs`,`ts`,`te`) 
                            VALUES ('$tmp_datums_sakums','$tmp_kontrolmernieks','$tmp_mernieks','$tmp_pasutitajs','$tmp_piegadatajs','$tmp_uzm_vieta',
                            '$tmp_pasut_nr','$tmp_balka_nr','$tmp_suga','$tmp_skira','$tmp_miza','$tmp_diam_tievgalis','$tmp_diam_vidus','$tmp_diam_resgalis',
                            '$tmp_garums','$tmp_redukcija_diam','$tmp_redukcija_gar','$tmp_brakis','$tmp_kb_numurs','$tmp_ts','$tmp_te')";
      //echo $tmpSQL_insert_txt;
      if($rowIsTrue){
        if (!mysql_query($tmpSQL_insert_txt)) {
            $tmp_SendMySQLError = 'Kļūda DB izpildē: [#7000001]['.mysql_errno().'] 
            '.mysql_error().'
            DB Query: '.$tmpSQL_insert_txt;
            snd_GlobalMailErr($tmp_SendMySQLError);
         return false;
        }
      }
    }
  }
  
	$result = mysql_query("UPDATE `zagbalki` SET skatits=1 WHERE id=".$skatits_id."") or die(mysql_error()) ;
	return true;
	}
	
function dateFormatChange($date_tmp){
  $date_arr = explode(' ',$date_tmp);
  $date_result = substr($date_arr[0],6,4).'-'.substr($date_arr[0],3,2).'-'.substr($date_arr[0],0,2).' '.$date_arr[1];
  return $date_result;
}

function changeReciever($firm_name, $place_num){
  $result = $firm_name;
  if($place_num == 6322){
    $result = 1197;
  }
  return $result;
}

function snd_GlobalMailErrRep($mail_body,$tmp_variable = 0){
// Funkcija nosūta kļūdas paziņojumu uz e-pastu.
// #0000006

    if (!$mail_body) {
      $mail_body = iconv("UTF-8","Windows-1257","Tukša ziņa!");
    }

//    $usr_Data = get_UsrData($type_id);
    $usr_Data = "Sistēma";

    $msg_error=
    "Sistēma:   " . $_SERVER['SERVER_NAME'] . "\r\n" .
    "Links:     " . $_SERVER['HTTP_REFERER'] . "\r\n" .
    "IP:        " . $_SERVER['REMOTE_ADDR'] . "\r\n" .
    "Lietotājs: " . $usr_Data . "\r\n" .
    "Laiks:     " . Date('m/d/Y H:i:s') . "\r\n" .
    "Fails:     " . $_SERVER['PHP_SELF'] . "\r\n" .
    "Kļūda:     " . $mail_body ."\r\n\r\n";

    $msg_error = iconv("UTF-8","Windows-1257",$msg_error);
        
    $Name = iconv("UTF-8","Windows-1257","VMF LATVIA Sistēma");
    $email = "vmf"; 
    $recipient = "prokofjevs@vmf.lv";
//    $cc = "Cc:prokofjevs@vmf.lv";
    $subject = iconv("UTF-8","Windows-1257","Sistēmas paziņojums!");
    $header = "From: ". $Name . " <" . $email . ">\r\n". $cc. "\r\n";

    mail($recipient, $subject, $msg_error, $header);

}

?>