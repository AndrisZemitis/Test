<?php


$sugas = array();
$sugas['1'] = 'Priede';
$sugas['2'] = 'Egle';


$braki = array();
$braki['000'] = 'Par tievu';
$braki['001'] = 'Par garu';
$braki['002'] = 'Par resnu max diam.';
$braki['003'] = 'Par resnu tievgalis';
$braki['004'] = 'Trupe, lielainums';
$braki['005'] = 'Saussanis';
$braki['006'] = 'Zari';
$braki['007'] = 'Likumainiba';
$braki['008'] = 'Citi';
$braki['009'] = 'Par isu';
$braki['010'] = 'Par tievu';
$braki['012'] = 'Līkumainība S';
$braki['016'] = 'Diametra neatbilstiba';
$braki['017'] = 'Garuma neatbilstiba';
$braki['255'] = '';

//VMF brakja kods pret LVM kodu
$LVM_braki= array();
$LVM_braki['000'] = 'D';
$LVM_braki['001'] = 'D';
$LVM_braki['002'] = 'D';
$LVM_braki['003'] = 'D';
$LVM_braki['004'] = 'T';
$LVM_braki['005'] = 'B';
$LVM_braki['006'] = 'Z';
$LVM_braki['007'] = 'L';
$LVM_braki['008'] = 'C';
$LVM_braki['009'] = 'D';
$LVM_braki['010'] = 'D';
$LVM_braki['012'] = 'L';
$LVM_braki['016'] = 'D';
$LVM_braki['017'] = 'D';
$LVM_braki['255'] = '';

$VIKA_braki = array();
$VIKA_braki['000'] = 'Metāls';
$VIKA_braki['001'] = 'Par garu';
$VIKA_braki['002'] = 'Par resnu max diam.';
$VIKA_braki['003'] = 'Par resnu tievgalis';
$VIKA_braki['004'] = 'Trupe, lielainums';
$VIKA_braki['005'] = 'Saussanis';
$VIKA_braki['006'] = 'Zari';
$VIKA_braki['007'] = 'Likumainiba';
$VIKA_braki['008'] = 'Citi';
$VIKA_braki['009'] = 'Par isu';
$VIKA_braki['010'] = 'Par tievu';
$VIKA_braki['012'] = 'Līkumainība S';
$VIKA_braki['016'] = 'Diametra neatbilstiba';
$VIKA_braki['017'] = 'Garuma neatbilstiba';
$VIKA_braki['255'] = '';

//VMF brakja kods pret LVM kodu
$VIKA_LVM_braki= array();
$VIKA_LVM_braki['000'] = 'M';
$VIKA_LVM_braki['001'] = 'D';
$VIKA_LVM_braki['002'] = 'D';
$VIKA_LVM_braki['003'] = 'D';
$VIKA_LVM_braki['004'] = 'T';
$VIKA_LVM_braki['005'] = 'B';
$VIKA_LVM_braki['006'] = 'Z';
$VIKA_LVM_braki['007'] = 'L';
$VIKA_LVM_braki['008'] = 'C';
$VIKA_LVM_braki['009'] = 'D';
$VIKA_LVM_braki['010'] = 'D';
$VIKA_LVM_braki['012'] = 'L';
$VIKA_LVM_braki['016'] = 'D';
$VIKA_LVM_braki['017'] = 'D';
$VIKA_LVM_braki['255'] = '';

//VMF sugas kods pret LVM kodu
$LVM_sugas = array();
$LVM_sugas['1'] = 'P';
$LVM_sugas['2'] = 'E';



class C_REPORT
{
var $DB;					// Datubāzes pieslēgums
var $lsk;					// grupēšanas līmeņu skaits
var $xml_vars=array();
//var $lasttype;
var $lasttype = 'data'; // vai otra vērtība 'sum'
var $rowclosed;
var $arr_index;
var $mtipi = array();
var $ERRORS = '';
var $MyPOST;
var $arr = array();			// izejas masīvs, HTML gadījumā
var $braki;
var $XML_Variants;
var $sugas;

function C_REPORT(&$My_POST,&$DB,$XML_Variants)
	{
	global $braki;
	global $sugas;
	global $VIKA_braki;
	global $LVM_braki;
	global $VIKA_LVM_braki;

	$this->DB = $DB;
	$this->XML_Variants=$XML_Variants; 
	$this->sugas=$sugas;
	$this->MyPOST=$My_POST;
	if (strrpos($this->MyPOST['pavadzime'],"KRVII") === false) {
		$this->braki=$VIKA_braki;
		$LVM_braki=$VIKA_LVM_braki;
	} else {
		$this->braki=$braki;
	}
	$this->XMLVARS();
	$this->SetParam();
	$this->mtipi['auto'] = "Auto nr";
	$this->mtipi['brakis'] = "Brāķis";
	$this->mtipi['cenu_matrica'] = "Cenu matrica";
	$this->mtipi['kad_piegad'] = "Datums";
	$this->mtipi['mind_pirms_red'] = "Diametrs";
	$this->mtipi['fsc'] = "FSC";
	$this->mtipi['garums'] = "Garums";
	$this->mtipi['kravas_id'] = "Kravas ID";
	$this->mtipi['pavadzime.pavadzime'] = "Pavadzīme";
	$this->mtipi['piegad_kods'] = "Piegādātājs";
	$this->mtipi['soferis'] = "Šoferis";
	$this->mtipi['suga'] = "Suga";
	$this->mtipi['skira'] = "Šķira";
	$this->mtipi['iecirknis'] = "Iecirknis";

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
		while ($this->MyPOST["gtype".($this->lsk+1)]!='') $this->lsk++;
		// --------------------cik grup??anas l?me?i izmantoti ----------------------------
		
		
		// Pārbauda vai nav vairāku pavazdīmju ar šādu numuru
		if ($this->MyPOST['pavadzime'] && !$this->MyPOST[pavadzime_id]) 
		{
			$pav_test_query = "select count(*) as x from pavadzime where pavadzime = '".trim($this->MyPOST['pavadzime'])."'";
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

		$query = " from balkis,pavadzime where balkis.pavadzime = pavadzime.id ";

		// nosac?jumi
		if ($this->MyPOST[datums_no_diena]!='')
			$query=$query . " and kad_piegad >= '".$this->MyPOST[datums_no_gads]."-".$this->MyPOST[datums_no_menesis]."-".$this->MyPOST[datums_no_diena]."' ";
		if ($this->MyPOST[datums_lidz_diena]!='')
			$query=$query . " and kad_piegad <= '".$this->MyPOST[datums_lidz_gads]."-".$this->MyPOST[datums_lidz_menesis]."-".$this->MyPOST[datums_lidz_diena]."' ";
		if ($this->MyPOST[piegad_grupa])
			$query=$query . " and pavadzime.piegad_grupa like '".$this->MyPOST[piegad_grupa]."%'";
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

			for ($i=0;$i<$this->lsk;$i++)
			{
				$this->arr[-1][$i]=$this->mtipi[$this->MyPOST["gtype".($i+1)]]; 
				if($this->XML_Variants)
				{
					$this->arr[-1][$i]=$this->MyPOST["gtype".($i+1)];
					if($this->MyPOST["gtype".($i+1)]=='mind_pirms_red' ) {
						$this->MyPOST["gvalues".($i+1)]=LVM_distribution($this->MyPOST["gvalues".($i+1)]);
						$this->MyPOST["gvalues".($i+1)."_1"]=LVM_distribution($this->MyPOST["gvalues".($i+1)."_1"]);
						$this->MyPOST["gvalues".($i+1)."_2"]=LVM_distribution($this->MyPOST["gvalues".($i+1)."_2"]);
						if(($this->MyPOST["gvalues".($i+1)]) || ($this->MyPOST["gvalues".($i+1)."_1"]) || ($this->MyPOST["gvalues".($i+1)."_2]"]))
						{
							$diam__ = true;
						}	
					}
					if($this->MyPOST["gtype".($i+1)]=='garums' ) $gar__ = true;
					if($this->MyPOST["gtype".($i+1)]=='brakis' ) $brak__ = true;
				} else {
				if($this->MyPOST["gtype".($i+1)]=="pavadzime.pavadzime") $this->arr[-1][$i]=$this->mtipi['pavadzime.pavadzime']; //kaut k?ds exception
				}
			}
			// pēdējās kolonnas kas visām atskaitēm vienādas
			$this->arr[-1][$i]="Skaits";
			$i++;
			$this->arr[-1][$i]="Bruto m3";
			$i++;
			//$this->arr[-1][$i]="Virsmērs m3";
			//$i++;
			//$this->arr[-1][$i]="Redukcija m3";
			//$i++;
			//$this->arr[-1][$i]="Brāķis m3";
			//$i++;
			//$this->arr[-1][$i]="Neto m3";
			//$i++;						// $i - tagad kolonnu skaits //
		//$this->arr[-1] - kolonnu nosaukumi un izvad?m? inform?cija atskait? v?l?k.


		$this->rowclosed=true;
		$summa = new CSumma();
		
		$this->arr_index = 0;

		// $query - satur nosac?jumus,kas jaliek gala katram selektam, nosacijumi izveidoti no formas Nosacijumiem
		if(!$this->ERRORS) { 
			// rekurs?v?s funkcijas izsaukums
			$this->print_level(1,$query,$summa,false,0);
			} 

		// kopsumma 
		++$this->arr_index;
		$this->arr[$this->arr_index] = array();
		$this->arr[$this->arr_index][-1] = "Viss kopā";
		$this->arr[$this->arr_index][summa] = $summa;

		
		if($this->XML_Variants) {
			if(!$gar__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc GARUMA!<br><br>"; 
			if(!$diam__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc DIAMETRA vai arī garuma intervālu robežas neatbilst standartam!<br><br>"; 
			if(!$brak__) $this->ERRORS .= "Kļūda! Netiek izmantota grupēšana pēc BRĀĶA!<br><br>"; 
			if ($correct_count != $summa->skaits) $this->ERRORS.= "Kļūda grupēšanā! Sagrupēti ".(int)$summa->skaits." baļķi no $correct_count.<br><br>";
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
	$xml_vars[0] = $this->MyPOST['gvalues1'];
	$xml_vars[1] = $this->MyPOST['gvalues2_1'];
	$xml_vars[2] = $this->MyPOST['gvalues2_2'];
	$xml_vars[3] = $this->MyPOST['gvalues3'];
	$xml_vars[4] = $this->MyPOST['virsmeri'];
	$xml_vars[5] = $this->MyPOST['koeficients'];
	$xml_vars[6] = $this->MyPOST['raukums'];
	$xml_vars[7] = $this->MyPOST['gvalues4'];
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
	}

function print_level($level,$query,&$summa_p,$irbrakis_p,$suga)
{

	$lauks = $this->MyPOST["gtype".$level]; 
	
	////////////////////////////////////////////////////////////////// JA IR DAL?JUMS PA SUG?M //////////////////
	if ($lauks == 'garums' || $lauks == 'mind_pirms_red')
	{	
		// ja ir sadal?jums pa sug?m
		if ($this->MyPOST["dalit".$level] && $suga)
		{
			$gvalues = "gvalues".$level."_".$suga;
		}
		else
		{
			$gvalues = "gvalues".$level;
		}

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
	if ($lauks == 'kad_piegad' || $lauks == 'auto' || $lauks == 'brakis' || $lauks == 'cenu_matrica' || $lauks == 'cirsmas_kods' || $lauks == 'kad_piegad' || $lauks == 'kravas_id' || $lauks == 'pavadzime.pavadzime' || $lauks == 'piegad_kods' || $lauks == 'soferis' || $lauks == 'skira' || $lauks=='suga' || $lauks=='iecirknis')
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
	while (list($key,$val) = each($a))   //mas?va $a ($key - elementa skaitlis p?c k?rtas, $val - v?rt?ba)
	{ 		
		if ($lauks == 'suga')
		{
			$suga = $val;
		}
		
		// virsm?ru sadal?jums
		if ($suga && $this->MyPOST['dalit_virsmeri'])
		{
			if ($this->MyPOST['virsmeri_'.$suga]!='')
			{
				$virsmeri = explode(',',$this->MyPOST['virsmeri_'.$suga]);
				for ($i=0;$i<count($virsmeri);$i++)
					$virsmeri[$i] = $virsmeri[$i]/100;
			}
		}
		else
		{
			if ($this->MyPOST['virsmeri']!='')
			{
				$virsmeri = explode(',',$this->MyPOST['virsmeri']);
				for ($i=0;$i<count($virsmeri);$i++)
					$virsmeri[$i] = $virsmeri[$i]/100;
			}
		}
		
		if ($suga && $_POST[dalit_raukums])
		{
			$raukums = raukums_2_array($_POST['raukums_'.$suga]);
		}
		else
		{
			$raukums = raukums_2_array($_POST['raukums']);
		}

		if ($suga && $this->MyPOST[dalit_koeficients])
		{
			$koeficients = $this->MyPOST['koeficients_'.$suga];
		}
		else
		{
			$koeficients = $this->MyPOST['koeficients'];
		}

		if ($typ!='string')	$mbounds = explode('-',$a[$row]);
		
		if (count($mbounds)>1)
			$myquery = $query . " and  (". $this->MyPOST["gtype".$level] . ">=" . $mbounds[0] ." and " . $this->MyPOST["gtype".$level] . "<=" . $mbounds[1] . ")";
		else
		{
			if ($typ == 'string')
				$myquery = $query . " and  ". $this->MyPOST["gtype".$level] . "='" . $a[$row] . "'";
			else
				$myquery = $query . " and  ". $this->MyPOST["gtype".$level] . "=" . $a[$row];
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
				$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$level],$val);

			}

			$sum = new CSumma();

			if (strlen($abr[$key])==1)
			{
				$irbrakis = true;
				$brkods = $abr[$key];
			}

			$this->print_level($level+1,$myquery,$sum,$irbrakis,$suga);
			
			// Te saskaita kop? par l?meni summu - XML varianta tas nav jadara
			if (!$this->XML_Variants) {			
						$this->arr_index++;
						$this->arr[$this->arr_index]=array();
						if ($sum->bruto)
						{
							$this->arr[$this->arr_index][-1] = "Kopā";
							for ($i=0;$i<$this->lsk;$i++)
							{
								if ($level==$i+1)
								{
									$this->arr[$this->arr_index][$i] = $this->kodi($this->MyPOST['gtype'.$level],$val);
								}
								else
								{
									$this->arr[$this->arr_index][$i] = "";
								}
							}
							
							$this->arr[$this->arr_index][summa] = $sum;
							//echo "<tr><td height=1 colspan=".(7+$this->lsk)."><hr></tr>";
						}
			}			
			$this->rowclosed = true;
			$summa_p->add_skaits($sum->skaits);
			//$summa_p->add_virsmers($sum->virsmers);
			//$summa_p->add_redukcija_d($sum->redukcija_d);
			//$summa_p->add_redukcija_l($sum->redukcija_l);
			//$summa_p->add_brakis($sum->brakis);
			//$summa_p->add_neto($sum->neto);
			$summa_p->add_bruto($sum->bruto);
			$this->lasttype = 'sum';
		}
		else
		{
			$this->lasttype = 'data';
			// ja nav dzi??k, tad apr??ina summu 
			$query__="select mind_pirms_red as d1, garums as l1, mind_pec_red as d2, gar_pec_red as l2, brakis, pavadzime.cenu_matrica as cm  " . $myquery;
			$r = $this->DB->query($query__);
			$bruto=0;
			$virsmers=0;
			$redukcija_d=0;
			$redukcija_l=0;
			$brakis=0;
			$neto=0;
			$skaits=0;
			while ($m = $this->DB->get_row($r))
			{
				$skaits++; 
				$d1 = $m[d1]/1000;
				$d2 = $m[d2]/1000;
				$l1 = $m[l1]/100;
				$l2 = $m[l2]/100;

				if (count($virsmeri)>0)
				{
					$l3 = 0;
					for ($i=0;$i<count($virsmeri);$i++)
					{
						if ($virsmeri[$i]<=$l2)
						{
							$l3 = $virsmeri[$i];
						}
					}
				}
				else
					$l3 = $l2;

				
				$rauk_koef = get_raukums_no_diam($raukums,$m[d1]); 

				$bruto_temp = f($d1,$l1,$rauk_koef,$koeficients);
				$bruto = $bruto + $bruto_temp;

				if ($m[brakis] != '255')
				{
					$irbrakis = true;
					$brkods = 'standart';
				}

				if (!$irbrakis)
				{
					$redukcija_d_temp = round(f($d1,$l1,$rauk_koef,$koeficients)-f($d2,$l1,$rauk_koef,$koeficients),3);
					$redukcija_l_temp = round(f($d1,$l1,$rauk_koef,$koeficients)-f($d1,$l2,$rauk_koef,$koeficients),3);
					$redukcija_d = round($redukcija_d + $redukcija_d_temp,3);
					$redukcija_l = round($redukcija_l + $redukcija_l_temp,3);
				}
				$b = 0;
				
				if (strlen($abr[$key])==1)
				{
					$irbrakis = true;
					$brkods = $abr[$key];
				}

				// ja nav br??is
				if (!$irbrakis)
				{
					$virsmers_temp = f($d2,$l2,$rauk_koef,$koeficients)-f($d2,$l3,$rauk_koef,$koeficients);
					$virsmers = $virsmers + $virsmers_temp;
					$neto = $neto + ($bruto_temp-$redukcija_d_temp-$redukcija_l_temp-$virsmers_temp);
				}
				else
				{
					$b = f($d1,$l1,$rauk_koef,$koeficients);
					$brakis = $brakis + $b;
				}
			}
			//izdruk? p?d?jo rindas elementu no grup??anas nosac?jumiem
			$this->arr[$this->arr_index][$level-1] = $this->kodi($this->MyPOST['gtype'.$this->lsk],$val);

			$sm = new CSumma;
			$sm->skaits = $skaits;
			//$sm->virsmers = $virsmers;
			//$sm->redukcija_d = $redukcija_d;
			//$sm->redukcija_l = $redukcija_l;
			//$sm->brakis = $brakis;
			//$sm->neto = $neto;
			$sm->bruto = $bruto;
			$this->arr[$this->arr_index][summa] = $sm;

			$this->rowclosed = true;
			$summa_p->add_skaits($skaits);
			//$summa_p->add_virsmers($virsmers);
			//$summa_p->add_redukcija_d($redukcija_d);
			//$summa_p->add_redukcija_l($redukcija_l);
			//$summa_p->add_brakis($brakis);
			//$summa_p->add_neto($neto);
			$summa_p->add_bruto($bruto);
		}
	}
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

function GetDataArray()
{
return $this->arr;
}

function GetHTML()
{
$str="<table border=0 cellspacing=0 cellpadding=0>";
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
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->skaits,3).$format_end."</td><td width=5>";
			$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->bruto,3).$format_end."</td><td width=5>";
			//$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->virsmers,3).$format_end."</td><td width=5>";
			//$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->redukcija_d+$this->arr[$i][summa]->redukcija_l,3).$format_end."</td><td width=5>";
			//$str= $str."<td align=right>".$format_start.round($this->arr[$i][summa]->brakis,3).$format_end."</td><td width=5>";
			//$str= $str."<td align=right bgcolor=#cccccc>".$format_start.round($this->arr[$i][summa]->neto,3).$format_end."</td>";
			$str= $str."</tr>";
		}
	}
return $str."</table>";
}

function kodi($typ,$val)
{
	global $LVM_sugas;
	global $LVM_braki;

	if(!$this->XML_Variants) {
		if ($typ=='brakis')
		{
			return $this->braki[$val];
		}
	
		if ($typ=='suga')
		{
			return $this->sugas[$val];
		}
	}
	if($this->XML_Variants) {
		if ($typ=='brakis')
		{
			//echo "braki:".$val." ".$LVM_braki[$val];
			return $LVM_braki[$val];
		}
	
		if ($typ=='suga')
		{
			return $LVM_sugas[$val];
		}
	}
		return $val;
}

}//CReport klases beigas



?>