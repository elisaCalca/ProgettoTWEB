<?php
/* Chiudo la sessione e faccio redirect alla pagina di login*/
if (!isset($_SESSION)) { session_start(); }

session_unset();
session_destroy();
header("Location: ../index.php");
?>