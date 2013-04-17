<?
//set_time_limit(0); 
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/db_connect.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/static/g_atskaite.php');

include ("db.inc.php");
include ("lvm_assort_matrix.inc.php");
include ("../check_login.php");
include ("c_report.inc_vika.php");

$arrsum = array();
$atskaite_veids = $_GET["veids"];
$h = $_GET['h'];

menu(-1);
?>
<center>
<font size=4>XML failu veidošanas rezultāti.</font><BR><BR>
<?

if ($_POST['pv'])
{
	$pv_array = explode(',',$_POST['pv']);
	$akts = $_POST['akts']; 
	$aktsp = $_POST['aktsp']; 
	$aktsp = $_POST['aktsp']; 
	for ($i=0;$i<count($pv_array);$i++)
	{

		$_POST['pavadzime_id'] = $pv_array[$i];
		$_POST['akts'] = $akts;
		$_POST['aktsp'] = $aktsp;

		// nosakam piegādātāju
		$rpav = mysql_query("select * from vikawood_pavadzime where id = ".$_POST['pavadzime_id']);
		$mpav = mysql_fetch_array($rpav);
		$kods = '3';
		if ($mpav['piegad_grupa']=='LVM')
			$kods = '1';
		if ($mpav['piegad_grupa']=='SALDUS MR')
			$kods = '2';
		if ($akts && $aktsp)
			$_POST['akts_nr_head'] = substr(date('Y'),2)."/2/$akts/$kods/$aktsp";


		// dabonam pavadzimes nr 
		$r = mysql_query("select pavadzime from vikawood_pavadzime where id = ".$_POST['pavadzime_id']);
		$m = mysql_fetch_array($r);


		$_POST['pavadzime'] = $m['pavadzime'];

		print_all_reports();

		$akts++;
		$aktsp++;
	}
//	LVM
//		SALDUS MR
//		citi
//		5/2/VMF/1,2,3/PARD
}
/*
if ($_POST['pv']){
    $pv_array = explode(',',$_POST['pv']);
    $akts = $_POST['akts']; 
    $aktsp = $_POST['aktsp']; 
    $aktsp = $_POST['aktsp'];
    if (!$atskaites_kods) {
		$atskaites_kods = substr($_POST['akts_nr_head'],2,2);
	}
    
    for ($i=0;$i<count($pv_array);$i++)
    {

        $_POST['pavadzime_id'] = $pv_array[$i];
        $_POST['akts'] = $akts;
        $_POST['aktsp'] = $aktsp;

        // nosakam piegādātāju
        $rpav = mysql_query("select * from ".$pavadzimes_tabula." where id = ".$_POST['pavadzime_id']);
        $mpav = mysql_fetch_array($rpav);
        $kods = '1';
        if ($mpav['piegad_grupa']=='LVM')
            $kods = '1';
            
        $piegad_compare = trim($mpav['piegad_grupa']);
        if ($piegad_compare == 'PATA')
            $kods = '6';

        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika SMR')
            $kods = '2';
        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika pirksana')
            $kods = '3';
        if ($mpav['piegad_grupa']=='VIKA' && $mpav['iecirknis_pieg']=='Vika darbinieki')
            $kods = '4';
        if ($akts && $aktsp)
            $_POST['akts_nr_head'] = substr(date('Y'),2)."/$atskaites_kods/$akts/$kods/$aktsp";
        

        $_POST['pavadzime']=$mpav['pavadzime'];
        $_POST['auto_head'] = $mpav['auto'];
        $_POST['soferis_head'] = $mpav['soferis'];
        $_POST['iecirknis_head'] = $mpav['iecirknis_pieg'];

		if (!$output_pdf) {
			if ($i == 0) { echo ('<html><head>'); }
		}

        print_all_reports();

		if (!$output_pdf) {
			if ($i<count($pv_array)-1)
			{ 
	//          echo "Page_Break_Test";		
					echo "<p style='page-break-before:always;'>&nbsp;";
			}
			else
			{ 
				echo ('</head></html>'); 
			}
		}
        $akts++;
        $akts = sprintf("%03d",$akts);
//        echo $y;
        $aktsp++;
        $aktsp = sprintf("%03d",$aktsp);
    }
//	LVM
//		SALDUS MR
//		citi
//		5/2/VMF/1,2,3/PARD
}*/
else
{
	print_all_reports();
}

?>
<BR><a href=report_xml.php?h=4>Turpināt</a>
<?

function print_all_reports()
{
	global $arrsum;
	$arrsum = array();

	$file_contents = '';
	for ($grup=1;$grup<=$_POST['grup'];$grup++) 
	{	
		$file_contents = $file_contents . print_report($grup);
	}

	if (file_exists("../batch/".$_POST['pavadzime'].".xml"))
	{
		echo "<font color=red>Nevar izveidot failu ../batch/".$_POST['pavadzime'].".xml jo fails jau eksistē.</font><BR>";
	}
	else
	{
		file_put_contents("../batch/".$_POST['pavadzime'].".xml",$file_contents);
		echo "Izveidots fails ../batch/".$_POST['pavadzime'].".xml<BR>";
	}
}

function print_report($grup)
{
$DB_CON = new C_DB('localhost', DATABASE, LOGIN,PWD);
$C_REP=  new C_REPORT($_POST,$DB_CON,true,$grup);
global $arrsum;

//echo '$grup = ' . $grup;

//print_r ($C_REP->arr);

if ($grup == 1) {
	$arrsum = $C_REP->arr[count($C_REP->arr)-1];
} else {
	$arrsum[summa]->skaits = $arrsum[summa]->skaits + $C_REP->arr[count($C_REP->arr)-1][summa]->skaits;
}

if ($grup == $_POST['grup']) {
	if ($arrsum[summa]->skaits != $arrsum[correct_count]) {
		$C_REP->ERRORS.= "Kļūda grupēšanā! Sagrupēti ".(int)$arrsum[summa]->skaits." baļķi no " . $arrsum[correct_count] . ".<br><br>";
	}
}

/////////////////////////////////////////////////////////////////////////
$_POST['pavadzime_head'] = $_POST['pavadzime'];

set_param('akts_nr',$_POST['akts_nr_head']);
set_param('pircejs_head',$_POST['pircejs_head']);
set_param('pircejs_regnum',$_POST['pircejs_regnum']);
set_param('pardevejs_head',$_POST['pardevejs_head']);
set_param('pardevejs_regnum',$_POST['pardevejs_regnum']);
set_param('pieg_lig_num',$_POST['pieg_lig_num']);
set_param('datums',$_POST['datums_head']);
set_param('iecirknis',$_POST['iecirknis_head']);
set_param('pavadzime_head',$_POST['pavadzime_head']);
set_param('transport_firm',$_POST['transport_firm']);
set_param('auto',$_POST['auto_head']);
set_param('soferis',$_POST['soferis_head']);
set_param('vieta',$_POST['vieta_head']);
set_param('piezimes',$_POST['piezimes_head']);
set_param('atbildigais',$_POST['atbildigais_head']);
set_param('custom11',$_POST['custom11_head']);
set_param('custom12',$_POST['custom12_head']);
$xml_vars['gvalues'.$grup.'1'] = $_POST['gvalues'.$grup.'1'];
$xml_vars['gvalues'.$grup.'1_1'] = $_POST['gvalues'.$grup.'1_1'];
$xml_vars['gvalues'.$grup.'1_2'] = $_POST['gvalues'.$grup.'1_2'];
$xml_vars['gvalues'.$grup.'2'] = $_POST['gvalues'.$grup.'2'];
$xml_vars['gvalues'.$grup.'2_1'] = $_POST['gvalues'.$grup.'2_1'];
$xml_vars['gvalues'.$grup.'2_2'] = $_POST['gvalues'.$grup.'2_2'];
$xml_vars['gvalues'.$grup.'3'] = $_POST['gvalues'.$grup.'3'];
$xml_vars['gvalues'.$grup.'3_1'] = $_POST['gvalues'.$grup.'3_1'];
$xml_vars['gvalues'.$grup.'3_2'] = $_POST['gvalues'.$grup.'3_2'];
$xml_vars['gvalues'.$grup.'4'] = $_POST['gvalues'.$grup.'4'];
$xml_vars['gvalues'.$grup.'4_1'] = $_POST['gvalues'.$grup.'4_1'];
$xml_vars['gvalues'.$grup.'4_2'] = $_POST['gvalues'.$grup.'4_2'];
$xml_vars['virsmeri'.$grup] = $_POST['virsmeri'.$grup];
$xml_vars['virsmeri'.$grup.'_1'] = $_POST['virsmeri'.$grup.'_1'];
$xml_vars['virsmeri'.$grup.'_2'] = $_POST['virsmeri'.$grup.'_2'];
$xml_vars['koeficients'.$grup] = $_POST['koeficients'.$grup];
$xml_vars['koeficients'.$grup.'_1'] = $_POST['koeficients'.$grup.'_1'];
$xml_vars['koeficients'.$grup.'_2'] = $_POST['koeficients'.$grup.'_2'];
$xml_vars['raukums'.$grup] = $_POST['raukums'.$grup];
$xml_vars['raukums'.$grup.'_1'] = $_POST['raukums'.$grup.'_1'];
$xml_vars['raukums'.$grup.'_2'] = $_POST['raukums'.$grup.'_2'];
$xml_vars['pavadzime'] = $_POST['pavadzime'];
/////////////////////////////////////////////////////////////////////////

if($C_REP->ERRORS)
			{?><head>
					 <title>Kļūda!</title>
					 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
					</head>
					
					<center>
					<STYLE TYPE="text/css">
					  TD { font-size: 12px; }
					</STYLE>
					</style>
					<body>
						<center><br><br>
						<b><font color=red>Kļūda!</font></b>
						<br><br>
						<?=$C_REP->ERRORS?>
						</center>
						<br><br>
						<input type=button value="Atkārtot" onclick="history.back(-1)">
					</body>
					</html>
			<?exit;
			}

//echo $C_REP->GetHTML();
//exit();
//create header///
//header ("Content-type: text/xml"); 
//header ("Content-type: file"); 
//header ("Content-Disposition: attachment; filename=".$_POST['pavadzime'].".xml"); 
 

 if (!$_POST['pavadzime_id'])
 {
  $_POST['pavadzime_id'] = GetFromPavadzime($_POST['pavadzime'],'id');
 }

 $pavadz_datums = GetFromPavadzimeID($_POST['pavadzime_id'],'kad_piegad','vikawood_pavadzime');

 if($pavadz_datums=='0000-00-00') $pavadz_datums=false;

 if(!$pavadz_datums)
 {
	 $pavadz_datums = GetPavadzimeDatumsID($_POST['pavadzime_id']);

	  if($pavadz_datums=='0000-00-00') $pavadz_datums = '';
	  $pavadz_datums = str_replace('.','-',$pavadz_datums);
 }
 if($pavadz_datums) $pavadz_datums = substr($pavadz_datums,0,10);

 if(!$uzmerisanas_datums)
 {
	  $uzmerisanas_datums = GetUzmerisanasDatumsID($_POST['pavadzime_id']);
	  if($uzmerisanas_datums=='0000-00-00') $uzmerisanas_datums = '';
	  $uzmerisanas_datums = str_replace('.','-',$uzmerisanas_datums);
 }
 if($uzmerisanas_datums) $uzmerisanas_datums = substr($uzmerisanas_datums,0,10);


$arr = $C_REP->GetDataArray();

$lsk = 5;
$output = "";

if ($_POST['grup'] == 1) {

	$output = $output . '<?xml version="1.0" encoding="UTF-8"?>';

	$output = $output . "<Invoice>";
	$output = $output . "	<EntryDate>".trim($_POST['datums_head'])."</EntryDate>";
	$output = $output . "	<InvoiceNumber>".$_POST['pavadzime_head']."</InvoiceNumber>";
	$output = $output . "	<InvoiceDate>".$pavadz_datums."</InvoiceDate>";
	$output = $output . "	<ContractNumber>".$_POST['pieg_lig_num']."</ContractNumber>";
	$output = $output . "	<MeasurerDocNr>".$_POST['akts_nr_head']."</MeasurerDocNr>";

	$output = $output . "	<Supplier>";
	$output = $output . "		<Name>".$_POST['pardevejs_head']."</Name>";
	$output = $output . "		<RegNr>".$_POST['pardevejs_regnum']."</RegNr>";
	$output = $output . "	</Supplier>";
		
	$output = $output . "	<Reciever>";
	$output = $output . "		<Name>".$_POST['pircejs_head']."</Name>";
	$output = $output . "		<RegNr>".$_POST['pircejs_regnum']."</RegNr>";
	$output = $output . "	</Reciever>";
		
	$output = $output . "	<Carrier>";
	if ($_POST['transport_firm']) 
	{ 
		$output = $output . "<FirmName>".$_POST['transport_firm']."</FirmName>";
	} 
	else 
	{ 
		$rAuto = mysql_query("select * from auto where numurs = '".GetFromPavadzimeID($_POST['pavadzime_id'],'auto','vikawood_pavadzime')."'");
		if (mysql_num_rows($rAuto)>0)
		{
			$mAuto = mysql_fetch_array($rAuto);
			$parvadatajs_id = $mAuto['parvadatajs'];
			$rParvadatajs = mysql_query("select * from parvadatajs where id = $parvadatajs_id");
			$mParvadatajs = mysql_fetch_array($rParvadatajs);
			$output = $output . "<FirmName>".$mParvadatajs['nosaukums']."</FirmName>";
		}
	}
	$output = $output . "<TruckNumber>".trim(GetFromPavadzimeID($_POST['pavadzime_id'],'auto','vikawood_pavadzime'))."</TruckNumber> ";
	$output = $output . "<Driver>".GetFromPavadzimeID($_POST['pavadzime_id'], 'soferis','vikawood_pavadzime')."</Driver>";
	$output = $output . "</Carrier>";
	
	$output = $output . "<Measuring>";
	$output = $output . "	<MeasuringDate>".$uzmerisanas_datums."</MeasuringDate>";
	$output = $output . "	<OperatorName>VMF Latvia</OperatorName>";
	$output = $output . "	<MeasureMethod>I</MeasureMethod>";
	$output = $output . "</Measuring>";
	
	$output = $output . "<AssortmOrigin> ";
	$output = $output . "	<FSCNumber>".GetFromPavadzimeID($_POST['pavadzime_id'],'fsc','vikawood_pavadzime')."</FSCNumber>";
	$output = $output . "	<SlashCode>".GetFromPavadzimeID($_POST['pavadzime_id'],'cirsmas_kods','vikawood_pavadzime')."</SlashCode>";
	$output = $output . "</AssortmOrigin >";

}
	
	if ($lsk>1)
	{
		for ($j=$lsk-2;$j>=0;$j--)
		{
			$v = $arr[0][$j];
			for ($i=0;$i<count($arr);$i++)
			{
				// iekopējam ja tukšs
				if (($arr[$i][$j]=="") && ($arr[$i][$j+1]!=""))
				{
					$arr[$i][$j]=$v; 
				}

				// ja nav tukšs paņem vērtību
				if ($arr[$i][$j]!="")
				{
					$v = $arr[$i][$j];
				}
			}
		}
	}

	/// drukājam tabulu
	for ($i=0;$i<count($arr);$i++)
	{
		if ($arr[$i][summa]->skaits!=0 && !$arr[$i][-1])
		{
			$output = $output .  "\n\n<DataRow>\n";
			$output = $output .  "<AssortmentGroup>ZB</AssortmentGroup>\n";
			$refused = false;
			$caurm_kods = '';
			for ($j=0;$j<$lsk;$j++)
			{
				switch ($arr[-1][$j])
				{

					case 'suga':
									//$arr[$i][$j]=$LVM_sugas[$arr[$i][$j]]; // pārveidojam uz LVM sugām P:E
									$output = $output .  "<Specie>".$arr[$i][$j]."</Specie>\n";
									break;
					case 'brakis':
									if(round($arr[$i][summa]->brakis,3)>0 && trim($arr[$i][$j])=="") //tiek kas ar "B"
									{
										$arr[$i][$j] = "D";
									}
									if ($arr[$i][$j]!='') {
										$refused = true;
										$output = $output .  "<RejectReason>".$arr[$i][$j]."</RejectReason>\n";
									}
									break;
					case 'mind_pirms_red':
									$SG=trim($arr[$i][$j]);
									if($SG=='0-79')	$SG="M";
									//echo $SG . '<br />';
									if ($SG == '120-129' || $SG == '130-139') {
										$SG = '120-139';
									}
									$output = $output .  "<SizeGroup>".$SG."</SizeGroup>\n";
									$caurm_kods=trim($arr[$i][$j]);
									if ($caurm_kods == '120-129' || $caurm_kods == '130-139') {
										$caurm_kods = '120-139';
									}
									break;

					case 'garums': 
									$a = explode('-',$arr[$i][$j]);
									$output = $output .  "<Length>\n<LowerLimit>$a[0]</LowerLimit>\n<UpperLimit>$a[1]</UpperLimit>\n</Length>\n";
									break;
					case 'cenu_matrica':
									$output = $output .  "<Price>".$arr[$i][$j]."</Price>\n";
					default: 
					//echo "<kaut_kas>".$arr[$i][$j]."</kaut_kas>\n";
				}
			}
			//echo "<td align=right>".round($arr[$i][summa]->bruto,3)."</td><td width=5>";
			$output = $output .  "<Assortment>".get_LVM_asort_kods_no_caurm_kods($caurm_kods)."</Assortment>";
			$output = $output .  "<Overlength>".round($arr[$i][summa]->virsmers,3)."</Overlength>\n";
			$output = $output . "<LengthReduction>".round($arr[$i][summa]->redukcija_d+$arr[$i][summa]->redukcija_l,3)."</LengthReduction>\n";
			if($refused)
			{
				$volume = round($arr[$i][summa]->brakis,3);

			} else {

				$volume = round($arr[$i][summa]->neto,3);
			}
			$output = $output .  "<NetVolume>".$volume."</NetVolume>\n";
			$output = $output .  "<Count>".round($arr[$i][summa]->skaits,3)."</Count>\n";
			$output = $output .  "<NotAgreed>0</NotAgreed>\n";
			
			$output = $output .  "</DataRow>";
		}
	}

if ($grup == $_POST['grup']) {

	$output = $output . "</Invoice>";

}

return $output;
}
?>