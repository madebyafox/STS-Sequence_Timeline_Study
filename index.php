<?php 
session_start();
session_unset();
?>

<!-- //SET VARIABLES -->
<?php 
$first_page = "index.php";
$_SESSION["page"] = $first_page;
$_SESSION["user"] = "";

?>

<!-- //INCLUDES -->
<?php 
include('includes/header.php'); 

?>

<div class="center">	
	<div class="top">
		<h3>Please turn off your mobile phone</h3>
	</div> <!--top!-->
	<div class="box">
		<img class="center" src="img/welcome.png" height=60% width=60%>
		<h3>Please wait for further instructions</h3>
		
		<form method="post" id="next_page" action="main.php">
				<h4> Enter Session ID:  &nbsp
					<input type="text" id ="session_name" name="session_name" >
				</h4>

	</div> <!--box!-->
	<div class = "bottom">
		<button type = "submit" class="next inactive">Next</button>
			</form>
	</div> <!--bottom!-->
</div> <!--center!-->
<?php include('includes/footer.php'); ?>


<script> // var page = "0I1";
$(document).ready(function(){
 $('input').change(function() { 
  var val = $(this).val();
  if ((val != "") && (val != "No")) {
   $(".next").removeClass('inactive');
   $(".exitlink").hide();
  } else if (val == "No") {
   $(".next").addClass('inactive');
   $(".exitlink").show();
  } else {
   $(".next").addClass('inactive');
   $(".exitlink").hide();
  }
 });
})
</script>
