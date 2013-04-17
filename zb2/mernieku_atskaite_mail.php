<? 
include ("db.inc.php");
include ("../classes/mernieku_atskaite.class.php");
include ("../classes/mernieku_atskaite_mail.class.php");
include ("../classes/mailing_list.class.php");
include ("../check_login.php");

//if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

$MerniekuAtskaite_Mail = new MerniekuAtskaite_Mail();
$MerniekuDati_Export = new MerniekuDati_Export();
$MailingList = new MailingList();

$MailingList->getLists();

$sent = false;
	
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($MerniekuAtskaite_Mail->setRecipients($_POST['recipients'])){
		if($MerniekuAtskaite_Mail->send_email()){
			$sent = true;
		}
	}
}
?>
<style>
.normal {color:white; font-family:arial; size:12pt; text-decoration: none;}
.normal:hover {color:yellow; font-family:arial; size:12pt; text-decoration: none;}
.head {color:white; size:24pt; font-weight:bold;}
</style>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>VMF</title>
</head>
<body>
<center>
<?if($sent){?>
	<h3>Nosūtīts!</h3>
	<a href="#close" onclick="window.close();">Aizvert</a>
<?} else {?>
	<form method="post" action="" id="mailForm">
		<input type="hidden" name="mernieks" value="<?=((isSet($_POST['mernieks']))?(int)$_POST['mernieks']:0)?>" id="mernieks" />
		<input type="hidden" name="piegadatajs" value="<?=((isSet($_POST['piegadatajs']))?(int)$_POST['piegadatajs']:0)?>" id="piegadatajs" />
		<input type="hidden" name="datums" value="<?=((isSet($_POST['datums']))?date("Y-m-d",strtotime($_POST['datums'])):"")?>" id="datums" />
		<table><tr><td>
		<table border=1 cellspacing=0 cellpadding=2> 
			<tr>
				<th bgcolor=#7EBF7E>&nbsp;Saņēmēji:&nbsp;</th>
				<td>
					<input type="text" name="recipients" value="<?=((isSet($_POST['recipients']) && !strpos($_POST['recipients'],"<") && !strpos($_POST['recipients'],">"))?addcslashes($_POST['recipients'],'"'):"")?>" id="recipients" />
				</td>
				<td>
					<select name="list" onchange="document.getElementById('recipients').value = this.value;">
							<option value=""> </option>
						<?while($list = $MailingList->next()){?>
							<option value="<?=$list->list?>" <?if(isSet($_POST['list']) && $_POST['list']==$list->list){?>selected="1"<?}?>><?=$list->name?></option>
						<?}?>
					</select>
				</td>
				
			

				<td><input type="submit" name="send" value="Nosūtīt" /></td>
			</tr> 
		</table>
		</td>
		</tr>
		</table>
	</form>
<?}?>
</center>
</body>
</html>