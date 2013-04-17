<?
include '../connect.php';
header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=papirmalka.xls"); header("Content-transfer-encoding: binary");

$non_arch = $_GET['excel'];

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
		// $d1 - > cm
		// $d2 - > cm
		// $lx - > m
		
		if ($d1 <= 14)
		{
			if ($l <= 349) $alfa = 0.485;
			if ($l >= 350 and $l <= 449) $alfa = 0.485;
			if ($l >= 450) $alfa = 0.485;
		}
		if ($d1 >= 15 and $d1 <= 24)
		{
			if ($l <= 349) $alfa = 0.465;
			if ($l >= 350 and $l <= 449) $alfa = 0.460;
			if ($l >= 450) $alfa = 0.455;
		}
		if ($d1 >= 25)
		{
			if ($l <= 349) $alfa = 0.465;
			if ($l >= 350 and $l <= 449) $alfa = 0.460;
			if ($l >= 450) $alfa = 0.455;
		}
		$tilp = (1/100000) * (3.1416/4) * $lx * (($alfa * $d2 * $d2) + (1 - $alfa) * $d1 * $d1);
	}
	$tilp = number_format($tilp, 3, '.', '');
	return $tilp;
}

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 11">
<link rel=File-List href="test_papirmalka_files/filelist.xml">
<link rel=Edit-Time-Data href="test_papirmalka_files/editdata.mso">
<link rel=OLE-Object-Data href="test_papirmalka_files/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>li</o:Author>
  <o:LastAuthor>li</o:LastAuthor>
  <o:Created>2005-12-30T14:03:45Z</o:Created>
  <o:LastSaved>2005-12-30T14:16:09Z</o:LastSaved>
  <o:Company>ms</o:Company>
  <o:Version>11.5207</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:" ";}
@page
	{margin:1.0in .75in 1.0in .75in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;}
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
.xl24
	{mso-style-parent:style0;
	text-align:left;
	border:.5pt solid windowtext;}
.xl25
	{mso-style-parent:style0;
	text-align:center;
	border:.5pt solid windowtext;}
.xl26
	{mso-style-parent:style0;
	text-align:right;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl27
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl28
	{mso-style-parent:style0;
	color:purple;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl29
	{mso-style-parent:style0;
	color:purple;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl30
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl31
	{mso-style-parent:style0;
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl32
	{mso-style-parent:style0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl33
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl34
	{mso-style-parent:style0;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	white-space:normal;}
.xl35
	{mso-style-parent:style0;
	color:fuchsia;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	white-space:normal;}
.xl36
	{mso-style-parent:style0;
	color:fuchsia;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl37
	{mso-style-parent:style0;
	color:fuchsia;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl38
	{mso-style-parent:style0;
	color:fuchsia;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl39
	{mso-style-parent:style0;
	color:#3366FF;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	white-space:normal;}
.xl40
	{mso-style-parent:style0;
	color:#3366FF;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl41
	{mso-style-parent:style0;
	color:#3366FF;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl42
	{mso-style-parent:style0;
	color:#3366FF;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl43
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl44
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl45
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl46
	{mso-style-parent:style0;
	color:purple;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl47
	{mso-style-parent:style0;
	color:purple;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl48
	{mso-style-parent:style0;
	color:aqua;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"0\.0000";
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl49
	{mso-style-parent:style0;
	color:aqua;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"0\.0000";
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl50
	{mso-style-parent:style0;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;}
.xl51
	{mso-style-parent:style0;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl52
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;
	white-space:normal;}
.xl53
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;
	white-space:normal;}
.xl54
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;
	white-space:normal;}
.xl55
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;
	white-space:normal;}
.xl56
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;}
.xl57
	{mso-style-parent:style0;
	color:blue;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#FFCC99;
	mso-pattern:auto none;}
.xl58
	{mso-style-parent:style0;
	color:aqua;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"0\.0000";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl59
	{mso-style-parent:style0;
	color:aqua;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"0\.0000";
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl60
	{mso-style-parent:style0;
	color:fuchsia;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl61
	{mso-style-parent:style0;
	color:fuchsia;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl62
	{mso-style-parent:style0;
	color:fuchsia;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl63
	{mso-style-parent:style0;
	color:#3366FF;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl64
	{mso-style-parent:style0;
	color:#3366FF;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl65
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl66
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl67
	{mso-style-parent:style0;
	color:#FF6600;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl68
	{mso-style-parent:style0;
	color:purple;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border:.5pt solid windowtext;}
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Sheet1</x:Name>
    <x:WorksheetOptions>
     <x:Selected/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>17</x:ActiveRow>
       <x:ActiveCol>7</x:ActiveCol>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Sheet2</x:Name>
    <x:WorksheetOptions>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Sheet3</x:Name>
    <x:WorksheetOptions>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>10365</x:WindowHeight>
  <x:WindowWidth>13260</x:WindowWidth>
  <x:WindowTopX>480</x:WindowTopX>
  <x:WindowTopY>60</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>

<table x:str border=0 cellpadding=0 cellspacing=0 width=2432 style='border-collapse:
 collapse;table-layout:fixed;width:1824pt'>
 <col width=64 span=38 style='width:48pt'>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl24 width=64 style='height:12.75pt;width:48pt'
  x:str="Noliktās ">Noliktās<span style='mso-spacerun:yes'> </span></td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl24 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl24 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl24 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl24 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl24 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl26 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl27 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td colspan=8 class=xl60 width=512 style='border-right:1.0pt solid black;
  width:384pt'>1 mērījuma dati</td>
  <td colspan=6 class=xl63 width=384 style='border-right:1.0pt solid black;
  width:288pt'>kontrolmērnieka dati</td>
  <td colspan=3 class=xl65 width=192 style='border-right:1.0pt solid black;
  width:144pt'>Uzmērīšanas novirze %</td>
  <td colspan=2 class=xl68 width=128 style='width:96pt'>Mērītāja dati</td>
  <td class=xl28 colspan=2 width=128 style='mso-ignore:colspan;width:96pt'>Kontrolmērnieka
  dati</td>
  <td rowspan=2 class=xl52 width=64 style='border-bottom:1.0pt solid black;
  width:48pt'>Kontrolmērnieks</td>
  <td rowspan=2 class=xl54 width=64 style='border-bottom:1.0pt solid black;
  width:48pt'>KP izdrukas Nr.</td>
  <td rowspan=2 class=xl56 width=64 style='border-bottom:1.0pt solid black;
  width:48pt'>Piezīmes</td>
  <td colspan=2 class=xl58 width=128 style='width:96pt'>Korekcija</td>
  <td rowspan=2 class=xl50 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Vid. diam.</td>
 </tr>
 <tr height=52 style='height:39.0pt'>
  <td height=52 class=xl30 style='height:39.0pt;border-top:none'>pakas</td>
  <td class=xl30 style='border-top:none;border-left:none'>Diena</td>
  <td class=xl30 style='border-top:none;border-left:none'>Mēnesis</td>
  <td class=xl30 style='border-top:none;border-left:none'>Gads</td>
  <td class=xl31 style='border-top:none;border-left:none'>Kuģis</td>
  <td class=xl31 style='border-top:none;border-left:none'>Vieta</td>
  <td class=xl32 style='border-top:none;border-left:none'>Osta</td>
  <td class=xl32 style='border-top:none'>Pasūtītājs</td>
  <td class=xl33 width=64 style='border-top:none;width:48pt'>Piegādā-tājs</td>
  <td class=xl34 width=64 style='border-top:none;width:48pt'>Mērītājs</td>
  <td class=xl33 width=64 style='border-top:none;border-left:none;width:48pt'>Sortiments</td>
  <td class=xl35 width=64 style='border-top:none;width:48pt'>Platums</td>
  <td class=xl36 width=64 style='border-top:none;border-left:none;width:48pt'>Augstums</td>
  <td class=xl36 width=64 style='border-top:none;border-left:none;width:48pt'>Garums</td>
  <td class=xl37 style='border-top:none'>k%</td>
  <td class=xl36 width=64 style='border-top:none;border-left:none;width:48pt'>Bruto
  m3</td>
  <td class=xl36 width=64 style='border-top:none;border-left:none;width:48pt'>Brāķa
  kods</td>
  <td class=xl36 width=64 style='border-top:none;border-left:none;width:48pt'>Brāķis
  %</td>
  <td class=xl38 width=64 style='border-top:none;border-left:none;width:48pt'>Neto
  m3</td>
  <td class=xl39 width=64 style='border-top:none;width:48pt'>UzmērīšanasDatums</td>
  <td class=xl40 style='border-top:none;border-left:none'>k%</td>
  <td class=xl41 width=64 style='border-top:none;border-left:none;width:48pt'>Bruto
  m3</td>
  <td class=xl41 width=64 style='border-top:none;border-left:none;width:48pt'>Brāķa
  kods</td>
  <td class=xl41 width=64 style='border-top:none;border-left:none;width:48pt'>Brāķis
  %</td>
  <td class=xl42 width=64 style='border-top:none;border-left:none;width:48pt'>Neto
  m3</td>
  <td class=xl43 style='border-top:none'>koeficientam</td>
  <td class=xl44 style='border-top:none;border-left:none'>Bruto</td>
  <td class=xl45 style='border-top:none;border-left:none'>Neto</td>
  <td class=xl46 style='border-top:none'>II</td>
  <td class=xl46 style='border-top:none;border-left:none'>I</td>
  <td class=xl46 style='border-top:none;border-left:none'>II</td>
  <td class=xl47 style='border-top:none;border-left:none'>I</td>
  <td class=xl48 style='border-top:none'>Bruto</td>
  <td class=xl49 style='border-top:none;border-left:none'>Neto</td>
 </tr>
 <!-- ************************** GALVAS DAĻA BEIDZAS ******************** -->
<?

$today = getdate();
$month = $today['mon'];
$year = $today['year'];
$month_s = ($month - 3) + $year * 12;

if ($non_arch == "n") {
$rpapirmalka = mysql_query("select * from papirmalka where MID( ts, 7, 4 ) *12 + MID( ts, 4, 2 ) > ".$month_s);
} else {
$rpapirmalka = mysql_query("select * from papirmalka where MID( ts, 7, 4 ) *12 + MID( ts, 4, 2 ) <= ".$month_s);
}

while ($mpapirmalka = mysql_fetch_array($rpapirmalka))
{
	// *********************** aprēķini ************************************
	
	$darba_id = $mpapirmalka['id'];
	$metode = $mpapirmalka['metode'];

	$pa_klasem_kopa_t0 = 0;
	$pa_b_kodiem_kopa_t0 = 0;
	$pa_sugam_kopa_t0 = 0;
	$pa_skiram_kopa_t0 = 0;
	$pirma_sortimenta_t0 = 0;

	for ($i = 0; $i<=11; $i++)
	{
		$pa_b_kodiem[$i]['tilpums'] = '';
		$pa_b_kodiem[$i]['skaits'] = '';
	}

	$test = 0;

	$skaits_kopa = 0;
	$diam_summa = 0;
	$gar_summa = 0;
	$ra = mysql_query(" select * from papirmalka_merijumi where papirmalka_id = $darba_id ");
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

		//echo ($skaits_kopa + 1).")   ".tilpums($metode,$d1,$d2,$lx)." metode".$metode."<br>";
		$test = $test + tilpums($metode,$d1,$d2,$lx);

		if ($d1 > $d2)
		{
			$c = $d1;
			$d1 = $d2;
			$d2 = $c;
		}
		
		//echo "d1->".$d1."<-d1<br>";
		
		// pirmo sortimentu tilpums
		/* if ($rx == 1)
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
		*/

		//brāķa/redukcijas tilpuma sadaliijums pa braakja kodiem

		if ($kx == 9 and !$re) //skira
		{
			for ($i=1; $i<= 9;$i++)
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
				$pa_b_kodiem_kopa_t0 = $pa_b_kodiem_kopa_t0 + (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
				$pa_b_kodiem[10]['tilpums']=$pa_b_kodiem[10]['tilpums']+(tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
				$pa_b_kodiem[10]['skaits']=$pa_b_kodiem[10]['skaits']+1;
			}
		}

		//neto tilpuma sadalījums pa sugām
		//echo $sx;
		/*
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
						if ((tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025)) < 0)
						{echo "KLUDA";}

						$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
						$pa_sugam[$i]['tilpums']=$pa_sugam[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
						$pa_sugam[$i]['skaits']=$pa_sugam[$i]['skaits']+1;
						$ir_kods = 1;
					}
				}
				if ($ir_kods == 0)
				{
					$pa_sugam_kopa_t0 = $pa_sugam_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
					$pa_sugam[10]['tilpums']=$pa_sugam[10]['tilpums']+tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
					$pa_sugamm[10]['skaits']=$pa_sugam[10]['skaits']+1;	
				}
			}
		}

		//neto tilpuma sadalījums pa šķirām
		//echo $sx;

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
					if ((tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025)) < 0)
					{echo "KLUDA";}
					$pa_skiram_kopa_t0 = $pa_skiram_kopa_t0 + tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
					$pa_skiram[$i]['tilpums']=$pa_skiram[$i]['tilpums']+tilpums($metode,$d1,$d2,$lx) - (tilpums($metode,$d1,$d2,$lx) * $re * 0.025);
					$pa_skiram[$i]['skaits']=$pa_skiram[$i]['skaits']+1;
					$ir_kods = 1;
				}
			}
		} */

		$skaits_kopa++;
	}

	$vid_diam = $diam_summa / ($skaits_kopa * 2);
	$vid_gar = $gar_summa / $skaits_kopa;

	$liel_b_kods = 0;
	$liel_b_tilpums = 0;
	for ($i = 1; $i<10; $i++)
	{
		if ($pa_b_kodiem[$i]['tilpums'] > $liel_b_tilpums)
		{
			$liel_b_tilpums = $pa_b_kodiem[$i]['tilpums'];
			$liel_b_kods = $i;
		}
	}

	// **************************** apreķini end ***************************
?>

 <tr height=17 style='height:12.75pt'>
  <td height=17 align=right style='height:12.75pt'><?=$mpapirmalka['nr']?></td>
  <td align=right x:num><!--19--></td>
  <td><!--07--></td>
  <td><!--05--></td>
  <td></td>
  <td><!--Klaipēda--></td>
  <td><!--Lietuva--></td>
  <td><!--Baltfor--></td>
  <td><!--Ekomedie<span style='display:none'>na UAB</span>--></td>
  <td align=right x:num><?=$mpapirmalka['me']?></td>
  <td align=right x:num><?=$mpapirmalka['so']?></td>
  <td align=right x:num><?=$mpapirmalka['pl']?></td>
  <td align=right x:num><?=$mpapirmalka['ag']?></td>
  <td align=right x:num><?=$mpapirmalka['gr']?></td>
  <td align=right x:num><?=$mpapirmalka['ti']?></td>
  <td align=right x:num x:fmla="=ROUND(L3:L3000*M3:M3000*N3:N3000*O3:O3000%%%%,3)"><!--3.3327--></td>
  <td align=right x:num><?=$mpapirmalka['bk']?></td>
  <td align=right x:num><?=$mpapirmalka['bp']?></td>
  <td align=right x:num x:fmla="=ROUND(P3:P3000-(P3:P3000*R3:R3000%),3)"><!--3.3327--></td>
  <td><?=$mpapirmalka['te']?></td><!-- uzmerisanas datums -->
  <td align=right x:num x:fmla="=ROUND(V3:V3000/(L3:L3000*M3:M3000*N3:N3000%%%%),0)"><!--0.53--></td><!-- k% -->
  <td align=right x:num><?=number_format($test,3,'.','')?></td><!-- bruto m3 -->
  <td align=right x:num><?=$liel_b_kods?></td><!-- braka kods -->
  <td align=right x:num><?=number_format(($pa_b_kodiem_kopa_t0/$test)*100,1,'.','')?></td><!-- brakis % -->
  <td align=right x:num><?=number_format($test-$pa_b_kodiem_kopa_t0,3,'.','')?></td><!-- neto m3 -->
  <td align=right x:num x:fmla="=ROUND(IF(O3:O3000&gt;U3:U3000,(O3:O3000-U3:U3000)/O3:O3000*100,((U3:U3000-O3:O3000)/U3:U3000*100)*(-1)),3)"><!---13.2109--></td>
  <td align=right x:num x:fmla="=ROUND(P3:P3000/V3:V3000*100-100,3)"><!---13.2109--></td>
  <td align=right x:num  x:fmla="=ROUND(IF(S3:S3000&gt;Y3:Y3000,(S3:S3000-Y3:Y3000)/S3:S3000*100,((Y3:Y3000-S3:S3000)/Y3:Y3000*100)*(-1)),3)"><!---11.3172--></td>
  <td colspan=4 style='mso-ignore:colspan'></td>
  <td align=right x:num><?=$mpapirmalka['me']?></td><!-- kontrolmernieks -->
  <td align=right x:num><!--842--></td>
  <td></td>
  <td align=right x:num x:fmla="=ROUND(V3:V3000/P3:P3000,2)"><!--1.152219--></td>
  <td align=right x:num x:fmla="=ROUND(Y3:Y3000/S3:S3000,2)"><!--1.127614--></td>
  <td><?=number_format($vid_diam,3,'.','')?></td>
 </tr>

<? } ?>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</body>

</html>
