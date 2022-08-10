<?php
$usur_system = true;

include_once '../config.php';

session_destroy();
header("Location:index.php");
?>