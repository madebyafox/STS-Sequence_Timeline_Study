<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0D0.php";
?>
<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

<div class = "center">
	<div class = "top"> <h3> </h3></div>
	
	<div class = "box">
	<br><br><br>
	<h1>PART THREE: DELIBERATION</h1>
	
		<h2	style="padding-left:45px;">
			In this phase you will consider the evidence and arguments presented, apply the relevant case law, and render a decision.</h2> 
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

</body>
</html>
