<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0E8.php";
?>

<!-- //INCLUDES -->
<?php 
include('includes/header.php'); 
?>

<div class="center">	
	<div class="top">
	<h3>Exhibit 8</h3> 
	</div> <!--top!-->
	
	<div class="box">
		
		<h2	style=" text-align:center;">
		Phone Records for the Defendant		
		</h2>
		
		<div id='basic-modal'>
			<input style="display: table;
    margin: auto;" type='button' name='basic' value='View Document' class='basic'/> 
		</div>
		
		<form method="post" id="next_page" action="main.php">

	</div> <!--box!-->
	
	<div class = "bottom">
		<button type = "submit" class="next ">Next</button>
		</form>
	</div> <!--bottom!-->
</div> <!--center!-->

<!-- modal content -->
	<div id="basic-modal-content">
		<img src="img/e8.jpg" width ="100%" >
	</div>

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
