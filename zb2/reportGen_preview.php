<?
set_time_limit(4900); 

require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/libs/firebug/fb.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/clsMakeZipFile.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_connect.php');
ob_start();

include ("clsFuncDB.php");
include ("lvm_ApUdaViSta.php");
include ("../check_login.php");
include ("valoda.php");
include ("GenCLS_report.php");
//include ("GenCLS_bin.php");

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

array_walk($_POST, 'sab_save');

$output_pdf = (isSet($_GET['pdf']));
$output_xml = (isSet($_GET['xml']));

$arrsum = array();
$C_REP = object;

$subMakeAll = false;
if($atskaite_veids == "akrs"){
  $subMakeAll = true;
}
if ($mlietotajs['g_report']!='Y') return;

//--------------------------------------------------------------
  $prefix_subname = tmp_getTableName($atskaite_veids);
//  die($_POST['pv']);  
      $pv_array = explode(',',$_POST['pv']);
      $akts = $_POST['akts']; 
      $aktsp = $_POST['aktsp']; 
      $aktsp = $_POST['aktsp'];
      
//      if (!$atskaites_kods) { $atskaites_kods = substr($_POST['akts_nr_head'],2,2); }
//      echo $atskaites_kods;
//      if (!$output_pdf) {
        if ($i == 0) { echo ('<html><head><STYLE TYPE=\"text/css\"> TD { font-size: 12px; } </STYLE><title>Atskaite</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"></head><body><center>'); }
//      }
      
      $check_dir = true;
      
      for ($i=0;$i<count($pv_array);$i++){

          $_POST['pavadzime_id'] = $pv_array[$i];
          $_POST['akts'] = $akts;
          $_POST['aktsp'] = $aktsp;

          $tmp_getPavadzimeData_txt = "SELECT * FROM `{$prefix_subname}pavadzime` WHERE `id` = ".$_POST['pavadzime_id'];
          $rpav = mysql_query($tmp_getPavadzimeData_txt);
          $mpav = mysql_fetch_assoc($rpav);

          $kods = '1';
          if ($mpav['piegad_grupa']=='LVM'){ $kods = '1';}
          if ($mpav['piegad_kods']=='MET'){ $kods = '12';}
          if ($mpav['piegad_kods']=='TZS'){ $kods = '13';}

        if ($mpav['piegad_grupa']=='SWL'){
            $atskaites_kods = 11;
            $output_xml_dir = "Swedwood";
        }
        
        if ($mpav['piegad_grupa']=='RBT'){
            $atskaites_kods = 12;
            $output_xml_dir = "Rettenmeier";
        }
        
        if ($mpav['piegad_grupa']=='PIE'){
            $atskaites_kods = 28;
            $output_xml_dir = "Piebalgas";
        }
        
        if ($mpav['piegad_grupa']=='SMR'){
            $atskaites_kods = 24;
            $output_xml_dir = "Saldus_MR";
        }
        
        if ($mpav['piegad_grupa']=='4PL'){
            $atskaites_kods = 33;
            $output_xml_dir = "4_Plus";
        }

        if ($mpav['piegad_grupa']=='OSU'){
            $atskaites_kods = 29;
            $output_xml_dir = "Osukalns";
        }

        if ($mpav['piegad_grupa']=='Kurekss'){
            $atskaites_kods = 27;
            $output_xml_dir = "Kurekss";
        }

        if ($mpav['piegad_grupa']=='STO'){
            $atskaites_kods = 25;
            $output_xml_dir = "Stora_Enso_Timber";
        }

        if ($mpav['piegad_grupa']=='AKZ'){
            $atskaites_kods = 18;
            $output_xml_dir = "AKZ";
        }

        if ($mpav['piegad_grupa']=='SMI'){
            $atskaites_kods = 23;
            $output_xml_dir = "Smiltene_Impex";
        }

        if ($mpav['piegad_grupa']=='BSW'){
            $atskaites_kods = 20;
            $output_xml_dir = "BSW_Latvia";
        }

        if ($mpav['piegad_grupa']=='LF'){
            $atskaites_kods = 26;
            $output_xml_dir = "Latvijas_Finieris";
        }

        if ($mpav['piegad_grupa']=='GK'){
            $atskaites_kods = 21;
            $output_xml_dir = "Gaujas_Koks";
        }

        if ($mpav['piegad_grupa']=='VUD'){
            $atskaites_kods = 22;
            $output_xml_dir = "Vudlande";
        }

        if ($mpav['piegad_grupa']=='TZS'){
            $atskaites_kods = 16;
            $output_xml_dir = "Tezei-S";
        }

        if ($mpav['piegad_grupa']=='VP1'){
            $atskaites_kods = 46;
            $output_xml_dir = "Varpas 1";
        }

        if ($mpav['piegad_grupa']=='LTV'){
            $atskaites_kods = 54;
            $output_xml_dir = "Latvani";
        }

        if ($mpav['piegad_grupa']=='KUB'){
            $atskaites_kods = 19;
            $output_xml_dir = "Kubikmetrs";
        }

        if ($mpav['piegad_grupa']=='JMR'){
            $atskaites_kods = 55;
            $output_xml_dir = "Jekabpils_MR";
        }

        if ($mpav['piegad_grupa']=='LVM' || $mpav['piegad_grupa']=='Vika'){
            $atskaites_kods = 2;
            $output_xml_dir = "Vika_Wood";
        }

        if(!$atskaites_kods){
          $atskaites_kods = getReportTypeIfEmpty($atskaite_veids);
          $akts_arr = explode('/',$_POST['akts_nr_head']);
          $atskaites_kods = $akts_arr[1];
          $output_xml_dir = "Kontrolmerijumi";
        }

          if ($akts && $aktsp){
           if($atskaites_kods != 666){
            $_POST['akts_nr_head'] = substr(date('Y'),2)."/$atskaites_kods/$akts/$kods/$aktsp";
           }else{
            $_POST['akts_nr_head'] = "12/$atskaites_kods/$akts/$kods/$aktsp";
           }
          }

          $_POST['pavadzime'] = $mpav['pavadzime'];
/*
          if($atskaites_kods == 27){
            $arr_Compare = AI_getcompare($_POST['pavadzime'],'test');
            $_POST['akts_nr_head'] = $arr_Compare['akta_nr'];
          }
*/
          if($_POST['pircejs_head']){ $_POST['head']['pircejs_head'] = $_POST['pircejs_head'];}
          if($mpav['pircejs_regnum']){$_POST['head']['pircejs_regnum'] = $mpav['pircejs_regnum'];}
          if($_POST['pardevejs_head']){$_POST['head']['pardevejs_head'] = $_POST['pardevejs_head'];}
          if($mpav['pardevejs_regnum']){$_POST['head']['pardevejs_regnum'] = $mpav['pardevejs_regnum'];}
          if($mpav['pavadzime']){$_POST['head']['pavadzime'] = "<b>".$mpav['pavadzime']."</b>";}else{$_POST['head']['pavadzime'] = "<b>".$_POST['pavadzime_head']."</b>";}
          if($mpav['kad_piegad']){$_POST['head']['kad_piegad'] = "<b>".dateFormatChange(substr($mpav['kad_piegad'],0,10))."</b>";}else{$_POST['head']['kad_piegad'] = "<b>".$_POST['datums_head']."</b>";}
          
          if($subMakeAll){
            $_POST['head']['kad_piegad'] = "<b>".$_POST['datums_head']."</b>";
          }
          
          if($mpav['auto']){$_POST['head']['auto_head'] = $mpav['auto'];}
          if($mpav['soferis']){$_POST['head']['soferis_head'] = $mpav['soferis'];}
          if($mpav['transport_firm']){$_POST['head']['transport_firm'] = $mpav['transport_firm'];}
          if(trim($mpav['fsc']) != ''){$_POST['head']['fsc'] = $mpav['fsc'];}
          if($mpav['kad_uzmer']){$_POST['head']['kad_uzmer'] = dateFormatChange(substr($mpav['kad_uzmer'],0,10));}
          if($mpav['kad_piegad']){$_POST['head']['kad_piegad'] = dateFormatChange(substr($mpav['kad_piegad'],0,10));}
          if($mpav['transp_darba_uzd']){$_POST['head']['transp_darba_uzd'] = $mpav['transp_darba_uzd'];}
          if($mpav['cirsmas_kods']){$_POST['head']['cirsma_head'] = $mpav['cirsmas_kods'];}
          if($mpav['iecirknis_pieg']){$_POST['head']['iecirknis_head'] = $mpav['iecirknis_pieg'];}
          if($_POST['vieta_head']){$_POST['head']['vieta_head'] = $_POST['vieta_head'];}
          if($_POST['custom12_head']){$_POST['head']['custom12_head'] = $_POST['custom12_head'];}
          if($_POST['standarts_head']){$_POST['head']['standarts_head'] = $_POST['standarts_head'];}
          if($_POST['metode_head']){$_POST['head']['metode_head'] = $_POST['metode_head'];}
          if($_POST['sortiments_head']){$_POST['head']['sortiments_head'] = $_POST['sortiments_head'];}
          if($_POST['raukums_head']){$_POST['head']['raukums_head'] = $_POST['raukums_head'];}
          if($_POST['merinstruments_head']){$_POST['head']['merinstruments_head'] = $_POST['merinstruments_head'];}
          if($_POST['terminsh_head']){$_POST['head']['terminsh_head'] = $_POST['terminsh_head'];}
//          if($_POST['piezimes_head']){$_POST['head']['piezimes_head'] = $_POST['piezimes_head'];}
          
          $akta_rinda = explode('/',$_POST['akts_nr_head']);
          $_POST['kods'] = $akta_rinda[3];

          if($check_dir && $output_xml){
            $dir_byDate = Date("d_m_Y");
            $returnResult = bld_XMLDirZGB($output_xml_dir,$dir_byDate,0);
          }
          
          if($output_pdf){
            $dir_byDate = Date("d_m_Y");
            $returnResult = bld_XMLDirZGB($output_xml_dir,$dir_byDate,1);
          } 
          
          $check_dir = false;
          
          $dir_result_arr = print_all_reports($atskaites_kods,$returnResult[0]);
        
          if ($i<count($pv_array)-1){ echo "<p style='page-break-before:always;'>&nbsp;";}

          $akts++;
          $akts = sprintf("%03d",$akts);
          $aktsp++;
          $aktsp = sprintf("%03d",$aktsp);
      }

      echo '<br /><br />- End of report -';

      if($output_xml){
        $test_name = $returnResult[0].".zip";
        $test_dir = $returnResult[0];
        $zip = new ZipFolder($test_name, $test_dir, '.svn');
        echo '<br /><br /><table><tr align="center" bgcolor=EEEEEE><td align="center" colspan="2"><a href="'.$test_name.'"><b>Lejuplādēt XML failu</b></a></td></tr></table>';
      }

      if($output_pdf){
        $test_name = $returnResult[0].".zip";
        $test_dir = $returnResult[0];
//        $zip = new ZipFolder($test_name, $test_dir, '.svn');
        echo '<br /><br /><table><tr align="center" bgcolor=EEEEEE><td align="center" colspan="2"><a href="'.$test_name.'"><b>Lejuplādēt PDF failu</b></a></td></tr></table>';
      }

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

function print_all_reports($atskaites_kods, $tmp_returnResult){
    global $lang;
    global $translate;
    global $arrsum;
    global $C_REP;
    global $pavadzimes_tabula;
    global $output_pdf;
    global $subMakeAll;
    global $output_xml;
    global $prefix_subname;
    global $output_xml_dir;
    $arrfinal = array();
    $output = "";

    $tmp_translation['pavadzime'] = "<b>Pavadzīme</b>";
    $tmp_translation['fsc'] = "Sertifikācija";
    $tmp_translation['transp_darba_uzd'] = "Transp. darba uzd.";
    $tmp_translation['pircejs_regnum'] = "Pircējs Reg. Num.";
    $tmp_translation['pardevejs_regnum'] = "Pārdevējs Reg. Num.";
    $tmp_translation['transport_firm'] = "Transp. firma";
    $tmp_translation['kad_piegad'] = "<b>Pavadzīmes datums</b>";
    $tmp_translation['kad_uzmer'] = "Uzm. datums";
    $tmp_translation['auto_head'] = "Automašīnas nr.";
    $tmp_translation['soferis_head'] = "Šoferis";
    $tmp_translation['iecirknis_head'] = "Iecirknis";
    $tmp_translation['pircejs_head'] = "Pircējs";
    $tmp_translation['pardevejs_head'] = "Pārdevējs";
    $tmp_translation['standarts_head'] = "Standarts";
    $tmp_translation['metode_head'] = "Metode";
    $tmp_translation['cirsma_head'] = "Cirsma";
    $tmp_translation['iecirknis_head'] = "Iecirknis";
    $tmp_translation['vieta_head'] = "Uzmērīšanas vieta";
    $tmp_translation['custom12_head'] = $_POST['custom11_head'];
    $tmp_translation['piezimes_head'] = "Piezīmes";
    $tmp_translation['sortiments_head'] = "Sortiments";
    $tmp_translation['raukums_head'] = "Raukums";
    $tmp_translation['merinstruments_head'] = "Mērinstruments";
    $tmp_translation['terminsh_head'] = "Pārbaudes termiņš";

    $lang = 'LAT';
    if(trim($_POST['pavadzime'])!=''){$_POST['pavadzime_head'] = $_POST['pavadzime'];}

    set_param('akts_nr',$_POST['akts_nr_head']);
    set_param('fsc', $_POST['fsc']);
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


			if ($output_pdf) {
				
				require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/g-atskaite.php');

				$g_atskaite = new g_atskaite();
				$g_atskaite->open_pdf();
				$g_atskaite->report_header_pdf($_POST,$lang,$translate);
			}else{

				$newOutput = $newOutput . "						 <title>Atskaite ".$lang."</title>";
				$newOutput = $newOutput . "						 <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";

				$newOutput = $newOutput . "						</head>";
				$newOutput = $newOutput . "						<center>";
				$newOutput = $newOutput . "	<STYLE TYPE=\"text/css\">";
				$newOutput = $newOutput . "	  TD { font-size: 12px; }";
				$newOutput = $newOutput . "	</STYLE>";

				$newOutput = $newOutput . "	<table border=0 width=90%><td align=center valign='top'>";
				$newOutput = $newOutput . "	<table border=0 width=100%><tr>";
				if(($atskaites_kods == 16 || $subMakeAll) && !$output_pdf){
          $newOutput = $newOutput . "	<td width=540><img src=\"images/vmf.gif\"></td><td align=center>VMF&nbsp;MI&nbsp;P&nbsp;02.01.02.\n<br />3. variants (22.02.2011.)</td></tr></table><table><tr><td align=center width=50></td>";
				}else{
          $newOutput = $newOutput . "	<td width=540><img src=\"images/vmf.gif\"></td><td align=center>VMF&nbsp;MI&nbsp;P&nbsp;02.01.04.\n<br />1. variants (12.11.2010.)</td></tr></table><table><tr><td align=center width=50></td>";
				}
				$newOutput = $newOutput . "	 <td align=center valign=center><font size=5>Testēšanas pārskats nr.".get_param('akts_nr')."</font></td>";
				$newOutput = $newOutput . "	</tr></table><br><table cellspacing=0 cellpadding=0 style=\"width:850;\">";

        foreach($_POST['head'] as $key => $tmp_item_head){
           $newOutput = $newOutput . "<tr><td align=right><font size=3>".$tmp_translation[$key].":&nbsp;</font></td><td><font size=3>".$tmp_item_head."</font></td>";
        }

				$newOutput = $newOutput . "</table><br>";
      }

        //Insert Global new
        $genGlobal_registrs_id = 0;
        if(!$output_xml && !$output_pdf){
          if($_POST['reg_atsk'] == 'on'){
            $pavadzime_tmpIns = $_POST['pavadzime'];
            $mysqlGlobal_registrs_insert_txt = "INSERT INTO `g_registrs` (`datums_registrets`,`pavadzime`,`opcija`) values ('".date("Y-m-d H:i:s")."','{$pavadzime_tmpIns}','U')";
            $mysqlGlobal_registrs_insert = mysql_query($mysqlGlobal_registrs_insert_txt);
            $genGlobal_registrs_id = mysql_insert_id();
          }
        }
        
        $DB_CON = new C_DB('localhost', DATABASE, LOGIN,PWD);
        $C_REP =  new C_REPORT($_POST,$DB_CON,$output_xml,$prefix_subname,$atskaites_kods,$output_pdf,$subMakeAll,$genGlobal_registrs_id,$pavadzime_tmpIns);

        $newOutput .= "<table style=\"border-width:1px;border-style:solid;width:750;\">";
        foreach($C_REP->arrPrintOut as $tmp_item_1){
          if($tmp_item_1['nosaukums'] == 1){
            $newOutput .= "<tr bgcolor=\"#e1e1e1\" style=\"font-weight:bold;\">";
          }else{ $newOutput .= "<tr>"; }
          
          foreach($tmp_item_1 as $key => $tmp_item_2){
            if(($atskaites_kods == 16 || $atskaites_kods == 666 || $subMakeAll || trim($_POST['pavadzime_head']) == '') && !$output_pdf){
              if($key != "nosaukums" && $key != "brakis_un_neto" && $key != "redukcija_un_virsmers"){
  //            if($key != "nosaukums"){
                $newOutput .= "<td align=center ><font size=3>";
                $newOutput .= $tmp_item_2;
                $newOutput .= "</font></td>";
              }
            }else{
              if($key != "nosaukums" && $key != "garums" && $key != "virsmers" && $key != "redukcija" && $key != "redukcija_un_virsmers"){
  //            if($key != "nosaukums"){
                $newOutput .= "<td align=center ><font size=3>";
                $newOutput .= $tmp_item_2;
                $newOutput .= "</font></td>";
              }
            }
          }
          $newOutput .= "</tr>";
        }
        $newOutput .= "</table><br /><br /><br /><br />";

        if ($_POST['piezimes_head']) { 
          $newOutput = $newOutput . '<tr><td align=left>'.$tmp_translation['piezimes_head'].': '.$_POST['piezimes_head'].'<br /><br /><br /><br /><br /></td></tr>';
        }

        if ($_POST['parbaudija_head'] == 0){
           if ($_POST['parbaudija_un_atbildigais_head'] == 6) {
              $newOutput = $newOutput . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."
                                            <br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
              $newOutput = $newOutput . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
              $newOutput = $newOutput . "</table>";
           } else {
              $newOutput = $newOutput . "<tr><td align=left>Pārbaudīja/ atbildīgā persona ...................................................".get_person($_POST['parbaudija_un_atbildigais_head'])."
                                            <br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
              $newOutput = $newOutput . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
              $newOutput = $newOutput . "</table>";
           }
        }else{
           $newOutput = $newOutput . "<tr><td align=left>".$translate['atb_persona'][$lang]." ...................................................".$_POST['atbildigais_head']."
                                           <br><br><br>Pārbaudīja ..............................................................".get_person($_POST['parbaudija_head'])."
                                           <br><br><br>Sagatavoja ".get_person($_POST['veidoja_head'])."</td></tr>";
           $newOutput = $newOutput . "<tr><td align=right><br><font size=1>".$translate['veikts'][$lang]." SIA VMF LATVIA  <br>Reģ.nr.: 40003405130<br>Skaistkalnes iela 1, Rīga, LV-1004 <br>".$translate['talrunis'][$lang]." +371 29470949 ".$translate['fakss'][$lang]." + 371 67223718 ".$translate['epasts'][$lang]." vmflatvia@vmf.lv</td></tr>";
           $newOutput = $newOutput . "</table>";
        }
     
     if(!$output_xml && !$output_pdf){
       if($_POST['reg_atsk'] == 'on'){
          $skaits = $C_REP->regSuperSum[skaits];
          $skaits_brakis = $C_REP->regSuperSum[skaits_brakis];
          $bruto = $C_REP->regSuperSum[bruto];
          $virsmers = $C_REP->regSuperSum[virsmers];
          $redukcija_kopa = $C_REP->regSuperSum[redukcija];
          $brakis = $C_REP->regSuperSum[brakis];
          $neto = $C_REP->regSuperSum[neto];

          $pavadzime = $_POST['pavadzime'];
          if(trim($_POST['pavadzime']) == ''){$pavadzime = $_POST['pavadzime_head'];}
          $akta_nr = $_POST['akts_nr_head'];
          $pircejs = $_POST['head']['pircejs_head'];
          $dataKey = explode("/",$_POST['akts_nr_head']);
          $atskaites_veids = get_AtskaitesVeids($dataKey[1]);
          $pardevejs = $_POST['head']['pardevejs_head'];
          $liguma_nr = $h;
          $datums = $_POST['head']['kad_uzmer'];
          $datums_piegade = $_POST['head']['kad_piegad'];
          $temp_datums = $datums;
          $temp_datums_arr = explode('.',$temp_datums);
          $datums = $temp_datums_arr[2].'-'.$temp_datums_arr[1].'-'.$temp_datums_arr[0];

          $temp_datums_piegad_arr = explode('.',$datums_piegade);
          $datums_piegade = $temp_datums_piegad_arr[2].'-'.$temp_datums_piegad_arr[1].'-'.$temp_datums_piegad_arr[0];

          if($_POST['datums_head']){
            $datums = $_POST['datums_head'];
            $datums = substr($datums,-5,4)."-".substr($datums,-8,2)."-".substr($datums,0,2);
          }
          $iecirknis = $_POST['iecirknis_head'];
          $piegade = $_POST['kods'];
          $cirsmas_kods = $_POST['cirsmas_kods_head'];
          $auto = $_POST['head']['auto_head'];
          $soferis = $_POST['head']['soferis_head'];
          $vieta = AI_returnPlace($_POST['vieta_head']);
          $veidoja = $_POST['veidoja_head'];
          $sortiments = $_POST['head']['sortiments_head'];
          $metode = $_POST['head']['metode_head'];

        $regSQL_update = "UPDATE `g_registrs` SET `pircejs` = '{$pircejs}', `pardevejs` = '{$pardevejs}', `atskaites_veids` = '{$atskaites_veids}', `piegadatajs` = '{$piegade}', `akta_nr` = '{$akta_nr}', `datums_piegade` = '{$datums_piegade}', `iecirknis` = '{$iecirknis}', `datums_uzmer` = '{$datums}', `vieta` = '{$vieta}', `soferis` = '{$soferis}', `auto_nr` = '{$auto}', `sortiments` = '{$sortiments}', `skaits_kopa` = '{$skaits}', `bruto` = '{$bruto}', `neto` = '{$neto}', `virsmers` = '{$virsmers}', `redukcija` = '{$redukcija_kopa}', `skaits_brakis` = '{$skaits_brakis}', `brakis` = '{$brakis}', `lietotajs_veidoja` = '{$veidoja}', `atskaites_nr` = '{$liguma_nr}', `opcija` = 'A' WHERE `id` = {$genGlobal_registrs_id}";
//        $regSQL = "INSERT INTO g_registrs (pircejs,pardevejs,atskaites_veids,piegadatajs,akta_nr,pavadzime,datums_piegade,vieta,soferis,auto_nr,sortiments,skaits_kopa,bruto,neto,virsmers,redukcija,skaits_brakis,brakis,lietotajs_veidoja,atskaites_nr,opcija) VALUES ('$pircejs','$pardevejs','$atskaites_veids','$piegade','$akta_nr','$pavadzime','$datums','$vieta','$soferis','$auto','$sortiments',$skaits,$bruto,$neto,$virsmers,$redukcija_kopa,$skaits_brakis,$brakis,'$veidoja','$liguma_nr','A')";
//        echo $regSQL;
        mysql_query($regSQL_update);
       }
     }
     
	if (!$_POST['negrupet']) {
		usort($arrfinal,'CompareArrays');
	}
    $arrfinal[-1] = $C_REP->arr[-1];
    $C_REP->arr = $arrfinal;

	if (!$output_pdf) {
		if($output_xml){
		$atskaite_veids = $_GET['veids'];
			$xml_arr=$C_REP->GetXML_new($atskaites_kods);
			$xml = $xml_arr['file_content'];
		} else {
	//		$output = $output . $C_REP->GetHTML();
		}
	} else {
//		$C_REP->GetHTML($g_atskaite);
	}
	
	if(!empty($_POST['pavadzime'])) {
		$pavXMLNum = trim($_POST['pavadzime']);
	} else {
		$pavXMLNum = trim($_POST['pavadzime_head']);
	}
	
	if ($output_xml) {

   $xml = iconv("UTF-8","cp1257",$xml);

//		if(!file_exists("../batch/xml/".$output_xml_dir) || !is_dir("../batch/xml/".$output_xml_dir)){
//			mkdir("../batch/xml/".$output_xml_dir, 0777);
//			chmod("../batch/xml/".$output_xml_dir, 0777);
//		}
		
		
//		$returnResult = "../batch/xml/".$output_xml_dir;
		
    $new_xml_data_file = $tmp_returnResult."/".$pavXMLNum.".xml";

		if (file_exists($new_xml_data_file))
		{

      $output = $output . '</table><BR><BR></td></tr>';
			file_put_contents("../batch/xml/".$output_xml_dir."/".$pavXMLNum."_1.xml",$xml);
			$output .= "<font color=red>Šāda pavadzīme jau ir veidota! ../batch/xml/".$output_xml_dir."/".$pavXMLNum.".xml </font><BR>";
      $output = $output . "</table></table>";
		}
		else
		{

//      $output = $output . '</table><BR><BR></td></tr>';
      $output = $output . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";

      
      $arr_Compare = AI_getcompare($pavXMLNum,'test');
      
			file_put_contents($new_xml_data_file,$xml);
      $output .= "<table width='580' style='border-width:1px;border-style:solid;' width=100%>";
      $output .= "<thead><td align=center bgcolor=#7EB000><b>*.<i>XML</i> datu faila pārbaude</b><br></td></tr></thead>";

      $output .= "<tbody>";
  
      if($arr_Compare['skaits_kopa'] != $xml_arr['skaits']){
        $starpibaSkaitsBalki = $arr_Compare['skaits_kopa'] - $xml_arr['skaits'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu skaits nesakrīt ar reģistrā esošo baļķu skaitu par ".$starpibaSkaitsBalki."!</font></td></tr>";
      }

      if($arr_Compare['akta_nr'] != $xml_arr['akta_nr']){
        $starpibaAktaNr = $xml_arr['akta_nr'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošais akta numurs(".$starpibaAktaNr.") nesakrīt ar reģistrā esošo akta numuru!</font></td></tr>";
      }

      if(round($arr_Compare['neto'],3) != round($xml_arr['neto_kopa'],3)){
        $starpibaNetoBalki = $arr_Compare['neto'] - $xml_arr['neto_kopa'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu neto nesakrīt ar reģistrā esošo baļķu neto par ".$starpibaNetoBalki."!</font></td></tr>";
      }

      if(round($arr_Compare['brakis'],3) != round($xml_arr['brakis_kopa'],3)){
        $starpibaBrakisBalki = $arr_Compare['brakis'] - $xml_arr['brakis_kopa'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu brāķis nesakrīt ar reģistrā esošo baļķu brāķi par ".$starpibaBrakisBalki."!</font></td></tr>";
      }

      if(round($arr_Compare['redukcija'],3) != round($xml_arr['redukcija_kopa'],3)){
        $starpibaRedukcijaBalki = $arr_Compare['redukcija'] - $xml_arr['redukcija_kopa'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu redukcija nesakrīt ar reģistrā esošo baļķu redukciju par ".$starpibaRedukcijaBalki."!</font></td></tr>";
      }

      if(round($arr_Compare['virsmers'],3) != round($xml_arr['virsmers_kopa'],3)){
        $starpibaVirsmersBalki = $arr_Compare['virsmers'] - $xml_arr['virsmers_kopa'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu virsmērs nesakrīt ar reģistrā esošo baļķu virsmēru par ".$starpibaVirsmersBalki."!</font></td></tr>";
      }

      if(round($arr_Compare['bruto'],3) != round($xml_arr['bruto_kopa'],3)){
        $starpibaBrutoBalki = $arr_Compare['bruto'] - $xml_arr['bruto_kopa'];
        $output .= "<tr><td collspan='2'><font color=red>Failā esošo baļķu bruto nesakrīt ar reģistrā esošo baļķu bruto par ".$starpibaBrutoBalki."!</font></td></tr>";
      }

			$output .= "<tr><td collspan=2>Izveidots fails <a href='../batch/xml/".$output_xml_dir."/".$pavXMLNum.".xml' target='_blank'>$pavXMLNum</a></td></tr>";
			$output .= "<tr><td>Akta numurs failā ".$xml_arr['akta_nr']."</td></tr>";
			$output .= "<tr><td>Baļķu skaits failā ".$xml_arr['skaits']."</td></tr>";
			$output .= "<tr><td>Bruto tilpums failā ".$xml_arr['bruto_kopa']." m3</td></tr>";
			$output .= "<tr><td>Brāķa tilpums failā ".$xml_arr['brakis_kopa']." m3</td></tr>";
			$output .= "<tr><td>Neto tilpums failā ".$xml_arr['neto_kopa']."m3</td></tr>";
//			$output .= "<tr><td>Virsmēra tilpums failā </td><td>".$xml_arr['virsmers_kopa']." m3</td></tr>";
//			$output .= "<tr><td>Redukcijas tilpums failā </td><td>".$xml_arr['redukcija_kopa']." m3</td></tr>";
      $output = $output . "</tbody></table>";
		}

		echo $output;
	} elseif ($output_pdf) {

		$show_reject_codes = false;

		$g_atskaite->report_pdf($C_REP->arrPrintOut);
		$g_atskaite->report_footer_pdf($_POST,$lang,$translate,$show_reject_codes);

    $new_xml_data_file = $tmp_returnResult."/".$pavXMLNum.".pdf";

		$location = $g_atskaite->pdf_save($new_xml_data_file,$pavXMLNum);

//    echo '<iframe width="50%" style="height: 85em;" src="'.$location.'"></iframe>';
//		echo "<a href='$location'>Atskaite PDF formātā</a><br /><br />";


	} else {

      echo $newOutput;
	
	}
  return true;
}

function dateFormatChange($tmp_date){
  $new_date_arr = explode('-',$tmp_date);
  $result = $new_date_arr[2].'.'.$new_date_arr[1].'.'.$new_date_arr[0];
  return $result;
}

function bld_XMLDirZGB($stacija,$dir_byDate,$type){
   if($type == 0){
    $tmp_virsmape = "xml";
   }else{
    $tmp_virsmape = "pdf";
    $stacija = strtoupper($stacija);
   }
   
   if($type == 0){
     $mape_Eksiste= is_dir("../batch/".$tmp_virsmape."/".$stacija."/".$dir_byDate);
     $mape_EksisteVirs = is_dir("../batch/".$tmp_virsmape."/".$stacija);
     $dir_path_temp = "../batch/".$tmp_virsmape."/".$stacija."/".$dir_byDate; 
     $dir_path_Main = "../batch/".$tmp_virsmape."/".$stacija;
     
     if(!$mape_EksisteVirs){
      mkdir($dir_path_temp,0777,true);
      chmod("../batch/".$tmp_virsmape."/".$stacija,0777);
     }				   

     if(!$mape_Eksiste){
      mkdir($dir_path_temp,0777,true);
      chmod($dir_path_temp,0777);
     }else{
      $similar_end_fix = getdate();
      $dir_path_temp = $dir_path_temp.'-'.$similar_end_fix['0'];
      $dir_byDate = $dir_byDate.'-'.$similar_end_fix['0'];
      mkdir($dir_path_temp,0777,true);
      chmod($dir_path_temp,0777);   
     }				   
  }else{
     $mape_Eksiste= is_dir("../batch/".$tmp_virsmape."/".$stacija);
     $mape_EksisteVirs = is_dir("../batch/".$tmp_virsmape."/".$stacija);
     $dir_path_temp = "../batch/".$tmp_virsmape."/".$stacija; 
     $dir_path_Main = "../batch/".$tmp_virsmape."/".$stacija;
     
     if(!$mape_EksisteVirs){
      mkdir($dir_path_temp,0777,true);
      chmod("../batch/".$tmp_virsmape."/".$stacija,0777);
     }				   

     if(!$mape_Eksiste){
      mkdir($dir_path_temp,0777,true);
      chmod($dir_path_temp,0777);
     }else{
      $similar_end_fix = getdate();
      $dir_path_temp = $dir_path_temp;
      $dir_byDate = $dir_byDate;
      mkdir($dir_path_temp,0777,true);
      chmod($dir_path_temp,0777);   
     }				   
  }

  $result[0] = $dir_path_temp;
  $result[1] = $dir_path_Main;
  $result[2] = $dir_byDate;

return $result;
}

function getReportTypeIfEmpty($atskaite_veids){

  switch($atskaite_veids){
      case "nelss":
      $atskaites_kods = 18;
      break;
      case "vika":
      $atskaites_kods = 2;
      break;
      case "incukalns":
        $pavadzimes_tabula = "i_pavadzime";
      break;
      case "akrs":
        $atskaites_kods = 7;
        $pavadzimes_tabula = "pavadzime";
      break;
      case "gaujaskoks":
        $atskaites_kods = 21;
      break;
      case "smiltene":
        $atskaites_kods = 23;
      break;
      case "bsw":
        $atskaites_kods = 20;
      break;
        $atskaites_kods = 22;
      break;
      case "pata_ab":
        $atskaites_kods = 24;
      break;
      case "stora_enso":
        $atskaites_kods = 25;
      break;
      case "kurekss":
        $atskaites_kods = 27;
      break;
      case "latvijas_finieris":
        $atskaites_kods = 26;
      break;
      case "piebalgas":
        $atskaites_kods = 28;
      break;
      case "osukalni":
        $atskaites_kods = 29;
      break;
      case "4plus":
        $atskaites_kods = 33;
      break;
      case "varpas1":
        $atskaites_kods = 143;
      break;
      case "latvani":
        $atskaites_kods = 54;
      break;
      case "kubikmetrs":
        $atskaites_kods = 19;
      break;
      case "jekabpils_mr":
        $atskaites_kods = 55;
      break;      
    default:
      $atskaites_kods = 1;
  }
  return $atskaites_kods;
}
?>