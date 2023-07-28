<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0V6.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Voir Dire</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
				Have you, a close friend or family member, ever been involved in a traffic accident which resulted in injury?  
				<br><br> 
				<input type ="radio" class="normal" name="accident" value = "1" id="1"/>  
				<label for="1">Yes</label> 
				<input type ="radio" class="normal" name="accident" value = "0" id="2"/> 
				<label for="2">No</label>
				
		</div>

		<div class = "bottom">
		<button type = "submit" class="next inactive">Next</button>
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
