<?
error_reporting(0);

global $conn;

define (DATABASE, 'vmf_reporting');
define (PWD,'Aecheis6Eiz4ighi');
define (LOGIN,'vmf_report_adm');
$conn = mysql_connect('localhost',LOGIN,PWD)  or die('Nevar pieslēgties datubāzei!');
mysql_select_db(DATABASE);

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");

global $sugas;
$sugas = array();
$sugas['0'] = 'Skuju koks';
$sugas['1'] = 'Priede';
$sugas['2'] = 'Egle';
$sugas['4'] = 'Bērzs';
$sugas['5'] = 'Apse';
$sugas['6'] = 'Osis';
$sugas['7'] = 'Alksnis';
$sugas['8'] = 'Ozols';
/*
global $braki;
$braki = array();
$braki['000'] = 'Met�ls';
$braki['001'] = 'Par garu';
$braki['002'] = 'Par resnu max diam.';
$braki['003'] = 'Par resnu tievgalis';
$braki['004'] = 'Trupe, lielainums';
$braki['005'] = 'Sauss�nis';
$braki['006'] = 'Zari';
$braki['007'] = 'L�kumain�ba';
$braki['008'] = 'Citi';
$braki['009'] = 'Par �su';
$braki['010'] = 'Par tievu';
$braki['012'] = 'L�kumain�ba';
$braki['016'] = 'Diametra neatbilst�ba';
$braki['017'] = 'Garuma neatbilst�ba';
$braki['255'] = '';
*/
//VMF kods pret LVM kodu
$LVM_braki= array();
$LVM_braki['000'] = 'M';
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



$LVM_sugas = array();
$LVM_sugas['1'] = 'P';
$LVM_sugas['2'] = 'E';


class CSumma
{
	var $bruto;
	var $virsmers;
	var $redukcija_d;
	var $redukcija_l;
	var $brakis;
	var $neto;
	var $skaits;
	var $skaits_bad;

	function init()
	{
		$this->bruto = 0;
		$this->virsmers = 0;
		$this->redukcija_d = 0;
		$this->redukcija_l = 0;
		$this->brakis = 0;
		$this->neto = 0;
		$this->skaits = 0;
		$this->skaits_bad = 0;
	}

	function add_skaits($x)
	{
		$this->skaits = $x+$this->skaits;
	}

	function add_skaits_bad($x)
	{
		$this->skaits_bad = $x+$this->skaits_bad;
	}

	function add_virsmers($x)
	{
		$this->virsmers = round($this->virsmers + $x,3);
	}

	function add_redukcija_d($x)
	{
		$this->redukcija_d = round($this->redukcija_d + $x,3);
	}

	function add_redukcija_l($x)
	{
		$this->redukcija_l = round($this->redukcija_l + $x,3);
	}

	function add_brakis($x)
	{
		$this->brakis = round($this->brakis + $x,3);
	}

	function add_neto($x)
	{
		$this->neto = round($this->neto + $x,3);
	}

	function add_bruto($x)
	{
		$this->bruto = round($this->bruto + $x,3);
	}

	function get_skaits()
	{
		return $this->skaits;
	}
	function get_bruto()
	{
		return $this->bruto;
	}
}


function menu($h=0)
{ $h=(int)$h;

  $t = array();
  $t[1]="Faila ielasīšana";
  $t[2]="Ielasītie dati";
  $t[3]="Atskaite"; 
  $t[4]="Kolektīva info"; 
  $t[5]="Ielasītās pavadzīmes"; 
  $t[6]="Atskaite Bruto";
  $t[7]="Gosti";
  $t[8]="Atskaite";
  $t[9]="Atskaite(AKZ)";
  $t[12]="Atskaite(Vika)";
  $t[13]="Atskaite(Laiko)";
  $t[14]="Atskaite(Akrs)";
  $t[11]="XML Atskaite";
  $t[10]="Atskaite(Inčukalns)"; 
  $t[17]="Atskaite(Kurekss)"; 
  $t[15]="Faila ielasīšana(Inčukalns)";
  $t[16]="Faila ielasīšana(Kurekss)";
  $t[19]="Atskaites";
  $t[20]="Atskaite(Gaujas Koks)";
  $t[21]="Atskaite(Smiltene)";
  $t[22]="Atskaite(BSW)";
  $t[23]="Atskaite(Inčukalns)";
  $t[24]="Atskaite(Kurekss)";
  $t[25]="Atskaite(Vudlande)";
  $t[26]="Visi";
  $t[27]="Akrs";
  $t[28]="BSW";
  $t[29]="Gaujas Koks";
  $t[30]="Incukalns";
  $t[31]="Kurekss";
  $t[32]="Laiko";
  $t[33]="AKZ";
  $t[34]="Smiltene";
  $t[35]="Vika Wood";
  $t[36]="Vudlande";
  $t[37]="Pata AB";
  $t[38]="Atskaite(Pata AB)";
  $t[39]="Stora Enso Timber";
  $t[40]="Atskaite(Stora Enso Timber)";
  $t[41]="Latvijas Finieris";
  $t[42]="Atskaite(Latvijas Finieris)";
  $t[43]="Datu reģistrs";
  $t[44]="Datu filtrs";
  $t[45]="Piebalgas";
  $t[46]="Atskaite(Piebalgas)";  
  $t[47]="Ošukalni";  
  $t[48]="Atskaite(Ošukalni)";
  $t[49]="4 Plus";  
  $t[50]="Atskaite(4 Plus)";
  $t[51]="Tezei-S";  
  $t[52]="Atskaite(Tezei-S)";  
  $t[55]="Vārpas 1";  
  $t[56]="Atskaite(Vārpas 1)"; 
  $t[57]="Kubikmetrs";  
  $t[58]="Atskaite(Kubikmetrs)"; 
  $t[59]="Jēkabpils MR";  
  $t[60]="Atskaite(Jēkabpils MR)";
  $t[61]="Latvāņi";  
  $t[62]="Atskaite(Latvāņi)";   
  $t[63]="Timberex Group";  
  $t[64]="Atskaite(Timberex Group)";   
  
	?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Atskaites un rēķini&nbsp;&nbsp;&nbsp;&nbsp;[Versija:<?=get_param('versija')?>]</title>
	</head>
	<style>
		a {color: #016734;}
		.head {color:white; font-weight:bold};
	</style>

	<center>
	<table width="100%" border=0 background='images/head_bg.gif'>
	<tr>
    <td align=center valign=middle>
      <table>
        <tr>
          <td><a href='http://www.vmf.lv/main_menu.php'><img src=images/logo.gif border=0></a>&nbsp;&nbsp;</td>
          <td>
            <font color=white size=4>
            [ <a href=batch_upload.php?h=1 class='head'><?=$t[1]?></a> ]&nbsp;
            [ <a href=GenCLS_list.php?h=2 class='head'><?=$t[2]?></a> ]&nbsp;
<!--            [ <a href=batch_filter.php?h=44 class='head'><?=$t[44]?></a> ]&nbsp; -->
            [ <a href=report_select.php?h=19 class='head'><?=$t[19]?></a> ]&nbsp;
            [ <a href=datu_registrs.php?h=43 class='head'><?=$t[43]?></a> ]&nbsp;
            [ <a href=clsKolektivs.php?h=4 class='head'><?=$t[4]?></a> ]
            [ <a href=report_bruto.php?h=6 class='head'><?=$t[6]?></a> ]&nbsp;
            [ <a href=gosti.php?h=7 class='head'><?=$t[7]?></a> ]&nbsp;
            </font>
          </td>
        </tr>
      </table>
	<td>
	</tr>
	</table>
	<h2>
    <?=$t[$h]?>
	</h2>
  </center>
	<br>
<?	
}

// vec� funkcijas kas ne�em gostu tabulas
function f($d,$l,$raukums,$koeficients)
{
	$pi = 3.1416;

	if ((double)$raukums!=0)
	{
		$d = $d * 100;
		$r = ($pi * ( ($d*$d) + ($d+($raukums*$l))*($d+($raukums*$l)) ) * $l) / (8*10000);
		return round($r,3);
	}
	$r = $pi*$d*$d*$l/4;
	if ($koeficients!='')
		return round($r*$koeficients,3);

	return round($r,3);
}

// jaun� funkcijas kas var izmantot ar� gostu tabulas

function KopTilpums(){
	// gostu tabulas mas�vs
	global $gosti;
	global $cgosti;

	$result = -1;
	if (!$gostu_tabula)
	{
		// apr��ins p�c formulas
		$pi = 3.1416;
          $r = $pi*$d*$d*$l/4;
          $result = round($r,3);

	}
	else
	{
		// apr��ins p�c gostu tabulas
		if (!($gosti)){
			load_gosti($gostu_tabula);
			$cgosti=count($gosti);
		}

		// atrodam tuv�ko gostu kam minimumi ir maz�ki par mekl�jamo izm�ru
		$solis = round($cgosti/4);
		$pos = round($cgosti/2);
		$solis_1 = 0; // skaita cik cik solis = 1;
		while ($solis_1<3)
		{
			if ($pos<0) $pos=0;
			if ($pos>$cgosti-1) $pos=$cgosti-1;

			if ($gosti[$pos]['g_max']<$l)
			{
				$pos=$pos+$solis;
			}
			else if ($gosti[$pos]['g_min']>$l)
			{
				$pos=$pos-$solis;
			}
			else
			{
				if ($gosti[$pos]['d_max']<$d)
				{
					$pos=$pos+$solis;
				}
				else if ($gosti[$pos]['d_min']>$d)
				{
					$pos=$pos-$solis;
				}
				else
				{
					if ($gosti[$pos]['g_min']<=$l && $gosti[$pos]['g_max']>=$l)
						if ($gosti[$pos]['d_min']<=$d && $gosti[$pos]['d_max']>=$d)
							$result = $gosti[$pos]['tilpums'];
				}
			}
			$solis = round($solis/2);
			if ($solis<1) $solis=1;
			if ($solis==1) $solis_1++;
		}

		$result = -1;
	}
	return $result;

}



function f2_mod($d,$l,$raukums,$koeficients,$gostu_tabula)
{
	// gostu tabulas mas�vs
	global $gosti;
	global $cgosti;

//	echo $d . ';' . $l . '<br />';
	
	$result = -1;


	if (!$gostu_tabula)
	{
		// apr��ins p�c formulas
		$pi = 3.1416;
          $r = $pi*$d*$d*$l/4;
          $result = round($r,3);

	}
	else
	{
		// apr��ins p�c gostu tabulas
		if (!($gosti)) 
		{
			// ielasam gostu tabulu glob�laj� main�gaj�
			load_gosti($gostu_tabula);
			// izskat�s ka count str�d� l�ni t�de� saglab�jam v�rt�bu
			$cgosti=count($gosti);
		}

		
		// atrodam tuv�ko gostu kam minimumi ir maz�ki par mekl�jamo izm�ru
		$solis = round($cgosti/4);
		$pos = round($cgosti/2);
		$solis_1 = 0; // skaita cik cik solis = 1;
		while ($solis_1<3)
		{
			if ($pos<0) $pos=0;
			if ($pos>$cgosti-1) $pos=$cgosti-1;

			if ($gosti[$pos]['g_max']<$l)
			{
				$pos=$pos+$solis;
			}
			else if ($gosti[$pos]['g_min']>$l)
			{
				$pos=$pos-$solis;
			}
			else
			{
				if ($gosti[$pos]['d_max']<$d)
				{
					$pos=$pos+$solis;
				}
				else if ($gosti[$pos]['d_min']>$d)
				{
					$pos=$pos-$solis;
				}
				else
				{
					if ($gosti[$pos]['g_min']<=$l && $gosti[$pos]['g_max']>=$l)
						if ($gosti[$pos]['d_min']<=$d && $gosti[$pos]['d_max']>=$d)
							$result = $gosti[$pos]['tilpums'];
				}
			}
			$solis = round($solis/2);
			if ($solis<1) $solis=1;
			if ($solis==1) $solis_1++;
		}

		//for ($i=0;$i<count($gosti);$i++)
		//	if ($gosti[$i]['g_min']<=$l && $gosti[$i]['g_max']>=$l)
		//		if ($gosti[$i]['d_min']<=$d && $gosti[$i]['d_max']>=$d)
		//			return $gosti[$i]['tilpums'];
		//echo 'garums:'.$l;
		//echo 'diam:'.$d.'<BR>';
		$result = -1;
	}
	//echo $d . ';' . $l  . ';' . $result . '<br />';
	return $result;
}

function f2_mod_3($d_tiev,$d_resn,$l,$raukums,$koeficients,$gostu_tabula)
{
	
	$result = -1;

		// apr��ins p�c formulas
      $pi = 3.1416;
			$d_tiev = $d_tiev * 10;
			$d_resn = $d_resn * 10;
			
          $r = ($pi * (($d_tiev * $d_tiev) + ($d_resn * $d_resn)) * $l) / (4 * 2 * 100);
          $result = round($r,3);

//	echo $d_tiev . ';' . $d_resn .';' . $l  . ';' . $result . '<br />','<br />';
	
	return $result;
}

function f2($d,$l,$raukums,$koeficients,$gostu_tabula)
{
	// gostu tabulas mas�vs
	global $gosti;
	global $cgosti;

	//echo $d . ';' . $l . ';' . $raukums . ';' . $koeficients . ' = ';
	
	$result = -1;

	if (!$gostu_tabula)
	{
		// apr��ins p�c formulas
		$pi = 3.1416;

		if ((double)$raukums!=0)
		{
			$d = $d * 100;
			$r = ($pi * ( ($d*$d) + ($d+($raukums*$l))*($d+($raukums*$l)) ) * $l) / (8*10000);
/*
			echo "r = ".$r.'<br/>';
			echo "d = ".$d.'<br/>';
			echo "raukums = ".$raukums.'<br/>';
			echo "l = ".$l.'<br/>';
			echo "pi = ".$pi.'<br/>';
			echo "result => ".$result.'<br/>','<br/>','<br/>';
*/
			$result = round($r,3);
		} else {
      $r = $pi*$d*$d*$l/4;
      if ($koeficients!='') {
        $result = round($r*$koeficients,3);
      } else {
        $result = round($r,3);
      }
	  
		}
		//echo $result . '<br />';
	}
	else
	{
		// apr��ins p�c gostu tabulas
		if (!($gosti)) 
		{
			// ielasam gostu tabulu glob�laj� main�gaj�
			load_gosti($gostu_tabula);
			// izskat�s ka count str�d� l�ni t�de� saglab�jam v�rt�bu
			$cgosti=count($gosti);
		}

		
		// atrodam tuv�ko gostu kam minimumi ir maz�ki par mekl�jamo izm�ru
		$solis = round($cgosti/4);
		$pos = round($cgosti/2);
		$solis_1 = 0; // skaita cik cik solis = 1;
		while ($solis_1<3)
		{
			if ($pos<0) $pos=0;
			if ($pos>$cgosti-1) $pos=$cgosti-1;

			if ($gosti[$pos]['g_max']<$l)
			{
				$pos=$pos+$solis;
			}
			else if ($gosti[$pos]['g_min']>$l)
			{
				$pos=$pos-$solis;
			}
			else
			{
				if ($gosti[$pos]['d_max']<$d)
				{
					$pos=$pos+$solis;
				}
				else if ($gosti[$pos]['d_min']>$d)
				{
					$pos=$pos-$solis;
				}
				else
				{
					if ($gosti[$pos]['g_min']<=$l && $gosti[$pos]['g_max']>=$l)
						if ($gosti[$pos]['d_min']<=$d && $gosti[$pos]['d_max']>=$d)
							$result = $gosti[$pos]['tilpums'];
				}
			}
			$solis = round($solis/2);
			if ($solis<1) $solis=1;
			if ($solis==1) $solis_1++;
		}

		//for ($i=0;$i<count($gosti);$i++)
		//	if ($gosti[$i]['g_min']<=$l && $gosti[$i]['g_max']>=$l)
		//		if ($gosti[$i]['d_min']<=$d && $gosti[$i]['d_max']>=$d)
		//			return $gosti[$i]['tilpums'];
		//echo 'garums:'.$l;
		//echo 'diam:'.$d.'<BR>';
		$result = -1;
	}
	//echo $d . ';' . $l  . ';' . $result . '<br />';
	return $result;
}

function load_gosti($gt)
{
	global $gosti;
	$r = mysql_query("select * from gostu_dati where tabula = $gt order by g_min, d_min ");
	$i = 0;
	$gosti = array();
	while ($m=mysql_fetch_array($r))
	{
		$gosti[$i] = array();
		$gosti[$i]['d_min'] = $m['d_min'];
		$gosti[$i]['d_max'] = $m['d_max'];
		$gosti[$i]['g_min'] = $m['g_min'];
		$gosti[$i]['g_max'] = $m['g_max'];
		$gosti[$i]['tilpums'] = $m['tilpums'];
		$i++;
	}
}

function set_param($param,$value)
{
	$user_id = $_SESSION['lid'];
	$atskaites_id = $_GET['h'];
//	echo "Atskaites ID = ".$atskaites_id.'<br/>';
	
	$r = mysql_query("select * from parametrs where nosaukums = '$param' and user_id = '$user_id' and atskaites_id = '$atskaites_id'");
	if ($m = mysql_fetch_array($r)){
		mysql_query("update parametrs set vertiba = '$value' where nosaukums = '$param' and user_id = '$user_id' and atskaites_id = '$atskaites_id'");
	
	}else{
		mysql_query("insert into parametrs (vertiba,nosaukums,user_id,atskaites_id) values ('$value','$param','$user_id','$atskaites_id')");
     }
}

function get_param($param)
{
//	$r = mysql_query("select * from parametrs where nosaukums = '$param'");
	$user_id = $_SESSION['lid'];
     $atskaites_id = $_GET['h'];
//	echo "Lietotaja nr. =".$user_id.'<br />';

	$r = mysql_query("select * from parametrs where nosaukums = '$param' and user_id = '$user_id' and atskaites_id = '$atskaites_id'");
	
	if ($m = mysql_fetch_array($r))
		return $m['vertiba'];
	else
		return '';
}

function get_param_selected($param,$value)
{
	$user_id = $_SESSION['lid'];
//	echo "Lietotaja nr. =".$user_id.'<br />';

	$r = mysql_query("select * from parametrs where nosaukums = '$param' and user_id = '$user_id' and atskaites_id = '$atskaites_id'");
	$m = mysql_fetch_array($r);
	if ($m['vertiba'] == '0' && $value == '0') echo "selected";
	if ($m['vertiba'] == '1' && $value == '1') echo "selected";
	if ($m['vertiba'] == '2' && $value == '2') echo "selected";
	if ($m['vertiba'] == '3' && $value == '3') echo "selected";
	if ($m['vertiba'] == '4' && $value == '4') echo "selected";
}

function get_param_checked($nosaukums,$atskaites_veids){
     if($nosaukums == 'noapalot_garumu'){
          if($atskaites_veids == 'laiko' || $atskaites_veids == 'nelss' || $atskaites_veids == 'vika'){
               echo "checked";
          }
     }elseif($nosaukums == 'is_vika'){
          if($atskaites_veids == 'vika'){
               echo "checked";
          }
     }
}

function GetFromPavadzime($pavadzime, $value,$tbl = 'vikawood_pavadzime')
{ 
//  die('Hello');
  $pavadzime=trim($pavadzime);
	$value=trim($value);
	$r = mysql_query("select $value from `$tbl` where opcija = 'A' AND pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m[$value];
	else
		return false;
}

function GetFromPavadzimeAKRS($pavadzime, $value,$tbl = 'pavadzime')
{ 
//  die('Hello');
  $pavadzime=trim($pavadzime);
	$value=trim($value);
	$r = mysql_query("select $value from `$tbl` where opcija = 'A' AND pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m[$value];
	else
		return false;
}

function GetFromPavadzimeID($pavadzime_id, $value, $pavadzime_table = 'pavadzime')
{
  $pavadzime_id=trim($pavadzime_id);
	$value=trim($value);
	$r = mysql_query("select $value from $pavadzime_table where id = $pavadzime_id");
	if ($m = mysql_fetch_array($r))
		return $m[$value];
	else
		return false;
}


function GetPavadzimeDatums($pavadzime)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select max(datums_laiks) as dat from balkis,pavadzime where balkis.pavadzime =pavadzime.id and pavadzime.opcija = 'A' AND pavadzime.pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m['dat'];
	else
		return false;
}

function GetPavadzimeDatumsID($pavadzime_id)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select max(datums_laiks) as dat from balkis,pavadzime where balkis.pavadzime =pavadzime.id and pavadzime.id = $pavadzime_id");
	if ($m = mysql_fetch_array($r))
		return $m['dat'];
	else
		return false;
}


function GetIdents($tabula)
{ 
	mysql_query("begin");
	$r = mysql_query("select id from idents where nosaukums='$tabula'");
	$v = mysql_fetch_array($r);
	$v0 = (int)$v['id'];
	$r = mysql_query("update idents set id = id+1 where nosaukums='$tabula'");
	$r = mysql_query("select id from idents where nosaukums='$tabula'");
	$v = mysql_fetch_array($r);
	$v1 = (int)$v['id'];

	if($v0+1 ==$v1 )
	{
			mysql_query("commit");
			return $v1;
	}

	mysql_query("rollback");
	return -1;
}

function raukums_2_array($x) {
	$y = array();
	$x1 = explode(',',$x);
	$i=0;
	foreach ($x1 as $val) {
		if (ereg('(-)+',$val)) {
			$z=explode('-',$val);
			$y[$i][diam_no]= (int)$z[0];
			$y[$i][diam_lidz]= (int)$z[1];
			$i++;
		} else {
			$y[$i][koef]=(double)$val;
		}
	}
	return $y;
}

function get_raukums_no_diam($x,$diam) {
	$ret = 0;
	for($i=0;$i<count($x);$i++){ 
		if (($x[$i][diam_no]<=$diam) && ($diam<=$x[$i][diam_lidz])) 
		{
			$ret = $x[$i][koef];
		}
	}
	return $ret;
}

function GetUzmerisanasDatums($pavadzime)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select min(datums_laiks) as dat from vikawood_balkis,vikawood_pavadzime where vikawood_balkis.pavadzime =vikawood_pavadzime.id and vikawood_pavadzime.opcija = 'A' AND vikawood_pavadzime.pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m['dat'];
	else
		return false;
}

function GetUzmerisanasDatumsID($pavadzime_id)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select min(datums_laiks) as dat from vikawood_balkis,vikawood_pavadzime where vikawood_balkis.pavadzime =vikawood_pavadzime.id and vikawood_pavadzime.id = $pavadzime_id");
	if ($m = mysql_fetch_array($r))
		return $m['dat'];
	else
		return false;
}


class C_DB {
	var $db_h;
	var $st_h;
	var $connected;
	var $tr_h;

	function C_DB($loc, $database, $user, $pass) {
		$this->connected=true;
		$this->db_h = @mysql_connect($loc, $user, $pass) or $this->connected=false;
		if($this->connected)
		{
			mysql_select_db($database,$this->db_h) or $this->connected=false;
		} 
		return $this->db_h; 
	}

	function query($q) {
		// $this->st_h = mysql_query($q,$this->db_h);
		$this->st_h = mysql_query($q);

		return $this->st_h;
	}
	function get_row($h=false) {
		if ($h) return @mysql_fetch_array($h);
		return @mysql_fetch_array($this->st_h);
	}
	function num_fields() {
    	return @mysql_num_fields($this->st_h);
	}
	/*function field_info($i) {
    	return @mysql_field_info($this->st_h, $i);
	}*/
	function close() {
		@mysql_close($this->db_h);
	}
	
}


if(!function_exists('file_put_contents')) {
  function file_put_contents($filename, $data, $file_append = false) {
   $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
   if(!$fp) {
     trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);
     return;
   }
   fputs($fp, $data);
   fclose($fp);
  }
} 

if(!function_exists('file_get_contents')) {
   function file_get_contents($file) {
       $file = file($file);
       return !$file ? false : implode('', $file);
   }
}
?>
