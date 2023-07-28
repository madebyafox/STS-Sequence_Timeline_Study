<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Dj.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Verdict</h3> 
		</div>

		<div class="box">

<form method="post" id="next_page" action="main.php">
								
Please provide a brief justification for your decision.		<br><br>
<textarea rows="10" cols="100" class="normal" name="justification" id="justification" autofocus = "true">  
</textarea>
</div>

<div class = "bottom">
<button type = "submit" class="next inactive">Next</button>	
</form>
</div>
</div>
<script> 
$(document).ready(function(){
 $('textarea').change(function() {
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

