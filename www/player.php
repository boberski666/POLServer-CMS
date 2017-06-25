<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include_once('include/mysql.php');
if (!isset($_GET['id'])) {
    echo "ID not set!";
    die();
}
$id = $_GET['id'];

unset($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="page-wrap">
		<?php echo '<center><img src = "paperdoll.php?id='.$id.'" style = "float: left; margin: 0 0 10px 10px;" /></center>'; ?>
	</div>
</body>
</html>