<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

$grupu_sk = 5;
$ar = array ('' => '', 'auto' =>'Auto', 'brakis' => 'Brāķis', 'cenu_matrica' => 'Cenu matrica', 'kad_piegad' => 'Datums', 'mind_pirms_red' => 'Diametrs pirms red', 'fsc' => 'FSC', 'garums' => 'Garums', 'kravas_id' => 'Kravas ID', 'pavadzime.pavadzime' => 'Pavadzīme', 'piegad_kods' => 'Piegādātājs', 'skira' => 'Šķira','soferis'=>'Šoferis', 'suga'=>'Suga', 'iecirknis'=>'Iecirknis');

menu($_GET['h']); 
$h = $_GET['h'];

switch($h){
    case 4:
    $veids = "xml";
    break;
}

?>
<center>
<form name=forma method=POST action="report_xml2.php?veids=<?=$veids?>&h=<?=$h?>" target=_blank>
<input type="hidden" name="grup" value="1">

<table bgcolor=#BFDBBF>
	<tr>
		<td align=center colspan=2 bgcolor=#D1CFFF><b>Galvene</b><br>
		</td>
	</tr>

	<tr>
		<td align=right>Baļķu uzmērīšanas atskaite Nr.:</td>
		<td align=left>
		 <input type=text name=akts_nr_head size=20 value="<?=htmlspecialchars(get_param('akts_nr'))?>">
		</td>
	</tr>
	<tr bgcolor=#FF9900>
		<td align=right>Pircējs:</td>
		<td align=left>
		 <input type=text name=pircejs_head size=35 value="<?=htmlspecialchars(get_param('pircejs_head'))?>">
		</td>
	</tr>
	<tr bgcolor=#FF9900>
		<td align=right>Pircējs Reg.Num:</td>
		<td align=left>
		 <input type=text name=pircejs_regnum size=35 value="<?=htmlspecialchars(get_param('pircejs_regnum'))?>">
		</td>
	</tr>

	<tr bgcolor=#FF9900>
		<td align=right>Pārdevējs:</td>
		<td align=left>
		 <input type=text name=pardevejs_head size=35 value="<?=htmlspecialchars(get_param('pardevejs_head'))?>">
		</td>
	</tr>
	<tr bgcolor=#FF9900>
		<td align=right>Pārdevējs Reg.Num:</td>
		<td align=left>
		 <input type=text name=pardevejs_regnum size=35 value="<?=htmlspecialchars(get_param('pardevejs_regnum'))?>">
		</td>
	</tr>

	<tr bgcolor=#FF9900>
		<td align=right>Piegādes līguma numurs:</td>
		<td align=left>
		 <input type=text name=pieg_lig_num size=20 maxlength=20 value="<?=htmlspecialchars(get_param('pieg_lig_num'))?>">
		</td>
	</tr>

	<tr>
		<td align=right>Datums:</td>
		<td align=left>
		 <input type=text name=datums_head size=20 value="<?=htmlspecialchars(get_param('datums'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pavadzīme:</td>
		<td align=left>
		 <input type=text name=pavadzime_head size=20 value="<?=htmlspecialchars(get_param('pavadzime_head'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Iecirknis:</td>
		<td align=left>
		 <input type=text name=iecirknis_head size=20 value="<?=htmlspecialchars(get_param('iecirknis'))?>">
		</td>
	</tr>
	<tr bgcolor=#FF9900>
		<td align=right>Pārvadātāj-firmas nosaukums:</td>
		<td align=left>
		 <input type=text name=transport_firm size=35 value="<?=htmlspecialchars(get_param('transport_firm'))?>">
		</td>
	</tr>

	<tr>
		<td align=right>Automašīnas Nr.:</td>
		<td align=left>
		 <input type=text name=auto_head size=20 value="<?=htmlspecialchars(get_param('auto'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Šoferis:</td>
		<td align=left>
		 <input type=text name=soferis_head size=20 value="<?=htmlspecialchars(get_param('soferis'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Uzmērīšanas vieta:</td>
		<td align=left>
		 <input type=text name=vieta_head size=20 value="<?=htmlspecialchars(get_param('vieta'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Piezīmes:</td>
		<td align=left>
		 <input type=text name=piezimes_head size=60 value="<?=htmlspecialchars(get_param('piezimes'))?>">
		</td>
	</tr>
	<tr>
		<td align=right>Atbildīgā persona:</td>
		<td align=left>
		 <input type=text name=atbildigais_head size=20 value="<?=htmlspecialchars(get_param('atbildigais'))?>">
		</td>
	</tr>
	<tr>
		<td align=right><input type=text name=custom11_head size=10 value="<?=htmlspecialchars(get_param('custom11'))?>"></td>
		<td align=left>
		 <input type=text name=custom12_head size=20 value="<?=htmlspecialchars(get_param('custom12'))?>">
		</td>
	</tr>
</table>

<br><br>

<table bgcolor=#BFDBBF>
	<tr>
		<td align=center colspan=2 bgcolor=#D1CFFF><b>Nosacījumi</b><br>
		</td>
	</tr>
	<!--<tr>
		<td align=right>Pavadzīmes datums no</td>
		<td align=left>
		 <input type=text name=datums_no_diena size=2 value="<?=$_POST['datums_no_diena']?>">
		 <input type=text name=datums_no_menesis size=2 value="<?=$_POST['datums_no_menesis']?>">
		 <input type=text name=datums_no_gads size=5 value="<?=$_POST['datums_no_gads']?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pavadzīmes datums līdz</td>
		<td align=left>
		 <input type=text name=datums_lidz_diena size=2 value="<?=$_POST['datums_lidz_diena']?>">
		 <input type=text name=datums_lidz_menesis size=2 value="<?=$_POST['datums_lidz_menesis']?>">
		 <input type=text name=datums_lidz_gads size=5 value="<?=$_POST['datums_lidz_gads']?>">
		</td>
	</tr>-->
	<tr>
		<td align=right>Pārdevejs:</td>
		<td align=left><input type=text name=piegad_grupa size=10 value="<?=$_POST['piegad_grupa']?>"></td>
	</tr>
	<tr bgcolor=#FF9900>
		<td align=right>Pavadzīmes numurs:</td>
		<td align=left><input type=text name=pavadzime size=10 value="<?=$xml_vars['pavadzime']?>"></td>
	</tr>
	<tr>
		<td align=right>Suga:</td>
		<td align=left><input type=text name=suga size=2 value="<?=$_POST['suga']?>"></td>
	</tr>
	<tr>
		<td align=right>Brāķis:</td>
		<td align=left>
		  <select name=brakis>
		    <option value="">Visi</option>
			<?
			 foreach($braki as $k=>$v)
			 {
				 if ($k=='255')
				 {
					 ?><option value='255' <?if ($_POST['brakis']=='255') echo ' selected ' ?> >Nav brāķis</option><?
				 }
				 else
				 {
					 ?><option value=<?=$k?> <?if ($_POST['brakis']==$k) echo ' selected ' ?>><?=$v?></option><?
				 }
			 }
			?>
		  </select>
	</tr>
	<tr>
		<td align=right>FSC:</td>
		<td align=left><input type=text name=fsc size=2 value="<?=$_POST['fsc']?>"></td>
	</tr>
	<tr>
		<td align=right>Kravas ID:</td>
		<td align=left><input type=text name=kravas_id size=10 value="<?=$_POST['kravas_id']?>"></td>
	</tr>
	<tr>
		<td align=right>Auto Nr.:</td>
		<td align=left><input type=text name=auto size=10 value="<?=$_POST['auto']?>"></td>
	</tr>
	<tr>
		<td align=right>Šoferis:</td>
		<td align=left><input type=text name=soferis size=20 value="<?=$_POST['soferis']?>"></td>
	</tr>
	<tr>
		<td align=right>Cenu matrica:</td>
		<td align=left><input type=text name=cenu_matrica size=3 value="<?=$_POST['cenu_matrica']?>"></td>
	</tr>
	<tr>
		<td align=right>Šķira:</td>
		<td align=left><input type=text name=skira size=3 value="<?=$_POST['skira']?>"></td>
	</tr>
	<tr>
		<td align=right>Ielasītā faila ID:</td>
		<td align=left><input type=text name=batch_fails size=20 value="<?=$_POST['batch_fails']?>"></td>
	</tr>
	<tr>
	<td align=right>Noapaļot diametru uz klases vidu:</td>
	<td align=left>
		<input type=checkbox name=noapalot_diametru></input>
	</td>
</tr>
	<tr>
	<td align=right>Noapaļot garumu uz decimetriem:</td>
	<td align=left>
		<input type=radio name=noapalot_garumu value="1"></input>
	</td>
</tr>
	<tr>
	<td align=right>Noapaļot garumu uz klases vidu:</td>
	<td align=left>
		<input type=radio name=noapalot_garumu value="2"></input>
	</td>
</tr>
	<tr>
	<td align=right>Nenoapaļot garumu:</td>
	<td align=left>
		<input type=radio name=noapalot_garumu value="3"></input>
	</td>
</tr>
	<tr>
	<td align=right>Pakešdatnes noapaļotie garumi:</td>
	<td align=left>
		<input type=checkbox name=is_vika></input>
	</td>
</tr>

	</table>
<br>

<? for ($grup=1;$grup<=9;$grup++) { ?>
<div id="grup<?=$grup?>" style="<? if ($grup > 1) { ?>display:none<? } ?>">
<b>Grupēšana <? if ($grup > 1) { echo $grup; } ?></b>
<br><br>
<table  bgcolor=#FDFFCF>
	<tr>
		<td align=right>Grupa 1</td>
		<td align=left><input value="Suga" readonly><input type=hidden name=gtype<?=$grup?>1 value="suga">
			<span id=lauks<?=$grup?>1>
			<input type=text name=gvalues<?=$grup?>1 value="<?=$xml_vars['gvalues'.$grup.'1']?>" size=15>
			<? parauga_poga($grup,1) ?>
			</span>
		</td>
		<td>
			<input type=checkbox name=dalit<?=$grup?>1 
				onclick="
				if (dalit<?=$grup?>1.checked) {
					lauks<?=$grup?>1.innerHTML = 'Priede:<input type=text name=gvalues<?=$grup?>1_1 value=\'<?=$xml_vars['gvalues'.$grup.'1_1']?>\' size=15><? parauga_poga2($grup,'1_1') ?> Egle:<input type=text name=gvalues<?=$grup?>1_2 value=\'<?=$xml_vars['gvalues'.$grup.'1_2']?>\' size=15><? parauga_poga2($grup,'1_2') ?>';
				}
				else
				{
					lauks<?=$grup?>1.innerHTML = '<input type=text name=gvalues<?=$grup?>1 value=\'<?=$xml_vars['gvalues'.$grup.'1']?>\' size=15><? parauga_poga2($grup,1) ?>';
				};
				">
		</td>
	</tr>
	<tr>
		<td align=right>Grupa 2</td>
		<td align=left><input  value="Diametrs pirms red" readonly><input type=hidden name=gtype<?=$grup?>2 value="mind_pirms_red">
			<span id=lauks<?=$grup?>2><input type=text name=gvalues<?=$grup?>2 value="<?=$xml_vars['gvalues'.$grup.'2']?>" size=15><? parauga_poga($grup,2) ?>
			</span>
		</td>
		<td>
			<input type=checkbox name=dalit<?=$grup?>2  
				onclick="
				if (dalit<?=$grup?>2.checked) {
					lauks<?=$grup?>2.innerHTML = 'Priede:<input type=text value=\'<?=$xml_vars['gvalues'.$grup.'2_1']?>\' name=gvalues<?=$grup?>2_1 size=15><? parauga_poga2($grup,'2_1') ?> Egle:<input type=text value=\'<?=$xml_vars['gvalues'.$grup.'2_2']?>\' name=gvalues<?=$grup?>2_2 size=15><? parauga_poga2($grup,'2_2') ?>';
				}
				else
				{
					lauks<?=$grup?>2.innerHTML = '<input type=text name=gvalues<?=$grup?>2 size=15><? parauga_poga2($grup,2) ?>';
				};
				">
		</td>
	</tr>
	<tr>
		<td align=right>Grupa 3</td>
		<td align=left><input value="Garums" readonly><input type=hidden name=gtype<?=$grup?>3 value="garums">
			<span id=lauks<?=$grup?>3><input type=text name=gvalues<?=$grup?>3 value="<?=$xml_vars['gvalues'.$grup.'3']?>" size=15><? parauga_poga($grup,3) ?>
			</span>
		</td>
		<td>
			<input type=checkbox name=dalit<?=$grup?>3
				onclick="
				if (dalit<?=$grup?>3.checked) {
					lauks<?=$grup?>3.innerHTML = 'Priede:<input type=text name=gvalues<?=$grup?>3_1  value=\'<?=$xml_vars['gvalues'.$grup.'3_1']?>\'  size=15><? parauga_poga2($grup,'3_1') ?> Egle:<input type=text name=gvalues<?=$grup?>3_2  value=\'<?=$xml_vars['gvalues'.$grup.'3_2']?>\' size=15><? parauga_poga2($grup,'3_2') ?>';
				}
				else
				{
					lauks<?=$grup?>3.innerHTML = '<input type=text name=gvalues<?=$grup?>3 size=15 value=\'<?=$xml_vars['gvalues'.$grup.'3']?>\'><? parauga_poga2($grup,3) ?>';
				};
				">
		</td>
	</tr>
	<tr>
		<td align=right>Grupa 4</td>
		<td align=left><input value="Brāķis" readonly><input type=hidden name=gtype<?=$grup?>4 value="brakis">
			<span id=lauks<?=$grup?>4>
			<input type=text name=gvalues<?=$grup?>4 value="<?=$xml_vars['gvalues'.$grup.'4']?>" size=15>
			<? parauga_poga($grup,4) ?>
			</span>
		</td>
		<td>
			<input type=checkbox name=dalit<?=$grup?>4
				onclick="
				if (dalit<?=$grup?>4.checked) {
					lauks<?=$grup?>4.innerHTML = 'Priede:<input type=text name=gvalues<?=$grup?>4_1 value=\'<?=$xml_vars['gvalues'.$grup.'4_1']?>\' size=15><? parauga_poga2($grup,'4_1') ?> Egle:<input type=text name=gvalues<?=$grup?>4_2 value=\'<?=$xml_vars['gvalues'.$grup.'4_2']?>\' size=15><? parauga_poga2($grup,'4_2') ?>';
				}
				else
				{
					lauks<?=$grup?>4.innerHTML = '<input type=text name=gvalues<?=$grup?>4 value=\'<?=$xml_vars['gvalues'.$grup.'4']?>\' size=15><? parauga_poga2($grup,4) ?>';
				};
				">
		</td>
	</tr>

<!--  <?for ($i=5;$i<=$grupu_sk;$i++) { ?>
	<tr>
		<td align=right>Grupa <?=$i?></td>
		<td align=left>
			<select name=gtype<?=$i?>>
			<? foreach ($ar as $v => $p) {
					echo "			<option value=\"$v\" "; 
					if ($_POST["gtype".$i]==$v) echo ' selected ';
					echo ">$p</option>\n"; };
			   ?>
			</select>
			<span id=lauks<?=$i?>>
			<input type=text name=gvalues<?=$i?> value="<?=$_POST["gvalues".$i]?>" size=15>
			<? parauga_poga($i) ?>
			</span>
		</td>
		<td>
			<input type=checkbox name=dalit<?=$i?> 
				onclick="
				if (dalit<?=$i?>.checked) {
					lauks<?=$i?>.innerHTML = 'Priede:<input type=text name=gvalues<?=$i?>_1 size=15><? parauga_poga2($i.'_1') ?> Egle:<input type=text name=gvalues<?=$i?>_2 size=15><? parauga_poga2($i.'_2') ?>';
				}
				else
				{
					lauks<?=$i?>.innerHTML = '<input type=text name=gvalues<?=$i?> size=15><? parauga_poga2($i) ?>';
				};
				">
		</td>
	</tr>
  <? } ?> -->
</table>

<table>
<tr>
	<td align=right>Nominālie garumi (cm)</td><td><span id=lauks_virsmeri<?=$grup?>><input type=text name=virsmeri<?=$grup?> value="<?=$xml_vars['virsmeri'.$grup]?>" size=40><?parauga_poga2($grup,70);?></span>
		
		<input type=checkbox name=dalit_virsmeri<?=$grup?> value="<?=$xml_vars['virsmeri'.$grup]?>"
			onclick="JavaScript:
			if (dalit_virsmeri<?=$grup?>.checked) {
				lauks_virsmeri<?=$grup?>.innerHTML = 'Priede:<input type=text name=virsmeri<?=$grup?>_1 value=\'<?=$xml_vars['virsmeri'.$grup.'_1']?>\' size=40><? parauga_poga2($grup,71) ?>Egle:<input type=text name=virsmeri<?=$grup?>_2 value=\'<?=$xml_vars['virsmeri'.$grup.'_2']?>\' size=40><? parauga_poga2($grup,72) ?>';
			}
			else
			{
				lauks_virsmeri<?=$grup?>.innerHTML = '<input type=text name=virsmeri<?=$grup?> value=\'<?=$xml_vars['virsmeri'.$grup]?>\' size=40><? parauga_poga2($grup,70) ?>';
			}">
	</td>
</tr>
<tr>

	<td align=right>Koeficients</td><td><span id=lauks_koeficients<?=$grup?>><input type=text name=koeficients<?=$grup?> size=10 value="<?=$xml_vars['koeficients'.$grup]?>"></span>
		<input type=checkbox name=dalit_koeficients<?=$grup?> 
			onclick="
			if (dalit_koeficients<?=$grup?>.checked) {
				lauks_koeficients<?=$grup?>.innerHTML = 'Priede:<input type=text name=koeficients<?=$grup?>_1 value=\'<?=$xml_vars['koeficients'.$grup.'_1']?>\' size=10>Egle:<input type=text name=koeficients<?=$grup?>_2 value=\'<?=$xml_vars['koeficients'.$grup.'_2']?>\' size=10>';
			}
			else
			{
				lauks_koeficients<?=$grup?>.innerHTML = '<input type=text name=koeficients<?=$grup?> value=\'<?=$xml_vars['koeficients'.$grup]?>\' size=10>';
			};
			">
	</td></tr>
<tr>
	<td align=right><label title="Formats: r1,d1-d2, r2,d3-d4, r3,d5-d6 utt.">Raukums:</label></td><td><span id=lauks_raukums<?=$grup?>><input type=text name=raukums<?=$grup?> size=40 value="<?=$xml_vars['raukums'.$grup]?>"><? parauga_poga2($grup,75) ?></span>
		<input type=checkbox name=dalit_raukums<?=$grup?> 
			onclick="
			if (dalit_raukums<?=$grup?>.checked) {
				lauks_raukums<?=$grup?>.innerHTML = 'Priede:<input type=text value=\'<?=$xml_vars['raukums'.$grup.'_1']?>\' name=raukums<?=$grup?>_1 size=40><? parauga_poga2($grup,73) ?>Egle:<input type=text value=\'<?=$xml_vars['raukums'.$grup.'_2']?>\' name=raukums<?=$grup?>_2 size=40><? parauga_poga2($grup,74) ?>';
			}
			else
			{
				lauks_raukums<?=$grup?>.innerHTML = '<input type=text value=\'<?=$xml_vars['raukums'.$grup]?>\' name=raukums<?=$grup?> size=40><? parauga_poga2($grup,75) ?>';
			};
			">
	</td>
</tr>
<? if ($grup < 9) { ?>
<tr>
	<td colspan="2" align="center">
Vēl grupēšanas nosacījumus: <input type="checkbox" onclick="if (this.checked) 
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



<br>

<? } ?>
</div></div></div></div></div></div></div></div></div>

<BR>
<b>Vairāku baču apstrāde</b><br><BR>
<table bgcolor=#FDFFCF>
	<tr>
		<td align=right>Izvēlēties failus</td>
		<td><input type=text name=pv><input type=button onclick="OpenPage('select_batches.php?type=<?=$veids?>');" value="..."></td>
	</tr>
	<tr>
		<td align=right>Nākamais VMF akta numurs</td>
		<td><input type=text name=akts size=5></td>
	</tr>
	<tr>
		<td align=right>Nākamais pārdevēja akta numurs</td>
		<td><input type=text name=aktsp size=5></td>
	</tr>
</table>

<BR>
<table><tr>
	<td align=right></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align=center colspan=2><input type=submit name=poga value="  Veidot XML  ">&nbsp;&nbsp;&nbsp;<input type=button name=poga2 value="  Veidot Atskaiti  " onClick="forma.action='report_view_test.php?veids=<?=$veids?>&h=<?=$h?>';forma.submit();"></td>
</tr>
</table>
<br>

<input type=hidden name=subm value=1>
</form>


<? function parauga_poga($grup,$num) { ?>
			<input type=button name=poga value="..." 
				onclick="
					//if (gtype<?=$grup?><?=$num?>.value=='garums' || gtype<?=$grup?><?=$num?>.value=='mind_pirms_red')
					//{
window.open('paraugs.php?tips='+gtype<?=$grup?><?=$num?>.value+'&field=forma.gvalues<?=$grup?><?=$num?>','Paraugs','toolbar=no,resizable=yes,width='+screen.width+',height='+screen.height+',left=0, top=0');
				">
<? } ?>

<? function parauga_poga2($grup,$num) { ?>	<input type=button name=poga<?=$grup?><?=$num?> value=... onclick=parauga_logs(this.name.substr(4,1),this.name.substr(5))> <? } ?>

</center>

</body>
<script>
function OpenPage(page) {
		var NewWindow=open('','popup','menubar=1,toolbar=1,location=1,directories=1,scrollbars=1,resizable=1,status=1,width=800,height=600');
	NewWindow.focus();
		window.open(page,target="popup");

  }

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

	if( num>=70) return;

	window.open('paraugs.php?tips='+t+'&field=forma.gvalues'+grup+num,'Paraugs',params);
}
</script>
</html>