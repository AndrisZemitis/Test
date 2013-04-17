<?
//$conn = mysql_connect('localhost','root','root') or die('Nevar pieslēgties datubāzei!');
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

function do_sql($q,$c) 
{
 echo "Izpildām: $q <br>";
 $res = mysql_query($q,$c);
 if($res) {echo "OK<br>";} else { echo "Error<br>";exit;}
}

$query = "select vertiba from parametrs where nosaukums='versija'";
$res = mysql_query($query);
if ($res = mysql_fetch_array($res))
{
	$versija =  $res['vertiba'];
}
echo "Versija: $versija <br><hr>";
//--------------------------------------------------------------------------------
if($versija=='1.20')
{
 $query = "UPDATE parametrs SET vertiba='1.25' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if($versija=='1.25')
{
 $query = "UPDATE parametrs SET vertiba='1.27' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
/* izlabota ielādes kļūda LVM - tukšie datumi*/

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if($versija=='1.27')
{
 $query = "UPDATE parametrs SET vertiba='1.28' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
/* izlabota ielādes kļūda XML - <RevusedReason> nebija vērtības pie parastā brāķa*/

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if((double)$versija<'1.30')
{
 $query = "UPDATE parametrs SET vertiba='1.30' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
/* pievienotd dinamiskā redukcija - atkarībā no baļķa diametra pirms redukcijas, tiek pielietots atbilstošs koeficents, var uzrādīt katrai sugai savas vērtības*/

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if((double)$versija<'1.31')
{
 $query = "UPDATE parametrs SET vertiba='1.31' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
/* pievienotd dinamiskā redukcija - atkarībā no baļķa diametra pirms redukcijas, tiek pielietots atbilstošs koeficents, var uzrādīt katrai sugai savas vērtības*/

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if((double)$versija<'1.32')
{
 $query = "UPDATE parametrs SET vertiba='1.32' WHERE nosaukums='versija'";
 do_sql($query, $conn);
}
/* Batch parsers pielabots - lai dzēš nevajadzīgās pavadzīmes un XML dod 0-79 MALKA*/

//--------------------------------------------------------------------------------
$query = "select vertiba from parametrs where nosaukums='versija'";
$res = mysql_query($query);
if ($res = mysql_fetch_array($res))
{
	$versija =  $res['vertiba'];
}

echo "<hr>Versija: $versija ";

?>