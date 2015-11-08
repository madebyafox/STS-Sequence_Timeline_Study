<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Dc.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Verdict</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
		
		Please indicate your confidence in your verdict: &nbsp &nbsp &nbsp
			<input type=range min=0 max=100 value=50 name ="confidence" id=fader step=1 oninput="outputUpdate(value)">
			<output for=fader id=volume>50</output>
			<script>
			function outputUpdate(vol) {
			document.querySelector('#volume').value = vol;
			}
			</script>
			% confident
				
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

