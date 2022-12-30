<h3>Users</h3>
<table class="table table-bordered table-hover">
   <thead>
      <tr>
         <th>Id</th>
         <th>Username</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Image</th>
         <th>Role</th>
         <!-- <th>Date</th> -->
         <th>Change to ..</th>
         <th>Change to ..</th>
         <th>Edit</th>
         <th>Delete</th>
      </tr>
   </thead>
   <tbody>

      <?php
         $query = "SELECT * FROM users ORDER BY user_id DESC";
         $select_users = mysqli_query($connection, $query);
         while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            // $user_date = $row['user_date'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$user_name}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td><img width='100' src='../images/{$user_image}'></td>";
            echo "<td>{$user_role}</td>";
            // echo "<td>{$user_date}</td>";

            echo "<td><a class='btn btn-success' href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a class='btn btn-primary' href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
            echo "<td><a class='btn btn-warning' href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";

            // // 1st variant (GET) of User-Deletion with simple confirmation message:
            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete $user_name?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";
            ?>

            <!-- 2nd variant (POST) of User-Deletion with simple confirmation message: -->
            <form action="" method="post">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
               <?php
                  echo "<td><input onClick=\"javascript: return confirm('Are you sure you want to delete $user_name?'); \" class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
               ?>
            </form>

            <?php
            echo "</tr>";
         }
      ?>
   </tbody>
</table>

<?php
   // Change user to Admin:
   changeUser('change_to_admin', 'admin');

   // Change user to Subscriber:
   changeUser('change_to_subscriber', 'subscriber');

   // Delete user:
   deleteSmth('user_id', 'users', 'user_id', 'users');
?>