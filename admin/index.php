<?php include ("includes/admin_head.php"); ?>

   <div id="wrapper">
      
      <!-- Navigation -->
      <?php include ("includes/admin_navigation.php"); ?>
      
<?php
   $posts_count = countRecords(getUserPosts());

   // $draft_posts_count = recordCountPartial('posts', 'post_status', 'draft');
   // $draft_posts_count = recordCountPartialByUser('posts', 'post_status', 'draft');
   $draft_posts_count = countRecords(getUserDraftPosts());

   // $published_posts_count = recordCountPartial('posts', 'post_status', 'published');
   // $published_posts_count = recordCountPartialByUser('posts', 'post_status', 'published');
   $published_posts_count = countRecords(getUserPublishedPosts());
   
   $comments_count = countRecords(getUserComments());

   // $unapproved_comments_count = recordCountPartial('comments', 'comment_status', 'unapproved');
   $unapproved_comments_count = countRecords(getUserApprovedComments());

   // $approved_comments_count = recordCountPartial('comments', 'comment_status', 'approved');
   $approved_comments_count = countRecords(getUserUnapproverComments());

   $categories_count = countRecords(getUserCategories());

   // $admin_users_count = recordCountPartial('users', 'user_role', 'admin');

   // $subscriber_users_count = recordCountPartial('users', 'user_role', 'subscriber');
?>

      <div id="page-wrapper">
         <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
               <div class="col-lg-12">
                  <h1 class="page-header">
                     Welcome to personal Dashboard, <?php echo getUserName(); ?>
                  </h1>
               </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
               <div class="col-lg-4 col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-file-text fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                              <div class='huge'>
                                 <?php // echo $posts_count = recordCountByUser('posts'); ?>
                                 <?php echo $posts_count; ?>
                              </div>
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
               <div class="col-lg-4 col-md-6">
                  <div class="panel panel-green">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-comments fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'>
                              <?php echo $comments_count; ?>
                           </div>
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
               <div class="col-lg-4 col-md-6">
                  <div class="panel panel-red">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-list fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $categories_count; ?></div>
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

            <div class="row">
               <script type="text/javascript">
                  google.charts.load('current', {'packages':['bar']});
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {
                     var data = google.visualization.arrayToDataTable([
                        ['Date', 'Count'],

                        <?php
                           // 1-row variants:
                           // $elements_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Pending Comments', 'Approved Comments', 'Users', 'Admins', 'Subscribers', 'Categories'];
                           $elements_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Pending Comments', 'Approved Comments', 'Categories'];
                           // $elements_count = [$posts_count, $draft_posts_count, $published_posts_count, $comments_count, $unapproved_comments_count, $approved_comments_count, $users_count, $admin_users_count, $subscriber_users_count, $categories_count];
                           $elements_count = [$posts_count, $draft_posts_count, $published_posts_count, $comments_count, $unapproved_comments_count, $approved_comments_count, $categories_count];

                           // for($i = 0; $i < 10; $i++) {
                           for($i = 0; $i < 7; $i++) {
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