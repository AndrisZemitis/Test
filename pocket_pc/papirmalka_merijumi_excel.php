<?
include '../connect.php';

$rinfo = mysql_query(" select * from papirmalka where id = ".$_GET['darba_id']." ");
if ($minfo = mysql_fetch_array($rinfo))
{
	$nr = $minfo['nr'];
}

header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=papirmalkas_merijumi.xls"); header("Content-transfer-encoding: binary");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
<link rel=File-List
href="./Estonian%20Cell%20sample%20bundless_files/filelist.xml">
<link rel=Edit-Time-Data
href="./Estonian%20Cell%20sample%20bundless_files/editdata.mso">
<link rel=OLE-Object-Data
href="./Estonian%20Cell%20sample%20bundless_files/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author> Aldis Ladusāns</o:Author>
  <o:LastAuthor>li</o:LastAuthor>
  <o:Created>2006-02-23T12:54:27Z</o:Created>
  <o:LastSaved>2006-03-03T12:00:51Z</o:LastSaved>
  <o:Version>9.3821</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:DownloadComponents/>
  <o:LocationOfComponents HRef="file:C:\Install\office\msowc.cab"/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:"\,";}
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
	text-align:center;
	background:white;
	mso-pattern:auto none;
	white-space:normal;}
.xl25
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#CCFFCC;
	mso-pattern:auto none;
	white-space:normal;}
.xl26
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#CCFFCC;
	mso-pattern:auto none;}
.xl27
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	background:#CCFFCC;
	mso-pattern:auto none;
	white-space:normal;}
.xl28
	{mso-style-parent:style0;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border:.5pt solid windowtext;
	background:#CCFFCC;
	mso-pattern:auto none;
	white-space:normal;}
.xl29
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	background:white;
	mso-pattern:auto none;
	white-space:normal;}
.xl30
	{mso-style-parent:style0;
	color:red;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	background:white;
	mso-pattern:auto none;
	white-space:normal;}
.xl31
	{mso-style-parent:style0;
	color:red;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Exsample</x:Name>
    <x:WorksheetOptions>
     <x:Selected/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>2</x:ActiveRow>
       <x:ActiveCol>9</x:ActiveCol>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>8835</x:WindowHeight>
  <x:WindowWidth>15180</x:WindowWidth>
  <x:WindowTopX>120</x:WindowTopX>
  <x:WindowTopY>120</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>

<table x:str border=0 cellpadding=0 cellspacing=0 width=640 style='border-collapse:
 collapse;table-layout:fixed;width:480pt'>
 <col width=64 span=11 style='width:48pt'>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl29 width=64 style='height:12.75pt;width:48pt' x:num><?=$nr?></td>
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

 <tr height=34 style='height:25.5pt'>
  <td height=34 class=xl27 width=64 style='height:25.5pt;width:48pt'>Sortiment</td>
  <td class=xl28 width=64 style='border-left:none;width:48pt'>Sort</td>
  <td class=xl27 width=64 style='border-left:none;width:48pt'>Reject code</td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>Diameter, cm</td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>Lenght, dm</td>
  <td class=xl25 width=64 style='border-left:none;width:48pt'>Diameter, cm</td>
  <td class=xl26 style='border-left:none'>Butt-end</td>
  <td class=xl28 width=64 style='border-left:none;width:48pt'>Reduction</td>
  <td class=xl28 width=64 style='border-left:none;width:48pt'>Anuled</td>
  <td colspan=2 style='mso-ignore:colspan'></td>
 </tr>

 <? 
 $cip = 3;
$r = mysql_query(" select * from papirmalka_merijumi where papirmalka_id = ".$_GET['darba_id']." order by id "); 
while ($m = mysql_fetch_array($r))
{ 
?>	
<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl30 width=64 style='height:12.75pt;width:48pt' x:num><?=$m['sx']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['kx']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['bx']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['dl']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['lx']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['d2']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['rx']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['re']?></td>
  <td class=xl30 width=64 style='width:48pt' x:num><?=$m['anuled']?></td>
  <td></td>
 </tr>
<?
$cip++;
}
?>

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
 </tr>
 <![endif]>
</table>

</body>

</html>
