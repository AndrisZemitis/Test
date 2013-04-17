<?
include '../connect.php';
	$group_c = 5; //group count
?>

<form method=POST>
	<center>
	<table>
		<tr>
			<td>Pavadzīme</td>
			<td><input type=text name=pavaddok value="<?=$_POST['pavaddok']?>"></td>
		</tr>
				<? 
				for ($i=1;$i<=$group_c;$i++)
				{
					?><tr><td>Grupa <?=$i?></td>
					<td>
						<select name="group<?=$i?>">
							<option value="">-</option>
							<option <?if ($_POST['group'.$i]=='garums') echo " selected "?> value="garums">Garums</option>
							<option <?if ($_POST['group'.$i]=='diametrs') echo " selected "?> value="diametrs">Diametrs</option>
							<option <?if ($_POST['group'.$i]=='skira') echo " selected "?> value="skira">Šķira</option>
							<option <?if ($_POST['group'.$i]=='suga') echo " selected "?> value="suga">Suga</option>
						</select>
						<input type=text name=groupvalue<?=$i?> value="<?=$_POST['groupvalue'.$i]?>">
					</td></tr><?
				}
				?>
	</table>
	
	<input name=poga type=submit value="Aprēķināt">
</form>

<?

if ($_POST['poga'])
{
	$x = new C_GROUPING();
	echo $x->init();

	$groups_selected = 0;
	for ($i=1;$i<=$group_c;$i++)
	{
		if ($_POST['group'.$i]=='suga')
		{
			$x->add_level_values('Priede=4;Egle=5',';','=','sg','Suga');
			$groups_selected++;
		}
		if ($_POST['group'.$i]=='skira')
		{
			$x->add_level_values('0=0;1=1;2=2;3=3;4=4;5=5;6=6;7=7;8=8;9=9',';','=','sk','Šķira');
			$groups_selected++;
		}

		if ($_POST['group'.$i]=='diametrs')
		{
			$x->add_level_range($_POST['groupvalue'.$i],';','-','tc','Diametrs');
			$groups_selected++;
		}
		if ($_POST['group'.$i]=='garums')
		{
			$x->add_level_range($_POST['groupvalue'.$i],';','-','gr','Garums');
			$groups_selected++;
		}
	}
	
	if ($groups_selected==0)
	{
		echo "Nav izvēlēta neviena grupa";
		return;
	}

	$r = $x->get_result();

	// lauku selekts
	$select = "select * from fails_zbm inner join fails_zbm_ui on fails_zbm.id = fails_zbm_ui.fails_zbm_id ";
	
	// skaita selekts
	$select_count = "select count(*) as c from fails_zbm inner join fails_zbm_ui on fails_zbm.id = fails_zbm_ui.fails_zbm_id ";

	// nosacījumi
	$where = " where 1=1 ";
	if ($_POST['pavaddok'])
	{
		$where = $where . " and pavaddok = '".$_POST['pavaddok']."'";
	}

	//aprēķinam masīvu
	for ($i=0;$i<count($r);$i++)
	{
		if ($r[$i]['type']=='data')
		{
			$r[$i]['bruto'] = '0';
			$r[$i]['count'] = '0';
			$rs = mysql_query($select . " " . $where . " and " . $r[$i]['sql']);
			while ($m=mysql_fetch_array($rs))
			{
				$r[$i]['bruto'] = $r[$i]['bruto'] + f($m['tc']/1000,$m['gr']/100,1,1);
				$r[$i]['count'] = $r[$i]['count'] + 1;
			}
		}
		//$r[$i]['sql']."<BR>";
	}

	// aprēķinam summas
	for ($i=0;$i<count($r);$i++)
	{
		if ($r[$i]['type']=='sum')
		{
			$level = $r[$i]['level'];
			$j=$i-1;
			while ($j>=0 && $r[$j]['level']>$level)
			{
				if ($r[$j]['type']=='data')
				{
					$r[$i]['count']=$r[$i]['count']+$r[$j]['count'];
					$r[$i]['bruto']=$r[$i]['bruto']+$r[$j]['bruto'];
				}
				$j--;
			}
		}
	}


	//drukājam masīvu
	?><table><?
	for ($i=0;$i<count($r);$i++)
	{
		if ($r[$i]['count'])
		{
			?><tr><?
			?><td><?=$r[$i]['type']?></td><?
			?><td><?=$r[$i]['level']?></td><?
			?><td><?=$r[$i]['title']?></td><?
			?><td><?=$r[$i]['bruto']?></td><?
			?><td><?=$r[$i]['count']?></td><?
			?></tr><?
		}
	}
	?></table><?
}
//echo count($r);

class C_GROUPING
{
	var $arr;		// ienākošais masīvs kas apraksta līmeņus
	var $result;	// rezultāts - masīvs ar nosacījumu matricu
	var $lsk;		// grupēšanas līmeņu skaits

	function init()
	{
		$this->lsk = 0;
		$this->arr = array();
		$this->result = array();
	}

	function add_level_recordset($rs,$value_field,$title_field,$title)
	{
		// rs as recordset, $value_field as string, $title_field as string
		$this->arr[$this->lsk] = array();
		$this->arr[$this->lsk]['values'] = array();
		$this->arr[$this->lsk]['type'] = 'string';
		$this->arr[$this->lsk]['field'] = $value_field;
		$this->arr[$this->lsk]['title'] = $title;
		$ivalue = 0;
		while ($m=mysql_fetch_array($rs))
		{
			$this->arr[$this->lsk]['values'][$ivalue]=array();
			$this->arr[$this->lsk]['values'][$ivalue]['value']=$m[$value_field];
			$this->arr[$this->lsk]['values'][$ivalue]['title']=$m[$title_field];
			$ivalue++;
		}
		$this->lsk++;
	}

	function add_level_values($values,$separator1,$separator2,$field,$title)
	{
		// values as string, $separator1 as string, $separator2 as string
		// P=priede;E=egle
		$this->arr[$this->lsk] = array();
		$this->arr[$this->lsk]['values'] = array();
		$this->arr[$this->lsk]['type'] = 'string';
		$this->arr[$this->lsk]['field'] = $field;
		$this->arr[$this->lsk]['title'] = $title;
		$ivalue = 0;
		$varr = split($separator1,$values);
		foreach ($varr as $key=>$val)
		{
			$this->arr[$this->lsk]['values'][$ivalue]=array();
			$vrec = split($separator2,$val);
			$this->arr[$this->lsk]['values'][$ivalue]['title']=$vrec[0];
			$this->arr[$this->lsk]['values'][$ivalue]['value']=$vrec[1];
			$ivalue++;
		}
		$this->lsk++;
	}

	function add_level_range($values,$separator1,$separator2,$field,$title)
	{
		// values as string, $separator1 as string, $separator2 as string
		// 100-200;201-300
		$this->arr[$this->lsk] = array();
		$this->arr[$this->lsk]['values'] = array();
		$this->arr[$this->lsk]['type'] = 'range';
		$this->arr[$this->lsk]['separator'] = $separator1;
		$this->arr[$this->lsk]['field'] = $field;
		$this->arr[$this->lsk]['title'] = $title;
		$ivalue = 0;
		$varr = split($separator1,$values);
		foreach ($varr as $key=>$val)
		{
			$this->arr[$this->lsk]['values'][$ivalue]=array();
			$vrec = split($separator2,$val);
			$this->arr[$this->lsk]['values'][$ivalue]['value1']=$vrec[0];
			$this->arr[$this->lsk]['values'][$ivalue]['value2']=$vrec[1];
			$ivalue++;
		}
		$this->lsk++;
	}

	function recursive($level,$sql)
	{

		// ja šāda līmeņa nav tad izejam
		if ($this->lsk<=$level) 
			return 0;

		// ejam cauri visiem elementiem
		for ($i=0;$i<count($this->arr[$level]['values']);$i++)
		{
			$new_sql = $sql;
			if ($new_sql) $new_sql = $new_sql . ' and ';

			if ($this->arr[$level]['type']=='string')
			{
				$new_sql = $new_sql . $this->arr[$level]['field'] ."='".$this->arr[$level]['values'][$i]['value']."'";
			}

			if ($this->arr[$level]['type']=='range')
			{
				$new_sql = $new_sql . "(" . $this->arr[$level]['field'] .">=".$this->arr[$level]['values'][$i]['value1']." and ".$this->arr[$level]['field'] ."<=".$this->arr[$level]['values'][$i]['value2'].")";
			}

			// izsaucam nākamo līmeni
			if ($this->recursive($level+1,$new_sql))
			{
				// ja ir vēl līmeņi tad šis ir summas lauks
				$row = count($this->result);
				$this->result[$row]=array();
				$this->result[$row]['type']='sum';
			}
			else
			{
				// ja nav citu līmeņu tad tie ir dati
				$row = count($this->result);
				$this->result[$row]=array();
				$this->result[$row]['type']='data';
			}
			$this->result[$row]['sql']=$new_sql;
			$this->result[$row]['title']=$this->arr[$level]['title'];
			$this->result[$row]['level']=$level;
		}
		return 1;
	}

	function get_result()
	{
		$this->recursive(0,'');
		return $this->result;
	}

	function get_array()
	{
		return $this->arr;
	}
}


// funkcijas kas aprēķina tilpumu ja dots diametrs, garums, raukums, koeficients
function f($d,$l,$raukums,$koeficients)
{
	$pi = 3.1416;
	$d = $d + 0.005;
	if ((double)$raukums!=0)
	{
		$d = $d * 100;
		$r = ($pi * ( ($d*$d) + ($d+($raukums*$l))*($d+($raukums*$l)) ) * $l) / (8*10000);
		return round($r,3);
	}
	$r = $pi*$d*$d*$l/4;
	if ($koeficients!='')
		return round($r*$koeficients,3);

	return round($r,3);
}

?>