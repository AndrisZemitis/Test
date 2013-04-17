<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;
//print_r($mlietotajs);
menu($_GET['h']); 
?>