<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0A4.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Arguments</h3>
		</div>

		<div class="box">
	 <h2	style="padding-left:75px;">
	 You are now going to review the evidence submitted in the case.
	 </h2>
				
	<h2	style="padding-left:75px;">
	 The exhibits will be presented in the order they were admitted into evidence.  Please 	 inspect each exhibit for as long as you need, in order to evaluate its content and 	      importance.  Then, click the "Next" button to continue. 
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

