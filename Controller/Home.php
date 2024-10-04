 <?php
 session_start();
 if (isset($_SESSION['success_message'])) {
     echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
     unset($_SESSION['success_message']); // Pour ne pas afficher le message à nouveau
 }
 ?>
 