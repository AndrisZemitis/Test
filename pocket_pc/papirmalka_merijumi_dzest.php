<?
include '../connect.php';
include '../check_login.php';
include '../funkcijas.php';
include 'menu.php';

if ($_GET['darba_id'] and $_GET['merijuma_id'])
{
		$darba_id = $_GET['darba_id'];
		$merijuma_id = $_GET['merijuma_id'];
		mysql_query("delete from papirmalka_merijumi where papirmalka_id = ".$darba_id." and id = ".$merijuma_id);
		//echo " update papirmalka_merijumi set sx = '".$sx."', kx = '".$kx."', bx = '".$bx."', dl = '".$d1."', lx = '".$lx."', d2 = '".$d2."', rx = '".$rx."', re = '".$re."', kb = '".$kb."' where papirmalka_id = ".$darba_id." and id = ".$merijuma_id;
		//return;
		?>
		<script language="javascript">
			window.location='papirmalka_merijumi.php?darba_id=<?=$darba_id?>';
		</script>
		<?
}
?>