<? 
include '../connect.php';
include '../check_login.php';
include 'menu.php';
if ($mlietotajs['g_report']!='Y') return;

menu('jauna_faila_ielasisana',$valoda);
?>

<center>
<font face=verdana>
<form name=forma method=POST ENCTYPE="multipart/form-data" action="transf_newfromfile.php">
 <input type=file size=50 name=fails>
 <br> <br>
 <input type=submit value="Ielasīt failu">
</form>
</center>
</body>
</html>