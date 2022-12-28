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
               $the_post_id = escape($_GET['p_id']);

               // Incrementing post_views_count every time someone views post:
               $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$the_post_id}'";
               $post_views_count_query = mysqli_query($connection, $query);
               if(!$post_views_count_query) {
                   exit("QUERY FAILED ." . mysqli_error($connection));
               }

               // Hiding draft posts from subscribers but showing them to admins:
               if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                  $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
               } else {
                  $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
               }
               $select_all_posts_query = mysqli_query($connection, $query);

               if(mysqli_num_rows($select_all_posts_query) >= 1) {   // Condition for not showing 'message' if there is at least 1 published post:
                  while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                     $post_id = $row["post_id"];
                     $post_title = $row["post_title"];
                     $post_author = $row["post_author"];
                     $post_date = $row["post_date"];
                     $post_image = $row["post_image"];
                     $post_content = $row["post_content"];
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
                     <hr>

                  <?php
                  }
               ?>

               <!-- Blog Comments -->

                  <!-- Posted Comments -->
                  <?php
                     $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                     $query .= "AND comment_status = 'approved' ";
                     $query .= "ORDER BY comment_id DESC ";
                     $select_comment_query = mysqli_query($connection, $query);

                     if(!$select_comment_query) {
                        exit('Query Failed' . mysqli_error($connection));
                     }

                     while($row = mysqli_fetch_assoc($select_comment_query)) {
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];
                        $comment_edit_author = $row['comment_edit_author'];
                        $comment_editors_comment = $row['comment_editors_comment'];
                        $comment_edited_date = $row['comment_edited_date'];

                     ?>
                        <!-- Comment -->
                        <div class="media">
                           <a class="pull-left" href="#">
                              <img class="media-object" src="http://placehold.it/64x64" alt="">
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading"><?php echo $comment_author; ?>
                                 <small><?php echo $comment_date; ?></small>
                              </h4>
                              <p><?php echo $comment_content; ?></p>
                           </div>

                           <?php
                           if($comment_edit_author) {
                              echo "<div class='comment_edit'>";
                              echo "<h4 class='text-muted '><small>Edited by</small> $comment_edit_author ";
                              echo "<small>$comment_edited_date</small>";
                              echo "</h4>";
                              echo "<p class='text-muted'>$comment_editors_comment</p>";
                              echo "</div>";
                           }
                           ?>

                        </div>
                        <hr>

                     <?php
                     }

                     // Adding comments Functionality:
                     if(isset($_POST['create_comment'])) {
                        $the_post_id = escape($_GET['p_id']);
         
                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        // Verification if all 3 fields are filled before the query send to DB:
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                           $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                           $query .= "VALUES ('{$the_post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                           $create_comment_query = mysqli_query($connection, $query);
                           if(!$create_comment_query) {
                              exit('QUERY FAILED' . mysqli_error($connection));
                           }         
                           echo "<p class='bg-success'>Comment to <b>$post_title</b> Added." . " " . "<a href='post.php?p_id={$the_post_id}'>Return to Post</a></p>";
                        } else {
                           // echo "<p class='bg-warning'>At least one of the fields is empty.</p>";
                           echo "<script>alert('Fields cannot be empty.')</script>";
                        }
                     }
                  ?>
            
                     <!-- Adding comments Form -->
                     <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">
                           <div class="form-group">
                              <label for="author">Author</label>
                              <input type="text" class="form-control" name="comment_author">
                           </div>
                           <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" name="comment_email">
                           </div>
                        <form role="form">
                           <div class="form-group">
                              <label for="comment">Your Comment</label>
                              <textarea id="editor_body" class="form-control" name="comment_content" rows="3"></textarea>
                           </div>
                           <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                        </form>
                     </div>
                     <hr>

               <?php
               } else {
                  echo "<h1 class='text-center'>Not posts available</h1>";
               }
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