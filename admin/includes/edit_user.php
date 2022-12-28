<?php
   if(isset($_GET['edit_user'])) {
      $the_user_id = escape($_GET['edit_user']);
      
      // Getting Values from DataBase
      $query = "SELECT * FROM users WHERE user_id = {$the_user_id}";
      $select_user_query = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($select_user_query)) {
         $user_name = $row['user_name'];
         $user_email = $row['user_email'];
         $user_password = $row['user_password'];
         $user_firstname = $row['user_firstname'];
         $user_lastname = $row['user_lastname'];
         $user_role = $row['user_role'];
         $user_image = $row['user_image'];
      }

      // Getting changed Values from $_Post
      if(isset($_POST['update_user'])) {
         $user_name = escape($_POST['user_name']);
         $user_email = escape($_POST['user_email']);
         $user_password = escape($_POST['user_password']);
         $user_firstname = escape($_POST['user_firstname']);
         $user_lastname = escape($_POST['user_lastname']);
         $user_role = escape($_POST['user_role']);
         $user_image = escape($_FILES['user_image']['name']);
         $user_image_temp = escape($_FILES['user_image']['tmp_name']);
         move_uploaded_file($user_image_temp, "../images/$user_image");

         // Making Image to show on "Edit User" page
         if(empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = {$the_user_id} ";
            $select_image = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select_image)) {
               $user_image = $row['user_image'];
            }
         }
         
         // NEW Password Encryption system:
         if(!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = {$the_user_id}";
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);
            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];
            if($db_user_password != $user_password) {
               $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }

            // Inserting updated Values into DataBase
            $query = "UPDATE users SET ";
            $query .= "user_name = '{$user_name}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$hashed_password}', ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "user_image = '{$user_image}' ";
            // $query .= "post_date = now() ";
            $query .= "WHERE user_id = '{$the_user_id}'";
            $user_update_query = mysqli_query($connection, $query);
            confirmQuery($user_update_query);
            echo "<p class='bg-success'>User <b>$user_name</b> Edited.   <a href='users.php'>View All Users</a></p>";
         }

      } else if (isset($_POST['cancel'])) {
         header("Location: users.php");
      }
   } else {
      header("Location: index.php");
   }
?>

<h3>Edit User</h3>
<form action="" method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="user_name">Username</label>
      <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>">
   </div>
   <div class="form-group">
      <label for="user_email">Email</label>
      <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
   </div>
   <div class="form-group">
      <label for="user_password">Password</label>
      <input type="password" class="form-control" name="user_password" autocomplete="off">
   </div>
   <div class="form-group">
      <label for="user_firstname">Firstname</label>
      <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
   </div>
   <div class="form-group">
      <label for="user_lastname">Lastname</label>
      <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
   </div>
   <div class="form-group">
      <label for="user-role">Select Role</label>
      <p></p>
      <select id="user-role" name="user_role">
         <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
         <?php
            if($user_role == 'admin') {
               echo "<option value='subscriber'>subscriber</option>";
            } else {
               echo "<option value='admin'>admin</option>";
            }
         ?>
      </select>
   </div>
   <div class="form-group">
      <img width="100" src="../images/<?php echo $user_image; ?>" alt="user_image">
      <label for="user_image">Image</label>
      <input type="file" name="user_image">
   </div>
   <!-- <div class="form-group">
      <label for="user_date">Date</label>
      <input type="text" class="form-control" name="user_date">
   </div> -->
   <div class="form-group">
      <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
      <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
   </div>
</form>