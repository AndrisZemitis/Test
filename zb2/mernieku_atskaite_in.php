<? 
include ("db.inc.php");
include ("../classes/mernieku_atskaite.class.php");
include ("../classes/firm_list.class.php");
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

$FirmList = new firmCont();

$MerniekuDati_In = new MerniekuDati_In();
$MerniekuDati_In->uid = $_SESSION['lid']; // Lietotaja ID
$MerniekuDati_In->setTerminals($terminals_id);
$MerniekuDati_In->msg = "";

$funcToCall = "showForm";
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isSet($_GET['id'])){
		$MerniekuDati_In->getById($_GET['id']);
	}
	elseif(isSet($_GET['list'])){
		$MerniekuDati_In->fillMerniekuSarakstu();
		$MerniekuDati_In->fillParvadajuSarakstu();
		$MerniekuDati_In->get();
		$funcToCall = "showTable";
	}
} 
elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isSet($_POST['save'])){
		$MerniekuDati_In->fillFromPost($_POST);
		if($MerniekuDati_In->save()){
			$MerniekuDati_In->msg = "Saglabāts!";
			if($MerniekuDati_In->id > 0){
				$funcToCall = "redirectToList";
			}
		}
	}
	elseif(isSet($_POST['readpost']) && $_POST['readpost'] == 1){
		$MerniekuDati_In->fillFromPost($_POST);
	}
	elseif(isSet($_POST['list_filter'])){
		$MerniekuDati_In->fillMerniekuSarakstu();
		$MerniekuDati_In->fillParvadajuSarakstu();
		$MerniekuDati_In->fillFilter($_POST);
		$MerniekuDati_In->get();
		$funcToCall = "showTable";
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
<script type="text/javascript">
     function PopupCenter(typURL) {
          if (typURL == "mail") {
			var pageURL = 'mernieku_atskaite_mail.php', title = 'Nosūtīt_atskaiti', w = '500', h = '70';
			  var left = (screen.width/2)-(w/2);
			  var top = (screen.height/2)-(h/2);
			  var params = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" + w + ", height=" + h + ", top=" + top + ", left=" + left;
			  var targetWin = window.open(pageURL, title, params);
			  var parentDoc = document;
			  targetWin.onload = function(){
				   targetWin.document.getElementById('mernieks').value = parentDoc.getElementById('mernieks').value;
				   targetWin.document.getElementById('piegadatajs').value = parentDoc.getElementById('piegadatajs').value;
				   targetWin.document.getElementById('datums').value = parentDoc.getElementById('datums').value;
			  };
         }else{
			  var pageURL = 'pievienot_firmu.php?frm=1', title = 'Pievienot_firmu', w = '500', h = '300';
			  var left = (screen.width/2)-(w/2);
			  var top = (screen.height/2)-(h/2);
			  var params = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=" + w + ", height=" + h + ", top=" + top + ", left=" + left;
			  var targetWin = window.open(pageURL, title, params);  
			  var parentDoc = document;
			  targetWin.onload = function(){
					//alert(1);
			  }	
			  targetWin.onbeforeunload = function(){
					//alert(2);
					parentDoc.getElementById('readpost').value = 1;
					parentDoc.getElementById('merniekuAtskaiteIN').submit();
			  };
         };
     } 
</script>
	
<?function showForm($MerniekuDati_In,$FirmList){?>
	<form method="post" action="" id="merniekuAtskaiteIN">
	<input type="hidden" name="id" value="<?=$MerniekuDati_In->id?>" />
	<input type="hidden" name="checksum" value="<?=$MerniekuDati_In->checksum?>" />
	<input type="hidden" name="readpost" id="readpost" value="0" />
          <table cellspacing=0 cellpadding=0 border=0 width=350 align=center>
          <tr>
               <td align=left>
                    1.	Datums un laiks
               </td>
			   <td>
					<input type="text" disabled="1" name="datums" value="<?=$MerniekuDati_In->datums?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    2.	Piegādātājs
               </td>
			   <td>
					<!-- <input type="text" name="piegadatajs" value="<?=$MerniekuDati_In->piegadatajs?>" /> -->
					<select name="piegadatajs" id="firmas_piegadataji" style="width:155px;">
						<?if($FirmList->get_FirmList())while($firma_piegatajs=$FirmList->next()){?>
							<option value="<?=$firma_piegatajs->nosaukums?>" <?if($MerniekuDati_In->piegadatajs==$firma_piegatajs->nosaukums){?>selected="1"<?}?>><?=$firma_piegatajs->nosaukums?></option>
						<?}?>
					</select>
			   </td>
			   <td>
                         &nbsp;&nbsp;<a href="#"  onclick="PopupCenter('firm');">Pievienot</a>
			   </td>
          </tr>
          <tr>
               <td align=left>
                    3.	Cirsmas kods
               </td>
			   <td>
					<input type="text" name="cirsmas_kods" value="<?=$MerniekuDati_In->cirsmas_kods?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    4.	Apakšpiegādātājs
               </td>
			   <td>
					<input type="text" name="piegadatajs2" value="<?=$MerniekuDati_In->piegadatajs2?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    5.	Pārvadātājs
               </td>
			   <td>
					<input type="text" name="parvadatajs" value="<?=$MerniekuDati_In->parvadatajs?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    6.	Pavadzīmes numurs
               </td>
			   <td>
					<input type="text" name="pavadzime" <?if($MerniekuDati_In->id > 0){?>disabled="1"<?}?> value="<?=$MerniekuDati_In->pavadzime?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    7.	Piegādātais tilpums (m3)
               </td>
			   <td>
					<input type="text" name="tilpums" <?if($MerniekuDati_In->id > 0){?>disabled="1"<?}?> value="<?=$MerniekuDati_In->tilpums?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    8.	Auto reģistrācijas numurs
               </td>
			   <td>
					<input type="text" name="auto" value="<?=$MerniekuDati_In->auto?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    9.	CAV Nr.
               </td>
			   <td>
					<input type="text" name="cav_nr" value="<?=$MerniekuDati_In->cav_nr?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    10.	Krautuves Nr.
               </td>
			   <td>
					<input type="text" name="krautuves_nr" value="<?=$MerniekuDati_In->krautuves_nr?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    11.	Darba uzdevuma Nr.
               </td>
			   <td>
					<input type="text" name="darba_uzdevuma_nr" <?if($MerniekuDati_In->id > 0){?>disabled="1"<?}?> value="<?=$MerniekuDati_In->darba_uzdevuma_nr?>" />
			   </td>
          </tr>
          <tr>
               <td align=left>
                    12. Grēda
               </td>
			   <td>
					<input type="text" name="greda" <?if($MerniekuDati_In->id > 0){?>disabled="1"<?}?> value="<?=$MerniekuDati_In->greda?>" />
			   </td>
          </tr>
		  
		  <?if($MerniekuDati_In->id > 0){?>
			  <tr><td colspan="2"> &nbsp;  </td></tr>
			  <tr>
				   <td align=left>
						13.	Labojumu skaits
				   </td>
				   <td>
						<input type="text" disabled="1"  name="labojumu_skaits" value="<?=$MerniekuDati_In->labojumu_skaits?>" />
				   </td>
			  </tr>
			  <?if($MerniekuDati_In->labojumu_skaits > 0){?>
			  <tr>
				   <td align=left>
						14.	Pēdēja labojuma laiks
				   </td>
				   <td>
						<input type="text" disabled="1" name="labojuma_laiks" value="<?=$MerniekuDati_In->labojuma_laiks?>" />
				   </td>
			  </tr>
			  <?}?>
		  <?}?>
          <tr>
               <td align=left>
                    <h4><?=$MerniekuDati_In->msg?></h4>
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
<?function showTable($MerniekuDati_In){?>
	<form method="post" action="" id="filterForm">
	<table><tr><td>
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr>
			<th bgcolor=#7EBF7E>&nbsp;Mērnieks:&nbsp;</th>
			<td>
				<select name="mernieks" id="mernieks">
						<option value="0"> </option>
					<?foreach($MerniekuDati_In->mernieki as $mernieks){?>
						<option value="<?=$mernieks->id?>" <?if($MerniekuDati_In->filters['mernieks'] == $mernieks->id){?>selected="1"<?}?> ><?=$mernieks->mernieks?></option>
					<?}?>
				</select>
			</td>
			
			<th bgcolor=#7EBF7E>&nbsp;Piegādātājs:&nbsp;</th>
			<td>
				<select name="piegadatajs" id="piegadatajs">
						<option value="0"> </option>
					<?foreach($MerniekuDati_In->piegadataji as $piegadatajs){?>
						<option value="<?=$piegadatajs?>" <?if($MerniekuDati_In->filters['piegadatajs'] == $piegadatajs){?>selected="1"<?}?> ><?=$piegadatajs?></option>
					<?}?>
				</select>
			</td>
			
			<th bgcolor=#7EBF7E>&nbsp;Datums:&nbsp;</th>
			<td>
				<input type="text" name="datums" id="datums" value="<?=$MerniekuDati_In->filters['datums']?>" /> (<?=date("Y-m-d")?>)
			</td>

			<td><input type="submit" name="list_filter" value="Filtrēt" /></td>
		</tr> 
	</table>
	</td>
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
			<td><input type="button" name="export" value="Exportēt" onclick="var f=document.getElementById('filterForm');f.action='mernieku_atskaite.php';f.submit();" /></td>
		</tr> 
	</table>
	</td>	
	<td>
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr>
			<td><input type="button" name="email" value="Nosūtīt uz E-pastu" onclick="PopupCenter('mail');" /></td>
		</tr> 
	</table>
	</td>
	<td>
	<table border=1 cellspacing=0 cellpadding=2> 
		<tr>
			<td><input type="button" name="toOutbox" value="Pie izejošiem" onclick="window.location.href='./mernieku_atskaite_out.php?list=1';" /></td>
		</tr> 
	</table>
	</td>
	</tr>
	</table>
	</form>
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
			<th>&nbsp;Piegādātais tilpums (m3)&nbsp;</th> 
			<th>&nbsp;Auto reg.nr&nbsp;</th> 
			<th>&nbsp;Krautuves Nr.&nbsp;</th> 
			<th>&nbsp;Darba uzdevuma Nr.&nbsp;</th> 
			<th>&nbsp;Labojumu skaits&nbsp;</th> 

			<th>&nbsp;Grēda&nbsp;</th> 
			<th colspan="2">&nbsp;Iespējas&nbsp;</th> 
		</tr> 
	<?while($dati = $MerniekuDati_In->next()){?>
		<tr>
			<td align=right>&nbsp;<?=$dati->id?>&nbsp;</td>
			<td align=left >&nbsp;#<?=$dati->terminals_id?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->mernieks?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->datums?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->piegadatajs?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->cirsmas_kods?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->piegadatajs2?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->parvadatajs?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->pavadzime?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->tilpums?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->auto?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->krautuves_nr?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->darba_uzdevuma_nr?>&nbsp;</td>
			<td align=left >&nbsp;<?=$dati->labojumu_skaits?>&nbsp;</td>

			<td align=left >&nbsp;<?=$dati->greda?>&nbsp;</td>
			<td>
				<a href="mernieku_atskaite_in.php?id=<?=$dati->id?>" onclick="return confirm('Labot?');">Labot</a>
			</td>
			<td>
				<?if($dati->out_id == 0){?>
					<a href="mernieku_atskaite_out.php?input_id=<?=$dati->id?>" onclick="return confirm('Tiešām?');">Norakstīt</a>
				<?} else {?>
					&nbsp;
				<?}?>
				
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
<?if(function_exists($funcToCall)){call_user_func($funcToCall,$MerniekuDati_In,$FirmList);}?>
</html>