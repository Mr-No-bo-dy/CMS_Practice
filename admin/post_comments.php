<?php include ("includes/admin_head.php"); ?>

    <div id="wrapper">

      <!-- Navigation -->
      <?php include ("includes/admin_navigation.php"); ?>

      <div id="page-wrapper">

         <div class="container-fluid">

               <!-- Page Heading -->
               <div class="row">
                  <div class="col-lg-12">
                     <h1 class="page-header">
                           Welcome to Comments
                           <small><?php echo $_SESSION['user_name']; ?></small>
                     </h1>

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
            <th>Delete</th>
         </tr>
      </thead>
      <tbody>

         <?php
            // $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) . " ORDER BY comment_id DESC ";
            $the_comment_id = escape($_GET['id']);
            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_comment_id} ORDER BY comment_id DESC ";
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

               echo "<td><a href='post_comments.php?approved=$comment_id&id=" . $_GET['id'] . "'>Approve</a></td>";     // &id=" . $_GET['id'] . " - додано тут для того, щоб функціонувало перенаправлення при зміні коментів
               echo "<td><a href='post_comments.php?unapproved=$comment_id&id=" . $_GET['id'] . "'>Unapprove</a></td>";
               echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this comment?'); \" href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
               echo "</tr>";
            }
         ?>
      </tbody>
   </table>
</form>

<?php
   if(isset($_GET['approved'])) {
      if(isset($_SESSION['user_role'])) {             // Added security to prevent comments's deletion or changing by anyone (by GET-request)
         if($_SESSION['user_role'] == 'admin') {      // Added security to prevent comments's deletion or changing by anyone (by GET-request)
            $the_comment_id = escape($_GET['approved']);
            $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";
            $approved_comment_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=" . $_GET['id'] . "");
         }
      }
   }

   if(isset($_GET['unapproved'])) {
      if(isset($_SESSION['user_role'])) {
         if($_SESSION['user_role'] == 'admin') {
            $the_comment_id = escape($_GET['unapproved']);
            $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id";
            $unapproved_comment_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=" . $_GET['id'] . "");
         }
      }
   }

   if(isset($_GET['delete'])) {
      if(isset($_SESSION['user_role'])) {
         if($_SESSION['user_role'] == 'admin') {
            $the_comment_id = escape($_GET['delete']);
            $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
            $delete_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=" . $_GET['id'] . "");
         }
      }
   }
?>

                  </div>
               </div>
               <!-- /.row -->

         </div>
         <!-- /.container-fluid -->

      </div>
      <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include ("includes/admin_footer.php"); ?>