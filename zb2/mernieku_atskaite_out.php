<? 
include ("db.inc.php");
include ("../classes/mernieku_atskaite.class.php");
include ("../check_login.php");
//if ($mlietotajs['g_report']!='Y') return;

if(!session_is_registered('xml_vars')){
     session_start();
     session_register('xml_vars');
}

$terminals_id = (isSet($_SESSION['MERNIEKU_TERMINALS_ID'])) ? (int)$_SESSION['MERNIEKU_TERMINALS_ID'] : -1;
if($terminals_id === -1){
	Header("Location: /zb2/mernieku_atskaite_terminals.php");
	exit;
}

menu($_GET['h']);
$h = $_GET['h'];

$funcToCall=null;

$MerniekuDati_Out = new MerniekuDati_Out();
$MerniekuDati_Out->setTerminals($terminals_id);
$MerniekuDati_Out->uid = $_SESSION['lid']; // Lietotaja ID
$MerniekuDati_Out->msg = "";

$funcToCall = "showForm";
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isSet($_GET['id'])){
		$MerniekuDati_Out->getById($_GET['id']);
	}
	elseif(isSet($_GET['input_id'])){
		$MerniekuDati_Out->getFromInput($_GET['input_id']);
	}
	elseif(isSet($_GET['list'])){
		$MerniekuDati_Out->get();
		$funcToCall = "showTable";
	}
} 
elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	$MerniekuDati_Out->fillFromPost($_POST);
	if($MerniekuDati_Out->checkInputSource()!==true){
		$MerniekuDati_Out->msg = "Nevar izrakstīt!";
	}
	elseif(isSet($_POST['save'])){
		if($MerniekuDati_Out->save()){
			$MerniekuDati_Out->msg = "Saglabāts!";
			if($MerniekuDati_Out->id > 0){
				$funcToCall = "redirectToList";
			}
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
<?function showForm($MerniekuDati_Out){?>
	<form method="post" action="">
	<input type="hidden" name="id" value="<?=$MerniekuDati_Out->id?>" />
	<input type="hidden" name="input_id" value="<?=$MerniekuDati_Out->input_id?>" />
	<input type="hidden" name="checksum" value="<?=$MerniekuDati_Out->checksum?>" />
          <table cellspacing=0 cellpadding=0 border=0 width=300 align="center">
          <tr>
               <td align=left>
                    1.	Datums un laiks
               </td>
			   <td>
					<input type="text" disabled="1" name="datums" value="<?=$MerniekuDati_Out->datums?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    2.	Piegādātājs
               </td>
			   <td>
					<input type="text" name="piegadatajs" value="<?=$MerniekuDati_Out->piegadatajs?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    3.	Cirsmas kods
               </td>
			   <td>
					<input type="text" name="cirsmas_kods" value="<?=$MerniekuDati_Out->cirsmas_kods?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    4.	Apakšpiegādātājs
               </td>
			   <td>
					<input type="text" name="piegadatajs2" value="<?=$MerniekuDati_Out->piegadatajs2?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    5.	Pārvadātājs
               </td>
			   <td>
					<input type="text" name="parvadatajs" value="<?=$MerniekuDati_Out->parvadatajs?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    6.	Pavadzīmes numurs
               </td>
			   <td>
					<input type="text" name="pavadzime" value="<?=$MerniekuDati_Out->pavadzime?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    7.	Priede tilpums (m3)
               </td>
			   <td>
					<input type="text" name="tilpums_priede" value="<?=$MerniekuDati_Out->tilpums_priede?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    8.	Egle tilpums (m3)
               </td>
			   <td>
					<input type="text" name="tilpums_egle" value="<?=$MerniekuDati_Out->tilpums_egle?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    9.	Brāķis tilpums (m3)
               </td>
			   <td>
					<input type="text" name="tilpums_brakis" value="<?=$MerniekuDati_Out->tilpums_brakis?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    10.	Skaits (gab.)
               </td>
			   <td>
					<input type="text" name="skaits" value="<?=$MerniekuDati_Out->skaits?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    11.	Piezīmes
               </td>
			   <td>
					<input type="text" name="piezimes" value="<?=$MerniekuDati_Out->piezimes?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    12.	Cargo
               </td>
			   <td>
					<input type="text" name="cargo" value="<?=$MerniekuDati_Out->cargo?>" />
			   </td>
          </tr>

		 <?if(false){?>
			  <tr><td colspan="2"> &nbsp;  </td></tr>
			  <tr>
				   <td align=left>
						13.	Labojumu skaits
				   </td>
				   <td>
						<input type="text" disabled="1" name="labojumu_skaits" value="<?=$MerniekuDati_Out->labojumu_skaits?>" />
				   </td>
			  </tr>
			  <?if($MerniekuDati_Out->labojumu_skaits > 0){?>
			  <tr>
				   <td align=left>
						14.	Pēdēja labojuma laiks
				   </td>
				   <td>
						<input type="text" disabled="1" name="labojuma_laiks" value="<?=$MerniekuDati_Out->labojuma_laiks?>" />
				   </td>
			  </tr>
			  <?}?>
		  <?}?>
		  
          <tr>
               <td align=left>
                    <h4><?=$MerniekuDati_Out->msg?></h4>
					<br />
					<input type="button" name="tolist" value="Pie saraksta" onclick="window.location.search = 'list=1';" />
               </td>
			   <td>
					<input type="submit" name="save" value="Saglabāt" />
			   </td>
          </tr>
		</table>
	</form>
<?}?>
<?function showTable($MerniekuDati_Out){?>
	<table><tr>
		<td>
		<table border=1 cellspacing=0 cellpadding=2> 
			<tr>
				<td><input type="button" name="add" value="Pievienot" onclick="window.location.search='';" /></td>
			</tr> 
		</table>
		</td>
		<td>
		<table border=1 cellspacing=0 cellpadding=2> 
			<tr>
				<td><input type="button" name="toOutbox" value="Pie ienakošiem" onclick="window.location.href='./mernieku_atskaite_in.php?list=1';" /></td>
			</tr> 
		</table>
		</td>
	</tr>
	</table>
	<br />
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr  bgcolor=#7EBF7E> 
			<th>&nbsp;ID&nbsp;</th> 
			<th>&nbsp;TID&nbsp;</th> 
			<th>&nbsp;Mērnieks&nbsp;</th> 
			<th>&nbsp;Datums un laiks&nbsp;</th> 
			<th>&nbsp;Piegādātājs&nbsp;</th> 
			<th>&nbsp;Cirsmas kods&nbsp;</th> 
			<th>&nbsp;Apakšpiegādātājs&nbsp;</th> 
			<th>&nbsp;Pārvadātājs&nbsp;</th> 
			<th>&nbsp;Pavadzīmes numurs&nbsp;</th> 
			<th>&nbsp;Priede tilpums (m3)&nbsp;</th> 
			<th>&nbsp;Egle tilpums (m3)&nbsp;</th> 
			<th>&nbsp;Brāķis tilpums (m3)&nbsp;</th> 
			<th>&nbsp;Skaits (gab.)&nbsp;</th> 
			<th>&nbsp;Piezīmes&nbsp;</th> 
			<th>&nbsp;Cargo&nbsp;</th> 
			<th>&nbsp;Labojumu skaits&nbsp;</th> 
			<th>&nbsp;Iespējas&nbsp;</th> 
		</tr> 
	<?while($dati = $MerniekuDati_Out->next()){?>
		<tr>
			<td align=right>&nbsp;<a name="#entry_id_<?=$dati->id?>"><?=$dati->id?></a>&nbsp;</td>
			<td align=left >&nbsp;#<?=$dati->terminals_id?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->mernieks?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->datums?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->piegadatajs?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->cirsmas_kods?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->piegadatajs2?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->parvadatajs?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->pavadzime?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->tilpums_priede?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->tilpums_egle?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->tilpums_brakis?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->skaits?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->piezimes?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->cargo?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->labojumu_skaits?>&nbsp;</td>
			<td>
				<a href="mernieku_atskaite_out.php?id=<?=$dati->id?>" onclick="return confirm('Labot?');">Labot</a>
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
<?if(function_exists($funcToCall)){call_user_func($funcToCall,$MerniekuDati_Out);}?>
</html>