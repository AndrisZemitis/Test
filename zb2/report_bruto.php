<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

$grupu_sk = 5;
$ar = array ('' => '', 'auto' =>'Auto', 'brakis' => 'Brāķis', 'cenu_matrica' => 'Cenu matrica', 'cirsmas_kods' => 'Cirsmas kods', 'kad_piegad' => 'Datums', 'mind_pirms_red' => 'Diametrs pirms red', 'fsc' => 'FSC', 'garums' => 'Garums', 'kravas_id' => 'Kravas ID', 'pavadzime.pavadzime' => 'Pavadzīme', 'piegad_kods' => 'Piegādātājs', 'skira' => 'Šķira','soferis'=>'Šoferis', 'suga'=>'Suga', 'iecirknis'=>'Iecirknis');

if(!session_is_registered('xml_vars'))
{
session_start();
session_register('xml_vars');
}

menu($_GET['h']);
$h = $_GET['h'];

switch($h){
    case 6:
    $veids = "bruto";
    break;
}

?>
<center>
<form name=forma method=POST action="report_view_bruto.php" >

<table bgcolor=#BFDBBF>
	<tr>
		<td align=center colspan=2 bgcolor=#D1CFFF><b>Galvene</b><br>
		</td>
	</tr>

	<tr>
		<td align=right>Baļķu uzmērīšanas atskaite Nr.:</td>
		<td align=left>
		 <input type=text name=akts_nr_head size=20 value="<?=get_param('akts_nr')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pircējs:</td>
		<td align=left>
		 <input type=text name=pircejs_head size=35 value="<?=get_param('pircejs_head')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pircējs Reg.Num:</td>
		<td align=left>
		 <input type=text name=pircejs_regnum size=35 value="<?=get_param('pircejs_regnum')?>">
		</td>
	</tr>

	<tr>
		<td align=right>Pārdevējs:</td>
		<td align=left>
		 <input type=text name=pardevejs_head size=35 value="<?=get_param('pardevejs_head')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pārdevējs Reg.Num:</td>
		<td align=left>
		 <input type=text name=pardevejs_regnum size=35 value="<?=get_param('pardevejs_regnum')?>">
		</td>
	</tr>

	<tr>
		<td align=right>Piegādes līguma numurs:</td>
		<td align=left>
		 <input type=text name=pieg_lig_num size=20 maxlength=20 value="<?=get_param('pieg_lig_num')?>">
		</td>
	</tr>

	<tr>
		<td align=right>Datums:</td>
		<td align=left>
		 <input type=text name=datums_head size=20 value="<?=get_param('datums')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pavadzīme:</td>
		<td align=left>
		 <input type=text name=pavadzime_head size=20 value="<?=get_param('pavadzime_head')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Iecirknis:</td>
		<td align=left>
		 <input type=text name=iecirknis_head size=20 value="<?=get_param('iecirknis')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pārvadātāj-firmas nosaukums:</td>
		<td align=left>
		 <input type=text name=transport_firm size=35 value="<?=get_param('transport_firm')?>">
		</td>
	</tr>

	<tr>
		<td align=right>Automašīnas Nr.:</td>
		<td align=left>
		 <input type=text name=auto_head size=20 value="<?=get_param('auto')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Šoferis:</td>
		<td align=left>
		 <input type=text name=soferis_head size=20 value="<?=get_param('soferis')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Uzmērīšanas vieta:</td>
		<td align=left>
		 <input type=text name=vieta_head size=20 value="<?=get_param('vieta')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Piezīmes:</td>
		<td align=left>
		 <input type=text name=piezimes_head size=60 value="<?=get_param('piezimes')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Atbildīgā persona:</td>
		<td align=left>
		 <input type=text name=atbildigais_head size=20 value="<?=get_param('atbildigais')?>">
		</td>
	</tr>
	<tr>
		<td align=right><input type=text name=custom11_head size=10 value="<?=get_param('custom11')?>"></td>
		<td align=left>
		 <input type=text name=custom12_head size=20 value="<?=get_param('custom12')?>">
		</td>
	</tr>
		<tr>
		<td align=right>Sortiments:</td>
		<td align=left>
		 <input type=text name=sortiments_head size=20 value="<?=get_param('sortiments')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Standarts:</td>
		<td align=left>
		 <input type=text name=standarts_head size=20 value="<?=get_param('standarts')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Metode un paņēmiens:</td>
		<td align=left>
		 <input type=text name=metode_head size=20 value="<?=get_param('metode')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Raukums:</td>
		<td align=left>
		 <input type=text name=raukums_head size=20 value="<?=get_param('raukums')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Mērinstruments:</td>
		<td align=left>
		 <input type=text name=merinstruments_head size=20 value="<?=get_param('merinstruments')?>">
		</td>
	</tr>
	<tr>
		<td align=right>Verificēšanas termiņš:</td>
		<td align=left>
		 <input type=text name=terminsh_head size=20 value="<?=get_param('terminsh')?>">
		</td>
	</tr>

</table>

<br><br>

<table bgcolor=#BFDBBF>
	<tr>
		<td align=center colspan=2 bgcolor=#7EBF7E><b>Nosacījumi</b><br>
		</td>
	</tr>

	<tr>
		<td align=right title="dd mm gggg">Pavadzīmes datums no:</td>
		<td align=left>
		 <input type=text name=datums_no_diena size=2 value="<?=$_POST['datums_no_diena']?>">
		 <input type=text name=datums_no_menesis size=2 value="<?=$_POST['datums_no_menesis']?>">
		 <input type=text name=datums_no_gads size=5 value="<?=$_POST['datums_no_gads']?>">
		</td>
	</tr>
	<tr>
		<td align=right title="dd mm gggg">Pavadzīmes datums līdz:</td>
		<td align=left>
		 <input type=text name=datums_lidz_diena size=2 value="<?=$_POST['datums_lidz_diena']?>">
		 <input type=text name=datums_lidz_menesis size=2 value="<?=$_POST['datums_lidz_menesis']?>">
		 <input type=text name=datums_lidz_gads size=5 value="<?=$_POST['datums_lidz_gads']?>">
		</td>
	</tr>
	<tr>
		<td align=right>Pārdevejs:</td>
		<td align=left><input type=text name=piegad_grupa size=10 value="<?=$_POST['piegad_grupa']?>"></td>
	</tr>
	<tr>
		<td align=right>Pavadzīmes numurs:</td>
		<td align=left><input type=text name=pavadzime size=10 value="<?=$xml_vars['pavadzime']?>"></td>
	</tr>
	<tr>
		<td align=right>Cirsmas kods:</td>
		<td align=left>
		 <input type=text name=cirsmas_kods size=20 value="<?=$_POST['cirsmas_kods']?>">
		</td>
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
		<td align=right title="Piemēram: 38,39,40">Ielasītā faila ID:</td>
		<td align=left><input type=text name=batch_fails size=20 value="<?=$_POST['batch_fails']?>"></td>
	</tr>
	<tr>
		<td align=right>Iecirknis:</td>
		<td align=left><input type=text name="iecirknis_pieg" size=20 value="<?=$_POST['iecirknis_pieg']?>"></td>
	</tr>

</table>
<br>

<b>Grupēšana</b><br><br>
<table bgcolor=#FDFFCF>
  <?for ($i=1;$i<=$grupu_sk;$i++) { ?>
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
  <? } ?>
</table>

<table>
<tr>
	<td align=right>Nominālie garumi (cm):</td><td><span id=lauks_virsmeri><input type=text name=virsmeri size=40><?parauga_poga2(70);?></span>
		
		<input type=checkbox name=dalit_virsmeri 
			onclick="JavaScript:
			if (dalit_virsmeri.checked) {
				lauks_virsmeri.innerHTML = 'Priede:<input type=text name=virsmeri_1 size=40><? parauga_poga2(71) ?>Egle:<input type=text name=virsmeri_2 size=40><? parauga_poga2(72) ?>';
			}
			else
			{
				lauks_virsmeri.innerHTML = '<input type=text name=virsmeri size=40><? parauga_poga2(70) ?>';
			}">
	</td>
</tr>

<tr>
	<td align=right>Koeficients:</td><td><span id=lauks_koeficients><input type=text name=koeficients size=40><?parauga_poga2(76);?></span>
		
		<input type=checkbox name=dalit_koeficients 
			onclick="JavaScript:
			if (dalit_koeficients.checked) {
				lauks_koeficients.innerHTML = 'Priede:<input type=text name=koeficients_1 size=40><? parauga_poga2(77) ?>Egle:<input type=text name=koeficients_2 size=40><? parauga_poga2(78) ?>';
			}
			else
			{
				lauks_koeficients.innerHTML = '<input type=text name=koeficients size=40><? parauga_poga2(76) ?>';
			}">
	</td>
</tr>

<!--<tr>

	<td align=right>Koeficients:</td><td><span id=lauks_koeficients><input type=text name=koeficients size=10></span>
		<input type=checkbox name=dalit_koeficients 
			onclick="
			if (dalit_koeficients.checked) {
				lauks_koeficients.innerHTML = 'Priede:<input type=text name=koeficients_1 size=10>Egle:<input type=text name=koeficients_2 size=10>';
			}
			else
			{
				lauks_koeficients.innerHTML = '<input type=text name=koeficients size=10>';
			};
			">
	</td></tr>-->
<tr>
	<td align=right><label title="Formats: r1,d1-d2, r2,d3-d4, r3,d5-d6 utt.">Raukums:</label></td><td><span id=lauks_raukums><input type=text name=raukums size=40><? parauga_poga2(75) ?></span>
		<input type=checkbox name=dalit_raukums 
			onclick="
			if (dalit_raukums.checked) {
				lauks_raukums.innerHTML = 'Priede:<input type=text name=raukums_1 size=40><? parauga_poga2(73) ?>Egle:<input type=text name=raukums_2 size=40><? parauga_poga2(74) ?>';
			}
			else
			{
				lauks_raukums.innerHTML = '<input type=text name=raukums size=40><? parauga_poga2(75) ?>';
			};
			">
	</td>
</tr>
<tr>
	<td align=right></td>
	<td>&nbsp;</td>
</tr>
</table>

<br>

<b>Vairāku baču apstrāde</b><br><br>
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

<table>
<tr>
	<td align=center colspan=2><input type=submit name=poga value="    Veidot    "></td>
</tr>
</table>
<br>

<input type=hidden name=subm value=1> 
</form>

<script>
function OpenPage(page) {
		var NewWindow=open('','popup','menubar=1,toolbar=1,location=1,directories=1,scrollbars=1,resizable=1,status=1,width=800,height=600');
	NewWindow.focus();
		window.open(page,target="popup");

  }
</script>

<? function parauga_poga($num) { ?>
			<input type=button name=poga value="..." 
				onclick="
					//if (gtype<?=$num?>.value=='garums' || gtype<?=$num?>.value=='mind_pirms_red')
					//{
window.open('paraugs.php?tips='+gtype<?=$num?>.value+'&field=forma.gvalues<?=$num?>','Paraugs','toolbar=no,resizable=yes,width='+screen.width/2+',height='+screen.height/2+',left='+screen.width/4+', top='+screen.height/4);
				">
<? } ?>

<? function parauga_poga2($num) { ?>	<input type=button name=poga<?=$num?> value=... onclick=parauga_logs(this.name.substr(4))> <? } ?>

</center>
</body>
<script>
function parauga_logs(num)
{
	 var params = 'toolbar=no,resizable=yes,width='+screen.width/2+',height='+screen.height/2+',left='+screen.width/4+', top='+screen.height/4;

	if (num == '1_1')
		t = forma.gtype1.value;
	if (num == '1_2')
		t = forma.gtype1.value;
	if (num == '2_1')
		t = forma.gtype2.value;
	if (num == '2_2')
		t = forma.gtype2.value;
	if (num == '3_1')
		t = forma.gtype3.value;
	if (num == '3_2')
		t = forma.gtype3.value;
	if (num == '4_1')
		t = forma.gtype4.value;
	if (num == '4_2')
		t = forma.gtype4.value;
	if (num == '5_1')
		t = forma.gtype5.value;
	if (num == '5_2')
		t = forma.gtype5.value;
	if (num == '1')
		t = forma.gtype1.value;
	if (num == '2')
		t = forma.gtype2.value;
	if (num == '3')
		t = forma.gtype3.value;
	if (num == '4')
		t = forma.gtype4.value;
	if (num == '5')
		t = forma.gtype5.value;
	
	if (num == '70') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri','Paraugs', params);
	if (num == '71') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri_1','Paraugs',params);
	if (num == '72') window.open('paraugs.php?tips=virsmeri&field=forma.virsmeri_2','Paraugs',params);
	
	if (num == '73') window.open('paraugs.php?tips=raukums&field=forma.raukums_1','Paraugs',params);
	if (num == '74') window.open('paraugs.php?tips=raukums&field=forma.raukums_2','Paraugs',params);
	if (num == '75') window.open('paraugs.php?tips=raukums&field=forma.raukums','Paraugs', params);

	if (num == '76') window.open('paraugs.php?tips=koeficients&field=forma.koeficients','Paraugs', params);
	if (num == '77') window.open('paraugs.php?tips=koeficients&field=forma.koeficients_1','Paraugs',params);
	if (num == '78') window.open('paraugs.php?tips=koeficients&field=forma.koeficients_2','Paraugs',params);
	if( num>=70) return;


	window.open('paraugs.php?tips='+t+'&field=forma.gvalues'+num,'Paraugs',params);
}
</script>
</html>