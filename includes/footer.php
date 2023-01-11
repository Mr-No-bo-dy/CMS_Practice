      <footer>
         <div class="row">
            <div class="col-lg-12">
               <p>Copyright &copy; CMS by MrNobody</p>
            </div>
            <!-- /.col-lg-12 -->
         </div>
         <!-- /.row -->
      </footer>

   </div>
   <!-- /.container -->

   <!-- jQuery -->
   <script src="js/jquery.js"></script>

   <!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>

   <!-- Calling SKEditor for Comments: -->
   <script>
        ClassicEditor
            .create( document.querySelector( '#editor_body' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

</body>

</html>