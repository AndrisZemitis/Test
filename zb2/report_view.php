<?

set_time_limit(200); 
include ("db.inc.php");
include ("c_report.inc.php");
include ("lvm_assort_matrix.inc.php");
include ("../check_login.php");
include ("valoda.php");

require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/g_atskaite.php');

$arrsum = array();
$C_REP = object;

$atskaite_veids = $_GET["veids"];
$h = $_GET['h'];
//echo "H = ".$h." AtV. = ".$atskaite_veids.'<br />';

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
		$kods = '0';
		if ($mpav['piegad_grupa']=='LVM')
			$kods = '1';
		if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika SMR')
			$kods = '2';
		if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika pirksana')
			$kods = '3';
		if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika darbinieki')
			$kods = '4';
		if ($akts && $aktsp)
			$_POST['akts_nr_head'] = substr(date('Y'),3)."/2/$akts/$kods/$aktsp";

		$_POST['pavadzime']=$mpav['pavadzime'];
		$_POST['auto_head'] = $mpav['auto'];
		$_POST['soferis_head'] = $mpav['soferis'];
		$_POST['iecirknis_head'] = $mpav['iecirknis_pieg'] . ' ' . $mpav['iecirknis'];

		if ($i == 0) { echo ('<html><head>'); }

		print_all_reports();

		if ($i<count($pv_array)-1)
		{ echo "<p style='page-break-before:always;'>"; }
		else
		{ echo ('</head></html>'); }
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
	print_all_reports();
}

echo 'end of the report';

function print_all_reports()
{
	global $lang;
	global $translate;
	global $arrsum;
	global $C_REP;
	$arrfinal = array();
	$output = "";

	for ($grup=1;$grup<=$_POST['grup'];$grup++) 
	{	
		//Valoda
		if (isset($_POST['valoda'.$grup])) 
		{
			$lang = $_POST['valoda'.$grup];
		} else {
			$lang = 'LAT';
		}

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

		$xml_vars['gvalues' . $grup . '1'] = $_POST['gvalues' . $grup . '1'];
		$xml_vars['gvalues' . $grup . '1_1'] = $_POST['gvalues' . $grup . '1_1'];
		$xml_vars['gvalues' . $grup . '1_2'] = $_POST['gvalues' . $grup . '1_2'];
		$xml_vars['gvalues' . $grup . '2'] = $_POST['gvalues' . $grup . '2'];
		$xml_vars['gvalues' . $grup . '2_1'] = $_POST['gvalues' . $grup . '2_1'];
		$xml_vars['gvalues' . $grup . '2_2'] = $_POST['gvalues' . $grup . '2_2'];
		$xml_vars['gvalues' . $grup . '3'] = $_POST['gvalues' . $grup . '3'];
		$xml_vars['gvalues' . $grup . '3_1'] = $_POST['gvalues' . $grup . '3_1'];
		$xml_vars['gvalues' . $grup . '3_2'] = $_POST['gvalues' . $grup . '3_2'];
		$xml_vars['gvalues' . $grup . '4'] = $_POST['gvalues' . $grup . '4'];
		$xml_vars['gvalues' . $grup . '4_1'] = $_POST['gvalues' . $grup . '4_1'];
		$xml_vars['gvalues' . $grup . '4_2'] = $_POST['gvalues' . $grup . '4_2'];
		$xml_vars['virsmeri' . $grup] = $_POST['virsmeri' . $grup];
		$xml_vars['virsmeri' . $grup . '_1'] = $_POST['virsmeri' . $grup . '_1'];
		$xml_vars['virsmeri' . $grup . '_2'] = $_POST['virsmeri' . $grup . '_2'];
		$xml_vars['koeficients' . $grup] = $_POST['koeficients' . $grup];
		$xml_vars['koeficients' . $grup . '_1'] = $_POST['koeficients' . $grup . '_1'];
		$xml_vars['koeficients' . $grup . '_2'] = $_POST['koeficients' . $grup . '_2'];
		$xml_vars['raukums' . $grup] = $_POST['raukums' . $grup];
		$xml_vars['raukums' . $grup . '_1'] = $_POST['raukums' . $grup . '_1'];
		$xml_vars['raukums' . $grup . '_2'] = $_POST['raukums' . $grup . '_2'];
		$xml_vars['pavadzime'] = $_POST['pavadzime'];
		/////////////////////////////////////////////////////////////////////////

		if($C_REP->ERRORS)
			{
			//$output = $output . "<html>";
			//$output = $output . "<head>";
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
			//$output = $output . "</body>";
			//$output = $output . "</html>";
			return $output;
			}

		if ($grup == 1) {

		//$output = $output . "	<html>";
		//$output = $output . "	<head>";
		$output = $output . "						 <title>Atskaite ".$lang."</title>";
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
		$output = $output . "	<tr><td align=center valign='top'>";
		$output = $output . "	<table>";
		$output = $output . "	<tr>";
		$output = $output . "	 <td align=center width=50></td>";
		$output = $output . "	 <td align=center valign=center><font size=5>".$translate['virsraksts'][$lang].get_param('akts_nr')."</font></td>";
		$output = $output . "	</tr>";
		$output = $output . "	</table>";
		$output = $output . "	<br>";
		$output = $output . "	<table cellspacing=0 cellpadding=0>";

		 if ($_POST['contract_num']) { 
		 $output = $output . "<tr><td align=right>".$translate['liguma_nr'][$lang].":&nbsp;</td><td>".$_POST['contract_num']."</td>";
		 } 
		 if ($_POST['pircejs_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['pircejs'][$lang].":&nbsp;</td><td>".$_POST['pircejs_head']."</td>";
		 } 
		 if ($_POST['pardevejs_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['pardevejs'][$lang].":&nbsp;</td><td>".$_POST['pardevejs_head']."</td>";
		 } 
		 if ($_POST['datums_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['datums'][$lang].":&nbsp;</td><td>".$_POST['datums_head']."</td>";
		 } 
		 if ($_POST['pavadzime_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['pavadzime'][$lang].":&nbsp;</td><td>".$_POST['pavadzime_head']."</td>";
		 } 
		 if ($_POST['iecirknis_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['iecirknis'][$lang].":&nbsp;</td><td>".$_POST['iecirknis_head']."</td>";
		 } 
		 if ($_POST['auto_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['auto_nr'][$lang].":&nbsp;</td><td>".$_POST['auto_head']."</td>";
		 } 
		 if ($_POST['soferis_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['soferis'][$lang].":&nbsp;</td><td>".$_POST['soferis_head']."</td>";
		 } 
		 if ($_POST['vieta_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['uzm_vieta'][$lang].":&nbsp;</td><td>".$_POST['vieta_head']."</td>";
		 } 
		 if ($_POST['custom12']) { 
		 $output = $output . "<tr><td align=right>".$custom11."&nbsp;</td><td>".$_POST['custom12']."</td>";
		 } 
		 if ($_POST['sortiments_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['sortiments'][$lang].":&nbsp;</td><td>".$_POST['sortiments_head']."</td>";
		 } 
		 if ($_POST['standarts_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['standarts'][$lang].":&nbsp;</td><td>".$_POST['standarts_head']."</td>";
		 } 
		 if ($_POST['metode_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['metode'][$lang].":&nbsp;</td><td>".$_POST['metode_head']."</td>";
		 } 
		 if ($_POST['raukums_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['raukums'][$lang].":&nbsp;</td><td>".$_POST['raukums_head']."</td>";
		 } 
		 if ($_POST['merinstruments_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['merinst'][$lang].":&nbsp;</td><td>".$_POST['merinstruments_head']."</td>";
		 } 
		 if ($_POST['terminsh_head']) { 
		 $output = $output . "<tr><td align=right>".$translate['v_term'][$lang].":&nbsp;</td><td>".$_POST['terminsh_head']."</td>";
		 } 
		$output = $output . "</table>";
		$output = $output . "<br><br><br>";
		
		$output = $output . "<table><tr><td>";
		$output = $output . "<table border=0 cellspacing=0 cellpadding=0>";
		}

		$DB_CON = new C_DB('localhost', DATABASE, LOGIN,PWD);
		$C_REP=  new C_REPORT($_POST,$DB_CON,false,$grup);

		if ($grup == 1) {
			//šī ir pirmā grupēšanas nosacījumu kopa, kopējam summas no $arr
			$arrsum = $C_REP->arr[count($C_REP->arr)-1];
			if ($_POST['grup'] != 1) {
				$C_REP->arr[count($C_REP->arr)-1] = array();
			}
			$arrfinal = $C_REP->arr;
		} else {
			//šī nav pirmā grupēšanas nosacījumu kopa, tāpēc pieskaitam doto apakšsummu kopīgajai summai
			$arrsum[summa]->skaits = $arrsum[summa]->skaits + $C_REP->arr[count($C_REP->arr)-1][summa]->skaits;
			$arrsum[summa]->skaits_bad = $arrsum[summa]->skaits_bad + $C_REP->arr[count($C_REP->arr)-1][summa]->skaits_bad;
			$arrsum[summa]->bruto = $arrsum[summa]->bruto + $C_REP->arr[count($C_REP->arr)-1][summa]->bruto;
			$arrsum[summa]->virsmers = $arrsum[summa]->virsmers + $C_REP->arr[count($C_REP->arr)-1][summa]->virsmers;
			$arrsum[summa]->redukcija_d = $arrsum[summa]->redukcija_d + $C_REP->arr[count($C_REP->arr)-1][summa]->redukcija_d;
			$arrsum[summa]->redukcija_l = $arrsum[summa]->redukcija_l + $C_REP->arr[count($C_REP->arr)-1][summa]->redukcija_l;
			$arrsum[summa]->brakis = $arrsum[summa]->brakis + $C_REP->arr[count($C_REP->arr)-1][summa]->brakis;
			$arrsum[summa]->neto = $arrsum[summa]->neto + $C_REP->arr[count($C_REP->arr)-1][summa]->neto;
			if ($grup != $_POST['grup']) 
			{
				$C_REP->arr[count($C_REP->arr)-1] = array(); //ja nav pēdējā nosacījumu kopa, iztīram kopsummas rindu
			} else {
				$C_REP->arr[count($C_REP->arr)-1] = $arrsum; //ja ir pēdējā nosacījumu kopa, atgriežam kopsummu
			}
			//$C_REP->arr[-1] = array(); //virsrakstus nevajag
			$arrfinal = array_merge($arrfinal,$C_REP->arr);
		}

		

		/*
		if ($grup < $_POST['grup']) {
			echo "<p style='page-break-before:always;'>";
		}
		*/
	}

	usort($arrfinal,'CompareArrays');
	$arrfinal[-1] = $C_REP->arr[-1];
	$C_REP->arr = $arrfinal;
	$output = $output . $C_REP->GetHTML();

	$output = $output . '</table><BR><BR></td></tr>';
	if ($_POST['piezimes_head']) { 
		$output = $output . '<tr><td align=left>'.$translate['piezimes'][$lang].': '.$_POST['piezimes_head'].'</td></tr>';
	}
	$output = $output . "<tr><td height=20></td></tr>";
	$output = $output . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."</td></tr>";
	$output = $output . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Artilērijas iela 40, korpuss 12, Rīga, LV-1009 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
	$output = $output . "</table></table>";

	echo $output;
		
}

function CompareArrays($x,$y) 
{
	if ($x[0] == "" && $y[0] != "") {
		return 1;
	} elseif ($x[0] != "" && $y[0] == "") {
		return -1;
	} elseif ($x[0] > $y[0]) {
		return 1;
	} elseif ($x[0] < $y[0]) {
		return -1;
	} elseif ($x[1] == "" && $y[1] != "") {
		return 1;
	} elseif ($x[1] != "" && $y[1] == "") {
		return -1;
	} elseif ($x[1] > $y[1]) {
		return 1;
	} elseif ($x[1] < $y[1]) {
		return -1;
	} elseif ($x[2] == "" && $y[2] != "") {
		return 1;
	} elseif ($x[2] != "" && $y[2] == "") {
		return -1;
	} elseif ($x[2] > $y[2]) {
		return 1;
	} elseif ($x[2] < $y[2]) {
		return -1;
	} elseif ($x[3] == "" && $y[3] != "") {
		return 1;
	} elseif ($x[3] != "" && $y[3] == "") {
		return -1;
	} elseif ($x[3] > $y[3]) {
		return 1;
	} elseif ($x[3] < $y[3]) {
		return -1;
	} elseif ($x[4] == "" && $y[4] != "") {
		return 1;
	} elseif ($x[4] != "" && $y[4] == "") {
		return -1;
	} elseif ($x[4] > $y[4]) {
		return 1;
	} elseif ($x[4] < $y[4]) {
		return -1;
	} elseif ($x[-1] == "" && $y[-1] != "") {
		return -1;
	} elseif ($x[-1] != "" && $y[-1] == "") {
		return 1;
	} elseif ($x[-1] > $y[-1]) {
		return 1;
	} elseif ($x[-1] < $y[-1]) {
		return -1;
	} else {
		return 0;
	}
}

/*
function SortArray($array)
{
	$newarr = array();
	$cols = array();
	$arrsize = sizeof($array[-1]);
	echo $arrsize;
	$i = 0;

	foreach ($array as $key => $row) {
		for($i=0;$i<$arrsize;$i++) {
			$cols[$i][$key] = $row[$i];
		}
	}
	
	$sort_string = "array_multisort(";
	for($i=0;$i<$arrsize;$i++) {
		if ($i>=1 && $i<=5) {
			$sort_string = $sort_string . "\$cols[" . $i . "], SORT_ASC, ";
		}
	}

	$sort_string = $sort_string . "\$cols[0], SORT_ASC, ";

	for($i=0;$i<$arrsize;$i++) {
		if ($i>5) {
			$sort_string = $sort_string . "\$cols[" . $i . "], SORT_ASC, ";
		}
	}

	$sort_string = $sort_string . "\$array);";

	echo($sort_string);
	eval($sort_string);

	return $array;
}
*/
?>