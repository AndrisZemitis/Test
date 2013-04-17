<? 
ob_start(); /* Otherwise buffer is flushed before headers */

include ("db.inc.php");
include ("../classes/mernieku_atskaite.class.php");
include ("../check_login.php");
//if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}


$MerniekuDati_Export = new MerniekuDati_Export();
$MerniekuDati_Export->export();

/* Finalization */
ob_end_clean();
/* Real data export */
$MerniekuDati_Export->download();
?>