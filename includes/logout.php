<?php ob_start (); ?>   <!-- Turn on output buffering: Need when Redirecting piece of code later on -->
<?php session_start(); ?>

<?php
   $_SESSION['user_name'] = null;
   $_SESSION['user_firstname'] = null;
   $_SESSION['user_lastname'] = null;
   $_SESSION['user_role'] = null;
   header("Location: ../index.php");
?>