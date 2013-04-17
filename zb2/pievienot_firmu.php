<? 
include ("db.inc.php");
include ("../classes/firm_list.class.php");
include ("../check_login.php");

if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

$FirmList = new firmCont();

$saved = false;
if($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_POST['nosaukums']) && isSet($_POST['papilddati']) && isSet($_POST['id'])){
	if($_POST['id']>0){
		if($FirmList->update_FirmList($_POST['id'],$_POST["nosaukums"],$_POST["papilddati"])){
			$saved = true;
			unSet($_GET['edit_id']);
		}
	} else {
		if($FirmList->add_FirmList($_POST["nosaukums"],$_POST["papilddati"])){
			$saved = true;
		}
	}
}

$editFirma = false;
if(isSet($_GET['edit_id'])){
	$editFirma=$FirmList->get_Firma($_GET['edit_id']);
}elseif(isSet($_GET['dzest_id'])){
	$FirmList->delete_FirmList($_GET['dzest_id']);
}
//$FirmList->get_FirmList();
?>
<style>
.normal {color:white; font-family:arial; size:12pt; text-decoration: none;}
.normal:hover {color:yellow; font-family:arial; size:12pt; text-decoration: none;}
.head {color:white; size:24pt; font-weight:bold;}
a { color: #016734;}
</style>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>VMF</title>
</head>
<body>
<center>
<?if($saved && false){?>
	<h3>Saglabāts!</h3>
	<a href="#close" onclick="window.close();">Aizvert</a>
<?}elseif(isSet($_GET['frm']) && !isSet($_GET['noframe'])){?>
	<iframe frameborder="0" src="http://<?=$_SERVER['HTTP_HOST']?>/zb2/pievienot_firmu.php" width="100%" height="90%">
	  <p>Your browser does not support iframes.</p>
    </iframe>
<?} else {?>
	<form method="post" action="" id="addFirmForm">
		<input type="hidden" name="id" value="<?=((is_object($editFirma))?(int)$editFirma->id:0)?>" id="id" />
		<center>
			<?if($saved){?>
				<h3>Saglabāts!</h3>
			<?}?>
		</center>
		<table>
		<tr>
			<td>
				<table border=1 cellspacing=0 cellpadding=2> 
						<tr>
							<td bgcolor=#7EBF7E>Nosaukums</td>
							<td><input type="text" name="nosaukums" value="<?=((is_object($editFirma))?htmlspecialchars($editFirma->nosaukums):"")?>" id="nosaukums" /></td>
						</tr> 
						<tr>
							<td bgcolor=#7EBF7E>Papilddati</td>
							<td><input type="text" name="papilddati" value="<?=((is_object($editFirma))?htmlspecialchars($editFirma->papilddati):"")?>" id="papilddati" /></td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<input type="submit" name="nosutit" value="Saglabāt" />
							</td>
						</tr>
					</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border=1 cellspacing=0 cellpadding=2> 
					<tr bgcolor=#7EBF7E>
					<td>Nosaukums</td>
					<td>Papilddati</td>
					<td>Iespējas</td>
					</tr>
					<?if($FirmList->get_FirmList())while($item = $FirmList->next()){?>
						<tr>
							<td><?=$item->nosaukums?></td>
							<td><?=$item->papilddati?></td>
							<td><a href="?edit_id=<?=$item->id?>">Labot</a> | <a href="?dzest_id=<?=$item->id?>">Dzēst</a></td>
						</tr>
					<?}?>
				</table>
			</td>
		</tr>
		</table>
	</form>
<?}?>
</center>
</body>
</html>