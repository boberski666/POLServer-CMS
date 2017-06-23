<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET["mode"])) {
	if (file_exists("utils/". $_GET["mode"] . ".php"))
		include("utils/". $_GET["mode"] . ".php");
}