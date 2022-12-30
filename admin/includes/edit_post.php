<?php
   if(isset($_GET['p_id'])) {
      $post_id_edit = escape($_GET['p_id']);

      // Getting Values from DataBase
      
      //    // SELECT POST via mysqli_query:
      // $query = "SELECT * FROM posts WHERE post_id = $post_id_edit";
      // $select_posts_by_id = mysqli_query($connection, $query);
      // while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
      //    $post_id = $row['post_id'];
      //    $post_author = $row['post_author'];
      //    $post_title = $row['post_title'];
      //    $post_category_id = $row['post_category_id'];
      //    $post_status = $row['post_status'];
      //    $post_image = $row['post_image'];
      //    $post_tags = $row['post_tags'];
      //    $post_content = $row['post_content'];
      //    $post_comment_count = $row['post_comment_count'];
      //    $post_date = $row['post_date'];
      // }

      // SELECT POST via mysqli_stmt:
      $stmt_select = mysqli_prepare($connection, "SELECT post_author, post_title, post_category_id, post_status, post_image, post_tags, post_content, post_comment_count, post_date FROM posts WHERE post_id = ?");
      mysqli_stmt_bind_param($stmt_select, "i", $post_id_edit);
      mysqli_stmt_execute($stmt_select);
      mysqli_stmt_bind_result($stmt_select, $post_author, $post_title, $post_category_id, $post_status, $post_image, $post_tags, $post_content, $post_comment_count, $post_date);
      mysqli_stmt_store_result($stmt_select);

      // Getting changed Values from $_POST
      if(isset($_POST['update_post'])) {
         $post_title = escape($_POST['post_title']);
         $post_author = escape($_POST['post_author']);
         $post_category_id = escape($_POST['post_category']);
         $post_status = escape($_POST['post_status']);
         $post_tags = escape($_POST['post_tags']);
         $post_content = escape($_POST['post_content']);
         $post_image = escape($_FILES['post_image']['name']);
         $post_image_temp = escape($_FILES['post_image']['tmp_name']);
         move_uploaded_file($post_image_temp, "../images/$post_image");

         // Making Image to show on "Edit Post" page
         if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $post_id_edit ";
            $select_image = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select_image)) {
               $post_image = $row['post_image'];
            }
         }
   
         // Inserting updated Values into DataBase
         
         //    // UPDATE COMMENT via mysqli_query:
         // $query = "UPDATE posts SET ";
         // $query .= "post_title = '{$post_title}', ";
         // $query .= "post_author = '{$post_author}', ";
         // $query .= "post_category_id = '{$post_category_id}', ";
         // $query .= "post_status = '{$post_status}', ";
         // $query .= "post_image = '{$post_image}', ";
         // $query .= "post_tags = '{$post_tags}', ";
         // $query .= "post_content = '{$post_content}', ";
         // $query .= "post_date = now() ";
         // $query .= "WHERE post_id = '{$post_id_edit}'";
         // $post_update_query = mysqli_query($connection, $query);
         // confirmQuery($post_update_query);

            // UPDATE COMMENT via mysqli_stmt:
         $stmt_update = mysqli_prepare($connection, "UPDATE posts SET post_title = ?, post_author = ?, post_category_id = ?, post_status = ?, post_image = ?, post_tags = ?, post_content = ?, post_date = now() WHERE post_id = ?");
         mysqli_stmt_bind_param($stmt_update, "ssissssi", $post_title, $post_author, $post_category_id, $post_status, $post_image, $post_tags, $post_content, $post_id_edit);
         mysqli_stmt_execute($stmt_update);
         confirmQuery($stmt_update);
         mysqli_stmt_close($stmt_update);

         echo "<p class='bg-success'>Post <b>$post_title</b> Edited.   <a href='../post.php?p_id={$post_id_edit}'>View Post</a> or <a href='posts.php'>Edit other Posts</a></p>";
      } else if (isset($_POST['cancel'])) {
         header("Location: posts.php");
      }
   }

while (mysqli_stmt_fetch($stmt_select)) {
?>

   <h3>Edit Post</h3>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
         <label for="post_title">Title</label>
         <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
      </div>
      <div class="form-group">
         <label for="post_author">Author</label>
         <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
      </div>
      <div class="form-group">
         <label for="post_category_id">Category</label>
         <select id="post_category_id" name="post_category">
            <?php
               $query = "SELECT * FROM categories";
               $select_category = mysqli_query($connection, $query);
               confirmQuery($select_category);

               while ($row = mysqli_fetch_assoc($select_category)) {
                  $cat_id = $row["cat_id"];
                  $cat_title = $row["cat_title"];
                  if($cat_id == $post_category_id) {
                     echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                  } else {
                     echo "<option value='{$cat_id}'>{$cat_title}</option>";
                  }
               }            
            ?>
         </select>
      </div>
      <div class="form-group">
         <label for="post_status_id">Status</label>
         <select id="post_status_id" name="post_status">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
               if($post_status == 'draft') {
                  echo "<option value='published'>publish</option>";
               } else {
                  echo "<option value='draft'>draft</option>";
               }
            ?>
         </select>
      </div>
      <div class="form-group">
         <img width="100" src="../images/<?php echo $post_image; ?>" alt="post_image">
         <label for="post_image">Image</label>
         <input type="file" name="post_image">
      </div>
      <div class="form-group">
         <label for="post_tags">Tags</label>
         <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
      </div>
      <div class="form-group">
         <label for="edit_post_content">Content</label>
         <textarea id="editor_body" type="text" class="form-control" name="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
      </div>
      <!-- <div class="form-group">
         <label for="post_comment_count">Comments</label>
         <input type="text" class="form-control" name="post_comment_count">
      </div> -->
      <div class="form-group">
         <label for="post_date">Date</label>
         <input type="text" class="form-control" name="post_date" value="<?php echo $post_date; ?>" readonly>
      </div>
      <div class="form-group">
         <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
         <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
      </div>
   </form>

<?php
}
confirmQuery($stmt_select);
mysqli_stmt_close($stmt_select);