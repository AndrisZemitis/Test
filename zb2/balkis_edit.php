<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_batch_func.php');
 include ('db.inc.php');
 include ("../check_login.php");
 if ($mlietotajs['g_report']!='Y') return;

 $h = $_GET['h'];
 $batch_query_select_balkis = getCorrectBatch($h,"table_balkis");
 $id = $_GET['id'];

     $query_001 = "select pavadzime as pavadzime, id as id, datums_laiks as datums_laiks, garums as gar_pirms_red, gar_pec_red as gar_pec_red, suga as suga, skira as skira, miza as miza, brakis as braka_kods, mind_pirms_red as diametrs_1, mind_pec_red as diametrs_2, mind_miza as diametrs_3, maxd_miza as diametrs_4, tilpums as tilpums_1, tilpums_scan as tilpums_2 from ".$batch_query_select_balkis." where id = $id";
	$r = mysql_query($query_001);
     $m = mysql_fetch_array($r);

// saglabājam datums
 if ($_POST['poga'])
 {
	 $datums_laiks  = $_POST['datums_laiks'];
	 $gar_pirms_red = $_POST['gar_pirms_red'];
	 $gar_pec_red   = $_POST['gar_pec_red'];
	 $suga          = $_POST['suga'];
	 $skira         = $_POST['skira'];
      $braka_kods    = $_POST['braka_kods'];
	 $miza          = $_POST['miza'];
	 $diametrs_1    = $_POST['diametrs_1'];
	 $diametrs_2    = $_POST['diametrs_2'];
	 $diametrs_3    = $_POST['diametrs_3'];
	 $diametrs_4    = $_POST['diametrs_4'];
	 $pavadzime     = $_POST['pavadzime'];

	 if (strlen($braka_kods)==2)
		$braka_kods = '0'.$braka_kods;
	 if (strlen($braka_kods)==1)
		$braka_kods = '00'.$braka_kods;

      $query_update = "UPDATE ".$batch_query_select_balkis." SET datums_laiks = '$datums_laiks', garums = $gar_pirms_red, gar_pec_red = $gar_pec_red, suga = '$suga', skira = '$skira', miza = '$miza', brakis = '$braka_kods', mind_pirms_red = $diametrs_1, mind_pec_red = $diametrs_2, mind_miza = $diametrs_3, maxd_miza = $diametrs_4 WHERE id = $id";
	 //die($query_update);
	 mysql_query($query_update);
	
	 header("location:balkis.php?h=".$h."&pavadzime=".$pavadzime);
	 return;
 }

 menu($_GET['h']);


?>
<center>
<font size=5>Baļķa labošana</font>
<form name=form1 method=POST>
	<table>
	     <tr>
			<td>Datums un laiks</td>
			<td><input name=datums_laiks value="<?=$m['datums_laiks']?>"></td>
		</tr>
		<tr>
			<td>Garums pirms redukcijas</td>
			<td><input name=gar_pirms_red value="<?=$m['gar_pirms_red']?>"></td>
		</tr>
		<tr>
			<td>Garums pēc redukcijas</td>
			<td><input name=gar_pec_red value="<?=$m['gar_pec_red']?>"></td>
		</tr>
		<tr>
			<td>Suga</td>
			<td><input name=suga value="<?=$m['suga']?>"></td>
		</tr>
		<tr>
			<td>Šķira</td>
			<td><input name=skira value="<?=$m['skira']?>"></td>
		</tr>
		<tr>
			<td>Miza</td>
			<td><input name=miza value="<?=$m['miza']?>"></td>
		</tr>
		<tr>
			<td>Brāķa kods</td>
			<td><input name=braka_kods value="<?=$m['braka_kods']?>"></td>
		</tr>
		<tr>
			<td>Tievgalis</td>
			<td><input name=diametrs_1 value="<?=$m['diametrs_1']?>"></td>
		</tr>
		<tr>
			<td>Diametrs pirms redukcijas</td>
			<td><input name=diametrs_3 value="<?=$m['diametrs_3']?>"></td>
		</tr>
		<tr>
			<td>Diametrs pēc redukcijas</td>
			<td><input name=diametrs_2 value="<?=$m['diametrs_2']?>"></td>
		</tr>
		<tr>
			<td>Resgalis</td>
			<td><input name=diametrs_4 value="<?=$m['diametrs_4']?>"></td>
		</tr>
		
		
	</table>
	<input type=submit value="Saglabāt" name=poga>
	<input type=hidden value=<?=$m['pavadzime']?> name=pavadzime>
</form>