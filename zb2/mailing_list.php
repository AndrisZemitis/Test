<? 
include ("db.inc.php");
include ("../classes/mailing_list.class.php");
include ("../check_login.php");

if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

menu($_GET['h']);
$h = $_GET['h'];


$funcToCall=null;
$MailingList = new MailingList();

$funcToCall = "showTableGroups";
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isSet($_GET['users'])){
		if(isSet($_GET['dzest']) && isSet($_GET['uid'])){
			$MailingList->deleteUser($_GET['uid']);
		}
		$MailingList->getUsers();
		$funcToCall = "showTableUsers";
	}elseif(isSet($_GET['groups'])){
		if(isSet($_GET['dzest']) && isSet($_GET['gid'])){
			$MailingList->deleteGroup($_GET['gid']);
		}
		$MailingList->getGroups();
		$funcToCall = "showTableGroups";
	}elseif(isSet($_GET['uid'])){
		$MailingList->getUser($_GET['uid']);
		$funcToCall = "showFormUser";
	}elseif(isSet($_GET['gid'])){
		$MailingList->getUsersAndGroup($_GET['gid']);
		$funcToCall = "showFormGroup";
	}else {
		$MailingList->getGroups();
		$funcToCall = "showTableGroups";
	}
} 
elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isSet($_POST['action'])){
		if($_POST['action'] == "user" && !empty($_POST['mail'])){
			if($_POST['id'] > 0){
				$res = $MailingList->editUser($_POST['id'],$_POST['mail'],$_POST['name']);
			} else {
				$res = $MailingList->addUser($_POST['mail'],$_POST['name']);
			}
			$MailingList->obj = null;
			$funcToCall = "showFormUser"; 
		} elseif($_POST['action'] == "group" && !empty($_POST['name'])){
			if($_POST['id'] > 0){
				$res = $MailingList->editList($_POST['id'],$_POST['name'],$_POST['users']);
			} else {
				$res = $MailingList->createList($_POST['name'],$_POST['users']);
			}
			$MailingList->obj = null;
			$MailingList->getUsers();
			$funcToCall = "showFormGroup"; 
		}
		if($res){
			$MailingList->msg = "Saglabāts!";
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
<title>VMF</title>
</head>
<body>
<?function showHeader(){?>
	<form method="post" action="" id="filterForm">
		<table><tr>
		<td>
			<table border=1 cellspacing=0 cellpadding=2> 
				<tr>
					<td><input type="button" name="addUser" value="Pievienot E-pastu/Lietotāju" onclick="window.location.search='uid=0';" /></td>
				</tr> 
			</table>
		</td>
		<td>
			<table border=1 cellspacing=0 cellpadding=2> 
				<tr>
					<td><input type="button" name="listUser" value="E-pastu/Lietotāju saraksts" onclick="window.location.search='users=1';" /></td>
				</tr> 
			</table>
		</td>
		<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			<table border=1 cellspacing=0 cellpadding=2> 
				<tr>
					<td><input type="button" name="addUser" value="Pievienot grupu" onclick="window.location.search='gid=0';" /></td>
				</tr> 
			</table>
		</td>
		<td>
			<table border=1 cellspacing=0 cellpadding=2> 
				<tr>
					<td><input type="button" name="listUser" value="Grupu saraksts" onclick="window.location.search='';" /></td>
				</tr> 
			</table>
		</td>
		</tr>
		</table>
	</form>
<?}?>
<?function showFormUser($mList){?>
	<?showHeader()?>
	
	<form method="post" action="">
	<input type="hidden" name="action" value="user" />
	<input type="hidden" name="id" value="<?=(($mList->obj)?$mList->obj->id:"")?>" />
          <table cellspacing=0 cellpadding=0 border=0 width=300 align=center>
          <tr>
               <td align=left>
                    Vārds Uzvārds
               </td>
			   <td>
					<input type="text" name="name" value="<?=(($mList->obj)?$mList->obj->name:"")?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    E-pasts*
               </td>
			   <td>
					<input type="text" name="mail" value="<?=(($mList->obj)?$mList->obj->mail:"")?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    <h4><?=$mList->msg?></h4>
					<br />
					<input type="button" name="tolist" value="Pie saraksta" onclick="window.location.search = 'users=1';" />
               </td>
			   <td>
					<input type="submit" name="save" value="Saglabāt" />
			   </td>
          </tr>
        </table>
	</form>
<?}?>
<?function showTableUsers($mList){?>
	<?showHeader()?>
	
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr  bgcolor=#7EBF7E> 
			<th>&nbsp;ID&nbsp;</th> 
			<th>&nbsp;Vārds Uzvārds&nbsp;</th> 
			<th>&nbsp;E-pasts&nbsp;</th> 
			<th colspan="2">&nbsp;Iespējas&nbsp;</th> 
		</tr> 
	<?while($dati = $mList->next()){?>
		<tr>
			<td align=right>&nbsp;<?=$dati->id?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->name?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->mail?>&nbsp;</td>
			<td>
				<a href="mailing_list.php?uid=<?=$dati->id?>" onclick="return confirm('Labot?');">Labot</a>
			</td>
			<td>
				<a href="mailing_list.php?uid=<?=$dati->id?>&amp;dzest=1&amp;users=1" onclick="return confirm('Dzēst?');">Dzēst</a>
			</td>
		</tr>
	<?}?>
	</table>
<?}?>

<?function showFormGroup($mList){?>
	<?showHeader()?>
	
	<form method="post" action="">
	<input type="hidden" name="action" value="group" />
	<input type="hidden" name="id" value="<?=(($mList->obj)?$mList->obj->id:"")?>" />
          <table cellspacing=0 cellpadding=0 border=0 width=300 align=center>
          <tr>
               <td align=left>
                    Nosaukums
               </td>
			   <td>
					<input type="text" name="name" value="<?=(($mList->obj)?$mList->obj->name:"")?>" />
			   </td>
          </tr>      
		  <tr>
               <td align=left>
                    Izvēlēties lietotājus
               </td>
			   <td>
					<select name="users[]" MULTIPLE="1" size="7">
						<?while($u = $mList->next()){?>
							<option value="<?=$u->id?>" <?if($u->link){?>selected="1"<?}?>><?=$u->mail?></option>
						<?}?>
					</select>
			   </td>
          </tr>
          <tr>
               <td align=left>
                    <h4><?=$mList->msg?></h4>
					<br />
					<input type="button" name="tolist" value="Pie saraksta" onclick="window.location.search = '';" />
               </td>
			   <td>
					<input type="submit" name="save" value="Saglabāt" />
			   </td>
          </tr>
        </table>
	</form>
<?}?>
<?function showTableGroups($mList){?>
	<?showHeader()?>
	
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr  bgcolor=#7EBF7E> 
			<th>&nbsp;ID&nbsp;</th> 
			<th>&nbsp;Nosaukums&nbsp;</th> 
			<th colspan="2">&nbsp;Iespējas&nbsp;</th> 
		</tr> 
	<?while($dati = $mList->next()){?>
		<tr>
			<td align=right>&nbsp;<?=$dati->id?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->name?>&nbsp;</td>
			<td>
				<a href="mailing_list.php?gid=<?=$dati->id?>" onclick="return confirm('Labot?');">Labot</a>
			</td>
			<td>
				<a href="mailing_list.php?gid=<?=$dati->id?>&amp;dzest=1&amp;groups=1" onclick="return confirm('Dzēst?');">Dzēst</a>
			</td>
		</tr>
	<?}?>
	</table>
<?}?>
<?function redirectToList($obj){?>
	<script>
		window.location.href = '?list=1';
	</script>
	<center>
		<h3>
			<?=$obj->msg?>
		</h3>
	</center>
<?}?>
<?if(function_exists($funcToCall)){call_user_func($funcToCall,$MailingList);}?>
</html>