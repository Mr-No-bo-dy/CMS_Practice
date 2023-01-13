<?php include ("includes/db.php"); ?>
<?php include ("includes/head.php"); ?>

<!-- Navigation -->
<?php include ("includes/navigation.php"); ?>

<?php
   // Not allowing anyone to get to this page:
   if (!isset($_GET['email']) && !isset($_GET['token'])) {
      redirect('index');
   }

   // Checking with DB to get user_name, user_email & token for this specific user:
   if ($stmt = mysqli_prepare($connection, "SELECT user_name, user_email, token FROM users WHERE token = ?")) {
      $escapedToken = escape($_GET['token']);
      mysqli_stmt_bind_param($stmt, "s", $escapedToken);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $user_name, $user_email, $token);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);

   //    if ($_GET['token'] !== $token || $_GET['email'] !== $email) {
   //        redirect('index');
   //    }

      if (isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
         if ($_POST['newPassword'] === $_POST['confirmPassword']) {
            $newPassword = $_POST['newPassword'];
            $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT, array('cost' => 12));

            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '{$hashed_password}' WHERE user_email = ?")) {
               $escapedEmail = escape($_GET['email']);
               mysqli_stmt_bind_param($stmt, "s", $escapedEmail);
               mysqli_stmt_execute($stmt);

               if (mysqli_stmt_affected_rows($stmt) >= 1) {    // If smth was changed then we redirect user into Login page
                  redirect('/!php/_cms_practice/login');
               }

               mysqli_stmt_close($stmt);
            }
         } else {
            echo "Passwords does NOT match!";
         }
      }
   }
?>

<div class="container">

   <div class="container">
      <div class="row">
         <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="text-center">

                     <h3><i class="fa fa-lock fa-4x"></i></h3>
                     <h2 class="text-center">Reset Password</h2>
                     <p>You can reset your password here.</p>
                     <div class="panel-body">

                        <form id="register-form" class="form" method="post" role="form" autocomplete="off">

                           <div class="form-group">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                 <input id="password" class="form-control" type="password" name="newPassword" placeholder="Enter new password">
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                 <input id="confirmPassword" class="form-control" type="password" name="confirmPassword" placeholder="Confirm password">
                              </div>
                           </div>

                           <div class="form-group">
                              <input class="btn btn-lg btn-primary btn-block" type="submit" name="resetPassword" value="Reset Password">
                           </div>

                           <input id="token" class="hide" type="hidden" name="token" value="">
                        </form>

                     </div><!-- Body-->

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <hr>

   <?php include ("includes/footer.php");?>

</div> <!-- /.container -->
