<?

$MAINU_SKAITS = 7; //cik mainju ir shablonaa

//funkcija sms suutishanai uz LMT, TELE2, TRIATEL
function sms_send($ident,$teksts)
{
	mail($ident.'@sms.lmt.lv', 'VMF', $teksts);
	mail('371'.$ident.'@sms.tele2.lv', 'VMF', $teksts);
	mail($ident.'@sms.triatel.lv', 'VMF', $teksts);
	
	// http://www.lmt.lv/lv/index.php?pageid=3005001007002 
	// xxxxxx@sms.lmt.lv  E+ 9319915, ADRESE 9319915
	// 371xxxxxxx@sms.tele2.lv
	// 58XXXXX@sms.triatel.lv
	return 'ok';
}

function nauda($skaitlis)
{
	$rezultats = $skaitlis;
	/*$rezultats = '';
	$a = explode('.',$skaitlis);
	if (strlen($a[1] == 0))
	{	
		//$rezultats = $skaitlis.".00";
		$rezultats = "&nbsp;".$skaitlis.".00";

	}
	else
	{
		if (strlen($a[1] == 1))
		{
			//$rezultats = $a[0].".".$a[1]."0";
			$rezultats = "&nbsp;".$skaitlis;
		}
		else
		{
			//$rezultats = $skaitlis;
			$rezultats = "&nbsp;".$skaitlis;
		}
	}*/
	return $rezultats;
}

function summa_vardiem($skaitlis) 
{
	// funkcija izdrukaa summu vārdiem līdz 9999
	if (strlen($skaitlis) > 4)
	{
		echo "***";
	}
	else
	{
		for ($i = 1; $i <= strlen($skaitlis); $i++)
		{
			$vieni = "";
			$desmiti = "";
			$vards = "";
			$vards_d = "";
			$padsmit = "";

			$vieni = substr($skaitlis,$i-1,1);
			switch ($vieni)
			{
				case 1:
				  $vards = "viens";
				  break;
				case 2:
				  $vards = "divi";
				  break;
				case 3:
				  $vards = "trīs";
				  break;
				case 4:
				  $vards = "četri";
				  break;
				case 5:
				  $vards = "pieci";
				  break;
				case 6:
				  $vards = "seši";
				  break;
				case 7:
				  $vards = "septiņi";
				  break;
				case 8:
				  $vards = "astoņi";
				  break;
				case 9:
				  $vards = "deviņi";
				  break;
				default:
				  $vards_d = "";
			}
			$desmiti = strlen($skaitlis)+1-$i;
			
			if ($vieni == 1)
			{
				if ($desmiti > 1)
				{
					switch ($desmiti)
					{
						case 2:
						  $vards_d = "desmit";
						  break;
						case 3:
						  $vards_d = "simts";
						  break;
						case 4:
						  $vards_d = "tūksots";
						  break;
						default:
						  $vards_d = "";
					}
					
					if ($desmiti == 2 and substr($skaitlis,$i,1) !== '' and substr($skaitlis,$i,1) != 0)
					{
						$padsmit = substr($skaitlis,$i,1);
						switch ($padsmit)
						{
							case 1:
							  $vards = "vien";
							  break;
							case 2:
							  $vards = "div";
							  break;
							case 3:
							  $vards = "trīs";
							  break;
							case 4:
							  $vards = "četr";
							  break;
							case 5:
							  $vards = "piec";
							  break;
							case 6:
							  $vards = "seš";
							  break;
							case 7:
							  $vards = "septiņ";
							  break;
							case 8:
							  $vards = "astoņ";
							  break;
							case 9:
							  $vards = "deviņ";
							  break;
							default:
							  $vards = "";
						}
						if ($i == 1){$vards = strtoupper(substr($vards,0,1)).substr($vards,1,strlen($vards)-1);}
						echo $vards."padsmit";
						$i = $i + 1;
					}
					else
					{
					if ($i == 1){$vards_d = strtoupper(substr($vards_d,0,1)).substr($vards_d,1,strlen($vards_d)-1);}
					echo $vards_d." ";
					}
				}
				else
				{
					if ($i == 1){$vards = strtoupper(substr($vards,0,1)).substr($vards,1,strlen($vards)-1);}
					echo $vards." ";
				}
			}
			else
			{
				switch ($desmiti)
				{
					case 2:
					  $vards_d = "desmit";
					  break;
					case 3:
					  $vards_d = "simt";
					  break;
					case 4:
					  $vards_d = "tūkstoš";
					  break;
					default:
					  $vards_d = "";
				}

				if ($vieni != 0)
				{
					
					if ($vieni != 3 and $desmiti > 1)
					{
						$vards = substr($vards,0,strlen($vards)-1);
					}
					if ($i == 1){$vards = strtoupper(substr($vards,0,1)).substr($vards,1,strlen($vards)-1);}

					echo $vards.$vards_d." ";
				}
			}
		}
	} 
}

function valutas_kurss($valuta,$val_kursa_datums)
{
	$valuta = strtoupper($valuta);
	$xmlf=file('http://www.bank.lv/vk/xml.xml?date='.date('Ymd',$val_kursa_datums));
	$daudz=sizeof($xmlf);
	$ciki=$daudz-1;
	for($i=1;$i<$ciki;$i++)
	{
		if (strpos($xmlf[$i],"<ID>".$valuta."</ID>") )
		{
			$units_s = strpos($xmlf[$i+1],"<Units>") + 7;
			$units_b = strpos($xmlf[$i+1],"</Units>");
			$rate_s = strpos($xmlf[$i+2],"<Rate>") + 6;
			$rate_b = strpos($xmlf[$i+2],"</Rate>");
			
			$arr = array();
			$arr['id'] = $valuta;
			$arr['units'] = substr($xmlf[$i+1],$units_s,($units_b-$units_s)); 
			$arr['rate'] = substr($xmlf[$i+2],$rate_s,($rate_b-$rate_s));
			$i=$ciki;
		}
	}
	return $arr;
}

function datums($s)
{
	$a = explode(' ',$s);
	$a1 = explode('/',$a[0]);
	return mktime(0,0,0,$a1[1],$a1[0],$a1[2]);
}

function print_datums($d)
{
	return date('d/m/Y',$d);
}

function dienas_num($d)
{
	return date('d',$d);
}

function datums_laiks($s,$stundas,$minutes)
{
	
	$a = explode(' ',$s);
	$a1 = explode('/',$a[0]);
//	echo mktime($stundas,$minutes,0,$a1[1],$a1[0],$a1[2]);
	return mktime($stundas,$minutes,0,$a1[1],$a1[0],$a1[2]);
}

function print_datums_laiks($d)
{
	return date('d/m/Y H:i',$d);
}


function sqlday($sql_datums)
{
	$a = explode(' ',$sql_datums);
	$a1 = explode('-',$a[0]);
	return $a1[2];
}

function sqlmonth($sql_datums)
{
	$a = explode(' ',$sql_datums);
	$a1 = explode('-',$a[0]);
	return $a1[1];
}

function sqlyear($sql_datums)
{
	$a = explode(' ',$sql_datums);
	$a1 = explode('-',$a[0]);
	return $a1[0];
}

function menesis($m)
{
	if ($m==1)
		return "Janvāris";
	if ($m==2)
		return "Februāris";
	if ($m==3)
		return "Marts";
	if ($m==4)
		return "Aprīlis";
	if ($m==5)
		return "Maijs";
	if ($m==6)
		return "Jūnijs";
	if ($m==7)
		return "Jūlijs";
	if ($m==8)
		return "Augusts";
	if ($m==9)
		return "Septembris";
	if ($m==10)
		return "Oktobris";
	if ($m==11)
		return "Novembris";
	if ($m==12)
		return "Decembris";
	return "";
}

function nedelas_diena($d)
{
	if ($d==1)
		return 'Pirmdiena';
	if ($d==2)
		return 'Otrdiena';
	if ($d==3)
		return 'Trešdiena';
	if ($d==4)
		return 'Ceturtdiena';
	if ($d==5)
		return 'Piektdiena';
	if ($d==6)
		return 'Sestdiena';
	if ($d==7)
		return 'Svētdiena';
}

function pieskaitit_dienas($datums,$dienas)
{
	return mktime(0,0,0,date('m',$datums),date('d',$datums)+$dienas,date('Y',$datums));
}

function sodiena()
{
	return mktime(0,0,0,date('m'),date('d')+$dienas,date('Y'));
}

function menesa_sakums($d)
{
	return mktime(0,0,0,date('m'),1,date('Y'));
}

function menesa_beigas($d)
{
	return mktime(0,0,0,date('m')+1,0,date('Y'));
}

function sqldate($d)
{
	return date('Y-m-d',$d);
}

function sqltime($t)
{
	return date('Y-m-d H:i:s', $t);
}

function laika_ievade15($lauks,$stundas,$minutes)
{
		echo '<select name='.$lauks.'h type="text" class="text_normal">';
			for ($i=0; $i<=23; $i++)
			{
				if ($i == $stundas)
					echo '<option selected>'.$i.'</option>';
				else
					echo '<option>'.$i.'</option>';
			} 

		echo '</select>:';
		echo '<select name='.$lauks.'m type="text" class="text_normal">';
			 
			   if ($minutes == 00)
					echo '<option selected>00</option>';
			   else
 					echo '<option>00</option>';

			   if ($minutes == 15)
					echo '<option selected>15</option>';
			   else
 					echo '<option>15</option>';

			   if ($minutes == 30)
					echo '<option selected>30</option>';
			   else
 					echo '<option>30</option>';

			   if ($minutes == 45)
					echo '<option selected>45</option>';
			   else
 					echo '<option>45</option>';

					
			
		echo '</select>';
}

function izvele($lauks,$tabulas_nosauk,$mainigais)
{
	$a = explode(' as ',$lauks);
	if (count($a)==2)
		$lauks2 = $a[1];
	else
		$lauks2 = $lauks;
	
	if ($noverosana)
	{ 
		echo '<select name='.$lauks2.' disabled type="number" class="text_normal">';
	}
	else
	{ 
		echo '<select name='.$lauks2.' type="number" class="text_normal">';
	}
	echo '<option>Izvēlies no saraksta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
		
		if ($lauks !== "concat(vards,' ',uzvards) as x")
		{	
			if ($lauks == 'transporta_nr' or $lauks == 'treilera_nr')
			{
				$r = mysql_query("select id,$lauks from $tabulas_nosauk order by seciba");
			}
			else
			{
				$r = mysql_query("select id,$lauks from $tabulas_nosauk");
			}
		}
		else
		{
			$r = mysql_query("select id,$lauks from $tabulas_nosauk order by vards,uzvards");
		}

		while ($m = mysql_fetch_array($r))
		{
			if ($m[id] == $mainigais)
				echo '<option selected value='.$m[id].'>'.$m[$lauks2].'</option>';
			else
				echo '<option value='.$m[id].'>'.$m[$lauks2].'</option>';
		}
															   
	echo '</select>';
}

//--------diikstaveem-----[no] - [liidz] viens aizpildits otrs nav; [no] < [lidz]-------

function laika_ievadisana($laiks_no,$laiks_lidz,$laiks_noh,$laiks_nom,$laiks_lidzh,$laiks_lidzm) 
{
	if ($laiks_no && $laiks_lidz)
	{
		if (datums($laiks_no)!=-1 && datums($laiks_lidz)!=-1)
		{
			if (datums_laiks($laiks_no,$laiks_noh,$laiks_nom)<datums_laiks($laiks_lidz,$laiks_lidzh,$laiks_lidzm))
			return true;
		}
	}
	if (!$laiks_no && !$laiks_lidz)
		return true;
}

function intervalu_parklasanas($int1a,$int1b,$int2a,$int2b)
{
	if (($int1b<=$int2a) || ($int2b<=$int1a))
		return true;
}

function getDateDifference($dateFrom, $dateTo, $unit = 'd')
{
   $difference = null;

   $dateFromElements = split(' ', $dateFrom);
   $dateToElements = split(' ', $dateTo);

   $dateFromDateElements = split('-', $dateFromElements[0]);
   $dateFromTimeElements = split(':', $dateFromElements[1]);
   $dateToDateElements = split('-', $dateToElements[0]);
   $dateToTimeElements = split(':', $dateToElements[1]);

   // Get unix timestamp for both dates

   $date1 = mktime($dateFromTimeElements[0], $dateFromTimeElements[1], $dateFromTimeElements[2], $dateFromDateElements[1], $dateFromDateElements[0], $dateFromDateElements[2]);
   $date2 = mktime($dateToTimeElements[0], $dateToTimeElements[1], $dateToTimeElements[2], $dateToDateElements[1], $dateToDateElements[0], $dateToDateElements[2]);

   if( $date1 > $date2 )
   {
       return null;
   }

   $diff = $date2 - $date1;

   $days = 0;
   $hours = 0;
   $minutes = 0;
   $seconds = 0;

   if ($diff % 86400 <= 0)  // there are 86,400 seconds in a day
   {
       $days = $diff / 86400;
   }

   if($diff % 86400 > 0)
   {
       $rest = ($diff % 86400);
       $days = ($diff - $rest) / 86400;

       if( $rest % 3600 > 0 )
       {
           $rest1 = ($rest % 3600);
           $hours = ($rest - $rest1) / 3600;

           if( $rest1 % 60 > 0 )
           {
               $rest2 = ($rest1 % 60);
               $minutes = ($rest1 - $rest2) / 60;
               $seconds = $rest2;
           }
           else
           {
               $minutes = $rest1 / 60;
           }
       }
       else
       {
           $hours = $rest / 3600;
       }
   }

   switch($unit)
   {
       case 'd':
       case 'D':

           $partialDays = 0;

           $partialDays += ($seconds / 86400);
           $partialDays += ($minutes / 1440);
           $partialDays += ($hours / 24);

           $difference = $days + $partialDays;

           break;

       case 'h':
       case 'H':

           $partialHours = 0;

           $partialHours += ($seconds / 3600);
           $partialHours += ($minutes / 60);

           $difference = $hours + ($days * 24) + $partialHours;

           break;

       case 'm':
       case 'M':

           $partialMinutes = 0;

           $partialMinutes += ($seconds / 60);

           $difference = $minutes + ($days * 1440) + ($hours * 60) + $partialMinutes;

           break;

       case 's':
       case 'S':

           $difference = $seconds + ($days * 86400) + ($hours * 3600) + ($minutes * 60);

           break;

       case 'a':
       case 'A':

           $difference = array (
               "days" => $days,
               "hours" => $hours,
               "minutes" => $minutes,
               "seconds" => $seconds
           );

           break;
   }

   return $difference;
}


function tiesibas_admin($id)
{
	$rt = mysql_query("select * from lietotaji where id = $id");
	$mt = mysql_fetch_array($rt);
	if ($mt['uzd_pievienosana']=='Y')
		return true;
	else
		return false;
}

function tiesibas_cenas_un_tarifi($id)
{
	$rt = mysql_query("select * from lietotaji where id = $id");
	$mt = mysql_fetch_array($rt);
	if ($mt['cenas_un_tarifi']=='Y')
		return true;
	else
		return false;
}

function tiesibas_skatisana($id)
{
	$rt = mysql_query("select * from lietotaji where id = $id");
	$mt = mysql_fetch_array($rt);
	if ($mt['skatisana']=='Y')
		return true;
	else
		return false;
}

function tiesibas_noverosana($id)
{
	$rt = mysql_query("select * from lietotaji where id = $id");
	$mt = mysql_fetch_array($rt);
	if ($mt['noverosana']=='Y')
		return true;
	else
		return false;
}

function viens_ieraksts($tabula,$id)
{
	$rt = mysql_query("select * from $tabula where id = $id");
	return mysql_fetch_array($rt);
}

/*function atskaites_stundas_old($atskaite_id)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);

	// darba stundas un kopējās dīkstāves
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);

	// dienas sākumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa visām dienām
	$stundas = 0;
	$stundas_virs = 0;
	$stundas_pamat = 0;

	// cikls pa dienām
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
		// nosakam cik strādāts konkrētajā dienā
		$t1apr = $i;
		$t2apr = $i+(60*60*24);

		if ($t1apr<$t1) $t1apr = $t1;
		if ($t2apr>$t2) $t2apr = $t2;
		
		// nostrādātās stundas šajā dienā
		$stundas = ($t2apr - $t1apr)/3600;
		if ($stundas>8)
		{
			$stundas_virs = $stundas_virs + $stundas - 8;
			$stundas_pamat = $stundas_pamat + 8;
		}
		else
		{
			$stundas_pamat = $stundas_pamat + $stundas;
		}
	}
	
	$stundas_d = 0 ;
	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$stundas_d = $stundas_d + ((strtotime($md['laiks_lidz']) - strtotime($md['laiks_no']))/3600);
	}

	$arr = array();
	$arr['pamat'] = $stundas_pamat;
	$arr['virs'] = $stundas_virs;
	$arr['d'] = $stundas_d;

	return $arr;
} */

$admin = tiesibas_admin($lietotajs_id);
$skatisana = tiesibas_skatisana($lietotajs_id);
$noverosana = tiesibas_noverosana($lietotajs_id);
$cenas_un_tarifi = tiesibas_cenas_un_tarifi($lietotajs_id);

/*function atskaites_stundas_backup2($atskaite_id,$darbdienas)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);

	// darba stundas un kopējās dīkstāves
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);

	// dienas sākumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa visām dienām
	$stundas = 0;
	$stundas_virs = 0;
	$stundas_pamat = 0;
	$stundas_nakts = 0;

	// cikls pa dienām
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
		// nosakam cik strādāts konkrētajā dienā
		$t1apr = $i;
		$t2apr = $i+(60*60*24);

		if ($t1apr<$t1) $t1apr = $t1;
		if ($t2apr>$t2) $t2apr = $t2;
		
		// nostrādātās stundas šajā dienā
		$stundas = ($t2apr - $t1apr)/3600;
		$rbrivdienas = mysql_query(" select * from brivdienas where datums = '".sqldate($i)."' ");
		if ($mbrivdienas = mysql_fetch_array($rbrivdienas))
		{
			$stundas_virs = $stundas_virs + $stundas;
		}
		else
		{
			if ($stundas>8)
			{
				//$stundas_nakts = $stundas_nakts + ($t1naksts + $t2nakts)/3600;
				$stundas_virs = $stundas_virs + $stundas - 8;
				$stundas_pamat = $stundas_pamat + 8;
			}
			else
			{	
				$j1 = $i + 3600*6;
				if ($j1 > $t2apr){$j1 = $t2apr;}
				$j2 = $i + 3600*22;
				if ($j2 < $t1apr){$j2 = $t1apr;}
				if ( ($j1 - $t1apr) > 0) 
				{ 
					//echo "t1a: ".print_datums_laiks($t1apr);
					//echo "t2: ".print_datums_laiks($t2apr);
					$t1nakts= $j1 - $t1apr; 
					
					//echo ($t1nakts/3600)."<br>";
				} else { $t1nakts=0;}
				if ( ($t2apr - $j2) > 0) 
				{ 
					//echo "t1a: ".print_datums_laiks($t1apr);
					//echo "t2: ".print_datums_laiks($t2apr);
					$t2nakts= $t2apr - $j2; 
					
					//echo ($t2nakts/3600)."<br>";
				} 
				else {  $t2nakts=0; }
				$stundas_nakts = $stundas_nakts + ($t1naksts + $t2nakts)/3600;
				$stundas_pamat = $stundas_pamat + $stundas;
			}
		}
	}
	
	$stundas_d = 0 ;
	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$stundas_d = $stundas_d + ((strtotime($md['laiks_lidz']) - strtotime($md['laiks_no']))/3600);
	}

	$arr = array();
	//echo $stundas_virs."<br>";
	//echo $stundas_pamat;
	$arr['nakts'] = $stundas_nakts;
	$arr['pamat'] = $stundas_pamat;
	$arr['virs'] = $stundas_virs;
	$arr['d'] = $stundas_d;

	return $arr;
}*/

/*function atskaites_stundas($atskaite_id,$darbdienas)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);

	// darba stundas un kopējās dīkstāves
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);

	// dienas sākumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa visām dienām
	$stundas = 0;
	$stundas_virs = 0;
	$stundas_pamat = 0;
	$stundas_nakts = 0;

	// cikls pa dienām
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
		// nosakam cik strādāts konkrētajā dienā
		$t1apr = $i;
		$t2apr = $i+(60*60*24);

		if ($t1apr<$t1) $t1apr = $t1;
		if ($t2apr>$t2) $t2apr = $t2;
		
		// nostrādātās stundas šajā dienā
		$stundas = ($t2apr - $t1apr)/3600;
		else
		{
			if ( ($stundas_pamat + $stundas_nakts + $stundas_d) >= ($darbdienas*8) )
			{
				//$stundas_nakts = $stundas_nakts + ($t1naksts + $t2nakts)/3600;
				$stundas_virs = $stundas_virs + $stundas;
			}
			else
			{	
				$stundas_nakts = $stundas_nakts + ($t1naksts + $t2nakts)/3600;
				$stundas_pamat = $stundas_pamat + $stundas;
			}
		}
	}
	
	$stundas_d = 0 ;
	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$stundas_d = $stundas_d + ((strtotime($md['laiks_lidz']) - strtotime($md['laiks_no']))/3600);
	}

	$arr = array();
	//echo $stundas_virs."<br>";
	//echo $stundas_pamat;
	$arr['nakts'] = $stundas_nakts;
	$arr['pamat'] = $stundas_pamat;
	$arr['virs'] = $stundas_virs;
	$arr['d'] = $stundas_d;

	return $arr;
}*/

function atskaites_stundas($atskaite_id)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);

	// darba stundas un kop?j?s d?kst?ves
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);

	// dienas s?kumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa vis?m dien?m
	$stundas = 0;
	$stundas_virs = 0;
	$stundas_pamat = 0;

	// cikls pa dien?m
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
		// nosakam cik str?d?ts konkr?taj? dien?
		$t1apr = $i;
		$t2apr = $i+(60*60*24);

		if ($t1apr<$t1) $t1apr = $t1;
		if ($t2apr>$t2) $t2apr = $t2;
		
		// nostr?d?t?s stundas ?aj? dien?
		$stundas = ($t2apr - $t1apr)/3600;
		$rbrivdienas = mysql_query(" select * from brivdienas where datums = '".sqldate($i)."' ");
		if ($mbrivdienas = mysql_fetch_array($rbrivdienas))
		{
			$stundas_virs = $stundas_virs + $stundas;
		}
		else
		{
			if ($stundas>8)
			{
				$stundas_virs = $stundas_virs + $stundas - 8;
				$stundas_pamat = $stundas_pamat + 8;
			}
			else
			{
				$stundas_pamat = $stundas_pamat + $stundas;
			}
		}
	}
	
	$stundas_d = 0 ;
	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$stundas_d = $stundas_d + ((strtotime($md['laiks_lidz']) - strtotime($md['laiks_no']))/3600);
	}

	$arr = array();
	//echo $stundas_virs."<br>";
	//echo $stundas_pamat;
	$arr['pamat'] = $stundas_pamat;
	$arr['virs'] = $stundas_virs;
	$arr['d'] = $stundas_d;

	return $arr;
}

function atskaites_stundas2($atskaite_id,$sakums,$beigas)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);
	// darba stundas un kopējās dīkstāves
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);
	if ($t1 < $sakums) {$t1 = $sakums;}
	if ($t2 > (strtotime(sqldate($beigas)." 23:59:59") + 1) ) {$t2 = (strtotime(sqldate($beigas)." 23:59:59") + 1);}
	//echo $m['ierasanas_darba']." ".$m['darbu_beidz']." ".$atskaite_id." ".$darbastundas." ".$darba_kategorija."<br>";
	// dienas sākumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa visām dienām
	$stundas = 0;
	$stundas_virs = 0;
	$stundas_pamat = 0;

	// cikls pa dienām
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
			// nosakam cik strādāts konkrētajā dienā

			//dienas stundas diennaktī
			$t1apr_d = $i+(60*60*6);
			$t2apr_d = $i+(60*60*22);
			//kopaa stundas diennaktī
			$t1apr = $i;
			$t2apr = $i+(60*60*24);

			if ($t1apr_d<$t1) $t1apr_d = $t1;
			if ($t2apr_d>$t2) $t2apr_d = $t2;

			if ($t1apr<$t1) $t1apr = $t1;
			if ($t2apr>$t2) $t2apr = $t2;
			
			// nostrādātās stundas šajā dienā
			$stundas = ($t2apr - $t1apr)/3600;
			if ($stundas < 0) {$stundas = 0;} 
			//echo " stundas ".$stundas;
			$stundas_d = ($t2apr_d - $t1apr_d)/3600;
			if ($stundas_d < 0) {$stundas_d = 0;} 
			//echo " stundas_d ".$stundas_d;

			$rbrivdienas = mysql_query(" select * from brivdienas where datums = '".sqldate($i)."' ");
			if ($mbrivdienas = mysql_fetch_array($rbrivdienas))
			{
				$stundas_virs = $stundas_virs + $stundas;
			}
			else
			{
				$stundas_pamat = $stundas_pamat + $stundas_d;
				$stundas_nakts = $stundas_nakts + ($stundas - $stundas_d);
			}
			
			/*if (sqldate($i) == '2005-10-30')
			{
				if (sqltime($t1) <= '2005-10-30 03:00:00' and sqltime($t2) >= '2005-10-30 03:00:00')
				{
					$stundas_nakts = $stundas_nakts + 1;
				}
			}*/
	}
	
	$stundas_d = 0 ;
	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$t2 = strtotime($md['laiks_lidz']);
		$t1 = strtotime($md['laiks_no']);
		if ($t1 < $sakums) {$t1 = $sakums;}
		if ($t2 > (strtotime(sqldate($beigas)." 23:59:59") + 1) ) {$t2 = (strtotime(sqldate($beigas)." 23:59:59") + 1);}
		if ($t2 - $t1 > 0)
		{
			$stundas_d = $stundas_d + (($t2 - $t1)/3600);
		}
	}

	$arr = array();
	$arr['pamat'] = $stundas_pamat;
	$arr['nakts'] = $stundas_nakts;
	$arr['d'] = $stundas_d;
	$arr['virs'] = $stundas_virs;
	return $arr;
}

function atskaites_stundas2_pas($atskaite_id,$dd_sakums,$dd_beigas,$d_sakums,$d_beigas)
{
	$m = viens_ieraksts('darba_atskaites',$atskaite_id);
	//****************************** darba dienu nostraadaataas stundas *****************************
	$t2 = strtotime($m['darbu_beidz']);
	$t1 = strtotime($m['ierasanas_darba']);
	//echo $m['ierasanas_darba']." ".$m['darbu_beidz']." ".$atskaite_id." ".$darbastundas." ".$darba_kategorija."<br>";

	// dienas sākumi
	$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
	$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

	// cikls pa visām dienām
	$stundas = 0;
	$stundas_nakts = 0;
	$stundas_pamat = 0;
	$stundas_virs = 0;

	// cikls pa dienām
	for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
	{
		// nosakam cik strādāts konkrētajā dienā

		//dienas stundas diennaktī
		$t1apr_d = $i+(60*60*date("H",strtotime($dd_sakums))+date("i",strtotime($dd_sakums))*60);
		$t2apr_d = $i+(60*60*date("H",strtotime($dd_beigas))+date("i",strtotime($dd_beigas))*60);
		//kopaa stundas diennaktī
		$t1apr = $i;
		$t2apr = $i+(60*60*24);

		if ($t1apr_d<$t1) $t1apr_d = $t1;
		if ($t2apr_d>$t2) $t2apr_d = $t2;

		if ($t1apr<$t1) $t1apr = $t1;
		if ($t2apr>$t2) $t2apr = $t2;
		
		// nostrādātās stundas šajā dienā
		$stundas = ($t2apr - $t1apr)/3600;
		if ($stundas < 0) {$stundas = 0;} 
		//echo " stundas ".$stundas;
		$stundas_d = ($t2apr_d - $t1apr_d)/3600;
		if ($stundas_d < 0) {$stundas_d = 0;} 
		//echo " stundas_d ".$stundas_d;

		$rbrivdienas = mysql_query(" select * from brivdienas where datums = '".sqldate($i)."' ");
		if (($mbrivdienas = mysql_fetch_array($rbrivdienas)) or (date("w",$i) == 0 or date("w",$i) == 6))
		{
			$stundas_nakts = $stundas_nakts + $stundas;
		}
		else
		{
			$stundas_pamat = $stundas_pamat + $stundas_d;
			$stundas_nakts = $stundas_nakts + ($stundas - $stundas_d);
		}
	}
	
	//********************************** diikstaavju stundas *********************************
	$stundas = 0;
	$stundas_nakts_d = 0;
	$stundas_pamat_d = 0;
	$stundas_virs_d = 0;

	$rd = mysql_query("select * from dikstaves where darba_atskaites_id = ".$atskaite_id);
	while ($md = mysql_fetch_array($rd))
	{
		$t2 = strtotime($md['laiks_lidz']);
		$t1 = strtotime($md['laiks_no']);
		//echo $m['ierasanas_darba']." ".$m['darbu_beidz']." ".$atskaite_id." ".$darbastundas." ".$darba_kategorija."<br>";

		// dienas sākumi
		$t10 = mktime(0,0,0,date('m',$t1),date('d',$t1),date('Y',$t1));
		$t20 = mktime(0,0,0,date('m',$t2),date('d',$t2),date('Y',$t2));

		// cikls pa dienām
		for ($i = $t10;$i<=$t20;$i=$i+(60*60*24))
		{
			// nosakam cik strādāts konkrētajā dienā

			//dienas stundas diennaktī
			$t1apr_d = $i+(60*60*date("H",strtotime($d_sakums))+date("i",strtotime($d_sakums))*60);
			$t2apr_d = $i+(60*60*date("H",strtotime($d_beigas))+date("i",strtotime($d_beigas))*60);
			//kopaa stundas diennaktī
			$t1apr = $i;
			$t2apr = $i+(60*60*24);

			if ($t1apr_d<$t1) $t1apr_d = $t1;
			if ($t2apr_d>$t2) $t2apr_d = $t2;

			if ($t1apr<$t1) $t1apr = $t1;
			if ($t2apr>$t2) $t2apr = $t2;
			
			// nostrādātās stundas šajā dienā
			$stundas = ($t2apr - $t1apr)/3600;
			if ($stundas < 0) {$stundas = 0;} 
			//echo " stundas ".$stundas;
			$stundas_d = ($t2apr_d - $t1apr_d)/3600;
			if ($stundas_d < 0) {$stundas_d = 0;} 
			//echo " stundas_d ".$stundas_d;

			$rbrivdienas = mysql_query(" select * from brivdienas where datums = '".sqldate($i)."' ");
			if (($mbrivdienas = mysql_fetch_array($rbrivdienas)) or (date("w",$i) == 0 or date("w",$i) == 6))
			{
				$stundas_nakts_d = $stundas_nakts_d + $stundas;
			}
			else
			{
				$stundas_pamat_d = $stundas_pamat_d + $stundas_d;
				$stundas_nakts_d = $stundas_nakts_d + ($stundas - $stundas_d);
			}
		}
		$stundas_d = $stundas_d + ((strtotime($md['laiks_lidz']) - strtotime($md['laiks_no']))/3600);
	}

	$arr = array();
	$arr['pamat'] = $stundas_pamat;		  //pamatstundas nereekjinot aaraa diikstaaves, taču rekinot aaraa sv un bri
	$arr['nakts'] = $stundas_nakts;		  //naktsstundas nereekjinnot aaraa diisktaaves, tacu rekiot aaraa sv un bri
	$arr['pamat_d'] = $stundas_pamat_d;   //diikstaaves dienaa, taču rekinot aaraa sv un bri
	$arr['nakts_d'] = $stundas_nakts_d;	  //diikstaaves naktii, taču rekinot aaraa sv un bri
	//$arr['virs'] = $stundas_virs;		  //nostraadaataas stundas sveetkudienaas un briibdienaas
	//$arr['virs_d'] = $stundas_virs_d;     //diikstaaves sveetkudienaas un briivdienaas
	return $arr;
}
?>