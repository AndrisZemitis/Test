<?

global $conn;

define (DATABASE, 'vmf');
define (PWD,'root');
define (LOGIN,'root');
$conn = mysql_connect('localhost',LOGIN,PWD)  or die('Nevar pieslēgties datubāzei!');

mysql_select_db(DATABASE);

global $sugas;
$sugas = array();
$sugas['1'] = 'Priede';
$sugas['2'] = 'Egle';

global $braki;
$braki = array();
$braki['000'] = 'Metāls';
$braki['001'] = 'Par garu';
$braki['002'] = 'Par resnu max diam.';
$braki['003'] = 'Par resnu tievgalis';
$braki['004'] = 'Trupe, lielainums';
$braki['005'] = 'Saussānis';
$braki['006'] = 'Zari';
$braki['007'] = 'Līkumainība';
$braki['008'] = 'Citi';
$braki['009'] = 'Par īsu';
$braki['010'] = 'Par tievu';
$braki['012'] = 'Līkumainība';
$braki['016'] = 'Diametra neatbilstība';
$braki['017'] = 'Garuma neatbilstība';
$braki['255'] = '';

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

	function init()
	{
		$this->bruto = 0;
		$this->virsmers = 0;
		$this->redukcija_d = 0;
		$this->redukcija_l = 0;
		$this->brakis = 0;
		$this->neto = 0;
		$this->skaits = 0;
	}

	function add_skaits($x)
	{
		$this->skaits = $x+$this->skaits;
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
  $t[4]="XML atskaite (LVM)"; 
  $t[5]="Ielasītās pavadzīmes"; 
  $t[6]="Atskaite Bruto";
	
	?>
	<body>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Atskaites un rēķini&nbsp;&nbsp;&nbsp;&nbsp;[Versija:<?=get_param('versija')?>]</title>
	</head>
	<style>
		a {color: #016734;}
		.head {color:white; font-weight:bold};
	</style>

	<center>
	<TABLE width="100%" border=0 background='images/head_bg.gif'>
	
	<TR>
	<TD align=center valign=middle>
	
	<table>
	<tr><td><a href=''><img src=images/logo.gif border=0></a>&nbsp;&nbsp;</td>
	<td><font color=white size=5>
	[ <a href=batch_upload.php?h=1 class='head'><?=$t[1]?></a> ]&nbsp;&nbsp;&nbsp;
	[ <a href=batch_list.php?h=2 class='head'><?=$t[2]?></a> ]&nbsp;&nbsp;&nbsp;
	[ <a href=report.php?h=3 class='head'><?=$t[3]?></a> ]&nbsp;&nbsp;&nbsp;
	[ <a href=report_bruto.php?h=6 class='head'><?=$t[6]?></a> ]&nbsp;&nbsp;&nbsp;
	[ <a href=report_xml.php?h=4 class='head'><?=$t[4]?></a> ]
	</font></td>
	</tr>
	</table>

	</TD>
	</TR>
	</TABLE>
	<h2>
	<?=$t[$h]?>
	</h2></center>
	<br>
<?	
}

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

function set_param($param,$value)
{
	$r = mysql_query("select * from parametrs where nosaukums = '$param'");
	if ($m = mysql_fetch_array($r))
		mysql_query("update parametrs set vertiba = '$value' where nosaukums = '$param'");
	else
		mysql_query("insert into parametrs (vertiba,nosaukums) values ('$value','$param')");
}

function get_param($param)
{
	$r = mysql_query("select * from parametrs where nosaukums = '$param'");
	if ($m = mysql_fetch_array($r))
		return $m['vertiba'];
	else
		return '';
}
function GetFromPavadzime($pavadzime, $value)
{ $pavadzime=trim($pavadzime);
	$value=trim($value);
	$r = mysql_query("select $value from pavadzime where pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m[$value];
	else
		return false;
}

function GetFromPavadzimeID($pavadzime_id, $value)
{ $pavadzime_id=trim($pavadzime_id);
	$value=trim($value);
	$r = mysql_query("select $value from pavadzime where id = $pavadzime_id");
	if ($m = mysql_fetch_array($r))
		return $m[$value];
	else
		return false;
}


function GetPavadzimeDatums($pavadzime)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select max(datums_laiks) as dat from balkis,pavadzime where balkis.pavadzime =pavadzime.id and pavadzime.pavadzime = '$pavadzime'");
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
		if (($x[$i][diam_no]<=$diam) && ($diam<=$x[$i][diam_lidz])) $ret = $x[$i][koef];
	}
	return $ret;
}

function GetUzmerisanasDatums($pavadzime)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select min(datums_laiks) as dat from balkis,pavadzime where balkis.pavadzime =pavadzime.id and pavadzime.pavadzime = '$pavadzime'");
	if ($m = mysql_fetch_array($r))
		return $m['dat'];
	else
		return false;
}

function GetUzmerisanasDatumsID($pavadzime_id)
{ $pavadzime=trim($pavadzime);
	$r = mysql_query("select min(datums_laiks) as dat from balkis,pavadzime where balkis.pavadzime =pavadzime.id and pavadzime.id = $pavadzime_id");
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
/*	function begin_trans() {
		$this->tr_h = @mysql_trans(IBASE_DEFAULT, $this->db_h);
		$this->log_err_query("");
		return $this->tr_h;
	}
	function commit() {
		return @ibase_commit($this->tr_h);
	}
	function rollback() {
		return @ibase_rollback($this->tr_h);
	}	
	function trans_query($q) {
		$this->st_h = @ibase_query($this->tr_h, $q);
		$this->log_err_query($q);
		return $this->st_h;
	}	*/
	function query($q) {
		$this->st_h = mysql_query($q,$this->db_h);

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
