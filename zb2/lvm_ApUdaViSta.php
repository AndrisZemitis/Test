<?
// @@@@@@@@@@@@@@@@@@ 
// Jaunas matricas nemtaas no ApUDAViSta 1.3 spec @ 26.04.2010
// @@@@@@@@@@@@@@@@@@
/* Matrica Eglei un Priedei */
$LVM_matrix_PE = array( // Zāģbaļķi
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

//--------------------------------------------------------------------------------------------------------------
function get_LVM_asort_kods_no_caurm_kods_XML_sorted($tmp_skira,$veids,$size,$suga) // XML versijai
{
	global $LVM_matrix;
	global $LVM_matrix_P_incukalns;
	global $LVM_matrix_E_incukalns;
	global $LVM_matrix_PE_akz;
	global $LVM_matrix_PE_piebalgas;
	global $LVM_matrix_PE_saldusmr;
	global $LVM_matrix_PE_kurekss;
	global $LVM_matrix_Osukalns_apse_alksnis;
	global $LVM_matrix_Osukalns_lapu_koki;
	global $LVM_matrix_PE_stora_enso;
	global $LVM_matrix_PE_smiltene;
	global $LVM_matrix_4_plus_apse;
	global $LVM_matrix_PE_vudlande;
	global $LVM_matrix_A_finieris;
	global $LVM_matrix_B_finieris;
	global $LVM_matrix_PE_GK;
	global $LVM_matrix_PE_BSW;
	global $LVM_matrix_Tezei_S;
	global $LVM_matrix_Vika_Wood;
	global $LVM_matrix_PE_Gulsnis;
	global $LVM_matrix_PE_Marko_kea;
	global $LVM_matrix_Aboltina_b;
	global $LVM_matrix_Triomax;
	global $LVM_matrix_SadalesTikls;
	global $LVM_matrix_PE_ivejas;
	global $LVM_matrix_PE_talsu_mr;
	global $LVM_matrix_A_finieris_maileks;
	global $LVM_matrix_B_finieris_maileks;
	global $LVM_matrix_ZB_finieris_maileks;
	global $LVM_matrix_Oz_maileks;
	global $LVM_matrix_latvani_a_skira;
	global $LVM_matrix_latvani_b_skira;
	global $LVM_matrix_PE_jekabpils;
	global $LVM_matrix_varpas_1;
	global $LVM_matrix_sinda;
	global $LVM_matrix_PE_varpas_1_1_pusg;
	global $LVM_matrix_PE_vudlande_priede;
	global $LVM_matrix_HTT_berzs;
	global $LVM_matrix_B_Kurzemes_finieris;
	global $LVM_matrix_KRAUSS_berzs;

	$suga = strtoupper($suga);
	
  if($veids == 11 || $veids == 12){
    if($suga != "E"){
      $LVM_matrix_PE = $LVM_matrix_P_incukalns;
      $LVM_matrix = $LVM_matrix_P_incukalns;
    }else{
      $LVM_matrix_PE = $LVM_matrix_E_incukalns;
      $LVM_matrix = $LVM_matrix_E_incukalns;
    }
  }  

  if($veids == 46){
    if($suga == "E" || $suga == "P"){
      $LVM_matrix_PE = $LVM_matrix_PE_varpas_1_1_pusg;
      $LVM_matrix = $LVM_matrix_PE_varpas_1_1_pusg;
      $LVM_matrix_other = $LVM_matrix_PE_varpas_1_1_pusg;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix_other = $LVM_matrix_PE_Gulsnis;
    }
  }  

  if($veids == 2 || $veids == 55){
      $LVM_matrix_PE = $LVM_matrix_Vika_Wood;
      $LVM_matrix = $LVM_matrix_Vika_Wood;
      $LVM_matrix_other = $LVM_matrix_Vika_Wood;
  }  

  if($veids == 58){
    if($suga == "P"){
      $LVM_matrix_PE = $LVM_matrix_varpas_1;
      $LVM_matrix = $LVM_matrix_varpas_1;
      $LVM_matrix_other = $LVM_matrix_varpas_1;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix_other = $LVM_matrix_PE_Gulsnis;
    }
  }

  if($veids == 50){
      $LVM_matrix_PE = $LVM_matrix_sinda;
      $LVM_matrix = $LVM_matrix_sinda;
      $LVM_matrix_other = $LVM_matrix_sinda;
  }  

  if($veids == 31 || $veids == 37){
      $LVM_matrix_PE = $LVM_matrix_HTT_berzs;
      $LVM_matrix = $LVM_matrix_HTT_berzs;
      $LVM_matrix_other = $LVM_matrix_HTT_berzs;
  } 
  
  if($veids == 40){
      $LVM_matrix_PE = $LVM_matrix_KRAUSS_berzs;
      $LVM_matrix = $LVM_matrix_KRAUSS_berzs;
      $LVM_matrix_other = $LVM_matrix_KRAUSS_berzs;
  } 

  if($veids == 8){
      $LVM_matrix_PE = $LVM_matrix_Aboltina_b;
      $LVM_matrix = $LVM_matrix_Aboltina_b;
      $LVM_matrix_other = $LVM_matrix_Aboltina_b;
  }  

  if($veids == 28){
      $LVM_matrix_PE = $LVM_matrix_PE_piebalgas;
      $LVM_matrix = $LVM_matrix_PE_piebalgas;
  }  

  if($veids == 22){
    if($suga == "E"){
      $LVM_matrix_PE = $LVM_matrix_PE_vudlande;
      $LVM_matrix = $LVM_matrix_PE_vudlande;
      $LVM_matrix_other = $LVM_matrix_PE_vudlande;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_vudlande_priede;
      $LVM_matrix = $LVM_matrix_PE_vudlande_priede;
      $LVM_matrix_other = $LVM_matrix_PE_vudlande_priede;
    }
  }

  if($veids == 51){
    if($suga == "E"){
      $LVM_matrix_PE = $LVM_matrix_PE_BSW;
      $LVM_matrix = $LVM_matrix_PE_BSW;
      $LVM_matrix_other = $LVM_matrix_PE_BSW;
    }elseif($suga == "P"){
      $LVM_matrix_PE = $LVM_matrix_PE_smiltene;
      $LVM_matrix = $LVM_matrix_PE_smiltene;
      $LVM_matrix_other = $LVM_matrix_PE_smiltene;
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix_other = $LVM_matrix_PE_Gulsnis;
    }
  }

  if($veids == 39){
      $LVM_matrix_PE = $LVM_matrix_Aboltina_b;
      $LVM_matrix = $LVM_matrix_Aboltina_b;
      $LVM_matrix_other = $LVM_matrix_Aboltina_b;
  }

  if($veids == 49 || $veids == 57){
      $LVM_matrix_PE = $LVM_matrix_PE_talsu_mr;
      $LVM_matrix = $LVM_matrix_PE_talsu_mr;
      $LVM_matrix_other = $LVM_matrix_PE_talsu_mr;
  }

  if($veids == 55){
      $LVM_matrix_PE = $LVM_matrix_PE_jekabpils;
      $LVM_matrix = $LVM_matrix_PE_jekabpils;
      $LVM_matrix_other = $LVM_matrix_PE_jekabpils;
  }

  if($veids == 54 || $veids == 48){
    if($tmp_skira == '1'){
      $LVM_matrix_PE = $LVM_matrix_latvani_a_skira;
      $LVM_matrix = $LVM_matrix_latvani_a_skira;
      $LVM_matrix_other = $LVM_matrix_latvani_a_skira;
    }else{
      $LVM_matrix_PE = $LVM_matrix_latvani_b_skira;
      $LVM_matrix = $LVM_matrix_latvani_b_skira;
      $LVM_matrix_other = $LVM_matrix_latvani_b_skira;    
    }
  }

  if($veids == 41){
      $LVM_matrix_PE = $LVM_matrix_Triomax;
      $LVM_matrix = $LVM_matrix_Triomax;
      $LVM_matrix_other = $LVM_matrix_Triomax;
  }

  if($veids == 16 || $veids == 34 || $veids == 30){
      $LVM_matrix_PE = $LVM_matrix_Tezei_S;
      $LVM_matrix = $LVM_matrix_Tezei_S;
      $LVM_matrix_other = $LVM_matrix_Tezei_S;
  }

  if($veids == 24){
      $LVM_matrix_PE = $LVM_matrix_PE_saldusmr;
      $LVM_matrix = $LVM_matrix_PE_saldusmr;
      $LVM_matrix_other = $LVM_matrix_PE_saldusmr;
  }  

  if($veids == 47){
      $LVM_matrix_PE = $LVM_matrix_PE_ivejas;
      $LVM_matrix = $LVM_matrix_PE_ivejas;
      $LVM_matrix_other = $LVM_matrix_PE_ivejas;
  }  

  if($veids == 25){
      $LVM_matrix_PE = $LVM_matrix_PE_stora_enso;
      $LVM_matrix = $LVM_matrix_PE_stora_enso;
      $LVM_matrix_other = $LVM_matrix_PE_stora_enso;
  }  

  if($veids == 42){
      $LVM_matrix_PE = $LVM_matrix_SadalesTikls;
      $LVM_matrix = $LVM_matrix_SadalesTikls;
      $LVM_matrix_other = $LVM_matrix_SadalesTikls;
  }  

  if($veids == 29 || $veids == 7 || $veids == 32|| ($veids == 19 && $suga == "LK")){
    if($suga != "LK"){
      $LVM_matrix_PE = $LVM_matrix_Osukalns_apse_alksnis;
      $LVM_matrix = $LVM_matrix_Osukalns_apse_alksnis;
      $LVM_matrix_other = $LVM_matrix_Osukalns_apse_alksnis;
    }else{
      $LVM_matrix_PE = $LVM_matrix_Osukalns_lapu_koki;
      $LVM_matrix = $LVM_matrix_Osukalns_lapu_koki;    
      $LVM_matrix_other = $LVM_matrix_Osukalns_lapu_koki;    
    }
  }  

  if($veids == 27){
      $LVM_matrix_PE = $LVM_matrix_PE_kurekss;
      $LVM_matrix = $LVM_matrix_PE_kurekss;
      $LVM_matrix_other = $LVM_matrix_PE_kurekss;    
  }  

  if($veids == 36 || ($veids == 19 && ($suga == "A" || $suga == "M"))){
      $LVM_matrix_PE = $LVM_matrix_4_plus_apse;
      $LVM_matrix = $LVM_matrix_4_plus_apse;
      $LVM_matrix_other = $LVM_matrix_4_plus_apse;    
  }  

  if($veids == 18){
      $LVM_matrix_PE = $LVM_matrix_PE_akz;
      $LVM_matrix = $LVM_matrix_PE_akz;
      $LVM_matrix_other = $LVM_matrix_PE_akz;    
  }  

  if($veids == 23){
      $LVM_matrix_PE = $LVM_matrix_PE_smiltene;
      $LVM_matrix = $LVM_matrix_PE_smiltene;
      $LVM_matrix_other = $LVM_matrix_PE_smiltene;    
  }  

  if($veids == 33){
      $LVM_matrix_PE = $LVM_matrix_4_plus_apse;
      $LVM_matrix = $LVM_matrix_4_plus_apse;
      $LVM_matrix_other = $LVM_matrix_4_plus_apse;    
  }  

  if($veids == 19){
    if($suga != "LK" && $suga != "A" && $suga != "M"){  
      $LVM_matrix_PE = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix_other = $LVM_matrix_PE_Gulsnis;    
    }
  }

  if($veids == 38 || $veids == 44){
    if($suga != "P"){
      $LVM_matrix_PE = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix = $LVM_matrix_PE_Gulsnis;
      $LVM_matrix_other = $LVM_matrix_PE_Gulsnis;    
    }else{
      $LVM_matrix_PE = $LVM_matrix_PE_Marko_kea;
      $LVM_matrix = $LVM_matrix_PE_Marko_kea;
      $LVM_matrix_other = $LVM_matrix_PE_Marko_kea;        
    }
  }  

  if($veids == 21){
      $LVM_matrix_PE = $LVM_matrix_PE_GK;
      $LVM_matrix = $LVM_matrix_PE_GK;
      $LVM_matrix_other = $LVM_matrix_PE_GK;    
  }  

  if($veids == 20){
      $LVM_matrix_PE = $LVM_matrix_PE_BSW;
      $LVM_matrix = $LVM_matrix_PE_BSW;
      $LVM_matrix_other = $LVM_matrix_PE_BSW;    
  }  

  if($veids == 45){
    if($tmp_skira == 'E' || $tmp_skira == '1'){
      $LVM_matrix_PE = $LVM_matrix_A_finieris;
      $LVM_matrix = $LVM_matrix_A_finieris;
      $LVM_matrix_other = $LVM_matrix_A_finieris;    
    }else{
      $LVM_matrix_PE = $LVM_matrix_B_Kurzemes_finieris;
      $LVM_matrix = $LVM_matrix_B_Kurzemes_finieris;
      $LVM_matrix_other = $LVM_matrix_B_Kurzemes_finieris;    
    }
  }

  if($veids == 26 || $veids == 35 || $veids == 45){
    if($tmp_skira == 'E' || $tmp_skira == '1'){
      $LVM_matrix_PE = $LVM_matrix_A_finieris;
      $LVM_matrix = $LVM_matrix_A_finieris;
      $LVM_matrix_other = $LVM_matrix_A_finieris;    
    }else{
      $LVM_matrix_PE = $LVM_matrix_B_finieris;
      $LVM_matrix = $LVM_matrix_B_finieris;
      $LVM_matrix_other = $LVM_matrix_B_finieris;    
    }
  }

  if($veids == 52 || $veids == 53){
    if($suga != 'OZ' && $suga != 'OS'){
        $LVM_matrix_PE = $LVM_matrix_HTT_berzs;
        $LVM_matrix = $LVM_matrix_HTT_berzs;
        $LVM_matrix_other = $LVM_matrix_HTT_berzs;    
    }else{
        $LVM_matrix_PE = $LVM_matrix_Oz_maileks;
        $LVM_matrix = $LVM_matrix_Oz_maileks;
        $LVM_matrix_other = $LVM_matrix_Oz_maileks;    
    }
  }

	$matricas = array($LVM_matrix, $LVM_matrix);	

	$ret = '';
	foreach($matricas as $matrix){
		for($i=0;$i<count($matrix);$i++) {
			list($diam_min1,$diam_max1,$sortiments, $min_or_max) = $matrix[$i];
			if ( ($size >= $diam_min1) && ($size <= $diam_max1)) {
				$ret[1] = $sortiments;
				$ret[0] = $diam_min1.'-'.$diam_max1;
				break 2;
			}

			if ($min_or_max == "min" && $size <= $diam_min1) {
				$ret[1] = $sortiments;
				$ret[0] = $diam_min1.'-'.$diam_max1;
				break 2;
			}

			if ($min_or_max == "max" && $size >= $diam_min1) {
				$ret[1] = $sortiments;
				if($diam_max1 == -1){
          $ret[0] = $diam_min1;
				}else{
          $ret[0] = $diam_min1.'-'.$diam_max1;				
				}
				break 2;
			}
		}
	}
	return $ret;
}

$LVM_matrix_SadalesTikls = array( // Zāģbaļķi
	array(100,	179,	'STABI 10-14', 'min'),
	array(180,	259,	'STABI 10-14', 'ZB'),
	array(260,	-1,	'STABI 10-14', 'max')
);


$LVM_matrix_Vika_Wood = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_Triomax = array( // Zāģbaļķi
	array(260,	279,	'28', 'min'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_Tezei_S = array( // Zāģbaļķi
	array(260,	279,	'28', 'min'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_Oz_maileks = array( // Zāģbaļķi
	array(180,	199,	'18', 'min'),
	array(200,	219,	'18', 'ZB'),
	array(220,	239,	'18', 'ZB'),
	array(240,	259,	'18', 'ZB'),
	array(260,	279,	'18', 'ZB'),
	array(280,	299,	'18', 'ZB'),
	array(360,	319,	'18', 'ZB'),
	array(300,	320,	'18', 'ZB'),
	array(320,	-1,	'18', 'max')
);

$LVM_matrix_HTT_berzs = array( // Zāģbaļķi
	array(160,	179,	'18', 'min'),
	array(180,	209,	'18', 'ZB'),
	array(210,	249,	'18', 'ZB'),
	array(250,	299,	'18', 'ZB'),
	array(300,	399,	'18', 'ZB'),
	array(400,	-1,	'18', 'max')
);

$LVM_matrix_KRAUSS_berzs = array( // Zāģbaļķi
	array(180,	209,	'18', 'min'),
	array(210,	249,	'18', 'ZB'),
	array(250,	299,	'18', 'ZB'),
	array(300,	399,	'18', 'ZB'),
	array(400,	-1,	'18', 'max')
);

$LVM_matrix_Aboltina_b = array( // Zāģbaļķi
	array(260,	279,	'28', 'min'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_latvani_a_skira = array( // Zāģbaļķi
	array(260,	279,	'A28', 'min'),
	array(280,	299,	'A28', 'ZB'),
	array(300,	319,	'A28', 'ZB'),
	array(320,	339,	'A28', 'ZB'),
	array(340,	359,	'A28', 'ZB'),
	array(360,	379,	'A28', 'ZB'),
	array(380,	399,	'A28', 'ZB'),
	array(400,	419,	'A28', 'ZB'),
	array(420,	-1,	'A28', 'max')
);

$LVM_matrix_latvani_b_skira = array( // Zāģbaļķi
	array(260,	279,	'28', 'min'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'ZB'),
	array(340,	359,	'28', 'ZB'),
	array(360,	379,	'28', 'ZB'),
	array(380,	399,	'28', 'ZB'),
	array(400,	419,	'28', 'ZB'),
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_A_finieris_maileks = array( // Zāģbaļķi
	array(160,	179,	'FIA', 'min'),
	array(180,	209,	'FIA', 'FK'),
	array(210,	249,	'FIA', 'FK'),
	array(250,	299,	'FIA', 'FK'),
	array(300,	399,	'FIA', 'FK'),
	array(400,	700,	'FIA', 'FK'),
	array(701,	1000,	'FIA', 'FK'),
	array(1001,	-1,	'FIA', 'max')
);

$LVM_matrix_B_finieris_maileks = array( // Zāģbaļķi
	array(160,	179,	'FIB', 'min'),
	array(180,	209,	'FIB', 'FK'),
	array(210,	249,	'FIB', 'FK'),
	array(250,	299,	'FIB', 'FK'),
	array(300,	399,	'FIB', 'FK'),
	array(400,	700,	'FIB', 'FK'),
	array(701,	1000,	'FIB', 'FK'),
	array(1001,	-1,	'FIB', 'max')
);

$LVM_matrix_A_finieris = array( // Zāģbaļķi
	array(180,	209,	'FIA', 'min'),
	array(210,	249,	'FIA', 'FK'),
	array(250,	299,	'FIA', 'FK'),
	array(300,	399,	'FIA', 'FK'),
	array(400,	-1,	'FIA', 'max')
);

$LVM_matrix_B_Kurzemes_finieris = array( // Zāģbaļķi
	array(180,	209,	'FIB', 'min'),
	array(210,	249,	'FIB', 'FK'),
	array(250,	299,	'FIB', 'FK'),
	array(300,	399,	'FIB', 'FK'),
	array(400,	-1,	'FIB', 'max')
);

$LVM_matrix_sinda = array( // Zāģbaļķi
	array(180,	209,	'18', 'min'),
	array(210,	249,	'18', 'FK'),
	array(250,	299,	'18', 'FK'),
	array(300,	399,	'18', 'FK'),
	array(400,	-1,	'18', 'max')
);

$LVM_matrix_B_finieris = array( // Zāģbaļķi
	array(120,	139,	'FIB', 'min'),
	array(140,	159,	'FIB', 'FK'),
	array(160,	179,	'FIB', 'FK'),
	array(180,	209,	'FIB', 'FK'),
	array(210,	249,	'FIB', 'FK'),
	array(250,	299,	'FIB', 'FK'),
	array(300,	399,	'FIB', 'FK'),
	array(400,	-1,	'FIB', 'max')
);

$LVM_matrix_PE_BSW = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_varpas_1 = array( // Zāģbaļķi
	array(160,	179,	'18X28', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_piebalgas = array( // Zāģbaļķi
	array(60,	99,	'6X10', 'min'),
	array(100,	119,	'10X14', 'ZB'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'max')
);

$LVM_matrix_P_incukalns = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'max')
);

$LVM_matrix_E_incukalns = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'max')
);

$LVM_matrix_PE_talsu_mr = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
	array(160,	179,	'14X18', 'max')
);

$LVM_matrix_PE_saldusmr = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_ZB_finieris_maileks = array(
	array(160,	179,	'18X24', 'min'),
	array(180,	199,	'18X24', 'ZB'),
	array(200,	219,	'18X24', 'ZB'),
	array(220,	239,	'18X24', 'ZB'),
	array(240,	259,	'24', 'ZB'),
	array(260,	279,	'24', 'ZB'),
	array(280,	299,	'24', 'ZB'),
	array(300,	319,	'24', 'ZB'),
	array(320,	339,	'24', 'ZB'),
	array(340,	-1,	'24', 'max')
);

$LVM_matrix_PE_stora_enso = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'14X18', 'ZB'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'max')
);

$LVM_matrix_PE_smiltene = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'ZB'),
	array(280,	299,	'28', 'ZB'),
	array(300,	319,	'28', 'ZB'),
	array(320,	339,	'28', 'max')
);

$LVM_matrix_PE_ivejas = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
	array(120,	139,	'10X14', 'ZB'),
	array(140,	159,	'10X14', 'max')
);

$LVM_matrix_Osukalns_apse_alksnis = array( // Zāģbaļķi
	array(220,	239,	'24', 'min'),
	array(240,	259,	'24', 'ZB'),
	array(260,	279,	'24', 'ZB'),
	array(280,	299,	'24', 'ZB'),
	array(300,	319,	'24', 'ZB'),
	array(320,	339,	'24', 'ZB'),
	array(340,	-1,	'24', 'max')
);

$LVM_matrix_4_plus_apse = array( // Zāģbaļķi
	array(220,	239,	'24', 'min'),
	array(240,	259,	'24', 'ZB'),
	array(260,	279,	'24', 'ZB'),
	array(280,	299,	'24', 'ZB'),
	array(300,	319,	'24', 'ZB'),
	array(320,	339,	'24', 'ZB'),
	array(340,	-1,	'24', 'max')
);

$LVM_matrix_Osukalns_lapu_koki = array( // Zāģbaļķi
	array(160,	179,	'18X24', 'min'),
	array(180,	199,	'18X24', 'ZB'),
	array(200,	219,	'18X24', 'ZB'),
	array(220,	239,	'18X24', 'max')
);

$LVM_matrix_PE_akz = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_vudlande = array( // Zāģbaļķi
	array(160,	179,	'18X28', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_vudlande_priede = array( // Zāģbaļķi
	array(160,	179,	'18X28', 'min'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'max')
);

$LVM_matrix_PE_kurekss = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_GK = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_varpas_1_1_pusg = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
	array(160,	179,	'14X18', 'ZB'),
	array(180,	199,	'18X28', 'ZB'),
	array(200,	219,	'18X28', 'ZB'),
	array(220,	239,	'18X28', 'ZB'),
	array(240,	259,	'18X28', 'ZB'),
	array(260,	279,	'18X28', 'max')
);

$LVM_matrix_PE_jekabpils = array( // Zāģbaļķi
	array(100,	119,	'10X14', 'min'),
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
	array(420,	-1,	'28', 'max')
);

$LVM_matrix_PE_Marko_kea = array( // Zāģbaļķi
	array(140,	159,	'14X18', 'min'),
	array(160,	179,	'14X18', 'max')
);

$LVM_matrix_PE_Gulsnis = array(
  array(160, 179, 'GULSNIS', 'min'),
  array(180, 239, 'GULSNIS', 'ZB'),
  array(240, -1, 'GULSNIS', 'max')
);
?>