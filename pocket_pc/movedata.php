<?
// pārnesam jaunos datus no fails_zbm uz pavadzime
// no fails_zbm_ui uz balkis

include '../connect.php';
include '../funkcijas.php';

//mysql_query("delete from pavadzime");
//mysql_query("update fails_zbm set export_id = 0");

//mysql_query("delete from balkis");
//mysql_query("update fails_zbm_ui set export_id = 0");

// jaunie ieraksti no fails_zbm
$zbm_id = $_GET['zbm_id'];
$round = $_GET['round'];
$r = mysql_query("select * from fails_zbm where id = ".$zbm_id." order by id");
while ($m = mysql_fetch_array($r))
{
	
	$metode = $m['metode'];
	// izdzēšam ierakstu kas jau tur varētu būt
	mysql_query ("delete from pavadzime where import_type = 'zbm' and import_id = ".$m['id']);
	mysql_query ("delete from batch_fails where import_type = 'zbm' and import_id = ".$m['id']);

	// insertējam jaunu ierakstu bačos
	mysql_query ("insert into batch_fails (nosaukums, datums, import_type, import_id) values ('".$m['pas_nos'].' '.$m['pavaddok']."', '".date('Y-m-d')."', 'zbm', ".$m['id'].") "); 

	//dabonam pēdējo baču
	$rid = mysql_query("select max(id) as x from batch_fails");
	$mid = mysql_fetch_array($rid);
	$new_id =$mid['x'];

	// insertējam jaunu ierakstu pavadzīmēs
	mysql_query ("insert into pavadzime (piegadataju_kods,batch_fails,piegad_grupa, kad_piegad, iecirknis, cirsmas_kods, fsc, pavadzime, transp_darba_uzd, piegad_kods, iecirknis_pieg, attalums, auto, soferis, cenu_matrica, kravas_id, import_type, import_id) select pasutitajs, $new_id,'', '".sqltime(convert_time($m['started']))."', '', '', '', pavaddok, transp_darba_uzd, '', '', 0, autonr, sofer, '', '', 'zbm', id from fails_zbm where id = ".$m['id']);

	// dabonam jauno id
	$rid = mysql_query("select max(id) as x from pavadzime");
	$mid = mysql_fetch_array($rid);
	$new_id = $mid['x'];

	// updeitojam ierakstu ar jauno id
	mysql_query("update fails_zbm set export_id = ".$new_id." where id = ".$m['id']);
}

// jaunie ieraksti no fails_zbm_ui
$r = mysql_query("select * from fails_zbm_ui where fails_zbm_id = $zbm_id and anuled = 0 order by id");
while ($m = mysql_fetch_array($r))
{
	// izdzēšam ierakstu kas jau tur varētu būt
	mysql_query ("delete from balkis where import_id = ".$m['id']);

	// atrodam pārnestās pavadzīmes id
	$rpav = mysql_query("select * from fails_zbm where id = ".$m['fails_zbm_id']);
	$mpav = mysql_fetch_array($rpav);
	$pavadzime = $mpav['export_id'];

	// konvertējam brāķi
	$brakis = '255';
	$brakis2 = '255';
	$skira = $m['sk'];
	$skira2 = $m['sk2'];
	if ($m['sk']==9) // || $m['sk']==4 4. škira vairs nav brāķis
	{
		// brāķa gadījumā konvertējam iemeslus
		if ($m['im']==0) $brakis='000';
		if ($m['im']==1) $brakis='001';
		if ($m['im']==2) $brakis='002';
		if ($m['im']==3) $brakis='003';
		if ($m['im']==4) $brakis='004';
		if ($m['im']==5) $brakis='005';
		if ($m['im']==6) $brakis='006';
		if ($m['im']==7) $brakis='007';
		if ($m['im']==8) $brakis='008';
		if ($m['im']==9) $brakis='009';
		$skira = 9;
	}
	if ($m['sk2']==9) // || $m['sk']==4 4. škira vairs nav brāķis
	{
		// brāķa gadījumā konvertējam iemeslus
		if ($m['im2']==0) $brakis2='000';
		if ($m['im2']==1) $brakis2='001';
		if ($m['im2']==2) $brakis2='002';
		if ($m['im2']==3) $brakis2='003';
		if ($m['im2']==4) $brakis2='004';
		if ($m['im2']==5) $brakis2='005';
		if ($m['im2']==6) $brakis2='006';
		if ($m['im2']==7) $brakis2='007';
		if ($m['im2']==8) $brakis2='008';
		if ($m['im2']==9) $brakis2='009';
		$skira2 = 9;
	}

	if ($pavadzime)
	{
		// insertējam jaunu ierakstu
		/*
		if ($round == 'no') {
			$tievgala_caurmers = $m['tc'];
		} else {
		// noapaļojam caurmēru
		$tievgala_caurmers = floor($m['tc']/10)*10;
	
		// pieskaitam vidējo kļūdu
		$tievgala_caurmers = $tievgala_caurmers + 5;
		}
		*/
		
		if ($round != 'no') {
      $tievgala_caurmers = floor($m['tc']/10)*10;
      $tievgala_caurmers = $tievgala_caurmers + 5;
      
      $vidus_caurmers = floor($m['vc']/10)*10;
      $vidus_caurmers = $vidus_caurmers + 5;

      $resgala_caurmers = floor($m['rcc']/10)*10;
      $resgala_caurmers = $resgala_caurmers + 5;
		} else {
			$tievgala_caurmers = $m['tc'];
      $vidus_caurmers = $m['vc'];
      $resgala_caurmers = $m['rcc'];
		}

    if ($metode == '1') {
      mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc*10, gr-(rg*10), ".$vidus_caurmers.", '$brakis', ".$resgala_caurmers.", '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
  //		mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
    }elseif ($metode == '2') {
      mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$vidus_caurmers.", gr, sg, ".$skira.", '', ".$vidus_caurmers."-rc*10, gr-(rg*10), ".$tievgala_caurmers.", '$brakis', ".$resgala_caurmers.", '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
  //		mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
    }elseif ($metode == '3') {
      mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc*10, gr-(rg*10), ".$vidus_caurmers.", '$brakis', ".$resgala_caurmers.", '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
  //		mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
    }else {
	
			$myQ = mysql_fetch_assoc(mysql_query("select gr from fails_zbm_ui where id = ".$m['id']));
			$balkaGarums = $myQ['gr'];
			error_log("balka garums: ".$balkaGarums. " !!!!");
	//Izmaiņas kodā, lai realizētu jaunas Kurzemes Finiera prasības par izdalītiem īskluču tilpumiem.
	//Šeit tiks aprēķināti īskluču tilpumi un baļķa virsmērs. Tie tiks ievietoti tabulā "balkis"  - kolonnas "1_cilindra_tilpums", "2_cilindra_tilpums" un "virsmers"
			//Sagatavojam mainigos
				$debug =1;
				$balkaGarums = (floor($balkaGarums/10)/10);//apaļojam uz decimetriem un 
				//saglabājam, lai atgriestu atpakaļ kāds bija
				$tievgala_caurmers_mem = $tievgala_caurmers;
				$tievgala_caurmers = $tievgala_caurmers/10;  //lai no milimetriem iegūtu centimetrus
				$balkaTilpums=0.0;
				$sql_query = "";
				$raukums =1;
				$mySkira = $skira;
				$mySkira2 = $skira2;
				//Ja balkis ieklaujas garuma robezzaas
				if($balkaGarums >= 2.70 )
				{
					if($balkaGarums > 3.2)
					{
						$mySkira =9;
						$mySkira2 =9;
					}
					//Balka tilpuma aprekins
					//Balka tilpuma aprekins
					$balkaNetoGarums = 2.7;
					$balkaNetoTilpums = tilpumaAprekins($tievgala_caurmers,$balkaNetoGarums,$raukums);
					$balkaBrutoTilpums = tilpumaAprekins($tievgala_caurmers,$balkaGarums,$raukums);
					//Aprēķinam pirmā cilindra tilpumu pēc tievgala caurmēra un pirmā kluča garuma 1.35m
					$pirmaCilindraTilpums = round(tilpumaAprekins($tievgala_caurmers,1.35,$raukums)*1000,0); 	
					//Aprēķins, ja pirmā cilindra tilpums ir neto tilpums / 2
					//floor(($balkaNetoTilpums/2)*1000);//reizinam ar 1000, lai tiktu pie kubikdecimetriem
					$otraCilindraNetoTilpums= round(($balkaNetoTilpums*1000 - $pirmaCilindraTilpums),0); //reizinam ar 1000, lai tiktu pie kubikdecimetriem
					$virsmers = (round($balkaBrutoTilpums*1000,0) - round($balkaNetoTilpums*1000,0));//reizinam ar 1000, lai tiktu pie kubikdecimetriem
					//Paareekkinam virsmeeru uz kubikdecimetriem un noapallojam, lai nebuutu komati.
					$tievgala_caurmers = $tievgala_caurmers_mem;
					$sql_query = "insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, skira_2, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, brakis2, import_type,import_id,1_cilindra_tilpums, 2_cilindra_tilpums, virsmera_tilpums) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."',                       ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$skira2.",".$tievgala_caurmers."-rc*10, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'$brakis2','zbm',".$m['id'].",".$pirmaCilindraTilpums .",".$otraCilindraNetoTilpums.", $virsmers from fails_zbm_ui where id = ".$m['id'];
					if($debug==1)
					{
						error_log("pirmaCilindraTilpums:".$pirmaCilindraTilpums);
						error_log("otraCilindraNetoTilpums:".$otraCilindraNetoTilpums);
						error_log("virsmers:".$virsmers);
						$skira2Vardos = "labs";
						$skira1Vardos = "labs";
						if($mySkira==9)$skira1Vardos="brāķis";
						if($mySkira2==9)$skira2Vardos="brāķis";
						
						error_log("<p>Balka garums ir: ".$balkaGarums." m</p>"); 
						error_log("<p>Balka tievgala caurmers  ir: ".$tievgala_caurmers." cm</p>"); 
						error_log("<p>Balka bruto tilpums ir: ".$balkaBrutoTilpums." cbm</p>"); 
						error_log("<p>Balka neto tilpums ir: ".$balkaNetoTilpums." cbm</p>"); 
						error_log("<p>Balka Neto tilpums C1(".$skira1Vardos."):".$pirmaCilindraTilpums." kubikdecimetri</p>");
						error_log("<p>Balka Neto tilpums C2(".$skira2Vardos."):".$otraCilindraNetoTilpums." kubikdecimetri</p>");
						error_log("<p>Virsmers:".$virsmers." kubikdecimetri</p>");
						error_log("<p><b>SQL Query:".$sql_query."</b></p>");
						$parbaude = round(($balkaBrutoTilpums*1000 - $pirmaCilindraTilpums - $otraCilindraNetoTilpums - $virsmers),0);
						error_log("<p>Pārbaude: [Brutto - Netto1+Netto2+virsmers == 0]: ".$parbaude."</p>");
					}
				}
				else if ($balkaGarums < 2.7 && $balkaGarums >= 1.35)
				{	
						if($balkaGarums < 1.6)
						{
							$mySkira =9;
							$mySkira2 =9;
						}
						//Aprēķinam renā gala kluča, tievā gala caurmēru:
						//Griezuma vieta ir "baļķa garums" - 135
						$resnaKlucaGarums = 1.35;//metros
						$isaGalaGarums = $balkaGarums - $resnaKlucaGarums;
						$pirmaCilindraTilpums =tilpumaAprekins($tievgala_caurmers, $isaGalaGarums, $raukums);
						
						$balkaBrutoTilpums = tilpumaAprekins($tievgala_caurmers,$balkaGarums,$raukums);
						$otraCilindraNetoTilpums = $balkaBrutoTilpums - $pirmaCilindraTilpums;

						$pirmaCilindraTilpums = round($pirmaCilindraTilpums *1000,0); //pārrēķinam uz kubikdecimetriem
						$otraCilindraNetoTilpums = round($otraCilindraNetoTilpums*1000,0); 
						$virsmers = 0;
						//Ja garums ir 1.6-2.7m
						//Ja mērnieks kluci ir novērtējis bez brāķa, tad tievgaļa pārpalikums ir brāķis.
							if($mySkira != 9 && $mySkira2 != 9)
							{
								$mySkira = 9;
							}//Ja mērnieks resno galu ir novērtējis kā brāķi, tad automātiski arī tievais gals ir brāķis.
							else if ($mySkira2 == 9 )
							{
								$mySkira = 9;
							}
						//Ja garums ir zem 1.6m tad abi brāķi
							if($balkaGarums < 1.6)
							{
								$mySkira =9;
								$mySkira2 =9;
							}
						$tievgala_caurmers = $tievgala_caurmers_mem; //lai dabūtu atpakaļ dabubāzē izmantoto standartu
						$sql_query = "insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, skira_2, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, brakis2, import_type,import_id, 1_cilindra_tilpums, 2_cilindra_tilpums, virsmera_tilpums) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."',                       ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$skira2.",".$tievgala_caurmers."-rc*10, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'$brakis2','zbm',".$m['id'].",".$pirmaCilindraTilpums.",".$otraCilindraNetoTilpums.", $virsmers from fails_zbm_ui where id = ".$m['id'];
				
						if($debug==1)
						{
							$skira2Vardos = "labs";
							$skira1Vardos = "labs";
							if($mySkira==9)$skira1Vardos="brāķis";
							if($mySkira2==9)$skira2Vardos="brāķis";
							
							error_log("<p>Balka garums ir: ".$balkaGarums." m</p>"); 
							error_log("<p>Balka tievgala caurmers  ir: ".$tievgala_caurmers." cm</p>"); 
							error_log("<p>Balka bruto tilpums ir: ".$balkaBrutoTilpums." cbm</p>"); 
							error_log("<p>Balka neto tilpums ir: nav aprēķināms jo garums zem 2.7m cbm</p>"); 
							error_log("<p>Balka Neto tilpums C1(".$skira1Vardos."):".$pirmaCilindraTilpums." kubikdecimetri</p>");
							error_log("<p>Balka Neto tilpums C2(".$skira2Vardos."):".$otraCilindraNetoTilpums." kubikdecimetri</p>");
							error_log("<p>Virsmers:".$virsmers." kubikdecimetri</p>");
							error_log("<p><b>SQL Query:".$sql_query."</b></p>");
							$parbaude = floor($balkaBrutoTilpums*1000 - $pirmaCilindraTilpums - $otraCilindraNetoTilpums - $virsmers);
							error_log("<p>Pārbaude: [Brutto - Netto1+Netto2+virsmers == 0]: ".$parbaude."</p>");
						}
				}
				else //Baļķa garums ir zem 1.35
				{	
						$mySkira =9;
						$mySkira2 =9;
						$balkaBrutoTilpums = tilpumaAprekins($tievgala_caurmers,$balkaGarums,$raukums);//tilpums kubikmetros
						$pirmaCilindraTilpums = $balkaBrutoTilpums;
						$pirmaCilindraTilpums = round($pirmaCilindraTilpums *1000,0); //pārrēķinam uz kubikdecimetriem
						$otraCilindraNetoTilpums = 0; 
						$virsmers = 0;
						$tievgala_caurmers = $tievgala_caurmers_mem; //lai dabūtu atpakaļ dabubāzē izmantoto standartu
  						$sql_query = "insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, skira_2, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, brakis2, import_type,import_id, 1_cilindra_tilpums, 2_cilindra_tilpums, virsmera_tilpums) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$skira2.",".$tievgala_caurmers."-rc*10, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'$brakis2','zbm',".$m['id'].",".$pirmaCilindraTilpums.",".$otraCilindraNetoTilpums.", $virsmers from fails_zbm_ui where id = ".$m['id'];
				
						if($debug==1)
						{
							$skira2Vardos = "labs";
						$skira1Vardos = "labs";
						if($mySkira==9)$skira1Vardos="brāķis";
						if($mySkira2==9)$skira2Vardos="brāķis";
						
						error_log("<p>Balka garums ir: ".$balkaGarums." m</p>"); 
						error_log("<p>Balka tievgala caurmers  ir: ".$tievgala_caurmers." cm</p>"); 
						error_log("<p>Balka bruto tilpums ir: ".$balkaBrutoTilpums." cbm</p>"); 
						error_log("<p>Balka neto tilpums ir: nav aprēķināms jo garums zem 2.7m cbm</p>"); 
						error_log("<p>Balka Neto tilpums C1(".$skira1Vardos."):".$pirmaCilindraTilpums." kubikdecimetri</p>");
						error_log("<p>Balka Neto tilpums C2(".$skira2Vardos."):".$otraCilindraNetoTilpums." kubikdecimetri</p>");
						error_log("<p>Virsmers:".$virsmers." kubikdecimetri</p>");
						error_log("<p><b>SQL Query:".$sql_query."</b></p>");
						$parbaude = floor($balkaBrutoTilpums*1000 - $pirmaCilindraTilpums - $otraCilindraNetoTilpums - $virsmers);
						error_log("<p>Pārbaude: [Brutto - Netto1+Netto2+virsmers == 0]: ".$parbaude."</p>");
						}
			}
		
		mysql_query ($sql_query);
		if($debug==1)
		{
			error_log("SQL statement: ".$sql_query."; !!!");
			error_log("MySQL error: ".mysql_error());
			error_log("Notika viena ieraksta ierakstīšana datubāzē no tabulas fails_zbm_ui uz balkis");
		}
	/*VECAIS KODS 17.04.2013 - Andris Zemitis*/
	//*****************************************
	//	mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, skira_2, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, brakis2, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$skira2.",".$tievgala_caurmers."-rc*10, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'$brakis2','zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
	//	//		mysql_query ("insert into balkis (pavadzime, nelieto, datums_laiks, mind_pirms_red, garums, suga, skira, miza, mind_pec_red, gar_pec_red, mind_miza, brakis, maxd_miza, kabata, tilpums, tilpums_scan, import_type,import_id) select $pavadzime, '', '".sqltime(convert_time2($m['ts']))."', ".$tievgala_caurmers.", gr, sg, ".$skira.", '', ".$tievgala_caurmers."-rc, gr-(rg*10), 0, '$brakis', 0, '', 0, 0,'zbm',".$m['id']." from fails_zbm_ui where id = ".$m['id']);
        }


		// dabonam jauno id
		$rid = mysql_query("select max(id) as x from balkis");
		$mid = mysql_fetch_array($rid);
		$new_id = $mid['x'];

    mysql_query("UPDATE `pavadzime` SET `kad_uzmer` = '".sqltime(convert_time2($m['ts']))."' WHERE `id` = $pavadzime");

		// updeitojam ierakstu ar jauno id
		mysql_query("update fails_zbm_ui set export_id = ".$new_id." where id = ".$m['id']);
	}
	else
	{
		// updeitojam ierakstu ar atzīmi ka ir kļūda
		mysql_query("update fails_zbm_ui set export_id = -1 where id = ".$m['id']);
	}

}

 header("location: http://www.vmf.lv/pocket_pc/zbm.php?h=zbm");
 return;

//Aprēķina baļķa tilpumu - caurmērs centimetros, garums metros, raukums cm/m 
function tilpumaAprekins($f_caurmers, $f_garums, $f_raukums)
{
	$f_tilpums = (3.1416 * ((pow($f_caurmers,2) + pow($f_caurmers + ($f_raukums * $f_garums),2)) * $f_garums))/(4 * 2 * 10000);//tilpums kubikmetros
	return $f_tilpums;
}  
 
function convert_time($s)
{
	$a1 = explode(' ',trim($s));
	$a2 = explode('.',$a1[0]);
	$a3 = explode(':',$a1[1]);
	return mktime($a3[0],$a3[1],$a3[2],$a2[1],$a2[0],$a2[2]);
}

function convert_time2($s)
{
	$a1 = explode(' ',trim($s));
	$a2 = explode('/',$a1[0]);
	$a3 = explode(':',$a1[1]);
	return mktime($a3[0],$a3[1],$a3[2],$a2[1],$a2[0],$a2[2]);
}

?>