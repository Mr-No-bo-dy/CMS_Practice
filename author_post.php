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
            if(isset($_GET['p_id'])) {
               $the_post_author = escape($_GET['author']);

               // Hiding draft posts from subscribers but showing them to admins:

                  // Preparing statements:
               if(isset($_SESSION['user_name']) && isAdmin($_SESSION['user_name'])) {
                  $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_author = ?");
               } else {
                  $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_author = ? AND post_status = ?");
                  $published = 'published';
               }

                  // Creating & Executing statements:
               if(isset($stmt1)) {
                  mysqli_stmt_bind_param($stmt1, "s", $the_post_author);     // Creating statement1
                  mysqli_stmt_execute($stmt1);                               // Execution of statement1
                  mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt1;
               } else {
                  mysqli_stmt_bind_param($stmt2, "ss", $the_post_author, $published);     // Creating statement2
                  mysqli_stmt_execute($stmt2);                                            // Execution of statement2
                  mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt2;
               }

                  // Showing chosen Author's posts:
               while(mysqli_stmt_fetch($stmt)) {
                  $post_content = substr($post_content, 0, 200);
               ?>
                  <h1 class="page-header">
                     Page Heading
                     <small>Secondary Text</small>
                  </h1>
                  <!-- First Blog Post -->
                  <h2>
                     <a href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>"><?php echo "$post_title"; ?></a>
                  </h2>
                  <p class="lead">
                     Post by <?php echo "$post_author"; ?>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span><?php echo "$post_date"; ?></p>
                  <hr>
                  <a href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>">
                     <img class="img-responsive" src="/!php/_cms_practice/images/<?php echo imagePlaceholder($post_image); ?>"alt="">
                  </a>
                  <hr>
                  <p><?php echo "$post_content"; ?></p>
                  <a class="btn btn-primary" href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                  <hr>
               <?php 
               }

               if(mysqli_stmt_num_rows($stmt) === 0) {       // Condition for not showing 'message' if there is at least 1 post to show:
                  // if(mysqli_stmt_num_rows($stmt) == 0) {       // Condition for not showing 'message' if there is at least 1 post to show:
                  echo "<h1 class='text-center'>No posts made by this author available</h1>";
               }
               mysqli_stmt_close($stmt);

            } else {
               header("Location: index.php");
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