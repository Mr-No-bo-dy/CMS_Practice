<?php
   include ("includes/db.php");
   include ("includes/head.php");
?>
   <!-- Navigation -->
<?php include ("includes/navigation.php"); ?>

   <!-- Page Content -->
<div class="container">

   <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

         <?php
            if (isset($_POST["submit"])) {
               $search = escape("%{$_POST["search"]}%");

               // Hiding draft posts from subscribers but showing them to admins:

                  // Preparing statements:
               if(isset($_SESSION['user_name']) && isAdmin($_SESSION['user_name'])) {
                  $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_tags LIKE ?");
               } else {
                  $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_tags LIKE ? AND post_status = ?");
                  $published = 'published';
               }
               
                  // Creating & Executing statements:
               if(isset($stmt1)) {
                  mysqli_stmt_bind_param($stmt1, "s", $search);     // Creating statement1
                  mysqli_stmt_execute($stmt1);                      // Execution of statement1
                  mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt1;
               } else {
                  mysqli_stmt_bind_param($stmt2, "ss", $search, $published);     // Creating statement2
                  mysqli_stmt_execute($stmt2);                                   // Execution of statement2
                  mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt2;
               }

                  // Showing Search'ed posts:
               mysqli_stmt_store_result($stmt);    // Needed for next mysqli_stmt_num_rows cos it doesn't save results in memory
               $count = mysqli_stmt_num_rows($stmt);
               if ($count > 0) {
                  while(mysqli_stmt_fetch($stmt)) {
                     $post_content = substr($post_content, 0, 200);
                  ?>   
                     <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                     </h1>   
                     <!-- First Blog Post -->
                     <h2>
                        <a href="#"><?php echo "$post_title"; ?></a>
                     </h2>
                     <p class="lead">
                        by <a href="author_post.php?author=<?php echo "$post_author"; ?>&p_id=<?php echo "$post_id"; ?>"><?php echo "$post_author"; ?></a>
                     </p>
                     <p><span class="glyphicon glyphicon-time"></span><?php echo "$post_date"; ?></p>
                     <hr>
                     <img class="img-responsive" src="images/<?php echo "$post_image"; ?>"alt="">
                     <hr>
                     <p><?php echo "$post_content"; ?></p>
                     <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                     <hr>   
                  <?php
                  }
               } else {
                  echo "<h3>No such posts</h3>";
               }
               mysqli_stmt_close($stmt);
            }
         ?>

      </div>

         <!-- Blog Sidebar Widgets Column -->
<?php include ("includes/sidebar.php"); ?>

      </div>
      <!-- /.row -->

      <hr>

      <!-- Footer -->
<?php include ("includes/footer.php"); ?>