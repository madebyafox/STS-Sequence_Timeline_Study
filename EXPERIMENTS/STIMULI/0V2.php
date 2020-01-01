<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0V2.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Voir Dire 	</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
				What is your year in school? 
				<br>	<br>	 
				<input type ="radio" class="normal" name="year" value = "freshman" id="1"/>  
				<label for="1">Freshman</label> 
				<input type ="radio" class="normal" name="year" value = "sophomore" id="2"/> 
				<label for="2">Sophomore</label> 
				<input type ="radio" class="normal" name="year" value = "junior" id="3"/>  	 
				<label for="3">Junior</label> 
				<input type ="radio" class="normal" name="year" value = "senior" id="4"/>  	 
				<label for="4">Senior</label> 
				<input type ="radio" class="normal" name="year" value = "graduate" id="5"/>   
				<label for="5">Graduate</label> 		 
				<input type ="radio" class="normal" name="year" value = "other" id="6"/>
				<label for="6">Other</label> 
		 			
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

