<? 
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

menu($_GET['h']);
?>

<center>
<font face=verdana>
<form name=forma method=POST ENCTYPE="multipart/form-data" action="batch_parse_test.php">
 <input type=file size=50 name=fails>
 <br> <br>
 <input type=submit value="Ielasīt failu">
</form>
</center>
</body>
</html>