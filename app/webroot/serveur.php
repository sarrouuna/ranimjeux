<?php 
define("HOST", "localhost");
define("USER", "root");
define("PASS", "");//34ta92ak
define("DB", "kinda");
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
$sql = 'select * from clients';
$tables = mysql_query($sql) or die(mysql_error());
$table=  mysql_fetch_array($tables);
echo json_encode($tables);
?>