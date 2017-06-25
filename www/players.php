<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include_once('include/mysql.php');

$mysql = new MySQL();
$result = null;

try{
	$result = $mysql->get(TBL_CHARS);
}catch(Exception $e){
	die('Caught exception: '. $e->getMessage());
}
	
foreach ($result as $row) {
	echo '<img src = "paperdoll.php?id='.$row['char_id'].'" style = "float: left; margin: 0 0 10px 10px;" />';
}