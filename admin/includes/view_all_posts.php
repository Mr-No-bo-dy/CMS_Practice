<?php
   include("delete_modal.php");     // Styled with Bootstrap pop-up window when deleting a post

   if(isset($_POST['checkBoxArray'])) {
      // $checkBoxArray[] .= $_POST['post_id'];
      foreach($_POST['checkBoxArray'] as $checkedPostId){
         $bulk_options = escape($_POST['bulk_options']);    // не впевнений: чи треба в цьому місці "ескейпити"
         switch($bulk_options){
            case 'draft':
               $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkedPostId}'";
               $post_draft_query = mysqli_query($connection, $query);
               confirmQuery($post_draft_query);
               break;
            case 'published':
               $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkedPostId}'";
               $post_published_query = mysqli_query($connection, $query);
               confirmQuery($post_published_query);
               break;
            case 'clone':
               // Cloning posts:
               $query = "SELECT * FROM posts WHERE post_id = '{$checkedPostId}'";
               $select_post_query = mysqli_query($connection, $query);

               while($row = mysqli_fetch_array($select_post_query)) {
                  $post_category_id = escape($row['post_category_id']);
                  $post_title = escape($row['post_title']);
                  $post_author = escape($row['post_author']);
                  $post_image = escape($row['post_image']);
                  $post_content = escape($row['post_content']);
                  $post_tags = escape($row['post_tags']);
                  $post_status = escape($row['post_status']);

                  // // Filling empty dimension with some content to not allow content shifting to another dimension:
                  // // // It can be upgraded to loop (for all the dimensions)...
                  // if(empty($post_tags)) {
                  //    $post_tags = "No tags";
                  // }
               }

               $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
               $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
               $post_clone_query = mysqli_query($connection, $query);
               confirmQuery($post_clone_query);
               break;
            case 'reset':
               $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$checkedPostId}'";
               $views_reset_query = mysqli_query($connection, $query);
               confirmQuery($views_reset_query);
               break;
            case 'delete':
               $query = "DELETE FROM posts WHERE post_id = '{$checkedPostId}'";
               $post_delete_query = mysqli_query($connection, $query);
               confirmQuery($post_delete_query);
               break;
         }
      }
   }
?>

<form action="" method="post">
   <h3>Posts</h3>
   <table class="table table-bordered table-hover">
      <div id="bulkOptionsContainer" class="form-group col-xs-4" style="padding-left: 0;">
         <select id="" class="form-control" name="bulk_options">
            <option value="draft">Draft</option>
            <option value="published">Publish</option>
            <option value="clone">Clone</option>
            <option value="reset">Reset Views</option>
            <option value="delete">Delete</option>
         </select>
      </div>
      <div class="form-group col-xs-4">
         <input class="btn btn-success" type="submit" name="Submit" value="Apply">
         <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
      </div>

      <thead>
         <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Content</th>
            <th>Comments</th>
            <th>Views</th>
            <th>Date</th>
            <th>Publish</th>
            <th>Unpublish</th>
            <th>Edit</th>
            <th>Delete</th>
         </tr>
      </thead>
      <tbody>
         <?php
            // $user_name = $_SESSION['user_name'];   // to Show only post made by current user
            
            // $query = "SELECT * FROM posts ORDER BY post_id DESC";  // Commented After Joining 2 tables in DataBase
            // Temporary Joining 2 tables in DataBase (Для того, щоб сторінка швидше працювала):
            $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, ";
            $query .= "posts.post_content, posts.post_comment_count, posts.post_views_count, posts.post_date, categories.cat_id, categories.cat_title ";
            $query .= "FROM posts ";
            $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC";
            // $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_author = '{$user_name}' ORDER BY post_id DESC";   // to Show only post made by current user

            $select_posts = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_posts)) {
               $post_id = $row['post_id'];
               $post_author = $row['post_author'];
               $post_title = $row['post_title'];
               $post_category_id = $row['post_category_id'];
               $post_status = $row['post_status'];
               $post_image = $row['post_image'];
               $post_tags = $row['post_tags'];
               $post_content = substr($row['post_content'], 0, 50);
               $post_comment_count = $row['post_comment_count'];
               $post_views_count = $row["post_views_count"];
               $post_date = $row['post_date'];
               $category_id = $row["cat_id"];        // After Joining 2 tables in DataBase
               $category_title = $row["cat_title"];  // After Joining 2 tables in DataBase

               echo "<tr>";
               ?>
                  <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo "$post_id"; ?>'></td>
               <?php
               echo "<td>{$post_id}</td>";
               echo "<td>{$post_author}</td>";
               echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

               // Commented After Joining 2 tables in DataBase:
               // // Making category_title to show instead of category_id
               // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
               // $select_categories_id = mysqli_query($connection, $query);
               // while ($row = mysqli_fetch_assoc($select_categories_id)) {
               //    $cat_id = $row["cat_id"];
               //    $cat_title = $row["cat_title"];
               //    echo "<td>{$cat_title}</td>";
               // }
               echo "<td>{$category_title}</td>";  // After Joining 2 tables in DataBase

               echo "<td>{$post_status}</td>";
               echo "<td><img width='100' src='../images/{$post_image}'></td>";
               echo "<td>{$post_tags}</td>";
               echo "<td>{$post_content}</td>";

               // NEW Comments_count system:
               // Не знаю, чи треба тут "ескейпити" $_GET['post_id'], а якщо треба - не знаю, як це зробити, щоб не втратити даний функціонал, і без помилок:
               $query = "SELECT * FROM comments WHERE comment_post_id = '{$post_id}'";
               $comment_count_query = mysqli_query($connection, $query);
               $count_comments = mysqli_num_rows($comment_count_query);
               echo "<td><a class='btn btn-info' href='post_comments.php?id={$post_id}'>{$count_comments}</a></td>";

               echo "<td><a class='btn btn-warning' onClick=\"javascript: return confirm('Are you sure you want to reset $post_title views count?'); \" href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
               echo "<td>{$post_date}</td>";
               echo "<td><a class='btn btn-success' href='posts.php?publish={$post_id}'>Publish</a></td>";
               echo "<td><a class='btn btn-primary' href='posts.php?unpublish={$post_id}'>Unpublish</a></td>";
               echo "<td><a class='btn btn-warning' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

               // // 1st variant (GET) of Post-Deletion with simple confirmation message:
               // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete $post_title?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
               
               // // 1st variant (GET) of Post-Deletion with nice-looking bootstrap confirmation message:
               // echo "<td><a rel='$post_id' href='javasript:void(0)' class='delete_link'>Delete</a></td>";
               ?>

               <!-- 2nd variant (POST) of Post-Deletion with simple confirmation message: -->
               <form action="" method="post">
                  <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                  <?php
                     // echo "<td><a rel='$post_id' href='javasript:void(0)' class='delete_link'><input class='btn btn-danger' type='submit' name='delete' value='Delete'></a></td>";     // JS Confirmation now does NOT work
                     echo "<td><input onClick=\"javascript: return confirm('Are you sure you want to delete $post_title?'); \" class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
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
   // Publish post:
   changePost('publish', 'post_status', 'published');

   // Unpublish post:
   changePost('unpublish', 'post_status', 'draft');

   // Reset post_views_count:
   changePost('reset', 'post_views_count', '0');
   
   // Delete post:
   deleteSmth('post_id', 'posts', 'post_id', 'posts');
?>

<!-- Script for Deleting post with nice-looking confirmation message: -->
<script>
   $(document).ready(function(){
      $(".delete_link").on('click', function(){
         var id = $(this).attr("rel");                      // Created var with value == value of attribute "rel"
         var delete_url = "posts.php?delete="+ id +" ";     // Created var with value == "posts.php?delete=#id"
         $(".modal_delete_link").attr("href", delete_url);  // Inserted in attr("href") of element with class "modal_delete_link" the value of var "delete_url"
         $("#exampleModal").modal('show');
      });
   });
</script>