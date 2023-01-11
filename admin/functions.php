<?php
   function confirmQuery($result) {
      global $connection;
      if(!$result) {
         exit("QUERY FAILED ." . mysqli_error($connection));
      }
   }


   // Security function to escape strings in various places of code:
   function escape($string) {
      global $connection;
      return mysqli_real_escape_string($connection, trim($string));
   }


   // Helper Functions:
      function redirect($location) {
         header("Location:" . $location);
         exit;
      }

      function ifItIsMethod($method=null) {
         if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
            return true;
         }
         return false;
      }

      function isLoggedIn(){
         if (isset($_SESSION['user_role'])) {
            return true;
         }
         return false;
      }

      function checkIfUserIsLoggedInAndRedirect($redirectLocation=null) {
         if (ifItIsMethod()) {
            redirect($redirectLocation);
         }
      }


    // Security function to NOT allow subscribers into "some page":
   function isAdmin($name) {
      global $connection;
      $query = "SELECT user_role FROM users WHERE user_name = '{$name}'";
      $result = mysqli_query($connection, $query);
      confirmQuery($result);
      $row = mysqli_fetch_array($result);
      if($row['user_role'] == 'admin') {
         return true;
      } else {
         return false;
      }
   }


   // Verification-Function to NOT allow registration user with same 'user_name':
   function user_name_Exist($name) {
      global $connection;

      //    // Check if Name is occupied via mysqli_query:
      // $query = "SELECT user_name FROM users WHERE user_name = '{$name}'";
      // $result = mysqli_query($connection, $query);
      // confirmQuery($result);
      // $row = mysqli_num_rows($result);
      
         // Check if Name is occupied via mysqli_stmt:
      $stmt = mysqli_prepare($connection, "SELECT user_name FROM users WHERE user_name = ?");
      mysqli_stmt_bind_param($stmt, "s", $name);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $name);
      mysqli_stmt_store_result($stmt);
      $row = mysqli_stmt_num_rows($stmt);
      confirmQuery($stmt);
      mysqli_stmt_close($stmt);

      if($row > 0) {
         return true;
      } else {
         return false;
      }
   }

   // Verification-Function to NOT allow registration user with same 'user_email':
   function user_email_Exist($email) {
      global $connection;

      //    // Check if Email is already registered via mysqli_query:
      // $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
      // $result = mysqli_query($connection, $query);
      // confirmQuery($result);
      // $row = mysqli_num_rows($result);
      
         // Check if Email is already registered via mysqli_stmt:
      $stmt = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ?");
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $email);
      mysqli_stmt_store_result($stmt);
      $row = mysqli_stmt_num_rows($stmt);
      confirmQuery($stmt);
      mysqli_stmt_close($stmt);
         
      if($row > 0) {
         return true;
      } else {
         return false;
      }
   }

   // User Regitration function:
   function registerUser($user_name, $user_email, $user_password) {
      global $connection;

      // NEW password encryption:
      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
      
      // Registration itself:

      //    // Register USER via mysqli_query:
      // $query = "INSERT INTO users (user_name, user_email, user_password, user_role) ";
      // $query .= "VALUES ('{$user_name}', '{$user_email}', '{$user_password}', 'subscriber')";
      // $register_user_query = mysqli_query($connection, $query);
      // confirmQuery($register_user_query);

         // Register USER via mysqli_stmt:
      $stmt_register = mysqli_prepare($connection, "INSERT INTO users(user_name, user_email, user_password, user_role) VALUES('{$user_name}', '{$user_email}', '{$user_password}', 'subscriber')");
      mysqli_stmt_execute($stmt_register);

      confirmQuery($stmt_register);
      mysqli_stmt_close($stmt_register);
   }

   // User Login function:
   function loginUser($user_name, $user_password) {
      global $connection;

      //    // Login USER via mysqli_query:
      // $query = "SELECT * FROM users WHERE user_name = '{$user_name}' ";
      // $select_user_query = mysqli_query($connection, $query);
      // confirmQuery($select_user_query);
      // while($row = mysqli_fetch_array($select_user_query)) {
      //    $db_user_id = $row['user_id'];
      //    $db_user_name = $row['user_name'];
      //    $db_user_password = $row['user_password'];
      //    $db_user_firstname = $row['user_firstname'];
      //    $db_user_lastname = $row['user_lastname'];
      //    $db_user_role = $row['user_role'];
      //    // $db_user_image = $row['user_image'];
      // }
      
         // Login USER via mysqli_stmt:
      $stmt_login = mysqli_prepare($connection, "SELECT user_id, user_name, user_password, user_firstname, user_lastname, user_role FROM users WHERE user_name = ? ");
      mysqli_stmt_bind_param($stmt_login, "s", $user_name);
      mysqli_stmt_execute($stmt_login);
      mysqli_stmt_bind_result($stmt_login, $db_user_id, $db_user_name, $db_user_password, $db_user_firstname, $db_user_lastname, $db_user_role);
      mysqli_stmt_store_result($stmt_login);

      while(mysqli_stmt_fetch($stmt_login)) {
         // NEW password verification and Login system:
         if(password_verify($user_password, $db_user_password)) {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['user_name'] = $db_user_name;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            // header("Location: ../admin/index.php");                  // Relative path
            header("Location: /!php/_cms_practice/admin/index.php");       // Absolute path
         } else {
            // header("Location: ../index.php");                        // Relative path
            // header("Location: /!php/_cms_practice/index");                 // Absolute path
            // echo "<script>alert('Wrong Username or Password.')</script>";        // Not implemented yet
            return false;
         }
      }
      confirmQuery($stmt_login);
      mysqli_stmt_close($stmt_login);
   }


   // ADD CATEGORY QUERY
   function insertCategories() {
      global $connection;
      if(isset($_POST["submit"])) {
         $cat_title = escape($_POST["cat_title"]);
         if ($cat_title == "" || empty ($cat_title)) {
            echo "This field should not be empty!";
         } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $cat_title);
            mysqli_stmt_execute($stmt);
            
            confirmQuery($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Category added</p>";
         }
      } else if (isset($_POST['cancel'])) {
         header("Location: categories.php");
      }
   }
    
   // FIND ALL CATEGORIES QUERY
   function findAllCategories() {
      global $connection;
      $query = "SELECT * FROM categories";
      $select_categories = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($select_categories)) {
         $cat_id = $row["cat_id"];
         $cat_title = $row["cat_title"];
         echo "<tr>";
         echo "<td>$cat_id</td>";
         echo "<td>$cat_title</td>";
         echo "<td><a class='btn btn-warning' href='categories.php?edit=$cat_id'>Edit</a></td>";
         echo "<td><a class='btn btn-danger' href='categories.php?delete=$cat_id'>Delete</a></td>";
         echo "</tr>";
      }
   }

   // DELETE CATEGORY QUERY
   function deleteCategories() {
      global $connection;
      if (isset($_GET["delete"])) {
         $cat_id_delete = escape($_GET["delete"]);
         $stmt = mysqli_prepare($connection, "DELETE FROM categories WHERE cat_id = ?");
         mysqli_stmt_bind_param($stmt, "i", $cat_id_delete);
         mysqli_stmt_execute($stmt);

         confirmQuery($stmt);
         mysqli_stmt_close($stmt);
         header("Location: categories.php");     /* This Send that request back to categories.php,
                              so we won't need to refresh page to see that category is deleted. */
      }
   }

   // UPDATE CATEGORY QUERY
   function updateCategories() {
      global $connection;
   ?>
      <form action="" method="post">
         <div class="form-group">
            <label for="cat_title">Update Category</label>
   <?php
            // FIND & SHOW CATEGORY QUERY
            if (isset($_GET["edit"])) {
               $cat_id = escape($_GET["edit"]);
               $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
               $select_categories_id = mysqli_query($connection, $query);
               while ($row = mysqli_fetch_assoc($select_categories_id)) {
                  $cat_id = $row["cat_id"];
                  $cat_title = $row["cat_title"];
                  ?>
                  <input class="form-control" type="text" name="cat_title" value="<?php if(isset($cat_title)){echo $cat_title;} ?>">
                  <?php
               }
            }

            // UPDATE CATEGORY
            if (isset($_POST["update_category"])) {
               $cat_title_update = escape($_POST["cat_title"]);
               $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
               mysqli_stmt_bind_param($stmt, "si", $cat_title_update, $cat_id);
               mysqli_stmt_execute($stmt);

               confirmQuery($stmt);
               mysqli_stmt_close($stmt);
               header("Location: categories.php");
            } else if (isset($_POST['cancel'])) {
               header("Location: categories.php");
            }
   ?>
         </div>
         <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
            <input class="btn btn-primary" type="submit" name="cancel" value="Cancel">
         </div>
      </form>
   <?php
   }

   
   // Function to count different stats for Admin's dashboard:
   function recordCount($table) {
      global $connection;
      $query = "SELECT * FROM " . $table;
      $select_all_smth = mysqli_query($connection, $query);
      $result = mysqli_num_rows($select_all_smth);
      confirmQuery($result);
      return $result;
   }

   // Function to count different partial stats for Admin's dashboard:
   function recordCountPartial($table, $column, $value) {
      global $connection;
      $query = "SELECT * FROM " . $table . " WHERE " . $column . "= '" . $value . "'";
      $select_partial_smth = mysqli_query($connection, $query);
      $resultPartial = mysqli_num_rows($select_partial_smth);
      confirmQuery($resultPartial);
      return $resultPartial;
   }
   

   // Changing Comments in Admin - Comments:
   function changeComment($request, $value) {
      global $connection;
      global $comment_id;
      if(isset($_GET[$request])) {
         if(isset($_SESSION['user_role'])) {             // Added security to prevent comments's changing by anyone (by GET-request)
            if($_SESSION['user_role'] == 'admin') {      // Added security to prevent comments's changing by anyone (by GET-request)
               $comment_id = escape($_GET[$request]);

               //    // Change comments via mysqli_query:
               // $query = "UPDATE comments SET comment_status = '{$value}' WHERE comment_id = '{$comment_id}'";
               // $comment_change_query = mysqli_query($connection, $query);
               // confirmQuery($comment_change_query);

                  // Change comments via mysqli_stmt:
               $stmt_comment = mysqli_prepare($connection, "UPDATE comments SET comment_status = ? WHERE comment_id = ?");
               mysqli_stmt_bind_param($stmt_comment, "si", $value, $comment_id);
               mysqli_stmt_execute($stmt_comment);

               confirmQuery($stmt_comment);
               mysqli_stmt_close($stmt_comment);
               header("Location: comments.php");
            } else {
               echo "<script>alert('You are NOT allowed to do this.')</script>";
            }
         }
      }
   }

   // Changing Posts in Admin - View All Posts:
   function changePost($request, $column, $value) {
      global $connection;
      global $post_id;
      if(isset($_GET[$request])) {
         if(isset($_SESSION['user_role'])) {          // Added security to prevent posts's changing by anyone (by GET-request)
            if($_SESSION['user_role'] == 'admin') {   // Added security to prevent posts's changing by anyone (by GET-request)
               $post_id = escape($_GET[$request]);

               //    // Change posts via mysqli_query:
               // $query = "UPDATE posts SET $column = '{$value}' WHERE post_id = '{$post_id}'";
               // $post_change_query = mysqli_query($connection, $query);
               // confirmQuery($post_change_query);

                  // Change posts via mysqli_stmt:
               $stmt_post = mysqli_prepare($connection, "UPDATE posts SET $column = ? WHERE post_id = ?");
               mysqli_stmt_bind_param($stmt_post, "si", $value, $post_id);
               mysqli_stmt_execute($stmt_post);

               confirmQuery($stmt_post);
               mysqli_stmt_close($stmt_post);
               header("Location: posts.php");
            } else {
               echo "<script>alert('You are NOT allowed to do this.')</script>";
            }
         }
      }      
   }

   // Changing Users in Admin - View All Users:
   function changeUser($request, $value) {
      global $connection;
      global $user_id;
      if(isset($_GET[$request])) {
         if(isset($_SESSION['user_role'])) {             // Added security to prevent user's changing by anyone (by GET-request)
            if($_SESSION['user_role'] == 'admin') {      // Added security to prevent user's changing by anyone (by GET-request)
               $user_id = escape($_GET[$request]);

               //    // Change users via mysqli_query:
               // $query = "UPDATE users SET user_role = '{$value}' WHERE user_id = '{$user_id}'";
               // $user_change_query = mysqli_query($connection, $query);
               // confirmQuery($user_change_query);

                  // Change users via mysqli_stmt:
               $stmt_user = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE user_id = ?");
               mysqli_stmt_bind_param($stmt_user, "si", $value, $user_id);
               mysqli_stmt_execute($stmt_user);

               confirmQuery($stmt_user);
               mysqli_stmt_close($stmt_user);
               header("Location: users.php");
            } else {
               echo "<script>alert('You are NOT allowed to do this.')</script>";
            }
         }
      }
   }

   // Deleting post/comment/user in Admin:
   function deleteSmth($smth_id, $table, $column, $redirect) {
      global $connection;
      if(isset($_POST['delete'])) {
         if(isset($_SESSION['user_role'])) {             // Added security to prevent user/post/comment's deletion by anyone (by GET-request)
            if($_SESSION['user_role'] == 'admin') {      // Added security to prevent user/post/comment's deletion by anyone (by GET-request)
               $smth_id = escape($_POST[$smth_id]);

               //    // Delete smth via mysqli_query:
               // $query = "DELETE FROM $table WHERE $column = '{$smth_id}'";
               // $delete_query = mysqli_query($connection, $query);
               // confirmQuery($delete_query);

                  // Delete smth via mysqli_stmt:
               $stmt_delete = mysqli_prepare($connection, "DELETE FROM $table WHERE $column = ?");
               mysqli_stmt_bind_param($stmt_delete, "i", $smth_id);
               mysqli_stmt_execute($stmt_delete);

               confirmQuery($stmt_delete);
               mysqli_stmt_close($stmt_delete);
               header("Location: $redirect.php");
            } else {
               echo "<script>alert('You are NOT allowed to do this.')</script>";
            }
         }
      }
   }


   // // Geting number of Online Users:
   // function usersOnlineCountB() {
   //    global $connection;
   //    $session = session_id();   // Catch the ID of started Session
   //    $time = time();            // Number of Seconds past after 1970.01.01 00:00:00 GMT
   //    $time_out_in_seconds = 60;   // Number of seconds after we mark user as offline
   //    $time_out = $time - $time_out_in_seconds;    // When User logged out
   //    $query = "SELECT * FROM users_online WHERE session = '{$session}'";
   //    $send_query = mysqli_query($connection, $query);
   //    $users_count = mysqli_num_rows($send_query);
   //    if($users_count == NULL) {
   //       mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')");    // Inserting the Session id & Time info of new Users
   //    } else {
   //       mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");     // Updating Time of old Users
   //    }
   //    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");     // Geting info about all online Users
   //    return $users_online_count = mysqli_num_rows($users_online_query);
   // }

   // Constantly Geting number of Online Users:
   // Через те, що в мене допуск в Адмінку мають лише адміни, то й лічильник цей показує лише адмінів:
   function usersOnlineCount() {
      if(isset($_GET['onlineusers'])) {   // Included Script to "Constantly sending request to DB to get the count of Users online:"
         global $connection;
         if(!$connection) {
            session_start();
            include("../includes/db.php");
      
            $session = session_id();   // Catch the ID of started Session
            $time = time();            // Number of Seconds past after 1970.01.01 00:00:00 GMT
            $time_out_in_seconds = 60;   // Number of seconds after we mark user as offline
            $time_out = $time - $time_out_in_seconds;    // When User logged out

            $query = "SELECT * FROM users_online WHERE session = '{$session}'";
            $send_query = mysqli_query($connection, $query);
            $users_count = mysqli_num_rows($send_query);

            if($users_count == NULL) {
               mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')");    // Inserting the Session id & Time info of new Users
            } else {
               mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");     // Updating Time of old Users
            }
            
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");     // Geting info about all online Users
            echo $users_online_count = mysqli_num_rows($users_online_query);
         }
      }
   }
   usersOnlineCount();
?>