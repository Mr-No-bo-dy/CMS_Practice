<!-- to Execute Login here: -->
<?php
   if(ifItIsMethod('post')){
      if (isset($_POST['login'])) {
         if (isset($_POST['user_name']) && isset($_POST['user_password'])) {
            loginUser(escape($_POST['user_name']), escape($_POST['user_password']));
         } else {
            redirect('/!php/_cms_practice/index');
         }
      }
   }
?>

<div class="col-md-4">

   <!-- Login -->
   <div class="well">      
      <?php if(isset($_SESSION['user_role'])): ?>
         <h4>Logged in as <b><?php echo $_SESSION['user_name']; ?></b></h4>
         <a href="/!php/_cms_practice/includes/logout.php" class="btn btn-primary">Logout</a>
      <?php else: ?>
         <h4>Login</h4>
         <!-- <form action="/!php/_cms_practice/login" method="post" autocomplete="off"> -->  <!-- to Execute Login in Login.php -->
         <form method="post" autocomplete="off">    <!-- to Execute Login here -->
            <div class="form-group">
               <input name="user_name" type="text" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
               <input name="user_password" type="password" class="form-control" placeholder="Enter Password">
            <span class="input-group-btn">
               <button class="btn btn-primary" type="submit" name="login">Submit</button>
            </span>
            </div>
            <div class="form-group">
               <a href="forgot_pass.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
            </div>
         </form> <!--login form-->
         <!-- /.input-group -->
      <?php endif; ?>
   </div>

   <!-- Blog Search Well -->
   <div class="well">
      <h4>Blog Search</h4>
      <form action="search.php" method="post">
         <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
               <button name="submit" class="btn btn-default" type="submit">
                  <span class="glyphicon glyphicon-search"></span>
               </button>
            </span>
         </div>
      </form> <!--search form-->
      <!-- /.input-group -->
   </div>

   <!-- Blog Categories Well -->
   <div class="well">

      <?php
         $query = "SELECT * FROM categories";
         // $query = "SELECT * FROM categories LIMIT 4";
         $select_categories_sidebar = mysqli_query($connection, $query);
      ?>
      <h4>Blog Categories</h4>
      <div class="row">
         <div class="col-lg-12">
            <ul class="list-unstyled">
               <?php
                  while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                     $cat_id = $row["cat_id"];
                     $cat_title = $row["cat_title"];
                     echo "<li><a href='/!php/_cms_practice/category/$cat_id'>{$cat_title}</a></li>";
                  }
               ?>
            </ul>
         </div>

         <!-- /.col-lg-6 -->
      </div>
      <!-- /.row -->
   </div>


   <!-- Side Widget Well -->
   <?php
      include ("widget.php");
   ?>

</div>