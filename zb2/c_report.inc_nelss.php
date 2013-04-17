<?php

include("valoda.php");

$sugas = gAtskaite::getSugas();
$braki = gAtskaite::getBrakiAkz();
$LVM_braki = gAtskaite::getLVMBraki();
$IT_braki = gAtskaite::getITBrakiAKZ();
$VIKA_braki = gAtskaite::getVIKABrakiAKZ();
$VIKA_LVM_braki = gAtskaite::getVIKALVMBrakiAKZ();
$LVM_sugas = gAtskaite::getLVMSugas();

class C_REPORT extends C_REPORT_BASE {

function C_REPORT(&$My_POST,&$DB,$XML_Variants,$grup)
	{

	global $braki;
	global $VIKA_braki;
	global $LVM_braki;
	global $VIKA_LVM_braki;
	global $sugas;

	global $lang;
	global $translate;

	if ($lang != "RUS") {
		$lang = "LAT";
	}

	$this->DB = $DB;
	$this->XML_Variants=$XML_Variants; 
	$this->sugas=$sugas;
	$this->MyPOST=$My_POST;
	$this->grup=$grup;
	if (strrpos($this->MyPOST['pavadzime'],"KRVII") === false) {
		$this->braki=$VIKA_braki;
		$LVM_braki=$VIKA_LVM_braki;
	} else {
		$this->braki=$braki;
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

//			if(trim($this->MyPOST['pieg_lig_num'])=='') $this->ERRORS.= "Nav norādīts PIEGĀDES LĪGUMA numurs!<br><br>";
	
			if(trim($this->MyPOST['pavadzime'])!='')
				{
				if	(!GetFromPavadzime($this->MyPOST['pavadzime'],'pavadzime','nelss_pavadzime') ) $this->ERRORS .= "Norādīts NEEKSISTĒJOŠS PAVADZĪMES numurs!<br><br>"; 
	
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
			$pav_test_query = "select count(*) as x from nelss_pavadzime where pavadzime = '".trim($this->MyPOST['pavadzime'])."'";
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

		//$query = " from balkis,pavadzime where balkis.pavadzime = pavadzime.id ";
		if ($this->MyPOST[datums_no_diena]!='' || $this->MyPOST[pavadzime_id]) { // 
			$query = " from nelss_balkis_temp INNER JOIN nelss_pavadzime ON nelss_balkis_temp.pavadzime = nelss_pavadzime.id WHERE 1=1 ";
		} else {
			$query = " from nelss_balkis INNER JOIN nelss_pavadzime ON nelss_balkis.pavadzime = nelss_pavadzime.id WHERE 1=1 ";
		}

		// nosac?jumi
		if ($this->MyPOST[datums_no_diena]!='')
			$query=$query . " and kad_piegad >= '".$this->MyPOST[datums_no_gads]."-".$this->MyPOST[datums_no_menesis]."-".$this->MyPOST[datums_no_diena]."' ";
		if ($this->MyPOST[datums_lidz_diena]!='')
			$query=$query . " and kad_piegad <= '".$this->MyPOST[datums_lidz_gads]."-".$this->MyPOST[datums_lidz_menesis]."-".$this->MyPOST[datums_lidz_diena]."' ";
		if ($this->MyPOST[piegad_grupa])
			$query=$query . " and nelss_pavadzime.piegad_grupa like '".$this->MyPOST[piegad_grupa]."%'";
		if ($this->MyPOST[piegadataju_kods])
			$query=$query . " and nelss_pavadzime.piegadataju_kods = ".$this->MyPOST[piegadataju_kods];
		if ($this->MyPOST[pavadzime])
			$query=$query . " and nelss_pavadzime.pavadzime = '".$this->MyPOST[pavadzime]."'";
		if ($this->MyPOST[pavadzime_id])
			$query=$query . " and nelss_pavadzime.id = '".$this->MyPOST[pavadzime_id]."'";
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
		$query2 = str_replace("nelss_balkis_temp","nelss_balkis",$query);

		if ($this->MyPOST[datums_no_diena]!='') {
			$this->DB->query("DELETE FROM nelss_balkis_temp");
			$this->DB->query("INSERT INTO nelss_balkis_temp (SELECT nelss_balkis.* " . $query2 . ")");
			$query = " from nelss_balkis_temp INNER JOIN nelss_pavadzime ON nelss_balkis_temp.pavadzime = nelss_pavadzime.id WHERE 1=1 ";
		}
		if ($this->MyPOST[pavadzime]) {
			$this->DB->query("DELETE FROM nelss_balkis_temp");
			$this->DB->query("INSERT INTO nelss_balkis_temp (SELECT nelss_balkis.* " . $query2 . ")");

			//Pievienoju pārbaudi uz baļķu esamību pavadzīmē 2010-03-09, Ervīns
			if (mysql_affected_rows() == 0) {
				$this->ERRORS .= "<font color=red>Pavadzīmē ".$this->MyPOST['pavadzime']." nav neviens baļķis!</font><br><br>";
				return false;
			}
			
//			echo "Kverijs 2 = ","INSERT INTO nelss_balkis_temp (SELECT nelss_balkis.* " . $query2 . ")",'<br />';
			$query = " from nelss_balkis_temp INNER JOIN nelss_pavadzime ON nelss_balkis_temp.pavadzime = nelss_pavadzime.id WHERE 1=1 ";
		}

		$rtest = $this->DB->query("select count(*) as x " . $query);
		if ($m = $this->DB->get_row($rtest))
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
					
//						$this->MyPOST["gvalues".$this->grup.($i+1)]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)]);
						$this->MyPOST["gvalues".$this->grup.($i+1)]=$this->MyPOST["gvalues".$this->grup.($i+1)];
//						$this->MyPOST["gvalues".$this->grup.($i+1)]=str_replace("b0-139","b0-59,b60-99,b100-119,b120-139",$this->MyPOST["gvalues".$this->grup.($i+1)]);
//						echo $this->MyPOST["gvalues".$this->grup.($i+1)];
//						$this->MyPOST["gvalues".$this->grup.($i+1)."_1"]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)."_1"],1);
						$this->MyPOST["gvalues".$this->grup.($i+1)."_1"]=$this->MyPOST["gvalues".$this->grup.($i+1)."_1"];
//						$this->MyPOST["gvalues".$this->grup.($i+1)."_2"]=LVM_distribution($this->MyPOST["gvalues".$this->grup.($i+1)."_2"],2);
						$this->MyPOST["gvalues".$this->grup.($i+1)."_2"]=$this->MyPOST["gvalues".$this->grup.($i+1)."_2"];
						
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
				if($this->MyPOST["gtype".$this->grup.($i+1)]=="nelss_pavadzime.pavadzime") $this->arr[-1][$i]=$this->mtipi['nelss_pavadzime.pavadzime']; //kaut k?ds exception
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
			$this->print_level(1,$query,$summa,false,0,'');
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

function print_level($level,$query,&$summa_p,$irbrakis_p,$suga,$id)
{
	global $lang;
	global $translate;

	// tekošā grupēšanas līmeņa lauks
	$lauks = $this->MyPOST["gtype".$this->grup.$level]; 

	////////////////////////////////////////////////////////////////// JA IR DAL?JUMS PA SUG?M //////////////////
	if ($lauks == 'garums' || $lauks == 'mind_pirms_red' || $lauks == 'skira')
	{	
		if ($this->MyPOST["dalit".$this->grup.$level] && $suga)
		{
			// ja ir sadalījums pa sugām ņemam attiecīgo lauku
			$gvalues = "gvalues".$this->grup.$level."_".$suga;
		}
		else
		{
			// ja nav tad ņemam kopīgo
			$gvalues = "gvalues".$this->grup.$level;
		}

		// sadalam nepieciešamās vērtības
		//echo $this->MyPOST[$gvalues];
		$a = explode(',',$this->MyPOST[$gvalues]);
		$a = str_replace(' ','',$a);
		
		// brāķis
		$abr = array();
		for ($i=0;$i<count($a);$i++)
		{
			if (substr($a[$i],0,1)=='b' || substr($a[$i],0,1)=='B')
			{
				$abr[$i] = '1'; //kursh masiva elements apzime braki
				$a[$i] = substr($a[$i],1); //masiva elements bez B prieksa
			}
		}
	}
	////////////////////////////////////////////////////////////////// JA IR DAL?JUMS PA SUG?M //////////////////


	if ($lauks == 'fsc')
	{
		$a = array();
		$a[0] = '0';
		$a[1] = '1';
		$typ = 'string';
	}

	if ($lauks == 'kad_piegad' || $lauks == 'auto' || $lauks == 'brakis' || $lauks == 'cenu_matrica' || $lauks == 'cirsmas_kods' || $lauks == 'kad_piegad' || $lauks == 'kravas_id' || $lauks == 'nelss_pavadzime.pavadzime' || $lauks == 'piegad_kods' || $lauks == 'soferis' || $lauks=='suga' || $lauks=='iecirknis' || ($lauks == 'skira' && $a[0] == '' && sizeof($abr) == 0))
	{ //no visiem atlas?tajiem ba??iem pavadz?m? atlasa attiec?g? lauka atrodam?s v?rt?bas (pa vienai)
		$a = array();
		$query__="select DISTINCT $lauks as lauks " . $query . " order by $lauks ";
		$r = $this->DB->query($query__);
		$ii=0;
		while ($m = $this->DB->get_row($r))
		{
			$a[$ii] = $m['lauks']; 
			$ii++;
		}

		if ($lauks=='brakis')
		{
			if ($a[count($a)-1]=='255')
			{

				for ($j=count($a)-1;$j>0;$j--)
					$a[$j] = $a[$j-1];
				$a[0] = '255';
			}
		}

		$typ = 'string';
	}
	$row = 0;
	$summa_p->init();
	$myid = 0;
	while (list($key,$val) = each($a))   //mas?va $a ($key - elementa skaitlis p?c k?rtas, $val - v?rt?ba)
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
					$virsmeri[$i] = $virsmeri[$i];
			}
		}
		else
		{
			if ($this->MyPOST['virsmeri'.$this->grup]!='')
			{
				$virsmeri = explode(',',$this->MyPOST['virsmeri'.$this->grup]);
				for ($i=0;$i<count($virsmeri);$i++)
					$virsmeri[$i] = $virsmeri[$i];
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

		if ($typ!='string')	$mbounds = explode('-',$a[$row]);
		
		if (count($mbounds)>1)
		{
			$low_range_brakis = 0;
			$high_range_brakis = 0;
			if ($mbounds[0]>5) { $low_range_brakis = $mbounds[0]+5; } else { $low_range_brakis = $mbounds[0]; }
			if ($mbounds[1]<994) { $high_range_brakis = $mbounds[1]+5; } else { $high_range_brakis = $mbounds[1]; }
			
//pievienots 17.07.2007
			if ($this->MyPOST["gtype".$this->grup.$level] == 'mind_pirms_red') {
				$myquery = $query . " and  ((". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $mbounds[1] . " AND nelss_balkis_temp.import_type <> 'zbm') or (". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $low_range_brakis ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $high_range_brakis . " AND nelss_balkis_temp.import_type = 'zbm'))";
			} else {
				$myquery = $query . " and  (". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $mbounds[1] . ")";
			}
			//$myquery = $query . " and  (". $this->MyPOST["gtype".$this->grup.$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$this->grup.$level] . "<=" . $mbounds[1] . ")";

		}
		else
		{
			if ($typ == 'string')
				$myquery = $query . " and  ". $this->MyPOST["gtype".$this->grup.$level] . "='" . $a[$row] . "'";
			else
				$myquery = $query . " and  ". $this->MyPOST["gtype".$this->grup.$level] . "=" . $a[$row];
		}

		$row = $row + 1;
		if ($this->rowclosed==true)
		{
			$this->rowclosed = false;
			$this->arr_index++;
			$this->arr[$this->arr_index] = array();
		}

		if ($level==1)
		{
			$this->arr[$this->arr_index][0] = "";
		}
		else
		{
			if ($row>1)
				for ($i=1;$i<$level+1;$i++)
				{
					$this->arr[$this->arr_index][$i-1] = "";
				}
		}
		$irbrakis = false;
		if ($irbrakis_p == true)
		{
			$irbrakis = true;
		}
		
		// Ja ir v?l dzi??ki l?me?i

		if ($level < $this->lsk)
		{
			if (!$val || $val=='') 
			{
				$this->arr[$this->arr_index][$level-1] = "nav";
			}
			else
			{
				$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$this->grup.$level],$val);

			}

			$sum = new CSumma();

			if (strlen($abr[$key])==1)
			{
				$irbrakis = true;
				$brkods = $abr[$key];
			}

			//$rrow = mysql_query("select * from gatskaite where rowid = '".dig3($id).dig3($myid)."'");
			//if ($mrow = mysql_fetch_array($rrow))
			//{
			//	$saved = 1;
			//	$x = unserialize($mrow['data']);
			//	$sum = $x[summa];
			//}
			//else
			//{
			//}

			$this->print_level($level+1,$myquery,$sum,$irbrakis,$suga,$id.$myid);


			// Te saskaita kop? par l?meni summu - XML varianta tas nav jadara
			if (!$this->XML_Variants) {			
				$this->arr_index++;
				$this->arr[$this->arr_index]=array();
				if ($sum->bruto)
				{
					$this->arr[$this->arr_index][-1] = $translate['kopa'][$lang];
					for ($i=0;$i<$this->lsk;$i++)
					{
						if ($level==$i+1)
						{
							$this->arr[$this->arr_index][$i] = $this->kodi($this->MyPOST['gtype'.$this->grup.$level],$val);
						}
						else
						{
							$this->arr[$this->arr_index][$i] = "";
						}
					}
					
					if (!$this->MyPOST['negrupet']) {
						$this->arr[$this->arr_index][summa] = $sum;
					}
					//echo "<tr><td height=1 colspan=".(7+$this->lsk)."><hr></tr>";
				}
			}			
			$this->rowclosed = true;

			if (!$this->MyPOST['negrupet']) {
				$summa_p->add_skaits($sum->skaits);
				$summa_p->add_skaits_bad($sum->skaits_bad);
				$summa_p->add_virsmers($sum->virsmers);
				$summa_p->add_redukcija_d($sum->redukcija_d);
				$summa_p->add_redukcija_l($sum->redukcija_l);
				$summa_p->add_brakis($sum->brakis);
				$summa_p->add_neto($sum->neto);
				$summa_p->add_bruto($sum->bruto);
				//print_r($summa_p);
				$this->lasttype = 'sum';
			}

			//$this->arr[$this->arr_index]['type']='sum';
			//$this->arr[$this->arr_index]['level']=$level;
			//$st = serialize($this->arr[$this->arr_index]);
			//if ($level==1)
			//	mysql_query("insert into gatskaite (rowid,data) values ('".dig3($myid)."','$st')");
			//else
			//	mysql_query("insert into gatskaite (rowid,data) values ('".dig3($id).dig3($myid)."','$st')");

//		echo "TEST 1.4.1",'<br />';
		
		}
		else
		{

//		echo "TEST 1.4.2",'<br />';

			$this->lasttype = 'data';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Saakums////////////////////////////////////////////////////////////////////////////////////
/*Query izvilksana*/  
      $query__="select mind_pirms_red as DBruto,nelss_balkis_temp.id as r_id, garums as LBruto, mind_pec_red as DPecReduc, gar_pec_red as LPecReduc, brakis, nelss_pavadzime.cenu_matrica as cm " . $myquery;
//          echo $query__;
			$r = $this->DB->query($query__);
/*NULL vertibu ievietosana*/			
      $SVBruto = 0;
      $SVReducD = 0;
      $SVReducL = 0;
      $SVVirsm = 0;
      
      $SVNeto = 0;
      $SVBrakis = 0;
      $SSkaits = 0;
      $SSkaitsBad = 0;
      
			$gostu_tabula = $this->MyPOST['gostu_tabula'.$this->grup];
/*
*/		
			while ($m = $this->DB->get_row($r))
			{

				/* Testēšanas nolūkiem */
				if ($this->MyPOST['negrupet']) {
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
/*
        if (!$this->MyPOST["min_virsmers".$this->grup]) 
        {
          $min_virsmers = 0;
        } else {
          $min_virsmers = $this->MyPOST["min_virsmers".$this->grup]/100;
        }
*/        
//--------------------------------------------------------------------------------

        if ($suga && $this->MyPOST['dalit_virsmers'.$this->grup])
        {
          $min_virsmers = $this->MyPOST['virsmers'.$this->grup.'_'.$suga]/100;
        }
        else
        {
          $min_virsmers = $this->MyPOST['virsmers'.$this->grup]/100;
        }
//echo "Virsm = ".$min_virsmers.'<br />';    
//--------------------------------------------------------------------------------        
        $r_id = $m['r_id'];
//        $LBruto = $m['LBruto'] / 100;
        $DBruto = $m['DBruto'] / 1000;
        $balkis_id = $m['balkis_id'];
        /*Noapalosana Test*/
		if ($this->MyPOST['noapalot_garumu'] == '1') {
			$LBruto = ((floor($m['LBruto']/10))/10);
//					echo "Bruto noapaļots = ".$DBrutoNoap.'<br>';
		}elseif ($this->MyPOST['noapalot_garumu'] == '2') {
			$LBruto = ((floor($m['LBruto']/10)+0.5)/10);
//					echo "Bruto noapaļots = ".$DBrutoNoap.'<br>';
        }elseif ($this->MyPOST['noapalot_garumu'] == '3') {
			$LBruto = $m['LBruto']/100;
//					echo "Bruto noapaļots = ".$DBrutoNoap.'<br>';
		}else {
			$LBruto = $m['LBruto']/100;
		}
				
        $rauk_koef = get_raukums_no_diam($raukums,$DBruto*1000); 
        
        $DPecReduc = $m['DPecReduc']/1000;
        $DReduc = $DBruto-$DPecReduc;

        $VBruto = f2($DBruto,$LBruto,$rauk_koef,$koeficients,$gostu_tabula);
/*
        echo "DBruto = ".$DBruto.'<br/>';
        echo "LBruto= ".$LBruto.'<br/>';
        echo "rauk_koef= ".$rauk_koef.'<br/>';
        echo "koeficients = ".$koeficients.'<br/>';
        echo "gostu_tabula = ".$gostu_tabula.'<br/>','<br/>','<br/>';
*/
        //echo $rauk_koef . '; ' . $koeficients . '; ' . $VBruto . '<br />';
        $VBezReducD = f2($DPecReduc,$LBruto,$rauk_koef,$koeficients,$gostu_tabula);
//        $VReducD = $VBruto-$VBezReducD;
//        echo "VReducD => ".$VReducD." = ".$VBruto." - ".$VBezReducD.'<br/>','<br/>','<br/>';
        

        /*Noapalosana*/
        

		if ($this->MyPOST['noapalot_diametru'] == 'on') {
			$DBrutoNoap = ((floor($m['DBruto']/10)+0.5)/100);
		} else {
			$DBrutoNoap = $m['DBruto']/1000;
		}
		
		if ($m[brakis] != '255')
		{
			$irbrakis = true;
			$brkods = 'standart';
		}
				
				
				//print_r($this->MyPOST);
        //echo '<<<<<<<<<<<<<<<<<<<<' . $this->MyPOST['piegad_grupa'];
//        if (strtoupper($this->MyPOST['pieg_lig_num'])=='VIKA WOOD') {
		if ($this->MyPOST['is_vika'] == 'on') {
			$LNeto = $m['LPecReduc'] / 100;

			$LNom = (nom($m['LBruto'],$virsmeri,$min_virsmers))/100;
			$LPecVirsm = $LNom;
			$LReduc = round($LPecVirsm - $LNeto,3);
			$LVirsm = round($LBruto - $LPecVirsm,3);
			
			$VBezVirsm = f2($DPecReduc,$LBruto-$LVirsm,$rauk_koef,$koeficients,$gostu_tabula);
			$VBezVirsmNeredD = f2($DBruto,$LBruto-$LVirsm,$rauk_koef,$koeficients,$gostu_tabula);
			if (!$irbrakis) {
				$VVirsm = $VBezReducD-$VBezVirsm;
			} else {
				$VVirsm = $VBruto-$VBezVirsmNeredD;
			}
			
			$VBezReducL = f2($DPecReduc,$LPecVirsm-$LReduc,$rauk_koef,$koeficients,$gostu_tabula);
			$VReducL = $VBezVirsm - $VBezReducL;
          
        } else {
        			
  				if ($this->MyPOST['noapalot_garumu'] == '1') {
					
					$LPecReduc = ((floor($m['LPecReduc']/10))/10);
					} else {
          $LPecReduc = ($m['LPecReduc'] / 100);
          }
                    
          $LNomBruto = (nom($m['LBruto'],$virsmeri,$min_virsmers))/100;
          $LnomNeto = (nom($m['LPecReduc'],$virsmeri,$min_virsmers))/100;
          
          $tilpums_bruto = f2($DBrutoNoap,$LBruto,$rauk_koef,$koeficients,$gostu_tabula);
//          echo $LnomNeto.'<br />';
          $tilpums_neto = f2($DPecReduc,$LnomNeto,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_bruto_virsmeram = f2($DBrutoNoap,$LNomBruto,$rauk_koef,$koeficients,$gostu_tabula);
          
          $tilpums_virsmers = ROUND($tilpums_bruto - $tilpums_bruto_virsmeram,3);
          
          $tilpums_garuma_redukcijai = f2($DBrutoNoap,$LnomNeto,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_garuma_redukcija = $tilpums_bruto_virsmeram - $tilpums_garuma_redukcijai;
          
          $tilpums_diametra_redukcijai_bruto = f2($DBrutoNoap,$LnomNeto,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_diametra_redukcijai_neto = f2($DPecReduc,$LnomNeto,$rauk_koef,$koeficients,$gostu_tabula);
          
          $tilpums_diametrs_redukcija = $tilpums_diametra_redukcijai_bruto - $tilpums_diametra_redukcijai_neto;

/*
          if($r_id == 42458 || $r_id == 42538){
            echo "Šis ir viens no baļķiem!---> ";
          }

          echo "Identifikators = ".$r_id.'<br />';
          echo "Bruto tilpums = ".$tilpums_bruto." , Izmantotie lielumi: Garums = ".$LBruto." , Diametrs = ".$DBrutoNoap." un raukums =".$rauk_koef.'<br />';
          echo "Neto tilpums = ".$tilpums_neto." , Izmantotie lielumi: Garums = ".$LnomNeto." , Diametrs = ".$DPecReduc." un raukums = ".$rauk_koef.'<br />';
          echo "Virsmers tilpums = ".$tilpums_virsmers.'<br />';
          echo "Redukcija diametra tilpums = ".$tilpums_diametrs_redukcija.'<br />';
          echo "Redukcija garumam tilpums = ".$tilpums_garuma_redukcija.'<br />'.'<br />';
*/
/*
          $LNeto = $LNom;
          
          
          
          $LVirsm = $LPecReduc - $LNeto;
//          echo "Virsmers = ".$LVirsm.'<br />';
//          echo "ID = ".$balkis_id.'<br />';
          $LReduc = $LBruto - $LPecReduc;
                    
          $VBezReducL = f2($DBrutoNoap,$LPecReduc,$rauk_koef,$koeficients,$gostu_tabula);

          $virs_test = f2($DBrutoNoap,$LVirsm,$rauk_koef,$koeficients,$gostu_tabula);

          $tilpums_bruto = f2($DBrutoNoap,$LBruto,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_bruto_1 = f2($DBrutoNoap,$LNom,$rauk_koef,$koeficients,$gostu_tabula);
          $tilpums_bruto_2 = f2($DBrutoNoap,$LNom + $LReduc,$rauk_koef,$koeficients,$gostu_tabula);

          $VReducL = $tilpums_bruto_2-$tilpums_bruto_1;
          
          $VBezReduc = f2($DPecReduc,$LPecReduc,$rauk_koef,$koeficients,$gostu_tabula);
          
          $VBezVirsm = f2($DPecReduc,$LPecReduc-$LVirsm,$rauk_koef,$koeficients,$gostu_tabula);
          $VBezVirsmNeredD = f2($DBruto,$LPecReduc-$LVirsm,$rauk_koef,$koeficients,$gostu_tabula);

*/
/*
          if (!$irbrakis) {
            if($VReducL > 0){
            $VVirsm = $tilpums_bruto-$tilpums_bruto_2;
             }else{
            $VVirsm = $VBezReduc-$VBezVirsm;
             }
          } else {
            $VVirsm = $VBruto-$VBezVirsmNeredD;
          }
*/          
      }

        $SVBruto += $tilpums_bruto;
        
				if ($gostu_tabula)
				{
					if ($VBruto==-1 
						|| $VReducD==-1
						|| $VReducL==-1
						|| $VVirsm==-1)
					{
						$SSkaitsBad++;
					}
					if ($VBruto==-1) $VBruto = 0;
					if ($VReducD==-1) $VReducD = 0;
					if ($VReducL==-1) $VReducL = 0;
					if ($VVirsm==-1) $VVirsm=0;
				}     
				
        
				$VBrakis = 0;
				
				if (strlen($abr[$key])==1)
				{
					$irbrakis = true;
					$brkods = $abr[$key];
				}
				
				if (!$irbrakis) {
					if ($LnomNeto > 0)
					{
                           $SVVirsm += $tilpums_virsmers;
                           $SVNeto += $tilpums_neto;
					}
					else
					{
                           $tilpums_diametrs_redukcija = 0;
                           $tilpums_garuma_redukcija = 0;
                           $SVBrakis += $tilpums_bruto;
//        echo "Brāķā tilpums = ".$tilpums_bruto.'<br />'.'<br />';
					}
                         $SVReducD += $tilpums_diametrs_redukcija;
                         $SVReducL += $tilpums_garuma_redukcija;
				}else{
				
					if ($LnomNeto!=0)
					{
						if ($this->MyPOST['braka_virsmers'] == 'on') {
                                  $SVVirsm += $tilpums_virsmers;
                                  $VBrakis = $tilpums_bruto - $tilpums_virsmers;
//        echo "Brāķā tilpums = ".$VBrakis.'<br />'.'<br />';
						}else{
                                  $VBrakis = $tilpums_bruto;
//        echo "Brāķā tilpums = ".$VBrakis.'<br />'.'<br />';
						}
					
						$SVBrakis += $VBrakis;
//        echo "Brāķā tilpums = ".$VBrakis.'<br />'.'<br />';
					}
					else
					{
						$VBrakis = $tilpums_bruto;
						$SVBrakis += $VBrakis;
//        echo "Brāķā tilpums = ".$VBrakis.'<br />'.'<br />';
					}
				
				}

				/* Testēšanas nolūkiem */
				if ($this->MyPOST['negrupet']) {
					$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$this->grup.$this->lsk],$val);

					//Pievienoju pārbaudi uz redukcijas negatīvu lielumu 2010-03-09, Ervīns
					if ($SVReducD + $SVReducL < 0) {
						$this->ERRORS .= "<font color=red>Pavadzīmē ".$this->MyPOST['pavadzime']." izveidojās negatīvs redukcijas lielums!</font><br><br>";
						return false;
					}

					$this->arr[$this->arr_index][1] = $m['DBruto'];
					//$this->arr[$this->arr_index][2] = $m['LBruto'];
					$this->arr[$this->arr_index][2] = $m['LBruto'];

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

					$this->rowclosed = true;
					$summa_p->add_skaits($SSkaits);
					$summa_p->add_skaits_bad($SSkaitsBad);
					$summa_p->add_virsmers($SVVirsm);
					$summa_p->add_redukcija_d($SVReducD);
					$summa_p->add_redukcija_l($SVReducL);
					$summa_p->add_brakis($SVBrakis);
					$summa_p->add_neto($SVNeto);
					$summa_p->add_bruto($SVBruto);

					$this->arr_index++;
				}

//          echo "Brāķa tilpums = ".$VBrakis.'<br />','<br />';
			}

/*Ievietosana*/		
	if (!$this->MyPOST['negrupet']) {
			$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$this->grup.$this->lsk],$val);

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

			$this->rowclosed = true;
			$summa_p->add_skaits($SSkaits);
			$summa_p->add_skaits_bad($SSkaitsBad);
			$summa_p->add_virsmers($SVVirsm);
			$summa_p->add_redukcija_d($SVReducD);
			$summa_p->add_redukcija_l($SVReducL);
			$summa_p->add_brakis($SVBrakis);
			$summa_p->add_neto($SVNeto);
			$summa_p->add_bruto($SVBruto);
		}
			
    }
  }
/*
*/			
			
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////Beigas/////////////////////////////////////////////
// "<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
// Aizpild?m tuk?umus 
// "<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
	if ($this->lsk>1)
	{
		for ($j=$this->lsk-2;$j>=0;$j--)
		{
			$v = $this->arr[0][$j];
			for ($i=0;$i<count($this->arr);$i++)
			{
				// iekop?jam ja tuk?s
				if (($this->arr[$i][$j]=="") && ($this->arr[$i][$j+1]!=""))
				{
					$this->arr[$i][$j]=$v;
				}

				// ja nav tuk?s pa?em v?rt?bu
				if ($this->arr[$i][$j]!="")
				{
					$v = $this->arr[$i][$j];
				}
			}
		}
	}
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

}//CReport klases beigas


function dig3($s)
{
	while (strlen($s)<3)
		$s='0'.$s;
	return $s;
}

function nom ($l,$virsmeri,$min_virsmers) {
  $min_virsmers = $min_virsmers;
  if (count($virsmeri)>0)
  {
    $result = 0;
    for ($i=0;$i<count($virsmeri);$i++)
    {
      if (($virsmeri[$i]) <= $l){
        $result = $virsmeri[$i];
      }
    }
  } else {

    $l = $l / 10;
    $l = round($l,2);
    $result = $l;
  }
    
  return $result;
}

?>