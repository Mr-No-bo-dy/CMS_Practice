<div class="col-md-4">

   <!-- Login -->
   <div class="well">      
      <?php if(isset($_SESSION['user_role'])): ?>
         <h4>Logged in as <b><?php echo $_SESSION['user_name']; ?></b></h4>
         <a href="includes/logout.php" class="btn btn-primary">Logout</a>
      <?php else: ?>
         <h4>Login</h4>
         <form action="includes/login.php" method="post">
            <div class="form-group">
               <input name="user_name" type="text" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
               <input name="user_password" type="password" class="form-control" placeholder="Enter Password">
            <span class="input-group-btn">
               <button class="btn btn-primary" type="submit" name="login">Submit</button>
            </span>
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
                     echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
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