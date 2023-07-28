<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Dz.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Congratulations !</h3>
		</div>

		<div class="box">
			<br><br>
			
			
	<h2	style="padding-left:75px;">
	 <br><br>
	You have completed our study, and made a contribution to science.
	</h2>
	
		
		</div>

		<div class = "bottom">
			<form method="post" id="next_page" action="main.php">
			
		<button type = "submit" class="next ">Next</button>
	</form>
		</div>
</div>
<script> 
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
<?php include('includes/footer.php'); ?>

