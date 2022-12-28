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
                        Welcome to Admin
                        <small><?php echo $_SESSION['user_name']; ?></small>
                  </h1>

                  <h3>User's Profile</h3>
   
<?php
   if(isset($_SESSION['user_name'])) {
      // Getting Values from DataBase:
      $user_name = escape($_SESSION['user_name']);    // не впевнений: чи треба тут "ескейпити"
      $query = "SELECT * FROM users WHERE user_name = '{$user_name}'";
      $select_user_query = mysqli_query($connection, $query);
      while($row = mysqli_fetch_array($select_user_query)) {
         $the_user_id = $row['user_id'];
         $user_name = $row['user_name'];
         $user_email = $row['user_email'];
         $user_password = $row['user_password'];
         $user_firstname = $row['user_firstname'];
         $user_lastname = $row['user_lastname'];
         $user_image = $row['user_image'];
      }
      
      // Getting changed Values from $_Post:
      if(isset($_POST['update_user'])) {
         $user_name = escape($_POST['user_name']);
         $user_email = escape($_POST['user_email']);
         $user_password = escape($_POST['user_password']);
         $user_firstname = escape($_POST['user_firstname']);
         $user_lastname = escape($_POST['user_lastname']);
         $user_image = escape($_FILES['user_image']['name']);
         $user_image_temp = escape($_FILES['user_image']['tmp_name']);
         move_uploaded_file($user_image_temp, "../images/$user_image");

         // Making Image to show on "Edit User" page:
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

            // Inserting updated Values into DataBase:
            $query = "UPDATE users SET ";
            $query .= "user_name = '{$user_name}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$hashed_password}', ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_image = '{$user_image}' ";
            // $query .= "post_date = now() ";
            $query .= "WHERE user_id = '{$the_user_id}'";
            $user_update_query = mysqli_query($connection, $query);
            confirmQuery($user_update_query);
            // header("Location: users.php");
            echo "<p class='bg-success'>Profile <b>$user_name</b> Edited." . " " . "<a href='users.php'>View All Users</a></p>";
         }
      } else if (isset($_POST['cancel'])) {
         header("Location: index.php");
      }
   }
?>

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
         <img width="100" src="../images/<?php echo $user_image; ?>" alt="user_image">
         <label for="user_image">Image</label>
         <input type="file" name="user_image">
      </div>
      <!-- <div class="form-group">
         <label for="user_date">Date</label>
         <input type="text" class="form-control" name="user_date">
      </div> -->
      <div class="form-group">
         <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
         <input type="submit" class="btn btn-primary" name="cancel" value="Cancel">
      </div>
   </form>

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