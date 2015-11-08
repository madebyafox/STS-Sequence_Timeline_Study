<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0V7.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Voir Dire</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
			What is your ethnicity?
			<br><br>
			<input type ="radio" class="normal" name="ethnicity" value = "white" id="1"/>  
			<label for="1">Caucasian</label> 
			<input type ="radio" class="normal" name="ethnicity" value = "black" id="2"/> 
			<label for="2">African American</label> 
			<input type ="radio" class="normal" name="ethnicity" value = "latin" id="3"/>  	
			<label for="3">Latin American</label>
			<input type ="radio" class="normal" name="ethnicity" value = "pacific" id="4"/> 
			<label for="4">Pacific Islander</label>
			<input type ="radio" class="normal" name="ethnicity" value = "other" id="5"/>  	
			<label for="5">Other</label>
				
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

