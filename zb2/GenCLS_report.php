<?php

include("valoda.php");

class C_REPORT {

function C_REPORT($My_POST,&$DB,$isXML,$table_pref,$tmp_firm,$isPDF,$subMakeAll,$genGlobal_id,$pavadzimeName)
	{
	global $braki;
	global $sugas;
	global $arrPrintOut;
	global $RowCount;
	global $tmpDiamGroup;
	global $firmCode;
	global $lang;
	global $translate;
  global $tblName;
  global $firmCode;
  global $GroupOrder;
  global $tmpAllGroup;
  global $regSuperSum;
  global $report_XML;
  global $report_PDF;
  global $isAllReport;
  global $genGlobalRegister_id;
  global $tmp_pavadzimeInsert;
  global $garGrupa;
  
  $this->tblName = $table_pref;
  $lang = "LAT";
  $this->report_XML = $isXML;
  $this->report_PDF = $isPDF;
  $this->isAllReport = $subMakeAll;
  $this->genGlobalRegister_id = $genGlobal_id;
  $this->tmp_pavadzimeInsert = $pavadzimeName;
//--------------------------------------------------------------------------------

//--------------------------------------------------------------------------------
  $this->firmCode = $tmp_firm;
	$this->DB = $DB;
	$this->sugas = getSupremeSugas($getSuga = true, $isXML);
	$this->braki = corrTrueDeffectCode($this->firmCode, $isXML);
	$this->MyPOST=array_filter($My_POST);

  $this->RowCount = 0;
  $this->arrPrintOut = array();

  $this->tmpDiamGroup = array();
  $this->tmpGarGroup = array();
  $this->tmpSugaGroup = array();
  $this->tmpSkiraGroup = array();
  $this->tmpBrakGroup = array();
  $this->tmpNomGarGroup = array();
  $this->tmpNomGarBrakGroup = array();
  $this->tmpVirsmGroup = array();
  $this->tmpKoefGroup = array();
  $this->tmpRaukGroup = array();
  $this->GroupOrder = array();
  $this->tmpAllGroup = array();

fb($this->MyPOST,'POST_D');
foreach($this->MyPOST as $key => $tmpPOST){
  if($tmpPOST == 'mind_pirms_red'){
    $this->GroupOrder[substr($key,-1,1)] = 'mind_pirms_red';
    $tmp_GValueInit = substr($key,5,2);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpAllGroup[$grupSK]['mind_pirms_red'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
    $this->tmpAllGroup[$grupSK]['mind_pirms_red'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
    $this->tmpAllGroup[$grupSK]['mind_pirms_red'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
  }

  if($tmpPOST == 'garums'){
    $tmp_GValueInit = substr($key,5,2);
    
    if($this->MyPOST["gvalues".$tmp_GValueInit] != '' || $this->MyPOST["gvalues".$tmp_GValueInit."_1"] != '' || $this->MyPOST["gvalues".$tmp_GValueInit."_2"] !=''){
      $this->garGrupa = 'garums';
      $this->GroupOrder[substr($key,-1,1)] = 'garums';
      $grupSK = substr($tmp_GValueInit,0,1);
      $this->tmpAllGroup[$grupSK]['garums'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
      $this->tmpAllGroup[$grupSK]['garums'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
      $this->tmpAllGroup[$grupSK]['garums'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
    }
  }

  if($tmpPOST == 'gar_pec_red'){
    $this->GroupOrder[substr($key,-1,1)] = 'gar_pec_red';
    $this->garGrupa = 'gar_pec_red';
    $tmp_GValueInit = substr($key,5,2);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpAllGroup[$grupSK]['gar_pec_red'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
    $this->tmpAllGroup[$grupSK]['gar_pec_red'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
    $this->tmpAllGroup[$grupSK]['gar_pec_red'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
  }

  if($tmpPOST == 'suga'){
    $this->GroupOrder[substr($key,-1,1)] = 'suga';
    $tmp_GValueInit = substr($key,5,2);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpAllGroup[$grupSK]['suga'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
    $this->tmpAllGroup[$grupSK]['suga'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
    $this->tmpAllGroup[$grupSK]['suga'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
  }

  if($tmpPOST == 'skira'){
    $this->GroupOrder[substr($key,-1,1)] = 'skira';
    $tmp_GValueInit = substr($key,5,2);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpAllGroup[$grupSK]['skira'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
    $this->tmpAllGroup[$grupSK]['skira'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
    $this->tmpAllGroup[$grupSK]['skira'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
  }

  if($tmpPOST == 'brakis'){
    $this->GroupOrder[substr($key,-1,1)] = 'brakis';
    $tmp_GValueInit = substr($key,5,2);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpAllGroup[$grupSK]['brakis'][0] = $this->MyPOST["gvalues".$tmp_GValueInit];
    $this->tmpAllGroup[$grupSK]['brakis'][1] = $this->MyPOST["gvalues".$tmp_GValueInit."_1"];
    $this->tmpAllGroup[$grupSK]['brakis'][2] = $this->MyPOST["gvalues".$tmp_GValueInit."_2"];
  }
//---------------------------------------------------------------------------------
  if(substr($key,0,7) == 'raukums'){
    $tmp_GValueInit = substr($key,7,1);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpRaukGroup[$grupSK][0] = $this->MyPOST["raukums".$tmp_GValueInit];
    $this->tmpRaukGroup[$grupSK][1] = $this->MyPOST["raukums".$tmp_GValueInit."_1"];
    $this->tmpRaukGroup[$grupSK][2] = $this->MyPOST["raukums".$tmp_GValueInit."_2"];
  }

  if(substr($key,0,8) == 'virsmeri'){
    $tmp_GValueInit = substr($key,8,1);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpNomGarGroup[$grupSK][0] = $this->MyPOST["virsmeri".$tmp_GValueInit];
    $this->tmpNomGarGroup[$grupSK][1] = $this->MyPOST["virsmeri".$tmp_GValueInit."_1"];
    $this->tmpNomGarGroup[$grupSK][2] = $this->MyPOST["virsmeri".$tmp_GValueInit."_2"];
  }

  if(substr($key,0,15) == 'virsmeri_brakim'){
    $tmp_GValueInit = substr($key,15,1);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpNomGarBrakGroup[$grupSK][0] = $this->MyPOST["virsmeri_brakim".$tmp_GValueInit];
    $this->tmpNomGarBrakGroup[$grupSK][1] = $this->MyPOST["virsmeri_brakim".$tmp_GValueInit."_1"];
    $this->tmpNomGarBrakGroup[$grupSK][2] = $this->MyPOST["virsmeri_brakim".$tmp_GValueInit."_2"];
  }

  if(substr($key,0,8) == 'virsmers'){
    $tmp_GValueInit = substr($key,8,1);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpVirsmGroup[$grupSK][0] = $this->MyPOST["virsmers".$tmp_GValueInit];
    $this->tmpVirsmGroup[$grupSK][1] = $this->MyPOST["virsmers".$tmp_GValueInit."_1"];
    $this->tmpVirsmGroup[$grupSK][2] = $this->MyPOST["virsmers".$tmp_GValueInit."_2"];
  }

  if(substr($key,0,11) == 'koeficients'){
    $tmp_GValueInit = substr($key,11,1);
    $grupSK = substr($tmp_GValueInit,0,1);
    $this->tmpKoefGroup[$grupSK][0] = $this->MyPOST["koeficients".$tmp_GValueInit];
    $this->tmpKoefGroup[$grupSK][1] = $this->MyPOST["koeficients".$tmp_GValueInit."_1"];
    $this->tmpKoefGroup[$grupSK][2] = $this->MyPOST["koeficients".$tmp_GValueInit."_2"];
  }

}

//fb($this->GroupOrder,'GroupOrder');
//Pārbaude uz pavadzīmes numuru-----------------------------------------------------------------
	if($_SERVER['REQUEST_METHOD']=='POST'){	
    if(trim($this->MyPOST['pavadzime'])!=''){
      if	(!GetFromPavadzime($this->MyPOST['pavadzime'],'pavadzime',"{$this->tblName}pavadzime") ) {
        $arrErrorMsgSystem = '001-Nav pavadzīmes'; 
      }
    } else{
     $arrErrorMsgSystem = '002-Nav pavadzīmes';
    }
	}
//----------------------------------------------------------------------------------------------

	if ($this->MyPOST[subm] && !$this->ERRORS)
	{	

		// --------------------cik grup??anas l?me?i izmantoti ----------------------------
		$this->lsk = 0;
		while ($this->MyPOST["gtype".$this->grup.($this->lsk+1)]!='') $this->lsk++;
		// --------------------cik grup??anas l?me?i izmantoti ----------------------------
		
		// Pārbauda vai nav vairāku pavazdīmju ar šādu numuru
		if ($this->MyPOST['pavadzime'] && !$this->MyPOST[pavadzime_id]) 
		{
			$pav_test_query = "select count(*) as x from {$this->tblName}pavadzime where pavadzime = '".trim($this->MyPOST['pavadzime'])."'";
			if ($this->MyPOST[datums_no]!='')
				$pav_test_query =$pav_test_query . " and kad_piegad >= '".$this->MyPOST[datums_no]."' ";
			if ($this->MyPOST[datums_lidz]!='')
				$pav_test_query =$pav_test_query  . " and kad_piegad <= '".$this->MyPOST[datums_lidz]."' ";

			$r = $this->DB->query($pav_test_query);
			if ($m = $this->DB->get_row($r))
			{
				if ($m[x]>1)
					$this->ERRORS.= "<font color=red>Eksistē ".$m[x]." pavadzīmes ar numuru ".$this->MyPOST['pavadzime']."!</font><br><br>";
			}
		}

//Pārbaude, vai ņemt no kopējās tabulas datus----------------------------------------------------
		if ($this->MyPOST[datums_no_diena]!='' || $this->MyPOST[pavadzime_id]) { // 
			$query = " from ".$this->tblName."balkis_temp INNER JOIN ".$this->tblName."pavadzime ON ".$this->tblName."balkis_temp.pavadzime = ".$this->tblName."pavadzime.id WHERE 1=1 ";
		} else {
			$query = " from ".$this->tblName."balkis INNER JOIN ".$this->tblName."pavadzime ON ".$this->tblName."balkis.pavadzime = ".$this->tblName."pavadzime.id WHERE 1=1 ";
		}
//-----------------------------------------------------------------------------------------------
		
		if ($this->MyPOST[datums_no_diena]!='')
			$query=$query . " and kad_piegad >= '".$this->MyPOST[datums_no_gads]."-".$this->MyPOST[datums_no_menesis]."-".$this->MyPOST[datums_no_diena]." 00:00:00' ";
		if ($this->MyPOST[datums_lidz_diena]!='')
			$query=$query . " and kad_piegad <= '".$this->MyPOST[datums_lidz_gads]."-".$this->MyPOST[datums_lidz_menesis]."-".$this->MyPOST[datums_lidz_diena]." 00:00:00' ";
		if ($this->MyPOST[piegad_grupa])
			$query=$query . " and {$this->tblName}pavadzime.piegad_grupa like '".$this->MyPOST[piegad_grupa]."%'";
		if ($this->MyPOST[piegadataju_kods])
			$query=$query . " and {$this->tblName}pavadzime.piegad_kods = '".$this->MyPOST[piegadataju_kods]."'";
		if ($this->MyPOST[pavadzime])
			$query=$query . " and {$this->tblName}pavadzime.pavadzime = '".$this->MyPOST[pavadzime]."'";
		if ($this->MyPOST[pavadzime_id])
			$query=$query . " and {$this->tblName}pavadzime.id = '".$this->MyPOST[pavadzime_id]."'";
		if ($this->MyPOST[suga]!='') 
			$query=$query . " and suga = '".$this->MyPOST[suga]."'";
		if ($this->MyPOST[cirsmas_kods]!='') 
			$query=$query . " and cirsmas_kods like '%".$this->MyPOST[cirsmas_kods]."%'";
		if ($this->MyPOST[brakis]!='')
			$query=$query . " and brakis = '".$this->MyPOST[brakis]."'";
		if ($this->MyPOST[fsc]!='')
			$query=$query . " and fsc = '".$this->MyPOST[fsc]."'";
		if ($this->MyPOST[kravas_id])
			$query=$query . " and kravas_id = '".$this->MyPOST[kravas_id]."'";
		if ($this->MyPOST[auto])
			$query=$query . " and auto = '".$this->MyPOST[auto]."'";
		if ($this->MyPOST[soferis])
			$query=$query . " and soferis = '".$this->MyPOST[soferis]."'";
		if ($this->MyPOST[cenu_matrica])
			$query=$query . " and cenu_matrica = '".$this->MyPOST[cenu_matrica]."'";
		if ($this->MyPOST[skira])
			$query=$query . " and skira = '".$this->MyPOST[skira]."'";
		if (trim($this->MyPOST['batch_fails'])!='')
			$query=$query . " and batch_fails in(".$this->MyPOST[batch_fails].")";
		if (trim($this->MyPOST['iecirknis_pieg'])!='')
			$query=$query . " and LOWER(iecirknis)=LOWER('".trim($this->MyPOST['iecirknis_pieg'])."')";
			$query=$query . " and opcija IN ('A','L')";
		$query2 = str_replace("{$this->tblName}balkis_temp","{$this->tblName}balkis",$query);

//      echo $query;

		if ($this->MyPOST[datums_no_diena]!='') {
			$this->DB->query("DELETE FROM {$this->tblName}balkis_temp");
			$this->DB->query("INSERT INTO {$this->tblName}balkis_temp (SELECT {$this->tblName}balkis.* " . $query2 . ")");
			$query = " from {$this->tblName}balkis_temp INNER JOIN {$this->tblName}pavadzime ON {$this->tblName}balkis_temp.pavadzime = {$this->tblName}pavadzime.id WHERE 1=1 ";
//      echo "INSERT INTO {$this->tblName}balkis_temp (SELECT {$this->tblName}balkis.* " . $query2 . ")";
		}
		
		
		if ($this->MyPOST[pavadzime]) {
			$this->DB->query("DELETE FROM {$this->tblName}balkis_temp");
      if($this->firmCode != 26 && $this->firmCode != 45){
        $this->DB->query("INSERT INTO {$this->tblName}balkis_temp (SELECT {$this->tblName}balkis.* " . $query2 . ")");
      }else{
        $tmpCilinderFilter_query = $this->DB->query("SELECT {$this->tblName}balkis.* " . $query2);
        while($tmpCilinderFilter_arr = mysql_fetch_assoc($tmpCilinderFilter_query)){

        $balkis_id_qry = $tmpCilinderFilter_arr['id'];
        $pavadzime_qry = $tmpCilinderFilter_arr['pavadzime'];
        $nelieto_qry = $tmpCilinderFilter_arr['nelieto'];
        $datums_laiks_qry = $tmpCilinderFilter_arr['datums_laiks'];
        $suga_qry = $tmpCilinderFilter_arr['suga'];
        $miza_qry = $tmpCilinderFilter_arr['miza'];
        $balkis_garums_pirms_red_tmp = $tmpCilinderFilter_arr['garums'];
        $kabata_qry = $tmpCilinderFilter_arr['kabata'];
        $tilpums_tmp_bruto = $tmpCilinderFilter_arr['tilpums_scan'];
        $tilpums_tmp_neto = $tmpCilinderFilter_arr['tilpums'];
        $tilpums_nepilnais_isklucis = $tmpCilinderFilter_arr['virsmera_tilpums'];
        $tilpums_tmp_virsmers = $tilpums_tmp_bruto - $tilpums_tmp_neto;
        
//        $pavadzime_IDS = $tmpCilinderFilter_arr['pavadzime'];
        $query_check_if_is_short = "SELECT `cenu_matrica` FROM {$this->tblName}pavadzime WHERE `id` = {$pavadzime_qry}";
        $query_check_if_is_short_query = mysql_query($query_check_if_is_short);
        $query_check_if_is_arr = mysql_fetch_assoc($query_check_if_is_short_query);
        $isLigums = $query_check_if_is_arr['cenu_matrica'];
        
          for($icCount = 0;$icCount < 4;$icCount++){
            $insertBOOL = false;
            
            if($this->firmCode != 45){   
                if($icCount == 0 && $tmpCilinderFilter_arr['1_cilindra_tilpums'] > 0){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                  $balkis_tilpums_tmp = ($tmpCilinderFilter_arr['1_cilindra_tilpums'])/1000;
    //              $balkis_tilpums_tmp = ($tmpCilinderFilter_arr['1_cilindra_tilpums'] + $tilpums_tmp_virsmers)/1000;
                  $balkis_tilpums_neto_tmp = $tmpCilinderFilter_arr['1_cilindra_tilpums']/1000;
    //              $balkis_tilpums_tmp = $tmpCilinderFilter_arr['1_cilindra_tilpums']/1000;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis'];
                  $skira_qry = $tmpCilinderFilter_arr['skira'];
                }

                if($icCount == 1 && $tmpCilinderFilter_arr['2_cilindra_tilpums'] > 0){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_miza'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_miza'];
                  $balkis_tilpums_tmp = $tmpCilinderFilter_arr['2_cilindra_tilpums']/1000;
                  $balkis_tilpums_neto_tmp = $tmpCilinderFilter_arr['2_cilindra_tilpums']/1000;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis2'];
                  $skira_qry = $tmpCilinderFilter_arr['skira_2'];
                }

                if($isLigums == 'AA'){//Bolderājas nosacījumi
                  if($icCount == 1 && $tmpCilinderFilter_arr['2_cilindra_tilpums'] < 1 && $balkis_garums_pirms_red_tmp < 270 && $balkis_garums_pirms_red_tmp >= 160){
                    $insertBOOL = true;
                    $skira_qry = "9";
                    $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                    $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                    $balkis_tilpums_tmp = $tilpums_nepilnais_isklucis/1000;
                    $balkis_tilpums_neto_tmp = $tilpums_nepilnais_isklucis/1000;
                    $balkis_brakis_tmp = '017';
                  }
                }

                if($isLigums == 'AC' || $isLigums == 'AD'){//Verems nosacījumi
    //              if($icCount == 1 && $tmpCilinderFilter_arr['2_cilindra_tilpums'] < 1 && (($balkis_garums_pirms_red_tmp < 320 && $balkis_garums_pirms_red_tmp >= 230 && $tmpCilinderFilter_arr['1_cilindra_garums'] < 1700) || ($balkis_garums_pirms_red_tmp > 320 && $tmpCilinderFilter_arr['1_cilindra_garums'] > 2200))){
                  if($icCount == 1 && $tmpCilinderFilter_arr['2_cilindra_tilpums'] < 1 && ($balkis_garums_pirms_red_tmp < 320 && $balkis_garums_pirms_red_tmp >= 230 && $tmpCilinderFilter_arr['1_cilindra_garums'] < 1700)){
                    $insertBOOL = true;
                    $skira_qry = "9";
                    $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                    $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                    $balkis_tilpums_tmp = $tilpums_nepilnais_isklucis/1000;
                    $balkis_tilpums_neto_tmp = $tilpums_nepilnais_isklucis/1000;
                    $balkis_brakis_tmp = '017';
                    if($tmpCilinderFilter_arr['brakis'] > 600){
                        $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis'];
                    }
                    if($tmpCilinderFilter_arr['brakis'] == '000'){
                        $balkis_brakis_tmp = '000';
                    } 
                  }
                }

                if($icCount == 2 && $tmpCilinderFilter_arr['3_cilindra_tilpums'] > 0){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['maxd_miza'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['maxd_miza'];
                  $balkis_tilpums_tmp = $tmpCilinderFilter_arr['3_cilindra_tilpums']/1000;
                  $balkis_tilpums_neto_tmp = $tmpCilinderFilter_arr['3_cilindra_tilpums']/1000;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis3'];
                  $skira_qry = $tmpCilinderFilter_arr['skira'];
                }

                if($icCount == 3 && $tmpCilinderFilter_arr['4_cilindra_tilpums'] > 0){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['diametrs5'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['diametrs5'];
                  $balkis_tilpums_tmp = $tmpCilinderFilter_arr['4_cilindra_tilpums']/1000;
                  $balkis_tilpums_neto_tmp = $tmpCilinderFilter_arr['4_cilindra_tilpums']/1000;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis4'];
                  $skira_qry = $tmpCilinderFilter_arr['skira'];
                }
            }else{
                if($icCount == 0){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_pirms_red'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_pec_red'];
                  $parbaudeGarumam = $tmpCilinderFilter_arr['garums'] - 137;
                  if($parbaudeGarumam > 0){
                    $balkis_garums_pirms_red_tmp = 137;                  
                  }else{
                    $balkis_garums_pirms_red_tmp = $tmpCilinderFilter_arr['garums'];
                  }
                  
                  $balkis_tilpums_tmp = 0;
    //              $balkis_tilpums_tmp = ($tmpCilinderFilter_arr['1_cilindra_tilpums'] + $tilpums_tmp_virsmers)/1000;
                  $balkis_tilpums_neto_tmp = 0;
    //              $balkis_tilpums_tmp = $tmpCilinderFilter_arr['1_cilindra_tilpums']/1000;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis'];
                  $skira_qry = $tmpCilinderFilter_arr['skira'];
                  if($tmpCilinderFilter_arr['garums'] >320){
                    $balkis_brakis_tmp = '012';
                    $skira_qry = 9;                  
                  }
                }

                if($icCount == 1){
                  $insertBOOL = true;
                  $balkis_diam_pirms_red_tmp = $tmpCilinderFilter_arr['mind_pirms_red'];
                  $balkis_diam_pec_red_tmp = $tmpCilinderFilter_arr['mind_pirms_red'];
                  
                  $parbaudeGarumam = $tmpCilinderFilter_arr['garums'] - 137;
                  if($parbaudeGarumam > 0){
                    $balkis_garums_pirms_red_tmp = $parbaudeGarumam;                  
                  }else{
                    $insertBOOL = true;
                  }
                  
                  $balkis_tilpums_tmp = 0;
                  $balkis_tilpums_neto_tmp = 0;
                  $balkis_brakis_tmp = $tmpCilinderFilter_arr['brakis2'];
                  $skira_qry = $tmpCilinderFilter_arr['skira_2'];
                
                  if($tmpCilinderFilter_arr['garums'] >320){
                    $balkis_brakis_tmp = '012';
                    $skira_qry = 9;                  
                  }                
                }
            }
            
            if($insertBOOL){
              $subQueryIns = "INSERT INTO {$this->tblName}balkis_temp (pavadzime,nelieto,datums_laiks,mind_pirms_red,garums,suga,skira,miza,mind_pec_red,gar_pec_red,mind_miza,brakis,maxd_miza,kabata,tilpums,tilpums_scan,import_id) VALUES ($pavadzime_qry,'$nelieto_qry','$datums_laiks_qry',$balkis_diam_pirms_red_tmp,$balkis_garums_pirms_red_tmp,'$suga_qry','$skira_qry','$miza_qry',$balkis_diam_pec_red_tmp,$balkis_garums_pirms_red_tmp,$balkis_diam_pirms_red_tmp,'$balkis_brakis_tmp',$balkis_diam_pirms_red_tmp,'$kabata_qry',$balkis_tilpums_tmp,$balkis_tilpums_neto_tmp,$balkis_id_qry)";
              $this->DB->query($subQueryIns);
            }
//            echo $subQueryIns.'<br />';
          }
        }
      }

      if (mysql_affected_rows() == 0) {$arrErrorMsgSystem = '003-Nav baļķu'; return false;}
			$query = " from {$this->tblName}balkis_temp INNER JOIN {$this->tblName}pavadzime ON {$this->tblName}balkis_temp.pavadzime = {$this->tblName}pavadzime.id WHERE 1=1 ";
		}

      $this->constrByMask($this->MyPOST[pavadzime_id]);
	}
} // CReport konstruktors

function getMaskGroup($var_MaskString,$findString,$groupType){
  $result = '';
  $tmp_arrCompare = explode(',',$var_MaskString);
  foreach($tmp_arrCompare as $newItem){
    if($groupType != 'suga' && $groupType != 'skira'){
      $compare_TEMP = str_replace('b','',explode('-',$newItem));
      if(($compare_TEMP[0] <= $findString)  && ($findString <= $compare_TEMP[1])){
        $result = $newItem;
      }
    }else{
      if($var_MaskString != '' && (($tmp_arrCompare[0] == $findString) || ($tmp_arrCompare[1] == $findString) || ($tmp_arrCompare[2] == $findString))){
        $result = $var_MaskString;
      }
    }
  }
  return $result;
}

function calc_Volume($d_tievg,$d_vidus,$d_resg,$l_galv,$raukums,$koeficients,$gostu_tabula,$apr_formula = 1){

	$result = -1;

	if (!$gostu_tabula){
		$pi = 3.1416;

    switch($apr_formula){
      case 1:
        if ((double)$raukums!=0){
          $r = ($pi * ( (($d_tievg/10) * ($d_tievg/10)) + (($d_tievg/10) + ($raukums * ($l_galv/100))) * (($d_tievg/10) + ($raukums * ($l_galv/100)))) * ($l_galv/100)) / (8 * 10000);
          $result = round($r,3);
        } else {
          $r = $pi*$d_tievg*$d_tievg*$l_galv/4;
          if ($koeficients!='') {
            $result = round($r*$koeficients,3);
          } else {
            $result = round($r,3);
          }
        }
      break;

      case 2:
        $r = $pi*($d_vidus/10)*($d_vidus/10)*($l_galv/4000000);
        $result = round($r,3);
      break;

      case 3:
//        $d_tievg = $d_tievg * 10;
//        $d_resg = $d_resg * 10;
        $r = ($pi * ((($d_tievg/10) * ($d_tievg/10)) + (($d_resg/10) * ($d_resg/10))) * ($l_galv/100)) / (4 * 2 * 10000);
        $result = round($r,3);		
      break;
		}
	}else{
    //Nepieciešama formula GOST tabulas aprēķinam
	}

	return $result;
}

function constrByMask($pvdzID){
  $tmp_rowCount = 1;
  $tilpums_bruto_KOPA = 0;
  $tilpums_virsmers_KOPA = 0;
  $tilpums_redukcija_KOPA = 0;
  $tilpums_neto_KOPA = 0;
  $tilpums_brakis_KOPA = 0;
  $tmp_balkuSkaits = 0;
  $tilpums_skaits_brakis_KOPA = 0;
  $bbq_temp = false;
  $liguma_matrica = '';

  $tmp_arrCollName['nosaukums'] = 1;
  $tmp_arrCollName['suga'] = "Suga";
  $tmp_arrCollName['skira'] = "Šķira";
  $tmp_arrCollName['diametrs'] = "Diametrs";
  $tmp_arrCollName['garums'] = "Garums";
  $tmp_arrCollName['brakis_kods'] = "Brāķa iemesls";
  $tmp_arrCollName['skaits'] = "Skaits";
  $tmp_arrCollName['bruto'] = "Bruto";
  $tmp_arrCollName['virsmers'] = "Virsmērs";
  $tmp_arrCollName['redukcija'] = "Redukcija";
  $tmp_arrCollName['redukcija_un_virsmers'] = "Red. un virsm.";
  $tmp_arrCollName['brakis'] = "Brāķis";
  $tmp_arrCollName['neto'] = "Neto";
  $tmp_arrCollName['brakis_un_neto'] = "Brāķis un Neto";
  
  $tmp_lig_matrica_txt = "SELECT `cenu_matrica` FROM ".$this->tblName."pavadzime WHERE `id` = {$pvdzID}";
  $tmp_lig_matrica_mysql = mysql_query($tmp_lig_matrica_txt);
  while($tmp_lig_matrica_arr = mysql_fetch_assoc($tmp_lig_matrica_mysql)){
    $liguma_matrica = trim($tmp_lig_matrica_arr['cenu_matrica']);
  }

  $tmp_getDataQuery_txt = "SELECT * FROM ".$this->tblName."balkis_temp WHERE pavadzime = ".$pvdzID." ORDER BY mind_pirms_red";
  if(!$pvdzID){
    $tmp_getDataQuery_txt = "SELECT * FROM ".$this->tblName."balkis_temp ORDER BY mind_pirms_red";
    $bbq_temp = true;
    $trunc_SQL = "DELETE FROM `global_kops_atsk`";
    mysql_query($trunc_SQL);
  }
  
  $tmp_getDataQuery_query = mysql_query($tmp_getDataQuery_txt);

  if($bbq_temp == false){
 
    while($tmp_getDataQuery_arr = mysql_fetch_assoc($tmp_getDataQuery_query)){

      $tilpums_bruto = 0;
      $tilpums_virsmers = 0;
      $tilpums_redukcija = 0;
      $tilpums_neto = 0;
      $tilpums_brakis = 0;
      $apmaksas_garums = 0;
      $isBrakaVirsmOn = $this->MyPOST['braka_virsmers'];

      if($tmp_getDataQuery_arr['pavadzime'] == 76806 && $this->firmCode == 2){
        $isBrakaVirsmOn = 'off';
      }
  //-#001-FUNC-START--Nepieciešamo datu kolekcionēšana no datubāzes------------------------------------------------------------------------------------
      $tmp_ident_balkis = $tmp_getDataQuery_arr['id'];
      $var_Suga = (string)$tmp_getDataQuery_arr['suga'];
//      if($var_Suga == 0){$var_Suga = '0';}
//      die('test');
      $varDateTime = $tmp_getDataQuery_arr['datums_laiks'];

      $tmp_tilpumsBruto = $tmp_getDataQuery_arr['tilpums'];
      $tmp_tilpumsNeto = $tmp_getDataQuery_arr['tilpums_scan'];

      $tmp_garums_pirms_red = $tmp_getDataQuery_arr['garums'];
      $tmp_garums_pec_red = $tmp_getDataQuery_arr['gar_pec_red'];
      
      $tmp_tievgalis_pirms_red = $tmp_getDataQuery_arr['mind_pirms_red'];
      $tmp_tievgalis_pec_red = $tmp_getDataQuery_arr['mind_pec_red'];

      $tmp_vidusdiametrs_pirms_red = $tmp_getDataQuery_arr['mind_miza'];
      $tmp_vidusdiametrs_pec_red = $tmp_getDataQuery_arr['mind_miza'] - ($tmp_getDataQuery_arr['mind_pirms_red'] - $tmp_getDataQuery_arr['mind_pec_red']);

      $tmp_resgalis_pirms_red = $tmp_getDataQuery_arr['maxd_miza'];
      $tmp_resgalis_pec_red = $tmp_getDataQuery_arr['maxd_miza'] - ($tmp_getDataQuery_arr['mind_pirms_red'] - $tmp_getDataQuery_arr['mind_pec_red']);

  //-#001-FUNC-END------------------------------------------------------------------------------------------------------------------------------------    
  
  if($this->firmCode == 26 && $liguma_matrica == 'AC' && $tmp_getDataQuery_arr['skira'] == 'E' && $tmp_getDataQuery_arr['mind_pirms_red'] > 130 && $tmp_getDataQuery_arr['mind_pirms_red'] < 180){
    $tmp_getDataQuery_arr['skira'] = 'B';
  }
//  fb($this->GroupOrder,'GroupOrder');
  //-#002-FUNC-START--Nepieciešamās grupas atrašana---------------------------------------------------------------------------------------------------    
      $igc = 1;// Grupu skaits
      $init_Group = false;
      while($igc < 9 && ($init_Group == false)){
        
        $tmp_igcCheck = 0;

        for($igo = 1; $igo < 6; $igo++){ //Grupēšanas nosacījumus cikls

          for($subcount = 0;$subcount < 3;$subcount++){
            if($this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$subcount]){

              $tmp_SubResult = $this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$subcount];
              if(!$this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][0]){
                $tmp_SubResult = $this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$var_Suga];
              }
//              echo $this->GroupOrder[$igo].'<br />';
              $tmp_ALLbResult = $this->getMaskGroup($tmp_SubResult,$tmp_getDataQuery_arr[$this->GroupOrder[$igo]],$this->GroupOrder[$igo]);
              $tmp_inputArrVal[$this->GroupOrder[$igo]] = $tmp_ALLbResult;
              
              if($tmp_ALLbResult != ''){ $tmp_igcCheck = $tmp_igcCheck + 1;}
            }else{ $tmp_igcCheck = $tmp_igcCheck + 1;}
          }

          if($igo == 5 && $tmp_igcCheck == 15){ // Grupas noteikšana līdz pirmajiem sakritības rezultātiem (rekursija ar limitētu ciklu skaitu)
            $init_Group = true;
            $globalGroupIdent = $igc;
          }
        }
        
        $igc++;
      }
//      echo $globalGroupIdent.'<br/>';
  //-#002-FUNC-END-------------------------------------------------------------------------------------------------------------------------------------
  //-#003-FUNC-START--Tilpuma aprēķināšana-------------------------------------------------------------------------------------------------------------

      $prnt_Nosaukums = 0;
      $prnt_Suga = $this->sugas[$var_Suga]['LAT'];
      $prnt_Skira = $tmp_getDataQuery_arr['skira'];
      $prnt_Brakis = $this->braki[$tmp_getDataQuery_arr['brakis']]['LAT'];
      $prnt_Diametrs = $tmp_inputArrVal['mind_pirms_red'];
      $prnt_Garums = $tmp_inputArrVal[$this->garGrupa];
//      echo $prnt_Garums.'<br/>';
//      echo $this->garGrupa;
//      $prnt_Garums = $tmp_inputArrVal['garums'];
      
  //---------------------------------------------------------------------------------------------------------------------------------------------------    
      if(($this->firmCode == 35) && $prnt_Skira == 3){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['010']['LAT'];
      }

      if(($this->firmCode == 37) && $prnt_Skira == 3){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['011']['LAT'];
      }

  //---------------------------------------------------------------------------------------------------------------------------------------------------
      if ($this->MyPOST['noapalot_garumu'] == '1') {
        $tmp_garums_pirms_red = ((floor($tmp_garums_pirms_red/10)) * 10);
      }elseif ($this->MyPOST['noapalot_garumu'] == '2') {
        $tmp_garums_pirms_red = ((floor($tmp_garums_pirms_red/10)+0.5) * 10);
      }
          
      $tmp_raukumaRinda = $this->tmpRaukGroup[$globalGroupIdent][0];
      if(!$tmp_raukumaRinda){
        $tmp_raukumaRinda = $this->tmpRaukGroup[$globalGroupIdent][$var_Suga];
      }
          
      $raukums = raukums_2_array($tmp_raukumaRinda);
      $rauk_koef = get_raukums_no_diam($raukums,$tmp_tievgalis_pirms_red); 
          
      $tmp_DiamRedukcija = $tmp_tievgalis_pirms_red - $tmp_tievgalis_pec_red;

      $tilpums_bruto = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
          
      if ($this->MyPOST['noapalot_diametru'] == 'on') { $tmp_tievgalis_pec_red = ((floor($tmp_tievgalis_pec_red/10)+0.5) * 100);}

      $tmp_virsmeraRinda = $this->tmpNomGarGroup[$globalGroupIdent][0];
      if(!$tmp_virsmeraRinda){
        $tmp_virsmeraRinda = $this->tmpNomGarGroup[$globalGroupIdent][$var_Suga];
      }

      $tmp_virsmeraRindaBrakis = $this->tmpNomGarBrakGroup[$globalGroupIdent][0];
      if(!$tmp_virsmeraRindaBrakis){
        $tmp_virsmeraRindaBrakis = $this->tmpNomGarBrakGroup[$globalGroupIdent][$var_Suga];
      }

      if($tmp_virsmeraRindaBrakis){
        $virsmeri_brakim = explode(',',$tmp_virsmeraRindaBrakis);
        for ($i=0;$i<count($virsmeri_brakim);$i++){
          $virsmeri_brakim[$i] = $virsmeri_brakim[$i];
        }
      }

      $virsmeri = explode(',',$tmp_virsmeraRinda);
      for ($i=0;$i<count($virsmeri);$i++){
        $virsmeri[$i] = $virsmeri[$i];
      }

      $tmp_mini_virsmeraRinda = $this->tmpVirsmGroup[$globalGroupIdent][0];
      if(!$tmp_mini_virsmeraRinda){
        $tmp_mini_virsmeraRinda = $this->tmpVirsmGroup[$globalGroupIdent][$var_Suga];
      }

      $tmp_nom_garums_pirms_red = nominalGarums($tmp_getDataQuery_arr['garums'],$virsmeri,$tmp_mini_virsmeraRinda);
      $tmp_nom_garums_pec_red = nominalGarums($tmp_garums_pec_red,$virsmeri,$tmp_mini_virsmeraRinda);

      if ($this->MyPOST['is_vika'] == 'on') {
        $tmp_garums_pec_red = $tmp_garums_pec_red + $tmp_mini_virsmeraRinda;
        $tmp_nom_garums_pec_red = nominalGarums($tmp_garums_pec_red,$virsmeri,$tmp_mini_virsmeraRinda);
        $tilpums_neto = $this->calc_Volume($tmp_tievgalis_pec_red,$tmp_vidusdiametrs_pec_red,$tmp_resgalis_pec_red,$tmp_nom_garums_pec_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_virsmers = ROUND($tilpums_bruto - $tilpums_bruto_virsmeram,3);
        $tilpums_redukcija = $tilpums_bruto_virsmeram - $tilpums_neto;
      } else {
        $tilpums_neto = $this->calc_Volume($tmp_tievgalis_pec_red,$tmp_vidusdiametrs_pec_red,$tmp_resgalis_pec_red,$tmp_nom_garums_pec_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_virsmers = ROUND($tilpums_bruto - $tilpums_bruto_virsmeram,3);
        $tilpums_redukcija = $tilpums_bruto_virsmeram - $tilpums_neto;
      }

      if($this->MyPOST['metode'] == 4){
        if($this->firmCode == 27){
          $tilpums_bruto = (floor($tmp_tilpumsBruto / 10)) / 1000;
          $tilpums_neto = (floor($tmp_tilpumsNeto / 10)) / 1000;
          $tilpums_bruto_virsmeram = (floor($tmp_tilpumsNeto / 10)) / 1000;
          $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
          $tilpums_redukcija = 0;
        }else{
          $tilpums_bruto = $tmp_tilpumsBruto;
          $tilpums_neto = $tmp_tilpumsNeto;
          $tilpums_bruto_virsmeram = $tmp_tilpumsNeto;
          
          $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
          
          if($this->firmCode == 26){
            
          }
          
          $tilpums_redukcija = 0;
        }
      }

      $apmaksas_garums = $tmp_nom_garums_pec_red;
      
      if($tilpums_virsmers < 0){$tilpums_virsmers = 0;}
      if($tilpums_bruto_virsmeram == 0){$tilpums_virsmers = 0;}
      if($tilpums_redukcija < 0){$tilpums_redukcija = 0;}

  //-#003-FUNC-END--------------------------------------------------------------------------------------------------------------------------------------
  //-#004-FUNC-START--Papildus dimensijas brāķa piešķiršana--------------------------------------------------------------------------------------------
      $takeReCallOn4 = false;

      if($tmp_nom_garums_pec_red < 1 && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $takeReCallOn4 = true;
      }
      
      if(substr($prnt_Diametrs,0,1) == 'b' && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $prnt_Diametrs = str_replace('b','',$prnt_Diametrs);
        $takeReCallOn4 = true;
      }
      
      if(substr($prnt_Garums,0,1) == 'b' && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $prnt_Garums = str_replace('b','',$prnt_Garums);
        $takeReCallOn4 = true;
      }

      if($prnt_Brakis == 'D'){// XML nobrāķēšana ar 4 kodu
        $takeReCallOn4 = true;
      }

      if($this->firmCode == 26 && $tmp_getDataQuery_arr['brakis'] == '017' && $liguma_matrica == 'AC'){
        $tmp_is4 = mod_ResignLVMRejectCode($this->firmCode,$liguma_matrica,$tmp_getDataQuery_arr['garums'],$tmp_getDataQuery_arr['mind_pirms_red'],$tmp_getDataQuery_arr['suga'],$tmp_getDataQuery_arr['skira'],$tmp_getDataQuery_arr['brakis']);

        if($tmp_is4){
          $prnt_Brakis = $this->braki['702']['LAT'];
        }
      }

      if($takeReCallOn4){
        $tmp_is4 = mod_ResignLVMRejectCode($this->firmCode,$liguma_matrica,$tmp_getDataQuery_arr['garums'],$tmp_getDataQuery_arr['mind_pirms_red'],$tmp_getDataQuery_arr['suga'],$tmp_getDataQuery_arr['skira'],$tmp_getDataQuery_arr['brakis']);

        if($tmp_is4){
          $prnt_Brakis = $this->braki['856']['LAT'];
        }
      }
      
      if($this->firmCode == 25){
        if($tmp_getDataQuery_arr['brakis'] == '003'){
          $prnt_Brakis = $this->braki['003']['LAT'];
        }
      }
  //-#004-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#005-FUNC-START--Brāķa tilpuma aprēķināšana---------------------------------------------------------------------------------------------------    
      if($prnt_Brakis){
        $tilpums_neto = 0;
        $tilpums_redukcija = 0;

        if ($isBrakaVirsmOn == 'on') {
          if($virsmeri_brakim){
            $tmp_nom_garums_pirms_red_brakim = nominalGarums($tmp_getDataQuery_arr['garums'],$virsmeri_brakim,$tmp_mini_virsmeraRinda);
            $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red_brakim,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
            
            $apmaksas_garums = $tmp_nom_garums_pirms_red_brakim;
            
            if($tilpums_bruto_virsmeram > 0){
              $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
              $tilpums_brakis = $tilpums_bruto_virsmeram;
              $apmaksas_garums = $tmp_garums_pirms_red;
            }else{
              $tilpums_virsmers = 0;
              $tilpums_brakis = $tilpums_bruto;
              $apmaksas_garums = $tmp_garums_pirms_red;
            }
          }else{
            if($tilpums_bruto_virsmeram > 0){
              $tilpums_brakis = $tilpums_bruto_virsmeram;
              $apmaksas_garums = $tmp_nom_garums_pirms_red;
            }else{
              $tilpums_virsmers = 0;
              $tilpums_brakis = $tilpums_bruto;
              $apmaksas_garums = $tmp_garums_pirms_red;
            }
          }
        }else{
          $tilpums_virsmers = 0;
          $tilpums_brakis = $tilpums_bruto;
          $apmaksas_garums = $tmp_garums_pirms_red;          
        }
      }
      
      
      $tmp_inputArrVal['mind_pirms_red'] = str_replace('b','',$tmp_inputArrVal['mind_pirms_red']);
      $prnt_Diametrs = str_replace('b','',$prnt_Diametrs);
      $tmp_inputArrVal['garums'] = str_replace('b','',$tmp_inputArrVal['garums']);
      $prnt_Garums = str_replace('b','',$prnt_Garums);
  //-#005-FUNC-END-----------------------------------------------------------------------------------------------------
  
      if($this->genGlobalRegister_id > 0){
        $datumsRegNow = date("Y-m-d H:i:s");
        $subInsertRegisterBool = $this->regSubGlobalRegisters($datumsRegNow, $varDateTime, $this->genGlobalRegister_id, $this->tmp_pavadzimeInsert, $prnt_Suga, $prnt_Skira, $tmp_getDataQuery_arr['mind_pirms_red'], $prnt_Diametrs, $tmp_getDataQuery_arr['garums'], $prnt_Garums, $prnt_Brakis, $tilpums_bruto, $tilpums_brakis, $tilpums_neto);
      }
  //-#006-FUNC-START--Vienādo grupēšanu pāskats---------------------------------------------------------------------------------------------------    
      $pilnaGrupesana = false;
      if($this->report_XML){$pilnaGrupesana = true;}
      if(($this->firmCode == 16 || $this->firmCode == 666 || $this->isAllReport)&& !$this->report_PDF){$pilnaGrupesana = true;}
      
      $rowExist = 0;
      if(!$pilnaGrupesana){
        for($protoKey = ($tmp_rowCount - 1);$protoKey > 0;$protoKey--){
          if($this->arrPrintOut[$protoKey]['suga'] == $prnt_Suga){
            if($this->arrPrintOut[$protoKey]['skira'] == $prnt_Skira){
              if($this->arrPrintOut[$protoKey]['diametrs'] == $prnt_Diametrs){
                if($this->arrPrintOut[$protoKey]['brakis_kods'] == $prnt_Brakis){
                  $rowExist = $protoKey;
                }
              }
            }
          }
        }
      }else{
        for($protoKey = ($tmp_rowCount - 1);$protoKey > 0;$protoKey--){
          if($this->arrPrintOut[$protoKey]['suga'] == $prnt_Suga){
            if($this->arrPrintOut[$protoKey]['skira'] == $prnt_Skira){
              if($this->arrPrintOut[$protoKey]['diametrs'] == $prnt_Diametrs){
                if($this->arrPrintOut[$protoKey]['garums'] == $prnt_Garums){
                  if($this->arrPrintOut[$protoKey]['brakis_kods'] == $prnt_Brakis){
                    $rowExist = $protoKey;
                  }
                }
              }
            }
          }
        }
      }
  //-#006-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#007-FUNC-START--Statisko vērtību ievietošana---------------------------------------------------------------------------------------------------    

      $insertRow = $tmp_rowCount;
      if($rowExist != 0){$insertRow = $rowExist;}

      $this->arrPrintOut[$insertRow]['nosaukums'] = 0;
      $this->arrPrintOut[$insertRow]['suga'] = $prnt_Suga;
      $this->arrPrintOut[$insertRow]['skira'] = $prnt_Skira;
      $this->arrPrintOut[$insertRow]['diametrs'] = $prnt_Diametrs;
      $this->arrPrintOut[$insertRow]['garums'] = $prnt_Garums;
      $this->arrPrintOut[$insertRow]['brakis_kods'] = $prnt_Brakis;
      if($this->report_XML){
        $this->arrPrintOut[$insertRow]['diametrs_tmp'] = $tmp_getDataQuery_arr['mind_pirms_red'];
//        $this->arrPrintOut[$insertRow]['garums_tmp'] = $tmp_getDataQuery_arr['garums'];
        $this->arrPrintOut[$insertRow]['garums_tmp'] = $apmaksas_garums;
      }
      $this->arrPrintOut[$insertRow]['skaits'] += 1;

      if($this->arrPrintOut[$insertRow]['brakis_kods'] != ''){
        $tilpums_skaits_brakis_KOPA += 1;
      }
  //-#007-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#008-FUNC-START--Dinamisko vērtību piešķiršana---------------------------------------------------------------------------------------------------    
      $this->arrPrintOut[$insertRow]['bruto'] += $tilpums_bruto;
      $this->arrPrintOut[$insertRow]['virsmers'] += $tilpums_virsmers;
      $this->arrPrintOut[$insertRow]['redukcija'] += $tilpums_redukcija;
      $this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] += $tilpums_bruto - $tilpums_neto;
      $this->arrPrintOut[$insertRow]['brakis'] += $tilpums_brakis;
      $this->arrPrintOut[$insertRow]['neto'] += $tilpums_neto;
      $this->arrPrintOut[$insertRow]['brakis_un_neto'] += $tilpums_neto + $tilpums_brakis;
  //------------------------------------------------------------------------------------------------------
      if($this->arrPrintOut[$insertRow]['bruto'] != ''){$this->arrPrintOut[$insertRow]['bruto'] = number_format($this->arrPrintOut[$insertRow]['bruto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['bruto'] = '';}
      if($this->arrPrintOut[$insertRow]['virsmers'] != ''){$this->arrPrintOut[$insertRow]['virsmers'] = number_format($this->arrPrintOut[$insertRow]['virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija'] != ''){$this->arrPrintOut[$insertRow]['redukcija'] = number_format($this->arrPrintOut[$insertRow]['redukcija'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] != ''){$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = number_format($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis'] != ''){$this->arrPrintOut[$insertRow]['brakis'] = number_format($this->arrPrintOut[$insertRow]['brakis'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis'] = '';}
      if($this->arrPrintOut[$insertRow]['neto'] != ''){$this->arrPrintOut[$insertRow]['neto'] = number_format($this->arrPrintOut[$insertRow]['neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['neto'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis_un_neto'] != ''){$this->arrPrintOut[$insertRow]['brakis_un_neto'] = number_format($this->arrPrintOut[$insertRow]['brakis_un_neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis_un_neto'] = '';}
  //------------------------------------------------------------------------------------------------------

      $tilpums_bruto_KOPA = $tilpums_bruto_KOPA + $tilpums_bruto;
      $tilpums_virsmers_KOPA = $tilpums_virsmers_KOPA + $tilpums_virsmers;
      $tilpums_redukcija_KOPA = $tilpums_redukcija_KOPA + $tilpums_redukcija;
      $tilpums_neto_KOPA = $tilpums_neto_KOPA + $tilpums_neto;
      $tilpums_brakis_KOPA = $tilpums_brakis_KOPA + $tilpums_brakis;

      $tmp_balkuSkaits++;
      $tmp_rowCount++;
    }


  }else{

    while($tmp_getDataQuery_arr = mysql_fetch_assoc($tmp_getDataQuery_query)){

      $tilpums_bruto = 0;
      $tilpums_virsmers = 0;
      $tilpums_redukcija = 0;
      $tilpums_neto = 0;
      $tilpums_brakis = 0;
      $isBrakaVirsmOn = $this->MyPOST['braka_virsmers'];

      if($tmp_getDataQuery_arr['pavadzime'] == 76806 && $this->firmCode == 2){
        $isBrakaVirsmOn = 'off';
      }
  //-#001-FUNC-START--Nepieciešamo datu kolekcionēšana no datubāzes------------------------------------------------------------------------------------
      $tmp_ident_balkis = $tmp_getDataQuery_arr['id'];
      $var_Suga = $tmp_getDataQuery_arr['suga'];

      $tmp_tilpumsBruto = $tmp_getDataQuery_arr['tilpums'];
      $tmp_tilpumsNeto = $tmp_getDataQuery_arr['tilpums_scan'];

      $tmp_garums_pirms_red = $tmp_getDataQuery_arr['garums'];
      $tmp_garums_pec_red = $tmp_getDataQuery_arr['gar_pec_red'];
      
      $tmp_tievgalis_pirms_red = $tmp_getDataQuery_arr['mind_pirms_red'];
      $tmp_tievgalis_pec_red = $tmp_getDataQuery_arr['mind_pec_red'];

      $tmp_vidusdiametrs_pirms_red = $tmp_getDataQuery_arr['mind_miza'];
      $tmp_vidusdiametrs_pec_red = $tmp_getDataQuery_arr['mind_miza'] - ($tmp_getDataQuery_arr['mind_pirms_red'] - $tmp_getDataQuery_arr['mind_pec_red']);

      $tmp_resgalis_pirms_red = $tmp_getDataQuery_arr['maxd_miza'];
      $tmp_resgalis_pec_red = $tmp_getDataQuery_arr['maxd_miza'] - ($tmp_getDataQuery_arr['mind_pirms_red'] - $tmp_getDataQuery_arr['mind_pec_red']);

  //-#001-FUNC-END------------------------------------------------------------------------------------------------------------------------------------    
  //-#002-FUNC-START--Nepieciešamās grupas atrašana---------------------------------------------------------------------------------------------------    
      $igc = 1;// Grupu skaits
      $init_Group = false;
      while($igc < 9 && ($init_Group == false)){
        
        $tmp_igcCheck = 0;

        for($igo = 1; $igo < 6; $igo++){ //Grupēšanas nosacījumus cikls

          for($subcount = 0;$subcount < 3;$subcount++){
            if($this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$subcount]){

              $tmp_SubResult = $this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$subcount];
              if(!$this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][0]){
                $tmp_SubResult = $this->tmpAllGroup[$igc][$this->GroupOrder[$igo]][$var_Suga];
              }

              $tmp_ALLbResult = $this->getMaskGroup($tmp_SubResult,$tmp_getDataQuery_arr[$this->GroupOrder[$igo]],$this->GroupOrder[$igo]);
              $tmp_inputArrVal[$this->GroupOrder[$igo]] = $tmp_ALLbResult;
              
              if($tmp_ALLbResult != ''){ $tmp_igcCheck = $tmp_igcCheck + 1;}
            }else{ $tmp_igcCheck = $tmp_igcCheck + 1;}
          }

          if($igo == 5 && $tmp_igcCheck == 15){ // Grupas noteikšana līdz pirmajiem sakritības rezultātiem (rekursija ar limitētu ciklu skaitu)
            $init_Group = true;
            $globalGroupIdent = $igc;
          }
        }
        
        $igc++;
      }
  //-#002-FUNC-END-------------------------------------------------------------------------------------------------------------------------------------
  //-#003-FUNC-START--Tilpuma aprēķināšana-------------------------------------------------------------------------------------------------------------

      $prnt_Nosaukums = 0;
      $prnt_Suga = $this->sugas[$var_Suga]['LAT'];
      $prnt_Skira = $tmp_getDataQuery_arr['skira'];
      $prnt_Brakis = $this->braki[$tmp_getDataQuery_arr['brakis']]['LAT'];
      $prnt_Diametrs = $tmp_inputArrVal['mind_pirms_red'];
      $prnt_Garums = $tmp_inputArrVal['garums'];
      
  //---------------------------------------------------------------------------------------------------------------------------------------------------    
      if(($this->firmCode == 35) && $prnt_Skira == 3){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['010']['LAT'];
      }
      
      if(($this->firmCode == 37) && $prnt_Skira == 3){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['011']['LAT'];
      }
      
  //---------------------------------------------------------------------------------------------------------------------------------------------------
      if ($this->MyPOST['noapalot_garumu'] == '1') {
        $tmp_garums_pirms_red = ((floor($tmp_garums_pirms_red/10)) * 10);
      }elseif ($this->MyPOST['noapalot_garumu'] == '2') {
        $tmp_garums_pirms_red = ((floor($tmp_garums_pirms_red/10)+0.5) * 10);
      }
          
      $tmp_raukumaRinda = $this->tmpRaukGroup[$globalGroupIdent][0];
      if(!$tmp_raukumaRinda){
        $tmp_raukumaRinda = $this->tmpRaukGroup[$globalGroupIdent][$var_Suga];
      }
          
      $raukums = raukums_2_array($tmp_raukumaRinda);
      $rauk_koef = get_raukums_no_diam($raukums,$tmp_tievgalis_pirms_red); 
          
      $tmp_DiamRedukcija = $tmp_tievgalis_pirms_red - $tmp_tievgalis_pec_red;

      $tilpums_bruto = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
          
      if ($this->MyPOST['noapalot_diametru'] == 'on') { $tmp_tievgalis_pec_red = ((floor($tmp_tievgalis_pec_red/10)+0.5) * 100);}

      $tmp_virsmeraRinda = $this->tmpNomGarGroup[$globalGroupIdent][0];
      if(!$tmp_virsmeraRinda){
        $tmp_virsmeraRinda = $this->tmpNomGarGroup[$globalGroupIdent][$var_Suga];
      }

      $tmp_virsmeraRindaBrakis = $this->tmpNomGarBrakGroup[$globalGroupIdent][0];
      if(!$tmp_virsmeraRindaBrakis){
        $tmp_virsmeraRindaBrakis = $this->tmpNomGarBrakGroup[$globalGroupIdent][$var_Suga];
      }

      if($tmp_virsmeraRindaBrakis){
        $virsmeri_brakim = explode(',',$tmp_virsmeraRindaBrakis);
        for ($i=0;$i<count($virsmeri_brakim);$i++){
          $virsmeri_brakim[$i] = $virsmeri_brakim[$i];
        }
      }

      $virsmeri = explode(',',$tmp_virsmeraRinda);
      for ($i=0;$i<count($virsmeri);$i++){
        $virsmeri[$i] = $virsmeri[$i];
      }

      $tmp_mini_virsmeraRinda = $this->tmpVirsmGroup[$globalGroupIdent][0];
      if(!$tmp_mini_virsmeraRinda){
        $tmp_mini_virsmeraRinda = $this->tmpVirsmGroup[$globalGroupIdent][$var_Suga];
      }

      $tmp_nom_garums_pirms_red = nominalGarums($tmp_getDataQuery_arr['garums'],$virsmeri,$tmp_mini_virsmeraRinda);
      $tmp_nom_garums_pec_red = nominalGarums($tmp_garums_pec_red,$virsmeri,$tmp_mini_virsmeraRinda);

      if ($this->MyPOST['is_vika'] == 'on') {
        $tmp_garums_pec_red = $tmp_garums_pec_red + $tmp_mini_virsmeraRinda;
        $tmp_nom_garums_pec_red = nominalGarums($tmp_garums_pec_red,$virsmeri,$tmp_mini_virsmeraRinda);
        $tilpums_neto = $this->calc_Volume($tmp_tievgalis_pec_red,$tmp_vidusdiametrs_pec_red,$tmp_resgalis_pec_red,$tmp_nom_garums_pec_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_virsmers = ROUND($tilpums_bruto - $tilpums_bruto_virsmeram,3);
        $tilpums_redukcija = $tilpums_bruto_virsmeram - $tilpums_neto;
      } else {
        $tilpums_neto = $this->calc_Volume($tmp_tievgalis_pec_red,$tmp_vidusdiametrs_pec_red,$tmp_resgalis_pec_red,$tmp_nom_garums_pec_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
        $tilpums_virsmers = ROUND($tilpums_bruto - $tilpums_bruto_virsmeram,3);
        $tilpums_redukcija = $tilpums_bruto_virsmeram - $tilpums_neto;
      }

      if($this->MyPOST['metode'] == 4){
        if($this->firmCode == 27){
          $tilpums_bruto = (floor($tmp_tilpumsBruto / 10)) / 1000;
          $tilpums_neto = (floor($tmp_tilpumsNeto / 10)) / 1000;
          $tilpums_bruto_virsmeram = (floor($tmp_tilpumsNeto / 10)) / 1000;
          $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
          $tilpums_redukcija = 0;
        }else{
          $tilpums_bruto = $tmp_tilpumsBruto;
          $tilpums_neto = $tmp_tilpumsNeto;
          $tilpums_bruto_virsmeram = $tmp_tilpumsNeto;
          $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
          $tilpums_redukcija = 0;
        }
      }

      if($tilpums_virsmers < 0){$tilpums_virsmers = 0;}
      if($tilpums_bruto_virsmeram == 0){$tilpums_virsmers = 0;}
      if($tilpums_redukcija < 0){$tilpums_redukcija = 0;}

  //-#003-FUNC-END--------------------------------------------------------------------------------------------------------------------------------------
  //-#004-FUNC-START--Papildus dimensijas brāķa priešķiršana--------------------------------------------------------------------------------------------
      $takeReCallOn4 = false;

      if($tmp_nom_garums_pec_red < 1 && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $takeReCallOn4 = true;
      }
      
      if(substr($prnt_Diametrs,0,1) == 'b' && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $prnt_Diametrs = str_replace('b','',$prnt_Diametrs);
        $takeReCallOn4 = true;
      }
      
      if(substr($prnt_Garums,0,1) == 'b' && !$prnt_Brakis){
        $prnt_Skira = 9;
        $prnt_Brakis = $this->braki['899']['LAT'];
        $prnt_Garums = str_replace('b','',$prnt_Garums);
        $takeReCallOn4 = true;
      }

      if($this->firmCode == 26 && $tmp_getDataQuery_arr['brakis'] == '017' && $liguma_matrica == 'AC'){
        $tmp_is4 = mod_ResignLVMRejectCode($this->firmCode,$liguma_matrica,$tmp_getDataQuery_arr['garums'],$tmp_getDataQuery_arr['mind_pirms_red'],$tmp_getDataQuery_arr['suga'],$tmp_getDataQuery_arr['skira'],$tmp_getDataQuery_arr['brakis']);

        if($tmp_is4){
          $prnt_Brakis = $this->braki['702']['LAT'];
        }
      }

      if($prnt_Brakis == 'D'){// XML nobrāķēšana ar 4 kodu
        $takeReCallOn4 = true;
      }

      if($takeReCallOn4){
        $tmp_is4 = mod_ResignLVMRejectCode($this->firmCode,$liguma_matrica,$tmp_getDataQuery_arr['garums'],$tmp_getDataQuery_arr['mind_pirms_red'],$tmp_getDataQuery_arr['suga'],$tmp_getDataQuery_arr['skira'],$tmp_getDataQuery_arr['brakis']);
        if($tmp_is4){
          $prnt_Brakis = $this->braki['856']['LAT'];
        }
      }
  //-#004-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#005-FUNC-START--Brāķa tilpuma aprēķināšana---------------------------------------------------------------------------------------------------    
      if($prnt_Brakis){
        $tilpums_neto = 0;
        $tilpums_redukcija = 0;

        if ($isBrakaVirsmOn == 'on') {
          if($virsmeri_brakim){
            $tmp_nom_garums_pirms_red_brakim = nominalGarums($tmp_getDataQuery_arr['garums'],$virsmeri_brakim,$tmp_mini_virsmeraRinda);
            $tilpums_bruto_virsmeram = $this->calc_Volume($tmp_tievgalis_pirms_red,$tmp_vidusdiametrs_pirms_red,$tmp_resgalis_pirms_red,$tmp_nom_garums_pirms_red_brakim,$rauk_koef,$koeficients,$gostu_tabula,$this->MyPOST['metode']);
            
            if($tilpums_bruto_virsmeram > 0){
              $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_virsmeram;
              $tilpums_brakis = $tilpums_bruto_virsmeram;
            }else{
              $tilpums_virsmers = 0;
              $tilpums_brakis = $tilpums_bruto;
            }
          }else{
            if($tilpums_bruto_virsmeram > 0){
              $tilpums_brakis = $tilpums_bruto_virsmeram;
            }else{
              $tilpums_virsmers = 0;
              $tilpums_brakis = $tilpums_bruto;
            }
          }
        }else{
          $tilpums_virsmers = 0;
          $tilpums_brakis = $tilpums_bruto;
        }
      }

      $tmp_inputArrVal['mind_pirms_red'] = str_replace('b','',$tmp_inputArrVal['mind_pirms_red']);
      $prnt_Diametrs = str_replace('b','',$prnt_Diametrs);
      $tmp_inputArrVal['garums'] = str_replace('b','',$tmp_inputArrVal['garums']);
      $prnt_Garums = str_replace('b','',$prnt_Garums);
  //-#005-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#006-FUNC-START--Vienādo grupēšanu pāskats---------------------------------------------------------------------------------------------------    
      $pilnaGrupesana = false;
      if($this->report_XML){$pilnaGrupesana = true;}
      if(($this->firmCode == 16 || $this->firmCode == 666 || $this->isAllReport)&& !$this->report_PDF){$pilnaGrupesana = true;}
      
  //-#006-FUNC-END-----------------------------------------------------------------------------------------------------
  //-#007-FUNC-START--Statisko vērtību ievietošana---------------------------------------------------------------------------------------------------    
/*
      $insertRow = $tmp_rowCount;
      if($rowExist != 0){$insertRow = $rowExist;}

      $this->arrPrintOut[$insertRow]['nosaukums'] = 0;
      $this->arrPrintOut[$insertRow]['suga'] = $prnt_Suga;
      $this->arrPrintOut[$insertRow]['skira'] = $prnt_Skira;
      $this->arrPrintOut[$insertRow]['diametrs'] = $prnt_Diametrs;
      $this->arrPrintOut[$insertRow]['garums'] = $prnt_Garums;
      $this->arrPrintOut[$insertRow]['brakis_kods'] = $prnt_Brakis;
      if($this->report_XML){
        $this->arrPrintOut[$insertRow]['diametrs_tmp'] = $tmp_getDataQuery_arr['mind_pirms_red'];
        $this->arrPrintOut[$insertRow]['garums_tmp'] = $tmp_getDataQuery_arr['garums'];
      }
      $this->arrPrintOut[$insertRow]['skaits'] += 1;

      if($this->arrPrintOut[$insertRow]['brakis_kods'] != ''){
        $tilpums_skaits_brakis_KOPA += 1;
      }
*/      
      $tmp_skaits = 1;
      $querySub_text = "INSERT INTO `global_kops_atsk` (`group_suga`,`group_skira`,`group_diametrs`,`group_garums`,`group_brakis`,`group_tilp_neto`,`group_tilp_bruto`,`group_tilp_brakis`,`group_tilp_neto_un_brakis`,`group_tilp_redukcija`,`group_tilp_virsmers`,`group_skaits`) VALUES ('$prnt_Suga','$prnt_Skira','$prnt_Diametrs','$prnt_Garums','$prnt_Brakis',$tilpums_neto,$tilpums_bruto,$tilpums_brakis,$tilpums_neto + $tilpums_brakis,$tilpums_redukcija,$tilpums_virsmers,$tmp_skaits)";
      mysql_query($querySub_text);
  //-#007-FUNC-END-----------------------------------------------------------------------------------------------------
  /*
  //-#008-FUNC-START--Dinamisko vērtību piešķiršana---------------------------------------------------------------------------------------------------    
      $this->arrPrintOut[$insertRow]['bruto'] += $tilpums_bruto;
      $this->arrPrintOut[$insertRow]['virsmers'] += $tilpums_virsmers;
      $this->arrPrintOut[$insertRow]['redukcija'] += $tilpums_redukcija;
      $this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] += $tilpums_bruto - $tilpums_neto;
      $this->arrPrintOut[$insertRow]['brakis'] += $tilpums_brakis;
      $this->arrPrintOut[$insertRow]['neto'] += $tilpums_neto;
      $this->arrPrintOut[$insertRow]['brakis_un_neto'] += $tilpums_neto + $tilpums_brakis;
  //------------------------------------------------------------------------------------------------------
      if($this->arrPrintOut[$insertRow]['bruto'] != ''){$this->arrPrintOut[$insertRow]['bruto'] = number_format($this->arrPrintOut[$insertRow]['bruto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['bruto'] = '';}
      if($this->arrPrintOut[$insertRow]['virsmers'] != ''){$this->arrPrintOut[$insertRow]['virsmers'] = number_format($this->arrPrintOut[$insertRow]['virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija'] != ''){$this->arrPrintOut[$insertRow]['redukcija'] = number_format($this->arrPrintOut[$insertRow]['redukcija'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] != ''){$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = number_format($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis'] != ''){$this->arrPrintOut[$insertRow]['brakis'] = number_format($this->arrPrintOut[$insertRow]['brakis'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis'] = '';}
      if($this->arrPrintOut[$insertRow]['neto'] != ''){$this->arrPrintOut[$insertRow]['neto'] = number_format($this->arrPrintOut[$insertRow]['neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['neto'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis_un_neto'] != ''){$this->arrPrintOut[$insertRow]['brakis_un_neto'] = number_format($this->arrPrintOut[$insertRow]['brakis_un_neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis_un_neto'] = '';}
  //------------------------------------------------------------------------------------------------------

      $tilpums_bruto_KOPA = $tilpums_bruto_KOPA + $tilpums_bruto;
      $tilpums_virsmers_KOPA = $tilpums_virsmers_KOPA + $tilpums_virsmers;
      $tilpums_redukcija_KOPA = $tilpums_redukcija_KOPA + $tilpums_redukcija;
      $tilpums_neto_KOPA = $tilpums_neto_KOPA + $tilpums_neto;
      $tilpums_brakis_KOPA = $tilpums_brakis_KOPA + $tilpums_brakis;

      $tmp_balkuSkaits++;
      $tmp_rowCount++;
 */
    }
  
    $mysqlGlobalSelect_text = "SELECT `group_suga`, `group_skira`, `group_diametrs`, `group_garums`, `group_brakis`, SUM(`group_skaits`) as skaits, SUM(`group_tilp_bruto`) as bruto, SUM(`group_tilp_virsmers`) as virsmers, SUM(`group_tilp_redukcija`) as redukcija, SUM(`group_tilp_brakis`) as brakis_tilp, SUM(`group_tilp_neto`) as neto FROM `global_kops_atsk` GROUP BY `group_suga`, `group_skira`, `group_diametrs`, `group_garums`, `group_brakis` ORDER BY `group_suga`, `group_skira`, `group_diametrs`, `group_garums`, `group_brakis`";
//    echo $mysqlGlobalSelect_text.'<br />';
    $mysqlGlobalSelect = mysql_query($mysqlGlobalSelect_text);
    
    $insertRow = $tmp_rowCount;
    while($mysqlGlobalSelect_arr = mysql_fetch_assoc($mysqlGlobalSelect)){

      $this->arrPrintOut[$insertRow]['nosaukums'] = 0;
      $this->arrPrintOut[$insertRow]['suga'] = $mysqlGlobalSelect_arr['group_suga'];
      $this->arrPrintOut[$insertRow]['skira'] = $mysqlGlobalSelect_arr['group_skira'];
      $this->arrPrintOut[$insertRow]['diametrs'] = $mysqlGlobalSelect_arr['group_diametrs'];
      $this->arrPrintOut[$insertRow]['garums'] = $mysqlGlobalSelect_arr['group_garums'];
      $this->arrPrintOut[$insertRow]['brakis_kods'] = $mysqlGlobalSelect_arr['group_brakis'];
      $this->arrPrintOut[$insertRow]['skaits'] = $mysqlGlobalSelect_arr['skaits'];
      $this->arrPrintOut[$insertRow]['bruto'] = $mysqlGlobalSelect_arr['bruto'];
      $this->arrPrintOut[$insertRow]['virsmers'] = $mysqlGlobalSelect_arr['virsmers'];
      $this->arrPrintOut[$insertRow]['redukcija'] = $mysqlGlobalSelect_arr['redukcija'];
      $this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = $mysqlGlobalSelect_arr['redukcija'] + $mysqlGlobalSelect_arr['virsmers'];
      $this->arrPrintOut[$insertRow]['brakis'] = $mysqlGlobalSelect_arr['brakis_tilp'];
      $this->arrPrintOut[$insertRow]['neto'] = $mysqlGlobalSelect_arr['neto'];
      $this->arrPrintOut[$insertRow]['brakis_un_neto'] = $mysqlGlobalSelect_arr['brakis'] + $mysqlGlobalSelect_arr['neto'];

      if($this->arrPrintOut[$insertRow]['bruto'] != '' && $this->arrPrintOut[$insertRow]['bruto'] != 0){$this->arrPrintOut[$insertRow]['bruto'] = number_format($this->arrPrintOut[$insertRow]['bruto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['bruto'] = '';}
      if($this->arrPrintOut[$insertRow]['virsmers'] != '' && $this->arrPrintOut[$insertRow]['virsmers'] != 0){$this->arrPrintOut[$insertRow]['virsmers'] = number_format($this->arrPrintOut[$insertRow]['virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija'] != '' && $this->arrPrintOut[$insertRow]['redukcija'] != 0){$this->arrPrintOut[$insertRow]['redukcija'] = number_format($this->arrPrintOut[$insertRow]['redukcija'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija'] = '';}
      if($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] != '' && $this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] != 0){$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = number_format($this->arrPrintOut[$insertRow]['redukcija_un_virsmers'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['redukcija_un_virsmers'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis'] != '' && $this->arrPrintOut[$insertRow]['brakis'] != 0){$this->arrPrintOut[$insertRow]['brakis'] = number_format($this->arrPrintOut[$insertRow]['brakis'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis'] = '';}
      if($this->arrPrintOut[$insertRow]['neto'] != '' && $this->arrPrintOut[$insertRow]['neto'] != 0){$this->arrPrintOut[$insertRow]['neto'] = number_format($this->arrPrintOut[$insertRow]['neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['neto'] = '';}
      if($this->arrPrintOut[$insertRow]['brakis_un_neto'] != '' && $this->arrPrintOut[$insertRow]['brakis_un_neto'] != 0){$this->arrPrintOut[$insertRow]['brakis_un_neto'] = number_format($this->arrPrintOut[$insertRow]['brakis_un_neto'], 3, '.', '');}else{$this->arrPrintOut[$insertRow]['brakis_un_neto'] = '';}

      $tilpums_bruto_KOPA = $tilpums_bruto_KOPA + $mysqlGlobalSelect_arr['bruto'];
      $tilpums_virsmers_KOPA = $tilpums_virsmers_KOPA + $mysqlGlobalSelect_arr['virsmers'];
      $tilpums_redukcija_KOPA = $tilpums_redukcija_KOPA + $mysqlGlobalSelect_arr['redukcija'];
      $tilpums_neto_KOPA = $tilpums_neto_KOPA + $mysqlGlobalSelect_arr['neto'];
      $tilpums_brakis_KOPA = $tilpums_brakis_KOPA + $mysqlGlobalSelect_arr['brakis_tilp'];

      $tmp_balkuSkaits = $tmp_balkuSkaits + $mysqlGlobalSelect_arr['skaits'];
      $tmp_rowCount++;

      $insertRow++;
    }

  }
  
//  }
//-#008-FUNC-END-----------------------------------------------------------------------------------------------------
//-#009-FUNC-START--Rindu pārgrupēšana masīvā---------------------------------------------------------------------------------------------------    
    if(($this->firmCode == 16 || $this->firmCode == 20 || $bbq_temp == true || $this->isAllReport) && !$this->report_PDF && !$this->report_XML){
      $this->arrPrintOut = array_orderby($this->arrPrintOut, 'suga', SORT_ASC, 'skira', SORT_ASC, 'diametrs', SORT_ASC, 'garums', SORT_ASC, 'brakis_kods', SORT_ASC);
    }else{
      $this->arrPrintOut = array_orderby($this->arrPrintOut, 'suga', SORT_ASC, 'skira', SORT_ASC, 'diametrs', SORT_ASC, 'brakis_kods', SORT_ASC);
    }
    array_unshift($this->arrPrintOut,$tmp_arrCollName);

//-#009-FUNC-END-----------------------------------------------------------------------------------------------------
//-#010-FUNC-START--Kopsummas rindas pievienošana---------------------------------------------------------------------------------------------------    
    $this->arrPrintOut[$tmp_rowCount]['nosaukums'] = 1;
    $this->arrPrintOut[$tmp_rowCount]['suga'] = "";
    $this->arrPrintOut[$tmp_rowCount]['skira'] = "";
    $this->arrPrintOut[$tmp_rowCount]['diametrs'] = "";
    $this->arrPrintOut[$tmp_rowCount]['garums'] = "";
    $this->arrPrintOut[$tmp_rowCount]['brakis_kods'] = "";
    $this->arrPrintOut[$tmp_rowCount]['skaits'] = $tmp_balkuSkaits;
    $this->arrPrintOut[$tmp_rowCount]['bruto'] = number_format($tilpums_bruto_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['virsmers'] = number_format($tilpums_virsmers_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['redukcija'] = number_format($tilpums_redukcija_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['redukcija_un_virsmers'] = number_format($tilpums_bruto_KOPA - $tilpums_neto_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['brakis'] = number_format($tilpums_brakis_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['neto'] = number_format($tilpums_neto_KOPA, 3, '.', '')."*";
    $this->arrPrintOut[$tmp_rowCount]['brakis_un_neto'] = number_format($tilpums_brakis_KOPA + $tilpums_neto_KOPA, 3, '.', '')."*";

    $this->regSuperSum['bruto'] = $tilpums_bruto_KOPA;
    $this->regSuperSum['virsmers'] = $tilpums_virsmers_KOPA;
    $this->regSuperSum['redukcija'] = $tilpums_redukcija_KOPA;
    $this->regSuperSum['brakis'] = $tilpums_brakis_KOPA;
    $this->regSuperSum['neto'] = $tilpums_neto_KOPA;
    $this->regSuperSum['skaits'] = $tmp_balkuSkaits;
    $this->regSuperSum['skaits_brakis'] = $tilpums_skaits_brakis_KOPA;
//-#010-FUNC-END-----------------------------------------------------------------------------------------------------
//-#011-FUNC-START-END-Rezultāts---------------------------------------------------------------------------------------------------    
//    fb($this->arrPrintOut,'arrPrintOut');
//  break;
  return true;
}


function SetParam() {
  set_param('akts_nr',$this->MyPOST['akts_nr_head']);
  set_param('pircejs',$this->MyPOST['pircejs_head']);
  set_param('pardevejs',$this->MyPOST['pardevejs_head']);
  set_param('pieg_lig_num',$this->MyPOST['pieg_lig_num']);
  set_param('datums',$this->MyPOST['datums_head']);
  set_param('iecirknis',$this->MyPOST['iecirknis_head']);
  set_param('pavadzime_head',$this->MyPOST['pavadzime_head']);
  
  set_param('auto',$this->MyPOST['auto_head']);
  set_param('soferis',$this->MyPOST['soferis_head']);
  set_param('vieta',$this->MyPOST['vieta_head']);
  set_param('piezimes',$this->MyPOST['piezimes_head']);
  set_param('atbildigais',$this->MyPOST['atbildigais_head']);
  set_param('custom11',$this->MyPOST['custom11_head']);
  set_param('custom12',$this->MyPOST['custom12_head']);

  set_param('sortiments',$this->MyPOST['sortiments_head']);
  set_param('standarts',$this->MyPOST['standarts_head']);
  set_param('metode',$this->MyPOST['metode_head']);
  set_param('raukums',$this->MyPOST['raukums_head']);
  set_param('merinstruments',$this->MyPOST['merinstruments_head']);
  set_param('terminsh',$this->MyPOST['terminsh_head']);
}

  function regSubGlobalRegisters($datumsRegNow, $datumsUzmer, $registrs_id, $pavadzime, $suga, $skira, $diametrs, $diametrs_grupa, $garums, $garums_grupa, $brakis_iemesls, $bruto, $brakis, $neto){
    $mysqlSubInsert_txt = "INSERT INTO `g_registrs_sub` (`datums_laiks`, `datums_uzmer`, `registrs_id`, `pavadzime`, `suga`, `skira`, `diametrs`, `diametrs_grupa`, `garums`, `garums_grupa`, `brakis_iemesls`, `bruto`, `brakis`, `neto`) VALUES ('{$datumsRegNow}', '{$datumsUzmer}', {$registrs_id}, '{$pavadzime}', '{$suga}', '{$skira}', {$diametrs}, '{$diametrs_grupa}', {$garums}, '{$garums_grupa}', '{$brakis_iemesls}', {$bruto}, {$brakis}, {$neto})";
    $mysqlSubInsert = mysql_query($mysqlSubInsert_txt);
//    echo $mysqlSubInsert_txt.'<br/><br/>';
    return true;
  }

function GetHTML($g_atskaite){
  $result = $g_atskaite->report_pdf($this->arrPrintOut);
  return $result;
}


  function GetXML_new($atskaite_veids){
      $sumSkaitskopa = 0;
      $sumBrutokopa = 0;
      $output = "";
//----------------------------------------------------------------------------------------
      $tmp_veidosanasDatums = Date('Y-m-d H:i:s');
      
      $entrydate_tmp = trim($_POST['head']['kad_uzmer']);
      $entrydate_arr = explode('.',$entrydate_tmp);
      $entrydate = $entrydate_arr[2].'-'.$entrydate_arr[1].'-'.$entrydate_arr[0];
      
      $invoicenumber = trim(str_replace(array("<b>","</b>"),"",$_POST['pavadzime']));
      $invoicedate_tmp = trim(str_replace(array("<b>","</b>"),"",$_POST['head']['kad_piegad']));
      $invoicedate_arr = explode('.',$invoicedate_tmp);
      $invoicedate = $invoicedate_arr[2].'-'.$invoicedate_arr[1].'-'.$invoicedate_arr[0];

      $contractnumber = trim($_POST['pieg_lig_num']);
      $measurerdocnr = trim(get_param('akts_nr'));
      $transportjobnr = trim($_POST['head']['transp_darba_uzd']);
      $supplier_name = trim($_POST['head']['pardevejs_head']);
      $supplier_regnum = $_POST['head']['pardevejs_regnum'];
      $reciever_name = $_POST['head']['pircejs_head'];
      $reciever_regnum = $_POST['head']['pircejs_regnum'];
      $carrier_firmname = trim($_POST['head']['transport_firm']);
      $carrier_trucknumber = trim($_POST['head']['auto_head']);
      $carrier_driver = trim(str_replace("&","&amp;",$_POST['head']['soferis_head']));
      $measuring_measuringdate = trim($_POST['head']['kad_uzmer']);
      $measuring_operatorname = "VMF Latvia";
      $measuring_measuremethod = "I";
      $assortmorigin_fscnumber = trim($_POST['head']['fsc']);
      $assortmorigin_slashcode = trim($_POST['head']['cirsma_head']);
//----------------------------------------------------------------------------------------
      $tmp_xmlRecord_qry = "INSERT INTO `xml_gen_record` (`pavadzime_nr`,`uzmer_stacija`,`datums_veidots`) VALUES ('$invoicenumber','$atskaite_veids','$tmp_veidosanasDatums')";
      mysql_query($tmp_xmlRecord_qry);
      $tmp_record_id = mysql_insert_id();
//----------------------------------------------------------------------------------------
      $output = $output . '<?xml version="1.0" encoding="Windows-1257"?>';
      $output = $output . "\n<Invoice>\n";
      $output = $output . "	<EntryDate>".$entrydate."</EntryDate>\n";
      $output = $output . "	<InvoiceNumber>".$invoicenumber."</InvoiceNumber>\n";
      $output = $output . "	<InvoiceDate>".$invoicedate."</InvoiceDate>\n";
      $output = $output . "	<ContractNumber>".$contractnumber."</ContractNumber>\n";
      $output = $output . "	<MeasurerDocNr>".$measurerdocnr."</MeasurerDocNr>\n";
      $output = $output . "	<TransportJobNr>".$transportjobnr."</TransportJobNr>\n";
      $output = $output . "	<Supplier>\n";
      $output = $output . "		<Name>".$supplier_name."</Name>\n";
      $output = $output . "		<RegNr>".$supplier_regnum."</RegNr>\n";
      $output = $output . "	</Supplier>\n";
      $output = $output . "	<Reciever>\n";
      $output = $output . "		<Name>".str_replace('&','&amp;',$reciever_name)."</Name>\n";
      $output = $output . "		<RegNr>".$reciever_regnum."</RegNr>\n";
      $output = $output . "	</Reciever>\n";
      $output = $output . "	<Carrier>\n";
      $output = $output . "<FirmName>".$carrier_firmname."</FirmName>\n";
      $output = $output . "<TruckNumber>".$carrier_trucknumber."</TruckNumber>\n";
      $output = $output . "<Driver>".$carrier_driver."</Driver>\n";
      $output = $output . "</Carrier>\n";
      $output = $output . "<Measuring>\n";
      $output = $output . "	<MeasuringDate>".$measuring_measuringdate."</MeasuringDate>\n";
      $output = $output . "	<OperatorName>".$measuring_operatorname."</OperatorName>\n";
      $output = $output . "	<MeasureMethod>".$measuring_measuremethod."</MeasureMethod>\n";
      $output = $output . "</Measuring>\n";
      $output = $output . "<AssortmOrigin>\n";
      $output = $output . "	<FSCNumber>".$assortmorigin_fscnumber."</FSCNumber>\n";
      $output = $output . "	<SlashCode>".$assortmorigin_slashcode."</SlashCode>\n";
      $output = $output . "</AssortmOrigin>\n";

    foreach($this->arrPrintOut as $tmp_item_1){

     if($tmp_item_1['nosaukums'] != 1){
    
        $refused = false;
        $caurm_kods = '';
        $suga = '';
        
        $suga = $tmp_item_1['suga'];
        $tmp_skira = trim($tmp_item_1['skira']);

        if ($tmp_item_1['brakis_kods']!='') {
          $refused = true;
        }
        
        if($refused){
          $volume = round($tmp_item_1['brakis'],3);
        } else {
          $volume = round($tmp_item_1['neto'],3);
        }

        $caurm_kods = $tmp_item_1['diametrs_tmp'];
        $datarow_assortment_tmp = get_LVM_asort_kods_no_caurm_kods_XML_sorted($tmp_skira,$atskaite_veids,$caurm_kods, $suga);
        $a = explode('-',$datarow_assortment_tmp[0]);
        if(!$a[1]){$a[1] = '999';}
//------------------------------------------------------------------------------------------
        $datarow_assortmentgroup = "ZB";
        $datarow_specie = $suga;
        $datarow_rejectreason = $tmp_item_1['brakis_kods'];
        $datarow_length = $tmp_item_1['garums_tmp'];
        $datarow_assortment = $datarow_assortment_tmp[1];
        $datarow_sizegroup = $datarow_assortment_tmp[0];

        if($atskaite_veids == 28 || $atskaite_veids == 7 || $atskaite_veids == 36){
          if($tmp_skira == 3){$datarow_sizegroup = $datarow_sizegroup."(3)";}
        }

        if($atskaite_veids == 29 || $atskaite_veids == 33 || $atskaite_veids == 32){
          if($tmp_skira == 2){$datarow_sizegroup = $datarow_sizegroup."(2)";}
        }

        if($atskaite_veids == 19){
          if($tmp_skira == 2 && $suga == 'A'){$datarow_sizegroup = $datarow_sizegroup."(2)";}
        }

        if($atskaite_veids == 19){
          if($tmp_skira == 2 && $suga == 'M'){$datarow_sizegroup = $datarow_sizegroup."(2)";}
        }

        if($atskaite_veids == 16 || $atskaite_veids == 34 || $atskaite_veids == 41 || $atskaite_veids == 48 || $atskaite_veids == 54 || $atskaite_veids == 30){
          if($tmp_skira == 1){$datarow_sizegroup = "A".$datarow_sizegroup; $datarow_assortment = "A";}
        }

        if($atskaite_veids == 26 || $atskaite_veids == 35 || $atskaite_veids == 45 || $atskaite_veids == 53){
          if($suga != 'Oz' && $suga != 'Os'){
            if($tmp_skira == 'E' || $tmp_skira == '1'){
              $datarow_assortmentgroup = "FK";
              $datarow_sizegroup = "A".$datarow_sizegroup;
            }else{
              $datarow_assortmentgroup = "FK";
              $datarow_sizegroup = "B".$datarow_sizegroup;
            }
          }else{
              $datarow_assortmentgroup = "ZB";
              $datarow_sizegroup = $datarow_sizegroup;
          }
        }

        if($atskaite_veids == 42){
          if($datarow_length < 1100){
            $datarow_sizegroup = "STABI 10";
            $datarow_assortment = "STABI 10";
          }elseif($datarow_length == 1200){
            $datarow_sizegroup = "STABI 12";
            $datarow_assortment = "STABI 12";
          }elseif($datarow_length == 1300){
            $datarow_sizegroup = "STABI 13";
            $datarow_assortment = "STABI 13";
          }elseif($datarow_length > 1300){
            $datarow_sizegroup = "STABI 14";
            $datarow_assortment = "STABI 14";
          }
        }
                
        $gar_tmp = explode('-',$tmp_item_1['garums']);
        $datarow_garums_lowerlimit = $gar_tmp[0];
        $datarow_garums_upperlimit = $gar_tmp[1];

        $datarow_diameter_lowerlimit = $a[0];
        $datarow_diameter_upperlimit = $a[1];
        $datarow_overlength = round($tmp_item_1['virsmers'],3);
        $datarow_lengthreduction = round($tmp_item_1['redukcija'],3);
        $datarow_grosvolume = round($tmp_item_1['bruto'],3);
        $datarow_netvolume = $volume;
        $datarow_count = $tmp_item_1['skaits'];
        $datarow_notagreed = 0;
        
        $xml_insertData_chk_qry = "INSERT INTO `xml_gen_data` (`xml_record_id`, `entrydate`, `invoicenumber`, `invoicedate`, `contractnumber`, `measurerdocnr`, `transportjobnr`, `supplier_name`, `supplier_regnr`, `reciever_name`, `reciever_regnr`, `carrier_firmname`, `carrier_trucknumber`, `carrier_driver`, `measuring_measuringdate`, `measuring_operatorname`, `measuring_measuremethod`, `assortmorigin_fscnumber`, `assortmorigin_slashcode`, `datarow_assortmentgroup`, `datarow_specie`, `datarow_rejectreason`, `datarow_sizegroup`, `datarow_diameter_lowerlimit`, `datarow_diameter_upperlimit`, `datarow_length`, `datarow_assortment`, `datarow_overlength`, `datarow_lengthreduction`, `datarow_grosvolume`, `datarow_netvolume`, `datarow_count`, `datarow_notagreed`) VALUES ('$tmp_record_id','$entrydate','$invoicenumber','$invoicedate','$contractnumber','$measurerdocnr','$transportjobnr','$supplier_name','$supplier_regnum','$reciever_name','$reciever_regnum','$carrier_firmname','$carrier_trucknumber','$carrier_driver','$measuring_measuringdate','$measuring_operatorname','$measuring_measuremethod','$assortmorigin_fscnumber','$assortmorigin_slashcode','$datarow_assortmentgroup','$datarow_specie','$datarow_rejectreason','$datarow_sizegroup','$datarow_diameter_lowerlimit','$datarow_diameter_upperlimit','$datarow_length','$datarow_assortment','$datarow_overlength','$datarow_lengthreduction','$datarow_grosvolume','$datarow_netvolume','$datarow_count','$datarow_notagreed')";
        mysql_query($xml_insertData_chk_qry);
//------------------------------------------------------------------------------------------

        if($atskaite_veids != 666){
          $output = $output .  "\n<DataRow>\n";
          $output = $output .  "	<AssortmentGroup>".$datarow_assortmentgroup."</AssortmentGroup>\n";
          $output = $output .  "	<Specie>".$datarow_specie."</Specie>\n";
          $output = $output .  "	<SizeGroup>".$datarow_sizegroup."</SizeGroup>\n";
          $output = $output .  "	<Length>".$datarow_length."</Length>\n";
          if($datarow_rejectreason != ''){ $output = $output .  "	<RejectReason>".$datarow_rejectreason."</RejectReason>\n";}
          $output = $output .  "	<Assortment>".$datarow_assortment."</Assortment>\n";
          $output = $output .  "	<Diameter>\n		<LowerLimit>".$datarow_diameter_lowerlimit."</LowerLimit>\n		<UpperLimit>".$datarow_diameter_upperlimit."</UpperLimit>\n	</Diameter>\n";
          $output = $output .  "	<Overlength>".$datarow_overlength."</Overlength>\n";
  //        $output = $output . "	<DiameterReduction></DiameterReduction>\n";
          $output = $output .  "	<LengthReduction>".$datarow_lengthreduction."</LengthReduction>\n";
          $output = $output .  "	<GrosVolume>".$datarow_grosvolume."</GrosVolume>\n";
          $output = $output .  "	<NetVolume>".$datarow_netvolume."</NetVolume>\n";
          $output = $output .  "	<Count>".$datarow_count."</Count>\n";
          $output = $output .  "	<NotAgreed>".$datarow_notagreed."</NotAgreed>\n";
          $output = $output .  "</DataRow>\n";
        }else{
          $output = $output .  "\n<DataRow>\n";
          $output = $output .  "	<AssortmentGroup>".$datarow_assortmentgroup."</AssortmentGroup>\n";
          $output = $output .  "	<Specie>".$datarow_specie."</Specie>\n";
          $output = $output .  "	<SizeGroup>".$datarow_sizegroup."</SizeGroup>\n";
          $output = $output .  "	<Length>\n		<LowerLimit>".$datarow_garums_lowerlimit."</LowerLimit>\n		<UpperLimit>".$datarow_garums_upperlimit."</UpperLimit>\n	</Length>\n";
//          $output = $output .  "	<Length>".$datarow_length."</Length>\n";
          if($datarow_rejectreason != ''){ $output = $output .  "	<RejectReason>".$datarow_rejectreason."</RejectReason>\n";}
          $output = $output .  "	<Assortment>".$datarow_assortment."</Assortment>\n";
          $output = $output .  "	<Overlength>".$datarow_overlength."</Overlength>\n";
          $output = $output .  "	<LengthReduction>".$datarow_lengthreduction."</LengthReduction>\n";
          $output = $output .  "	<NetVolume>".$datarow_netvolume."</NetVolume>\n";
          $output = $output .  "	<Count>".$datarow_count."</Count>\n";
          $output = $output .  "	<NotAgreed>".$datarow_notagreed."</NotAgreed>\n";
          $output = $output .  "</DataRow>\n";
        }
      //---------------------------------------------------------------------------------
      $akta_nr = trim(get_param('akts_nr'));
      $sumNetokopa = $sumNetokopa + round($tmp_item_1['neto'],3);
      $sumBrakiskopa = $sumBrakiskopa + round($tmp_item_1['brakis'],3);
      $sumVirsmerskopa = $sumVirsmerskopa + round($tmp_item_1['virsmers'],3);
      $sumRedukcijakopa = $sumRedukcijakopa + round($tmp_item_1['redukcija'],3);
      $sumBrutokopa = $sumBrutokopa + round($tmp_item_1['bruto'],3);
      $sumSkaitskopa = $sumSkaitskopa + $tmp_item_1['skaits'];
    }
   }

    $output = $output . "\n</Invoice>";

//----*.xml datu faila kopsummu aprēķināšana--------------------------------------------------------------------------------
    $resultOut = array();
    $resultOut['file_content'] = $output;
    $resultOut['skaits'] = $sumSkaitskopa;
    $resultOut['neto_kopa'] = $sumNetokopa;
    $resultOut['brakis_kopa'] = $sumBrakiskopa;
    $resultOut['virsmers_kopa'] = $sumVirsmerskopa;
    $resultOut['redukcija_kopa'] = $sumRedukcijakopa;
    $resultOut['bruto_kopa'] = $sumBrutokopa;
    $resultOut['akta_nr'] = $akta_nr;

    return $resultOut;
  }

}//CReport klases beigas

function nominalGarums($l,$virsmeri,$min_virsmers){
  if (count($virsmeri)>0){
    $result = 0;
    for ($i=0;$i<count($virsmeri);$i++){
      if (($virsmeri[$i] + $min_virsmers) <= $l){
        $result = $virsmeri[$i];
      }
    }
  }else{
    $l = $l / 10;
    $l = round($l,2);
    $result = $l;
  }

  return $result;
}

function get_person($person_value){
  if($person_value == '2') $person = "Jānis Buļs<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29470949";
  if($person_value == '3') $person = "Ingus Donis<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29122585";
  if($person_value == '4') $person = "S.Beņķe<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26447465";
  if($person_value == '5') $person = "G.Ziemele<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26595831";
  if($person_value == '10') $person = "G.Ceriņa<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29266992";
  if($person_value == '11') $person = "S.Grosvalde<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29455959";
  if($person_value == '12') $person = "L.Poriete<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29279787";
  if($person_value == '13') $person = "M.Sekste<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 20275737";
  if($person_value == '7') $person = "Jānis Buļs<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29470949";
  if($person_value == '14') $person = "Gunta Ziemele<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26595831";
  if($person_value == '8') $person = "Ingus Donis<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 29122585";
  if($person_value == '9') $person = "Aldis Ladusāns<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 26386152";
  return $person;
}

function AI_getcompare($pavadzime,$output_value){
  $tmp_query_txt = "SELECT * FROM g_registrs WHERE pavadzime = '".trim($pavadzime)."' AND `opcija` = 'A'";
  $tmp_query = mysql_query($tmp_query_txt);
  $tmp_arr = mysql_fetch_assoc($tmp_query);
  return $tmp_arr;
}

function CompareArrays($x,$y){
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

function get_AtskaitesVeids($atskaiteNum){ // Funkcija tiek izmantota, lai pievienotu saņēmēju G-Atskaitei
  switch ($atskaiteNum){
      case 11:
      $result = "Swedwood";
      break;
      case 12:
      $result = "Rettenmeier";
      break;
      case 28:
      $result = "Piebalgas";
      break;
      case 33:
      $result = "4 Plus";
      break;
      case 29:
      $result = "Ošukalns";
      break;
      case 27:
      $result = "Kurekss";
      break;
      case 25:
      $result = "Stora Enso Timber";
      break;
      case 18:
      $result = "AKZ";
      break;
      case 23:
      $result = "Smiltene Impex";
      break;
      case 26:
      $result = "Latvijas Finieris";
      break;
      case 21:
      $result = "Gaujas Koks";
      break;
      case 22:
      $result = "Vudlande";
      break;
      case 20:
      $result = "BSW Latvia";
      break;
      case 24:
      $result = "Pata AB";
      break;
      case 16:
      $result = "Tezei-S";
      break;
      case 2:
      $result = "Vika Wood";
      break;
      case 35:
      $result = "Ka un Mo";
      break;
      case 7:
      $result = "Akrs";
      break;
      case 34:
      $result = "TFK Latekss";
      break;
      case 32:
      $result = "Liepas-AK";
      break;
      case 30:
      $result = "LDM Koks";
      break;
      case 31:
      $result = "Hansa Timber Trade";
      break;
      case 13:
      $result = "Tezei-S";
      break;
      case 36:
       $result = "Zelma 22";
      break;
      case 37:
       $result = "Inerce";
      break;
      case 38:
       $result = "Marko KEA";
      break;
      case 39:
        $result = "Āboltiņa būvuzņēmums";
      break;
      case 40:
        $result = "Krauss";
      break;
      case 41:
        $result = "Triomax";
      break;
      case 42:
        $result = "Sadales tīkls";
      break;
      case 44:
        $result = "Vaidens";
      break;
      case 45:
        $result = "Kurzemes Finieris";
      break;
      case 47:
        $result = "Īveja";
      break;
      case 48:
        $result = "Frip";
      break;
      case 49:
        $result = "Talsu mežrūpniecība";
      break;
      case 46:
        $result = "Vārpas 1";
      break;
      case 50:
        $result = "Sinda & VR";
      break;
      case 52:
        $result = "Maileks";
      break;
      case 53:
        $result = "Dižmežs";
      break;
      case 54:
        $result = "Latvāņi";
      break;
      case 55:
        $result = "Jēkabpils mežrūpniecība";
      break;
      case 19:
        $result = "Kubikmetrs";
      break;
      case 57:
        $result = "SGA Plus";
      break;
      case 51:
        $result = "Timberex Group";
      break;
      case 58:
        $result = "G. Matroža kokzāģētava";
      break;
      default:
        $result = "Kontrolmerijumi";
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

function compare($x, $y){
 if ( $x[1] == $y[1] )
  return 0;
 else if ( $x[1] < $y[1] )
  return -1;
 else
  return 1;
}

function mod_ResignLVMRejectCode($atskaite_num,$liguma_matrica,$tmpr_Garums,$tmpr_Diametrs,$tmpr_Suga,$tmp_Skira,$tmp_brakis){
  $tmp_result = false;
  
  switch($atskaite_num){
    case 12:
      if ((($tmpr_Diametrs >= 90 && $tmpr_Diametrs <= 299) && ($tmpr_Garums >= 365 && $tmpr_Garums < 620)) || (($tmpr_Diametrs >= 300 && $tmpr_Diametrs <= 399) && ($tmpr_Garums >= 425 && $tmpr_Garums < 620))){
        $tmp_result = true;
      }
    break;
    case 11:
    if($liguma_matrica != '3M'){
      if (($tmpr_Diametrs >= 90 && $tmpr_Diametrs <= 299) && ($tmpr_Garums >= 308 && $tmpr_Garums < 625)){
        $tmp_result = true;
      }
    }else{
      if (($tmpr_Diametrs >= 90 && $tmpr_Diametrs <= 299) && ($tmpr_Garums >= 308 && $tmpr_Garums < 333)){
        $tmp_result = true;
      }
    }
    break;
    case 34:
      if (($tmpr_Diametrs >= 240 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 309 && $tmpr_Garums < 454)){
        $tmp_result = true;
      }
    break;
    case 51:
      if (($tmpr_Suga == 1 && (($tmpr_Diametrs >= 140 && $tmpr_Diametrs <= 500) && ($tmpr_Garums >= 365 && $tmpr_Garums < 542))) || ($tmpr_Suga == 2 && (($tmpr_Diametrs >= 140 && $tmpr_Diametrs <= 299) && ($tmpr_Garums >= 365 && $tmpr_Garums < 542) || ($tmpr_Diametrs >= 300 && $tmpr_Diametrs <= 420) && ($tmpr_Garums >= 365 && $tmpr_Garums < 512)))){
        $tmp_result = true;
      }
    break;
    case 25:
      if(($tmpr_Diametrs >= 90 && $tmpr_Diametrs <= 550) && ($tmpr_Garums >= 307 && $tmpr_Garums <= 628)){
        $tmp_result = true;
      }
    break;
    case 26:
        if(($tmpr_Diametrs >= 0 && $tmpr_Diametrs < 130) && ($tmpr_Garums >= 220 && $tmpr_Garums <= 600) && $liguma_matrica == 'AC' && $tmp_brakis == '017'){
          $tmp_result = true;
        }
    break;
    case 21:
      if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 600) && ($tmpr_Garums >= 365 && $tmpr_Garums <= 628) && $liguma_matrica == 'ST'){
//      if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 600) && ($tmpr_Garums >= 365 && $tmpr_Garums <= 628)){
        $tmp_result = true;
      }
      if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 600) && ($tmpr_Garums >= 368 && $tmpr_Garums <= 631) && $liguma_matrica == 'JP'){
        $tmp_result = true;
      }
    break;
    case 52:
      if ($tmpr_Suga == 4 && ($tmpr_Diametrs >= 180 && $tmpr_Diametrs <= 1000) && ($tmpr_Garums >= 305 && $tmpr_Garums < 355)){
        $tmp_result = true;
      }
    break;
    case 50:
      if (($tmpr_Diametrs >= 180 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 269 && $tmpr_Garums < 375)){
        $tmp_result = true;
      }
    break;
    case 58:
      if ($tmpr_Suga == 1 && ($tmpr_Diametrs >= 160 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 310 && $tmpr_Garums < 632)){
        $tmp_result = true;
      }
    break;
    case 28:
      if($liguma_matrica != 'J3'){
        if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 219) && ($tmpr_Garums >= 367 && $tmpr_Garums <= 514)){
          $tmp_result = false;
        }
      }
    break;
    case 35:
      if (($tmpr_Diametrs >= 180 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 280 && $tmpr_Garums <= 315)){
        $tmp_result = true;
      }
    break;
    case 38:
      if (((($tmpr_Diametrs >= 160 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 250 && $tmpr_Garums <= 515)) && $tmpr_Suga == 0) || ((($tmpr_Diametrs >= 140 && $tmpr_Diametrs <= 500) && ($tmpr_Garums >= 250 && $tmpr_Garums <= 425)) && $tmpr_Suga == 1)){
        $tmp_result = true;
      }
    break;
    case 36:
      if (($tmpr_Diametrs >= 160 && $tmpr_Diametrs <= 600) && ($tmpr_Garums >= 230 && $tmpr_Garums <= 326)){
        $tmp_result = true;
      }
    break;
    case 27:
      if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 500) && ($tmpr_Garums >= 308 && $tmpr_Garums <= 634)){
        $tmp_result = true;
      }
    break;
    case 16:
      if ($tmpr_Garums >= 308 && $tmpr_Garums <= 635){
        $tmp_result = true;
      }
    break;
    case 45:
      if (($tmpr_Diametrs >= 180 && $tmpr_Diametrs <= 700) && ($tmpr_Garums >= 28 && $tmpr_Garums <= 160)){
        $tmp_result = true;
      }
    break;
    case 32:
      if (($tmpr_Diametrs >= 160 && $tmpr_Diametrs <= 2000) && ($tmpr_Garums >= 300 && $tmpr_Garums <= 335)){
        $tmp_result = false;
      }
    break;
    case 23:
      if (($tmpr_Diametrs >= 140 && $tmpr_Diametrs <= 400) && ($tmpr_Garums >= 308 && $tmpr_Garums <= 625)){
        $tmp_result = true;
      }
    break;
    case 24:
      if (($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 600) && ($tmpr_Garums >= 366 && $tmpr_Garums <= 541) && $liguma_matrica == 'LZ'){
        $tmp_result = true;
      }
    break;
    case 4:
      if ((($tmpr_Diametrs >= 100 && $tmpr_Diametrs <= 159) && ($tmpr_Garums >= 305 && $tmpr_Garums <= 390)) || (($tmpr_Diametrs >= 160 && $tmpr_Diametrs <= 400) && ($tmpr_Garums >= 305 && $tmpr_Garums <= 630))){
        $tmp_result = true;
      }
    break;
    case 30:
      if ((($tmpr_Diametrs >= 260 && $tmpr_Diametrs <= 999) && ($tmpr_Garums >= 300 && $tmpr_Garums <= 632) && $tmp_Skira == 4) && (($tmpr_Diametrs >= 260 && $tmpr_Diametrs <= 999) && ($tmpr_Garums >= 300 && $tmpr_Garums <= 332) && $tmp_Skira == 1)){
        $tmp_result = true;
      }
    break;
    case 48:
      if ((($tmpr_Diametrs >= 260 && $tmpr_Diametrs <= 999) && ($tmpr_Garums >= 300 && $tmpr_Garums <= 632) && $tmp_Skira == 4) && (($tmpr_Diametrs >= 260 && $tmpr_Diametrs <= 999) && ($tmpr_Garums >= 300 && $tmpr_Garums <= 332) && $tmp_Skira == 1)){
        $tmp_result = true;
      }
    break;
  }
  
  $result = $tmp_result;
  return $result;
}

function corrTrueDeffectCode($atskaite_num, $is_xml){
  $braki = array();
  
  if(!$is_xml){
    $braki['856']['LAT'] = 'Spec. neatbilstošs';
    $braki['899']['LAT'] = 'Dimensijas brāķis';
    
    switch($atskaite_num){
      case 12: //Rettenmeier Baltic Timber
        $braki['000']['LAT'] = 'Nav definēts'; //Tukšais brāķis
        $braki['001']['LAT'] = 'Stumbra forma';
        $braki['002']['LAT'] = 'Metāls';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Zari';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Glabāšana';
        $braki['007']['LAT'] = 'Mazs garums';
        $braki['008']['LAT'] = 'Mazs diametrs';
        $braki['009']['LAT'] = 'Liels garums';
        $braki['010']['LAT'] = 'Liels sakņu kakls';
        $braki['011']['LAT'] = 'Spec. neatbilsotšs';
        $braki['012']['LAT'] = 'Liels tievgaļa diametrs';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 54://Latvāņi
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Max resnākā vieta par lielu';
        $braki['004']['LAT'] = 'Max tievgalis par lielu';
        $braki['005']['LAT'] = 'Gadskārtas, Meža trupe, saspiesta koksne, gala plaisas';
        $braki['006']['LAT'] = 'Stumbra forma';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Par īsu';
        $braki['011']['LAT'] = 'Neatbilstība specifikācijai';

        $braki['255']['LAT'] = '';
      break;
      case 19://4 Plus
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Glabāšana';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Max tievgalis par lielu';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Stumbra forma';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Dimensija';
        $braki['011']['LAT'] = 'Neatbilstība specifikācijai';
        $braki['255']['LAT'] = '';
      break;
      case 11://Swedwood
        $braki['000']['LAT'] = 'Nav definēts'; //Tukšais brāķis
        $braki['001']['LAT'] = 'Stumbra forma';
        $braki['002']['LAT'] = 'Metāls';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Zari';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Glabāšana';
        $braki['007']['LAT'] = 'Mazs garums';
        $braki['008']['LAT'] = 'Mazs diametrs';
        $braki['009']['LAT'] = 'Liels garums';
        $braki['010']['LAT'] = 'Liels sakņu kakls';
        $braki['011']['LAT'] = 'Spec. neatbilsotšs';
        $braki['012']['LAT'] = 'Liels tievgaļa diametrs';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 20://BSW Latvia
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['011']['LAT'] = 'Nav Definēts';//BSW rūpnīcā kā tukšs
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 8:
        $braki['000']['LAT'] = 'Metāla ieslēgumi';
        $braki['001']['LAT'] = 'Stumbra formas vainas';
        $braki['002']['LAT'] = 'Saussāns';
        $braki['003']['LAT'] = 'Zari';
        $braki['004']['LAT'] = 'Līkumainība';
        $braki['005']['LAT'] = 'Glabāšanas vainas';
        $braki['006']['LAT'] = 'Ražošanas vainas';
        $braki['007']['LAT'] = 'Trupe';
        $braki['008']['LAT'] = 'Resnākā vieta';
        $braki['009']['LAT'] = 'Cits';
        $braki['010']['LAT'] = 'Spec. neatbilstošs';
        $braki['011']['LAT'] = '3. šķira';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['401']['LAT'] = 'Zilējums';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 28: // Piebalgas
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Par resnu resgalis';
        $braki['004']['LAT'] = 'Par resnu tievgalis';
        $braki['005']['LAT'] = 'Trupe, lielainums';
        $braki['006']['LAT'] = 'Saussānis';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Par īsu';
        $braki['011']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Diametra neatbilstība';
        $braki['013']['LAT'] = 'Garuma neatbilstība';
        $braki['014']['LAT'] = 'Dimensija';
        $braki['255']['LAT'] = '';
      break;
      case 16://Tezei-S
/*
        $braki['000']['LAT'] = 'Metāla ieslēgumi';
        $braki['001']['LAT'] = 'Stumbra formas vainas';
        $braki['002']['LAT'] = 'Saussāns';
        $braki['003']['LAT'] = 'Zari';
        $braki['004']['LAT'] = 'Līkumainība';
        $braki['005']['LAT'] = 'Glabāšanas vainas';
        $braki['006']['LAT'] = 'Ražošanas vainas';
        $braki['007']['LAT'] = 'Trupe';
        $braki['008']['LAT'] = 'Resnākā vieta';
        $braki['009']['LAT'] = 'Cits';
        $braki['010']['LAT'] = 'Spec. neatbilstošs';
        $braki['011']['LAT'] = '3. šķira';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['401']['LAT'] = 'Zilējums';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
*/      
        $braki['000']['LAT'] = 'Dimensijas brāķis';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Dimensijas brāķis';
        $braki['003']['LAT'] = 'Dimensijas brāķis';
        $braki['004']['LAT'] = 'Dimensijas brāķis';
        $braki['005']['LAT'] = 'Trupe, lielainums';
        $braki['006']['LAT'] = 'Saussānis';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Dimensijas brāķis';
        $braki['011']['LAT'] = 'Dimensijas brāķis';
        $braki['012']['LAT'] = 'Dimensijas brāķis';
        $braki['013']['LAT'] = 'Dimensijas brāķis';
        $braki['014']['LAT'] = 'Dimensija';
        $braki['015']['LAT'] = 'Ražošana';
        $braki['255']['LAT'] = '';

      break;
      case 55:
        $braki['000']['LAT'] = 'Metāls'; //Nezinu!
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Par resnu resgalis';
        $braki['004']['LAT'] = 'Par resnu tievgalis';
        $braki['005']['LAT'] = 'Trupe, lielainums';
        $braki['006']['LAT'] = 'Saussānis';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Par īsu';
        $braki['011']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Diametra neatbilstība';
        $braki['013']['LAT'] = 'Garuma neatbilstība';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'C';
        $braki['016']['LAT'] = 'Līkumainība';
        $braki['017']['LAT'] = 'Citi';
        $braki['255']['LAT'] = '';      
      break;
      case 24: // Saldus MR
/*
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
*/
/*
        $braki['000']['LAT'] = 'Metāls'; //Nezinu!
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Par resnu resgalis';
        $braki['004']['LAT'] = 'Par resnu tievgalis';
        $braki['005']['LAT'] = 'Trupe, lielainums';
        $braki['006']['LAT'] = 'Saussānis';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Par īsu';
        $braki['011']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Diametra neatbilstība';
        $braki['013']['LAT'] = 'Garuma neatbilstība';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'C';
        $braki['016']['LAT'] = 'Līkumainība';
        $braki['017']['LAT'] = 'Citi';
        $braki['255']['LAT'] = '';
*/
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 33://4 Plus
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Glabāšana';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Max tievgalis par lielu';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Stumbra forma';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Dimensija';
        $braki['011']['LAT'] = 'Neatbilstība specifikācijai';
        $braki['255']['LAT'] = '';
      break;
      case 29://Ošukalns
        $braki['000']['LAT'] = 'Dimensija';
        $braki['001']['LAT'] = 'Dimensija';
        $braki['002']['LAT'] = 'Dimensija';
        $braki['003']['LAT'] = 'Dimensija';
        $braki['004']['LAT'] = 'Dimensija';
        $braki['005']['LAT'] = 'Ražošana';
        $braki['006']['LAT'] = 'Dimensija';
        $braki['007']['LAT'] = 'Glabāšana';
        $braki['008']['LAT'] = 'Stumbra forma';
        $braki['009']['LAT'] = 'Trupe, zari';
        $braki['010']['LAT'] = 'Dimensija';
        $braki['011']['LAT'] = 'Dimensija';
        $braki['012']['LAT'] = 'Dimensija';
        $braki['013']['LAT'] = 'Dimensija';
        $braki['014']['LAT'] = 'Dimensija';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 27: // Kurekss
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Liela sakne';
        $braki['004']['LAT'] = 'Par resnu tievgalis';
        $braki['005']['LAT'] = 'Līkumainība';
        $braki['006']['LAT'] = 'Trupe';
        $braki['007']['LAT'] = 'Tehnisks bojājums';
        $braki['008']['LAT'] = 'Zari';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Ieaugumi';
        $braki['011']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Zilējis';
        $braki['013']['LAT'] = 'Dubultlīkumainība';
        $braki['014']['LAT'] = 'L. nepareiza suga';
        $braki['015']['LAT'] = 'Kontrolbaļķis';
        $braki['016']['LAT'] = 'Nezināms';
        $braki['017']['LAT'] = 'Bez šķiras';
        $braki['018']['LAT'] = 'V. nepareiza suga';
        $braki['019']['LAT'] = 'Nepareiza suga';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 25://Stora Enso Latvija
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Par garu';
        $braki['003']['LAT'] = 'Par resnu max diam.';
        $braki['004']['LAT'] = 'Par resnu tievgalis';
        $braki['005']['LAT'] = 'Saliktā līkumainība';
        $braki['006']['LAT'] = 'Trupe, lielainums';
        $braki['007']['LAT'] = 'Mehāniskais bojājums';
        $braki['008']['LAT'] = 'Zari';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Dubultgalotne';
        $braki['011']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Kukainis';
        $braki['013']['LAT'] = 'Līkumainība';
        $braki['014']['LAT'] = 'Cita suga';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Kontrolbalkis';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 18://AKZ
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Papīrmalka';
        $braki['003']['LAT'] = 'Par resnu maks. diam.';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['019']['LAT'] = 'Līkumainība';
        $braki['255']['LAT'] = '';
      break;
      case 23:// Smiltene Impex
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Papīrmalka';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
			break;
      case 26://Latvijas Finieris, Verems
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';

        $braki['701']['LAT'] = 'Papīrmalka';
        $braki['702']['LAT'] = 'Papīrmalka';
        $braki['703']['LAT'] = 'Papīrmalka';
        $braki['704']['LAT'] = 'Papīrmalka';
        $braki['705']['LAT'] = 'Papīrmalka';
        $braki['706']['LAT'] = 'Papīrmalka';
        $braki['707']['LAT'] = 'Papīrmalka';
        $braki['708']['LAT'] = 'Papīrmalka';
        $braki['709']['LAT'] = 'Papīrmalka';
        $braki['710']['LAT'] = 'Papīrmalka';
        $braki['716']['LAT'] = 'Papīrmalka';
        $braki['717']['LAT'] = 'Papīrmalka';
        $braki['718']['LAT'] = 'Papīrmalka';

      break;
      case 21: //Gaujas Koks
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu resgalis';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['019']['LAT'] = 'Zilējums';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
/*
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
*/        
      break;
      case 22:
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Glabāšana';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Max tievgalis par lielu';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Stumbra forma';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Dimensija';
        $braki['011']['LAT'] = 'Neatbilstība specifikācijai';
        $braki['255']['LAT'] = '';
      break;
      case 46:
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Metāls';
        $braki['002']['LAT'] = 'Glabāšana';
        $braki['003']['LAT'] = 'Ražošana';
        $braki['004']['LAT'] = 'Max tievgalis par lielu';
        $braki['005']['LAT'] = 'Trupe';
        $braki['006']['LAT'] = 'Stumbra forma';
        $braki['007']['LAT'] = 'Zari';
        $braki['008']['LAT'] = 'Līkumainība';
        $braki['009']['LAT'] = 'Citi';
        $braki['010']['LAT'] = 'Dimensija';
        $braki['011']['LAT'] = 'Neatbilstība specifikācijai';
        $braki['255']['LAT'] = '';
      break;
      case 2://Vika wood
        $braki['000']['LAT'] = 'Metāls';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Par resnu max diam.';
        $braki['003']['LAT'] = 'Par resnu tievgalis';
        $braki['004']['LAT'] = 'Trupe, lielainums';
        $braki['005']['LAT'] = 'Saussānis';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Citi';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Par tievu';
        $braki['012']['LAT'] = 'Līkumainība';
        $braki['016']['LAT'] = 'Diametra neatbilstība';
        $braki['017']['LAT'] = 'Garuma neatbilstība';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;

      default://Latekss,

        $braki['000']['LAT'] = 'Metāla ieslēgumi';
        $braki['001']['LAT'] = 'Stumbra formas vainas';
        $braki['002']['LAT'] = 'Saussāns';
        $braki['003']['LAT'] = 'Zari';
        $braki['004']['LAT'] = 'Līkumainība';
        $braki['005']['LAT'] = 'Glabāšanas vainas';
        $braki['006']['LAT'] = 'Ražošanas vainas';
        $braki['007']['LAT'] = 'Trupe';
        $braki['008']['LAT'] = 'Resnākā vieta';
        $braki['009']['LAT'] = 'Cits';
        $braki['010']['LAT'] = 'Spec. neatbilstošs';
        $braki['011']['LAT'] = '3. šķira';
        $braki['012']['LAT'] = 'Par Garu';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['401']['LAT'] = 'Zilējums';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
/*
        $braki['000']['LAT'] = 'Par tievu';
        $braki['001']['LAT'] = 'Par garu';
        $braki['002']['LAT'] = 'Max resnākā vieta par lielu';
        $braki['003']['LAT'] = 'Max tievgalis par lielu';
        $braki['004']['LAT'] = 'Gadskārtas, Meža trupe, saspiesta koksne, gala plaisas';
        $braki['005']['LAT'] = 'Sausānis, kaltuši, sānu plaisas';
        $braki['006']['LAT'] = 'Zari';
        $braki['007']['LAT'] = 'Līkumainība';
        $braki['008']['LAT'] = 'Cits';
        $braki['009']['LAT'] = 'Par īsu';
        $braki['010']['LAT'] = 'Spec. neatbilstošs';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
*/

      break;
    }
  }else{
    $braki['899']['LAT'] = 'D';
    $braki['856']['LAT'] = '4';
    switch($atskaite_num){
      case 12:
        $braki['000']['LAT'] = 'N'; //Tukšais brāķis
        $braki['001']['LAT'] = 'S';
        $braki['002']['LAT'] = 'M';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Z';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'G';
        $braki['007']['LAT'] = 'D';
        $braki['008']['LAT'] = 'D';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'D';
        $braki['016']['LAT'] = 'N';
        $braki['017']['LAT'] = 'N';
        $braki['255']['LAT'] = '';
      break;
      case 11:
        $braki['000']['LAT'] = 'N'; //Tukšais brāķis
        $braki['001']['LAT'] = 'S';
        $braki['002']['LAT'] = 'M';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Z';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'G';
        $braki['007']['LAT'] = 'D';
        $braki['008']['LAT'] = 'D';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'D';
        $braki['016']['LAT'] = 'N';
        $braki['017']['LAT'] = 'N';
        $braki['255']['LAT'] = '';
      break;
      case 2:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['012']['LAT'] = 'L';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 20:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'C';
        $braki['012']['LAT'] = 'L';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 28:
        $braki['000']['LAT'] = 'D';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'C';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
      break;
      case 16:
/*
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'S';
        $braki['002']['LAT'] = 'C';
        $braki['003']['LAT'] = 'Z';
        $braki['004']['LAT'] = 'L';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'C';
        $braki['007']['LAT'] = 'T';
        $braki['008']['LAT'] = 'D';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = '4';
        $braki['011']['LAT'] = '3';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['401']['LAT'] = '3';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
*/      
        $braki['000']['LAT'] = 'D';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'C';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'D';
        $braki['014']['LAT'] = 'D';
        $braki['015']['LAT'] = 'R';
        $braki['255']['LAT'] = '';

      break;
      case 24:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['012']['LAT'] = 'L';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';

/*
        $braki['000']['LAT'] = 'M';//Nezinu!
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'C';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'D';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'C';
        $braki['016']['LAT'] = 'L';
        $braki['017']['LAT'] = 'C';
        $braki['255']['LAT'] = '';
*/
      break;
      case 55:
        $braki['000']['LAT'] = 'M';//Nezinu!
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'C';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'D';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'C';
        $braki['016']['LAT'] = 'L';
        $braki['017']['LAT'] = 'C';
        $braki['255']['LAT'] = '';      
      break;
      case 33:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'G';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Nav definēts';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'S';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 26:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'L';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';

        $braki['701']['LAT'] = '4';
        $braki['702']['LAT'] = '4';
        $braki['703']['LAT'] = '4';
        $braki['704']['LAT'] = '4';
        $braki['705']['LAT'] = '4';
        $braki['706']['LAT'] = '4';
        $braki['707']['LAT'] = '4';
        $braki['708']['LAT'] = '4';
        $braki['709']['LAT'] = '4';
        $braki['710']['LAT'] = '4';
        $braki['716']['LAT'] = '4';
        $braki['717']['LAT'] = '4';
        $braki['718']['LAT'] = '4';

      break;
      case 29:
        $braki['000']['LAT'] = 'D';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'R';
        $braki['006']['LAT'] = 'D';
        $braki['007']['LAT'] = 'G';
        $braki['008']['LAT'] = 'S';
        $braki['009']['LAT'] = 'T';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'D';
        $braki['014']['LAT'] = 'D';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 27:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'L';
        $braki['006']['LAT'] = 'T';
        $braki['007']['LAT'] = 'C';
        $braki['008']['LAT'] = 'Z';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'C';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'C';
        $braki['013']['LAT'] = 'L';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'C';
        $braki['016']['LAT'] = 'C';
        $braki['017']['LAT'] = 'C';
        $braki['018']['LAT'] = 'C';
        $braki['019']['LAT'] = 'C';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 25:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'D';
        $braki['005']['LAT'] = 'L';
        $braki['006']['LAT'] = 'T';
        $braki['007']['LAT'] = 'C';
        $braki['008']['LAT'] = 'Z';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'C';
        $braki['011']['LAT'] = 'D';
        $braki['012']['LAT'] = 'C';
        $braki['013']['LAT'] = 'L';
        $braki['014']['LAT'] = 'C';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'C';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 18:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'C';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'L';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'L';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 23:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = '4';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'G';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['012']['LAT'] = 'L';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['255']['LAT'] = '';
			break;
      case 21:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'D';
        $braki['002']['LAT'] = 'D';
        $braki['003']['LAT'] = 'D';
        $braki['004']['LAT'] = 'T';
        $braki['005']['LAT'] = 'C';
        $braki['006']['LAT'] = 'Z';
        $braki['007']['LAT'] = 'L';
        $braki['008']['LAT'] = 'C';
        $braki['009']['LAT'] = 'D';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = 'Nav definēts';
        $braki['012']['LAT'] = 'L';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'D';
        $braki['017']['LAT'] = 'D';
        $braki['019']['LAT'] = 'C';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';
      break;
      case 22:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'G';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Nav definēts';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'S';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 46:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'G';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Nav definēts';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'S';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 54:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'Nav definēts';
        $braki['003']['LAT'] = 'Nav definēts';
        $braki['004']['LAT'] = 'Nav definēts';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'S';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      case 19:
        $braki['000']['LAT'] = 'Nav definēts';
        $braki['001']['LAT'] = 'M';
        $braki['002']['LAT'] = 'G';
        $braki['003']['LAT'] = 'R';
        $braki['004']['LAT'] = 'Nav definēts';
        $braki['005']['LAT'] = 'T';
        $braki['006']['LAT'] = 'S';
        $braki['007']['LAT'] = 'Z';
        $braki['008']['LAT'] = 'L';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = 'D';
        $braki['011']['LAT'] = '4';
        $braki['012']['LAT'] = 'Nav definēts';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['255']['LAT'] = '';
      break;
      default:
        $braki['000']['LAT'] = 'M';
        $braki['001']['LAT'] = 'S';
        $braki['002']['LAT'] = 'R';
        $braki['003']['LAT'] = 'Z';
        $braki['004']['LAT'] = 'S';
        $braki['005']['LAT'] = 'G';
        $braki['006']['LAT'] = 'R';
        $braki['007']['LAT'] = 'T';
        $braki['008']['LAT'] = 'D';
        $braki['009']['LAT'] = 'C';
        $braki['010']['LAT'] = '4';
        $braki['011']['LAT'] = '3';
        $braki['012']['LAT'] = 'D';
        $braki['013']['LAT'] = 'Nav definēts';
        $braki['014']['LAT'] = 'Nav definēts';
        $braki['015']['LAT'] = 'Nav definēts';
        $braki['016']['LAT'] = 'Nav definēts';
        $braki['017']['LAT'] = 'Nav definēts';
        $braki['018']['LAT'] = 'Nav definēts';
        $braki['019']['LAT'] = 'Nav definēts';
        $braki['401']['LAT'] = '3';
        $braki['255']['LAT'] = '';
        $braki['256']['LAT'] = '';

      break;
    }
  }
  
  $result = $braki;
  return $result;
}

function getSupremeSugas($getTrue, $is_xml){
  if($getTrue){
    $sugas = array();
    if($is_xml){
      $sugas['0']['LAT'] = 'SK';
      $sugas['1']['LAT'] = 'P';
      $sugas['2']['LAT'] = 'E';
      $sugas['3']['LAT'] = 'LK';
      $sugas['4']['LAT'] = 'B';
      $sugas['5']['LAT'] = 'A';
      $sugas['6']['LAT'] = 'Os';
      $sugas['7']['LAT'] = 'M';
      $sugas['8']['LAT'] = 'Oz';
    }else{
      $sugas['0']['LAT'] = 'Skuju koks';
      $sugas['1']['LAT'] = 'Priede';
      $sugas['2']['LAT'] = 'Egle';
      $sugas['3']['LAT'] = 'Lapu koki';
      $sugas['4']['LAT'] = 'Bērzs';
      $sugas['5']['LAT'] = 'Apse';
      $sugas['6']['LAT'] = 'Osis';
      $sugas['7']['LAT'] = 'Alksnis';
      $sugas['8']['LAT'] = 'Ozols';
    }
  }else{
    $result = false;
  }
  $result = $sugas;
  return $result;
}

function run_mysql_by_partitions($part,$tmp_query) {
  $size = 100;
  $off = $part*$size;
  $result = $tmp_query." LIMIT ".$off.", ".$size;
  return $result;
}



function array_orderby(){
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}
?>