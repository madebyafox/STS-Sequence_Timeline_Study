<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0J2.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3> Deliberation</h3>
		</div>

		<div class="box">
	
<p>At the time of the occurrence in question in this case, the following statutes were in effect: </p>

<p>Cell Phones?</br>
A person shall not use a wireless telephone for the purpose of text messaging while operating a motor vehicle.</p>
<p>Pedestrial Signals?<br>
Whenever the "Don't Walk" indication is flashing, no bicyclist shall start to cross the roadway in the direction of the indication, but any bicyclist who has partially completed his crossing during the "Walk" indication shall proceed to a sidewalk or to a safety island, and all drivers of vehicles shall yield to any such bicyclist.</p>
<p>Headphones?</br>
A person operating a motor vehicle or bicycle may not wear a headset covering, or earplugs in, both ears.</p>

<p><i>A violation of any of the above statutes constitutes <u>negligence.</u> If you find such a violation, you may only consider it if you also find that it was a <u>cause</u> of the plaintiff’s claimed injuries.</i></p>

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

