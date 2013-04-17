<?
// @@@@@@@@@@@@@@@@@@ 
// Jaunas matricas nemtaas no ApUDAViSta 1.3 spec @ 26.04.2010
// @@@@@@@@@@@@@@@@@@
/* Matrica Eglei un Priedei */
$LVM_matrix_PE = array( // Zâìbaïíi
	array(60,	99,		'6X10', 'ZB'),
	array(100,	139,	'10X14', 'ZB'),
	array(100,	119,	'10X14', 'ZB'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	179,	'14X18', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	279,	'18X28', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	-1,		'28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	439,	'28', 'ZB'),
	array(440,	459,	'28', 'ZB'),
	array(460,	479,	'28', 'ZB'),
	array(480,	499,	'28', 'ZB'),
	array(500,	-1,		'28', 'ZB'),
);

/* Matrica Priedei */
$LVM_matrix_P = array( // Zagbalki
	/*A280-299*/	array('A280',	299,	'A',	'ZB'),
	/*A300-319*/	array('A300',	319,	'A',	'ZB'),
	/*A320-339*/	array('A320',	339,	'A',	'ZB'),
	/*A340-359*/	array('A340',	359,	'A',	'ZB'),
	/*A360-379*/	array('A360',	379,	'A',	'ZB'),
	/*A380-399*/	array('A380',	399,	'A',	'ZB'),
	/*A400-419*/	array('A400',	419,	'A',	'ZB'),
	/*A420-439*/	array('A420',	439,	'A',	'ZB'),
	/*A440-459*/	array('A440',	459,	'A',	'ZB'),
	/*A460-479*/	array('A460',	479,	'A',	'ZB'),
	/*A480-499*/	array('A480',	499,	'A',	'ZB'),
	/*A500*/	  	array('A500',	-1,		'A',	'ZB'),
);

/* Matrica - Bçrzs, apse, melnalksnis, ozols, osis, lapu koki */
$LVM_matrix_BAO = array(
	array(120	,139	,'24',	'ZB'),
	array(140	,159	,'24',	'ZB'),
	array(160	,179	,'24',	'ZB'),
	array(120	,179	,'24',	'ZB'),
	array(120	,239	,'24',	'ZB'),
	array(180	,239	,'24',	'ZB'),
	array(180	,199	,'24',	'ZB'),
	array(200	,219	,'24',	'ZB'),
	array(220	,239	,'24',	'ZB'),
);
/* Matrica - Apse, melnalksnis, ozols, osis */
$LVM_matrix_AOO = array(
	array(240	,259	,'24',	'ZB'),
	array(260	,279	,'24',	'ZB'),
	array(280	,299	,'24',	'ZB'),
	array(300	,319	,'24',	'ZB'),
	array(320	,339	,'24',	'ZB'),
	array(340	,-1		,'24',	'ZB'),
	array(240	,259	,'24',	'ZB'),
	array(260	,279	,'24',	'ZB'),
	array(280	,299	,'24',	'ZB'),
	array(300	,319	,'24',	'ZB'),
	array(320	,339	,'24',	'ZB'),
	array(340	,-1		,'24',	'ZB'),
);

/* Matrica - Berzs */
$LVM_matrix_B = array(
	/*A160-179*/	array('A160',	179,	'FIA', 'FK'),
	/*A180-209*/	array('A180',	209,	'FIA', 'FK'),
	/*A210-249*/	array('A210',	249,	'FIA', 'FK'),
	/*A250-299*/	array('A250',	299,	'FIA', 'FK'),
	/*A300-399*/	array('A300',	399,	'FIA', 'FK'),
	/*A400*/		array('A400',	-1,		'FIA', 'FK'),
	/*B160-179*/	array('B160',	179,	'FIB', 'FK'),
	/*B180-209*/	array('B180',	209,	'FIB', 'FK'),
	/*B210-249*/	array('B210',	249,	'FIB', 'FK'),
	/*B250-299*/	array('B250',	299,	'FIB', 'FK'),
	/*B300-399*/	array('B300',	399,	'FIB', 'FK'),
	/*B400*/		array('B400',	-1,		'FIB', 'FK'),
);

/* Citas Matricas */
$LVM_matrix_other = array(
	array('PM', -1, 'PM', 'PM'), // Egle, bçrzs, apse
	array('PMSK', -1,'PMSK', 'PM'), // Priede, egle
	array('M', -1, 'MALKA', 'MA'), // Visas sugas
	array(120,	179, '12X18' , 'ZB'), // Priede, egle, skuju koki
	array('G', -1, 'GULSNIS', 'ZB'), // Priede, egle, skuju koki
	array(140, 179,	'GULSNIS', 'ZB'), //Zâìbaïíi	Priede, egle, skuju koki
	array(180, 239,	'GULSNIS',	'ZB'), //Zâìbaïíi	Priede, egle, skuju koki
	array(240, -1,	'GULSNIS', 'ZB'), //Zâìbaïíi	Priede, egle, skuju koki
);

$LVM_matrix = array (
array (0,	79,		'MALKA'),
array (80,	99,		'8X10'),
array (100,	119,	'10X14'),
array (120,	139,	'10X14'),
array (140,	159,	'14X18'),
array (160,	179,	'14X18'),
array (180,	199,	'18X28'),
array (200,	219,	'18X28'),
array (220,	239,	'18X28'),
array (240,	259,	'18X28'),
array (260,	279,	'18X28'),
array (280,	299,	'28'),
array (300,	319,	'28'),
array (320,	339,	'28'),
array (340,	359,	'28'),
array (360,	379,	'28'),
array (380,	399,	'28'),
array (400,	419,	'28'),
array (420,	439,	'28'),
array (440,	459,	'28'),
array (460,	479,	'28'),
array (480,	499,	'28'),
array (500,	519,	'28'),
array (520,	539,	'28'),
array (540,	559,	'28'),
array (560,	579,	'28'),
array (580,	600,	'28'),
array (601,	-1,		'28')
);

$LVM_matrix_egle = array (

array (0,	79,		'MALKA'),
array (80,	99,		'8X10'),
array (100,	119,	'10X14'),
array (120,	139,	'10X14'),
array (140,	159,	'14X18'),
array (160,	179,	'14X18'),
array (180,	199,	'18X28'),
array (200,	219,	'18X28'),
array (220,	239,	'18X28'),
array (240,	259,	'18X28'),
array (260,	279,	'18X28'),
array (280,	299,	'28'),
array (300,	319,	'28'),
array (320,	339,	'28'),
array (340,	359,	'28'),
array (360,	379,	'28'),
array (380,	399,	'28'),
array (400,	419,	'28'),
array (420,	439,	'28'),
array (440,	459,	'28'),
array (460,	479,	'28'),
array (480,	499,	'28'),
array (500,	519,	'28'),
array (520,	539,	'28'),
array (540,	559,	'28'),
array (560,	579,	'28'),
array (580,	600,	'28'),
array (601,	-1,		'28')

/* Changed on 09.01.08.
array (0,	79,		'MALKA'),
array (80,	99,		'8X10'),
array (100,	119,	'10X14'),
array (120,	129,	'10X14'),
array (130,	139,	'10X14'),
array (140,	159,	'14X18'),
array (160,	179,	'14X18'),
array (180,	199,	'18X28'),
array (200,	219,	'18X28'),
array (220,	239,	'18X28'),
array (240,	259,	'18X28'),
array (260,	279,	'18X28'),
array (280,	299,	'28'),
array (300,	319,	'28'),
array (320,	339,	'28'),
array (340,	359,	'28'),
array (360,	379,	'28'),
array (380,	399,	'28'),
array (400,	419,	'28'),
array (420,	439,	'28'),
array (440,	459,	'28'),
array (460,	479,	'28'),
array (480,	500,	'28'),
array (501,	-1,		'28')
*/
);

function get_LVM_asort_kods_no_caurm_kods($size)
{
	global $LVM_matrix;
	global $LVM_matrix_egle;

	$matrix = $LVM_matrix;

	$x = explode('-',$size);
	$mind = (int)$x[0];
	$maxd  = ((isSet($x[1]))?(int)$x[1]:0); // Ja kods ir formataa XX-XX tad nemam otro kaa max, ja formataa XX tad max ka 0
	

	$ret = '';
	for($i=0;$i<count($matrix);$i++) {
		list($diam_min1,$diam_max1,$sortiments) = $matrix[$i];
		if ( ($diam_min1==$mind) && ($diam_max1==$maxd)) {
			$ret = $sortiments;
			break;
		}
		if ( ($diam_min1==$mind) && ($diam_max1==-1) && ($maxd>=$diam_min1)) {
			$ret = $sortiments;
			break;
		}
	
	}
	return $ret;
}

function get_LVM_asort_kods_no_caurm_kods_XML($size,$suga = '') // XML versijai
{
	global $LVM_matrix;
	global $LVM_matrix_other;
	global $LVM_matrix_PE;
	global $LVM_matrix_P;
	global $LVM_matrix_BAO;
	global $LVM_matrix_AOO;

	$suga = strtoupper($suga);
	$matricas = array($LVM_matrix_other, $LVM_matrix);

	if($suga == 'A' || $suga == 'Ma' || $suga = 'Oz' || $suga == 'Os'){
		array_unshift($matricas, $LVM_matrix_AOO);
	}
	if($suga == 'B'){
		array_unshift($matricas, $LVM_matrix_B);
	}
	if($suga == 'P'){
		array_unshift($matricas, $LVM_matrix_P);
	}
	
	if($suga == 'P' || $suga == 'E'){
		array_unshift($matricas, $LVM_matrix_PE);
	} else {
		array_unshift($matricas, $LVM_matrix_BAO);
	}
	
	
	$x = explode('-',$size);
	$mind = (int)$x[0];
	$maxd  = ((isSet($x[1]))?(int)$x[1]:0); // Ja kods ir formataa XX-XX tad nemam otro kaa max, ja formataa XX tad max ka 0
	

	$ret = '';
	foreach($matricas as $matrix){
		for($i=0;$i<count($matrix);$i++) {
			list($diam_min1,$diam_max1,$sortiments, $sortimentsGroup) = $matrix[$i];
			if ( ($diam_min1==$mind) && ($diam_max1==$maxd)) {
				$ret = $sortiments;
				break 2;
			}
			if ( ($diam_min1==$mind) && ($diam_max1==-1) && ($maxd>=(int)$diam_min1 || (int)$diam_min1 == 0) ) {
				$ret = $sortiments;
				break 2;
			}
		}
	}
	return $ret;
}


function LVM_distribution($a,$suga = 1){
	$ret='';
//	echo "LVM_distribution [".$a."]<br> ";
	$a = str_replace(' ','',$a);
	$a = explode(',',$a);
//	var_dump($a);

	for($i=0; $i<count($a);$i++) {
		$z = explode('-',$a[$i]);
		$z[0] = trim ($z[0]);
		$prefix = '';
		$prefix =strtolower(substr($z[0],0,1));
		if ($prefix !='b') $prefix = '';
		if ($prefix =='b') $z[0] = substr($z[0],1,strlen($z[0])-1);

		$div = LVM_one_element_distribution($z[0],$z[1],$prefix,$suga);

		if (!$div) return false;
		$ret .=', '.$div;
	}
	$ret = substr($ret,1,strlen($ret)-1);
//	echo "Ret = ".$ret.'<br/>';
	return $ret;


}

function LVM_one_element_distribution($a,$b,$prfx='',$suga=1){

	global $LVM_matrix; 
	global $LVM_matrix_egle;
	
	if ($suga == 1) 
   {
      $matrix = $LVM_matrix;
      $ir_egle = 0; 
   } else 
   {
      $matrix = $LVM_matrix_egle;
      $ir_egle = 1; 
   }

	$ret = '';
	$index_a=-1;
	$index_b=-1;
	$a=(int)$a;
	$b=(int)$b;
	if (($a>$b) || ($a==$b)) return false;

	for($i=0;$i<count($matrix);$i++)
	{
		list($diam_min1,$diam_max1,$sortiments) = $matrix[$i];
		if ($a==$diam_min1) $index_a=$i;
		if ($b==$diam_max1) $index_b=$i;
	}

	if (($index_a==-1) && ($a>79)) return false;
	if (($index_b==-1) && ($b<=502)) return false;
	if ($index_b==-1) {$index_b=count($matrix)-1;}
	if ($index_b==-1) {$index_b=count($matrix)-1;}
	
	if ($index_a>$index_b) return false;
	if (($index_a==-1) && ($a<80)) { $ret .= ", ".$prfx."0-79";$index_a=1;}


	for ($i=$index_a;$i<=$index_b;$i++)
	{
		$matrix_sakums = $matrix[$i][0];
		$matrix_beigas = $matrix[$i][1];
		/*
		if ($ir_egle == 1)
		{
			  if (($matrix_sakums == 120) && ($matrix_beigas == 129)){$matrix[$i][1] = 139;}
			  if (($matrix_sakums == 130) && ($matrix_beigas == 139)){$matrix[$i][0] = 120;}
		}
		*/
		$ret .=", ".$prfx.$matrix[$i][0]."-";
		if ($matrix[$i][1]==-1)
      { 
        $ret .= $b;
      }else
      {
        $ret .=$matrix[$i][1];
      }
	}

	//echo $ret . '<br />';

	$ret=substr($ret,2,strlen($ret));
	//echo $ret . '<br />';
	return $ret;
}
//--------------------------------------------------------------------------------------------------------------
function get_LVM_asort_kods_no_caurm_kods_XML_sorted($tmp_skira,$veids,$size,$suga = '') // XML versijai
{
	global $LVM_matrix;
	global $LVM_matrix_other;
	global $LVM_matrix_PE_LDM_A;
	global $LVM_matrix_PE_LDM;
	global $LVM_matrix_PE_vudlande;
	global $LVM_matrix_PE_smiltene;
	global $LVM_matrix_Akrs;
	global $LVM_matrix_PE_incukalns;
	global $LVM_matrix_PE_akz;
	global $LVM_matrix_PE_bsw;
	global $LVM_matrix_P;
	global $LVM_matrix_BAO;
	global $LVM_matrix_AOO;
	global $LVM_matrix_B_hansa_A;
	global $LVM_matrix_B_hansa;
	global $LVM_matrix_PE_tfk_latekss;
	global $LVM_matrix_PE_tfk_latekss_A;

	$suga = strtoupper($suga);
	
	$matricas = array($LVM_matrix_other, $LVM_matrix);

  if($veids == "smiltene"){
    $LVM_matrix_PE = $LVM_matrix_PE_smiltene;
  }

  if($veids == "nelss"){
    $LVM_matrix_PE = $LVM_matrix_PE_akz;
  }

  if($veids == "bsw"){
    $LVM_matrix_PE = $LVM_matrix_PE_bsw;
  }

  if($veids == "vudlande"){
    $LVM_matrix_PE = $LVM_matrix_PE_vudlande;
  }

  if($veids == "tfk_latekss"){
    if($tmp_skira == 1){
      $LVM_matrix_PE = $LVM_matrix_PE_tfk_latekss_A;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_tfk_latekss;
    }
  }

  if($veids == "akrs"){
    $LVM_matrix_AOO = $LVM_matrix_Akrs;
    $LVM_matrix_BAO = $LVM_matrix_Akrs;
    $LVM_matrix_other = $LVM_matrix_Akrs;
    $LVM_matrix = $LVM_matrix_Akrs;
  }

  if($veids == "ldm_koks" || $veids == "tezei_s"){
    if($tmp_skira == 1){
      $LVM_matrix_PE = $LVM_matrix_PE_LDM_A;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_LDM;
    }
  }

  if($veids == "hansa_timber_trade" || $veids == "ma_un_ko"){
    if($tmp_skira == 1){
      $LVM_matrix_B = $LVM_matrix_B_hansa_A;
    }else{
      $LVM_matrix_B = $LVM_matrix_B_hansa;
    }
  }  

  if($veids == "incukalns"){
      $LVM_matrix_PE = $LVM_matrix_PE_incukalns;
      $LVM_matrix = $LVM_matrix_PE_incukalns;
      $LVM_matrix_BAO = $LVM_matrix_PE_incukalns;
      $LVM_matrix_AOO = $LVM_matrix_PE_incukalns;
      $LVM_matrix_other = $LVM_matrix_PE_incukalns;
      $LVM_matrix_P = $LVM_matrix_PE_incukalns;
  }  
	
	if($suga == 'A' || $suga == 'Ma' || $suga = 'Oz' || $suga == 'Os'){
		array_unshift($matricas, $LVM_matrix_AOO);
	}

	if($suga == 'B'){
		array_unshift($matricas, $LVM_matrix_B);
	}

	if($suga == 'P'){
		array_unshift($matricas, $LVM_matrix_P);
	}
	
	if($suga == 'P' || $suga == 'E'){
		array_unshift($matricas, $LVM_matrix_PE);
	} else {
		array_unshift($matricas, $LVM_matrix_BAO);
	}
	
	
	$x = explode('-',$size);
	$mind = (int)$x[0];
	$maxd  = ((isSet($x[1]))?(int)$x[1]:0); // Ja kods ir formataa XX-XX tad nemam otro kaa max, ja formataa XX tad max ka 0
	

	$ret = '';
	foreach($matricas as $matrix){
		for($i=0;$i<count($matrix);$i++) {
			list($diam_min1,$diam_max1,$sortiments, $sortimentsGroup) = $matrix[$i];
			if ( ($diam_min1==$mind) && ($diam_max1==$maxd)) {
				$ret = $sortiments;
				break 2;
			}
			if ( ($diam_min1==$mind) && ($diam_max1==-1) && ($maxd>=(int)$diam_min1 || (int)$diam_min1 == 0) ) {
				$ret = $sortiments;
				break 2;
			}
		}
	}
	return $ret;
}

$LVM_matrix_B_hansa_A = array( // Zâìbaïíi
	array(180,	209,	'FIA', 'FIA'),
	array(210,	249,	'FIA', 'FIA'),
	array(250,	299,	'FIA', 'FIA'),
	array(300,	399,	'FIA', 'FIA'),
	array(400,	-1,	'FIA', 'FIA')
);

$LVM_matrix_B_hansa = array( // Zâìbaïíi
	array(180,	209,	'FIB', 'FIB'),
	array(210,	249,	'FIB', 'FIB'),
	array(250,	299,	'FIB', 'FIB'),
	array(300,	399,	'FIB', 'FIB'),
	array(400,	-1,	'FIB', 'FIB')
);

$LVM_matrix_PE_smiltene = array( // Zâìbaïíi
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB')
);


$LVM_matrix_PE_akz = array( // Zâìbaïíi
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);

$LVM_matrix_PE_bsw = array( // Zâìbaïíi
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);

$LVM_matrix_PE_vudlande = array( // Zâìbaïíi
	array(60,	99,	'6X10', 'ZB'),
	array(100,	119,	'10X14', 'ZB'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);

$LVM_matrix_PE_tfk_latekss = array( // Zâìbaïíi
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);

$LVM_matrix_PE_tfk_latekss_A = array( // Zâìbaïíi
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'A', 'ZB'),
	array(280,	299,	'A', 'ZB'),
	array(300,	319,	'A', 'ZB'),
	array(320,	339,	'A', 'ZB'),
	array(340,	359,	'A', 'ZB'),
	array(360,	379,	'A', 'ZB'),
	array(380,	399,	'A', 'ZB'),
	array(400,	419,	'A', 'ZB'),
	array(420,	-1,	'A', 'ZB')
);

$LVM_matrix_PE_incukalns = array( // Zâìbaïíi
	array(100,	119,	'10X14', 'ZB'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'18x28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);


$LVM_matrix_Akrs = array( // Zâìbaïíi
	array(220	,239	,'24',	'ZB'),
	array(240	,259	,'24',	'ZB'),
	array(260	,279	,'24',	'ZB'),
	array(280	,299	,'24',	'ZB'),
	array(300	,319	,'24',	'ZB'),
	array(320	,339	,'24',	'ZB'),
	array(340	,-1		,'24',	'ZB')
);

$LVM_matrix_PE_LDM = array( // Zâìbaïíi
	array(260,	279,	'28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'ZB')
);

$LVM_matrix_PE_LDM_A = array( // Zâìbaïíi
	array(260,	279,	'A', 'ZB'),
	array(280,	299,	'A', 'ZB'),
	array(300,	319,	'A', 'ZB'),
	array(320,	339,	'A', 'ZB'),
	array(340,	359,	'A', 'ZB'),
	array(360,	379,	'A', 'ZB'),
	array(380,	399,	'A', 'ZB'),
	array(400,	419,	'A', 'ZB'),
	array(420,	-1,	'A', 'ZB')
);

?>