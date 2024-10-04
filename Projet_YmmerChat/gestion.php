<?php
// Toujours inclure cela au début de la page protégée
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
