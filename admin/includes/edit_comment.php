<?php
   if(isset($_GET['comment_id'])) {
      $comment_id_edit = escape($_GET['comment_id']);

      // Getting Values from DataBase

      //    // SELECT COMMENT via mysqli_query:
      // $query = "SELECT * FROM comments WHERE comment_id = {$comment_id_edit}";
      // $select_comments = mysqli_query($connection, $query);
      // while ($row = mysqli_fetch_assoc($select_comments)) {
      //    // $comment_id = $row['comment_id'];
      //    $comment_post_id = $row['comment_post_id'];
      //    $comment_author = $row['comment_author'];
      //    $comment_email = $row['comment_email'];
      //    $comment_content = $row['comment_content'];
      //    $comment_status = $row['comment_status'];
      //    $comment_date = $row['comment_date'];
      //    $comment_edit_author = $row['comment_edit_author'];
      //    $comment_editors_comment = $row['comment_editors_comment'];
      //    $comment_edited_date = $row['comment_edited_date'];
      // }

         // SELECT COMMENT via mysqli_stmt:
      $stmt_select = mysqli_prepare($connection, "SELECT comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date, comment_edit_author, comment_editors_comment, comment_edited_date FROM comments WHERE comment_id = ?");
      mysqli_stmt_bind_param($stmt_select, "i", $comment_id_edit);
      mysqli_stmt_execute($stmt_select);
      mysqli_stmt_bind_result($stmt_select, $comment_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date, $comment_edit_author, $comment_editors_comment, $comment_edited_date);
      mysqli_stmt_store_result($stmt_select);

      // Getting changed Values from $_POST
      if(isset($_POST['update_comment'])) {
         // $comment_author = escape($_POST['comment_author']);
         // $comment_email = escape($_POST['comment_email']);
         $comment_content = escape($_POST['comment_content']);
         $comment_status = escape($_POST['comment_status']);
         $comment_edit_author = escape($_SESSION['user_name']);
         $comment_editors_comment = escape($_POST['comment_editors_comment']);
         // $comment_edited_date = escape($_POST['comment_edited_date']);
   
         // Inserting updated Values into DataBase
         
         //    // UPDATE COMMENT via mysqli_query:
         // $query = "UPDATE comments SET ";
         // // $query .= "comment_author = '{$comment_author}', ";
         // // $query .= "comment_email = '{$comment_email}', ";
         // $query .= "comment_content = '{$comment_content}', ";
         // $query .= "comment_status = '{$comment_status}', ";
         // $query .= "comment_edit_author = '{$comment_edit_author}', ";
         // $query .= "comment_editors_comment = '{$comment_editors_comment}', ";
         // $query .= "comment_edited_date = now() ";
         // $query .= "WHERE comment_id = '{$comment_id_edit}'";
         // $comment_update_query = mysqli_query($connection, $query);
         // confirmQuery($comment_update_query);

            // UPDATE COMMENT via mysqli_stmt:
         $stmt_update = mysqli_prepare($connection, "UPDATE comments SET comment_content = ?, comment_status = ?, comment_edit_author = ?, comment_editors_comment = ?, comment_edited_date = now() WHERE comment_id = ?");
         mysqli_stmt_bind_param($stmt_update, "ssssi", $comment_content, $comment_status, $comment_edit_author, $comment_editors_comment, $comment_id_edit);
         mysqli_stmt_execute($stmt_update);
         confirmQuery($stmt_update);
         mysqli_stmt_close($stmt_update);

         while (mysqli_stmt_fetch($stmt_select)) {    // This loop needed for geting $comment_post_id
            echo "<p class='bg-success'>Comment Edited.   <a href='../post.php?p_id={$comment_post_id}'>View parent Post</a> or <a href='comments.php'>Edit other Comments</a></p>";
         }
      } else if (isset($_POST['cancel'])) {
         header("Location: comments.php");
      }
   }

while (mysqli_stmt_fetch($stmt_select)) {
?>

   <h3>Edit Comment</h3>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
         <label for="comment_author">Author</label>
         <input type="text" class="form-control" name="comment_author" value="<?php echo $comment_author; ?>" readonly>
      </div>
      <div class="form-group">
         <label for="comment_email">Email</label>
         <input type="text" class="form-control" name="comment_email" value="<?php echo $comment_email; ?>" readonly>
      </div>
      <div class="form-group">
         <label for="comment_status_id">Status</label>
         <select id="comment_status_id" name="comment_status">
            <option value='<?php echo $comment_status; ?>'><?php echo $comment_status; ?></option>
            <?php
               if($comment_status == 'approved') {
                  echo "<option value='unapproved'>unapproved</option>";
               } else {
                  echo "<option value='approved'>approved</option>";
               }
            ?>
         </select>
      </div>
      <div class="form-group">
         <label for="edit_comment_content">Content</label>
         <textarea id="editor_body" type="text" class="form-control" name="comment_content" cols="30" rows="10"><?php echo $comment_content; ?></textarea>
      </div>
      <div class="form-group">
         <label for="comment_date">Date</label>
         <input type="text" class="form-control" name="comment_date" value="<?php echo $comment_date; ?>" readonly>
      </div>
         <div class="form-group">
         <label for="comment_edit_author">Edit Author</label>
         <input type="text" class="form-control" name="comment_edit_author" value="<?php echo $_SESSION['user_name']; ?>" readonly>
      </div>
      <div class="form-group">
         <label for="comment_editors_comment">Editor's Comment</label>
         <input type="text" class="form-control" name="comment_editors_comment">
      </div>
      <div class="form-group">
         <label for="comment_edited_date">Edited Date</label>
         <input type="text" class="form-control" name="comment_date" value="<?php echo "$comment_edited_date"; ?>" readonly>
      </div>
      <div class="form-group">
         <input type="submit" class="btn btn-primary" name="update_comment" value="Update Comment">
         <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
      </div>
   </form>

<?php
}
confirmQuery($stmt_select);
mysqli_stmt_close($stmt_select);