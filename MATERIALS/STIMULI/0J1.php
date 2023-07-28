<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0J1.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3> Deliberation</h3>
		</div>

		<div class="box">

				
<h2	style="padding-left:75px;">	Before you begin your deliberation, please consider the following instructions from the presiding judge.  
		<br> <br>
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

