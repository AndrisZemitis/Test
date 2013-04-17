<?

function menu($h,$valoda)
{ 
	global $lietotajs_id;
	$t = array();
	if ($valoda != 'en')
	{
		$t['papirmalka']="Papīrmalka";
		$t['papirmalka_arhivs']="Papīrmalka(Arhīvs)";
		$t['papirmalkas_merijumi']="Papīrmalkas mērījumi";
		$t['zagbalki']="Zāģbaļķi";
		$t['zagbalku_merijumi']="Zāģbaļķu mērījumi";
		$t['zbm']="Uzmērītie zāģbaļķi";
		$t['zbm_arhivs']="Uzmērītie zāģbaļķi(Arhīvs)";
		$t['zbm_iu']="Jauna sadaļa mērījumi";
		$t['clsKraujmers']="Kraujmērs";
		$t['clsKraujmersKoef']="Kraujmēra koef.";
		$t['faila_ielasisana']="Faila ielasīšana";
	}
	else
	{
		$t['papirmalka']="Pulpwood"; 
		$t['papirmalkas_merijumi']="Pulpwood measurements";
		$t['zagbalki']="Saw timber";
		$t['zagbalku_merijumi']="Saw timber measurements";
		$t['zbm']="Measured saw timber";
		$t['zbm_iu']="Measured saw timber";
		$t['faila_ielasisana']="File upload";
	}

	?>

	<body>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>VMF darbi</title>
	</head>
	<style>
		a {color: #016734; text-decoration:none}
		.head {color:white; font-weight:bold;};
	</style>

	<center>
	<TABLE width="100%" border=0 background='head_bg.gif'>
	
	  <TR>
	    <TD align=left valign=middle>
	
	      <table width=100%>
			<tr>
			  <td width=0><a href='http://www.vmf.lv/main_menu.php'><img src=logo.gif border=0></a></td>
			  <td width=100% align=center><font color=white size=3>

	<? if ($h=='papirmalka' || $h=='papirmalkas_merijumi') { ?>
		<nobr> <a href=papirmalka.php?h=papirmalka class='head'><font color=yellow><?=$t['papirmalka']?> </font></a> 
	<? } else { ?>
		<nobr> <a href=papirmalka.php?h=papirmalka class='head'><?=$t['papirmalka']?></a> 
	<? }?>

	<? if ($h=='papirmalka_arhivs') { ?>
		&nbsp;|&nbsp;<nobr> <a href=papirmalka_arhivs.php?h=papirmalka_arhivs class='head'><font color=yellow><?=$t['papirmalka_arhivs']?> </font></a> 
	<? } else { ?>
		&nbsp;|&nbsp;<nobr> <a href=papirmalka_arhivs.php?h=papirmalka_arhivs class='head'><?=$t['papirmalka_arhivs']?></a> 
	<? }?>

	<? if ($h=='zagbalki' || $h=='zagbalku_merijumi') { ?>
			&nbsp;|&nbsp;<nobr> <a href=zagbalki.php?h=zagbalki class='head'><font color=yellow><?=$t['zagbalki']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=zagbalki.php?h=zagbalki class='head'><?=$t['zagbalki']?></a></nobr>
	<? }?>

	<? if ($h=='zbm' || $h=='zbm_iu') { ?>
			&nbsp;|&nbsp;<nobr> <a href=zbm.php?h=zbm class='head'><font color=yellow><?=$t['zbm']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=zbm.php?h=zbm class='head'><?=$t['zbm']?></a></nobr>
	<? }?>
	
	<? if ($h=='zbm_arhivs') { ?>
			&nbsp;|&nbsp;<nobr> <a href=zbm_arhivs.php?h=zbm_arhivs class='head'><font color=yellow><?=$t['zbm_arhivs']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=zbm_arhivs.php?h=zbm_arhivs class='head'><?=$t['zbm_arhivs']?></a></nobr>
	<? }?>

	<? if ($h=='clsKraujmers') { ?>
			&nbsp;|&nbsp;<nobr> <a href=clsKraujmers.php?h=clsKraujmers class='head'><font color=yellow><?=$t['clsKraujmers']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=clsKraujmers.php?h=clsKraujmers class='head'><?=$t['clsKraujmers']?></a></nobr>
	<? }?>

	<? if ($h=='clsKraujmersKoef') { ?>
			&nbsp;|&nbsp;<nobr> <a href=clsKraujmersKoef.php?h=clsKraujmersKoef class='head'><font color=yellow><?=$t['clsKraujmersKoef']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=clsKraujmersKoef.php?h=clsKraujmersKoef class='head'><?=$t['clsKraujmersKoef']?></a></nobr>
	<? }?>

	<? if ($h=='faila_ielasisana') { ?>
			&nbsp;|&nbsp;<nobr> <a href=transf_upload.php?h=zbm class='head'><font color=yellow><?=$t['faila_ielasisana']?></font></a></nobr>
	<? } else { ?>
			&nbsp;|&nbsp;<nobr> <a href=transf_upload.php?h=zbm class='head'><?=$t['faila_ielasisana']?></a></nobr>
	<? }?>

	</font></td>
	</tr>
	</table>

	</TD>
	</TR>
	</TABLE>
	<h2>
	<?=$t[$h]?>
	</h2></center>
	<br>
<?	

	}
?>