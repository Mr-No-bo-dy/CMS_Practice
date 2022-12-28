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
               </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-file-text fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $posts_count = recordCount('posts'); ?></div>
                              <div>Posts</div>
                           </div>
                        </div>
                     </div>
                     <a href="posts.php">
                        <div class="panel-footer">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                           <div class="clearfix"></div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-green">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-comments fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $comments_count = recordCount('comments'); ?></div>
                              <div>Comments</div>
                           </div>
                        </div>
                     </div>
                     <a href="comments.php">
                        <div class="panel-footer">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                           <div class="clearfix"></div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-yellow">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-user fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $users_count = recordCount('users'); ?></div>
                              <div> Users</div>
                           </div>
                        </div>
                     </div>
                     <a href="users.php">
                        <div class="panel-footer">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                           <div class="clearfix"></div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-red">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-list fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $categories_count = recordCount('categories'); ?></div>
                              <div>Categories</div>
                           </div>
                        </div>
                     </div>
                     <a href="categories.php">
                        <div class="panel-footer">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                           <div class="clearfix"></div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
            <!-- /.row -->

            <?php
               $draft_posts_count = recordCountPartial('posts', 'post_status', 'draft');

               $published_posts_count = recordCountPartial('posts', 'post_status', 'published');
               
               $unapproved_comments_count = recordCountPartial('comments', 'comment_status', 'unapproved');

               $approved_comments_count = recordCountPartial('comments', 'comment_status', 'approved');

               $admin_users_count = recordCountPartial('users', 'user_role', 'admin');

               $subscriber_users_count = recordCountPartial('users', 'user_role', 'subscriber');
            ?>

            <div class="row">
               <script type="text/javascript">
                  google.charts.load('current', {'packages':['bar']});
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {
                     var data = google.visualization.arrayToDataTable([
                        ['Date', 'Count'],

                        <?php
                           // 1-row variants:
                           $elements_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Pending Comments', 'Approved Comments', 'Users', 'Admins', 'Subscribers', 'Categories'];
                           $elements_count = [$posts_count, $draft_posts_count, $published_posts_count, $comments_count, $unapproved_comments_count, $approved_comments_count, $users_count, $admin_users_count, $subscriber_users_count, $categories_count];

                           for($i = 0; $i < 10; $i++) {
                              echo "['{$elements_text[$i]}'" . "," . "{$elements_count[$i]}],";
                           }
                        ?>

                     ]);

                     var options = {
                        chart: {
                           title: '',
                           subtitle: '',
                        }
                     };

                     var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                     chart.draw(data, google.charts.Bar.convertOptions(options));
                  }
               </script>

               <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>

         </div>
         <!-- /.container-fluid -->

      </div>
      <!-- /#page-wrapper -->

   </div>
   <!-- /#wrapper -->

<?php include ("includes/admin_footer.php"); ?>