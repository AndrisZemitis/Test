<?

header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=papirmalka.xls"); header("Content-transfer-encoding: binary");

include '../connect.php';
include '../check_login.php';
$metode = $_POST['metode_id']; // pagaidaam, kameer nav otras puses.
if ($metode) mysql_query("update papirmalka set metode = '".$metode."' where id = $darba_id ");
//$metode_tmp = 1;
//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------
$tmp_lang = $_POST['valoda_id'];
$arr_transl = array();
$arr_transl[1]['vmf_mi'] = "VMF MI P 04.02.05";
$arr_transl[1]['variants'] = "3.variants";
$arr_transl[1]['vmf_datums'] = "26.11.2010";
$arr_transl[1]['krautnes_un_individualas_uzmērisanas_salidzinajums'] = "Krautnes un individuālās uzmērīšanas salīdzinājums";
$arr_transl[1]['krautnes_uzmerisana'] = "Krautnes uzmērīšana (K - mērīšana)";
$arr_transl[1]['pakas_identif'] = "Pakas identif.nr.";
$arr_transl[1]['sortiments'] = "Sortiments";
$arr_transl[1]['pasutitajs'] = "Pasūtītajs";
$arr_transl[1]['kolektivs'] = "Kolektīvs";
$arr_transl[1]['kontrolmerijuma_vieta'] = "Kontrolmērījuma vieta";
$arr_transl[1]['gredas_nr_uz_autotransp'] = "Grēdas nr uz autotransp.";
$arr_transl[1]['kontrolmerijuma_datums'] = "Kontrolmērījuma datums";
$arr_transl[1]['kontrolpakas_izveles_datums'] = "Kontrolpakas izvēles datums";
$arr_transl[1]['kraujmera_uzmerisanas_rezultats'] = "Kraujmērā uzmērīšanas rezultāts";
$arr_transl[1]['platums'] = "Platums,";
$arr_transl[1]['augstums'] = "Augstums,";
$arr_transl[1]['garums'] = "Garums,";
$arr_transl[1]['steri'] = "Steri,";
$arr_transl[1]['koef'] = "K, %";
$arr_transl[1]['bruto_tilp'] = "Bruto tilp";
$arr_transl[1]['brakis'] = "Brāķis";
$arr_transl[1]['neto_tilp'] = "Neto tilp";
$arr_transl[1]['sugu_sadalijums'] = "Sugu sadalījums, %";
$arr_transl[1]['kods'] = "Kods";
$arr_transl[1]['priede'] = "Priede";
$arr_transl[1]['egle'] = "Egle";
$arr_transl[1]['berzs'] = "Bērzs";
$arr_transl[1]['citas'] = "citas";
$arr_transl[1]['individualas_uzm_rezultats'] = "Individuālās uzm. rezultāts";
$arr_transl[1]['bruto_novirze'] = "Bruto novirze, %";
$arr_transl[1]['neto_novirze'] = "Neto novirze, %";
$arr_transl[1]['individualas_uzmerisanas_analize'] = "Individuālās uzmērīšanas analīze";
$arr_transl[1]['bruto_tilpums'] = "Bruto tilpums, m3";
$arr_transl[1]['sortimenta_skaits'] = "Sortimenta skaits, gab.";
$arr_transl[1]['brakis_redukcija'] = "Brāķis/redukcija, m3";
$arr_transl[1]['aritmetiskais_videjais_diametrs'] = "Aritmētiskais vidējais diametrs, cm";
$arr_transl[1]['neto_tilpums'] = "Neto tilpums, m3";
$arr_transl[1]['aritmetiskais_videjais_garums'] = "Aritmētiskais vidējais garums, dm";
$arr_transl[1]['standarts_metode'] = "Standarts/metode";
$arr_transl[1]['pirmo_sortimentu_tilpums'] = "Pirmo sortimentu tilpums, %";
$arr_transl[1]['bruto_tilpuma_sadalijums_pa_klasem'] = "Bruto tilpuma sadalījums pa klasēm";
$arr_transl[1]['diametra_klase'] = "Diametra klase, cm";
$arr_transl[1]['kopa'] = "Kopā";
$arr_transl[1]['tilpums'] = "Tilpums, %";
$arr_transl[1]['skaits'] = "Skaits, gab.";
$arr_transl[1]['braka_redukcijas_tilpuma_sadalijums_pa_braka_kodiem'] = "Brāķa/redukcijas tilpuma sadalījums pa brāķa kodiem";
$arr_transl[1]['braka_kods'] = "Brāķa kods";
$arr_transl[1]['redukcija'] = "Redukcija";
$arr_transl[1]['neto_tilpuma_sadalijums_pa_sugam'] = "Neto tilpuma sadalījums pa sugām";
$arr_transl[1]['suga'] = "Suga";
$arr_transl[1]['citas_cl'] = "Citas";
$arr_transl[1]['neto_tilpuma_sadalijums_pa_skiram'] = "Neto tilpuma sadalījums pa šķirām";
$arr_transl[1]['skira'] = "Šķira";
$arr_transl[1]['piezimes'] = "Piezīmes";
$arr_transl[1]['kontrolmeritajs'] = "Kontrolmērītājs";
$arr_transl[1]['num'] = "Nr.";
$arr_transl[1]['sia_vmf_latvia_valdes_loceklis'] = "SIA VMF LATVIA valdes priekšsēdētājs _________________________________________ /Jānis Buļs/";
$arr_transl[1]['merijums_veikts'] = "Mērījums veikts SIA VMF LATVIA";
$arr_transl[1]['reg_num'] = "Reģ.nr.: 40003405130";
$arr_transl[1]['skaistkalnes_iela'] = "Skaistkalnes iela 1, Rīga, LV-1004";
$arr_transl[1]['talrunis'] = "Tālrunis +371 29470949; Fakss +371 67223718; e-pasts vmflatvia@vmf.lv";
//-----------------------------------------------------------------------------------------------------------------
$arr_transl[2]['vmf_mi'] = "VMF MI P 04.02.05. E";
$arr_transl[2]['variants'] = "1.version";
$arr_transl[2]['vmf_datums'] = "29.11.2010";
$arr_transl[2]['krautnes_un_individualas_uzmērisanas_salidzinajums'] = "Comparison of individual and stack measurement";
$arr_transl[2]['krautnes_uzmerisana'] = "Stack measurement (K - measurement)";
$arr_transl[2]['pakas_identif'] = "Identif. number of pack";
$arr_transl[2]['sortiments'] = "Assortment";
$arr_transl[2]['pasutitajs'] = "Customer";
$arr_transl[2]['kolektivs'] = "Collective";
$arr_transl[2]['kontrolmerijuma_vieta'] = "Place of controlmeasurement";
$arr_transl[2]['gredas_nr_uz_autotransp'] = "Number of pile on truck";
$arr_transl[2]['kontrolmerijuma_datums'] = "Date of controlmeasurement";
$arr_transl[2]['kontrolpakas_izveles_datums'] = "Date of controlpack";
$arr_transl[2]['kraujmera_uzmerisanas_rezultats'] = "Result of stack measurement";
$arr_transl[2]['platums'] = "Width,";
$arr_transl[2]['augstums'] = "Height,";
$arr_transl[2]['garums'] = "Length,";
$arr_transl[2]['steri'] = "Stacks,";
$arr_transl[2]['koef'] = "K, %";
$arr_transl[2]['bruto_tilp'] = "Gross vol";
$arr_transl[2]['brakis'] = "Reject";
$arr_transl[2]['neto_tilp'] = "Net vol";
$arr_transl[2]['sugu_sadalijums'] = "Distribution of species, %";
$arr_transl[2]['kods'] = "Code";
$arr_transl[2]['priede'] = "Pine";
$arr_transl[2]['egle'] = "Spruce";
$arr_transl[2]['berzs'] = "Birch";
$arr_transl[2]['citas'] = "Other";
$arr_transl[2]['individualas_uzm_rezultats'] = "Result of indiv.measurement";
$arr_transl[2]['bruto_novirze'] = "Gross deviation, %";
$arr_transl[2]['neto_novirze'] = "Net deviation, %";
$arr_transl[2]['individualas_uzmerisanas_analize'] = "Analyze of individual measurement";
$arr_transl[2]['bruto_tilpums'] = "Gross volume, m3";
$arr_transl[2]['sortimenta_skaits'] = "Amount of assortment, pcs";
$arr_transl[2]['brakis_redukcija'] = "Reject/reduction, m3";
$arr_transl[2]['aritmetiskais_videjais_diametrs'] = "Arithmetic average  of diameter, cm";
$arr_transl[2]['neto_tilpums'] = "Net volume, m3";
$arr_transl[2]['aritmetiskais_videjais_garums'] = "Arithmetic average  of length, dm";
$arr_transl[2]['standarts_metode'] = "Standard/method";
$arr_transl[2]['pirmo_sortimentu_tilpums'] = "Volume of first assortments, %";
$arr_transl[2]['bruto_tilpuma_sadalijums_pa_klasem'] = "Distribution of gross volume according classes";
$arr_transl[2]['diametra_klase'] = "Diameter class, cm";
$arr_transl[2]['kopa'] = "Total";
$arr_transl[2]['tilpums'] = "Volume, %";
$arr_transl[2]['skaits'] = "Amount, pcs";
$arr_transl[2]['braka_redukcijas_tilpuma_sadalijums_pa_braka_kodiem'] = "Distribution of reject/reduction volume according reject codes";
$arr_transl[2]['braka_kods'] = "Reject  code";
$arr_transl[2]['redukcija'] = "Reduction";
$arr_transl[2]['neto_tilpuma_sadalijums_pa_sugam'] = "Distribution of net volume according species";
$arr_transl[2]['suga'] = "Species";
$arr_transl[2]['citas_cl'] = "Other";
$arr_transl[2]['neto_tilpuma_sadalijums_pa_skiram'] = "Distribution of net volume according sorts";
$arr_transl[2]['skira'] = "Sort";
$arr_transl[2]['piezimes'] = "Remarks";
$arr_transl[2]['kontrolmeritajs'] = "Controlmeasurer";
$arr_transl[2]['num'] = "No.";
$arr_transl[2]['sia_vmf_latvia_valdes_loceklis'] = "SIA VMF LATVIA chairman of the board ______________________________________________ /Jānis Buļs/";
$arr_transl[2]['merijums_veikts'] = "Measurement done by SIA VMF LATVIA";
$arr_transl[2]['reg_num'] = "Reg.no.: 40003405130";
$arr_transl[2]['skaistkalnes_iela'] = "Skaistkalnes iela 1, Rīga, LV-1004";
$arr_transl[2]['talrunis'] = "Phone +371 29470949; Fax +371 67223718; e-mail vmflatvia@vmf.lv";
//-----------------------------------------------------------------------------------------------------------------

$rtiesibas = mysql_query(" select * from lietotaji where id = ".$lietotajs_id);
$mtiesibas = mysql_fetch_array($rtiesibas);
$sagat_vards = $mtiesibas['vards'];
$sagat_uzvards = $mtiesibas['uzvards'];
$tel_nr = $mtiesibas['telefons'];

function get_KontrolMesurer($mernieks){
  $sql_Query_txt = "SELECT `vards`, `uzvards` FROM `lietotaji` WHERE `login` = '$mernieks'";
  $sql_Query = mysql_query($sql_Query_txt);
  while($sql_Query_arr = mysql_fetch_assoc($sql_Query)){
    $result = $sql_Query_arr['vards']." ".$sql_Query_arr['uzvards'];
  }
  return $result;
}

function tilpums ($metode,$d1,$d2,$lx)
{
	$lx = $lx / 10;
	$tilp = 0;
	if ($d1 > $d2)
	{
		$c = $d1;
		$d1 = $d2;
		$d2 = $c;
	}
	if ($metode == 1)
	{
//    echo $metode;
		$tilp = (3.1416 * ( (($d1 + 0.5) * ($d1 + 0.5)) + (($d2 + 0.5) * ($d2 + 0.5)) ) * $lx)/(4 * 2 * 10000);
	}
	if ($metode == 2)
	{
		$lx = $lx * 10;
		// $d1 - > cm
		// $d2 - > cm
		// $lx - > dm
		
		if ($d1 <= 14)
		{
			if ($lx <= 349) $alfa = 0.485;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.485;
			if ($lx >= 450) $alfa = 0.485;
		}
		if ($d1 >= 15 and $d1 <= 24)
		{
			if ($lx <= 349) $alfa = 0.465;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.460;
			if ($lx >= 450) $alfa = 0.455;
		}
		if ($d1 >= 25)
		{
			if ($lx <= 349) $alfa = 0.440;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.430;
			if ($lx >= 450) $alfa = 0.420;
		}
		$tilp = (3.1416/4) * ($lx + 0.5) * (($alfa * ($d2 + 0.5) * ($d2 + 0.5 )) + ((1 - $alfa) * ($d1 + 0.5) * ($d1 + 0.5))) / 100000;
		//echo "(" . $tilp . "," . ($d2) . "," . ($d1) . "," . (($alfa * ($d2 + 0.5) * ($d2 + 0.5 )) + ((1 - $alfa) * ($d1 + 0.5) * ($d1 + 0.5))) . ")";
	}
	
	if ($metode == 3)
	{
//    echo $metode;
		$tilp = ((3.14/16)  * $lx * ( (($d1 + 0.5) + ($d2 + 0.5)) * (($d1 + 0.5) + ($d2 + 0.5)))) / 10000;
//		$tilp = round($tilp,3);
	}
	
	$tilp = number_format($tilp, 3, '.', '');
	return $tilp;
}

$darba_id = $_GET['darba_id'];

if ($_GET['darba_id']) $darba_id = $_GET['darba_id'];
$m = mysql_fetch_array(mysql_query(" select * from papirmalka where id = $darba_id "));
$nr=$m['nr'];
$me=$m['me'];
$so=$m['so'];
$sg=$m['sg'];
$pk=$m['pk'];
$rn=$m['rn'];
$ag=$m['ag'];
$gr=$m['gr'];
$pl=$m['pl'];
$ti=$m['ti'];
$bk=$m['bk'];
$bp=$m['bp'];
$sk1=$m['sk1'];
$si1=$m['si1'];
$sk2=$m['sk2'];
$si2=$m['si2'];
$sk3=$m['sk3'];
$si3=$m['si3'];
$ts=$m['ts'];
$te=$m['te'];
//$metode=$m['metode'];
$doc_nr=$m['doc_nr'];
//$bt=number_format($ag*$pl*$gr/1000000,2);
//$nt=number_format($bt*$ti/100,2);

 $pa_klasem = array(); 
 $pa_b_kodiem = array();
 $pa_sugam = array();

$pa_klasem_kopa_t0 = 0;
$pa_b_kodiem_kopa_t0 = 0;
$pa_sugam_kopa_t0 = 0;
$pa_skiram_kopa_t0 = 0;
$pirma_sortimenta_t0 = 0;

$test = 0;

$skaits_kopa = 0;
$diam_summa = 0;
$gar_summa = 0;
echo $darba_id;
$ra = mysql_query("select * from papirmalka_merijumi where papirmalka_id = $darba_id and anuled <> 1 order by id");
while ($ma = mysql_fetch_array($ra))
{
	$merijumi = $i;
	$sx=$ma['sx']; //suga
	$kx=$ma['kx']; //shkjira
	$bx=$ma['bx']; //braakja kods
	$d1=$ma['dl']; //caurmeers tievgala
	$lx=$ma['lx']; //garums
	$d2=$ma['d2']; //caurmeers resgala
	$rx=$ma['rx']; //?rezgalis?
	$re=$ma['re']; //redukcija
	$kb=$ma['kb'];
	
	$diam_summa = $diam_summa + $d1 + $d2;
	$gar_summa = $gar_summa + $lx;

	//echo tilpums($metode,$d1,$d2,$lx)." ".$d1." ".$lx." ".$d2."<br>"; //metode".$metode."<br>";
	$tmp_tilpums_nosacits = tilpums($metode,$d1,$d2,$lx);
	$tmp_bruto_tilpums = $tmp_bruto_tilpums + $tmp_tilpums_nosacits;
  if($kx == 9){
    $tmp_brakis_tilpums = $tmp_brakis_tilpums + $tmp_tilpums_nosacits;
  }else{
    $tmp_neto_tilpums = $tmp_neto_tilpums + ($tmp_tilpums_nosacits - ($re * 0.0025));
    $tmp_brakis_tilpums = $tmp_brakis_tilpums + ($tmp_tilpums_nosacits + ($re * 0.0025));
  }

	if ($d1 > $d2)
	{
		$c = $d1;
		$d1 = $d2;
		$d2 = $c;
	}
	
	//echo "d1->".$d1."<-d1<br>";
	
	// pirmo sortimentu tilpums
	if ($rx == 1)
	{
		$pirma_sortimenta_t0 = $pirma_sortimenta_t0 + tilpums($metode,$d1,$d2,$lx);
	}

	// bruto tilpuma sadaliijums pa klaseem 
	if ($d1 <= 7)
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[1]['tilpums']=$pa_klasem[1]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[1]['skaits']=$pa_klasem[1]['skaits']+1;
	}
	if (($d1 >= 8 and $d1 <= 10))
	{	
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[2]['tilpums']=$pa_klasem[2]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[2]['skaits']=$pa_klasem[2]['skaits']+1;
	}
	if (($d1 >= 11 and $d1 <= 14))
	{	
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[3]['tilpums']=$pa_klasem[3]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[3]['skaits']=$pa_klasem[3]['skaits']+1;
	}
	if (($d1 >= 15 and $d1 <= 17))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[4]['tilpums']=$pa_klasem[4]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[4]['skaits']=$pa_klasem[4]['skaits']+1;
	}
	if (($d1 >= 18 and $d1 <= 19))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[5]['tilpums']=$pa_klasem[5]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[5]['skaits']=$pa_klasem[5]['skaits']+1;
	}
	if (($d1 >= 20 and $d1 <= 24))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[6]['tilpums']=$pa_klasem[6]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[6]['skaits']=$pa_klasem[6]['skaits']+1;
	}
	if (($d1 >= 25 and $d1 <= 29))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[7]['tilpums']=$pa_klasem[7]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[7]['skaits']=$pa_klasem[7]['skaits']+1;
	}
	if (($d1 >= 30 and $d1 <= 34))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[8]['tilpums']=$pa_klasem[8]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[8]['skaits']=$pa_klasem[8]['skaits']+1;
	}
	if ($d1 >= 35)
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[9]['tilpums']=$pa_klasem[9]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[9]['skaits']=$pa_klasem[9]['skaits']+1;
	}




	//brāķa/redukcijas tilpuma sadaliijums pa braakja kodiem

	if ($kx == 9 and !$re) //skira
	{
		for ($i=0; $i<= 9;$i++)
		{
			if ($bx == $i) //braka kods
			{
				$pa_b_kodiem_kopa_t0 = $pa_b_kodiem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_b_kodiem[$i]['tilpums']=$pa_b_kodiem[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_b_kodiem[$i]['skaits']=$pa_b_kodiem[$i]['skaits']+1;
			}
		}
	}

	if ($kx < 9)
	{
		if (!$re)
		{
			//NAV
		}
		if ($re > 0)
		{
			//echo 'red = ' . $re;
			//echo 'tilpums = ' . tilpums($metode,$d1,$d2,$lx);

			//tilpums($metode,$d1,$d2,$lx) * 
			$pa_b_kodiem_kopa_t0 = $pa_b_kodiem_kopa_t0 + ($re * 0.0025);
			//echo 'kopā redukcija = ' . $pa_b_kodiem_kopa_t0;

			//tilpums($metode,$d1,$d2,$lx) * 
			$pa_b_kodiem[10]['tilpums']=$pa_b_kodiem[10]['tilpums']+($re * 0.0025);
			$pa_b_kodiem[10]['skaits']=$pa_b_kodiem[10]['skaits']+1;
		}
	}

	//neto tilpuma sadalījums pa sugām
	//echo $sx;

	if ($kx < 9) //skira
	{
		if (!$re) 
		{	
			$ir_kods = 0;
			for ($i=1; $i<= 9;$i++)
			{
				if ($sx == $i) //suga
				{
					$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
					$pa_sugam[$i]['tilpums']=$pa_sugam[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
					$pa_sugam[$i]['skaits']=$pa_sugam[$i]['skaits']+1;
					$ir_kods = 1;
				}
			}
			if ($ir_kods == 0)
			{
				$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_sugam[10]['tilpums']=$pa_sugam[10]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_sugamm[10]['skaits']=$pa_sugam[10]['skaits']+1;	
			}
		}

		if ($re > 0)
		{
			$ir_kods = 0;
			for ($i=1; $i<= 9;$i++)
			{
				if ($sx == $i)
				{
					//tilpums($metode,$d1,$d2,$lx) * 
					if ((tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025)) < 0)
					{echo "KLUDA";}

					//tilpums($metode,$d1,$d2,$lx) * 
					$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
					//tilpums($metode,$d1,$d2,$lx) * 
					$pa_sugam[$i]['tilpums']=$pa_sugam[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
					$pa_sugam[$i]['skaits']=$pa_sugam[$i]['skaits']+1;
					$ir_kods = 1;
				}
			}
			if ($ir_kods == 0)
			{
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_sugam[10]['tilpums']=$pa_sugam[10]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				$pa_sugamm[10]['skaits']=$pa_sugam[10]['skaits']+1;	
			}
		}
	}

	//neto tilpuma sadalījums pa šķirām
	//echo $sx;

	//echo $kx . '/';
	//echo $re . '/';

	if (!$re) 
	{	
		for ($i=1; $i<= 8;$i++)
		{
			if ($kx == $i) //skira
			{
				$pa_skiram_kopa_t0 = $pa_skiram_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_skiram[$i]['tilpums']=$pa_skiram[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_skiram[$i]['skaits']=$pa_skiram[$i]['skaits']+1;
				$ir_kods = 1;
			}
		}
	}
	if ($re > 0)
	{
		for ($i=1; $i<= 9;$i++)
		{
			if ($kx == $i)
			{
				//tilpums($metode,$d1,$d2,$lx) * 
				if ((tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025)) < 0)
				{echo "KLUDA";}
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_skiram_kopa_t0 = $pa_skiram_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_skiram[$i]['tilpums']=$pa_skiram[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				$pa_skiram[$i]['skaits']=$pa_skiram[$i]['skaits']+1;
				$ir_kods = 1;
			}
		}
	}

	$skaits_kopa++;
}
$tmp_bruto_tilpums = number_format(round($tmp_bruto_tilpums,2), 2, '.', '');
$tmp_brakis_tilpums = number_format(round($tmp_bruto_tilpums - $tmp_neto_tilpums,2), 2, '.', '');
$tmp_neto_tilpums = number_format(round($tmp_neto_tilpums,2), 2, '.', '');
$tmp_brakis_procents = round((($tmp_bruto_tilpums - $tmp_neto_tilpums) / $tmp_bruto_tilpums) * 100,2);
$tmp_brakis_procents = number_format($tmp_brakis_procents, 2, '.', '');


$vid_diam = $diam_summa / ($skaits_kopa * 2);
$vid_gar = $gar_summa / $skaits_kopa;

$liel_b_kods = 0;
$liel_b_tilpums = 0;
for ($i = 0; $i<10; $i++)
{
	if ($pa_b_kodiem[$i]['tilpums'] > $liel_b_tilpums){
		$liel_b_tilpums = $pa_b_kodiem[$i]['tilpums'];
		$liel_b_kods = $i;
	}
}


//print_r($pa_b_kodiem);
//die($liel_b_kods);

//echo " kopaa ".$test;

//echo "<br>V kopa =".$test."<br>";
//echo "V bruto = ".$pa_klasem_kopa_t0."<br>";
//echo "V br/red = ".$pa_b_kodiem_kopa_t0."<br>";
//echo "V neto = ".$pa_sugam_kopa_t0."<br>";
// echo "sk = ".$skaits_kopa."<br><br>";
// echo "pa sugam: ";
// print_r($pa_sugam);
// echo "<br><br>";
// echo "pa b dodiem: ";
// print_r($pa_b_kodiem);
// echo "<br><br>";
// echo "pa klasem: ";
// print_r($pa_klasem);
// echo "<br><br>";
// echo tilpums(1,7,7,3);
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
<link rel=File-List href="./papirmalka_atskaite_files/filelist.xml">
<link rel=Edit-Time-Data href="./papirmalka_atskaite_files/editdata.mso">
<link rel=OLE-Object-Data href="./papirmalka_atskaite_files/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:LastAuthor>mariz</o:LastAuthor>
  <o:LastPrinted>2006-01-17T12:47:16Z</o:LastPrinted>
  <o:Created>2006-01-16T14:24:20Z</o:Created>
  <o:LastSaved>2006-01-17T12:56:11Z</o:LastSaved>
  <o:Version>9.3821</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:DownloadComponents/>
  <o:LocationOfComponents HRef="file:///D:/msowc.cab"/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:" ";}
@page
	{margin:.38in .0in .38in .45in;
	mso-header-margin:.51in;
	mso-footer-margin:.51in;}
tr
	{mso-height-source:auto;}
col
	{mso-width-source:auto;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
.style092
	{mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:8.5pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
tds
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl24
	{mso-style-parent:style0;
	text-align:right;}
.xl25
	{mso-style-parent:style0;
	text-align:center;}
.xl26
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl27
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl28
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl29
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl30
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl31
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl32
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl33
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl34
	{mso-style-parent:style0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl35
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl36
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl37
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl38
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl39
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl40
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl41
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl42
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl43
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl44
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl45
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl46
	{mso-style-parent:style0;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl47
	{mso-style-parent:style0;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl48
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl49
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl50
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	white-space:normal;}
.xl51
	{mso-style-parent:style0;
	text-align:center;	
	border:.5pt solid windowtext;}
.xl52
	{mso-style-parent:style0;
	font-size:13.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl53
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl54
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl55
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl56
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl57
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl58
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl59
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl60
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl61
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl62
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl63
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl64
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl65
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl66
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl67
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl68
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl69
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid black;}
.xl70
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl71
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl72
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl73
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl74
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl75
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid windowtext;}
.xl76
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl77
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl78
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl79
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl80
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl81
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl82
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl83
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl84
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;}
.xl85
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid windowtext;}
.xl86
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;}
.xl87
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;}
.xl88
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl89
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl90
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl91
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl92
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl93
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl94
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl95
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl96
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl97
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl98
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid black;}
.xl99
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl100
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl101
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl102
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl103
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl104
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl105
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl106
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl107
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl108
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl109
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl110
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl111
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl112
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl113
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	white-space:normal;}
.xl114
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	white-space:normal;}
.xl115
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl116
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	white-space:normal;}
.xl117
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	white-space:normal;}
.xl118
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl119
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl444
	{mso-style-parent:style092;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl445
	{mso-style-parent:style0;
	font-size:10.0pt;
	mso-number-format:"0\.000";
	text-align:center;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	white-space:nowrap;
	mso-text-control:shrinktofit;}
.xl446
	{mso-style-parent:style0;
	mso-number-format:fixed;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl447
	{mso-style-parent:style0;
	mso-number-format:fixed;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid black;}
.xl448
	{mso-style-parent:style0;
	mso-number-format:fixed;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl449
	{mso-style-parent:style0;
	mso-number-format:fixed;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl450
	{mso-style-parent:style0;
	mso-number-format:fixed;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl451
	{mso-style-parent:style0;
	mso-number-format:fixed;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
   
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>papirmalka 1 </x:Name>
    <x:WorksheetOptions>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:Scale>97</x:Scale>
      <x:HorizontalResolution>204</x:HorizontalResolution>
      <x:VerticalResolution>196</x:VerticalResolution>
      <x:NumberofCopies>0</x:NumberofCopies>
     </x:Print>
     <x:PageBreakZoom>60</x:PageBreakZoom>
     <x:Selected/>
     <x:DoNotDisplayGridlines/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>1</x:ActiveRow>
       <x:RangeSelection>A2:G2</x:RangeSelection>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>9345</x:WindowHeight>
  <x:WindowWidth>14220</x:WindowWidth>
  <x:WindowTopX>360</x:WindowTopX>
  <x:WindowTopY>60</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>
<table x:str border=0 cellpadding=0 cellspacing=0 width=653 style='border-collapse:collapse;table-layout:fixed;width:463pt'>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['vmf_mi']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['variants']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['vmf_datums']?></td></tr>
 <tr height=49 style='mso-height-source:userset;height:16.75pt'>
  <td colspan=10 height=49 class=xl52 width=506 style='height:16.75pt;width:382pt'><?=$arr_transl[$tmp_lang]['krautnes_un_individualas_uzmērisanas_salidzinajums']?></td>
  <td class=xl24 width=49 style='width:37pt'><?=$arr_transl[$tmp_lang]['num']?></td>
  <td colspan=2 width=98 style='width:74pt'><?=substr($te,8,2)?>/</td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:16.0pt'>
  <td colspan=7 height=40 class=xl53 style='height:16.0pt'><?=$arr_transl[$tmp_lang]['krautnes_uzmerisana']?></td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td colspan=4 height=16 class=xl54 style='border-right:.5pt solid black;
  height:12.0pt'><?=$arr_transl[$tmp_lang]['pakas_identif']?></td>
  <td colspan=3 class=xl57 x:num style='border-right:1.0pt solid black;border-left:
  none'><?=$m['nr']//#pakas_nr
  ?> 
  </td>
  <td></td>
  <td colspan=3 class=xl54 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['sortiments']?></td>
  <td colspan=2 class=xl59 x:num style='border-right:1.0pt solid black;border-left:
  none'><?=$m['so']?></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td colspan=4 height=16 class=xl60 style='border-right:1.0pt solid black;
  height:12.0pt'><?=$arr_transl[$tmp_lang]['pasutitajs']?></td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black;border-left:
  none'><!--#pasutitajs#--></td>
  <td></td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['kolektivs']?></td>
  <td colspan=2 class=xl64 style='border-right:1.0pt solid black;border-left:
  none'><!--#kolektivs#--></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl60 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['kontrolmerijuma_vieta']?></td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black;border-left:
  none'><!--#vieta--></td>
  <td></td>
  <td colspan=3 class=xl65 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['gredas_nr_uz_autotransp']?></td>
  <td colspan=2 class=xl69 style='border-right:1.0pt solid black;border-left:
  none'><!--#gredasnr#--></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['kontrolmerijuma_datums']?></td>
  <td colspan=3 class=xl71 style='border-right:1.0pt solid black;border-left:
  none'><?=substr($te,0,10)?></td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
  <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['kontrolpakas_izveles_datums']?></td>
  <td colspan=3 class=xl71 style='border-right:1.0pt solid black;border-left:
  none'><?=substr($m['nr'],2,2)?>/<?=substr($m['nr'],4,2)?>/2013</td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td colspan=6 height=27 class=xl73 style='height:20.25pt'><?=$arr_transl[$tmp_lang]['kraujmera_uzmerisanas_rezultats']?></td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td class=xl26><?=$arr_transl[$tmp_lang]['platums']?></td>
  <td class=xl26><?=$arr_transl[$tmp_lang]['augstums']?></td>
  <td class=xl26><?=$arr_transl[$tmp_lang]['garums']?></td>
  <td class=xl26><?=$arr_transl[$tmp_lang]['steri']?></td>
  <td rowspan=2 class=xl78 style='border-bottom:1.0pt solid black;border-top:none'><?=$arr_transl[$tmp_lang]['koef']?></td>
  <td class=xl26><?=$arr_transl[$tmp_lang]['bruto_tilp']?></td>
  <td colspan=2 class=xl80 style='border-right:.5pt solid black;border-left:
  none'><?=$arr_transl[$tmp_lang]['brakis']?></td>
  <td class=xl27><?=$arr_transl[$tmp_lang]['neto_tilp']?></td>
  <td colspan=4 rowspan=2 class=xl82 style='border-right:1.0pt solid black;border-bottom:.5pt solid black'><?=$arr_transl[$tmp_lang]['sugu_sadalijums']?></td>
 </tr>
 <tr class=xl25 height=18 style='mso-height-source:userset;height:13.5pt'>
  <td height=18 class=xl28 style='height:13.5pt'>cm</td>
  <td height=18 class=xl28 style='height:13.5pt'>cm</td>
  <td height=18 class=xl28 style='height:13.5pt'>cm</td>
  <td height=18 class=xl28 style='height:13.5pt'>m3</td>
  <td height=18 class=xl28 style='height:13.5pt'>m3</td>
  <td class=xl28><?=$arr_transl[$tmp_lang]['kods']?></td>
  <td class=xl28>%</td>
  <td class=xl29>m3</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl30 style='height:12.75pt' x:num><?=$pl?></td>
  <td class=xl31 x:num><?=$ag?></td>
  <td class=xl31 x:num><?=$gr?></td>
  <td class=xl445 x:num x:fmla="=ROUND(A14*B14*C14%%%,3)"><!--#Steri#--></td>
  <td class=xl31 x:num><?=$ti?></td>
  <? if($metode_tmp == 1){ ?>
    <td class=xl451 x:num x:fmla="=ROUND(A14*B14*C14*E14%%%%,2)"><!--#kbrut#--></td>
  <? }else{ ?>
    <td class=xl451 x:num x:fmla="=ROUND(A14*B14*C14*E14%%%%,2)"><!--#kbrut#--></td>
  <? } ?>
  <td class=xl31 x:num><?=$bk?></td>
  <td class=xl451 x:num><?=$bp?></td>
  <? if($metode_tmp == 1){ ?>
    <td class=xl451 x:num x:fmla="=ROUND(F14-(F14*H14%),2)"><!--#knet#--></td>
  <? }else{ ?>
    <td class=xl451 x:num x:fmla="=ROUND(F14-(F14*H14%),2)"><!--#knet#--></td>
  <? } ?>
  <td rowspan=2 class=xl88 style='border-bottom:1.0pt solid black;border-top:
  none'><?=$arr_transl[$tmp_lang]['priede']?></td>
  <td rowspan=2 class=xl89 style='border-bottom:1.0pt solid black;border-top:
  none'><?=$arr_transl[$tmp_lang]['egle']?></td>
  <td rowspan=2 class=xl89 style='border-bottom:1.0pt solid black;border-top:
  none'><?=$arr_transl[$tmp_lang]['berzs']?></td>
  <td rowspan=2 class=xl90 style='border-bottom:1.0pt solid black;border-top:
  none'><?=$arr_transl[$tmp_lang]['citas']?></td>
 </tr>
 <tr height=5 style='mso-height-source:userset;height:3.75pt'>
  <td height=5 class=xl34 style='height:3.75pt'>&nbsp;</td>
  <td colspan=3 style='mso-ignore:colspan'></td>
  <td class=xl35>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl92 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['individualas_uzm_rezultats']?></td>
  <td class=xl37><!--#kind#--></td>
  <? if($metode_tmp == 1){ ?>
    <td class=xl448 x:num><?=$tmp_bruto_tilpums?></td>
  <? }else{ ?>
    <td class=xl448 x:num><?=$tmp_bruto_tilpums?></td>
  <? } ?>
  <td class=xl31 x:num><?=$liel_b_kods?></td>
  <td class=xl448 x:num><?=$tmp_brakis_procents?></td>
  <? if($metode_tmp == 1){ ?>
    <td class=xl448 x:num><?=$tmp_neto_tilpums?></td>
  <? }else{?>
    <td class=xl448 x:num><?=$tmp_neto_tilpums?></td>
  <? } ?>
  <td class=xl40 x:num><?=number_format(($pa_sugam[1]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- priede -->
  <td class=xl40 x:num><?=number_format(($pa_sugam[2]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- egle -->
  <td class=xl40 x:num><?=number_format(($pa_sugam[4]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- berzs -->
  <td class=xl41 x:num><?=number_format((($pa_sugam_kopa_t0 - $pa_sugam[1]['tilpums'] - $pa_sugam[2]['tilpums'] - $pa_sugam[4]['tilpums'])/ $pa_sugam_kopa_t0 * 100),1,'.','')?></td> <!-- citi -->
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 colspan=13 style='height:9.0pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl95 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['bruto_novirze']?></td>
  <td colspan=3 x:num class=xl447 style='border-right:1.0pt solid black;border-left:none' x:fmla="=ROUND(F14/F16*100-100,2)"><!--#bnovirze#--></td>
  <td></td>
  <td colspan=2 class=xl92 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['neto_novirze']?></td>
  <td colspan=2 class=xl447 style='border-right:1.0pt solid black;border-left:none' x:num x:fmla="=ROUND(I14/I16*100-100,2)"><!--#nnovirze#--></td>
  <td colspan=3 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 colspan=13 style='height:9.0pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=6 height=17 class=xl100 style='height:12.75pt'><?=$arr_transl[$tmp_lang]['individualas_uzmerisanas_analize']?></td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl54 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['bruto_tilpums']?></td>
  <? if($metode_tmp == 1){ ?>
    <td colspan=3 class=xl449 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_bruto_tilpums?></td>
  <? }else{ ?>
    <td colspan=3 class=xl449 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_bruto_tilpums?></td>
  <? } ?>
  <td></td>
  <td colspan=4 class=xl54 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['sortimenta_skaits']?></td>
  <td colspan=3 class=xl59 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=$skaits_kopa?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['brakis_redukcija']?></td>
  <? if($metode_tmp == 1){ ?>
    <td colspan=3 class=xl450 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_brakis_tilpums?></td>
  <? }else{ ?>
    <td colspan=3 class=xl450 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_brakis_tilpums?></td>
  <? } ?>
  <td></td>
  <td colspan=4 class=xl60 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['aritmetiskais_videjais_diametrs']?></td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($vid_diam,3,'.','')?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['neto_tilpums']?></td>
  <? if($metode_tmp == 1){ ?>
    <td colspan=3 class=xl450 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_neto_tilpums?></td>
  <? }else{ ?>
    <td colspan=3 class=xl450 style='border-right:1.0pt solid black;border-left:none' x:num><?=$tmp_neto_tilpums?></td>
  <? } ?>
  <td></td>
  <td colspan=4 class=xl60 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['aritmetiskais_videjais_garums']?></td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($vid_gar,3,'.','')?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['standarts_metode']?></td>
  <td colspan=3 class=xl69 style='border-right:1.0pt solid black;border-left:
  none' x:num><? if ($_POST['metode_id'] == 1) {echo "LVS 82:2003 (1.3)";} elseif($_POST['metode_id'] == 2) {echo "VMR 1-06 (4.3)";} else {echo "СТБ 1667-2012 (4.5)";} ?></td>
  <td></td>
  <td colspan=4 class=xl71 style='border-right:1.0pt solid black'><?=$arr_transl[$tmp_lang]['pirmo_sortimentu_tilpums']?></td>
  <td colspan=3 class=xl69 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format(($pirma_sortimenta_t0 / $pa_klasem_kopa_t0) * 100,1,'.','')?></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td colspan=6 height=27 class=xl101 style='height:20.25pt'><?=$arr_transl[$tmp_lang]['bruto_tilpuma_sadalijums_pa_klasem']?></td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=3 height=18 class=xl102 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['diametra_klase']?></td>
  <td class=xl42>&lt;7</td>
  <td class=xl42><span style="mso-spacerun: yes"> </span>8-10</td>
  <td class=xl42><span style="mso-spacerun: yes"> </span>11-14</td>
  <td class=xl43><span style="mso-spacerun: yes"> </span>15-17</td>
  <td class=xl43><span style="mso-spacerun: yes"> </span>18-19</td>
  <td class=xl43>20-24</td>
  <td class=xl43>25-29</td>
  <td class=xl43>30-34</td>
  <td class=xl43>35&gt;=</td>
  <td class=xl44>Kopā</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=3 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['tilpums']?></td>
  <? for ($i = 1; $i <= 9; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format(($pa_klasem[$i]['tilpums']/$pa_klasem_kopa_t0) * 100, 3, '.', '')?></td>
  <?
  $pa_klasem_kopa_t = $pa_klasem_kopa_t + $pa_klasem[$i]['tilpums']/$pa_klasem_kopa_t0 * 100;
  } ?>
  <td class=xl45 align=center x:num><?=$pa_klasem_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=3 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['skaits']?></td>
  <? for($i = 1; $i<= 9; $i++) { ?>
  <td class=xl31 align=center x:num><?=$pa_klasem[$i]['skaits']?></td>
  <? 
  $pa_klasem_kopa_s = $pa_klasem_kopa_s + $pa_klasem[$i]['skaits'];
  } ?>
   <td class=xl31 align=center x:num><?=$pa_klasem_kopa_s?></td>
 </tr>
 <tr height=39 style='mso-height-source:userset;height:29.25pt'>
  <td colspan=9 height=39 class=xl73 style='height:29.25pt'><?=$arr_transl[$tmp_lang]['braka_redukcijas_tilpuma_sadalijums_pa_braka_kodiem']?></td>
  <td colspan=5 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl105 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['braka_kods']?></td>
  <td class=xl42 x:num>0</td>
  <td class=xl42 x:num>1</td>
  <td class=xl42 x:num>2</td>
  <td class=xl42 x:num>3</td>
  <td class=xl42 x:num>4</td>
  <td class=xl42 x:num>5</td>
  <td class=xl42 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl43 x:num>9</td>
  <td class=xl47><?=$arr_transl[$tmp_lang]['redukcija']?></td>
  <td class=xl44><?=$arr_transl[$tmp_lang]['kopa']?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['tilpums']?></td>
  <?for ($i = 0; $i <= 10; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format($pa_b_kodiem[$i]['tilpums']/$pa_b_kodiem_kopa_t0 * 100, 3, '.', '')?></td>
  <?
  $pa_b_kodiem_kopa_t = $pa_b_kodiem_kopa_t + $pa_b_kodiem[$i]['tilpums']/$pa_b_kodiem_kopa_t0 * 100;
  } ?>
  <td class=xl49 x:num><?=$pa_b_kodiem_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['skaits']?></td>
  <?for ($i = 0; $i <= 10; $i++){ ?>
  <td class=xl28 x:num><?=$pa_b_kodiem[$i]['skaits']?></td>
  <?
  $pa_b_kodiem_kopa_s = $pa_b_kodiem_kopa_s + $pa_b_kodiem[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_b_kodiem_kopa_s?></td>
 </tr>
 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td colspan=6 height=34 class=xl73 style='height:25.5pt'><?=$arr_transl[$tmp_lang]['neto_tilpuma_sadalijums_pa_sugam']?></td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl109 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['suga']?></td>
  <td class=xl42 x:num>1</td>
  <td class=xl42 x:num>2</td>
  <td class=xl42 x:num>3</td>
  <td class=xl42 x:num>4</td>
  <td class=xl43 x:num>5</td>
  <td class=xl43 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl43 x:num>9</td>
  <td class=xl43 x:num><?=$arr_transl[$tmp_lang]['citas_cl']?></td>
  <td class=xl44><?=$arr_transl[$tmp_lang]['kopa']?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'>Tilpums, %</td>
  <? for ($i = 1; $i <= 10; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format(($pa_sugam[$i]['tilpums'] / $pa_sugam_kopa_t0 * 100),3,'.','')?></td>
  <?
   $pa_sugam_kopa_t =  $pa_sugam_kopa_t + $pa_sugam[$i]['tilpums'] / $pa_sugam_kopa_t0 * 100;
  } ?>
  <td class=xl49 x:num><?=$pa_sugam_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl110 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['skaits']?></td>
  <? for ($i = 1; $i <= 10; $i++)
  { ?>
  <td class=xl28 x:num><?=$pa_sugam[$i]['skaits']?></td>
  <?
  $pa_sugam_kopa_s = $pa_sugam_kopa_s + $pa_sugam[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_sugam_kopa_s?></td>
 </tr>

 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td colspan=6 height=34 class=xl73 style='height:25.5pt'><?=$arr_transl[$tmp_lang]['neto_tilpuma_sadalijums_pa_skiram']?></td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl109 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['skira']?></td>
  <td class=xl43 x:num>1</td>
  <td class=xl43 x:num>2</td>
  <td class=xl43 x:num>3</td>
  <td class=xl43 x:num>4</td>
  <td class=xl43 x:num>5</td>
  <td class=xl43 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl44><?=$arr_transl[$tmp_lang]['kopa']?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=4 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'><?=$arr_transl[$tmp_lang]['tilpums']?></td>
  <? for ($i = 1; $i <= 8; $i++) {
  if ($pa_skiram_kopa_t0 > 0) {
  ?>
  <td class=xl48 x:num><?=number_format(($pa_skiram[$i]['tilpums'] / $pa_skiram_kopa_t0 * 100),3,'.','')?></td>
  <?
   $pa_skiram_kopa_t =  $pa_skiram_kopa_t + $pa_skiram[$i]['tilpums'] / $pa_skiram_kopa_t0 * 100;
  } else {
	 ?>
	<td class=xl48 x:num>0</td>
	<?
	$pa_skiram_kopa_t = 0;
  }
  } ?>
  <td class=xl49 x:num><?=$pa_skiram_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl110 style='border-right:1.0pt solid black;
  height:13.5pt'><?=$arr_transl[$tmp_lang]['skaits']?></td>
  <? for ($i = 1; $i <= 8; $i++)
  { ?>
  <td class=xl28 x:num><?=$pa_skiram[$i]['skaits']?></td>
  <?
  $pa_skiram_kopa_s = $pa_skiram_kopa_s + $pa_skiram[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_skiram_kopa_s?></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 colspan=13 style='height:17.25pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'><?=$arr_transl[$tmp_lang]['piezimes']?></td>
  <td colspan=12 rowspan=2 class=xl112 width=597 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:451pt'><!--#piezimes#--></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'></td>
  <td colspan=12 class=xl50 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 style='border-right:.5pt solid black;height:12.75pt'><?=$arr_transl[$tmp_lang]['kontrolmeritajs']?></td>
  <td colspan=9 class=xl118 style='border-right:.5pt solid black;border-left:
  none'><?=get_KontrolMesurer($me)?></td>
  <td class=xl24><?=$arr_transl[$tmp_lang]['num']?></td>
  <td class=xl51 x:num><?=$me?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='font-size:8pt;height:12.75pt'>Sagatavoja </td>
  <td height=17 style='font-size:8pt;height:12.75pt'><?=$sagat_vards?> <?=$sagat_uzvards?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'><td colspan=2 height=17 style='font-size:8pt;height:12.75pt'><?=$tel_nr?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:30.75pt'><td colspan=13 height=17 style='height:12.75pt'><?=$arr_transl[$tmp_lang]['sia_vmf_latvia_valdes_loceklis']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:30.75pt'><td colspan=13 height=10 style='height:12.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['merijums_veikts']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['reg_num']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['skaistkalnes_iela']?></td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'><?=$arr_transl[$tmp_lang]['talrunis']?></td></tr>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=56 style='width:42pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
 </tr>
 <![endif]>
</table>
</body>

</html>

