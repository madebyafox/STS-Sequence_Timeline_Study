<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0E1.php";
?>

<!-- //INCLUDES -->
<?php 
include('includes/header.php'); 

?>
<div class="center">	
	<div class="top">
		<h3>Exhibit 1</h3> 
	</div> <!--top!-->
	<div class="box">
		
		<h2	style=" text-align:center;">
		Crosswalk instructions at intersection
		</h2>
		
		<img class="center" src="img/e1.png" height=70% width=60%>
		
		<form method="post" id="next_page" action="main.php">

	</div> <!--box!-->
	<div class = "bottom">
		<button type = "submit" class="next ">Next</button>
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
