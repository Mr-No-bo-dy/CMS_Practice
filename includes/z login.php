<?php session_start(); ?>
<?php include ("db.php"); ?>
<?php include ("../admin/functions.php"); ?>

<?php
   if(isset($_POST['login'])) {
      $user_name = escape($_POST['user_name']);
      $user_password = escape($_POST['user_password']);
      loginUser($user_name, $user_password);
   }
?>