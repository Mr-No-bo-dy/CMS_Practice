<?php
   if(isset($_POST['create_post'])) {
      $post_category_id = escape($_POST['post_category']);
      $post_title = escape($_POST['post_title']);
      $post_author = escape($_POST['post_author']);

      $post_date = escape($_POST['post_date']);
      $post_date = escape(date('y-m-d'));

      $post_image = escape($_FILES['post_image']['name']);
      $post_image_temp = escape($_FILES['post_image']['tmp_name']);
      move_uploaded_file($post_image_temp, "../images/$post_image");

      $post_content = escape($_POST['post_content']);
      $post_tags = escape($_POST['post_tags']);
      $post_status = escape($_POST['post_status']);

      // // ADD POST via mysqli_query:
      // $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
      // $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
      // $create_post_query = mysqli_query($connection, $query);
      // confirmQuery($create_post_query);

      // ADD POST via mysqli_stmt:
      $stmt = mysqli_prepare($connection, "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "isssssss", $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $post_status);
      mysqli_stmt_execute($stmt);
      confirmQuery($stmt);
      mysqli_stmt_close($stmt);
      
      // header("Location: posts.php");
      $the_post_id = mysqli_insert_id($connection);
      echo "<p class='bg-success'>Post <b>$post_title</b> Created." . " " . "<a href='../post.php?p_id={$the_post_id}'>View This Post</a> or <a href='posts.php'>View All Posts</a> or <a href='posts.php?source=add_post'>Add another Post</a></p>";

   } else if (isset($_POST['cancel'])) {
      header("Location: posts.php");
   }
?>
<h3>Add Post</h3>
<form action="" method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="post_title">Title</label>
      <input type="text" class="form-control" name="post_title">
   </div>
   <div class="form-group">
      <label for="post_author">Author</label>
      <input type="text" class="form-control" name="post_author">
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
               echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
         ?>
      </select>
   </div>
   <div class="form-group">
      <label for="post_status_id">Status</label>
      <select id="post_status_id" name="post_status">
         <option value='draft'>Draft</option>
         <option value='published'>Publish</option>
      </select>
   </div>
   <div class="form-group">
      <label for="post_image">Image</label>
      <input type="file" name="post_image">
   </div>
   <div class="form-group">
      <label for="post_tags">Tags</label>
      <input type="text" class="form-control" name="post_tags">
   </div>
   <div class="form-group">
      <label for="post_content">Content</label>
      <textarea id="editor_body" type="text" class="form-control" name="post_content" cols="30" rows="10"></textarea>
   </div>
   <div class="form-group">
      <label for="post_comment_count">Comments</label>
      <input type="text" class="form-control" name="post_comment_count">
   </div>
   <div class="form-group">
      <label for="post_date">Date</label>
      <input type="text" class="form-control" name="post_date">
   </div>
   <div class="form-group">
      <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
      <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
   </div>
</form>