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
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
               $post_query_count = "SELECT * FROM posts";
            } else {
               $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            $find_post_count = mysqli_query($connection, $post_query_count);
            $post_count = mysqli_num_rows($find_post_count);
            $page_count = ceil($post_count / $per_page);
            
            // Loop for showing all published posts:
            if($post_count >= 1) {   // Condition for not showing 'message' if there is at least 1 published post:
               // Hiding draft posts from subscribers but showing them to admins:
               if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                  $query = "SELECT * FROM posts LIMIT $page_start, $per_page";                                 // Added LIMIT for Paging system
               } else {
                  $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_start, $per_page"; // Added LIMIT for Paging system

               }
               $select_all_posts_query = mysqli_query($connection, $query);

               while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                  $post_id = $row["post_id"];
                  $post_title = $row["post_title"];
                  $post_author = $row["post_author"];
                  $post_date = $row["post_date"];
                  $post_image = $row["post_image"];
                  $post_content = substr($row["post_content"], 0, 200);
                  $post_status = $row["post_status"];
               ?>
                  <!-- First Blog Post -->

                  <h1 class="page-header">
                     Page Heading
                     <small>Secondary Text</small>
                  </h1>

                  <!-- <h1><?php echo "Page " . "$page_count"; ?></h1> -->

                  <h2>
                     <a href="post.php?p_id=<?php echo "$post_id"; ?>"><?php echo "$post_title"; ?></a>
                  </h2>
                  <p class="lead">
                     by <a href="author_post.php?author=<?php echo "$post_author"; ?>&p_id=<?php echo "$post_id"; ?>"><?php echo "$post_author"; ?></a>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span><?php echo "$post_date"; ?></p>
                  <hr>
                  <a href="post.php?p_id=<?php echo "$post_id"; ?>">
                     <img class="img-responsive" src="images/<?php echo "$post_image"; ?>"alt="">
                  </a>
                  <hr>
                  <p><?php echo "$post_content"; ?></p>
                  <a class="btn btn-primary" href="post.php?p_id=<?php echo "$post_id"; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                  <hr>
               <?php
               }
            } else {
               echo "<h1 class='text-center'>Not posts available</h1>";
            }
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