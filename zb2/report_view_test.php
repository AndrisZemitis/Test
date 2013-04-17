<?

set_time_limit(600); 

require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/g_atskaite.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_connect.php');
ob_start();

include ("db.inc.php");
include ("lvm_assort_matrix.inc.php");
include ("../check_login.php");
include ("valoda.php");

if($_SERVER['REQUEST_METHOD']=="POST"){
	if($_POST['delete_template']>0){
		$query = "delete from g_sab_saturs where sablona_id = '".$_POST['delete_template']."'";
		mysql_query($query);
		$query = "delete from g_sabloni where id = '".$_POST['delete_template']."'";
		mysql_query($query);
		header('Location: '.$_SERVER['HTTP_REFERER'].'');
		die();
	}elseif($_POST['save_template']>0){ //Saglabājam šablonu un redirektējam atpakaļ
		$query = "INSERT INTO g_sabloni (atskaites_id, nosaukums, info) values ('".htmlspecialchars($_POST['save_template'])."','".htmlspecialchars($_POST['sab_nosaukums'])."','".htmlspecialchars($_POST['sab_info'])."')";
		mysql_query($query);
		$sablona_id = mysql_insert_id();
		foreach($_POST as $item => $data){
			$query = "INSERT INTO g_sab_saturs (sablona_id, lauks, vertiba) values ('".$sablona_id."','".htmlspecialchars($item)."','".htmlspecialchars($data)."')";
			mysql_query($query);
		}

		header('Location: '.$_SERVER['HTTP_REFERER'].'');
		die();
	}elseif ($_POST['replace_template'] > 0) {
		$sablona_id = $_POST['replace_template'];
		unset($_POST['replace_template']);
		unset($_POST['save_template']);
		unset($_POST['delete_template']);

		$query_del = "DELETE FROM g_sab_saturs WHERE sablona_id = '$sablona_id'";
		//echo($query_del . "<br /><br />");
		mysql_query($query_del);

		foreach($_POST as $item => $data){
			$query = "INSERT INTO g_sab_saturs (sablona_id, lauks, vertiba) values ('".$sablona_id."','".htmlspecialchars($item)."','".htmlspecialchars($data)."')";
			//echo $query;
			mysql_query($query);
		}

		header('Location: '.$_SERVER['HTTP_REFERER'].'');
		die();
	}
	//print_r($post_arr);
}

$atskaite_veids = $_GET["veids"];
$h = $_GET['h'];

//print_r(array_values($_POST));
/*
function sab_save($key,$prefix){
  if ($key){
    echo "Value = ".$prefix.'<br />';
    echo "_value = ".$key.'<br />'.'<br />';
  }
}
*/
array_walk($_POST, 'sab_save');

$output_pdf = false;

switch($atskaite_veids){
	case "2009":
		include ("c_report.inc_2009.php");
      $pavadzimes_tabula = "pavadzime";
	  break;
	case "2010":
		include ("c_report.inc_2010.php");
      $pavadzimes_tabula = "pavadzime";
	  $output_pdf = true;
	  break;
    case "all":
      include ("c_report.inc_test.php");
      $pavadzimes_tabula = "pavadzime";
    break;
    case "nelss":
      include ("c_report.inc_nelss.php");
      $pavadzimes_tabula = "nelss_pavadzime";
	  $atskaites_kods = 18;
    break;
    case "vika":
      include ("c_report.inc_vika.php");
      $pavadzimes_tabula = "pavadzime";
	  $atskaites_kods = 2;
    break;
    case "laiko":
      include ("c_report.inc_laiko.php");
      $pavadzimes_tabula = "pavadzime";
    break;
    case "akrs":
      include ("c_report.inc_akrs.php");
      $pavadzimes_tabula = "pavadzime";
    break;
    case "gaujaskoks":
      include ("c_report.inc_gaujaskoks.php");
      $pavadzimes_tabula = "gaujaskoks_pavadzime";
      $atskaites_kods = 21;
    break;
    case "smiltene":
      include ("c_report.inc_smiltene.php");
      $pavadzimes_tabula = "smiltene_pavadzime";
      $atskaites_kods = 23;
    break;
    case "bsw":
      include ("c_report.inc_bsw.php");
      $pavadzimes_tabula = "bsw_pavadzime";
      $atskaites_kods = 20;
    break;
    case "vudlande":
      include ("c_report.inc_vudlande.php");
      $pavadzimes_tabula = "vudlande_pavadzime";
      $atskaites_kods = 22;
    break;
    case "pata_ab":
      include ("c_report.inc_pata_ab.php");
      $pavadzimes_tabula = "pata_ab_pavadzime";
      $atskaites_kods = 24;
    break;
    case "stora_enso":
      include ("c_report.inc_stora_enso.php");
      $pavadzimes_tabula = "stora_enso_pavadzime";
      $atskaites_kods = 25;
    break;
    case "kurekss":
      include ("c_report.inc_kurekss.php");
      $pavadzimes_tabula = "k_pavadzime";
      $atskaites_kods = 27;
    break;
    case "latvijas_finieris":
      include ("c_report.inc_latvijas_finieris.php");
      $pavadzimes_tabula = "latvijas_finieris_pavadzime";
      $atskaites_kods = 26;
    break;
    case "piebalgas":
      include ("c_report.inc_piebalgas.php");
      $pavadzimes_tabula = "piebalgas_pavadzime";
      $atskaites_kods = 28;
    break;
}

$arrsum = array();
$C_REP = object;

if ($mlietotajs['g_report']!='Y') return;

if ($_POST['pv']){
    $pv_array = explode(',',$_POST['pv']);
    $akts = $_POST['akts']; 
    $aktsp = $_POST['aktsp']; 
    $aktsp = $_POST['aktsp'];
    if (!$atskaites_kods) {
		$atskaites_kods = substr($_POST['akts_nr_head'],2,2);
	}
    
    for ($i=0;$i<count($pv_array);$i++)
    {

        $_POST['pavadzime_id'] = $pv_array[$i];
        $_POST['akts'] = $akts;
        $_POST['aktsp'] = $aktsp;

        // nosakam piegādātāju
        $rpav = mysql_query("select * from ".$pavadzimes_tabula." where id = ".$_POST['pavadzime_id']);
        $mpav = mysql_fetch_array($rpav);
        $kods = '1';
        if ($mpav['piegad_grupa']=='LVM')
            $kods = '1';
            
        $piegad_compare = trim($mpav['piegad_grupa']);
        if ($piegad_compare == 'PATA')
            $kods = '6';

        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika SMR')
            $kods = '2';
        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika pirksana')
            $kods = '3';
        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika darbinieki')
            $kods = '4';
        if ($akts && $aktsp)
            $_POST['akts_nr_head'] = substr(date('Y'),2)."/$atskaites_kods/$akts/$kods/$aktsp";
        

        $_POST['pavadzime']=$mpav['pavadzime'];
        $_POST['auto_head'] = $mpav['auto'];
        $_POST['soferis_head'] = $mpav['soferis'];
        $_POST['iecirknis_head'] = $mpav['iecirknis_pieg'];

		if (!$output_pdf) {
			if ($i == 0) { echo ('<html><head>'); }
		}

        print_all_reports();

		if (!$output_pdf) {
			if ($i<count($pv_array)-1)
			{ 
	//          echo "Page_Break_Test";		
					echo "<p style='page-break-before:always;'>&nbsp;";
			}
			else
			{ 
				echo ('</head></html>'); 
			}
		}
        $akts++;
        $akts = sprintf("%03d",$akts);
//        echo $y;
        $aktsp++;
        $aktsp = sprintf("%03d",$aktsp);
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
    global $atskaite_veids;
    global $lang;
    global $translate;
    global $arrsum;
    global $C_REP;
	global $output_pdf;
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
        set_param('parbaudija',$_POST['parbaudija_head']);
        set_param('veidoja',$_POST['veidoja_head']);
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

        $xml_vars['virsmeri_brakim' . $grup] = $_POST['virsmeri_brakim' . $grup];
        $xml_vars['virsmeri_brakim' . $grup . '_1'] = $_POST['virsmeri_brakim' . $grup . '_1'];
        $xml_vars['virsmeri_brakim' . $grup . '_2'] = $_POST['virsmeri_brakim' . $grup . '_2'];

        $xml_vars['koeficients' . $grup] = $_POST['koeficients' . $grup];
        $xml_vars['koeficients' . $grup . '_1'] = $_POST['koeficients' . $grup . '_1'];
        $xml_vars['koeficients' . $grup . '_2'] = $_POST['koeficients' . $grup . '_2'];
        $xml_vars['raukums' . $grup] = $_POST['raukums' . $grup];
        $xml_vars['raukums' . $grup . '_1'] = $_POST['raukums' . $grup . '_1'];
        $xml_vars['raukums' . $grup . '_2'] = $_POST['raukums' . $grup . '_2'];
        $xml_vars['pavadzime'] = $_POST['pavadzime'];
        /////////////////////////////////////////////////////////////////////////

        if ($grup == 1) {

//        $output = $output . "	<html>";
//        $output = $output . "	<head>";

			if ($output_pdf) {
				
				require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/g-atskaite.php');

				$g_atskaite = new g_atskaite();
				$g_atskaite->open_pdf();
				$g_atskaite->report_header_pdf($_POST,$lang,$translate);
			} else {

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
				$output = $output . "<td align=right>VMF NI P 02.01.02.</td>";
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
				 if (strlen($_POST['soferis_head']) > 1) { 
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

        }

        $DB_CON = new C_DB('localhost', DATABASE, LOGIN,PWD);
        $C_REP=  new C_REPORT($_POST,$DB_CON,false,$grup);

		if($C_REP->ERRORS)
            {
//            $output = $output . "<html>";
//            $output = $output . "<head>";
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
/*            $output = $output . "<br><br>";
            $output = $output . "<input type=button value=\"Atkārtot\" onclick=\"history.back(-1)\">";
			$output = $output . "<br><br>";*/
//            $output = $output . "</body>";
//            $output = $output . "</html>";
            echo $output;
			return $output;
            }

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
            $arrfinal = array_merge($arrfinal,$C_REP->arr);
        }
    }
     
     if($_POST['reg_atsk'] == 'on'){
        $skaits = $arrsum[summa]->skaits;
        $skaits_brakis = $arrsum[summa]->skaits_bad;
        $bruto = $arrsum[summa]->bruto;
        $virsmers = $arrsum[summa]->virsmers;
        $redukcija_d = $arrsum[summa]->redukcija_d;
        $redukcija_l = $arrsum[summa]->redukcija_l;
        $redukcija_kopa = $redukcija_l + $redukcija_d;
        $brakis = $arrsum[summa]->brakis;
        $neto = $arrsum[summa]->neto;

        $pavadzime = $_POST['pavadzime'];
        $akta_nr = $_POST['akts_nr_head'];
        $pircejs = $_POST['pircejs_head'];
        $dataKey = explode("/",$_POST['akts_nr_head']);
        $atskaites_veids = get_AtskaitesVeids($dataKey[1]);
//        set_param('pircejs_regnum',$_POST['pircejs_regnum']);
        $pardevejs = $_POST['pardevejs_head'];
//        set_param('pardevejs_regnum',$_POST['pardevejs_regnum']);
        $liguma_nr = $h;
        $datums = $_POST['datums_head'];
        $datums = substr($datums,-5,4)."-".substr($datums,-8,2)."-".substr($datums,0,2);
        $iecirknis = $_POST['iecirknis_head'];
        $cirsmas_kods = $_POST['cirsmas_kods_head'];
//        set_param('pavadzime_head',$_POST['pavadzime_head']);
//        set_param('transport_firm',$_POST['transport_firm']);
        $auto = $_POST['auto_head'];
        $soferis = $_POST['soferis_head'];
        $vieta = AI_returnPlace($_POST['vieta_head']);
//        set_param('piezimes',$_POST['piezimes_head']);
//        set_param('atbildigais',$_POST['atbildigais_head']);
//        set_param('parbaudija',$_POST['parbaudija_head']);
        $veidoja = $_POST['veidoja_head'];
//        $atskaites_veids = $_GET["veids"];
//        set_param('custom11',$_POST['custom11_head']);
//        set_param('custom12',$_POST['custom12_head']);
        $sortiments = $_POST['sortiments_head'];
//        set_param('standarts',$_POST['standarts_head']);
        $metode = $_POST['metode_head'];
//        set_param('raukums',$_POST['raukums_head']);
//        set_param('merinstruments',$_POST['merinstruments_head']);
//        set_param('terminsh',$_POST['terminsh_head']);



     $regSQL = "INSERT INTO g_registrs (pircejs,pardevejs,atskaites_veids,akta_nr,pavadzime,datums_piegade,vieta,soferis,auto_nr,sortiments,skaits_kopa,bruto,neto,virsmers,redukcija,skaits_brakis,brakis,lietotajs_veidoja,atskaites_nr,opcija) VALUES ('$pircejs','$pardevejs','$atskaites_veids','$akta_nr','$pavadzime','$datums','$vieta','$soferis','$auto','$sortiments',$skaits,$bruto,$neto,$virsmers,$redukcija_kopa,$skaits_brakis,$brakis,'$veidoja','$liguma_nr','A')";
//echo "INSERT INTO g_registrs (pircejs,pardevejs,atskaites_veids,akta_nr,pavadzime,datums_piegade,vieta,soferis,auto_nr,sortiments,skaits_kopa,bruto,neto,virsmers,redukcija,skaits_brakis,brakis,lietotajs_veidoja,atskaites_nr,opcija) VALUES ('$pircejs','$pardevejs','$atskaites_veids','$akta_nr','$pavadzime','$datums','$vieta','$soferis','$auto','$sortiments',$skaits,$bruto,$neto,$virsmers,$redukcija_kopa,$skaits_brakis,$brakis,'$veidoja','$liguma_nr','A')";
     mysql_query($regSQL);
     }
     
     
	if (!$_POST['negrupet']) {
		usort($arrfinal,'CompareArrays');
	}
    $arrfinal[-1] = $C_REP->arr[-1];
    $C_REP->arr = $arrfinal;

	if (!$output_pdf) {
		$output = $output . $C_REP->GetHTML();
	} else {
		$C_REP->GetHTML($g_atskaite);
	}

	if ($output_pdf) {
		$show_reject_codes = !($atskaite_veids == 'vika' || $atskaite_veids == 'gaujaskoks' || $atskaite_veids == 'smiltene' || $atskaite_veids == 'bsw' || $atskaite_veids == 'vudlande' || $atskaite_veids == 'pata_ab');
		$g_atskaite->report_footer_pdf($_POST,$lang,$translate,$show_reject_codes);
		$location = $g_atskaite->pdf_save($atskaite_veids,$_POST['pavadzime']);

		echo "<a href='$location'>Atskaite PDF formātā</a><br /><br />";
	} else {

		$output = $output . '</table><BR><BR></td></tr>';
		if ($_POST['piezimes_head']) { 
			$output = $output . '<tr><td align=left>'.$translate['piezimes'][$lang].': '.$_POST['piezimes_head'].'</td></tr>';
		}

	/*Atskaite tiek pievienota papildus informācija par brāki, izņemot VIKAWOOD atskaiti*/  
	  if($atskaite_veids == 'vika' || $atskaite_veids == 'gaujaskoks' || $atskaite_veids == 'smiltene' || $atskaite_veids == 'bsw' || $atskaite_veids == 'vudlande' || $atskaite_veids == 'pata_ab'){
		  $output = $output . "<tr><td height=20></td></tr>";
	  }else{
		  $output = $output . "<tr><td height=1><br><font size=1><b>Brāķa kodu atšifrējums:</b><br/>0 - Par tievu <br/>1 - Par garu <br/>2 - Max resnākā vieta par lielu <br/>3 - Max tievgalis par lielu <br/>4 - Gadskārtas, Meža trupe, saspiesta koksne, gala plaisas <br/>5 - Sausānis, kaltuši, sānu plaisas <br/>6 - Zari <br>7 - Līkumainība <br/>8 - Cits <br/>9 - Par īsu <br/><br/></td></tr>";
	  }
	/************************************************************************************/
		if ($_POST['parbaudija_head'] == 0){
			 if ($_POST['parbaudija_un_atbildigais_head'] == 6) {
				  $output = $output . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."
																				<br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
				  $output = $output . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
				  $output = $output . "</table></table>";

	//	$output = $output . "</body>";
	//	$output = $output . "</html>";


				  echo $output;
			 } else {
				  $output = $output . "<tr><td align=left>Pārbaudīja/ atbildīgā persona ...................................................".get_person($_POST['parbaudija_un_atbildigais_head'])."
																				<br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
				  $output = $output . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
				  $output = $output . "</table></table>";
				  
	//           	$output = $output . "</body>";
	//	$output = $output . "</html>";
	   
				  echo $output;
			 }
		}else{
			 $output = $output . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."
																		   <br><br><br>Pārbaudīja ..............................................................".get_person($_POST['parbaudija_head'])."
																		   <br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
			 $output = $output . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
			 $output = $output . "</table></table>";
			 
	//          $output = $output . "</body>";
	//          $output = $output . "</html>";
			 
			 echo $output;

		}

	}
}

function get_person($person_value){
//     if($person_value == '1') $person = "Raimonds Svikšs<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29470031";
     if($person_value == '2') $person = "Jānis Buļs<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29470949";
     if($person_value == '3') $person = "Ingus Donis<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29122585";
     if($person_value == '4') $person = "S.Beņķe<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26447465";
     if($person_value == '5') $person = "G.Ziemele<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26595831";
     if($person_value == '10') $person = "G.Ceriņa<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29266992";
     if($person_value == '13') $person = "M.Sekste<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 20275737";
     if($person_value == '11') $person = "S.Grosvalde<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29455959";
     if($person_value == '7') $person = "Jānis Buļs<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29470949";
     if($person_value == '8') $person = "Ingus Donis<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29122585";
     if($person_value == '9') $person = "Aldis Ladusāns<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26386152";
     return $person;
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

function get_AtskaitesVeids($atskaiteNum){
     switch ($atskaiteNum){
          case 2:
          $result = "Vika Wood";
          break;
          case 7:
          $result = "Akrs";
          break;
          case 8:
          $result = "Kontrolmērījumi";
          break;
          case 16:
          $result = "Tezei S";
          break;
          case 10:
          $result = "Launkalne";
          break;
          case 15:
          $result = "Laiko";
          break;
          case 18:
          $result = "AKZ";
          break;
          case 19:
          $result = "Kubikmetrs";
          break;
          case 20:
          $result = "BSW Latvia";
          break;
          case 21:
          $result = "Gaujas Koks";
          break;
          case 22:
          $result = "Vudlande";
          break;
          case 23:
          $result = "Smiltene Impex";
          break;
          case 25:
          $result = "Stora Enso Timber";
          break;
          case 24:
          $result = "Pata AB";
          break;
          case 26:
          $result = "Latvijas Finieris";
          break;
          case 27:
          $result = "Kurekss";
          break;
          case 28:
          $result = "Piebalgas";
          break;
     }

     return $result;
  
}

function AI_returnPlace($stringREP){
  $arr_temp = explode('"',$stringREP);
  $meklet = 'sia';
  $meklet_2 = 'as';

  if(stristr($arr_temp[0],$meklet)){
    $result = $arr_temp[1];
  }else{
    $result = $arr_temp[0];
  }

  if(stristr($arr_temp[0],$meklet_2)){
    $result = $arr_temp[1];
  }

  $meklet_gk_1 = "kabpils";
  $meklet_gk_2 = "ulbene";
  $meklet_pata = "vidi";
  $meklet_lf = "bold";
  $meklet_lf_2 = "ver";
  
  if(stristr($arr_temp[2],$meklet_gk_1)){
    $result = "Jēkabpils";
  }
  
  if(stristr($arr_temp[2],$meklet_gk_2)){
    $result = "Gulbene";
  }

  if(stristr($arr_temp[1],$meklet_pata)){
    $result = "Mežvidi";
  }

  if(stristr($arr_temp[1],$meklet_lf)){
    $result = $arr_temp[1];
  }

  if(stristr($arr_temp[1],$meklet_lf_2)){
    $result = $arr_temp[1];
  }
  
  return $result;
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