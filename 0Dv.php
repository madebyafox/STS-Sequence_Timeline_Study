<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Dv.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Verdict</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
Please select a verdict.		<br><br>
			<input type ="radio" class="normal" name="verdict" value = "P" id="1" required/>  
			<label for="1">	<i><b>Finding for the Plaintiff (cyclist) Woodward </i></b> <br><br>The plaintiff, Mr. Woodward, has proven by a preponderance of the evidence that the defendant Mr. Johnson’s acts were negligent and caused injury to the plaintiff.  <br> 
</label> 
			<input type ="radio" class="normal" name="verdict" value = "D" id="2"/> 
			<label for="2">	<i><b>Finding for the Defense (motorist) Johnson</i></b> <br><br>	The plaintiff Mr. Woodward has failed to prove by a preponderance of the evidence that the defendant Mr. Johnson's acts were negligent and contributed to the cause of the plaintiff’s injuries.
<br> 
</label> 
<br>
<br>
		
				
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

