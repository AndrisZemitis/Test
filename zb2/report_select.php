<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

menu($_GET['h']);
$h = $_GET['h'];

$report_file_url = "report_test.php";

// New version
$report_file_url = "report_test_2.php";
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
               <td bgcolor=#0000EE align=center>
                    <a href="<?=$report_file_url?>?h=14" class="normal">Vecā atskaite</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=14" class="normal">Kontrolmērījumi u.c.</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=9" class="normal">SIA "AKZ"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=22" class="normal">SIA "BSW Latvia"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=20" class="normal">SIA "Gaujas Koks"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=23" class="normal">SIA "Inčukalns Timber"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=60" class="normal">SIA "Jēkabpils MR"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=58" class="normal">SIA "Kubikmetrs"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=24" class="normal">SIA "Kurekss"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=62" class="normal">SIA "Latvāņi"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>          
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=42" class="normal">A/S "Latvijas Finieris"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=48" class="normal">SIA "Ošukalns"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=52" class="normal">SIA "Tezei-S"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=21" class="normal">SIA "Smiltene Impex"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=40" class="normal">A/S "Stora Enso Latvia"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=38" class="normal">A/S "Saldus MR"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=64" class="normal">SIA "Timberex Group"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=46" class="normal">SIA "Piebalgas"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=56" class="normal">SIA "Vārpas 1"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=12" class="normal">SIA "Vika Wood"</a>
               </td>
          </tr>
          <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=25" class="normal">SIA "Vudlande"</a>
               </td>
          </tr>
          <tr>
                   <td bgcolor=white align=center>
                        &nbsp;
                   </td>
              </tr>
          <tr>
               <td bgcolor=#336633 align=center>
                    <a href="reportGen_bld.php?h=50" class="normal">SIA "4 Plus"</a>
               </td>
          </tr>
		  <tr>
               <td bgcolor=white align=center>
                    &nbsp;
               </td>
          </tr>
          </table>
</html>