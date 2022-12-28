$(document).ready(function(){   // This is a function to load functions inside after the document has been loaded

   // SKEditor for posts and comments:
   ClassicEditor
      .create( document.querySelector( '#editor_body' ))
      .catch( error => {
         console.error( error );
      });

   // script to check all items with class '.checkBoxes' when item with id '#selectAllBoxes' is checked, and vice versa:
   $('#selectAllBoxes').click(function(event){
      if(this.checked){
         $('.checkBoxes').each(function(){
               this.checked = true;
         });
      } else {
         $('.checkBoxes').each(function(){
               this.checked = false;
         });
      }
   });

   // loader animation & background
   var div_box = "<div id='load-screen'><div id='loading'></div></div>";
   $("body").prepend(div_box);
   $('#load-screen').delay(200).fadeOut(300, function(){
      $(this).remove();
   });

});

// Constantly sending request to DB to get the count of Users online:
function loadUsersOnline() {
   $.get("functions.php?onlineusers=result", function(data){
      $(".usersonline").text(data);
   });
}
setInterval(function(){
   loadUsersOnline();
},1000);