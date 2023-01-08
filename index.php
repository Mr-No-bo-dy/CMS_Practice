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
            // Paging system
            $per_page = 5;    // Number of posts per page
            if(isset($_GET['page'])) {
               $page = escape($_GET['page']);
            } else {
               $page ="";     // For no_errors, if there was no GET-request for 'page'
            }
            if($page == "" || $page == 1) {
               $page_start = 0;
            } else {
               $page_start = ($page * $per_page) - $per_page;
            }

            // Hiding draft posts from subscribers but showing them to admins:
            
               // Preparing statements:
               if(isset($_SESSION['user_name']) && isAdmin($_SESSION['user_name'])) {
                  $stmt_count1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts");
               } else {
                  $stmt_count2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_status = ?");
                  $published = 'published';
               }
            
               // Creating & Executing statements:
            if(isset($stmt_count1)) {
               mysqli_stmt_execute($stmt_count1);                         // Execution of statement1
               mysqli_stmt_bind_result($stmt_count1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
               $stmt_count = $stmt_count1;
            } else {
               mysqli_stmt_bind_param($stmt_count2, "s", $published);     // Creating statement2
               mysqli_stmt_execute($stmt_count2);                         // Execution of statement2
               mysqli_stmt_bind_result($stmt_count2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
               $stmt_count = $stmt_count2;
            }
            
            mysqli_stmt_store_result($stmt_count);    // Needed for next mysqli_stmt_num_rows cos it doesn't save results in memory
            $post_count = mysqli_stmt_num_rows($stmt_count);
            $page_count = ceil($post_count / $per_page);
            confirmQuery($stmt_count);
            mysqli_stmt_close($stmt_count);
            
            // Loop for showing all published posts:
            if($post_count >= 1) {   // Condition for not showing 'message' if there is at least 1 published post:
               // Hiding draft posts from subscribers but showing them to admins:
               
                  // Preparing statements:
               if(isset($_SESSION['user_name']) && isAdmin($_SESSION['user_name'])) {
                  $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts LIMIT ?, ?");  // Added LIMIT for Paging system
               } else {
                  $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_status = ? LIMIT ?, ?"); // Added LIMIT for Paging system
                  $published = 'published';
               }
               
                  // Creating & Executing statements:
               if(isset($stmt1)) {
                  mysqli_stmt_bind_param($stmt1, "ii", $page_start, $per_page);     // Creating statement1
                  mysqli_stmt_execute($stmt1);                      // Execution of statement1
                  mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt1;
               } else {
                  mysqli_stmt_bind_param($stmt2, "sii", $published, $page_start, $per_page);     // Creating statement2
                  mysqli_stmt_execute($stmt2);                                   // Execution of statement2
                  mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  $stmt = $stmt2;
               }

                  // Showing published/all posts:
               while(mysqli_stmt_fetch($stmt)) {
                  $post_content = substr($post_content, 0, 200);
               ?>
                  <!-- First Blog Post -->

                  <h1 class="page-header">
                     Page Heading
                     <small>Secondary Text</small>
                  </h1>

                  <!-- <h1><?php echo "Page " . "$page_count"; ?></h1> -->

                  <h2>
                     <a href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>"><?php echo "$post_title"; ?></a>
                  </h2>
                  <p class="lead">
                     by <a href="author_post.php?author=<?php echo "$post_author"; ?>&p_id=<?php echo "$post_id"; ?>"><?php echo "$post_author"; ?></a>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span><?php echo "$post_date"; ?></p>
                  <hr>
                  <a href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>">
                     <img class="img-responsive" src="/!php/_cms_practice/images/<?php echo "$post_image"; ?>"alt="">
                  </a>
                  <hr>
                  <p><?php echo "$post_content"; ?></p>
                  <a class="btn btn-primary" href="/!php/_cms_practice/post/<?php echo "$post_id"; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                  <hr>
               <?php
               }

            } else {
               echo "<h1 class='text-center'>No posts available</h1>";
            }
            mysqli_stmt_close($stmt);
         ?>

      </div>

         <!-- Blog Sidebar Widgets Column -->
<?php include ("includes/sidebar.php"); ?>

   </div>
   <!-- /.row -->

   <hr>

   <ul class="pager">
      <?php
         for($i=1; $i<= $page_count; $i++) {
            if($i == $page) {
               echo "<li><a class='active_page' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
               echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
         }
      ?>
   </ul>

   <!-- Footer -->
<?php include ("includes/footer.php"); ?>