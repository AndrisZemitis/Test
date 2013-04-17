<?php

	include '../connect.php';
	include '../check_login.php';
	include '../funkcijas.php';
	
    $export_file = "datu_registrs.xls";
    ob_end_clean();
    ini_set('zlib.output_compression','Off');
    
    header('Pragma: public');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                  // Date in the past    
    header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1 
    header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
    header ("Pragma: no-cache");
    header("Expires: 0");
    header('Content-Transfer-Encoding: none');
    header('Content-Type: application/vnd.ms-excel; charset=utf-8' );                 // This should work for IE & Opera
    //header("Content-Type: application/vnd.ms-excel.sheet.macroEnabled.12");    
    header("Content-type: application/x-msexcel; charset=utf-8");                    // This should work for the rest
    header('Content-Disposition: attachment; filename="'.basename($export_file).'"');

  $query = $_POST['query'];
  
  $res = mysql_query($query);  
  $rows = array();
  while( $row = mysql_fetch_assoc($res) ) 
  { $rows []= $row; }

  print "<?xml version=\"1.0\"?>\n";
  print "<?mso-application progid=\"Excel.Sheet\"?>\n";
  ?>
  <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:html="http://www.w3.org/TR/REC-html40">
  <DocumentProperties 
     xmlns="urn:schemas-microsoft-com:office:office">
 <Author>SIA VMF LATVIA</Author>
  <LastAuthor>SIA VMF LATVIA</LastAuthor>
  <Company>SIA VMF LATVIA</Company>
  <Version>2</Version>
  </DocumentProperties>
  <ExcelWorkbook 
     xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>8535</WindowHeight>
  <WindowWidth>12345</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>90</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
  </ExcelWorkbook>
  <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
  <Alignment ss:Vertical="Bottom"/>
  <Borders/>
  <Font />
  <Interior/>
  <NumberFormat/>
  <Protection/>
  </Style>
  <Style ss:ID="s21">
   <Font x:Family="Swiss" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s27">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s28">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s29">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s30">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s31">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders/>
  </Style>
  <Style ss:ID="s32">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s33">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s34">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s35">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s39">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font x:Family="Swiss" ss:Bold="1"/>
   <Interior ss:Color="#CCFFCC" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s40">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font x:Family="Swiss" ss:Bold="1"/>
   <Interior ss:Color="#CCFFCC" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s41">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font x:Family="Swiss" ss:Bold="1"/>
   <Interior ss:Color="#CCFFCC" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s54">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Interior ss:Color="#FFCC00" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s55">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders/>
   <Interior ss:Color="#FFCC00" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s56">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Interior ss:Color="#FFCC00" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s57">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders/>
   <NumberFormat ss:Format="yyyy/mm/dd/;@"/>
  </Style>
  <Style ss:ID="s58">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders/>
   <Interior ss:Color="#FFCC00" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="yyyy/mm/dd/;@"/>
  </Style>  
 </Styles>
  <Worksheet ss:Name="Names">
  <Table ss:ExpandedColumnCount="21"
  ss:ExpandedRowCount="<?php echo( count( $rows ) + 1 ); ?>"
  x:FullColumns="1" x:FullRows="1">
  <Column ss:Index="1" ss:AutoFitWidth="1" ss:Width="35"/>
  <Column ss:Index="2" ss:AutoFitWidth="0" ss:Width="75"/>
  <Column ss:Index="3" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="4" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="5" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="6" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="7" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="8" ss:AutoFitWidth="0" ss:Width="100"/>
  <Column ss:Index="9" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="10" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="11" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="12" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="13" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="14" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="15" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="16" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="17" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="18" ss:AutoFitWidth="0" ss:Width="70"/>
  <Column ss:Index="19" ss:AutoFitWidth="0" ss:Width="70"/>
  <Row ss:StyleID="s21">
  <Cell ss:StyleID="s39"><Data ss:Type="String">ID</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Atskaites veids</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Akta nr.</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Pavadzime</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Sortiments</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Šoferis</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Auto</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Vieta</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Datums</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Skaits kopā</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Bruto m3</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Neto m3</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Virsmērs m3</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Redukcija</Data></Cell>
  <Cell ss:StyleID="s40"><Data ss:Type="String">Brāķis m3</Data></Cell>
  <Cell ss:StyleID="s41"><Data ss:Type="String">Brāķa %</Data></Cell>
  </Row>

  <?php foreach( $rows as $row ) { 
     $br_proc = braka_procents($row['brakis'],$row['bruto']);
          $style_type[0] = 's30';
          $style_type[1] = 's31';
          $style_type[2] = 's32';
          $style_type[3] = 's57';
     
     if ($br_proc >= 4){
          $style_type[0] = 's54';
          $style_type[1] = 's55';
          $style_type[2] = 's56';
          $style_type[3] = 's58';
     }
  ?>
  <Row>
  <Cell ss:StyleID="<?=$style_type[0]?>"><Data ss:Type="Number"><?=$row['id']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['atskaites_veids']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['akta_nr']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['pavadzime']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['sortiments']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['soferis']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['auto_nr']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="String"><?=$row['vieta']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[3]?>"><Data ss:Type="String"><?=str_replace('-','.',$row['datums_uzmer'])?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['skaits_kopa']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['bruto']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['neto']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['virsmers']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['redukcija']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[1]?>"><Data ss:Type="Number"><?=$row['brakis']?></Data></Cell>
  <Cell ss:StyleID="<?=$style_type[2]?>"><Data ss:Type="Number"><?=braka_procents($row['brakis'],$row['bruto'])?></Data></Cell>
  </Row>
  <?php } ?>
  </Table>
  <WorksheetOptions 
     xmlns="urn:schemas-microsoft-com:office:excel">
  <Print>
  <ValidPrinterInfo/>
  <HorizontalResolution>300</HorizontalResolution>
  <VerticalResolution>300</VerticalResolution>
  </Print>
  <Selected/>
  <Panes>
  <Pane>
  <Number>3</Number>
  <ActiveRow>1</ActiveRow>
  </Pane>
  </Panes>
  <ProtectObjects>False</ProtectObjects>
  <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  </Worksheet>
  </Workbook>

<?
/*
$agreement = array();
function agreement($id, $w_id)
{
	global $agreements;
	if ($agreements[$id])
		return $agreements[$id];
	$rc = mysql_query("select * from e_agreement where id = ".$id." AND workstation_id = " . $w_id);
	$mc = mysql_fetch_array($rc);
	$companies[$id]=$mc['num'];
	return $mc['num'];
}

$companies = array();
function company($id, $w_id)
{
	global $companies;
	if ($companies[$id])
		return $companies[$id];
	$rc = mysql_query("select * from e_company where id = ".$id." AND workstation_id = " . $w_id);
	$mc = mysql_fetch_array($rc);
	$companies[$id]=$mc['title'];
	return $mc['title'];
}
*/
function braka_procents($brakis, $bruto){
     $braka_procents = ROUND(($brakis / $bruto) * 100,2);
     return $braka_procents;
}

?>