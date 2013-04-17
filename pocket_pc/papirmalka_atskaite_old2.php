<?
include '../connect.php';

$metode = $_POST['metode_id']; // pagaidaam, kameer nav otras puses.
if ($metode) mysql_query("update papirmalka set metode = '".$metode."' where id = $darba_id ");

header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=papirmalka.xls"); header("Content-transfer-encoding: binary");

function tilpums ($metode,$d1,$d2,$lx)
{
	$lx = $lx / 10;
	$tilp = 0;
	if ($d1 > $d2)
	{
		$c = $d1;
		$d1 = $d2;
		$d2 = $c;
	}
	if ($metode == 1)
	{
		$tilp = (3.1416 * ( (($d1 + 0.5) * ($d1 + 0.5)) + (($d2 + 0.5) * ($d2 + 0.5)) ) * $lx)/(4 * 2 * 10000);
	}
	if ($metode == 2)
	{
		$lx = $lx * 10;
		// $d1 - > cm
		// $d2 - > cm
		// $lx - > dm
		
		if ($d1 <= 14)
		{
			if ($lx <= 349) $alfa = 0.485;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.485;
			if ($lx >= 450) $alfa = 0.485;
		}
		if ($d1 >= 15 and $d1 <= 24)
		{
			if ($lx <= 349) $alfa = 0.465;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.460;
			if ($lx >= 450) $alfa = 0.455;
		}
		if ($d1 >= 25)
		{
			if ($lx <= 349) $alfa = 0.440;
			if ($lx >= 350 and $lx <= 449) $alfa = 0.430;
			if ($lx >= 450) $alfa = 0.420;
		}
		$tilp = (3.1416/4) * ($lx + 0.5) * (($alfa * ($d2 + 0.5) * ($d2 + 0.5 )) + ((1 - $alfa) * ($d1 + 0.5) * ($d1 + 0.5))) / 100000;
		//echo "(" . $tilp . "," . ($d2) . "," . ($d1) . "," . (($alfa * ($d2 + 0.5) * ($d2 + 0.5 )) + ((1 - $alfa) * ($d1 + 0.5) * ($d1 + 0.5))) . ")";
	}
	$tilp = number_format($tilp, 3, '.', '');
	return $tilp;
}

$darba_id = $_GET['darba_id'];

if ($_GET['darba_id']) $darba_id = $_GET['darba_id'];
$m = mysql_fetch_array(mysql_query(" select * from papirmalka where id = $darba_id "));
$nr=$m['nr'];
$me=$m['me'];
$so=$m['so'];
$sg=$m['sg'];
$pk=$m['pk'];
$rn=$m['rn'];
$ag=$m['ag'];
$gr=$m['gr'];
$pl=$m['pl'];
$ti=$m['ti'];
$bk=$m['bk'];
$bp=$m['bp'];
$sk1=$m['sk1'];
$si1=$m['si1'];
$sk2=$m['sk2'];
$si2=$m['si2'];
$sk3=$m['sk3'];
$si3=$m['si3'];
$ts=$m['ts'];
$te=$m['te'];
//$metode=$m['metode'];
$doc_nr=$m['doc_nr'];
//$bt=number_format($ag*$pl*$gr/1000000,2);
//$nt=number_format($bt*$ti/100,2);

// $pa_klasem = array(); 
// $pa_b_kodiem = array();
// $pa_sugam = array();

$pa_klasem_kopa_t0 = 0;
$pa_b_kodiem_kopa_t0 = 0;
$pa_sugam_kopa_t0 = 0;
$pa_skiram_kopa_t0 = 0;
$pirma_sortimenta_t0 = 0;

$test = 0;

$skaits_kopa = 0;
$diam_summa = 0;
$gar_summa = 0;
echo $darba_id;
$ra = mysql_query(" select * from papirmalka_merijumi where papirmalka_id = $darba_id order by id");
while ($ma = mysql_fetch_array($ra))
{	
	$merijumi = $i;
	$sx=$ma['sx']; //suga
	$kx=$ma['kx']; //shkjira
	$bx=$ma['bx']; //braakja kods
	$d1=$ma['dl']; //caurmeers tievgala
	$lx=$ma['lx']; //garums
	$d2=$ma['d2']; //caurmeers resgala
	$rx=$ma['rx']; //?rezgalis?
	$re=$ma['re']; //redukcija
	$kb=$ma['kb'];
	
	$diam_summa = $diam_summa + $d1 + $d2;
	$gar_summa = $gar_summa + $lx;

	//echo tilpums($metode,$d1,$d2,$lx)." ".$d1." ".$lx." ".$d2."<br>"; //metode".$metode."<br>";
	$test = $test + tilpums($metode,$d1,$d2,$lx);

	if ($d1 > $d2)
	{
		$c = $d1;
		$d1 = $d2;
		$d2 = $c;
	}
	
	//echo "d1->".$d1."<-d1<br>";
	
	// pirmo sortimentu tilpums
	if ($rx == 1)
	{
		$pirma_sortimenta_t0 = $pirma_sortimenta_t0 + tilpums($metode,$d1,$d2,$lx);
	}

	// bruto tilpuma sadaliijums pa klaseem 
	if ($d1 <= 7)
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[1]['tilpums']=$pa_klasem[1]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[1]['skaits']=$pa_klasem[1]['skaits']+1;
	}
	if (($d1 >= 8 and $d1 <= 10))
	{	
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[2]['tilpums']=$pa_klasem[2]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[2]['skaits']=$pa_klasem[2]['skaits']+1;
	}
	if (($d1 >= 11 and $d1 <= 14))
	{	
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[3]['tilpums']=$pa_klasem[3]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[3]['skaits']=$pa_klasem[3]['skaits']+1;
	}
	if (($d1 >= 15 and $d1 <= 17))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[4]['tilpums']=$pa_klasem[4]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[4]['skaits']=$pa_klasem[4]['skaits']+1;
	}
	if (($d1 >= 18 and $d1 <= 19))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[5]['tilpums']=$pa_klasem[5]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[5]['skaits']=$pa_klasem[5]['skaits']+1;
	}
	if (($d1 >= 20 and $d1 <= 24))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[6]['tilpums']=$pa_klasem[6]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[6]['skaits']=$pa_klasem[6]['skaits']+1;
	}
	if (($d1 >= 25 and $d1 <= 29))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[7]['tilpums']=$pa_klasem[7]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[7]['skaits']=$pa_klasem[7]['skaits']+1;
	}
	if (($d1 >= 30 and $d1 <= 34))
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[8]['tilpums']=$pa_klasem[8]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[8]['skaits']=$pa_klasem[8]['skaits']+1;
	}
	if ($d1 >= 35)
	{
		$pa_klasem_kopa_t0 = $pa_klasem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[9]['tilpums']=$pa_klasem[9]['tilpums']+tilpums($metode,$d1,$d2,$lx);
		$pa_klasem[9]['skaits']=$pa_klasem[9]['skaits']+1;
	}




	//brāķa/redukcijas tilpuma sadaliijums pa braakja kodiem

	if ($kx == 9 and !$re) //skira
	{
		for ($i=0; $i<= 9;$i++)
		{
			if ($bx == $i) //braka kods
			{
				$pa_b_kodiem_kopa_t0 = $pa_b_kodiem_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_b_kodiem[$i]['tilpums']=$pa_b_kodiem[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_b_kodiem[$i]['skaits']=$pa_b_kodiem[$i]['skaits']+1;
			}
		}
	}

	if ($kx < 9)
	{
		if (!$re)
		{
			//NAV
		}
		if ($re > 0)
		{
			//echo 'red = ' . $re;
			//echo 'tilpums = ' . tilpums($metode,$d1,$d2,$lx);

			//tilpums($metode,$d1,$d2,$lx) * 
			$pa_b_kodiem_kopa_t0 = $pa_b_kodiem_kopa_t0 + ($re * 0.0025);
			//echo 'kopā redukcija = ' . $pa_b_kodiem_kopa_t0;

			//tilpums($metode,$d1,$d2,$lx) * 
			$pa_b_kodiem[10]['tilpums']=$pa_b_kodiem[10]['tilpums']+($re * 0.0025);
			$pa_b_kodiem[10]['skaits']=$pa_b_kodiem[10]['skaits']+1;
		}
	}

	//neto tilpuma sadalījums pa sugām
	//echo $sx;

	if ($kx < 9) //skira
	{
		if (!$re) 
		{	
			$ir_kods = 0;
			for ($i=1; $i<= 9;$i++)
			{
				if ($sx == $i) //suga
				{
					$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
					$pa_sugam[$i]['tilpums']=$pa_sugam[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
					$pa_sugam[$i]['skaits']=$pa_sugam[$i]['skaits']+1;
					$ir_kods = 1;
				}
			}
			if ($ir_kods == 0)
			{
				$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_sugam[10]['tilpums']=$pa_sugam[10]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_sugamm[10]['skaits']=$pa_sugam[10]['skaits']+1;	
			}
		}

		if ($re > 0)
		{
			$ir_kods = 0;
			for ($i=1; $i<= 9;$i++)
			{
				if ($sx == $i)
				{
					//tilpums($metode,$d1,$d2,$lx) * 
					if ((tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025)) < 0)
					{echo "KLUDA";}

					//tilpums($metode,$d1,$d2,$lx) * 
					$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
					//tilpums($metode,$d1,$d2,$lx) * 
					$pa_sugam[$i]['tilpums']=$pa_sugam[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
					$pa_sugam[$i]['skaits']=$pa_sugam[$i]['skaits']+1;
					$ir_kods = 1;
				}
			}
			if ($ir_kods == 0)
			{
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_sugam[10]['tilpums']=$pa_sugam[10]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				$pa_sugamm[10]['skaits']=$pa_sugam[10]['skaits']+1;	
			}
		}
	}

	//neto tilpuma sadalījums pa šķirām
	//echo $sx;

	//echo $kx . '/';
	//echo $re . '/';

	if (!$re) 
	{	
		for ($i=1; $i<= 8;$i++)
		{
			if ($kx == $i) //skira
			{
				$pa_skiram_kopa_t0 = $pa_skiram_kopa_t0 + tilpums($metode,$d1,$d2,$lx);
				$pa_skiram[$i]['tilpums']=$pa_skiram[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx);
				$pa_skiram[$i]['skaits']=$pa_skiram[$i]['skaits']+1;
				$ir_kods = 1;
			}
		}
	}
	if ($re > 0)
	{
		for ($i=1; $i<= 9;$i++)
		{
			if ($kx == $i)
			{
				//tilpums($metode,$d1,$d2,$lx) * 
				if ((tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025)) < 0)
				{echo "KLUDA";}
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_skiram_kopa_t0 = $pa_skiram_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				//tilpums($metode,$d1,$d2,$lx) * 
				$pa_skiram[$i]['tilpums']=$pa_skiram[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - ($re * 0.0025);
				$pa_skiram[$i]['skaits']=$pa_skiram[$i]['skaits']+1;
				$ir_kods = 1;
			}
		}
	}

	$skaits_kopa++;
}

$vid_diam = $diam_summa / ($skaits_kopa * 2);
$vid_gar = $gar_summa / $skaits_kopa;

$liel_b_kods = 0;
$liel_b_tilpums = 0;
for ($i = 0; $i<10; $i++)
{
	if ($pa_b_kodiem[$i]['tilpums'] > $liel_b_tilpums)
	{
		$liel_b_tilpums = $pa_b_kodiem[$i]['tilpums'];
		$liel_b_kods = $i;
	}
}

//echo " kopaa ".$test;

//echo "<br>V kopa =".$test."<br>";
//echo "V bruto = ".$pa_klasem_kopa_t0."<br>";
//echo "V br/red = ".$pa_b_kodiem_kopa_t0."<br>";
//echo "V neto = ".$pa_sugam_kopa_t0."<br>";
// echo "sk = ".$skaits_kopa."<br><br>";
// echo "pa sugam: ";
// print_r($pa_sugam);
// echo "<br><br>";
// echo "pa b dodiem: ";
// print_r($pa_b_kodiem);
// echo "<br><br>";
// echo "pa klasem: ";
// print_r($pa_klasem);
// echo "<br><br>";
// echo tilpums(1,7,7,3);
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
<link rel=File-List href="./papirmalka_atskaite_files/filelist.xml">
<link rel=Edit-Time-Data href="./papirmalka_atskaite_files/editdata.mso">
<link rel=OLE-Object-Data href="./papirmalka_atskaite_files/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:LastAuthor>mariz</o:LastAuthor>
  <o:LastPrinted>2006-01-17T12:47:16Z</o:LastPrinted>
  <o:Created>2006-01-16T14:24:20Z</o:Created>
  <o:LastSaved>2006-01-17T12:56:11Z</o:LastSaved>
  <o:Version>9.3821</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:DownloadComponents/>
  <o:LocationOfComponents HRef="file:///D:/msowc.cab"/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:" ";}
@page
	{margin:.98in 0in .98in .75in;
	mso-header-margin:.51in;
	mso-footer-margin:.51in;}
tr
	{mso-height-source:auto;}
col
	{mso-width-source:auto;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
.style092
	{mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:8.5pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
tds
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:186;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl24
	{mso-style-parent:style0;
	text-align:right;}
.xl25
	{mso-style-parent:style0;
	text-align:center;}
.xl26
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl27
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl28
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl29
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl30
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl31
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl32
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl33
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl34
	{mso-style-parent:style0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl35
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl36
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;}
.xl37
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl38
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl39
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl40
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl41
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl42
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl43
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl44
	{mso-style-parent:style0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl45
	{mso-style-parent:style0;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl46
	{mso-style-parent:style0;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl47
	{mso-style-parent:style0;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl48
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl49
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl50
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	white-space:normal;}
.xl51
	{mso-style-parent:style0;
	border:.5pt solid windowtext;}
.xl52
	{mso-style-parent:style0;
	font-size:13.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl53
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl54
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl55
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl56
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl57
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl58
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl59
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl60
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl61
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl62
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl63
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl64
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid black;}
.xl65
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl66
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl67
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl68
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl69
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid black;}
.xl70
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl71
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl72
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl73
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl74
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl75
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid windowtext;}
.xl76
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl77
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl78
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl79
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl80
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl81
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl82
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl83
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl84
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;}
.xl85
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid windowtext;}
.xl86
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;}
.xl87
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;}
.xl88
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;}
.xl89
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl90
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid black;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl91
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;}
.xl92
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl93
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl94
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl95
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl96
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl97
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl98
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid black;}
.xl99
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl100
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl101
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl102
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl103
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl104
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl105
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl106
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl107
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl108
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl109
	{mso-style-parent:style0;
	text-align:left;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl110
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl111
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl112
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl113
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	white-space:normal;}
.xl114
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	white-space:normal;}
.xl115
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl116
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	white-space:normal;}
.xl117
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	white-space:normal;}
.xl118
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl119
	{mso-style-parent:style0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl444
	{mso-style-parent:style092;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:none;}   
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>papirmalka 1 </x:Name>
    <x:WorksheetOptions>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:HorizontalResolution>204</x:HorizontalResolution>
      <x:VerticalResolution>196</x:VerticalResolution>
      <x:NumberofCopies>0</x:NumberofCopies>
     </x:Print>
     <x:PageBreakZoom>60</x:PageBreakZoom>
     <x:Selected/>
     <x:DoNotDisplayGridlines/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>1</x:ActiveRow>
       <x:RangeSelection>A2:G2</x:RangeSelection>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>9345</x:WindowHeight>
  <x:WindowWidth>14220</x:WindowWidth>
  <x:WindowTopX>360</x:WindowTopX>
  <x:WindowTopY>60</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>
<table x:str border=0 cellpadding=0 cellspacing=0 width=653 style='border-collapse:
 collapse;table-layout:fixed;width:493pt'>
 <col width=56 style='mso-width-source:userset;mso-width-alt:2048;width:42pt'>
 <col width=58 style='mso-width-source:userset;mso-width-alt:2121;width:44pt'>
 <col width=49 span=11 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>VMF MI P 04.02.05</td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>2.variants</td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>04.07.2008</td></tr>
 <tr height=49 style='mso-height-source:userset;height:16.75pt'>
  <td colspan=10 height=49 class=xl52 width=506 style='height:16.75pt;width:382pt'>Krautnes un individuālās uzmērīšanas salidzinājums</td>
  <td class=xl24 width=49 style='width:37pt' x:str="Nr. ">Nr. </td>
  <td colspan=2 width=98 style='width:74pt'><?=substr($te,8,2)?>/</td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:16.0pt'>
  <td colspan=7 height=40 class=xl53 style='height:16.0pt'>Krautnes uzmērīšana
  (K - mērīšana)</td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td colspan=4 height=16 class=xl54 style='border-right:.5pt solid black;
  height:12.0pt'>Pakas identif.nr.</td>
  <td colspan=3 class=xl57 x:num style='border-right:1.0pt solid black;border-left:
  none'><?=$m['nr']//#pakas_nr
  ?> 
  </td>
  <td></td>
  <td colspan=3 class=xl54 style='border-right:1.0pt solid black'>Sortiments</td>
  <td colspan=2 class=xl59 x:num style='border-right:1.0pt solid black;border-left:
  none'><?=$m['so']?></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td colspan=4 height=16 class=xl60 style='border-right:1.0pt solid black;
  height:12.0pt'>Pasūtītajs</td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black;border-left:
  none'><!--#pasutitajs#--></td>
  <td></td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black'>Kolektīvs</td>
  <td colspan=2 class=xl64 style='border-right:1.0pt solid black;border-left:
  none'><!--#kolektivs#--></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl60 style='border-right:1.0pt solid black;
  height:13.5pt'>Kontrolmērījuma vieta</td>
  <td colspan=3 class=xl60 style='border-right:1.0pt solid black;border-left:
  none'><!--#vieta--></td>
  <td></td>
  <td colspan=3 class=xl65 style='border-right:1.0pt solid black'>Grēdas nr uz
  autotransp.</td>
  <td colspan=2 class=xl69 style='border-right:1.0pt solid black;border-left:
  none'><!--#gredasnr#--></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'>Kontrolmērījuma datums</td>
  <td colspan=3 class=xl71 style='border-right:1.0pt solid black;border-left:
  none'><?=substr($te,0,10)?></td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
  <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'>Kontrolpakas izvēles datums</td>
  <td colspan=3 class=xl71 style='border-right:1.0pt solid black;border-left:
  none'><!--#izvdat#--></td>
  <td colspan=6 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td colspan=6 height=27 class=xl73 style='height:20.25pt'>Kraujmērā
  uzmērīšanas rezultāts</td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td rowspan=2 height=37 class=xl74 style='border-bottom:1.0pt solid black;
  height:27.75pt;border-top:none'>Platums</td>
  <td rowspan=2 class=xl76 style='border-bottom:1.0pt solid black;border-top:
  none'>Augstums</td>
  <td rowspan=2 class=xl76 style='border-bottom:1.0pt solid black;border-top:
  none'>Garums</td>
  <td rowspan=2 class=xl78 style='border-bottom:1.0pt solid black;border-top:
  none'>Steri</td>
  <td rowspan=2 class=xl78 style='border-bottom:1.0pt solid black;border-top:
  none'>K, %</td>
  <td class=xl26>Bruto tilp</td>
  <td colspan=2 class=xl80 style='border-right:.5pt solid black;border-left:
  none'>Brāķis</td>
  <td class=xl27>Neto tilp</td>
  <td colspan=4 rowspan=2 class=xl82 style='border-right:1.0pt solid black;
  border-bottom:.5pt solid black'>Sugu sadalīlums, %</td>
 </tr>
 <tr class=xl25 height=18 style='mso-height-source:userset;height:13.5pt'>
  <td height=18 class=xl28 style='height:13.5pt'>m3</td>
  <td class=xl28>Kods</td>
  <td class=xl28>%</td>
  <td class=xl29>m3</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl30 style='height:12.75pt' x:num><?=$pl?></td>
  <td class=xl31 x:num><?=$ag?></td>
  <td class=xl31 x:num><?=$gr?></td>
  <td class=xl31 x:num x:fmla="=ROUND(A11*B11*C11%%%,2)"><!--#Steri#--></td>
  <td class=xl31 x:num><?=$ti?></td>
  <td class=xl31 x:num x:fmla="=ROUND(A11*B11*C11*E11%%%%,3)"><!--#kbrut#--></td>
  <td class=xl31 x:num><?=$bk?></td>
  <td class=xl31 x:num><?=$bp?></td>
  <td class=xl33 x:num x:fmla="=ROUND(F11-(F11*H11%),3)"><!--#knet#--></td>
  <td rowspan=2 class=xl88 style='border-bottom:1.0pt solid black;border-top:
  none'>Priede</td>
  <td rowspan=2 class=xl89 style='border-bottom:1.0pt solid black;border-top:
  none'>Egle</td>
  <td rowspan=2 class=xl89 style='border-bottom:1.0pt solid black;border-top:
  none'>Bērzs</td>
  <td rowspan=2 class=xl90 style='border-bottom:1.0pt solid black;border-top:
  none'>citas</td>
 </tr>
 <tr height=5 style='mso-height-source:userset;height:3.75pt'>
  <td height=5 class=xl34 style='height:3.75pt'>&nbsp;</td>
  <td colspan=3 style='mso-ignore:colspan'></td>
  <td class=xl35>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td class=xl36>&nbsp;</td>
  <td></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl92 style='border-right:1.0pt solid black;
  height:13.5pt'>Individuālās uzm. rezultāts</td>
  <td class=xl37><!--#kind#--></td>
  <td class=xl31 x:num><?=number_format($pa_klasem_kopa_t0,3,'.','')?></td>
  <td class=xl31 x:num><?=$liel_b_kods?></td>
  <td class=xl31 x:num><?=number_format(($pa_b_kodiem_kopa_t0/$pa_klasem_kopa_t0)*100,1,'.','')?></td>
  <td class=xl31 x:num><?=number_format($pa_sugam_kopa_t0,3,'.','')?></td>
  <td class=xl40 x:num><?=number_format(($pa_sugam[1]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- priede -->
  <td class=xl40 x:num><?=number_format(($pa_sugam[2]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- egle -->
  <td class=xl40 x:num><?=number_format(($pa_sugam[4]['tilpums'] / $pa_sugam_kopa_t0 * 100),1,'.','')?></td><!-- berzs -->
  <td class=xl41 x:num><?=number_format((($pa_sugam_kopa_t0 - $pa_sugam[1]['tilpums'] - $pa_sugam[2]['tilpums'] - $pa_sugam[4]['tilpums'])/ $pa_sugam_kopa_t0 * 100),1,'.','')?></td> <!-- citi -->
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 colspan=13 style='height:9.0pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl95 style='border-right:1.0pt solid black;
  height:13.5pt'>Bruto novirze</td>
  <td colspan=3 x:num class=xl98 style='border-right:1.0pt solid black;border-left:none' x:fmla="=ROUND(F11/F13*100-100,1)"><!--#bnovirze#--></td>
  <td></td>
  <td colspan=2 class=xl92 style='border-right:1.0pt solid black'>Neto novirze</td>
  <td colspan=2 class=xl98 style='border-right:1.0pt solid black;border-left:none' x:num x:fmla="=ROUND(I11/I13*100-100,1)"><!--#nnovirze#--></td>
  <td colspan=3 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 colspan=13 style='height:9.0pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=6 height=17 class=xl100 style='height:12.75pt'>Individuālās
  uzmērīšanas analīze</td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl54 style='border-right:1.0pt solid black;
  height:12.75pt'>Bruto tilpums</td>
  <td colspan=3 class=xl59 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($pa_klasem_kopa_t0,3,'.','')?></td>
  <td></td>
  <td colspan=4 class=xl54 style='border-right:1.0pt solid black'>Sortimenta
  skaits</td>
  <td colspan=3 class=xl59 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=$skaits_kopa?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'>Brāķis/redukcija</td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($pa_b_kodiem_kopa_t0,3,'.','')?></td>
  <td></td>
  <td colspan=4 class=xl60 style='border-right:1.0pt solid black'>Aritmētiskais
  vidējais diametrs</td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($vid_diam,3,'.','')?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'>Neto tilpums</td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format($pa_sugam_kopa_t0,3,'.','')?></td>
  <td></td>
  <td colspan=4 class=xl60 style='border-right:1.0pt solid black'>Aritmētiskais
  vidējais garums</td>
  <td colspan=3 class=xl64 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=$vid_gar?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'>Metode</td>
  <td colspan=3 class=xl69 style='border-right:1.0pt solid black;border-left:
  none' x:num><? if ($_POST['metode_id'] == 1) {echo "pēc LVS 82:2003";} else {echo "pēc VMR 1-06";} ?></td>
  <td></td>
  <td colspan=4 class=xl71 style='border-right:1.0pt solid black'>Pirmo
  sortimentu tilpums, %</td>
  <td colspan=3 class=xl69 style='border-right:1.0pt solid black;border-left:
  none' x:num><?=number_format(($pirma_sortimenta_t0 / $pa_klasem_kopa_t0) * 100,1,'.','')?></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td colspan=6 height=27 class=xl101 style='height:20.25pt'>Bruto tilpuma
  sadalījums pa klasēm</td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=3 height=18 class=xl102 style='border-right:1.0pt solid black;
  height:13.5pt'>Diametra klase, cm</td>
  <td class=xl42>&lt;7</td>
  <td class=xl42><span style="mso-spacerun: yes"> </span>8-10</td>
  <td class=xl42><span style="mso-spacerun: yes"> </span>11-14</td>
  <td class=xl43><span style="mso-spacerun: yes"> </span>15-17</td>
  <td class=xl43><span style="mso-spacerun: yes"> </span>18-19</td>
  <td class=xl43>20-24</td>
  <td class=xl43>25-29</td>
  <td class=xl43>30-34</td>
  <td class=xl43>35&gt;=</td>
  <td class=xl44>Kopā</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=3 height=17 class=xl60 style='border-right:1.0pt solid black;
  height:12.75pt'>Tilpums, %</td>
  <? for ($i = 1; $i <= 9; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format(($pa_klasem[$i]['tilpums']/$pa_klasem_kopa_t0) * 100, 3, '.', '')?></td>
  <?
  $pa_klasem_kopa_t = $pa_klasem_kopa_t + $pa_klasem[$i]['tilpums']/$pa_klasem_kopa_t0 * 100;
  } ?>
  <td class=xl45 align=center x:num><?=$pa_klasem_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=3 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'>Skaits</td>
  <? for($i = 1; $i<= 9; $i++) { ?>
  <td class=xl31 align=center x:num><?=$pa_klasem[$i]['skaits']?></td>
  <? 
  $pa_klasem_kopa_s = $pa_klasem_kopa_s + $pa_klasem[$i]['skaits'];
  } ?>
   <td class=xl31 align=center x:num><?=$pa_klasem_kopa_s?></td>
 </tr>
 <tr height=39 style='mso-height-source:userset;height:29.25pt'>
  <td colspan=9 height=39 class=xl73 style='height:29.25pt'>Brāķa/redukcijas
  tilpuma sadalījums pa brāķa kodiem</td>
  <td colspan=5 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl105 style='border-right:1.0pt solid black;
  height:13.5pt'>Brāķa kods</td>
  <td class=xl42 x:num>1</td>
  <td class=xl42 x:num>2</td>
  <td class=xl42 x:num>3</td>
  <td class=xl42 x:num>4</td>
  <td class=xl42 x:num>5</td>
  <td class=xl42 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl43 x:num>9</td>
  <td class=xl47>Redukcija</td>
  <td class=xl44>Kopā</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'>Tilpums, %</td>
  <?for ($i = 1; $i <= 10; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format($pa_b_kodiem[$i]['tilpums']/$pa_b_kodiem_kopa_t0 * 100, 3, '.', '')?></td>
  <?
  $pa_b_kodiem_kopa_t = $pa_b_kodiem_kopa_t + $pa_b_kodiem[$i]['tilpums']/$pa_b_kodiem_kopa_t0 * 100;
  } ?>
  <td class=xl49 x:num><?=$pa_b_kodiem_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl71 style='border-right:1.0pt solid black;
  height:13.5pt'>Skaits</td>
  <?for ($i = 1; $i <= 10; $i++){ ?>
  <td class=xl28 x:num><?=$pa_b_kodiem[$i]['skaits']?></td>
  <?
  $pa_b_kodiem_kopa_s = $pa_b_kodiem_kopa_s + $pa_b_kodiem[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_b_kodiem_kopa_s?></td>
 </tr>
 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td colspan=6 height=34 class=xl73 style='height:25.5pt'>Neto tilpuma
  sadalījums pa sugām</td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl109 style='border-right:1.0pt solid black;
  height:13.5pt'>Suga</td>
  <td class=xl42 x:num>1</td>
  <td class=xl42 x:num>2</td>
  <td class=xl42 x:num>3</td>
  <td class=xl42 x:num>4</td>
  <td class=xl43 x:num>5</td>
  <td class=xl43 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl43 x:num>9</td>
  <td class=xl43 x:num>Citas</td>
  <td class=xl44>Kopā</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'>Tilpums, %</td>
  <? for ($i = 1; $i <= 10; $i++)
  { ?>
  <td class=xl48 x:num><?=number_format(($pa_sugam[$i]['tilpums'] / $pa_sugam_kopa_t0 * 100),3,'.','')?></td>
  <?
   $pa_sugam_kopa_t =  $pa_sugam_kopa_t + $pa_sugam[$i]['tilpums'] / $pa_sugam_kopa_t0 * 100;
  } ?>
  <td class=xl49 x:num><?=$pa_sugam_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=2 height=18 class=xl110 style='border-right:1.0pt solid black;
  height:13.5pt'>Skaits</td>
  <? for ($i = 1; $i <= 10; $i++)
  { ?>
  <td class=xl28 x:num><?=$pa_sugam[$i]['skaits']?></td>
  <?
  $pa_sugam_kopa_s = $pa_sugam_kopa_s + $pa_sugam[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_sugam_kopa_s?></td>
 </tr>

 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td colspan=6 height=34 class=xl73 style='height:25.5pt'>Neto tilpuma
  sadalījums pa šķirām</td>
  <td colspan=7 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl109 style='border-right:1.0pt solid black;
  height:13.5pt'>Šķira</td>
  <td class=xl43 x:num>1</td>
  <td class=xl43 x:num>2</td>
  <td class=xl43 x:num>3</td>
  <td class=xl43 x:num>4</td>
  <td class=xl43 x:num>5</td>
  <td class=xl43 x:num>6</td>
  <td class=xl43 x:num>7</td>
  <td class=xl43 x:num>8</td>
  <td class=xl44>Kopā</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=4 height=17 class=xl107 style='border-right:1.0pt solid black;
  height:12.75pt'>Tilpums, %</td>
  <? for ($i = 1; $i <= 8; $i++) {
  if ($pa_skiram_kopa_t0 > 0) {
  ?>
  <td class=xl48 x:num><?=number_format(($pa_skiram[$i]['tilpums'] / $pa_skiram_kopa_t0 * 100),3,'.','')?></td>
  <?
   $pa_skiram_kopa_t =  $pa_skiram_kopa_t + $pa_skiram[$i]['tilpums'] / $pa_skiram_kopa_t0 * 100;
  } else {
	 ?>
	<td class=xl48 x:num>0</td>
	<?
	$pa_skiram_kopa_t = 0;
  }
  } ?>
  <td class=xl49 x:num><?=$pa_skiram_kopa_t?></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td colspan=4 height=18 class=xl110 style='border-right:1.0pt solid black;
  height:13.5pt'>Skaits</td>
  <? for ($i = 1; $i <= 8; $i++)
  { ?>
  <td class=xl28 x:num><?=$pa_skiram[$i]['skaits']?></td>
  <?
  $pa_skiram_kopa_s = $pa_skiram_kopa_s + $pa_skiram[$i]['skaits'];
  } ?>
  <td class=xl29 x:num><?=$pa_skiram_kopa_s?></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 colspan=13 style='height:17.25pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'>Piezīmes</td>
  <td colspan=12 rowspan=2 class=xl112 width=597 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:451pt'><!--#piezimes#--></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 style='height:12.75pt'></td>
  <td colspan=12 class=xl50 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 style='border-right:.5pt solid black;height:12.75pt'>Kontrolmērītājs</td>
  <td colspan=9 class=xl118 style='border-right:.5pt solid black;border-left:
  none'><!--#meritajs#--></td>
  <td class=xl24 x:str="Nr. ">Nr. </td>
  <td class=xl51><!--#nr#--></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:30.75pt'><td colspan=13 height=17 style='height:12.75pt'>SIA VMF LATVIA valdes loceklis _________________________________________ /Jānis Buļs/</td></tr>
 <tr height=17 style='mso-height-source:userset;height:30.75pt'><td colspan=13 height=10 style='height:12.75pt;font-size:8pt;text-align:right'>Mērījums veikts SIA VMF LATVIA</td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>Reģ.nr.: 40003405130</td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>Artilērijas iela 40, korpuss 12, Rīga, LV-1009</td></tr>
 <tr height=17 style='mso-height-source:userset;height:10.75pt'><td colspan=13 height=10 style='height:9.75pt;font-size:8pt;text-align:right'>Tālrunis +371 29470949; Fakss +371 67223718; e-pasts vmflatvia@vmf.lv</td></tr>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=56 style='width:42pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
 </tr>
 <![endif]>
</table>
</body>

</html>

