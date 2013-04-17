<?
session_start();

if (!$_SESSION['lid'])
{
	header('location:http://www.vmf.lv/index.php');
}
else
{
	$lietotajs_id = $_SESSION['lid'];

	if ($_GET['valoda'])
		$_SESSION['valoda'] = $_GET['valoda'];
	
	if (!$_SESSION['valoda']) 
		$_SESSION['valoda'] = 'lv';

	$valoda = $_SESSION['valoda'];
}

session_write_close();
?>