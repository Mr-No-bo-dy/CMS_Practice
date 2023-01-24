<?php  include ("includes/db.php"); ?>
<?php  include ("includes/head.php"); ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php
   // Setting Language variables:
   if (isset($_GET['lang']) && !empty($_GET['lang'])) {
      $_SESSION['lang'] = escape($_GET['lang']);

      // Refresh the page only if language is changed to another:
      if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
         echo "<script type='text/javascript'> location.reload(); </script>";
      }
   }

   // Setting Language itself:
   if (isset($_SESSION['lang'])) {
      include ("includes/languages/" . $_SESSION['lang'] . ".php");
   } else {
      include ("includes/languages/en.php");
   }
?>
    
<?php
   // if (isset($_POST['register'])) {
   // if ($_SERVER['REQUEST_METHOD'] == "POST") {
   if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] == "POST") {
      $user_name = escape($_POST['user_name']);
      $user_email = escape($_POST['user_email']);
      $user_password = escape($_POST['user_password']);

      // Errors Array:
      $error = [
         'name' => '',
         'email' => '',
         'password' => '',
      ];
      if (strlen($user_name) < 4) {
         $error['name'] = 'Username needs to be longer.';
      }
      if ($user_name == '') {
         $error['name'] = 'Username cannot be empty.';
      }
      if (user_name_Exist($user_name)) {
         $error['name'] = "$user_name is already exists, pick another one.";
      }
      if ($user_email == '') {
         $error['email'] = 'Email cannot be empty.';
      }
      if (user_email_Exist($user_email)) {
         $error['email'] = "$user_email is already registered.";
      }
      if (strlen($user_password) < 4) {
         $error['password'] = 'Password needs to be longer.';
      }
      if ($user_password == '') {
         $error['password'] = 'Password cannot be empty.';
      }

      // UnSetting in error-array $key's $values if they are empty:
      foreach ($error as $key => $value) {
         if (empty($value)) {
            unset($error[$key]);
         }
      }

      // Errors verification, Executing Registration function & Login user:
      if (empty($error)) {
         registerUser($user_name, $user_email, $user_password);
         loginUser($user_name, $user_password);
      }
      // echo "<script>alert('Your Registration has been submitted.')</script>"; // Massaging about Registration

   } else if (isset($_POST['cancel'])) {
      header("Location: index.php");
   }
?>

   <!-- Page Content -->
   <div class="container">

   <!-- Select Language form -->
   <form id="language_form" class="navbar-form navbar-right" action="" method="get">
      <div class="form-group">
         <select name="lang" class="form-control" onchange="changeLanguage()">
            <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == "en") { echo "selected"; } ?>>English</option>
            <option value="uk" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == "uk") { echo "selected"; } ?>>Українська</option>
         </select>
      </div>
   </form>
    
<section id="login">
   <div class="container">
      <div class="row">
         <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
            <h1><?php echo _REGISTRATION; ?></h1>
               <!-- Registration form -->
               <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                  <div class="form-group">
                     <label for="username" class="sr-only">Username</label>
                     <input id="username" class="form-control" type="text" name="user_name" placeholder="<?php echo _USER_NAME; ?>" autocomplete="on" 
                     value="<?php echo isset($user_name) ? $user_name : '' ?>">
                     <p class="bg-warning"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>    <!-- Displaying 'name'-Errors in form during Registration -->
                  </div>
                  <div class="form-group">
                     <label for="email" class="sr-only">Email</label>
                     <input id="email" class="form-control" type="email" name="user_email" placeholder="<?php echo _USER_EMAIL; ?>" autocomplete="on" 
                     value="<?php echo isset($user_email) ? $user_email : '' ?>">
                     <p class="bg-warning"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>     <!-- Displaying 'email'-Errors in form during Registration -->
                  </div>
                  <div class="form-group">
                     <label for="password" class="sr-only">Password</label>
                     <input id="key" class="form-control" type="password" name="user_password" placeholder="<?php echo _USER_PASSWORD; ?>">
                     <p class="bg-warning"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>     <!-- Displaying 'password'-Errors in form during Registration -->
                  </div>
                  <input type="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" name="register" value="<?php echo _REGISTER; ?>">
                  <input type="submit" class="btn btn-custom btn-lg btn-block" name="cancel" value="<?php echo _CANCEL; ?>">
               </form>
            </div>
         </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
   </div> <!-- /.container -->
</section>

      <hr>

<script>
   function changeLanguage() {
      document.getElementById('language_form').submit();
   }
</script>

<?php include "includes/footer.php";?>
