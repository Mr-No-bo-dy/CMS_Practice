<?php
   if(isset($_POST['checkBoxArray'])) {
      foreach($_POST['checkBoxArray'] as $checkedCommentId){
         $bulk_options = escape($_POST['bulk_options']);    // не впевнений: чи треба в цьому місці "ескейпити"
         switch($bulk_options){
            case 'approved':
               $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$checkedCommentId}'";
               $comment_approve_query = mysqli_query($connection, $query);
               confirmQuery($comment_approve_query);
               break;
            case 'unapproved':
               $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$checkedCommentId}'";
               $comment_unapprove_query = mysqli_query($connection, $query);
               confirmQuery($comment_unapprove_query);
               break;
            case 'delete':
               $query = "DELETE FROM comments WHERE comment_id = '{$checkedCommentId}'";
               $comment_delete_query = mysqli_query($connection, $query);
               confirmQuery($comment_delete_query);
               break;
         }
      }
   }
?>

<form action="" method="post">
   <h3>Comments</h3>
   <table class="table table-bordered table-hover">
         <div id="bulkOptionsContainer" class="form-group col-xs-4" style="padding-left: 0;">
            <select id="" class="form-control" name="bulk_options">
               <option value="approved">Approve</option>
               <option value="unapproved">Unapprove</option>
               <option value="delete">Delete</option>
            </select>
         </div>
         <div class="form-group col-xs-4">
            <input class="btn btn-success" type="submit" name="Submit" value="Apply">
         </div>

      <thead>
         <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>Date</th>
            <th>In Response to</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Edit</th>
            <th>Delete</th>
         </tr>
      </thead>
      <tbody>

         <?php
            $query = "SELECT * FROM comments ORDER BY comment_id DESC";
            $select_comments = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_comments)) {
               $comment_id = $row['comment_id'];
               $comment_post_id = $row['comment_post_id'];
               $comment_author = $row['comment_author'];
               $comment_email = $row['comment_email'];
               $comment_content = substr($row['comment_content'], 0, 50);
               $comment_status = $row['comment_status'];
               $comment_date = $row['comment_date'];

               echo "<tr>";
               ?>
                  <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo "$comment_id"; ?>'></td>
               <?php
               echo "<td>{$comment_id}</td>";
               echo "<td>{$comment_author}</td>";
               echo "<td>{$comment_content}</td>";
               echo "<td>{$comment_email}</td>";
               echo "<td>{$comment_status}</td>";
               echo "<td>{$comment_date}</td>";

               $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
               $select_post_id_query = mysqli_query($connection, $query);
               while($row = mysqli_fetch_assoc($select_post_id_query)) {
                  $post_id = $row['post_id'];
                  $post_title = $row['post_title'];
                  echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
               }

               echo "<td><a class='btn btn-success' href='comments.php?approved=$comment_id'>Approve</a></td>";
               echo "<td><a class='btn btn-primary' href='comments.php?unapproved=$comment_id'>Unapprove</a></td>";
               echo "<td><a class='btn btn-warning' href='comments.php?source=edit_comment&comment_id=$comment_id'>Edit</a></td>";
               
               // // 1st variant (GET) of Comment-Deletion with simple confirmation message:
               // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this comment?'); \" href='comments.php?delete=$comment_id'>Delete</a></td>";
               ?>

               <!-- 2nd variant (POST) of Comment-Deletion with simple confirmation message: -->
               <form action="" method="post">
                     <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                  <?php
                     echo "<td><input onClick=\"javascript: return confirm('Are you sure you want to delete this comment?'); \" class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
                  ?>
               </form>

               <?php
            
               echo "</tr>";
            }
         ?>
      </tbody>
   </table>
</form>

<?php
   // Approve comment:
   changeComment('approved', 'approved');

   // Unapprove comment:
   changeComment('unapproved', 'unapproved');

   // Delete comment:
   deleteSmth('comment_id', 'comments', 'comment_id', 'comments');
?>