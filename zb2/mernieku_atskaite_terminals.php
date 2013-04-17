<? 
include ("db.inc.php");
include ("../classes/mernieku_terminali.class.php");
include ("../classes/firm_list.class.php");
include ("../check_login.php");
//if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

$_SESSION['MERNIEKU_TERMINALS_ID'] = -1;

$funcToCall=null;

$MerniekuTerminali = new MerniekuTerminali();
$MerniekuTerminali->get();

$funcToCall = "showAuth";
if(isSet($_GET['edit'])){
	$funcToCall = "showForm";
	if(isSet($_GET['id'])){
		$MerniekuTerminali->getById($_GET['id']);
		$MerniekuTerminali->get();
	}elseif(isSet($_GET['delid'])){
		$MerniekuTerminali->tryDelete($_GET['delid']);
		$MerniekuTerminali->get();
	}
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isSet($_POST['save'])){
		$MerniekuTerminali->fillFromPost($_POST);
		if($MerniekuTerminali->save()){
			$MerniekuTerminali->msg = "Saglabāts!";
			$MerniekuTerminali->get();
		}
	}
	elseif(isSet($_POST['auth']) && isSet($_POST['terminals'])){
		$terminals = $MerniekuTerminali->getById($_POST['terminals']);
		if($terminals!==false){
			if($terminals->password === $_POST['password']){
				$_SESSION['MERNIEKU_TERMINALS_ID'] = $terminals->id;
				Header("Location: /zb2/mernieku_atskaite_in.php?list=1");
			}
		}
	}
}

menu($_GET['h']);
$h = $_GET['h'];
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
<?function showForm($MerniekuTerminali){?>
	<form method="post" action="?edit=1" id="MerniekuTerminali">
	<input type="hidden" name="id" value="<?=$MerniekuTerminali->id?>" />
          <table cellspacing=0 cellpadding=0 border=0 width=350 align=center>
          <tr>
               <td align=left>
                    1.	Termināla nosaukums
               </td>
			   <td>
					<input type="text" name="name" value="<?=$MerniekuTerminali->name?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    2. Termināla parole
               </td>
			   <td>
					<input type="text" name="password" value="<?=$MerniekuTerminali->password?>" />
			   </td>
          </tr>

          <tr>
               <td align=left>
                    <h4><?=$MerniekuTerminali->msg?></h4>
					<br />
					<input type="button" name="tolist" value="Pie termināla izvlenes" onclick="window.location.search = '';" />
               </td>
			   <td>
					<input type="submit" name="save" value="Saglabāt" />
			   </td>
          </tr>
        </table>
	</form>
	
	<br/>
	<center>
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr  bgcolor=#7EBF7E> 
			<th>&nbsp;ID&nbsp;</th> 
			<th>&nbsp;Nosaukums&nbsp;</th> 
			<th>&nbsp;Termināls&nbsp;</th> 
			<th colspan="2">&nbsp;Iespējas&nbsp;</th> 
		</tr> 
	<?while($dati = $MerniekuTerminali->next()){?>
		<tr>
			<td align=right>&nbsp;<?=$dati->id?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->name?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->password?>&nbsp;</td>
			<td>
				<a href="mernieku_atskaite_terminals.php?edit=1&amp;id=<?=$dati->id?>" onclick="return confirm('Labot?');">Labot</a>
			</td>
			<td>
				<a href="mernieku_atskaite_terminals.php?edit=1&amp;delid=<?=$dati->id?>" onclick="return confirm('Tiešām?');">Dzēst</a>
			</td>
		</tr>
	<?}?>
	</table>
	</center>
<?}?>
<?function showAuth($MerniekuTerminali){?>
	<form method="post" action="" id="MerniekuTerminali">
          <table cellspacing=0 cellpadding=0 border=0 width=350 align=center>
          <tr>
               <td align=left>
                    Termināla nosaukums
               </td>
			   <td>
					<select name="terminals">
						<?while($terminals=$MerniekuTerminali->next()){?>
							<option value="<?=$terminals->id?>"><?=$terminals->name?></option>
						<?}?>
					</select>
			   </td>
          </tr>
		  <tr>
               <td align=left><br />
                    Termināla parole
               </td>
			   <td>
					<input type="text" name="password" value="" />
			   </td>
          </tr>

          <tr>
			   <td></td>
			   <td><br />
					<input type="submit" name="auth" value="Apstiprināt" />
					<input type="button" name="none" onclick="window.location.search='edit=1';" value="Labot" />
			   </td>
          </tr>
        </table>
	</form>
<?}?>
<?if(function_exists($funcToCall)){call_user_func($funcToCall,$MerniekuTerminali);}?>
</html>