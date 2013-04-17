<script>
	function checkFile(){
		if(document.forms['forma'].elements['fails'].value==""){
			document.getElementById('error').innerHTML = "Izvēlieties failu!";
			return false;
		}else{
			document.getElementById('error').innerHTML = "";
			return true;		
		}
	}
</script>
<? 
//print_r($_SERVER);
include ("db.inc.php");
include ("../check_login.php");
if ($mlietotajs['g_report']!='Y') return;

menu($_GET['h']);
?>

<center>
<font face=verdana>
<!--form name=forma method=POST ENCTYPE="multipart/form-data" action="batch_parse.php"-->

<form name=forma method=POST ENCTYPE="multipart/form-data" action="">
<input type="hidden" name="admin_upload" value="1" />
<div id="error" style="font-weight:bold;color:red;">
</div>
<?
//postējam datus uz jauno parseri
if($_SERVER['REQUEST_METHOD']=="POST"){
require_once('../client/batch_parse.php');
}
?>
 <input type=file size=50 name=fails>
 <br> <br>
 <input type="submit" value="Ielasīt failu" onclick="return checkFile();">
</form>
</center>
</body>
</html>