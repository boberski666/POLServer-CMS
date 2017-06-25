<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include_once('include/mysql.php');

$mysql = new MySQL();
$result = null;

try{
	$result = $mysql->get(TBL_CHARS_ONLINE);
}catch(Exception $e){
	die('Caught exception: '. $e->getMessage());
}
?>

<?php include 'header.php'; ?>
<?php
	foreach ($result as $row) {
		echo '<a href = "player.php?id='.$row['char_id'].'">'.$row['char_name'].'</a>&ensp;';
	}
?>
<?php include 'footer.php'; ?>