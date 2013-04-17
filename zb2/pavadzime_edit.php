<?
 include ('db.inc.php');
 include ("../check_login.php");
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/func_pavadzime.php');
 if ($mlietotajs['g_report']!='Y') return;
 
// die('Uz doto brīdi datus labot nevar!');
 
 $h = $_GET['h'];
 $report_id = $_GET['report_id'];
 $batch_query_pavadzime = getCorrectBatch($report_id);

 $id = $_GET['id'];
 $r = mysql_query("select * from ".$batch_query_pavadzime."pavadzime where id = $id");
 $m = mysql_fetch_array($r);
 $batch_fails = $_POST['root_datFile'];

 if ($_POST['poga']){

   updCorrectWaybill($h,$id,$batch_query_pavadzime,$_POST);
	 header("location: http://www.vmf.lv/zb2/pavadzime_list.php?fails=$batch_fails&h=$h&report_id=$report_id");
	
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
			<td>Piegādātājs</td>
			<td><input name=piegad_grupa value="<?=$m['piegad_grupa']?>"></td>
		</tr>
    <tr>
			<td>Piegādāts</td>
			<td><input name=kad_piegad value="<?=$m['kad_piegad']?>"></td>
		</tr>
    <tr>
			<td>Uzmērīts</td>
			<td><input name=kad_uzmer value="<?=$m['kad_uzmer']?>"></td>
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
			<td>Auto</td>
			<td><input name=auto value="<?=$m['auto']?>"></td>
		</tr>
		<tr>
			<td>Šoferis</td>
			<td><input name=soferis value="<?=$m['soferis']?>"></td>
		</tr>
		 <tr>
			<td>Kravas id</td>
			<td><input name=kravas_id value="<?=$m['kravas_id']?>"></td>
		</tr>
	</table>
	<input type=submit value="Saglabāt" name=poga>
     <input type="hidden" name="h" value=<?=$h?>>	
     <input type="hidden" name="root_pvdz" value=<?=$m['pavadzime']?>>	     
     <input type="hidden" name="root_datFile" value=<?=$m['batch_fails']?>>	     
</form>