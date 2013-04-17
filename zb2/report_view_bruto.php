<?

//set_time_limit(0); 
include ("db.inc.php");
include ("c_report_bruto.inc.php");
include ("lvm_assort_matrix.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;


if ($_POST['pv'])
{
	$pv_array = explode(',',$_POST['pv']);
	$akts = $_POST['akts']; 
	$aktsp = $_POST['aktsp']; 
	$aktsp = $_POST['aktsp']; 
	for ($i=0;$i<count($pv_array);$i++)
	{

		$_POST['pavadzime_id'] = $pv_array[$i];
		$_POST['akts'] = $akts;
		$_POST['aktsp'] = $aktsp;

		// nosakam piegādātāju
		$rpav = mysql_query("select * from pavadzime where id = ".$_POST['pavadzime_id']);
		$mpav = mysql_fetch_array($rpav);
		$kods = '3';
		if ($mpav['piegad_grupa']=='LVM')
			$kods = '1';
		if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika SMR')
			$kods = '2';
		if ($akts && $aktsp)
			$_POST['akts_nr_head'] = substr(date('Y'),3)."/2/$akts/$kods/$aktsp";

		$_POST['pavadzime']=$mpav['pavadzime'];
		$_POST['auto_head'] = $mpav['auto'];
		$_POST['soferis_head'] = $mpav['soferis'];
		$_POST['iecirknis_head'] = $mpav['iecirknis_pieg'] . ' ' . $mpav['iecirknis'];

		echo print_report();
		if ($i<count($pv_array)-1) 
			echo "<p style=\"page-break-after:always;\">";
		$akts++;
		$aktsp++;
	}
//	LVM
//		SALDUS MR
//		citi
//		5/2/VMF/1,2,3/PARD
}
else
{
	echo print_report();
}

function print_report()
{
	$output = '';

	$DB_CON = new C_DB('localhost', DATABASE, LOGIN,PWD);
	$C_REP=  new C_REPORT($_POST,$DB_CON,false);

	/////////////////////////////////////////////////////////////////////////
	$_POST['pavadzime_head'] = $_POST['pavadzime'];

	set_param('akts_nr',$_POST['akts_nr_head']);
	set_param('pircejs_head',$_POST['pircejs_head']);
	set_param('pircejs_regnum',$_POST['pircejs_regnum']);
	set_param('pardevejs_head',$_POST['pardevejs_head']);
	set_param('pardevejs_regnum',$_POST['pardevejs_regnum']);
	set_param('pieg_lig_num',$_POST['pieg_lig_num']);
	set_param('datums',$_POST['datums_head']);
	set_param('iecirknis',$_POST['iecirknis_head']);
	set_param('cirsmas_kods',$_POST['cirsmas_kods_head']);
	set_param('pavadzime_head',$_POST['pavadzime_head']);
	set_param('transport_firm',$_POST['transport_firm']);
	set_param('auto',$_POST['auto_head']);
	set_param('soferis',$_POST['soferis_head']);
	set_param('vieta',$_POST['vieta_head']);
	set_param('piezimes',$_POST['piezimes_head']);
	set_param('atbildigais',$_POST['atbildigais_head']);
	set_param('custom11',$_POST['custom11_head']);
	set_param('custom12',$_POST['custom12_head']);
	set_param('sortiments',$_POST['sortiments_head']);
	set_param('standarts',$_POST['standarts_head']);
	set_param('metode',$_POST['metode_head']);
	set_param('raukums',$_POST['raukums_head']);
	set_param('merinstruments',$_POST['merinstruments_head']);
	set_param('terminsh',$_POST['terminsh_head']);
	$xml_vars['gvalues1'] = $_POST['gvalues1'];
	$xml_vars['gvalues1_1'] = $_POST['gvalues1_1'];
	$xml_vars['gvalues1_2'] = $_POST['gvalues1_2'];
	$xml_vars['gvalues2'] = $_POST['gvalues2'];
	$xml_vars['gvalues2_1'] = $_POST['gvalues2_1'];
	$xml_vars['gvalues2_2'] = $_POST['gvalues2_2'];
	$xml_vars['gvalues3'] = $_POST['gvalues3'];
	$xml_vars['gvalues3_1'] = $_POST['gvalues3_1'];
	$xml_vars['gvalues3_2'] = $_POST['gvalues3_2'];
	$xml_vars['gvalues4'] = $_POST['gvalues4'];
	$xml_vars['gvalues4_1'] = $_POST['gvalues4_1'];
	$xml_vars['gvalues4_2'] = $_POST['gvalues4_2'];
	$xml_vars['virsmeri'] = $_POST['virsmeri'];
	$xml_vars['virsmeri_1'] = $_POST['virsmeri_1'];
	$xml_vars['virsmeri_2'] = $_POST['virsmeri_2'];
	$xml_vars['koeficients'] = $_POST['koeficients'];
	$xml_vars['koeficients_1'] = $_POST['koeficients_1'];
	$xml_vars['koeficients_2'] = $_POST['koeficients_2'];
	$xml_vars['raukums'] = $_POST['raukums'];
	$xml_vars['raukums_1'] = $_POST['raukums_1'];
	$xml_vars['raukums_2'] = $_POST['raukums_2'];
	$xml_vars['pavadzime'] = $_POST['pavadzime'];
	/////////////////////////////////////////////////////////////////////////

	if($C_REP->ERRORS)
		{
		$output = $output . "<html>";
		$output = $output . "<head>";
		$output = $output . "<title>Kļūda!</title>";
		$output = $output . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$output = $output . "</head>";
		$output = $output . "<center>";
		$output = $output . "<STYLE TYPE=\"text/css\">";
		$output = $output . "  TD { font-size: 12px; }";
		$output = $output . "</STYLE>";
		$output = $output . "</style>";
		$output = $output . "<body>";
		$output = $output . "<p class='pagestart'></p><center><br><br>";
		$output = $output . "<b><font color=red>Kļūda!</font></b>";
		$output = $output . "<br><br>";
		$output = $output . $C_REP->ERRORS;
		$output = $output . "</center>";
		$output = $output . "<br><br>";
		$output = $output . "<input type=button value=\"Atkārtot\" onclick=\"history.back(-1)\">";
		$output = $output . "</body>";
		$output = $output . "</html>";
		return $output;
		}

		$output = $output . "	<html>";
		$output = $output . "	<head>";
		$output = $output . "						 <title>Atskaite</title>";
		$output = $output . "						 <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";

		$output = $output . "						</head>";
		$output = $output . "						<center>";
		$output = $output . "	<STYLE TYPE=\"text/css\">";
		$output = $output . "	  TD { font-size: 12px; }";
		$output = $output . "	</STYLE>";
		$output = $output . "	<table border=0 width=90%>";
		$output = $output . "	<tr>";
		$output = $output . "	<td><img src=\"images/vmf.gif\"></td>";
		$output = $output . "	</tr>";
		$output = $output . "	<tr><td align=center>";
		$output = $output . "	<table>";
		$output = $output . "	<tr>";
		$output = $output . "	 <td align=center width=50></td>";
		$output = $output . "	 <td align=center valign=center><font size=5>Testēšanas pārskats nr. ".get_param('akts_nr')."</font></td>";
		$output = $output . "	</tr>";
		$output = $output . "	</table>";
		$output = $output . "	<br>";
		$output = $output . "	<table cellspacing=0 cellpadding=0>";

	 if ($_POST['contract_num']) { 
	 $output = $output . "<tr><td align=right>Līguma Nr.:&nbsp;</td><td>".$_POST['contract_num']."</td>";
	 } 
	 if ($_POST['pircejs_head']) { 
	 $output = $output . "<tr><td align=right>Pircējs:&nbsp;</td><td>".$_POST['pircejs_head']."</td>";
	 } 
	 if ($_POST['pardevejs_head']) { 
	 $output = $output . "<tr><td align=right>Pārdevējs:&nbsp;</td><td>".$_POST['pardevejs_head']."</td>";
	 } 
	 if ($_POST['datums_head']) { 
	 $output = $output . "<tr><td align=right>Datums:&nbsp;</td><td>".$_POST['datums_head']."</td>";
	 } 
	 if ($_POST['pavadzime_head']) { 
	 $output = $output . "<tr><td align=right>Pavadzīme:&nbsp;</td><td>".$_POST['pavadzime_head']."</td>";
	 } 
	 if ($_POST['iecirknis_head']) { 
	 $output = $output . "<tr><td align=right>Iecirknis:&nbsp;</td><td>".$_POST['iecirknis_head']."</td>";
	 } 
	 if ($_POST['auto_head']) { 
	 $output = $output . "<tr><td align=right>Automašīnas nr.:&nbsp;</td><td>".$_POST['auto_head']."</td>";
	 } 
	 if ($_POST['soferis_head']) { 
	 $output = $output . "<tr><td align=right>Šoferis:&nbsp;</td><td>".$_POST['soferis_head']."</td>";
	 } 
	 if ($_POST['vieta_head']) { 
	 $output = $output . "<tr><td align=right>Uzmērīšanas vieta:&nbsp;</td><td>".$_POST['vieta_head']."</td>";
	 } 
	 if ($_POST['custom12']) { 
	 $output = $output . "<tr><td align=right>".$custom11."&nbsp;</td><td>".$_POST['custom12']."</td>";
	 } 
	 if ($_POST['sortiments_head']) { 
	 $output = $output . "<tr><td align=right>Sortiments:&nbsp;</td><td>".$_POST['sortiments_head']."</td>";
	 } 
	 if ($_POST['standarts_head']) { 
	 $output = $output . "<tr><td align=right>Standarts:&nbsp;</td><td>".$_POST['standarts_head']."</td>";
	 } 
	 if ($_POST['metode_head']) { 
	 $output = $output . "<tr><td align=right>Metode un paņēmiens:&nbsp;</td><td>".$_POST['metode_head']."</td>";
	 } 
	 if ($_POST['raukums_head']) { 
	 $output = $output . "<tr><td align=right>Raukums:&nbsp;</td><td>".$_POST['raukums_head']."</td>";
	 } 
	 if ($_POST['merinstruments_head']) { 
	 $output = $output . "<tr><td align=right>Mērinstruments:&nbsp;</td><td>".$_POST['merinstruments_head']."</td>";
	 } 
	 if ($_POST['terminsh_head']) { 
	 $output = $output . "<tr><td align=right>Verificēšanas termiņš:&nbsp;</td><td>".$_POST['terminsh_head']."</td>";
	 } 
	$output = $output . "</table>";
	$output = $output . "<br><br><br>";
	$output = $output . "<table><tr><td>";

	$output = $output . $C_REP->GetHTML();

	$output = $output . '<BR><BR></td></tr>';
	 if ($_POST['piezimes_head']) { 
	 $output = $output . '<tr><td align=left>Piezīmes: '.$_POST['piezimes_head'].'</td></tr>';
	}
	$output = $output . "<tr><td height=20></td></tr>";
	$output = $output . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."</td></tr>";
	$output = $output . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Artilērijas iela 40, korpuss 12, Rīga, LV-1009 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
	$output = $output . "</table></table>";

	$output = $output . "</body>";
	$output = $output . "</html>";
	return $output;
}
?>