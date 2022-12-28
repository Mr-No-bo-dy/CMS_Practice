<?php  include "includes/db.php"; ?>
<?php  include "includes/head.php"; ?>

<?php
   if(isset($_POST['submit'])) {
      // $to = $_POST['to'];
      $to = "mrnobodyxampp@gmail.com";
      $subject = $_POST['subject'];
      $message = $_POST['message'];
      $sender = "From: " . $_POST['sender'];

      // In case any of our lines are larger than 70 characters, we should use wordwrap()
      $message = wordwrap($message, 70, "\r\n");

      // Send Email
      mail($to, $subject, $message, $sender);

      echo "<script>alert('Your Email has been sent.')</script>";  // Massaging about successfull email sending

   } else if(isset($_POST['cancel'])) {
      header("Location: index.php");
   }
   
?>

   <!-- Navigation -->
   <?php  include "includes/navigation.php"; ?>
    
   <!-- Page Content -->
   <div class="container">
    
      <section id="login">
         <div class="container">
            <div class="row">
               <div class="col-xs-6 col-xs-offset-3">
                  <div class="form-wrap">
                  <h1>Contact</h1>
                     <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                           <label for="email" class="sr-only">Email</label>
                           <input id="email" class="form-control" type="email" name="sender" placeholder="Enter your Email">
                        </div>
                        <div class="form-group">
                           <label for="subject" class="sr-only">Subject</label>
                           <input id="subject" class="form-control" type="text" name="subject" placeholder="Enter your Subject">
                        </div>
                        <div class="form-group">
                           <label for="massage" class="sr-only">Massage</label>
                           <textarea id="massage" class="form-control" name="message" cols="30" rows="10" placeholder="Enter your Message"></textarea>
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" name="submit" value="Send">
                        <input type="submit" class="btn btn-custom btn-lg btn-block" name="cancel" value="Cancel">
                     </form>
                  </div>
               </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
         </div> <!-- /.container -->
      </section>

      <hr>

<?php include "includes/footer.php";?>
