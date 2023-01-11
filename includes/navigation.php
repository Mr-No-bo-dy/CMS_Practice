<?php session_start(); ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="/!php/_cms_practice/">Front Page</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <?php
               $query = "SELECT * FROM categories";
               $select_all_categories_query = mysqli_query($connection, $query);
               while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                  $cat_id = $row["cat_id"];
                  $cat_title = $row["cat_title"];

                  // Adding class="active" (for bootstrap's styles) for dinamic categories or static links:
                  $category_class = '';
                  $registration_class = '';
                  $login_class = '';
                  $contact_class = '';
                  $pageName = basename($_SERVER['PHP_SELF']);     // Filename of the currently executing script
                  $registration = 'registration.php';
                  $login = 'login.php';
                  $contact = 'contact.php';
                  if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                     $category_class = 'active';
                  } else if ($pageName == $registration) {
                     $registration_class = 'active';
                  } else if ($pageName == $login) {
                     $login_class = 'active';
                  } else if ($pageName == $contact) {
                     $contact_class = 'active';
                  }

                  echo "<li class='$category_class'><a href='/!php/_cms_practice/category/{$cat_id}'>{$cat_title}</a></li>";
               }
            ?>
            
            <?php if (isLoggedIn()): ?>
               <li>
                  <a href="/!php/_cms_practice/admin">Admin</a>
               </li>
               
               <?php
                  if($_SESSION['user_role'] == 'admin') {   // Show link to Edit post if admin logged in
                     if (isset($_GET['p_id'])) {
                        $post_id_edit = escape($_GET['p_id']);
                        echo "<li><a href='/!php/_cms_practice/admin/posts.php?source=edit_post&p_id={$post_id_edit}'>Edit Post</a></li>";
                     }
                  }
               ?>

               <li class="<?php echo $contact_class; ?>">
                  <a href="/!php/_cms_practice/contact">Contact</a>
               </li>

               <li>
                  <a href="/!php/_cms_practice/includes/logout.php">Logout</a>
               </li>

            <?php else: ?>
               <li class="<?php echo $registration_class; ?>">
                  <a href="/!php/_cms_practice/registration">Registration</a>
               </li>

               <li class="<?php echo $login_class; ?>">
                  <a href="/!php/_cms_practice/login">Login</a>
               </li>
               
            <?php endif; ?>

            <!-- <li>
               <a href="#">Services</a>
            </li> -->
         </ul>
      </div>
      <!-- /.navbar-collapse -->
   </div>
   <!-- /.container -->
</nav>