<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Dr.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Verdict</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
		
		Please indicate the relative responsibility of each party to the accident. 
		<br><br>
		Plaintiff, cyclist, Mr. Woodward &nbsp;
		<output for=fader id=volumew>50</output> %
		
<input type=range min=0 max=100 value=50 name ="responsibility" id=fader step=1 oninput="outputUpdate(value)">
			
<output for=fader id=volumej>50</output>
			
			<script>
				function outputUpdate(vol) 
				{
					document.querySelector('#volumew').value = 100-vol;
					document.querySelector('#volumej').value = vol;
				}
			</script>
			% Defendant, motorist, Mr. Johnson
				
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

