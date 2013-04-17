<?
 include ('db.inc.php');
 include ("../check_login.php");
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
 if ($mlietotajs['g_report']!='Y') return;

 $h = $_GET['h'];
 $batch_query_pavadzime = getCorrectBatch($h,"table_pavadzime");

// saglabājam datums

 $id = $_GET['id'];
 $r = mysql_query("select * from ".$batch_query_pavadzime." where id = $id");
 $m = mysql_fetch_array($r);

 if ($_POST['poga'])
 {
	 if (!$iecikrnis) $iecirknis = "NULL";
	 if (!$kravas_id) $kravas_id = "NULL";
	 if (!$attalums) $attalums= "0";

	 $pavadzime = $_POST['pavadzime'];
	 $piegad_grupa = $_POST['piegad_grupa'];
	 $kad_piegad = $_POST['kad_piegad'];
	 $iecirknis = $_POST['iecirknis'];
	 $cirsmas_kods = $_POST['cirsmas_kods'];
	 $fsc = $_POST['fsc'];
	 $piegad_kods = $_POST['piegad_kods'];
	 $iecirknis_pieg = $_POST['iecirknis_pieg'];
//	 $iecirknis_pieg = iconv("","UTF-8",$iecirknis_pieg);
	 $attalums = $_POST['attalums'];
	 $auto = $_POST['auto'];
	 $soferis = $_POST['soferis'];
	 $cenu_matrica = $_POST['cenu_matrica'];
	 $kravas_id = $_POST['kravas_id'];
	 $batch_fails = $m['batch_fails'];

	 mysql_query("update ".$batch_query_pavadzime." set pavadzime = '$pavadzime',piegad_grupa = '$piegad_grupa',kad_piegad='$kad_piegad',iecirknis ='$iecirknis',cirsmas_kods = '$cirsmas_kods',fsc = '$fsc',piegad_kods = '$piegad_kods',iecirknis_pieg = '$iecirknis_pieg',attalums = $attalums,auto = '$auto',soferis = '$soferis',cenu_matrica = '$cenu_matrica',kravas_id = '$kravas_id'  where id = $id ");

//	 die("update ".$batch_query_pavadzime." set pavadzime = '$pavadzime',piegad_grupa = '$piegad_grupa',kad_piegad='$kad_piegad',iecirknis ='$iecirknis',cirsmas_kods = '$cirsmas_kods',fsc = '$fsc',piegad_kods = '$piegad_kods',iecirknis_pieg = '$iecirknis_pieg',attalums = $attalums,auto = '$auto',soferis = '$soferis',cenu_matrica = '$cenu_matrica',kravas_id = '$kravas_id'  where id = $id ");   
//      die("location:pavadzime_list.php?fails=$batch_fails&h=$h");
			 
	 header("location: http://www.vmf.lv/zb2/pavadzime_list.php?fails=$batch_fails&h=$h");
	
	 return;
 }

 menu($_GET['h']);

?>
<center>
<font size=5>Pavadzime labošana</font>
<form name=form1 method=POST>
	<table>
	    <tr>
			<td>Pavadzime numurs</td>
			<td><input name=pavadzime value="<?=$m['pavadzime']?>"></td>
		</tr>
	    <tr>
			<td>Piegādāts</td>
			<td><input name=piegad_grupa value="<?=$m['piegad_grupa']?>"></td>
		</tr>
	    <tr>
			<td>Datums</td>
			<td><input name=kad_piegad value="<?=$m['kad_piegad']?>"></td>
		</tr>
		<tr>
			<td>Iecirknis</td>
			<td><input name=iecirknis value="<?=$m['iecirknis']?>"></td>
		</tr>
		<tr>
			<td>Cirsma</td>
			<td><input name=cirsmas_kods value="<?=$m['cirsmas_kods']?>"></td>
		</tr>
		<tr>
			<td>Fsc</td>
			<td><input name=fsc value="<?=$m['fsc']?>"></td>
		</tr>
		<tr>
			<td>Pieg. kods</td>
			<td><input name=piegad_kods value="<?=$m['piegad_kods']?>"></td>
		</tr>
		<tr>
			<td>Iecirknis pieg.</td>
			<td><input name=iecirknis_pieg value="<?=$m['iecirknis_pieg']?>"></td>
		</tr>
		<tr>
			<td>Attālums</td>
			<td><input name=attalums value="<?=$m['attalums']?>"></td>
		</tr>
        <tr>
			<td>Auto</td>
			<td><input name=auto value="<?=$m['auto']?>"></td>
		</tr>
		<tr>
			<td>Šoferis</td>
			<td><input name=soferis value="<?=$m['soferis']?>"></td>
		</tr>
		<tr>
			<td>Cenas</td>
			<td><input name=cenu_matrica value="<?=$m['cenu_matrica']?>"></td>
		</tr>
		 <tr>
			<td>Kravas id</td>
			<td><input name=kravas_id value="<?=$m['kravas_id']?>"></td>
		</tr>
	</table>
	<input type=submit value="Saglabāt" name=poga>
     <input type="hidden" name="h" value=<?=$h?>>	
</form>