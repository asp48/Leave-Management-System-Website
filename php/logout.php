<?php
session_start();
$_SESSION["Log"]='0';
header("location:modify.html");
session_destroy();
?>