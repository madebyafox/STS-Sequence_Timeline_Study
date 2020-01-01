<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0J3.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3> Deliberation</h3>
		</div>

		<div class="box">
	
<p>The plaintiff, cyclist Mr. Woodward, claims that the defendant, motorist Mr. Johnson, was negligent, and that Mr.Johnson’s negligence caused an injury to Mr. Woodward.</p>  
<p>As an affirmative defense, the defendant, motorist Mr. Johnson, asserts that Mr. Woodward’s injuries were caused in whole or in part by Mr. Woodward's own negligence.</p>

<p>Preponderance or Reasonable Doubt?<br>
Each side must prove their claim by a <u>preponderance of the evidence.</u> This is different than reasonable doubt!  This means to prove that it is <u>more probably true than not</u>. If a party fails to meet his or her burden of proof as to any claim or defense, or if the evidence weighs so evenly that you are unable to say that there is a preponderance on either side, <u>then you must reject</u> that claim or defense.</p>

<p>Truth or Lies?<br>
It is your job to render a decision based on the testimony and evidence presented.  In doing so, you may need to make a judgment on the truthfullness of testimony you heard.  </p>
		
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

