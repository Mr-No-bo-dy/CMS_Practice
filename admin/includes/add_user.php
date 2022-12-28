<?php
   if(isset($_POST['create_user'])) {
      $user_name = escape($_POST['user_name']);
      $user_email = escape($_POST['user_email']);
      $user_password = escape($_POST['user_password']);
      $user_firstname = escape($_POST['user_firstname']);
      $user_lastname = escape($_POST['user_lastname']);
      $user_role = escape($_POST['user_role']);

      $user_image = escape($_FILES['user_image']['name']);
      $user_image_temp = escape($_FILES['user_image']['tmp_name']);
      move_uploaded_file($user_image_temp, "../images/$user_image");

      // $user_date = escape($_POST['user_date']);
      // $user_date = escape(date('y-m-d'));
      
      // NEW password encryption:
      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

      $query = "INSERT INTO users(user_name, user_email, user_password, user_firstname, user_lastname, user_role, user_image) ";
      $query .= "VALUES('{$user_name}', '{$user_email}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$user_image}')";
      $create_user_query = mysqli_query($connection, $query);
      
      confirmQuery($create_user_query);
      // header("Location: users.php");
      echo "<p class='bg-success'>User <b>$user_name</b> Created." . " " . "<a href='users.php'>View All Users</a></p>";
   } else if (isset($_POST['cancel'])) {
      header("Location: users.php");
   }
?>
<h3>Add User</h3>
<form action="" method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="user_name">Username</label>
      <input type="text" class="form-control" name="user_name">
   </div>
   <div class="form-group">
      <label for="user_email">Email</label>
      <input type="email" class="form-control" name="user_email">
   </div>
   <div class="form-group">
      <label for="user_password">Password</label>
      <input type="password" class="form-control" name="user_password" autocomplete="off">
   </div>
   <div class="form-group">
      <label for="user_firstname">Firstname</label>
      <input type="text" class="form-control" name="user_firstname">
   </div>
   <div class="form-group">
      <label for="user_lastname">Lastname</label>
      <input type="text" class="form-control" name="user_lastname">
   </div>
   <div class="form-group">
      <label for="user-role">Select Role</label>
      <p></p>
      <select if="user-role" name="user_role">
         <option value="subscriber">Subscriber</option>
         <option value="admin">Admin</option>
      </select>
   </div>
   <div class="form-group">
      <!-- <img width="100" src="../images/<?php echo $user_image; ?>" alt="user_image"> -->
      <label for="user_image">Image</label>
      <input type="file" name="user_image">
   </div>
   <!-- <div class="form-group">
      <label for="user_date">Date</label>
      <input type="text" class="form-control" name="user_date">
   </div> -->
   <div class="form-group">
      <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
      <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
   </div>
</form>