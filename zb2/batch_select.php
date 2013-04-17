<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;
/*
if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}
*/
menu($_GET['h']);
$h = $_GET['h'];
?>
<style>
.normal {color:white; font-family:arial; size:12pt; text-decoration: none;}
.normal:hover {color:yellow; font-family:arial; size:12pt; text-decoration: none;}
.head {color:white; size:24pt; font-weight:bold;}
</style>
<html>
<head>
<title>VMF</title>
</head>
<body>

          <table cellspacing=0 cellpadding=0 border=0 width=300 align=center>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=26" class="normal">Visi</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=27" class="normal">Akrs</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=33" class="normal">AKZ</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=28" class="normal">BSW</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=29" class="normal">Gaujas Koks</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=30" class="normal">Inčukalns</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=31" class="normal">Kurekss</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=32" class="normal">Laiko</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=41" class="normal">Latvijas Finieris</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=47" class="normal">Ošukalni</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=34" class="normal">Smiltene</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=39" class="normal">Stora Enso Timber</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=51" class="normal">Tezei-S</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=37" class="normal">Pata AB</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=45" class="normal">Piebalgas</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=35" class="normal">Vika Wood</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=36" class="normal">Vudlande</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="GenCLS_list.php?h=49" class="normal">4 Plus</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          </table>
</html>