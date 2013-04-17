<?

// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number
//$server = '195.13.211.202\SQLEXPRESS';

// Connect to MSSQL
//$link = mssql_connect($server, 'VMF', 't54ew#Q');

$cs = mssql_connect( '195.13.211.202', 'VMF', 't54ew#Q' ) or die ( 'Can not connect to server' );

 // select
mssql_select_db( '[Kubiks]', $cs ) or die ( 'Can not select database' );

 //query
 $sql = "SELECT * FROM dbo.WayBill WHERE uzmerisanas_datums > '2012-11-21 00:00:00'";
 $r = mssql_query( $sql, $cs ) or die ( 'Query Error' );

 // loop the result

 while ( $row = mssql_fetch_array ( $r ) ){
    echo 'test';
 }

?>