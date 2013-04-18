<?
include './darbi/connect.php';
include './darbi/menu.php';
include './darbi/funkcijas.php';
//include './darbi/sms_send.php';
if ($_POST['ir'])
{
	$login=mysql_real_escape_string($_POST['login']);
	$parole=mysql_real_escape_string($_POST['parole']);
	$r=mysql_query("select id,login,parole from lietotaji where (login='$login' and parole='$parole') AND passive = 'N'");
	if ($m=mysql_fetch_array($r))
	{
		session_start();
		$_SESSION['valoda'] = $_POST['valoda'];
		$_SESSION['lid'] = $m['id'];
//----------------------------------------------------------------------------
    $session=session_id();
    $time=time();
    $lid = $_SESSION['lid'];
    $time_check=$time-6000; //SET TIME 10 Minute

    $tbl_name="user_online"; // Table name

    $sql="SELECT * FROM $tbl_name WHERE session='$session'";
    $result=mysql_query($sql);

    $count=mysql_num_rows($result);

    if($count=="0"){
    $sql1="INSERT INTO $tbl_name(session, time,userID)VALUES('$session', '$time',$lid)";
    $result1=mysql_query($sql1);
    }
    else {
    "$sql2=UPDATE $tbl_name SET time='$time' WHERE session = '$session'";
    $result2=mysql_query($sql2);
    }

    $sql3="SELECT * FROM $tbl_name";
    $result3=mysql_query($sql3);

    $count_user_online=mysql_num_rows($result3);

//    echo "User online : $count_user_online ";

    // if over 10 minute, delete session
//    $sql4="DELETE FROM $tbl_name WHERE time<$time_check";
//    $result4=mysql_query($sql4);

    mysql_close();

//============================================================================
		header("location:main_menu.php");
		return;
	}
	else
	{
    $tmp_ClientLogin = explode("::",$login);
    if($tmp_ClientLogin[0] == "client"){
      $login=mysql_real_escape_string($tmp_ClientLogin[1]);
      $r_client=mysql_query("select `id` as identifikators, `cl_lietotajs` as lietotajvards FROM `acc_logme` WHERE `cl_lietotajs`='$login' and `cl_parole`='$parole'");
      if ($m=mysql_fetch_array($r_client)){
        session_start();
        $_SESSION['valoda'] = $_POST['valoda'];
        $_SESSION['cl_lid'] = $m['identifikators'];
        header("location:/client_data/slcDataClient.php");
        return;
      }else{
        $kluda='Lietotājvārds un/vai parole nav pareizi!';
        $login='';
        $parole='';
      }
    }else{
	
		$kluda='Lietotājvārds un/vai parole nav pareizi!<BR>Login or password are incorrect!';
		$login='';
		$parole='';
    }
	}

}

?>
<STYLE>

</STYLE>


<html>
<HEAD>
<TITLE>VMF</TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY onload="document.autorizacija.login.focus();">
<?
menu($_GET['h'],"lv");
?>

<form name=autorizacija method=POST>

<center><br><br>

<?
if ($kluda)
	echo '<font color=red><b>'.$kluda.'<b></font><br><br>';
?>

<table>
<tr>
	<td><b>Lietotājvārds/Login:</b></td>
	<td><input type=text name=login value="<?=$login?>"></td>
</tr>
<tr></tr>
<tr></tr>
<tr>
	<td align=right><b>Parole/Password:</b></td>
	<td><input type=password name=parole value="<?=$parole?>"></td>
</tr>
<tr>
	<td align=right><b>Valoda/Language</b></td>
	<td>Latviski: <input type=radio name=valoda value="lv" checked>&nbsp;&nbsp;English<input type=radio name=valoda value="en"></td>
</tr>
</table>

<br>
<p align=center><input type=submit value="   Ieiet   "></p>
<input type=hidden name=ir value=1>


</form>
<!-- /form autorizacija -->

</body>
</html>