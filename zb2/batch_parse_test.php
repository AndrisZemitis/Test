<?
include ('db.inc.php');
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

menu();
?><br><br><center><?
$name = $_FILES['fails']['name'];

$ERRORS = 0;
$ielasita_pavadzime = '';

if(trim($name)=='') $ERRORS=1;


// pārbaudam vai jau nav ielasīts
$r = mysql_query("select nosaukums from batch_fails where nosaukums = '$name'");
//if (mysql_num_rows($r)>0) $ERRORS=2;

if($ERRORS==0)
{
	//echo "<BR>Sākumā kļūdu nav";
	//set_time_limit(0); 
	$fsk=copy($_FILES['fails']['tmp_name'],'../batch/'.$name );
	//$fsk=move_uploaded_file($_FILES['fails']['tmp_name'],'/home/vmf/htdocs/batch/'.$name );


//	mysql_query("insert into batch_fails (nosaukums,datums) values ('$name','".date("Y-m-d h:i:s")."')") or die('Kļūda sākot ielasīt baču: ' . mysql_error());
	echo "insert into batch_fails (nosaukums,datums) values ('$name','".date("Y-m-d h:i:s")."')",'<br/>';
	//$rfails = mysql_query("select max(id) as x from batch_fails where nosaukums = '$name'");
	//$mfails = mysql_fetch_array($rfails);
	//$batch_fails = $mfails['x'];
	$batch_fails = mysql_insert_id();
	$balku_skaits = 0;

	chdir('../batch');

	$mf = file($name,NULL);
//	mysql_query ("delete from balkis where pavadzime=0");
	//echo("<BR>Dati par baču ielikti datubāzē");
	for ($i=0;$i<count($mf);$i++)
	{
		$j = substr($mf[$i],3,1);
    echo "J ir = ".$j.'<br/>';

		if ($j == 'R')
		{
			//echo("<BR>Ifs izpildīts - tips R, pavadzīme");
			//echo $mf[$i]."<BR>";
//      echo "Labrit",'<br>';
			$kad_piegad="";
			$piegad_grupa_datums = substr($mf[$i],39,30);
			$piegad_grupa_datums = ereg_replace(" +"," ",$piegad_grupa_datums);
			$pgd__ = explode(' ',$piegad_grupa_datums);
			$piegad_grupa = trim($pgd__[0]); 
			$kad_piegad=trim($pgd__[1]);
			$kad_piegad = '20'.substr($kad_piegad,8,2).'.'.substr($kad_piegad,3,2).'.'.substr($kad_piegad,0,2);
			echo $piegad_grupa_datums." | ".$piegad_grupa ." ".$kad_piegad." ".count($pgd__)."<br>";

			$iecirknis = substr($mf[$i],69,2);
			$cirsmas_kods = substr($mf[$i],71,7);
			$fsc = substr($mf[$i],78,1);
			if ($fsc!='0' && $fsc!='1') $fcs = 0;
			$pavadzime = substr($mf[$i],79,6);
			$piegad_kods = substr($mf[$i],89,2);
			$iecirknis_pieg = substr($mf[$i],92,26);
			$attalums = substr($mf[$i],149,3);
			$auto = substr($mf[$i],152,7);
			$soferis = substr($mf[$i],159,29);
			$cenu_matrica = substr($mf[$i],189,2);
			$kravas_id = substr($mf[$i+1],0,9);
			$i = $i+1;
//			$query = "insert into pavadzime (batch_fails,piegad_grupa,kad_piegad,iecirknis,cirsmas_kods,fsc,pavadzime,piegad_kods,iecirknis_pieg,attalums,auto,soferis,cenu_matrica,kravas_id) values($batch_fails,'$piegad_grupa','$kad_piegad','$iecirknis','$cirsmas_kods','$fsc','$pavadzime','$piegad_kods','$iecirknis_pieg',$attalums,'$auto','$soferis','$cenu_matrica','$kravas_id')";
			echo "insert into pavadzime (batch_fails,piegad_grupa,kad_piegad,iecirknis,cirsmas_kods,fsc,pavadzime,piegad_kods,iecirknis_pieg,attalums,auto,soferis,cenu_matrica,kravas_id) values($batch_fails,'$piegad_grupa','$kad_piegad','$iecirknis','$cirsmas_kods','$fsc','$pavadzime','$piegad_kods','$iecirknis_pieg',$attalums,'$auto','$soferis','$cenu_matrica','$kravas_id')",'<br/>';

			echo "Kad_piegad = ".$kad_piegad.'<br />';
			echo "Piegad_grupa_datums = ".$piegad_grupa_datums.'<br />';
			echo "Pgd__ = ".$pgd__.'<br />';
			echo "Piegad_grupa = ".$piegad_grupa.'<br />';
			echo "Kad_piegad = ".$kad_piegad.'<br />';
			echo "Iecirknis = ".$iecirknis.'<br />';
			echo "Cirsmas_kods = ".$cirsmas_kods.'<br />';
			echo "Fsc = ".$fsc.'<br />';
			echo "Pavadzime = ".$pavadzime.'<br />';
			echo "Piegad_kods = ".$piegad_kods.'<br />';
			echo "Iecirknis_pieg = ".$iecirknis_pieg.'<br />';
			echo "Attalums = ".$attalums.'<br />';
			echo "Auto = ".$auto.'<br />';
			echo "Soferis = ".$soferis.'<br />';
			echo "Cenu_matrica = ".$cenu_matrica.'<br />';
			echo "Kravas_id = ".$kravas_id.'<br />';



			if($piegad_grupa!='SILVA' || substr($mf[$i-1],189,3) == 'GO1' || substr($mf[$i-1],189,3) == 'I42')
			{
				//echo ("<BR>Pavadzīme ielasīta");
				$ielasita_pavadzime .= $piegad_grupa."&nbsp;&nbsp;&nbsp;".$pavadzime;
				mysql_query($query) or die("Kļūda ielasot pavadzīmi Nr. $pavadzime. Lūdzu izdzēsiet šo baču un lasiet to no jauna!");
				//$rpav = mysql_query("select max(id) as x from pavadzime where pavadzime = '$pavadzime'");
				//$mpav = mysql_fetch_array($rpav);
				$last_id = mysql_insert_id();
				$ielasita_pavadzime .= "&nbsp;&nbsp;&nbsp;". $last_id."&nbsp;&nbsp;&nbsp;Baļķu skaits pavadzīmē:".$balku_skaits."<BR>" ;

//				mysql_query("update balkis set pavadzime = ".$last_id." where pavadzime = 0");
				echo "update balkis set pavadzime = ".$last_id." where pavadzime = 0",'<br/>';
			} else 
			{
				 echo "Ielasita SILVA - labojam datus!<br>";
				$rpav = mysql_query("select count(*) as x from balkis where pavadzime = 0");
				$res = mysql_fetch_array($rpav);
				echo "Nepareizi ielasīti baļķi: ".$res['x']."<br>";
				mysql_query("delete  from balkis where pavadzime = 0");
				echo "Dzēšam!<br>";
				$rpav = mysql_query("select count(*) as x from balkis where pavadzime = 0");
				$res = mysql_fetch_array($rpav);
				echo "Nepareizi ielasīti baļķi: ".$res['x']."<br><hr>";

			}
			$balku_skaits = 0;
		}
		else
		{
			//echo("<BR>Ifs nav izpildīts - tips nav R, baļķis");
			$nelieto = substr($mf[$i],0,3); 
			$datums_laiks =  substr($mf[$i],7,4).'-'.substr($mf[$i],5,2).'-'.substr($mf[$i],3,2).' '.substr($mf[$i],11,2).'.'.substr($mf[$i],13,2).'.'.substr($mf[$i],15,2);
			$mind_pirms_red = substr($mf[$i],17,3);
			$garums = substr($mf[$i],20,4);
			$suga = substr($mf[$i],24,1);
			$skira = substr($mf[$i],25,1);
			$miza = substr($mf[$i],26,1);
			$mind_pec_red = substr($mf[$i],27,3);
			$gar_pec_red = substr($mf[$i],30,3);
			$mind_miza = substr($mf[$i],33,3);
			$brakis = substr($mf[$i],36,3);
			$maxd_miza = substr($mf[$i],39,3);
			$kabata = substr($mf[$i],42,2);
			$tilpums = substr($mf[$i],44,4);
			$tilpums_scan = substr($mf[$i],48,4);
			if ($brakis!='255') $skira='9';
//			$query = "insert into balkis (pavadzime,nelieto,datums_laiks,mind_pirms_red,garums,suga,skira,miza,mind_pec_red,gar_pec_red,mind_miza,brakis,maxd_miza,kabata,tilpums,tilpums_scan) 	values(0,'$nelieto','$datums_laiks',$mind_pirms_red,$garums,'$suga','$skira','$miza',$mind_pec_red,$gar_pec_red,$mind_miza,'$brakis',$maxd_miza,'$kabata',$tilpums,$tilpums_scan)";

               echo "Nelieto = ".$nelieto.'<br />';
			echo "Datums_laiks = ".$datums_laiks.'<br />';
			echo "Mind_pirms_red = ".$mind_pirms_red.'<br />';
			echo "Garums = ".$garums.'<br />';
			echo "Suga = ".$suga.'<br />';
			echo "Skira = ".$skira.'<br />';
			echo "Miza = ".$miza.'<br />';
			echo "Mind_pec_red = ".$mind_pec_red.'<br />';
			echo "Gar_pec_red = ".$gar_pec_red.'<br />';
			echo "Mind_miza = ".$mind_miza.'<br />';
			echo "Brakis = ".$brakis.'<br />';
			echo "Maxd_miza = ".$maxd_miza.'<br />';
			echo "Kabata = ".$kabata.'<br />';
			echo "Tilpums = ".$tilpums.'<br />';
			echo "Tilpums_scan = ".$tilpums_scan,'<br />','<br />','<br />';

			echo "insert into balkis (pavadzime,nelieto,datums_laiks,mind_pirms_red,garums,suga,skira,miza,mind_pec_red,gar_pec_red,mind_miza,brakis,maxd_miza,kabata,tilpums,tilpums_scan) 	values(0,'$nelieto','$datums_laiks',$mind_pirms_red,$garums,'$suga','$skira','$miza',$mind_pec_red,$gar_pec_red,$mind_miza,'$brakis',$maxd_miza,'$kabata',$tilpums,$tilpums_scan)",'<br/>';
			//echo("<BR>" . $query);
			mysql_query($query);
			$balku_skaits++;
		}
	}



	

	//echo $mf[0];

}



$msg = "Notikusi kļūda! Mēģiniet vēlreiz.";
switch ($ERRORS) {
	case 1: $msg = "Norādītiet ielasāmo failu!";  break;
	case 2: $msg = "Fails ar šādu nosaukumu jau ir ielasīts.";  break;
}
if($ERRORS) {echo $msg;} else {echo '<b>Fails ielasīts!</b><br><br>'.$ielasita_pavadzime;}
?>
</center>
</body>
</html>