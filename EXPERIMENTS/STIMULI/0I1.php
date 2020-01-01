<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0I1.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

<div class="center">
	
	<div class="top">
		<h3>Informed Consent</h3>
	</div> <!--top!-->
		<div class="box">
			<p>This study consists of one session lasting no more than 1.5 hours during which 			you will be asked to: </p>
			<ol>
			<li>Read instructions.
			<li>	Complete a survey. 
			<li>	Watch a number of videos.
			<li>	Complete tasks and answer questions related to the videos.
			</ol>
			
			<p>	It is important for you to know that this investigation conforms to the 			ethical guidelines of the American Psychological Association (APA). Thus, the data 			we collect from you will be coded to anonymous values, remain entirely confidential, 			and will be used exclusively for research. APA also ensures that you are free to 			withdraw your participation at any time should you choose to do so.</p>
			
			<p>If you understand the Informed Consent and agree with its contents, click the 			corresponding checkbox below. If you wish to terminate your participation, please 			notify the experimenter, and you may be excused. </p>
			
			<form method="post" id="next_page" action="main.php">
					<br>
				<input type="radio" id="1" class="ready" name="consent" value="approve"  />
				<label for="1">I have read and understood this Informed Consent and I agree with 				its contents.</label> <br> 
				<input type="radio" id="2" class="ready" name="consent" value="decline"/>
				<label for="2">I do not wish to participate</label>	
		</div> <!--box!-->
	<div class = "bottom">
		<button type = "submit" class="next inactive">Next</button>
		</form>
		
	</div> <!--bottom!-->
</div> <!--center!-->
<?php include('includes/footer.php'); ?>

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

