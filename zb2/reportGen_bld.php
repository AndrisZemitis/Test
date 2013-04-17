<? 
include ("clsFuncDB.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

$grupu_sk = 5;

menu($_GET['h']);
$h = $_GET['h'];
if($_GET['template']){
	$query = "SELECT * FROM g_sabloni where id = '".$_GET['template']."'";
	$query = mysql_query($query);
	$template = mysql_fetch_array($query);
//print_r($template);
	$query = "SELECT * FROM g_sab_saturs where sablona_id = '".$template['id']."'";
	$query = mysql_query($query);
	while($row = mysql_fetch_array($query)){
		$tpl[$row['lauks']]=($row['vertiba']);
	}
	//print_r($tpl);
	$template_ident = $_GET['template'];
}

$veids = get_AtskVeidsByPlaceCode($h);
$tabulaName = tmp_getTableName($veids);
$ar = array ('' => '', 'brakis' => 'Brāķis', 'mind_pirms_red' => 'Diametrs pirms red', 'garums' => 'Garums', 'gar_pec_red' => 'Garums pēc redukcijas',  'skira' => 'Šķira', 'suga'=>'Suga');

$query_sabloni = "SELECT * FROM g_sabloni WHERE atskaites_id = $h order by id asc";
$r_sabloni=mysql_query($query_sabloni);


if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

?>
  <script type="text/javascript" src="../js_jquery/jquery-1.4.2.js"></script>
  <script type="text/javascript" src="../js_jquery/jquery.uitablefilter.js"></script>
  <script type="text/javascript" src="../js_jquery/sablonu_grupesana.js"></script>
  <script type="text/javascript" src="../js_jquery/exTransfTable.js"></script>
  <script type="text/javascript" src="../js_jquery/thickbox.js"></script>
<!--  <script type="text/javascript" src="../js_jquery/jqModal.js"></script> -->

	<link type="text/css" href="../js_jquery/themes/custom-theme/ui.all.css" rel="stylesheet" />
	<link type="text/css" href="../js_jquery/themes/thickbox.css" rel="stylesheet" />
<!--	<link type="text/css" href="../js_jquery/themes/jqModal.css" rel="stylesheet" /> -->
	<script type="text/javascript" src="../js_jquery/ui/ui.core.js"></script>
	<script type="text/javascript" src="../js_jquery/ui/ui.draggable.js"></script>
	<script type="text/javascript" src="../js_jquery/ui/ui.resizable.js"></script>
	<script type="text/javascript" src="../js_jquery/ui/ui.dialog.js"></script>
	<script type="text/javascript" src="../js_jquery/ui/effects.core.js"></script>
	<script type="text/javascript" src="../js_jquery/ui/effects.highlight.js"></script>
<!--  <script type="text/javascript" src="../js_jquery/exFileInp.js"></script> -->
	<script type="text/javascript" src="../js_jquery/external/bgiframe/jquery.bgiframe.js"></script>
<!--	<link type="text/css" href="../js_jquery/themes/demos.css" rel="stylesheet" /> -->
  
<!--
  <link rel="stylesheet" href="../nyroModal/styles/global.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../nyroModal/styles/nyroModal.css" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

	<script type="text/javascript" src="../nyroModal/js/jquery.scrollTo-1.3.3-min.js"></script>
	<script type="text/javascript" src="../nyroModal/js/jquery.mousewheel.pack.js"></script>
	<script type="text/javascript" src="../nyroModal/js/jquery.color.js"></script>
	<script type="text/javascript" src="../nyroModal/js/jquery.nyroModal-1.6.2.pack.js"></script>
-->

<center>
<form name=forma method=POST id="forma" action="reportGen_preview.php?veids=<?=$veids?>&h=<?=$h?>" target=_blank>
<input type="hidden" name="save_template" id="save_template" />
<input type="hidden" name="delete_template" id="delete_template" />
<input type="hidden" name="replace_template" id="replace_template" />
<input type="hidden" name="grup" id="grup" value="1">

<table>
  <tr>
    <td valign="top">
      <table bgcolor="#BFDBBF"  width="880">
        <thead>
          <tr>
            <td align=center colspan=4 bgcolor=#D1CFFF><b>Galvene</b><br></td>
          </tr>
        </thead>

        <tbody>
          <tr class="parent" id="filterhead">
            <td align=center colspan=4 bgcolor=#D1E0F0><b>Rādīt pilno galvenes formu</b><br></td>
          </tr>

          <tr>
            <td align=right>Baļķu uzmērīšanas atskaite Nr.:</td>
            <td align=left><input type=text name=akts_nr_head size=20 value="<? if($tpl){echo $tpl['akts_nr_head'];}else{echo htmlspecialchars(get_param('akts_nr'));}?>"></td>
            <td align=right>Datums:</td>
            <td align=left><input type=text name=datums_head size=20 value="<?  if($tpl){echo $tpl['datums_head'];}else{htmlspecialchars(get_param('datums'));}?>"></td>
          </tr>
          
          <tr>
            <td align=right>Pircējs:</td>
            <td align=left><input type=text name=pircejs_head size=35 value="<?  if($tpl){echo $tpl['pircejs_head'];}else{echo htmlspecialchars(get_param('pircejs_head'));}?>"></td>
            <td align=right>Pircējs Reg.Num:</td>
            <td align=left><input type=text name=pircejs_regnum size=35 value="<?  if($tpl){echo $tpl['pircejs_regnum'];}else{ echo htmlspecialchars(get_param('pircejs_regnum'));}?>"></td>
          </tr>

          <tr>
            <td align=right>Pārdevējs:</td>
            <td align=left><input type=text name=pardevejs_head size=35 value="<? if($tpl){echo $tpl['pardevejs_head'];}else{htmlspecialchars(get_param('pardevejs_head'));}?>"></td>
            <td align=right>Pārdevējs Reg.Num:</td>
            <td align=left><input type=text name=pardevejs_regnum size=35 value="<? if($tpl){echo $tpl['pardevejs_regnum'];}else{htmlspecialchars(get_param('pardevejs_regnum'));}?>"></td>
          </tr>

          <tr class="child-filterhead" style="display: none;">
            <td align=right>Piegādes līguma numurs:</td>
            <td align=left><input type=text name=pieg_lig_num size=20 maxlength=20 value="<? if($tpl){echo $tpl['pieg_lig_num'];}else{htmlspecialchars(get_param('pieg_lig_num'));}?>"></td>
            <td align=right>Pavadzīme:</td>
            <td align=left><input type=text name=pavadzime_head size=20 value="<?  if($tpl){echo $tpl['pavadzime_head'];}else{htmlspecialchars(get_param('pavadzime_head'));}?>"></td>
          </tr>
          
          <tr class="child-filterhead" style="display: none;">
            <td align=right>Iecirknis:</td>
            <td align=left><input type=text name=iecirknis_head size=20 value="<? if($tpl){echo $tpl['iecirknis_head'];}else{htmlspecialchars(get_param('iecirknis'));}?>"></td>
            <td align=right>Pārvadātāj-firmas nosaukums:</td>
            <td align=left><input type=text name=transport_firm size=35 value="<? if($tpl){echo $tpl['transport_firm'];}else{htmlspecialchars(get_param('transport_firm'));}?>"></td>
          </tr>

          <tr class="child-filterhead" style="display: none;">
            <td align=right>Automašīnas Nr.:</td>
            <td align=left><input type=text name=auto_head size=20 value="<? if($tpl){echo $tpl['auto_head'];}else{htmlspecialchars(get_param('auto'));}?>"></td>
            <td align=right>Šoferis:</td>
            <td align=left><input type=text name=soferis_head size=20 value="<? if($tpl){echo $tpl['soferis_head'];}else{htmlspecialchars(get_param('soferis'));}?>"></td>
          </tr>
          
          <tr>
            <td align=right>Uzmērīšanas vieta:</td>
            <td align=left><input type=text name=vieta_head size=20 value="<?  if($tpl){echo $tpl['vieta_head'];}else{htmlspecialchars(get_param('vieta'));}?>"></td>
            <td align=right>Piezīmes:</td>
            <td align=left><input type=text name=piezimes_head size=35 value="<?  if($tpl){echo $tpl['piezimes_head'];}else{htmlspecialchars(get_param('piezimes'));}?>"></td>
          </tr>
          
          <tr class="child-filterhead" style="display: none;">
            <td align=right>Atbildīgā persona:</td>
            <td align=left><input type=text name=atbildigais_head size=20 value="<?  if($tpl){echo $tpl['atbildigais_head'];}else{htmlspecialchars(get_param('atbildigais'));}?>"></td>
            <td align=right>Pārbaudīja:</td>
            <td align=left>
              <select name=parbaudija_head>
                <option value="0" <? if($tpl['parbaudija_head']==0){echo " selected";}else{get_param_selected('parbaudija','0');}?>></option>
                <option value="2" <? if($tpl['parbaudija_head']==2){echo " selected";}else{get_param_selected('parbaudija','2');}?>>Jānis Buļs</option>
                <option value="3" <? if($tpl['parbaudija_head']==3){echo " selected";}else{get_param_selected('parbaudija','3');}?>>Ingus Donis</option>
              </select>
            </td>
          </tr>
          
          <tr>
            <td align=right>Pārbaudīja/ atbildīgā persona:</td>
            <td align=left>
              <select name=parbaudija_un_atbildigais_head>
                      <option value="6" <? if($tpl['parbaudija_un_atbildigais_head']==6){echo " selected";}else{get_param_selected('parbaudija_atbildigais','6');}?>></option>
                      <option value="7" <?  if($tpl['parbaudija_un_atbildigais_head']==7){echo " selected";}else{get_param_selected('parbaudija_atbildigais','7');}?>>Jānis Buļs</option>
                      <option value="8" <?  if($tpl['parbaudija_un_atbildigais_head']==8){echo " selected";}else{get_param_selected('parbaudija_atbildigais','8');}?>>Ingus Donis</option>
                      <option value="9" <?  if($tpl['parbaudija_un_atbildigais_head']==9){echo " selected";}else{get_param_selected('parbaudija_atbildigais','9');}?>>Aldis Ladusāns</option>
                      <option value="14" <?  if($tpl['parbaudija_un_atbildigais_head']==14){echo " selected";}else{get_param_selected('parbaudija_atbildigais','14');}?>>Gunta Ziemele</option>
              </select>
            </td>
            <td align=right>Standarts:</td>
            <td align=left><input type=text name=standarts_head size=20 value="<? if($tpl){echo $tpl['standarts_head'];}else{htmlspecialchars(get_param('standarts'));}?>"></td>
          </tr>
          
          <tr>
            <td align=right>Sagatavoja:</td>
            <td align=left>
              <select name=veidoja_head>
                 <option value="4" <?  if($tpl['veidoja_head']==4){echo " selected";}else{get_param_selected('veidoja','4');}?>>Sigita Beņķe</option>
                 <option value="5" <?  if($tpl['veidoja_head']==5){echo " selected";}else{get_param_selected('veidoja','5');}?>>Gunta Ziemele</option>
                 <option value="10" <?  if($tpl['veidoja_head']==10){echo " selected";}else{get_param_selected('veidoja','10');}?>>Gita Ceriņa</option>
                 <option value="11" <?  if($tpl['veidoja_head']==11){echo " selected";}else{get_param_selected('veidoja','11');}?>>Signe Grosvalde</option>
                 <option value="12" <?  if($tpl['veidoja_head']==12){echo " selected";}else{get_param_selected('veidoja','12');}?>>Līga Poriete</option>
                 <option value="13" <?  if($tpl['veidoja_head']==13){echo " selected";}else{get_param_selected('veidoja','13');}?>>Māra Sekste</option>
              </select>
            </td>
            <td align=right>Metode un paņēmiens:</td>
            <td align=left><input type=text name=metode_head size=20 value="<? if($tpl){echo $tpl['metode_head'];}else{htmlspecialchars(get_param('metode'));}?>"></td>
          </tr>
          
          <tr class="child-filterhead" style="display: none;">
            <td align=right><input type=text name=custom11_head size=10 value="<?  if($tpl){echo $tpl['custom11_head'];}else{htmlspecialchars(get_param('custom11'));}?>"></td>
            <td align=left>
             <input type=text name=custom12_head size=20 value="<? if($tpl){echo $tpl['custom12_head'];}else{htmlspecialchars(get_param('custom12'));}?>">
            </td>
            <td align=right>Sortiments:</td>
            <td align=left><input type=text name=sortiments_head size=20 value="<? if($tpl){echo $tpl['sortiments_head'];}else{htmlspecialchars(get_param('sortiments'));}?>"></td>
          </tr>

          <tr class="child-filterhead" style="display: none;">
            <td align=right>Raukums:</td>
            <td align=left><input type=text name=raukums_head size=20 value="<? if($tpl){echo $tpl['raukums_head'];}else{htmlspecialchars(get_param('raukums'));}?>"></td>
            <td align=right>Mērinstruments:</td>
            <td align=left><input type=text name=merinstruments_head size=20 value="<? if($tpl){echo $tpl['merinstruments_head'];}else{htmlspecialchars(get_param('merinstruments'));}?>"></td>
          </tr>
          
          <tr class="child-filterhead" style="display: none;">
            <td align=right>Verificēšanas termiņš:</td>
            <td align=left><input type=text name=terminsh_head size=20 value="<? if($tpl){echo $tpl['terminsh_head'];}else{htmlspecialchars(get_param('terminsh'));}?>"></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top">
      <table bgcolor=#BFDBBF id="detail_table" class="detail" width="880">
        <thead>
          <tr><td align=center colspan=4 bgcolor=#7EBF7E><b>Nosacījumi</b><br></td>
           </tr>
        </thead>
        
        <tbody>
          <tr class="parent" id="filterstat">
            <td align=center colspan=4 bgcolor=#7EB000><b>Filtrēšana</b><br></td>
          </tr>

          <tr class="child-filterstat" style="display: none;">
            <td align=right title="dd mm gggg">Pavadzīmes datums no:</td>
            <td align=left>
             <input type=text name=datums_no_diena size=2 value="<? if($tpl){echo $tpl['datums_no_diena'];}else{echo $_POST['datums_no_diena'];}?>">
             <input type=text name=datums_no_menesis size=2 value="<? if($tpl){echo $tpl['datums_no_menesis'];}else{echo $_POST['datums_no_menesis'];}?>">
             <input type=text name=datums_no_gads size=5 value="<? if($tpl){echo $tpl['datums_no_gads'];}else{echo $_POST['datums_no_gads'];}?>">
            </td>
            <td align=right title="dd mm gggg">Pavadzīmes datums līdz:</td>
            <td align=left>
             <input type=text name=datums_lidz_diena size=2 value="<? if($tpl){echo $tpl['datums_lidz_diena'];}else{echo $_POST['datums_lidz_diena'];}?>">
             <input type=text name=datums_lidz_menesis size=2 value="<? if($tpl){echo $tpl['datums_lidz_menesis'];}else{echo $_POST['datums_lidz_menesis'];}?>">
             <input type=text name=datums_lidz_gads size=5 value="<? if($tpl){echo $tpl['datums_lidz_gads'];}else{echo $_POST['datums_lidz_gads'];}?>">
            </td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>Pārdevejs:</td>
            <td align=left><input type=text name=piegad_grupa size=10 value="<? if($tpl){echo $tpl['piegad_grupa'];}else{echo $_POST['piegad_grupa'];}?>"></td>
            <td align=right>Piegādātāju kods:</td>
            <td align=left><input type=text name=piegadataju_kods size=10 value="<? if($tpl){echo $tpl['piegadataju_kods'];}else{echo $_POST['piegad_grupa'];}?>"></td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>Pavadzīmes numurs:</td>
            <td align=left><input type=text name=pavadzime size=10 value="<? if($tpl){echo $tpl['pavadzime'];}else{$xml_vars['pavadzime'];}?>"></td>
            <td align=right>Cirsmas kods:</td>
            <td align=left>
             <input type=text name=cirsmas_kods size=20 value="<? if($tpl){echo $tpl['cirsmas_kods'];}else{echo $_POST['cirsmas_kods'];}?>">
            </td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>Suga:</td>
            <td align=left><input type=text name=suga size=2 value="<? if($tpl){echo $tpl['suga'];}else{echo $_POST['suga'];}?>"></td>
            <td align=right>Brāķis:</td>
            <td align=left><input type=text name=brakis size=2 value="<? if($tpl){echo $tpl['brakis'];}else{echo $_POST['brakis'];}?>"></td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>FSC:</td>
            <td align=left><input type=text name=fsc size=2 value="<? if($tpl){echo $tpl['fsc'];}else{echo $_POST['fsc'];}?>"></td>
            <td align=right>Kravas ID:</td>
            <td align=left><input type=text name=kravas_id size=10 value="<? if($tpl){echo $tpl['kravas_id'];}else{echo $_POST['kravas_id'];}?>"></td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>Auto Nr.:</td>
            <td align=left><input type=text name=auto size=10 value="<? if($tpl){echo $tpl['auto'];}else{echo $_POST['auto'];}?>"></td>
            <td align=right>Šoferis:</td>
            <td align=left><input type=text name=soferis size=20 value="<? if($tpl){echo $tpl['soferis'];}else{echo $_POST['soferis'];}?>"></td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right>Cenu matrica:</td>
            <td align=left><input type=text name=cenu_matrica size=3 value="<? if($tpl){echo $tpl['cenu_matrica'];}else{echo $_POST['cenu_matrica'];}?>"></td>
            <td align=right>Šķira:</td>
            <td align=left><input type=text name=skira size=3 value="<? if($tpl){echo $tpl['skira'];}else{echo $_POST['skira'];}?>"></td>
          </tr>
          
          <tr class="child-filterstat" style="display: none;">
            <td align=right title="Piemēram: 38,39,40">Ielasītā faila ID:</td>
            <td align=left><input type=text name=batch_fails size=20 value="<? if($tpl){echo $tpl['batch_fails'];}else{echo $_POST['batch_fails'];}?>"></td>
            <td align=right>Iecirknis:</td>
            <td align=left><input type=text name="iecirknis_pieg" size=20 value="<? if($tpl){echo $tpl['iecirknis_pieg'];}else{echo $_POST['iecirknis_pieg'];}?>"></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top">
      <table bgcolor=#BFDBBF width="880">
        <thead>
            <td align=center colspan=5 bgcolor=#7EB000><b>Datu aprēķina nosacījumi</b><br>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td align=right width="250">Noapaļot diametru uz klases vidu:</td>
            <td align=center><input type=checkbox name=noapalot_diametru <? if($tpl['noapalot_diametru']=="on"){?> checked<?}?> /></td>
            <td align=right>Rēķināt virsmēru no brāķa:</td>
            <td align=center><input type=checkbox name=braka_virsmers <?  if($tpl['braka_virsmers']=="on"){?> checked<?}else{get_param_checked('braka_virsmers',$veids);}?> /></td>
          </tr>
          
          <tr>
            <td align=right bgcolor="#9ABA90">Noapaļot garumu uz decimetriem:</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=noapalot_garumu value="1" <? if($tpl['noapalot_garumu']=="1"){?> checked<?}else{get_param_checked('noapalot_garumu',$veids);}?> /></td>
            <td align=right bgcolor="#9ABA90">Tilpuma aprēķina 1. metode</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=metode value="1" <?if($tpl){if($tpl['metode']==1){?> checked<?}}else{?> checked<?}?>></input></td>
          </tr>
        
          <tr>
            <td align=right bgcolor="#9ABA90">Noapaļot garumu uz klases vidu:</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=noapalot_garumu value="2" <? if($tpl['noapalot_garumu']=="2"){?> checked<?}?> /></td>
            <td align=right bgcolor="#9ABA90">Tilpuma aprēķina 2. metode</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=metode value="2" <?if($tpl['metode']==2){?> checked<?}?> /></td>
          </tr>
        
          <tr>
            <td align=right bgcolor="#9ABA90">Nenoapaļot garumu:</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=noapalot_garumu value="3" <? if($tpl['noapalot_garumu']=="3"){?> checked<?}?> /></td>
            <td align=right bgcolor="#9ABA90">Tilpuma aprēķina 3. metode</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=metode value="3" <?if($tpl['metode']==3){?> checked<?}?> /></td>
          </tr>
        
          <tr>
            <td align=right>Pakešdatnes noapaļotie garumi:</td>
            <td align=center><input type=checkbox name=is_vika <?  if($tpl['is_vika']=="on"){?> checked<?}else{get_param_checked('is_vika',$veids);}?> /></td>
            <td align=right bgcolor="#9ABA90">Tilpuma aprēķina 4. metode</td>
            <td align=center bgcolor="#9ABA90"><input type=radio name=metode value="4" <?if($tpl['metode']==4){?> checked<?}?> /></td>
            <td align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <table width="880" style="border-width:1px;border-style:solid;"><tr>
      <td valign="top" align=center colspan=5><br />

      <? for ($grup=1;$grup<=9;$grup++) { ?>
      <div id="grup<?=$grup?>" style="<? if ($grup > 1) { ?>display:none<? } ?>">
      <b>Grupēšana <? if ($grup > 1) { echo $grup; } ?></b>&nbsp;<a href="#" onclick="window.open('paraugi.php','Paraugi','toolbar=no,resizable=yes,scrollbars=2,width='+screen.width+',height='+screen.height+',left=0, top=0');">[Labot]</a><br><br>
      <table bgcolor=#FDFFCF>
        <?for ($i=1;$i<=$grupu_sk;$i++) { ?>
        <tr>
          <td align=right>Grupa <?=$i?></td>
          <td align=left>
            <select name=gtype<?=$grup?><?=$i?>>
            <? foreach ($ar as $v => $p) {
                echo "			<option value=\"$v\" "; 
                if($tpl['gtype'.$grup.$i]==$v){
                  echo ' selected ';
                }
                elseif ($_POST["gtype".$grup.$i]==$v) echo ' selected ';
                echo ">$p</option>\n"; };
               ?>
            </select>
            <span id=lauks<?=$grup?><?=$i?>>
            <input type=text name=gvalues<?=$grup?><?=$i?> value="<? if($tpl){echo $tpl['gvalues'.$grup.$i];}else{echo $_POST["gvalues".$grup.$i];}?>" size=15>
            <? parauga_poga($grup,$i) ?>
            </span>
          </td>
          <td>
            <input type=checkbox name=dalit<?=$grup?><?=$i?>  id=dalit<?=$grup?><?=$i?> 
              onclick="
              if (dalit<?=$grup?><?=$i?>.checked) {
                lauks<?=$grup?><?=$i?>.innerHTML = 'Priede:<input type=text name=gvalues<?=$grup?><?=$i?>_1 size=15><? parauga_poga2($grup,$i.'_1') ?> Egle:<input type=text name=gvalues<?=$grup?><?=$i?>_2 size=15><? parauga_poga2($grup,$i.'_2') ?>';
              }
              else
              {
                lauks<?=$grup?><?=$i?>.innerHTML = '<input type=text name=gvalues<?=$grup?><?=$i?> size=15><? parauga_poga2($grup,$i) ?>';
              };
              ">
                <? if($tpl['dalit'.$grup.$i]=="on"){?>
                  <script>
                    document.getElementById('lauks<?=$grup?><?=$i?>').innerHTML = 'Priede:<input type=text name=gvalues<?=$grup?><?=$i?>_1 size=15 <? echo "value=\"".$tpl["gvalues".$grup.$i."_1"]."\"";?>> Egle:<input type=text name=gvalues<?=$grup?><?=$i?>_2 size=15 <?  echo "value=\"".$tpl["gvalues".$grup.$i."_2"]."\"";?>>';
                    document.getElementById('dalit<?=$grup?><?=$i?>').checked = true;
                  </script>
                <?}?>
          </td>
        </tr>
        <? } ?>
      </table>
      <table>
      <tr>
        <td align=right>Nominālie garumi (cm):</td><td>
        <span id=lauks_virsmeri<?=$grup?>>
        <input type=text name=virsmeri<?=$grup?> size=40 <? if($tpl){echo "value=\"".$tpl['virsmeri'.$grup]."\"";}?>>
          <?parauga_poga2($grup,70);?>
        </span>
          <input type=checkbox name=dalit_virsmeri<?=$grup?> id=dalit_virsmeri<?=$grup?>
            onclick="JavaScript:
            if (dalit_virsmeri<?=$grup?>.checked) {
              lauks_virsmeri<?=$grup?>.innerHTML = 'Priede:<input type=text name=virsmeri<?=$grup?>_1 size=40><? parauga_poga2($grup,71) ?>Egle:<input type=text name=virsmeri<?=$grup?>_2 size=40><? parauga_poga2($grup,72) ?>';
            }
            else
            {
              lauks_virsmeri<?=$grup?>.innerHTML = '<input type=text name=virsmeri<?=$grup?> size=40><? parauga_poga2($grup,70) ?>';
            }">
              <? if($tpl['dalit_virsmeri'.$grup]=="on"){?>
                <script>
                  document.getElementById('lauks_virsmeri<?=$grup?>').innerHTML = 'Priede:<input type=text name=virsmeri<?=$grup?>_1 size=40 <? echo "value=\"".$tpl["virsmeri".$grup."_1"]."\"";?>> Egle:<input type=text name=virsmeri<?=$grup?>_2 size=40 <?  echo "value=\"".$tpl["virsmeri".$grup."_2"]."\"";?>>';
                  document.getElementById('dalit_virsmeri<?=$grup?>').checked = true;
                </script>
              <?}?>
          </td>
        </tr>
        <tr>
          <td align=right>Nominālie garumi brāķim (cm):</td><td><span id=lauks_virsmeri_brakim<?=$grup?>><input type=text name=virsmeri_brakim<?=$grup?> size=40 <?  if($tpl){echo "value=\"".$tpl['virsmeri_brakim'.$grup]."\"";}?>>
          <?parauga_poga2($grup,79);?></span>
            <input type=checkbox name=dalit_virsmeri_brakim<?=$grup?>  id=dalit_virsmeri_brakim<?=$grup?> 
              onclick="JavaScript:
              if (dalit_virsmeri_brakim<?=$grup?>.checked) {
                lauks_virsmeri_brakim<?=$grup?>.innerHTML = 'Priede:<input type=text name=virsmeri_brakim<?=$grup?>_1 size=40><? parauga_poga2($grup,80) ?>Egle:<input type=text name=virsmeri_brakim<?=$grup?>_2 size=40><? parauga_poga2($grup,81) ?>';
              }
              else
              {
                lauks_virsmeri_brakim<?=$grup?>.innerHTML = '<input type=text name=virsmeri_brakim<?=$grup?> size=40><? parauga_poga2($grup,70) ?>';
              }">
                <? if($tpl['dalit_virsmeri_brakim'.$grup]=="on"){?>
                  <script>
                    document.getElementById('lauks_virsmeri_brakim<?=$grup?>').innerHTML = 'Priede:<input type=text name=virsmeri_brakim<?=$grup?>_1 size=40 <? echo "value=\"".$tpl["virsmeri_brakim".$grup."_1"]."\"";?>> Egle:<input type=text name=virsmeri_brakim<?=$grup?>_2 size=40 <?  echo "value=\"".$tpl["virsmeri_brakim".$grup."_2"]."\"";?>>';
                    document.getElementById('dalit_virsmeri_brakim<?=$grup?>').checked = true;
                  </script>
                <?}?>
          </td>
        </tr>
        <tr>
          <td align=right>Virsmērs:</td><td><span id=min_virsmers<?=$grup?>><input type=text name="virsmers<?=$grup?>" size=20  <?  if($tpl){echo "value=\"".$tpl['virsmers'.$grup]."\"";}?>></span>
          <input type=checkbox name=dalit_virsmers<?=$grup?>  id=dalit_virsmers<?=$grup?> 
            onclick="JavaScript:
            if (dalit_virsmers<?=$grup?>.checked) {
              min_virsmers<?=$grup?>.innerHTML = 'Priede:<input type=text name=virsmers<?=$grup?>_1 size=20> Egle:<input type=text name=virsmers<?=$grup?>_2 size=20>';
            }
            else
            {
              min_virsmers<?=$grup?>.innerHTML = '<input type=text name=virsmers<?=$grup?> size=20>';
            }">
          </td>
              <? if($tpl['dalit_virsmers'.$grup]=="on"){?>
                <script>
                  document.getElementById('min_virsmers<?=$grup?>').innerHTML = 'Priede:<input type=text name=virsmers<?=$grup?>_1 size=40 <? echo "value=\"".$tpl["virsmers".$grup."_1"]."\"";?>> Egle:<input type=text name=virsmers<?=$grup?>_2 size=40 <?  echo "value=\"".$tpl["virsmers".$grup."_2"]."\"";?>>';
                  document.getElementById('dalit_virsmers<?=$grup?>').checked = true;
                </script>
              <?}?>
        </tr>
        <tr>
          <td align=right>Koeficients:</td><td><span id=lauks_koeficients<?=$grup?>><input type=text name=koeficients<?=$grup?> size=40 <?  if($tpl){echo "value=\"".$tpl['koeficients'.$grup]."\"";}?>>
          <?parauga_poga2($grup,76);?></span>
            
            <input type=checkbox name=dalit_koeficients<?=$grup?>  id=dalit_koeficients<?=$grup?> 
              onclick="JavaScript:
              if (dalit_koeficients<?=$grup?>.checked) {
                lauks_koeficients<?=$grup?>.innerHTML = 'Priede:<input type=text name=koeficients<?=$grup?>_1 size=40><? parauga_poga2($grup,77) ?>Egle:<input type=text name=koeficients<?=$grup?>_2 size=40><? parauga_poga2($grup,78) ?>';
              }
              else
              {
                lauks_koeficients<?=$grup?>.innerHTML = '<input type=text name=koeficients<?=$grup?> size=40><? parauga_poga2($grup,76) ?>';
              }">
          </td>
                <? if($tpl['dalit_koeficients'.$grup]=="on"){?>
                  <script>
                    document.getElementById('lauks_koeficients<?=$grup?>').innerHTML = 'Priede:<input type=text name=koeficients<?=$grup?>_1 size=40 <? echo "value=\"".$tpl["koeficients".$grup."_1"]."\"";?>> Egle:<input type=text name=koeficients<?=$grup?>_2 size=40 <?  echo "value=\"".$tpl["koeficients".$grup."_2"]."\"";?>>';
                    document.getElementById('dalit_koeficients<?=$grup?>').checked = true;
                  </script>
                <?}?>
        </tr>
        <tr>
          <td align=right><label title="Formats: r1,d1-d2, r2,d3-d4, r3,d5-d6 utt.">Raukums:</label></td><td><span id=lauks_raukums<?=$grup?>><input type=text name=raukums<?=$grup?> size=40 <?   if($tpl){echo "value=\"".$tpl['raukums'.$grup]."\"";} ?>>
          <?parauga_poga2($grup,75);?>
          </span>
            <input type=checkbox name=dalit_raukums<?=$grup?>  id=dalit_raukums<?=$grup?>
              onclick="
              if (dalit_raukums<?=$grup?>.checked) {
                lauks_raukums<?=$grup?>.innerHTML = 'Priede:<input type=text name=raukums<?=$grup?>_1 size=40><? parauga_poga2($grup,73) ?>Egle:<input type=text name=raukums<?=$grup?>_2 size=40><? parauga_poga2($grup,74) ?>';
              }
              else
              {
                lauks_raukums<?=$grup?>.innerHTML = '<input type=text name=raukums<?=$grup?> size=40><? parauga_poga2($grup,75) ?>';
              };
              ">
                  <? if($tpl['dalit_raukums'.$grup]=="on"){?>
                    <script>
                      document.getElementById('lauks_raukums<?=$grup?>').innerHTML = 'Priede:<input type=text name=raukums<?=$grup?>_1 size=40 <? echo "value=\"".$tpl["raukums".$grup."_1"]."\"";?>> Egle:<input type=text name=raukums<?=$grup?>_2 size=40 <?  echo "value=\"".$tpl["raukums".$grup."_2"]."\"";?>>';
                      document.getElementById('dalit_raukums<?=$grup?>').checked = true;
                    </script>
                  <?}?>
          </td>
        </tr>
        <tr>
          <td align=right>Aprēķina veids:</td>
          <td>
            <select name=gostu_tabula<?=$grup?>>
              <option value=0>Aprēķins pēc formulas</option>
              <? 
              $rgostu_tabulas = mysql_query('select * from gostu_tabulas order by nosaukums'); 
              while ($mgostu_tabulas = mysql_fetch_array($rgostu_tabulas)){
                ?><option value="<?=$mgostu_tabulas['id']?>" <?if($tpl['gostu_tabula'.$grup]==$mgostu_tabulas['id']){?> selected<?}?> ><?=$mgostu_tabulas['nosaukums']?></option><?
              }
              ?>
            </select>
            <input type="button" onclick="window.open('gosti.php');" value="Skatīt...">
          </td>
          </td>
        </tr>
      <tr>
        <td align=right>Atskaites valoda:</td>
        <td>
          <select name=valoda<?=$grup?>>
            <option value="LAT" <?if($tpl['valoda'.$grup]=="LAT"){?> selected<?}?>>Latviešu</option>
            <option value="RUS" <?if($tpl['valoda'.$grup]=="RUS"){?> selected<?}?>>Krievu</option>
          </select>
        </td>
        </td>
      </tr>

      <? if ($grup < 9) { ?>
      <tr>
        <td colspan="2" align="center">
      Vēl grupēšanas nosacījumus: <input type="checkbox" name="more<?=$grup;?>" id="more<?=$grup;?>" onclick="if (this.checked) 
      {
        document.getElementById('grup<?=$grup+1?>').style.display='';
        for (i=<?=$grup+1?>;i<=9;i++) 
        {
          if (document.getElementById('grup' + i.toString()).style.display=='')
          {
            document.getElementById('grup').value=i.toString();
          } else {
            break;
          }
          //alert(i);
        }
      } else {
        document.getElementById('grup<?=$grup+1?>').style.display='none';
        document.getElementById('grup').value='<?=$grup?>';
      }">
      <? } ?>
        </td>
      </tr>
      <tr>
        <td align=right></td>
        <td>&nbsp;</td>
      </tr>
      </table>
      <? } ?>
      <?if($tpl){?>
        <script>
          <?
              for($sk=1;$sk<=9;$sk++){
                  if($tpl['more'.$sk]=="on"){
                  ?>
                      document.getElementById('grup<?=$sk+1?>').style.display='';
                      document.getElementById('more<?=$sk?>').checked=true;
                      for (i=<?=$sk+1?>;i<=9;i++) 
                      {									
                        if (document.getElementById('grup' + i).style.display=='')
                        {
                          document.getElementById('grup').value = i;
                          //document.getElementById('grup').value=i;
                        } else {
                          break;
                        }
                      }							
                  <?
                  }
              }
          ?>
        </script>
      <?}?>
      </div></div></div></div></div></div></div></div></div>

      <?
        $batches_veids = $veids;
        if ($batches_veids == 2009 || $batches_veids == 2010) {
          $batches_veids = 'all';
        }
      ?>

      <b>Grupēšanas šablona informācija</b><br>
      <table bgcolor=#FDFFCF>
        <tr>
          <td align=right>Nosaukums</td>
          <td><input type=text name=sab_nosaukums size=30></td>
        </tr>
        <tr>
          <td align=right>Informācija</td>
          <td><input type=text name=sab_info size=30></td>
        </tr>
      </table>
      <a href="javascript:;" onclick="document.getElementById('save_template').value=<?=$_GET['h']?>;document.forms['forma'].submit();">Saglabāt</a><br /><br /><br />
      <b>Vairāku baču apstrāde</b><br><br>
      <table bgcolor=#FDFFCF>
        <tr>
          <td align=right>Izvēlēties failus</td>
<!--          <td><input type=text id="fileget" name=pv>&nbsp;<a href="slcPavadzimes.php?type=<?=$batches_veids?>&height=400&width=900" class="thickbox" title="">Izvēlēties failus</a></td> -->
          <td><input type=text name=pv><input type=button onclick="OpenPage('select_batches.php?type=<?=$batches_veids?>');" value="..."></td>
        </tr>
        <tr>
          <td align=right>Nākamais VMF akta numurs</td>
          <td><input type=text name=akts size=5></td>
        </tr>
        <tr>
          <td align=right>Nākamais pārdevēja akta numurs</td>
          <td><input type=text name=aktsp size=5></td>
        </tr>
        <tr>
          <td align=right>Reģistrēt atskaiti(-es):</td>
          <td align=left><input type="checkbox" name="reg_atsk" <?if($tpl['reg_atsk']=="on"){?> checked<?}?> /></td>
        </tr>	
      </table>
      <table>
        <tr>
          <td align=center colspan=2><input type="button" onclick="var f=document.getElementById('forma');f.action='reportGen_preview.php?veids=<?=$veids?>&h=<?=$h?>';f.submit();"" name=poga value=" Veidot "><input type="button" onclick="var f=document.getElementById('forma');f.action='reportGen_preview.php?xml=1&veids=<?=$veids?>&h=<?=$h?>';f.submit();" name="poga_xml" value="Veidot XML"><input type="button" onclick="var f=document.getElementById('forma');f.action='reportGen_preview.php?pdf=1&veids=<?=$veids?>&h=<?=$h?>';f.submit();" name="poga_pdf" value="Veidot PDF"><input type="button" onclick="var f=document.getElementById('forma');f.action='report_view_test_2.php?veids=<?=$veids?>&h=<?=$h?>';f.submit();" name="poga_pdf" value="Veidot HTML"></td>
        </tr>
      </table>
    
    </td>
  </tr>
  </table>
  </td>
  </tr>
  
  <tr>
    <td valign="top"><br />
      <table class="sablonu_filtrs" bgcolor="#BFDBBF" width="880" style="border-width:1px;border-style:solid;">
        <thead>
          <tr bgcolor=#7EBF7E>
            <td align=center colspan=3><b>Grupēšanas šabloni</b></td>
            <td align=center colspan=1><b>Meklēt:</b></td>
            <td align=center colspan=2><input name="filter" id="filter" value="" maxlength="50" size="30" type="text"></td>
          </tr>
          
          <tr bgcolor=#7EB000>
            <td align=center><b>ID&nbsp;</b></td>
            <td align=center><b>Nosaukums&nbsp;</b></td>
            <td align=center><b>Informācija&nbsp;</b></td>
            <td colspan="3" align=center><b>Iespējas&nbsp;</b></td>
          </tr>
        <thead>
        <tbody>
          <? while ($m_sabloni = mysql_fetch_array($r_sabloni)) { 
                $color = '';
              if($m_sabloni['id'] == $template_ident){
                $color = 'bgcolor=#FFCC33';
              }
          ?>
          <tr <?=$color?>>
            <td><?=$m_sabloni['id']?></td>
            <td><?=$m_sabloni['nosaukums']?></td>
            <td><?=$m_sabloni['info']?></td>
            <td><a href="http://www.vmf.lv/zb2/reportGen_bld.php?h=<? echo $h."&template=".$m_sabloni['id'];?>">Izvēlēties</a></td>
            <td>
            <span id="del<?=$m_sabloni['id']?>" style="display:none;"><a href="javascript:;" onclick="document.getElementById('delete_template').value=<?=$m_sabloni['id']?>;document.forms['forma'].submit();">Jā</a> | <a href="javascript:;" onclick="document.getElementById('del<?=$m_sabloni['id']?>').style.display='none';document.getElementById('select<?=$m_sabloni['id']?>').style.display='block';">Nē</a></span>
            <a href="javascript:;" id="select<?=$m_sabloni['id']?>" onclick="document.getElementById('select<?=$m_sabloni['id']?>').style.display='none';document.getElementById('del<?=$m_sabloni['id']?>').style.display='block';">Dzēst</a>
            </td>
            <td>
            <span id="rep<?=$m_sabloni['id']?>" style="display:none;"><a href="javascript:;" onclick="document.getElementById('replace_template').value=<?=$m_sabloni['id']?>;document.forms['forma'].submit();">Jā</a> | <a href="javascript:;" onclick="document.getElementById('rep<?=$m_sabloni['id']?>').style.display='none';document.getElementById('select2<?=$m_sabloni['id']?>').style.display='block';">Nē</a></span>
            <a href="javascript:;" id="select2<?=$m_sabloni['id']?>" onclick="document.getElementById('select2<?=$m_sabloni['id']?>').style.display='none';document.getElementById('rep<?=$m_sabloni['id']?>').style.display='block';">Pārrakstīt</a>
            </td>
          <!--	<td><a href="#" onclick="OpenPage('group_info.php?sablons=<?=$m_sabloni['id']?>');" value="">Skatīt</a></td>-->
          </tr>
          <? } ?>
        </tbody>
      </table>
    </td><br />
  </tr>
</table>

<input type=hidden name=subm value=1> 
</form>

<script>
function OpenPage(page) {
		var NewWindow=open('','popup','menubar=1,toolbar=1,location=1,directories=1,scrollbars=1,resizable=1,status=1,width=800,height=600');
    NewWindow.focus();
		window.open(page,target="popup");

  }
</script>

<? function parauga_poga($grup,$num) { ?>
			<input type=button name=poga value="..." 
				onclick="
					//if (gtype<?=$grup?><?=$num?>.value=='garums' || gtype<?=$grup?><?=$num?>.value=='mind_pirms_red')
					//{
window.open('paraugs.php?tips='+gtype<?=$grup?><?=$num?>.value+'&field=forma.gvalues<?=$grup?><?=$num?>','Paraugs','toolbar=no,resizable=yes,scrollbars=2,width='+screen.width+',height='+screen.height+',left=0, top=0');
				">
<? } ?>

<? function parauga_poga2($grup,$num) { ?>	<input type=button name=poga<?=$grup?><?=$num?> value=... onclick=parauga_logs(this.name.substr(4,1),this.name.substr(5))> <? } ?>

</center>
</body>
<script>
function parauga_logs(grup,num)
{
	 var params = 'toolbar=no,resizable=yes,scrollbars=2,width='+screen.width+',height='+screen.height+',left=0, top=0';

	if (num.toString().length != 2)
	{
		t = document.getElementsByName('gtype' + grup + num.toString().substr(0,1))[0].value;
	}

	if (num == '70') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri'+grup,'Paraugs', params);
	if (num == '71') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri'+grup+'_1','Paraugs',params);
	if (num == '72') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri'+grup+'_2','Paraugs',params);
	
	if (num == '73') window.open('paraugs.php?tips=raukums&field=forma.raukums'+grup+'_1','Paraugs',params);
	if (num == '74') window.open('paraugs.php?tips=raukums&field=forma.raukums'+grup+'_2','Paraugs',params);
	if (num == '75') window.open('paraugs.php?tips=raukums&field=forma.raukums'+grup,'Paraugs', params);

	if (num == '76') window.open('paraugs.php?tips=koeficients&field=forma.koeficients'+grup,'Paraugs', params);
	if (num == '77') window.open('paraugs.php?tips=koeficients&field=forma.koeficients'+grup+'_1','Paraugs',params);
	if (num == '78') window.open('paraugs.php?tips=koeficients&field=forma.koeficients'+grup+'_2','Paraugs',params);

	if (num == '79') window.open('paraugs.php?tips=virsmeri_brakim&field=forma.virsmeri_brakim'+grup,'Paraugs', params);
	if (num == '80') window.open('paraugs.php?tips=virsmeri_brakim&field=forma.virsmeri_brakim'+grup+'_1','Paraugs',params);
	if (num == '81') window.open('paraugs.php?tips=virsmeri_brakim&field=forma.virsmeri_brakim'+grup+'_2','Paraugs',params);

	
	if( num>=70) return;


	window.open('paraugs.php?tips='+t+'&field=forma.gvalues'+grup+num,'Paraugs',params);
}
</script>
</html>