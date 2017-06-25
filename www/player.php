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

<?php include 'header.php'; ?>
<?php echo '<center><img src = "paperdoll.php?id='.$id.'" style = "float: left; margin: 0 0 10px 10px;" /></center>'; ?>
<?php include 'footer.php'; ?>