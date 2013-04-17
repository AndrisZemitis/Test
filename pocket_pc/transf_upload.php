<? 
include '../connect.php';
include '../check_login.php';
include 'menu.php';
if ($mlietotajs['g_report']!='Y') return;

menu('faila_ielasisana',$valoda);
?>

<center>
<font face=verdana>
<form name=forma method=POST ENCTYPE="multipart/form-data" action="transf_fromfile.php">
 <input type=file size=50 name=fails>
 <br> <br>
 <input type=submit value="Ielasīt failu">
</form>
</center>
</body>
</html>