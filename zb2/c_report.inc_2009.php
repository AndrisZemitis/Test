<?php

include("valoda.php");

gAtskaite::loadDefectCodes();
gAtskaite::loadSpecieTypes();

class C_REPORT
{
var $lsk;					// grupēšanas līmeņu skaits
var $xml_vars=array();
//var $lasttype;
var $lasttype = 'data'; // vai otra vērtība 'sum'
var $rowclosed;
var $arr_index;
var $mtipi = array();
var $ERRORS = '';
var $MyPOST;
var $grup;
var $arr = array();			// izejas masīvs, HTML gadījumā
var $braki;
var $XML_Variants;
var $sugas;
var $pieg_grupa;
//var $lang;

var $allowed_values;
var $rejected_values;
var $diam_allowed_values;
var $gar_allowed_values;

function C_REPORT(&$My_POST,&$DB,$XML_Variants,$grup)
	{
	
	global $lang;
	global $translate;

	if ($lang != "RUS") {
		$lang = "LAT";
	}

	$this->XML_Variants=$XML_Variants; 
	$this->sugas=gAtskaite::$sugas;
	$this->MyPOST=$My_POST;
	$this->grup=$grup;
	if (strrpos($this->MyPOST['pavadzime'],"KRVII") === false) {
		$this->braki=gAtskaite::$VIKA_braki;
		gAtskaite::$LVM_braki=gAtskaite::$VIKA_LVM_braki;
	} else {
		$this->braki=gAtskaite::$braki;
	}

	$this->XMLVARS();
	$this->SetParam();
	$this->mtipi['auto'] = $translate['auto_nr2'][$lang];
	$this->mtipi['brakis'] = $translate['brakis'][$lang];
	$this->mtipi['cenu_matrica'] = $translate['cenu_matrica2'][$lang];
	$this->mtipi['kad_piegad'] = $translate['datums2'][$lang];
	$this->mtipi['mind_pirms_red'] = $translate['diametrs2'][$lang];
	$this->mtipi['fsc'] = $translate['fsc2'][$lang];
	$this->mtipi['garums'] = $translate['garums2'][$lang];
	$this->mtipi['kravas_id'] = $translate['kravas_id2'][$lang];
	$this->mtipi['pavadzime.pavadzime'] = $translate['pavadzime2'][$lang];
	$this->mtipi['piegad_kods'] = $translate['piegadatajs2'][$lang];
	$this->mtipi['soferis'] = $translate['soferis2'][$lang];
	$this->mtipi['suga'] = $translate['suga2'][$lang];
	$this->mtipi['skira'] = $translate['skira2'][$lang];
	$this->mtipi['iecirknis'] = $translate['iecirknis2'][$lang];

	if($_SERVER['REQUEST_METHOD']=='POST' && $this->XML_Variants)
		{	

			if(trim($this->MyPOST['pieg_lig_num'])=='') $this->ERRORS.= "Nav norādīts PIEGĀDES LĪGUMA numurs!<br><br>";
	
			if(trim($this->MyPOST['pavadzime'])!='')
				{
				if	(!GetFromPavadzime($this->MyPOST['pavadzime'],'pavadzime') ) $this->ERRORS .= "Norādīts NEEKSISTĒJOŠS PAVADZĪMES numurs!<br><br>"; 
	
				} else $this->ERRORS .= "Nav norādīts PAVADZĪMES numurs!<br><br>";
		}

	if ($this->MyPOST[subm] && !$this->ERRORS)
	{	

		// --------------------cik grup??anas l?me?i izmantoti ----------------------------
		$this->lsk = 0;
		while ($this->MyPOST["gtype".$this->grup.($this->lsk+1)]!='') $this->lsk++;
		// --------------------cik grup??anas l?me?i izmantoti ----------------------------
		
		
		// Pārbauda vai nav vairāku pavazdīmju ar šādu numuru
		if ($this->MyPOST['pavadzime'] && !$this->MyPOST[pavadzime_id]) 
		{
			$pav_test_query = "select count(*) as x from pavadzime where pavadzime = '".trim($this->MyPOST['pavadzime'])."'";
			if ($this->MyPOST[datums_no]!='')
				$pav_test_query =$pav_test_query . " and kad_piegad >= '".$this->MyPOST[datums_no]."' ";
			if ($this->MyPOST[datums_lidz]!='')
				$pav_test_query =$pav_test_query  . " and kad_piegad <= '".$this->MyPOST[datums_lidz]."' ";

			$r = mysql_query($pav_test_query);
			if ($m = mysql_fetch_array($r))
			{
				if ($m[x]>1)
					$this->ERRORS.= "<font color=red>Eksistē ".$m[x]." pavadzīmes ar numuru ".$this->MyPOST['pavadzime']."!</font><br><br>";
			}
		}

		//$query = " from balkis,pavadzime where balkis.pavadzime = pavadzime.id ";
		if ($this->MyPOST[datums_no_diena]!='' || $this->MyPOST[pavadzime_id]) { // 
			$query = " from balkis_temp INNER JOIN pavadzime ON balkis_temp.pavadzime = pavadzime.id WHERE 1=1 ";
		} else {
			$query = " from balkis INNER JOIN pavadzime ON balkis.pavadzime = pavadzime.id WHERE 1=1 ";
		}

		// nosac?jumi
		if ($this->MyPOST[datums_no_diena]!='')
			$query=$query . " and kad_piegad >= '".$this->MyPOST[datums_no_gads]."-".$this->MyPOST[datums_no_menesis]."-".$this->MyPOST[datums_no_diena]."' ";
		if ($this->MyPOST[datums_lidz_diena]!='')
			$query=$query . " and kad_piegad <= '".$this->MyPOST[datums_lidz_gads]."-".$this->MyPOST[datums_lidz_menesis]."-".$this->MyPOST[datums_lidz_diena]."' ";
		if ($this->MyPOST[piegad_grupa])
			$query=$query . " and pavadzime.piegad_grupa like '".$this->MyPOST[piegad_grupa]."%'";
		if ($this->MyPOST[piegadataju_kods])
			$query=$query . " and pavadzime.piegadataju_kods = ".$this->MyPOST[piegadataju_kods];
		if ($this->MyPOST[pavadzime])
			$query=$query . " and pavadzime.pavadzime = '".$this->MyPOST[pavadzime]."'";
		if ($this->MyPOST[pavadzime_id])
			$query=$query . " and pavadzime.id = '".$this->MyPOST[pavadzime_id]."'";
		if ($this->MyPOST[suga]!='') 
			$query=$query . " and suga = '".$this->MyPOST[suga]."'";
		if ($this->MyPOST[cirsmas_kods]!='') 
			$query=$query . " and cirsmas_kods like '".$this->MyPOST[cirsmas_kods]."'";
	
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
			$query=$query . " and LOWER(iecirknis_pieg)=LOWER('".trim($this->MyPOST['iecirknis_pieg'])."')";
		$query2 = str_replace("balkis_temp","balkis",$query);

		if ($this->MyPOST[datums_no_diena]!='') {
			mysql_query("DELETE FROM balkis_temp");
			mysql_query("INSERT INTO balkis_temp (SELECT balkis.* " . $query2 . ")");
			$query = " from balkis_temp INNER JOIN pavadzime ON balkis_temp.pavadzime = pavadzime.id WHERE 1=1 ";
		}
		if ($this->MyPOST[pavadzime]) {
			mysql_query("DELETE FROM balkis_temp");
			mysql_query("INSERT INTO balkis_temp (SELECT balkis.* " . $query2 . ")");
			$query = " from balkis_temp INNER JOIN pavadzime ON balkis_temp.pavadzime = pavadzime.id WHERE 1=1 ";
		}

		$rtest = mysql_query("select count(*) as x " . $query);
		if ($m = mysql_fetch_array($rtest))
		{
			if ($m[x]>1)
				$correct_count = $m[x];
			else
				$correct_count = 0;
		}
	
		$this->arr[-1] = array();		// izejas masīva headeri
		if($this->XML_Variants) 
		{
			$diam__ = false; // p?rbaudei vai vajadz?g?s grup??anas XML atskaitei iesl?gtas
			$gar__ = false; 
		}

			// pirmās kolonnas atskaitei ko izvēlējies lietotājs
			//var_dump($this->MyPOST);
			//print_r($this->MyPOST);
			for ($i=0;$i<$this->lsk;$i++)
			{
				$this->arr[-1][$i]=$this->mtipi[$this->MyPOST["gtype".$this->grup.($i+1)]]; 
				if($this->XML_Variants)
				{
					//echo "<br>gtype".($i+1)." gvalues".($i+1)." gvalues".($i+1)."_1"." gvalues".($i+1)."_2";

					$this->arr[-1][$i]=$this->MyPOST["gtype".$this->grup.($i+1)];
					if($this->MyPOST["gtype".$this->grup.($i+1)]=='mind_pirms_red' ) {
						//echo '****************mind_pirms_red*************';
					
						$this->MyPOST["gvalues".$this->grup.($i+1)]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)]);
						$this->MyPOST["gvalues".$this->grup.($i+1)."_1"]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)."_1"],1);
						$this->MyPOST["gvalues".$this->grup.($i+1)."_2"]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)."_2"],2);
						
						//echo "<br> IN mind_pirms_red "."gtype".($i+1)."invalue [".(($this->MyPOST["gvalues".($i+1)]) || ($this->MyPOST["gvalues".($i+1)."_1"]) || ($this->MyPOST["gvalues".($i+1)."_2]"]))."]";	

						if(($this->MyPOST["gvalues".$this->grup.($i+1)]) || ($this->MyPOST["gvalues".$this->grup.($i+1)."_1"]) || ($this->MyPOST["gvalues".$this->grup.($i+1)."_2"]))
						{
							//echo "<br> IN "."gvalues".($i+1);
							$diam__ = true;
						}	
					}
					if($this->MyPOST["gtype".$this->grup.($i+1)]=='garums' ) $gar__ = true;
					if($this->MyPOST["gtype".$this->grup.($i+1)]=='brakis' ) $brak__ = true;
				} else {
				if($this->MyPOST["gtype".$this->grup.($i+1)]=="pavadzime.pavadzime") $this->arr[-1][$i]=$this->mtipi['pavadzime.pavadzime']; //kaut k?ds exception
				}
			}
			//print_r($this->MyPOST);

			// pēdējās kolonnas kas visām atskaitēm vienādas
			$this->arr[-1][$i]= $translate['skaits'][$lang];
			$i++;
			$this->arr[-1][$i]= $translate['bruto'][$lang]." m3";
			$i++;
			$this->arr[-1][$i]= $translate['virsmers'][$lang]." m3";
			$i++;
			$this->arr[-1][$i]= $translate['redukcija'][$lang]." m3";
			$i++;
			$this->arr[-1][$i]= $translate['brakis'][$lang]." m3";
			$i++;
			$this->arr[-1][$i]= $translate['neto'][$lang]." m3";
			$i++;						// $i - tagad kolonnu skaits //
		//$this->arr[-1] - kolonnu nosaukumi un izvad?m? inform?cija atskait? v?l?k.


		$this->rowclosed=true;
		$summa = new CSumma();
		
		$this->arr_index = 0;

		// $query - satur nosac?jumus,kas jaliek gala katram selektam, nosacijumi izveidoti no formas Nosacijumiem
		if(!$this->ERRORS) { 

			// rekurs?v?s funkcijas izsaukums
			$this->print_level($query,$summa,false,0,'');
			} 

		// kopsumma 
		++$this->arr_index;
		$this->arr[$this->arr_index] = array();
		$this->arr[$this->arr_index][-1] = $translate['v_kopa'][$lang];
		$this->arr[$this->arr_index][summa] = $summa;
		
		if($this->XML_Variants) {

			if(!$gar__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc GARUMA!<br><br>"; 
			if(!$diam__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc DIAMETRA vai arī garuma intervālu robežas neatbilst standartam!<br><br>"; 
			if(!$brak__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc BRĀĶA!<br><br>"; 
			//labots sakarā ar vairākām grupēšanām XML atskaitē
			$this->arr[$this->arr_index][correct_count] = $correct_count;
			//if ($correct_count != $summa->skaits) $this->ERRORS.= "Kļūda grupēšanā! Sagrupēti ".(int)$summa->skaits." baļķi no $correct_count.<br><br>";
		}
	}
		//$this->ErrorCheck(); // 

	if($this->ERRORS) return false;  
	

	} // CReport konstruktors

function GetERRORS()
	{
		return $this->ERRORS;
	}

function XMLVARS()
	{
	$xml_vars[0] = $this->MyPOST['gvalues'.$this->grup.'1'];
	$xml_vars[1] = $this->MyPOST['gvalues'.$this->grup.'2_1'];
	$xml_vars[2] = $this->MyPOST['gvalues'.$this->grup.'2_2'];
	$xml_vars[3] = $this->MyPOST['gvalues'.$this->grup.'3'];
	$xml_vars[4] = $this->MyPOST['virsmeri'.$this->grup];
	$xml_vars[5] = $this->MyPOST['koeficients'.$this->grup];
	$xml_vars[6] = $this->MyPOST['raukums'.$this->grup];
	$xml_vars[7] = $this->MyPOST['gvalues'.$this->grup.'4'];
	$xml_vars['pavadzime'] = $this->MyPOST['pavadzime'];
	}

function SetParam()
	{
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

function build_value_ranges($level,$suga) {
	if ($this->MyPOST["dalit".$this->grup.$level] && $suga) {
		// ja ir sadalījums pa sugām ņemam attiecīgo lauku
		$gvalues = "gvalues".$this->grup.$level."_".$suga;
	} else {
		// ja nav tad ņemam kopīgo
		$gvalues = "gvalues".$this->grup.$level;
	}

	// sadalam nepieciešamās vērtības
	//echo $this->MyPOST[$gvalues];
	$this->allowed_values = explode(',',$this->MyPOST[$gvalues]);
	$this->allowed_values = str_replace(' ','',$this->allowed_values);
	
	// brāķis
	$this->rejected_values = array();
	for ($i=0;$i<count($this->allowed_values);$i++) {
		if (substr($this->allowed_values[$i],0,1)=='b' || substr($this->allowed_values[$i],0,1)=='B') {
			$this->rejected_values[$i] = '1'; //kursh masiva elements apzime braki
			$this->allowed_values[$i] = substr($this->allowed_values[$i],1); //masiva elements bez B prieksa
		}
	}
}

function build_single_values($field,$query) {
	$this->allowed_values = array();
	$query__="select DISTINCT $field as lauks " . $query . " order by $field ";
	$r = mysql_query($query__);
	$ii=0;
	while ($m = mysql_fetch_array($r))
	{
		$this->allowed_values[$ii] = $m['lauks']; 
		$ii++;
	}

	if ($field=='brakis')
	{
		if ($this->allowed_values[count($this->allowed_values)-1]=='255')
		{

			for ($j=count($this->allowed_values)-1;$j>0;$j--) {
				$this->allowed_values[$j] = $this->allowed_values[$j-1];
			}
			$this->allowed_values[0] = '255';
		}
	}

	$typ = 'string';
}

function print_level($query,&$summa_p,$irbrakis_p,$suga,$id)
{
	global $lang;
	global $translate;

	$select = "";
	$orderby = "ORDER BY ";
	$criteria = array();

	for ($level=1;$level<=$this->lsk;$level++) {
	
		// tekošā grupēšanas līmeņa lauks
		$lauks = $this->MyPOST["gtype".$this->grup.$level]; 

		if ($lauks == 'garums' || $lauks == 'mind_pirms_red')
		{	
			$this->build_value_ranges($level,$suga);
			if ($lauks == 'garums') {
				$this->gar_allowed_values = $this->allowed_values;
			} elseif ($lauks == 'mind_pirms_red') {
				$this->diam_allowed_values = $this->allowed_values;
			}
		}

		if ($lauks == 'fsc')
		{
			$this->allowed_values = array();
			$this->allowed_values[0] = '0';
			$this->allowed_values[1] = '1';
			$typ = 'string';
		}

		if ($lauks == 'kad_piegad' || $lauks == 'auto' || $lauks == 'brakis' || $lauks == 'cenu_matrica' || $lauks == 'cirsmas_kods' || $lauks == 'kad_piegad' || $lauks == 'kravas_id' || $lauks == 'pavadzime.pavadzime' || $lauks == 'piegad_kods' || $lauks == 'soferis' || $lauks == 'skira' || $lauks=='suga' || $lauks=='iecirknis')
		{ //no visiem atlas?tajiem ba??iem pavadz?m? atlasa attiec?g? lauka atrodam?s v?rt?bas (pa vienai)
			$this->build_single_values($lauks,$query);
		}

		$row = 0;
		$summa_p->init();
		$myid = 0;

		while (list($key,$val) = each($this->allowed_values))   //mas?va $this->allowed_values ($key - elementa skaitlis p?c k?rtas, $val - v?rt?ba)
		{ 		
			$myid++;
			if ($lauks == 'suga')
			{
				$suga = $val;
			}
		
			// virsm?ru sadal?jums
			if ($suga && $this->MyPOST['dalit_virsmeri'.$this->grup])
			{
				if ($this->MyPOST['virsmeri'.$this->grup.'_'.$suga]!='')
				{
					$virsmeri = explode(',',$this->MyPOST['virsmeri'.$this->grup.'_'.$suga]);
					for ($i=0;$i<count($virsmeri);$i++)
						$virsmeri[$i] = $virsmeri[$i]/100;
				}
			}
			else
			{
				if ($this->MyPOST['virsmeri'.$this->grup]!='')
				{
					$virsmeri = explode(',',$this->MyPOST['virsmeri'.$this->grup]);
					for ($i=0;$i<count($virsmeri);$i++)
						$virsmeri[$i] = $virsmeri[$i]/100;
				}
			}
			
			if ($suga && $this->MyPOST['dalit_raukums'.$this->grup])
			{
				$raukums = raukums_2_array($this->MyPOST['raukums'.$this->grup.'_'.$suga]);
			}
			else
			{
				$raukums = raukums_2_array($this->MyPOST['raukums'.$this->grup]);
			}

			if ($suga && $this->MyPOST['dalit_koeficients'.$this->grup])
			{
				$koeficients = $this->MyPOST['koeficients'.$this->grup.'_'.$suga];
			}
			else
			{
				$koeficients = $this->MyPOST['koeficients'.$this->grup];
			}

			if ($typ!='string')	$mbounds = explode('-',$this->allowed_values[$key]);
		
			if (count($mbounds)>1)
			{
				$low_range_brakis = 0;
				$high_range_brakis = 0;
				if ($mbounds[0]>5) { $low_range_brakis = $mbounds[0]+5; } else { $low_range_brakis = $mbounds[0]; }
				if ($mbounds[1]<994) { $high_range_brakis = $mbounds[1]+5; } else { $high_range_brakis = $mbounds[1]; }
				
				//pievienots 17.07.2007
				
				if ($myid==1) {
					$select .= ", CASE \n";
					
				}

				if ($this->MyPOST["gtype".$this->grup.$level] == 'mind_pirms_red') {
						$select .= "WHEN ((balkis_temp.import_type <> 'zbm' AND mind_pirms_red BETWEEN $mbounds[0] AND $mbounds[1]) OR (balkis_temp.import_type = 'zbm' AND mind_pirms_red BETWEEN $low_range_brakis AND $high_range_brakis)) THEN $myid \n";
						if ($myid==sizeof($this->allowed_values)) {
							$select .= "END AS diam_group";
							$orderby .= "diam_group";
							$criteria []= "diam_group";
							//
						}
					//$myquery = $query . " and  ((". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $mbounds[1] . " AND balkis_temp.import_type <> 'zbm') or (". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $low_range_brakis ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $high_range_brakis . " AND balkis_temp.import_type = 'zbm'))";
				} else {
					$select .= "WHEN (garums BETWEEN $mbounds[0] AND $mbounds[1]) THEN $myid \n";
					if ($myid==sizeof($this->allowed_values)) {
						$select .= "END AS gar_group";
						$orderby .= "gar_group";
						$criteria []= "gar_group";
						//$this->gar_allowed_values = $this->allowed_values;
					}
					//$myquery = $query . " and  (". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $mbounds[1] . ")";
				}
			}
			else
			{
				if ($myid==sizeof($this->allowed_values)) {
					$orderby .= $this->MyPOST["gtype".$this->grup.$level];
					$criteria []= $this->MyPOST["gtype".$this->grup.$level];
				}
			}

			if (($myid==sizeof($this->allowed_values)) && ($level < $this->lsk)) {
				$orderby .= ",";
			}
		}
	}

		$query__="select mind_pirms_red as DBruto, garums as LBruto, mind_pec_red as DPecReduc, gar_pec_red as LPecReduc, brakis, suga, pavadzime.cenu_matrica as cm" . $select . $query . $orderby;

		$r = mysql_query($query__);

		$same_group = false;

		$gostu_tabula = $this->MyPOST['gostu_tabula'.$this->grup];

		while ($m = mysql_fetch_array($r)) {

			$last = $m;

			$same_group = true;
			$criteria_changed = 6;

			for($ci=$this->lsk-1;$ci>=0;$ci--) {
				$value = $criteria[$ci];

				if ($old_values[$value] != $m[$value]) {
					$criteria_changed = $ci;
				}

				if ($old_values[$value] != $m[$value]) {
					if ($same_group) {
						$old_bak = $old_values;
					}
					$same_group = false;

					$old_values[$value] = $m[$value];
				}
			}

			if (!$same_group && $old_bak) {

				for ($ci=$this->lsk-2;$ci>=0;$ci--) {
					if (!$summa[$ci+1]) {
						$summa[$ci+1] = new CSumma;
					}
					$summa[$ci+1]->add_skaits($SSkaits);
					$summa[$ci+1]->add_skaits_bad($SSkaitsBad);
					$summa[$ci+1]->add_virsmers($SVVirsm);
					$summa[$ci+1]->add_redukcija_d($SVReducD);
					$summa[$ci+1]->add_redukcija_l($SVReducL);
					$summa[$ci+1]->add_brakis($SVBrakis);
					$summa[$ci+1]->add_neto($SVNeto);
					$summa[$ci+1]->add_bruto($SVBruto);

					if ($criteria_changed <= $ci && !$this->XML_Variants) {
						//fb($summa,'Summa');
						$this->AddSumRowAtLevel($ci, $criteria, $summa, $old_bak);
					}
				}

				$this->arr_index++;
				$this->arr[$this->arr_index] = array();

				foreach($criteria as $key => $value) {
					$this->arr[$this->arr_index][$key] = $this->kodi($value,$old_bak[$value]);
				}

				$sm = new CSumma;
				$sm->skaits = $SSkaits;
				$sm->skaits_bad = $SSkaitsBad;
				$sm->virsmers = $SVVirsm;
				$sm->redukcija_d = $SVReducD;
				$sm->redukcija_l = $SVReducL;
				$sm->brakis = $SVBrakis;
				$sm->neto = $SVNeto;
				$sm->bruto = $SVBruto;
				//fb($sm,'Sm');
				$this->arr[$this->arr_index][summa] = $sm;
				//echo $m['brakis'];


				$summa_p->add_skaits($SSkaits);
				$summa_p->add_skaits_bad($SSkaitsBad);
				$summa_p->add_virsmers($SVVirsm);
				$summa_p->add_redukcija_d($SVReducD);
				$summa_p->add_redukcija_l($SVReducL);
				$summa_p->add_brakis($SVBrakis);
				$summa_p->add_neto($SVNeto);
				$summa_p->add_bruto($SVBruto);

				/*NULL vertibu ievietosana*/
				$SVBruto = 0;
				$SVReducD = 0;
				$SVReducL = 0;
				$SVVirsm = 0;

				$SVNeto = 0;
				$SVBrakis = 0;
				$SSkaits = 0;
				$SSkaitsBad = 0;
			}

			$SSkaits++;
/*Vai ir Vika Wood*/   

//		$min_virsmers = 0;
		
        if ($suga && $this->MyPOST['dalit_virsmers'.$this->grup])
        {
          $min_virsmers = $this->MyPOST['virsmers'.$this->grup.'_'.$suga]/100;
        }
        else
        {
          $min_virsmers = $this->MyPOST['virsmers'.$this->grup]/100;
        }

          if ($this->MyPOST['metode'] == '1') {
          }else if($this->MyPOST['metode'] == '2'){
          }else if($this->MyPOST['metode'] == '3'){
          }else if($this->MyPOST['metode'] == '4'){
          }else{
          }

          $tilp_Metode = $this->MyPOST['metode'];
          
          $gar_PirmsRed       = 0;
          $gar_PecRed         = 0;
          $diam_TievPirmsRed  = 0;
          $diam_TievPecRed    = 0;
          $diam_VidusPirmsRed = 0;
          $diam_VidusPecRed   = 0;
          $diam_ResPirmsRed   = 0;
          $diam_ResPecRed     = 0;
          
//---Tiek veikta pārbaude, pēc kādiem nosacījumiem noapaļot garumu pirms redukcijas, no kura tiek rēķināts Bruto tilpums!-------------------------------------------------------------------------

          $gar_PirmsRed = $m['LBruto']/100;
          if ($this->MyPOST['noapalot_garumu'] == '1') {
               $gar_PirmsRed = ((floor($m['LBruto']/10))/10);
          }elseif ($this->MyPOST['noapalot_garumu'] == '2') {
               $gar_PirmsRed = ((floor($m['LBruto']/10)+0.5)/10);
          }

//---Tiek pārbaudīts, vai garums tiek ņemts kā nominālais garums, vai notiek nominālā garuma aprēķināšana, no kura tiks rēķināts Neto tilpums!-------------------------------------------------------------------------
          
          $gar_PecRed = gAtskaite::nom($gar_PirmsRed,$virsmeri,$min_virsmers);
		if ($this->MyPOST['is_vika'] == 'on') { $gar_PecRed = $m['LPecReduc'] / 100;}
		
//---Tiek aprēķināts nominālais garums pirms pirms redukcijas, lai varētu aprēķināt tilpumu bez virsmēra!-------------------------------------------------------------------------

          $gar_NomPirsmRed = gAtskaite::nom($gar_PirmsRed,$virsmeri,$min_virsmers);;

//----------------------------------------------------------------------------
          
          $diam_TievPirmsRed  = $m['DBruto']/1000;
          $diam_VidusPirmsRed = $m['DBruto']/1000;
          $diam_ResPirmsRed   = $m['DBruto']/1000;
          $rauk_koef = get_raukums_no_diam($raukums,$diam_TievPirmsRed * 1000); 
          if ($this->MyPOST['noapalot_diametru'] == 'on') {
               $diam_TievPirmsRed  = ((floor($m['DBruto']/10)+0.5)/100);
               $diam_VidusPirmsRed = ((floor($m['DBruto']/10)+0.5)/100);
               $diam_ResPirmsRed   = ((floor($m['DBruto']/10)+0.5)/100);
          }

//----------------------------------------------------------------------------

		if ($this->MyPOST['braka_virsmers'] == 'on') {
          }else{
          }

          $DPecReduc = $m['DPecReduc']/1000;
          $DReduc = $DBruto-$DPecReduc;

          if ($m[brakis] != '255'){
               $irbrakis = true;
               $brkods = 'standart';
          }
						
          $tilpums_bruto = f2($diam_TievPirmsRed,$gar_PirmsRed,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_neto = f2($DPecReduc,$gar_PecRed,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_bruto_bez_virsmera = f2($diam_TievPirmsRed,$gar_NomPirsmRed,$rauk_koef,$koeficients,$gostu_tabula);
          
          $tilpums_virsmers = $tilpums_bruto - $tilpums_bruto_bez_virsmera;
          $tilpums_garuma_redukcija = $tilpums_bruto_bez_virsmera - $tilpums_neto;
          $tilpums_diametrs_redukcija = 0;

//----------        
        $SVBruto += $tilpums_bruto;

				if ($gostu_tabula) {
					if ($VBruto==-1 
					 || $VReducD==-1
					 || $VReducL==-1
					 || $VVirsm ==-1) $SSkaitsBad++;
					
					if ($VBruto ==-1) $VBruto  = 0;
					if ($VReducD==-1) $VReducD = 0;
					if ($VReducL==-1) $VReducL = 0;
					if ($VVirsm ==-1) $VVirsm  = 0;
				}     
				
				        
				$VBrakis = 0;
				
				if (strlen($this->rejected_values[$key])==1){
					$irbrakis = true;
					$brkods = $this->rejected_values[$key];
				}
				
				if (!$irbrakis) {
                         /*Vai ir brakis?*/
                         				
                         $SVReducD += $tilpums_diametrs_redukcija;
                         $SVReducL += $tilpums_garuma_redukcija;

                         if ($gar_PecRed!=0)
                         {
                              $SVVirsm += $tilpums_virsmers;
                              $SVNeto += $tilpums_neto;
                         }else{
                              $SVBrakis += $SVBruto;
                         }
				}
				else
				{
					if ($gar_PecRed!=0)
					{
						$SVVirsm += $tilpums_virsmers;
						$VBrakis = $tilpums_bruto - $tilpums_virsmers;
						$SVBrakis += $VBrakis;
					}
					else
					{
						$VBrakis = $tilpums_bruto;
						$SVBrakis += $VBrakis;
					}
				}

			}

/*Ievietosana*/			
			//$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$this->grup.$this->lsk],$val);


			/* Vienu reizi pašās beigās papildina ar pēdējo ierakstu */
			$this->arr_index++;
			$this->arr[$this->arr_index] = array();

			foreach($criteria as $key => $value) {
				//fb($m['value']);
				$this->arr[$this->arr_index][$key] = $this->kodi($value,$last[$value]);
			}

			$sm = new CSumma;
			$sm->skaits = $SSkaits;
			$sm->skaits_bad = $SSkaitsBad;
			$sm->virsmers = $SVVirsm;
			$sm->redukcija_d = $SVReducD;
			$sm->redukcija_l = $SVReducL;
			$sm->brakis = $SVBrakis;
			$sm->neto = $SVNeto;
			$sm->bruto = $SVBruto;
			$this->arr[$this->arr_index][summa] = $sm;

			for ($ci=$this->lsk-2;$ci>=0;$ci--) {
				if (!$summa[$ci+1]) {
					$summa[$ci+1] = new CSumma;
				}
				$summa[$ci+1]->add_skaits($SSkaits);
				$summa[$ci+1]->add_skaits_bad($SSkaitsBad);
				$summa[$ci+1]->add_virsmers($SVVirsm);
				$summa[$ci+1]->add_redukcija_d($SVReducD);
				$summa[$ci+1]->add_redukcija_l($SVReducL);
				$summa[$ci+1]->add_brakis($SVBrakis);
				$summa[$ci+1]->add_neto($SVNeto);
				$summa[$ci+1]->add_bruto($SVBruto);

				if (!$this->XML_Variants) {
					$this->AddSumRowAtLevel($ci, $criteria, $summa, $last);
				}
			}
		
			$summa_p->add_skaits($SSkaits);
			$summa_p->add_skaits_bad($SSkaitsBad);
			$summa_p->add_virsmers($SVVirsm);
			$summa_p->add_redukcija_d($SVReducD);
			$summa_p->add_redukcija_l($SVReducL);
			$summa_p->add_brakis($SVBrakis);
			$summa_p->add_neto($SVNeto);
			$summa_p->add_bruto($SVBruto);

  
}

function AddSumRowAtLevel ($level, $criteria, &$summa, $log_data) {
	global $lang;
	global $translate;

	$this->arr_index++;
	$this->arr[$this->arr_index]=array();
	$this->arr[$this->arr_index][-1] = $translate['kopa'][$lang];

	for ($i=0;$i<=$level;$i++)
	{
		$this->arr[$this->arr_index][$i] = $this->kodi($criteria[$i],$log_data[$criteria[$i]]);
	}	
	
	$this->arr[$this->arr_index][summa] = $summa[$level+1];
	$summa[$level+1] = new CSumma;
}

function GetDataArray()
{
	return $this->arr;
}

function GetHTML()
{
//$str="<table border=0 cellspacing=0 cellpadding=0>";
$str= $str."<tr>";

	for ($j=-1;$j<count($this->arr[-1]);$j++)
	{
		$str= $str. "<th><b>".$this->arr[-1][$j]."</b></td><td width=5></th>";
	}
	$str= $str. "</tr>";

	// druk?jam tabulu

	for ($i=0;$i<count($this->arr);$i++)
	{
		if ($this->arr[$i][summa]->skaits!=0)
		{
			$str= $str. "<tr>";
			
			if ($this->arr[$i][-1]!="") 
			{
				$format_start = "<b>";
				$format_end = "</b>";
			}
			else
			{
				$format_start = "";
				$format_end = "";
			}

			for ($j=-1;$j<$this->lsk;$j++)
			{
				$str= $str."<td align=center><nobr>";
				$str= $str.$format_start.$this->arr[$i][$j].$format_end;
				$str= $str."</nobr></td><td width=5>";
			}
			$str= $str."<td align=right>".$format_start;
			$str= $str.round($this->arr[$i][summa]->skaits,3);
			if ($this->arr[$i][summa]->skaits_bad)
			{
				$str= $str."<font color=red>(".round($this->arr[$i][summa]->skaits_bad,3).")</font>";
			}
			$str= $str.$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->bruto,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->virsmers,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->redukcija_d+$this->arr[$i][summa]->redukcija_l,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->brakis,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right bgcolor=#cccccc>".$format_start.round($this->arr[$i][summa]->neto,3).$format_end."</td>";
			$str= $str."</tr>";
		}
	}
//return $str."</table>";
return $str;
}

function GetHTML2()
{
$str="<table border=0 cellspacing=0 cellpadding=0>";
$str= $str."<tr>";

	$saveheader = $this->arr[-1];
	$this->arr=array();
	$this->arr[-1]=$saveheader;
	for ($j=-1;$j<count($this->arr[-1]);$j++)
	{
		$str= $str. "<th><b>".$this->arr[-1][$j]."</b></td><td width=5></th>";
	}
	$str= $str. "</tr>";

	// druk?jam tabulu

	$rrows = mysql_query("select * from gatskaite order by id");
	$i=0;
	while ($mrows=mysql_fetch_array($rrows))
	{
		$this->arr[$i]=array();
		$this->arr[$i]=unserialize($mrows['data']);
		$i++;
	}

	for ($i=0;$i<count($this->arr);$i++)
	{
		if ($this->arr[$i][summa]->skaits!=0)
		{
			$str= $str. "<tr>";

			if ($this->arr[$i][-1]!="") 
			{
				$format_start = "<b>";
				$format_end = "</b>";
			}
			else
			{
				$format_start = "";
				$format_end = "";
			}

			for ($j=-1;$j<$this->lsk;$j++)
			{
				$str= $str."<td align=center><nobr>";
				$str= $str.$format_start.$this->arr[$i][$j].$format_end;
				$str= $str."</nobr></td><td width=5>";
			}
			$str= $str."<td align=right>".$format_start;
			$str= $str.round($this->arr[$i][summa]->skaits,3);
			if ($this->arr[$i][summa]->skaits_bad)
			{
				$str= $str."<font color=red>(".round($this->arr[$i][summa]->skaits,3).")</font>";
			}
			$str= $str.$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->bruto,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->virsmers,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->redukcija_d+$this->arr[$i][summa]->redukcija_l,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->brakis,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right bgcolor=#cccccc>".$format_start.round($this->arr[$i][summa]->neto,3).$format_end."</td>";
			$str= $str."</tr>";
		}
	}
	mysql_query("delete from gatskaite");

return $str."</table>";
}


function kodi($typ,$val)
{
	global $lang;

	if(!$this->XML_Variants) {
		if ($typ=='brakis')
		{
			return $this->braki[$val][$lang];
		}
	
		if ($typ=='suga')
		{
			return $this->sugas[$val][$lang];
		}

		if ($typ=='diam_group')
		{
			return $this->diam_allowed_values[$val-1];
		}

		if ($typ=='gar_group')
		{
			return $this->gar_allowed_values[$val-1];
		}
	}
	if($this->XML_Variants) {
		if ($typ=='brakis')
		{
			//echo "braki:".$val." ".gAtskaite::$LVM_braki[$val];
			return gAtskaite::$LVM_braki[$val];
		}
	
		if ($typ=='suga')
		{
			return gAtskaite::$LVM_sugas[$val];
		}
	}
		return $val;
}

}//CReport klases beigas


function dig3($s)
{
	while (strlen($s)<3)
		$s='0'.$s;
	return $s;
}

?>