<script type="text/javascript">
  function checkUncheckAll(checkAllState, cbGroup)
  {
    for (i = 0; i < cbGroup.length; i++){
      cbGroup[i].checked = checkAllState.checked;
    }
  }

  function anyCheck(form) {
  var total = '';
  var max = form.chkList.length;
    for (var idx = 0; idx < max; idx++) {
      if (eval("document.form1.chkList[" + idx + "].checked") == true) {
        total +=document.form1.chkList[idx].value + ","
      }
    }
    return total;
  }
</script>

<?
 include ('db.inc.php');
 include ("../check_login.php");
 include '../funkcijas.php';
 if ($mlietotajs['g_report']!='Y') return;

menu($_GET['h']);
$h = $_GET['h'];

// workstation id
global $mlietotajs;

$SortDouble = $_POST['sort_double'];
$a_veids = $_POST['a_veids'];
$piegadatajs = $_POST['piegade'];
$registrator = $_POST['registrator'];

$ID_arr = explode(",",substr($_POST['id'],0,-1));

if ($_POST['komanda'] == 'delete')
{
	$id = $_POST['id'];
  $query_del = "update g_registrs SET opcija = 'D' where id = $id";
	mysql_query($query_del);
}elseif($_POST['komanda'] == 'deleteSelected'){
  foreach($ID_arr as $ID_del){
    $query_del = "update g_registrs SET opcija = 'D' where id = $ID_del";
    mysql_query($query_del);
  }
}

?>
<center>
<form name=form1 method=POST>
<table>
		<tr>
			<td>Atskaites veids</td>
			<td>
				<select name=a_veids>
					<? $rw = mysql_query("SELECT DISTINCT(atskaites_veids) FROM g_registrs");?>
					<option value="0">-- visi --</option>
					<? while ($mw=mysql_fetch_array($rw)) { ?>
					   <option value="<?=$mw['atskaites_veids']?>"
          <? if ($a_veids==$mw['atskaites_veids']) echo ' selected ';?>
          ><?=$mw['atskaites_veids']?></option><? } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Piegādātājs</td>
			<td>
				<select name=piegade>
					<? $rw = mysql_query("SELECT DISTINCT(piegadatajs) FROM g_registrs");?>
					<option value="0">-- visi --</option>
					<? while ($mw=mysql_fetch_array($rw)) { ?>
					   <option value="<?=$mw['piegadatajs']?>"
          <? if ($piegadatajs==$mw['piegadatajs']) echo ' selected ';?>
          ><?=getPiegadatajs($mw['piegadatajs'])?></option><? } ?>
				</select>
			</td>
		</tr>
		<tr>
               <td>Datums no:</td>
               <td><input name=date_from value="<?=$date_from?>"><font size='1'>(piem. 01/01/2007)</font></td>
		</tr>
		<tr>
               <td>Datums lidz:</td>
               <td><input name=date_to value="<?=$date_to?>"><font size='1'>(piem. 01/01/2007)</font></td>
		</tr>
  		<tr>
			<td>Vieta:</td>
			<td>
				<select name=vieta>
					<?
					$zw = mysql_query("SELECT DISTINCT(vieta) FROM g_registrs");
					?><option value="0">- visi -</option><?
					while ($tw=mysql_fetch_array($zw)){
						?><option value="<?=$tw['vieta']?>"
						<? if (($vieta == $tw['vieta'])  && ($vieta != '')) echo ' selected ';?>
						><?=$tw['vieta']?></option><?
					}
					?>
				</select>
			</td>
		</tr>		

  		<tr>
			<td>Reģistrēja:</td>
			<td>
				<select name=registrator>
					<?
					$rw = mysql_query("SELECT DISTINCT(lietotajs_veidoja) FROM g_registrs");
					?><option value="0">- visi -</option><?
					while ($mw=mysql_fetch_array($rw))
					{
						?><option value="<?=$mw['lietotajs_veidoja']?>"
						<? if ($registrator==$mw['lietotajs_veidoja']) echo ' selected ';?>
						><?=atskaiti_veidoja($mw['lietotajs_veidoja'])?></option><?
					}
					?>
				</select>
			</td>
		</tr>		
  	<tr>
			<td>Meklēt dubplētos ierakstus:</td>
			<td><input type="checkbox" name="sort_double" <?if($SortDouble=="on"){?> checked<?}?>></td>
		</tr>		
		<tr>
			<td></td>
			<td>
				<input name="button" type=submit value="Parādīt">			
			</td>
		</tr>
	</table>
<?

$where = " 1=1 ";

if ($a_veids!= '0') {
	$where = $where." and atskaites_veids = "."'".$a_veids."'";
}

if ($piegadatajs!= '0') {
	$where = $where." and piegadatajs = $piegadatajs";
}

if ($registrator!= 0) {
	$where = $where." and lietotajs_veidoja = "."'".$registrator."'";
}
if ($vieta != '0' && $vieta != '') {
	$where = $where." and vieta = "."'".$vieta."'";
}
if ($date_from!=0){
	$where = $where." and datums_uzmer >= '".sqldate(datums($date_from))." 00:00'";
}
if ($date_to!=0){
	$where = $where." and datums_uzmer <= '".sqldate(datums($date_to))." 23:59'";
}

$query = "SELECT * FROM g_registrs WHERE ".$where." AND opcija != 'D' ORDER BY id ASC";

if ($SortDouble === "on"){
     $sub_query = "SELECT pavadzime FROM g_registrs WHERE ".$where." AND opcija != 'D' GROUP BY pavadzime having count(pavadzime)> 1"; 
     $sub_query_SQL = mysql_query($sub_query);
     while($sub_query_temps = mysql_fetch_assoc($sub_query_SQL)) { $sub_query_temp []= $sub_query_temps; }
}

?>
<table border="0" align="center">
<font size="10">
<tr bgcolor=CCFFCC>
		<td align="center">ID</td>
		<td align="center">Atskaites veids</td>
		<td align="center">Akta nr.</td>
		<td align="center">Pavadzime</td>
		<td align="center">Sortiments</td>
		<td align="center">Šoferis</td>
		<td align="center">Auto</td>
		<td align="center">Vieta</td>
		<td align="center">Datums</td>
		<td align="center">Skaits kopā</td>
		<td align="center">Bruto m3</td>
		<td align="center">Neto m3</td>
		<td align="center">Virsmērs m3</td>
		<td align="center">Redukcija</td>
		<td align="center">Brāķis m3</td>
		<td align="center">Brāķa %</td>
		<td align="center">Reģistrēja</td>
		<td align="center">Atzīmēt</td>
		<td align="center">Darbības</td>
	</tr><?
	$color = "#FFFFFF";
	if($SortDouble === 'on'){
	foreach($sub_query_temp as $pavadzime_temp){
    $query = "SELECT * FROM g_registrs WHERE opcija != 'D' AND pavadzime = "."'".$pavadzime_temp['pavadzime']."'";

  $r=mysql_query($query);
	
	while ($m=mysql_fetch_array($r))
	{
          if((braka_procents($m['brakis'],$m['bruto'])) >= 4){ $color="#ffcccc";}
	 ?>
          <tr bgcolor="<?=$color?>">
               <? if ($color=="#FFFFFF"){ $color = "#EEEEEE";} else { $color = "#FFFFFF";} ?>
               <td align="center"><?=$m['id']?></td>
               <td align="center"><?=$m['atskaites_veids']?></td>
               <td align="center"><?=$m['akta_nr']?></td>
               <td align="center"><?=$m['pavadzime']?></td>
               <td align="center"><?=$m['sortiments']?></td>
               <td align="center"><?=$m['soferis']?></td>
               <td align="center"><?=$m['auto_nr']?></td>
               <td align="center"><?=$m['vieta']?></td>
               <td align="center"><?=str_replace('-','.',$m['datums_uzmer'])?></td>
               <td align="center"><?=$m['skaits_kopa']?></td>
               <td align="center"><?=$m['bruto']?></td>
               <td align="center"><?=$m['neto']?></td>
               <td align="center"><?=$m['virsmers']?></td>
               <td align="center"><?=$m['redukcija']?></td>
               <td align="center"><?=$m['brakis']?></td>
               <td align="center"><?=braka_procents($m['brakis'],$m['bruto'])?></td>
               <td align="center"><?=atskaiti_veidoja($m['lietotajs_veidoja'])?></td>
               <td align="center"><input type="checkbox" id="<?=$m['id']?>" name="chkList" value="<?=$m['id']?>"></td>
               <td align="center"><a href="datu_registrs.php?h=43" onclick="if (confirm('Dzēst?')) 
                    {
                         nodot.a_veids.value = document.form1.a_veids.options[document.form1.a_veids.options.selectedIndex].value;
                         nodot.piegade.value = document.form1.piegade.options[document.form1.piegade.options.selectedIndex].value;
                         nodot.komanda.value='delete';
                         nodot.button.value='Parādīt';
                         nodot.registrator.value='<?=$registrator?>';
                         nodot.id.value='<?=$m['id']?>';
                         nodot.submit();
                    } return false;">Dzēst</a></td>
</tr><? ;} } }else{?><tr>

<?
  $r=mysql_query($query);
	
	while ($m=mysql_fetch_array($r))
	{
          if((braka_procents($m['brakis'],$m['bruto'])) >= 4){ $color="#ffcccc";}
	 ?>
          <tr bgcolor="<?=$color?>">
               <? if ($color=="#FFFFFF"){ $color = "#EEEEEE";} else { $color = "#FFFFFF";} ?>
               <td align="center"><?=$m['id']?></td>
               <td align="center"><?=$m['atskaites_veids']?></td>
               <td align="center"><?=$m['akta_nr']?></td>
               <td align="center"><?=$m['pavadzime']?></td>
               <td align="center"><?=$m['sortiments']?></td>
               <td align="center"><?=$m['soferis']?></td>
               <td align="center"><?=$m['auto_nr']?></td>
               <td align="center"><?=$m['vieta']?></td>
               <td align="center"><?=str_replace('-','.',$m['datums_uzmer'])?></td>
               <td align="center"><?=$m['skaits_kopa']?></td>
               <td align="center"><?=$m['bruto']?></td>
               <td align="center"><?=$m['neto']?></td>
               <td align="center"><?=$m['virsmers']?></td>
               <td align="center"><?=$m['redukcija']?></td>
               <td align="center"><?=$m['brakis']?></td>
               <td align="center"><?=braka_procents($m['brakis'],$m['bruto'])?></td>
               <td align="center"><?=atskaiti_veidoja($m['lietotajs_veidoja'])?></td>
               <td align="center"><input type="checkbox" id="<?=$m['id']?>" name="chkList" value="<?=$m['id']?>"></td>
               <td align="center"><a href="datu_registrs.php?h=43" onclick="if (confirm('Dzēst?')) 
                    {
                         nodot.a_veids.value = document.form1.a_veids.options[document.form1.a_veids.options.selectedIndex].value;
                         nodot.piegade.value = document.form1.piegade.options[document.form1.piegade.options.selectedIndex].value;
                         nodot.komanda.value='delete';
                         nodot.button.value='Parādīt';
                         nodot.registrator.value='<?=$registrator?>';
                         nodot.id.value='<?=$m['id']?>';
                         nodot.submit();
                    } return false;">Dzēst</a></td>
</tr><? ;} }?><tr>

          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center"  bgcolor="#CFE0D1"><input type="checkbox" name="Check_ctr" onClick="checkUncheckAll(this, chkList);"></td>
          <td align="center" bgcolor="#CFE0D1"><a href="datu_registrs.php?h=43" onclick="if (confirm('Dzēst?')) 
                    {
                         nodot.a_veids.value = document.form1.a_veids.options[document.form1.a_veids.options.selectedIndex].value;
                         nodot.piegade.value = document.form1.piegade.options[document.form1.piegade.options.selectedIndex].value;
                         nodot.komanda.value='deleteSelected';
                         nodot.button.value='Parādīt';
                         nodot.registrator.value='<?=$registrator?>';
                         nodot.id.value=anyCheck(form1);
                         nodot.submit();
                    } return false;">Dzēst</a></td>
          </tr>
</font>
</table>

</form>

<form name="nodot" method="post" action="datu_registrs.php?h=<?=$h?>">
	<input type=hidden name=a_veids>
	<input type=hidden name=piegade>
	<input type=hidden name=komanda>
	<input type=hidden name=button>
	<input type=hidden name=registrator>
	<input type=hidden name="id">
</form>

<form name="excel" method="post" action="datu_registrs_excel.php">
	<input name="query" type="hidden" value="<?=$query?>">
	<input name="coll" type="hidden" value="<?=$term?>">
	<input type="submit" value="Pārcelt uz Excel">
</form>

</body>
</html>

<?

function braka_procents($brakis, $bruto){
     $braka_procents = ROUND(($brakis / $bruto) * 100,2);
     return $braka_procents;
}


function getPiegadatajs($numurs){
  switch($numurs){
    case 1:
      $result = "Latvijas valsts meži";
    break;
    case 12:
      $result = "Metsaliitto";
    break;
    case 13:
      $result = "Tezei-S";
    break;
    default:
      $result = "Nav";
    break;
  }
  return $result;
}
function atskaiti_veidoja($userID){
     switch ($userID){
          case 5:
          $user = "Gunta Ziemele";
          break;
          case 4:
          $user = "Sigita Beņķe";
          break;
          case 10:
          $user = "Gita Ceriņa";
          break;
          case 11:
          $user = "Signe Grosvalde";
          break;
          case 12:
          $user = "Līga Poriete";
          break;
          case 13:
          $user = "Māra Sekste";
          break;

     }
     return $user;
}

?>
