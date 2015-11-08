<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0A0.php";
?>
<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

<div class = "center">
	<div class = "top"> <h3> </h3></div>
	
	<div class = "box">
	<br><br><br>
	<h1>PART TWO: ARGUMENTS</h2>
	
		<h2	style="padding-left:45px;">
			In this phase you will be presented with evidence and arguments for the case.</h2> 
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
